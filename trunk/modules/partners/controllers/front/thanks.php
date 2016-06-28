<?php 

class PartnersThanksModuleFrontController extends ModuleFrontController
{
	function initContent()
	{
		parent::initContent();
		$this->setTemplate('Thanks.tpl');
		$server_name=$_SERVER['SERVER_NAME'];
		header('Refresh: 10;url:'.$server_name.'/partners-with-us');
	}
}


?>