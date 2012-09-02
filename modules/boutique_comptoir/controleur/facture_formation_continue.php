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

//FIX ME : sécuriser les génération pdf
//if(isset($_SESSION['vendeur']) && $_SESSION['vendeur']==1)
require_once('../../boutique_en_ligne/modele/boutique_en_ligne.php');
require_once('../../../libs/tcpdf/config/lang/fra.php');
require_once('../../../libs/tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
//$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('BUTC');
$pdf->SetTitle('Facture vente interne');
$pdf->SetSubject('Formation continue');
$pdf->SetKeywords('');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "BUTC - Facture interne", "Formation continue");

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
$html = "Date : ".date("d/m/Y")."<BR>";

if (isset($_GET['utilisateur'])){
    $vente_interne_utilisateur = vente_interne_utilisateur($_GET['utilisateur']);
	$detail_utilisateur = detailler_utilisateur("", $_GET['utilisateur'])->fetch();
	$html.='Étudiant : '.$detail_utilisateur->prenom1.' '.$detail_utilisateur->nom.'<br><br>';
}else{
    $vente_interne_utilisateur = vente_interne_utilisateur();
}

	$montant_commandes=0;
	$html.= '
	<TABLE cellspacing="0" cellpadding="1" border="1">
		<thead>
		<tr><TH>Code article</TH> <TH>Prix unitaire</TH> <TH>Quantité</TH> <TH>Total</TH> </tr>		
		</thead>
		<tbody>';
		    while($l = $vente_interne_utilisateur->fetch()){
		        $html.="<tr>";
		        $html.="<td>".$l->codep."</td>";
		        $html.="<td>".$l->prix."</td>";
		        $html.="<td>".$l->quantite."</td>";
		        $total_ligne = $l->prix*$l->quantite;
		        $montant_commandes = $montant_commandes + $total_ligne;
		        $html.="<td>".$total_ligne."</td>";
		        $html.="</tr>";
			}
		$html.='</tbody><tfoot><tr><td colspan="3">TOTAL : </td><td>'.$montant_commandes.'</td></tr></tfoot>
	</TABLE>';

// Print text using writeHTMLCell()
$pdf->writeHTML($html, true, false, false, false, '');

// This method has several options, check the source code documentation for more information.
$pdf->Output('facture_interne'.$detail_utilisateur->prenom1.' '.$detail_utilisateur->nom.'pdf', 'I');
?>
