	<div id="content">

<?php
echo '<div class="post">
<h2 class="title">Mon profil</h2>
<div class="entry">
<br>';

if (isset($message_erreur)) {
    echo '<span class="erreur_formulaire">'.$message_erreur.'</span>';
}

echo '<form name="modifier_profil" action="index.php?module=utilisateur&action=modifier_profil" method="post">

<table border="0" cellspacing="1" cellpadding="2">
<tr>
	<td bgcolor="#B1D2E1">NOM</td>
	<td><input type="text" size="50" maxlength="50" name="nom" value="'; if (isset($utilisateur->nom)) { echo $utilisateur->nom; } echo'"></td>
</tr>

<tr>
	<td bgcolor="#B1D2E1">Prénom</td>
	<td><input type="text" size="50" maxlength="50" name="prenom" value="'; if (isset($utilisateur->prenom)) { echo $utilisateur->prenom; } echo'"></td>
</tr>
<tr>
	<td bgcolor="#B1D2E1">Téléphone</td>
	<td><input type="text" name="telephone" size="10" maxlength="10" value="'; if (isset($utilisateur->telephone)) { echo $utilisateur->telephone; } echo '"></td>
</tr>
</table>
<br><br><center><input type="submit" name="valider" value="OK"/></center>
</form>';

?>
</div></div>
<div style="clear: both;">&nbsp;</div>
</div>
