<?php 
session_start();
		
include("../connexion/connexionBDD.php");
		
//on prépare la requete
$req = $bdd->prepare('INSERT INTO classement(pseudo, score, nomQuiz) VALUES(:pseudo, :score, :nomQuiz)');

//on rajoute les entrées
$req->execute(array( 
    ':pseudo' => $_SESSION['user'], 
    ':score' => $_POST['score'], 
    ':nomQuiz' => $_POST['nomQuiz']
));		
?>