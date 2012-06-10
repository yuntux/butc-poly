<?php
// Vérification des droits d'accès de la page
if ((isset($_SESSION['login'])) && (!empty($_SESSION['login'])))  {

	if ($_SESSION['administrateur'] == 1)
	{
		if ($_SESSION['login'] != $_GET['id']) {
			include_once CHEMIN_MODELE.'utilisateur.php';
			droit_administrateur($_GET['id'],0);
			$message = 'Les droits de l\'utilisateur ont bien été mis à jour.';
			include 'gerer_admin.php';
		} else {
			$message = 'Vous ne pouvez pas retirer vos propres droits d\'administration.';
			include 'gerer_admin.php';
		}
	}
	else {
		include CHEMIN_VUE_GLOBALE.'hacker.php';
	}

} else {
	include CHEMIN_VUE_GLOBALE.'erreur_non_connecte.php';
}
?>
