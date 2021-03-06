<!DOCTYPE html>
<html lang="fr">
<head>
  <title>One Bee - Flux video</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="bootstrap.min.css" rel="stylesheet">
  <link href="flux.css" rel="stylesheet">
  <script src="jquery-3.2.1.min.js"></script>
  <script src="bootstrap.min.js"></script>
  <script type="text/javascript">
		// scrip trouvé sur internet qui permet d'actualiser le contenu d'une div, à interval régulier, sans rafraichir la page complète
		function writediv(texte, endroit)
		{
			$("#endroit").html(texte);
		}
		function afficher()
		{
		if(texte = file('compteur.php'))//permet de choisir le fichier que l'on va afficher dans la div : ici compteur.php
		{
		 writediv('<p align="left">'+texte+'</p>', 'compteur');//permet de choisir dans quelle div on va affichier notre fichier : ici la div qui a pour classe "compteur"
		}
		}
		function file(fichier)
		{
		$.get("compteur.php", function(data, status){
				$("#compteur").html(data);
			});
		}
		setInterval('afficher()', 500); // nombre de milisecondes entre deux rafraichissements : ici 0.5 secondes
		
		//exécute le code de la page session.php qui permet d'actualiser la date courante
				function loadSession(){
			$("#session").load("session.php");
		}
		//lance la fonction loadSession lorsque l'on click sur le bouton qui  pour id update
		$(function() {
				$('#update').click(function() {				
					loadSession();
				}); 
			});
			
  </script>
</head>
<body >
<!-- barre des menus en haut de la page (avec bootstraps) inverse pour fixer les menus à gauche, fixed-top pour avoir la barre affiché quand on scroll vers le bas -->
	<nav class="navbar navbar-inverse navbar-fixed-top">
	  <div class="container-fluid">
		<div class="navbar-header">
		<!--titre de la barre des menus qui permet aussi de revenir à l'acceuil -->
		 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
		 <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
		</button>
      <a class="navbar-brand" href="index.php">One Bee</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
	  <!-- les 3 boutons du menu. celui qui est "active" est en surbrillance -->
			<li><a href="index.php">ACCUEIL</a></li> 
			<li><a href="graphe.php">GRAPHIQUE</a></li>
			<li class="active"><a href="flux.php">FLUX VIDEO</a></li>
      </ul>
	  <!-- bouton déroullant parametrage-->
      <ul class="nav navbar-nav navbar-right">
		<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">PARAMETRAGE <span class="caret"></span></a>
        <ul class="dropdown-menu"><!-- menu déroulant-->
          <li><a href="#">REDEMARRER</a></li>
          <li><a href="#">COMPTEUR A ZERO</a></li>
		  <!--ligne à copier pour ajouter des boutons pour les futures fonctionnalités
          <li><a href="#">FONCTIONNALITES FUTURES...</a></li>-->
        </ul>
		</li>
	  </ul>
	  </div>
	</nav>
	<!--Fin de la barre des menus -->
	<?php 
	session_start();/*on démare une session pour les varriables de session que l'on va avoir*/
	
	/*la première fois ue l'on arrive sur la page flux.php la varriable qui contien la date courante
	est vide donc on la remplie*/
	if(empty($_SESSION['dateCourante']))
	{
		$_SESSION['dateCourante'] = new DateTime();
		$_SESSION['dateCourante']->setTimezone(new DateTimeZone("Europe/Paris"));// pour avoir la bonne heure
	}
	
	/*si l'utilisateur a envoyé le formulaire on met la valeur dans la varrible de session*/
	if(!empty($_POST['debut']))
	{
		$_SESSION['debut'] = $_POST['debut'];
	}
	else/*sinon on vide la varrible de session*/
	{
		unset($_SESSION['debut']);
	}
	// Permet d'afficher le flux vidéo de motion sur une page web.
	// N'oubliez pas de configurer l'adresse IP et le port correctement.
	$IP = $_SERVER['SERVER_ADDR'];
	$PORT = 8081;
	echo '<img alt="http://'.$IP.':'.$PORT.'/" src="http://'.$IP.':'.$PORT.'/">';
	?>
	<form action="flux.php" method="post">
	date de début de la ligne 3 </br>
	<input type="datetime-local" name="debut"  placeholder="mm/jj/aaaa hh:mm">
	<button type="submit">changer</button>
	</form>
	<div id="compteur"> <!-- div dans laquelle on affiche compteur.php grâce au scrip -->
	</div>
	<button id="update">Mettre à jour la ligne 2</button>
	<div id="session"></div><!-- div dans laquelle on exécute session.php grâce au scrip -->
</body>
</html>
