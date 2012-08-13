<?php
if ((!isset($_SESSION['login'])) || (empty($_SESSION['login'])))  {

    include CHEMIN_VUE_GLOBALE.'erreur_non_connecte.php';

} else {
	if(isset($_SESSION['vendeur']) && $_SESSION['vendeur']==1) {

		include_once 'modules/boutique_en_ligne/modele/boutique_en_ligne.php';

		$liste_polys = lister_poly();	
		while($ligne = $liste_polys->fetch()){
			if ($ligne->stock_courant > 0) {
				$headers ='From: "Boutique BUTC BF"<'.EMAIL_CONTACT_BUTC.'>'."\n"; 
				$headers .=EMAIL_CONTACT_BUTC."\n"; 
				$headers .='Content-Type: text/html; charset="iso-8859-1"'."\n"; 
				$headers .='Content-Transfer-Encoding: 8bit'; 

				$message ='<html><head><title>Devenir des polycopiés invendus</title></head>
		<body>Il reste '.$ligne->stock_courant.' exemplaire(s) du polycopié '.$ligne->code_barre.'.
		<br>Devons-nous les détruire ou bien les conserver et les remettre en vente au semestre prochain ?
		<br>Merci de cliquer sur le lien suivant afin de nous faire parvenir votre réponse :
		<a href="http://'.IP_SERVEUR_BUTC.'/index.php?module=enseignant&action=devenir_invendu&code_poly='.$ligne->code_barre.'">http://'.IP_SERVEUR_BUTC.'/index.php?module=enseignant&action=devenir_invendu&code_poly='.$ligne->code_barre.'</a>
		<br><br>Attention, sans réponse de votre part <b>les polycopiés restants seront remis en vente au prochain semestre</b>.
		<br><br>Dans tous les cas, contactez Monsieur Piredda de l\'imprimerie pour toute demande de polycopié (retirage ou nouvelle édition).
		<br><br><br>Cordialement.
		<br>br>'.VENDEUR_BUTC.'</body>';

				echo $message.'<br><br>'$utilisateur->email.'<br>====================================================';

				if(mail($ligne->email, 'BUTC : polycopiés '.$ligne->code_barre.' invendu(s)', $message, $headers)) 
					//Le message a bien été envoyé.
				else 
					echo 'Le message n\'a pu être envoyé'; 
			}
		}

	} else {
	        include CHEMIN_VUE_GLOBALE.'hacker.php';
	}

}
?>
