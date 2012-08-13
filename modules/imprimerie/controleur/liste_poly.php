<?php

if ((!isset($_SESSION['login'])) || (empty($_SESSION['login'])))  {

    include CHEMIN_VUE_GLOBALE.'erreur_non_connecte.php';

} else {
	if(isset($_SESSION['imprimeur']) && $_SESSION['imprimeur']==1) {

		include_once 'modules/boutique_en_ligne/modele/boutique_en_ligne.php';
		$liste_polys = lister_poly();

		include CHEMIN_VUE.'liste_poly.php';

	} else {
	        include CHEMIN_VUE_GLOBALE.'hacker.php';
	}

}
?>
