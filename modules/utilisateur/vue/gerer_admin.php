	<div id="content">

<?php
if (isset($message)) {
    echo '<span class="erreur_formulaire">'.$message.'</span>';
}

echo '<div class="post">
<h2 class="title">Ajouter un administrateur</h2>
<div class="entry">
<br>
<br>ATTENTION: Seuls les utilisateurs s\'étant déjà connectés une fois au site peuvent être ajoutés comme administrateurs.<br>';


echo '<form name="gerer_admin" action="index.php?module=utilisateur&action=ajouter_admin" method="post">';
//inclusion pour les listes d'autocompletion des utilisateurs
include(CHEMIN_LIB."autoComplete/liste_utilisateurs.php");

echo '<br><br><center><input type="submit" name="valider" value="OK"/></center>
</form>
</div></div>';

echo '<div class="post">
<h2 class="title">Liste des administrateurs</h2>
<div class="entry">
<br>
ATTENTION: un administrateur ne peut pas retirer lui-même ses propres droits admin.<br>
<br>
<table border="0" cellspacing="1" cellpadding="2">
<tr>
	<th>Login</th>
	<th>NOM</th>
	<th>Prénom</th>
	<th>Action</th>
</tr>';

while($administrateur = $liste_administrateur->fetch())
{
		echo '<tr>';
			echo '<td>'.$administrateur->login.'</td>';
			echo '<td>'.$administrateur->nom.'</td>';
			echo '<td>'.$administrateur->prenom.'</td>';
			if ($administrateur->login != $_SESSION['login']) { echo '<td><a href="index.php?module=utilisateur&action=supprimer_admin&id='.$administrateur->login.'">Retirer les droits admin</a>'; }
			echo '</td>';
		echo '</tr>';
}

echo '</table>';
?>
</div></div>
<div style="clear: both;">&nbsp;</div>
</div>
