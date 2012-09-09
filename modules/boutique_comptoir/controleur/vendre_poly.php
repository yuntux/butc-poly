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

    include CHEMIN_VUE_GLOBALE.'erreur_non_connecte.php';

} else {
	if(isset($_SESSION['vendeur']) && $_SESSION['vendeur']==1) {

			include_once 'modules/boutique_en_ligne/modele/boutique_en_ligne.php';
			include_once CHEMIN_MODELE.'boutique_comptoir.php';
			include_once(CHEMIN_LIB.'fonctions-panier.php');

				//on ne peut pas toucher au panier tant que l'étudiant n'a pas été séléctionné
				if(isset($_SESSION['etudiant_en_cours']) && $_SESSION['etudiant_en_cours']!="") {

							if (isset($_POST['code_poly'])) { //ajouter le poly ayant le code barre correspondant
								$detail_poly = detailler_poly(strtoupper($_POST['code_poly']))->fetch();
								if ($detail_poly->code_barre != "")
									ajouterArticle($detail_poly->code_barre, 1, $detail_poly->prix);
								else
									$message_erreur = "Le poly ".$_POST['code_poly']." est invalide.";
							}

							if (isset($_GET['supprimer_poly']))
								supprimerArticle($_GET['supprimer_poly']);

							$articles_sans_code_barre = articles_sans_code_barre();
					        include CHEMIN_VUE.'saisie_poly.php';
				} else {
					header('Location: index.php?module=boutique_comptoir&action=choix_etudiant&action_post_choix=vendre_poly');
				}
//  include CHEMIN_VUE.'vendre_poly.php';

	} else {
	        include CHEMIN_VUE_GLOBALE.'hacker.php';
	}

}
?>
