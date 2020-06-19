<?php 

/**
 * Fichier qui permet d'importer rapidement la configuration de la base données pour ne pas la retaper à chaque fois qu'on en a besoin 
 * Le nom d'utilisateur et le mot de passe ont été modifié pour des raisons évidentes de sécurité !
 */

$db_config = new PDO('mysql:host=sql.toudou.xyz;dbname=romain2002_todo;charset=utf8', 'USER', 'XXXXXXXXXXXXXXXXXXXXXXXXX');

?>