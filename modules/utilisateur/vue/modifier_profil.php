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
	<div id="content">

<?php
echo '<div class="post">
<h2 class="title">Mon profil</h2>
<div class="entry">
<br>';

if (isset($message_erreur)) {
    echo '<span class="erreur_formulaire">'.$message_erreur.'</span>';
}

echo '<form name="modifier_profil" action="index.php?module=utilisateur&action=modifier_profil" method="post">

<table border="0" cellspacing="1" cellpadding="2">
<tr>
	<td bgcolor="#B1D2E1">NOM</td>
	<td><input type="text" size="50" maxlength="50" name="nom" value="'; if (isset($utilisateur->nom)) { echo $utilisateur->nom; } echo'"></td>
</tr>

<tr>
	<td bgcolor="#B1D2E1">Prénom</td>
	<td><input type="text" size="50" maxlength="50" name="prenom" value="'; if (isset($utilisateur->prenom)) { echo $utilisateur->prenom; } echo'"></td>
</tr>
<tr>
	<td bgcolor="#B1D2E1">Téléphone</td>
	<td><input type="text" name="telephone" size="10" maxlength="10" value="'; if (isset($utilisateur->telephone)) { echo $utilisateur->telephone; } echo '"></td>
</tr>
</table>
<br><br><center><input type="submit" name="valider" value="OK"/></center>
</form>';

?>
</div></div>
<div style="clear: both;">&nbsp;</div>
</div>
