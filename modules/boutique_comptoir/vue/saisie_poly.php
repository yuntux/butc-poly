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
echo '
<script type="text/javascript">
	window.onload = function() { document.getElementById("code_poly").focus();  }

	window.onkeydown=function(e){
	    if(e.which == 120)
			 document.getElementById("payer_cb").click();
	    if(e.which == 121)
			 document.getElementById("payer_moneo").click();
	    if(e.which == 122)
			 document.getElementById("payer_cheque").click();
	    if(e.which == 123)
			 document.getElementById("vente_interne").click();
	}

	function test_longueur_code_poly(){
		var longueur=document.getElementById("code_poly").value.length;
		if (longueur=='.LONGUEUR_CODE_POLY.')
			document.forms["ajouter_poly"].submit();
	}

	function selection_article_sans_code_barre (liste_deroulante){
		document.getElementById("code_poly").value = liste_deroulante.options[liste_deroulante.options.selectedIndex].value;
		document.forms["ajouter_poly"].submit();
	}
</script>';

$action_post_changement='vendre_poly';
include CHEMIN_VUE.'cartouche_etudiant.php';

echo'
<div class="groupe" id="liste_poly">
	<h3>Saisie des polys</h3>
	<form name="ajouter_poly" action="index.php?module=boutique_comptoir&action=vendre_poly" method="post" autocomplete="off">
	<SELECT name="articles_sans_code_barre" onchange="selection_article_sans_code_barre(this)">';
		echo '<OPTION VALUE="--">--Articles sans code barre--</OPTION>';
		while($article = $articles_sans_code_barre->fetch())
			echo'<OPTION VALUE="'.$article->code_barre.'">'.$article->designation.' ('.$article->code_barre.')</OPTION>';
	echo'	</SELECT>
	<br>
	Saisir le code barre : <input type="text" name="code_poly" id="code_poly" value="" onkeyup="test_longueur_code_poly(); ">
	<br>Appuyer sur la touche TABulation du clavier pour passer directement à la zome de saisie des références du moyen de paiement.';
if (ENVIRONNEMENT_DEMO) echo '<br>CODE BARRE DU POLY DE DEMO : LB24C1P12';
if (isset($message_erreur)) echo '<strong>'.$message_erreur.'</strong>';
echo '<br>
	</form>
</div>
</div>

<div style="float: right;width:57%;">
<div class="groupe" id="panier" autocomplete="on">
<h3>Panier</h3>';

	// FIXME : liste d'auto complétion modifiable (si le porteur n'est pas de l'UTC ex : un parent) si modification du porteur
	echo '
	<form name="modif_panier" action="index.php?module=boutique_comptoir&action=paiement_comptoir" method="post">
	Références du moyen de paiement : <input type="text" name="references_moyen_paiement" id="references_moyen_paiement" value="" size="50"><br>Vide si Monéo, N°Cheque+N°Compte+Banque si chèque, N° de carte si CB
	<br>
	Propriétaire du moyen de paiement : <input type="text" name="proprietaire_moyen_paiement" id="proprietaire_moyen_paiement" value="'.$_SESSION['etudiant_en_cours']['prenom'].' '.$_SESSION['etudiant_en_cours']['nom'].'" size="50">
<br><br>
';

echo'
<TABLE id="pannier">
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
</TABLE>';
if ($total_panier > 0) {
	echo '<br>Ne pas valider le paiement avant que l\'étudiant aie quitté le comptoir sinon ça fausse les statistiques !<br><input type="submit" id="payer_cb" name="payer_cb" value="PAIEMENT CB [F9]" class="btn_valider">
	<input type="submit" id="payer_moneo" name="payer_moneo" value="PAIEMENT MONEO [F10]" class="btn_valider">
	<input type="submit" id="payer_cheque" name="payer_cheque" value="PAIEMENT CHEQUE [F11]" class="btn_valider">';
	if ($_SESSION['etudiant_en_cours']['formation_continue'])
		echo '<input type="submit" id="vente_interne" name="vente_interne" value="VENTE INTERNE [F12]" class="btn_valider">
		</FORM>';
}

echo'</div></div><div style="clear: both ;"></div>';
?>
