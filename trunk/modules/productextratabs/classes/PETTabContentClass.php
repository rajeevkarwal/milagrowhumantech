<?php

/**
 * @author PresTeamShop.com
 * @copyright PresTeamShop.com - 2013
 */
 
class PETTabContentClass extends ObjectModel
{
	public		$id;
    public      $id_tab;
    public      $id_product;
    public      $id_category;
    public		$content;

	protected 	$table = 'pet_tab_content';    
	protected 	$identifier = 'id_tab_content';
    
    protected 	$tables = array ('pet_tab_content', 'pet_tab_content_lang');
	
    protected   $fieldsRequired = array('id_tab', 'id_product');
    
    protected   $fieldsRequiredLang = array('content');	
	protected   $fieldsSizeLang = array();
	protected   $fieldsValidateLang = array('description' => 'isString');
       
    /**
	 * @see ObjectModel::$definition
	 */
	public static $definition;
	
	public	function __construct($id = null, $id_lang = null, $id_shop = null)
	{
		if(version_compare(_PS_VERSION_, '1.5') >= 0){
            self::$definition = array(
        		'table' => 'pet_tab_content',
        		'primary' => 'id_tab_content',
        		'multilang' => true,
        		'multilang_shop' => false,
        		'fields' => array(
        			'id_tab' => 			array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true),
        			'id_product' => 		array('type' => self::TYPE_INT, 'required' => true),
        			'id_category' => 		array('type' => self::TYPE_INT, 'required' => true),
        			
        			// Lang fields
        			'content' => 			array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isString')
        		)
        	);
            
            parent::__construct($id, $id_lang, $id_shop);
        }else{
            parent::__construct($id, $id_lang);
        }
	}
	
    public function getFields()
	{
		parent::validateFields();
		if (isset($this->id))
			$fields['id_tab_content'] = (int)($this->id);
		$fields['id_tab'] = (int)($this->id_tab);
        $fields['id_product'] = (int)($this->id_product);
        $fields['id_category'] = (int)($this->id_category);
		return $fields;
	}
    
    /**
	  * Check then return multilingual fields for database interaction
	  *
	  * @return array Multilingual fields
	  */
    public function getTranslationsFieldsChild()
	{
		//self::validateFieldsLang();

		$fieldsArray = array();
		$fields = array();
		$languages = Language::getLanguages(false);
		$defaultLanguage = Configuration::get('PS_LANG_DEFAULT');
		foreach ($languages as $language)
		{
			$fields[$language['id_lang']]['id_lang'] = $language['id_lang'];
			$fields[$language['id_lang']][$this->identifier] = (int)($this->id);
			$fields[$language['id_lang']]['content'] = (isset($this->content[$language['id_lang']])) ? pSQL($this->content[$language['id_lang']], true) : '';			
			foreach ($fieldsArray as $field)
			{
				if (!Validate::isTableOrIdentifier($field))
					die(Tools::displayError());

				/* Check fields validity */
				if (isset($this->{$field}[$language['id_lang']]) AND !empty($this->{$field}[$language['id_lang']]))
					$fields[$language['id_lang']][$field] = pSQL($this->{$field}[$language['id_lang']]);
				elseif (in_array($field, $this->fieldsRequiredLang))
				{
					if ($this->{$field} != '')
						$fields[$language['id_lang']][$field] = pSQL($this->{$field}[$defaultLanguage]);
				}
				else
					$fields[$language['id_lang']][$field] = '';
			}
		}
		return $fields;
	}
       
    public static function getTabsContent($id_lang = null, $where = ''){
        if (empty($id_lang))
            $id_lang = Configuration::get('PS_LANG_DEFAULT');
            
        $query = 'SELECT tc.*, tl.name AS name_tab, pl.name AS name_product, cl.name AS name_category' .
            ' FROM '._DB_PREFIX_.'pet_tab_content AS tc' .
            ' INNER JOIN '._DB_PREFIX_.'pet_tab AS t ON t.id_tab = tc.id_tab' .
            ' LEFT JOIN '._DB_PREFIX_.'pet_tab_lang AS tl ON tl.id_tab = tc.id_tab AND tl.id_lang = '.$id_lang .
            ' LEFT JOIN '._DB_PREFIX_.'product_lang AS pl ON pl.id_product = tc.id_product AND pl.id_lang = '.$id_lang .
            ' LEFT JOIN '._DB_PREFIX_.'category_lang AS cl ON cl.id_category = tc.id_category AND cl.id_lang = '.$id_lang .
            ' ' . $where . ' GROUP BY tc.id_tab_content, tc.id_product ORDER BY t.position ASC';
        
        return Db::getInstance()->ExecuteS($query);
    }     
    
    public static function existTabProduct($id_tab, $id_product, $id_category){
        return Db::getInstance()->ExecuteS('SELECT * FROM '._DB_PREFIX_.'pet_tab_content AS tc
                                                WHERE 
                                                    tc.`id_tab` = '.$id_tab.' AND
                                                    tc.`id_product` = '.$id_product . ' AND
                                                    tc.`id_category` = '. $id_category);
    }
    
    public static function tab_content_exist($id_tab, $id_product, $id_category, $comparator = "=") {
        $sql = "SELECT id_tab_content 
            FROM " . _DB_PREFIX_ . "pet_tab_content
            WHERE id_tab = {$id_tab} AND id_product {$comparator} '{$id_product}' AND id_category {$comparator} '{$id_category}'";

        return Db::getInstance()->getValue($sql);
    }
    
    /*public static function saveContent($id_tab, $id_product, $content) {        
        $upd = Tools::getValue('upd');
        
        $id_tab_content = self::tab_content_exist($id_tab, $id_product);
        
        if ($upd == "false") {            
            if ($id_tab_content){
                $PETTabContentClass = new PETTabContentClass((int)$id_tab_content);
                $PETTabContentClass->delete();
            }
        }
        else {            
            $content_lang = array();

            foreach ($content as $_content) {
                $content_lang[$_content->id_lang] = base64_decode($_content->content);
            }
            
            if ($id_tab_content === FALSE) {
                $product = new Product($id_product);
                
                $PETTabContent = new PETTabContentClass();

                $PETTabContent->id_tab = $id_tab;
                $PETTabContent->id_product = $id_product;
                $PETTabContent->id_category = $product->id_category_default;

                $PETTabContent->content = $content_lang;

                return $PETTabContent->add();                
            } else {
                $PETTabContent = new PETTabContentClass($id_tab_content);

                $PETTabContent->content = $content_lang;

                return $PETTabContent->update();                
            }            
        }
    }*/
    
    public static function getTabsByProduct($id_product, $id_lang){
        if (empty($id_lang))
            $id_lang = Configuration::get('PS_LANG_DEFAULT');
            
        $product = new Product((int)$id_product);
        
        if (Validate::isLoadedObject($product)){
            $ids_categories = array();
            $_categories = Db::getInstance()->executeS('SELECT id_category FROM ' . _DB_PREFIX_ . 'category_product WHERE id_product = ' . $id_product);
            
            foreach($_categories AS $category){
                array_push($ids_categories, $category['id_category']);
            }

            return Db::getInstance()->ExecuteS('
                SELECT
                    t.type,
                    tl.name AS name_tab, 
                    tc.*, 
                    tcl.content 
                FROM 
                    '._DB_PREFIX_.'pet_tab AS t,
                    '._DB_PREFIX_.'pet_tab_lang AS tl,
                    '._DB_PREFIX_.'pet_tab_content AS tc,
                    '._DB_PREFIX_.'pet_tab_content_lang AS tcl
                WHERE
                    t.`id_tab` = tl.`id_tab` AND
                    t.`id_tab` = tc.`id_tab` AND 
                    tc.`id_tab_content` = tcl.`id_tab_content` AND
                    tl.`id_lang` = '.$id_lang.' AND
                    tcl.`id_lang` = '.$id_lang.' AND
                    tc.`id_product` IN ('.$id_product.', -1) AND
                    tc.`id_category` IN ('. implode(',', $ids_categories) .', -1) AND
                    t.`active` = 1 ORDER BY t.position ASC');
        }
        else
            return array();
    }
}
?>