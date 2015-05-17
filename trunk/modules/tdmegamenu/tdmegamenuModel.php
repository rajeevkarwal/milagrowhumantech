<?php

class TdMegaMenuModel extends ObjectModel {

    public static function createTables() {
        return (
                TdMegamenuModel::createtdmegamenuTable() &&
                TdMegamenuModel::createtdmegamenuLangTable()
                 && TdMegamenuModel::createtdDefaultData()
                );
    }

    public static function dropTables() {
        return Db::getInstance()->execute('DROP TABLE
			`' . _DB_PREFIX_ . 'tdmegamenu`,
			`' . _DB_PREFIX_ . 'tdmegamenu_lang`');
    }

  
    public static function createtdmegamenuTable() {
        return (Db::getInstance()->Execute('
		CREATE TABLE IF NOT EXISTS `'. _DB_PREFIX_ .'tdmegamenu`(
	        `id_tdmegamenu`int(10) unsigned NOT NULL,
                `menu_type` varchar(255) NOT NULL,
		`link` varchar(255) NOT NULL,
                `publish` int(11) unsigned NOT NULL,
                `order` int(11) unsigned NOT NULL default \'0\',
                `parent` int(11) unsigned NOT NULL,
                `custome_type` varchar(255) NOT NULL,
                `id_shop` INT UNSIGNED NOT NULL,
		PRIMARY KEY (`id_tdmegamenu`))
		ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8'));
    }

    public static function createtdmegamenuLangTable() {
        return (Db::getInstance()->Execute('
		CREATE TABLE IF NOT EXISTS `'. _DB_PREFIX_ .'tdmegamenu_lang`(
		`id_tdmegamenu` int(10) unsigned NOT NULL,
		`id_lang` int(10) unsigned NOT NULL,
                `menu_title` varchar(255) NOT NULL,
                `description` varchar(255) NOT NULL)
		ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8'));
    }
    
        public static function createtdDefaultData() {
        $context = Context::getContext();
        $id_shop = $context->shop->id;
              $sql =Db::getInstance()->Execute('
            INSERT INTO `' . _DB_PREFIX_ . 'tdmegamenu`(`id_tdmegamenu`,`menu_type`,`link`,`publish`,`order`,`parent`,`custome_type`,`id_shop`) 
            VALUES(1,"LNK1","index.php", 1,1,0,"cus_url",' . $id_shop . ')');

        
        $languages = Language::getLanguages(false);

            
             $title = "Home";
            
            foreach ($languages as $language) {
                
                $sql .=Db::getInstance()->Execute('
                INSERT INTO `' . _DB_PREFIX_ . 'tdmegamenu_lang`(`id_tdmegamenu`,`id_lang`,`menu_title`,`description`) 
                VALUES(1, ' . (int) $language['id_lang'] . ', "'.$title.'", "")');
  
        }
        return $sql;
     
    }

    

    public static function getAllMegaMenu($id_lang, $parent = 0) {
        global $cookie;
     $context = Context::getContext();
		$id_shop = $context->shop->id;
                $allmenus= array();
                
        $allselectedmenus= Db::getInstance()->ExecuteS('
            SELECT td.`id_tdmegamenu`, td.`link`,td.`menu_type`, td.`publish`, td.`order`,td.`parent`,td.`custome_type`,td1.`menu_title`,td1.`description`
            FROM `' . _DB_PREFIX_ . 'tdmegamenu` td
            INNER JOIN `' . _DB_PREFIX_ . 'tdmegamenu_lang` td1 ON (td.`id_tdmegamenu` = td1.`id_tdmegamenu`)
            WHERE td1.`id_lang` = ' . $id_lang . ' and td.`id_shop`='.$id_shop.' and td.parent = "' . $parent . '"
            ORDER BY td.`order`');
        
        
           $i = 0;
                foreach ($allselectedmenus as $tdmenulinks) {

            $allmenus[$i] = $tdmenulinks;



            $allmenus[$i]['submenu'] = self::getAllMegaMenu($id_lang, $tdmenulinks['id_tdmegamenu']);



            $i++;

        }

         return $allmenus;
           

    }
     public static function getAllRootMegaMenu($id_lang, $parent = 0) {
        global $cookie;
           $context = Context::getContext();
		$id_shop = $context->shop->id;
                $allmenu= array();
                
        $allmenu=Db::getInstance()->ExecuteS('
            SELECT td.`id_tdmegamenu`, td.`link`,td.`menu_type`, td.`publish`, td.`order`,td.`parent`,td.`custome_type`,td1.`menu_title`,td1.`description`
            FROM `' . _DB_PREFIX_ . 'tdmegamenu` td
            INNER JOIN `' . _DB_PREFIX_ . 'tdmegamenu_lang` td1 ON (td.`id_tdmegamenu` = td1.`id_tdmegamenu`)
            WHERE td1.`id_lang` = ' . (int) $id_lang . ' and td.`id_shop`='.$id_shop.' and td.`parent` = 0 
            ORDER BY td.`order`');
        
        $i = 0;
                foreach ($allmenus as $tdmenulinks) {

            $allmenu[$i] = $tdmenulinks;



            $allmenu[$i]['submenu'] = self::getAllRootMegaMenu($id_lang, $tdmenulinks['id_tdmegamenu']);



            $i++;

        }

         return $allmenu;
        
    }
    
        public static function getMenuType() {
        global $cookie;
        return Db::getInstance()->ExecuteS('
            SELECT `id_tdmegamenu`, `link`, `menu_type`
            FROM `' . _DB_PREFIX_ . 'tdmegamenu`
            ORDER BY `order`');
    }
     
  
}