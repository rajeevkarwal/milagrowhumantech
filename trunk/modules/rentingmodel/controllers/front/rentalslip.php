<?php
//require(getcwd() . _MODULE_DIR_ . "rentingmodel/libFunctions.php");

session_start();
define('ADMIN_EMAIL','cs@milagrow.in');
define('ADMIN_NAME','MilagrowAdmin');
define('PAYMENT_URL','');//ccavenue url for payment;
define('WORKING_KEY','');//WORDKING KEY
define('_MERCHANT_ID', 'M_milagrow_6881');
define('_BILLING_PAGE_HEADING', 'Milagrow Humantech - Annual Maintenance Contract for %s');
class RentingmodelRentalSlipModuleFrontController extends ModuleFrontController
{
    public $display_column_left=true;
    public  function initContent()
    {
        parent::initContent();
      
       	$customer_info=$_SESSION;
       	//$Merchant_Id=_MERCHANT_ID;
       	$total=$_SESSION['security_deposited']+$_SESSION['monthly_rental'];
       	//$paymentNotificationUrl='renting-payment-notification';
       //	$WorkingKey=$key;
       //	 $Checksum = getChecksum($Merchant_Id, $_SESSION['customerId'], $total, $paymentNotificationUrl, $WorkingKey);
      	 $data1=$customer_info['data'];
        $this->context->smarty->assign(array(
        'customer'=>$data1,
        'productName'=>$this->getProductName($data1['product_id']),
        'categoryName'=>$this->getCategoryName($data1['category_id']),
        'total'=>$this->getTotal($data1['security_deposited'],$data1['monthly_rental']),
        'merchant_id'=>_MERCHANT_ID,
        'orderId'=>$_SESSION['customerId'],
        'billing_cust_name'=>$_SESSION['name'],
        'billing_cust_address'=>$_SESSION['address'],
        'billing_cust_country'=>'India',
        'billing_city'=>$data1['state'],
        'billing_zip'=>$_SESSION['pincode'],
        'billing_cust_tel'=>$_SESSION['contact_number'],
        'billing_cust_email'=>$_SESSION['email'],
        'billingPageHeading'=>'Loan Initial Payment',
        'amount'=>$_SESSION['security_deposited']+$_SESSION['monthly_rental'],
        ));
        $this->setTemplate('slip.tpl');
    }
    public function getTotal($val1,$val2)
    {
    	return $val1+$val2;
    }
    public function postProcess()
    {
    	$chequeValue=Tools::getValue('cheque');
    	if($chequeValue)
    	{			
    		    		$result=$this->updatePaymentMode($_SESSION['customerId']);
    		    		
    					if($result)
    					{
    						header('location:thanks');
    					}
    	}
    }
    private function sendMail()
    {
    try
	         {
	         //send mail to customer
    	        $customer=$_SESSION['data'];
	          	$id=$_SESSION['customerId'];
	            $subject='Payment Method Request for Application #'.$id.'--'.$customer['name'];
	            $template='customer_mail_after_payment_method';
            	if (!empty($customer['email']))
            	 {
                	 $res =Mail::Send(
             	   (int)1,
             	   $template,
             	   $subject,
            	    $data,
          	      $customer['email'],
          	      $customer['name'],
          	      null,
          	      null,
          	      '',
          	      null,
          	      getcwd() . _MODULE_DIR_ . RentingModel::MODULE_NAME . '/',
           	     false,
           	     null
            		);
           		 }
           		 //send Mail to Ciompany
	        	
	            $subject='Payment Method Rececived for Application #'.$id.'--'.$customer['name'].'By CHEQUE';
	            $template='company_mail_after_payment_method';
	            $title='ADMINISTARTOR';
	            $mailto=ADMIN_EMAIL;
            	if (!empty($mailto))
            	 {
                	 $res =Mail::Send(
             	   (int)1,
             	   $template,
             	   $subject,
            	    $data,
          	      $mailto,
          	      $title,
          	      null,
          	      null,
          	      '',
          	      null,
          	      getcwd() . _MODULE_DIR_ . RentingModel::MODULE_NAME . '/',
           	     false,
           	     null
            		);
            		//send mail to receivable departments
            		//$mailto='receivables@milagrow.in';
            		$res =Mail::Send(
             	   (int)1,
             	   $template,
             	   $subject,
            	    $data,
          	      $mailto,
          	      $title,
          	      null,
          	      null,
          	      '',
          	      null,
          	      getcwd() . _MODULE_DIR_ . RentingModel::MODULE_NAME . '/',
           	     false,
           	     null
            		);
            		//sending mail to outbond logistic
            		//$mailto='outboundlogistics@milagrow.in';
            		$res =Mail::Send(
             	   (int)1,
             	   $template,
             	   $subject,
            	    $data,
          	      $mailto,
          	      $title,
          	      null,
          	      null,
          	      '',
          	      null,
          	      getcwd() . _MODULE_DIR_ . RentingModel::MODULE_NAME . '/',
           	     false,
           	     null
            		);
           		 }
         return $res;
        }catch(Exception $e) {
			Tools::displayError();
        }
    }
    private function updatePaymentMode($rentId)
    {
    					$data['payment_mode']=0;
    					//$customer_id=$this->getCustomerId($email);
    					Db::getInstance()->update('rental_customer',$data,'rent_id='.$rentId);
    					if(Db::getInstance()->Affected_Rows()>=0)
    						return true;
    						else 
    						return false;
    }
    
    /*
    private function getCustomerId($byEmail)
    {
    	$sql="select customer_id from ps_rental_customer where email=".$byEmail;
    	$row=Db::getInstance()->getRow($sql);
    		return $row['customer_id'];
    }
    */
    private function getProductName($id)
    {
    	$sql="select name from ps_product_lang where id_product=".$id;
    	$row=Db::getInstance()->getRow($sql);
    	if($row)
    		return $row['name'];
    		else
    		return false;
    }
    private function getCategoryName($id)
    {
    	$sql="select name from ps_category_lang where id_category=".$id;
    	$row=Db::getInstance()->getRow($sql);
    	if($row)
    		return $row['name'];
    		else
    		return false;
    }
	
}
?>