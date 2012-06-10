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
					$_SESSION['etudiant_en_cours']['num_badge'] = $detail_etudiant->num_badge;
					$_SESSION['etudiant_en_cours']['login'] = $detail_etudiant->login;
					$_SESSION['etudiant_en_cours']['nom'] = $detail_etudiant->nom;
					$_SESSION['etudiant_en_cours']['prenom'] = $detail_etudiant->prenom1;
					creationPanier();
				}

				if (isset($_POST['changer_etudiant'])) { //saisie de l'étudiant avec le code RFID de la carte
					supprimePanier();
					unset($_SESSION['etudiant_en_cours']);
				}

				//on ne peut pas toucher au panier tant que l'étudiant n'a pas été séléctionné
				if(isset($_SESSION['etudiant_en_cours']) && $_SESSION['etudiant_en_cours']!="") {

							if (isset($_POST['code_poly'])) { //ajouter le poly ayant le code barre correspondant
								$detail_poly = detailler_poly($_POST['code_poly'])->fetch();
								ajouterArticle($detail_poly->code_barre, 1, $detail_poly->prix);					
								//FIXME : vérifier le comportement de ajouter_article dans le cas où le code issu de ajouter_poly n'existe pas.
							}

							if (isset($_GET['supprimer_poly']))
								supprimerArticle($_GET['supprimer_poly']);

					        include CHEMIN_VUE.'saisie_poly.php';
				} else {

					        include CHEMIN_VUE.'choix_etudiant.php';
				}
//  include CHEMIN_VUE.'vendre_poly.php';

	} else {
	        include CHEMIN_VUE_GLOBALE.'hacker.php';
	}

}
?>
