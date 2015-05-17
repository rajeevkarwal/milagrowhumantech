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
class ServiceCenterInstall
{
    /**
     * Create Service Center table
     */
    public function createTables()
    {
        /* Set database for service centers */
        if (!Db::getInstance()->Execute('
		CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'service_center` (
			`id_service_center` int(10) unsigned NOT NULL AUTO_INCREMENT,
			`state` varchar(1000) DEFAULT NULL,
			`city` varchar(1000) DEFAULT NULL,
			`asc_name` varchar(1000) DEFAULT NULL,
			`asp_address` TEXT DEFAULT NULL,
			`pincode` varchar(255) DEFAULT NULL,
			`contact_person` varchar(1000) DEFAULT NULL,
			`contact_number` varchar(255) DEFAULT NULL,
			`mobile_number` varchar(100) DEFAULT NULL,
			`emailid` varchar(1000) DEFAULT NULL,
		    PRIMARY KEY (`id_svc`)
		) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8 AUTO_INCREMENT=1')
        )
            return false;
    }
}
