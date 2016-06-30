<?php 

include_once(dirname(__FILE__) . '/../../../../config/config.inc.php');
include_once(dirname(__FILE__) . '/../../../../init.php');
require(getcwd() . _MODULE_DIR_ . "rentingmodel/libFunctions.php");
class RentingModelPaymentNotificationModuleFrontController extends ModuleFrontController
{
		
    public $display_column_left=true;
		public function initContent()
		{
		
		}
		 public function postProcess()
   		 {
   		 try{
        //$WorkingKey = _WORKING_KEY; //put in the 32 bit working key in the quotes provided here
        $card_number = '';
        $card_expiration = '';
        $card_holder = '';
        $MerchantId = isset($_REQUEST["Merchant_Id"]) ? $_REQUEST["Merchant_Id"] : '';
        $OrderId = isset($_REQUEST["Order_Id"]) ? $_REQUEST["Order_Id"] : '';
        $Amount = isset($_REQUEST["Amount"]) ? $_REQUEST["Amount"] : '';
        $AuthDesc = isset($_REQUEST["AuthDesc"]) ? $_REQUEST["AuthDesc"] : '';
        $avnChecksum = isset($_REQUEST["Checksum"]) ? $_REQUEST["Checksum"] : '';
        $nb_order_no = isset($_REQUEST["nb_order_no"]) ? $_REQUEST['nb_order_no'] : '';
        if (empty($MerchantId) || empty($OrderId) || empty($Amount) || empty($AuthDesc) || empty($avnChecksum) || empty($nb_order_no))
            $this->setTemplate('illegal_access.tpl');
        else {
            $Checksum = verifyChecksum($MerchantId, $OrderId, $Amount, $AuthDesc, $WorkingKey, $avnChecksum);
            $billing_cust_name = isset($_REQUEST["billing_cust_name"]) ? $_REQUEST["billing_cust_name"] : '';
            $billing_cust_address = isset($_REQUEST["billing_cust_address"]) ? $_REQUEST["billing_cust_address"] : '';
            $billing_cust_country = isset($_REQUEST["billing_cust_country"]) ? $_REQUEST["billing_cust_country"] : '';
            $billing_cust_tel = isset($_REQUEST["billing_cust_tel"]) ? $_REQUEST['billing_cust_tel'] : '';
            $billing_cust_email = isset($_REQUEST["billing_cust_email"]) ? $_REQUEST["billing_cust_email"] : '';
            $delivery_cust_name = isset($_REQUEST["delivery_cust_name"]) ? $_REQUEST["delivery_cust_name"] : '';
            $delivery_cust_address = isset($_REQUEST["delivery_cust_address"]) ? $_REQUEST["delivery_cust_address"] : '';
            $delivery_cust_tel = isset($_REQUEST["delivery_cust_tel"]) ? $_REQUEST["delivery_cust_tel"] : '';
            $delivery_cust_notes = isset($_REQUEST["delivery_cust_notes"]) ? $_REQUEST["delivery_cust_notes"] : '';
            $Merchant_Param = isset($_REQUEST["Merchant_Param"]) ? $_REQUEST["Merchant_Param"] : '';

            $card_category = isset($_REQUEST["card_category"]) ? $_REQUEST["card_category"] : '';

            if (true && $AuthDesc === "Y") {
                $message = "<br>Thank you for shopping with us. Your card has been charged and your transaction is successful. We will be shipping your order to you soon.";
                // Getting payment row already exist from order reference number
                $OrderId=split('_',$OrderId);
                $ids=split('_',$OrderId);
                
                $data['rent_id']=(int)$ids[1];
                $data['payment_pending']=$Amount;
                $data['payment_received']=$Amount;
                $data['payment_mode']=1;
                $data['bank_name']='CCAVENUE';
                $data['document_number']=$nb_order_no;
                $data['status']=1;
             		$status=$this->updatePayment((int)$OrderId[1],$data);
             		echo $status;
             		if($status)
             		{	
             			header('location:thanks');
             		}
             		else
             		{
             			header('location:rent-our-robots');
             		}
              
            } else if ($Checksum && $AuthDesc === "B") {
//                echo "<br>Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail";
//				 echo "<br>Testing-2";
                $this->setTemplate('');
                //Here you need to put in the routines/e-mail for a  "Batch Processing" order
                //This is only if payment for this transaction has been made by an American Express Card or by any netbank and status is not known is real time  the authorisation status will be  available only after 5-6 hours  at the "View Pending Orders" or you may do an order status query to fetch the status . Refer inetegrtaion document for order status tracker documentation"
            } else if ($Checksum && $AuthDesc === "N") {
//				 echo "<br>Testing-3";
                $this->setTemplate('');

                //Here you need to put in the routines for a failed
                //transaction such as sending an email to customer
                //setting database status etc etc
            } else {

//    Tools::redirect('index.php?controller=my-account');
                //Here you need to check for the checksum, the checksum did not match hence the error.
//				 echo "<br>Testing-4";
                $this->setTemplate('');
            }
        }
   		 }catch(Exception $e)
   		 {
   		 	
   		 }
   		 
    }
	
		private function updatePayment($loan_id,$data)
   		{
   			
   			$counter=0;
	   		$customer=$this->getCustomerDetailById($loan_id);
   			$duration=$customer['payment_duration'];
   			$status=$customer['status'];
   			$sql="select count(rent_id) as counter from ps_customer_rent_received where rent_id=".$loan_id;
   			//echo $sql;
   			$extended_date=$this->generateNewDate($customer['monthly_rental_expire'],1);
   			$extendsdate=array('monthly_rental_expire'=>$extended_date);
   			$row=Db::getInstance()->getRow($sql);
   			if($row)
   			{
   				$counter=$row['counter'];
   			}		
   			if($duration!=$counter)
   			{
   							Db::getInstance()->insert('customer_rent_received',$data);
   							//Db::getInstance()->getMsgError();
   							if(Db::getInstance()->Affected_Rows()>0)
   							{
   								
   									Db::getInstance()->update('rental_customer',$extendsdate,'rent_id='.$loan_id);
   									//echo 'row updated'; 
   									//echo Db::getInstance()->getMsgError();
   									//$this->sendMail($customerId,$data['document_number']);
   									return true;						
   							} 
   							else
   							{
   								//return Db::getInstance()->getMsgError();
   								//echo 'rent not inserted';
   								 return false;
   							}
   							
   			}
   			else 
   			{
   				//echo 'something wrong';
   			}
   		}
		private function generateNewDate($date,$duration)
		{
			
			$date = strtotime(date("Y-m-d", strtotime($date)) . " +".$duration." month");
			$date = date("Y-m-d",$date);
			return $date;
		}
		private function getCustomerDetailById($customer_id)
		{
			$sql='select * from ps_rental_customer where loan_id='.$customer_id;
			if($row=Db::getInstance()->getRow($sql))
				return $row;
			else return array();
		}
		private function getProductName($product_id)
		{
			$sql="select name from ps_product_lang where id_product=".$product_id;
			if($row=Db::getInstance()->getRow($sql))
				return $row['name'];
			else return array();
		}
		private function sendMail($customerId,$data)
		{
		try
	         {
    	        //send notification mail to customer's email id of payment
	           
	            $customer=$this->getCustomerDetailById($loanId);
	            $subject='Loan Application Requested #'.$id.'--'.$customer['name'];
	            $template='customer_template_payment_received';
            	if (!empty($cs_Email))
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
           		 
           		 //send mail to customer care
           		 $customerCare="cs@milagrow.in";
           		 $subject='Loan Payment Received #'.$customerId;
           		 $template='admin_template_payment_received';
           		  $res =Mail::Send(
                (int)1,
                $template,
                $subject,
                $data,
                $customerCare,
                'ADMINISTRATOR',
                null,
                null,
                '',
                null,
                getcwd() . _MODULE_DIR_ . RentingModel::MODULE_NAME . '/',
                false,
                null
           		 );
            return $res;
         }
        }catch(Exception $e) {
			Tools::displayError();
			die();
        }
		}
   		
 
}

?>