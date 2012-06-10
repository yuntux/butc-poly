<?php
// Vérification des droits d'accès de la page
if ((isset($_SESSION['login'])) && (!empty($_SESSION['login'])))  {

    if ($_SESSION['administrateur'] == 1)
    {
		include_once CHEMIN_MODELE.'utilisateur.php';
	    $liste_administrateur = lister_administrateur();
		include 'vue/gerer_admin.php';
    } else {
        include CHEMIN_VUE_GLOBALE.'hacker.php';
    }
} else {
    include CHEMIN_VUE_GLOBALE.'erreur_non_connecte.php';

}
?>
