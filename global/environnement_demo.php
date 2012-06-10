<?php
	//AFFICHAGE DES ERREURS => OFF EN PRODUCTION
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	//utilisateur de démo
	//session_start();
	//$_SESSION['login']='usertest';

	//paramètre de démo de la base
		
	if(isset($_GET['profil_demo_acheteur']))
	{
		$_SESSION['administrateur'] = 0;
		$_SESSION['vendeur'] = 0;
		$_SESSION['acheteur'] = 1;
	}

	if(isset($_GET['profil_demo_admin']))
	{
		$_SESSION['administrateur'] = 1;
		$_SESSION['vendeur'] = 0;
		$_SESSION['acheteur'] = 0;
	}

	if(isset($_GET['profil_demo_vendeur']))
	{
		$_SESSION['administrateur'] = 0;
		$_SESSION['vendeur'] = 1;
		$_SESSION['acheteur'] = 0;
	}

	echo 'ENVIRONNEMENT DE DEMO';

	echo '<a href="index.php?profil_demo_acheteur=1" >Profil acheteur</a>        ';
	echo '<a href="index.php?profil_demo_vendeur=1">Profil vendeur</a>       ';
	echo '<a href="index.php?profil_demo_admin=1">Profil admin</a>';

	//Identifiants paybox de démo
/*	define('PBX_SITE', 1999888);
	define('PBX_RANG', 99);
	define('PBX_IDENTIFIANT', 2);
*/
?>
