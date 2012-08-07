<?php

if ((!isset($_SESSION['login'])) || (empty($_SESSION['login'])))  {

    include CHEMIN_VUE_GLOBALE.'erreur_non_connecte.php';

} else {

	if(isset($_SESSION['vendeur']) && $_SESSION['vendeur']==1) {
	    include_once 'modules/boutique_en_ligne/modele/boutique_en_ligne.php';

		$utilisateur_formation_continue = utilisateur_formation_continue();
	    include CHEMIN_VUE.'formation_continue.php';

	} else {
 
	    include CHEMIN_VUE_GLOBALE.'hacker.php';
	}
}
?>

