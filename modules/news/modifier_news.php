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

    //on récuppère les données sur le trajet stockées en base qui seront affichées
    include_once CHEMIN_MODELE.'news.php';
    $news = detail_news($_GET['id'])->fetch();
	if ($_SESSION['administrateur'] == 1) //si celui qui veut supprimer la news est bien un administrateur
	{
        if (isset($_POST['valider'])) { //si le formulaire a été envoyé, il faut vérifier les modifications
            include 'verif_news.php';
            if (verifier_news($_POST['titre'], $_POST['date'], $_POST['texte']) == true) { //si le formulaire est valide on ajoute dans la bdd
                modifier_news($_GET['id'], $_SESSION['login'], $_POST['titre'], dateen($_POST['date']), $_POST['texte']);
                $message = 'Votre news a bien été modifiée.';
				include 'liste_news.php';
            } else { // si le formulaire est invalide on le renvoie
                //on modifie les valeur du tableau trajet puis on renvoie le formulaire
                $news->date = dateen($_POST['date']);
                $news->titre = $_POST['titre'];
                $news->texte = $_POST['texte'];
                include 'vue/modifier_news.php';
            }
        } else { //sinon on affiche le formulaire avec les données de la base donc sans modifier le tableau
            include 'vue/modifier_news.php';
        }
    } else {
        include CHEMIN_VUE_GLOBALE.'hacker.php';
    }
} else {
    include CHEMIN_VUE_GLOBALE.'erreur_non_connecte.php';

}
?>
