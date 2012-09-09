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
<?php
$date = date("d-m-Y");
$heure = date("H:i");
$monUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$ref_paybox = $_GET['ref'];
$montant_paybox = $_GET['montant'];
$errors = '';
$unauthorized_server = true;
$pbk_ok = false;
$sign_ok = false;


//LOG DE LA REQUETTE
$monfichier = fopen('logs_paybox.txt', 'a+');
fputs($monfichier, '___'.$date.'::'.$heure.'::'.$monUrl.' \n'); // On écrit le nouveau nombre de pages vues
fclose($monfichier);


//ip verification when using url http
if($monUrl){
	$authorized_ips = array('195.101.99.76','194.2.122.158','62.39.109.166','194.50.38.6');
	foreach ($authorized_ips as $authorized_ip) 
	{
		if ($_SERVER['REMOTE_ADDR'] == $authorized_ip) {
			$unauthorized_server = false;
			break;
		}
	}
	if($unauthorized_server)
		$errors.='Unauthorized server : '.$_SERVER['REMOTE_ADDR'];
}


if(!$unauthorized_server) {
	include('../modules/boutique_en_ligne/modele/boutique_en_ligne.php');
	include('../../global/init.php');

	$montant_commande = montant_commande($ref_paybox)->fetch(); 
	//SI LE SERVEUR AYANT ENVOYÉ L'URI ET LE MONTANT SONT OK ON ENREGISTRE LE PAIEMENT VALDIE
	if ($montant_commande->montant_commande*100 == $montant_paybox) //montant de retour paybox exprimé en centimes
		enregistrer_paiement($ref_paybox, 'PAYBOX', '', $_SERVER['REQUEST_URI']);	
	//SI LE SERVEUR AYANT ENVOYÉ L'URI MAIS MAUVAIS MONTANT ON ENREGISTRE LE PAIEMENT en invalide
	else
		enregistrer_paiement($ref_paybox, '', '', $_SERVER['REQUEST_URI']);	
}

/*include('/var/www/code/libs/fonctions-paybox.php');
echo PbxVerSign( $_POST['signeddata'], 'pubkey.pem', monUrl);


	//sign verification
//	$fp = fopen('pubkey.pem', 'r');
	$public_key = LoadKey('pubkey.pem');
//	fclose($fp);

/*	
	if($monUrl)
		$vars = $_POST;
	else
		$vars = $_GET;
		
		foreach ($vars as $key => $val) 
		{
			if ($key == 'sign') $pbx_sign = $val;
				else $pbx_retour .= '&' . $key . '=' . $val;
		}
		$pbx_retour = substr($pbx_retour, 1);
		echo $pbx_retour;
		$pbx_sign = base64_decode($pbx_sign);
		$ossl_public_key = openssl_pkey_get_public($public_key);

while ($msg = openssl_error_string()) echo $msg . "<br />\n";


		if (openssl_verify($pbx_retour, $pbx_sign, $ossl_public_key) != 1) {
			$sign_ok = false;
			$errors.=$paybox->getError('sign_ko');
		}
		else{
			$sign_ok = true;
		}


	//transaction result
$f = fopen('logs_verif.txt', 'a+'); 
if($sign_ok)
	fputs($f, "VERIF :  OK");
else
	fputs($f, "VERIF :  KO");
fclose($f);


	$pbx_error = $vars['pbx_error'];
	
	switch($pbx_error)
	{
		case '00000':
			$pbx_ok = true;
			break;
		default:
			$errors.= $paybox->getError($pbx_error);s
			break;
	}
*/
?>
