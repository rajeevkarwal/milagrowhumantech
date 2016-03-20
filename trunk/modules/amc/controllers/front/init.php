<?php
define('AMC_BEFORE_PAYMENT_CUSTOMER_CARE', 'customercare@milagrow.in');
define('AMC_BEFORE_PAYMENT_CS', 'cs@milagrow.in');
//define('AMC_BEFORE_PAYMENT_CUSTOMER_CARE', 'hitanshumalhotra@gmail.com');
//define('AMC_BEFORE_PAYMENT_CS', 'hitanshumalhotra@gmail.com');

class AMCInitModuleFrontController extends ModuleFrontController
{
    public $display_column_left = true;
//    private $category = 13;
    private $price = 750;

//    private $productIdsForRoboticFloorCleaner = array(18, 21, 97, 98);
//    private $productIdsForRoboticWindowCleaner = array(40, 22);
////    private $productIdsForRoboticWindowCleaner = array(1, 22);


    public function postProcess()
    {
        if (Tools::isSubmit('submit')) {
//            echo "<pre>";print_r($_POST);echo "</pre>";echo "<pre>";print_r($_FILES);echo "</pre>";exit;
            $fileAttachment = null;
            if (isset($_FILES['fileUpload']['name']) && !empty($_FILES['fileUpload']['name']) && !empty($_FILES['fileUpload']['tmp_name'])) {

                $extension = array('.rtf', '.doc', '.docx', '.pdf', '.jpeg', '.png', '.jpg');
                $filename = uniqid() . substr($_FILES['fileUpload']['name'], -5);
                $fileAttachment['content'] = file_get_contents($_FILES['fileUpload']['tmp_name']);
                $fileAttachment['name'] = $_FILES['fileUpload']['name'];
                $fileAttachment['mime'] = $_FILES['fileUpload']['type'];
            }

            if (!($name = trim(Tools::getValue('name'))))
                $this->errors[] = Tools::displayError('Name is Required');
            if (!($cost = trim(Tools::getValue('cost'))))
                $this->errors[] = Tools::displayError('cost is Required');
            if (!($email = trim(Tools::getValue('email'))))
                $this->errors[] = Tools::displayError('Email is Required');
            if (!($mobile = trim(Tools::getValue('mobile'))))
                $this->errors[] = Tools::displayError('Mobile is Required');
            if (!($product = trim(Tools::getValue('product'))))
                $this->errors[] = Tools::displayError('Product is required');
            if (!($period = trim(Tools::getValue('period'))))
                $this->errors[] = Tools::displayError('Period is required');
            if (!($state = trim(Tools::getValue('state'))))
                $this->errors[] = Tools::displayError('State is Required');
            if (!($city = trim(Tools::getValue('city'))))
                $this->errors[] = Tools::displayError('City is Required');
            if (!($date = trim(Tools::getValue('date'))))
                $this->errors[] = Tools::displayError('Date is Required');
            $order_id = $this->GUID();
            if (!($address = trim(Tools::getValue('address'))))
                $this->errors[] = Tools::displayError('Address is Required');
            if (!($pincode = trim(Tools::getValue('pincode'))))
                $this->errors[] = Tools::displayError('Pincode is Required');
            if (!($specialComment = trim(Tools::getValue('special_comments'))))
                $this->errors[] = Tools::displayError('Special comments is Required');
            if (empty($_FILES['fileUpload']['name']))
                $this->errors[] = Tools::displayError('Please upload purchase invoice');
            if (!empty($_FILES['fileUpload']['name']) && $_FILES['fileUpload']['error'] != 0)
                $this->errors[] = Tools::displayError('An error occurred during the uploading process.');
            if (!empty($_FILES['fileUpload']['name']) && !in_array(substr(Tools::strtolower($_FILES['fileUpload']['name']), -4), $extension) && !in_array(substr(Tools::strtolower($_FILES['fileUpload']['name']), -5), $extension))
                $this->errors[] = Tools::displayError('Bad file extension');
            if (!($captcha = trim(Tools::getValue('captcha'))))
                $this->errors[] = Tools::displayError('Captcha is Required');
            if (!($captchaName = trim(Tools::getValue('captchaName'))))
                $this->errors[] = Tools::displayError('Invalid Captcha Name');

//            if (!($captcha = trim(Tools::getValue('captcha')))) {
//                $this->errors[] = Tools::displayError('Captcha Required');
//            }
            if (trim(Tools::getValue('captcha')) && $this->context->cookie->{$captchaName} != trim(Tools::getValue('captcha'))) {
                $this->errors[] = Tools::displayError('Invalid Captcha');
            }

            if (count($this->errors) == 0) {
                $amcProductDataSql = "Select categoryID,productID from " . _DB_PREFIX_ . "damc_products where productID = '" . $product . "' ";
                $amcProductData = Db::getInstance()->executeS($amcProductDataSql);
                $category = $amcProductData[0]['categoryID'];

//            empty($country) ||

                $categorySql = "Select name from " . _DB_PREFIX_ . "category_lang where id_category = '" . $category . "' ";
                $categoryData = Db::getInstance()->executeS($categorySql);
                $categoryName = $categoryData[0]['name'];

                $productSql = "select name from " . _DB_PREFIX_ . "product_lang where id_product = " . $amcProductData[0]['productID'] . "";
                $productData = Db::getInstance()->executeS($productSql);
                $productName = $productData[0]['name'];

                $country = "India";
                $currentDate = new DateTime('now', new DateTimeZone('UTC'));
                $currentTime = $currentDate->format("Y-m-d H:i:s");

                if (isset($filename) && rename($_FILES['fileUpload']['tmp_name'], _PS_MODULE_DIR_ . '../upload/amc/' . $filename)) {
                    $file_name = $filename;
                }

                $insertData = array('purchase_date' => $date, 'amount' => $cost,'period'=>$period, 'order_id' => $order_id, 'name' => $name,
                    'email' => $email, 'city' => $city, 'product' => $product, 'category' => $category, 'mobile' => $mobile,
                    'country' => $country, 'state' => $state, 'address' => $address, 'zip' => $pincode, 'special_comments' => $specialComment,
                    'attached_invoice' => $file_name, 'created_at' => $currentTime, 'updated_at' => $currentTime);

                if (Db::getInstance()->insert('amc', $insertData)) {
                    $lastInsertedId = Db::getInstance()->Insert_ID();
                    $url = amc::getShopDomainSsl(true, true);
                    $values = array('order_id' => $order_id);
                    $url .= '/annual-maintenance-contract-payment?' . http_build_query($values, '', '&');

                    //sending mail to admin regarding book a demo but payment not received
                    $data = array('{id}' => $lastInsertedId, '{date}' => $insertData['purchase_date'],
                        '{name}' => $insertData['name'], '{product}' => $productName,
                        '{address}' => $insertData['address'], '{country}' => $insertData['country'],
                        '{state}' => $insertData['state'], '{city}' => $insertData['city'], '{zip}' => $insertData['zip'],
                        '{mobile}' => $insertData['mobile'], '{email}' => $insertData['email'],
                        '{category}' => $categoryName, '{specialComments}' => $insertData['special_comments'],'{cost}'=>$insertData['amount'],'{period}'=>$insertData['period']);

                    $this->sendEmails($data, $fileAttachment);
//                    echo json_encode(array('status' => true, 'url' => $url));
                    Tools::redirect($url);
                } else {
//                    echo json_encode(array('status' => false, 'message' => 'Sorry an error occurred please try again..'));
                    $this->errors[] = Tools::displayError('An error occurred while sending the message.');
                }
//                exit;
            }
//            else {
//                $this->errors[] = Tools::displayError('An error occurred while sending the message.');
//            }
//            exit;
        }

    }

    public function initContent()
    {/*
        parent::initContent();
        $captchas = $this->getCaptcha();
        global $cookie;
        $captchaVariable = "demo_reg" . rand(1000000, PHP_INT_MAX);

        $cookie->{$captchaVariable} = null;
        $cookie->write(); // I think you'll need this as it doesn't automatically save
        $key = array_rand($captchas, 1);
        $cookie->{$captchaVariable} = $captchas[$key]['value'];
        $cookie->write(); // I think you'll need this as it doesn't automatically save

        $productsSql = 'Select ' . _DB_PREFIX_ . 'product_lang.name as product,' . _DB_PREFIX_ . 'category_lang.name as category,' . _DB_PREFIX_ . 'amc_products.product_id as product_id,duration,maintenance_cost from ' . _DB_PREFIX_ . 'amc_products JOIN ' . _DB_PREFIX_ . 'category_lang ON ' . _DB_PREFIX_ . 'category_lang.id_category = ' . _DB_PREFIX_ . 'amc_products.category_id JOIN ' . _DB_PREFIX_ . 'product_lang ON ' . _DB_PREFIX_ . 'product_lang.id_product = ' . _DB_PREFIX_ . 'amc_products.product_id';
        $products = Db::getInstance()->executeS($productsSql);

        $categorywiseProduct = array();
        $productsarr = array();
        $productarr = array();

        foreach ($products as $pr) {
            $amount = $pr['maintenance_cost'];
            $duration = $pr['duration'];

            $category = $pr['category'];
            if ($category == $pr['category']) {
                if (is_array($categorywiseProduct[$pr['category']])) {
                    $categorywiseProduct[$pr['category']][$pr['product_id']] = $pr['product'];
                } else {
                    $categorywiseProduct = $categorywiseProduct + array($pr['category'] => array($pr['product_id'] => $pr['product']));
                }
            } else {
                $categorywiseProduct = $categorywiseProduct + array($pr['category'] => array($pr['product_id'] => $pr['product']));
            }
            $productsarr = array_merge($productsarr, array('amount' => $amount, 'duration' => $duration));
            $productarr = array_merge($productarr, array($pr['product'] => $productsarr));
            $productdataarr = json_encode($productarr);
        }

        $productshtml = '';
        $productshtml .= '<select name="product" id="product" >';
        $productshtml .= '<option value="select">Select Product</option>';
        foreach ($categorywiseProduct as $key1 => $cproduct) {
            $productshtml .= '<OPTGROUP LABEL="' . $key1 . '">';
            foreach ($cproduct as $key2 => $product) {
                $productshtml .= '<option value="' . $key2 . '">' . $cproduct[$key2] . '</option>';
            }
            $productshtml .= '</OPTGROUP>';
        }
        $productshtml .= '</select>';

//        echo "<pre>";print_r($productarr);echo "</pre>";

        $product = trim(Tools::getValue('product'));
        if(empty($product)){
            $product = 'No product';
        }*/
        parent::initContent();
        $captchas = $this->getCaptcha();
        global $cookie;
        $captchaVariable = "demo_reg" . rand(1000000, PHP_INT_MAX);

        $cookie->{$captchaVariable} = null;
        $cookie->write(); // I think you'll need this as it doesn't automatically save
        $key = array_rand($captchas, 1);
        $cookie->{$captchaVariable} = $captchas[$key]['value'];
        $cookie->write(); // I think you'll need this as it doesn't automatically save

        $amcProductsSql = 'SELECT p.id as damcid,p.warranty as warranty,p.productID as productid, pa.name AS category_name, pd.name AS prod_name FROM ps_product_lang as pd join ps_damc_products as p on p.productID = pd.id_product join ps_product as pc on p.productID=pc.id_product join ps_category_lang as pa on p.categoryID = pa.id_category WHERE pc.active=1 and is_amc_active = 1 and is_del = 0 order by category_name';
//		 $sql= 'SELECT DISTINCT p.productID as productid, pa.name AS category_name ,pc.price AS price , pd.name AS prod_name FROM ps_product_lang as pd join ps_damc_products as p on p.productID = pd.id_product join ps_product as pc on p.productID=pc.id_product join ps_category_lang as pa on p.categoryID = pa.id_category WHERE 	is_amc_active = 1 and is_del = 0 order by category_name';

        $cat_name = '';

        $productshtml = '';
        $productshtml .= '<select name="product" id="product" onchange="getPeriodList()" >';
        $productshtml .= '<option value="select">Select Product</option>';
        $productWiseAmountArr=array();
        $prodwiseWarranty=array();
        if ($query = Db::getInstance()->executeS($amcProductsSql))
        {

            foreach ($query as $row) {

                $prodwiseWarranty[$row['productid']]=$row['warranty'];

                if ($cat_name != $row['category_name']) {
                    if ($cat_name != '') {
                        $productshtml .= '</optgroup>';
                    }
                    $productshtml .= '<OPTGROUP LABEL="' . $row['category_name'] . '">';
                }
                $productshtml .= '<option value="' . $row['productid'] . '">' . $row['prod_name'] . '</option>';
                $cat_name = $row['category_name'];

                //fetch the amount and period
                $productId=$row['productid'];
                //fetch product price
                $productAMT=Product::getPriceStatic((int)$productId, true,null,6,null,false,false);
//                echo $productAMT;
                $periodFetchSql="select * from ps_damc_products_period where damc_id={$row['damcid']}";
                if($results=Db::getInstance()->executeS($periodFetchSql))
                {
                    foreach($results as $periodRow)
                    {
                        $maintenanceCost = ceil(($periodRow['amc_percentage'] * $productAMT) / 100);
                        $productWiseAmountArr[$productId][] = array('product_period' => $periodRow['period'], 'product_amount' => $maintenanceCost,'actual_price'=>$productAMT);
                    }

                }

            }
            if ($cat_name != '') {
                $productshtml .= '</OPTGROUP>';
            }
        }

        $productshtml .= '</select>';

        $product = trim(Tools::getValue('product'));
        if(empty($product)){
            $product = 'No product';
        }


        $pidWarrantyList = json_encode($prodwiseWarranty);

        $this->context->smarty->assign(array(
            'ajaxurl' => _MODULE_DIR_,
            'errors' => $this->errors,
            'form_action' => amc::getShopDomainSsl(true, true) . '/index.php?fc=module&module=' . amc::MODULE_NAME . '&controller=init',
            'jsSource' => $this->module->getPathUri(), 'price' => $this->price,
            'states' => $this->getStates(),
//            'productdata' => $productdataarr,
            'selectedProduct' => $product,
            'products' => $productshtml,
            'captchaName' => $captchaVariable,
            'captchaText' => $captchas[$key]['key'],
            'this_path' => $this->module->getPathUri(),
            'name' => trim(Tools::getValue('name')),
            'email' => trim(Tools::getValue('email')),
            'mobile' => trim(Tools::getValue('mobile')),
            'cost' => trim(Tools::getValue('cost')),
            'period' => trim(Tools::getValue('period')),
            'product' => $product,
            'pincode' => trim(Tools::getValue('pincode')),
            'mobile' => trim(Tools::getValue('mobile')),
            'address' => trim(Tools::getValue('address')),
            'date' => trim(Tools::getValue('date')),
            'special_comments' => trim(Tools::getValue('special_comments')),
            'prodwiseamt' => json_encode($productWiseAmountArr),
            'pidWarrantyList' => $pidWarrantyList
        ));

        $this->setTemplate('amc.tpl');
    }

    private function GUID()
    {

        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X%04X%04X%04X%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));

    }

    private function getCaptcha()
    {
        return array(array('key' => "2 + 2 = ?", 'value' => 4), array('key' => "2 + 7 = ?", 'value' => 9),
            array('key' => "7 - 2 = ?", 'value' => 5), array('key' => "5 - 4 = ?", 'value' => 1),
            array('key' => "2 * 2 = ?", 'value' => 4), array('key' => "3 * 4 = ?", 'value' => 12),
            array('key' => "4 + 3 = ?", 'value' => 7), array('key' => "9 + 7 = ? ", 'value' => 16));
    }

    private function getStates()
    {
        return State::getStatesByIdCountry(110);
    }

    private function sendEmails($data, $fileAttachment)
    {

        try {
            $adminTemplate = 'admin_mail_before_payment';
//            if (_PS_ENVIRONMENTS) {

            //sending email to receivable
            $cs_Email = AMC_BEFORE_PAYMENT_CUSTOMER_CARE;
//                $cs_Email ='ptailor@greenapplesolutions.com';
            if (!empty($cs_Email)) {
                $res = Mail::Send(
                    (int)1,
                    $adminTemplate,
                    Mail::l("Annual Maintenance Contract (Payment not received) - #" . $data['{id}'] . " - " . $data['{product}'] . " - " . $data['{city}'] . " - " . $data['{name}'], (int)1),
                    $data,
                    $cs_Email,
                    'Administrator',
                    null,
                    null,
                    $fileAttachment,
                    null,
                    getcwd() . _MODULE_DIR_ . AMC::MODULE_NAME . '/',
                    false,
                    null
                );
            }

            $customerCareEmail = AMC_BEFORE_PAYMENT_CUSTOMER_CARE;
//            $customerCareEmail = 'ptailor@greenapplesolutions.com';
            // Sending mail to customer care
            $res = Mail::Send(
                (int)1,
                $adminTemplate,
                Mail::l("Annual Maintenance Contract (Payment not received) - #" . $data['{id}'] . " - " . $data['{product}'] . " - " . $data['{city}'] . " - " . $data['{name}'], (int)1),
                $data,
                $customerCareEmail,
                'Administrator',
                null,
                null,
                $fileAttachment,
                null,
                getcwd() . _MODULE_DIR_ . AMC::MODULE_NAME . '/',
                false,
                null
            );

//            } else {
//                $res = Mail::Send(
//                    (int)1,
//                    $adminTemplate,
//                    Mail::l($data['{name}'] . " - Pre Sales Demo (Payment not received)", (int)1),
//                    $data,
//                    'hmalhotra@greenapplesolutions.com',
//                    'Administrator',
//                    null,
//                    null,
//                    null,
//                    null,
//                    getcwd() . _MODULE_DIR_ . DemoRegistration::MODULE_NAME . '/',
//                    false,
//                    null
//                );
//            }
        } catch
        (Exception $e) {

        }


    }

}
