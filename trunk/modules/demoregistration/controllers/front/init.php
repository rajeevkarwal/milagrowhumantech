<?php

define('BOOK_DEMO_BEFORE_PAYMENT_CUSTOMER_CARE', 'customercare@milagrow.in');
define('BOOK_DEMO_BEFORE_PAYMENT_CS', 'cs@milagrow.in');
//define('BOOK_DEMO_BEFORE_PAYMENT_CUSTOMER_CARE', 'ptailor@greenapplesolutions.com');
//define('BOOK_DEMO_BEFORE_PAYMENT_CS', 'ptailor@greenapplesolutions.com');

class DemoRegistrationInitModuleFrontController extends ModuleFrontController
{
    public $display_column_left = true;
//    private $category = 13;
    private $price = 750;

//    private $productIdsForRoboticFloorCleaner = array(18, 21, 97, 98);
//    private $productIdsForRoboticWindowCleaner = array(40, 22);
////    private $productIdsForRoboticWindowCleaner = array(1, 22);


    public function postProcess()
    {
        if (Tools::getValue('demo')) {

            $name = Tools::getValue('name');
            $email = Tools::getValue('email');
            $mobile = Tools::getValue('mobile');
            $product = Tools::getValue('product');
            $city = Tools::getValue('city');
            $date = Tools::getValue('date');
            $time = Tools::getValue('time');
            $order_id = $this->GUID();
            $address = Tools::getValue('address');
            $zip = Tools::getValue('zip');
            $specialComment = Tools::getValue('special_comments');
			$o_city = Tools::getValue('other_city');
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

            $productDataSql = "Select amount,category_id,state from ". _DB_PREFIX_ ."demo_detail where product = '". $product ."' and city = '" . $city . "' ";
            $productData = Db::getInstance()->executeS($productDataSql);

            $price = $productData[0]['amount'];
            $state = $productData[0]['state'];

            /*if (empty($name) || empty($email) || empty($mobile) || empty($product) || empty($price) ||
                empty($date) || empty($time) || empty($order_id) || empty($address) || empty($zip)
            ) {
                echo json_encode(array('status' => false, 'message' => 'Please Fill the required fields'));
                exit;
            }*/

            $categorySql = "Select name from ". _DB_PREFIX_ ."category_lang where id_category = '". $productData[0]['category_id'] ."' ";
            $category = Db::getInstance()->executeS($categorySql);
            $categoryName = $category[0]['name'];

            $country = "India";
            $currentDate = new DateTime('now', new DateTimeZone('UTC'));
            $currentTime = $currentDate->format("Y-m-d H:i:s");
            $insertData = array('date' => $date ." " . $time, 'amount' => $price, 'order_id' => $order_id, 'name' => $name,
                'email' => $email, 'city' => $city, 'product' => $product, 'category' => $categoryName, 'mobile' => $mobile,
                'country' => $country, 'state' => $state, 'address' => $address, 'zip' => $zip, 'special_comments' => $specialComment,
                'created_at' => $currentTime, 'updated_at' => $currentTime,);

            if ( $city=="other") 
			{	//echo json_encode(array('status' => false, 'message' => 'You have selected other city..'));
			
					$insertData = array('date' => $date ." " . $time, 'amount' => $price, 'order_id' => $order_id, 'name' => $name,
                'email' => $email, 'city' => $o_city, 'product' => $product, 'category' => $categoryName, 'mobile' => $mobile,
                'country' => $country, 'state' => $state, 'address' => $address, 'zip' => $zip, 'special_comments' => $specialComment,
                'created_at' => $currentTime, 'updated_at' => $currentTime,);
					 if (Db::getInstance()->insert('demos', $insertData)) {
						$lastInsertedId=Db::getInstance()->Insert_ID();
						//$url = DemoRegistration::getShopDomainSsl(true, true);
						$values = array('order_id' => $order_id);
						//$url .= '/book-demo-payment?' . http_build_query($values, '', '&');
						$url = '/booked';
						
		
						//sending mail to admin regarding book a demo but payment not received
						$data = array('{id}'=>$lastInsertedId,'{date}' => $insertData['date'],
						   '{name}' => $insertData['name'], '{product}' => $insertData['product'],
							'{address}' => $insertData['address'], '{country}' => $insertData['country'],
							'{state}' => $insertData['state'], '{city}' => $insertData['city'], '{zip}' => $insertData['zip'],
							'{mobile}' => $insertData['mobile'], '{email}' => $insertData['email'],
							'{category}' => $insertData['category'], '{specialComments}' => $insertData['special_comments']);
		
						//$this->sendEmails($data);
						 
						//echo "insert successfully";
						//$send = Mail::Send($to,$subject,$message,$header);
					
						$protocol_content = (Configuration::get('PS_SSL_ENABLED')) ? 'https://' : 'http://';
						$link=$protocol_content.$_SERVER['HTTP_HOST'];
						$sub="Thank You For Demo Registration";
						$vars = array(
								'{name}' => $name, 
								'{email}' => $email,
								'{city}'=> $o_city,
								'{phone}'=> $mobile,
								'{product}'=> $product,
								'{address}'=> $address,
								'{zip}'=> $zip,
								'{date}'=> $date,
								'{comments}'=> $specialComment
						);
         			 	$id_lang = (int)Configuration::get('PS_LANG_DEFAULT');
						$send = Mail::Send($id_lang, 'booked',$sub, $vars, $email);
		
		
						//$successfully='<font color="green" size="2" class="green">Registration successfully.</font>';
						//$smarty->assign('inserted', $successfully);
						
						if($send)
						{	  $this->sendEmails($data);
							echo json_encode(array('status' => true, 'url' => $url));
						}
						else
						{
							$smarty->assign('mail', 'Email not sent');
						}
						
	
					
						 //$this->context->smarty->assign(array('confirmation' => 1));
						
						  //$this->context->smarty->assign(array('confirmation' => 1, 'alertMessage' => $alertMessage));
							
						//echo json_encode(array('status' => true,'message' => 'Your demo for other city have been booked'));
						
						} else {
						echo json_encode(array('status' => false, 'message' => 'Sorry an error occurred to insert demo for other city, please try again..'));
					}
					exit;
				
				} else {
                //echo json_encode(array('status' => false, 'message' => 'Sorry an error occurred please try again..'));
							 if (Db::getInstance()->insert('demos', $insertData)) {
						$lastInsertedId=Db::getInstance()->Insert_ID();
						$url = DemoRegistration::getShopDomainSsl(true, true);
						$values = array('order_id' => $order_id);
						$url .= '/book-demo-payment?' . http_build_query($values, '', '&');
		
						//sending mail to admin regarding book a demo but payment not received
						$data = array('{id}'=>$lastInsertedId,'{date}' => $insertData['date'],
						   '{name}' => $insertData['name'], '{product}' => $insertData['product'],
							'{address}' => $insertData['address'], '{country}' => $insertData['country'],
							'{state}' => $insertData['state'], '{city}' => $insertData['city'], '{zip}' => $insertData['zip'],
							'{mobile}' => $insertData['mobile'], '{email}' => $insertData['email'],
							'{category}' => $insertData['category'], '{specialComments}' => $insertData['special_comments']);
		
						//$this->sendEmails($data);
						//echo json_encode(array('status' => true, 'url' => $url));
						
								$protocol_content = (Configuration::get('PS_SSL_ENABLED')) ? 'https://' : 'http://';
						$link=$protocol_content.$_SERVER['HTTP_HOST'];
						$sub="Thank You For Demo Registration";
						$vars = array(
								'{name}' => $name, 
								'{email}' => $email,
								'{city}'=> $city,
								'{phone}'=> $mobile,
								'{product}'=> $product,
								'{address}'=> $address,
								'{zip}'=> $zip,
								'{date}'=> $date,
								'{comments}'=> $specialComment
						);
         			 	$id_lang = (int)Configuration::get('PS_LANG_DEFAULT');
						$send = Mail::Send($id_lang, 'booked',$sub, $vars, $email);
		
		
						//$successfully='<font color="green" size="2" class="green">Registration successfully.</font>';
						//$smarty->assign('inserted', $successfully);
						
						if($send)
						{	  $this->sendEmails($data);
							echo json_encode(array('status' => true, 'url' => $url));
						}
						else
						{
							$smarty->assign('mail', 'Email not sent');
						}
						
							
							} else {
								echo json_encode(array('status' => false, 'message' => 'Sorry an error occurred please try again..'));
							}
            		exit;
				
            }
            exit;
        }

    }

    public function initContent()
    {

        parent::initContent();
        $captchas = $this->getCaptcha();
        global $cookie;
        $captchaVariable = "demo_reg" . rand(1000000, PHP_INT_MAX);
        $cookie->{$captchaVariable} = null;
        $cookie->write(); // I think you'll need this as it doesn't automatically save
        $key = array_rand($captchas, 1);
        $cookie->{$captchaVariable} = $captchas[$key]['value'];
        $cookie->write(); // I think you'll need this as it doesn't automatically save

        $productsSql = 'Select DISTINCT product,name as category from ' . _DB_PREFIX_ . 'demo_detail
        JOIN '. _DB_PREFIX_ .'category_lang  ON  '. _DB_PREFIX_ .'category_lang.id_category =  ' . _DB_PREFIX_ . 'demo_detail.category_id';
        $products = Db::getInstance()->executeS($productsSql);

        $categorywiseProduct = array();

        $productsarr = array();$productarr = array();
        foreach($products as $pr){
            $productsdataSql = "Select city,amount,category_id from ". _DB_PREFIX_ ."demo_detail where product = '". $pr['product'] ."' ";
            $productsdata = Db::getInstance()->executeS($productsdataSql);

            $cities = array();
            $category ='';
            foreach($productsdata as $product){
                array_push($cities,$product['city']);
                $amount = $product['amount'];
            }

            $category = $pr['category'];
            if($category == $pr['category']){
                if(is_array($categorywiseProduct[$pr['category']])){
                    array_push($categorywiseProduct[$pr['category']],$pr['product']);
                }else{
                    $categorywiseProduct = $categorywiseProduct + array($pr['category'] => array($pr['product']));
                }
            }else{
                $categorywiseProduct = $categorywiseProduct + array($pr['category'] => array($pr['product']));
            }


            $productsarr = array_merge($productsarr,array('city' => $cities,'amount' => $amount));
            $productarr = array_merge($productarr,array($pr['product'] => $productsarr));
            $productdataarr = json_encode($productarr);
        }

        $productshtml ='';
        $productshtml .= '<select name="product" id="product">';
        $productshtml .= '<option value="select">Select Product</option>';
        foreach($categorywiseProduct as $key1 => $cproduct){
            $productshtml .= '<OPTGROUP LABEL="' . $key1 .'">';
            for($i=0;$i<count($cproduct);$i++){
                $productshtml .= '<option value="'. $cproduct[$i] .'">'. $cproduct[$i] .'</option>';
            }
            $productshtml .= '</OPTGROUP>';
        }
        $productshtml .=  '</select>';
//        echo "<pre>";print_r($categorywiseProduct);echo "</pre>";exit;

        $this->context->smarty->assign(array(
            'form_action' => DemoRegistration::getShopDomainSsl(true, true) . '/index.php?fc=module&module=' . DemoRegistration::MODULE_NAME . '&controller=init',
            'jsSource' => $this->module->getPathUri(), 'price' => $this->price,
            'productdata' => $productdataarr,
//            'selectedProduct' => $selectedProduct,
            'products' => $productshtml,
            'captchaName' => $captchaVariable,
            'captchaText' => $captchas[$key]['key'],
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
//    private function getProducts()
//    {
//        $sql = "SELECT * from " . _DB_PREFIX_ . "product_lang where id_product in ('" . implode('\',\'', array_merge($this->productIdsForRoboticFloorCleaner, $this->productIdsForRoboticWindowCleaner)) . "')";
//        if ($results = Db::getInstance()->ExecuteS($sql))
//            return $results;
//        return array();
//    }

    private function GUID()
    {

        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X%04X%04X%04X%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));

    }

//    private function getCategoryNameForGivenProduct($id_product)
//    {
//        if (in_array($id_product, $this->productIdsForRoboticFloorCleaner))
//            return 'Robotic Floor Cleaners';
//        else
//            return 'Window Floor Cleaners';
//    }
    private function getCaptcha()
    {
        return array(array('key' => "2 + 2 = ?", 'value' => 4), array('key' => "2 + 7 = ?", 'value' => 9),
            array('key' => "7 - 2 = ?", 'value' => 5), array('key' => "5 - 4 = ?", 'value' => 1),
            array('key' => "2 * 2 = ?", 'value' => 4), array('key' => "3 * 4 = ?", 'value' => 12),
            array('key' => "4 + 3 = ?", 'value' => 7), array('key' => "9 + 7 = ? ", 'value' => 16));
    }

    private
    function sendEmails($data)
    {

        try {
            $adminTemplate = 'admin_mail_before_payment';
//            if (_PS_ENVIRONMENTS) {

                //sending email to receivable
                $cs_Email = BOOK_DEMO_BEFORE_PAYMENT_CS;
//                $cs_Email ='ptailor@greenapplesolutions.com';
                if (!empty($cs_Email)) {
                    $res = Mail::Send(
                        (int)1,
                        $adminTemplate,
                        Mail::l("Pre Sales Demo (Payment not received) - #" . $data['{id}'] ." - ". $data['{product}'] ." - ". $data['{city}'] ." - ". $data['{name}'] , (int)1),
                        $data,
                        $cs_Email,
                        'Administrator',
                        null,
                        null,
                        null,
                        null,
                        getcwd() . _MODULE_DIR_ . DemoRegistration::MODULE_NAME . '/',
                        false,
                        null
                    );
                }

                $customerCareEmail = BOOK_DEMO_BEFORE_PAYMENT_CUSTOMER_CARE;
//            $customerCareEmail = 'ptailor@greenapplesolutions.com';
                // Sending mail to customer care
                $res = Mail::Send(
                    (int)1,
                    $adminTemplate,
                    Mail::l("Pre Sales Demo (Payment not received) - #" . $data['{id}'] ." - ". $data['{product}'] ." - ". $data['{city}'] ." - ". $data['{name}'] , (int)1),
                    $data,
                    $customerCareEmail,
                    'Administrator',
                    null,
                    null,
                    null,
                    null,
                    getcwd() . _MODULE_DIR_ . DemoRegistration::MODULE_NAME . '/',
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
