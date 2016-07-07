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
$city_id=Tools::getValue('city_id');

//
$zip1=Tools::getValue('a_zipcode');
$pid1=Tools::getValue('pid1');


$pincode_back=Tools::getValue('back_pincode');

$singleCheck=Tools::getValue('single_zip');

$city_row_id=Tools::getValue('city_row_id');

if(!empty($city_row_id))
{
	$data=$library->deleteCity($city_row_id);
	echo json_encode(array('output'=>$data));
}
if(!empty($singleCheck))
{
	$data=$library->getCounters($singleCheck);
	echo json_encode($data);
}
if(!empty($zip1))
{
	$data=$library->getCityAuthetication($pid1 ,$zip1);
	echo json_encode($data,true);
        die;
}
if(!empty($zipcode))
{
	$data=$library->getPincodeStatus($zipcode);
	$data1=$library->getCityName($zipcode);
	echo json_encode($data);
	$cityName=array('name'=>$data1);
	echo json_encode($cityName);
}
if(!empty($city_id))
{
	$data=$library->getPincodeByCityId($city_id);
	echo json_encode($data);
}


/*
 * case for fetching the name of the city and 
 */
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