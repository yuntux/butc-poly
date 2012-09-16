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

echo '<strong>Aucun polycopié payé ne sera remboursé. Aucun polycopié retiré ne sera repris ou échangé.</strong><br>';
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
		echo '<br>Num carte de test : 4012 0010 3844 3335 -> juin 2016 -> 123';
}
echo '</FORM>';
echo '</div>';
if (isset($message_erreur)) echo '<strong>'.$message_erreur.'</strong>';
?>


<br>

<div class="groupe" style="margin-top:10px;width:97.5%;" id="liste_poly">
<form name="code_poly" action="index.php?module=boutique_en_ligne&action=boutique_en_ligne" method="post">

<h3>Produits disponibles pour l'achat en ligne</h3>
	<?php
		while($poly = $liste_poly->fetch())
		{
			echo '<input type="submit" name="code_poly" value="'.$poly->code_barre.'">';
		}
	?>
</div>
