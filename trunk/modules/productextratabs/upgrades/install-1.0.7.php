<?php

if (!defined('_PS_VERSION_'))
  exit;
 
function upgrade_module_1_0_7($object)
{
    $query = "ALTER TABLE `" . _DB_PREFIX_ . "pet_tab` ADD `position` INT( 10 ) NULL;";    
    if (!Db::getInstance()->execute($query))
        return false;
        
    return true;
}
?>