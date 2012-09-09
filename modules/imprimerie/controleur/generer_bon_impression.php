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
			$id_pdf=$_SESSION['login'].date('dmY_His');

			$generation_pdf = fopen('modules/generation_pdf/controleur/'.$id_pdf, 'a');
			require_once('modules/boutique_en_ligne/modele/boutique_en_ligne.php');
			$detail_bon = ligne_impression($_GET['id']);

			// Set some content to print
				$html = "Date : ".date("d/m/Y")."<br><br>";

				$montant_entree_stock=0;
				$liste_entree_stock = '
				<TABLE cellspacing="0" cellpadding="1" border="1">
					<CAPTION>Liste des entrées de stock</CAPTION><br>
					<THEAD>
					<tr><TH>Code article</TH> <TH>Prix unitaire</TH> <TH>Quantité</TH> <TH>Montant</TH> </tr>		
					</THEAD>
						<tbody>';
							while($l = $detail_bon->fetch()){
								$liste_entree_stock.="<tr>";
								$liste_entree_stock.="<td>".$l->code_poly."</td>";
								$liste_entree_stock.="<td>".$l->prix."</td>";
								$liste_entree_stock.="<td>".$l->quantite."</td>";
								$montant_poly = $l->prix*$l->quantite;
								$motant_entree_stock = $montant_entree_stock + $montant_poly;
								$liste_entree_stock.="<td>".$montant_poly."</td>";
								$liste_entree_stock.="</tr>";
							}

					$liste_entree_stock.='</tbody><tfoot><tr><td colspan="3">TOTAL :</td><td>'.$montant_entree_stock.' </td></tr></tfoot></table>';
				$html.=$liste_entree_stock;

			//-----------------------------

			fputs($generation_pdf, $html);

			fclose($generation_pdf);

			header('Location: modules/generation_pdf/controleur/generer_pdf.php?creator='.$_SESSION['login'].'&autor=Imprimerie&title=Bon d\'impression&subject=n°'.$_GET['id'].'&keywords=&entete1=Imprimerie&entete2=Bon d\'impression n° '.$_GET['id'].'&nom_fichier=bon_impression_'.$_GET['id'].'&id_pdf='.$id_pdf);


	} else {
	        include CHEMIN_VUE_GLOBALE.'hacker.php';
	}
}
?>
