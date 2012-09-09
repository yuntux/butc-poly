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

include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/paybox.php');

$errors = '';
$unauthorized_server = true;
$pbk_ok = false;
$sign_ok = false;
$paybox = new Paybox();
$url_http = $paybox->isUrlHttp();

//ip verification when using url http
if($url_http){

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
//if we use url_http, it has to be un authorized server
//if(($url_http AND !$unauthorized_server) OR (!$url_http))
	//sign verification
	$fp = fopen('pubkey.pem', 'r');
	$public_key = fread($fp, 8192);
	fclose($fp);
	
	
	if($url_http)
		$vars = $_POST;
	else
		$vars = $_GET;
		
		foreach ($vars as $key => $val) 
		{
			if ($key == 'pbx_sign') $pbx_sign = $val;
				else $pbx_retour .= '&' . $key . '=' . $val;
		}
		$pbx_retour = substr($pbx_retour, 1);
		echo $pbx_retour;
		$pbx_sign = base64_decode($pbx_sign);
		$ossl_public_key = openssl_pkey_get_public($public_key);

		if (openssl_verify($pbx_retour, $pbx_sign, $ossl_public_key) != 1) {
			$sign_ok = false;
			$errors.=$paybox->getError('sign_ko');
		}
		else{
			$sign_ok = true;
		}

	//transaction result	
	
	$pbx_error = $vars['pbx_error'];
	
	switch($pbx_error)
	{
		case '00000':
			$pbx_ok = true;
			break;
		default:
			$errors.= $paybox->getError($pbx_error);
			break;
	}

if(isset($vars['ref']))
{
  //ref is compose like id_cart;payment_date
	list($id,$payment_type,$payment_date) = split(';',$vars['ref'],3);
	
	if($pbx_ok AND $sign_ok AND empty($errors))
	{
		$total = floatval(number_format($vars['pbx_amount'], 2, '.', ''))/100;	
		switch($payment_type)
    {
      //Cart Payment
      case 'CP':
        $paybox->validateOrder($id, _PS_OS_PAYMENT_, $total, $paybox->displayName, 'PAYBOX : auto : '.$vars['pbx_auth'].' - trans : '.$vars['pbx_trans'].'<br />');
        //redirect to confirmation
		    if(!$url_http)
			   Tools::redirectLink(__PS_BASE_URI__.'history.php');
			   break;
      //Payment demand
      case 'PD':
        //$paybox->validatePaymentDemand($id,$total);
        Tools::redirectLink(__PS_BASE_URI__);
        break;
      default:
        Tools::redirectLink(__PS_BASE_URI__);
        break;
    }
			
		
	}
	
	else
	{	
	   //we don't validate order if there is a problem during payment
		//$paybox->validateOrder(intval($vars['ref']), _PS_OS_ERROR_, 0, $paybox->displayName, $errors.'<br />');
		//redirect to confirmation
		if(!$url_http)
			Tools::redirectLink(__PS_BASE_URI__.'order.php');
	}
}

?>
