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
<h2 class="title">Suppression de la news numéro '.$news->id.'</h2>
<div class="entry">
<br>
<form name="modif_trajet" action="index.php?module=news&action=supprimer_news&id='.$_GET['id'].'" method="post">
Vous etes sur le point de suppimer le trajet numéro '.$news->id.'
<br><br><center><input type="submit" name="valider" value="OK"/></center>
</form>';
?>
</div></div>
<div style="clear: both;">&nbsp;</div>
</div>
