<?php
// Vérification des droits d'accès de la page
if ((isset($_SESSION['login'])) && (!empty($_SESSION['login'])))  {
	
	if ($_SESSION['administrateur'] == 1) //si celui qui veut supprimer la news est bien un administrateur
	{
		if (isset($_POST['valider'])) { //si le formulaire a été envoyé, il faut vérifier les modifications
				include_once CHEMIN_MODELE.'utilisateur.php';
				droit_administrateur($_POST['login_admin'],1);
				$message = '<br>Les droits de l\'utilisateur ont bien été mis à jour.<br>';
				include 'gerer_admin.php'; 
		} else {
			include 'vue/gerer_admin.php';
		}
	} else {
		include CHEMIN_VUE_GLOBALE.'hacker.php';
	}

} else {
	include CHEMIN_VUE_GLOBALE.'erreur_non_connecte.php';

}
?>
