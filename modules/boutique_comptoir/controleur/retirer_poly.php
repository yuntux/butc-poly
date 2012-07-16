<?php

if ((!isset($_SESSION['login'])) || (empty($_SESSION['login'])))  {

    include CHEMIN_VUE_GLOBALE.'erreur_non_connecte.php';

} else {
	if(isset($_SESSION['vendeur']) && $_SESSION['vendeur']==1) {

			include_once 'modules/boutique_en_ligne/modele/boutique_en_ligne.php';
			include_once CHEMIN_MODELE.'boutique_comptoir.php';
			include_once(CHEMIN_LIB.'fonctions-panier.php');

				//on ne peut pas retirer tant que l'étudiant n'a pas été séléctionné
				if(isset($_SESSION['etudiant_en_cours']) && $_SESSION['etudiant_en_cours']!="") {

/*							if (isset($_POST['valider_retrait'])) {
								enregistrer_entete_retrait($_SESSION['panier']['reference'], $_SESSION['etudiant_en_cours']['login'], $_SESSION['login']);
								for ($i=0 ;$i < CompterArticles(); $i++)
								{
								enregistrer_ligne_retrait($_SESSION['panier']['reference'], $_SESSION['panier']['libelleProduit'][$i], $_SESSION['panier']['qteProduit'][$i]);
								}
								unset($_SESSION['etudiant_en_cours']);
							}
*/
							$liste_retraits_possibles = liste_retraits_possibles($_SESSION['etudiant_en_cours']['login']);
					        include CHEMIN_VUE.'retrait_poly.php';

				} else {
					header('Location: index.php?module=boutique_comptoir&action=choix_etudiant&action_post_choix=retirer_poly');
				}
//  include CHEMIN_VUE.'vendre_poly.php';

	} else {
	        include CHEMIN_VUE_GLOBALE.'hacker.php';
	}

}
?>
