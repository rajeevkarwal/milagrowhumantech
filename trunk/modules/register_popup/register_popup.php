<?php
/**
 * Created by PhpStorm.
 * User: hitanshu
 * Date: 25/11/13
 * Time: 10:09 PM
 */
//include('config/smarty.config.inc.php');
include(dirname(__FILE__) . '/tools.php');


class Register_Popup extends Module
{
    private $_html = '';
    private $_postErrors = array();

    public function __construct()
    {
        $this->name = 'register_popup';
        $this->tab = 'front_office_features';
        $this->version = '1.0';
        $this->author = 'Deepanshu';
        $this->need_instance = 0;
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        parent::__construct();

        $this->displayName = $this->l('Register Pop Up');
        $this->description = $this->l('Display pop up for register');
    }

    /**
     * @see ModuleCore::install()
     */
    public function install()
    {
        if (!parent::install() ||
            !$this->registerHook('displayHome') ||
            !$this->registerHook('header')
        )
            return false;
        return true;
    }

    public function uninstall()
    {
        return parent::uninstall();
    }


    /////This function administers the feed module


    public function getContent()
    {

        if (Tools::isSubmit('submit_reg')) {

            $this->_displayReg();
        }


    }

    /* private function _displayReg() {

                Db::getInstance()->Execute('
                INSERT INTO `' . _DB_PREFIX_ . 'test2` (`name`,`email`)
                VALUES("' . Tools::getValue('name') . '", ' . Tools::getValue('email') . ')');



                }*/


    private function _displayForm()
    {
        global $smarty;
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "test2";
        $results = Db::getInstance()->executeS($sql);
        $smarty->assign('hi', 'hi');
        return $this->display(__FILE__, 'hello.tpl');


    }


    function hookFooter($params)
    {
        global $smarty;


        // Generate years, months and days
        if (isset($_POST['years']) && is_numeric($_POST['years']))
            $selectedYears = (int)($_POST['years']);
        $years = Tools::dateYears();
        if (isset($_POST['months']) && is_numeric($_POST['months']))
            $selectedMonths = (int)($_POST['months']);
        $months = Tools::dateMonths();

        if (isset($_POST['days']) && is_numeric($_POST['days']))
            $selectedDays = (int)($_POST['days']);
        $days = Tools::dateDays();


        $this->context->smarty->assign(array(
            'one_phone_at_least' => (int)Configuration::get('PS_ONE_PHONE_AT_LEAST'),
            'onr_phone_at_least' => (int)Configuration::get('PS_ONE_PHONE_AT_LEAST'), //retro compat
            'years' => $years,
            'sl_year' => (isset($selectedYears) ? $selectedYears : 0),
            'months' => $months,
            'sl_month' => (isset($selectedMonths) ? $selectedMonths : 0),
            'days' => $days,
            'sl_day' => (isset($selectedDays) ? $selectedDays : 0)
        ));


        $days = Tools::dateDays();
        if (Tools::isSubmit('submit_reg')) {

            $gender = Tools::getValue('id_gender');
            $f_name = Tools::getValue('f_name');
            $l_name = Tools::getValue('l_name');
            $email = Tools::getValue('email');
            $pwd1 = Tools::getValue('pwd');
            $pwd = Tools::encrypt($pwd1);
            $bday = (empty($_POST['years']) ? '' : (int)$_POST['years'] . '-' . (int)$_POST['months'] . '-' . (int)$_POST['days']);
            $date_added = date("Y-m-d H:i:s", time());
            $date_updated = $date_added;
            $last_pass_gen = $date_added;
            $newsletter = '1';
            $ip = pSQL(Tools::getRemoteAddr());
            $optin = '1';
            $maxpay = '0';
            $s_key = md5(uniqid(rand(), true));
            //$insert_id=(int)Db::getInstance()->Insert_ID();

            $id_land = Language::getIdByIso('en');
            $title = Mail::l('Test Mail');
            $templateVars['{firstname}'] = $f_name;
            $templateVars['{lastname}'] = $l_name;
            $toName = $email; //Customer name
            $from = $email;
            $to = "deepanshu.sharma@milagrow.in";
            $subject = "This is subject";
            $message = "This is simple text message.";
            $header = "From:deepanshu.sharma@milagrow.in \r\n";
            $fromName = Configuration::get('PS_SHOP_NAME'); //Sender's name


            if (Customer::customerExists($email)) {
                $emailexist = '<font color="red" size="2" class="red">You have already registered. Please login to enjoy shopping or just close the popup.</font>';
                $smarty->assign('email_exist', $emailexist);
            } else {
                //$sql2="INSERT INTO `ps_test2` (`firstname`, `email`, `id_gender`, `passwd`, `birthday`) VALUES ('".$f_name."', '".$email."', '".$gender."', '".$pwd."', '".$bday."' )";
                //$sql2= "INSERT into "._DB_PREFIX_."customer (`id_gender`,`id_default_group`,`id_lang`, `firstname`,`lastname`,`email`,`passwd`,`last_passwd_gen`,`birthday`,`newsletter`,`ip_registration_newsletter`,`optin`,`active`,`date_add`,`date_upd`,`max_payment_days`,`secure_key` ) values ('".$gender."','3', '1','".$f_name."','".$l_name."','".$email."','".$pwd."','".$last_pass_gen."','".$bday."','".$newsletter."','".$ip."','".$optin."','1','".$date_added."','".$date_updated."','".$maxpay."','".$s_key."') ";

                $sql2 = "INSERT INTO  " . _DB_PREFIX_ . "customer (`id_gender`, `id_default_group`, `id_lang`, `id_risk`, `firstname`, `lastname`, `email`, `passwd`, `last_passwd_gen`, `birthday`, `newsletter`, `ip_registration_newsletter`, `optin`, `active`, `date_add`, `date_upd`, `max_payment_days`, `secure_key`) VALUES ('" . $gender . "', '3', '1', '0', '" . $f_name . "', '" . $l_name . "', '" . $email . "', '" . $pwd . "', '" . $last_pass_gen . "', '" . $bday . "', '" . $newsletter . "', '" . $ip . "', '" . $optin . "', '1', '" . $date_added . "', '" . $date_updated . "', '" . $maxpay . "', '" . $s_key . "')";
                $result2 = Db::getInstance()->execute($sql2);

                $insert_id = (int)Db::getInstance()->Insert_ID();
                $tbl = pSQL(_DB_PREFIX_ . 'customer_group');
                Db::getInstance()->Execute("DELETE FROM $tbl WHERE id_customer='" . $insert_id . "'");
                $query = "INSERT into $tbl (`id_customer`,`id_group`) values ('" . $insert_id . "','3') ";
                Db::getInstance()->Execute($query);


                if ($result2) {
                    //echo "insert successfully";
                    //$send = Mail::Send($to,$subject,$message,$header);
                    $protocol_content = (Configuration::get('PS_SSL_ENABLED')) ? 'https://' : 'http://';
                    $link = $protocol_content . $_SERVER['HTTP_HOST'];
                    $sub = "Thank You For Registration";
                    $vars = array(
                        '{firstname}' => $f_name,
                        '{lastname}' => $l_name,
                        '{email}' => $email,
                        '{passwd}' => $pwd1
                    );
                    $id_lang = (int)Configuration::get('PS_LANG_DEFAULT');
                    $send = Mail::Send($id_lang, 'account', $sub, $vars, $email);


                    $successfully = '<font color="green" size="2" class="green">Registration successful.</font>';
                    $smarty->assign('inserted', $successfully);


                    $cookie->id_customer = intval($customer->id);
                    $cookie->customer_lastname = $customer->lastname;
                    $cookie->customer_firstname = $customer->firstname;
                    $cookie->logged = 1;
                    $cookie->secure_key = $customer->secure;
                    $cookie->passwd = $customer->passwd;
                    $cookie->email = $customer->email;


                    if ($send) {
                        $smarty->assign('mail', 'Email sent');
                    } else {
                        $smarty->assign('mail', 'Email not sent');
                    }


                } else {
                    echo "not insert";
                }

            }
        }


        if (Tools::isSubmit('submit_reg2')) { // registeration form for GOSF page

            $gender = Tools::getValue('id_gender');
            $f_name = Tools::getValue('f_name');
            $l_name = Tools::getValue('l_name');

            $email = Tools::getValue('email');
            $emailExp=explode("@", $email);

            if(empty($f_name))
            {
                $f_name=$emailExp[0];
            }
            if(empty($l_name))
            {
                $l_name=$emailExp[0];
            }
            $pwd1 = Tools::getValue('pwd');
            $pwd = Tools::encrypt($pwd1);
            $bday = (empty($_POST['years']) ? '' : (int)$_POST['years'] . '-' . (int)$_POST['months'] . '-' . (int)$_POST['days']);
            $date_added = date("Y-m-d H:i:s", time());
            $date_updated = $date_added;
            $last_pass_gen = $date_added;
            $newsletter = '1';
            $ip = pSQL(Tools::getRemoteAddr());
            $optin = '1';
            $maxpay = '0';
            $s_key = md5(uniqid(rand(), true));
            //$insert_id=(int)Db::getInstance()->Insert_ID();

            $id_land = Language::getIdByIso('en');
            $title = Mail::l('Test Mail');
            $templateVars['{firstname}'] = $f_name;
            $templateVars['{lastname}'] = $l_name;
            $toName = $email; //Customer name
            $from = $email;
            $to = "deepanshu.sharma@milagrow.in";
            //$email_admin = "deepanshu.sharma@milagrow.in";
            $email_admin = "ebiz@milagrow.in";
            $subject = "This is subject";
            $message = "This is simple text message.";
            $header = "From:deepanshu.sharma@milagrow.in \r\n";
            $fromName = Configuration::get('PS_SHOP_NAME'); //Sender's name

            $host = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
            if (Customer::customerExists($email)) {
                $emailexist = '<font color="red" size="2" class="red">You have already registered. Please login to enjoy shopping or just close the popup.</font>';
                $smarty->assign('email_exist', $emailexist);
            } else {
                //$sql2="INSERT INTO `ps_test2` (`firstname`, `email`, `id_gender`, `passwd`, `birthday`) VALUES ('".$f_name."', '".$email."', '".$gender."', '".$pwd."', '".$bday."' )";
                //$sql2= "INSERT into "._DB_PREFIX_."customer (`id_gender`,`id_default_group`,`id_lang`, `firstname`,`lastname`,`email`,`passwd`,`last_passwd_gen`,`birthday`,`newsletter`,`ip_registration_newsletter`,`optin`,`active`,`date_add`,`date_upd`,`max_payment_days`,`secure_key` ) values ('".$gender."','3', '1','".$f_name."','".$l_name."','".$email."','".$pwd."','".$last_pass_gen."','".$bday."','".$newsletter."','".$ip."','".$optin."','1','".$date_added."','".$date_updated."','".$maxpay."','".$s_key."') ";

                $sql2 = "INSERT INTO  " . _DB_PREFIX_ . "customer (`id_gender`, `id_default_group`, `id_lang`, `id_risk`, `firstname`, `lastname`, `email`, `passwd`, `last_passwd_gen`, `birthday`, `newsletter`, `ip_registration_newsletter`, `optin`, `active`, `date_add`, `date_upd`, `max_payment_days`, `secure_key`) VALUES ('" . $gender . "', '3', '1', '0', '" . $f_name . "', '" . $l_name . "', '" . $email . "', '" . $pwd . "', '" . $last_pass_gen . "', '" . $bday . "', '" . $newsletter . "', '" . $ip . "', '" . $optin . "', '1', '" . $date_added . "', '" . $date_updated . "', '" . $maxpay . "', '" . $s_key . "')";
                $result2 = Db::getInstance()->execute($sql2);

                $insert_id = (int)Db::getInstance()->Insert_ID();
                $tbl = pSQL(_DB_PREFIX_ . 'customer_group');
                Db::getInstance()->Execute("DELETE FROM $tbl WHERE id_customer='" . $insert_id . "'");
                $query = "INSERT into $tbl (`id_customer`,`id_group`) values ('" . $insert_id . "','3') ";
                Db::getInstance()->Execute($query);

                //$gosf_coupon_sql = "SELECT code FROM " . _DB_PREFIX_ . "cart_rule where id_cart_rule='286'";
                //$gosf_coupon_code = Db::getInstance()->executeS($sql);


                if ($result2) {
                    //echo "insert successfully";
                    //$send = Mail::Send($to,$subject,$message,$header);
                    $protocol_content = (Configuration::get('PS_SSL_ENABLED')) ? 'https://' : 'http://';
                    $link = $protocol_content . $_SERVER['HTTP_HOST'];
                    $q_url = strtok($_SERVER["REQUEST_URI"], '?');
                    $url = $_SERVER['HTTP_HOST'] . $q_url;
                    $sub = "Thank You For Registration" . '     ' . $email;
                    $sub_admin = "New Registration by" . '     ' . $email;
                    $host = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
                    $vars = array(
                        '{firstname}' => $f_name,
                        '{lastname}' => $l_name,
                        '{email}' => $email,
                        '{passwd}' => $pwd1,
                        '{page_url}' => $url
                    );
                    $id_lang = (int)Configuration::get('PS_LANG_DEFAULT');
//                    $smarty->assign('gosf_coupon_code', '');
                    //$send = Mail::Send($id_lang, 'gosf',$sub, $vars, $email);
                    if ($host == 'milagrow.net' || $host=='milagrow.net/content/38-contact-us' || $host == 'milagrow.net/' || $host=='milagrow.net/content/category/2-buying-guides' || $host=='milagrow.net/content/category/5-etailers') {
                        $send = Mail::Send($id_lang, 'gosf', $sub, $vars, $email);
                    } elseif ($host == 'milagrow.net/87-body-robots' ||$host=='milagrow.net/body-robots/23-robotic-body-massager-700112167935.html'|| $host=='milagrow.net/111-wheeme-red'||$host=='milagrow.net/112-wheeme-blue' || $host == 'milagrow.net/137-body-robot-models' || $host == 'milagrow.net/body-robots/23-robotic-body-massager.html' || $host=='milagrow.net/body-robots/90-robotic-body-massager-blue-700112167942.html' || $host=='milagrow.net/content/18-robotic-massagers' ) {
                        $send = Mail::Send($id_lang, 'gosf_br', $sub, $vars, $email);
                    } elseif ($host == 'milagrow.net/85-floor-robots' || $host=='milagrow.net/content/category/4-buying-guides-for-floor-robots' || $host=='milagrow.net/content/16-robotic-floor-cleaners' || $host=='milagrow.net/floor-robots/428-milagrow-blackcat20-refurbished.html' || $host=='milagrow.net/floor-robots/221-ecovacs-deebot-66-6943757601615.html' ||$host=='milagrow.net/floor-robots/507-milagrow-ecovacs-3d-deebot-79.html' || $host=='milagrow.net/floor-robots/220-ecovacs-deebot-63-6943757602032.html' || $host=='milagrow.net/floor-robots/508-phillips-easystar-fc8800.html' || $host == 'milagrow.net/85-floor-robots/' || $host == 'milagrow.net/85-floor-robots/#') {
                        $send = Mail::Send($id_lang, 'gosf_fr', $sub, $vars, $email);
                    } elseif ($host == 'milagrow.net/floor-robots/285-milagrow-redhawk-india-s-number-1-floor-robots.html') {
                        $send = Mail::Send($id_lang, 'gosf_fr_redhawk3', $sub, $vars, $email);
                    } elseif ($host == 'milagrow.net/floor-robots/109-milagrow-redhawk-india-s-number-1-floor-robots.html' || $host == 'milagrow.net/floor-robots/442-milagrow-redhawk10-refurbished-.html' || $host == 'milagrow.net/107-drywet-cleaning') {
                        $send = Mail::Send($id_lang, 'gosf_fr_redhawk3', $sub, $vars, $email);
                    } elseif ($host == 'milagrow.net/floor-robots/110-blackcat1.html' || $host == 'milagrow.net/floor-robots/217-blackcat2.html' || $host == 'milagrow.net/108-healthcare-cleaning' || $host == 'milagrow.net/67-floor-robot-accessories' || $host == 'milagrow.net/68-batteries' || $host == 'milagrow.net/70-brushes-sweepers' || $host == 'milagrow.net/75-chargers-cables' || $host == 'milagrow.net/73-docking-stations' || $host == 'milagrow.net/71-filters' || $host == 'milagrow.net/69-dustbin-mops-pads' || $host == 'milagrow.net/72-remotes' || $host == 'milagrow.net/74-virtual-walls'){
                        $send = Mail::Send($id_lang, 'gosf_fr_blackcat3', $sub, $vars, $email);
                    } elseif ($host == 'milagrow.net/floor-robots/224-milagrow-robocop-20-india-s-number-1-floor-robot.html' || $host == 'milagrow.net/106-only-dry-cleaning'){
                        $send = Mail::Send($id_lang, 'gosf_fr_robo_cop', $sub, $vars, $email);
                    } elseif ($host == 'milagrow.net/105-lawn-robots' || $host=='milagrowhumantech.com/content/category/2-buying-guides' || $host == 'milagrow.net/115-lawn-robot-models'  || $host == 'milagrow.net/123-lawn-robot-accessories' || $host === 'milagrow.net/lawn-robot-accessories/302-virtual-wire.html' || $host == 'milagrow.net/lawn-robot-accessories/303-peges.html' || $host =='milagrow.net/lawn-robot-accessories/305-docking-station.html' || $host == 'milagrow.net/remote/344-robo-nicklaus-20.html' || $host =='milagrow.net/batteries/392-nicklaus-20-battery.html' || $host == 'milagrow.net/blades/412-lawn-robots-blades-for-nicklaus20.html' || $host == 'milagrow.net/charger/416-lawn-robots-charger-for-robo-nicklaus20-tiger-20.html' || $host == 'milagrow.net/batteries/413-robo-nicklaus-20-battery.html' || $host == 'milagrow.net/docking-station/415-robo-tiger-20-tiger-10-docking-station.html' || $host == 'milagrow.net/batteries/392-nicklaus-20-battery.html' || $host == 'milagrow.net/batteries/413-robo-nicklaus-20-battery.html' || $host == 'milagrow.net/141-batteries' || $host == 'milagrow.net/146-remote' || $host == 'milagrow.net/145-docking-station' || $host == 'milagrow.net/144-blades' || $host == 'milagrow.net/143-pegs' || $host == 'milagrow.net/142-virtual-wire' || $host == 'milagrow.net/151-charger') {
                        $send = Mail::Send($id_lang, 'gosf_ln', $sub, $vars, $email);
                    } 
                	else if($host=='http://milagrow.net/lawn-robots/232-robotiger-10-8908002152715.html'||$host == 'milagrow.net/lawn-robots/231-robotiger-20.html'||$host=='milagrow.net/lawn-robots/231-robotiger-20-8908002152692.html'||$host=='http://milagrow.net/lawn-robots/232-robotiger-10-8908002152715.html' || $host == 'milagrow.net/lawn-robots/232-robotiger-10.html' )
                	{
                		 $send = Mail::Send($id_lang, 'gosf_robotiger2', $sub, $vars, $email);
                	}
                    elseif ($host == 'milagrow.net/lawn-robots/229-robonicklaus-20.html' || $host=='milagrow.net/lawn-robots/229-robonicklaus-20-8908002152708.html'){
                        $send = Mail::Send($id_lang, 'gosf_ln_rb_nick', $sub, $vars, $email);
                    } elseif ($host == 'milagrow.net/113-pool-robots' || $host=='milagrow.net/content/category/12-buying-guide-for-pool-robots' || $host=='milagrow.net/content/62-pool-robots' || $host == 'milagrow.net/114-pool-robot-models' || $host == 'milagrow.net/122-pool-robot-accessories' || $host == 'milagrow.net/pool-robot-accessories/299-caddy.html' || $host == 'milagrow.net/pool-robot-accessories/300-dustbin.html' || $host == 'milagrow.net/pool-robot-accessories/298-charger-cable.html' || $host == 'milagrow.net/pool-robot-accessories/322-remote.html' || $host == 'milagrow.net/pool-robot-accessories/323-charger-.html' || $host == 'milagrow.net/pool-robot-accessories/298-charger-cable.html' || $host == 'milagrow.net/pool-robot-accessories/323-charger-.html' || $host == 'milagrow.net/pool-robot-accessories/299-caddy.html' || $host == 'milagrow.net/pool-robot-accessories/300-dustbin.html' || $host == 'milagrow.net/pool-robot-accessories/322-remote.html') {
                        $send = Mail::Send($id_lang, 'gosf_pr', $sub, $vars, $email);
                   // } elseif ($host == 'milagrow.net/114-pool-robot-models'){
                       // $send = Mail::Send($id_lang, 'gosf_pr_model', $sub, $vars, $email);
                   // } elseif ($host == 'milagrow.net/122-pool-robot-accessories'){
                     //   $send = Mail::Send($id_lang, 'gosf_pr_access', $sub, $vars, $email);
                    } elseif ($host=='milagrow.net/pool-robots/233-robophelps-true-blue-8908002152753.html' || $host == 'milagrow.net/pool-robots/233-robophelps-true-blue.html' || $host == 'milagrow.net/138-charger-cable' || $host == 'milagrow.net/139-caddy' || $host == 'milagrow.net/140-dustbin' || $host == 'milagrow.net/152-remote') {
                        $send = Mail::Send($id_lang, 'gosf_pr_15', $sub, $vars, $email);
                    } elseif ($host == 'milagrow.net/pool-robots/419-milagrow-robophelps20.html'|| $host=='milagrow.net/pool-robots/419-milagrow-robophelps20-8908002152111.html') {
                        $send = Mail::Send($id_lang, 'gosf_pr_20', $sub, $vars, $email);
                    } elseif ($host == 'milagrow.net/pool-robots/420-milagrow-robophelps25.html' || $host=='milagrow.net/pool-robots/420-milagrow-robophelps25-8908002152135.html') {
                        $send = Mail::Send($id_lang, 'gosf_pr_25', $sub, $vars, $email);
                    } elseif ($host == 'milagrow.net/pool-robots/421-milagrow-robophelps30.html' || $host=='milagrow.net/pool-robots/421-milagrow-robophelps30-8908002152142.html') {
                        $send = Mail::Send($id_lang, 'gosf_pr_30', $sub, $vars, $email);
                    } 
                    elseif ($host == 'milagrow.net/6-tabtop-pcs' || $host == 'milagrow.net/11-android-models' || $host == 'milagrow.net/27-tabtop-accessories') {
                        $send = Mail::Send($id_lang, 'gosf_m2pro32gb', $sub, $vars, $email);
                    } elseif ($host == 'milagrow.net/quad-core/75-104-pro-3g-sim-quad-core-16gb.html' || $host=='milagrow.net/content/15-tablet-pcs' || $host=='milagrow.net/content/category/3-buying-guides-for-tabtops') {
                        $send = Mail::Send($id_lang, 'gosf_m2pro32gb', $sub, $vars, $email);
                    } elseif ($host == 'milagrow.net/quad-core/226-m2-pro-3g-32gb-84-quad-core.html' || $host == 'milagrow.net/90-quad-core' || $host == 'milagrow.net/30-cases-covers-pouches' || $host == 'milagrow.net/34-charger-adapters' || $host == 'milagrow.net/35-connectors-cables' || $host == 'milagrow.net/41-screen-protection' || $host == 'milagrow.net/45-speakers-headsets' || $host == 'milagrow.net/148-power-banks') {
                        $send = Mail::Send($id_lang, 'gosf_m2pro32gb', $sub, $vars, $email);
                    } elseif ($host == 'milagrow.net/quad-core/227-m2-pro-3g-16gb-84-quad-core.html') {
                        $send = Mail::Send($id_lang, 'gosf_m2pro32gb', $sub, $vars, $email);
                    } elseif ($host == 'milagrow.net/dual-core/228-m2-pro-3g-8gb-74-dual-core.html' || $host == 'milagrow.net/89-dual-core') {
                        $send = Mail::Send($id_lang, 'gosf_m2pro32gb', $sub, $vars, $email);
                    } elseif ($host == 'milagrow.net/10-mounts' || $host == 'milagrow.net/15-ceiling-mount-models' || $host=='milagrow.net/wall-mount-models/208-double-arm-articulating-wall-mount-704-refurbished.html' || $host == 'milagrow.net/16-wall-rack-models' || $host == 'milagrow.net/17-wall-mount-models' || $host == 'milagrow.net/ceiling-mount-models/24-ceiling-mount-300a.html' || $host == 'milagrow.net/wall-rack-models/25-accessories-wall-rack-001.html' || $host == 'milagrow.net/wall-mount-models/30-single-arm-articulating-wall-mount-222.html' || $host == 'milagrow.net/wall-mount-models/33-double-arm-articulating-wall-mount-723.html' || $host == 'milagrow.net/wall-mount-models/34-quad-arm-fulcrum-wall-mount-4011.html' || $host == 'milagrow.net/wall-mount-models/170-double-arm-articulating-wall-mount-704.html' || $host=='http://milagrow.net/content/19-tv-mounts') {
                        $send = Mail::Send($id_lang, 'gosf_mounts', $sub, $vars, $email);
                    } elseif ($host == 'milagrow.net/86-window-robots' || $host=='milagrow.net/window-robots/556-milagrow-robosnail10.html' || $host=='milagrow.net/content/17-robotic-window-cleaners' || $host=='milagrow.net/frameless-windows/509-milagrow-ecovacs-winbot-930.html' || $host=='milagrow.net/window-robots/557-milagrow-robosnail12.html' || $host=='milagrow.net/frameless-windows/211-milagrow-ecovacs-winbot-730-6943757602056.html' || $host=='milagrow.net/window-robots/555-milagrow-hobot188.html' || $host == 'milagrow.net/135-window-robot-models' || $host == 'milagrow.net/93-winbot' || $host == 'milagrow.net/81-chargers-cables' || $host == 'milagrow.net/83-detergent' || $host == 'milagrow.net/79-cleaning-pads-cupule' || $host == 'milagrow.net/80-remotes' || $host == 'milagrow.net/accessories/191-winbot-7-safety-pod.html' || $host == 'milagrow.net/chargers-cables/185-winbot-7-charger.html' || $host == 'milagrow.net/chargers-cables/186-winbot-7-extension-cable.html' || $host == 'milagrow.net/detergent/74-robot-detergent.html' || $host == 'milagrow.net/detergent/187-winbot-7-detergent-100ml-35-oz.html' || $host == 'milagrow.net/cleaning-pads-cupule/173-windoro-cleaning-pads-40pcs.html' || $host == 'milagrow.net/cleaning-pads-cupule/175-winbot-7-cleaning-pads-set-of-3.html' || $host == 'milagrow.net/cleaning-pads-cupule/176-windoro-edge-cleaners-set-of-20.html' || $host == 'milagrow.net/cleaning-pads-cupule/181-winbot-7-cupule-gasket-set-of-2.html' || $host == 'milagrow.net/remotes/183-winbot-7-remote.html' || $host == 'milagrow.net/77-window-robot-accessories') {
                        $send = Mail::Send($id_lang, 'gosf_wr', $sub, $vars, $email);
                    } elseif ($host == 'milagrow.net/content/27-offers-zone-') {
                        $send = Mail::Send($id_lang, 'gosf_ofr', $sub, $vars, $email);
                    }
                    else if($host == 'milagrow.net/floor-robots/505-milagrow-blackcat3-0-india-s-longest-battery-life-floor-cleaner-8908002152678.html')
                    {
                    	 $send = Mail::Send($id_lang, 'gosf_blck_cat', $sub, $vars, $email);
                    }
                    //send mailer while registering through aguabot 5.0 product page
                    else if($host=='milagrow.net/floor-robots/506-milagrow-ecovacs-deebot-dm-85.html'||$host== 'milagrow.net/floor-robots/504-milagrow-aguabot-4-0-robotic-floor-cleaner-with-water-tank-8908002152081.html'||$host== 'milagrow.net/floor-robots/575-milagrow-aguabot-5-0-indias-1st-full-wetmopping-and-drycleaning-floor-robovac-8908002152081.html')
                    {
                    	 $send = Mail::Send($id_lang, 'gosf_ag5', $sub, $vars, $email);
                    }
                     //send mailer while registering through aguabot 4.0 product page
                   
                     //new mailer added for redhawk 3.0
                     else if($host=='milagrow.net/floor-robots/503-milagrow-redhawk3-0-india-s-number-1-floor-robots-8908002152012.html')
                     {
                     	$send = Mail::Send($id_lang, 'gosf_fr_redhawk3', $sub, $vars, $email);
                     }
                     //new mailer added for black cat 3.0
               		  else if($host=='milagrow.net/floor-robots/505-milagrow-blackcat3-0-india-s-longest-battery-life-floor-cleaner-8908002152678.html')
                     {
                     	$send = Mail::Send($id_lang, 'gosf_fr_blackcat3', $sub, $vars, $email);
                     }
                     //new mailer added robo phelps 40 Turbo
                	elseif ($host == 'milagrow.net/pool-robots/502-milagrow-robophelps40turbo.html') {
                        $send = Mail::Send($id_lang, 'gosf_pr_rp40', $sub, $vars, $email);
                    }
                    else {
                        $send = Mail::Send($id_lang, 'gosf_fr', $sub, $vars, $email);
                    }
                    $send2 = Mail::Send($id_lang, 'gosf_admin', $sub_admin, $vars, $email_admin);


                    $successfully = '<font color="green" size="2" class="green">Registration Successful.</font>';
                    $smarty->assign('inserted', $successfully);


                    $cookie->id_customer = intval($customer->id);
                    $cookie->customer_lastname = $customer->lastname;
                    $cookie->customer_firstname = $customer->firstname;
                    $cookie->logged = 1;
                    $cookie->secure_key = $customer->secure;
                    $cookie->passwd = $customer->passwd;
                    $cookie->email = $customer->email;


                    if ($send) {
                        $smarty->assign('mail', 'Email sent');
                    } else {
                        $smarty->assign('mail', 'Email not sent');
                    }


                } else {
                    echo "not insert";
                }

            }
        } // end registeration form for GOSF page		


        // $sql="INSERT INTO ps_test2 (`name`, `email`) VALUES (10, 'myName')";
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "test2";
        $results = Db::getInstance()->executeS($sql);


        //$smarty->assign('hello', $aa);
        $smarty->assign('sql', $results);
        $smarty->assign('ENT_QUOTES', ENT_QUOTES);
        $smarty->assign('firstname', 'Doug');
        $smarty->assign('lastname', 'Evans');
        $smarty->assign('meetingPlace', 'New York');
        if (file_exists('modules/hello/logo-footer.jpg')) {
            $smarty->assign('logo2', 'modules/hello/logo-footer.jpg');
        } else {
            $smarty->assign('logo2', null);
        }
        $FOOTERdescription = Configuration::get('FOOTER_DESC');
        $smarty->assign('description', $FOOTERdescription);
        return $this->display(__FILE__, 'register_popup.tpl');
    }



    /* public function hookHeader($params) {

     return $this->display(__FILE__, 'register_popup.tpl');

     }*/

    /* public function hookHeader() {
       $this->context->controller->addCSS(($this->_path).'css/store_styles.css', 'all');
        $this->context->smarty->assign(array('base_u' => 'http://etc...'));

     }
   */

}