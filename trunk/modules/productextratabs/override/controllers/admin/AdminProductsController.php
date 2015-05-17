<?php

class AdminProductsController extends AdminProductsControllerCore 
{
    private $module_name = 'productextratabs';
    
    public function __construct() {
        parent::__construct();
        
        $this->available_tabs_lang['Tabs'] = $this->l('Tabs');
        $this->available_tabs['Tabs'] = 15;
        
        require_once(_PS_MODULE_DIR_ . $this->module_name . '/classes/PETTabClass.php');
        require_once(_PS_MODULE_DIR_ . $this->module_name . '/classes/PETTabContentClass.php');
        require_once(_PS_MODULE_DIR_ . $this->module_name . '/productextratabs.php');        
    }

    public function initFormTabs($product) {
        /**
         * Tabs data
         */
        //Valida que exista el tabs.tpl
        if (!file_exists(_PS_ROOT_DIR_ . '/override/controllers/admin/templates/products/tabs.tpl')) {
            $this->displayWarning('You must copy the folder "override/" of module at the root of your store "/override/"');

            $this->tpl_form_vars['custom_form'] = "&nbsp;";

            return;
        }

        $tabs = PETTabClass::getAvailablePetTabs();

        for ($i = 0; $i < count($tabs); $i++) {
            $tabs[$i]['own'] = FALSE;

            $content_tab = PETTabClass::getContentTabsByIdTab($tabs[$i]['id_tab'], $this->object->id);

            $default_content_tab = array();

            foreach ($content_tab as $content) {


                if ($content['content'] != '') {
                    $own = PETTabContentClass::tab_content_exist($tabs[$i]['id_tab'], $this->object->id, $this->object->id_category_default);
                    if ($own === FALSE) {
                        $default_content_tab[$content['id_lang']] = '';
                        continue;
                    } else {
                        $tabs[$i]['own'] = TRUE;
                        $default_content_tab[$content['id_lang']] = $content['content'];
                    }
                }
            }

            //add content to var
            $tabs[$i]['content'] = $default_content_tab;
        }

        $languages_flag = array();
        foreach ($this->_languages as $k => $language) {
            $languages_flag[$k] = (object) array(
                        'id_lang' => (int) $language['id_lang'],
                        'iso_code' => '\'' . $language['iso_code'] . '\'',
                        'name' => '\'' . htmlentities($language['name'], ENT_COMPAT, 'UTF-8') . '\''
            );
        }

        $languages_flag = json_encode($languages_flag);

        $data = $this->createTemplate($this->tpl_form);

        //employee cokie
        $allowEmployeeFormLang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        
        $this->object = $product;
        $this->display = 'edit';
        
        // TinyMCE
        $iso_tiny_mce = $this->context->language->iso_code;
        $iso_tiny_mce = (file_exists(_PS_JS_DIR_ . 'tiny_mce/langs/' . $iso_tiny_mce . '.js') ? $iso_tiny_mce : 'en');

        $data->assign('ad', dirname($_SERVER['PHP_SELF']));
        $data->assign('iso_tiny_mce', $iso_tiny_mce);
        $data->assign('id_lang', $this->context->language->id);
        
        $data->assign(array(
            'ad' => dirname($_SERVER['PHP_SELF']),
            'iso_tiny_mce' => $iso_tiny_mce,
            'id_lang' => $this->context->language->id,
            'allowEmployeeFormLang' => $allowEmployeeFormLang,
            'languages' => $this->_languages,
            'languages_flag' => $languages_flag,
            'default_form_language' => $this->default_form_language,
            'product' => $product,
            'tabs' => $tabs
        ));

        $this->addJS(array('modules/' . $this->module_name . '/js/productextratabs_back.js'));

        $this->tpl_form_vars['product'] = $product;

        $this->tpl_form_vars['custom_form'] = $data->fetch();
    }

    public function checkProduct() {
        $productExtraTabs = new ProductExtraTabs();
        
        $tabs = Tools::getValue('id_tabs');

        $languages = Language::getLanguages(false);

        foreach ($tabs as $key => $id_tab) {
            $content_lang = array();

            $id_tab_content = PETTabContentClass::tab_content_exist($id_tab, $this->object->id, $this->object->id_category_default);

            $update_tab = Tools::getValue('update_tab_content_' . $id_tab);

            if (!$update_tab) {
                if ($id_tab_content){
                    $PETTabContentClass = new PETTabContentClass((int)$id_tab_content);
                    $PETTabContentClass->delete();
                }
                continue;
            }

            foreach ($languages as $language) {

                $field_name = 'tab_content_' . $id_tab . '_' . $language['id_lang'];
                $tab_content_lang = Tools::getValue($field_name);

                $content = new stdClass();

                $content->id_lang = $language['id_lang'];
                $content->content = base64_encode($tab_content_lang);

                $content_lang[] = $content;
            }

            $product = new Product($this->object->id);

            $r = $productExtraTabs->updateTabContent($id_tab_content, $id_tab, $this->object->id, $product->id_category_default, $content_lang);

            $r = $productExtraTabs->jsonDecode($r);

            if ($r->message_code == -1) {
                $this->errors[] = $r->message;
            }
        }
        
        parent::checkProduct();
    }
}
?>