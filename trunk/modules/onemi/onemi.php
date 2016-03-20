<?php
if (!defined('_CAN_LOAD_FILES_'))
	exit;
	
class Onemi extends PaymentModule
{
	private	$_html = '';
	private $_postErrors = array();
	private $_responseReasonText = null;

	public function __construct(){
		$this->name = 'onemi';
		$this->tab = 'payments_gateways';
		$this->version = '3';
		$this->author = 'Onemi Development Team';
        parent::__construct();
		$this->page = basename(__FILE__, '.php');
        $this->displayName = $this->l('OneEMI&reg;');
        $this->description = $this->l('Module for accepting payments by Onemi');
	}
	
	public function getOnemiUrl(){
		$mod = Configuration::get('MODE');		
		if(!empty($mod)){ 
			if($mod=='TEST'){
				return 'http://test.onemi.in/pg/PaySub.aspx';
			}
			if($mod=='LIVE'){
				return 'http://onemi.in/Pg/PaySub.aspx';
			}
		}
		
	}
	
	public function install(){
		if(parent::install()){
			Configuration::updateValue('merchantid', '');
			Configuration::updateValue('merchantpasscode', '');
			Configuration::updateValue('MODE', '');
			$this->registerHook('payment');
			$this->registerHook('PaymentReturn');
			$this->registerHook('ShoppingCartExtra');
			if(!Configuration::get('Onemi_ORDER_STATE')){
				$this->setOnemiOrderState('Onemi_ID_ORDER_SUCCESS','Payment Received','#b5eaaa');
				$this->setOnemiOrderState('Onemi_ID_ORDER_FAILED','Payment Failed','#E77471');
				$this->setOnemiOrderState('Onemi_ID_ORDER_PENDING','Payment Pending','#F4E6C9');			
				Configuration::updateValue('Onemi_ORDER_STATE', '1');
			}		
			return true;
		}
		else {
			return false;
		}
	}
	
	public function uninstall(){
		if (!Configuration::deleteByName('merchantid') OR 
			!Configuration::deleteByName('merchantpasscode') OR 
			!Configuration::deleteByName('MODE') OR 
			!parent::uninstall()){
				return false;
		}	
		return true;
	}
	
	public function setOnemiOrderState($var_name,$status,$color){
		$orderState = new OrderState();
		$orderState->name = array();
		foreach(Language::getLanguages() AS $language){
			$orderState->name[$language['id_lang']] = $status;
		}
		$orderState->send_email = false;
		$orderState->color = $color;
		$orderState->hidden = false;
		$orderState->delivery = false;
		$orderState->logable = true;
		$orderState->invoice = true;
		if ($orderState->add())
			Configuration::updateValue($var_name, (int)$orderState->id);
		return true;
	}
	
	public function getContent(){
		$this->_html = '<h2>'.$this->displayName.'</h2>';
		if (isset($_POST['submitOnemi'])){
			if (empty($_POST['merchantid']))
				$this->_postErrors[] = $this->l('Please Enter the Merchant ID.');
			if (empty($_POST['merchantpasscode']))
				$this->_postErrors[] = $this->l('Please Enter the Merchant Passcode.');
			if (empty($_POST['accesskey']))
				$this->_postErrors[] = $this->l('Please Enter the Access Key.');
			if (empty($_POST['secretkey']))
				$this->_postErrors[] = $this->l('Please Enter the Secret Key.');
			if (empty($_POST['mode']))
				$this->_postErrors[] = $this->l('Please Select the Mode.');
			if (!sizeof($this->_postErrors)){
				Configuration::updateValue('merchantid', $_POST['merchantid']);
				Configuration::updateValue('merchantpasscode', $_POST['merchantpasscode']);
				Configuration::updateValue('secretkey', $_POST['secretkey']);
				Configuration::updateValue('accesskey', $_POST['accesskey']);
				Configuration::updateValue('promoCode', $_POST['promoCode']);
				Configuration::updateValue('MODE', $_POST['mode']);
				$this->displayConf();
			}
			else{
				$this->displayErrors();
			}
		}
		$this->_displayOnemi();
		$this->_displayFormSettings();
		return $this->_html;
	}
	
	public function displayConf(){
		$this->_html .= '
		<div class="conf confirm">
			<img src="../img/admin/ok.gif" alt="'.$this->l('Confirmation').'" />
			'.$this->l('Settings updated').'
		</div>';
	}
	
	public function displayErrors(){
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
	
	public function _displayOnemi(){
		$this->_html .= '
		<img src="../modules/onemi/logo_onemi.png" style="float:left; padding: 0px; margin-right:15px;" />
		<b>'.$this->l('This module allows you to accept payments by Onemi.').'</b><br /><br />
		'.$this->l('If the client chooses this payment mode, your Onemi account will be automatically credited.').'<br />
		'.$this->l('You need to configure your Onemi account first before using this module.').'
		<br /><br /><br />';
	}
	
	public function _displayFormSettings(){
		$mod = Configuration::get('MODE');
		$acc_id = Configuration::get('merchantid');
		$sec_key = Configuration::get('merchantpasscode');
		$secretkey = Configuration::get('secretkey');
		$accesskey = Configuration::get('accesskey');
		$promoCode = Configuration::get('promoCode');
		if(!empty($acc_id)){ $merchantid = $acc_id; } else { $merchantid = ''; }
		if(!empty($sec_key)){ $merchantpasscode = $sec_key; } else { $merchantpasscode = ''; }
		if(!empty($mod)){ 
			if($mod=='TEST'){
				$test_attr = "selected='selected'";
				$live_attr = '';
			}
			if($mod=='LIVE'){
				$live_attr = "selected='selected'";
				$test_attr = '';
			}
		}
		else{
			$live_attr = '';
			$test_attr = '';
		}
		$this->_html .= '
		<form action="'.$_SERVER['REQUEST_URI'].'" method="post">
			<fieldset>
			<legend><img src="../img/admin/contact.gif" />'.$this->l('Configuration Settings').'</legend>
				<table border="0" width="500" cellpadding="0" cellspacing="0" id="form">
					<tr><td colspan="2">'.$this->l('Please specify the Account ID and Secret Key to which Merchant must send their onemi.').'<br /><br /></td></tr>
					<tr><td width="130" style="height: 25px;">'.$this->l('Account ID').'</td><td><input type="text" name="merchantid" value="'.$merchantid.'" style="width: 150px;" /></td></tr>
					<tr>
						<td width="130" style="height: 25px;">'.$this->l('Merchant Passcode').'</td>
						<td><input type="text" name="merchantpasscode" value="'.$merchantpasscode.'" style="width: 150px;" /></td>
					</tr>
					<tr>
						<td width="130" style="height: 25px;">'.$this->l('Secret Key').'</td>
						<td><input type="text" name="secretkey" value="'.$secretkey.'" style="width: 150px;" /></td>
					</tr>
					<tr>
						<td width="130" style="height: 25px;">'.$this->l('Access Key').'</td>
						<td><input type="text" name="accesskey" value="'.$accesskey.'" style="width: 150px;" /></td>
					</tr>
					<tr>
						<td width="130" style="height: 25px;">'.$this->l('PromoCode').'</td>
						<td><input type="text" name="promoCode" value="'.$promoCode.'" style="width: 150px;" /></td>
					</tr>
					<tr>
						<td width="130" style="height: 25px;">'.$this->l('Mode').'</td>
						<td>
							<select name="mode" style="width: 100px;">
								<option value="">-Select-</option>
								<option value="TEST" '.$test_attr.'>TEST</option>
								<option value="LIVE" '.$live_attr.'>LIVE</option>
							</select>
						</td>
					</tr>
                   
					<tr><td colspan="2" align="center"><br /><input class="button" name="submitOnemi" value="'.$this->l('Update settings').'" type="submit" /></td></tr>
				</table>
			</fieldset>
		</form>
		';
	}
	
	public function hookPayment($params){
		global $smarty;
		$smarty->assign(array(
	        'this_path' 		=> $this->_path,
	        'this_path_ssl' 	=> Configuration::get('PS_FO_PROTOCOL').$_SERVER['HTTP_HOST'].__PS_BASE_URI__."modules/{$this->name}/"));
	
		return $this->display(__FILE__, 'payment.tpl');
    }
	
	public function execPayment($cart){
		global $smarty,$cart;      
        
		$bill_address = new Address(intval($cart->id_address_invoice));
		$ship_address = new Address(intval($cart->id_address_delivery));
//		$bc = new Country($bill_address->id_country);
//		$sc = new Country($ship_address->id_country);
		$customer = new Customer(intval($cart->id_customer));
		
		$merchantid= Configuration::get('merchantid');
		$merchantpasscode = Configuration::get('merchantpasscode');		
//		$mode = Configuration::get('MODE');
		$PromoCode = Configuration::get('promoCode');
//		$id_currency = intval(Configuration::get('PS_CURRENCY_DEFAULT'));
        $currency = 'INR';
		$first_name = $bill_address->firstname;
		$last_name = $bill_address->lastname;
		$name = $first_name." ".$last_name;
		$phone = $bill_address->phone_mobile;
		$email = $customer->email;			
        $return_url = urldecode(Context::getContext()->link->getModuleLink('onemi', 'response'));		
		if (!Validate::isLoadedObject($bill_address) OR !Validate::isLoadedObject($customer))
			return $this->l('Onemi error: (invalid address or customer)');
		
		$amount = $cart->getOrderTotal(true,Cart::BOTH);
//		$ref_no = intval($cart->id);

		$reference_no = intval($cart->id);
//		$description = "Order ID is ".$reference_no;
//        $channel = 0;
        $udf1=$udf2=$udf3=$udf4=$udf5=0;
		//set_include_path(_PS_ROOT_DIR_.'modules/onemi/lib'.PATH_SEPARATOR);
		
			/****** New Code ****/
			$accesskey = Configuration::get('accesskey');
            $secretkey = Configuration::get('secretkey');
			set_include_path(_PS_ROOT_DIR_.'/modules/onemi/lib'.PATH_SEPARATOR);
			require_once 'lib/Zend/Crypt/Hmac.php';
			$MerTranId = time();
			$data="loginacceskey=".$accesskey."&transactionid=".$MerTranId."&amount=".round($amount,2);
			$securitySignature = Zend_Crypt_Hmac::compute($secretkey,"sha1", $data);
			/****** New Ends Here **************/
          $smarty->assign(array(
                'MerchantId' => $merchantid,
                'MerchantPass' => $merchantpasscode,
                'MerOrdRefNo' => $reference_no,
                'TranCur' => 'INR',
                'Amt' => round($amount,2),
                'Cname' => $name,
                'EmailId' => $email,
                'Mobile' => $phone,
                'ResponseUrl' => $return_url,
                'MerTranId' => $MerTranId,
                'PromoCode' => $PromoCode,
                'udf1' => $udf1,
                'udf2' => $udf2,
                'udf3' => $udf3,
                'udf4' => $udf4,
                'udf5' => $udf5,				
                'total' => number_format(Tools::convertPrice($cart->getOrderTotal(true, 3), $currency), 2, '.', ''),
			    'onemiurl' => $this->getOnemiUrl(),
                'Signature' => $securitySignature,                    
			));	
				
		return $this->display(__FILE__, 'payment_execution.tpl');
    }
}
?>
