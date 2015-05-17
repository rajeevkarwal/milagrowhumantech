<?php

/**
 * @author PresTeamShop.com
 * @copyright PresTeamShop.com - 2013
 */
class PETTabClass extends ObjectModel {

    public $id;
    public $name;
    public $position;
    public $type;
    public $active = true;
    protected $table = 'pet_tab';
    protected $identifier = 'id_tab';
    protected $tables = array('pet_tab', 'pet_tab_lang');
    protected $fieldsRequired = array();
    protected $fieldsValidate = array('active' => 'isBool');
    protected $fieldsRequiredLang = array('name');
    protected $fieldsSizeLang = array('name' => 50);
    protected $fieldsValidateLang = array('name' => 'isGenericName');

    /**
     * @see ObjectModel::$definition
     */
    public static $definition;

    public function __construct($id = null, $id_lang = null, $id_shop = null) {
        if (version_compare(_PS_VERSION_, '1.5') >= 0) {
            self::$definition = array(
                'table' => 'pet_tab',
                'primary' => 'id_tab',
                'multilang' => true,
                'multilang_shop' => false,
                'fields' => array(
                    'position' => array('type' => self::TYPE_INT, 'validate' => 'isInt'),
                    'type' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
                    'active' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
                    // Lang fields
                    'name' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'required' => true, 'size' => 50)
                )
            );
            
            parent::__construct($id, $id_lang, $id_shop);
        } else {
            parent::__construct($id, $id_lang);
        }
    }
    
    public function delete() {
        $query = 'SELECT id_tab_content FROM ' . _DB_PREFIX_ . 'pet_tab_content WHERE id_tab = ' . $this->id;
        
        $rows = Db::getInstance()->executeS($query);
        foreach ($rows AS $row) {
            Db::getInstance()->execute('DELETE FROM ' . _DB_PREFIX_ . 'pet_tab_content WHERE id_tab_content = ' . $row['id_tab_content']);
            Db::getInstance()->execute('DELETE FROM ' . _DB_PREFIX_ . 'pet_tab_content_lang WHERE id_tab_content = ' . $row['id_tab_content']);
        }
        
        return parent::delete();
    }

    public function getFields() {
        parent::validateFields();
        if (isset($this->id))
            $fields['id_tab'] = (int) ($this->id);
        $fields['position'] = (int) ($this->position);
        $fields['type'] = pSQL($this->type);
        $fields['active'] = (int) ($this->active);
        return $fields;
    }

    /**
     * Check then return multilingual fields for database interaction
     *
     * @return array Multilingual fields
     */
    public function getTranslationsFieldsChild() {
        parent::validateFieldsLang();
        return parent::getTranslationsFields(array('name'));
    }

    public static function getTabs($id_lang = null) {
        if (empty($id_lang))
            $id_lang = Configuration::get('PS_LANG_DEFAULT');

        return Db::getInstance()->ExecuteS('SELECT t.* ,tl.name FROM 
                                                ' . _DB_PREFIX_ . 'pet_tab AS t,
                                                ' . _DB_PREFIX_ . 'pet_tab_lang AS tl
                                            WHERE 
                                                t.`id_tab` = tl.`id_tab` AND
                                                tl.`id_lang` = ' . $id_lang .
                        ' ORDER BY t.position ASC');
    }

    public static function getAvailablePetTabs() {
        $id_lang = Configuration::get('PS_LANG_DEFAULT');

        $sql = 'SELECT ptl.id_tab, ptl.`name`, ptc.id_product
            FROM ' . _DB_PREFIX_ . 'pet_tab_lang ptl 
            LEFT JOIN ' . _DB_PREFIX_ . 'pet_tab_content ptc ON ptc.id_tab = ptl.id_tab
            WHERE (ptc.id_product != -1 OR ptc.id_product IS NULL) AND ptl.id_lang = ' . $id_lang . '
            GROUP BY ptl.id_tab';

        return Db::getInstance()->ExecuteS($sql);
    }

    public static function getContentTabsByIdTab($id_tab, $id_product) {
        $sql = 'SELECT * FROM ' . _DB_PREFIX_ . 'pet_tab_content ptc 
            INNER JOIN ' . _DB_PREFIX_ . 'pet_tab_content_lang ptcl ON ptc.id_tab_content = ptcl.id_tab_content
            WHERE ptc.id_tab = ' . $id_tab . ' AND ptc.id_product = ' . $id_product;

        return Db::getInstance()->ExecuteS($sql);
    }

}

?>