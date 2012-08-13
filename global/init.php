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
