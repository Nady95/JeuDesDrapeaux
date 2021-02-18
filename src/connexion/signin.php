<?php

require("utilisateur.php");

if(isset($_POST['pseudo']) && !empty($_POST['pseudo']) && isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['pwd']) && !empty($_POST['pwd']) && isset($_POST['pwd2']) && !empty($_POST['pwd2']) && $_POST['pwd'] == $_POST['pwd2'])
{
	if(!inscription($_POST["pseudo"], $_POST["email"], $_POST["pwd"]))
		return false;
	echo 'Bienvenue sur notre site, '.$_POST['pseudo'].' !<br />';
	echo 'Merci de t\'être inscrit, tu peux désormais avoir accès à tous les questionnaires !<br />';
	echo 'Si tu n\'es pas redirigé automatiquement, <a href="../index.php"> clique ici </a>!';
	header('Refresh: 3; URL=../index.php');
}

else{
	echo 'Il y a une erreur. Merci de réessayer en faisant bien attention à remplir correctement le formulaire.<br />';
	echo 'Si le problème persiste, contactez un administrateur.<br />';
	echo '<a href="../index.php">Cliquez ici</a> pour revenir à la page d\'accueil';
	return false;
}

 ?>
