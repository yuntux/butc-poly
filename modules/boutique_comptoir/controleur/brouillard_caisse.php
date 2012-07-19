<?php

if ((!isset($_SESSION['login'])) || (empty($_SESSION['login'])))  {

    include CHEMIN_VUE_GLOBALE.'erreur_non_connecte.php';

} else {
	if(isset($_SESSION['vendeur']) && $_SESSION['vendeur']==1) {

			include_once 'modules/boutique_en_ligne/modele/boutique_en_ligne.php';
			include_once CHEMIN_MODELE.'boutique_comptoir.php';

			if (isset($_POST['generer_brouillard'])) {

			} else {
				include CHEMIN_VUE.'selection_brouillard_caisse.php';
			}

	} else {
	        include CHEMIN_VUE_GLOBALE.'hacker.php';
	}

}
?>
