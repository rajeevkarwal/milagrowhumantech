<?php
/**
 * Created by PhpStorm.
 * User: MILAGROW4
 * Date: 5/17/2016
 * Time: 4:39 PM
 */
include_once(dirname(__FILE__).'/../../config/config.inc.php');
include_once(dirname(__FILE__).'/../../init.php');
$form_name=Tools::getValue('form_code');
echo $form_name;