<?php
session_start();
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


            /*
             * New parameters added
             */
            $demoMode = Tools::getValue('demoMode');
            $demoType = Tools::getValue('demo_type');


            if($demoType==0 && $city!='other')
            {
                echo json_encode(array('status' => false, 'message' => 'Parameters mismatch!!'));
                exit;
            }

            if($demoType=='3' && empty($demoMode))
            {
                echo json_encode(array('status' => false, 'message' => 'Parameters mismatch!!'));
                exit;
            }

            $paidDemo=true;

            $demoText='Home Demo';
            if($demoType==2)
            {
                $demoText='Skype Demo';
                $paidDemo=false;
            }

            if($city=='other')
            {
                $demoText='Demo for other city';
                $paidDemo=false;
            }

            if($demoType==3 && $demoMode=='1')
            {
                $paidDemo=false;
                $demoText='Skype Demo';
            }




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

            if (trim(Tools::getValue('captcha')) && $_SESSION[$captchaName] != trim(Tools::getValue('captcha'))) {
                echo json_encode(array('status' => false, 'message' => 'Invalid Captcha'));
                exit;
            }

            /*
             * fetching the demo price and state from the demo products cities table
             */

            $productsdataSql = "Select productId,categoryId,statename,amount,demoText from ". _DB_PREFIX_ ."demo_products dp join "._DB_PREFIX_."demo_products_cities dpc on dp.id=dpc.demo_id where id=$product and cityname='$city' and demoType=$demoType";
            //echo $productsdataSql;
            $productData = Db::getInstance()->executeS($productsdataSql);

            //echo '<pre>';
            //print_r($_REQUEST);
            //print_r($productData);
            $price = $productData[0]['amount'];
            $state = $productData[0]['statename'];

            /*if (empty($name) || empty($email) || empty($mobile) || empty($product) || empty($price) ||
                empty($date) || empty($time) || empty($order_id) || empty($address) || empty($zip)
            ) {
                echo json_encode(array('status' => false, 'message' => 'Please Fill the required fields'));
                exit;
            }*/

            $categorySql = "Select name from ". _DB_PREFIX_ ."category_lang where id_category = '". $productData[0]['categoryId'] ."' ";
            $category = Db::getInstance()->executeS($categorySql);
            $categoryName = $category[0]['name'];

            $productSql = "Select name from ". _DB_PREFIX_ ."product_lang where id_product = '". $productData[0]['productId'] ."' ";
            $productRes = Db::getInstance()->executeS($productSql);
            $productName = $productRes[0]['name'];

            $country = "India";
            $currentDate = new DateTime('now', new DateTimeZone('UTC'));
            $currentTime = $currentDate->format("Y-m-d H:i:s");
            $insertData = array('date' => $date ." " . $time, 'amount' => $price, 'order_id' => $order_id, 'name' => $name,
                'email' => $email, 'city' => $city, 'product' => $productName, 'category' => $categoryName, 'mobile' => $mobile,
                'country' => $country, 'state' => $state, 'address' => $address, 'zip' => $zip, 'special_comments' => $specialComment,
                'created_at' => $currentTime, 'updated_at' => $currentTime,'demoType'=>$demoText);


            if (!$paidDemo)
			{	//echo json_encode(array('status' => false, 'message' => 'You have selected other city..'));
			
                     if(empty($city))
                     {
                        $city=$o_city;
                     }
					$insertData = array('date' => $date ." " . $time, 'amount' => $price, 'order_id' => $order_id, 'name' => $name,
                'email' => $email, 'city' => $city, 'product' => $productName, 'category' => $categoryName, 'mobile' => $mobile,
                'country' => $country, 'state' => $state, 'address' => $address, 'zip' => $zip, 'special_comments' => $specialComment,
                'created_at' => $currentTime, 'updated_at' => $currentTime,'demoType'=>$demoText);
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
							'{category}' => $insertData['category'], '{specialComments}' => $insertData['special_comments'],'{demomode}'=>$demoText);
		
						//$this->sendEmails($data);
						 
						//echo "insert successfully";
						//$send = Mail::Send($to,$subject,$message,$header);
					
						$protocol_content = (Configuration::get('PS_SSL_ENABLED')) ? 'https://' : 'http://';
						$link=$protocol_content.$_SERVER['HTTP_HOST'];
						$sub="Thank You For Demo Registration";
						$vars = array(
								'{name}' => $name, 
								'{email}' => $email,
								'{city}'=> $city,
								'{phone}'=> $mobile,
								'{product}'=> $productName,
								'{address}'=> $address,
								'{zip}'=> $zip,
								'{date}'=> $date,
								'{comments}'=> $specialComment,
                                '{demomode}'=>$demoText
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
							//$smarty->assign('mail', 'Email not sent');
                            echo json_encode(array('status' => true, 'url' => $url));
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
							'{category}' => $insertData['category'], '{specialComments}' => $insertData['special_comments'],'{demomode}'=>$demoText);
		
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
								'{comments}'=> $specialComment,
                                '{demomode}'=>$demoText
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
        $crkey = array_rand($captchas, 1);
        
        foreach($_SESSION as $sKey=>$sVal)
        {
            if (strpos($sKey, 'demo_reg') !== false) {
              unset($_SESSION[$sKey]);
            }
        }
        $_SESSION[$captchaVariable]=$captchas[$crkey]['value'];


        //$cookie->{$captchaVariable} = $captchas[$key]['value'];
        //$cookie->write(); // I think you'll need this as it doesn't automatically save
        
        $productsSql = 'Select ps_demo_products.id,ps_product_lang.name as product,ps_category_lang.name as category from ps_demo_products JOIN ps_category_lang ON ps_category_lang.id_category = ps_demo_products.categoryId JOIN ps_product ON ps_product.id_product = ps_demo_products.productId JOIN ps_product_lang ON ps_product_lang.id_product = ps_product.id_product where ps_product.active=1 and ps_demo_products.is_active=1';
//        echo $productsSql;
        $products = Db::getInstance()->executeS($productsSql);

        $categorywiseProduct = array();
        $productshtml ='';
        $productshtml .= '<select name="product" id="product">';
        $productshtml .= '<option value="">Select Product</option>';
        $productdataarr=array();
        foreach($products as $key=>$pr){
            $productsdataSql = "Select cityname,amount,demoType,demoText from ". _DB_PREFIX_ ."demo_products_cities where demo_id =". $pr['id'];
            $productsdata = Db::getInstance()->executeS($productsdataSql);
//            echo $productsdataSql;
            $categorywiseProduct[$pr['category']][]=$pr;
            $products[$key]['cities']=$productsdata;
            $productdataarr[$pr['id']]=$products[$key];
        }

        foreach($categorywiseProduct as $key1 => $cproduct){
            $productshtml .= '<OPTGROUP LABEL="' . $key1 .'">';
            foreach($cproduct as $val){
                $productshtml .= '<option value="'. $val['id'] .'">'. $val['product'] .'</option>';
            }
            $productshtml .= '</OPTGROUP>';
        }

        $productshtml .=  '</select>';
//        echo "<pre>";print_r($categorywiseProduct);echo "</pre>";
//        print_r($productdataarr);

        $this->context->smarty->assign(array(
            'form_action' => DemoRegistration::getShopDomainSsl(true, true) . '/index.php?fc=module&module=' . DemoRegistration::MODULE_NAME . '&controller=init',
            'jsSource' => $this->module->getPathUri(), 'price' => $this->price,
            'productdata' => json_encode($productdataarr),
//            'selectedProduct' => $selectedProduct,
            'products' => $productshtml,
            'captchaName' => $captchaVariable,
            'captchaText' => $captchas[$crkey]['key'],
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
//                $cs_Email = BOOK_DEMO_BEFORE_PAYMENT_CS;
                $cs_Email ='hitanshu.malhotra@milagrow.in';
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

//                $customerCareEmail = BOOK_DEMO_BEFORE_PAYMENT_CUSTOMER_CARE;
            $customerCareEmail = 'hitanshu.malhotra@milagrow.in';
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
