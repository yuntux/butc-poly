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
/*
Permet de générer un PDF avec TCPDF.
Il ne faut avoir raucune autre entete d'envoyée. On ne peut donc pas vérifier l'identité du demandeur CAS (échange d'en-têtes incompatible avec TCPDF).
On vérifie donc l'identité dans un controleur ayant une structure standart.
L'on crée un fichier placé dans ce repertoire contenant le contenu html à inclure dans le PDF.
On execute ce fichier puis on le supprime.
Ainsi les personnes non autorités ne peuvent pas générer de PDF (ou pendant moins d'une seconde !) et l'on est pas limité par la taille d'une quelconque variable GET ou POST.
*/
require_once('../../../libs/tcpdf/config/lang/fra.php');
require_once('../../../libs/tcpdf/tcpdf.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator($_GET['creator']);
$pdf->SetAuthor($_GET['autor']);
$pdf->SetTitle($_GET['title']);
$pdf->SetSubject($_GET['subject']);
$pdf->SetKeywords($_GET['keywords']);

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $_GET['entete1'], $_GET['entete2']);

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
$html = fopen($_GET['id_pdf'], "a+");
$contenu_html="";
while ($ligne = fgets($html))
	$contenu_html.=$ligne;

fclose($html);
unlink($_GET['id_pdf']);

// Print text using writeHTMLCell()
$pdf->writeHTML($contenu_html, true, false, false, false, '');

// This method has several options, check the source code documentation for more information.
$pdf->Output($_GET['nom_fichier'].'.pdf', 'I');

?>
