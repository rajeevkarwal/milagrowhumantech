<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hitanshu
 * Date: 7/10/13
 * Time: 10:32 AM
 * To change this template use File | Settings | File Templates.
 */

class ServiceCenterDetailModuleFrontController extends ModuleFrontController
{

    public function initContent()
    {

        parent::initContent();

        $id = Tools::getValue('id');
        $serviceCenterDetail = $this->getServiceCenterDetail($id);
        $this->context->smarty->assign(array(
            'serviceCenterDetail' => $serviceCenterDetail,
        ));

        $this->setTemplate('servicecenter-detail.tpl');
    }

    private function getServiceCenterDetail($id)
    {
        $sql = 'select * from ' . _DB_PREFIX_ . 'service_center where id_service_center=' . $id;
        if ($results = Db::getInstance()->getRow($sql)) {
            return $results;
        }
        return false;
    }
}