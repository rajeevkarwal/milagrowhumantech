<?php
if (!defined('_PS_VERSION_'))
    exit;

class ComboOffers extends Module
{
    public function __construct()
    {

        $this->name = 'combooffers';
        $this->tab = 'front_office_features';
        $this->version = '1.0';
        $this->author = 'HITANSHU';
        $this->need_instance = 0;
//        $this->ps_versions_compliancy = array('min' => '1.5', 'max' => '1.5');

        parent::__construct();

        $this->displayName = $this->l('combooffers');
        $this->description = $this->l('This module will used to create combo offers page');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
    }

    public function install()
    {
        if (!parent::install())
            return false;
        return true;
    }

    public function uninstall()
    {
        if (!parent::uninstall())
            return false;
        return true;
    }



}
