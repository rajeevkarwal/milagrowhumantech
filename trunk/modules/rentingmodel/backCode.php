<?php
include_once(dirname(__FILE__).'/../../config/config.inc.php');
include_once(dirname(__FILE__).'/../../init.php');
include_once(_PS_MODULE_DIR_ . 'rentingmodel/rentingmodel.php');
$rentingmodel=new rentingmodel();


$cityName=Tools::getValue('cityName');
$pincodeName=Tools::getValue('pincodeName');
if(!empty($cityName) && !empty($pincodeName))
{
	
	$data=$rentingmodel->savePincodeAndCity($pincodeName,$cityName);
	echo json_encode($data);
}


?>