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
echo '<h1>Liste des polys</h1>
<a href="index.php?module=imprimerie&action=ajout_poly">Ajout poly</a>
		<TABLE>
			<THEAD>
				<TR><TH>Code poly</TH> <TH>UV</TH> <TH>Type</TH> <TH>Prix</TH> <TH>Nb ex commandés</TH> <TH>Nb ex retirés</TH> <TH>Nb ex à retirer</TH> <TH>Stock courant</TH> <TH>Action</TH></TR>
			</THEAD>
	    <TBODY>';
		while($ligne = $liste_polys->fetch()){
			echo "<tr>";
			echo "<td>".$ligne->code_barre."</td>";
			echo "<td>".$ligne->id_uv."</td>";
			echo "<td>".$ligne->type."</td>";
			echo "<td>".$ligne->prix."</td>";
			echo "<td>".$ligne->qte_commandee."</td>";
			echo "<td>".$ligne->qte_retiree."</td>";
			echo "<td>".$ligne->reste_a_retirer."</td>";
			echo "<td>".$ligne->stock_courant."</td>";
			echo "<td><a href=index.php?module=imprimerie&action=detail_poly&code_poly=".$ligne->code_barre.">Voir la fiche</a></td>";
            echo "</tr>";
		}
		echo '</TBODY></TABLE>';

echo '<br><a href="index.php?module=imprimerie&action=mail_devenir_poly">Envoyer les mails de gestion des invendus en fin de semestre aux responsables d\'UV.</a>';
echo '<br><a href="index.php?module=imprimerie&action=mail_poly_non_retires">Envoyer les mails de rappels des polys payés mais non retirés aux étudiants.</a>';
?>
