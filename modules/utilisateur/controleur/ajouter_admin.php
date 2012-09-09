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
// Vérification des droits d'accès de la page
if ((isset($_SESSION['login'])) && (!empty($_SESSION['login'])))  {
	
	if ($_SESSION['administrateur'] == 1) //si celui qui veut supprimer la news est bien un administrateur
	{
		if (isset($_POST['valider'])) { //si le formulaire a été envoyé, il faut vérifier les modifications
				include_once CHEMIN_MODELE.'utilisateur.php';
				droit_administrateur($_POST['login_admin'],1);
				$message = '<br>Les droits de l\'utilisateur ont bien été mis à jour.<br>';
				include 'gerer_admin.php'; 
		} else {
			include 'vue/gerer_admin.php';
		}
	} else {
		include CHEMIN_VUE_GLOBALE.'hacker.php';
	}

} else {
	include CHEMIN_VUE_GLOBALE.'erreur_non_connecte.php';

}
?>
