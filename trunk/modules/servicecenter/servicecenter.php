<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hitanshu
 * Date: 24/8/13
 * Time: 12:54 PM
 * To change this template use File | Settings | File Templates.
 */

class ServiceCenter extends Module
{

    protected $_html = '';

    public $_errors = array();

    public $context;

    public function __construct()
    {
        $this->name = 'servicecenter';
        $this->tab = 'front_office_features';
        $this->version = '1.0';
        $this->author = 'GAPS';

        parent::__construct();

        $this->displayName = $this->l('ServiceCenter');
        $this->description = $this->l('Millagrow Service Centers List');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        $this->page = basename(__FILE__, '.php');

    }

    public function install()
    {
        if (!parent::install()
        )
            return false;

        include_once(_PS_MODULE_DIR_ . '/' . $this->name . '/servicecenter_install.php');
        $service_center_install = new ServiceCenterInstall();
        $service_center_install->createTables();

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
                return $this->display(__FILE__, $views . 'hook/' . $name); elseif (@filemtime(dirname(__FILE__) . '/' . $views . 'front/' . $name))
                return $this->display(__FILE__, $views . 'front/' . $name); elseif (@filemtime(dirname(__FILE__) . '/' . $views . 'back/' . $name))
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


    public function getContent()
    {
        $this->html = '<h2>' . $this->displayName . '</h2>';
        $this->html .= '<link media="all" type="text/css" rel="stylesheet" href="' . $this->_path . 'views/css/back.css"/>';
        if (Tools::getValue('saveServiceCenter') != NULL || Tools::getValue('editServiceCenter') != NULL) {

            if (!($asc_name = trim(Tools::getValue('ascName'))))
                $this->_errors[] = Tools::displayError('ASC Name is Required');
            if (!($contactPerson = trim(Tools::getValue('contactPerson'))))
                $this->_errors[] = Tools::displayError('Contact Person is Required');
            if (!($phone = trim(Tools::getValue('contactNumber'))))
                $this->_errors[] = Tools::displayError('Contact Number is Required');
            if (!($email = trim(Tools::getValue('email'))) ||!Validate::isEmail($email))
                $this->_errors[] = Tools::displayError('Invalid email address.');
            if (!($state = trim(Tools::getValue('state'))))
                $this->_errors[] = Tools::displayError('State is Required');
            if (!($city = trim(Tools::getValue('city'))))
                $this->_errors[] = Tools::displayError('City is Required');
            if (!($pincode = trim(Tools::getValue('pincode'))))
                $this->_errors[] = Tools::displayError('Pin Code is Required');
            if (!($address = html_entity_decode(Tools::getValue('aspAddress'))))
                $this->_errors[] = Tools::displayError('ASP Address is Required');
            if (count($this->_errors) == 0) {
                $error = $this->postProcess();
                if (!empty($error))
                    $this->_errors[] = Tools::displayError($error);

            }
            if (isset($this->_errors) && count($this->_errors) > 0) {
                $this->html .= $this->errorBlock($this->_errors);
                if (Tools::getValue('saveServiceCenter') != NULL)
                    $_GET['sl_tab'] = 'create_service_center';
                elseif (Tools::getValue('editServiceCenter') != NULL)
                    $_GET['sl_tab'] = 'edit_service_center';
            } else {
                $_GET['sl_tab'] = 'servicecenterlist'; //redirect to overview after post action
            }
        }

        $url = $_SERVER['REQUEST_URI'];
        if (strpos($url, '&sl_tab') > 0)
            $url = substr($url, 0, strpos($url, '&sl_tab'));

        $this->html .= '<ul><li ' . (Tools::getValue('sl_tab') == "servicecenterlist" || Tools::getValue('sl_tab') == NULL || Tools::getValue('sl_tab') == '' ? 'class="sl_admin_tab_active"' : 'class="sl_admin_tab"') . '><a style="padding:8px 8px 4px 4px;" href="' . $url . '&sl_tab=" id = "sl_servicecenterlist">' . $this->l('Service Centers') . '</a></li>
		<li ' . (Tools::getValue('sl_tab') == "create_service_center" ? 'class="sl_admin_tab_active"' : 'class="sl_admin_tab"') . '><a style="padding:8px 8px 4px 4px;" href="' . $url . '&sl_tab=create_service_center" id = "sl_create_service_center">' . $this->l('Add New Service Center') . '</a></li></ul>';
        if (Tools::getValue('sl_tab') == 'create_service_center')
            $this->html .= $this->displayCreateServiceCenter($url);
        else if (Tools::getValue('sl_tab') == 'edit_service_center') {
            $id_service_center = Tools::getValue('id_service_center');
            $this->html .= $this->displayEditServiceCenter($id_service_center, $url);
        } else if (Tools::getValue('sl_tab') == 'delete_service_center') {
            $id_service_center = Tools::getValue('id_service_center');
            $this->html .= $this->deleteServiceCenter($id_service_center, $url);
        } else
            $this->html .= $this->displayServiceCenters($url);
        return $this->html;
    }

    private function errorBlock($errors)
    {
        $this->context->smarty->assign(array(
            'errors' => $errors
        ));

        return $this->fetchTemplate('/views/templates/back/errors.tpl');
    }

    private function displayServiceCenters($url)
    {
        $page = Tools::getValue('page');
        $page = !empty($page) ? $page : 1;
        $state = Tools::getValue('state');
        $city = Tools::getValue('city');
        $previousPage = 0;
        $nextPage = 0;
        $pageCount = 10;
        $serviceCenters = $this->getServiceCenterList($state, $city, $page, $pageCount);
        $totalServiceCenters = $this->countServiceCenters($state, $city);
        if (($page * $pageCount) < (int)$totalServiceCenters) {
            $nextPage = $page + 1;
        }
        if ($page > 1)
            $previousPage = $page - 1;

        $stateCityMapping = $this->getStateAndCityMapping();

        $this->context->smarty->assign(array(
            'stateCityMapping' => json_encode($stateCityMapping),
            'selectedState' => $state,
            'selectedCity' => $city,
            'serviceCentersResults' => $serviceCenters,
            'page' => $page,
            'previous' => $previousPage,
            'next' => $nextPage,
            'url' => $url
        ));

        return $this->fetchTemplate('/views/templates/back/service-center-list.tpl');
    }

    private function displayCreateServiceCenter($url)
    {
        $this->context->smarty->assign(array(
            'states' => $this->getStatesFromServiceCenters(),
            'selectedState' => Tools::getValue('state'),
            'selectedCity' => Tools::getValue('city'),
            'ascName' => Tools::getValue('ascName'),
            'aspAddress' => html_entity_decode(Tools::getValue('aspAddress')),
            'contactPerson' => Tools::getValue('contactPerson'),
            'contactNumber' => Tools::getValue('contactNumber'),
            'mobileNumber' => Tools::getValue('mobileNumber'),
            'pincode' => Tools::getValue('pincode'),
            'email' => Tools::getValue('email'),
            'url' => $url
        ));
        return $this->fetchTemplate('/views/templates/back/add-service-center.tpl');
    }


    private function displayEditServiceCenter($id, $url)
    {

        $serviceCenterDetails = $this->getServiceCenter($id);
        $state = trim(Tools::getValue('state'));
        $city = trim(Tools::getValue('city'));
        $ascName = trim(Tools::getValue('ascName'));
        $aspAddress = html_entity_decode(Tools::getValue('aspAddress'));
        $contactPerson = trim(Tools::getValue('contactPerson'));
        $phone = trim(Tools::getValue('contactNumber'));
        $mobile = trim(Tools::getValue('mobileNumber'));
        $email = trim(Tools::getValue('email'));
        $pincode = trim(Tools::getValue('pincode'));

        $state = !empty($state) ? $state : $serviceCenterDetails['state'];
        $city = !empty($city) ? $city : $serviceCenterDetails['city'];
        $ascName = !empty($ascName) ? $ascName : $serviceCenterDetails['asc_name'];
        $aspAddress = !empty($aspAddress) ? $aspAddress : $serviceCenterDetails['asp_address'];
        $contactPerson = !empty($contactPerson) ? $contactPerson : $serviceCenterDetails['contact_person'];
        $phone = !empty($phone) ? $phone : $serviceCenterDetails['contact_number'];
        $mobile = !empty($mobile) ? $mobile : $serviceCenterDetails['mobile_number'];
        $email = !empty($email) ? $email : $serviceCenterDetails['emailid'];
        $pincode = !empty($pincode) ? $pincode : $serviceCenterDetails['pincode'];

        $this->context->smarty->assign(array(
            'states' => $this->getStatesFromServiceCenters(),
            'selectedState' => $state,
            'selectedCity' => $city,
            'ascName' => $ascName,
            'aspAddress' => html_entity_decode($aspAddress),
            'contactPerson' => $contactPerson,
            'contactNumber' => $phone,
            'mobileNumber' => $mobile,
            'email' => $email,
            'pincode' => $pincode,
            'id_service_center' => $serviceCenterDetails['id_service_center'],
            'url' => $url
        ));
        return $this->fetchTemplate('/views/templates/back/edit-service-center.tpl');

    }

    private function deleteServiceCenter($id, $url)
    {
        $id = intval($id);
        Db::getInstance()->Execute('DELETE FROM ' . _DB_PREFIX_ . 'service_center WHERE id_service_center = ' . $id);
        $error = Db::getInstance()->getMsgError();
        $html = '';
        if ($error) {
            $this->_errors[] = 'Sorry error occured while deleting service center';
            $html = $this->errorBlock($this->_errors);
        }
        $html .= $this->displayServiceCenters($url);
        return $html;
    }

    private function postProcess()
    {
        $state = trim(Tools::getValue('state'));
        $city = trim(Tools::getValue('city'));
        $ascName = trim(Tools::getValue('ascName'));
        $aspAddress = html_entity_decode(Tools::getValue('aspAddress'));
        $contactPerson = trim(Tools::getValue('contactPerson'));
        $phone = trim(Tools::getValue('contactNumber'));
        $mobile = trim(Tools::getValue('mobileNumber'));
        $email = trim(Tools::getValue('email'));
        $pincode = trim(Tools::getValue('pincode'));
        $insertData = array('state' => $state, 'city' => $city, 'asc_name' => $ascName, 'asp_address' => $aspAddress, 'contact_number' => $phone,'mobile_number'=>$mobile,'emailid'=>$email, 'contact_person' => $contactPerson,'pincode'=>$pincode);
        if (Tools::getValue('saveServiceCenter') != NULL) {
            Db::getInstance()->insert('service_center', $insertData);
            if (!Db::getInstance()->Insert_ID())
                return $this->l('Sorry an error occured while saving service center');
        } else if (Tools::getValue('editServiceCenter') != NULL) { //edit category
            Db::getInstance()->update('service_center', $insertData, 'id_service_center=' . Tools::getValue('id_service_center'));
            $affectedRows = Db::getInstance()->Affected_Rows();
            $errorMsg = Db::getInstance()->getMsgError();
            if (!$affectedRows && !empty($errorMsg))
                return $this->l('Error Occured while updating service center.');
        }
    }

    public function initContent()
    {
        parent::initContent();
    }

    private function getStateAndCityMapping()
    {
        $sql = 'select * from ' . _DB_PREFIX_ . 'service_center';
        if ($results = Db::getInstance()->ExecuteS($sql)) {
            $stateCityMapping = array();
            foreach ($results as $row) {
                if (!isset($stateCityMapping[$row['state']]) && !empty($row['city']))
                    $stateCityMapping[$row['state']][] = $row['city'];
                elseif (isset($stateCityMapping[$row['state']]) && !in_array($row['city'], $stateCityMapping[$row['state']]))
                    $stateCityMapping[$row['state']][] = $row['city'];
            }
            return $stateCityMapping;
        }
        return array();
    }

    private function getServiceCenterList($state, $city, $p = 1, $n = null)
    {
        $whereQuery = '';
        if (!empty($city) && empty($state))
            $whereQuery .= "where city='$city'";
        elseif (!empty($state) && empty($city))
            $whereQuery .= "where state='$state'"; elseif (empty($state) && empty($city))
            $whereQuery .= ""; else
            $whereQuery .= "where state='$state' and city='$city'";
        $sql = 'select * from ' . _DB_PREFIX_ . 'service_center ' . $whereQuery . ($n ? 'LIMIT ' . (int)(($p - 1) * $n) . ', ' . (int)($n) : '');
        if ($results = Db::getInstance()->ExecuteS($sql)) {
            return $results;
        }
        return array();
    }

    private function countServiceCenters($state, $city)
    {
        $whereQuery = '';
        if (!empty($city) && empty($state))
            $whereQuery .= "where city='$city'";
        elseif (!empty($state) && empty($city))
            $whereQuery .= "where state='$state'"; elseif (empty($state) && empty($city))
            $whereQuery .= ""; else
            $whereQuery .= "where state='$state' and city='$city'";
        $sql = 'select count(id_service_center) from ' . _DB_PREFIX_ . 'service_center ' . $whereQuery;
        if ($results = Db::getInstance()->getValue($sql)) {
            return $results;
        }
        return 0;
    }

    private function getStatesFromServiceCenters()
    {
        $sql = 'select distinct(state) as state from ' . _DB_PREFIX_ . 'service_center ';
        if ($results = Db::getInstance()->executeS($sql)) {
            return $results;
        }
        return array();
    }

    private function getServiceCenter($id)
    {
        $sql = 'select * from ' . _DB_PREFIX_ . 'service_center where id_service_center=' . $id;
        if ($result = Db::getInstance()->getRow($sql)) {
            return $result;
        }
        return array();
    }
}