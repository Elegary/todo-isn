<?php 

/**
 * Classe représentative d'un User (Utilisateur)
 */

class User {


    /**
    * L'ensemble des attributs de l'utilisateur sont privés 
    */

    /** @var string $_id L'id de l'utilisateur */
    private $_id;

    /** @var string $_username L'username de l'utilisateur */
    private $_username;

    /** @var string $_email L'email de l'utilisateur */
    private $_email;

    /** @var string $_hashed_password Le hash du mot de passe de l'utilisateur */
    private $_hashed_password;

    public function __construct($username, $email, $hashed_password){
        $this->_username = $username;
        $this->_email =$email;
        $this->_hashed_password = $hashed_password;
    }

    /**
     * Récupérer l'id de l'utilisateur 
     * @return string L'id de l'utilisateur
     */

    public function id(){
        return $this->_id;
    }

    
    /**
    * Définir l'id de l'utilisateur 
    * @param string $id L'id à définir
    * @return void L'id de l'utilisateur
    */

    public function setId($id){
        $this->_id = $id;
    }
    
    /**
    * Récupérer l'username de l'utilisateur 
    * @return string L'username de l'utilisateur
    */

    public function username(){
        return $this->_username;
    }

    /**
    * Récupérer l'email de l'utilisateur 
    * @return string L'email de l'utilisateur
    */

    public function email(){
        return $this->_email;
    }

    /**
    * Récupérer le mot de passe hashé de l'utilisateur 
    * @return string Le hash du mot de passe de l'utilisateur
    */

    public function hashed_password(){
        return $this->_hashed_password;
    }

    
    /**
     * Savoir si l'utilisateur est propriétaire du TODO
     * @param Response $response Reponse d'une requete SQL d'un TODO
     * @return boolean True si propriétaire / False sinon
     */

    public function isOwner($response){
        // Si pas de réponse le todo n'existe pas
        if($response == false){ 
          return false;
        }
  
        // On vérifie si le demandeur est bien propriétaire
        if($this->_id == $response["owner_id"]){
          return true;
        } 
        // Sinon il n'est pas propriétaire donc refus
        return false;
      }


}