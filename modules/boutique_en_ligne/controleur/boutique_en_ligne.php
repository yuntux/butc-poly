<?php

if ((!isset($_SESSION['login'])) || (empty($_SESSION['login'])))  {

    include CHEMIN_VUE_GLOBALE.'erreur_non_connecte.php';

} else {
	
    include_once CHEMIN_MODELE.'boutique_en_ligne.php';
	$liste_poly_tc_cs = lister_poly("TC", "CS");
	$liste_poly_tc_tm = lister_poly("TC", "TM");
	$liste_poly_gi_cs = lister_poly("GI", "CS");
	$liste_poly_gi_tm = lister_poly("GI", "TM");
	$liste_poly_tsh =  lister_poly("%", "%");
	$liste_poly_gm_cs =  lister_poly("GM", "CS");
	$liste_poly_gm_tm =  lister_poly("GM", "TM");
	$liste_poly_gsm_cs =  lister_poly("GSM", "CS");
	$liste_poly_gsm_tm =  lister_poly("GSM", "TM");
	$liste_poly_gb_cs =  lister_poly("GB", "CS");
	$liste_poly_gb_tm =  lister_poly("GB", "TM");
	$liste_poly_gp_cs =  lister_poly("GP", "CS");
	$liste_poly_gp_tm =  lister_poly("GP", "TM");
	$liste_poly_gsu_cs =  lister_poly("GSU", "CS");
	$liste_poly_gsu_tm =  lister_poly("GSU", "TM");

	include(CHEMIN_LIB.'fonctions-panier.php');
	creationPanier();

	
        if (isset($_POST['code_poly'])) { //si le formulaire a été envoyé, il faut vérifier les modifications
            $detail_poly = detailler_poly($_POST['code_poly'])->fetch();
			if ($detail_poly->code_barre != "")
				ajouterArticle($detail_poly->code_barre, 1, $detail_poly->prix);
			else
				$message_erreur = "Le poly ".$_POST['code_poly']." est invalide.";
//FIXME : vérifier le comportement de ajouter_article dans le cas où le code issu de code_poly n'existe pas.
		}

		if (isset($_GET['supprimer_poly']))
			supprimerArticle($_GET['supprimer_poly']);


        include CHEMIN_VUE.'boutique_en_ligne.php';

}
?>
