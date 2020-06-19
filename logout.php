<?php 

    /**
     * Cette page est relativement simple; quand elle est ouverte la session de l'utilisateur est détruite et il est déconnecté. 
     */

    session_start();

    if(isset($_SESSION["user"])){
        session_destroy();
    }

    header("Location: welcome.php")

?>