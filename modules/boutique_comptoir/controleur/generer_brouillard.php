<?php
require_once('../../../global/init.php');
/*
require_once('../../../global/config.php');
ini_set('display_errors', 1);

	try {
		$connexion = new PDO('mysql:host='.SQL_HOST.';dbname='.SQL_DATABASE, SQL_USERNAME, SQL_PASSWORD, array(
		PDO::ATTR_PERSISTENT => true
	)); // CONNEXION PERSISTANTE : pas besoin de la fermer en fin de script, elle est mise en cache
		$connexion->exec("SET CHARACTER SET utf8");
	} catch (PDOException $e) {
		print "Erreur ! : " . $e->getMessage();
		die();
	}
*/
//FIX ME : sécuriser la génération PDF
require_once('../modele/brouillard_caisse.php');
require_once('../../boutique_en_ligne/modele/boutique_en_ligne.php');
require_once('../../../libs/tcpdf/config/lang/fra.php');
require_once('../../../libs/tcpdf/tcpdf.php');

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

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('BUTC');
$pdf->SetTitle('Recettes constatées - Guichet BF');
$pdf->SetSubject('Régie UTC');
$pdf->SetKeywords('');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 048', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', 'B', 20);

// add a page
$pdf->AddPage();

$pdf->SetFont('helvetica', '', 8);

// -----------------------------------------------------------------------------

// Set some content to print
$totaux_paiements = <<<EOD
<TABLE cellspacing="0" cellpadding="1" border="1">
	<CAPTION>Recettes</CAPTION><br>
	<THEAD>
	<tr><TH>Moyen de paiement</TH> <TH>Nombre de paiements</TH> <TH>Total</TH> </tr>		
	</THEAD>
	<TBODY>
	<tr> 
	<td>PAYBOX</td>
	<td>$totaux_paybox->nb_paiements</td>
	<td>$totaux_paybox->total_paiements</td>
	</tr>
	<tr>
	<td>CB</td>
	<td>$totaux_cb->nb_paiements</td>
	<td>$totaux_cb->total_paiements</td>
	</tr>
	<tr>
	<td>MONEO</td>
	<td>$totaux_moneo->nb_paiements</td>
	<td>$totaux_moneo->total_paiements</td>
	</tr>
	<tr>
	<td>INTERNE</td>
	<td>$totaux_interne->nb_paiements</td>
	<td>$totaux_interne->total_paiements</td>
	</tr>
	</TBODY>
	<TFOOT>
	<tr><td colspan="3" align="right">TOTAL : $total_tous_paiements</td></tr>
	</TFOOT>
</TABLE>
EOD;

// Print text using writeHTMLCell()
$pdf->writeHTML($totaux_paiements, true, false, false, false, '');

$liste_paiements_paybox = '
<TABLE cellspacing="0" cellpadding="1" border="1">
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
$pdf->writeHTML($liste_paiements_paybox, true, false, false, false, '');

$liste_paiements_cb = '
<TABLE cellspacing="0" cellpadding="1" border="1">
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
$pdf->writeHTML($liste_paiements_cb, true, false, false, false, '');

$liste_paiements_cheque = '
<TABLE cellspacing="0" cellpadding="1" border="1">
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
$pdf->writeHTML($liste_paiements_cheque, true, false, false, false, '');


$liste_paiements_interne = '
<TABLE cellspacing="0" cellpadding="1" border="1">
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
$pdf->writeHTML($liste_paiements_interne, true, false, false, false, '');
/*
$montant_sortie_stock=0;
$liste_sortie_stock = '
<TABLE cellspacing="0" cellpadding="1" border="1">
	<CAPTION>Liste des sorties de stock</CAPTION><br>
	<THEAD>
	<tr><TH>Code article</TH> <TH>Prix unitaire</TH> <TH><Quantité/TH> <TH>Montant</TH> </tr>		
	</THEAD>
		<tbody>';
		    while($l = $sortie_stock->fetch()){
		        $liste_sortie_stock.="<tr>";
		        $liste_sortie_stock.="<td>".$l->codep."</td>";
		        $liste_sortie_stock.="<td>".$l->prix."</td>";
		        $liste_sortie_stock.="<td>".$l->quantite."</td>";
				$montant_poly = $l->prix*$l->quantite;
				$motant_sortie_stock = $montant_sortie_stock + $montant_poly;
		        $liste_sortie_stock.="<td>".$montant_poly"</td>";
		        $liste_sortie_stock.="</tr>";
			}

		$liste_sortie_stock.='</tbody><tfoot><tr><td collspan="3">TOTAL SORTIES DE STOCK :</td><td>'.$montant_sortie_stock.' </td></tr></tfoot></table>';
$pdf->writeHTML($liste_sortie_stock, true, false, false, false, '');
*/

$montant_entree_stock=0;
$liste_entree_stock = '
<TABLE cellspacing="0" cellpadding="1" border="1">
	<CAPTION>Liste des entrées de stock</CAPTION><br>
	<THEAD>
	<tr><TH>Code article</TH> <TH>Prix unitaire</TH> <TH><Quantité/TH> <TH>Montant</TH> </tr>		
	</THEAD>
		<tbody><tr><td>test</td></tr></tbody></table>';
/*		    while($l = $entree_stock->fetch()){
		        $liste_entree_stock.="<tr>";
		        $liste_entree_stock.="<td>".$l->codep."</td>";
		        $liste_entree_stock.="<td>".$l->prix."</td>";
		        $liste_entree_stock.="<td>".$l->quantite."</td>";
				$montant_poly = $l->prix*$l->quantite;
				$motant_entree_stock = $montant_entree_stock + $montant_poly;
		        $liste_entree_stock.="<td>".$montant_poly"</td>";
		        $liste_entree_stock.="</tr>";
			}
*/
//		$liste_entree_stock.='</tbody><tfoot><tr><td collspan="3">TOTAL SORTIES DE STOCK :</td><td>'.$montant_entree_stock.' </td></tr></tfoot></table>';

$pdf->writeHTML($liste_entree_stock, true, false, false, false, '');

// This method has several options, check the source code documentation for more information.
$pdf->Output('example_001.pdf', 'I');
?>
