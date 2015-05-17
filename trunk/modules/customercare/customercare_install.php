<?php
/**
 * Created by JetBrains PhpStorm.
 * User: keshav
 * Date: 6/8/13
 * Time: 5:15 PM
 * To change this template use File | Settings | File Templates.
 */
if (!defined('_PS_VERSION_'))
    exit;

class CustomerCareInstall
{
    /**
     * Create customer queries tables
     */
    public function createTables()
    {

        /* Set database */
        $sql = "CREATE TABLE IF NOT EXISTS " . _DB_PREFIX_ . "customer_care (
  `customer_care_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(1000) DEFAULT NULL,
  `email` varchar(1000) DEFAULT NULL,
  `phone_number` varchar(1000) DEFAULT NULL,
  `product` varchar(1000) DEFAULT NULL,
  `state` varchar(1000) DEFAULT NULL,
   `city` varchar(1000) DEFAULT NULL,
  `category` varchar(1000) DEFAULT NULL,
  `is_existing_customer` tinyint(1) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`customer_care_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
        if (!Db::getInstance()->Execute($sql)
        )
            return false;
    }


}