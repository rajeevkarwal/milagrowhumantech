<?php
if (!defined('_PS_VERSION_'))
	exit;
class TdHeaderToplinks extends Module
{
	public function __construct()
	{
		$this->name = 'tdheadertoplinks';
                
		$this->tab = 'front_office_features';
		$this->version = '1.1.0';
		$this->author = 'ThemesDeveloper';
		$this->need_instance = 0;
		parent::__construct();
		$this->displayName = $this->l('ThemesDeveloper  Header Top Links');
		$this->description = $this->l('Show headertoplinks on header of the page.');
	}

	public function install()
	{
		return (parent::install() AND $this->registerHook('top') AND $this->registerHook('header'));
	}

	/**
	* Returns module content for header
	*
	* @param array $params Parameters
	* @return string Content
	*/
	public function hookTop($params)
	{
		if (!$this->active)
			return;

		$this->smarty->assign(array(
			'cart' => $this->context->cart,
			'cart_qties' => $this->context->cart->nbProducts(),
			'logged' => $this->context->customer->isLogged(),
			'customerName' => ($this->context->customer->logged ? $this->context->customer->firstname.' '.$this->context->customer->lastname : false),
			'firstName' => ($this->context->customer->logged ? $this->context->customer->firstname : false),
			'lastName' => ($this->context->customer->logged ? $this->context->customer->lastname : false),
			'order_process' => Configuration::get('PS_ORDER_PROCESS_TYPE') ? 'order-opc' : 'order'
		));
		return $this->display(__FILE__, 'tdheadertoplinks.tpl');
	}


}