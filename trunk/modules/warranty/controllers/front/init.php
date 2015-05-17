<?php

class WarrantyInitModuleFrontController extends ModuleFrontController
{
    public $display_column_left = true;


    public function postProcess()
    {

        if (Tools::getValue('product')) {

            $name = Tools::getValue('name');
            $email = Tools::getValue('email');
            $mobile = Tools::getValue('mobile');
            $city = Tools::getValue('city');
            $city = empty($city) ? '-' : $city;
            $state = Tools::getValue('state');
            $state = empty($state) ? '-' : $state;
            $productId = Tools::getValue('product');
            $date = Tools::getValue('date');
            $storeName = Tools::getValue('storeName');
            $address = Tools::getValue('address');
            $address = empty($address) ? '-' : $address;
            $productNumber = Tools::getValue('productNumber');
            if (!($captchaName = trim(Tools::getValue('captchaName')))) {
                echo json_encode(array('status' => false, 'message' => 'Invalid captcha name'));
                exit;
            }

            if (!($captcha = trim(Tools::getValue('captcha')))) {
                echo json_encode(array('status' => false, 'message' => 'Captcha Required'));
                exit;
            }
            if (trim(Tools::getValue('captcha')) && $this->context->cookie->{$captchaName} != trim(Tools::getValue('captcha'))) {
                echo json_encode(array('status' => false, 'message' => 'Invalid Captcha'));
                exit;

            }


            if (empty($name) || empty($email) || empty($mobile) || empty($productId) ||
                empty($date) || empty($storeName) || empty($productNumber)
            ) {
                echo json_encode(array('status' => false, 'message' => 'Please Fill the required fields'));
                exit;
            }
            $productName = $this->getProductName($productId);
            $currentDate = new DateTime('now', new DateTimeZone('UTC'));
            $currentTime = $currentDate->format("Y-m-d H:i:s");
            $insertData = array('name' => $name, 'email' => $email, 'mobile' => $mobile,
                'city' => $city, 'state' => $state, 'product' => $productId, 'date' => $date, 'store_name' => $storeName,
                'product_number' => $productNumber, 'address' => $address, 'created_at' => $currentTime, 'updated_at' => $currentTime);
            //Mail if data inserted
            if (Db::getInstance()->insert('product_registration', $insertData)) {
                $eamilSubject = "$productName, $productNumber, $name";
                $customerEmailResult = $this->sendMailToCustomer($name, $email, array('{name}' => $name, '{product}' => $productName));
                $adminEmailResult = $this->sendMailToAdmin('Administrator', Configuration::get('PS_SHOP_EMAIL'), array('{name}' => $name, '{email}' => $email,
                    '{mobile}' => $mobile, '{city}' => $city, '{state}' => $state, '{product}' => $productName,
                    '{date}' => date("d-m-Y", strtotime($date)), '{storeName}' => $storeName, '{productNumber}' => $productNumber, '{address}' => $address), $eamilSubject);
                $url = Warranty::getShopDomainSsl(true, true);
                $url .= '/product-warranty-registration-success';
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
        $captchas = $this->getCaptcha();
        global $cookie;
        $captchaVariable = "warranty" . rand(1000000, PHP_INT_MAX);
        $cookie->{$captchaVariable} = null;
        $cookie->write(); // I think you'll need this as it doesn't automatically save
        $key = array_rand($captchas, 1);
        $cookie->{$captchaVariable} = $captchas[$key]['value'];
        $cookie->write(); // I think you'll need this as it doesn't automatically save
        $products = $this->getProducts();
        $this->context->smarty->assign(array('products' => $products,
            'form_action' => Warranty::getShopDomainSsl(true, true) . '/index.php?fc=module&module=' . Warranty::MODULE_NAME . '&controller=init',
            'jsSource' => $this->module->getPathUri(),
            'captchaText' => $captchas[$key]['key'],
            'captchaName' => $captchaVariable,
            'states' => $this->getStates(),
            'this_path' => $this->module->getPathUri()));

        $this->setTemplate('warranty1.tpl');

    }

    private function getProducts()
    {
        $sql = "SELECT " . _DB_PREFIX_ . "product.id_product as id, " . _DB_PREFIX_ . "product_lang.name as name
                FROM " . _DB_PREFIX_ . "product JOIN " . _DB_PREFIX_ . "product_lang
                ON " . _DB_PREFIX_ . "product.id_product=" . _DB_PREFIX_ . "product_lang.id_product where " . _DB_PREFIX_ . "product.active=1;";
        if ($results = Db::getInstance()->ExecuteS($sql))
            return $results;
        return array();
    }


    private function sendMailToCustomer($customerName, $customerEmailId, $vars)
    {
        try {
            $res = Mail::Send(
                (int)1,
                'warranty_mail',
                Mail::l('Product Registration', (int)1),
                $vars,
                $customerEmailId,
                null,
                strval(Configuration::get('PS_SHOP_EMAIL')),
                strval(Configuration::get('PS_SHOP_NAME')),
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


    private function sendMailToAdmin($adminName, $adminEmailId, $vars, $subject)
    {
        try {
            $res = Mail::Send(
                (int)1,
                'warranty_admin_mail',
                Mail::l("$subject - Product Registration Form", (int)1),
                $vars,
                $adminEmailId,
                $adminName,
                strval(Configuration::get('PS_SHOP_EMAIL')),
                strval(Configuration::get('PS_SHOP_NAME')),
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

    private function getProductName($productId)
    {
        $sql = "SELECT name from " . _DB_PREFIX_ . "product_lang where id_product=" . $productId;
        if ($results = Db::getInstance()->getRow($sql))
            return $results['name'];
        return "OTHER";
    }

    private function getStates()
    {
        return State::getStatesByIdCountry(110);
    }

    private function getCaptcha()
    {
        return array(array('key' => "2 + 2 = ?", 'value' => 4), array('key' => "2 + 7 = ?", 'value' => 9),
            array('key' => "7 - 2 = ?", 'value' => 5), array('key' => "5 - 4 = ?", 'value' => 1),
            array('key' => "2 * 2 = ?", 'value' => 4), array('key' => "3 * 4 = ?", 'value' => 12),
            array('key' => "4 + 3 = ?", 'value' => 7), array('key' => "9 + 7 = ? ", 'value' => 16));
    }


}