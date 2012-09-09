<?php
////////////////////////////////////////////////////////////////////////////////
//
//    Ce fichier fait partie intégrante du Système de Gestion des Polycopiés
//    Copyright (C) 2012 - Aurélien DUMAINE (<wwwetu.utc.fr/~adumaine/>).
//
//    This program is free software: you can redistribute it and/or modify
//    it under the terms of the GNU Affero General Public License as
//    published by the Free Software Foundation, either version 3 of the
//    License, or (at your option) any later version.
//
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU Affero General Public License for more details.
//
//    You should have received a copy of the GNU Affero General Public License
//    along with this program.  If not, see <http://www.gnu.org/licenses/>.
//
////////////////////////////////////////////////////////////////////////////////
?>
<?php

if ((!isset($_SESSION['login'])) || (empty($_SESSION['login'])))  {

    include_once CHEMIN_VUE_GLOBALE.'erreur_non_connecte.php';

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

	include_once CHEMIN_LIB.'fonctions-panier.php';
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


        include_once CHEMIN_VUE.'boutique_en_ligne.php';
	}
 ?>
