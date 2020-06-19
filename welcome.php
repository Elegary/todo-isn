<?php

	/**
	 * Ce fichier PHP contient la page de Bienvenue dite "welcome.php"
	 */

	session_start();
    
    if(isset($_SESSION["user"])){
        header("Location: index.php");
    } 

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Bienvuenue</title>
<link href="cssaccueil.css" rel="stylesheet" type="text/css">
</head>

<body>
	<section>
		<h1>TOUDOU.xyz</h1>
		<h3>La révolution commence.</h3>	
	</section>
	
	<a href="login.php" id="button">Se Connecter</a>
	<a href="register.php" id="button2">S'enregistrer</a>
	
	
	
</body>
</html>
