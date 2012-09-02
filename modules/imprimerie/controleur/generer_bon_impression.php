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
require_once('../../../libs/tcpdf/config/lang/fra.php');
require_once('../../boutique_en_ligne/modele/boutique_en_ligne.php');
require_once('../../../libs/tcpdf/tcpdf.php');

$detail_bon = ligne_impression($_GET['id']);

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Imprimerie UTC');
$pdf->SetTitle('Bon d\'impression');
$pdf->SetSubject('');
$pdf->SetKeywords('');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "Imprimerie", "Bon d'impression n° ".$_GET['id']);

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

// add a page
$pdf->AddPage();

$pdf->SetFont('helvetica', '', 8);

// -----------------------------------------------------------------------------

// Set some content to print
$html = "Date : ".date("d/m/Y");
$pdf->writeHTML($html, true, false, false, false, '');

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

$pdf->writeHTML($liste_entree_stock, true, false, false, false, '');

// This method has several options, check the source code documentation for more information.
$pdf->Output('bon_impression_'.$_GET['id'].'.pdf', 'I');
?>
