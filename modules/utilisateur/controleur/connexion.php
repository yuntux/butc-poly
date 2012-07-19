<?php
	phpCAS::forceAuthentication();
	$login = phpCAS::getUser();
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


