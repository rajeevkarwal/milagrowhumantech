<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hitanshu
 * Date: 9/9/13
 * Time: 6:30 PM
 * To change this template use File | Settings | File Templates.
 */
include_once(dirname(__FILE__).'/../../config/config.inc.php');
include_once(dirname(__FILE__).'/../../init.php');
include_once(_PS_MODULE_DIR_ . 'b2b/b2b.php');
$b2b = new B2b();
$pincode = Tools::getValue('pincode');
if (!empty($pincode)) {
    $stateandcity = $b2b->getCityAndStateFromThePinCode($pincode);
    if ($stateandcity)
        echo json_encode($stateandcity);
    else
        echo false;
} else
    echo false;