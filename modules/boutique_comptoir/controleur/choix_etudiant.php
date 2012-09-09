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


				if (isset($_POST['num_badge_etudiant'])) { //saisie de l'étudiant avec le code RFID de la carte
					unset($_SESSION['etudiant_en_cours']);
					supprimePanier();
				    $detail_etudiant = detailler_utilisateur($_POST['num_badge_etudiant'], "")->fetch();
					if ($detail_etudiant->login != "") {
						$_SESSION['etudiant_en_cours']['num_badge'] = $detail_etudiant->num_badge;
						$_SESSION['etudiant_en_cours']['login'] = $detail_etudiant->login;
						$_SESSION['etudiant_en_cours']['nom'] = $detail_etudiant->nom;
						$_SESSION['etudiant_en_cours']['prenom'] = $detail_etudiant->prenom1;
						$_SESSION['etudiant_en_cours']['formation_continue'] = $detail_etudiant->formation_continue;
						$_SESSION['etudiant_en_cours']['debut_session'] = time();
						creationPanier();
						//redirection vers la cible
						header('Location: index.php?module=boutique_comptoir&action='.$_GET['action_post_choix']);
					} else {
						//FIXME : bug lorsque l'étudiant n'est pas en base. PDO foire alors qu'il ne foire pas avec un code barre de poly inexistant !
						$message_erreur = "Le numéro de badge ".$_POST['num_badge_etudiant']." est invalide.";
					}

				} else {
					include CHEMIN_VUE.'choix_etudiant.php';
				}

	} else {
	        include CHEMIN_VUE_GLOBALE.'hacker.php';
	}

}
?>
