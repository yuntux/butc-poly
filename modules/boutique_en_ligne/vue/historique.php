<?php

echo '<h1>Hisorique de '.$login.'</h1>';

echo '<h2>Synthèse</h2>
<TABLE>
    <THEAD>
        <TR><TH>Code</TH> <TH>Payés</TH> <TH>Retirés</TH> <TH>À retirer</TH> <TH>Stock</TH></TR>
    </THEAD>
    <TBODY>';

        while($ligne = $retraits_possibles->fetch()){
                    $poly_non_retires = $ligne->qte_payee - $ligne->qte_retiree;
                    if ($poly_non_retires != 0) {
                        $stock_poly = stock_poly($ligne->codep);
                         echo "<tr>";
                         echo "<td>".$ligne->codep."</td>";
                         echo "<td>".$ligne->qte_payee."</td>";
                         echo "<td>".$ligne->qte_retiree."</td>";
                         echo "<td>".$poly_non_retires."</td>";
                         echo "<td>".$stock_poly."</td>";
                         echo "</tr>";
                    }
        }
    echo '</TBODY> 
</TABLE>';

echo '<h2>Commandes/paiements</h2>';
    while($ligne = $liste_commandes->fetch()){
		echo '<h3>Commande n°'.$ligne->id.' ('.$ligne->date_heure_commande.' par '.$ligne->login_vendeur.')</h3>';
		echo 'Paiement : '.$ligne->montant.' par'.$ligne->mode_paiement.'('.$ligne->date_heure_paiement.')';
    }
echo '<h2>Retraits</h2>';
?>
