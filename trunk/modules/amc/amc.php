<?php
if (!defined('_PS_VERSION_'))
    exit;
//require_once(dirname(__FILE__) . '/DemoPdf.php');
//require_once(dirname(__FILE__) . '/mydatetime.php');

class AMC extends Module
{
    const MODULE_NAME = "amc";

    public function __construct()
    {

        $this->name = 'amc';
        $this->tab = 'front_office_features';
        $this->version = '1.0';
        $this->author = 'GAPS';
        $this->need_instance = 0;
//        $this->ps_versions_compliancy = array('min' => '1.5', 'max' => '1.5');

        parent::__construct();

        $this->displayName = $this->l('Annual Maintenance Contract');
        $this->description = $this->l('This module will give extended warranty on products');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        /*if (!Configuration::get('MYMODULE_NAME'))
            $this->warning = $this->l('No name provided');*/
    }

    public function install()
    {
        if (!parent::install())
            return false;
        include_once(_PS_MODULE_DIR_ . '/' . $this->name . '/amc_install.php');

        $amcInstall = new AMCInstall();
        $amcInstall->createTables();
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
			SELECT a.*
			FROM `' . _DB_PREFIX_ . 'amc` a
			WHERE DATE_ADD(a.created_at, INTERVAL -1 DAY) <= \'' . pSQL($date_to) . '\'
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
		<li ' . (Tools::getValue('sl_tab') == "bulk_download_queries" ? 'class="sl_admin_tab_active"' : 'class="sl_admin_tab"') . '><a style="padding:8px 8px 4px 4px;" href="' .  $url . '&sl_tab=bulk_download_queries" id = "sl_bulk_download_queries">' . $this->l('Download Queries') . '</a></li>
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
            $this->downloadAMCReceipt($demos_id);
        }
//        else if(Tools::getValue('sl_tab') == 'add_amc_product'){
//            $this->html .= $this->displayAddAmcProductForm($url);
//        }
        else
            $this->html .= $this->displayAMCsList($url);
        return $this->html;
    }

    private function errorBlock($errors)
    {
        $this->context->smarty->assign(array(
            'errors' => $errors
        ));
        return $this->fetchTemplate('/views/templates/back/errors.tpl');
    }

    private function displayAddAmcProductForm(){

//        $context = context::getContext();

        $sql = 'select '._DB_PREFIX_ .'category.id_category as category_id,'._DB_PREFIX_ .'category_lang.name as category_name from '._DB_PREFIX_ .'category join '._DB_PREFIX_ .'category_lang on '._DB_PREFIX_ .'category.id_category = '._DB_PREFIX_ .'category_lang.id_category where (select count(*) from '._DB_PREFIX_ .'product join '._DB_PREFIX_ .'category_product on ps_product.id_product = '._DB_PREFIX_ .'category_product.id_product where  '._DB_PREFIX_ .'category_product.id_category = '._DB_PREFIX_ .'category.id_category and '._DB_PREFIX_ .'category.level_depth = 2 group by '._DB_PREFIX_ .'category_product.id_category) > 0 ';
        $categories = Db::getInstance()->ExecuteS($sql);

        $sql = 'select '._DB_PREFIX_ .'product.id_product ,'._DB_PREFIX_ .'product_lang.name,'._DB_PREFIX_ .'category_product.id_category  from '._DB_PREFIX_ .'product join '._DB_PREFIX_ .'product_lang on '._DB_PREFIX_ .'product.id_product = '._DB_PREFIX_ .'product_lang.id_product join '._DB_PREFIX_ .'category_product on '._DB_PREFIX_ .'category_product.id_product = '._DB_PREFIX_ .'product.id_product ';
        $products = Db::getInstance()->ExecuteS($sql);

        $this->context->smarty->assign(array(
            'categories' => $categories,
            'products' => json_encode($products)
        ));

        return $this->fetchTemplate('/views/templates/back/add-amc-product.tpl');
    }

    private function getCategoryWiseProduct($category_id){
        $sql = 'select ps_product.id_product ,ps_product_lang.name from ps_product join ps_product_lang on ps_product.id_product = ps_product_lang.id_product join ps_category_product on ps_category_product.id_product = ps_product.id_product where ps_category_product.id_category = '.$category_id;
        $products = Db::getInstance()->ExecuteS($sql);

        echo json_encode($products);
    }

    private function displayAMCsList($url)
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
        $demosList = $this->getAMCsList($fromDate, $toDate, $page, $pageCount);
        $totalDemos = $this->countAMCs($fromDate, $toDate);
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

    private function getAMCsList($fromDate, $toDate, $p = 1, $n = null)
    {
        $whereQuery = '';
        if (!empty($fromDate) && empty($toDate)) {
            $fromDate = date('Y', $fromDate->getTimestamp()) . "-" . date('m', $fromDate->getTimestamp()) . "-" . date('d', $fromDate->getTimestamp()) . " 00:00:00";
            $fromDate = new MyDateTime($fromDate);
            $fromDate = $fromDate->format('Y-m-d H:i:s');
            $whereQuery .= "where a.created_at>='$fromDate'";
        } elseif (empty($fromDate) && !empty($toDate)) {
            $toDate = date('Y', $toDate->getTimestamp()) . "-" . date('m', $toDate->getTimestamp()) . "-" . date('d', $toDate->getTimestamp()) . " 00:00:00";
            $toDate = new MyDateTime($toDate);
            $toDate->add();
            $toDate = $toDate->format('Y-m-d H:i:s');
            $whereQuery .= "where a.created_at<'$toDate'";
        } elseif (!empty($fromDate) && !empty($toDate)) {
            $fromDate = date('Y', $fromDate->getTimestamp()) . "-" . date('m', $fromDate->getTimestamp()) . "-" . date('d', $fromDate->getTimestamp()) . " 00:00:00";
            $fromDate = new MyDateTime($fromDate);
            $fromDate = $fromDate->format('Y-m-d H:i:s');
            $toDate = date('Y', $toDate->getTimestamp()) . "-" . date('m', $toDate->getTimestamp()) . "-" . date('d', $toDate->getTimestamp()) . " 00:00:00";
            $toDate = new MyDateTime($toDate);
            $toDate->add();
            $toDate = $toDate->format('Y-m-d H:i:s');
            $whereQuery .= "where a.created_at>='$fromDate' and a.created_at<'$toDate'";
        }

        $sql = 'select a.*,pd.name as product_name from ' . _DB_PREFIX_ . 'amc as a join ' . _DB_PREFIX_ . 'product_lang pd on a.product = pd.id_product  ' . $whereQuery . ($n ? ' LIMIT ' . (int)(($p - 1) * $n) . ', ' . (int)($n) : '');
//        echo $sql;exit;

        if ($results = Db::getInstance()->ExecuteS($sql)) {
            return $results;
        }

        return array();
    }

    private function getAllAMCs($fromDate, $toDate,$status)
    {
        $fromDate = !empty($fromDate) ? new MyDateTime($fromDate) : null;
        $toDate = !empty($toDate) ? new MyDateTime($toDate) : null;
        $whereQuery = '';
        if (!empty($fromDate) && empty($toDate)) {
            $fromDate = date('Y', $fromDate->getTimestamp()) . "-" . date('m', $fromDate->getTimestamp()) . "-" . date('d', $fromDate->getTimestamp()) . " 00:00:00";
            $fromDate = new MyDateTime($fromDate);
            $fromDate = $fromDate->format('Y-m-d');
            $whereQuery .= "where a.created_at>='$fromDate'";
        } elseif (empty($fromDate) && !empty($toDate)) {
            $toDate = date('Y', $toDate->getTimestamp()) . "-" . date('m', $toDate->getTimestamp()) . "-" . date('d', $toDate->getTimestamp()) . " 00:00:00";
            $toDate = new MyDateTime($toDate);
            $toDate->add();
            $toDate = $toDate->format('Y-m-d');
            $whereQuery .= "where a.created_at<'$toDate'";
        } elseif (!empty($fromDate) && !empty($toDate)) {
            $fromDate = date('Y', $fromDate->getTimestamp()) . "-" . date('m', $fromDate->getTimestamp()) . "-" . date('d', $fromDate->getTimestamp()) . " 00:00:00";
            $fromDate = new MyDateTime($fromDate);
            $fromDate = $fromDate->format('Y-m-d');
            $toDate = date('Y', $toDate->getTimestamp()) . "-" . date('m', $toDate->getTimestamp()) . "-" . date('d', $toDate->getTimestamp()) . " 00:00:00";
            $toDate = new MyDateTime($toDate);
            $toDate->add();
            $toDate = $toDate->format('Y-m-d');
            $whereQuery .= "where a.created_at>='$fromDate' and a.created_at<'$toDate'";
        }

        if(!empty($status))
            $whereQuery.=' and a.status=\''.$status.'\'';

        $sql = 'select * from ' . _DB_PREFIX_ . 'amc as a ' . $whereQuery;
        if ($results = Db::getInstance()->ExecuteS($sql)) {
            return $results;
        }

        return array();
    }


    private function countAMCs($fromDate, $toDate)
    {
        $whereQuery = '';
        if (!empty($fromDate) && empty($toDate)) {
            $fromDate = date('Y', $fromDate->getTimestamp()) . "-" . date('m', $fromDate->getTimestamp()) . "-" . date('d', $fromDate->getTimestamp()) . " 00:00:00";
            $fromDate = new MyDateTime($fromDate);
            $fromDate = $fromDate->format('Y-m-d H:i:s');
            $whereQuery .= "where a.created_at>='$fromDate'";
        } elseif (empty($fromDate) && !empty($toDate)) {
            $toDate = date('Y', $toDate->getTimestamp()) . "-" . date('m', $toDate->getTimestamp()) . "-" . date('d', $toDate->getTimestamp()) . " 00:00:00";
            $toDate = new MyDateTime($toDate);
            $toDate->add();
            $toDate = $toDate->format('Y-m-d H:i:s');
            $whereQuery .= "where a.created_at<'$toDate'";
        } elseif (!empty($fromDate) && !empty($toDate)) {
            $fromDate = date('Y', $fromDate->getTimestamp()) . "-" . date('m', $fromDate->getTimestamp()) . "-" . date('d', $fromDate->getTimestamp()) . " 00:00:00";
            $fromDate = new MyDateTime($fromDate);
            $fromDate = $fromDate->format('Y-m-d H:i:s');
            $toDate = date('Y', $toDate->getTimestamp()) . "-" . date('m', $toDate->getTimestamp()) . "-" . date('d', $toDate->getTimestamp()) . " 00:00:00";
            $toDate = new MyDateTime($toDate);
            $toDate->add();
            $toDate = $toDate->format('Y-m-d H:i:s');
            $whereQuery .= "where a.created_at>='$fromDate' and a.created_at<'$toDate'";
        }

        $sql = 'select count(*) from ' . _DB_PREFIX_ . 'amc as a ' . $whereQuery;
        if ($results = Db::getInstance()->getValue($sql)) {
            return $results;
        }

        return 0;
    }

    private function downloadAMCReceipt($id)
    {
        $orderInfo = $this->getAMC($id);
        if (!empty($orderInfo)) {
            $demoTotalPrice = $orderInfo['amount'];
            $demoTax = 12.36;
            #$demoTax = 12.36;
            if($orderInfo['created_at']>='2015-10-02 00:00:00')
            {
                $demoTax=14;
            }
            if($orderInfo['created_at']>='2015-11-17 16:49:00')
            {
                $demoTax=14.5;
            }

            if(!empty($orderInfo['tax_rate']))
            {
                $demoTax=$orderInfo['tax_rate'];
            }
            elseif($orderInfo['created_at']>='2016-06-01 00:00:00')
            {
                $demoTax=15;
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

    private function getAMC($id)
    {
        $sql = "SELECT * from " . _DB_PREFIX_ . "amc where " . _DB_PREFIX_ . "amc.amc_id='" . $id . "';";
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
        $amcs = $this->getAllAMCs($fromDate, $toDate,'paid');

        $contents = array();
        if(!empty($amcs)){
            foreach ($amcs as $amc) {
                if (!empty($amc)) {
                    $amcTotalPrice = $amc['amount'];
                    $amcTax = 12.36;
                    if($amc['created_at']>='2015-10-02 00:00:00')
                    {
                    $amcTax=14;
                    }
		    if($amc['created_at']>='2015-10-17 16:49:00')
            	    {
                        $amcTax=14.5;
            	    }

                    if(!empty($orderInfo['tax_rate']))
                    {
                        $amcTax=$orderInfo['tax_rate'];
                    }
                    elseif($orderInfo['created_at']>='2016-06-01 00:00:00')
                    {
                        $amcTax=15;
                    }

                    $amcPrice = round(($$amcTotalPrice * 100) / (100 + $amcTax), 2);
                    $receiptNo = sprintf('%06d', $amc['demos_id']);
                    $content = array(
                        'demoPriceTaxExcl' => $amcPrice,
                        'demoPriceTaxIncl' => $amcTotalPrice,
                        'demoPriceTotal' => $amcTotalPrice,
                        'demoTax' => $amcTax,
                        'receiptNo' => $receiptNo,
                        'demoDate' => $amc['created_at'],
                        'demoAddress' => $this->getFormattedAddress($amc['name'], $amc['address'], $amc['city'], $amc['state'], $amc['zip']),
                        'category' => $amc['product']
                    );
                    $contents[] = $content;
                }
            }

            $pdf = new DemoPdf($this->context->smarty, $this->context->language->id);
            $pdf->renderBulkDemoReceipt(true, $contents);
        }else{
            $content = "No rows Found";

            $this->context->smarty->assign(array(
                'content' => $content
            ));
            return $this->fetchTemplate('/views/templates/back/bulk-download-receipt.tpl');
        }

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
        $queries = $this->getAllAMCs($fromDate, $toDate,null);
//        echo "<pre>";print_r($queries);echo "</pre>";
        if(!empty($queries) && count($queries) > 0){
            ob_end_clean();
            header('Content-Disposition: attachment; filename=Annual maintenance Contract Queries.csv');
            header('Cache-Control: max-age=0');
            header('Content-Type: application/octet-stream');
            $content = "AMC Id,Purchase Date,Amount,Status,Product,Category,Order Id,Name,Email,Payment Type,Transaction Id,Comments,Address,Country,State,City,PinCode,Mobile,Entry Date \r\n";
            $dataRow = "";
            foreach ($queries as $key => $query) {
                $dataRow .= $this->wrapString($query['amc_id']) . $this->wrapString($query['date']) . $this->wrapString($query['amount']) . $this->wrapString($query['status']) . $this->wrapString($query['product']) . $this->wrapString($query['category']) . $this->wrapString($query['order_id']) . $this->wrapString($query['name']) . $this->wrapString($query['email'])
                    . $this->wrapString($query['payment_type']) . $this->wrapString($query['nb_order_no']) . $this->wrapString($query['special_comments']) . $this->wrapString($query['address']) . $this->wrapString($query['country']) . $this->wrapString($query['state']) . $this->wrapString($query['city']) . $this->wrapString($query['zip'])
                    . $this->wrapString($query['mobile']) . $this->wrapString($query['created_at']) . "\r\n";
            }
            $dataRow = rtrim($dataRow, ",");
            $content .= "$dataRow \n";
            echo trim($content);
            exit;
        }else{
            $content = "No rows Found";
            $this->context->smarty->assign(array(
                'content' => $content
            ));
            return $this->fetchTemplate('/views/templates/back/bulk-download-queries.tpl');
        }


    }

    private function wrapString($val)
    {
        if (empty($val))
            return ",";
        return "\"$val\",";
    }


}
