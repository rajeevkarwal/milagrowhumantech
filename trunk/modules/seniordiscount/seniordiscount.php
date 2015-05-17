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

class SeniorDiscount extends Module
{

    function __construct()
    {
        $this->name = 'seniordiscount';
        $this->tab = 'front_office_features';
        $this->version = '0.9';
        $this->author = 'GAPS';
        $this->need_instance = 0;

        parent::__construct();

        $this->displayName = $this->l('Senior Citizen Discount Form');
        $this->description = $this->l('Senior Citizen Discount Form developed by GAPS');
    }

    function install()
    {
        if (!parent::install() || !$this->registerHook('header'))
            return false;
        include_once(_PS_MODULE_DIR_ . '/' . $this->name . '/seniordiscount_install.php');
        $seniorDiscountInstall = new SeniorDiscountInstall();
        $seniorDiscountInstall->createTables();
        return true;
    }

    public function uninstall()
    {
        if (!parent::uninstall())
            return false;
        return true;
    }


    public function hookDisplayHeader($params)
    {
        $this->hookHeader($params);
    }

    public function hookHeader($params)
    {
//        $this->context->controller->addJS('/js/jquery/ui/jquery.ui.datepicker.min.js');
        $this->context->controller->addCSS(_THEME_CSS_DIR_ . 'contact-form.css');

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
        $this->html .= '<link media="all" type="text/css" rel="stylesheet" href="' . 
            $this->_path . 'views/css/back.css"/>';
        if (Tools::getValue('generateQueries') != NULL) {
            $this->bulkDownloadQueries(Tools::getValue('fromDate'), Tools::getValue('toDate'));
        }
        $url = $_SERVER['REQUEST_URI'];
        if (strpos($url, '&sd_tab') > 0)
            $url = substr($url, 0, strpos($url, '&sd_tab'));

        $this->html .= '<ul><li ' . (Tools::getValue('sd_tab') == "querieslist" || Tools::getValue('sd_tab') == NULL ||
            Tools::getValue('sd_tab') == '' ? 'class="sd_admin_tab_active"' : 'class="sd_admin_tab"')
            . '><a style="padding:8px 8px 4px 4px;" href="' .
            $url . '&sd_tab=" id = "sd_querieslist">' . $this->l('Senior citizen discount list') . '</a></li>
		<li ' . (Tools::getValue('sd_tab') == "bulk_download_queries" ? 'class="sd_admin_tab_active"' : 'class="sd_admin_tab"') . '><a style="padding:8px 8px 4px 4px;" href="' .
            $url . '&sd_tab=bulk_download_queries" id = "sd_bulk_download_queries">' . $this->l('Download senior citizen discount list') . '</a></li></ul>';

        if (Tools::getValue('sd_tab') == 'delete_query') {
            $id_query = Tools::getValue('id_query');
            $this->html .= $this->deleteQuery($id_query, $url);
        } else if (Tools::getValue('sd_tab') == 'bulk_download_queries')
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

            $whereQuery .= "where sd.created_at>='$fromDate'";
        } elseif (empty($fromDate) && !empty($toDate)) {

            $toDate = str_replace('-', '/', $toDate);
            $tomorrow = date('Y-m-d', strtotime($toDate . "+1 days"));
            $whereQuery .= "where sd.created_at<'$tomorrow'";
        } elseif (!empty($fromDate) && !empty($toDate)) {

            $toDate = str_replace('-', '/', $toDate);
            $tomorrow = date('Y-m-d', strtotime($toDate . "+1 days"));
            $whereQuery .= "where sd.created_at>='$fromDate' and sd.created_at<'$tomorrow'";
        }

        $sql = 'select * from ' . _DB_PREFIX_ . 'senior_discount as sd ' . $whereQuery . " ORDER BY created_at ".($n ? ' LIMIT ' . (int)(($p - 1) * $n) . ', ' . (int)($n) : '');
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

            $whereQuery .= "where sd.created_at>='$fromDate'";
        } elseif (empty($fromDate) && !empty($toDate)) {
            $toDate = str_replace('-', '/', $toDate);
            $tomorrow = date('Y-m-d', strtotime($toDate . "+1 days"));
            $whereQuery .= "where sd.created_at<'$tomorrow'";
        } elseif (!empty($fromDate) && !empty($toDate)) {
            $toDate = str_replace('-', '/', $toDate);
            $tomorrow = date('Y-m-d', strtotime($toDate . "+1 days"));

            $whereQuery .= "where sd.created_at>='$fromDate' and sd.created_at<'$tomorrow'";
        }

        $sql = 'select * from ' . _DB_PREFIX_ . 'senior_discount as sd ' . $whereQuery. " ORDER BY created_at ";
        if ($results = Db::getInstance()->ExecuteS($sql)) {
            return $results;
        }

        return array();
    }


    private function countQueries($fromDate, $toDate)
    {
        $whereQuery = '';
        if (!empty($fromDate) && empty($toDate)) {

            $whereQuery .= "where sd.created_at>='$fromDate'";
        } elseif (empty($fromDate) && !empty($toDate)) {
            $toDate = str_replace('-', '/', $toDate);
            $tomorrow = date('Y-m-d', strtotime($toDate . "+1 days"));
            $whereQuery .= "where sd.created_at<'$tomorrow'";

        } elseif (!empty($fromDate) && !empty($toDate)) {
            $toDate = str_replace('-', '/', $toDate);
            $tomorrow = date('Y-m-d', strtotime($toDate . "+1 days"));

            $whereQuery .= "where sd.created_at>='$fromDate' and sd.created_at<'$tomorrow'";
        }

        $sql = 'select count(*) from ' . _DB_PREFIX_ . 'senior_discount as sd ' . $whereQuery;
        if ($results = Db::getInstance()->getValue($sql)) {
            return $results;
        }

        return 0;
    }

    private function bulkDownloadQueries($fromDate, $toDate)
    {
        $queries = $this->getAllQueries($fromDate, $toDate);
        ob_end_clean();
        header('Content-Disposition: attachment; filename=senior_citizen_discount_list.csv');
        header('Cache-Control: max-age=0');
        header('Content-Type: application/octet-stream');
        $content = "Serial Number,Name,Email,PhoneNumber,Interest,Date of Birth,City,Date \r\n";

        foreach ($queries as $key => $query) {
            $content .= $key + 1 . "," . $query['name'] . "," . $query['email'] . "," .
                $query['mobile'] . "," . $query['interest'] . "," . $query['dob'] . "," .
                $query['city']  . "," . $query['created_at'] . "\r\n";
        }
        echo trim($content);
        exit;
    }

    private function deleteQuery($id, $url)
    {
        $id = intval($id);
        Db::getInstance()->Execute('DELETE FROM ' . _DB_PREFIX_ . 'senior_discount WHERE id_senior_discount = ' . $id);
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
