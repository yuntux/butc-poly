<?php
////////////////////////////////////////////////////////////////////////////////
//
//    Ce fichier fait partie intégrante du Système de Gestion des Polycopiés
//    Copyright (C) 2012 - Aurélien DUMAINE (<wwwetu.utc.fr/~adumaine/>).
//
//    This program is free software: you can redistribute it and/or modify
//    it under the terms of the GNU Affero General Public License as
//    published by the Free Software Foundation, either version 3 of the
//    License, or (at your option) any later version.
//
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU Affero General Public License for more details.
//
//    You should have received a copy of the GNU Affero General Public License
//    along with this program.  If not, see <http://www.gnu.org/licenses/>.
//
////////////////////////////////////////////////////////////////////////////////
?>
<?php
if ((!isset($_SESSION['login'])) || (empty($_SESSION['login'])))  {

    include CHEMIN_VUE_GLOBALE.'erreur_non_connecte.php';

} else {
	if(isset($_SESSION['imprimeur']) && $_SESSION['imprimeur']==1) {

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
		<br><br>'.VENDEUR_BUTC.'</body>';

				echo $message.'<br><br>'.$ligne->email.'<br>====================================================<br>';

				if(mail($ligne->email, 'BUTC : polycopiés '.$ligne->code_barre.' invendu(s)', $message, $headers)) 
					echo '<br>Le mail a été envoyé.<br>';
				else 
					echo '<br>Le message n\'a pu être envoyé.<br>'; 
			}
		}

	} else {
	        include CHEMIN_VUE_GLOBALE.'hacker.php';
	}

}
?>
