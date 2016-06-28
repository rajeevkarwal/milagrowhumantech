<?php 

class SeniorDiscountThanksModuleFrontController extends ModuleFrontController
{
	function initContent()
	{
		parent::initContent();
		$this->setTemplate('Thanks.tpl');
	}
}
?>