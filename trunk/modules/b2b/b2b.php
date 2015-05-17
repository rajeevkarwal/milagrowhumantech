<?php
/*
* 2007-2013 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2013 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_'))
    exit;

class B2b extends Module
{
    protected $_html = '';

    public $_errors = array();

    public $context;

    public function __construct()
    {
        $this->name = 'b2b';
        $this->tab = 'front_office_features';
        $this->version = '1.0';
        $this->author = 'GAPS';

        parent::__construct();

        $this->displayName = $this->l('B2B');
        $this->description = $this->l('Millagrow B2B System');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        $this->page = basename(__FILE__, '.php');

    }

    public function install()
    {
        if (!parent::install()
        )
            return false;

        include_once(_PS_MODULE_DIR_ . '/' . $this->name . '/b2b_install.php');
        $b2b_install = new B2bInstall();
        $b2b_install->createTables();

        return true;
    }

    public function uninstall()
    {
        return parent::uninstall();
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

    public function getProductsList($categoryId)
    {
        $query = 'select id_category from ' . _DB_PREFIX_ . 'category where id_parent=' . $categoryId;
        $subCategories = Db::getInstance()->ExecuteS($query);
        $allSelectedCategories = array();
        foreach ($subCategories as $row) {
            $allSelectedCategories[] = $row['id_category'];
        }
        $categoryString = $categoryId;
        if (!empty($allSelectedCategories))
            $categoryString = implode(',', $allSelectedCategories) . ',' . $categoryId;
        $sql = 'select distinct(' . _DB_PREFIX_ . 'product_lang.id_product) as id_product,' . _DB_PREFIX_ . 'product_lang.name as name from ' . _DB_PREFIX_ . 'category_product join ' . _DB_PREFIX_ . 'product_lang on ' . _DB_PREFIX_ . 'category_product.id_product=' . _DB_PREFIX_ . 'product_lang.id_product join ' . _DB_PREFIX_ . 'product on ' . _DB_PREFIX_ . 'product_lang.id_product=' . _DB_PREFIX_ . 'product.id_product where ' . _DB_PREFIX_ . 'category_product.id_category in(' . $categoryString . ') and ' . _DB_PREFIX_ . 'product.active=1';
        $results = Db::getInstance()->ExecuteS($sql);
        if ($results)
            return $results;
        return array();
    }

    public function getCityAndStateFromThePinCode($pincode)
    {
        $sql = 'select ' . _DB_PREFIX_ . 'state.name as name, city from ' . _DB_PREFIX_ . 'state join ' . _DB_PREFIX_ . 'pincode_cod on ' . _DB_PREFIX_ . 'state.id_state=' . _DB_PREFIX_ . 'pincode_cod.id_state where pincode=\'' . $pincode . '\'';
        $row = Db::getInstance()->getRow($sql);
        if ($row)
            return $row;
        else
            return false;
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
            $url . '&cc_tab=" id = "cc_querieslist">' . $this->l('Queries List') . '</a></li>
		<li ' . (Tools::getValue('cc_tab') == "bulk_download_queries" ? 'class="cc_admin_tab_active"' : 'class="cc_admin_tab"') . '><a style="padding:8px 8px 4px 4px;" href="' .
            $url . '&cc_tab=bulk_download_queries" id = "cc_bulk_download_queries">' . $this->l('Generate Queries') . '</a></li></ul>';

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

        $sql = 'select * from ' . _DB_PREFIX_ . 'b2b as cc ' . $whereQuery . " ORDER BY created_at DESC " . ($n ? ' LIMIT ' . (int)(($p - 1) * $n) . ', ' . (int)($n) : '');
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

        $sql = 'select * from ' . _DB_PREFIX_ . 'b2b as cc ' . $whereQuery . " ORDER BY created_at DESC";
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

        $sql = 'select count(*) from ' . _DB_PREFIX_ . 'b2b as cc ' . $whereQuery;
        if ($results = Db::getInstance()->getValue($sql)) {
            return $results;
        }

        return 0;
    }


    private function bulkDownloadQueries($fromDate, $toDate)
    {
        $queries = $this->getAllQueries($fromDate, $toDate);
        ob_end_clean();
        header('Content-Disposition: attachment; filename=Bulk Purchase queries.csv');
        header('Cache-Control: max-age=0');
        header('Content-Type: application/octet-stream');
        $content = "Serial Number,Name,Company Name,Email,Phone,Country,Pincode,City,State,Product,Quantity,Comment,Date \r\n";
        foreach ($queries as $key => $query) {
            $content .= $key + 1 . "," . $query['name'] . "," . $query['companyName'] . "," .
                $query['email'] . "," . $query['mobile'] . "," . $query['country'] . "," .
                $query['pincode'] . "," . $query['city'] . ","
                . $query['state'] . "," . $query['product'] . "," . $query['quantity'] .
                "," . $query['comment'] . "," . $query['created_at'] . "\r\n";
        }
        echo trim($content);
        exit;
    }

    private function deleteQuery($id, $url)
    {
        $id = intval($id);
        Db::getInstance()->Execute('DELETE FROM ' . _DB_PREFIX_ . 'b2b WHERE id_b2b = ' . $id);
        $error = Db::getInstance()->getMsgError();
        $html = '';
        if ($error) {
            $this->_errors[] = 'Sorry error occured while deleting store';
            $html = $this->errorBlock($this->_errors);
        }
        $html .= $this->displayQueriesList($url);
        return $html;
    }
}
