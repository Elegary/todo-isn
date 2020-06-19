<?php 
    require("core/User.php");
    require("core/ToDo.php");
    require("core/ToDosManager.php");
    require("core/database.php");

    session_start();
    if(!isset($_SESSION["user"])){
        header("Location: welcome.php");
    }

    else {
        $user = $_SESSION["user"];
        $manager = new ToDosManager($db_config);
        $todos = $manager->getToDosList();
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="indexcss.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
    <title>To Do List PHP</title>
</head>
<body>
    <section id="logged_welcome">
        <h2 id="bonjour">Bonjour <?php echo $user->username() . "(id : " . $user->id() . ")."?></h2>
        <h2 id="bienvenue">Bienvenue sur votre assitant de gestion de tâches.</h2>
        <h2 id="taches">Voici vos tâches :</h2>
        <div id =div>
            <ul>
                <?php foreach($todos as $todo){
                    $expiration = new DateTime($todo["expiration"]);
                    $expiration = $expiration->format("d/m/Y à H:i");
                        echo '
                            <li>
                                <h3 id=>' . $todo["title"] . '</h3>
                                <h4>' . $todo["details"] . '</h4>
                                <h4>Échéance : ' . $expiration . ' <a href="actions/delete.php?id=' . $todo["id"] . '"> X </a></h4>
                            </li>
                            ';
                    } 
                ?>
            </ul> 
        </div>
        <form class="box" action="actions/add.php" method="post">
            <input placeholder="Titre" type="text" name="title" />
            <textarea placeholder="Détails" name="details" ></textarea>
            <input placeholder="Date" type="date" value="2020-05-13" name="expiration_date" />
            <input placeholder="Date" type="time" value="15:30" name="expiration_time" />
            <input type="submit" value="Ajouter"  />
        </form>  
    </section>
<a id="deco" href="logout.php">Déconnexion</a>
</body>
</html>