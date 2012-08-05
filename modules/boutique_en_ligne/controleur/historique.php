<?php

if ((!isset($_SESSION['login'])) || (empty($_SESSION['login'])))  {

    include CHEMIN_VUE_GLOBALE.'erreur_non_connecte.php';

} else {
    
    include_once CHEMIN_MODELE.'boutique_en_ligne.php';
    	
	if (isset($_SESSION['vendeur']) && isset($_GET['login']))
		$login = $_GET['login'];
	else
		$login = $_SESSION['login'];

	$retraits_possibles = liste_retraits_possibles($login);
	$commandes = liste_commandes($login);
	$retraits = liste_retraits($login);

    include CHEMIN_VUE.'historique.php';
}
?>
