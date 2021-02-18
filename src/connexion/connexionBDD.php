<?php

  $user = "root";
  $mdp = "";
  $dbname = "projet_web";
  $dsn = 'mysql:host=localhost; dbname='.$dbname;

  try{
    $bdd = new PDO($dsn, $user, $mdp);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }catch(PDOException $e){
	echo $e -> getMessage();
	die();
  }

 ?>
