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
// Initialisation
include 'global/init.php';


if ((!isset($_SESSION['login'])) || (empty($_SESSION['login'])))  {
	include 'modules/utilisateur/controleur/connexion.php';
}
if (isset($_GET['deconnexion'])) {
	include 'modules/utilisateur/controleur/deconnexion.php';
} else {

	include 'global/haut.php';

	// Si un module est specifié, on regarde s'il existe
	if (!empty($_GET['module'])) {

		$module = dirname(__FILE__).'/modules/'.$_GET['module'].'/';

		// Si l'action est specifiée, on l'utilise, sinon, on tente une action par défaut
		$action = (!empty($_GET['action'])) ? 'controleur/'.$_GET['action'].'.php' : 'index.php';

		// Si l'action existe, on l'exécute
		if (is_file($module.$action)) {

			include $module.$action;

		// Sinon, on affiche la page d'accueil !
		} else {
			include 'global/accueil.php';
		}

	// Module non specifié ou invalide ? On affiche la page d'accueil !
	} else {

		include 'global/accueil.php';
	}

	include 'global/bas.php';
}
?>
