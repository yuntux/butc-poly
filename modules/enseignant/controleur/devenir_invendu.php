<?php

if ((!isset($_SESSION['login'])) || (empty($_SESSION['login'])))  {

    include CHEMIN_VUE_GLOBALE.'erreur_non_connecte.php';

} else {
	if(isset($_SESSION['enseignant']) && $_SESSION['enseignant']==1) {

		include_once 'modules/boutique_en_ligne/modele/boutique_en_ligne.php';
		include_once(CHEMIN_LIB.'fonctions-panier.php');


		$detail_poly = detailler_poly($_GET['code_poly'])->fetch();
//		$detail_poly = $detail_poly->fetch();

		if (isset($_POST['valider'])) {
//FIX ME : remplacer cette vérif par un hash passé en GET ? Éviterait d'obliger les enseignants à se logger, les 2 liens dans le mail
				if($detail_poly->id_responsable == $_SESSION['login'] || (isset($_SESSION['vendeur']) && $_SESSION['vendeur']==1))
					enregistrer_devenir_poly($_GET['code_poly'], $_POST['devenir_poly'], $_SESSION['login']);
				else
					$message_erreur = "Vous n'avez pas les droits sur ce poly.";
		} else {
			include CHEMIN_VUE.'devenir_invendu.php';
		}

	} else {
	        include CHEMIN_VUE_GLOBALE.'hacker.php';
	}

}
?>
