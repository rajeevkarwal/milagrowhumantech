<?php

include_once(dirname(__FILE__).'/../../config/config.inc.php');
include_once(dirname(__FILE__).'/../../init.php');
include_once(_PS_MODULE_DIR_ . 'rentingmodel/rentingmodel.php');
$library=new rentingmodel();
$value=Tools::getValue('product_id');
$rowId=Tools::getValue('row_id');
$product_id=Tools::getValue('productCode');
$customer_id=Tools::getValue('CustomerId');
$customerCode=Tools::getValue('CustomerCode');
$pid=Tools::getValue('pid');
$document_number=Tools::getValue('chequeNumber');
$customerrowid=Tools::getValue('customerrowid');
$statusvalue=Tools::getValue('status');
$product_rental=Tools::getValue('pro_id');
$zipcode=Tools::getValue('zipcode');

$pincode_back=Tools::getValue('back_pincode');
if(!empty($zipcode))
{
	$data=$library->getPincodeStatus($zipcode);
	$data1=$library->getCityName($zipcode);
	echo json_encode($data);
	$cityName=array('name'=>$data1);
	echo json_encode($cityName);

}
if(!empty($pincode_back))
{
	$data=$library->getCityName($pincode_back);
	$cityName=array('name'=>$data);
	echo json_encode($cityName);
}
if(!empty($product_rental))
{
	$data=$library->getMonthlyRental($product_rental);
	echo json_encode($data);
}
if(!empty($value))
{
		$data=$library->getProductPrice($value);
		echo json_encode($data);
}
if(!empty($rowId))
{
	$data=$library->deleteProductFromId($rowId);
	if($data)
		echo json_encode(array('status'=>$data));
	else
		echo json_encode(array('status'=>$data));
}
if(!empty($product_id))
{
	$data=$library->getMetaDataByProductId($product_id);
	echo json_encode($data);
}
if(!empty($pid))
{
	$data=$library->getProductPrice($product_id);
	
	echo json_encode($data);
}
if(!empty($customer_id))
{
	
	$data=$library->deleteCustomer($customer_id);
	echo json_encode(array('status'=>$data));
}
if(!empty($customerCode))
{
	$data=$library->getCustomerDetailById($customerCode);
	echo json_encode($data);
}

if(!empty($customerrowid)&&!empty($statusvalue))
{	
	
	$data=array('status'=>$statusvalue);
	
	$result=$library->updateStatus($customerrowid,$data);
	$returningArray=array('statusCode'=>$result);
	echo json_encode($returningArray);
}
if(!empty($document_number))
{
	$result=$library->deleteCheque($document_number);
	$data=array('deleted'=>$result);
	echo json_encode($data);
}
else
	return false;
?>