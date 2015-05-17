<?php
/*
 * 2007-2013 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author PrestaShop SA <contact@prestashop.com>
 *  @copyright  2007-2013 PrestaShop SA
 *  @version  Release: $Revision: 14390 $
 *  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

if (!defined('_PS_VERSION_'))
    exit;

class CareersInstall
{
    /**
     * Create careers tables
     */
    public function createTables()
    {
        /* Set database */
        if (!Db::getInstance()->Execute('
		CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'careers` (
			`id_careers` int(10) unsigned NOT NULL AUTO_INCREMENT,
			`name` varchar(255) NOT NULL,
			`email` varchar(255) NOT NULL,
			`dob` date NOT NULL,
			`phone` varchar(255) NOT NULL,
			`address` text NULL,
			`state` varchar(1000) DEFAULT NULL,
            `city` varchar(1000) DEFAULT NULL,
			`department` varchar(255) DEFAULT NULL,
			`education` varchar(255) NOT NULL,
			`professional` varchar(255) NOT NULL,
			`skill` varchar(255) DEFAULT NULL,
			`career_highlights` text DEFAULT NULL,
			`work_experience` int(10) DEFAULT NULL,
			`resume_file` varchar(255) NOT NULL,
			`created_at` datetime NOT NULL,
		    PRIMARY KEY (`id_careers`)
		) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8 AUTO_INCREMENT=2')
        )
            return false;
    }


}
