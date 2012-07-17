<?php

if ((!isset($_SESSION['login'])) || (empty($_SESSION['login'])))  {

    include CHEMIN_VUE_GLOBALE.'erreur_non_connecte.php';

} else {
	if(isset($_SESSION['vendeur']) && $_SESSION['vendeur']==1) {

			include_once 'modules/boutique_en_ligne/modele/boutique_en_ligne.php';
			include_once CHEMIN_MODELE.'boutique_comptoir.php';
			include_once(CHEMIN_LIB.'fonctions-panier.php');


				if (isset($_POST['num_badge_etudiant'])) { //saisie de l'étudiant avec le code RFID de la carte
					unset($_SESSION['etudiant_en_cours']);
					supprimePanier();
				    $detail_etudiant = detailler_utilisateur($_POST['num_badge_etudiant'], "")->fetch();
					if ($detail_etudiant->login != "") {
						$_SESSION['etudiant_en_cours']['num_badge'] = $detail_etudiant->num_badge;
						$_SESSION['etudiant_en_cours']['login'] = $detail_etudiant->login;
						$_SESSION['etudiant_en_cours']['nom'] = $detail_etudiant->nom;
						$_SESSION['etudiant_en_cours']['prenom'] = $detail_etudiant->prenom1;
						$_SESSION['etudiant_en_cours']['formation_continue'] = $detail_etudiant->formation_continue;
						creationPanier();
						//redirection vers la cible
						header('Location: index.php?module=boutique_comptoir&action='.$_GET['action_post_choix']);
					} else {
						//FIXME : bug lorsque l'étudiant n'est pas en base. PDO foire alors qu'il ne foire pas avec un code barre de poly inexistant !
						$message_erreur = "Le numéro de badge ".$_POST['num_badge_etudiant']." est invalide.";
					}

				} else {
					include CHEMIN_VUE.'choix_etudiant.php';
				}

	} else {
	        include CHEMIN_VUE_GLOBALE.'hacker.php';
	}

}
?>
