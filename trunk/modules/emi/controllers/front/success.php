<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hitanshu
 * Date: 29/11/13
 * Time: 11:28 AM
 * To change this template use File | Settings | File Templates.
 */

class EMISuccessModuleFrontController extends ModuleFrontController
{

    public function initContent()
    {
        parent::initContent();
        $this->setTemplate('success.tpl');
    }

}