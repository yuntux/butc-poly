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
