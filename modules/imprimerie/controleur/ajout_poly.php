<?php

if ((!isset($_SESSION['login'])) || (empty($_SESSION['login'])))  {

    include CHEMIN_VUE_GLOBALE.'erreur_non_connecte.php';

} else {
	if(isset($_SESSION['imprimeur']) && $_SESSION['imprimeur']==1) {

		include_once 'modules/boutique_en_ligne/modele/boutique_en_ligne.php';
		include_once(CHEMIN_LIB.'fonctions-panier.php');


		if (isset($_POST['ajouter_poly'])) {
				enregistrer_poly($_POST['uv'], $_POST['code_poly'], $_POST['type'], $_POST['prix'], $_POST['sans_code_barre'], $_POST['dispo_commande_en_ligne']);
		} else {
			$liste_uv = lister_uv();
			include CHEMIN_VUE.'ajout_poly.php';
		}

	} else {
	        include CHEMIN_VUE_GLOBALE.'hacker.php';
	}

}
?>
