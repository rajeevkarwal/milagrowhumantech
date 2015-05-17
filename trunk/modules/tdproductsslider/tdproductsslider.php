<?php

if (!defined('_PS_VERSION_'))
    exit;
include_once(dirname(__FILE__) . '/tdproductsliderModel.php');


class TDProductsSlider extends Module {

    public $tdmodname = "themesdev";
    public $_html, $pattern, $_fields, $_tabs, $Defaults, $category;
    public $tdoptions = array();

    public function __construct() {
        $this->name = 'tdproductsslider';
        $this->tab = 'front_office_features';
        $this->version = '1.1.0';
        $this->author = 'ThemesDeveloper';
        $this->need_instance = 0;
        parent::__construct();
        $this->displayName = $this->l('ThemesDeveloper  Products Slider');
        $this->description = $this->l('Prestashop Products Slider By ThemesDeveloper');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall your details ?');
        $this->secure_key = Tools::encrypt($this->name);

        $this->tdThemeOption();
    }

    public function install() {
             if (parent::install() && $this->registerHook('home') && $this->registerHook('header'))
		{
                    $res =$this->installData(); 
                    $res &= tdProductsSliderModel::createTables();
                    return $res;
		}
		return false;
    }

    public function installData() {
        $tdoptions = $this->tdoptions;
        foreach ($tdoptions as $option_result):
            $stdvalue = $option_result['std'];
            if (isset($stdvalue)) :
                if (is_array($stdvalue)) {
                    foreach ($stdvalue as $key => $output_value) {
                        Configuration::updateValue($option_result['id'] . "_" . $key, htmlspecialchars($output_value));
                    }
                } else {
                  
                   Configuration::updateValue($option_result['id'], htmlspecialchars($option_result['std']));
                  
                }
            endif;

        endforeach;
        return true;
    }

    public function tdOptionDataDelete() {
        $tdoptions = $this->tdoptions;
        foreach ($tdoptions as $option_result):
            $stdvalue = $option_result['std'];
            if (isset($stdvalue)) :
                if (is_array($stdvalue)) {
                    foreach ($stdvalue as $key => $output_value) {
                        Configuration::deleteByName($option_result['id'] . '_' . $key);
                    }
                } else {
                    Configuration::deleteByName($option_result['id']);
                
                }
            endif;

        endforeach;
    }

    public function uninstall() {
        if (!parent::uninstall())
            return false;
        $this->tdOptionDataDelete();
        tdProductsSliderModel::DropTables();
        return true;
    }

    public function getContent() {
        $this->_html = '';
        global $cookie;
        require_once '../config/config.inc.php';
        require_once '../init.php';
        $this->_includeAdminFile();
        $this->_tdOptionForm();
        return $this->_html;
    }

    public function tdThemeOption() {
        $td_options = array();
        $slider_type=array('special_products' => 'Special Products', 'new_products' => 'New Products', 'featured_products' => 'Featured Products',  'best_sells' => 'Best Sells Products', 'selected_products' => 'Selected Products', 'selected_category' => 'Selected Category Products');
        
        
        
        /* Start Theme Option **********************************  */
        $td_options[] = array( "name" => "Slider Options",
            "type" => "heading");
        
         $td_options[] = array("name" => "Select Type Of Slider",
            "desc" => "Select of any type, for view prodoct on home Page slider.",
            "id" => $this->tdmodname . "_slider_type",
            "std" => 'featured_products',
            "options" => $slider_type,
            "type" => "select");

          $td_options[] = array("name" => 'Number Of Slide',
            "desc" => 'You can use this text box for showing support number on header of the page.',
            "id" => $this->tdmodname . "_numpro",
            "std" => "5",
            "type" => "text");
           $td_options[] = array("name" => "Select Category",
            "desc" => "You can change menu & heading font style.",
            "id" => $this->tdmodname . "_selcat",
            "std" => '',
            "section" => "category",
            "type" => "category");
           
          $td_options[] = array("name" => "Select Products",
            "desc" => "You can change menu & heading font style.",
            "id" => $this->tdmodname . "_selpro",
            "std" => '',
            "section" => "category",
            "type" => "products");

     
        $this->tdoptions = $td_options;
    }

    private function _includeAdminFile() {

        $this->_html = '
<link href="' . __PS_BASE_URI__ . 'modules/tdproductsslider/admin/css/admin-style.css" rel="stylesheet" type="text/css" />
<link href="' . __PS_BASE_URI__ . 'modules/tdproductsslider/admin/css/colorpicker.css" rel="stylesheet" type="text/css" />
<link href="' . __PS_BASE_URI__ . 'modules/tdproductsslider/admin/css/bootstrap-trim.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript"  src="' . __PS_BASE_URI__ . 'modules/tdproductsslider/admin/js/bootstrap-trim.min.js"></script>
<script type="text/javascript"  src="' . __PS_BASE_URI__ . 'modules/tdproductsslider/admin/js/options-custom.js"></script>
    ';
    }

    public function getSaveOption($id) {
        return Configuration::get($id);
    }

    private function _tdOptionForm() {
        global $cookie;

        $tdoptionfields = $this->tdOptionPanelFields();

        $this->_fields = $tdoptionfields[0];
        $this->_tabs = $tdoptionfields[1];


        $this->_html .= '
            
           <div class="container custome-bg">

         <div id="td-popup-save" class="of-save-popup">
		<div class="for-button-save">Product Slider Updated</div>
	</div>
        <form id="for_form" method="post" action="" enctype="multipart/form-data" >
               <div class="header_wrap">
                        <h2>' . $this->displayName . '</h2>
                        For future updates follow me <a href="http://themeforest.net/user/themesdev" target="_blank">@themeforest</a> or <a href="https://twitter.com/themesdeveloper" target="_blank">@twitter</a>

            </div>

            <div class="row-fluid">
                <div id="sidebar" class="tabbable">
                    <div class="span3">
                        <div class="well">
                            <ul id="sidenav" class="nav nav-pills nav-stacked">
                                 ' . $this->_tabs . ' 
                            </ul>
                        </div><!-- .well -->

                    </div><!-- .span3 -->
                    <div class="span9">				
                        <div class="tab-content content-gbcolr">

 ' . $this->_fields . ' 
                        </div><!-- .tab-content -->
                    </div><!-- .span7 -->
                </div><!-- .tabbable -->
               
            </div>
                <div class="page-footer">
                     <button type="submit" class="savebutton btn-button save-button">Change Update</button>
               </div>
            	</form>
	
	<div style="clear:both;"></div>
        </div>';

        return $this->_html;
    }
    public function getAllProducts() {
        global $cookie;
        return Db::getInstance()->ExecuteS('select p.`id_product`, pl.`name` 
		from `' . _DB_PREFIX_ . 'product` p, `' . _DB_PREFIX_ . 'product_lang` pl
		where p.`id_product` = pl.`id_product` and pl.id_lang = ' . (int) Context::getContext()->language->id . ' order by pl.`name` and active=1 ');
    }
     public function getAllCategorys($selected_cat, $categories, $selected, $id_category = 1, $id_category_default = NULL) {
        global $td_cat;
        static $cat_row;

        $identifire = intval(Tools::getValue($this->identifier));

        if (!isset($td_cat[$selected['infos']['id_parent']]))
            $td_cat[$selected['infos']['id_parent']] = 0;
        $td_cat[$selected['infos']['id_parent']] += 1;

        $td_cat_size = sizeof($categories[$selected['infos']['id_parent']]);

        $td_cat_parent = $td_cat[$selected['infos']['id_parent']];
        $level = $selected['infos']['level_depth'] + 1;

        $cat_icon = $level == 1 ? 'lv1.gif' : 'lv' . $level . '_' . ($td_cat_size == $td_cat_parent ? 'f' : 'b') . '.png';

         $this->category .= '
    <tr class="' . ($cat_row++ % 2 ? 'alt_row' : '') . '">
            <td>
                    <input type="radio" name="themesdev_selcat"  id="category_' . $id_category . '" value="' . $id_category . '"' . (($id_category==$selected_cat)? ' checked="checked"' : '') . ' />
            </td>
            <td>
                    ' . $id_category . '
            </td>
            <td>
                    <img src="../img/admin/' . $cat_icon . '" alt="" /> &nbsp;<label for="categoryBox_' . $id_category . '" class="t">' . htmlspecialchars(stripslashes($selected['infos']['name'])) . '</label>
            </td>
    </tr>';

        if (isset($categories[$id_category]))
            foreach ($categories[$id_category] AS $key => $row)
                if ($key != 'infos')
                    $this->getAllCategorys($selected_cat, $categories, $categories[$id_category][$key], $key);
                
         return $this->category;
    }

    public function getSelectedProducts() {
        return Db::getInstance()->ExecuteS('SELECT * FROM `' . _DB_PREFIX_ . 'td_selectedproduct`');
    }

    public function getSelectedCategories() {
        return Configuration::get('themesdev_selcat');
    }
    public function tdOptionPanelFields() {
        global $currentIndex, $cookie;
        $tdoptions = $this->tdoptions;
        $optiondata = array();
        $count = 0;
        $tabs = '';
        $tdfieldsoutput = '';

        foreach ($tdoptions as $result) {

            $count++;
            if ($result['type'] != "heading") {
                $heading_class = '';
                if (isset($result['class'])) {
                    $heading_class = $result['class'];
                }
                $tdfieldsoutput .= '<div class="sectionupload  section-' . $result['type'] . ' ' . $heading_class . '">';

                if (isset($result['name']))
                    $tdfieldsoutput .= '<h3 class="heading">' . $result['name'] . '</h3>';

                if (isset($result['sub_name']))
                    $tdfieldsoutput .= '<h5>' . $result['sub_name'] . '</h5>';

                $tdfieldsoutput .= '<div class="option">';
                   if(!isset($result['desc'])):
                         $tdfieldsoutput .= '<div class="manage managefull">';
                   else:
                        $tdfieldsoutput .= '<div class="manage">';
                   endif;
            }
            switch ($result['type']) {
                case 'block_text':

                    $type_value = $this->getSaveOption($result['id']);


                    $std = $this->getSaveOption($result['id']);
                    if ($std != "") {
                        $type_value = stripslashes($std);
                    }
                    $tdfieldsoutput .= '<input class="td-input" name="' . $result['id'] . '" id="' . $result['id'] . '" type="' . $result['type'] . '" value="' . $type_value . '" />';
                    break;
                case 'text':
                    $type_value = '';

                    $defaultLanguage = (int) (Configuration::get('PS_LANG_DEFAULT'));
                    $divLangName = $result['id'];

                    if (isset($result['lang']) && $result['lang'] == true)
                        $std = $this->getSaveOption($result['id'] . '_' . $defaultLanguage);
                    else
                        $std = $this->getSaveOption($result['id']);

                    if ($std != "") {
                        $type_value = stripslashes($std);
                    }

                    $languages = Language::getLanguages(false);
                    if (isset($result['lang']) && $result['lang'] == true):
                        foreach ($languages as $lang) {

                            $tdfieldsoutput .='<div id="' . $result['id'] . '_' . $lang['id_lang'] . '" style="display: ' . ($lang['id_lang'] == $defaultLanguage ? 'block' : 'none') . ';float: left;">';
                            $tdfieldsoutput .= '<input class="td-input" name="' . $result['id'] . '_' . $lang['id_lang'] . '" id="' . $result['id'] . '_' . $lang['id_lang'] . '" type="' . $result['type'] . '" value="' . $type_value . '" />';
                            $tdfieldsoutput .= '</div>';
                        }

                        $tdfieldsoutput .=$this->displayFlags($languages, $defaultLanguage, $divLangName, $result['id'], true);
                    else:
                        $tdfieldsoutput .= '<input class="td-input" name="' . $result['id'] . '" id="' . $result['id'] . '" type="' . $result['type'] . '" value="' . $type_value . '" />';
                    endif;

                    break;

                case 'select':


                    $tdfieldsoutput .= '<div class="for-body-selected">';
                    $tdfieldsoutput .= '<select class="of-typography of-typography-size select" name="' . $result['id'] . '" id="' . $result['id'] . '">';

                    foreach ($result['options'] as $select_key => $option_val) {


                        $selected_value = $this->getSaveOption($result['id']);

                        if ($selected_value != '') {
                            if ($selected_value == $select_key) {
                                $selected_value = ' selected="selected"';
                            }
                        } else {
                            if ($result['std'] == $select_key) {
                                $selected_value = ' selected="selected"';
                            }
                        }


                        $tdfieldsoutput .= '<option id="' . $select_key . '" value="' . $select_key . '" ' . $selected_value . ' />' . $option_val . '</option>';
                    }
                    $tdfieldsoutput .= '</select></div>';
                    break;
                     case 'category':
                        $tdfieldsoutput .= '
                                    <div  id="categoryList">
                              <table cellspacing="0" cellpadding="0" class="table">';
                       
                        $categories = Category::getCategories(intval($cookie->id_lang), false);
                        $selected_cat = $this->getSelectedCategories();
                        
                            $tdfieldsoutput .= $this->getAllCategorys($selected_cat, $categories, $categories[0][1]);
                    
                    $tdfieldsoutput .= ' </table>
          </div>';
                     break;
                    
                case 'products':
                   
                    
                    
          $selected_product_id = array();
        $products = $this->getAllProducts();
       
        $selected_product = $this->getSelectedProducts();
        
        foreach ($selected_product AS $test => $prodid)
            $selected_product_id[] = $prodid['id_product'];
        
                    $tdfieldsoutput .= '<div>';
                        $tdfieldsoutput .= '<select class="selected_multi" name="td_selected_products[]" id="' . $result['id'] . '" multiple="multiple">';
                   
                            foreach ($products as $p)
                                $tdfieldsoutput .= '<option value="'.intval($p['id_product']).'"'.(in_array($p['id_product'], $selected_product_id) ? ' selected="selected"' : '').'>'.htmlspecialchars(stripslashes($p['name'])).'</option>';
                   $tdfieldsoutput .= '</select></div>';
        
          break;
        
                case 'textarea':
                    $cols = '10';
                    $type_value = '';

                    if (isset($result['options'])) {
                        $text_option = $result['options'];
                        if (isset($text_option['cols'])) {
                            $cols = $text_option['cols'];
                        }
                    }
                    $defaultLanguage = (int) (Configuration::get('PS_LANG_DEFAULT'));
                    $divLangName = $result['id'];

                    if (isset($result['lang']) && $result['lang'] == true)
                        $std = $this->getSaveOption($result['id'] . '_' . $defaultLanguage);
                    else
                        $std = $this->getSaveOption($result['id']);


                    if ($std != "") {
                        $type_value = stripslashes($std);
                    }



                    $languages = Language::getLanguages(false);
                    if (isset($result['lang']) && $result['lang'] == true):
                        foreach ($languages as $lang) {

                            $tdfieldsoutput .='<div id="' . $result['id'] . '_' . $lang['id_lang'] . '" style="display: ' . ($lang['id_lang'] == $defaultLanguage ? 'block' : 'none') . ';float: left;">';
                            $tdfieldsoutput .= '<textarea class="td-input" name="' . $result['id'] . '_' . $lang['id_lang'] . '" id="' . $result['id'] . '_' . $lang['id_lang'] . '" cols="' . $cols . '" rows="8">' . $type_value . '</textarea>';
                            $tdfieldsoutput .= '</div>';
                        }

                        $tdfieldsoutput .=$this->displayFlags($languages, $defaultLanguage, $divLangName, $result['id'], true);
                    else:
                        $tdfieldsoutput .= '<textarea class="td-input" name="' . $result['id'] . '" id="' . $result['id'] . '" cols="' . $cols . '" rows="8">' . $type_value . '</textarea>';
                    endif;


                    break;

                case "radio":

                    $selected_value = $this->getSaveOption($result['id']);

                    foreach ($result['options'] as $option_val => $name) {
                        $checked = '';

                        if ($selected_value = '') {

                            if ($selected_value == $option_val) {
                                $checked = ' checked';
                            }
                        } else {

                            if ($result['std'] == $option_val) {
                                $checked = ' checked';
                            }
                        }



                        $tdfieldsoutput .= '<input class="td-input of-radio" name="' . $result['id'] . '" type="radio" value="' . $option_val . '" ' . $checked . ' /><label class="radio">' . $name . '</label><br/>';
                    }
                    break;

                case 'checkbox':
                    if (!isset($optiondata[$result['id']])) {
                        $optiondata[$result['id']] = 0;
                    }

                    $get_std = $this->getSaveOption($result['id']);
                    $std = $result['std'];
                    $checked = '';

                    if (!empty($get_std)) {
                        if ($get_std == '1') {
                            $checked = 'checked="checked"';
                        } else {
                            $checked = '';
                        }
                    } elseif ($std == '1') {
                        $checked = 'checked="checked"';
                    } else {
                        $checked = '';
                    }

                    $tdfieldsoutput .= '<input type="hidden" class="' . 'checkbox aq-input" name="' . $result['id'] . '" id="' . $result['id'] . '" value="0"/>';
                    $tdfieldsoutput .= '<input type="checkbox" class="' . 'checkbox td-input" name="' . $result['id'] . '" id="' . $result['id'] . '" value="1" ' . $checked . ' />';
                    break;
                case 'upload':
                    $tdfieldsoutput .= $this->tdUploadImage($result['id'], $result['std']);
                    break;
                case 'images':

                    $i = 0;
                    $get_std = $this->getSaveOption($result['id']);
                    $std = $result['std'];
                    foreach ($result['options'] as $key => $option_val) {
                        $i++;
                        if (!empty($get_std)) {
                            if ($get_std == $key) {
                                $selected_value = 'add-radio-picture';
                            } else {
                                $selected_value = '';
                            }
                        } elseif ($std == $key) {
                            $selected_value = 'add-radio-picture';
                        } else {
                            $selected_value = '';
                        }

                        $tdfieldsoutput .= '<span>';
                        $tdfieldsoutput .= '<input type="radio" id="of-radio-img-' . $result['id'] . $i . '" class="checkbox of-radio-img-radio" value="' . $key . '" name="' . $result['id'] . '" ' . $selected_value . ' />';
                        $tdfieldsoutput .= '<div class="for-radio-picture-label">' . $key . '</div>';
                        $tdfieldsoutput .= '<img src="' . $option_val . '" alt="" class="radio-box-picture ' . $selected_value . '" onClick="document.getElementById(\'of-radio-img-' . $result['id'] . $i . '\').checked = true;" />';
                        $tdfieldsoutput .= '</span>';
                    }

                    break;
                case "image":
                    $src = $result['std'];
                    $tdfieldsoutput .= '<img src="' . $src . '">';
                    break;
                case 'heading':
                    if ($count >= 2) {
                        $tdfieldsoutput .= '</div>';
                    }

                    $tabs_class = str_replace(' ', '', strtolower($result['name']));
                    $click_heading = str_replace(' ', '', strtolower($result['name']));
                    $click_heading = "of-option-" . $click_heading;
                    $tabs .= '<li class="' . $tabs_class . ' "><a  data-toggle="tab" title="' . $result['name'] . '" href="#' . $click_heading . '">' . $result['name'] . '</a></li>';
                    $tdfieldsoutput .= '<div class="tab-pane" id="' . $click_heading . '"> <div class="alerts alert-success"><h4>' . $result['name'] . '</h4></div>' . "\n";
                 break;
               
            }
            if ($result['type'] != 'heading') {
                if (!isset($result['desc'])) {
                    $explain_value = '';
                } else {
                    $explain_value = '<div class="explain">' . $result['desc'] . '</div>';
                }
                $tdfieldsoutput .= '</div>' . $explain_value;
                $tdfieldsoutput .= '<div class="clear"> </div></div></div>';
            }
        }
        $tdfieldsoutput .= '</div>';

        return array($tdfieldsoutput, $tabs);
    }

   

    public function hookHome($params) {
        
        global $smarty;
            $slider_type = Configuration::get('themesdev_slider_type');
            $number_of_count = Configuration::get('themesdev_numpro');
          $products='';
            if ($slider_type == "special_products"):
                $products = Product::getPricesDrop((int) $params['cookie']->id_lang, NULL, $number_of_count);
            elseif ($slider_type == "new_products"):
                $products = Product::getNewProducts((int) $params['cookie']->id_lang, NULL, $number_of_count, false, NULL, NULL);
            elseif ($slider_type == "best_sells"):
                $products = ProductSale::getBestSales((int) $params['cookie']->id_lang, NULL, $number_of_count, NULL, NULL);
            elseif ($slider_type == "featured_products"):
                $category = new Category(Context::getContext()->shop->getCategory(), (int) Context::getContext()->language->id);
                $products = $category->getProducts((int) Context::getContext()->language->id, NULL, $number_of_count);
            elseif ($slider_type == "selected_category"):
                $selected_cat = $this->getSelectedCategories();

                $category = new Category($selected_cat, intval($params['cookie']->id_lang));
                $products = $category->getProducts($params['cookie']->id_lang, NULL, $number_of_count);

            elseif ($slider_type == "selected_products"):
                $selproduct = $this->getSelectedProducts();

                $testss = array();
                foreach ($selproduct as $testes):
                    $testss[] = $testes['id_product'];
                endforeach;

                $ids = join(',', $testss);
                if (!isset($context))
                    $context = Context::getContext();
          
                $sql = 'SELECT p.*, product_shop.*, pl.* , t.`rate` AS tax_rate, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity,image_shop.`id_image`,
                                il.`legend`,(product_shop.`price` * ((100 + (t.`rate`))/100)) AS orderprice
				FROM `' . _DB_PREFIX_ . 'product` p
				' . Shop::addSqlAssociation('product', 'p') . '
                                ' . Product::sqlStock('p', 0, true) . '
				LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl ON (p.`id_product` = pl.`id_product` ' . Shop::addSqlRestrictionOnLang('pl') . ')
				LEFT JOIN `' . _DB_PREFIX_ . 'tax_rule` tr ON (product_shop.`id_tax_rules_group` = tr.`id_tax_rules_group`
		 		AND tr.`id_country` = ' . (int) Context::getContext()->country->id . '
		 		AND tr.`id_state` = 0)
	  		 	LEFT JOIN `' . _DB_PREFIX_ . 'tax` t ON (t.`id_tax` = tr.`id_tax`)
                                LEFT JOIN `' . _DB_PREFIX_ . 'image` i ON (i.`id_product` = p.`id_product`)' .
                        Shop::addSqlAssociation('image', 'i', true, 'image_shop.cover=1') . '
                                LEFT JOIN `' . _DB_PREFIX_ . 'image_lang` il ON (i.`id_image` = il.`id_image` AND il.`id_lang` = ' . (int) $this->context->language->id . ')
				where p.id_product IN (' . $ids . ') and pl.id_lang = ' . (int) $this->context->language->id . ' ';


                $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
                $products = Product::getProductsProperties($params['cookie']->id_lang, $result);



            endif;

            $count = count($products);
          
            $this->smarty->assign(array(
                'products_slider' => $products,
                'products_count' => $number_of_count,
                'total_number' => $count,
                'slider_type'=>$slider_type,
                'product_type' => Configuration::get('wd_product_slider_type'),
                'homesize' => Image::getSize('home'),
            ));

            return $this->display(__FILE__, 'tdproductsslider.tpl');
    }


}

?>