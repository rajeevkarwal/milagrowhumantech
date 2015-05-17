<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hitanshu
 * Date: 14/11/13
 * Time: 5:43 PM
 * To change this template use File | Settings | File Templates.
 */
if (!defined('_PS_VERSION_'))
    exit;

class CustomerCare extends Module
{

    function __construct()
    {
        $this->name = 'customercare';
        $this->tab = 'front_office_features';
        $this->version = '1.0';
        $this->author = 'GAPS';
        $this->need_instance = 0;

        parent::__construct();

        $this->displayName = $this->l('Customer Care');
        $this->description = $this->l('Customer care module developed by gaps');
    }

    public function install()
    {
        if (!parent::install() || !$this->registerHook('header') || !$this->registerHook('customerAccount'))
            return false;
        include_once(_PS_MODULE_DIR_ . '/' . $this->name . '/customercare_install.php');
        $demoRegistrationInstall = new CustomerCareInstall();
        $demoRegistrationInstall->createTables();
        Configuration::updateValue('MILAGROW_CUSTOMER_CARE_EMAIL', 'cs@milagrow.in');
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


    public function getContent()
    {
        $this->html = '<h2>' . $this->displayName . '</h2>';
        $this->html .= '<link media="all" type="text/css" rel="stylesheet" href="' . $this->_path . 'views/css/back.css"/>';
        if (Tools::getValue('generateQueries') != NULL) {
            $this->bulkDownloadQueries(Tools::getValue('fromDate'), Tools::getValue('toDate'));
        }
        $url = $_SERVER['REQUEST_URI'];
        if (strpos($url, '&cc_tab') > 0)
            $url = substr($url, 0, strpos($url, '&cc_tab'));

        $this->html .= '<ul><li ' . (Tools::getValue('cc_tab') == "querieslist" || Tools::getValue('cc_tab') == NULL ||
            Tools::getValue('cc_tab') == '' ? 'class="cc_admin_tab_active"' : 'class="cc_admin_tab"')
            . '><a style="padding:8px 8px 4px 4px;" href="' .
            $url . '&cc_tab=" id = "cc_querieslist">' . $this->l('Query List') . '</a></li>
		<li ' . (Tools::getValue('cc_tab') == "bulk_download_queries" ? 'class="cc_admin_tab_active"' : 'class="cc_admin_tab"') . '><a style="padding:8px 8px 4px 4px;" href="' .
            $url . '&cc_tab=bulk_download_queries" id = "cc_bulk_download_queries">' . $this->l('Download Queries') . '</a></li></ul>';

        if (Tools::getValue('cc_tab') == 'delete_query') {
            $id_query = Tools::getValue('id_query');
            $this->html .= $this->deleteQuery($id_query, $url);
        } else if (Tools::getValue('cc_tab') == 'bulk_download_queries')
            $this->html .= $this->displayBulkDownloadQueries($url);
        else
            $this->html .= $this->displayQueriesList($url);
        return $this->html;
    }

    private function errorBlock($errors)
    {
        $this->context->smarty->assign(array(
            'errors' => $errors
        ));
        return $this->fetchTemplate('/views/templates/back/errors.tpl');
    }

    private function displayQueriesList($url)
    {
        $page = Tools::getValue('page');
        $page = !empty($page) ? $page : 1;
        $fromDate = Tools::getValue('fromDate');
        $toDate = Tools::getValue('toDate');
        $fromDate = !empty($fromDate) ? $fromDate : null;
        $toDate = !empty($toDate) ? $toDate : null;
        $previousPage = 0;
        $nextPage = 0;
        $pageCount = 10;
        $queriesList = $this->getQueriesList($fromDate, $toDate, $page, $pageCount);
        $totalQueries = $this->countQueries($fromDate, $toDate);
        if (($page * $pageCount) < (int)$totalQueries) {
            $nextPage = $page + 1;
        }
        if ($page > 1)
            $previousPage = $page - 1;

        $selectedFromDate = !empty($fromDate) ? $fromDate : '';
        $selectedToDate = !empty($toDate) ? $toDate : '';
        $this->context->smarty->assign(array(
            'fromDate' => $selectedFromDate,
            'toDate' => $selectedToDate,
            'queriesList' => $queriesList,
            'page' => $page,
            'previous' => $previousPage,
            'next' => $nextPage,
            'url' => $url
        ));

        return $this->fetchTemplate('/views/templates/back/enquiry-list.tpl');
    }

    private function displayBulkDownloadQueries($url)
    {
        $this->context->smarty->assign(array(
            'url' => $url
        ));

        return $this->fetchTemplate('/views/templates/back/bulk-download-receipt.tpl');
    }

    private function getQueriesList($fromDate, $toDate, $p = 1, $n = null)
    {
        $whereQuery = '';
        if (!empty($fromDate) && empty($toDate)) {

            $whereQuery .= "where cc.created_at>='$fromDate'";
        } elseif (empty($fromDate) && !empty($toDate)) {

            $toDate = str_replace('-', '/', $toDate);
            $tomorrow = date('Y-m-d', strtotime($toDate . "+1 days"));
            $whereQuery .= "where cc.created_at<'$tomorrow'";
        } elseif (!empty($fromDate) && !empty($toDate)) {

            $toDate = str_replace('-', '/', $toDate);
            $tomorrow = date('Y-m-d', strtotime($toDate . "+1 days"));
            $whereQuery .= "where cc.created_at>='$fromDate' and cc.created_at<'$tomorrow'";
        }

        $sql = 'select * from ' . _DB_PREFIX_ . 'customer_care as cc ' . $whereQuery . " ORDER BY created_at DESC ". ($n ? ' LIMIT ' . (int)(($p - 1) * $n) . ', ' . (int)($n) : '');
        if ($results = Db::getInstance()->ExecuteS($sql)) {
            return $results;
        }

        return array();
    }

    private function getAllQueries($fromDate, $toDate)
    {
        $fromDate = !empty($fromDate) ? $fromDate : null;
        $toDate = !empty($toDate) ? $toDate : null;
        $whereQuery = '';
        if (!empty($fromDate) && empty($toDate)) {

            $whereQuery .= "where cc.created_at>='$fromDate'";
        } elseif (empty($fromDate) && !empty($toDate)) {
            $toDate = str_replace('-', '/', $toDate);
            $tomorrow = date('Y-m-d', strtotime($toDate . "+1 days"));
            $whereQuery .= "where cc.created_at<'$tomorrow'";
        } elseif (!empty($fromDate) && !empty($toDate)) {
            $toDate = str_replace('-', '/', $toDate);
            $tomorrow = date('Y-m-d', strtotime($toDate . "+1 days"));

            $whereQuery .= "where cc.created_at>='$fromDate' and cc.created_at<'$tomorrow'";
        }

        $sql = 'select * from ' . _DB_PREFIX_ . 'customer_care as cc ' . $whereQuery . " ORDER BY created_at DESC";
        if ($results = Db::getInstance()->ExecuteS($sql)) {
            return $results;
        }

        return array();
    }


    private function countQueries($fromDate, $toDate)
    {
        $whereQuery = '';
        if (!empty($fromDate) && empty($toDate)) {

            $whereQuery .= "where cc.created_at>='$fromDate'";
        } elseif (empty($fromDate) && !empty($toDate)) {
            $toDate = str_replace('-', '/', $toDate);
            $tomorrow = date('Y-m-d', strtotime($toDate . "+1 days"));
            $whereQuery .= "where cc.created_at<'$tomorrow'";

        } elseif (!empty($fromDate) && !empty($toDate)) {
            $toDate = str_replace('-', '/', $toDate);
            $tomorrow = date('Y-m-d', strtotime($toDate . "+1 days"));

            $whereQuery .= "where cc.created_at>='$fromDate' and cc.created_at<'$tomorrow'";
        }

        $sql = 'select count(*) from ' . _DB_PREFIX_ . 'customer_care as cc ' . $whereQuery;
        if ($results = Db::getInstance()->getValue($sql)) {
            return $results;
        }

        return 0;
    }

    private function bulkDownloadQueries($fromDate, $toDate)
    {
        $queries = $this->getAllQueries($fromDate, $toDate);
        ob_end_clean();
        header('Content-Disposition: attachment; filename=customer care queries.csv');
        header('Cache-Control: max-age=0');
        header('Content-Type: application/octet-stream');
        $content = "Serial Number,Name,Email,PhoneNumber,Product,City,State,Purpose,Is Existing Customer,Remarks \r\n";
        foreach ($queries as $key => $query) {
            $content .= $key + 1 . "," . $query['name'] . "," . $query['email'] . "," .
                $query['phone_number'] . "," . $query['product'] . "," .$query['city'].",".$query['state'].",". $query['category'] . "," .
                ($query['is_existing_customer'] == 0 ? "No" : "Yes") . "," . $query['message'] . "\r\n";
        }
        echo trim($content);
        exit;
    }

    private function deleteQuery($id, $url)
    {
        $id = intval($id);
        Db::getInstance()->Execute('DELETE FROM ' . _DB_PREFIX_ . 'customer_care WHERE customer_care_id = ' . $id);
        $error = Db::getInstance()->getMsgError();
        $html = '';
        if ($error) {
            $this->_errors[] = 'Sorry error occured while deleting store';
            $html = $this->errorBlock($this->_errors);
        }
        $html .= $this->displayQueriesList($url);
        return $html;
    }
    /*
*  my account hook that show tpl for Customer Care
*/
    public function hookcustomerAccount()
    {
        return $this->display(__FILE__, 'customer-care.tpl');
    }
}
