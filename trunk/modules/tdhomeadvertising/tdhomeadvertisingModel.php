<?php

class tdHomeAdvertisingModel extends ObjectModel {

    public static function createTables() {
        return (
                tdhomeadvertisingModel::createtdhomeadvertisingTable() &&
                tdhomeadvertisingModel::createtdhomeadvertisingLangTable() &&
                tdhomeadvertisingModel::createtdDefaultData()
                );
    }

    public static function dropTables() {
        return Db::getInstance()->execute('DROP TABLE
			`' . _DB_PREFIX_ . 'tdhomeadvertising`,
			`' . _DB_PREFIX_ . 'tdhomeadvertising_lang`');
    }

    public static function createtdDefaultData() {

        $sql= Db::getInstance()->Execute('
		INSERT INTO `' . _DB_PREFIX_ . 'tdhomeadvertising`(`image_link`, `active`, `position`, `new_page`) VALUES("http://yourlink.com",1,0,0)');

        $sql .= Db::getInstance()->Execute('
		INSERT INTO `' . _DB_PREFIX_ . 'tdhomeadvertising`(`image_link`, `active`, `position`, `new_page`) VALUES("http://yourlink.com",1,1,0)');
        $sql .= Db::getInstance()->Execute('
		INSERT INTO `' . _DB_PREFIX_ . 'tdhomeadvertising`(`image_link`, `active`, `position`, `new_page`) VALUES("http://yourlink.com",1,1,0)');


        $languages = Language::getLanguages(false);
        for ($i = 1; $i <= 3; $i++) {
            if ($i == 1):
                $title = "Promo Banner 1";
            elseif ($i == 2):
                $title = "Promo Banner 2";
             elseif ($i == 2):
                $title = "Promo Banner 3";
            endif;
            foreach ($languages as $language) {
                $sql .=Db::getInstance()->Execute('
                        INSERT INTO `' . _DB_PREFIX_ . 'tdhomeadvertising_lang`(`id_tdhomeadvertising`, `id_lang`, `image_title`, `image_url`) 
                        VALUES(' . $i . ', ' . (int) $language['id_lang'] . ', 
                        "' . $title . '", 
                        "modules/tdhomeadvertising/images/home-' . $i . '.jpg")');
            }
        }
        return $sql;
    }

    public static function createtdhomeadvertisingTable() {
        return (Db::getInstance()->Execute('
		CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'tdhomeadvertising` (
	        `id_tdhomeadvertising` int(10) unsigned NOT NULL auto_increment,
		`image_link` varchar(255) NOT NULL,
                `active` int(11) unsigned NOT NULL,
                `position` int(11) unsigned NOT NULL default \'0\',
                `new_page` int(11) unsigned NOT NULL,
		PRIMARY KEY (`id_tdhomeadvertising`))
		ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8'));
    }

    public static function createtdhomeadvertisingLangTable() {
        return (Db::getInstance()->Execute('
		CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'tdhomeadvertising_lang` (
		`id_tdhomeadvertising` int(10) unsigned NOT NULL,
		`id_lang` int(10) unsigned NOT NULL,
                `image_title` varchar(255) NOT NULL,
                `image_url` varchar(255) NOT NULL,
		PRIMARY KEY (`id_tdhomeadvertising`, `id_lang`))
		ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8'));
    }

    public static function getAllSlider() {
        global $cookie;
        return Db::getInstance()->ExecuteS('
            SELECT td.`id_tdhomeadvertising`, td.`image_link`, td.`active`, td.`position`, td.`new_page`,td1.`image_url`, td1.image_title
            FROM `' . _DB_PREFIX_ . 'tdhomeadvertising` td
            INNER JOIN `' . _DB_PREFIX_ . 'tdhomeadvertising_lang` td1 ON (td.`id_tdhomeadvertising` = td1.`id_tdhomeadvertising`)
            WHERE td1.`id_lang` = ' . (int) $cookie->id_lang . '
            ORDER BY td.`position`');
    }

    public static function getSliderByID($id_tdhomeadvertising) {

        $getslider = Db::getInstance()->ExecuteS('
            SELECT td.`id_tdhomeadvertising`, td.`image_link`, td.`active`, td.`position`, td.`new_page`,td1.id_lang, td1.image_title, td1.`image_url`
            FROM `' . _DB_PREFIX_ . 'tdhomeadvertising` td
            INNER JOIN `' . _DB_PREFIX_ . 'tdhomeadvertising_lang` td1 ON (td.`id_tdhomeadvertising` = td1.`id_tdhomeadvertising`)
            WHERE td.`id_tdhomeadvertising` = ' . (int) $id_tdhomeadvertising);


        $store_display_update = array(0, $size = count($getslider));
        foreach ($getslider AS $sliderbyid) {
            $getslider['image_title'][(int) $sliderbyid['id_lang']] = $sliderbyid['image_title'];
            if ($store_display_update['0'] < $store_display_update['1'])
                ++$store_display_update['0'];
        }
        foreach ($getslider AS $imagecaption) {
            $getslider['image_url'][(int) $imagecaption['id_lang']] = $imagecaption['image_url'];
            if ($store_display_update['0'] < $store_display_update['1'])
                ++$store_display_update['0'];
        }
        return $getslider;
    }

}