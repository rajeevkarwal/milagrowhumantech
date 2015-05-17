<?php
class tdProductsSliderModel extends ObjectModel
{

	public static function createTables()
	{
		return (
			tdProductsSliderModel::createTDProductSliderProductsTable()
		);
	}

	public static function dropTables()
	{
            	return Db::getInstance()->execute('DROP TABLE `'._DB_PREFIX_.'td_selectedproduct`');
	}
	public static function createTDProductSliderProductsTable()
	{
		return (Db::getInstance()->Execute('
		CREATE TABLE `' . _DB_PREFIX_ . 'td_selectedproduct` (
		`id_product` int(10) unsigned NOT NULL auto_increment,
		PRIMARY KEY (`id_product`))
		ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8'));
	}

}