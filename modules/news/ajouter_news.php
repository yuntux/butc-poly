<?php
// Vérification des droits d'accès de la page
if ((isset($_SESSION['login'])) && (!empty($_SESSION['login'])))  {

    //on récuppère les données sur le trajet stockées en base qui seront affichées
    include_once CHEMIN_MODELE.'news.php';
	if ($_SESSION['administrateur'] == 1) //si celui qui veut supprimer la news est bien un administrateur
	{
        if (isset($_POST['valider'])) { //si le formulaire a été envoyé, il faut vérifier les modifications
            include 'verif_news.php';
            if (verifier_news($_POST['titre'], $_POST['date'], $_POST['texte']) == true) { //si le formulaire est valide on ajoute dans la bdd
                ajouter_news($_SESSION['login'], $_POST['titre'], dateen($_POST['date']), $_POST['texte']);
                $message = 'Votre news a bien été ajoutée.';
				include 'liste_news.php';
            } else { // si le formulaire est invalide on le renvoie
                //on modifie les valeur du tableau trajet puis on renvoie le formulaire
                $news['date'] = $_POST['date'];
                $news['titre'] = $_POST['titre'];
                $news['texte'] = $_POST['texte'];
                include 'vue/ajouter_news.php';
            }
        } else { //sinon on affiche le formulaire avec les données de la base donc sans modifier le tableau
			$news['date'] = date("Y-m-d");
            include 'vue/ajouter_news.php';
        }
    } else {
        include CHEMIN_VUE_GLOBALE.'hacker.php';
    }
} else {
    include CHEMIN_VUE_GLOBALE.'erreur_non_connecte.php';

}
?>
