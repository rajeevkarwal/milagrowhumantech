<?php
/**
 * Created by PhpStorm.
 * User: hitanshu
 * Date: 25/11/13
 * Time: 10:09 PM
 */
 //include('config/smarty.config.inc.php'); 
 include(dirname(__FILE__).'/tools.php');


class Register_Popup extends Module {
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
	
	
	
  public function getContent() {
        
 if (Tools::isSubmit('submit_reg') ) {
            
            $this->_displayReg();
        }
       
        
      }
 
/* private function _displayReg() {
	 
	        Db::getInstance()->Execute('
            INSERT INTO `' . _DB_PREFIX_ . 'test2` (`name`,`email`) 
            VALUES("' . Tools::getValue('name') . '", ' . Tools::getValue('email') . ')');

              
               
            }*/
 
  
  
 private function _displayForm() {
        global $smarty;
		 $sql="SELECT * FROM "._DB_PREFIX_."test2";
 $results = Db::getInstance()->executeS($sql);
$smarty->assign('hi', 'hi');
  return $this->display(__FILE__, 'hello.tpl');
		
        
 }
    
  
  
  function hookFooter($params)
{ global $smarty;

 
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
 if (Tools::isSubmit('submit_reg') ) {
            
			 $gender = Tools::getValue('id_gender');
			 $f_name = Tools::getValue('f_name');
			 $l_name = Tools::getValue('l_name');
		     $email = Tools::getValue('email');
			 $pwd1 = Tools::getValue('pwd');
			 $pwd=Tools::encrypt($pwd1);
			 $bday = (empty($_POST['years']) ? '' : (int)$_POST['years'] . '-' . (int)$_POST['months'] . '-' . (int)$_POST['days']);
			 $date_added=date("Y-m-d H:i:s",time());
 			 $date_updated=$date_added;
             $last_pass_gen=$date_added;
			 $newsletter='1';
			 $ip = pSQL(Tools::getRemoteAddr());
			 $optin='1';
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
			  
			  
		if (Customer::customerExists($email))
		{
			$emailexist='<font color="red" size="2" class="red">You have already registered. Please login to enjoy shopping or just close the popup.</font>';
			$smarty->assign('email_exist', $emailexist);
		} 
		else
		{
            //$sql2="INSERT INTO `ps_test2` (`firstname`, `email`, `id_gender`, `passwd`, `birthday`) VALUES ('".$f_name."', '".$email."', '".$gender."', '".$pwd."', '".$bday."' )";
			//$sql2= "INSERT into "._DB_PREFIX_."customer (`id_gender`,`id_default_group`,`id_lang`, `firstname`,`lastname`,`email`,`passwd`,`last_passwd_gen`,`birthday`,`newsletter`,`ip_registration_newsletter`,`optin`,`active`,`date_add`,`date_upd`,`max_payment_days`,`secure_key` ) values ('".$gender."','3', '1','".$f_name."','".$l_name."','".$email."','".$pwd."','".$last_pass_gen."','".$bday."','".$newsletter."','".$ip."','".$optin."','1','".$date_added."','".$date_updated."','".$maxpay."','".$s_key."') ";
			
			$sql2 ="INSERT INTO  "._DB_PREFIX_."customer (`id_gender`, `id_default_group`, `id_lang`, `id_risk`, `firstname`, `lastname`, `email`, `passwd`, `last_passwd_gen`, `birthday`, `newsletter`, `ip_registration_newsletter`, `optin`, `active`, `date_add`, `date_upd`, `max_payment_days`, `secure_key`) VALUES ('".$gender."', '3', '1', '0', '".$f_name."', '".$l_name."', '".$email."', '".$pwd."', '".$last_pass_gen."', '".$bday."', '".$newsletter."', '".$ip."', '".$optin."', '1', '".$date_added."', '".$date_updated."', '".$maxpay."', '".$s_key."')";
				    $result2=Db::getInstance()->execute($sql2);
					
					$insert_id=(int)Db::getInstance()->Insert_ID();
					 $tbl=pSQL(_DB_PREFIX_.'customer_group');
  					 Db::getInstance()->Execute("DELETE FROM $tbl WHERE id_customer='".$insert_id."'");
 					 $query= "INSERT into $tbl (`id_customer`,`id_group`) values ('".$insert_id."','3') ";
					 Db::getInstance()->Execute($query);
					
					
					if($result2)
					{
						//echo "insert successfully";
						//$send = Mail::Send($to,$subject,$message,$header);
						$protocol_content = (Configuration::get('PS_SSL_ENABLED')) ? 'https://' : 'http://';
						$link=$protocol_content.$_SERVER['HTTP_HOST'];
						$sub="Thank You For Registration";
						$vars = array(
								'{firstname}' => $f_name, 
								'{lastname}' => $l_name, 
								'{email}' => $email,
								'{passwd}'=> $pwd1
						);
         			 	$id_lang = (int)Configuration::get('PS_LANG_DEFAULT');
						$send = Mail::Send($id_lang, 'account',$sub, $vars, $email);
		
		
						$successfully='<font color="green" size="2" class="green">Registration successful.</font>';
						$smarty->assign('inserted', $successfully);
						
						
						$cookie->id_customer = intval($customer->id);
            $cookie->customer_lastname = $customer->lastname;
            $cookie->customer_firstname = $customer->firstname;
            $cookie->logged = 1;
            $cookie->secure_key = $customer->secure;
            $cookie->passwd = $customer->passwd;
            $cookie->email = $customer->email;
						
						
						if($send)
						{
							$smarty->assign('mail', 'Email sent');
						}
						else
						{
							$smarty->assign('mail', 'Email not sent');
						}
						
	
					}
					else
					{ 
					   echo "not insert";
					}
					
		       }
        }
		
		
		
 if (Tools::isSubmit('submit_reg2') ) { // registeration form for GOSF page
            
			 $gender = Tools::getValue('id_gender');
			 $f_name = Tools::getValue('f_name');
			 $l_name = Tools::getValue('l_name');
		     $email = Tools::getValue('email');
			 $pwd1 = Tools::getValue('pwd');
			 $pwd=Tools::encrypt($pwd1);
			 $bday = (empty($_POST['years']) ? '' : (int)$_POST['years'] . '-' . (int)$_POST['months'] . '-' . (int)$_POST['days']);
			 $date_added=date("Y-m-d H:i:s",time());
 			 $date_updated=$date_added;
             $last_pass_gen=$date_added;
			 $newsletter='1';
			 $ip = pSQL(Tools::getRemoteAddr());
			 $optin='1';
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
			  
			  
		if (Customer::customerExists($email))
		{
			$emailexist='<font color="red" size="2" class="red">You have already registered. Please login to enjoy shopping or just close the popup.</font>';
			$smarty->assign('email_exist', $emailexist);
		} 
		else
		{
            //$sql2="INSERT INTO `ps_test2` (`firstname`, `email`, `id_gender`, `passwd`, `birthday`) VALUES ('".$f_name."', '".$email."', '".$gender."', '".$pwd."', '".$bday."' )";
			//$sql2= "INSERT into "._DB_PREFIX_."customer (`id_gender`,`id_default_group`,`id_lang`, `firstname`,`lastname`,`email`,`passwd`,`last_passwd_gen`,`birthday`,`newsletter`,`ip_registration_newsletter`,`optin`,`active`,`date_add`,`date_upd`,`max_payment_days`,`secure_key` ) values ('".$gender."','3', '1','".$f_name."','".$l_name."','".$email."','".$pwd."','".$last_pass_gen."','".$bday."','".$newsletter."','".$ip."','".$optin."','1','".$date_added."','".$date_updated."','".$maxpay."','".$s_key."') ";
			
			$sql2 ="INSERT INTO  "._DB_PREFIX_."customer (`id_gender`, `id_default_group`, `id_lang`, `id_risk`, `firstname`, `lastname`, `email`, `passwd`, `last_passwd_gen`, `birthday`, `newsletter`, `ip_registration_newsletter`, `optin`, `active`, `date_add`, `date_upd`, `max_payment_days`, `secure_key`) VALUES ('".$gender."', '3', '1', '0', '".$f_name."', '".$l_name."', '".$email."', '".$pwd."', '".$last_pass_gen."', '".$bday."', '".$newsletter."', '".$ip."', '".$optin."', '1', '".$date_added."', '".$date_updated."', '".$maxpay."', '".$s_key."')";
				    $result2=Db::getInstance()->execute($sql2);
					
					$insert_id=(int)Db::getInstance()->Insert_ID();
					 $tbl=pSQL(_DB_PREFIX_.'customer_group');
  					 Db::getInstance()->Execute("DELETE FROM $tbl WHERE id_customer='".$insert_id."'");
 					 $query= "INSERT into $tbl (`id_customer`,`id_group`) values ('".$insert_id."','3') ";
					 Db::getInstance()->Execute($query);
					 
					  $gosf_coupon_sql="SELECT code FROM "._DB_PREFIX_."cart_rule where id_cart_rule='286'";
 					  $gosf_coupon_code = Db::getInstance()->executeS($sql);
					
					
					if($result2)
					{
						//echo "insert successfully";
						//$send = Mail::Send($to,$subject,$message,$header);
						$protocol_content = (Configuration::get('PS_SSL_ENABLED')) ? 'https://' : 'http://';
						$link=$protocol_content.$_SERVER['HTTP_HOST'];
						$q_url=strtok($_SERVER["REQUEST_URI"],'?');
						$url=$_SERVER['HTTP_HOST'].$q_url;
						$sub="Thank You For Registration".'     '.$email;
						$sub_admin="New Registration by".'     '.$email;
						$host = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
						$vars = array(
								'{firstname}' => $f_name, 
								'{lastname}' => $l_name, 
								'{email}' => $email,
								'{passwd}'=> $pwd1,
								'{page_url}'=> $url
						);
         			 	$id_lang = (int)Configuration::get('PS_LANG_DEFAULT');
						$smarty->assign('gosf_coupon_code', $gosf_coupon_code);
						//$send = Mail::Send($id_lang, 'gosf',$sub, $vars, $email);
							if($host=='milagrowhumantech.com' || $host=='milagrowhumantech.com/'){
							$send = Mail::Send($id_lang, 'gosf',$sub, $vars, $email);
							}
						elseif($host=='milagrowhumantech.com/87-body-robots' || $host=='milagrowhumantech.com/body-robots/23-robotic-body-massager.html' || $host=='milagrowhumantech.com/body-robots/90-robotic-body-massager-blue.html')
							{ $send = Mail::Send($id_lang, 'gosf_br',$sub, $vars, $email);}
						elseif($host=='milagrowhumantech.com/85-floor-robots' || $host=='milagrowhumantech.com/85-floor-robots/' || $host=='milagrowhumantech.com/85-floor-robots/#')						{ $send = Mail::Send($id_lang, 'gosf_fr',$sub, $vars, $email);}
						
						elseif($host=='milagrowhumantech.com/105-lawn-robots' || $host=='milagrowhumantech.com/lawn-robots/229-robonicklaus-20.html' || $host=='milagrowhumantech.com/lawn-robots/231-robotiger-20.html' || $host=='milagrowhumantech.com/lawn-robots/232-robotiger-10.html' || $host=='milagrowhumantech.com/123-lawn-robot-accessories' || $host==='milagrowhumantech.com/lawn-robot-accessories/302-virtual-wire.html' || $host=='milagrowhumantech.com/lawn-robot-accessories/303-peges.html' || $host='milagrowhumantech.com/lawn-robot-accessories/305-docking-station.html' || $host=='milagrowhumantech.com/remote/344-robo-nicklaus-20.html' || $host='milagrowhumantech.com/batteries/392-nicklaus-20-battery.html' || $host=='milagrowhumantech.com/blades/412-lawn-robots-blades-for-nicklaus20.html' || $host=='milagrowhumantech.com/charger/416-lawn-robots-charger-for-robo-nicklaus20-tiger-20.html' || $host=='milagrowhumantech.com/batteries/413-robo-nicklaus-20-battery.html' || $host=='milagrowhumantech.com/docking-station/415-robo-tiger-20-tiger-10-docking-station.html' || $host=='milagrowhumantech.com/batteries/392-nicklaus-20-battery.html' || $host=='milagrowhumantech.com/batteries/413-robo-nicklaus-20-battery.html')
						{ $send = Mail::Send($id_lang, 'gosf_ln',$sub, $vars, $email);}
						
						elseif($host=='milagrowhumantech.com/113-pool-robots' || $host=='milagrowhumantech.com/pool-robots/233-robophelps-true-blue.html' || $host=='milagrowhumantech.com/pool-robots/419-milagrow-robophelps20.html' || $host=='milagrowhumantech.com/pool-robots/420-milagrow-robophelps25.html' || $host=='milagrowhumantech.com/pool-robots/421-milagrow-robophelps30.html' || $host=='milagrowhumantech.com/122-pool-robot-accessories' || $host=='milagrowhumantech.com/pool-robot-accessories/299-caddy.html' || $host=='milagrowhumantech.com/pool-robot-accessories/300-dustbin.html' || $host=='milagrowhumantech.com/pool-robot-accessories/298-charger-cable.html' || $host=='milagrowhumantech.com/pool-robot-accessories/322-remote.html' || $host=='milagrowhumantech.com/pool-robot-accessories/323-charger-.html' || $host=='milagrowhumantech.com/pool-robot-accessories/298-charger-cable.html' || $host=='milagrowhumantech.com/pool-robot-accessories/323-charger-.html' || $host=='milagrowhumantech.com/pool-robot-accessories/299-caddy.html' || $host=='milagrowhumantech.com/pool-robot-accessories/300-dustbin.html' || $host=='milagrowhumantech.com/pool-robot-accessories/322-remote.html')	
						{ $send = Mail::Send($id_lang, 'gosf_pr',$sub, $vars, $email);}
						elseif($host=='milagrowhumantech.com/6-tabtop-pcs' || $host=='milagrowhumantech.com/quad-core/75-104-pro-3g-sim-quad-core-16gb.html' || $host=='milagrowhumantech.com/quad-core/226-m2-pro-3g-32gb-84-quad-core.html' || $host=='milagrowhumantech.com/quad-core/227-m2-pro-3g-16gb-84-quad-core.html' || $host=='milagrowhumantech.com/dual-core/228-m2-pro-3g-8gb-74-dual-core.html')
						{ $send = Mail::Send($id_lang, 'gosf_tab_pc',$sub, $vars, $email);}
						elseif($host=='milagrowhumantech.com/10-mounts' || $host=='milagrowhumantech.com/ceiling-mount-models/24-ceiling-mount-300a.html' || $host=='milagrowhumantech.com/wall-rack-models/25-accessories-wall-rack-001.html' || $host=='milagrowhumantech.com/wall-mount-models/30-single-arm-articulating-wall-mount-222.html' || $host=='milagrowhumantech.com/wall-mount-models/33-double-arm-articulating-wall-mount-723.html' || $host=='milagrowhumantech.com/wall-mount-models/34-quad-arm-fulcrum-wall-mount-4011.html' || $host=='milagrowhumantech.com/wall-mount-models/170-double-arm-articulating-wall-mount-704.html')
						{ $send = Mail::Send($id_lang, 'gosf_mount',$sub, $vars, $email);}
						
						elseif($host=='milagrowhumantech.com/86-window-robots' || $host=='milagrowhumantech.com/135-window-robot-models' || $host=='milagrowhumantech.com/93-winbot' || $host=='milagrowhumantech.com/81-chargers-cables' || $host=='milagrowhumantech.com/83-detergent' || $host=='milagrowhumantech.com/79-cleaning-pads-cupule' || $host=='milagrowhumantech.com/80-remotes' || $host=='milagrowhumantech.com/accessories/191-winbot-7-safety-pod.html' || $host=='milagrowhumantech.com/chargers-cables/185-winbot-7-charger.html' || $host='milagrowhumantech.com/chargers-cables/186-winbot-7-extension-cable.html' || $host='milagrowhumantech.com/detergent/74-robot-detergent.html' || $host='milagrowhumantech.com/detergent/187-winbot-7-detergent-100ml-35-oz.html' || $host='milagrowhumantech.com/cleaning-pads-cupule/173-windoro-cleaning-pads-40pcs.html' || $host='milagrowhumantech.com/cleaning-pads-cupule/175-winbot-7-cleaning-pads-set-of-3.html' || $host='milagrowhumantech.com/cleaning-pads-cupule/176-windoro-edge-cleaners-set-of-20.html' || $host='milagrowhumantech.com/cleaning-pads-cupule/181-winbot-7-cupule-gasket-set-of-2.html' || $host='milagrowhumantech.com/remotes/183-winbot-7-remote.html')
						{ $send = Mail::Send($id_lang, 'gosf_wr',$sub, $vars, $email);}
							else
							{ $send = Mail::Send($id_lang, 'gosf_fr',$sub, $vars, $email);}
						$send2 =  Mail::Send($id_lang, 'gosf_admin',$sub_admin, $vars, $email_admin);
		
		
						$successfully='<font color="green" size="2" class="green">Registration Successful.</font>';
						$smarty->assign('inserted', $successfully);
						
						
						 $cookie->id_customer = intval($customer->id);
            $cookie->customer_lastname = $customer->lastname;
            $cookie->customer_firstname = $customer->firstname;
            $cookie->logged = 1;
            $cookie->secure_key = $customer->secure;
            $cookie->passwd = $customer->passwd;
            $cookie->email = $customer->email;
						
						
						if($send)
						{
							$smarty->assign('mail', 'Email sent');
						}
						else
						{
							$smarty->assign('mail', 'Email not sent');
						}
						
	
					}
					else
					{ 
					   echo "not insert";
					}
					
		       }
        } // end registeration form for GOSF page		
		


  // $sql="INSERT INTO ps_test2 (`name`, `email`) VALUES (10, 'myName')";
   $sql="SELECT * FROM "._DB_PREFIX_."test2";
 $results = Db::getInstance()->executeS($sql);
 

			

			
 
  //$smarty->assign('hello', $aa);
   $smarty->assign('sql', $results);
    $smarty->assign('ENT_QUOTES', ENT_QUOTES);
	$smarty->assign('firstname', 'Doug');
$smarty->assign('lastname', 'Evans');
$smarty->assign('meetingPlace', 'New York');
    if( file_exists('modules/hello/logo-footer.jpg')){
        $smarty->assign('logo2','modules/hello/logo-footer.jpg');
    } else {
        $smarty->assign('logo2', null);
    }
    $FOOTERdescription=Configuration::get('FOOTER_DESC');
    $smarty->assign('description',$FOOTERdescription );
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