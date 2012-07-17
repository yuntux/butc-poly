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

	echo 'ENVIRONNEMENT DE DEMO ';

	echo '<a href="index.php?profil_demo=acheteur" >Profil acheteur</a> ';
	echo '<a href="index.php?profil_demo=enseignant">Profil enseignant</a> ';
	echo '<a href="index.php?profil_demo=imprimeur">Profil imprimeur</a> ';
	echo '<a href="index.php?profil_demo=vendeur">Profil vendeur</a> ';
	echo '<a href="index.php?profil_demo=regisseur">Profil régisseur</a> ';
	echo '<a href="index.php?profil_demo=admin">Profil admin</a>';

	//Identifiants paybox de démo
/*	define('PBX_SITE', 1999888);
	define('PBX_RANG', 99);
	define('PBX_IDENTIFIANT', 2);
*/
?>
