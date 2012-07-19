<?php
$date = date("d-m-Y");
$heure = date("H:i");
$monfichier = fopen('logs_paybox.txt', 'a+');
$monUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 
fputs($monfichier, '___'.$date.'::'.$heure.'::'.$monUrl.'___\n'); // On écrit le nouveau nombre de pages vues
fclose($monfichier);
//echo 'test';
?>
