<?php
// Initialisation
include 'global/init.php';


if ((!isset($_SESSION['login'])) || (empty($_SESSION['login'])))  {
	include 'modules/utilisateur/controleur/connexion.php';
}
if (isset($_GET['deconnexion'])) {
	include 'modules/utilisateur/controleur/deconnexion.php';
} else {

	include 'global/haut.php';

	// Si un module est specifié, on regarde s'il existe
	if (!empty($_GET['module'])) {

		$module = dirname(__FILE__).'/modules/'.$_GET['module'].'/';

		// Si l'action est specifiée, on l'utilise, sinon, on tente une action par défaut
		$action = (!empty($_GET['action'])) ? 'controleur/'.$_GET['action'].'.php' : 'index.php';

		// Si l'action existe, on l'exécute
		if (is_file($module.$action)) {

			include $module.$action;

		// Sinon, on affiche la page d'accueil !
		} else {
			include 'global/accueil.php';
		}

	// Module non specifié ou invalide ? On affiche la page d'accueil !
	} else {

		include 'global/accueil.php';
	}

	include 'global/bas.php';
}
?>
