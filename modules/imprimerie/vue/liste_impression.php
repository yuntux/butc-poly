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
echo '<h1>Liste des bons d\'impression</h1>';
echo '<a href="index.php?module=imprimerie&action=ajout_impression">Ajout impression</a>';
    while($ligne = $liste_impressions->fetch()){
		echo '<h2>Impression n°'.$ligne->id.' ('.$ligne->date_heure_impression.' par '.$ligne->login_imprimeur.')</h2>';
		echo'
		<TABLE  class="liste">
			<THEAD>
				<TR><TH>Code</TH> <TH>Quantite</TH></TR>
			</THEAD>
	    <TBODY>';
		$ligne_impression = ligne_impression($ligne->id);
		while($l = $ligne_impression->fetch()){
			echo "<tr>";
			echo "<td>".$l->code_poly."</td>";
            echo "<td>".$l->quantite."</td>";
            echo "</tr>";
		}
		echo '</TBODY></TABLE>';
		echo '<a href="index.php?module=imprimerie&action=generer_bon_impression&id='.$ligne->id.'">Imprimer bon d\'impression</a><br>';
		echo '<a href="index.php?module=imprimerie&action=supprimer_impression&id='.$ligne->id.'">Supprimer bon d\'impression</a><br>';
    }
?>
