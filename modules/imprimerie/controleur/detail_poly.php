<?php

if ((!isset($_SESSION['login'])) || (empty($_SESSION['login'])))  {

    include CHEMIN_VUE_GLOBALE.'erreur_non_connecte.php';

} else {
	if(isset($_SESSION['imprimeur']) && $_SESSION['imprimeur']==1) {

		include_once 'modules/boutique_en_ligne/modele/boutique_en_ligne.php';
		$detail_poly = detailler_poly($_GET['code_poly'])->fetch();
		$detail_ligne_commande = detailler_ligne_commande($_GET['code_poly']);
		$detail_ligne_retrait = detailler_ligne_retrait($_GET['code_poly']);
		$detail_ligne_impression = detailler_ligne_impression($_GET['code_poly']);
		include CHEMIN_VUE.'detail_poly.php';

	} else {
	        include CHEMIN_VUE_GLOBALE.'hacker.php';
	}

}
?>
