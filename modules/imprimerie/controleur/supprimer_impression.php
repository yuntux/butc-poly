<?php

if ((!isset($_SESSION['login'])) || (empty($_SESSION['login'])))  {

    include CHEMIN_VUE_GLOBALE.'erreur_non_connecte.php';

} else {
	if(isset($_SESSION['imprimeur']) && $_SESSION['imprimeur']==1) {

		include_once 'modules/boutique_en_ligne/modele/boutique_en_ligne.php';
		include_once(CHEMIN_LIB.'fonctions-panier.php');


		if (isset($_POST['valider_suppression'])) {
				supprimer_impression($_GET['id']);
				header('Location: index.php?module=imprimerie&action=liste_impression');
		} else {
			include CHEMIN_VUE.'supprimer_impression.php';
		}

	} else {
	        include CHEMIN_VUE_GLOBALE.'hacker.php';
	}

}
?>
