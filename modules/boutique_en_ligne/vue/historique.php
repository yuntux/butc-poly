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

echo '<h1>Hisorique de '.$login.'</h1>';

echo '<h2>Synthèse</h2>
<TABLE>
	<THEAD>
		<TR><TH>Code</TH> <TH>Payés</TH> <TH>Retirés</TH> <TH>À retirer</TH> <TH>Stock</TH> </TR>
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
						 echo "<td>".$ligne->stock_courant."</td>";
						 echo "</tr>";
					}
		}
    echo '</TBODY> 
</TABLE>';

echo '<div style="float: left;width:60%;">';
echo '<h2>Commandes/paiements</h2>';
    while($ligne = $liste_commandes->fetch()){
		$montant_commande = 0;
		echo '<h3>Commande n°'.$ligne->id.' ('.$ligne->date_heure_commande.' par '.$ligne->login_vendeur.')</h3>';
		echo'
		<TABLE>
			<THEAD>
				<TR><TH>Code</TH> <TH>Prix unitaire</TH> <TH>Quantite</TH> <TH>Total</TH></TR>
			</THEAD>
	    <TBODY>';
		$ligne_commande = ligne_commande($ligne->id);
		while($l = $ligne_commande->fetch()){
			echo "<tr>";
			echo "<td>".$l->code_poly."</td>";
            echo "<td>".$l->prix."</td>";
            echo "<td>".$l->quantite."</td>";
			$total_ligne = $l->prix*$l->quantite;
			$montant_commande = $montant_commande + $total_ligne;
            echo "<td>".$total_ligne."</td>";
            echo "</tr>";	
		}
		echo '</TBODY></TABLE>';
		echo 'Paiement : '.$montant_commande.' par '.$ligne->mode_paiement.'('.$ligne->date_heure_paiement.')';
    }
echo '</div>';

echo '<div style="float: right;width:40%;">';
echo '<h2>Retraits</h2>';
    while($ligne = $liste_retraits->fetch()){
		echo '<h3>Retrait n°'.$ligne->id.' ('.$ligne->date_heure_retrait.' par '.$ligne->login_vendeur.')</h3>';
		echo'
		<TABLE>
			<THEAD>
				<TR><TH>Code</TH> <TH>Quantite</TH> </TR>
			</THEAD>
	    <TBODY>';
		$ligne_retrait = ligne_retrait($ligne->id);
		while($l = $ligne_retrait->fetch()){
			echo "<tr>";
			echo "<td>".$l->code_poly."</td>";
            echo "<td>".$l->quantite."</td>";
            echo "</tr>";	
		}
		echo '</TBODY></TABLE>';
    }
echo '</div><div style="clear: both ;"></div>';
?>
