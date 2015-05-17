<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hitanshu
 * Date: 24/12/13
 * Time: 6:39 PM
 * To change this template use File | Settings | File Templates.
 */

class EMIErrorModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();
        $this->setTemplate('error.tpl');
    }
}