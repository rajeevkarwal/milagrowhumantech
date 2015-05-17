<?php

if (!defined('_PS_VERSION_'))
  exit;
 
function upgrade_module_1_0_4($object)
{
    $query = "ALTER TABLE `" . _DB_PREFIX_ . "pet_tab_content` ADD `id_category` INT(10) NULL;";    
    if (!Db::getInstance()->execute($query))
        return false;
        
    $query = "UPDATE `" . _DB_PREFIX_ . "pet_tab_content` AS ptc SET ptc.`id_category` = (SELECT id_category_default FROM `PREFIX_product` WHERE `id_product` = ptc.`id_product`);";    
    if (!Db::getInstance()->execute($query))
        return false;
        
    Configuration::updateValue('PET_REGISTERED_MODULE', '0');
    Configuration::updateValue('PET_VERSION', '1.0.4');
    
    return true;
}
?>