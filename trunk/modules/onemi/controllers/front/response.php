<?php
define('_ONEMI_SUCCESS_MESSAGE', 'Thank you placing the order, %s of amount Rs. %s. Your order is being processed. Please check your email for additional details.');
class OnemiResponseModuleFrontController extends ModuleFrontController {
	public function postProcess() {
        $response = $_REQUEST;
        
        /* start code for storing the response */
        if ( isset($_SERVER['HTTP_CLIENT_IP']) && ! empty($_SERVER['HTTP_CLIENT_IP'])) {
    	$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif ( isset($_SERVER['HTTP_X_FORWARDED_FOR']) && ! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
    	$ip = (isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
		}

        $responseData=array('response'=>json_encode($response),'created_at'=>date('Y-m-d H:i:s'),
        	'ip'=>$ip);
        Db::getInstance()->insert('onemi_response_v2',$responseData);  


        //echo '<pre>';
        //print_r($response);		
		$cartID = $response['merordrefno'];
		$extras = array();
		$responseMsg='';
		$extras['transaction_id'] = $response['onemitranid'];
		$cart = new Cart(intval($cartID));
		$amount = $cart->getOrderTotal(true,Cart::BOTH);
		if(($response['responsecode'] == "102")||($response['responsecode'] == "105")){
			$status_code = "Ok";
			if($response['tranamt'] == $amount){
				$status = Configuration::get('Onemi_ID_ORDER_SUCCESS');	
				$message= "Transaction Successful";
                $extras['ONEMITXNTYPE']='cc/dc';
                if(!empty($response['tenure']))
                {
                    $extras['ONEMITXNTYPE']='emi';
                }
			}
			 else{
                 $extras['ONEMITXNTYPE']='loan';
				$status = Configuration::get('Onemi_ID_ORDER_PENDING');
				$responseMsg.= "The payment has been kept on hold until the manual verification is completed and authorized by Onemi";
				$message = "Transaction Successful";

			}
		}
		else{
			if($response['errorcode']=='01'){
				$errorcode = "Missing Mandatory Parameters";
			}
			else if($response['errorcode']=='02'){
				$errorcode = "Invalid Merchant";
			}
			else if($response['errorcode']=='03'){
				$errorcode = "Invalid Channel";
			}
			else if($response['errorcode']=='04'){
				$errorcode = "Invalid Bank Code";
			}
			else if($response['errorcode']=='05'){
				$errorcode = "Invalid Tenure";
			}
			else if($response['errorcode']=='06'){
				$errorcode = "Invalid Promo code";
			}
			else if($response['errorcode']=='07'){
				$errorcode = "Signature Mismatch";
			}
			else if($response['errorcode']=='08'){
				$errorcode = "Invalid Amount";
			}
			else if($response['errorcode']=='09'){
				$errorcode = "Invalid Payment Option";
			}
            else if($response['errorcode']=='00'){
                $errorcode = "Cancelled by user";
            }
			else{
				$errorcode = "";
			}
			$status_code = "Failed";
			$status = Configuration::get('Onemi_ID_ORDER_FAILED');
			$message = $errorcode. " - Transaction Failed, Retry!!";
		}
		
		$history_message = $responseMsg.' Onemi Payment ID: '.$response['onemitranid'];
		//echo $history_message;		
		$onemi = new Onemi();
		$onemi->validateOrder(intval($cart->id), $status, $amount, $onemi->displayName, $history_message, $extras, '', false, $cart->secure_key);					
		//echo 'reached_here';
        //die;
        if($response['responsecode'] == "105")
        {
            $orders = $this->getAllOrdersForGivenCart((int)$cartID);
            $orderReference=$this->currentOrderReference;
            $customerDet = new Customer($cart->id_customer);

            foreach($orders as $orderRow)
            {
                $this->sendLoanWaitingEmail($orderRow['id_order'],$orderReference,$customerDet->firstname,$customerDet->lastname,$customerDet->email);

            }
        }


		$this->context->smarty->assign(array(
			'status' => $status_code,
			'responseMsg' => $message,
			'this_path' => $this->module->getPathUri(),
			'this_path_ssl' => Tools::getShopDomainSsl(true, true).__PS_BASE_URI__.'modules/'.$this->module->name.'/'
		));
		
		//echo 'reached_here';
		$this->setTemplate('payment_response.tpl');

	}

    public function getAllOrdersForGivenCart($cartId)
    {
        $sqlQuery = 'Select * from ' . _DB_PREFIX_ . 'orders where id_cart=' . $cartId;
        $result = Db::getInstance()->executeS($sqlQuery);
        if ($result)
            return $result;
        return array();
    }


    private function sendLoanWaitingEmail($orderId,$reference,$firstname,$lastname,$email)
    {

        $order = new Order($orderId);

        $data = array(
            '{firstname}' => $firstname,
            '{lastname}' => $lastname,
            '{email}' => $email,
            '{order_name}' => $reference
        );


        $logisticEmail = 'outboundlogistics@milagrow.in';
        $receivableEmail = 'receivables@milagrow.in';


        //$logisticEmail = 'hitanshu.malhotra@milagrow.in';
        //$receivableEmail = 'hitanshu.malhotra@milagrow.in';

        $adminEmailErrorTemplate = 'order_loan_admin';
        $adminSubject = sprintf(Mail::l('New order Loan Under Approval - #%06d , ONEMI', $order->id_lang), $order->id);

        Mail::Send(
            (int)$order->id_lang,
            $adminEmailErrorTemplate,
            Mail::l($adminSubject, (int)$order->id_lang),
            $data,
            $logisticEmail,
            'Administrator',
            null,
            null,
            null,
            null, getcwd() . '/', false, (int)$order->id_shop
        );

        Mail::Send(
            (int)$order->id_lang,
            $adminEmailErrorTemplate,
            Mail::l($adminSubject, (int)$order->id_lang),
            $data,
            $receivableEmail,
            'Administrator',
            null,
            null,
            null,
            null, getcwd() . '/', false, (int)$order->id_shop
        );
    }
}
