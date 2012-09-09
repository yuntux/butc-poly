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
	if(isset($_SESSION['enseignant']) && $_SESSION['enseignant']==1) {

		include_once 'modules/boutique_en_ligne/modele/boutique_en_ligne.php';

		$detail_poly = detailler_poly($_GET['code_poly'])->fetch();

		if (isset($_POST['valider'])) {
//FIX ME : remplacer cette vérif par un hash passé en GET ? Éviterait d'obliger les enseignants à se logger, les 2 liens dans le mail
				if($detail_poly->id_responsable == $_SESSION['login'] || (isset($_SESSION['vendeur']) && $_SESSION['vendeur']==1))
					enregistrer_devenir_poly($_GET['code_poly'], $_POST['devenir_poly'], $_SESSION['login']);
				else
					$message_erreur = "Vous n'avez pas les droits sur ce poly.";
		} else {
			include_once CHEMIN_VUE.'devenir_invendu.php';
		}

	} else {
	        include_once CHEMIN_VUE_GLOBALE.'hacker.php';
	}

}
?>
