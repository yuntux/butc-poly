<?php
$date = date("d-m-Y");
$heure = date("H:i");
$monfichier = fopen('logs_paybox.txt', 'a+');
$monUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$errors = '';
$unauthorized_server = true;
$pbk_ok = false;
$sign_ok = false;
fputs($monfichier, '___'.$date.'::'.$heure.'::'.$monUrl.' \n'); // On écrit le nouveau nombre de pages vues
fclose($monfichier);

/*
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
*/

include('/var/www/code/libs/fonctions-paybox.php');
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
*/

	//transaction result
$f = fopen('logs_verif.txt', 'a+'); 
if($sign_ok)
	fputs($f, "VERIF :  OK");
else
	fputs($f, "VERIF :  KO");
fclose($f);

/*
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
