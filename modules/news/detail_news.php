<?php

	include_once CHEMIN_MODELE.'news.php';
	$detail_news = detail_news($_GET['id']);
	include 'vue/detail_news.php';

?>
