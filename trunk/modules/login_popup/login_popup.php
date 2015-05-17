<?php
/**
 * Created by PhpStorm.
 * User: hitanshu
 * Date: 25/11/13
 * Time: 10:09 PM
 */

class Login_Popup extends Module {
    private $_html = '';
    private $_postErrors = array();

    public function __construct()
    {
        $this->name = 'login_popup';
        $this->tab = 'front_office_features';
        $this->version = '1.0';
        $this->author = 'GAPS';
        $this->need_instance = 0;
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        parent::__construct();

        $this->displayName = $this->l('Login Pop Up');
        $this->description = $this->l('Display pop up for login');
    }

    /**
     * @see ModuleCore::install()
     */
    public function install()
    {
        if (!parent::install() ||
            !$this->registerHook('displayHome') ||
            !$this->registerHook('header')
        )
            return false;
        return true;
    }

    public function uninstall()
    {
        return parent::uninstall();
    }

    public function hookHeader()
    {
        if (Configuration::get('PS_CATALOG_MODE'))
            return;
        $this->context->controller->addCSS($this->_path . 'login_popup.css', 'all');
        $this->context->controller->addJS($this->_path.'login_popup.js');
    }


} 