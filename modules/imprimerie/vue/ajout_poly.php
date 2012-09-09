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
</script>';

echo'

<h1>Ajout d\'un poly</h1>
<form name="ajouter_poly" action="index.php?module=imprimerie&action=ajout_poly" method="post" autocomplete="off">
<br>Code poly : <input type="text" name="code_poly" id="code_poly" value="" size="9" oninput="test_longueur_code_poly(); ">
<br>UV :<input list="liste_uv" type="text" name="uv" id="uv" value="">
<br>Type : <SELECT name="type" >
<OPTION VALUE="CM">Cours Magistral</OPTION>
<OPTION VALUE="TD">Travaux Dirigés</OPTION>
<OPTION VALUE="TP">Travaux Pratiques</OPTION>
</SELECT>
<br>Prix :<input type="text" name="prix" id="prix" value="">
<br>Disponible pour la commande en ligne <input name="dispo_commande_en_ligne" value="1" type="checkbox" CHECKED>
<br>Pas de code barre physique sur l\'article <input name="sans_code_barre" value="1" type="checkbox">
';
if (isset($message_erreur)) echo '<strong>'.$message_erreur.'</strong>';

echo '<datalist id="liste_uv">';
	while($ligne = $liste_uv->fetch())
		echo '<option>'.$ligne->code.'</option>';
echo '</datalist>';

echo '
	<br><input type="submit" id="ajouter_poly" name="ajouter_poly" value="Ajouter poly" class="btn_valider">
	</form>';
?>
