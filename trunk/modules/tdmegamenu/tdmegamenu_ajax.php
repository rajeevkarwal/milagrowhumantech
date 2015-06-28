<?php

include_once('../../config/config.inc.php');
include_once('../../init.php');
//$postmenudata = $_POST['sorted_menulink'];
//$menulinkele = 0;
//foreach ($postmenudata as $k => $childrens) :
//    $parentmenulinks = str_replace("ele_", "", $childrens['id']);
//    if (isset($postmenudata[$k]['children'])) :
//        childmenuSave($postmenudata[$k]['children'], $parentmenulinks, $menulinkele);
//    else :
//        Db::getInstance()->Execute('UPDATE `' . _DB_PREFIX_ . 'tdmegamenu` SET `parent` = 0 , `order` = ' . $menulinkele . ' WHERE `id_tdmegamenu` = ' . $parentmenulinks);
//    endif;
//    $menulinkele++;
//endforeach;
//
//function childmenuSave($postmenudata, $parentmenulinks, $menulinkele) {
//    foreach ($postmenudata as $postresult) :
//        $id_td_menu = (int) str_replace("ele_", "", $postresult['id']);
//        if (isset($postresult['children'])):
//            childmenuSave($postresult['children'], $id_td_menu, $menulinkele);
//        else :
//            Db::getInstance()->Execute($updatesql = 'UPDATE `' . _DB_PREFIX_ . 'tdmegamenu` SET `parent` = ' . $parentmenulinks . ', `order` = ' . $menulinkele . ' WHERE `id_tdmegamenu` = ' . $id_td_menu);
//            $menulinkele++;
//        endif;
//    endforeach;
//    return true;
//}

$postmenudata = $_POST['sorted_menulink'];
//print_r($postmenudata);
$menulinkele = 0;
foreach ($postmenudata as $k => $childrens) :
    $parentmenulinks = str_replace("ele_", "", $childrens['id']);
    Db::getInstance()->Execute('UPDATE `' . _DB_PREFIX_ . 'tdmegamenu` SET `parent` = 0 , `order` = ' . $menulinkele . ' WHERE `id_tdmegamenu` = ' . $parentmenulinks);
    if (isset($postmenudata[$k]['children'])) :
        childmenuSave($postmenudata[$k]['children'], $parentmenulinks, $menulinkele);
    endif;
    $menulinkele++;
endforeach;

function childmenuSave($postmenudata, $parentmenulinks, $menulinkele) {
    foreach ($postmenudata as $postresult) :
        $id_td_menu = (int) str_replace("ele_", "", $postresult['id']);
        if (isset($postresult['children'])):
            childmenuSave($postresult['children'], $id_td_menu, $menulinkele);
        else :
            Db::getInstance()->Execute($updatesql = 'UPDATE `' . _DB_PREFIX_ . 'tdmegamenu` SET `parent` = ' . $parentmenulinks . ', `order` = ' . $menulinkele . ' WHERE `id_tdmegamenu` = ' . $id_td_menu);
            $menulinkele++;
        endif;
    endforeach;
    return true;
}

