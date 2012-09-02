<?php
echo '<h1>Liste des bons d\'impression</h1>';
echo '<a href="index.php?module=imprimerie&action=ajout_impression">Ajout impression</a>';
    while($ligne = $liste_impressions->fetch()){
		echo '<h2>Impression n°'.$ligne->id.' ('.$ligne->date_heure_impression.' par '.$ligne->login_imprimeur.')</h2>';
		echo'
		<TABLE>
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
