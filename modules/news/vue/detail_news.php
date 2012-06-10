<div id="content">
<?php
$news = $detail_news->fetch();
echo '<div class="post">
<h2 class="title">'.$news->titre.'</h2>
<div class="entry">
<p>'.$news->texte.'</p>

<br>
<p>publié le '.datefr($news->date).' par <a href="mailto:'.$news->email.'">'.$news->prenom.' '.$news->nom.'</a></p>';

if ($_SESSION['administrateur'] == 1) {
        echo '<p><a href="index.php?module=news&action=modifier_news&id='.$news->id.'">Modifier cette news</a>';
        echo ' <a href="index.php?module=news&action=supprimer_news&id='.$news->id.'">Supprimer cette news</a></p>';
 
}
?>
</div></div>
<div style="clear: both;">&nbsp;</div>
</div>
