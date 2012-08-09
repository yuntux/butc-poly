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

							if (isset($_POST['valider_retrait'])) {
								$id_retrait = $_SESSION['login'].'_'.date('dmY_His');
								$enregistrer_une_entete = false;
								foreach ($_POST as $cle=>$valeur)
								{
									if(substr($cle,0,10) == "code_poly_" && is_numeric($valeur) && (int)$valeur>0)
									{
// FIXME : on ne vérifie pas que la quantité retirée est comprise entre le stock courant et lenombre d'exemplaires payés pour donner de la souplesse au vendeur
										$enregistrer_une_entete = true;
										enregistrer_ligne_retrait($id_retrait, strtoupper(substr($cle,10,LONGUEUR_CODE_POLY)), $valeur);
									}
								}
								if ($enregistrer_une_entete)
									$duree_retrait = time() - $_SESSION['etudiant_en_cours']['debut_session'];
									enregistrer_entete_retrait($id_retrait, $_SESSION['etudiant_en_cours']['login'], $_SESSION['login'], $duree_retrait);
								header('Location: index.php?module=boutique_comptoir&action=changer_etudiant&action_post_changement=retirer_poly');
							} else {
								$liste_retraits_possibles = liste_retraits_possibles($_SESSION['etudiant_en_cours']['login']);
						        include CHEMIN_VUE.'retrait_poly.php';
							}
				} else {
					header('Location: index.php?module=boutique_comptoir&action=choix_etudiant&action_post_choix=retirer_poly');
				}
//  include CHEMIN_VUE.'vendre_poly.php';

	} else {
	    include CHEMIN_VUE_GLOBALE.'hacker.php';
	}

}
?>
