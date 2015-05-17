<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hitanshu
 * Date: 6/2/14
 * Time: 12:23 PM
 * To change this template use File | Settings | File Templates.
 */

class CODSuccessModuleFrontController extends ModuleFrontController
{

    public function initContent()
    {
        parent::initContent();
        $this->setTemplate('success.tpl');
    }
}