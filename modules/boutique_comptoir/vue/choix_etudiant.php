<?php
echo '
<script type="text/javascript">
	window.onload = function() { document.getElementById("num_badge_etudiant").focus();  }

	function test_longueur_code_etudiant(){
		var longueur=document.getElementById("num_badge_etudiant").value.length;
		if (longueur==5) {
			document.forms["saisie_etudiant"].submit();
		}
	}
</script>';

echo'
<div class="groupe" style="margin-top:10px;width:97.5%;" id="liste_poly">
	<h3>Saisie étudiant</h3>
	<form name="saisie_etudiant" action="index.php?module=boutique_comptoir&action=vendre_poly" method="post" autocomplete="off">
	<input type="text" name="num_badge_etudiant" id="num_badge_etudiant" value="" onkeyup="test_longueur_code_etudiant();">';
if (ENVIRONNEMENT_DEMO) echo 'NUMERO BUTC ETUDIANT DEMO : 72648';
echo'	</form>
</div>';

?>
