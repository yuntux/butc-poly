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
	//AFFICHAGE DES ERREURS => OFF EN PRODUCTION
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	//utilisateur de démo
	//session_start();
	//$_SESSION['login']='usertest';

	//paramètre de démo de la base

	if(isset($_GET['profil_demo'])){
		$_SESSION['administrateur'] = 0;
		$_SESSION['vendeur'] = 0;
		$_SESSION['acheteur'] = 0;
		$_SESSION['imprimeur'] = 0;
		$_SESSION['regisseur'] = 0;
		$_SESSION['enseignant'] = 0;

		if($_GET['profil_demo']=='acheteur')
			$_SESSION['acheteur'] = 1;
		if($_GET['profil_demo']=='admin')
			$_SESSION['administrateur'] = 1;
		if($_GET['profil_demo']=='vendeur')
			$_SESSION['vendeur'] = 1;
		if($_GET['profil_demo']=='imprimeur')
			$_SESSION['imprimeur'] = 1;
		if($_GET['profil_demo']=='regisseur')
			$_SESSION['regisseur'] = 1;
		if($_GET['profil_demo']=='enseignant')
			$_SESSION['enseignant'] = 1;
	}

	//Identifiants paybox de démo
/*	define('PBX_SITE', 1999888);
	define('PBX_RANG', 99);
	define('PBX_IDENTIFIANT', 2);
*/
?>
