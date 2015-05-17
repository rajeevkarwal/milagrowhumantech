<?php

if (!defined('_PS_VERSION_'))
  exit;
 
function upgrade_module_1_1_2($object)
{
    $query = "UPDATE `" . _DB_PREFIX_ . "configuration` SET `name` = 'PET_RM' WHERE `name` = 'PET_REGISTERED_MODULE';";    
    if (!Db::getInstance()->execute($query))
        return false;
    return true;
}
?>