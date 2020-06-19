<?php 
    require("../core/User.php");
    require("../core/ToDo.php");
    require("../core/ToDosManager.php");
    require("../core/database.php");

    session_start();
    if(!isset($_SESSION["user"])){
        header("Location: welcome.php");
    }
    
    else {

        if(!empty($_GET["id"])){

            $id = htmlspecialchars($_GET["id"]);

            $manager = new ToDosManager($db_config);
            $manager->deleteFromId($id);

        }

        header("Location: ../index.php");


    }