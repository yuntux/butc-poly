<?php
if ((!isset($_SESSION['login'])) || (empty($_SESSION['login'])))  {

    include CHEMIN_VUE_GLOBALE.'erreur_non_connecte.php';

} else {
	if(isset($_SESSION['imprimeur']) && $_SESSION['imprimeur']==1) {

		include_once 'modules/boutique_en_ligne/modele/boutique_en_ligne.php';

		$liste_util = liste_utilisateurs(); 
		while($utilisateur = $liste_util->fetch()){
			$liste_polys = liste_retraits_possibles($utilisateur->login);	
			while($ligne = $liste_polys->fetch()){
				$poly_non_retires = $ligne->qte_payee - $ligne->qte_retiree;
				if ($poly_non_retires != 0) {
					$headers ='From: "Boutique BUTC BF"<'.EMAIL_CONTACT_BUTC.'>'."\n"; 
					$headers .=EMAIL_CONTACT_BUTC."\n"; 
					$headers .='Content-Type: text/html; charset="iso-8859-1"'."\n"; 
					$headers .='Content-Transfer-Encoding: 8bit'; 

					$message ='<html><head><title>Polycopié à retirer</title></head>
						<body>Il reste '.$poly_non_retires.' exemplaire(s) du polycopié '.$ligne->codep.' à retirer à la BUTC.
						<br><b>ATTENTION : si ce polycopié n\'est pas retiré avant la fin du semestre, il sera considéré commme abandonné.</b>
						<br><br><br>Cordialement.
						<br><br>'.VENDEUR_BUTC.'</body>';

					echo $message.'<br><br>'.$utilisateur->email.'<br>====================================================<br>';

					if(mail($utilisateur->email, 'BUTC : polycopié '.$ligne->codep.' non retiré', $message, $headers)) 
						echo '<br>Le mail a été envoyé.<br>';
					else 
						echo '<br>Le message n\'a pu être envoyé.<br>'; 
				}
			}
		}

	} else {
	        include CHEMIN_VUE_GLOBALE.'hacker.php';
	}

}
?>
