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

	include_once CHEMIN_MODELE.'utilisateur.php';
	$utilisateur = detail_utilisateur($_SESSION['login'])->fetch();

        if (isset($_POST['valider'])) { //si le formulaire a été envoyé, il faut vérifier les modifications
            include 'verif_profil.php';
            if (verifier_form($_POST['nom'], $_POST['prenom'], $_POST['telephone']) == true) {
                modifier_profil($_SESSION['login'], mb_convert_case($_POST['nom'],MB_CASE_UPPER,"UTF-8"), mb_convert_case($_POST['prenom'],MB_CASE_TITLE,"UTF-8"), $_POST['telephone']);
				$_SESSION['nom'] = mb_convert_case($_POST['nom'],MB_CASE_UPPER,"UTF-8");
			    $_SESSION['prenom'] = mb_convert_case($_POST['prenom'],MB_CASE_TITLE,"UTF-8");
            } else { // si le formulaire est invalide on le renvoie
                //on modifie les valeur du tableau trajet puis on renvoie le formulaire
                $utilisateur['nom'] = $_POST['nom'];
                $utilisateur['prenom'] = $_POST['prenom'];
                $utilisateur['telephone'] = $_POST['telephone'];
                include 'vue/modifier_profil.php';
            }
        } else { //sinon on affiche le formulaire avec les données de la base donc sans modifier le tableau
            include 'vue/modifier_profil.php';
        }

} else {
    include CHEMIN_VUE_GLOBALE.'erreur_non_connecte.php';

}
?>
