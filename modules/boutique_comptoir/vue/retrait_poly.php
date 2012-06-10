<?php
if(isset($_SESSION['etudiant_en_cours']) && $_SESSION['etudiant_en_cours']!="") {
	echo '
<div class="groupe" style="margin-top:10px;width:97.5%;" id="bon_retrait" autocomplete="off">
<form name="modif_panier" action="index.php?module=boutique_comptoir&action=retirer_poly" method="post">
<TABLE id="bon_retrait">
	<CAPTION>Bon de retrait n° </CAPTION>
	<THEAD>
		<TR><TH>Code</TH> <TH>Payés</TH> <TH>Retirés</TH> <TH>À retirer</TH> <TH>Stock</TH> <TH>Retrait</TH></TR>
	</THEAD>
	<TBODY>';
		while($ligne = $liste_commandes->fetch()){
					//les quatre lignes suivantes devraient remonter dans un tableau généré par le controleur
					$poly_commandes = nb_exemplaires_commandes_payes($_SESSION['etudiant_en_cours']['login'], $ligne->code_poly);
					$poly_retires = nb_exmplaires_retires($_SESSION['etudiant_en_cours']['login'], $ligne->code_poly);
					$poly_non_retires = $poly_commandes - $poly_retires;
					$stock_poly = stock_poly($lign->code_poly);
					 echo "<tr>";
					 echo "<td>".$ligne->code_poly."</td>";
					 echo "<td>".$poly_commandes."</td>";
					 echo "<td>".$poly_retires."</td>";
					 echo "<td>".$stock_poly."</td>";
					 echo "<td>".$poly_non_retires."</td>";
					if ($stock_poly -  $poly_non_retires < 0 ) {
							$retirable = $stock_poly;
					} else {
							$retirable = $poly_non_retires;
					}
					 echo "<td>".'<input type="text" name="'.$ligne->poly.'" id="'.$ligne->poly.'" value="'.$retirable.'">'."</td>";
					 echo "</tr>";
		}
	echo '</TBODY>
	<TFOOT>
		<TR><td colspan="5">

		</td></TR>
	</TFOOT>
</TABLE>
	<input type="submit" name="valider_retrait" value="RETIRER" class="btn_valider">
</form>';

}

?>
