<?php
if (!defined('_PS_VERSION_'))
    exit;
require_once(dirname(__FILE__) . '/DemoPdf.php');
require_once(dirname(__FILE__) . '/mydatetime.php');

class DemoRegistration extends Module
{
    const MODULE_NAME = "demoregistration";

    public function __construct()
    {

        $this->name = 'demoregistration';
        $this->tab = 'front_office_features';
        $this->version = '1.0';
        $this->author = 'GAPS';
        $this->need_instance = 0;
//        $this->ps_versions_compliancy = array('min' => '1.5', 'max' => '1.5');

        parent::__construct();

        $this->displayName = $this->l('demoregistration');
        $this->description = $this->l('This module will register product demos robotics category');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        /*if (!Configuration::get('MYMODULE_NAME'))
            $this->warning = $this->l('No name provided');*/
    }

    public function install()
    {
        if (!parent::install())
            return false;
        include_once(_PS_MODULE_DIR_ . '/' . $this->name . '/demoregistration_install.php');
        $demoRegistrationInstall = new DemoRegistrationInstall();
        $demoRegistrationInstall->createTables();
        return true;
    }

    public function uninstall()
    {
        if (!parent::uninstall() ||
            !Configuration::deleteByName('MYMODULE_NAME')
        )
            return false;
        return true;
    }

    public static function getShopDomainSsl($http = false, $entities = false)
    {
        if (method_exists('Tools', 'getShopDomainSsl'))
            return Tools::getShopDomainSsl($http, $entities);
        else {
            if (!($domain = Configuration::get('PS_SHOP_DOMAIN_SSL')))
                $domain = self::getHttpHost();
            if ($entities)
                $domain = htmlspecialchars($domain, ENT_COMPAT, 'UTF-8');
            if ($http)
                $domain = (Configuration::get('PS_SSL_ENABLED') ? 'https://' : 'http://') . $domain;
            return $domain;
        }
    }

    protected function getCurrentUrl()
    {
        $protocol_link = Tools::usingSecureMode() ? 'https://' : 'http://';
        $request = $_SERVER['REQUEST_URI'];
        $pos = strpos($request, '?');

        if (($pos !== false) && ($pos >= 0))
            $request = substr($request, 0, $pos);

        $params = urlencode($_SERVER['QUERY_STRING']);

        return $protocol_link . Tools::getShopDomainSsl() . $request . '?' . $params;
    }

    public function fetchTemplate($name)
    {
        if (_PS_VERSION_ < '1.4')
            $this->context->smarty->currentTemplate = $name;
        elseif (_PS_VERSION_ < '1.5') {
            $views = 'views/templates/';
            if (@filemtime(dirname(__FILE__) . '/' . $name))
                return $this->display(__FILE__, $name);
            elseif (@filemtime(dirname(__FILE__) . '/' . $views . 'hook/' . $name))
                return $this->display(__FILE__, $views . 'hook/' . $name);
            elseif (@filemtime(dirname(__FILE__) . '/' . $views . 'front/' . $name))
                return $this->display(__FILE__, $views . 'front/' . $name);
            elseif (@filemtime(dirname(__FILE__) . '/' . $views . 'back/' . $name))
                return $this->display(__FILE__, $views . 'back/' . $name);
        }

        return $this->display(__FILE__, $name);
    }

    public static function getByDateInterval($date_from, $date_to)
    {
        $demo_receipt_list = Db::getInstance()->executeS('
			SELECT dmr.*
			FROM `' . _DB_PREFIX_ . 'demos` dmr
			WHERE DATE_ADD(dmr.created_at, INTERVAL -1 DAY) <= \'' . pSQL($date_to) . '\'
			AND oi.created_at >= \'' . pSQL($date_from) . '\' AND status=\'paid\'
			ORDER BY oi.created_at ASC
		');

        return ObjectModel::hydrateCollection('DemoInvoice', $demo_receipt_list);
    }

    public function getContent()
    {
        $this->html = '<h2>' . $this->displayName . '</h2>';
        $this->html .= '<link media="all" type="text/css" rel="stylesheet" href="' . $this->_path . 'views/css/back.css"/>';
        if (Tools::getValue('generateReceipts') != NULL) {
            $this->bulkDownloadReceipts(Tools::getValue('fromDate'), Tools::getValue('toDate'));
        }

        if (Tools::getValue('generateQueries') != NULL) {
            $this->bulkDownloadQueries(Tools::getValue('fromDate'), Tools::getValue('toDate'));
        }
        $url = $_SERVER['REQUEST_URI'];
        if (strpos($url, '&sl_tab') > 0)
            $url = substr($url, 0, strpos($url, '&sl_tab'));

        $this->html .= '<ul><li ' . (Tools::getValue('sl_tab') == "demoslist" || Tools::getValue('sl_tab') == NULL || Tools::getValue('sl_tab') == '' ? 'class="sl_admin_tab_active"' : 'class="sl_admin_tab"') . '><a style="padding:8px 8px 4px 4px;" href="' . $url . '&sl_tab=" id = "sl_demoslist">' . $this->l('Query List') . '</a></li>
		<li ' . (Tools::getValue('sl_tab') == "bulk_download_queries" ? 'class="sl_admin_tab_active"' : 'class="sl_admin_tab"') . '><a style="padding:8px 8px 4px 4px;" href="' .
            $url . '&sl_tab=bulk_download_queries" id = "sl_bulk_download_queries">' . $this->l('Download Queries') . '</a></li>
		<li ' . (Tools::getValue('sl_tab') == "bulk_download_receipts" ? 'class="sl_admin_tab_active"' : 'class="sl_admin_tab"') . '><a style="padding:8px 8px 4px 4px;" href="' . $url . '&sl_tab=bulk_download_receipts" id = "sl_bulk_download_receipts">' . $this->l('Download Receipts PDF') . '</a></li></ul>';
        if (Tools::getValue('sl_tab') == 'bulk_download_receipts')
            $this->html .= $this->displayBulkDownloadReceipts($url);
        else if (Tools::getValue('sl_tab') == 'bulk_download_queries')
            $this->html .= $this->displayBulkDownloadQueries($url);
        else if (Tools::getValue('sl_tab') == 'edit_service_center') {
            $id_service_center = Tools::getValue('id_service_center');
            $this->html .= $this->displayEditServiceCenter($id_service_center, $url);
        } else if (Tools::getValue('sl_tab') == 'download_demo_receipt') {
            $demos_id = Tools::getValue('demos_id');
            $this->downloadDemoReceipt($demos_id);
        } else
            $this->html .= $this->displayDemosList($url);
        return $this->html;
    }

    private function errorBlock($errors)
    {
        $this->context->smarty->assign(array(
            'errors' => $errors
        ));
        return $this->fetchTemplate('/views/templates/back/errors.tpl');
    }

    private function displayDemosList($url)
    {
        $page = Tools::getValue('page');
        $page = !empty($page) ? $page : 1;
        $fromDate = Tools::getValue('fromDate');
        $toDate = Tools::getValue('toDate');
        $fromDate = !empty($fromDate) ? new MyDateTime($fromDate) : null;
        $toDate = !empty($toDate) ? new MyDateTime($toDate) : null;
        $previousPage = 0;
        $nextPage = 0;
        $pageCount = 10;
        $demosList = $this->getDemosList($fromDate, $toDate, $page, $pageCount);
        $totalDemos = $this->countDemos($fromDate, $toDate);
        if (($page * $pageCount) < (int)$totalDemos) {
            $nextPage = $page + 1;
        }
        if ($page > 1)
            $previousPage = $page - 1;

        $selectedFromDate = !empty($fromDate) ? $fromDate->format('Y-m-d') : '';
        $selectedToDate = !empty($toDate) ? $toDate->format('Y-m-d') : '';
        $this->context->smarty->assign(array(
            'fromDate' => $selectedFromDate,
            'toDate' => $selectedToDate,
            'demosList' => $demosList,
            'page' => $page,
            'previous' => $previousPage,
            'next' => $nextPage,
            'url' => $url
        ));

        return $this->fetchTemplate('/views/templates/back/demos-list.tpl');
    }

    private function displayBulkDownloadReceipts($url)
    {
        $this->context->smarty->assign(array(
            'url' => $url
        ));

        return $this->fetchTemplate('/views/templates/back/bulk-download-receipt.tpl');
    }

    private function getDemosList($fromDate, $toDate, $p = 1, $n = null)
    {
        $whereQuery = '';
        if (!empty($fromDate) && empty($toDate)) {
            $fromDate = date('Y', $fromDate->getTimestamp()) . "-" . date('m', $fromDate->getTimestamp()) . "-" . date('d', $fromDate->getTimestamp()) . " 00:00:00";
            $fromDate = new MyDateTime($fromDate);
            $fromDate = $fromDate->format('Y-m-d H:i:s');
            $whereQuery .= "where dmr.created_at>='$fromDate'";
        } elseif (empty($fromDate) && !empty($toDate)) {
            $toDate = date('Y', $toDate->getTimestamp()) . "-" . date('m', $toDate->getTimestamp()) . "-" . date('d', $toDate->getTimestamp()) . " 00:00:00";
            $toDate = new MyDateTime($toDate);
            $toDate->add();
            $toDate = $toDate->format('Y-m-d H:i:s');
            $whereQuery .= "where dmr.created_at<'$toDate'";
        } elseif (!empty($fromDate) && !empty($toDate)) {
            $fromDate = date('Y', $fromDate->getTimestamp()) . "-" . date('m', $fromDate->getTimestamp()) . "-" . date('d', $fromDate->getTimestamp()) . " 00:00:00";
            $fromDate = new MyDateTime($fromDate);
            $fromDate = $fromDate->format('Y-m-d H:i:s');
            $toDate = date('Y', $toDate->getTimestamp()) . "-" . date('m', $toDate->getTimestamp()) . "-" . date('d', $toDate->getTimestamp()) . " 00:00:00";
            $toDate = new MyDateTime($toDate);
            $toDate->add();
            $toDate = $toDate->format('Y-m-d H:i:s');
            $whereQuery .= "where dmr.created_at>='$fromDate' and dmr.created_at<'$toDate'";
        }

        $sql = 'select * from ' . _DB_PREFIX_ . 'demos as dmr ' . $whereQuery .' order by created_at desc'. ($n ? ' LIMIT ' . (int)(($p - 1) * $n) . ', ' . (int)($n) : '');
        if ($results = Db::getInstance()->ExecuteS($sql)) {
            return $results;
        }

        return array();
    }

    private function getAllDemos($fromDate, $toDate,$status)
    {
        $fromDate = !empty($fromDate) ? new MyDateTime($fromDate) : null;
        $toDate = !empty($toDate) ? new MyDateTime($toDate) : null;
        $whereQuery = '';
        if (!empty($fromDate) && empty($toDate)) {
            $fromDate = date('Y', $fromDate->getTimestamp()) . "-" . date('m', $fromDate->getTimestamp()) . "-" . date('d', $fromDate->getTimestamp()) . " 00:00:00";
            $fromDate = new MyDateTime($fromDate);
            $fromDate = $fromDate->format('Y-m-d H:i:s');
            $whereQuery .= "where dmr.created_at>='$fromDate'";
        } elseif (empty($fromDate) && !empty($toDate)) {
            $toDate = date('Y', $toDate->getTimestamp()) . "-" . date('m', $toDate->getTimestamp()) . "-" . date('d', $toDate->getTimestamp()) . " 00:00:00";
            $toDate = new MyDateTime($toDate);
            $toDate->add();
            $toDate = $toDate->format('Y-m-d H:i:s');
            $whereQuery .= "where dmr.created_at<'$toDate'";
        } elseif (!empty($fromDate) && !empty($toDate)) {
            $fromDate = date('Y', $fromDate->getTimestamp()) . "-" . date('m', $fromDate->getTimestamp()) . "-" . date('d', $fromDate->getTimestamp()) . " 00:00:00";
            $fromDate = new MyDateTime($fromDate);
            $fromDate = $fromDate->format('Y-m-d H:i:s');
            $toDate = date('Y', $toDate->getTimestamp()) . "-" . date('m', $toDate->getTimestamp()) . "-" . date('d', $toDate->getTimestamp()) . " 00:00:00";
            $toDate = new MyDateTime($toDate);
            $toDate->add();
            $toDate = $toDate->format('Y-m-d H:i:s');
            $whereQuery .= "where dmr.created_at>='$fromDate' and dmr.created_at<'$toDate'";
        }

        if(!empty($status))
            $whereQuery.='and dmr.status=\''.$status.'\'';

        $sql = 'select * from ' . _DB_PREFIX_ . 'demos as dmr ' . $whereQuery;
        if ($results = Db::getInstance()->ExecuteS($sql)) {
            return $results;
        }

        return array();
    }


    private function countDemos($fromDate, $toDate)
    {
        $whereQuery = '';
        if (!empty($fromDate) && empty($toDate)) {
            $fromDate = date('Y', $fromDate->getTimestamp()) . "-" . date('m', $fromDate->getTimestamp()) . "-" . date('d', $fromDate->getTimestamp()) . " 00:00:00";
            $fromDate = new MyDateTime($fromDate);
            $fromDate = $fromDate->format('Y-m-d H:i:s');
            $whereQuery .= "where dmr.created_at>='$fromDate'";
        } elseif (empty($fromDate) && !empty($toDate)) {
            $toDate = date('Y', $toDate->getTimestamp()) . "-" . date('m', $toDate->getTimestamp()) . "-" . date('d', $toDate->getTimestamp()) . " 00:00:00";
            $toDate = new MyDateTime($toDate);
            $toDate->add();
            $toDate = $toDate->format('Y-m-d H:i:s');
            $whereQuery .= "where dmr.created_at<'$toDate'";
        } elseif (!empty($fromDate) && !empty($toDate)) {
            $fromDate = date('Y', $fromDate->getTimestamp()) . "-" . date('m', $fromDate->getTimestamp()) . "-" . date('d', $fromDate->getTimestamp()) . " 00:00:00";
            $fromDate = new MyDateTime($fromDate);
            $fromDate = $fromDate->format('Y-m-d H:i:s');
            $toDate = date('Y', $toDate->getTimestamp()) . "-" . date('m', $toDate->getTimestamp()) . "-" . date('d', $toDate->getTimestamp()) . " 00:00:00";
            $toDate = new MyDateTime($toDate);
            $toDate->add();
            $toDate = $toDate->format('Y-m-d H:i:s');
            $whereQuery .= "where dmr.created_at>='$fromDate' and dmr.created_at<'$toDate'";
        }

        $sql = 'select count(*) from ' . _DB_PREFIX_ . 'demos as dmr ' . $whereQuery;
        if ($results = Db::getInstance()->getValue($sql)) {
            return $results;
        }

        return 0;
    }

    private function downloadDemoReceipt($id)
    {
        $orderInfo = $this->getDemo($id);
        if (!empty($orderInfo)) {
            $demoTotalPrice = $orderInfo['amount'];
            $demoTax = 12.36;
            if($orderInfo['created_at']>='2015-09-20 00:00:00')
                {
                    $demoTax=14;
                }
	    if($orderInfo['created_at']>='2015-11-17 16:49:00')
                {
                    $demoTax=14.5;
                }
            $demoPrice = round(($demoTotalPrice * 100) / (100 + $demoTax), 2);
            $receiptNo = sprintf('%06d', $orderInfo['demos_id']);
            $content = array(
                'demoPriceTaxExcl' => $demoPrice,
                'demoPriceTaxIncl' => $demoTotalPrice,
                'demoPriceTotal' => $demoTotalPrice,
                'demoTax' => $demoTax,
                'receiptNo' => $receiptNo,
                'demoDate' => $orderInfo['created_at'],
                'demoAddress' => $this->getFormattedAddress($orderInfo['name'], $orderInfo['address'], $orderInfo['city'], $orderInfo['state'], $orderInfo['zip']),
                'category' => $orderInfo['product']
            );

            $pdf = new DemoPdf($this->context->smarty, $this->context->language->id);
            $pdf->render(true, $content);
        }

    }

    private function getDemo($id)
    {
        $sql = "SELECT * from " . _DB_PREFIX_ . "demos where " . _DB_PREFIX_ . "demos.demos_id='" . $id . "';";
        if ($results = Db::getInstance()->getRow($sql))
            return $results;
        return array();
    }

    private function getFormattedAddress($name, $address, $city, $state, $zip)
    {
        $address = '&nbsp;&nbsp;' . ucfirst($name) . '<br>&nbsp;&nbsp;' . $address . '<br>&nbsp;&nbsp;' . $city . '<br>&nbsp;&nbsp;' . $state . '<br>&nbsp;&nbsp;' . $zip;
        return $address;
    }

    private function bulkDownloadReceipts($fromDate, $toDate)
    {
        $demos = $this->getAllDemos($fromDate, $toDate,'paid');
        $contents = array();
        foreach ($demos as $demo) {
            if (!empty($demo)) {
                $demoTotalPrice = $demo['amount'];
                $demoTax = 12.36;
		if($demo['created_at']>='2015-09-20 00:00:00')
                {
                    $demoTax=14;
                }
		if($demo['created_at']>='2015-11-17 16:49:00')
                {
                    $demoTax=14.5;
                }
                $demoPrice = round(($demoTotalPrice * 100) / (100 + $demoTax), 2);
                $receiptNo = sprintf('%06d', $demo['demos_id']);
                $content = array(
                    'demoPriceTaxExcl' => $demoPrice,
                    'demoPriceTaxIncl' => $demoTotalPrice,
                    'demoPriceTotal' => $demoTotalPrice,
                    'demoTax' => $demoTax,
                    'receiptNo' => $receiptNo,
                    'demoDate' => $demo['created_at'],
                    'demoAddress' => $this->getFormattedAddress($demo['name'], $demo['address'], $demo['city'], $demo['state'], $demo['zip']),
                    'category' => $demo['product']
                );
                $contents[] = $content;

            }
        }

        $pdf = new DemoPdf($this->context->smarty, $this->context->language->id);
        $pdf->renderBulkDemoReceipt(true, $contents);
    }

    private function displayBulkDownloadQueries($url)
    {
        $this->context->smarty->assign(array(
            'url' => $url
        ));

        return $this->fetchTemplate('/views/templates/back/bulk-download-queries.tpl');
    }

    private function bulkDownloadQueries($fromDate, $toDate)
    {
        $queries = $this->getAllDemos($fromDate, $toDate,null);
        ob_end_clean();
        header('Content-Disposition: attachment; filename=Pre Sales Demo Queries.csv');
        header('Cache-Control: max-age=0');
        header('Content-Type: application/octet-stream');
        $content = "Demo Id,Demo Date,Amount,Status,Product,Category,Order Id,Name,Email,Transaction Id,Comments,Address,Country,State,City,PinCode,Mobile,Entry Date \r\n";
        $dataRow = "";
        foreach ($queries as $key => $query) {
            $dataRow .= $this->wrapString($query['demos_id']) . $this->wrapString($query['date']) . $this->wrapString($query['amount']) . $this->wrapString($query['status']) . $this->wrapString($query['product']) . $this->wrapString($query['category']) . $this->wrapString($query['order_id']) . $this->wrapString($query['name']) . $this->wrapString($query['email'])
                . $this->wrapString($query['nb_order_no']) . $this->wrapString($query['special_comments']) . $this->wrapString($query['address']) . $this->wrapString($query['country']) . $this->wrapString($query['state']) . $this->wrapString($query['city']) . $this->wrapString($query['zip'])
                . $this->wrapString($query['mobile']) . $this->wrapString($query['created_at']) . "\r\n";
        }
        $dataRow = rtrim($dataRow, ",");
        $content .= "$dataRow \n";
        echo trim($content);
        exit;
    }

    private function wrapString($val)
    {
        if (empty($val))
            return ",";
        return "\"$val\",";
    }


}
