<?php

if ((!isset($_SESSION['login'])) || (empty($_SESSION['login'])))  {

    include CHEMIN_VUE_GLOBALE.'erreur_non_connecte.php';

} else {

    include CHEMIN_MODELE.'statistique.php';
	$achat_comptoir = duree_moyenne_achat_retrait_comptoir()->fetch();
	$achat_en_ligne = duree_moyenne_simple_retrait_comptoir()->fetch();
    include CHEMIN_VUE.'statistique.php';

}
?>

