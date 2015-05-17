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

class Careers extends Module
{

    function __construct()
    {
        $this->name = 'careers';
        $this->tab = 'front_office_features';
        $this->version = '0.9';
        $this->author = 'GAPS';
        $this->need_instance = 0;

        parent::__construct();

        $this->displayName = $this->l('Careers Section');
        $this->description = $this->l('Careers module developed by gaps');
    }

    function install()
    {
        if (!parent::install() || !$this->registerHook('header'))
            return false;
        include_once(_PS_MODULE_DIR_ . '/' . $this->name . '/careers_install.php');
        $careersInstall = new CareersInstall();
        $careersInstall->createTables();
        Configuration::updateValue('MILAGROW_HR_EMAIL', 'hrd@milagrow.in');
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
            $url . '&cc_tab=" id = "cc_querieslist">' . $this->l('Queries List') . '</a></li>
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

        $sql = 'select * from ' . _DB_PREFIX_ . 'careers as cc ' . $whereQuery . " ORDER BY created_at DESC " . ($n ? ' LIMIT ' . (int)(($p - 1) * $n) . ', ' . (int)($n) : '');
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

        $sql = 'select * from ' . _DB_PREFIX_ . 'careers as cc ' . $whereQuery . " ORDER BY created_at DESC";
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

        $sql = 'select count(*) from ' . _DB_PREFIX_ . 'careers as cc ' . $whereQuery;
        if ($results = Db::getInstance()->getValue($sql)) {
            return $results;
        }

        return 0;
    }

    private function bulkDownloadQueries($fromDate, $toDate)
    {
        $queries = $this->getAllQueries($fromDate, $toDate);
        ob_end_clean();
        header('Content-Disposition: attachment; filename=careers queries.csv');
        header('Cache-Control: max-age=0');
        header('Content-Type: application/octet-stream');
        $content = "Serial Number,Name,Email,Date of birth,Phone,City,State,Address,Department,Education,Professional,Skill,Career Highlight,Work Experience,Date \r\n";
        foreach ($queries as $key => $query) {
            $content .= $key + 1 . "," . $query['name'] . "," . $query['email'] . "," .
                $query['dob'] . "," . $query['phone'] . "," . $query['city'].",".$query['state'].",".$query['address'] . "," .
                $query['department'] . "," . $query['education'] . ","
                . $query['professional'] . "," . $query['skill'] . "," . $query['career_highlights'] .
                "," . $query['work_experience'] . "," . $query['created_at'] . "\r\n";
        }
        echo trim($content);
        exit;
    }

    private function deleteQuery($id, $url)
    {
        $id = intval($id);
        Db::getInstance()->Execute('DELETE FROM ' . _DB_PREFIX_ . 'careers WHERE id_careers = ' . $id);
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
