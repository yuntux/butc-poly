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
	if(isset($_SESSION['imprimeur']) && $_SESSION['imprimeur']==1) {

		include_once 'modules/boutique_en_ligne/modele/boutique_en_ligne.php';
		include_once(CHEMIN_LIB.'fonctions-panier.php');


		if (isset($_POST['valider_suppression'])) {
				supprimer_impression($_GET['id']);
				header('Location: index.php?module=imprimerie&action=liste_impression');
		} else {
			include CHEMIN_VUE.'supprimer_impression.php';
		}

	} else {
	        include CHEMIN_VUE_GLOBALE.'hacker.php';
	}

}
?>