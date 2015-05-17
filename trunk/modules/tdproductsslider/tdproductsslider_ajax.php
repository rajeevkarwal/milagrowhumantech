<?php
include_once('../../config/config.inc.php');
include_once('../../init.php');
include_once(dirname(__FILE__) . '/tdproductsslider.php');
$tdoptionpanel = new TDProductsSlider();


$click_button = $_POST['type'];


if ($click_button == 'tdoptiondata') {
    $postdata = $_POST['data'];
    
    parse_str($postdata, $data);
    foreach ($data as $id => $output) {
        Db::getInstance()->Execute('delete from `' . _DB_PREFIX_ . 'td_selectedproduct');
        if (is_array($output)) {
            foreach ($output as $key => $output_value) { 

                Db::getInstance()->Execute('
                INSERT INTO `' . _DB_PREFIX_ . 'td_selectedproduct` (`id_product`) 
                VALUES(' . (int) $output_value . ')');
    
            }
        } else {
                Configuration::updateValue($id, htmlspecialchars($output));
        }
    }
}
die();
?>
        



