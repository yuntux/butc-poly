<?php
require_once('../../../global/config.php');
ini_set('display_errors', 1);
//require_once('../../../global/init.php');
try {
    $connexion = new PDO('mysql:host='.SQL_HOST.';dbname='.SQL_DATABASE, SQL_USERNAME, SQL_PASSWORD, array(
    PDO::ATTR_PERSISTENT => true
)); // CONNEXION PERSISTANTE : pas besoin de la fermer en fin de script, elle est mise en cache
	$connexion->exec("SET CHARACTER SET utf8");
} catch (PDOException $e) {
    print "Erreur ! : " . $e->getMessage();
    die();
}
require_once('../modele/brouillard_caisse.php');
require_once('../../../libs/tcpdf/config/lang/fra.php');
require_once('../../../libs/tcpdf/tcpdf.php');

$totaux_paybox=encaissements($_POST['date'], 'PAYBOX');
$totaux_cb=encaissements($_POST['date'], 'CB');
$totaux_moneo=encaissements($_POST['date'], 'MONEO');
$totaux_interne=encaissements($_POST['date'], 'INTERNE');

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

// Set some content to print
$html = '
<TABLE>
	<CAPTION>Recettes</CAPTION><br>
	<THEAD>
		<TR><TH>Moyen de paiement</TH> <TH>Nombre de paiements</TH> <TH>Total</TH> </TR>		
	</THEAD>
	<TBODY>
		<TR>
			<TD>PAYBOX</TD>
			<TD>'.$totaux_paybox->nb_paiements.'</TD>
			<TD>'.$totaux_paybox->total_paiements.'</TD>
		</TR>
		<TR>
			<TD>CB</TD>
			<TD>'.$totaux_cb->nb_paiements.'</TD>
			<TD>'.$totaux_cb->total_paiements.'</TD>
		</TR>
		<TR>
			<TD>MONEO</TD>
			<TD>'.$totaux_moneo->nb_paiements.'</TD>
			<TD>'.$totaux_moneo->total_paiements.'</TD>
		</TR>
		<TR>
			<TD>Articles gratuits</TD>
			<TD>'.$totaux_interne->nb_paiements.'</TD>
			<TD>'.$totaux_interne->total_paiements.'</TD>
		</TR>
	</TBODY>
</TABLE>
';

// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

// This method has several options, check the source code documentation for more information.
$pdf->Output('example_001.pdf', 'I');
?>
