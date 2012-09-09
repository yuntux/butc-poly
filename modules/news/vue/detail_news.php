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
$news = $detail_news->fetch();
echo '<div class="post">
<h2 class="title">'.$news->titre.'</h2>
<div class="entry">
<p>'.$news->texte.'</p>

<br>
<p>publié le '.datefr($news->date).' par <a href="mailto:'.$news->email.'">'.$news->prenom.' '.$news->nom.'</a></p>';

if ($_SESSION['administrateur'] == 1) {
        echo '<p><a href="index.php?module=news&action=modifier_news&id='.$news->id.'">Modifier cette news</a>';
        echo ' <a href="index.php?module=news&action=supprimer_news&id='.$news->id.'">Supprimer cette news</a></p>';
 
}
?>
</div></div>
<div style="clear: both;">&nbsp;</div>
</div>
