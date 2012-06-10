<?php

if ((!isset($_SESSION['login'])) || (empty($_SESSION['login'])))  {

    include CHEMIN_VUE_GLOBALE.'erreur_non_connecte.php';

} else {
	
    include_once CHEMIN_MODELE.'boutique_en_ligne.php';
	include(CHEMIN_LIB.'fonctions-panier.php');

	if (isset($_POST['payer_panier'])) {
		//on enregistre la commande en base
		enregistrer_entete_commande($_SESSION['panier']['reference'], $_SESSION['login'], $_SESSION['login']);
		for ($i=0 ;$i < CompterArticles() ; $i++)
		{
			enregistrer_ligne_commande($_SESSION['panier']['reference'], $_SESSION['panier']['libelleProduit'][$i], $_SESSION['panier']['qteProduit'][$i]);
		}


		//on génère les paramètres du paiement paybox
		if (!$fp = fopen(FICHIERS_PAYBOX.$_SESSION['panier']['reference'],"w+")) {
			echo "Echec de l'ouverture du fichier";
			exit;
		} else {
			$montant_en_centimes = MontantGlobal()*100;
			fputs($fp, "PBX_SITE = ".PBX_SITE."\n");
			fputs($fp, "PBX_RANG = ".PBX_RANG."\n");
			fputs($fp, "PBX_IDENTIFIANT = ".PBX_IDENTIFIANT."\n");
			fputs($fp, "PBX_TOTAL = ".$montant_en_centimes."\n");
			fputs($fp, "PBX_DEVISE = ".PBX_DEVISE."\n");
			fputs($fp, "PBX_CMD = ".$_SESSION['panier']['reference']."\n");
			fputs($fp, "PBX_PORTEUR = ".$_SESSION['email']."\n");
			fputs($fp, "PBX_RETOUR = ".PBX_RETOUR."\n");
			fputs($fp, "PBX_REPONDRE_A = ".PBX_REPONDRE_A."\n");
			fputs($fp, "PBX_EFFECTUE = ".PBX_EFFECTUE."\n");
			fputs($fp, "PBX_REFUSE = ".PBX_REFUSE."\n");
			fputs($fp, "PBX_ANNULE = ".PBX_ANNULE);

			if (ENVIRONNEMENT_DEMO) {
				fputs($fp, "\nPBX_PAYBOX = https://preprod-tpeweb.paybox.com/cgi/MYchoix_pagepaiement.cgi");
				fputs($fp, "\nPBX_BACKUP1 = https://preprod-tpeweb.paybox.com/cgi/MYchoix_pagepaiement.cgi");
				fputs($fp, "\nPBX_BACKUP2 = https://preprod-tpeweb.paybox.com/cgi/MYchoix_pagepaiement.cgi");
			}

			fclose($fp);
		}


		//on l'envoie au cgi paybox
		echo '
		<script type="text/javascript">
			window.onload = function() {document.forms["redirection_paybox"].submit();}
			}
		</script>';
		echo '<FORM NAME="redirection_paybox" ACTION = "/cgi-bin/modulev2.cgi" METHOD = post>';
		echo '<INPUT TYPE = hidden NAME = PBX_MODE VALUE = "'.PBX_MODE.'">';
		echo '<INPUT TYPE = hidden NAME = PBX_OPT VALUE = "'.REPERTOIRE_SERVEUR.FICHIERS_PAYBOX.$_SESSION['panier']['reference'].'">';
		echo '<INPUT TYPE = submit NAME = bouton_paiement VALUE ="paiement">';
		echo '</FORM>';

		//on supprime le panier
		supprimePanier();

	}

}
?>
