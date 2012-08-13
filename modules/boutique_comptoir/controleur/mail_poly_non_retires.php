<?php
if ((!isset($_SESSION['login'])) || (empty($_SESSION['login'])))  {

    include CHEMIN_VUE_GLOBALE.'erreur_non_connecte.php';

} else {
	if(isset($_SESSION['vendeur']) && $_SESSION['vendeur']==1) {

		include_once 'modules/boutique_en_ligne/modele/boutique_en_ligne.php';

		$liste_utilisateurs = liste_utilisateurs(); 
		while($utilisateur = $liste_utilisateurs->fetch()){

			$liste_polys = liste_retraits_possible($utilisateur->login);	
			while($ligne = $liste_polys->fetch()){
				if ($ligne->stock_courant > 0) {
					$headers ='From: "Boutique BUTC BF"<'.EMAIL_CONTACT_BUTC.'>'."\n"; 
					$headers .=EMAIL_CONTACT_BUTC."\n"; 
					$headers .='Content-Type: text/html; charset="iso-8859-1"'."\n"; 
					$headers .='Content-Transfer-Encoding: 8bit'; 

					$message ='<html><head><title>Polycopié à retirer</title></head>
						<body>Il reste '.$ligne->stock_courant.' exemplaire(s) du polycopié '.$ligne->code_barre.' à retirer à la BUTC.
						<br><b>ATTENTION : si ce polycopié n\'est pas retiré avant la fin du semestre, il sera considéré commme abandonné.</b>
						<br><br><br>Cordialement.
						<br>br>'.VENDEUR_BUTC.'</body>';

					echo $message.'<br><br>'$utilisateur->email.'<br>====================================================';

					if(mail($utilisateur->email, 'BUTC : polycopié '.$ligne->code_barre.' non retiré', $message, $headers)) 
						//Le message a bien été envoyé.
					else 
						echo 'Le message n\'a pu être envoyé'; 
				}
			}
		}

	} else {
	        include CHEMIN_VUE_GLOBALE.'hacker.php';
	}

}
?>
