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

echo '<h2>Liste des utilisateurs en formation continue (elligibles à la vente interne)</h2>
<TABLE class="liste">
    <THEAD>
        <TR><TH>Utilisateur</TH> <TH>Action</TH></TR>
    </THEAD>
    <TBODY>';

        while($ligne = $utilisateur_formation_continue->fetch()){
			echo "<tr>";
            echo "<td>".$ligne->nom.' '.$ligne->prenom1."</td>";
            echo '<td><a href="index.php?module=boutique_comptoir&action=facture_formation_continue&utilisateur='.$ligne->login.'">Facture</a></td>';
            echo "</tr>";
            }
    echo '</TBODY> 
</TABLE>';
echo '<br><a href="modules/boutique_comptoir/controleur/facture_formation_continue.php"Facture récapitulative</a>';
?>
