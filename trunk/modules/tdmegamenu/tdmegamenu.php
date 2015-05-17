<?php

if (!defined('_CAN_LOAD_FILES_'))
    exit;
include_once(dirname(__FILE__) . '/tdmegamenuModel.php');

class TdMegaMenu extends Module {
        private $_menu = '';
        private $_html = '';
	private $user_groups;
        public $_td_megamenu = '';
        
	/*
	 * Pattern for matching config values
	 */
	private $pattern = '/^([A-Z_]*)[0-9]+/';

	/*
	 * Name of the controller
	 * Used to set item selected or not in top menu
	 */
	private $page_name = '';  
        private $spacer_size = '5';
    public function __construct() {
        $this->name = 'tdmegamenu';
        $this->tab = 'front_office_features';
        $this->version = '1.1.1';
        $this->author = 'ThemesDeveloper';
        $this->need_instance = 0;
        parent::__construct();
        $this->displayName = $this->l('ThemesDeveloper Mega Menu');
        $this->description = $this->l('Add a mega menu on your shop.');
    }

    public function install() {
        //install table
        if (parent::install() && $this->registerHook('top')) {
            $response = TdMegamenuModel::createTables();
            return $response;
        }
        return false;
    }

    public function uninstall() {
        //uninstall table
        if (parent::uninstall()) {
            $response = TdMegaMenuModel::DropTables();
            return $response;
        }
        return false;
    }

    public function getContent() {
        $this->_html = '';
        $this->_html .= $this->adminHeadOptions();
        $this->_html .='
                <div class="main-container">
                    <div class="wrapper">';
        $this->_html .= '<h2>' . $this->l('ThemesDeveloper Mega Menu') . '</h2>';

        $this->_html .= '<div class="menu-add-area">';
        $this->_displayAdminDesign();
        $this->_html .='  </div>
                           <div class="display-shorting-menu">
                                    <legend><img src="../img/admin/details.gif" alt="List Of menu" title="List Of menu" />' . $this->l('List Of menu') . '</legend>
                            ';
        $this->_html .= $this->adminMenuLikeList();
        $this->_html .=' 
                          <div class="clearboth"></div>   
                         </div>
                    </div>
                </div>

           ';

        return $this->_html;
    }

    private function getCategoryOption($id_category = 1, $id_lang = false, $id_shop = false, $recursive = true) {
        $id_lang = $id_lang ? (int) $id_lang : (int) Context::getContext()->language->id;
        $category = new Category((int) $id_category, (int) $id_lang, (int) $id_shop);

        if (is_null($category->id))
            return;

        if ($recursive) {
            $children = Category::getChildren((int) $id_category, (int) $id_lang, true, (int) $id_shop);
            $spacer = str_repeat('&nbsp;', $this->spacer_size * (int) $category->level_depth);
        }

        $shop = (object) Shop::getShop((int) $category->getShopID());
        $this->_html .= '<option value="CAT' . (int) $category->id . '">' . (isset($spacer) ? $spacer : '') . $category->name . '</option>';

        if (isset($children) && count($children))
            foreach ($children as $child) {
                $this->getCategoryOption((int) $child['id_category'], (int) $id_lang, (int) $child['id_shop']);
            }
    }

    private function getCategory($id_category, $id_lang = false, $id_shop = false) {
        $category_menu = '';
        $id_lang = $id_lang ? (int) $id_lang : (int) Context::getContext()->language->id;
        $category = new Category((int) $id_category, (int) $id_lang);

        if ($category->level_depth > 1)
            $category_link = $category->getLink();
        else
            $category_link = $this->context->link->getPageLink('index');

        if (is_null($category->id))
            return;

        $children = Category::getChildren((int) $id_category, (int) $id_lang, true, (int) $id_shop);
        $selected = ($this->page_name == 'category' && ((int) Tools::getValue('id_category') == $id_category)) ? ' class="sfHoverForce"' : '';


        $category_menu .= '<a href="' . $category_link . '"><span>' . $category->name . '</span></a>';


        return $category_menu;
    }

    private function getCMSCategories($recursive = false, $parent = 1, $id_lang = false) {
        $id_lang = $id_lang ? (int) $id_lang : (int) Context::getContext()->language->id;

        if ($recursive === false) {
            $sql = 'SELECT bcp.`id_cms_category`, bcp.`id_parent`, bcp.`level_depth`, bcp.`active`, bcp.`position`, cl.`name`, cl.`link_rewrite`
				FROM `' . _DB_PREFIX_ . 'cms_category` bcp
				INNER JOIN `' . _DB_PREFIX_ . 'cms_category_lang` cl
				ON (bcp.`id_cms_category` = cl.`id_cms_category`)
				WHERE cl.`id_lang` = ' . (int) $id_lang . '
				AND bcp.`id_parent` = ' . (int) $parent;

            return Db::getInstance()->executeS($sql);
        } else {
            $sql = 'SELECT bcp.`id_cms_category`, bcp.`id_parent`, bcp.`level_depth`, bcp.`active`, bcp.`position`, cl.`name`, cl.`link_rewrite`
				FROM `' . _DB_PREFIX_ . 'cms_category` bcp
				INNER JOIN `' . _DB_PREFIX_ . 'cms_category_lang` cl
				ON (bcp.`id_cms_category` = cl.`id_cms_category`)
				WHERE cl.`id_lang` = ' . (int) $id_lang . '
				AND bcp.`id_parent` = ' . (int) $parent;

            $results = Db::getInstance()->executeS($sql);
            foreach ($results as $result) {
                $sub_categories = $this->getCMSCategories(true, $result['id_cms_category'], (int) $id_lang);
                if ($sub_categories && count($sub_categories) > 0)
                    $result['sub_categories'] = $sub_categories;
                $categories[] = $result;
            }

            return isset($categories) ? $categories : false;
        }
    }

    private function getCMSPages($id_cms_category, $id_shop = false, $id_lang = false) {
        $id_shop = ($id_shop !== false) ? (int) $id_shop : (int) Context::getContext()->shop->id;
        $id_lang = $id_lang ? (int) $id_lang : (int) Context::getContext()->language->id;

        $sql = 'SELECT c.`id_cms`, cl.`meta_title`, cl.`link_rewrite`
			FROM `' . _DB_PREFIX_ . 'cms` c
			INNER JOIN `' . _DB_PREFIX_ . 'cms_shop` cs
			ON (c.`id_cms` = cs.`id_cms`)
			INNER JOIN `' . _DB_PREFIX_ . 'cms_lang` cl
			ON (c.`id_cms` = cl.`id_cms`)
			WHERE c.`id_cms_category` = ' . (int) $id_cms_category . '
			AND cs.`id_shop` = ' . (int) $id_shop . '
			AND cl.`id_lang` = ' . (int) $id_lang . '
			AND c.`active` = 1
			ORDER BY `position`';

        return Db::getInstance()->executeS($sql);
    }

    private function getCMSOptions($parent = 0, $depth = 1, $id_lang = false) {
        $id_lang = $id_lang ? (int) $id_lang : (int) Context::getContext()->language->id;

        $categories = $this->getCMSCategories(false, (int) $parent, (int) $id_lang);
        $pages = $this->getCMSPages((int) $parent, false, (int) $id_lang);

        $spacer = str_repeat('&nbsp;', $this->spacer_size * (int) $depth);

        foreach ($categories as $category) {
            $this->_html .= '<option value="CMS_CAT' . $category['id_cms_category'] . '" style="font-weight: bold;">' . $spacer . $category['name'] . '</option>';
            $this->getCMSOptions($category['id_cms_category'], (int) $depth + 1, (int) $id_lang);
        }

        foreach ($pages as $page)
            $this->_html .= '<option value="CMS' . $page['id_cms'] . '">' . $spacer . $page['meta_title'] . '</option>';
    }

    private function makeMenuOption($item) {
     
        $id_lang = (int) $this->context->language->id;
        $id_shop = (int) Shop::getContextShopID();
        $listofthismenu = '';

        preg_match($this->pattern, $item, $values);
        $id = (int) substr($item, strlen($values[1]), strlen($item));

        switch (substr($item, 0, strlen($values[1]))) {

            case 'CAT':
                $category = new Category((int) $id, (int) $id_lang);
                if (Validate::isLoadedObject($category))
                    $listofthismenu .= $category->name . PHP_EOL;
                break;

            case 'PRD':
                $product = new Product((int) $id, true, (int) $id_lang);
                if (Validate::isLoadedObject($product))
                    $listofthismenu .= $product->name;
                break;

            case 'CMS':
                $cms = new CMS((int) $id, (int) $id_lang);
                if (Validate::isLoadedObject($cms))
                    $listofthismenu .= $cms->meta_title . PHP_EOL;
                break;

            case 'CMS_CAT':
                $category = new CMSCategory((int) $id, (int) $id_lang);
                if (Validate::isLoadedObject($category))
                    $listofthismenu .= $category->name . PHP_EOL;
                break;

            case 'MAN':
                $manufacturer = new Manufacturer((int) $id, (int) $id_lang);
                if (Validate::isLoadedObject($manufacturer))
                    $listofthismenu .= $manufacturer->name . PHP_EOL;
                break;

            case 'SUP':
                $supplier = new Supplier((int) $id, (int) $id_lang);
                if (Validate::isLoadedObject($supplier))
                    $listofthismenu .= $supplier->name . PHP_EOL;
                break;

            case 'LNK':
                $link = TdMegaMenu::getCustomLinksByid((int) $id, (int) $id_lang, (int) $id_shop);

                if (count($link)) {
                    if (!isset($link[0]['label']) || ($link[0]['label'] == '')) {
                        $default_language = Configuration::get('PS_LANG_DEFAULT');
                        $link = TdMegaMenu::getCustomLinksByid($link[0]['id_tdmegamenu'], (int) $default_language, (int) Shop::getContextShopID());
                    }
                    $listofthismenu .= $link[0]['menu_title'];
                }
                break;
            case 'SHOP':
                $shop = new Shop((int) $id);
                if (Validate::isLoadedObject($shop))
                    $listofthismenu .=$shop->name . PHP_EOL;
                break;
        }
        return $listofthismenu;
    }
    
    private function makeFrontMenu($item) {

        $listofthisfrontmenu = '';
        $id_lang = (int) $this->context->language->id;
        $id_shop = (int) Shop::getContextShopID();

        preg_match($this->pattern, $item, $values);
        $id = (int) substr($item, strlen($values[1]), strlen($item));

        switch (substr($item, 0, strlen($values[1]))) {
            case 'CAT':

                $listofthisfrontmenu .= $this->getCategory((int) $id);
                break;

            case 'PRD':
                $selected = ($this->page_name == 'product' && (Tools::getValue('id_product') == $id)) ? ' class="sfHover"' : '';
                $product = new Product((int) $id, true, (int) $id_lang);
                if (!is_null($product->id))
                    $listofthisfrontmenu .= '<a href="' . $product->getLink() . '"><span>' . $product->name . '</span></a>' . PHP_EOL;
                break;

            case 'CMS':
                $selected = ($this->page_name == 'cms' && (Tools::getValue('id_cms') == $id)) ? ' class="sfHover"' : '';
                $cms = CMS::getLinks((int) $id_lang, array($id));
                if (count($cms))
                    $listofthisfrontmenu .= '<a href="' . $cms[0]['link'] . '"><span>' . $cms[0]['meta_title'] . '</span></a>' . PHP_EOL;
                break;

            case 'CMS_CAT':
                $category = new CMSCategory((int) $id, (int) $id_lang);
                if (count($category)) {
                    $listofthisfrontmenu .= '<a href="' . $category->getLink() . '"><span>' . $category->name . '</span></a>';
                    $this->getCMSMenuItems($category->id);
                }
                break;

            case 'MAN':
                $selected = ($this->page_name == 'manufacturer' && (Tools::getValue('id_manufacturer') == $id)) ? ' class="sfHover"' : '';
                $manufacturer = new Manufacturer((int) $id, (int) $id_lang);
                if (!is_null($manufacturer->id)) {
                    if (intval(Configuration::get('PS_REWRITING_SETTINGS')))
                        $manufacturer->link_rewrite = Tools::link_rewrite($manufacturer->name, false);
                    else
                        $manufacturer->link_rewrite = 0;
                    $link = new Link;
                    $listofthisfrontmenu .= '<a href="' . $link->getManufacturerLink((int) $id, $manufacturer->link_rewrite) . '"><span>' . $manufacturer->name . '</span></a>' . PHP_EOL;
                }
                break;

            case 'SUP':
                $selected = ($this->page_name == 'supplier' && (Tools::getValue('id_supplier') == $id)) ? ' class="sfHover"' : '';
                $supplier = new Supplier((int) $id, (int) $id_lang);
                if (!is_null($supplier->id)) {
                    $link = new Link;
                    $listofthisfrontmenu .= '<a href="' . $link->getSupplierLink((int) $id, $supplier->link_rewrite) . '"><span>' . $supplier->name . '</span></a>' . PHP_EOL;
                }
                break;

            case 'SHOP':
                $selected = ($this->page_name == 'index' && ($this->context->shop->id == $id)) ? ' class="sfHover"' : '';
                $shop = new Shop((int) $id);
                if (Validate::isLoadedObject($shop)) {
                    $link = new Link;
                    $listofthisfrontmenu.= '<a href="' . $shop->getBaseURL() . '"><span>' . $shop->name . '</span></a>' . PHP_EOL;
                }
                break;
            case 'LNK':
                $link = TdMegaMenu::getCustomLinksByid((int) $id, (int) $id_lang, (int) $id_shop);

                if (count($link)) {
                    if (!isset($link[0]['label']) || ($link[0]['label'] == '')) {
                        $default_language = Configuration::get('PS_LANG_DEFAULT');
                        $link = TdMegaMenu::getCustomLinksByid($link[0]['id_tdmegamenu'], (int) $default_language, (int) Shop::getContextShopID());
                    }
                    
                    $listofthisfrontmenu .= '<a href="' . $link[0]['link'] . '"><span>' . $link[0]['menu_title'] . '</span></a>' . PHP_EOL;
                    if($link[0]['custome_type']=='cus_html'){
                         $listofthisfrontmenu .= html_entity_decode($link[0]['description']);
                    }
                }
                break;
        }

        return $listofthisfrontmenu;
    }

    private function insertMenuLinks() {
        $languages = Language::getLanguages(false);
        $context = Context::getContext();
        $id_shop = $context->shop->id;


        if (Tools::getValue('order')) {
            $order = Tools::getValue('order');
        } else {
            $order = Db::getInstance()->getValue('
			SELECT COUNT(*) 
			FROM `' . _DB_PREFIX_ . 'tdmegamenu`');
        }
               $totalid = Db::getInstance()->getValue('
			SELECT MAX(id_tdmegamenu)
			FROM `' . _DB_PREFIX_ . 'tdmegamenu`');
                $totalid +=1;
          
        if (Tools::getValue('cat_id') != '0') {
            $typeofthismenu = (Tools::getValue('cat_id'));
        } elseif (Tools::getValue('cms_id') != '0') {
            $typeofthismenu = (Tools::getValue('cms_id'));
        } elseif (Tools::getValue('manu_id') != '0') {
            $typeofthismenu = (Tools::getValue('manu_id'));
        } elseif (Tools::getValue('sup_id') != '0') {
            $typeofthismenu = (Tools::getValue('sup_id'));
        } else {
            if (Tools::getValue('menu_type')) {
         
                $typeofthismenu = 'LNK' . $totalid;
 
            }
  
        }
        if (Tools::getValue('custom-block-section') != '0') {
            $custommenu = (Tools::getValue('custom-block-section'));
        } else {
            $custommenu = '';
        }
        Db::getInstance()->Execute('
            INSERT INTO `' . _DB_PREFIX_ . 'tdmegamenu`(`id_tdmegamenu`,`menu_type`,`link`,`publish`,`order`,`parent`,`custome_type`,`id_shop`) 
            VALUES('.$totalid.',"' . $typeofthismenu . '","' . Tools::getValue('link') . '", ' . (int) Tools::getValue('publish') . ',' . (int) $order . ',' . (int) Tools::getValue('parent') . ',"' . $custommenu . '",' . $id_shop . ')');


      
        foreach ($languages as $language) {
            Db::getInstance()->Execute('
                INSERT INTO `' . _DB_PREFIX_ . 'tdmegamenu_lang`(`id_tdmegamenu`,`id_lang`,`menu_title`,`description`) 
                VALUES(' . (int) $totalid. ', ' . (int) $language['id_lang'] . ', 
                "' . pSQL(Tools::getValue('title_' . $language['id_lang'])) . '", 
                 "' . htmlspecialchars(Tools::getValue('description_' . $language['id_lang'])) . '")');
        }
    }


    private function _displayAdminDesign() {
        global $cookie;
      
        $defaultLanguage = (int) (Configuration::get('PS_LANG_DEFAULT'));
        $languages = Language::getLanguages(false);
        $iso = Language::getIsoById((int) ($cookie->id_lang));

        $id_lang = Context::getContext()->language->id;

        $divLangName = 'title¤description';
        if (Tools::isSubmit('submitMenuLinks')) {
            if (Tools::getValue('menu_type') == '') {
                $this->_html .= $this->displayError($this->l('Please select menu type first!'));
            } else {
                $this->insertMenuLinks();
                $this->_html .= $this->displayConfirmation($this->l('Menu Links Added Successfully!'));
            }
        } elseif (Tools::isSubmit('removemenu_links')) {

            $id_tdmegamenu = Tools::getValue('id_tdmegamenu');

            $delsuccess = $this->deleteMenuFromList($id_tdmegamenu);
            if (isset($delsuccess))
                $this->_html .= $this->displayConfirmation($this->l('Menu Links Removed Successfully!'));
        }
        $this->_html .= '<fieldset>
      		<legend><img src="../img/admin/add.gif" alt="" title="" />' . $this->l('Add Menu Links') . '</legend>
      			<form action="' . $_SERVER['REQUEST_URI'] . '" method="post" id="form">
                        <label>' . $this->l('Links type') . '</label>
                        <div class="padding_boxarea">
                        <select id="selected_menu_type" name="menu_type">
                            <option value="">Select Menu type </option>
                            <option value="cat">Categories</option>
                            <option value="cms">CMS</option>
                            <option value="manu"> Manufacturer</option>
                            <option value="sup">Supplier </option>
                            <option value="custom">Custom Options</option>';
        $this->_html .= '</select>
              <script type="text/javascript">
                $(document).ready(function(){
   $("#category_block").css("display","none");
                            $("#cms-block").css("display","none");
                            $("#menuf-block").css("display","none");
                            $("#supplier-block").css("display","none");
                            $("#custom-box").css("display","none");
});
                        $("#selected_menu_type").change(function () {
                            var selected_menu_type=$(this).val();
                            switch (selected_menu_type){
                            case "cat":
                            $("#category_block").css("display","block");
                            $("#cms-block").css("display","none");
                            $("#menuf-block").css("display","none");
                            $("#supplier-block").css("display","none");
                            $("#custom-box").css("display","none");
                            $("#custom_links_block").css("display","none");
                           $("#menu_links_block").css("display","none");
                            break; 
                          case "cms":
                            $("#category_block").css("display","none");
                            $("#cms-block").css("display","block");
                            $("#menuf-block").css("display","none");
                            $("#supplier-block").css("display","none");
                            $("#custom-box").css("display","none");
                           $("#custom_links_block").css("display","none");
                           $("#menu_links_block").css("display","none");
                            break; 
                            case "manu":
                            $("#category_block").css("display","none");
                            $("#cms-block").css("display","none");
                            $("#menuf-block").css("display","block");
                            $("#supplier-block").css("display","none");
                            $("#custom-box").css("display","none");
                            $("#custom_links_block").css("display","none");
                           $("#menu_links_block").css("display","none");
                            break; 
                            case "sup":
                            $("#category_block").css("display","none");
                            $("#cms-block").css("display","none");
                            $("#menuf-block").css("display","none");
                            $("#supplier-block").css("display","block");
                            $("#custom-box").css("display","none");
                           $("#custom_links_block").css("display","none");
                           $("#menu_links_block").css("display","none");
                            break; 
                           case "custom":
                            $("#category_block").css("display","none");
                            $("#cms-block").css("display","none");
                            $("#menuf-block").css("display","none");
                            $("#supplier-block").css("display","none");
                            $("#custom-box").css("display","block");
                            $("#custom_links_block").css("display","none");
                           $("#menu_links_block").css("display","none");
                            break; 
                            default:
                            $("#category_block").css("display","none");
                            $("#cms-block").css("display","none");
                            $("#menuf-block").css("display","none");
                            $("#supplier-block").css("display","none");
                            $("#custom-box").css("display","none");
                            }
                           return false;
                        });
               
                    </script>
                        </div>
                        <div id="category_block">
                        <label>' . $this->l('Categoryes') . '</label>
                        <div class="padding_boxarea">
                        <select id="cat_id" name="cat_id">
                            <option value="0"> Select category</option>';
        $this->_html .=$this->getCategoryOption();
        $this->_html .= '</select>
                        </div>
                        </div>
                         <div id="cms-block">
                        <label>' . $this->l('CMS') . '</label>
                        <div class="padding_boxarea">
                        <select id="cms_id" name="cms_id">
                        <option value="0"> Select CMS</option>';
        $this->_html .=$this->getCMSOptions();
        $this->_html .= '</select>
                        </div>
                        </div>
                       <div id="menuf-block">
                        <label>' . $this->l('Manufacturer') . '</label>
                        <div class="padding_boxarea">
                        <select id="manu_id" name="manu_id">
                            <option value="0">Select Manufacturer</option>';
        $manufacturers = Manufacturer::getManufacturers(false, $id_lang);
        foreach ($manufacturers as $manufacturer)
            $this->_html .= '<option value="MAN' . $manufacturer['id_manufacturer'] . '">' . ' ' . $manufacturer['name'] . '</option>';
        $this->_html .= '</select>
                        </div>
                        </div>
                        <div id="supplier-block">
                        <label>' . $this->l('Supplier') . '</label>
                        <div class="padding_boxarea">
                        <select id="sup_id" name="sup_id">
                            <option value="0">Select Supplier</option>';
        $suppliers = Supplier::getSuppliers(false, $id_lang);
        foreach ($suppliers as $supplier)
            $this->_html .= '<option value="SUP' . $supplier['id_supplier'] . '">' . ' ' . $supplier['name'] . '</option>';
        $this->_html .= '</select>
                        </div>
                        </div>
                        <div id="custom-box">
                        <label>' . $this->l('Custom type') . '</label>
                        <div class="padding_boxarea">
                        <select id="custom-block-section" name="custom-block-section">
                            <option value="">Select Custom type</option>
                            <option value="cus_links">Custom Link</option>
                            <option value="cus_html">Custom HTML</option>';
        $this->_html .= '</select>
                        </div>
                        </div>
                        <script type="text/javascript">
                        $("select#custom-block-section").change(function(){
                            var custome_url=$(this).val();
                            switch(custome_url) {
                            case "cus_links":
                            $("#custom_links_block").css("display","block");
                            $("#description").css("display","none");
                              $("#menu_links_block").css("display","block");
                            break; 
                          case "cus_html":
                            $("#custom_links_block").css("display","none");
                            $("#description").css("display","block");
                            $("#menu_links_block").css("display","block");
                            break; 
                            }
                        });
                    </script>
                    <div id="menu_links_block">
            
  			<label>' . $this->l('Title') . '</label>
        			<div class="padding_boxarea">';
        foreach ($languages as $language) {
            $this->_html .= '<div id="title_' . $language['id_lang'] . '" style="display: ' . ($language['id_lang'] == $defaultLanguage ? 'block' : 'none') . ';float: left;">					
                <input type="text" name="title_' . $language['id_lang'] . '" id="title_' . $language['id_lang'] . '" size="28" value="';

            $this->_html .= '" />
						
            </div>';
        }
        $this->_html .= $this->displayFlags($languages, $defaultLanguage, $divLangName, 'title', true);

        $this->_html .= '</div></div><div id="description">
            <label>' . $this->l('Custom HTML') . '</label>
        			<div class="padding_boxarea">';
        foreach ($languages as $language) {
            $this->_html .= '
		<div id="description_' . $language['id_lang'] . '" style="display: ' . ($language['id_lang'] == $defaultLanguage ? 'block' : 'none') . ';float: left;">
                <textarea  name="description_' . $language['id_lang'] . '" id="description_' . $language['id_lang'] . '" rows="20" cols="50" >';

            $this->_html .= '</textarea>
        </div>
       ';
        }
        $this->_html .= $this->displayFlags($languages, $defaultLanguage, $divLangName, 'description', true);
       

        $this->_html .= '</div> </div>';
        $this->_html .= '<p class="clearboth"> </p>
            <div id="custom_links_block">
  					<label>' . $this->l('Link') . '</label>
  			<div class="padding_boxarea">
          <input type="text" name="link"  size="28" />
  			</div>
             </div>
			<label>' . $this->l('Parent') . '</label>
  			<div class="padding_boxarea">
				<select name="parent">
					<option value=0> Root </option>';
        $this->_html .= $this->displayParentMenu();

        $this->_html .= '</select>
  			</div>
	
  			<label>' . $this->l('Publish') . '</label>
  			<div class="padding_boxarea">';
        
            $this->_html .= '<input type="radio" name="publish" value="1" checked /><img title="Enabled" alt="Enabled" src="../img/admin/enabled.gif"/>
          			<input type="radio" name="publish" value="0" /><img title="Disabled" alt="Disabled" src="../img/admin/disabled.gif"/>';
       
        $this->_html .= '
  			</div>
			<label>' . $this->l('Order') . '</label>
  			<div class="padding_boxarea">
          <input type="text" name="order" size="10" />
  			</div>
       ';
 
            $this->_html .= ' <p class="center"> <input type="submit" name="submitMenuLinks" value="' . $this->l('  Add Links  ') . '" class="button" /> </p>';
 
        $this->_html .= '</form>
    </fieldset><br />';



        return $this->_html;
    }


    public function adminHeadOptions() {
        $this->_html = "

           <link id='test' href='" . __PS_BASE_URI__ . "modules/tdmegamenu/css/style.css' rel='stylesheet' type='text/css' />
                    <script type='text/javascript' src='" . __PS_BASE_URI__ . "modules/tdmegamenu/js/jquery-1.2.pack.js'></script>
             <script type='text/javascript' src='" . __PS_BASE_URI__ . "modules/tdmegamenu/js/interface-1.2.js'></script>
            <script type='text/javascript' src='" . __PS_BASE_URI__ . "modules/tdmegamenu/js/inestedsortable.js'></script>";
        $this->_html .="<script type='text/javascript'>
                $( function($) {
                $('#sorted_menulink').NestedSortable(
                        {
                                accept: 'menu-items',
                                opacity: 0.8,
                                helperclass: 'placeholder',
                                onChange: function(serialized) {
                                        $('#serial')
                                        .val(serialized[0].hash);
                                        $.post('" . __PS_BASE_URI__ . "modules/tdmegamenu/tdmegamenu_ajax.php',serialized[0].hash);         
                                },
                                autoScroll: true,
                                handle: '.sort-handle'
                        }
                );

                });
                </script>";


        return $this->_html;
    }
    
    private function getCustomLinksByid($id_td_menu, $id_lang = false, $id_shop = false) {

        global $cookie;
        return Db::getInstance()->ExecuteS('
            SELECT td.`id_tdmegamenu`, td.`link`,td.`menu_type`, td.`publish`, td.`order`,td.`parent`,td.`custome_type`,td1.`menu_title`,td1.`description`
            FROM `' . _DB_PREFIX_ . 'tdmegamenu` td
            INNER JOIN `' . _DB_PREFIX_ . 'tdmegamenu_lang` td1 ON (td.`id_tdmegamenu` = td1.`id_tdmegamenu`)
            WHERE td1.`id_lang` = ' . (int) $cookie->id_lang . ' and td.`id_shop`='.$id_shop.' and td1.`id_tdmegamenu` = ' . (int) $id_td_menu . '
            ORDER BY td.`order`');
    }
      
    private function deleteMenuFromList($id_td_menu) {
     $context = Context::getContext();
		$id_shop = $context->shop->id;
                //echo $id_tdmegamenu;
        Db::getInstance()->Execute('DELETE FROM ' . _DB_PREFIX_ . 'tdmegamenu WHERE id_tdmegamenu=' . $id_td_menu);
        Db::getInstance()->Execute('DELETE FROM ' . _DB_PREFIX_ . 'tdmegamenu_lang WHERE id_tdmegamenu=' . $id_td_menu);
        return true;
    }

    private function displayFrontMobileMenu($defaultValue = 0, $parent = 0, $pretext = '') {
        global $cookie;
        $formobilemenulinks = '';

        $pretext .='-';
        if ($parent != 0)
            $pretext .= '--';
        $td_menulinks = TdMegamenuModel::getAllMegaMenu($cookie->id_lang, $parent);
        foreach ($td_menulinks as $td_menulink) {
            $formobilemenulinks .= '<option value="' . $td_menulink['link'] . '"';
          
            if ($defaultValue == $td_menulink['link']) {
                $formobilemenulinks .= ' SELECTED ';
            }
            $formobilemenulinks .= '> ' . $pretext . $this->makeMenuOption($td_menulink['menu_type']) . ' </option>';
            if ($td_menulink['submenu'])
                $formobilemenulinks .= $this->displayFrontMobileMenu($defaultValue, $td_menulink['id_tdmegamenu'], $pretext);
        }
        return $formobilemenulinks;
    }

    private function displayParentMenu($defaultValue = 0, $parent = 0, $pretext = '') {
        global $cookie;
        $formobilemenulinks = '';
        $pretext .= '-';
        $td_menulinks = TdMegamenuModel::getAllMegaMenu($cookie->id_lang, $parent);



        foreach ($td_menulinks as $td_menulink) {
            $formobilemenulinks .= '<option value="' . $td_menulink['id_tdmegamenu'] . '"';
          
            if ($defaultValue == $td_menulink['id_tdmegamenu']) {
                $formobilemenulinks .= ' SELECTED ';
            }

            $formobilemenulinks .= '> ' . $pretext . $this->makeMenuOption($td_menulink['menu_type']) . ' </option>';


            if ($td_menulink['submenu'])
                $formobilemenulinks .= $this->displayParentMenu($defaultValue, $td_menulink['id_tdmegamenu'], $pretext);
        }


        return $formobilemenulinks;
    }
    
    private function displayAdminListChildMenu($parent = 0, $pretext = '') {
        global $cookie;
        $listofthismenu = '';
        $td_menulinks = TdMegamenuModel::getAllMegaMenu($cookie->id_lang);
        $listofthismenu.='<ul  class="page-list" >';
        foreach ($td_menulinks as $td_menulink) {
            $listofthismenu .= '<li id="ele_' . $td_menulink['id_tdmegamenu'] . '" class="clearboth-element menu-items left">';
            $listofthismenu .= '<div class="sort-handle">';
            $listofthismenu .='<span class="menu-name">';
            $listofthismenu .= $pretext . $td_menulink['name'];
            $listofthismenu .='</span><span class="delete-main-menu">';
            $listofthismenu .= '<form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
                <input type="hidden" name="id_tdmegamenu" value="' . $td_menulink['id_tdmegamenu'] . '" />
				
				<button name="removemenu_links" class="button" onclick="javascript:return confirm(\'' . $this->l('Are you sure you want to remove this link?') . '\');" ><img src="../img/admin/delete.gif" alt="Delete" title="Delete" /></button>
          			
          		</form>';
            $listofthismenu .='</span>';
            $listofthismenu .= '</div>';
            $listofthismenu .= '</li>';

            if ($td_menulink['submenu'])
                $listofthismenu .= $this->displayAdminListChildMenu($td_menulink['id_tdmegamenu'], $pretext);
        }
        $listofthismenu.='</ul>';
        return $listofthismenu;
    }

    private function displayAdminListParentMenu($parent = 0, $pretext = '') {
        global $cookie;
        $listofthismenu = '';
        $td_menulinks = TdMegamenuModel::getAllMegaMenu($cookie->id_lang, $parent);

        $listofthismenu.='<ul  class="page-list" >';
        foreach ($td_menulinks as $td_menulink) {
            $listofthismenu .= '<li id="ele_' . $td_menulink['id_tdmegamenu'] . '" class="clearboth-element menu-items left">';
            $listofthismenu .= '<div class="sort-handle">';
            $listofthismenu .='<span class="menu-name">';
            $listofthismenu .= $this->makeMenuOption($td_menulink['menu_type']);
            $listofthismenu .='</span><span class="delete-main-menu">';
            $listofthismenu .= '<form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
                <input type="hidden" name="id_tdmegamenu" value="' . $td_menulink['id_tdmegamenu'] . '" />
				
				<button name="removemenu_links" class="button" onclick="javascript:return confirm(\'' . $this->l('Are you sure you want to remove this link?') . '\');" ><img src="../img/admin/delete.gif" alt="Delete" title="Delete" /></button>
          			
          		</form>';
            $listofthismenu .='</span>';
            $listofthismenu .= '</div>';
            $listofthismenu .= '</li>';

            if ($td_menulink['submenu'])
                $listofthismenu .= $this->displayAdminListParentMenu($td_menulink['id_tdmegamenu'], $pretext);
        }
        $listofthismenu.='</ul>';
        return $listofthismenu;
    }

    private function adminMenuLikeList($parent = 0, $pretext = '') {
        global $cookie;
        $listofthismenu = '';
        $td_menulinks = TdMegamenuModel::getAllMegaMenu($cookie->id_lang, $parent);

        $listofthismenu.='<ul  id="sorted_menulink" class="page-list">';
        foreach ($td_menulinks as $td_menulink) {

            $listofthismenu .= '<li id="ele_' . $td_menulink['id_tdmegamenu'] . '" class="clearboth-element menu-items left">';
            $listofthismenu .= '<div class="sort-handle">';
            $listofthismenu .='<span class="menu-name">';
            $listofthismenu .= $this->makeMenuOption($td_menulink['menu_type']);
            $listofthismenu .='</span><span class="delete-main-menu">';
            $listofthismenu .= '<form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
                <input type="hidden" name="id_tdmegamenu" value="' . $td_menulink['id_tdmegamenu'] . '" />
				
				<button name="removemenu_links" class="button" onclick="javascript:return confirm(\'' . $this->l('Are you sure you want to remove this link?') . '\');" ><img src="../img/admin/delete.gif" alt="Delete" title="Delete" /></button>
          			
          		</form>';
            $listofthismenu .='</span>';
            $listofthismenu .= '</div>';

            if ($td_menulink['submenu'])
                $listofthismenu .= $this->displayAdminListParentMenu($td_menulink['id_tdmegamenu'], $pretext);
            $listofthismenu .= '</li>';
        }
        $listofthismenu.='</ul>';

        return $listofthismenu;
    }

    
    
    
    private function FrontListParentMenu($parent = 0) {

        global $cookie;

        $curent_link = str_replace(__PS_BASE_URI__, '', $_SERVER["REQUEST_URI"]);
        $frontmenulist = '';
        $frontmenulist .= '<ul>';
        $td_menulinks = TdMegamenuModel::getAllMegaMenu($cookie->id_lang, $parent);
 
        foreach ($td_menulinks as $td_menulink) {
       
            $curentmenuclass = '';

 
            if (($td_menulink['link'] == $curent_link) or ($curent_link == NULL and $td_menulink['link'] == 'index.php')) {
                $curentmenuclass .= 'class=""';
            }
       if ($td_menulink['submenu']){
            $frontmenulist .= '<li  class="parent  ">';
       }else{
           $frontmenulist .= '<li  class=" ">';
       }
            $frontmenulist .= $this->makeFrontMenu($td_menulink['menu_type']);
             
            if ($td_menulink['submenu'])
                $frontmenulist .= $this->FrontListParentMenu($td_menulink['id_tdmegamenu']);
            $frontmenulist .= '</li>';
        }

        $frontmenulist .= '</ul>';

        return $frontmenulist;
    }

    private function FrontListMenu($parent = 0) {
        global $cookie;

        $curent_link = str_replace(__PS_BASE_URI__, '', $_SERVER["REQUEST_URI"]);
        $frontmenulist = '';
      
        $td_menulinks = TdMegamenuModel::getAllMegaMenu($cookie->id_lang, $parent);
        foreach ($td_menulinks as $td_menulink) {
            $currentliclass = '';
            $curentmenuclass = '';
    
            if (($td_menulink['link'] == $curent_link) or ($curent_link == NULL and $td_menulink['link'] == 'index.php')) {
                $currentliclass .= 'li-current';
                $curentmenuclass .= 'class="child_active"';
            }
           if ($td_menulink['submenu']){
            $frontmenulist .= '<li id="menu-item-' . $td_menulink['id_tdmegamenu'] . '" class="parent">';
           }else{
                $frontmenulist .= '<li id="menu-item-' . $td_menulink['id_tdmegamenu'] . '" class="' . $currentliclass . '">';
           }

            $frontmenulist .=$this->makeFrontMenu($td_menulink['menu_type']);
            
            if ($td_menulink['submenu'])
                $frontmenulist .= $this->FrontListParentMenu($td_menulink['id_tdmegamenu']);
            $frontmenulist .= '</li>';
        }

     

        return $frontmenulist;
    }

    public function hookTop($param) {
        global $smarty;


        $this->_tdmegamenu = $this->FrontListMenu();

        $smarty->assign('tdMENU', $this->_tdmegamenu);

        $this->_tdmegamenu = $this->FrontListMenu();
          $smarty->assign('tdMobileMenu', $this->_tdmegamenu);
         
        return $this->display(__FILE__, 'tdmegamenu.tpl');
    }

}
?>