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

	if(isset($_SESSION['vendeur']) && $_SESSION['vendeur']==1) {
			$id_pdf=$_SESSION['login'].date('dmY_His');

			$generation_pdf = fopen('modules/generation_pdf/controleur/'.$id_pdf, 'a');


			require_once('modules/boutique_comptoir/modele/brouillard_caisse.php');
			require_once('modules/boutique_en_ligne/modele/boutique_en_ligne.php');


			// Set some content to print
				$html="";
				$totaux_paybox=encaissements($_POST['date'], 'PAYBOX');
				$totaux_cb=encaissements($_POST['date'], 'CB');
				$totaux_moneo=encaissements($_POST['date'], 'MONEO');
				$totaux_interne=encaissements($_POST['date'], 'INTERNE');
				$totaux_cheque=encaissements($_POST['date'], 'CHEQUE');
				$total_tous_paiements = $totaux_paybox->total_paiements + $totaux_cb->total_paiements + $totaux_moneo->total_paiements + $totaux_interne->total_paiements + $totaux_cheque->total_paiements;
				$liste_cb = liste_paiements($_POST['date'], 'CB'); 
				$liste_moneo = liste_paiements($_POST['date'], 'MONEO'); 
				$liste_paybox = liste_paiements($_POST['date'], 'PAYBOX'); 
				$liste_interne = liste_paiements($_POST['date'], 'INTERNE'); 
				$liste_cheque = liste_paiements($_POST['date'], 'CHEQUE'); 

				$sortie_stock = liste_retraits("",$_POST['date']);
				$entree_stock = liste_impressions($_POST['date']);


				$totaux_paiements = '
				<BR><BR><TABLE cellspacing="0" cellpadding="1" border="1">
					<CAPTION>Recettes</CAPTION><br>
					<THEAD>
					<tr><TH>Moyen de paiement</TH> <TH>Nombre de paiements</TH> <TH>Total</TH> </tr>		
					</THEAD>
					<TBODY>
					<tr> 
					<td>PAYBOX</td>
					<td>'.$totaux_paybox->nb_paiements.'</td>
					<td>'.$totaux_paybox->total_paiements.'</td>
					</tr>
					<tr>
					<td>CB</td>
					<td>'.$totaux_cb->nb_paiements.'</td>
					<td>'.$totaux_cb->total_paiements.'</td>
					</tr>
					<tr>
					<td>MONEO</td>
					<td>'.$totaux_moneo->nb_paiements.'</td>
					<td>'.$totaux_moneo->total_paiements.'</td>
					</tr>
					<tr>
					<td>INTERNE</td>
					<td>'.$totaux_interne->nb_paiements.'</td>
					<td>'.$totaux_interne->total_paiements.'</td>
					</tr>
					</TBODY>
					<TFOOT>
					<tr><td colspan="3" align="right">TOTAL : '.$total_tous_paiements.'</td></tr>
					</TFOOT>
				</TABLE>
				';

				// Print text using writeHTMLCell()
				$html.=$totaux_paiements;


				$liste_paiements_paybox = '
				<BR><BR><TABLE cellspacing="0" cellpadding="1" border="1">
					<CAPTION>Liste des paiements PAYBOX</CAPTION><br>
					<THEAD>
					<tr><TH>Nom du tireur</TH> <TH>Références</TH> <TH>Montant</TH> </tr>		
					</THEAD>
						<tbody>';
							while($l = $liste_paybox->fetch()){
								$liste_paiements_paybox.="<tr>";
								$liste_paiements_paybox.="<td>".$l->proprietaire_moyen_paiement."</td>";
								$liste_paiements_paybox.="<td>".$l->ref."</td>";
								$liste_paiements_paybox.="<td>".$l->montant_commande."</td>";
								$liste_paiements_paybox.="</tr>";
							}
						$liste_paiements_paybox.='</tbody></table>
				';
				$html.=$liste_paiements_paybox;

				$liste_paiements_cb = '
				<BR><BR><TABLE cellspacing="0" cellpadding="1" border="1">
					<CAPTION>Liste des paiements CB</CAPTION><br>
					<THEAD>
					<tr><TH>Nom du tireur</TH> <TH>Références</TH> <TH>Montant</TH> </tr>		
					</THEAD>
						<tbody>';
							while($l = $liste_cb->fetch()){
								$liste_paiements_cb.="<tr>";
								$liste_paiements_cb.="<td>".$l->proprietaire_moyen_paiement."</td>";
								$liste_paiements_cb.="<td>".$l->ref."</td>";
								$liste_paiements_cb.="<td>".$l->montant_commande."</td>";
								$liste_paiements_cb.="</tr>";
							}
						$liste_paiements_cb.='</tbody></table>
				';
				$html.=$liste_paiements_cb;

				$liste_paiements_cheque = '
				<BR><BR><TABLE cellspacing="0" cellpadding="1" border="1">
					<CAPTION>Liste des paiements CHEQUE</CAPTION><br>
					<THEAD>
					<tr><TH>Nom du tireur</TH> <TH>Références</TH> <TH>Montant</TH> </tr>		
					</THEAD>
						<tbody>';
							while($l = $liste_cheque->fetch()){
								$liste_paiements_cheque.="<tr>";
								$liste_paiements_cheque.="<td>".$l->proprietaire_moyen_paiement."</td>";
								$liste_paiements_cheque.="<td>".$l->ref."</td>";
								$liste_paiements_cheque.="<td>".$l->montant_commande."</td>";
								$liste_paiements_cheque.="</tr>";
							}
						$liste_paiements_cheque.='</tbody></table>
				';
				$html.=$liste_paiements_cheque;


				$liste_paiements_interne = '
				<BR><BR><TABLE cellspacing="0" cellpadding="1" border="1">
					<CAPTION>Liste des paiements INTERNE</CAPTION><br>
					<THEAD>
					<tr><TH>Nom du tireur</TH> <TH>Références</TH> <TH>Montant</TH> </tr>		
					</THEAD>
						<tbody>';
							while($l = $liste_interne->fetch()){
								$liste_paiements_interne.="<tr>";
								$liste_paiements_interne.="<td>".$l->proprietaire_moyen_paiement."</td>";
								$liste_paiements_interne.="<td>".$l->ref."</td>";
								$liste_paiements_interne.="<td>".$l->montant_commande."</td>";
								$liste_paiements_interne.="</tr>";
							}
						$liste_paiements_interne.='</tbody></table>
				';
				$html.=$liste_paiements_interne;

				$montant_sortie_stock=0;
				$liste_sortie_stock = '
				<BR><BR><TABLE cellspacing="0" cellpadding="1" border="1">
					<CAPTION>Liste des sorties de stock</CAPTION><br>
					<THEAD>
					<tr><TH>Code article</TH> <TH>Prix unitaire</TH> <TH>Quantité</TH> <TH>Montant</TH> </tr>		
					</THEAD>
						<tbody>';
							while($l = $sortie_stock->fetch()){
								$liste_sortie_stock.="<tr>";
								$liste_sortie_stock.="<td>".$l->code_barre."</td>";
								$liste_sortie_stock.="<td>".$l->prix."</td>";
								$liste_sortie_stock.="<td>".$l->quantite."</td>";
								$montant_poly = $l->prix*$l->quantite;
								$motant_sortie_stock = $montant_sortie_stock + $montant_poly;
								$liste_sortie_stock.="<td>".$montant_poly."</td>";
								$liste_sortie_stock.="</tr>";
							}
						$liste_sortie_stock.='</tbody><tfoot><tr><td colspan="3">TOTAL SORTIES DE STOCK :</td><td>'.$montant_sortie_stock.'</td></tr></tfoot></table>';
				$html.=$liste_sortie_stock;


				$montant_entree_stock=0;
				$liste_entree_stock = '
				<BR><BR><TABLE cellspacing="0" cellpadding="1" border="1">
					<CAPTION>Liste des entrées de stock</CAPTION><br>
					<THEAD>
					<tr><TH>Code article</TH> <TH>Prix unitaire</TH> <TH>Quantité</TH> <TH>Montant</TH> </tr>		
					</THEAD>
						<tbody>';
							while($l = $entree_stock->fetch()){
								$liste_entree_stock.="<tr>";
								$liste_entree_stock.="<td>".$l->code_poly."</td>";
								$liste_entree_stock.="<td>".$l->prix."</td>";
								$liste_entree_stock.="<td>".$l->quantite."</td>";
								$montant_poly = $l->prix*$l->quantite;
								$motant_entree_stock+= $montant_poly;
								$liste_entree_stock.="<td>".$montant_poly." ".$montant_entree_stock."</td>";
								$liste_entree_stock.="</tr>";
							}

					$liste_entree_stock.='</tbody><tfoot><tr><td colspan="3">TOTAL ENTRÉE DE STOCK :</td><td>'.$montant_entree_stock.'</td></tr></tfoot></table>';
				$html.=$liste_entree_stock;

			//-----------------------------

			fputs($generation_pdf, $html);

			fclose($generation_pdf);

			header('Location: modules/generation_pdf/controleur/generer_pdf.php?creator='.$_SESSION['login'].'&autor=BUTC&title=Brouillard de caisse - Guichet BF&subject='.$_POST['date'].'&keywords=&entete1=BUTC - Guichet BF&entete2=Brouillard de caisse du '.$_POST['date'].'&nom_fichier=brouillard_'.$_POST['date'].'&id_pdf='.$id_pdf);


	} else {
	        include CHEMIN_VUE_GLOBALE.'hacker.php';
	}
}
?>
