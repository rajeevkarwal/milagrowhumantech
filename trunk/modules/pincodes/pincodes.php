<?php
if (!defined('_PS_VERSION_'))
    exit;

class PinCodes extends Module
{
    public function __construct()
    {
        $this->name = 'pincodes';
        $this->tab = 'front_office_features';
        $this->version = '1.0';
        $this->author = 'GAPS';

        $this->need_instance = 0;
//        $this->ps_versions_compliancy = array('min' => '1.5', 'max' => '1.5');

        parent::__construct();

        $this->displayName = $this->l('PinCodes');
        $this->description = $this->l('Delivery address management');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        if (!Configuration::get('MYMODULE_NAME'))
            $this->warning = $this->l('No name provided');
    }

    public function install()
    {
        if (!parent::install()
        )
            return false;
        include_once 'pincodes_install.php';
        $pinCodes_install = new PincodesInstall();
        $pinCodes_install->createTables();

        return true;
    }

    public function uninstall()
    {
        return parent::uninstall() && Configuration::deleteByName('MYMODULE_NAME');
    }

    public function getCityAndStateFromThePinCode($pincode)
    {
        $sql = 'select id_state,city from ' . _DB_PREFIX_ . 'pincode_cod where pincode=\'' . $pincode . '\'';
        $row = Db::getInstance()->getRow($sql);
        if ($row)
            return $row;
        else
            return false;
    }

}

