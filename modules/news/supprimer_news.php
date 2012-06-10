<?php
// Vérification des droits d'accès de la page
if ((isset($_SESSION['login'])) && (!empty($_SESSION['login'])))  {
	
	//on récuppère les données sur le trajet stockées en base qui seront affichées
	include CHEMIN_MODELE.'news.php';
	$news = detail_news($_GET['id'])->fetch();
	if ($_SESSION['administrateur'] == 1) //si celui qui veut supprimer la news est bien un administrateur
	{
		if (isset($_POST['valider'])) { //si le formulaire a été envoyé, il faut vérifier les modifications
				supprimer_news($_GET['id']);
				$message = 'La news a bien été supprimée.';
				include 'liste_news.php';
		} else { //sinon on affiche le formulaire avec les données de la base donc sans modifier le tableau
			include 'vue/supprimer_news.php';
		}
	} else {
		include CHEMIN_VUE_GLOBALE.'hacker.php';
	}

} else {
	include CHEMIN_VUE_GLOBALE.'erreur_non_connecte.php';

}
?>
