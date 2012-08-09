<?php
echo '
<script type="text/javascript">
	window.onload = function() { document.getElementById("code_poly").focus();  }
</script>';

echo'

<h1>Ajout d\'un poly</h1>
<form name="ajouter_poly" action="index.php?module=imprimerie&action=ajout_poly" method="post" autocomplete="off">
<br>Code poly : <input type="text" name="code_poly" id="code_poly" value="" oninput="test_longueur_code_poly(); ">
<br>UV :<input list="liste_uv" type="text" name="uv" id="uv" value="">
<br>Prix :<input type="text" name="prix" id="prix" value="">';
if (isset($message_erreur)) echo '<strong>'.$message_erreur.'</strong>';

echo '<datalist id="liste_uv">';
	while($ligne = $liste_uv->fetch())
		echo '<option>'.$ligne->code.'</option>';
echo '</datalist>';

echo '
	<br><input type="submit" id="ajouter_poly" name="ajouter_poly" value="Ajouter poly" class="btn_valider">
	</form>';
?>
