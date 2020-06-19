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

        if(!empty($_POST["title"]) AND !empty($_POST["details"]) AND !empty($_POST["expiration_date"]) AND !empty($_POST["expiration_time"])){

            $title = htmlspecialchars($_POST["title"]);
            $details = htmlspecialchars($_POST["details"]);
            $expiration_date = htmlspecialchars($_POST["expiration_date"]);
            $expiration_time = htmlspecialchars($_POST["expiration_time"]);
            $expiration = date('Y-m-d H:i:s', strtotime("$expiration_date $expiration_time"));

            $manager = new ToDosManager($db_config);
            $todo = new ToDo($title, $details, $expiration);
            $manager->add($todo);

            header("Location: ../index.php");

        }

        header("Location: ../index.php");


    }