<?php

if (!defined('_PS_VERSION_'))
  exit;
 
function upgrade_module_1_1_3($object)
{
    $query = "ALTER TABLE `" . _DB_PREFIX_ . "pet_tab` ADD `type` VARCHAR(255) DEFAULT 'content' AFTER `position`;";
    if (!Db::getInstance()->execute($query))
        return false;
        
    $query = "UPDATE `" . _DB_PREFIX_ . "pet_tab` SET `type` = 'content';";
    if (!Db::getInstance()->execute($query))
        return false;
        
    return true;
}
?>