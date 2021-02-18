		<header>
			<nav class="navbar navbar-expand-md navbar-inverse bg-custom navbar-dark">
				<!-- Logo du site -->
				<img class="navbar-brand" src="" alt="Le jeu des drapeaux" />
				<!-- Lorsque l'écran est trop petit, ou que la page est trop zoomée, on affiche un bouton pour afficher le menu -->
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
					<span class="navbar-toggler-icon"></span>
				</button>
				<!-- Le menu en question -->
				<div class="collapse navbar-collapse" id="collapsibleNavbar">
					<ul class="nav navbar-nav ml-auto">
						<li class="nav-item">
							<a class="nav-link" href="index.php">Accueil</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="classement.php">Classement</a>
						</li>
						<?php 
						if (!isset($_SESSION['user'])) {
							echo '
							<li class="nav-item">
							<button class="nav-link btn btn-success" type="button" data-toggle="modal" data-target="#signin"><i class="fa fa-user-plus"></i> S\'inscrire</button>
							</li>
							<li class="nav-item" style="padding-left:5px;">
							<button class="nav-link btn btn-info" type="button" data-toggle="modal" data-target="#login"><i class="fa fa-sign-in"></i> Se connecter</button>
							</li>
							';
						}
						else{
							echo '
							<li class="nav-item" style="padding-left:5px;">
							<a class="nav-link btn btn-danger" type="button" href="connexion/signout.php"><i class="fa fa-sign-out"></i> Se déconnecter</a>
							</li>
							';
						}
						?>
					</ul>
				</div>
			</nav>
		</header>
		
		<!-- Inscription -->
		<div class="modal fade" id="signin">
			<div class="modal-dialog">
			  <div class="modal-content">
			  
				<!-- Modal Header -->
				<div class="modal-header">
				  <h4 class="modal-title">Inscription</h4>
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				
				<!-- Modal body -->
				<div class="modal-body">
				  <form method="post" action="connexion/signin.php">
					<label for="pseudo">Pseudo</label>
					<input type="text" name="pseudo" id="pseudo" required /><br />
					<label for="email">Email</label>
					<input type="email" name="email" id="email" required /><br />
					<label for="pwd">Mot de passe</label>
					<input type="password" name="pwd" id="pwd" required /><br />
					<label for="pwd2">Vérification du mot de passe</label>
					<input type="password" name="pwd2" id="pwd" required /><br />
					<input type="submit" value="S'inscrire"/>
				  </form>
				</div>
				
			  </div>
			</div>
		</div>
		
		<!-- Connexion -->
		<div class="modal fade" id="login">
			<div class="modal-dialog">
			  <div class="modal-content">
			  
				<!-- Modal Header -->
				<div class="modal-header">
				  <h4 class="modal-title">Connexion</h4>
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				
				<!-- Modal body -->
				<div class="modal-body">
				  <form method="post" action="connexion/login.php">
					<label for="pseudo">Pseudo</label>
					<input type="text" name="pseudo" id="pseudo" required /><br />
					<label for="pwd">Mot de passe</label>
					<input type="password" name="pwd" id="pwd" required /><br />
					<input type="submit" value="Se connecter"/>
				  </form>
				</div>
				
			  </div>
			</div>
		</div>