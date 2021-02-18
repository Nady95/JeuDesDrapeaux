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

function getArrayBestScore($mode){
    include("connexion/connexionBDD.php");
    // Requête à effectuer
    $req = 'SELECT * FROM classement WHERE nomQuiz = "'.$mode.'" ORDER BY score DESC LIMIT 0,10';					
    // On récupère le tableau contenant les meilleurs scores puis on l'affiche
    $bests = $bdd->query($req);
    echo '
        <table class="table table-dark table-striped table-hover">
			<thead>
				<tr>
					<th>Rang</th>
                    <th>Score</th>
                    <th>Pseudo</th>
				</tr>
			</thead>	
			<tbody>
         ';
	$rank = 1;
	while ($data = $bests->fetch()) {
        echo '<tr><td>' . $rank . '</td><td>' . $data['score'] . '</td><td>' . $data['pseudo'] . '</td></tr>' ;				
        $rank++;
	}
	$bests->closeCursor();
	echo '
            </tbody>			
		</table>
         ';
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
			<div class="col-sm-12">
				<h1>Bienvenue dans le classement des 10 meilleurs joueurs</h1>
                <h3>En faites vous partie ?</h3>
			</div>
		</div>
        
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#europe">Europe</a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#asie">Asie</a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#afrique">Afrique</a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#amerique">Amérique</a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#oceanie">Océanie</a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#monde">Monde entier</a></li>
        </ul>

        <div class="tab-content">
          <div id="europe" class="tab-pane active">
            <h3>Classement pour le mode "Europe"</h3>
            <?php getArrayBestScore("europe"); ?>
          </div>
          <div id="asie" class="tab-pane fade">
            <h3>Classement pour le mode "Asie"</h3>
            <?php getArrayBestScore("asie"); ?>
          </div>
          <div id="afrique" class="tab-pane fade">
            <h3>Classement pour le mode "Afrique"</h3>
            <?php getArrayBestScore("afrique"); ?>
          </div>
          <div id="amerique" class="tab-pane fade">
            <h3>Classement pour le mode "Amérique"</h3>
            <?php getArrayBestScore("amerique"); ?>
          </div>
          <div id="oceanie" class="tab-pane fade">
            <h3>Classement pour le mode "Océanie"</h3>
            <?php getArrayBestScore("oceanie"); ?>
          </div>
          <div id="monde" class="tab-pane fade">
            <h3>Classement pour le mode "Monde entier"</h3>
            <?php getArrayBestScore("monde"); ?>
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