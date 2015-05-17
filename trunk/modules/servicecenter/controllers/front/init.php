<?php


class ServiceCenterInitModuleFrontController extends ModuleFrontController
{

//    public function postProcess()
//    {
//        $this->updateStateCityAlphabets();
//        exit;
//    }

    public function initContent()
    {

        parent::initContent();

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
            'next' => $nextPage
        ));

        $this->setTemplate('servicecenter.tpl');
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
            $whereQuery .= "where state='$state'";
        elseif (empty($state) && empty($city))
            $whereQuery .= "";
        else
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
            $whereQuery .= "where state='$state'";
        elseif (empty($state) && empty($city))
            $whereQuery .= "";
        else
            $whereQuery .= "where state='$state' and city='$city'";
        $sql = 'select count(id_service_center) from ' . _DB_PREFIX_ . 'service_center ' . $whereQuery;
        if ($results = Db::getInstance()->getValue($sql)) {
            return $results;
        }
        return 0;
    }

    private function updateStateCityAlphabets()
    {
        $sql = 'select * from ' . _DB_PREFIX_ . 'service_center';
        if ($results = Db::getInstance()->ExecuteS($sql)) {
            foreach ($results as $row) {
                $ascName=ucwords(strtolower($row['asc_name']));
                $state = ucwords(strtolower($row['state']));
                $city = ucwords(strtolower($row['city']));
                $updateData = array('state' => $state, 'city' => $city,'asc_name'=>$ascName);
                Db::getInstance()->update('service_center', $updateData, "id_service_center=" . $row['id_service_center']);
            }
        }
    }
}
