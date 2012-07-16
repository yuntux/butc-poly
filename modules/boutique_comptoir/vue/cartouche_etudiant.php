<?php
echo'
<div style="float:left;margin-top:10px;width:40%">
<div class="groupe" id="etudiant_en_cours style="">
	<h3>Étudiant en cours</h3>
	<form name="fiche_etudiant" action="index.php?module=boutique_comptoir&action=changer_etudiant&action_post_changement='.$action_post_changement.'" method="post">';
	echo '<img src="https://demeter.utc.fr/pls/portal30/portal30.get_photo_utilisateur?username='.$_SESSION['etudiant_en_cours']['login'].'" alt="Photo non disponible" WIDTH="100"  style="float: left; margin: 10px;"/>';
	echo '<p>';
	echo 'login : '.$_SESSION['etudiant_en_cours']['login'].'<br>';
	echo 'NOM : '.$_SESSION['etudiant_en_cours']['nom'].'<br>';
	echo 'Prénom : '.$_SESSION['etudiant_en_cours']['prenom'].'<br>';
	echo '<input type="submit" name="changer_etudiant" value="Changer d\'étudiant" class="btn_valider">';
	echo '</p>
	</form>
</div>';

?>
