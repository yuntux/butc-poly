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
//FIX ME : indiquer le nombre de polys commandés mais non retiré de manière distincte du stock courant total
echo '
<h1>Devenir du poly '.$_GET['code_poly'].'</h1>
<form name="ajouter_poly" action="index.php?module=enseignant&action=devenir_invendu&code_poly='.$_GET['code_poly'].'" method="post" autocomplete="off">
En fin de semestre, je souhaite que les polycopiés '.$_GET['code_poly'].' invendus (actuellement '.$detail_poly->stock_courant.' exemplaires sont concernés) soient 
<SELECT name="devenir_poly" >
<OPTION value="DESTRUCTION">détruits</OPTION>
<OPTION value="REVENTE">revendus au semestre suivant</OPTION>
</SELECT>.
<br>
	<input type="submit" name="valider" value="VALIDER" class="btn_valider">
';
?>
