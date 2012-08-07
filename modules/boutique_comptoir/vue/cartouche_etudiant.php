<?php
echo'
<div style="float:left;width:40%">
<div class="groupe" id="etudiant_en_cours">
	<h3>Étudiant en cours</h3>';
	echo '<img src="https://demeter.utc.fr/pls/portal30/portal30.get_photo_utilisateur?username='.$_SESSION['etudiant_en_cours']['login'].'" alt="Photo non disponible" WIDTH="100"  style="float: left; margin: 10px;"/>';
	echo '<p>';
	echo 'login : '.$_SESSION['etudiant_en_cours']['login'].'<br>';
	echo 'NOM : '.$_SESSION['etudiant_en_cours']['nom'].'<br>';
	echo 'Prénom : '.$_SESSION['etudiant_en_cours']['prenom'].'<br>';
	echo 'Élligible vente interne : '; if ($_SESSION['etudiant_en_cours']['formation_continue']) echo 'OUI'; else echo 'NON'; echo '<br>';
	echo "<input type=\"submit\" name=\"historique_etudiant\" value=\"Historique\" class=\"btn_valider\" 
onClick=\"window.open ('index.php?module=boutique_en_ligne&action=historique&login=".$_SESSION['etudiant_en_cours']['login']."', 'nom_interne_de_la_fenetre', config='toolbar=no, menubar=no, scrollbars=yes, resizable=yes, location=yes, directories=no, status=no, fullscreen')\">";
	echo '<form name="fiche_etudiant" action="index.php?module=boutique_comptoir&action=changer_etudiant&action_post_changement='.$action_post_changement.'" method="post">';
		echo '<input type="submit" name="changer_etudiant" value="Changer d\'étudiant" class="btn_annuler">';
	echo'</form>';
	echo '</p>
</div>';

?>
