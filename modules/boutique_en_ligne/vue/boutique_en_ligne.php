<div class="groupe" style="margin-top:10px;width:97.5%;" id="panier">
<form name="modif_panier" action="index.php?module=boutique_en_ligne&action=boutique_en_ligne" method="post">
<TABLE id="panier">
	<CAPTION>Panier référence <?php if(isset($_SESSION['panier']['reference'])) echo $_SESSION['panier']['reference'];?></CAPTION>
	<THEAD>
		<TR><TH>Code</TH> <TH>Quantité</TH> <TH>Prix Unitaire</TH> <TH>Montant</TH> <TH>Action</TH></TR>
	</THEAD>
	<TBODY>
<?php
	if (creationPanier())
	{
	   $nbArticles=compterArticles();
	   $total_panier = MontantGlobal();
	   if ($nbArticles <= 0) {
			echo '
			</TBODY>
			<TFOOT>
				<TR><td colspan="5">Votre panier est vide </td></TR>
			</TFOOT>';
	   } else {
				  for ($i=0 ;$i < $nbArticles ; $i++)
				  {
					 echo "<tr>";
					 echo "<td>".htmlspecialchars($_SESSION['panier']['libelleProduit'][$i])."</td>";
					 echo "<td>".htmlspecialchars($_SESSION['panier']['qteProduit'][$i])."</td>";
					 echo "<td>".htmlspecialchars($_SESSION['panier']['prixProduit'][$i])."</td>";
		$montant = $_SESSION['panier']['prixProduit'][$i]*$_SESSION['panier']['qteProduit'][$i];
					 echo "<td>".htmlspecialchars($montant)."</td>";
					 echo "<td><a href=\"".htmlspecialchars("index.php?module=boutique_comptoir&action=vendre_poly&supprimer_poly=".rawurlencode($_SESSION['panier']['libelleProduit'][$i]))."\">Supprimer</a></td>";
					 echo "</tr>";
				  }
			echo '
			</TBODY>
			<TFOOT>
				<TR><td colspan="5">Total : '.$total_panier.'</td></TR>
			</TFOOT>';
	   }
	}

echo '</TABLE>';
echo '</form>';


/*echo '<FORM ACTION = "/cgi-bin/modulev2.cgi" METHOD = post>';
echo '<INPUT TYPE = hidden NAME = PBX_MODE VALUE = "'.PBX_MODE.'">';
echo '<INPUT TYPE = hidden NAME = PBX_SITE VALUE = "'.PBX_SITE.'">';
echo '<INPUT TYPE = hidden NAME = PBX_RANG VALUE = "'.PBX_RANG.'">';
echo '<INPUT TYPE = hidden NAME = PBX_IDENTIFIANT VALUE = "'.PBX_IDENTIFIANT.'">';
$montant_en_centimes = $total_panier*100;
echo '<INPUT TYPE = hidden NAME = PBX_TOTAL VALUE = "'.$montant_en_centimes.'">'; //montant exprimé en centimes
echo '<INPUT TYPE = hidden NAME = PBX_DEVISE VALUE = "'.PBX_DEVISE.'">';
echo '<INPUT TYPE = hidden NAME = PBX_CMD VALUE = "'.$_SESSION['panier']['reference'].'">';
echo '<INPUT TYPE = hidden NAME = PBX_PORTEUR VALUE = "'.$_SESSION['email'].'">';
echo '<INPUT TYPE = hidden NAME = PBX_RETOUR VALUE = "'.PBX_RETOUR.'">';
echo '<INPUT TYPE = hidden NAME = PBX_REPONDRE_A VALUE = "'.PBX_REPONDRE_A.'">';
echo '<INPUT TYPE = hidden NAME = PBX_EFFECTUE VALUE = "'.PBX_EFFECTUE.'">';
echo '<INPUT TYPE = hidden NAME = PBX_REFUSE VALUE = "'.PBX_REFUSE.'">';
echo '<INPUT TYPE = hidden NAME = PBX_ANNULE VALUE = "'.PBX_ANNULE.'">';

if (ENVIRONNEMENT_DEMO) {
	echo 'Num carte de test : 4012 0010 3844 3335 -> juin 2016 -> 123';
	echo '<INPUT TYPE = hidden NAME = PBX_PAYBOX VALUE = "https://preprod-tpeweb.paybox.com/cgi/MYchoix_pagepaiement.cgi">';
	echo '<INPUT TYPE = hidden NAME = PBX_BACKUP1 VALUE = "https://preprod-tpeweb.paybox.com/cgi/MYchoix_pagepaiement.cgi">';
	echo '<INPUT TYPE = hidden NAME = PBX_BACKUP2 VALUE = "https://preprod-tpeweb.paybox.com/cgi/MYchoix_pagepaiement.cgi">';
}
*/
if ($total_panier>0){
	if ($_SESSION['formation_continue']) {
		echo '<form name="modif_panier" action="index.php?module=boutique_en_ligne&action=vente_interne" method="post">';
		echo '<input type="submit" name="vente_interne" value="GRATUIT FORMATION CONTINUE" class="btn_valider">';
	}
	else {
		echo '<form name="modif_panier" action="index.php?module=boutique_en_ligne&action=demande_paiement_paybox" method="post">';
		echo '<input type="submit" name="payer_panier" value="PAYER" class="btn_valider">';
	}

	if (ENVIRONNEMENT_DEMO)
		echo 'Num carte de test : 4012 0010 3844 3335 -> juin 2016 -> 123';
}
echo '</FORM>';
echo '</div>';
if (isset($message_erreur)) echo '<strong>'.$message_erreur.'</strong>';
?>


<br>

<div class="groupe" style="margin-top:10px;width:97.5%;" id="liste_poly">
<form name="code_poly" action="index.php?module=boutique_en_ligne&action=boutique_en_ligne" method="post">

	<TABLE id="liste_poly">		
		<CAPTION>Liste des poly disponibles</CAPTION>
		<THEAD>
			<TR><TH></TH> <TH>CS</TH> <TH>TM</TH> <TH>TSH</TH></TR>
		</THEAD>

		<TBODY>
			<TR>
				<TH>TC</TH>
				<TD>
	<?php
		while($poly = $liste_poly_tc_cs->fetch())
		{
			echo '<input type="submit" name="code_poly" value="'.$poly->code_barre.'">';
		}
	?>
				</TD>
				<TD>
	<?php
		while($poly = $liste_poly_tc_tm->fetch())
		{
			echo '<input type="submit" name="code_poly" value="'.$poly->code_barre.'">';
		}
	?>
				</td>
				<TD rowspan="7">
	<?php
		while($poly = $liste_poly_tsh->fetch())
		{
			echo '<input type="submit" name="code_poly" value="'.$poly->code_barre.'">';
		}
	?>
				</TD>
			</TR>

			<TR>
				<TH>GB</TH>
				<TD>
	<?php
		while($poly = $liste_poly_gb_cs->fetch())
		{
			echo '<input type="submit" name="code_poly" value="'.$poly->code_barre.'">';
		}
	?>
				</TD>
				<TD>
	<?php
		while($poly = $liste_poly_gb_tm->fetch())
		{
			echo '<input type="submit" name="code_poly" value="'.$poly->code_barre.'">';
		}
	?>
				</TD>

			</TR>

			<TR>
				<TH>GI</TH>
				<TD>
	<?php
		while($poly = $liste_poly_gi_cs->fetch())
		{
			echo '<input type="submit" name="code_poly" value="'.$poly->code_barre.'">';
		}
	?>
				</TD>
				<TD>
	<?php
		while($poly = $liste_poly_gi_tm->fetch())
		{
			echo '<input type="submit" name="code_poly" value="'.$poly->code_barre.'">';
		}
	?>
				</TD>

			</TR>

			<TR>
				<TH>GM</TH>
				<TD>
	<?php
		while($poly = $liste_poly_gm_cs->fetch())
		{
			echo '<input type="submit" name="code_poly" value="'.$poly->code_barre.'">';
		}
	?>
				</TD>
				<TD>
	<?php
		while($poly = $liste_poly_gm_tm->fetch())
		{
			echo '<input type="submit" name="code_poly" value="'.$poly->code_barre.'">';
		}
	?>
				</TD>

			</TR>

			<TR>
				<TH>GP</TH>
				<TD>
	<?php
		while($poly = $liste_poly_gp_cs->fetch())
		{
			echo '<input type="submit" name="code_poly" value="'.$poly->code_barre.'">';
		}
	?>
				</TD>
				<TD>
	<?php
		while($poly = $liste_poly_gp_tm->fetch())
		{
			echo '<input type="submit" name="code_poly" value="'.$poly->code_barre.'">';
		}
	?>
				</TD>

			</TR>

			<TR>
				<TH>GSM</TH>
				<TD>
	<?php
		while($poly = $liste_poly_gsm_cs->fetch())
		{
			echo '<input type="submit" name="code_poly" value="'.$poly->code_barre.'">';
		}
	?>
				</TD>
				<TD>
	<?php
		while($poly = $liste_poly_gsm_tm->fetch())
		{
			echo '<input type="submit" name="code_poly" value="'.$poly->code_barre.'">';
		}
	?>
				</TD>

			</TR>

			<TR>
				<TH>GSU</TH>
				<TD>
	<?php
		while($poly = $liste_poly_gsu_cs->fetch())
		{
			echo '<input type="submit" name="code_poly" value="'.$poly->code_barre.'">';
		}
	?>
				</TD>
				<TD>
	<?php
		while($poly = $liste_poly_gsu_tm->fetch())
		{
			echo '<input type="submit" name="code_poly" value="'.$poly->code_barre.'">';
		}
	?>
				</TD>

			</TR>
		<TBODY>
	</TABLE>
</FORM>
</div>
