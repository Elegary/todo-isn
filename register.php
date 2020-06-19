<?php 

    /**
     * Ce fichier PHP contient la page d'inscription dite "register.php" 
     * Permet d'afficher, de vérifier la saisie de l'utilisateur
     * Permet aussi d'enregistrer les ifnos de l'utilisateur dans la base de données
     */
    
    session_start();
    
    if(isset($_SESSION["user"])){
        header("Location: index.php");
    } 
    
	require("core/User.php");
	require("core/UsersManager.php");
	require("core/database.php");

    /**
     * Les lignes qui suivent sont un certains nombres de vérifications
     * Elles contiennent des conditions imbriquées pour que l'utilisateur enregistré soit valide,
     * n'aie pas le même email ou nom d'utilisateur existant pour éviter les conflits
     * Également la vérification de la sécurité du mdp (longueur etc) et la validité du format email 
     */

    if(isset($_POST["form"])){
    	if(!empty($_POST["username"]) AND !empty($_POST["email"]) AND !empty($_POST["password"]) AND !empty($_POST["password_confirm"])){

    	    $username = htmlspecialchars($_POST["username"]);
    	    $email = htmlspecialchars($_POST["email"]);
    	    $password = htmlspecialchars($_POST["password"]);
    	    $password_confirm = htmlspecialchars($_POST["password_confirm"]);

    	    if($password == $password_confirm){

                if (ctype_alnum($username) AND strlen($username) >= 3 AND strlen($username) <= 50) {

                    if(strlen($password) >= 7 AND strlen($password) <= 50){

                        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            	        
                	        $manager = new UsersManager($db_config);
                	        $usernameExist = $manager->getUserFromUsername($username);
                            $emailExist = $manager->getUserFromEmail($email);

                	        if($usernameExist == false ){
                                if($emailExist == false){
                                    /**
                                     * Lorsque toutes les conditions sont remplies, l'utilisateur est enregistré
                                    */
                    	            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    	            $user = new User($username, $email, $hashed_password);
                    	            $manager->add($user);
                    	            $manager->setEmailConfirmKey($user);

                                    $success = true;
                                }
                                
                                /**
                                 * Ici les différentes erreurs sont définies pour être ensuites affichées à l'utilisateur
                                 */

                                else {
                                    $erreur = "L'adresse email est déjà utilisée !";
                                }
                	        } 
                	        
                	        else {
                	            $erreur = "Le nom d'utilisateur est déjà pris !";
                	        }
                        } 

                        else {
                            $erreur = "L'adresse email n'est pas valide !";
                        }
                    } 

                    else {
                        $erreur = "Le mot de passe doit comporter entre 7 et 50 caractères !";
                    }
                } 

                else {
                    $erreur = "Le nom d'utilisateur doit comporter entre 3 et 50 caractères et être valide !";
                }
    	    } 
    	    
    	    else {
    	        $erreur = "Les mots de passe ne correspondent pas !";
    	    }

    	}

    	else {
    	    $erreur = "Tous les champs doivent être complétés !";

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
        <div>
            <h1 id="bienvenue">Bienvenue sur votre assistant de gestion de tâches.</h1>
            <h2 id="cafe">Prenez un café et découvrez une nouvelle façon d'organiser vos tâches.</h2>
    

            <h2 id="revolution">Commencez votre révolution dès maintenant.</h2>
            <div id="form">
            <?php if(isset($erreur)){
                    echo '<h2 class="error_form">' . $erreur . "</h2>";
                } 
                if(isset($success)){
                    echo '<h2 class="success_form">Inscription validée. Vérifiez vos emails.</h2>';
                }
            ?>
                <form action="register.php" method="post" id="home_form">
                <?php 
                /**
                * Les champs du formulaire sont automatiquement remis en cas d'erreur pour ne pas avoir à les retaper.
                */
                
                ?>
                    <input placeholder="Nom d'utilisateur" type="text" name="username" value="<?php if(isset($username)){ echo $username; } ?>"/>
                    <br />
                    <input placeholder="Adresse email" type="text" name="email" value="<?php if(isset($email)){ echo $email; } ?>"/>
                    <br />
                    <input placeholder="Mot de passe" type="password" name="password" />
                    <br />
                    <input placeholder="Confirmation" type="password" name="password_confirm" />
                    <br />
                    <input type="submit" value="Commencer" name="form"/>
                </form>
            </div>
            <h4 id="inscrit">Déjà inscrit ? <a href="login.php">Connectez-vous à votre tableau de bord</a></h4>
        </div>
    </section>
</body>
</html>