<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Design by Free CSS Templates
http://www.freecsstemplates.org
Released for free under a Creative Commons Attribution 2.5 License

Name       : EarthlingTwo  
Description: A two-column, fixed-width design with dark color scheme.
Version    : 1.0
Released   : 20090918
-->

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>BUTC Polys</title>
	<meta name="author" content="Aurélien DUMAINE">
	<meta name="description" content="TX P12 : paiement en ligne des polys à l'UTC">
	<meta name="keywords" content="UTC, TX">
	<meta name="language" content="fr">
	<meta name="revist-after" content="30 days">
	<meta name="robots" content="ALL">
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="style/tableaux.css" type="text/css">

    <link rel="stylesheet" href="https://demeter.utc.fr/pls/portal30/docs/PAGE/PORTLETREPOSITORY/OTHER_PROVIDERS/PORTAIL_SIGAM/CSS/COMMUN.CSS" type="text/css">
	<link rel="shortcut icon" type="image/x-icon" href="https://ent.utc.fr/uPortal/favicon.ico" /> 

    <script type="text/javascript" src="https://demeter.utc.fr/pls/portal30/docs/PAGE/PORTLETREPOSITORY/OTHER_PROVIDERS/PORTAIL_SIGAM/JS/commun.js"></script>  
    <script type="text/javascript">
<!-- javascript -->
	</script>

</head>
<body>

<h1>BUTC - Vente en ligne des polycopiés</h1>

<div class="left">	
<form name="deco" action="index.php?module=utilisateur&action=deconnexion" method="post">
<?php echo 'UTILISATEUR : '.$_SESSION['login']; ?>
<input type="submit" name="changer_etudiant" value="Déconnexion" class="btn_annuler">
</form>
</div>

<div class="right">
      <b><i>Si vous rencontrez un probl&egrave;me technique sur le site :</i></b>
      <a class="image" href="mailto:5000@utc.fr">
        <img src="https://demeter.utc.fr/pls/portal30/docs/PAGE/PORTLETREPOSITORY/OTHER_PROVIDERS/PORTAIL_SIGAM/IMAGES/envoi_mail.gif" alt="Courriel hotline" title="Ecrire &agrave; la hotline">
      </a>
</div>
<br>

<div id="menu">
  <ul>
	<?php
	if (isset($_SESSION['administrateur']) &&  $_SESSION['administrateur']==1) {
		echo '<li><a href="index.php?module=utilisateur&action=utilisateur"'; if($_GET['module']=="utilisateur" && $_GET['action']=="utilisateur") echo ' class="current" '; echo '>Gestion des droits</a></li>';
//		echo '<li><a href="index.php?module=utilisateur&action=incoherence_paiement" class="current">Incohérences de paiement</a></li>';
//		echo '<li><a href="index.php?module=utilisateur&action=retrais_incoherents" class="current">Retraits supérieurs aux paiements/commandes</a></li>';
//		echo '<li><a href="index.php?module=utilisateur&action=payes_non_retires" class="current">Payés non retirés</a></li>';
	}
	if (isset($_SESSION['acheteur']) &&  $_SESSION['acheteur']==1) {
		echo '<li><a href="index.php?module=boutique_en_ligne&action=boutique_en_ligne"'; if($_GET['module']=="boutique_en_ligne" && $_GET['action']=="boutique_en_ligne") echo ' class="current" '; echo '>Acheter des poly</a></li>';
		echo '<li><a href="index.php?module=boutique_en_ligne&action=historique"'; if($_GET['module']=="boutique_en_ligne" && $_GET['action']=="hitorique") echo ' class="current" '; echo '>Historique</a></li>';
//		echo '<li><a href="index.php?module=boutique_en_ligne&action=synthese">Synthèse achats</a></li>';
//		echo '<li><a href="index.php?module=boutique_en_ligne&action=liste_commandes">Commandes</a></li>';
//		echo '<li><a href="index.php?module=boutique_en_ligne&action=liste_paiements">Paiement</a></li>';
//		echo '<li><a href="index.php?module=boutique_en_ligne&action=liste_retraits">Retraits</a></li>';
	}
	if (isset($_SESSION['vendeur']) &&  $_SESSION['vendeur']==1) {
		echo '<li><a href="index.php?module=boutique_comptoir&action=vendre_poly"' ; if($_GET['module']=="boutique_comptoir" && $_GET['action']=="vendre_poly") echo ' class="current" '; echo '>Vendre des polys</a></li>';
		echo '<li><a href="index.php?module=boutique_comptoir&action=retirer_poly"' ; if($_GET['module']=="boutique_comptoir" && $_GET['action']=="retirer_poly") echo ' class="current" '; echo '>Retirer des polys</a></li>';
	echo '<li><a href="index.php?module=boutique_comptoir&action=brouillard_caisse"' ; if($_GET['module']=="boutique_comptoir" && $_GET['action']=="brouillard_caisse") echo ' class="current" '; echo '>Brouillard de caisse</a></li>';
		echo '<li><a href="index.php?module=boutique_comptoir&action=formation_continue"' ; if($_GET['module']=="boutique_comptoir" && $_GET['action']=="formation_continue") echo ' class="current" '; echo '>Formation continue</a></li>';
//		echo '<li><a href="index.php?module=boutique_comptoir&action=stock">Stocks</a></li>';
//		echo '<li><a href="index.php?module=boutique_comptoir&action=livraison_imprimeur">Livraisons imprimeur</a></li>';
//		echo '<li><a href="index.php?module=boutique_comptoir&action=vente_interne">Vente interne</a></li>';
//		echo '<li><a href="index.php?module=boutique_comptoir&action=brouillard_caisse">Brouillard de caisse</a></li>';
	}

	if (isset($_SESSION['regisseur']) &&  $_SESSION['regisseur']==1) {
		
		echo '<li><a href="index.php?module=boutique_comptoir&action=export_compta.php"' ; if($_GET['module']=="boutique_comptoir" && $_GET['action']=="export_compta") echo ' class="current" '; echo '>Exports vers la comptabilité</a></li>';
	}
	?>
  </ul>
</div>

