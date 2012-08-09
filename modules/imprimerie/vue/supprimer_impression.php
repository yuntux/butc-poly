<?php
echo '
<h1>Supprimer impression</h1>
<form action="index.php?module=imprimerie&action=supprimer_impression&id='.$_GET['id'].'" method="post">
Voulez-vous réelement supprimer l\'impression n° '.$_GET['id'].' ?
<br><input type="submit" name="valider_suppression" value="Confirmer la suppression" class="btn_valider">
</form>
';
?>
