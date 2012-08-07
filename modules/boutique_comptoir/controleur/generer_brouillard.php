<?php
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

//FIX ME : sécuriser la génération PDF
require_once('../modele/brouillard_caisse.php');
require_once('../../../libs/tcpdf/config/lang/fra.php');
require_once('../../../libs/tcpdf/tcpdf.php');

$totaux_paybox=encaissements($_POST['date'], 'PAYBOX');
$totaux_cb=encaissements($_POST['date'], 'CB');
$totaux_moneo=encaissements($_POST['date'], 'MONEO');
$totaux_interne=encaissements($_POST['date'], 'INTERNE');
$total_tous_paiements = $totaux_paybox->total_paiements + $totaux_cb->total_paiements + $totaux_moneo->total_paiements + $totaux_interne->total_paiements;
/*
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('BUTC');
$pdf->SetTitle('Recettes constatées - Guichet BF');
$pdf->SetSubject('Régie UTC');
$pdf->SetKeywords('');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING);

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

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 12, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();
*/
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
$html = <<<EOD
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
	<td>Articles gratuits</td>
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
$pdf->writeHTML($html, true, false, false, false, '');

// This method has several options, check the source code documentation for more information.
$pdf->Output('example_001.pdf', 'I');
?>
