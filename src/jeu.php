<?php
session_start();
require("connexion/utilisateur.php");

if(!isset($_SESSION['user']) && $_GET['mode']!='europe') header('Location: index.php'); 
$liste_mode = array("europe", "asie", "afrique", "amerique", "oceanie", "monde");
if(!in_array($_GET['mode'], $liste_mode)) header('Location: index.php');
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Le jeu des drapeaux - par Nady SADDIK</title>
		<meta charset="utf-8" />
		<meta name="description" content="Le jeu des drapeaux est incroyable croyez-moi" />
		<meta name="keywords" content="jeu drapeaux géographie geo pays carte monde europe afrique etats unis oceanie australie points score">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="stylesheet" href="assets/css/global.css" />
		<link rel="icon" type="image/png" href="assets/img/favicon.png" />
		<!--[if IE]><link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico" /><![endif]-->
		<!-- Installation Bootstrap v4 -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" />
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	</head>
	<body>
		<!-- Header -->
		<?php include("includes/header.php"); ?>
		
		<?php 
            $updateBdd = false;
            if(isset($_POST['updateBdd']))
                $updateBdd = $_POST['updateBdd'];
        ?>
		
		<section class="jumbotron text-center" id="main">
			<h1 id="instructions">Cliquez sur le drapeau souhaité et identifiez le pays correspondant sur la carte suivante</h1>
            <h2 id="instructions2">Tous les drapeaux correspondent à des pays d'<span id="nomContinent" style="font-weight:bold;" /></h2>
			<p class="alert alert-info">Vous pouvez zoomer/dézoomer avec la molette de la souris</p>
		
			<!-- StamenTileLayer -->
			<div class="row">
				<div class="col">
					<div id="map" style="width: 800px; height: 600px"></div>
				</div>
				<div class="col">
                    <div>
                        <button id="flag1-btn"><img id="flag1" src="" alt="Drapeau1" /></button>
                        <button id="flag2-btn"><img id="flag2" src="" alt="Drapeau2" /></button>
                        <button id="flag3-btn"><img id="flag3" src="" alt="Drapeau3" /></button>
                        <button id="flag4-btn"><img id="flag4" src="" alt="Drapeau4" /></button>
                        <button id="flag5-btn"><img id="flag5" src="" alt="Drapeau5" /></button>
                    </div>
                    <div id="carousel-container"></div>
				</div>
			</div>
			
			<script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"></script>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
			<script src="assets/js/displayMap.js"></script>
			<script src="assets/js/quiz.js"></script>
			
            <p style="font-weight:bold;font-size:32px;">Nombre d'essais restants : <span id="attempts_remaining" />0</p>
			<p style="font-weight:bold;font-size:32px;">SCORE : <span id="score" />0</p>
			
		</section>
		
		
		<!-- Footer -->
		<?php include("includes/footer.php"); ?>
		
		<!-- Installation des scripts JS -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	</body>
</html>