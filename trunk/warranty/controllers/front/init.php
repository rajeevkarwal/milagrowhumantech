<?php

class WarrantyInitModuleFrontController extends ModuleFrontController
{
    public $display_column_left = true;

    private $warranty;

    public function postProcess()
    {
        $this->warranty = new Warranty();
        if (Tools::getValue('product')) {
            $name = Tools::getValue('name');
            $email = Tools::getValue('email');
            $mobile = Tools::getValue('mobile');
            $city = Tools::getValue('city');
            $state = Tools::getValue('state');
            $product = Tools::getValue('product');
            $date = Tools::getValue('date');
            $storeName = Tools::getValue('storeName');
            $address1 = Tools::getValue('address1');
            $address2 = Tools::getValue('address2');
            $productNumber = Tools::getValue('productNumber');
            $productNumber = empty($productNumber) ? null : $productNumber;

            if (empty($name) || empty($email) || empty($mobile) || empty($product) || empty($city) || empty($state) ||
                empty($date) || empty($storeName) || empty($address1) || empty($address2)
            ) {
                echo json_encode(array('status' => false, 'message' => 'Please Fill the required fields'));
            }
            $currentTime = (new DateTime())->format('Y-m-d H:i:s');
            $insertData = array('name' => $name, 'email' => $email, 'mobile' => $mobile,
                'city' => $city, 'state' => $state, 'product' => $product, 'date' => $date, 'store_name' => $storeName,
                'product_number' => $productNumber, 'created_at' => $currentTime, 'updated_at' => $currentTime);
            //Mail if data inserted
            if (Db::getInstance()->insert('product_registration', $insertData)) {
                $customerEmailResult = $this->sendMailToCustomer($name, $email, $product, array('name' => $name));
                $adminEmailResult = $this->sendMailToAdmin('Admin', Configuration::get('PS_SHOP_EMAIL'), 'Dell Xps 15', array('name' => 'keshav'));

                if (!$customerEmailResult || !$adminEmailResult) {
                    echo json_encode(array('status' => false, 'message' => 'Sorry an error occured while sending mail'));
                    exit;
                }
                $url = Warranty::getShopDomainSsl(true, true);
                $values = array('fc' => 'module', 'module' => $this->warranty->name, 'controller' => 'success');
                $url .= '/index.php?' . http_build_query($values, '', '&');
                echo json_encode(array('status' => true, 'url' => $url));
            } else {
                echo json_encode(array('status' => false, 'message' => 'Sorry an error occured please try again..'));
            }
            exit;
        }
    }

    public function initContent()
    {
        parent::initContent();

        $products = $this->getProducts();
        $this->context->smarty->assign(array('products' => $products,
            'form_action' => Warranty::getShopDomainSsl(true, true) . '/index.php?fc=module&module=' . $this->warranty->name . '&controller=init',
            'jsSource' => $this->module->getPathUri() . 'warranty.js',
            'this_path' => $this->module->getPathUri()));

        $this->setTemplate('warranty.tpl');

    }

    private function getProducts()
    {
        $sql = "SELECT mg_product.id_product as id, mg_product_lang.name as name
                FROM " . _DB_PREFIX_ . "product JOIN " . _DB_PREFIX_ . "product_lang
                ON mg_product.id_product=mg_product_lang.id_product where mg_product.active=1;";
        if ($results = Db::getInstance()->ExecuteS($sql))
            return $results;
        return array();
    }


    private function sendMailToCustomer($customerName, $customerEmailId, $productName, $vars)
    {
        try {
            $res = Mail::Send(
                (int)1,
                'warranty_mail',
                Mail::l('Product Registration form', (int)1),
                $vars,
                $customerEmailId,
                $customerName,
                null,
                true,
                null,
                null,
                getcwd() . _MODULE_DIR_ . 'warranty/',
                false,
                null
            );

        } catch (Exception $e) {
            return false;
        }
        return $res;
    }


    private function sendMailToAdmin($adminName, $adminEmailId, $productName, $vars)
    {
        try {
            $res = Mail::Send(
                (int)1,
                'warranty_mail',
                Mail::l('Product Registration form', (int)1),
                $vars,
                $adminEmailId,
                $adminName,
                null,
                true,
                null,
                null,
                getcwd() . _MODULE_DIR_ . 'warranty/',
                false,
                null
            );

        } catch (Exception $e) {
            return false;
        }
        return $res;
    }

}