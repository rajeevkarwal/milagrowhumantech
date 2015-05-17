<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hitanshu
 * Date: 8/10/13
 * Time: 6:45 PM
 * To change this template use File | Settings | File Templates.
 */

class FrontOrderTrackingModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        $trackingCode = Tools::getValue('trackingCode');
        $this->context->smarty->assign(array('trackingCode' => $trackingCode));

        $output = $this->context->smarty->fetch(dirname(__FILE__) . '/../../views/templates/front/default.tpl');
        echo $output;
        exit;
    }
}