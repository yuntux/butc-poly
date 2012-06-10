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

				//on ne peut pas retirer tant que l'étudiant n'a pas été séléctionné
				if(isset($_SESSION['etudiant_en_cours']) && $_SESSION['etudiant_en_cours']!="") {
							if (isset($_POST['valider_retrait'])) {
								enregistrer_entete_retrait($_SESSION['panier']['reference'], $_SESSION['etudiant_en_cours']['login'], $_SESSION['login']);
								for ($i=0 ;$i < CompterArticles(); $i++)
								{
								enregistrer_ligne_retrait($_SESSION['panier']['reference'], $_SESSION['panier']['libelleProduit'][$i], $_SESSION['panier']['qteProduit'][$i]);
								}
								unset($_SESSION['etudiant_en_cours']);
							}

					        include CHEMIN_VUE.'retirer_poly.php';

				} else {
							$liste_commandes = liste_commandes($_SESSION['etudiant_en_cours']['login']);
					        include CHEMIN_VUE.'choix_etudiant.php';
				}
//  include CHEMIN_VUE.'vendre_poly.php';

	} else {
	        include CHEMIN_VUE_GLOBALE.'hacker.php';
	}

}
?>
