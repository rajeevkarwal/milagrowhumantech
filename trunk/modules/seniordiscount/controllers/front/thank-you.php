<?php 

class SeniorDiscountthankyouModuleFrontController extends ModuleFrontController
{
	function initContent()
	{
		parent::initContent();
		$this->setTemplate('Thanks.tpl');
	}
}
?>