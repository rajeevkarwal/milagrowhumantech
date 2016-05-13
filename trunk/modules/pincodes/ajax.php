<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hitanshu
 * Date: 11/05/2016
 * Time: 6:30 PM
 * To change this template use File | Settings | File Templates.
 */
include_once(dirname(__FILE__).'/../../config/config.inc.php');
include_once(dirname(__FILE__).'/../../init.php');
include_once(_PS_MODULE_DIR_ . 'pincodes/pincodes.php');
$address = new PinCodes();
$pincode = Tools::getValue('pincode');
$status = $address->checkCodStatus($pincode);
if (!empty($pincode)) {
    $stateandcity = $address->getCityAndStateFromThePinCode($pincode);
    if ($stateandcity)
        echo json_encode($stateandcity);
    else
        echo false;
} else
    echo false;
if(!empty($pincode)){
    echo json_encode($status);
}