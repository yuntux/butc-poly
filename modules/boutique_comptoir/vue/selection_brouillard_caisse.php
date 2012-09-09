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
echo'
<div class="groupe">
	<h3>Sélection du brouillard de caisse</h3>
	<form name="selection_brouillard" action="index.php?module=boutique_comptoir&action=generer_brouillard" method="post" autocomplete="off">
	<input type="date" name="date" value="aaaammjj">
	<input type="submit" name="generer_brouillard" value="Générer le brouillard de caisse" class="btn_valider">';
if (isset($message_erreur)) echo '<strong>'.$message_erreur.'</strong>';
echo'	</form>
</div>';

?>
