<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hitanshu
 * Date: 10/9/13
 * Time: 4:51 PM
 * To change this template use File | Settings | File Templates.
 */
include_once(dirname(__FILE__) . '/../../config/config.inc.php');
include_once(dirname(__FILE__) . '/../../init.php');
include_once(_PS_MODULE_DIR_ . 'productcomments/productcomments.php');
$productComment = new ProductComments();
$product_id = Tools::getValue('productId');
$rating = Tools::getValue('rating');
if (Tools::getValue('action') == 'get') {
    echo $productComment->getGradeForTheGivenProduct($product_id);
}

if (Tools::getValue('action') == 'post') {
    if (empty($product_id) || empty($rating))
        echo false;
    echo $productComment->addorUpdateGradeForTheGivenProduct($product_id, $rating);
}

