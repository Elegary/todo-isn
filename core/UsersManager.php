<?php 

require(__DIR__.'/EmailStatus.php');
require(__DIR__.'/Mail.php');

/**
 * classe Manager des Users (Utilisateurs)
 * Contient des méthodes pour ajouter / supprimer / modifier les données des Users (Utilisateurs)
 */

class UsersManager {

    private $_db;

    /**
     * Constructeur du UsersManager
     * @param PDO $db La base de données dans laquelle on travaille
    */

    public function __construct($db){
          $this->_db = $db;
    }
    
    /**
     * Ajouter un User dans la base de données
     * @param User $user Le User à ajouter dans la base de données
     * @return void
    */

    public function add(User $user){
        echo "Adding user to the database";
        $q = $this->_db->prepare('INSERT INTO users(username, email, hashed_password, date_register, ip_register) VALUES(:username, :email, :hashed_password, NOW(), :ip_register)');
        $q->bindValue(':username', $user->username());
        $q->bindValue(':email', $user->email());
        $q->bindValue(':hashed_password', $user->hashed_password());
        $q->bindValue(':ip_register', $_SERVER["REMOTE_ADDR"]);

        $q->execute();
        $user->setId($this->_db->lastInsertId());
        var_dump($user);
    }

    /**
     * Définir et insérer une première clé de confirmation email dans la base de données
     * @param User $user L'utilisateur dont la clé est à insérer dans la base de données
     * @return void
    */

    public function setEmailConfirmKey($user){
        $q = $this->_db->prepare("INSERT INTO verifications (user_id, confirm_key, confirmed) VALUES (:user_id, :confirm_key, :confirmed)");

        $q->bindValue(':user_id', $user->id());
        //Génération de la clé de confirmation
        $key = $this->generateConfirmKey($user);
        $q->bindValue(':confirm_key', $key);
        $q->bindValue(':confirmed', 0);

        $q->execute();

        // On envoie le mail de confirmattion !
        $emailVerif = new Mail();
        $emailVerif->sendConfirmationEmail($user, $key);

    }

    /**
     * Récupérer un User dans la base de données depuis un username (nom d'utilisateur)
     * @param string $username Le username à récupérer dans la base de données
     * @return Response Réponse de mysql
    */

    public function getUserFromUsername($username){
        $q = $this->_db->query("SELECT * from users WHERE username = '$username'");
        $user = $q->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    /**
     * Récupérer un User dans la base de données depuis un email
     * @param string $email L'email à récupérer dans la base de données
     * @return Response Réponse de mysql
    */

    public function getUserFromEmail($email){
        $q = $this->_db->query("SELECT * from users WHERE email = '$email'");
        $user = $q->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    /**
     * Récupérer un état de clé email dans la base de données
     * @param string $key La clé dont le statut est à récupérer dans la base de données
     * @return int Etat de la clé selon la classe EmailStatus
    */

    public function getKeyStatus($key){
        $q = $this->_db->query("SELECT * from verifications WHERE confirm_key = '$key'");
        $response = $q->fetch(PDO::FETCH_ASSOC);

        if($response == false){
            return EmailStatus::INVALID_KEY;
        }
        
        elseif($response["confirmed"] == 0){
            return EmailStatus::UNVERIFIED;
        } 

        elseif($response["confirmed"] == 1){
            return EmailStatus::VERIFIED;
        }

    }

    /**
     * Passe une clé en état vérifié
     * @param string $key La clé dont le statut est à modifier dans la base de données
     * @return void Si pas de clé existante (pour différentes raisons), on stop la procédure
     */

    public function setKeyVerified($key){
        $q = $this->_db->query("SELECT * from verifications WHERE confirm_key = '$key'");
        $response = $q->fetch(PDO::FETCH_ASSOC);

        if($response == false){
            return;
        }

        $q = $this->_db->prepare("UPDATE verifications SET confirmed = 1 WHERE confirm_key = '$key'");

        $q->execute();

    }

    /**
     * Générer une clé de confirmation au format sha1 . sha1
     * @param User $user L'utilisateur dont la clé est à générer
     * @return string La clé de confirmation de l'utilisateur
     */

    private function generateConfirmKey($user){
        return sha1(mt_rand(10000,99999).time().$user->email().$user->username()).sha1(mt_rand(10000,99999).time().$user->email().$user->username());
        
    }

    /**
     * Méthode privée pour récupérer la date et heure actuelle
     * Non utilisée en production
     * @return string La date au format AAAA-MM-JJ heure:minute:seconde
     */
    
    private function getDate(){
        return date('Y-m-d H:i:s');
    }

}