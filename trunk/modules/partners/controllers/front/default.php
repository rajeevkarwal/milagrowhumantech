<?php

class PartnersDefaultModuleFrontController extends ModuleFrontController
{

    public function postProcess()
    {
        if (Tools::isSubmit('submitMessage')) {
            if (!($name = trim(Tools::getValue('name'))))
                $this->errors[] = Tools::displayError('Company Name is Required');
            if (!($from = trim(Tools::getValue('from'))) || !Validate::isEmail($from))
                $this->errors[] = Tools::displayError('Invalid email address.');
            if (!($phone = trim(Tools::getValue('phone'))))
                $this->errors[] = Tools::displayError('Contact Number is Required');
            if (!($product = trim(Tools::getValue('product'))))
                $this->errors[] = Tools::displayError('Product is Required');
            if (!($state = trim(Tools::getValue('state'))))
                $this->errors[] = Tools::displayError('State is Required');
            if (!($city = trim(Tools::getValue('city'))))
                $this->errors[] = Tools::displayError('City is Required');
            if (!($address = trim(Tools::getValue('address'))))
                $this->errors[] = Tools::displayError('Address is Required');
            if (!($captcha = trim(Tools::getValue('captcha'))))
                $this->errors[] = Tools::displayError('Captcha is Required');
            if (!($captchaName = trim(Tools::getValue('captchaName'))))
                $this->errors[] = Tools::displayError('Invalid Captcha Name');
            if (trim(Tools::getValue('captcha')) && $this->context->cookie->{$captchaName} != trim(Tools::getValue('captcha')))
                $this->errors[] = Tools::displayError('Invalid Captcha');
            $purpose = trim(Tools::getValue('purpose', ""));
            if (count($this->errors) == 0) {
                $currentDate = new DateTime('now', new DateTimeZone('UTC'));
                $currentTime = $currentDate->format("Y-m-d H:i:s");
//                updating entry to the database and sending mail to admin and customer
                $insertData = array('name_of_company' => $name, 'email' => $from, 'contact_number' => $phone, 'product' => $product, 'message' => html_entity_decode(Tools::getValue('message')), 'state' => $state, 'city' => $city,
                    'address' => $address, 'purpose' => $purpose,
                    'website' => trim(Tools::getValue('website')), 'turnover' => trim(Tools::getValue('turnover')), 'created_at' => $currentTime);
                Db::getInstance()->insert('partners', $insertData);

                if (Db::getInstance()->Insert_ID()) {

                    $partner_id = Db::getInstance()->Insert_ID();
                    //sending mail to user
                    $userVarList = array('{name}' => $name);
                    Mail::Send(
                        $this->context->language->id,
                        'partners_form_customer',
                        Mail::l("Milagrow Partner Enquiry - #" . $partner_id ." - ". $product ." - " .$purpose . " - ". $city ." - ". $name , (int)1),
                        $userVarList,
                        $from,
                        $name,
                        null,
                        null,
                        null,
                        null,
                        getcwd() . _MODULE_DIR_ . 'partners/',
                        false,
                        null
                    );

//                    if (_PS_ENVIRONMENTS) {
                        $trade_partner_email_id = Configuration::get('TRADE_PARTNER_SALES_EMAIL');
//                       $trade_partner_email_id = 'ptailor@greenapplesolutions.com';
//                    } else {

//                        $customerCareEmailId = Configuration::get('PS_SHOP_EMAIL');
//                    }
                    //sending mail to customer care , previously we're sending mail to admin
                    $var_list = array(
                        '{name}' => $name,
                        '{email}' => $from,
                        '{phone}' => $phone,
                        '{product}' => $product,
                        '{message}' => html_entity_decode(Tools::getValue('message')),
                        '{state}' => $state,
                        '{city}' => $city,
                        '{address}' => $address,
                        '{purpose}' => $purpose,
                        '{website}' => trim(Tools::getValue('website')),
                        '{turnover}' => trim(Tools::getValue('turnover')),
                        '{created_at}' => $currentTime
                    );
//                    $emailSubject = $product . ", ";
//                    if (!empty($purpose))
//                        $emailSubject .= $purpose.", ";
//                    $emailSubject .= $name;
                    Mail::Send(
                        $this->context->language->id,
                        'partners_form',
                        Mail::l("Partner with Us form - #" . $partner_id ." - ". $product ." - " .$purpose . " - ". $city ." - ". $name , (int)1),
                        $var_list,
                        $trade_partner_email_id,
                        'Administrator',
                        $from,
                        $name,
                        null,
                        null,
                        getcwd() . _MODULE_DIR_ . 'partners/',
                        false,
                        null
                    );
                    $this->context->smarty->assign('confirmation', 1);
                } else
                    $this->errors[] = Tools::displayError('An error occurred while sending the message.');
            }

        }
    }

    public function initContent()
    {

        parent::initContent();

        $email = Tools::safeOutput(Tools::getValue('from',
            ((isset($this->context->cookie) && isset($this->context->cookie->email) && Validate::isEmail($this->context->cookie->email)) ? $this->context->cookie->email : '')));
        $captchas = $this->getCaptcha();
        global $cookie;
        $captchaVariable = "partner" . rand(1000000, PHP_INT_MAX);
        $cookie->{$captchaVariable} = null;
        $cookie->write(); // I think you'll need this as it doesn't automatically save
        $key = array_rand($captchas, 1);
        $cookie->{$captchaVariable} = $captchas[$key]['value'];
        $cookie->write(); // I think you'll need this as it doesn't automatically save
        $this->context->smarty->assign(array(
            'captchaName' => $captchaVariable,
            'errors' => $this->errors,
            'email' => $email,
            'captchaText' => $captchas[$key]['key'],
            'states' => $this->getStates(),
            'action' => $this->context->link->getModuleLink('partners'),
            'jsSource' => $this->module->getPathUri(),
            'name' => Tools::getValue('name'),
            'message' => html_entity_decode(Tools::getValue('message')),
            'phone' => Tools::getValue('phone'),
            'position' => Tools::getValue('position'),
            'product' => trim(Tools::getValue('product')),
            'stateselected' => trim(Tools::getValue('state')),
            'city' => trim(Tools::getValue('city')),
            'address' => trim(Tools::getValue('address')),
            'purpose' => trim(Tools::getValue('purpose')),
            'website' => trim(Tools::getValue('project')),
            'trunover' => trim(Tools::getValue('turnover')),
        ));

        $this->setTemplate('default.tpl');
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
