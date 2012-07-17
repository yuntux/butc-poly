<?php
if(isset($_SESSION['etudiant_en_cours']) && $_SESSION['etudiant_en_cours']!="") {

$action_post_changement='retirer_poly';
include CHEMIN_VUE.'cartouche_etudiant.php';

	echo '
</div>
<div class="groupe" "float: right;margin-top:10px;width:57%; id="bon_retrait" autocomplete="off">
<form name="modif_panier" action="index.php?module=boutique_comptoir&action=retirer_poly" method="post">
<TABLE id="bon_retrait">
	<CAPTION>Bon de retrait</CAPTION>
	<THEAD>
		<TR><TH>Code</TH> <TH>Payés</TH> <TH>Retirés</TH> <TH>À retirer</TH> <TH>Stock</TH> <TH>Retrait</TH></TR>
	</THEAD>
	<TBODY>';

/*
SELECT lc.code_poly AS codep, SUM(lc.quantite) AS qte_payee
FROM entete_commande ec
		INNER JOIN ligne_commande lc ON ec.id=lc.id_entete_commande
WHERE ec.date_heure_paiement IS NOT NULL AND ec.login_acheteur='adumaine'
GROUP BY codep

SELECT lr.code_poly AS codep, SUM(lr.quantite) AS qte_retiree
FROM 	entete_retrait er
		INNER JOIN ligne_retrait lr ON er.id=lr.id_entete_retrait
WHERE er.login_acheteur='adumaine'
GROUP BY codep

SELECT lc.code_poly AS codep, SUM(lc.quantite) AS qte_payee, retraits.qte_retiree
FROM entete_commande ec
		INNER JOIN ligne_commande lc ON ec.id=lc.id_entete_commande
		LEFT OUTER JOIN (SELECT lr.code_poly AS cpr, SUM(lr.quantite) AS qte_retiree
						FROM 	entete_retrait er
						INNER JOIN ligne_retrait lr ON er.id=lr.id_entete_retrait
						WHERE er.login_acheteur='adumaine'
						GROUP BY cpr) AS retraits ON retraits.cpr=lc.code_poly
WHERE ec.date_heure_paiement IS NOT NULL AND ec.login_acheteur='adumaine'
GROUP BY codep
*/
		while($ligne = $liste_retraits_possibles->fetch()){
					$poly_non_retires = $ligne->qte_payee - $ligne->qte_retiree;
					if ($poly_non_retires != 0) {
						$stock_poly = stock_poly($ligne->codep);
						 echo "<tr>";
						 echo "<td>".$ligne->codep."</td>";
						 echo "<td>".$ligne->qte_payee."</td>";
						 echo "<td>".$ligne->qte_retiree."</td>";
						 echo "<td>".$poly_non_retires."</td>";
						 echo "<td>".$stock_poly."</td>";
						if ($stock_poly <  $poly_non_retires) {
								$retirable = 'value="'.$stock_poly.'" style="background-color: red"';	
						} else {
								$retirable = 'value="'.$poly_non_retires.'"';
						}
						 echo '<td><input type="text" name="code_poly_'.$ligne->codep.'" id="'.$ligne->codep.'" '.$retirable.' size="2"></td>';
						 echo "</tr>";
					}
		}
	echo '</TBODY>
</TABLE>
	<input type="submit" name="valider_retrait" value="RETIRER" class="btn_valider">
</form></div>';

}

?>
