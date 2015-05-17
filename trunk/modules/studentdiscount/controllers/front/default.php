<?php

class StudentDiscountDefaultModuleFrontController extends ModuleFrontController
{

    public function postProcess()
    {
        if (Tools::isSubmit('submitMessage')) {
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
            if (!($interest = trim(Tools::getValue('interest'))))
                $this->errors[] = Tools::displayError('Interested in is Required');
            if (!($college = trim(Tools::getValue('college'))))
                $this->errors[] = Tools::displayError('College is Required');
            if (!($dob = trim(Tools::getValue('dob'))))
                $this->errors[] = Tools::displayError('DOB is Required');
            if (!($city = trim(Tools::getValue('city'))))
                $this->errors[] = Tools::displayError('City is Required');
            if (!($mobile = trim(Tools::getValue('mobile'))))
                $this->errors[] = Tools::displayError('Mobile is Required');
            if (!($from = trim(Tools::getValue('from'))) || !Validate::isEmail($from))
                $this->errors[] = Tools::displayError('Invalid email address.');
            if (empty($_FILES['fileUpload']['name']))
                $this->errors[] = Tools::displayError('Please upload your id proof');
            if (!empty($_FILES['fileUpload']['name']) && $_FILES['fileUpload']['error'] != 0)
                $this->errors[] = Tools::displayError('An error occurred during the uploading process.');
            if (!empty($_FILES['fileUpload']['name']) && !in_array(substr(Tools::strtolower($_FILES['fileUpload']['name']), -4), $extension) && !in_array(substr(Tools::strtolower($_FILES['fileUpload']['name']), -5), $extension))
                $this->errors[] = Tools::displayError('Bad file extension');
            if (!($captcha = trim(Tools::getValue('captcha'))))
                $this->errors[] = Tools::displayError('Captcha is Required');
            if (!($captchaName = trim(Tools::getValue('captchaName'))))
                $this->errors[] = Tools::displayError('Invalid Captcha Name');
            if (trim(Tools::getValue('captcha')) && $this->context->cookie->{$captchaName} != trim(Tools::getValue('captcha')))
                $this->errors[] = Tools::displayError('Invalid Captcha');

            if (count($this->errors) == 0) {
                $currentDate = new DateTime('now', new DateTimeZone('UTC'));
                $currentTime = $currentDate->format("Y-m-d H:i:s");
                if (isset($filename) && rename($_FILES['fileUpload']['tmp_name'], _PS_MODULE_DIR_ . '../upload/studentdiscount/' . $filename))
                    $file_name = $filename;
                //updating entry to the database and sending mail to admin and customer
                $insertData = array('name' => $name, 'interest' => $interest, 'college' => $college, 'dob' => $dob, 'city' => $city, 'mobile' => $mobile, 'email' => $from, 'college_id_proof_file' => $file_name, 'created_at' => $currentTime);
                Db::getInstance()->insert('student_discount', $insertData
                );

                if (Db::getInstance()->Insert_ID()) {
                    //sending mail to user
                    $userVarList = array('{name}' => $name, '{interest}' => $interest);
                    Mail::Send(
                        $this->context->language->id,
                        'student_discount_form_customer',
                        Mail::l('Student Discount Enquiry', (int)1),
                        $userVarList,
                        $from,
                        $name,
                        null,
                        null,
                        null,
                        null,
                        getcwd() . _MODULE_DIR_ . 'studentdiscount/',
                        false,
                        null
                    );
                    //sending mail to admin
                    $var_list = array('{name}' => $name,
                        '{interest}' => $interest,
                        '{college}' => $college,
                        '{city}' => $city,
                        '{mobile}' => $mobile,
                        '{email}' => $from,
                        '{dob}' => $dob,
                        '{college_id_proof_file}' => $file_name,
                        '{created_at}' => $currentTime);

                    if (isset($filename))
                        $var_list['{attached_file}'] = $_FILES['fileUpload']['name'];

//                    if (_PS_ENVIRONMENTS) {
                        $adminEmail = 'cs@milagrow.in';
//                    } else {
//                        $adminEmail = Configuration::get('PS_SHOP_EMAIL');
//                    }
                    Mail::Send(
                        $this->context->language->id,
                        'student_discount_form',
                        Mail::l("$interest, $college, $name - Student Discount Form", (int)1),
                        $var_list,
                        $adminEmail,
                        'Administrator',
                        $from,
                        $name,
                        $fileAttachment,
                        null,
                        getcwd() . _MODULE_DIR_ . 'studentdiscount/',
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
        $captchas = $this->getCaptcha();
        global $cookie;
        $captchaVariable = "stud_dis" . rand(1000000, PHP_INT_MAX);
        $cookie->{$captchaVariable} = null;
        $cookie->write(); // I think you'll need this as it doesn't automatically save
        $key = array_rand($captchas, 1);
        $cookie->{$captchaVariable} = $captchas[$key]['value'];
        $cookie->write(); // I think you'll need this as it doesn't automatically save
        $email = Tools::safeOutput(Tools::getValue('from',
            ((isset($this->context->cookie) && isset($this->context->cookie->email) && Validate::isEmail($this->context->cookie->email)) ? $this->context->cookie->email : '')));

        $productSql = 'SELECT pd.id_product,p.reference as name FROM ps_product as p left join ps_product_lang as pd on p.id_product = pd.id_product left join ps_stock_available as sa on sa.id_product =  p.id_product left join ps_category_product as cp on p.id_product = cp.id_product left join ps_category_lang as cd on cd.id_category = cp.id_category where sa.quantity > 0 and p.active = 1 and cd.id_category = 6 group by sa.id_product';
        $products = Db::getInstance()->executeS($productSql);
//        var_dump($products);exit;

        $this->context->smarty->assign(array(
            'errors' => $this->errors,
            'email' => $email,
            'captchaText' => $captchas[$key]['key'],
            'action' => $this->context->link->getModuleLink('studentdiscount'),
            'jsSource' => $this->module->getPathUri(),
            'captchaName' => $captchaVariable,
            'name' => trim(Tools::getValue('name')),
            'interest' => trim(Tools::getValue('interest')),
            'city' => trim(Tools::getValue('city')),
            'college' => trim(Tools::getValue('college')),
            'mobile' => Tools::getValue('mobile'),
            'products' => $products
        ));

        $this->setTemplate('default.tpl');
    }

    private function getCaptcha()
    {
        return array(array('key' => "2 + 2 = ?", 'value' => 4), array('key' => "2 + 7 = ?", 'value' => 9),
            array('key' => "7 - 2 = ?", 'value' => 5), array('key' => "5 - 4 = ?", 'value' => 1),
            array('key' => "2 * 2 = ?", 'value' => 4), array('key' => "3 * 4 = ?", 'value' => 12),
            array('key' => "4 + 3 = ?", 'value' => 7), array('key' => "9 + 7 = ? ", 'value' => 16));
    }

}
