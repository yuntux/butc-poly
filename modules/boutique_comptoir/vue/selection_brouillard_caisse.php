<?php
echo'
<div class="groupe">
	<h3>Sélection du brouillard de caisse</h3>
	<form name="selection_brouillard" action="modules/boutique_comptoir/controleur/generer_brouillard.php" method="post" autocomplete="off">
	<input type="text" name="date" value="aaaammjj">
	<input type="submit" name="generer_brouillard" value="Générer le brouillard de caisse" class="btn_valider">';
if (isset($message_erreur)) echo '<strong>'.$message_erreur.'</strong>';
echo'	</form>
</div>';

?>
