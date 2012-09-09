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

include_once('config.php');

//on affiche pas les erreurs php lorsqu'on est en prod !
ini_set('display_errors', 0);

// Désactivation des guillemets magiques
ini_set('magic_quotes_runtime', 0);

if (1 == get_magic_quotes_gpc())
{
	function remove_magic_quotes_gpc(&$value) {
	
		$value = stripslashes($value);
	}
	array_walk_recursive($_GET, 'remove_magic_quotes_gpc');
	array_walk_recursive($_POST, 'remove_magic_quotes_gpc');
	array_walk_recursive($_COOKIE, 'remove_magic_quotes_gpc');
}


//Inialisation du serveur CAS
	include_once(CHEMIN_LIB.'CAS/CAS.php');
	phpCAS::client(CAS_VERSION_2_0,SERVEUR_SSO,PORT_SSO,RACINE_SSO);
	phpCAS::setLang(PHPCAS_LANG_FRENCH);
	phpCAS::setNoCasServerValidation();

if (ENVIRONNEMENT_DEMO)
	include('environnement_demo.php');


//Connexion à la base de donnée

try {
    $connexion = new PDO('mysql:host='.SQL_HOST.';dbname='.SQL_DATABASE, SQL_USERNAME, SQL_PASSWORD, array(
    PDO::ATTR_PERSISTENT => true
)); // CONNEXION PERSISTANTE : pas besoin de la fermer en fin de script, elle est mise en cache
	$connexion->exec("SET CHARACTER SET utf8");
} catch (PDOException $e) {
    print "Erreur ! : " . $e->getMessage();
    die();
}

//fonction de conversion des dates
date_default_timezone_set("Europe/Paris");
function dateen($date) {
$split = split("/",$date);
$jour = $split[0];
$mois = $split[1];
$annee = $split[2];
return "$annee"."-"."$mois"."-"."$jour";
}

function datefr($date) {
$split = split("-",$date);
$annee = $split[0];
$mois = $split[1];
$jour = $split[2];
return "$jour"."/"."$mois"."/"."$annee";
}

?>
