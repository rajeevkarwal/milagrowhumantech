<?php
require(getcwd() . _MODULE_DIR_ . "rentingmodel/libFunctions.php");
define('_SMS_URL', 'https://control.msg91.com/sendhttp.php');
define('_WORKING_KEY', 'f6srdljv9krmyof389tjdixf86bgmc55');
define('_SMS_USERNAME', '56096');
define('_SMS_PASSWORD', 'milagrowHelpdesk');
define('_SMS_SENDERID', 'MLGROW');
session_start();
#define('ADMIN_EMAIL','kishor.pant@milagrow.in');
define('ADMIN_EMAIL','cs@milagrow.in');
define('ADMIN_NAME','MilagrowAdmin');
define('PAYMENT_URL','');//ccavenue url for payment;
define('WORKING_KEY','');//WORDKING KEY
define('_MERCHANT_ID', 'M_milagrow_6881');
define('_BILLING_PAGE_HEADING', 'Milagrow Humantech - FOR PRODUCT RENTAL %s');
class RentingmodelPaynowModuleFrontController extends ModuleFrontController
{
    public $display_column_left=true;
    public  function initContent()
    {
        	parent::initContent();
        	$result=$_SESSION['data'];
        	$rent_id=$_SESSION['customerId'];	
        	$this->updatePaymentStatus($rent_id);
        	$paymentNotificationUrl='http://'.$_SESSION['server_name'];
        	$paymentNotificationUrl .= '/online-rental-payment-notification';
                    //take user to the payment gateway screen for some down payment
                    $Merchant_Id = _MERCHANT_ID; //This id(also User_Id)  available at "Generate Working Key" of "Settings & Options"

                    $Amount = floatval($result['security_deposited']+$result['monthly_rental']); //your script should substitute the amount here in the quotes provided here
					$orderId='MILAGROW1_'.$_SESSION['customerId'];
                    $WorkingKey = "f6srdljv9krmyof389tjdixf86bgmc55"; //put in the 32 bit alphanumeric key in the quotes provided here.Please note that get this key login to your
                    $Checksum = getChecksum($Merchant_Id, $orderId, $Amount, $paymentNotificationUrl, $WorkingKey);
					
                    $this->context->smarty->assign(array(
                        'merchant_id' => _MERCHANT_ID,
                        'amount' => $Amount,
                        'redirectLink' => $paymentNotificationUrl,
                        'orderId' =>$orderId,
                        'delivery_cust_name' => $result['name'],
                        'delivery_cust_address' => $result['address'],
                        'delivery_cust_country' => '',
                        'delivery_cust_state' => '',
                        'delivery_city' => '',
                        'delivery_zip' => '',
                        'delivery_cust_tel' => $result['contact_number'],
                        'delivery_cust_email' => $result['email'],
                        'billing_cust_name' => $result['name'],
                        'billing_cust_address' => $result['address'],
                        'billing_cust_country' => 'India',
                        'billing_cust_state' => '',
                        'billing_city' => '',
                        'billing_zip' => '',
                        'billing_cust_tel' => $result['contact_number'],
                        'billing_cust_email' => $result['email'],
                        'billingPageHeading' => $billingPageHeading,
                        'delivery_cust_notes' => "",
                        'checksum' => $Checksum,
                        'request_url' => _PS_BASE_URL_ . __PS_BASE_URI__,
                        'HOOK_PAYMENT' => Hook::exec('displayPayment')
                    ));
        		
				$this->setTemplate('paynow.tpl');
			
				
    }
    private function updatePaymentStatus($rent_id)
    {
    	$data=array('payment_mode'=>1);
    	Db::getInstance()->update('rental_customer',$data,'rent_id='.$rent_id);
    	if(Db::getInstance()->Affected_Rows())
    		return true;
    	else
    		return false;
    }
   
    
}
?>