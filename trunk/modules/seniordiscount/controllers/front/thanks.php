<?php 

class PartnersThanksModuleFrontController extends ModuleFrontController
{
	function initContent()
	{
		parent::initContent();
		$this->setTemplate('Thanks.tpl');
		header('Refresh: 10;location:partners-with-us');
	}
}


?>