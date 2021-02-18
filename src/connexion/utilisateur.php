<?php

// Sous-fonction permettant de gérer l'inscription ainsi que la connexion
function ins_conn($pseudo, $email, $pwd, $sql)
{
  try{
    $pseudo = htmlentities($pseudo);
    $pwd = md5($pwd);
    $bdd = new PDO('mysql:host=localhost;dbname=projet_web;charset=utf8', "root", "");
    $sth = $bdd->prepare($sql);
	
	if($email != null){
		$sth->execute(array(':user'=>$pseudo,
							':mail'=>$email,
							':pwd'=>$pwd));				
	}
	
	else{
		$sth->execute(array(':user'=>$pseudo,
							':pwd'=>$pwd));			
	}

    

    return $sth;
  }catch(PDOException $e){
    echo $e->getMessage();
    die();
  }
}

// Permet de gérer l'inscription au site
function inscription($pseudo, $email, $pwd)
{
  $sql = "INSERT into utilisateur(pseudo, email, mdp) values(:user, :mail, :pwd)";
  $res = ins_conn($pseudo,$email,$pwd,$sql);
  if($res->rowCount() == 0)
    return false;
  return true;
}

// Permet de gérer la connexion au site
function connexion($pseudo, $pwd)
{
  $sql = "SELECT * from utilisateur where pseudo = :user and mdp = :pwd";
  $res = ins_conn($pseudo,null,$pwd,$sql);

  if($res->fetchAll())
    return true;
  return false;
}

 ?>
