<?php 

/**
 * classe Manager des ToDos
 * Contient des méthodes poour ajouter / supprimer / modifier les données des ToDos
 */

class ToDosManager {

    private $_db;

    /**
     * Constructeur du ToDosManager
     * @param PDO $db La base de données dans laquelle on travaille
     */

    public function __construct($db){
          $this->_db = $db;
    }
  
    /**
     * Ajouter un ToDo dans la base de données
     * @param ToDo $todo Le ToDo à ajouter dans la base de données
     * @return void
     */

    public function add(ToDo $todo){
        $user = $_SESSION["user"];
        echo "Adding todo to the database";
        var_dump($todo);
        $q = $this->_db->prepare('INSERT INTO todos(owner_id, title, details, expiration, creation_date) VALUES(:owner_id, :title, :details, :expiration, NOW())');
        $q->bindValue(':owner_id', $user->id());
        $q->bindValue(':title', $todo->title());
        $q->bindValue(':details', $todo->details());
        $q->bindValue(':expiration', $todo->expiration());

        $q->execute();
    }

    /**
     * Récupérer la liste des Todos d'un utilisateur
     * @return array Liste des ToDos de l'utilisateur
     */

    public function getToDosList(){
        $user = $_SESSION["user"];
        $id = $user->id();
        $q = $this->_db->query("SELECT * from todos WHERE owner_id = '$id' ORDER BY creation_date DESC");
        $todos = array();
        while ($todo = $q->fetch(PDO::FETCH_ASSOC))
        {
          array_push($todos, $todo);
        }
        return $todos;
    }

    /**
     * Récupérer un ToDo depuis son id
     * @param string $id L'id du ToDo à récupérer
     * @return Response Réponse de mysql
     */

    public function getFromId($id){
      $q = $this->_db->query("SELECT * FROM todos WHERE id = '$id'");
      return $q->fetch();
    }

    /**
     * Supprimer un ToDo depuis un id si l'utilisateur courant en est propriétaire
     * @param int $id L'id du ToDo à supprimer
     * @return void
     */

    public function deleteFromId($id){
      $user = $_SESSION["user"];
      $response = $this->getFromId($id);

      // On vérifie que l'utilisateur est bien propriétaire du TODO en question
      if($user->isOwner($response)){
        $this->_db->query("DELETE FROM todos WHERE id = $id");
      }
      // Sinon on fait rien
      else {
        echo "pas propriétaire";
      }

    }

    /**
     * Mettre à jour les données d'un ToDo depuis un id si l'utilisateur courant en est propriétaire
     * @param int $id L'id du ToDo à modifier
     * @param ToDo $todo L'objet ToDo qui représente les nouvelles données
     * @return void
     */

    public function updateFromId($id, ToDo $todo){
      $user = $_SESSION["user"];
      $response = $this->getFromId($id);

      // On vérifie que l'utilisateur est bien propriétaire du TODO en question
      if($user->isOwner($response)){
        $q = $this->_db->prepare("UPDATE todos SET title = :title, details = :details, expiration = :expiration WHERE id = $id");
        $q->bindValue(':title', $todo->title());
        $q->bindValue(':details', $todo->details());
        $q->bindValue(':expiration', $todo->expiration());

        $q->execute();

      }
      // Sinon on ne fait rien
      else {
        echo "pas propriétaire";
      }

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