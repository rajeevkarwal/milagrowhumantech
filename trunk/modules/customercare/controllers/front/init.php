<?php

class CustomerCareInitModuleFrontController extends ModuleFrontController
{

    public function postProcess()
    {

        if (Tools::isSubmit('submitMessage')) {
            $fileAttachment = null;
            $filename = null;
            if (isset($_FILES['fileUpload']['name']) && !empty($_FILES['fileUpload']['name']) && !empty($_FILES['fileUpload']['tmp_name'])) {
                $extension = array('.rtf', '.doc', '.docx', '.pdf', '.jpeg', '.png', '.jpg');
                $filename = uniqid() . substr($_FILES['fileUpload']['name'], -5);
                $fileAttachment['content'] = file_get_contents($_FILES['fileUpload']['tmp_name']);
                $fileAttachment['name'] = $_FILES['fileUpload']['name'];
                $fileAttachment['mime'] = $_FILES['fileUpload']['type'];
            }

            if (!($name = trim(Tools::getValue('name'))))
                $this->errors[] = Tools::displayError('Name is Required');

            if (!($phone = trim(Tools::getValue('phone'))))
                $this->errors[] = Tools::displayError('Phone number is Required');
            if (!($product = trim(Tools::getValue('product'))))
                $this->errors[] = Tools::displayError('product is Required');
            if (!($email = trim(Tools::getValue('email'))) || !Validate::isEmail($email))
                $this->errors[] = Tools::displayError('Invalid email address.');
            if (!($state = trim(Tools::getValue('state'))))
                $this->errors[] = Tools::displayError('State is Required');
            if (!($city = trim(Tools::getValue('city'))))
                $this->errors[] = Tools::displayError('City is Required');
            if (!($category = trim(Tools::getValue('category'))))
                $this->errors[] = Tools::displayError('Purpose is Required');
            $isExistingCustomer = Tools::getValue('existingCustomer', null);
            if (is_null($isExistingCustomer))
                $this->errors[] = Tools::displayError('Are you existing customer field is required');
            if (!($captcha = trim(Tools::getValue('captcha'))))
                $this->errors[] = Tools::displayError('Captcha is Required');
            if (!($captchaName = trim(Tools::getValue('captchaName'))))
                $this->errors[] = Tools::displayError('Invalid Captcha Name');
            if (!($message = trim(Tools::getValue('message'))))
                $this->errors[] = Tools::displayError('Remarks field is required');
            if (trim(Tools::getValue('captcha')) && $this->context->cookie->{$captchaName} != trim(Tools::getValue('captcha')))
                $this->errors[] = Tools::displayError('Invalid Captcha');

            if (!empty($_FILES['fileUpload']['name']) && $_FILES['fileUpload']['error'] != 0)
                $this->errors[] = Tools::displayError('An error occurred during the uploading process.');
            if (!empty($_FILES['fileUpload']['name']) && !in_array(substr(Tools::strtolower($_FILES['fileUpload']['name']), -4), $extension) && !in_array(substr(Tools::strtolower($_FILES['fileUpload']['name']), -5), $extension))
                $this->errors[] = Tools::displayError('Bad file extension');

            if (count($this->errors) == 0) {
                $file_name = null;
                if (!empty($filename) && rename($_FILES['fileUpload']['tmp_name'], _PS_MODULE_DIR_ . '../upload/customercare/' . $filename))
                    $file_name = $filename;

                $currentDate = new DateTime('now', new DateTimeZone('UTC'));
                $currentTime = $currentDate->format("Y-m-d H:i:s");
                $isExistingCustomer = strcmp($isExistingCustomer, "yes") == 0 ? 1 : 0;
                $insertData = array('name' => $name, 'email' => $email, 'phone_number' => $phone,
                    'product' => $product,
                    'city' => $city,
                    'state' => $state,
                    'is_existing_customer' => $isExistingCustomer, 'category' => $category, 'attachment' => $file_name,
                    'message' => Tools::getValue('message', null),
                    'created_at' => $currentTime,
                    'updated_at' => $currentTime);
                Db::getInstance()->insert('customer_care', $insertData);

                $alertMessage = "";
                if ($category == 'Installation (Product in Warranty)' && $product == "TabTops") {
                    $alertMessage = "Please note that in case of In-warranty Taptops, installation help is available only over Phone, Email and Skype.";
                } else if ($category == "Demo (Product in Warranty)" && $product == "TabTops")
                    $alertMessage = "Please note that in case of In-warranty Taptops, demo is available only over Phone, Email and Skype.";

                else if ($category == "Software Issue (Product in Warranty)" && $product == "TabTops")
                    $alertMessage = "Please note that in case of In-warranty Taptops, help for software related issues is available only over Phone, Email and Skype.";

                else if ($category == "Pre Sales – Demo" && $product == "Robotic Floor Cleaners") {
                    $alertMessage = "Please note that Pre Sales – Demo for Robotic Floor Cleaners is available in three cities only i.e., Chennai, Bangalore and Delhi/NCR. It has a nominal charge which get reimbursed on purchase.";

                } else if ($category == "Demo (Product in Warranty)" && $product == "Robotic Floor Cleaners")

                    $alertMessage = "Please note that in case of In-warranty Robotic Floor Cleaners, in person demo is available only in three cities i.e., Chennai, Bangalore and Delhi/NCR. In other places we offer demo over Phone, Email and Skype. We also offer video manuals.";
                else if ($category == "Installation (Product in Warranty)" && $product == "Robotic Floor Cleaners")
                    $alertMessage = "Please note that in case of In-warranty Robotic Floor Cleaners, in person installation help is available only in three cities i.e., Chennai, Bangalore and Delhi/NCR. In other places we offer help over Phone, Email and Skype. We also offer video manuals.";
                else if ($category == "Software Issue (Product in Warranty)" && $product == "Robotic Floor Cleaners")
                    $alertMessage = "Please note that in case of In-warranty Robotic Floor Cleaners, help for software related issues is available only over Phone, Email and Skype.";
                else if ($category == "Demo (Product in Warranty)" && $product == "Robotic Window Cleaners")
                    $alertMessage = "Please note that in case of In-warranty Robotic Window Cleaners, demo is available only over Phone, Email and Skype.";
                else if ($category == "Installation (Product in Warranty)" && $product == "Robotic Window Cleaners")
                    $alertMessage = "Please note that in case of In-warranty Robotic Window Cleaners, installation help is available only over Phone, Email and Skype.";
                else if ($category == "Software Issue (Product in Warranty)" && $product == "Robotic Window Cleaners")
                    $alertMessage = "Please note that in case of In-warranty Robotic Window Cleaners, help for software related issues is available only over Phone, Email and Skype.";
                else if ($category == "Demo (Product in Warranty)" && $product == "Robotic Body Massagers")
                    $alertMessage = "Please note that in case of In-warranty Robotic Body Massagers, demo is available only over Phone, Email and Skype.";
                else if ($category == "Installation (Product in Warranty)" && $product == "Robotic Body Massagers")
                    $alertMessage = "Please note that in case of In-warranty Robotic Body Massagers, installation help is available only over Phone, Email and Skype.";
                else if ($category == "Installation (Product in Warranty)" && $product == "TV Mounts and Racks")
                    $alertMessage = "Please note that in case of In-warranty TV Mounts and Racks, in person installation help is available only in Delhi/NCR.";
//
//                if (_PS_ENVIRONMENTS) {
                $customerCareEmailId = Configuration::get('MILAGROW_CUSTOMER_CARE_EMAIL');
//                $customerCareEmailId = 'ptailor@greenapplesolutions.com';
//                } else {
//                    $customerCareEmailId = Configuration::get('PS_SHOP_EMAIL');
//                }
                if (Db::getInstance()->Insert_ID()) {

                    $customer_care_id = Db::getInstance()->Insert_ID();
                    //sending mail to user
                    $userVarList = array('{name}' => $name);
                    Mail::Send(
                        $this->context->language->id,
                        'customer_care_form_customer',
                        Mail::l('Thank you for contacting Milagrow Humantech ', (int)1),
                        $userVarList,
                        $email,
                        $name,
                        null,
                        null,
                        null,
                        null,
                        getcwd() . _MODULE_DIR_ . 'customercare/',
                        false,
                        null
                    );

                    //sending mail to customer care
                    $var_list = array('{name}' => $name, '{phone}' => $phone, '{product}' => $product, '{state}' => $state, '{city}' => $city,
                        '{email}' => $email, '{category}' => $category, '{remarks}' => Tools::getValue('message', null),
                        '{isExistingCustomer}' => empty($isExistingCustomer) ? "No" : "Yes");
                    Mail::Send(
                        $this->context->language->id,
                        'customer_care_form',
                        Mail::l("Customer Care Form - #" . $customer_care_id ." - ". $category ." - ". $product ." - ". $city ." - ". $name , (int)1),
                        $var_list,
                        $customerCareEmailId,
                        'Customer Care',
                        $email,
                        $name,
                        $fileAttachment,
                        null,
                        getcwd() . _MODULE_DIR_ . 'customercare/',
                        false,
                        null
                    );

                    //--------------> uncomment the given below code to send mail to your own email id for testing

                    //----------and change yout email id --------------//

//                    Mail::Send(
//                        $this->context->language->id,
//                        'customer_care_form',
//                        Mail::l("$category, $product, $name - Customer Care Form", (int)1),
//                        $var_list,
//                        'hmalhotra@greenapplesolutions.com',
//                        'Customer Care',
//                        $email,
//                        $name,
//                        $fileAttachment,
//                        null,
//                        getcwd() . _MODULE_DIR_ . 'customercare/',
//                        false,
//                        null
//                    );

                    $this->context->smarty->assign(array('confirmation' => 1, 'alertMessage' => $alertMessage));
                } else {

                    $this->errors[] = Tools::displayError('An error occurred while sending the message.');
                }
            }
        }
    }


    public function initContent()
    {
        parent::initContent();
        $captchas = $this->getCaptcha();
        global $cookie;
        $captchaVariable = "cc" . rand(1000000, PHP_INT_MAX);
        $cookie->{$captchaVariable} = null;
        $cookie->write(); // I think you'll need this as it doesn't automatically save
        $key = array_rand($captchas, 1);
        $cookie->{$captchaVariable} = $captchas[$key]['value'];
        $cookie->write(); // I think you'll need this as it doesn't automatically save
        $this->context->smarty->assign(
            array(
                'errors' => $this->errors,
                'captchaName' => $captchaVariable,
                'captchaText' => $captchas[$key]['key'],
                'action' => $this->context->link->getModuleLink('customercare'),
                'jsSource' => $this->module->getPathUri(),
                'states' => $this->getStates(),
                'name' => Tools::getValue('name'),
                'email' => Tools::getValue('email'),
                'phone' => Tools::getValue('phone'),
                'stateselected' => trim(Tools::getValue('state')),
                'city' => trim(Tools::getValue('city')),
                'product' => trim(Tools::getValue('product')),
                'existingcustomerselected' => trim(Tools::getValue('existingCustomer')),
                'purpose' => trim(Tools::getValue('category')),
                'message' => trim(Tools::getValue('message'))
            ));
        $this->setTemplate('customercare.tpl');

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
        return State::getStatesByIdCountryandName(110);
    }


}
