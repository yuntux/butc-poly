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
	if(isset($_SESSION['imprimeur']) && $_SESSION['imprimeur']==1) {

		include_once CHEMIN_MODELE.'boutique_en_ligne.php';

		if (isset($_POST['ajouter_poly'])) {
				if (!isset($_POST['sans_code_barre']))
					$_POST['sans_code_barre']=0;
				if (!isset($_POST['dispo_commande_en_ligne']))
					$_POST['dispo_commande_en_ligne']=0;
				if (isset($_POST['uv']) && isset($_POST['code_poly']) && isset($_POST['type']) && isset($_POST['prix']))
					enregistrer_poly($_POST['uv'], $_POST['code_poly'], $_POST['type'], $_POST['prix'], $_POST['sans_code_barre'], $_POST['dispo_commande_en_ligne']);
				else
					echo "Certains champs sont vides. Le poly n\'a pas été ajouté.";
		} else {
			$liste_uv = lister_uv();
			include_once CHEMIN_VUE.'ajout_poly.php';
		}

	} else {
	        include_once CHEMIN_VUE_GLOBALE.'hacker.php';
	}

}
?>
