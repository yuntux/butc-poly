<div id="content">
<?php 
echo '<div class="post">';

if (isset($message)) {
    echo '<span class="erreur_formulaire">'.$message.'</span>';
}

while($news = $liste_toutes_news->fetch())
{
	echo '<h2 class="title">'.$news->titre.'</h2>
	<div class="entry">
	<p>'.substr($news->texte, 0, 100).'<br><a href="index.php?module=news&action=detail_news&id='.$news->id.'"> lire la suite</a></p>

	<br>
	<p>publié le '.datefr($news->date).' par <a href="mailto:'.$news->email.'">'.$news->prenom.' '.$news->nom.'</a><br>';

	if ($_SESSION['administrateur'] == 1) {
		echo ' <a href="index.php?module=news&action=modifier_news&id='.$news->id.'">Modifier cette news</a>';
		echo ' <a href="index.php?module=news&action=supprimer_news&id='.$news->id.'">Supprimer cette news</a>';
    }
	echo '</p></div>';
}
echo '</div>';

?>
<div style="clear: both;">&nbsp;</div>
</div>
