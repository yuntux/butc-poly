<?php
////////////////////////////////////////////////////////////////////////////////
//
//    Ce fichier fait partie intégrante du Système de Gestion des Polycopiés
//    Copyright (C) 2012 - Aurélien DUMAINE (<wwwetu.utc.fr/~adumaine/>).
//
//    This program is free software: you can redistribute it and/or modify
//    it under the terms of the GNU Affero General Public License as
//    published by the Free Software Foundation, either version 3 of the
//    License, or (at your option) any later version.
//
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU Affero General Public License for more details.
//
//    You should have received a copy of the GNU Affero General Public License
//    along with this program.  If not, see <http://www.gnu.org/licenses/>.
//
////////////////////////////////////////////////////////////////////////////////
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<title>BUTC Polys</title>
	<meta name="author" content="Aur&acute;lien DUMAINE">
	<meta name="description" content="TX P12 : paiement en ligne des polys &acute; l'UTC">
	<meta name="keywords" content="UTC, TX">
	<meta name="robots" content="ALL">
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta charset="utf-8">


    <link rel="stylesheet" href="https://demeter.utc.fr/pls/portal30/docs/PAGE/PORTLETREPOSITORY/OTHER_PROVIDERS/PORTAIL_SIGAM/CSS/COMMUN.CSS" type="text/css">
    <script type="text/javascript" src="https://demeter.utc.fr/pls/portal30/docs/PAGE/PORTLETREPOSITORY/OTHER_PROVIDERS/PORTAIL_SIGAM/JS/commun.js"></script>
    <link rel="stylesheet" href="style/footer.css" type="text/css">
	<link rel="shortcut icon" type="image/x-icon" href="https://ent.utc.fr/uPortal/favicon.ico"> 

</head>
<body>
	<div id="wrapper_outer">
		<div id="wrapper">
<?php
if (ENVIRONNEMENT_DEMO) {
	echo 'ENVIRONNEMENT DE DEMO ';

	echo '<a href="index.php?profil_demo=acheteur" >Profil acheteur</a> ';
	echo '<a href="index.php?profil_demo=enseignant">Profil enseignant</a> ';
	echo '<a href="index.php?profil_demo=imprimeur">Profil imprimeur</a> ';
	echo '<a href="index.php?profil_demo=vendeur">Profil vendeur</a> ';
	echo '<a href="index.php?profil_demo=regisseur">Profil régisseur</a> ';
	echo '<a href="index.php?profil_demo=admin">Profil admin</a>';
}
?>

<h1>BUTC - Vente en ligne des polycopiés</h1>

<div class="left">	
<form name="deco" action="index.php?module=utilisateur&action=deconnexion" method="post">
<?php echo 'UTILISATEUR : '.$_SESSION['login'].' BADGE NUMÉRO : '.$_SESSION['num_badge']; ?>
<input type="submit" name="changer_etudiant" value="Déconnexion" class="btn_annuler">
</form>
</div>

<div class="right">
      <b><i>Si vous rencontrez un problème technique sur le site :</i></b>
      <a class="image" href="mailto:5000@utc.fr">
        <img src="https://demeter.utc.fr/pls/portal30/docs/PAGE/PORTLETREPOSITORY/OTHER_PROVIDERS/PORTAIL_SIGAM/IMAGES/envoi_mail.gif" alt="Courriel hotline" title="Ecrire &agrave; la hotline">
      </a>
</div>
<br>
<div style="clear: both ;"></div>
<div id="menu">
  <ul>
	<?php
	if (isset($_SESSION['administrateur']) &&  $_SESSION['administrateur']==1) {
//		echo '<li><a href="index.php?module=utilisateur&action=utilisateur"'; if($_GET['module']=="utilisateur" && $_GET['action']=="utilisateur") echo ' class="current" '; echo '>Gestion des droits</a></li>';
		echo '<li><a href="index.php?module=statistique&action=statistique"'; if($_GET['module']=="statistique" && $_GET['action']=="statistique") echo ' class="current" '; echo '>Statistiques</a></li>';
//		echo '<li><a href="index.php?module=utilisateur&action=incoherence_paiement" class="current">Incohérences de paiement</a></li>';
//		echo '<li><a href="index.php?module=utilisateur&action=retrais_incoherents" class="current">Retraits supérieurs aux paiements/commandes</a></li>';
//		echo '<li><a href="index.php?module=utilisateur&action=payes_non_retires" class="current">Payés non retirés</a></li>';
	}
	if (isset($_SESSION['acheteur']) &&  $_SESSION['acheteur']==1) {
		echo '<li><a href="index.php?module=boutique_en_ligne&action=boutique_en_ligne"'; if($_GET['module']=="boutique_en_ligne" && $_GET['action']=="boutique_en_ligne") echo ' class="current" '; echo '>Acheter des poly</a></li>';
		echo '<li><a href="index.php?module=boutique_en_ligne&action=historique"'; if($_GET['module']=="boutique_en_ligne" && $_GET['action']=="hitorique") echo ' class="current" '; echo '>Historique</a></li>';
	}
	if (isset($_SESSION['vendeur']) &&  $_SESSION['vendeur']==1) {
		echo '<li><a href="index.php?module=boutique_comptoir&action=vendre_poly"' ; if($_GET['module']=="boutique_comptoir" && $_GET['action']=="vendre_poly") echo ' class="current" '; echo '>Vendre des polys</a></li>';
		echo '<li><a href="index.php?module=boutique_comptoir&action=retirer_poly"' ; if($_GET['module']=="boutique_comptoir" && $_GET['action']=="retirer_poly") echo ' class="current" '; echo '>Retirer des polys</a></li>';
	echo '<li><a href="index.php?module=boutique_comptoir&action=brouillard_caisse"' ; if($_GET['module']=="boutique_comptoir" && $_GET['action']=="brouillard_caisse") echo ' class="current" '; echo '>Brouillard de caisse</a></li>';
		echo '<li><a href="index.php?module=boutique_comptoir&action=formation_continue"' ; if($_GET['module']=="boutique_comptoir" && $_GET['action']=="formation_continue") echo ' class="current" '; echo '>Formation continue</a></li>';
	}

	if (isset($_SESSION['regisseur']) &&  $_SESSION['regisseur']==1) {
		echo '<li><a href="index.php?module=boutique_comptoir&action=export_compta"' ; if($_GET['module']=="boutique_comptoir" && $_GET['action']=="export_compta") echo ' class="current" '; echo '>Exports vers la comptabilité</a></li>';
	}


	if (isset($_SESSION['imprimeur']) &&  $_SESSION['imprimeur']==1) {
		echo '<li><a href="index.php?module=imprimerie&action=liste_impression"' ; if($_GET['module']=="imprimerie" && $_GET['action']=="liste_impression") echo ' class="current" '; echo '>Liste des impressions</a></li>';
		echo '<li><a href="index.php?module=imprimerie&action=liste_poly"' ; if($_GET['module']=="imprimerie" && $_GET['action']=="liste_poly") echo ' class="current" '; echo '>Liste des polys</a></li>';
	}
	?>
  </ul>
</div>
<div style="clear: both ;"></div>
