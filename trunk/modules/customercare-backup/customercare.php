<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hitanshu
 * Date: 14/11/13
 * Time: 5:43 PM
 * To change this template use File | Settings | File Templates.
 */
if (!defined('_PS_VERSION_'))
    exit;

class CustomerCare extends Module
{

    function __construct()
    {
        $this->name = 'customercare';
        $this->tab = 'front_office_features';
        $this->version = '1.0';
        $this->author = 'GAPS';
        $this->need_instance = 0;

        parent::__construct();

        $this->displayName = $this->l('Milagrow Help Desk Integration');
        $this->description = $this->l('Milagrow HelpDesk Integration module developed by gaps');
    }

    function install()
    {
        if (!parent::install() || !$this->registerHook('header') || !$this->registerHook('customerAccount'))
            return false;
        return true;
    }

    public function uninstall()
    {
        if (!parent::uninstall())
            return false;
        return true;
    }

    /*
 *  my account hook that show tpl for Customer Care
 */
    public function hookcustomerAccount()
    {
        return $this->display(__FILE__, 'customer-care.tpl');
    }
}