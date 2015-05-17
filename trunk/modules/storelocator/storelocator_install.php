<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hitanshu
 * Date: 24/8/13
 * Time: 12:56 PM
 * To change this template use File | Settings | File Templates.
 */
if (!defined('_PS_VERSION_'))
    exit;
class StoreLocatorInstall
{
    /**
     * Create Service Center table
     */
    public function createTables()
    {
        /* Set database for service centers */
        if (!Db::getInstance()->Execute('
		CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'store_locator` (
			`id_store_locator` int(10) unsigned NOT NULL AUTO_INCREMENT,
			`product` varchar(1000) DEFAULT NULL,
			`state` varchar(1000) DEFAULT NULL,
			`city` varchar(1000) DEFAULT NULL,
			`location` varchar(1000) NOT NULL,
            `store_name` varchar(1000) NOT NULL,
            `landline` varchar(1000) NOT NULL,
            `address` text NOT NULL,
		    PRIMARY KEY (`id_store_locator`)
		) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8 AUTO_INCREMENT=1')
        )
            return false;
    }
}
