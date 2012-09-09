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
/*
  Paybox module allow to accept CB payment via Paybox
  v0.3 :  change payment identification and payment type
  v0.2 :  delete order validation when payment was incorrect
          change redirection after payment
  v0.1 :  first release 
  
  Info :
    Test card : 1111222233334444
  
*/
class Paybox extends PaymentModule
{
	private	$_html = '';
	private $_postErrors = array();

	
	public function __construct()
	{
		$this->name = 'paybox';
		$this->tab = 'Payment';
		$this->version = '0.3';
		
		$this->currencies = true;
		$this->currencies_mode = 'radio';

        parent::__construct();

        /* The parent construct is required for translations */
		$this->page = basename(__FILE__, '.php');
        $this->displayName = $this->l('Credit card with PayBox');
        $this->description = $this->l('Accepts payments by PayBox');
		$this->confirmUninstall = $this->l('Are you sure you want to delete your details ?');
		
	}

	public function isUrlHttp()
	{
		return Configuration::get('PAYBOX_URLHTTP');
	}
	public function install()
	{
		if (!parent::install() OR !Configuration::updateValue('PAYBOX_SITE', '1999888') 
			OR !Configuration::updateValue('PAYBOX_RANG', '98')
			OR !Configuration::updateValue('PAYBOX_IDENTIFIANT', '3')
			OR !Configuration::updateValue('PAYBOX_URLHTTP', '0')
			OR !$this->registerHook('payment'))
			return false;
		return true;
	}

	public function uninstall()
	{
		if (!Configuration::deleteByName('PAYBOX_SITE') 
			OR !Configuration::deleteByName('PAYBOX_RANG')
			OR !Configuration::deleteByName('PAYBOX_IDENTIFIANT')
			OR !Configuration::deleteByName('PAYBOX_URLHTTP')
			OR !parent::uninstall())
			return false;
		return true;
	}

	public function getContent()
	{
		$this->_html = '<h2>Paybox</h2>';
		if (isset($_POST['submitPaybox']))
		{
			if (empty($_POST['pbx_site']))
				$this->_postErrors[] = $this->l('Paybox site required');
			if (empty($_POST['pbx_rang']))
				$this->_postErrors[] = $this->l('Paybox rang required');
			if (empty($_POST['pbx_identifiant']))
				$this->_postErrors[] = $this->l('Paybox identifiant required');
			if (empty($_POST['pbx_urlhttp']))
				$_POST['pbx_urlhttp'] = 0;
				
			if (!sizeof($this->_postErrors))
			{
				Configuration::updateValue('PAYBOX_SITE',$_POST['pbx_site'] ) ;
				Configuration::updateValue('PAYBOX_RANG', $_POST['pbx_rang']);
				Configuration::updateValue('PAYBOX_IDENTIFIANT', $_POST['pbx_identifiant']);
				Configuration::updateValue('PAYBOX_URLHTTP', $_POST['pbx_urlhttp']);
				$this->displayConf();
			}
			else
				$this->displayErrors();
		}

		$this->displayPaybox();
		$this->displayFormSettings();
		return $this->_html;
	}

	public function displayConf()
	{
		$this->_html .= '
		<div class="conf confirm">
			<img src="../img/admin/ok.gif" alt="'.$this->l('Confirmation').'" />
			'.$this->l('Settings updated').'
		</div>';
	}

	public function displayErrors()
	{
		$nbErrors = sizeof($this->_postErrors);
		$this->_html .= '
		<div class="alert error">
			<h3>'.($nbErrors > 1 ? $this->l('There are') : $this->l('There is')).' '.$nbErrors.' '.($nbErrors > 1 ? $this->l('errors') : $this->l('error')).'</h3>
			<ol>';
		foreach ($this->_postErrors AS $error)
			$this->_html .= '<li>'.$error.'</li>';
		$this->_html .= '
			</ol>
		</div>';
	}
	
	
	public function displayPaybox()
	{
		$this->_html .= '
		<img src="../modules/paybox/paybox.jpg" style="float:left; margin-right:15px;" />
		<b>'.$this->l('This module allows you to accept payments by Paybox.').'</b><br /><br />
		<br /><br /><br />';
	}

	public function displayFormSettings()
	{
		$conf = Configuration::getMultiple(array('PAYBOX_SITE', 'PAYBOX_RANG', 'PAYBOX_IDENTIFIANT','PAYBOX_URLHTTP'));
		$pbx_site = array_key_exists('pbx_site', $_POST) ? $_POST['pbx_site'] : (array_key_exists('PAYBOX_SITE', $conf) ? $conf['PAYBOX_SITE'] : '');
		$pbx_rang = array_key_exists('pbx_rang', $_POST) ? $_POST['pbx_rang'] : (array_key_exists('PAYBOX_RANG', $conf) ? $conf['PAYBOX_RANG'] : '');
		$pbx_identifiant = array_key_exists('pbx_identifiant', $_POST) ? $_POST['pbx_identifiant'] : (array_key_exists('PAYBOX_IDENTIFIANT', $conf) ? $conf['PAYBOX_IDENTIFIANT'] : '');
		$pbx_urlhttp = array_key_exists('pbx_urlhttp', $_POST) ? $_POST['pbx_urlhttp'] : (array_key_exists('PAYBOX_URLHTTP', $conf) ? $conf['PAYBOX_URLHTTP'] : '');
		

		$this->_html .= '
		<form action="'.$_SERVER['REQUEST_URI'].'" method="post">
		<fieldset>
			<legend><img src="../img/admin/contact.gif" />'.$this->l('Settings').'</legend>
			<label>'.$this->l('Paybox site value').'</label>
			<div class="margin-form"><input type="text" size="33" name="pbx_site" value="'.htmlentities($pbx_site, ENT_COMPAT, 'UTF-8').'" /></div>
			<label>'.$this->l('Paybox rang value').'</label>
			<div class="margin-form"><input type="text" size="33" name="pbx_rang" value="'.htmlentities($pbx_rang, ENT_COMPAT, 'UTF-8').'" /></div>
			<label>'.$this->l('Paybox identifiant value').'</label>
			<div class="margin-form"><input type="text" size="33" name="pbx_identifiant" value="'.htmlentities($pbx_identifiant, ENT_COMPAT, 'UTF-8').'" /></div>
			<label>'.$this->l('Url http mode').'</label>
			<div class="margin-form">
				<input type="radio" name="pbx_urlhttp" value="1" '.($pbx_urlhttp ? 'checked="checked"' : '').' /> '.$this->l('Yes').'
				<input type="radio" name="pbx_urlhttp" value="0" '.(!$pbx_urlhttp ? 'checked="checked"' : '').' /> '.$this->l('No').'
			</div>
			<br /><center><input type="submit" name="submitPaybox" value="'.$this->l('Update settings').'" class="button" /></center>
		</fieldset>
		</form><br /><br />
		<fieldset class="width3">
			<legend><img src="../img/admin/warning.gif" />'.$this->l('Information').'</legend>
			'.$this->l('Paybox warning information').'<br /><br />
		</fieldset>';
	}

	public function hookPayment($params)
	{
		global $smarty;

		$customer = new Customer(intval($params['cart']->id_customer));
		$pbx_site = Configuration::get('PAYBOX_SITE');
		$pbx_rang = Configuration::get('PAYBOX_RANG');
		$pbx_identifiant = Configuration::get('PAYBOX_IDENTIFIANT');
		$pbx_urlhttp = Configuration::get('PAYBOX_URLHTTP');
		//P = Cart Payment
		//PD = Payment Demand
    $payment_type = 'CP';
		$order_total = number_format($params['cart']->getOrderTotal(true, 3), 2,'', '');
		
    //payment id is composed with cart number and 
    $id_payment=$params['cart']->id.';'.$payment_type.';'.date('d-m-y-H:i:s');
    
		$pbx_currency = "978";
		//fix currency code for paybox
		
		/*if($currency=="EUR"){$pbx_currency = 978;}
		if($currency=="USD"){$pbx_currency = 840;}
		if($currency=="CHF"){$pbx_currency = 4217;}
		*/
		
		
		
		$smarty->assign(array(
			'pbx_site' => $pbx_site,
			'pbx_rang' => $pbx_rang,
			'pbx_identifiant' => $pbx_identifiant,
			'pbx_currency' => $pbx_currency,
			'id_payment' => $id_payment,
			'order_total' => $order_total,
			'pbx_urlhttp' =>$pbx_urlhttp,
			'customer' => $customer,
			'url_ok' => $pbx_urlhttp ? 'http://'.htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8').__PS_BASE_URI__.'history.php' : 'http://'.htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8').__PS_BASE_URI__.'modules/paybox/validation.php',
			'url_cancel' => 'http://'.htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8').__PS_BASE_URI__.'order.php',
			'return_format' => 'pbx_amount:M;ref:R;pbx_auth:A;pbx_trans:T;pbx_error:E;pbx_sign:K',
			'url_ko' => $pbx_urlhttp ? 'http://'.htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8').__PS_BASE_URI__.'order.php' : 'http://'.htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8').__PS_BASE_URI__.'modules/paybox/validation.php'
		));

		return $this->display(__FILE__, 'paybox.tpl');
    }
	
	function getError($pbx_error)
	{
		return 'Error : '.$pbx_error;
	}
}

?>
