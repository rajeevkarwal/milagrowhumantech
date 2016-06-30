<?php
define('PAYMENT_URL','');//ccavenue url for payment;
define('WORKING_KEY','');//WORDKING KEY
include_once(dirname(__FILE__.'..\..\rentingmodel.php'));
define('_MERCHANT_ID', 'M_milagrow_6881');
define('_BILLING_PAGE_HEADING', 'Milagrow Humantech - Rental Contract for %s');
class RentingmodelPaylinkModuleFrontController extends ModuleFrontController
{
    public $display_column_left=true;
    public  function initContent()
    {
    	$customerData=array();
        parent::initContent();
        $this->setTemplate();
        $customer_id=Tools::getValue('customerId');
        //$data=$this->getCustomer();
       	$customerData=$this->getCustomerDetailById($data[$i]);
        /* This is not the standard think what will happened when we have 10000 customers or may be more than that and you are fetching all the customers and then matching. 
        for($i=0;$i<count($data);$i++)
       	{
       		if($customer_id ===md5($data[$i]))
       		{
       			
       		}
       	}
        */
     	$this->context->smarty->assign(array(
     	'customerId'=>$customerData['rent_id'],
     	'customerName'=>$customerData['name'],
     	'customerEmail'=>$customerData['email'],
     	'contactNumber'=>$customerData['contact_number'],
     	'installmentAmount'=>$customerData['monthly_rental'],
     	'status'=>$customerData['status'],
     	'address'=>$customerData['address'],
     	'merchant_id'=>_MERCHANT_ID,
     	'billingPageHeading'=>_BILLING_PAGE_HEADING
     	
     	
     	));
     	$this->setTemplate('customer-information.tpl');
    }
    private function getCustomer()
    {
    	$customer1=array();
    	$sql="select rent_id from ps_rental_customer";
    	$result=Db::getInstance()->ExecuteS($sql);
    	foreach ($result as $customer)
    	{
    		array_push($customer1,$customer['rent_id']);
    	}
    	return $customer1;
    }
	protected function getCustomerDetailById($customer_id)
	{
		$sql="select * from ps_rental_customer where md5(rent_id)='".$customer_id."'";
		if($row=Db::getInstance()->getRow($sql))
			return $row;
		else return array();
	}
}
?>   