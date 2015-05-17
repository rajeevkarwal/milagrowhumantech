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

class FeedbackInstall
{
    /**
     * Create Feedback table
     */

    public function createTables()
    {

        /* Set database */
        $sql = "CREATE TABLE IF NOT EXISTS " . _DB_PREFIX_ . "feedbacks (
  `feedback_id` int(10) NOT NULL AUTO_INCREMENT,
  `email` varchar(1000) DEFAULT NULL,
  `mobile` varchar(1000) DEFAULT NULL,
  `message` text DEFAULT NULL,
 `currentUrl` varchar(1000) DEFAULT NULL,
 `category` varchar(1000) DEFAULT NULL,
 `experience` varchar(1000) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`feedback_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
        if (!Db::getInstance()->Execute($sql)
        )
            return false;
    }


}