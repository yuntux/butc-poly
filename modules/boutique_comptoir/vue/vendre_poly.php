<script type="text/javascript">
	function test_longueur_code_poly(){
		var longueur=document.getElementById("code_poly").value.length;
		if (longueur==9) {

			document.forms["ajouter_poly"].submit();
		}
	}

	function test_longueur_code_etudiant(){
		var longueur=document.getElementById("num_badge_etudiant").value.length;
		if (longueur==5) {
			document.forms["saisie_etudiant"].submit();
		}
	}

</script>

<?php
echo '
<script type="text/javascript">';
if(!isset($_SESSION['etudiant_en_cours'])) {
	echo '	 window.onload = function() { document.getElementById("num_badge_etudiant").focus();  }';
} else {
	echo '	 window.onload = function() { document.getElementById("code_poly").focus(); }';
}
echo '</script>';



if(!isset($_SESSION['etudiant_en_cours'])) {
	echo'
<div class="groupe" style="margin-top:10px;width:97.5%;" id="liste_poly">
	<h3>Saisie étudiant</h3>
	<form name="saisie_etudiant" action="index.php?module=boutique_comptoir&action=vendre_poly" method="post" autocomplete="off">
	<input type="text" name="num_badge_etudiant" id="num_badge_etudiant" value="" onkeyup="test_longueur_code_etudiant();">
	</form>
</div>';
} else {
	echo'
<div class="groupe" style="margin-top:10px;width:97.5%;" id="liste_poly">
	<h3>Étudiant en cours</h3>
	<form name="fiche_etudiant" action="index.php?module=boutique_comptoir&action=vendre_poly" method="post">';

	echo 'login : '.$_SESSION['etudiant_en_cours']['login'].'<br>';
	echo 'NOM : '.$_SESSION['etudiant_en_cours']['nom'].'<br>';
	echo 'Prénom : '.$_SESSION['etudiant_en_cours']['prenom'].'<br>';
	echo '<input type="submit" name="changer_etudiant" value="Changer d\'étudiant" class="btn_valider">';
echo '<img src="https://demeter.utc.fr/pls/portal30/portal30.get_photo_utilisateur?username=adumaine" alt="Photo non disponible"/>';
	echo '
	</form>
</div>';
}

if(isset($_SESSION['etudiant_en_cours']) && $_SESSION['etudiant_en_cours']!="") {
	echo '
<div class="groupe" style="margin-top:10px;width:97.5%;" id="panier" autocomplete="off">
<form name="modif_panier" action="index.php?module=boutique_comptoir&action=vendre_poly" method="post">
<TABLE id="panier">
	<CAPTION>Panier</CAPTION>
	<THEAD>
		<TR><TH>Code</TH> <TH>Quantité</TH> <TH>Prix Unitaire</TH> <TH>Montant</TH> <TH>Action</TH></TR>
	</THEAD>
	<TBODY>';

	if (creationPanier())
	{
	   $nbArticles=compterArticles();
	   if ($nbArticles <= 0)
	   echo '<tr><td colspan="5">Votre panier est vide </ td></tr>';
	   else
	   {
	      for ($i=0 ;$i < $nbArticles ; $i++)
	      {
	         echo "<tr>";
	         echo "<td>".htmlspecialchars($_SESSION['panier']['libelleProduit'][$i])."</td>";
	         echo "<td>".htmlspecialchars($_SESSION['panier']['qteProduit'][$i])."</td>";
	         echo "<td>".htmlspecialchars($_SESSION['panier']['prixProduit'][$i])."</td>";
$montant = $_SESSION['panier']['prixProduit'][$i]*$_SESSION['panier']['qteProduit'][$i];
	         echo "<td>".htmlspecialchars($montant)."</td>";
	         echo "<td><a href=\"".htmlspecialchars("index.php?module=boutique_en_ligne&action=boutique_en_ligne&supprimer_poly=".rawurlencode($_SESSION['panier']['libelleProduit'][$i]))."\">Supprimer</a></td>";
	         echo "</tr>";
	      }
	   }
	}

	echo '<TBODY>
	<TFOOT>
		<TR><td colspan="5">
	    <?php echo "Total : ".MontantGlobal();?>
		</td></TR>
	</TFOOT>
</TABLE>
</form>

<form name="modif_panier" action="index.php?module=boutique_en_ligne&action=demande_paiement_paybox" method="post">
<input type="submit" name="payer_panier" value="PAYER" class="btn_valider">
</FORM>
</div>

<br>
<div class="groupe" style="margin-top:10px;width:97.5%;" id="liste_poly">
	<h3>Saisie des polys</h3>
	<form name="ajouter_poly" action="index.php?module=boutique_comptoir&action=vendre_poly" method="post" autocomplete="off">
	<input type="text" name="code_poly" id="code_poly" value="" onkeyup="test_longueur_code_poly(); autocomplete="off"">
	<!--<input type="submit" name="ajouter_poly_code_barre" value="Ajouter" class="btn_valider">-->
	</form>
</div>
<br>';
}
//prévoir une méthode de saisie alternative en cas de disfonctionnement du lecteur de code barre
?>
