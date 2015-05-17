<?php

class PsmodImagesliderModel extends ObjectModel {

    public static function createTables() {
        return (
                PsmodImagesliderModel::createsccimagesliderTable() &&
                PsmodImagesliderModel::createsccimagesliderLangTable() &&
                PsmodImagesliderModel::createSCCDefaultData()
                );
    }

    public static function dropTables() {
        return Db::getInstance()->execute('DROP TABLE
			`' . _DB_PREFIX_ . 'sccimageslider`,
			`' . _DB_PREFIX_ . 'sccimageslider_lang`');
    }

    public static function createSCCDefaultData() {

        $sql= Db::getInstance()->Execute('
		INSERT INTO `' . _DB_PREFIX_ . 'sccimageslider`(`image_link`, `active`, `position`, `new_page`) VALUES("http://yourlink.com",1,0,0)');

        $sql .= Db::getInstance()->Execute('
		INSERT INTO `' . _DB_PREFIX_ . 'sccimageslider`(`image_link`, `active`, `position`, `new_page`) VALUES("http://yourlink.com",1,1,0)');

        $sql .= Db::getInstance()->Execute('
		INSERT INTO `' . _DB_PREFIX_ . 'sccimageslider`(`image_link`, `active`, `position`, `new_page`) VALUES("http://yourlink.com",1,2,0)');

      

        $languages = Language::getLanguages(false);
        for ($i = 1; $i <= 3; $i++) {
            if ($i == 1):
                $title = "Slider 1";
            elseif ($i == 2):
                $title = "Slider 2";
            elseif ($i == 3):
                $title = "Slider 3";
            endif;
            foreach ($languages as $language) {
                $sql .=Db::getInstance()->Execute('
                        INSERT INTO `' . _DB_PREFIX_ . 'sccimageslider_lang`(`id_sccimageslider`, `id_lang`, `image_title`, `image_url`) 
                        VALUES(' . $i . ', ' . (int) $language['id_lang'] . ', 
                        "' . $title . '", 
                        "modules/psmodimageslider/images/slider-' . $i . '.jpg")');
            }
        }
        return $sql;
    }

    public static function createsccimagesliderTable() {
        return (Db::getInstance()->Execute('
		CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'sccimageslider` (
	        `id_sccimageslider` int(10) unsigned NOT NULL auto_increment,
		`image_link` varchar(255) NOT NULL,
                `active` int(11) unsigned NOT NULL,
                `position` int(11) unsigned NOT NULL default \'0\',
                `new_page` int(11) unsigned NOT NULL,
		PRIMARY KEY (`id_sccimageslider`))
		ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8'));
    }

    public static function createsccimagesliderLangTable() {
        return (Db::getInstance()->Execute('
		CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'sccimageslider_lang` (
		`id_sccimageslider` int(10) unsigned NOT NULL,
		`id_lang` int(10) unsigned NOT NULL,
                `image_title` varchar(255) NOT NULL,
                `image_url` varchar(255) NOT NULL,
		PRIMARY KEY (`id_sccimageslider`, `id_lang`))
		ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8'));
    }

    public static function getAllSlider() {
        global $cookie;
        return Db::getInstance()->ExecuteS('
            SELECT scc.`id_sccimageslider`, scc.`image_link`, scc.`active`, scc.`position`, scc.`new_page`,scc1.`image_url`, scc1.image_title
            FROM `' . _DB_PREFIX_ . 'sccimageslider` scc
            INNER JOIN `' . _DB_PREFIX_ . 'sccimageslider_lang` scc1 ON (scc.`id_sccimageslider` = scc1.`id_sccimageslider`)
            WHERE scc1.`id_lang` = ' . (int) $cookie->id_lang . '
            ORDER BY scc.`position`');
    }

    public static function getSliderByID($id_sccimageslider) {

        $getslider = Db::getInstance()->ExecuteS('
            SELECT scc.`id_sccimageslider`, scc.`image_link`, scc.`active`, scc.`position`, scc.`new_page`,scc1.id_lang, scc1.image_title, scc1.`image_url`
            FROM `' . _DB_PREFIX_ . 'sccimageslider` scc
            INNER JOIN `' . _DB_PREFIX_ . 'sccimageslider_lang` scc1 ON (scc.`id_sccimageslider` = scc1.`id_sccimageslider`)
            WHERE scc.`id_sccimageslider` = ' . (int) $id_sccimageslider);


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