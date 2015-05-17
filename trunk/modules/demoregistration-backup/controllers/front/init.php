<?php

class DemoRegistrationInitModuleFrontController extends ModuleFrontController
{
    public $display_column_left = true;
    private $category = 13;
    private $price = 750;
    private $productIdsForRoboticFloorCleaner = array(18, 21, 97, 98);
    private $productIdsForRoboticWindowCleaner = array(40, 22);
//    private $productIdsForRoboticWindowCleaner = array(1, 22);


    public function postProcess()
    {
        if (Tools::getValue('demo')) {

            $name = Tools::getValue('name');
            $email = Tools::getValue('email');
            $mobile = Tools::getValue('mobile');
            $product = Tools::getValue('product');
            $city = Tools::getValue('city');
            $date = Tools::getValue('dateTime');
            $price = $this->price;
            $order_id = $this->GUID();
            $address = Tools::getValue('address');
            $zip = Tools::getValue('zip');
            $specialComment = Tools::getValue('special_comments');

            if (empty($name) || empty($email) || empty($mobile) || empty($product) || empty($city) || empty($price) ||
                empty($date) || empty($order_id) || empty($address) || empty($zip)
            ) {
                echo json_encode(array('status' => false, 'message' => 'Please Fill the required fields'));
                exit;
            }
            $state = "";

            if ($city == "Banglore") {
                $state = "Karnataka";
            } else if ($city == "Chennai") {
                $state = "Tamil Nadu";
            } else {
                $state = "Delhi";
            }

            $category = $this->getCategoryNameForGivenProduct($product);
            $country = "India";
            $currentDate = new DateTime('now', new DateTimeZone('UTC'));
            $currentTime = $currentDate->format("Y-m-d H:i:s");
            $insertData = array('date' => $date, 'amount' => $price, 'order_id' => $order_id, 'name' => $name,
                'email' => $email, 'city' => $city, 'product' => $product, 'category' => $category, 'mobile' => $mobile,
                'country' => $country, 'state' => $state, 'address' => $address, 'zip' => $zip, 'special_comments' => $specialComment,
                'created_at' => $currentTime, 'updated_at' => $currentTime,);

            if (Db::getInstance()->insert('demos', $insertData)) {

                $url = DemoRegistration::getShopDomainSsl(true, true);
                $values = array('fc' => 'module', 'module' => DemoRegistration::MODULE_NAME, 'controller' => 'payment', 'order_id' => $order_id);
                $url .= '/index.php?' . http_build_query($values, '', '&');
                echo json_encode(array('status' => true, 'url' => $url));
            } else {
                echo json_encode(array('status' => false, 'message' => 'Sorry an error occurred please try again..'));
            }
            exit;
        }

    }

    public function initContent()
    {
        parent::initContent();

        $products = $this->getProducts();
        $categoryWiseProduct = array();
        foreach ($products as $product) {
            if (in_array($product['id_product'], $this->productIdsForRoboticFloorCleaner)) {
                $categoryWiseProduct['Robotic Floor Cleaners'][] = $product;
            } else if (in_array($product['id_product'], $this->productIdsForRoboticWindowCleaner)) {
                $categoryWiseProduct['Robotic Window Cleaners'][] = $product;
            }
        }
        $this->context->smarty->assign(array(
            'form_action' => DemoRegistration::getShopDomainSsl(true, true) . '/index.php?fc=module&module=' . DemoRegistration::MODULE_NAME . '&controller=init',
            'jsSource' => $this->module->getPathUri(), 'price' => $this->price,
            'products' => $categoryWiseProduct,
            'this_path' => $this->module->getPathUri()));

        $this->setTemplate('demoregistration.tpl');

    }

//    private function getProducts()
//    {
//        $sql = "SELECT " . _DB_PREFIX_ . "product_lang.id_product as id, " . _DB_PREFIX_ . "product_lang.name as name
//                FROM " . _DB_PREFIX_ . "category_product JOIN " . _DB_PREFIX_ . "product_lang
//                ON " . _DB_PREFIX_ . "product_lang.id_product=" . _DB_PREFIX_ . "category_product.id_product where " . _DB_PREFIX_ . "category_product.id_category=" . $this->category . ";";
//        if ($results = Db::getInstance()->ExecuteS($sql))
//            return $results;
//        return array();
//    }


    //getting products for window cleaner and
    private function getProducts()
    {
        $sql = "SELECT * from " . _DB_PREFIX_ . "product_lang where id_product in ('" . implode('\',\'', array_merge($this->productIdsForRoboticFloorCleaner, $this->productIdsForRoboticWindowCleaner)) . "')";
        if ($results = Db::getInstance()->ExecuteS($sql))
            return $results;
        return array();
    }

    private function GUID()
    {

        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X%04X%04X%04X%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));

    }

    private function getCategoryNameForGivenProduct($id_product)
    {
        if (in_array($id_product, $this->productIdsForRoboticFloorCleaner))
            return 'Robotic Floor Cleaners';
        else
            return 'Window Floor Cleaners';
    }

}