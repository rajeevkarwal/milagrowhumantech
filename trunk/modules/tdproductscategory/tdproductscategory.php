<?php
if (!defined('_PS_VERSION_'))
	exit;

class TDProductsCategory extends Module
{
 	private $_html;

	public function __construct()
 	{
 	 	$this->name = 'tdproductscategory';
 	 	$this->version = '1.1.0';
		$this->author = 'ThemesDeveloper';
 	 	$this->tab = 'front_office_features';
		$this->need_instance = 0;
		parent::__construct();
		$this->displayName = $this->l('ThemesDeveloper Products Category');
		$this->description = $this->l('Display products of the same category on the product page.');
		
		if (!$this->isRegisteredInHook('header'))
			$this->registerHook('header');
 	}

	public function install()
	{
	 	if (!parent::install() OR !$this->registerHook('productfooter') OR !$this->registerHook('header') OR !Configuration::updateValue('PRODUCTSCATEGORY_DISPLAY_PRICE', 1))
	 		return false;
	 	return true;
	}
	
	public function uninstall()
	{
	 	if (!parent::uninstall() OR !Configuration::deleteByName('PRODUCTSCATEGORY_DISPLAY_PRICE'))
	 		return false;
	 	return true;
	}
	
	public function getContent()
	{
		$this->_html = '';
		if (Tools::isSubmit('submitCross') AND Tools::getValue('displayPrice') != 0 AND Tools::getValue('displayPrice') != 1)
			$this->_html .= $this->displayError('Invalid displayPrice');
		elseif (Tools::isSubmit('submitCross'))
		{
			Configuration::updateValue('PRODUCTSCATEGORY_DISPLAY_PRICE', Tools::getValue('displayPrice'));
			$this->_html .= $this->displayConfirmation($this->l('Settings updated successfully'));
		}
		$this->_html .= '
		<form action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" method="post">
		<fieldset><legend><img src="'.$this->_path.'logo.gif" alt="" title="" />'.$this->l('Settings').'</legend>
			<label>'.$this->l('Display price on products').'</label>
			<div class="margin-form">
				<input type="radio" name="displayPrice" id="display_on" value="1" '.(Configuration::get('PRODUCTSCATEGORY_DISPLAY_PRICE') ? 'checked="checked" ' : '').'/>
				<label class="t" for="display_on"> <img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" /></label>
				<input type="radio" name="displayPrice" id="display_off" value="0" '.(!Configuration::get('PRODUCTSCATEGORY_DISPLAY_PRICE') ? 'checked="checked" ' : '').'/>
				<label class="t" for="display_off"> <img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" /></label>
				<p class="clear">'.$this->l('Show the price on the products in the block.').'</p>
			</div>
			<center><input type="submit" name="submitCross" value="'.$this->l('Save').'" class="button" /></center>
		</fieldset>
		</form>';
		return $this->_html;
	}
	
	private function getCurrentProduct($products, $id_current)
	{
		if ($products)
			foreach ($products AS $key => $product)
				if ($product['id_product'] == $id_current)
					return $key;
		return false;
	}
	
	public function hookProductFooter($params)
	{
		$idProduct = (int)(Tools::getValue('id_product'));
		$product = new Product((int)($idProduct));

		/* If the visitor has came to this product by a category, use this one */
		if (isset($params['category']->id_category))
			$category = $params['category'];
		/* Else, use the default product category */
		else
		{
			if (isset($product->id_category_default) AND $product->id_category_default > 1)
				$category = New Category((int)($product->id_category_default));
		}
		
		if (!Validate::isLoadedObject($category) OR !$category->active) 
			return;

		// Get infos
		$categoryProducts = $category->getProducts($this->context->language->id, 1, 100); /* 100 products max. */
		$sizeOfCategoryProducts = (int)sizeof($categoryProducts);
		$middlePosition = 0;
		
		// Remove current product from the list
		if (is_array($categoryProducts) AND sizeof($categoryProducts))
		{
			foreach ($categoryProducts AS $key => $categoryProduct)
				if ($categoryProduct['id_product'] == $idProduct)
				{
					unset($categoryProducts[$key]);
					break;
				}

			$taxes = Product::getTaxCalculationMethod();
			if (Configuration::get('PRODUCTSCATEGORY_DISPLAY_PRICE'))
				foreach ($categoryProducts AS $key => $categoryProduct)
					if ($categoryProduct['id_product'] != $idProduct)
					{
						if ($taxes == 0 OR $taxes == 2)
							$categoryProducts[$key]['displayed_price'] = Product::getPriceStatic((int)$categoryProduct['id_product'], true, NULL, 2);
						elseif ($taxes == 1)
							$categoryProducts[$key]['displayed_price'] = Product::getPriceStatic((int)$categoryProduct['id_product'], false, NULL, 2);
					}
		
			// Get positions
			$middlePosition = round($sizeOfCategoryProducts / 2, 0);
			$productPosition = $this->getCurrentProduct($categoryProducts, (int)$idProduct);
		
			// Flip middle product with current product
			if ($productPosition)
			{
				$tmp = $categoryProducts[$middlePosition-1];
				$categoryProducts[$middlePosition-1] = $categoryProducts[$productPosition];
				$categoryProducts[$productPosition] = $tmp;
			}
		
			// If products tab higher than 30, slice it
			if ($sizeOfCategoryProducts > 30)
			{
				$categoryProducts = array_slice($categoryProducts, $middlePosition - 15, 30, true);
				$middlePosition = 15;
			}
		}
		
		// Display tpl
		$this->smarty->assign(array(
			'categoryProducts' => $categoryProducts,
			'middlePosition' => (int)$middlePosition,
			'ProdDisplayPrice' => Configuration::get('PRODUCTSCATEGORY_DISPLAY_PRICE')));

		return $this->display(__FILE__, 'tdproductscategory.tpl');
	}
	
	public function hookHeader($params)
	{

	}
}