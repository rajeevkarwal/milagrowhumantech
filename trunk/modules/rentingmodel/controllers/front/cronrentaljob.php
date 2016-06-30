<?php
session_start();
define('MAIL_FROM','payment@milagrow.in');
define('ADMIN_NAME','MILAGROW KNOWLEDGE AND BUISNESS SOLUTIONS');
define('CUSTOMER_CARE_EMAIL','cs@milagrow.in');
define('ACCOUNT_EMAIL','account@milagrow.in');
class RentingmodelCronRentalJobModuleFrontController extends ModuleFrontController
{
   
    public  function initContent()
    {
        parent::initContent();
        $date=new DateTime();
        $currentDate=$date->format('d-m-Y');
       $customer=$this->getPendingRentalCustomerEmail();
       
    
       foreach ($customer as $data)
       {
       		//$newDate=$data['monthly_rental_expire'];
       		 echo $currentDate.''.$data['monthly_rental_expire'];
       		echo dif($currentDate,$data['monthly_rental_expire']);
       		if(1)
       		{
       			echo $data['name'];
       		}
       		echo '<br>';
       }
   
    }
    private function dif($from,$to)
    {
    		$days='';
    	return $days;
    }
    public function postProcess()
    {
    	
    }
    protected function getPendingRentalCustomerEmail()
    {
    	
    	$sql="select name,monthly_rental_expire from ps_rental_customer";
    	$result=Db::getInstance()->ExecuteS($sql);
    	if($result)
    		return $result;
    	else 
    		return true;
    }
	protected function extendCustomer()
	{
		$sql="select name,email,monthly_rental_expire from ps_rental_customer where monthly_rental_expire<=now()";
    	$result=Db::getInstance()->ExecuteS($sql);
    	if($result)
    		return $result;
    	else 
    		return true;
	}
	private function generateNewDate($date,$duration)
	{
			//echo 'original date'.$date;
			$date = strtotime(date("Y-m-d", strtotime($date)) . " +".$duration." month");
			$date = date("Y-m-d",$date);
			return date;
			//echo 'new date'.$date.'duration'.$duration.'<br>';
	}
	
	private function sendEmail($email,$customerId,$customerName)
	{
		try{
	$customerCareEmail=CUSTOMER_CARE_EMAIL;
		 $adminTemplate='';
		 $fileAttachment='';
		Mail::Send(
                    (int)1,
                    $adminTemplate,
                    Mail::l("Pre Sales Demo - #" . $customerId ." - ". $customerName, (int)1),
                    $data,
                    $email,
                    'Administrator',
                    null,
                    null,
                    $fileAttachment,
                    null,
                    NULL,
                    false,
                    null
                );
               
               
                
		}catch (Exception $e)
		{
			var_dump($e);
		}
               
       
	}
}

 
?>