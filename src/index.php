<?php
session_start();
require("connexion/utilisateur.php");

function name(){
	if(isset($_SESSION['user'])) return $_SESSION['user'];
	else return "Invité";
}

function isConnected(){
	if(isset($_SESSION['user'])) return true;
	else return false;
}
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Le jeu des drapeaux - par Nady SADDIK</title>
		<meta charset="utf-8" />
		<meta name="description" content="Le jeu des drapeaux est incroyable croyez-moi" />
		<meta name="keywords" content="jeu drapeaux géographie geo pays carte monde europe afrique etats unis oceanie australie points score">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/index.css" />
		<link rel="stylesheet" href="assets/css/global.css" />
		<link rel="icon" type="image/png" href="assets/img/favicon.png" />
		<!--[if IE]><link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico" /><![endif]-->
		<!-- Installation Bootstrap v4 -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" />
	</head>
	<body>
		<!-- Header -->
		<?php include("includes/header.php"); ?>
		
		<section id="banner" class="jumbotron text-center">
			<div class="row">
				<div class="col-sm-12" id="presentation">
					<h1>Explorons le monde !</h1>
					<h3>Bienvenue, <?php echo name(); ?></h3>
					<div class="border-top my-3 mx-auto" style="max-width:260px;"></div>
					<p>Bienvenue dans notre jeu de géographie !<br />
					Testez vos connaissances grâce à nos différents quiz. Actuellement, il en existe de deux types :</p>
					<ul>
						<li>Par continent</li>
						<li>Monde entier</li>
					</ul>
					<p>Dans le premier, vous devrez situer cinq pays dans un seul continent grâce à leurs drapeaux.</p>
					<p>Dans le second, le but est identique, mais on ne se limitera pas à un seul continent. Vous jouerez sur le monde entier.</p>
					<p>Enfin, en tant qu'invité, vous ne pourrez profiter que du premier mode de jeu, avec un questionnaire de test. Pour profiter de toutes les fonctionnalités du jeu, il faudra vous inscrire.</p>
					<p>Bon jeu my frouuuuuuuuuuuuuuuuuueeeeeeeeeeeeeeeennnnnnnnnnnnd !</p>
					<div class="border-top my-3 mx-auto" style="max-width:260px;"></div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<?php 
                        if(isConnected()){
                            echo '<a href="jeu.php?mode=europe" class="btn btn-primary btn-lg" role="button">EUROPE</a>';
                            echo '<a href="jeu.php?mode=asie" class="btn btn-primary btn-lg" role="button">ASIE</a>';
                            echo '<a href="jeu.php?mode=afrique" class="btn btn-primary btn-lg" role="button">AFRIQUE</a>';
                            echo '<a href="jeu.php?mode=amerique" class="btn btn-primary btn-lg" role="button">AMERIQUE</a>';
                            echo '<a href="jeu.php?mode=oceanie" class="btn btn-primary btn-lg" role="button">OCEANIE</a>';
                            echo '<a href="jeu.php?mode=monde" class="btn btn-primary btn-lg" role="button">MONDE ENTIER</a>';
                        } else{
                            echo '<a href="jeu.php?mode=europe" class="btn btn-primary btn-lg" role="button">EUROPE</a>';
                        }
                    ?>
				</div>		
			</div>
		</section>
		
		<!-- Footer -->
		<?php include("includes/footer.php"); ?>
		
		<!-- Installation des scripts JS -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	</body>
</html>