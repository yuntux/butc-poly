<?php

	include_once CHEMIN_MODELE.'news.php';
	$liste_toutes_news = liste_toutes_news();
	include 'vue/liste_news.php';

?>
