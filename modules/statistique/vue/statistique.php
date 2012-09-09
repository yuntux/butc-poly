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

echo '<h1>Statistiques</h1>
<b>Critère :</b> temps passé au comptoire<br/>
<b>Indicateur :</b>  delta entre l\'heure de sélection de l\'étudiant et l\'heure d\'enregistrement du retrait retrait.<br/>
<b>Mesure : </b>
<br/>
Temps moyen au comptoire sans avoir payé en ligne : '.$achat_comptoir->moyenne_duree_retrait.'
<br/>
Temps moyen au comptoire après avoir payé en ligne : '.$achat_en_ligne->moyenne_duree_retrait.'
';
?>
