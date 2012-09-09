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
	<!-- ajoutés pour le calendrier JS-->
	<link type="text/css" rel="stylesheet" href="libs/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css" media="screen"></LINK> 
	<SCRIPT type="text/javascript" src="libs/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js"></script>
<div id="content">

<?php
echo '<div class="post">
<h2 class="title">Modifier une news</h2>
<div class="entry">
<br>';

if (isset($message_erreur)) {
	echo '<span class="erreur_formulaire">'.$message_erreur.'</span>';
}

echo '<form name="proposer_trajet" action="index.php?module=news&action=modifier_news&id='.$news->id.'" method="post">

<table border="0" cellspacing="1" cellpadding="2">

<tr>
	<td bgcolor="#B1D2E1">Date de publication</td>
	<td><input type="text" value="'.date("d/m/Y",strtotime($news->date)).'" readonly id="date" name="date" onclick="displayCalendar(document.forms[0].date,\'dd/mm/yyyy\',this)"></td>
</tr>
<tr>
	<td bgcolor="#B1D2E1">Titre</td>
	<td><input type="text" size="20" maxlength="20" name="titre" value="'; if (isset($news->titre)) { echo $news->titre; } echo'"></td>
</tr>
<tr>
	<td bgcolor="#B1D2E1">Corps</td>
	<td><textarea name="texte" rows="10" cols="50">'; if (isset($news->texte)) { echo $news->texte; } echo '</textarea></td>
</tr>
</table>

<br><br><center><input type="submit" name="valider" value="OK"/></center>
</form>';
?>
</div></div>
<div style="clear: both;">&nbsp;</div>
</div>
