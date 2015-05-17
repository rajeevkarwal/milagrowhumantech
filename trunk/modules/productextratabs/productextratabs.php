<?php

/**
 * @author PresTeamShop.com
 * @copyright PresTeamShop.com - 2013
 */

if( _PS_VERSION_ > '1.3.1.1' ) {
    if (!defined('_CAN_LOAD_FILES_'))
        exit;
}

require_once (_PS_MODULE_DIR_ . '/productextratabs/classes/ProductExtraTabsCore.php');

define ('VAR_MODULE_EXITO', 0);
define ('VAR_MODULE_ERROR', -1);

global $_ProductExtraTabs;
$_ProductExtraTabs = (object) array(
        'Types' => (object) array(
            'Content' => 'content',
            'Contact' => 'contact'
        )
);

class ProductExtraTabs extends ProductExtraTabsCore
{    
    static  $list_categories = '';
    
    private $GLOBALS_SMARTY = array();
    private $GLOBAL = array();
        
    protected $_configVars = array(
        array('name' => 'PET_VERSION', 'default_value' => '1.1.4')
    );

    public function __construct()
    {
        global $_ProductExtraTabs;
        
        $this->prefix_module = 'PET';
        $this->name = 'productextratabs';
        $this->tab = floatval(substr(_PS_VERSION_,0,3)) < 1.4 ? 'Development Team - PresTeamShop.com' : 'front_office_features';
        $this->version = '1.1.4';
		$this->author = 'PresTeamShop.com';
        $this->module_key = '43550bce1a137e05171febc9be92b922';
        
        parent::__construct();
        
        $this->name_file = substr(basename(__FILE__), 0, strlen(basename(__FILE__)) - 4);        

        self::$list_categories = '<option value="-1">' . $this->l('All categories', $this->name_file) . '</option>';

        $this->displayName = 'Product Extra Tabs';
        $this->description = $this->l('Add additional tabs to their products to provide more relevant information details', $this->name_file);
        $this->confirmUninstall = $this->l('Are you sure you want uninstall ?', $this->name_file);
        
		require_once(_PS_MODULE_DIR_ . $this->name . '/classes/PETTabClass.php');
        require_once(_PS_MODULE_DIR_ . $this->name . '/classes/PETTabContentClass.php');
        
        //Asignacion de valores a constantes de servidor
        $this->GLOBAL = $_ProductExtraTabs;
        
        //Asingacion de valores a constantes smarty
        $this->GLOBALS_SMARTY = array(
            'TYPES' => array(
                $this->GLOBAL->Types->Content => $this->l('Content'),
                $this->GLOBAL->Types->Contact => $this->l('Form contact')
            )
        );
        
        //update version
        if (Module::isInstalled($this->name))
            $this->updateVersion($this);
    }
    
	public function install()
	{	
        if (!parent::install() OR
            !$this->registerHook('productTab') OR            
            !$this->registerHook('productTabContent'))
    		return false;
        
        if(version_compare(_PS_VERSION_, '1.3') >= 0)
            if (!$this->registerHook('backOfficeFooter'))
                return false;
                 
        return true;
    }
    
    public function uninstall()
	{            
		if (!parent::uninstall())
			return false;		
		return true;
	}

    public function getContent()
    {
        $this->_html = '<h2>'.$this->displayName.' - v'.$this->version.'</h2>';

        parent::getContent();
                
        $this->displayErrors();
        $this->_displayForm();
        
        return $this->_html;
    }
    
    private function _displayForm()
    {        
        $js_files = array();
        $css_files = array();
        
        $iso = Language::getIsoById((int)($this->_cookie->id_lang));
        
        
        if(version_compare(_PS_VERSION_, '1.5.4') >= 0){
            array_push($js_files, _PS_JS_DIR_ . 'jquery/ui/jquery.ui.core.min.js');
            array_push($js_files, _PS_JS_DIR_ . 'jquery/ui/jquery.ui.widget.min.js');
            
            array_push($js_files, _PS_JS_DIR_ . 'jquery/ui/jquery.ui.tabs.min.js');
            array_push($js_files, _PS_JS_DIR_ . 'jquery/ui/jquery.ui.button.min.js');
            array_push($js_files, _PS_JS_DIR_ . 'jquery/ui/jquery.ui.mouse.min.js');
            array_push($js_files, _PS_JS_DIR_ . 'jquery/ui/jquery.ui.sortable.min.js');
            array_push($js_files, _PS_JS_DIR_ . 'jquery/plugins/jquery.cookie-plugin.js');
            
            array_push($css_files, _PS_JS_DIR_ . 'jquery/ui/themes/base/jquery.ui.all.css');            
            array_push($css_files, _PS_JS_DIR_ . 'jquery/ui/themes/base/jquery.ui.tabs.css');
            array_push($css_files, _PS_JS_DIR_ . 'jquery/ui/themes/base/jquery.ui.button.css');
        }else{
            if(version_compare(_PS_VERSION_, '1.5.0.0') < 0)
                array_push($js_files, $this->_path . 'js/lib/jquery/jquery-1.9.1.js');                        
            
            array_push($js_files, $this->_path . 'js/lib/jquery-ui/jquery-ui-1.10.3.custom.min.js');
            array_push($js_files, $this->_path . 'js/lib/jquery/plugins/jquery.cookie-plugin.js');
            
            array_push($css_files, $this->_path . 'js/lib/jquery-ui/themes/flick/jquery-ui-1.10.3.custom.min.css');
        }
        
        array_push($js_files, $this->_path . 'js/lib/script.base64.js');
        array_push($js_files, $this->_path . 'js/tools.js');               
               
        if (version_compare(_PS_VERSION_, '1.5.0.0') >= 0) {
            array_push($js_files, _PS_JS_DIR_.'tiny_mce/tiny_mce.js');
            array_push($js_files, _PS_JS_DIR_.'tinymce.inc.js');

            $this->_smarty->assign(array(
                'TINY_ISO_LANG' => (file_exists(_PS_ROOT_DIR_.'/js/tiny_mce/langs/'.$iso.'.js') ? $iso : 'en'),
                'TINY_PATH_CSS' => _THEME_CSS_DIR_,
                'TINY_AD' => dirname($_SERVER['PHP_SELF']),
                'TYNY_15' => true
            ));
        }elseif (version_compare(_PS_VERSION_, '1.4.0.0') >= 0) {
            array_push($js_files, __PS_BASE_URI__ . 'js/tiny_mce/tiny_mce.js');
            array_push($js_files, __PS_BASE_URI__ . 'js/tinymce.inc.js');

            $this->_smarty->assign(array(
                'TINY_ISO_LANG' => (file_exists(_PS_ROOT_DIR_ . '/js/tiny_mce/langs/' . $iso . '.js') ? $iso : 'en'),
                'TINY_PATH_CSS' => _THEME_CSS_DIR_,
                'TINY_AD' => dirname($_SERVER['PHP_SELF'])
            ));            
        } else {
            $this->_smarty->assign(array(
                'TINY_CONTENT_CSS' => __PS_BASE_URI__ . 'themes/' . _THEME_NAME_ . '/css/global.css',
                'TINY_DOC_BASE_URL' => __PS_BASE_URI__,
                'TINY_LANG' => (file_exists(_PS_ROOT_DIR_ . '/js/tinymce/jscripts/tiny_mce/langs/' . $iso . '.js') ? $iso : 'en')
            ));

            array_push($js_files, __PS_BASE_URI__ . 'js/tinymce/jscripts/tiny_mce/jquery.tinymce.js');
            array_push($js_files, __PS_BASE_URI__ . 'js/tinymce/jscripts/tiny_mce/tiny_mce.js');
        }                 
                
        array_push($js_files, $this->_path . 'js/'.$this->name.'_back.js');        
        array_push($css_files, $this->_path . 'css/'.$this->name.'_back.css');      
        
        $defaultLanguage = intval(Configuration::get('PS_LANG_DEFAULT'));
        $languages = Language::getLanguages(false);
        
        $categories = Category::getCategories($this->_cookie->id_lang, false);
        self::recurseCategory($categories, null);        
        
        $paramsBack = array('PRODUCTEXTRATABS_DIR'              => $this->_path,
                            'PRODUCTEXTRATABS_IMG'              => $this->_path . 'img/',
                            'GLOBALS_SMARTY'                    => $this->GLOBALS_SMARTY,
                            'GLOBALS'                           => $this->jsonEncode($this->GLOBAL),
                            'LIST_TABS'                         => PETTabClass::getTabs((int)$this->_cookie->id_lang),
                            'LIST_TABS_CONTENT'                 => PETTabContentClass::getTabsContent((int)$this->_cookie->id_lang),
                            'CATEGORIES'                        => self::$list_categories,
                            'PRODUCTS'                          => $this->getProductsByCategory(),
                            'DEFAULT_LENGUAGE'                  => $defaultLanguage,
                            'LANGUAGES'                         => $languages,
                            'FLAGS_TAB'                         => $this->displayFlags($languages, $defaultLanguage, utf8_encode('lang_name_tab¤ctab_content'), 'lang_name_tab', true),
                            'FLAGS_TAB_CONTENT'                 => $this->displayFlags($languages, $defaultLanguage, utf8_encode('lang_name_tab¤ctab_content'), 'ctab_content', true),
                            'CONFIGS'                           => $this->configVars,
                            'JS_FILES'                          => $js_files,
                            'CSS_FILES'                         => $css_files,                          
                            'ACTION_URL'                        => Tools::safeOutput($_SERVER['PHP_SELF']).'?'.$_SERVER['QUERY_STRING']);

        $this->_smarty->assign('paramsBack', $paramsBack);
        $this->_html .= $this->display(__FILE__, $this->name.'_back.tpl');
    }
    
    public function getType($id_tab) {
        $PETTabClass = new PETTabClass($id_tab);
        
        if (!empty($PETTabClass->type))
            return $this->jsonEncode(array('message_code' => VAR_MODULE_EXITO, 'type' => $PETTabClass->type));
        else
            return $this->jsonEncode(array('message_code' => VAR_MODULE_ERROR, 'message' => $this->l('Tab not exists')));
        
    }
    
    public function updateTab($id_tab, $name, $active, $type){
        $arrName = array();
        $arrTmp = explode('@', $name);
        
        foreach ($arrTmp AS $item){
            $arrItem = explode('|', $item);
            
            $arrName[$arrItem[0]] = $arrItem[1];
        }
        
        if (empty($id_tab)){
            $PETTabClass = new PETTabClass();
            $PETTabClass->name = $arrName;
            $PETTabClass->type = $type;

            if ($PETTabClass->add())
                return $this->jsonEncode(array('message_code' => VAR_MODULE_EXITO, 'message' => $this->l('The tab was successfully saved.')));
            else
                return $this->jsonEncode(array('message_code' => VAR_MODULE_ERROR, 'message' => $this->l('An error occurred while trying to save.')));
        }else{
            $PETTabClass = new PETTabClass((int)($id_tab));
            $PETTabClass->name = $arrName;
            $PETTabClass->active = $active;
            $PETTabClass->type = $type;
        
            if ($PETTabClass->update())
                return $this->jsonEncode(array('message_code' => VAR_MODULE_EXITO, 'message' => $this->l('The tab was successfully updated.')));
            else
                return $this->jsonEncode(array('message_code' => VAR_MODULE_ERROR, 'message' => $this->l('An error occurred while trying to update.')));
        }
    } 
    
    public function deleteTab($id_tab){                
        if (!empty($id_tab)){
            $PETTabClass = new PETTabClass($id_tab);
            
            if ($PETTabClass->delete())
                return $this->jsonEncode(array('message_code' => VAR_MODULE_EXITO, 'message' => $this->l('The tab was successfully deleted.')));
            else
                return $this->jsonEncode(array('message_code' => VAR_MODULE_ERROR, 'message' => $this->l('An error occurred while trying to delete.')));
        }        
    }
    
    public function getProductsByCategory($id_category = 1){
        return DB::getInstance()->ExecuteS('SELECT pl.id_product, pl.name 
                                                        FROM '._DB_PREFIX_.'category_product AS cp, '._DB_PREFIX_.'product_lang AS pl
                                                    WHERE
                                                        cp.id_product = pl.id_product AND
                                                        cp.id_category = '.$id_category.' AND
                                                        pl.id_lang = '.(int)(Configuration::get('PS_LANG_DEFAULT')));
    }
    
    public function getExtraTabsFilter($id_tab = -1, $id_category = 1, $id_product = -1){
        
        $where = "WHERE 1=1 ";
        if ($id_tab != 0) {
            $where .= " AND t.`id_tab` = {$id_tab} ";
        }
        
        if ($id_category != 0) {
            $where .= " AND tc.`id_category` = {$id_category} ";
        }
        
        if ($id_product != 0) {
            $where .= " AND tc.`id_product` = {$id_product} ";
        }
                
        return PETTabContentClass::getTabsContent(NULL, $where);        
    }
    
    public function saveTabContentByTabLang() {
        
        $id_tab = Tools::getValue('id_tab');
        $id_product = Tools::getValue('id_product');
        $_content = Tools::getValue('content');
        
        $upd = Tools::getValue('upd');
        
        $content = json_decode($_content);
        
        $product = new Product($id_product);
        
        $id_tab_content = PETTabContentClass::tab_content_exist($id_tab, $id_product, $product->id_category_default);
        
        $updated = false;
        if ($upd == "false") {
            $updated = $this->deleteTabContent($id_tab_content);
        }
        else {
            $updated = $this->updateTabContent($id_tab_content, $id_tab, $id_product, $product->id_category_default, $content);
        }
                        
        if ($updated)
            return $this->jsonEncode(array('message_code' => VAR_MODULE_EXITO, 'message' => $this->l('The tab content was successfully updated.')));
        else
            return $this->jsonEncode(array('message_code' => VAR_MODULE_ERROR, 'message' => $this->l('An error occurred while trying to update.')));
        
    }

    public function updateTabsPosition($order_tabs)
    {
        if (empty($order_tabs))
            return $this->jsonEncode(array('message_code' => VAR_MODULE_ERROR, 'message' => $this->l('An error occurred while trying update the positions.')));

        $defaultLanguage = intval(Configuration::get('PS_LANG_DEFAULT'));
        $position = 1;
        $errors = array();
        $success = VAR_MODULE_EXITO;

        foreach ($order_tabs AS $id_tab) {
            $PETTabClass = new PETTabClass((int)$id_tab);
                        
            $PETTabClass->position = $position;

            if (!$PETTabClass->update()) {
                $errors[] = 'An error has ocurred.';
            }
            //echo "<pre>"; print_r($PETTabClass); echo "</pre>";
            $position++;
        }

        return array(
            'message_code' => !sizeof($errors) ? VAR_MODULE_EXITO : VAR_MODULE_ERROR,
            'errors' => $errors
        );
    }
    
    public function updateTabContent($id_tab_content, $id_tab, $id_product, $id_category, $content){ 
        //verifica que no exista ya las mismas condiciones del tab
        if (empty($id_tab_content) && PETTabContentClass::existTabProduct($id_tab, $id_product, $id_category))
            return $this->jsonEncode(array('message_code' => VAR_MODULE_ERROR, 'message' => $this->l('The tab and product, already created, if you want to change it please look in the list and edit it.')));
            
        //verifica que el tab ya no este asiganado a "Todos los productos" teniendo en cuenta el id de categoria.
        if (empty($id_tab_content)){
            $id_content_tab = PETTabContentClass::tab_content_exist($id_tab, -1, $id_category);
            
            if ($id_content_tab)
                return $this->jsonEncode(array('message_code' => VAR_MODULE_ERROR, 'message' => $this->l('Can not be saved the contents of a tab that is already created and associated to all products.')));
        }                            

        if (!is_array($content))
            $content = $this->jsonDecode($content);
                
        $arrContent = array();        
        foreach ($content as $_content) {
            $arrContent[$_content->id_lang] = base64_decode($_content->content);
        }                
        
        $PETTabContentClass = new PETTabContentClass($id_tab_content);            
        $PETTabContentClass->id_tab = $id_tab;
        $PETTabContentClass->id_product = $id_product;
        $PETTabContentClass->id_category = $id_category;
        $PETTabContentClass->content = $arrContent;

        if ($PETTabContentClass->save())
            return $this->jsonEncode(array('message_code' => VAR_MODULE_EXITO, 'message' => $this->l('The tab content was successfully saved.')));
        else
            return $this->jsonEncode(array('message_code' => VAR_MODULE_ERROR, 'message' => $this->l('An error occurred while trying to save.')));

    }
    
    public function deleteTabContent($id_tab_content){                
        $PETTabContentClass = new PETTabContentClass($id_tab_content);
        
        if ($PETTabContentClass->delete())
            return $this->jsonEncode(array('message_code' => VAR_MODULE_EXITO, 'message' => $this->l('The tab content was successfully deleted.')));
        else
            return $this->jsonEncode(array('message_code' => VAR_MODULE_ERROR, 'message' => $this->l('An error occurred while trying to delete.')));      
    }    
    
    public function hookProductTab($id_tab_content){
        $id_product = Tools::getValue('id_product');
        
        if ($tabs = PETTabContentClass::getTabsByProduct((int)($id_product), (int)($this->_cookie->id_lang))){
            $this->_smarty->assign(array('pet_id_product' => $id_product, 'tabs' => $tabs));
            
            return $this->display(__FILE__, $this->name.'_productTab.tpl');
        }        
    }
    
    public function hookProductTabContent($params){
        global $smarty, $cookie;
        $id_product = Tools::getValue('id_product');
        
        if ($tabs = PETTabContentClass::getTabsByProduct((int)($id_product), (int)($this->_cookie->id_lang))){
            
            foreach ($tabs as $key => $tab) {
                if ($tab['type'] == $this->GLOBAL->Types->Contact) {
                    $link = new Link();
                    if(version_compare(_PS_VERSION_, '1.5') >= 0)
                        $actionUrl = $link->getPageLink('contact');
                    else if(version_compare(_PS_VERSION_, '1.5') >= 0)
                        $actionUrl = $link->getPageLink('contact-form.php');
                    else
                        $actionUrl = __PS_BASE_URI__ . 'contact-form.php';
                    
                    $email = Tools::safeOutput(Tools::getValue('from',
                    ((isset($cookie) && isset($cookie->email) && Validate::isEmail($cookie->email)) ? $this->cookie->email : '')));
                    $this->_smarty->assign(array(
                        'email' => $email,
                        'actionUrl' => $actionUrl,
                        'id_product' => $id_product,
                        'fileupload' => Configuration::get('PS_CUSTOMER_SERVICE_FILE_UPLOAD'),
                        'contacts' => Contact::getContacts($cookie->id_lang),
                        'message' => html_entity_decode(Tools::getValue('message'))
                    ));
                    
                    $tabs[$key]['content'] = $smarty->fetch(dirname(__FILE__) . '/contact-form.tpl');
                    
                }
            }
            
            
            $this->_smarty->assign(array(
                'pet_id_product' => $id_product, 'tabs' => $tabs
            ));
            
            return $this->display(__FILE__, $this->name.'_productTabContent.tpl');
        }
    }
    
    public function hookBackOfficeFooter($params)
    {
        if (_PS_VERSION_ > '1.5')
            return;
        
        if(Tools::getValue('tab')=='AdminCatalog' && Tools::getValue('updateproduct')!==false) {
            
            //product
            $id_product = Tools::getValue('id_product');
            
            $product = new Product((int)$id_product);
            
            $tabs = PETTabClass::getAvailablePetTabs();
                
            $languages = Language::getLanguages(false);
            $defaultLanguage = intval(Configuration::get('PS_LANG_DEFAULT'));
            
            $flags_names = array();
            
            for($i = 0; $i < count($tabs); $i++)
            {
                $tabs[$i]['own'] = FALSE;

                $content_tab = PETTabClass::getContentTabsByIdTab($tabs[$i]['id_tab'], $id_product);

                $default_content_tab = array();

                foreach ($content_tab as $content) {
                    if ($content['content'] != '') {
                        $own = PETTabContentClass::tab_content_exist($tabs[$i]['id_tab'], $id_product, $product->id_category_default);
                        
                        if ($own === FALSE) {
                            $default_content_tab[$content['id_lang']] = '';                   
                            continue;
                        }
                        else {
                            $tabs[$i]['own'] = TRUE;
                            $default_content_tab[$content['id_lang']] = $content['content'];
                        }
                    }

                }
                
                if (count($content_tab) == 0) {
                    foreach ($languages as $languaje) {
                        $default_content_tab[$languaje['id_lang']] = '';
                    }
                }

                //add content to var
                
                $flags_names[] = 'ctab_content_'.$tabs[$i]['id_tab'];
                
                $tabs[$i]['content'] = $default_content_tab;
                
            }
            
            $_flags_names = implode('¤', $flags_names);
            
            for($i = 0; $i < count($tabs); $i++)
            {
                $tabs[$i]['flags_content'] =  $this->displayFlags($languages, $defaultLanguage, utf8_encode($_flags_names), 'ctab_content_'.$tabs[$i]['id_tab'], true);
            }
            
            
            $this->_smarty->assign('id_product', $id_product);
            
            //language, flag
            $this->_smarty->assign('languages', $languages);
            $this->_smarty->assign('default_language', $defaultLanguage);

            $this->_smarty->assign('tabs', $tabs);
                                    
            $_html = $this->display(__FILE__, 'productextratabs_backOfficeFooter.tpl');
            
            
            $_html = base64_encode($_html);
            
            echo '
                <script>var productextratabs_dir = "' . $this->_path . '"</script>
                <script src="' . $this->_path . 'js/lib/script.base64.js"></script>
                <script src="' . $this->_path . 'js/productextratabs_backOfficeFooter.js"></script>
                <script>
                    $(document).ready(function() {
                    
                        $("div#tabPane1").append(\'<div class="tab-page" id="step8"></div>\');
                        
                        //$("#step8").innerHTML(\'<div id="step1" style="max-height: 1000px; overflow: auto;">\');
                        $("#step8").html(\'<h4 class="tab">8. Tabs</h4>\');
                        $("#step8").append(Base64.decode("' . $_html . '"));
                    });
                    </script>
                ';
            
        }
    }
    
    public static function recurseCategory($categories, $current, $id_category = 1, $id_selected = -1)
	{
        if((_PS_VERSION_ >= '1.5' && $id_category != 1) || version_compare(_PS_VERSION_, '1.5.0.0') < 0)
            if($current != null)
        		  self::$list_categories .= '<option value="'.$id_category.'"'.(($id_selected == $id_category) ? ' selected="selected"' : '').'>'.
                    str_repeat('&nbsp;', $current['infos']['level_depth'] * 5).stripslashes($current['infos']['name']).'</option>';
		if (isset($categories[$id_category]))
			foreach (array_keys($categories[$id_category]) AS $key)
				self::recurseCategory($categories, $categories[$id_category][$key], $key, $id_selected);
	}
}
?>