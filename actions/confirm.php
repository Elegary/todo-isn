<?php 
    require("../core/User.php");
    require("../core/UsersManager.php");
    require("../core/database.php");

    session_start();

        if(!empty($_GET["key"])){
            $key = htmlspecialchars($_GET["key"]);

            $manager = new UsersManager($db_config);

            $key_status = $manager->getKeyStatus($key);

            if($key_status == EmailStatus::UNVERIFIED){
                $manager->setKeyVerified($key);
                echo "Votre email a bien été confirmé.";
            }

            elseif($key_status == EmailStatus::VERIFIED){
                echo "L'adresse email a déja été vérifiée.";
            }

            elseif($key_status == EmailStatus::INVALID_KEY){
                echo "La clé de confirmation est invalide.";
            }

            else {
                echo "Erreur inattendue.";
            }




        }


    