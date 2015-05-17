<?php

/**
 * @author PresTeamShop.com
 * @copyright PresTeamShop.com - 2013
 */

require_once(dirname(__FILE__).'/../../config/config.inc.php');
require_once(dirname(__FILE__).'/../../init.php');
require_once(dirname(__FILE__)."/productextratabs.php");

global $cookie;

if (isset($_POST['action'])){
    $action = $_POST['action'];
    
    $productextratabs = new ProductExtraTabs();
    
    switch ($action){
        case "getType":
            if (isset($_POST['id_tab'])) {
                echo $productextratabs->getType($_POST['id_tab']);
            }
            break;
        case "updateTab":          
            if (isset($_POST['id_tab']) && isset($_POST['name']) && isset($_POST['active'])){                                
                echo $productextratabs->updateTab($_POST['id_tab'], $_POST['name'], $_POST['active'], $_POST['type']);
            }      
        break;
        case "editTab":
            if (isset($_POST['id_tab']) && !empty($_POST['id_tab'])){
                $PETTabClass = new PETTabClass((int)($_POST['id_tab']));
                                
                echo $productextratabs->jsonEncode($PETTabClass);
            }
        break;
        case "deleteTab":
            if (isset($_POST['id_tab']) && !empty($_POST['id_tab'])){    
                echo $productextratabs->deleteTab((int)($_POST['id_tab']));
            }
        break;
        case "getListTab":
            echo $productextratabs->jsonEncode(PETTabClass::getTabs((int)$cookie->id_lang));            
        break;
        case "getProductByCategory":
            echo $productextratabs->jsonEncode($productextratabs->getProductsByCategory($_POST['id_category']));            
        break;
        case "updateTabContent":          
            if (isset($_POST['id_tab_content']) && isset($_POST['id_tab']) && isset($_POST['id_product']) && isset($_POST['id_category']) && isset($_POST['content'])){                                
                echo $productextratabs->updateTabContent($_POST['id_tab_content'], $_POST['id_tab'], $_POST['id_product'], $_POST['id_category'], Tools::getValue('content'));
            }      
        break;
        case "editTabContent":
            if (isset($_POST['id_tab_content']) && !empty($_POST['id_tab_content'])){
                $PETTabContentClass = new PETTabContentClass((int)($_POST['id_tab_content']));
                                
                echo $productextratabs->jsonEncode($PETTabContentClass);
            }
        break;
        case "deleteTabContent":
            if (isset($_POST['id_tab_content']) && !empty($_POST['id_tab_content'])){    
                echo $productextratabs->deleteTabContent((int)($_POST['id_tab_content']));
            }
        break;
        case "getListTabsContent":
            echo $productextratabs->jsonEncode(PETTabContentClass::getTabsContent((int)$cookie->id_lang));            
            break; 
        case "getExtraTabsFilter":
            echo $productextratabs->jsonEncode($productextratabs->getExtraTabsFilter($_POST['id_tab'], $_POST['id_category'], $_POST['id_product']));
            break;
        case "updateOptionsPosition":
            $order_tabs = $_POST['$order_tabs'];
            echo $productextratabs->jsonEncode($productextratabs->updateTabsPosition($order_tabs));
            break;
        case "saveTabContentByTabLang":
            echo $productextratabs->jsonEncode($productextratabs->saveTabContentByTabLang());
            break;
    
    }
}
else {
    Tools::redirect('index.php');
}
?>