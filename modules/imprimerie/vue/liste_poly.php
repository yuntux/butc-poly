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
			echo "<td><a href="">Voir la fiche</a></td>";
            echo "</tr>";
		}
		echo '</TBODY></TABLE>';

echo '<br><a href="">Envoyer les mails de gestion des invendus en fin de semestre aux responsables d\'UV.</a>';
echo '<br><a href="">Envoyer les mails de rappels des polys payés mais non retirés aux étudiants.</a>';
?>
