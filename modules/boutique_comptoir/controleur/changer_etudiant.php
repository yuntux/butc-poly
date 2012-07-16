<?php

if ((!isset($_SESSION['login'])) || (empty($_SESSION['login'])))  {

    include CHEMIN_VUE_GLOBALE.'erreur_non_connecte.php';

} else {
	if(isset($_SESSION['vendeur']) && $_SESSION['vendeur']==1) {

			include_once 'modules/boutique_en_ligne/modele/boutique_en_ligne.php';
			include_once CHEMIN_MODELE.'boutique_comptoir.php';
			include_once(CHEMIN_LIB.'fonctions-panier.php');

			supprimePanier();
			unset($_SESSION['etudiant_en_cours']);
			header('Location: index.php?module=boutique_comptoir&action=choix_etudiant&action_post_choix='.$_GET['action_post_changement']);

	} else {
	        include CHEMIN_VUE_GLOBALE.'hacker.php';
	}

}
?>
