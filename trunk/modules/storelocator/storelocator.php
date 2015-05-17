<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hitanshu
 * Date: 24/8/13
 * Time: 12:54 PM
 * To change this template use File | Settings | File Templates.
 */

class StoreLocator extends Module
{

    protected $_html = '';

    public $_errors = array();

    public $context;

    public function __construct()
    {
        $this->name = 'storelocator';
        $this->tab = 'front_office_features';
        $this->version = '1.0';
        $this->author = 'GAPS';
        $this->module_key = 'a2b7cee1897e09a7783e7d1fa5738873';
        $this->need_instance = 0;
        parent::__construct();

        $this->displayName = $this->l('StoreLocator');
        $this->description = $this->l('Millagrow Store Locator List');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        $this->page = basename(__FILE__, '.php');

    }

    public function install()
    {
        if (!parent::install() && !$this->registerHook('actionAdminControllerSetMedia')
        )
            return false;

        include_once(_PS_MODULE_DIR_ . '/' . $this->name . '/storelocator_install.php');
        $store_locator_install = new StoreLocatorInstall();
        $store_locator_install->createTables();

        return true;
    }

    public function uninstall()
    {
        return parent::uninstall();
    }

    public function hookActionAdminControllerSetMedia()
    {

        $this->context->controller->addCss($this->_path . 'css/admin-back.css');
    }

    public function fetchTemplate($name)
    {
        if (_PS_VERSION_ < '1.4')
            $this->context->smarty->currentTemplate = $name;
        elseif (_PS_VERSION_ < '1.5') {
            $views = 'views/templates/';
            if (@filemtime(dirname(__FILE__) . '/' . $name))
                return $this->display(__FILE__, $name);
            elseif (@filemtime(dirname(__FILE__) . '/' . $views . 'hook/' . $name))
                return $this->display(__FILE__, $views . 'hook/' . $name); elseif (@filemtime(dirname(__FILE__) . '/' . $views . 'front/' . $name))
                return $this->display(__FILE__, $views . 'front/' . $name); elseif (@filemtime(dirname(__FILE__) . '/' . $views . 'back/' . $name))
                return $this->display(__FILE__, $views . 'back/' . $name);
        }

        return $this->display(__FILE__, $name);
    }


    public static function getShopDomainSsl($http = false, $entities = false)
    {
        if (method_exists('Tools', 'getShopDomainSsl'))
            return Tools::getShopDomainSsl($http, $entities);
        else {
            if (!($domain = Configuration::get('PS_SHOP_DOMAIN_SSL')))
                $domain = self::getHttpHost();
            if ($entities)
                $domain = htmlspecialchars($domain, ENT_COMPAT, 'UTF-8');
            if ($http)
                $domain = (Configuration::get('PS_SSL_ENABLED') ? 'https://' : 'http://') . $domain;
            return $domain;
        }
    }

    protected function getCurrentUrl()
    {
        $protocol_link = Tools::usingSecureMode() ? 'https://' : 'http://';
        $request = $_SERVER['REQUEST_URI'];
        $pos = strpos($request, '?');

        if (($pos !== false) && ($pos >= 0))
            $request = substr($request, 0, $pos);

        $params = urlencode($_SERVER['QUERY_STRING']);

        return $protocol_link . Tools::getShopDomainSsl() . $request . '?' . $params;
    }


    public function getContent()
    {
        $this->html = '<h2>' . $this->displayName . '</h2>';
        $this->html .= '<link media="all" type="text/css" rel="stylesheet" href="' . $this->_path . 'views/css/back.css"/>';
        if (Tools::getValue('saveStore') != NULL || Tools::getValue('editStore') != NULL) {
            if (!($product = trim(Tools::getValue('product'))))
                $this->_errors[] = Tools::displayError('Product is Required');
            if (!($state = trim(Tools::getValue('state'))))
                $this->_errors[] = Tools::displayError('State is Required');
            if (!($city = trim(Tools::getValue('city'))))
                $this->_errors[] = Tools::displayError('City is Required');
            if (!($location = trim(Tools::getValue('location'))))
                $this->_errors[] = Tools::displayError('Location is Required');
            if (!($store = trim(Tools::getValue('storeName'))))
                $this->_errors[] = Tools::displayError('Store Name is Required');
            if (!($phone = trim(Tools::getValue('phoneNumber'))))
                $this->_errors[] = Tools::displayError('Phone is Required');
            if (!($address = html_entity_decode(Tools::getValue('address'))))
                $this->_errors[] = Tools::displayError('Address is Required');
            if (count($this->_errors) == 0) {
                $error = $this->postProcess();
                if (!empty($error))
                    $this->_errors[] = Tools::displayError($error);

            }
            if (isset($this->_errors) && count($this->_errors) > 0) {
                $this->html .= $this->errorBlock($this->_errors);
                if (Tools::getValue('saveStore') != NULL)
                    $_GET['sl_tab'] = 'create_store';
                elseif (Tools::getValue('editStore') != NULL)
                    $_GET['sl_tab'] = 'edit_store';
            } else {
                $_GET['sl_tab'] = 'storelocatorlist'; //redirect to overview after post action
            }
        }

        $url = $_SERVER['REQUEST_URI'];
        if (strpos($url, '&sl_tab') > 0)
            $url = substr($url, 0, strpos($url, '&sl_tab'));

        $this->html .= '<ul><li ' . (Tools::getValue('sl_tab') == "storelocatorlist" || Tools::getValue('sl_tab') == NULL || Tools::getValue('sl_tab') == '' ? 'class="sl_admin_tab_active"' : 'class="sl_admin_tab"') . '><a style="padding:8px 8px 4px 4px;" href="' . $url . '&sl_tab=" id = "sl_storelocatorlist">' . $this->l('Store Locators') . '</a></li>
		<li ' . (Tools::getValue('sl_tab') == "create_store" ? 'class="sl_admin_tab_active"' : 'class="sl_admin_tab"') . '><a style="padding:8px 8px 4px 4px;" href="' . $url . '&sl_tab=create_store" id = "sl_create_store">' . $this->l('Add New Store') . '</a></li></ul>';
        if (Tools::getValue('sl_tab') == 'create_store')
            $this->html .= $this->displayCreateStore($url);
        else if (Tools::getValue('sl_tab') == 'edit_store') {
            $id_store_locator = Tools::getValue('id_store_locator');
            $this->html .= $this->displayEditStore($id_store_locator, $url);
        } else if (Tools::getValue('sl_tab') == 'delete_store') {
            $id_store_locator = Tools::getValue('id_store_locator');
            $this->html .= $this->deleteStore($id_store_locator, $url);
        } else
            $this->html .= $this->displayStores($url);
        return $this->html;
    }

    private function errorBlock($errors)
    {
        $this->context->smarty->assign(array(
            'errors' => $errors
        ));

        return $this->fetchTemplate('/views/templates/back/errors.tpl');
    }

    private function displayStores($url)
    {
        $page = Tools::getValue('page');
        $page = !empty($page) ? $page : 1;
        $product = Tools::getValue('product');
        $state = Tools::getValue('state');
        $city = Tools::getValue('city');
        $previousPage = 0;
        $nextPage = 0;
        $pageCount = 10;
        $storeLocators = $this->getStoreLocatorList($product, $state, $city, $page, $pageCount);
        $totalStoresLocators = $this->getTotalStoreLocators($product, $state, $city);
        if (($page * $pageCount) < (int)$totalStoresLocators) {
            $nextPage = $page + 1;
        }
        if ($page > 1)
            $previousPage = $page - 1;

        $products = $this->getProductsAndStatesAndCities();

        $this->context->smarty->assign(array(
            'products' => json_encode($products),
            'selectedProduct' => $product,
            'selectedState' => $state,
            'selectedCity' => $city,
            'storeLocatorResults' => $storeLocators,
            'page' => $page,
            'previous' => $previousPage,
            'next' => $nextPage,
            'url' => $url
        ));

        $output = $this->fetchTemplate('/views/templates/back/store-list.tpl');
        return $output;
    }

    private function displayCreateStore($url)
    {
        $category = $this->getCategories();

        $this->context->smarty->assign(array(
            'products' => $category,
            'selectedProduct' => Tools::getValue('product'),
            'selectedState' => Tools::getValue('state'),
            'selectedCity' => Tools::getValue('city'),
            'location' => Tools::getValue('location'),
            'storeName' => Tools::getValue('storeName'),
            'phoneNumber' => Tools::getValue('phoneNumber'),
            'address' => html_entity_decode(Tools::getValue('address')),
            'states' => $this->getStates(),
            'url' => $url
        ));
        return $this->fetchTemplate('/views/templates/back/add-store.tpl');
    }

    private function getCategories()
    {
        $maxdepth = 2;
        if ($result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
				SELECT DISTINCT c.id_parent, c.id_category, cl.name, cl.description, cl.link_rewrite
				FROM `' . _DB_PREFIX_ . 'category` c
				INNER JOIN `' . _DB_PREFIX_ . 'category_lang` cl ON (c.`id_category` = cl.`id_category` AND cl.`id_lang` = ' . (int)$this->context->language->id . Shop::addSqlRestrictionOnLang('cl') . ')
				INNER JOIN `' . _DB_PREFIX_ . 'category_shop` cs ON (cs.`id_category` = c.`id_category` AND cs.`id_shop` = ' . (int)$this->context->shop->id . ')
				WHERE (c.`active` = 1 OR c.`id_category` = ' . (int)Configuration::get('PS_HOME_CATEGORY') . ')
				AND c.`id_category` != ' . (int)Configuration::get('PS_ROOT_CATEGORY') . '
				' . ((int)$maxdepth != 0 ? ' AND `level_depth` <= ' . (int)$maxdepth : '') . '
			    ORDER BY `level_depth` ASC, ' . (Configuration::get('BLOCK_CATEG_SORT') ? 'cl.`name`' : 'cs.`position`') . ' ' . (Configuration::get('BLOCK_CATEG_SORT_WAY') ? 'DESC' : 'ASC'))
        )
            return $result;
        return array();
    }

    private function getStates()
    {
        return State::getStatesByIdCountry(110);
    }

    private function displayEditStore($id, $url)
    {
        $storeDetails = $this->getStoreLocator($id);
        $category = $this->getCategories();
        $state = trim(Tools::getValue('state'));
        $city = trim(Tools::getValue('city'));
        $product = trim(Tools::getValue('product'));
        $location = trim(Tools::getValue('location'));
        $store = trim(Tools::getValue('storeName'));
        $landline = trim(Tools::getValue('phoneNumber'));
        $address = html_entity_decode(Tools::getValue('address'));
        $state = !empty($state) ? $state : $storeDetails['state'];
        $city = !empty($city) ? $city : $storeDetails['city'];
        $product = !empty($product) ? $product : $storeDetails['product'];
        $location = !empty($location) ? $location : $storeDetails['location'];
        $store = !empty($store) ? $store : $storeDetails['store_name'];
        $landline = !empty($landline) ? $landline : $storeDetails['landline'];
        $address = !empty($address) ? $address : $storeDetails['address'];
        $this->context->smarty->assign(array(
            'products' => $category,
            'selectedProduct' => $product,
            'selectedState' => $state,
            'selectedCity' => $city,
            'location' => $location,
            'storeName' => $store,
            'phoneNumber' => $landline,
            'address' => html_entity_decode($address),
            'id_store_locator' => $storeDetails['id_store_locator'],
            'states' => $this->getStates(),
            'url' => $url
        ));
        return $this->fetchTemplate('/views/templates/back/edit-store.tpl');

    }

    private function deleteStore($id, $url)
    {
        $id = intval($id);
        Db::getInstance()->Execute('DELETE FROM ' . _DB_PREFIX_ . 'store_locator WHERE id_store_locator = ' . $id);
        $error = Db::getInstance()->getMsgError();
        $html = '';
        if ($error) {
            $this->_errors[] = 'Sorry error occured while deleting store';
            $html=$this->errorBlock($this->_errors);
        }
        $html.=$this->displayStores($url);
        return $html;
    }

    private function postProcess()
    {
        $state = trim(Tools::getValue('state'));
        $city = trim(Tools::getValue('city'));
        $product = trim(Tools::getValue('product'));
        $location = trim(Tools::getValue('location'));
        $store = trim(Tools::getValue('storeName'));
        $phone = trim(Tools::getValue('phoneNumber'));
        $address = html_entity_decode(Tools::getValue('address'));
        $insertData = array('state' => $state, 'city' => $city, 'product' => $product, 'location' => $location, 'store_name' => $store, 'landline' => $phone, 'address' => $address);
        if (Tools::getValue('saveStore') != NULL) {
            Db::getInstance()->insert('store_locator', $insertData);
            if (!Db::getInstance()->Insert_ID())
                return $this->l('Sorry an error occured while saving store');
        } else if (Tools::getValue('editStore') != NULL) { //edit category
            Db::getInstance()->update('store_locator', $insertData, 'id_store_locator=' . Tools::getValue('id_store_locator'));
            $affectedRows = Db::getInstance()->Affected_Rows();
            $errorMsg = Db::getInstance()->getMsgError();
            if (!$affectedRows && !empty($errorMsg))
                return $this->l('Error Occured while updating store.');
        }
    }

    private function getProductsAndStatesAndCities()
    {
        $sql = 'select product,state,city from ' . _DB_PREFIX_ . 'store_locator order by product';
        if ($results = Db::getInstance()->ExecuteS($sql)) {
            $products = array();
            foreach ($results as $row) {
                if (!isset($products[$row['product']])) {
                    if (!in_array($row['city'], $products[$row['product']][$row['state']]))
                        $products[$row['product']][$row['state']][] = $row['city'];
                } else if (!in_array($row['city'], $products[$row['product']][$row['state']])) {
                    $products[$row['product']][$row['state']][] = $row['city'];
                }

            }
            return $products;
        }
    }

    private function getStoreLocatorList($product, $state, $city, $p = 1, $n = null)
    {
        $whereQuery = '';
        if (!empty($product) && empty($city) && empty($state))
            $whereQuery .= "where product='$product'";
        elseif (!empty($product) && !empty($state))
            $whereQuery .= "where product='$product' and state='$state'"; elseif (empty($product))
            $whereQuery .= ""; else
            $whereQuery .= "where product=$product and state='$state' and city='$city'";
        $sql = 'select * from ' . _DB_PREFIX_ . 'store_locator ' . $whereQuery . ($n ? 'LIMIT ' . (int)(($p - 1) * $n) . ', ' . (int)($n) : '');
        if ($results = Db::getInstance()->ExecuteS($sql)) {
            return $results;
        }
        return array();
    }

    private function getStoreLocator($id)
    {
        $sql = 'select * from ' . _DB_PREFIX_ . 'store_locator where id_store_locator=' . $id;
        if ($result = Db::getInstance()->getRow($sql)) {
            return $result;
        }
        return array();
    }

    private function getTotalStoreLocators($product, $state, $city)
    {
        $whereQuery = '';
        if (!empty($product) && empty($city) && empty($state))
            $whereQuery .= "where product='$product'";
        elseif (!empty($product) && !empty($state))
            $whereQuery .= "where product='$product' and state='$state'"; elseif (empty($product))
            $whereQuery .= ""; else
            $whereQuery .= "where product=$product and state='$state' and city='$city'";
        $sql = 'select count(*) as total from ' . _DB_PREFIX_ . 'store_locator ' . $whereQuery;
        if ($results = Db::getInstance()->getValue($sql)) {
            return $results;
        }
        return 0;
    }


}