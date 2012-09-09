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
//	phpCAS::forceAuthentication();
//	$login = phpCAS::getUser();
	$login='adumaine';
	include_once 'modules/boutique_en_ligne/modele/boutique_en_ligne.php';
	$detail_utilisateur = detailler_utilisateur("", $login)->fetch();
	if ($detail_utilisateur->login != ""){
		$_SESSION['num_badge'] = $detail_utilisateur->num_badge;
		$_SESSION['login'] = $detail_utilisateur->login;
		$_SESSION['nom'] = $detail_utilisateur->nom;
		$_SESSION['email'] = $detail_utilisateur->email;
		$_SESSION['prenom'] = $detail_utilisateur->prenom1;
		$_SESSION['formation_continue'] = $detail_utilisateur->formation_continue;
		$_SESSION['administrateur'] = $detail_utilisateur->administrateur;
		$_SESSION['vendeur'] = $detail_utilisateur->vendeur;
		$_SESSION['imprimeur'] = $detail_utilisateur->imprimeur;
		$_SESSION['acheteur'] = $detail_utilisateur->acheteur;
		$_SESSION['enseignant'] = $detail_utilisateur->enseignant;
	} else {
		echo '<strong>Utilisateur invalide.</strong>';
	}
?>


