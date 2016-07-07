<?php
include_once(_PS_MODULE_DIR_ . 'rentingmodel/RentingPdf.php');
include_once(_PS_MODULE_DIR_ . 'rentingmodel/SecurityPdf.php');
define('COMPANY_MAIL_AFTER_PAYMENT','cs@milagrow.in');
session_start();
class RentingmodelThanksModuleFrontController extends ModuleFrontController
{
    public $display_column_left=true;
    public  function initContent()
    {
        parent::initContent();
        $customerInfo=$_SESSION['data'];
       	
        $applicationNumber= $this->generateApplicationFormat($customerInfo['category_id'],$_SESSION['customerId']);
        $this->context->smarty->assign(array(
        'applicationNumber'=>$applicationNumber,
        'productName'=>$this->getProduct($customerInfo['product_id']),
        ));
       	$this->mailToCustomer($_SESSION['customerId']);
        $this->setTemplate('thanks.tpl');
       session_unset();
       
        //session_unset();
    }
	private function getProduct($product_id)
	{
		$sql="select name from ps_product_lang where id_product=".$product_id;
		$row=Db::getInstance()->getRow($sql);
		if($row)
			return $row['name'];
		else 
			return false;
	}
	private function generateApplicationFormat($category_id,$customerId)
	{
		$date=new DateTime();
		$year=$date->format('Y');
		$categoryName=$this->getCategoryName($category_id);
		$string1=split(' ',$categoryName);
		$firstChar=substr($string1[0],0,1);
		$secondChar=substr($string1[1],0,1);
		return $year.'/'.$date->format('m').'/'.$firstChar.$secondChar.'/'.$customerId;
	}
	private function getCategoryName($category_id)
	{
		$sql="select name from ps_category_lang where id_category=".$category_id;
		$row=Db::getInstance()->getRow($sql);
		if($row)
			return $row['name'];
		else
			return false;
	}
	private function mailToCustomer($id)
    	{
    		
    		$customer=$_SESSION['data'];
    		
    		$_SESSION['customerId']=$id;
    		$customer=$this->getCustomer($id);
    		if($customer['type'])
    			$app_type='Company';
    		else 
    			$app_type='Individual';
    		$date=new DateTime();
    		$newDate1=$date->format('d-m-Y');
    		$paymentMode=$customer['payment_mode'];
    		if($paymentMode==0)
 				$paymentMode='Payment Awaited/By Cheque';
 			else   			
 				$paymentMode='Paid/Online';
    		//generating security deposited receipt;
    		 $receiptNo=$this->generateApplicationFormat($customer['category_id'],$id);
            $content = array(
                'securityDeposited'=>$customer['security_deposited'],
                'receiptNo' => $receiptNo,
                'demoDate' => $newDate1,
                'demoAddress' =>  $customer['name'].'<br>'.$customer['address'].'<br>'.$customer['contact_number'].'<br>'.$customer['email'],
            'product'=>$this->getProduct($customer['product_id'])
               
            );
           
    			
    		 $pdf = new SecurityPdf($this->context->smarty, $this->context->language->id);
                            $content = $pdf->render(false, $content);
                            $fileAttachment = array();
                            $fileAttachment['content'] = $content;
                            $fileAttachment['name'] = 'Security Deposit Receipt'.$customer['name'].'.pdf';
                            $fileAttachment['mime'] = 'application/pdf';
    	
    		//creating loan receipt
    		$tax=15.00;
    		
    		$productMeta=$this->getMetaDataByProductId($customer['product_id']);//get complete detail by product
           	
           	 $taxInInstallment=($customer['monthly_rental']*14/100);//where tax applied on test
           	 $cess2=($customer['monthly_rental']*.5/100);
           	 
            $actualPrice=$productMeta['product_value'];//actual price of product
            $discount=0;
            if($customer['payment_duration']>=9 && $customer['payment_duration']<15)$discount=10;
            else  if($customer['payment_duration']>14 && $customer['payment_duration']<=24)$discount=15;
            
            $discountInRent=($productMeta['installment_amount']*$discount/100);//discount In Rent
            $rentAfterDiscount=ceil($productMeta['installment_amount']-$discountInRent);//Rent Amount after discount
            $rentBeforeTax=$customer['monthly_rental']-$taxInInstallment-$cess2-$cess2;
            $content = array(
            	'originalInstallment'=>$productMeta['installment_amount'],
                'receiptNo' => $receiptNo,
            	'serviceTax'=>$tax,
            	'priceWithoutTax'=>$priceWithoutTax,
            	'taxAmount'=>$amountTax,
            	'endingDate'=>$this->generateNewDate($this->getDateByCustomerId($customer['customer_id']),$customer['payment_duration']),
            	'priceAfterTax'=>round($priceAfterTax,2),
            	'unitPrice'=>$priceWithoutTax,
                'demoDate' => $newDate1,
            	'actualPrice'=>$actualPrice['price'],
            	'discountedAmount'=>$discountedPrice,
            	'rentAfterDiscount'=>$rentAfterDiscount,
            	'taxInInstallment'=>$taxInInstallment,
            	'rentBeforeTax'=>$rentBeforeTax,
            	'discount'=>$discount,
            	'otherTax'=>$cess2,
            	'duration'=>$customer['payment_duration'],
                'demoAddress' =>  $customer['name'].'<br>'.$customer['address'].'<br>'.$customer['city'].'<br>'.$customer['state'].'<br>'.$customer['contact_number'].'<br>'.$customer['email'],
            	'paymentMode'=>$paymentMode,
            	'product'=>$this->getProduct($customer['product_id'])
               
            );
           
           $pdf = new RentingPdf($this->context->smarty, $this->context->language->id);
                            $content1 = $pdf->render(false, $content);
                            $fileAttachment1 = array();
                            $fileAttachment1['content'] = $content1;
                            $fileAttachment1['name'] = 'Monthly Rental Slip'.$customer['name'].'.pdf';
                            $fileAttachment1['mime'] = 'application/pdf';
            
                      
    		$productName=$this->getProductDetails($customer['product_id']);
    		$date=new DateTime();
    		$nowDate=$date->format('d-m-Y');
    		$desc=$date->format('d-m-Y').'--To--'.$this->generateNewDate($date->format('d-m-Y'),$customer['payment_duration']);
    		$total=$customer['monthly_rental']+$customer['security_deposited'];
    		$data=array(
    		'{productName}'=>$productName,
    		'{name}'=>$customer['name'],
    		'{order_no}'=>$this->generateApplicationFormat($customer['category_id'],$id),
    		'{security}'=>$customer['security_deposited'],
    		'{installmentDesc}'=>$desc,
    		'{duration}'=>$customer['payment_duration'],
    		'{installment_amount}'=>$customer['monthly_rental'],
    		'{total_amount}'=>$total,
    		'{address}'=>$customer['address'].','.$customer['city'].','.$customer['state'],
    		'{contact_number}'=>$customer['contact_number'],
    		'{email}'=>$customer['email'],
    		'{date}'=>$nowDate,
    		'{link}'=>$_SERVER['SERVER_NAME'].'/view-customer?key='.md5($id),
    		'{payment}'=>$paymentMode,
    		'{type}'=>$app_type
    		);
    		
	       try
	         {
	         	//sending mail to customer
    	        $attachments=array($fileAttachment,$fileAttachment1);
	           
	            $subject='('.$paymentMode.')-Loan Application Requested-'.$productName.'-#'.$id.'--'.strtoupper($customer['name']).'-'.strtoupper($customer['state']).'-'.strtoupper($customer['city']);
	            $template='first_mail';
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
                $attachments,
                null,
                getcwd() . _MODULE_DIR_ . 'rentingmodel/',
                false,
                null
            );
        
            //send mail to customer support
            	$customerCare='cs@milagrow.in';
            	//$subject="Loan Application Received #-".$id.'-'.$customer['name'].'-'.$paymentMode;
            	$templateName='company_mail_before_payment';
            	$title="Admin";
            	if (!empty($customerCare))
            	 {
                	 $res =Mail::Send(
                (int)1,
                $templateName,
                $subject,
                $data,
                $customerCare,
                $title,
                null,
                null,
                $attachments,
                null,
               getcwd() . _MODULE_DIR_ . 'rentingmodel/',
                false,
                null
            );
           }
           //receivable mails
          $customerCare='receivables@milagrow.in';
            	 if (!empty($customerCare))
            	 {
                	 $res =Mail::Send(
                (int)1,
                $templateName,
                $subject,
                $data,
                $customerCare,
                $title,
                null,
                null,
                $attachments,
                null,
                 getcwd() . _MODULE_DIR_ . 'rentingmodel/',
                false,
                null
            );
           }
           //account mail
            	 
            	  $customerCare='outboundlogistics@milagrow.in';
            	 if (!empty($customerCare))
            	 {
                	 $res =Mail::Send(
                (int)1,
                $templateName,
                $subject,
                $data,
                $customerCare,
                $title,
                null,
                null,
                $attachments,
                null,
                getcwd() . _MODULE_DIR_ . 'rentingmodel/',
                false,
                null
            );
           }
            return $res;
         }
        }catch(Exception $e) {
			echo Tools::displayError();
        }
    		
    }
	public function getMetaDataByProductId($productId)
    {
        $sql="select * from ps_product_rental where product_id=".$productId;
        $row=Db::getInstance()->getRow($sql);
        if($row)
            return $row;
        else
            return $sql;
    }
private function generateNewDate($date,$duration)
	{
			//echo 'original date'.$date;
			$date = strtotime(date("d-m-Y", strtotime($date)) . " +".$duration." month");
			$date = date("d-m-Y",$date);
			return $date;
			//echo 'new date'.$date.'duration'.$duration.'<br>';
	}
private function getDateByCustomerId($id)
	{
		$sql='select date(applied_on)as date from ps_rental_customer where customer_id='.$id;
		$row=Db::getInstance()->getRow($sql);
		if($row)
			return $row['date'];
		else return false;
	}
	private function getProductDetails($id)
	{
		$sql="select name from ps_product_lang where id_product=".$id;
		$row=Db::getInstance()->getRow($sql);
		if($row)
			return $row['name'];
		else
			return false;
		
	}
    
  	private function getCustomer($rent_id)
  	{
  		$sql="select * from ps_rental_customer where rent_id=".$rent_id;
  		$row=Db::getInstance()->getRow($sql);
  		if($row)
  			return $row;
  		else
  			return false;
  	}
  
}
