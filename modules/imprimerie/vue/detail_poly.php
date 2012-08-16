<?php
echo'
	
<h1>Détail du polycopié '.$detail_poly->code_barre.'</h1>
Code : '.$detail_poly->code_barre.'
<br>
UV : '.$detail_poly->id_uv.' (responsable : '.$detail_poly->id_responsable.')
<br>
Sans code barre : '; if ($detail_poly->sans_code_barre) echo 'oui'; else echo 'non'; echo'
<br>
Type : '.$detail_poly->type.'
<br>
Prix : '.$detail_poly->prix.' €
<br>
Stock courant : '.$detail_poly->stock_courant.'
<br>
Devenir fin de semestre : '.$detail_poly->devenir_fin_semestre.' (enregistré par '.$detail_poly->login_devenir.' le '.$detail_poly->date_heure_devenir.')
<br>
Dispo commmande en ligne : '; if ($detail_poly->dispo_commande_en_ligne) echo 'oui'; else echo 'non'; echo'

<h2>Impressions</h2>
<TABLE>
	<THEAD>
		<TR><TH>Login imprimeur</TH> <TH>Quantite</TH> <TH>Date impression</TH> </TR>
	</THEAD>
	<TBODY>';
		$total_impressions = 0;
		while($ligne = $detail_ligne_impression->fetch()){
			 echo "<tr>";
			 echo "<td>".$ligne->login_imprimeur."</td>";
			 echo "<td>".$ligne->quantite."</td>";
				$total_impressions = $total_impressions + $ligne->quantite;
			 echo "<td>".$ligne->date_heure_retrait."</td>";
			 echo "</tr>";
		}
    echo '</TBODY> 
</TABLE>
<br>Quantité totale imprimée : '.$total_impressions.'

<h2>Commandes</h2>
<TABLE>
	<THEAD>
		<TR><TH>Login vendeur</TH> <TH>Login acheteur</TH> <TH>Mode paiement</TH> <TH>Quantite</TH> <TH>Date commande</TH> </TR>
	</THEAD>
	<TBODY>';
		$total_commandes = 0;
		while($ligne = $detail_ligne_commande->fetch()){
			 echo "<tr>";
			 echo "<td>".$ligne->login_vendeur."</td>";
			 echo "<td>".$ligne->login_acheteur."</td>";
			 echo "<td>".$ligne->mode_paiement."</td>";
			 echo "<td>".$ligne->quantite."</td>";
				$total_commandes = $total_commandes + $ligne->quantite;
			 echo "<td>".$ligne->date_heure_commande."</td>";
			 echo "</tr>";
		}
    echo '</TBODY> 
</TABLE>
<br>Quantité totale commandée : '.$total_commandes.'

<h2>Retraits</h2>
<TABLE>
	<THEAD>
		<TR><TH>Login vendeur</TH> <TH>Login acheteur</TH> <TH>Quantite</TH> <TH>Date retrait</TH> </TR>
	</THEAD>
	<TBODY>';
		$total_retraits = 0;
		while($ligne = $detail_ligne_retrait->fetch()){
			 echo "<tr>";
			 echo "<td>".$ligne->login_vendeur."</td>";
			 echo "<td>".$ligne->login_acheteur."</td>";
			 echo "<td>".$ligne->quantite."</td>";
				$total_retraits = $total_retraits + $ligne->quantite;
			 echo "<td>".$ligne->date_heure_retrait."</td>";
			 echo "</tr>";
		}
    echo '</TBODY> 
</TABLE>
<br>Quantité totale retirée : '.$total_retraits;

?>
