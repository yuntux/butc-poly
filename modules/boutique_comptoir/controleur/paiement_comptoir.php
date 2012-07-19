<?php

if ((!isset($_SESSION['login'])) || (empty($_SESSION['login'])))  {

    include CHEMIN_VUE_GLOBALE.'erreur_non_connecte.php';

} else {
	if(isset($_SESSION['vendeur']) && $_SESSION['vendeur']==1) {

			include_once 'modules/boutique_en_ligne/modele/boutique_en_ligne.php';
			include_once CHEMIN_MODELE.'boutique_comptoir.php';
			include_once(CHEMIN_LIB.'fonctions-panier.php');

			if(isset($_SESSION['etudiant_en_cours']) && $_SESSION['etudiant_en_cours']!="") {
					if (isset($_POST['payer_cb']) || isset($_POST['payer_moneo']) || isset($_POST['payer_cheque']) || isset($_POST['vente_interne'])) {
						//on enregistre la commande en base
						enregistrer_entete_commande($_SESSION['panier']['reference'], $_SESSION['etudiant_en_cours']['login'], $_SESSION['login']);
						for ($i=0 ;$i < CompterArticles() ; $i++)
							enregistrer_ligne_commande($_SESSION['panier']['reference'], $_SESSION['panier']['libelleProduit'][$i], $_SESSION['panier']['qteProduit'][$i]);

						//on enregistre le paiement
// FIXME : vérification des clés de CB ou de numéro de chèque/compte + nombre de caractères des références des moyens de paiement
						if (isset($_POST['payer_cb']))
							enregistrer_paiement($_SESSION['panier']['reference'], 'CB', $_POST['proprietaire_moyen_paiement'], $_POST['references_moyen_paiement']);
						if (isset($_POST['payer_cheque']))
							enregistrer_paiement($_SESSION['panier']['reference'], 'CHEQUE', $_POST['proprietaire_moyen_paiement'], $_POST['references_moyen_paiement']);
						if (isset($_POST['payer_moneo']))
							enregistrer_paiement($_SESSION['panier']['reference'], 'MONEO', $_POST['proprietaire_moyen_paiement'], $_POST['references_moyen_paiement']);
						if (isset($_POST['vente_interne']) && $_SESSION['etudiant_en_cours']['formation_continue'])
							enregistrer_paiement($_SESSION['panier']['reference'], 'INTERNE', $_POST['proprietaire_moyen_paiement'], $_POST['references_moyen_paiement']);

						//on enregistre le retrait
						enregistrer_entete_retrait($_SESSION['panier']['reference'], $_SESSION['etudiant_en_cours']['login'], $_SESSION['login']);
						for ($i=0 ;$i < CompterArticles() ; $i++)
							enregistrer_ligne_retrait($_SESSION['panier']['reference'], $_SESSION['panier']['libelleProduit'][$i], $_SESSION['panier']['qteProduit'][$i]);
						header('Location: index.php?module=boutique_comptoir&action=changer_etudiant&action_post_changement=vendre_poly');
					}
			}

	} else {
	        include CHEMIN_VUE_GLOBALE.'hacker.php';
	}

}
?>
