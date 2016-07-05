<?php

class RentingModelCustomerViewModuleFrontController extends ModuleFrontController
{
	public function postProcess()
	{
		
	}
	public function initContent()
	{
		parent::initContent();
		
		$customerId=Tools::getValue('key');
		//$customerKey=$customer_id;
		//$CustomerId=$this->findDecryptedId($customerKey);
		$statusList=array('Payment Pending','Payment Awaited/By Cheque','Awaiting Approval','Document Verified','Product Sent','Delivered','Active','Completed','Settelled','Cancelled','Rejected');
    	$customerInfo=$this->customerDetails($customerId);
		$customerPaymentDetails=$this->getLoanDetails($customerInfo['rent_id']);
		$productName=$this->getProductInfo($customerInfo['product_id']);
		$this->context->smarty->assign(array(
		'customerName'=>$customerInfo['name'],
		'customerEmail'=>$customerInfo['email'],
		'contactNumber'=>$customerInfo['contact_number'],
		'dateOfBirth'=>$customerInfo['date_of_birth'],
		'customerAddress'=>$customerInfo['address'],
		'productName'=>$productName,
		'securityDeposit'=>$customerInfo['security_deposited'],
		'monthlyInstallment'=>$customerInfo['monthly_rental'],
		'rentalDuration'=>$customerInfo['payment_duration'],
		'monthly_expiration'=>$customerInfo['monthly_rental_expire'],
		'expirationDate'=>$customerInfo['tenure_expiration_date'],
		'activationDate'=>$customerInfo['applied_on'],
		'productAmount'=>$customerInfo['product_price'],
		'status'=>$customerInfo['status'],
		'loanData'=>$customerPaymentDetails,
		'extensions'=>$this->getExtensions($customerInfo['rent_id']),
		'statusName'=>$statusList[$customerInfo['status']],
		'extension'=>$this->getRowsExtensions($customerInfo['rent_id']),
		'payments'=>$this->getNoOfCheques($customerInfo['rent_id'])
		));
		//echo $this->getNoOfCheques($customerId);
		$this->setTemplate('customerProfile.tpl');
		
	}	
	// this function is use to find the decrypted customer id which we have to pass to other function for getting other details
	/*
	public function findDecryptedId($customer_id)
	{
		
		$sql="select customer_id from ps_rental_customer";
		$row=Db::getInstance()->ExecuteS($sql);
		if($row)
		{
			foreach($row as $data)
			{
				if($customer_id==md5($data['customer_id']))
				{
					return $data['customer_id'];
				}
			}
		}
	}

	*/
	public function customerDetails($rent_id)
	{
		$sql="select * from ps_rental_customer where md5(rent_id)='".$rent_id."'";
		//echo $sql;
		$row=Db::getInstance()->getRow($sql);
		if($row)
		{
			return $row;
		}
		else return false;
		
	}
	private function getRowsExtensions($customer_id)
	{
		$sql="select count(*) as rows from ps_manage_rental where rent_id=".$customer_id;
		//echo $sql;
		$row=Db::getInstance()->getRow($sql);
		if($row)
		{
			return $row['rows'];
		}
		else return false;
	}
	private function getNoOfCheques($rent_id)
	{
		$sql="select count(*) as rows from ps_customer_rent_received where rent_id=".$rent_id;
		$row=Db::getInstance()->getRow($sql);
		if($row)
		{
			return $row['rows'];
		}
		else return false;
	}
	public function getLoanDetails($customer_id)
	{
		$sql="select * from ps_customer_rent_received where rent_id=".$customer_id;
		//echo $sql;
		$row=Db::getInstance()->ExecuteS($sql);
		if($row)
		{
			return $row;
		}
		else return false;
		
	}
	private function getProductInfo($product_id)
	{
		$sql="select name from ps_product_lang where id_product=".$product_id;
		$row=Db::getInstance()->getRow($sql);
		if($row)
			return $row['name'];
		else
			return false;
	}
	private function getExtensions($customerId)
	{
		$sql="select * from ps_manage_rental where rent_id=".$customerId;
		$row=Db::getInstance()->ExecuteS($sql);
		if($row)
		{
			return $row;
		}
		else return false;
	}
	
	
}

?>