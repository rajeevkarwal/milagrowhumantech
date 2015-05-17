<?php
class MultiFeatures extends Module {
    public function __construct() {
	$this->name    = 'multifeatures';
	$this->tab     = 'front_office_features';
	$this->author  = 'Silbersaiten';
	$this->module_key = '943a7d75ec43d6c6025934d1c305ab58';
	$this->version = '0.1';
	
	parent::__construct();
	
	$this->displayName = $this->l('MultiFeatures');
	$this->description = $this->l('Allows you to use multiple features for products instead of just one');
    }
    
    public function install() {
	if (parent::install() &&
	    $this->registerHook('displayHeader') &&
	    $this->registerHook('actionAdminControllerSetMedia') &&
	    $this->registerHook('displayBackOfficeHeader') &&
	    $this->registerHook('actionProductAdd') &&
	    $this->registerHook('actionProductUpdate')) {
		Db::getInstance()->Execute('
		    ALTER TABLE
			`' . _DB_PREFIX_ . 'feature_product`
		    DROP PRIMARY KEY,
		    ADD PRIMARY KEY (
			`id_feature`,
			`id_product`,
			`id_feature_value`
		    )'
		);
	    
	    return true;
	}
	
	return false;
    }
    
    private static function getProductFeatures($id_product, $id_lang) {
	$features = array();
	
	$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
	SELECT
	    `id_product`,
	    `name`,
	    `value`,
	    pf.`id_feature`,
	    pf.`id_feature_value`
	FROM
	    `' . _DB_PREFIX_ . 'feature_product` pf
	LEFT JOIN
	    `' . _DB_PREFIX_ . 'feature_lang` fl
	    ON (
		fl.id_feature = pf.id_feature AND fl.id_lang = ' . (int)$id_lang . '
	    )
	LEFT JOIN
	    `' . _DB_PREFIX_ . 'feature_value_lang` fvl
	    ON (
		fvl.id_feature_value = pf.id_feature_value AND fvl.id_lang = ' . (int)$id_lang . '
	    )
	LEFT JOIN `' . _DB_PREFIX_ . 'feature` f
	ON (
	    f.id_feature = pf.id_feature
	)
	WHERE
	    `id_product` = ' . (int)$id_product . '
	ORDER BY f.position ASC');
	
	if ($result && sizeof($result)) {
	    foreach ($result as $row) {
		if ( ! isset($features[$row['id_feature']])) {
		    $features[$row['id_feature']] = array();
		}
		
		if ( ! isset($features[$row['id_feature']][$row['id_feature_value']])) {
		    $features[$row['id_feature']][$row['id_feature_value']] = $row;
		}
	    }
	}
	
	return sizeof($features) ? $features : false;
    }
    
    public function hookDisplayHeader($params) {
	$controller = Tools::getValue('controller');
	$id_product = Tools::getValue('id_product');
	
	if ($controller == 'product' && Validate::isUnsignedId($id_product)) {
	    $features = self::getProductFeatures((int)$id_product, $this->context->language->id);
	    
	    if ($features) {
		$this->context->controller->addJs($this->_path . 'js/multifeatures_front.js');
		
		return '
		<script type="text/javascript">
		    var pfeatures = ' . Tools::jsonEncode($features) . ';
		</script>';
	    }
	}
    }
    
    public function hookActionAdminControllerSetMedia($params) {
	if (Tools::getIsset('updateproduct') || Tools::getIsset('addproduct')) {
	    $this->context->controller->addJs($this->_path . 'js/jqwatch.js');
	    $this->context->controller->addJs($this->_path . 'js/multifeatures_back.js');
	    $this->context->controller->addCss($this->_path . 'css/style.css');
	}
    }
    
    public function hookDisplayBackOfficeHeader($params) {
	if (Tools::getIsset('updateproduct') || Tools::getIsset('addproduct')) {
	    if (Tools::getIsset('updateproduct')) {
		$features = self::getProductFeatures((int)Tools::getValue('id_product'), $this->context->language->id);
	    }
	    else {
		$features = false;
	    }
	    
	    $html = '
	    <script type="text/javascript">
		var stringCollapse = "' . $this->l('Collapse features') . '";
		var stringExpand = "' . $this->l('Expand fields') . '";';
	    
	    if ($features) {
		$html.= '
		    var pfeatures = ' . Tools::jsonEncode($features) . ';';
	    }
	    
	    $html.= '</script>';
	    
	    return $html;
	}
    }
    
    public function hookActionProductAdd($params) {
	$product = $params['product'];
	
	$features = Tools::getValue('multifeature');

//	$product->deleteProductFeatures();
	
	if (is_array($features) && sizeof($features)) {
	    foreach ($features as $id_selected_feature => $selected_features) {
		if (is_array($selected_features) && sizeof($selected_features)) {
		    foreach ($selected_features as $id_selected_feature_value) {
			$product->addFeaturesToDB($id_selected_feature, $id_selected_feature_value);
		    }
		}
	    }
	}
    }
    
    public function hookActionProductUpdate($params) {
	return $this->hookActionProductAdd($params);
    }
}
