<?php
// Vérification des droits d'accès de la page
if ((isset($_SESSION['login'])) && (!empty($_SESSION['login'])))  {

	include_once CHEMIN_MODELE.'utilisateur.php';
	$utilisateur = detail_utilisateur($_SESSION['login'])->fetch();

        if (isset($_POST['valider'])) { //si le formulaire a été envoyé, il faut vérifier les modifications
            include 'verif_profil.php';
            if (verifier_form($_POST['nom'], $_POST['prenom'], $_POST['telephone']) == true) {
                modifier_profil($_SESSION['login'], mb_convert_case($_POST['nom'],MB_CASE_UPPER,"UTF-8"), mb_convert_case($_POST['prenom'],MB_CASE_TITLE,"UTF-8"), $_POST['telephone']);
				$_SESSION['nom'] = mb_convert_case($_POST['nom'],MB_CASE_UPPER,"UTF-8");
			    $_SESSION['prenom'] = mb_convert_case($_POST['prenom'],MB_CASE_TITLE,"UTF-8");
            } else { // si le formulaire est invalide on le renvoie
                //on modifie les valeur du tableau trajet puis on renvoie le formulaire
                $utilisateur['nom'] = $_POST['nom'];
                $utilisateur['prenom'] = $_POST['prenom'];
                $utilisateur['telephone'] = $_POST['telephone'];
                include 'vue/modifier_profil.php';
            }
        } else { //sinon on affiche le formulaire avec les données de la base donc sans modifier le tableau
            include 'vue/modifier_profil.php';
        }

} else {
    include CHEMIN_VUE_GLOBALE.'erreur_non_connecte.php';

}
?>
