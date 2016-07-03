<?php
/**
 * Created by PhpStorm.
 * User: KISHOR PANT
 * Date: 5/17/2016
 * Time: 10:40 AM
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

class renting_model_install
{
    //table for rental products
    function install_product()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `ps_product_rental` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
         `product_id` int(11) NOT NULL,
         `category_id` int(11) NOT NULL,
           `offer_for` int(11) NOT NULL,
         `product_value` int(11) NOT NULL,
          `security_value` int(11) NOT NULL,
            `installment_mode` int(11) NOT NULL,
            `installment_amount` int(11) NOT NULL,
                 `min_period` int(11) NOT NULL,
           `max_period` int(11) NOT NULL,
  `visit_per_month` int(11) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";
        return Db::getInstance()->Execute($sql);
    }
    function install_customer()
    {
  $sql="CREATE TABLE IF NOT EXISTS `ps_rental_customer` (
  `rent_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `name` varchar(1000) NOT NULL,
  `email` varchar(1000) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `date_of_birth` varchar(20) NULL,
  `year_of_establishment` int NULL,
  `address` text NOT NULL,
  `state` varchar(1000) NOT NULL,
  `city` varchar(1000) NOT NULL,
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `payment_mode` int(11) NOT NULL,
  `payment_duration` int(11) NOT NULL,
  `monthly_rental` double NOT NULL,
  `product_price` double NOT NULL,
  `security_deposited` double NOT NULL,
  `status` tinyint(1) NOT NULL,
  `monthly_rental_expire` date,
  `tenure_expiration_date` date,
  `image_url` text NULL,
  `id_url` text NULL,
  `address_url` text NULL,
  `payment_status` tinyint(1) NOT NULL,
  `sent_monthly_mail` int(11) NOT NULL,
  `sent_tenure_mail` int(11) NOT NULL,
  `applied_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`rent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1  AUTO_INCREMENT=1 ;";
        return Db::getInstance()->Execute($sql);
    }
	function install_pincode()
	{
		$sql="CREATE TABLE IF NOT EXISTS `ps_rental_product_cities`(
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`product_id` int(11) NOT NULL,
		`pincode` varchar(7) NOT NULL,
		`status` tinyint(1) NOT NULL,
		PRIMARY KEY(`id`)
		)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";
		return Db::getInstance()->Execute($sql);
	}
	function managePayment()
	{
		$sql="CREATE TABLE IF NOT EXISTS `ps_customer_rent_received` (
		 `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  	 	`rent_id` int(11) NOT NULL,
 		 `payment_pending` int(11) NOT NULL,
  		`payment_received` int(11) NOT NULL,
 		 `payment_mode` int(11) NOT NULL,
		  `bank_name` varchar(1000) NULL,
		  `document_number` varchar(1000) NULL,
		  `status` tinyint(1) NOT NULL,
 		 `DateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 		 PRIMARY KEY(`payment_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='For Payment Received' AUTO_INCREMENT=1 ;";
		return Db::getInstance()->Execute($sql);
	}
	function install_management()
	{
		$sql="CREATE TABLE IF NOT EXISTS `ps_rental_metadata` (
			`column_id` int(11) NOT NULL AUTO_INCREMENT,
  		`rent_id` int(11) NOT NULL,
 			`product_id` int(11) NOT NULL,
 			 `last_payment_id` int(11) NOT NULL,
		 	 `discount` int(11) NOT NULL,
		  	`discount_reason` int(11) NOT NULL,
		  	`last_payment` datetime,
		 	 `comment` text NULL,
		  	`datetime`timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 		 PRIMARY KEY(`column_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='For Payment Received' AUTO_INCREMENT=1 ;";
		return Db::getInstance()->Execute($sql);
	}
	function manage_rental_period()
	{
		$sql="CREATE TABLE IF NOT EXISTS `ps_manage_rental` 
		(
			`id` int(11) NOT NULL AUTO_INCREMENT,
  		`rent_id` int(11) NOT NULL,
 			 `rent_duration` int(11) NOT NULL,
 			 `extend_period` tinyint(1) NOT NULL,
 			 `extend_duration` int(11) NOT NULL,
		 	 `extending_date` datetime NOT NULL,
		 	 `extended_rental` int(11) NOT NULL,
		  	`datetime`timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 		 PRIMARY KEY(`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='For Payment Received' AUTO_INCREMENT=1 ;";
		return Db::getInstance()->Execute($sql);
	}
	
}
