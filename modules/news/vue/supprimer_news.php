<div id="content">

<?php
echo '<div class="post">
<h2 class="title">Suppression de la news numéro '.$news->id.'</h2>
<div class="entry">
<br>
<form name="modif_trajet" action="index.php?module=news&action=supprimer_news&id='.$_GET['id'].'" method="post">
Vous etes sur le point de suppimer le trajet numéro '.$news->id.'
<br><br><center><input type="submit" name="valider" value="OK"/></center>
</form>';
?>
</div></div>
<div style="clear: both;">&nbsp;</div>
</div>
