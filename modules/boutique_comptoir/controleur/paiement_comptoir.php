<?php

if ((!isset($_SESSION['login'])) || (empty($_SESSION['login'])))  {

    include CHEMIN_VUE_GLOBALE.'erreur_non_connecte.php';

} else {
	if(isset($_SESSION['vendeur']) && $_SESSION['vendeur']==1) {

			include_once 'modules/boutique_en_ligne/modele/boutique_en_ligne.php';
			include_once CHEMIN_MODELE.'boutique_comptoir.php';
			include_once(CHEMIN_LIB.'fonctions-panier.php');

			if(isset($_SESSION['etudiant_en_cours']) && $_SESSION['etudiant_en_cours']!="") {
					if (isset($_POST['paiement_cb']) || isset($_POST['paiement_moneo']) || isset($_POST['paiement_cheuqe'])) {
						//on enregistre la commande en base
						enregistrer_entete_commande($_SESSION['panier']['reference'], $_SESSION['etudiant_en_cours']['login'], $_SESSION['login']);
						for ($i=0 ;$i < CompterArticles() ; $i++)
						{
							enregistrer_ligne_commande($_SESSION['panier']['reference'], $_SESSION['panier']['libelleProduit'][$i], $_SESSION['panier']['qteProduit'][$i]);
						}
						//on enregistre le paiement
						if (isset($_POST['paiement_cb']))
							enregistrer_paiement($_SESSION['panier']['reference'], 'CB');
						if (isset($_POST['paiement_cheque']))
							enregistrer_paiement($_SESSION['panier']['reference'], 'CHEQUE');
						if (isset($_POST['paiement_moneo']))
							enregistrer_paiement($_SESSION['panier']['reference'], 'MONEO');

						//on enregistre le retrait
						enregistrer_entete_retrait($_SESSION['panier']['reference'], $_SESSION['etudiant_en_cours']['login'], $_SESSION['login']);
						for ($i=0 ;$i < CompterArticles() ; $i++)
						{
							enregistrer_ligne_retrait($_SESSION['panier']['reference'], $_SESSION['panier']['libelleProduit'][$i], $_SESSION['panier']['qteProduit'][$i]);
						}

						//on supprime le panier
						supprimePanier();

						//on change d'étudiant
						unset($_SESSION['etudiant_en_cours']);

						//on redirige vers vendre_poly
						include('vendre_poly.php');
					}
			}

	} else {
	        include CHEMIN_VUE_GLOBALE.'hacker.php';
	}

}
?>
