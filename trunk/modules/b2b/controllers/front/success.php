<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hitanshu
 * Date: 30/7/13
 * Time: 10:46 AM
 * To change this template use File | Settings | File Templates.
 */

class B2bSuccessModuleFrontController extends ModuleFrontController
{
    public $display_column_left = true;

    public function initContent()
    {
        parent::initContent();
        $this->setTemplate('success.tpl');
    }

}