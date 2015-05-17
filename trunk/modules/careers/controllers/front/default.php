<?php

class CareersDefaultModuleFrontController extends ModuleFrontController
{

    public function postProcess()
    {
        if (Tools::isSubmit('submitMessage')) {
            $fileAttachment = null;
            if (isset($_FILES['fileUpload']['name']) && !empty($_FILES['fileUpload']['name']) && !empty($_FILES['fileUpload']['tmp_name'])) {
                $extension = array('.rtf', '.doc', '.docx', '.pdf');
                $filename = uniqid() . substr($_FILES['fileUpload']['name'], -5);
                $fileAttachment['content'] = file_get_contents($_FILES['fileUpload']['tmp_name']);
                $fileAttachment['name'] = $_FILES['fileUpload']['name'];
                $fileAttachment['mime'] = $_FILES['fileUpload']['type'];
            }
            if (!($name = trim(Tools::getValue('name'))))
                $this->errors[] = Tools::displayError('Name is Required');
            if (!($dob = trim(Tools::getValue('dob'))))
                $this->errors[] = Tools::displayError('DateOfBirth is Required');
            if (!($phone = trim(Tools::getValue('phone'))))
                $this->errors[] = Tools::displayError('Phone is Required');
            if (!($from = trim(Tools::getValue('from'))) || !Validate::isEmail($from))
                $this->errors[] = Tools::displayError('Invalid email address.');
            if (!($postAppliedFor = trim(Tools::getValue('postappliedfor'))))
                $this->errors[] = Tools::displayError('Post applied for is Required');
            if (!($state = trim(Tools::getValue('state'))))
                $this->errors[] = Tools::displayError('State is Required');
            if (!($city = trim(Tools::getValue('city'))))
                $this->errors[] = Tools::displayError('City is Required');
            if (!($department = trim(Tools::getValue('department'))))
                $this->errors[] = Tools::displayError('Department is Required');
            if (!($education = trim(Tools::getValue('education'))))
                $this->errors[] = Tools::displayError('Education Qualification is Required');
            if (!($professional = trim(Tools::getValue('professional'))))
                $this->errors[] = Tools::displayError('Professional Qualification is Required');
            if (!($careerHighlights = html_entity_decode(Tools::getValue('careerhighlights'))))
                $this->errors[] = Tools::displayError('Career Highlights is Required');
            if (empty($_FILES['fileUpload']['name']))
                $this->errors[] = Tools::displayError('Please upload your resume');
            if (!empty($_FILES['fileUpload']['name']) && $_FILES['fileUpload']['error'] != 0)
                $this->errors[] = Tools::displayError('An error occurred during the uploading resume process.');
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
                if (isset($filename) && rename($_FILES['fileUpload']['tmp_name'], _PS_MODULE_DIR_ . '../upload/resume/' . $filename))
                    $file_name = $filename;
                //updating entry to the database and sending mail to admin and customer
                $insertData = array('name' => $name, 'email' => $from,'post_applied_for' => $postAppliedFor, 'phone' => $phone,'state'=>$state,'city'=>$city, 'dob' => $dob, 'address' => html_entity_decode(Tools::getValue('address')), 'department' => $department, 'education' => $education, 'professional' => $professional, 'skill' => trim(Tools::getValue('primarySkill')), 'career_highlights' => html_entity_decode(Tools::getValue('careerhighlights')), 'work_experience' => trim(Tools::getValue('workExperience')), 'resume_file' => $file_name, 'created_at' => $currentTime);
                Db::getInstance()->insert('careers', $insertData);

//                $career_form_id = Db::getInstance()->Insert_ID();
                if ($career_form_id = Db::getInstance()->Insert_ID()) {
                    //sending mail to user
                    $userVarList = array('{name}' => $name, '{department}' => $department);
                    Mail::Send(
                        $this->context->language->id,
                        'careers_form_customer',
                        Mail::l('Thank you for applying at Milagrow Humantech ', (int)1),
                        $userVarList,
                        $from,
                        $name,
                        null,
                        null,
                        null,
                        null,
                        getcwd() . _MODULE_DIR_ . 'careers/',
                        false,
                        null
                    );
                    //sending mail to admin
                    $var_list = array(
                        '{name}' => $name,
                        '{email}' => $from,
                        '{post}' => $postAppliedFor,
                        '{phone}' => $phone,
                        '{dob}' => $dob,
                        '{address}' => html_entity_decode(Tools::getValue('address')),
                        '{department}' => trim(Tools::getValue('department')),
                        '{education}' => $education,
                        '{professional}' => $professional,
                        '{skill}' => trim(Tools::getValue('primarySkill')),
                        '{career_highlights}' => $careerHighlights,
                        '{work_experience}' => trim(Tools::getValue('workExperience')),
                        '{created_at}' => $currentTime,
                        '{state}'=>$state,
                        '{city}'=>$city
                    );

                    if (isset($filename))
                        $var_list['{attached_file}'] = $_FILES['fileUpload']['name'];
//                    if (_PS_ENVIRONMENTS) {
                        $adminEmail = Configuration::get('MILAGROW_HR_EMAIL');
//                    $adminEmail = 'ptailor@greenapplesolutions.com';
//                    } else {
//                        $adminEmail = Configuration::get('PS_SHOP_EMAIL');
//                    }

//                    Senior Citizen Discount Form - #7 - SuperBot - New Delhi - priyanka
//                    It should pick up department, name, location and a unique number.
                    Mail::Send(
                        $this->context->language->id,
                        'careers_form',
                        Mail::l("Careers Form - #$career_form_id - $department - $city - $name ", (int)1),
                        $var_list,
                        $adminEmail,
                        'Administrator',
                        $from,
                        $name,
                        $fileAttachment,
                        null,
                        getcwd() . _MODULE_DIR_ . 'careers/',
                        false,
                        null
                    );

//                    Mail::Send(
//                        $this->context->language->id,
//                        'careers_form',
//                        Mail::l("$department, $careerHighlights, $name - Careers Form", (int)1),
//                        $var_list,
//                        "hmalhotra@greenapplesolutions.com",
//                        'Administrator',
//                        $from,
//                        $name,
//                        $fileAttachment,
//                        null,
//                        getcwd() . _MODULE_DIR_ . 'careers/',
//                        false,
//                        null
//                    );


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
        $captchaVariable = "car" . rand(1000000, PHP_INT_MAX);
        $cookie->{$captchaVariable} = null;
        $cookie->write(); // I think you'll need this as it doesn't automatically save
        $key = array_rand($captchas, 1);
        $cookie->{$captchaVariable} = $captchas[$key]['value'];
        $cookie->write(); // I think you'll need this as it doesn't automatically save
        $email = Tools::safeOutput(Tools::getValue('from',
            ((isset($this->context->cookie) && isset($this->context->cookie->email) && Validate::isEmail($this->context->cookie->email)) ? $this->context->cookie->email : '')));
        $this->context->smarty->assign(array(
            'errors' => $this->errors,
            'email' => $email,
            'action' => $this->context->link->getModuleLink('careers'),
            'jsSource' => $this->module->getPathUri()
        ));


        $this->context->smarty->assign(
            array('captchaName' => $captchaVariable,
                'name' => Tools::getValue('name'),
                'dob' => Tools::getValue('dob'),
                'address' => html_entity_decode(Tools::getValue('address')),
                'phone' => Tools::getValue('phone'),
                'postappliedfor' => Tools::getValue('postappliedfor'),
                'department' => Tools::getValue('department'),
                'captchaText' => $captchas[$key]['key'],
                'education' => Tools::getValue('education'),
                'professional' => Tools::getValue('professional'),
                'primarySkill' => Tools::getValue('primarySkill'),
                'stateselected' => trim(Tools::getValue('state')),
                'city' => trim(Tools::getValue('city')),
                'careerhighlights' => html_entity_decode(Tools::getValue('careerhighlights')),
                'workExperience' => Tools::getValue('workExperience'),
                'states' => $this->getStates()
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

    private function getStates()
    {
        return State::getStatesByIdCountry(110);
    }


}
