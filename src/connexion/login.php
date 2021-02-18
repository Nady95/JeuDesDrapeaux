<?php

require("utilisateur.php");

try {
  $bdd = new PDO('mysql:host=localhost;dbname=projet_web;charset=utf8', "root", "");
  array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

  if(connexion($_POST["pseudo"], $_POST["pwd"]))
  {
    session_start();
    $_SESSION['user'] = htmlentities($_POST["pseudo"]);
    echo 'Bonjour '. $_SESSION['user'] . ', content de vous revoir !<br />';
	echo 'Si vous n\'êtes pas redirigé automatiquement, <a href="../index.php"> cliquez ici </a>!';
    header('Refresh:3; URL=../index.php');
  }

  else {
    echo "Soit le pseudo ou le mot de passe est incorrect, soit vous ne vous êtes jamais inscrit.<br />";
	echo '<a href="../index.php">Cliquez ici</a> pour revenir à la page d\'accueil';
  }

}catch (PDOException $e) {
  echo "Erreur !: " . $e->getMessage() . "<br/>";
  die();
}

 ?>
