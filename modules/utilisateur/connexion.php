<?php
	phpCAS::forceAuthentication();
	$_SESSION['login'] = phpCAS::getUser();
	include_once 'modules/boutique_en_ligne/modele/boutique_en_ligne.php';
	$detail_etudiant = detailler_utilisateur("", $_SESSION['login'])->fetch();
	$_SESSION['num_badge'] = $detail_etudiant->num_badge;
	$_SESSION['login'] = $detail_etudiant->login;
	$_SESSION['nom'] = $detail_etudiant->nom;
	$_SESSION['email'] = $detail_etudiant->email;
	$_SESSION['prenom'] = $detail_etudiant->prenom1;
?>


