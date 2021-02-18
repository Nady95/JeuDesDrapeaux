<?php
	session_start();
    session_destroy();
    echo 'Vous êtes bien déconnecté.';
	echo 'Si vous n\'êtes pas redirigé automatiquement, <a href="../index.php"> cliquez ici </a>!';
    header('Refresh:3; URL=../index.php');

?>