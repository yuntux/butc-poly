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
if(isset($_SESSION['etudiant_en_cours']) && $_SESSION['etudiant_en_cours']!="") {

echo '
<script type="text/javascript">
	window.onkeydown=function(e){
	    if(e.which == 123)
			 document.getElementById("valider_retrait").click();
	}
</script>
';

$action_post_changement='retirer_poly';
include CHEMIN_VUE.'cartouche_etudiant.php';

	echo '
</div>
<div class="groupe" "float: right;margin-top:10px;width:57%; id="bon_retrait" autocomplete="off">
<form name="modif_panier" action="index.php?module=boutique_comptoir&action=retirer_poly" method="post">
<TABLE id="bon_retrait">
	<CAPTION>Bon de retrait</CAPTION>
	<THEAD>
		<TR><TH>Code</TH> <TH>Payés par '.$_SESSION['etudiant_en_cours']['login'].'</TH> <TH>Retirés par '.$_SESSION['etudiant_en_cours']['login'].'</TH> <TH>Retirables par '.$_SESSION['etudiant_en_cours']['login'].'</TH> <TH>Stock</TH> <TH>Retrait</TH></TR>
	</THEAD>
	<TBODY>';

		while($ligne = $liste_retraits_possibles->fetch()){
					$poly_non_retires = $ligne->qte_payee - $ligne->qte_retiree;
					if ($poly_non_retires != 0) {
						 echo "<tr>";
						 echo "<td>".$ligne->codep."</td>";
						 echo "<td>".$ligne->qte_payee."</td>";
						 echo "<td>".$ligne->qte_retiree."</td>";
						 echo "<td>".$poly_non_retires."</td>";
						 //echo "<td>".$stock_poly."</td>";
						 echo "<td>".$ligne->stock_courant."</td>";
						if ($ligne->stock_courant <  $poly_non_retires) {
								$retirable = 'value="'.$ligne->stock_courant.'" style="background-color: red"';	
						} else {
								$retirable = 'value="'.$poly_non_retires.'"';
						}
//FIX ME : possibilité de retirer plus de poly que de  polys payés
						 echo '<td><input type="text" name="code_poly_'.$ligne->codep.'" id="'.$ligne->codep.'" '.$retirable.' size="2"></td>';
						 echo "</tr>";
					}
		}
	echo '</TBODY>
</TABLE>
	<br>
	<input type="submit" id="valider_retrait" name="valider_retrait" value="RETIRER [F12]" class="btn_valider">
</form></div><div style="clear: both ;"></div>';

}

?>
