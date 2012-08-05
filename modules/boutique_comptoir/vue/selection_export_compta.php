<?php
echo'
<div class="groupe">
	<h3>Sélection de la date des ventes à exporter</h3>
	<form name="selection_brouillard" action="modules/boutique_comptoir/controleur/generer_export_compta.php" method="post" autocomplete="off">
	<input type="text" name="date" value="aaaammjj">
	<input type="submit" name="generer_brouillard" value="Exporter les ventes" class="btn_valider">';
if (isset($message_erreur)) echo '<strong>'.$message_erreur.'</strong>';
echo'	</form>
</div>';

?>
