<?php 

    /**
     * Ce fichier PHP contient la page de connexion dite "login.php" 
     * Permet d'afficher, de vérifier la saisie de l'utilisateur
     * Quand les informations d'identification sont valides, l'utilisateur est connecté
     */

    require("core/User.php");
    require("core/UsersManager.php");
    require("core/database.php");

    session_start();
    if(isset($_SESSION["user"])){
        header("Location: index.php");
    }
    
    if(!empty($_POST["username"]) AND !empty($_POST["password"])){

        $username = htmlspecialchars($_POST["username"]);
        $password = htmlspecialchars($_POST["password"]);

        $manager = new UsersManager($db_config);
        $requestedUser = $manager->getUserFromUsername($username);
        
        if($requestedUser != false){
            $user = new User($requestedUser["username"], $requestedUser["email"], $requestedUser["hashed_password"]);
            $user->setId($requestedUser["id"]);

            /**
             * Permet de vérifier le mot de passe saisi avec le mot de passe hashé dans la base de données
             */

            if(password_verify($password, $user->hashed_password())){
                /**
                 *Si le mot de passe est bon, l'utilisateur est connecté et renvoyé sur son tableau de bord. 
                 */

                $_SESSION["user"] = $user;
                header("Location: index.php");
            } 
            
            else {
            	$erreur = "Le nom d'utilisateur ou le mot de passe est incorrect !";
            }
        } 

        else {
        	$erreur = "Le nom d'utilisateur ou le mot de passe est incorrect !";
        }


    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="main.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
    <title>To Do List PHP</title>
</head>
<body>
    <section>
        <h1 id="bienvenue">Bienvenue sur votre assistant de gestion de tâches.</h1>
        <h2 id="cafe">Connectez-vous pour accéder à votre tableau de bord.</h2>
        <br />
        <div id="form">
            <form action="" method="post" id="home_form">
            <?php if(isset($erreur)){
                    echo '<h2 class="error_form">' . $erreur . "</h2>";
                } 
            ?>
                <input placeholder="Nom d'utilisateur" type="text" name="username" />
                <br />
                <input placeholder="Mot de passe" type="password" name="password" />
                <br />
                <input type="submit" value="Commencer" />
            </form>
        </div>
        <h4 id="inscrit"><a href="register.php">Pas encore inscrit ?</a></h4>
    </section>
</body>
</body>
</html>