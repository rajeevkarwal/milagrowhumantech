<?php
class MultiFeatures extends Module {
    public function __construct() {
	$this->name    = 'multifeatures';
	$this->tab     = 'front_office_features';
	$this->author  = 'Silbersaiten';
	$this->version = '0.2';
	$this->module_key = '943a7d75ec43d6c6025934d1c305ab58';
	
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
		
		Db::getInstance()->Execute('
		    CREATE TABLE `' . _DB_PREFIX_ . 'product_feature_pos` (
			`id_product` int(10) unsigned NOT NULL,
			`id_feature` int(10) unsigned NOT NULL DEFAULT \'0\',
			`position` int(10) unsigned NOT NULL DEFAULT \'0\',
			PRIMARY KEY (`id_product`,`id_feature`),
			KEY `id_product` (`id_product`)
		    ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;'
		);
		
		Db::getInstance()->Execute('
		    CREATE TABLE `' . _DB_PREFIX_ . 'product_feature_value_pos` (
			`id_product` int(10) unsigned NOT NULL,
			`id_feature` int(10) unsigned NOT NULL DEFAULT \'0\',
			`id_feature_value` int(10) unsigned NOT NULL DEFAULT \'0\',
			`position` int(10) unsigned NOT NULL DEFAULT \'0\',
			PRIMARY KEY (`id_product`,`id_feature_value`),
			KEY `id_product` (`id_product`)
		    ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;'
		);
	    
	    return true;
	}
	
	return false;
    }
    
    public function uninstall() {
	if (parent::uninstall()) {
	    Db::getInstance()->Execute('DROP TABLE `' . _DB_PREFIX_ . 'product_feature_pos`');
	    Db::getInstance()->Execute('DROP TABLE `' . _DB_PREFIX_ . 'product_feature_value_pos`');
	    
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
	
//	if ($controller == 'product' && Validate::isUnsignedId($id_product)) {
//	    $features = self::getProductFeatures((int)$id_product, $this->context->language->id);
//	    $positions = self::getProductFeaturePositions((int)$id_product);

//	    if ($features) {
//		$this->context->controller->addJs($this->_path . 'js/multifeatures_front.js');
//
//		return '
//		<script type="text/javascript">
//		    var pfeatures = ' . Tools::jsonEncode($features) . ',
//			feature_positions = ' . Tools::jsonEncode($positions) . ';
//		</script>';
//	    }
//	}
    }
    
    public function hookActionAdminControllerSetMedia($params) {
	if (Tools::getIsset('updateproduct') || Tools::getIsset('addproduct')) {
	    $this->context->controller->addJqueryUi('ui.sortable');
	    $this->context->controller->addJs($this->_path . 'js/jqwatch.js');
	    $this->context->controller->addJs($this->_path . 'js/multifeatures_back.js');
	    $this->context->controller->addCss($this->_path . 'css/style.css');
	}
    }
    
    public function hookDisplayBackOfficeHeader($params) {
	if (Tools::getIsset('updateproduct') || Tools::getIsset('addproduct')) {
	    if (Tools::getIsset('updateproduct')) {
		$features = self::getProductFeatures((int)Tools::getValue('id_product'), $this->context->language->id);
		$features_positions = self::getProductFeaturePositions((int)Tools::getValue('id_product'));
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
		    var pfeatures = ' . Tools::jsonEncode($features) . ',
			feature_positions = ' . Tools::jsonEncode($features_positions) . ';';
	    }
	    
	    $html.= '</script>';
	    
	    return $html;
	}
    }
    
    public function deleteFeatures($id_product) {
	$features = Db::getInstance()->executeS('
	SELECT p.*, f.*
	FROM `' . _DB_PREFIX_ . 'feature_product` as p
	LEFT JOIN `' . _DB_PREFIX_ . 'feature_value` as f ON (f.`id_feature_value` = p.`id_feature_value`)
	WHERE `id_product` = ' . (int)$id_product . ' AND f.`custom` = 0');
	
	$id_list = array();

	if ($features && sizeof($features)) {
	    
	    foreach ($features as $feature) {
		array_push($id_list, (int)$feature['id_feature_value']);
	    }
	}
	
	if (sizeof($id_list)) {
	    $result = Db::getInstance()->execute('
	    DELETE FROM `'._DB_PREFIX_.'feature_product`
	    WHERE `id_product` = '.(int)$id_product . ' AND `id_feature_value` IN (' . (implode(',', $id_list)) . ')');
	}
    }
    
    public function hookActionProductAdd($params) {
	$product = $params['product'];
	
	$features = Tools::getValue('multifeature');

	if (is_array($features)) {
	    $this->deleteFeatures($product->id);
	    $this->deleteFeaturePositions($product->id);
	    
	    if (sizeof($features)) {
		$feature_positions = array();
		
		foreach ($features as $id_selected_feature => $selected_features) {
		    if (is_array($selected_features) && sizeof($selected_features)) {
			foreach ($selected_features as $id_selected_feature_value) {
			    if ( ! array_key_exists($id_selected_feature, $feature_positions)) {
				$feature_positions[$id_selected_feature] = array();
			    }
			    
			    array_push($feature_positions[$id_selected_feature], $id_selected_feature_value);

			    $product->addFeaturesToDB($id_selected_feature, $id_selected_feature_value);
			}
		    }
		}
		
		if (sizeof($feature_positions)) {
		    $feature_index = 1;
		    foreach ($feature_positions as $id_feature => $selected_features) {
			Db::getInstance()->Execute('INSERT INTO `' . _DB_PREFIX_ . 'product_feature_pos` VALUES (' . $product->id . ', ' . $id_feature . ', ' . $feature_index . ')');
			$feature_value_index = 1;
			
			foreach ($selected_features as $id_feature_value) {
			    Db::getInstance()->Execute('INSERT INTO `' . _DB_PREFIX_ . 'product_feature_value_pos` VALUES (' . $product->id . ', ' . $id_feature . ', ' . $id_feature_value . ', ' . $feature_value_index . ')');
			    
			    $feature_value_index++;
			}
			
			$feature_index++;
		    }
		}
	    }
	}
    }
    
    private static function getProductFeaturePositions($id_product) {
	$prepared_positions = array();
	
	// Using DESC instead of ASC, as it is easier to sort with jQuery later
	$feature_positions = Db::getInstance()->ExecuteS('SELECT * FROM `' . _DB_PREFIX_ . 'product_feature_pos` WHERE `id_product` = ' . (int)$id_product . ' ORDER BY `position` DESC');
	$feature_value_positions = Db::getInstance()->ExecuteS('SELECT * FROM `' . _DB_PREFIX_ . 'product_feature_value_pos` WHERE `id_product` = ' . (int)$id_product . ' ORDER BY `position` DESC');
	
	if ($feature_positions && sizeof($feature_positions)) {
	    foreach ($feature_positions as $feature_position) {
		$prepared_positions[$feature_position['id_feature']] = array();
	    }
	}
	
	if ($feature_value_positions && sizeof($feature_value_positions)) {
	    foreach ($feature_value_positions as $feature_value_position) {
		if (array_key_exists($feature_value_position['id_feature'], $prepared_positions)) {
		    array_push($prepared_positions[$feature_value_position['id_feature']], $feature_value_position['id_feature_value']);
		}
	    }
	}
	
	return sizeof($prepared_positions) ? $prepared_positions : false;
    }
    
    private function deleteFeaturePositions($id_product) {
	if ( ! Validate::isUnsignedId($id_product)) {
	    return false;
	}
	
	Db::getInstance()->Execute('DELETE FROM `' . _DB_PREFIX_ . 'product_feature_pos` WHERE `id_product` = ' . (int)$id_product);
	Db::getInstance()->Execute('DELETE FROM `' . _DB_PREFIX_ . 'product_feature_value_pos` WHERE `id_product` = ' . (int)$id_product);
    }
    
    public function hookActionProductUpdate($params) {
	return $this->hookActionProductAdd($params);
    }
}
