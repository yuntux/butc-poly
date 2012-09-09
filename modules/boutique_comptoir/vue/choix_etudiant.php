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
	window.onload = function() { document.getElementById("num_badge_etudiant").focus();  }

	function test_longueur_code_etudiant(){
		var longueur=document.getElementById("num_badge_etudiant").value.length;
		if (longueur=='.LONGUEUR_NUM_CARTE_ETU.') {
			document.forms["saisie_etudiant"].submit();
		}
	}
</script>';

echo'
<div class="groupe" style="margin-top:10px;width:97.5%;" id="liste_poly">
	<h3>Saisie étudiant</h3>
	<form name="saisie_etudiant" action="index.php?module=boutique_comptoir&action=choix_etudiant&action_post_choix='.$_GET['action_post_choix'].'" method="post" autocomplete="off">
	<input type="text" name="num_badge_etudiant" id="num_badge_etudiant" value="" onkeyup="test_longueur_code_etudiant();">';
if (ENVIRONNEMENT_DEMO) echo 'NUMERO BUTC ETUDIANT DEMO : 81640';
if (isset($message_erreur)) echo '<strong>'.$message_erreur.'</strong>';
echo'	</form>
</div>';

?>
