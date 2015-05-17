<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hitanshu
 * Date: 16/7/13
 * Time: 1:07 PM
 * To change this template use File | Settings | File Templates.
 */
include_once(dirname(__FILE__) . '/../../../config/config.inc.php');
include_once(dirname(__FILE__) . '/../../../init.php');

$order_id = Tools::getValue('order_id');
if (!isset($order_id))
    return false;
try {
    $sql = 'SELECT tracking_number from ' . _DB_PREFIX_ . 'order_carrier WHERE id_order=' . $order_id;
    if ($row = Db::getInstance()->getRow($sql)) {
        $tracking_number = $row['tracking_number'];
        $data = explode('-', $tracking_number);
        $carrier = '';
        if (!empty($data))
            $carrier = $data[0];
        $exactTrackingNumber = ltrim(strstr($tracking_number, '-'), '-');
        //find carrier url from name
        $query = 'Select url from ' . _DB_PREFIX_ . 'carrier where name=\'' . $carrier . '\'';
        $url = '';
        if ($row2 = Db::getInstance()->getRow($query)) {
            $url = $row2['url'];
        }
        if (empty($url))
            $url = '#';
        $url = str_replace('@', $exactTrackingNumber, $url);
        if ($carrier == 'FDX' || $carrier == 'fdx') {
            $url = Tools::getShopDomainSsl(true, true) . '?fc=module&module=frontorder&controller=tracking&trackingCode=' . $exactTrackingNumber;
            echo json_encode(array('url' => $url, 'carrier' => $carrier, 'trackingNumber' => $exactTrackingNumber));
        } else {
            echo json_encode(array('url' => $url, 'carrier' => $carrier, 'trackingNumber' => $exactTrackingNumber));
        }
    } else {
        echo json_encode(array('url' => '#', 'carrier' => '', 'trackingNumber' => $exactTrackingNumber));
    }
} catch (Exception $e) {
    throw new PrestaShopExceptionCore($e);
}

