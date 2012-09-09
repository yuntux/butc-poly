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

	function test_longueur_code_poly(){
		var longueur=document.getElementById("code_poly").value.length;
		if (longueur=='.LONGUEUR_CODE_POLY.') {
			ajouterLigne();
			document.getElementById("code_poly").value = "";
		}
	}

function ajouterLigne()
{
	var tableau = document.getElementById("tab_panier");

	var ligne = tableau.insertRow(-1);//on a ajouté une ligne

	var colonne1 = ligne.insertCell(0);//on a une ajouté une cellule
	colonne1.innerHTML += document.getElementById("code_poly").value;//on y met le contenu de titre

	var colonne2 = ligne.insertCell(1);//on ajoute la seconde cellule
	var valeur_code_poly = "code_poly_" + document.getElementById("code_poly").value;
	colonne2.innerHTML += \'<input type="text" name="\'+valeur_code_poly+\'" value="1">\';

//	var colonne3 = ligne.insertCell(2);
//	colonne3.innerHTML += date.getDate();//on ajoute le jour du mois
}

</script>';

echo'
<div style="float: left;width:43%;">
<div class="groupe" id="liste_poly">
	<h3>Saisie des polys</h3>
	<form name="ajouter_poly" action="index.php?module=imprimerie&action=ajout_impression" method="post" autocomplete="off">
	<input list="liste_polys" type="text" name="code_poly" id="code_poly" value="" oninput="test_longueur_code_poly(); ">';
//FIX ME : supprimer l'élèment de la liste une fois ajouté + interdire la saisie manuel d'un code déjà dans le bon (pas de doblon)
if (ENVIRONNEMENT_DEMO) echo 'CODE BARRE DU POLY DE DEMO : LB24C1P12';
if (isset($message_erreur)) echo '<strong>'.$message_erreur.'</strong>';

echo '<datalist id="liste_polys">';
	while($ligne = $liste_polys->fetch())
		echo '<option>'.$ligne->code_barre.'</option>';
echo '</datalist>';

echo '<br>
	</form>
	<br><a href="index.php?module=imprimerie&action=ajout_poly">Créer un poly</a>
</div>
</div>

<div style="float: right;width:57%;">
<div class="groupe" id="panier" autocomplete="on">
<form name="modif_panier" action="index.php?module=imprimerie&action=ajout_impression" method="post">
<TABLE id="tab_panier">
	<CAPTION>Bon d\'impression</CAPTION>
	<THEAD>
		<TR><TH>Code</TH> <TH>Quantité</TH> <TH>Action</TH></TR>
	</THEAD>
	<TBODY>
	</TBODY>
</TABLE>
	<br><input type="submit" id="valider_impression" name="valider_impression" value="Valider impression" class="btn_valider">
</form>

<br><a href="index.php?module=imprimerie&action=generer_bon_impression">Générer le bon d\'impression</a>
</div></div>';
?>
