<?php
echo '
<script type="text/javascript">
	window.onload = function() { document.getElementById("code_poly").focus();  }

	function test_longueur_code_poly(){
		var longueur=document.getElementById("code_poly").value.length;
		if (longueur==9)
		{
			document.forms["ajouter_poly"].submit();
		}
	}
</script>


<div class="groupe" style="margin-top:10px;width:97.5%;" id="liste_poly">
	<h3>Étudiant en cours</h3>
	<form name="fiche_etudiant" action="index.php?module=boutique_comptoir&action=vendre_poly" method="post">';
	echo 'login : '.$_SESSION['etudiant_en_cours']['login'].'<br>';
	echo 'NOM : '.$_SESSION['etudiant_en_cours']['nom'].'<br>';
	echo 'Prénom : '.$_SESSION['etudiant_en_cours']['prenom'].'<br>';
	echo '<input type="submit" name="changer_etudiant" value="Changer d\'étudiant" class="btn_valider">';
	echo '
	</form>
</div>

<div class="groupe" style="margin-top:10px;width:97.5%;" id="liste_poly">
	<h3>Saisie des polys</h3>
	<form name="ajouter_poly" action="index.php?module=boutique_comptoir&action=vendre_poly" method="post" autocomplete="off">
	<input type="text" name="code_poly" id="code_poly" value="" onkeyup="test_longueur_code_poly(); ">
	<!--<input type="submit" name="ajouter_poly_code_barre" value="Ajouter" class="btn_valider">-->
	</form>
</div>
<br>

<div class="groupe" style="margin-top:10px;width:97.5%;" id="panier" autocomplete="off">
<form name="modif_panier" action="index.php?module=boutique_comptoir&action=vendre_poly" method="post">
<TABLE id="pannier">
	<CAPTION>Pannier</CAPTION>
	<THEAD>
		<TR><TH>Code</TH> <TH>Quantité</TH> <TH>Prix Unitaire</TH> <TH>Montant</TH> <TH>Action</TH></TR>
	</THEAD>
	<TBODY>';

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

echo '
</TABLE>
</form>';

if ($total_panier > 0) {
	echo '
	<form name="modif_panier" action="index.php?module=boutique_en_ligne&action=paiement_comptoir" method="post">
	<input type="submit" name="payer_cb" value="PAIEMENT CB" class="btn_valider">
	<input type="submit" name="payer_moneo" value="PAIEMENT MONEO" class="btn_valider">
	<input type="submit" name="payer_cheque" value="PAIEMENT CHEQUE" class="btn_valider">
	</FORM>';
}

echo'</div>';

<br>';
?>
