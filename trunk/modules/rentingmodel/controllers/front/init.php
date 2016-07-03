<?php
define('NOTIFICATION_BEFORE_PAYMENT', 'cs@milagrow.in');
define('NOTIFY_OUR_TEAM', 'cs@milagrow.in');
session_destroy();
session_start();
include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/../../init.php');
include_once(_PS_MODULE_DIR_ . 'rentingmodel/RentingPdf.php');
include_once(_PS_MODULE_DIR_ . 'rentingmodel/SecurityPdf.php');

class RentingModelInitModuleFrontController extends ModuleFrontController
{
    public $display_column_left=true;
    public function postProcess()
    {
    	global $cookie;

		$fileAttachment=null;
		$data['type']=Tools::getValue('occupation');
		$type=$data['type'];
		$data['name']=Tools::getValue('name');
		$data['email']=Tools::getValue('email');
		$data['contact_number']=Tools::getValue('contact_number');
		$data['address']=Tools::getValue('address');
		$data['date_of_birth']=Tools::getValue('date_of_birth');
		$data['product_id']=Tools::getValue('product');
		$data['category_id']=Tools::getValue('category');
		$data['payment_mode']=0;
		$data['payment_duration']=Tools::getValue('payment_duration');
		$data['monthly_rental']=Tools::getValue('monthly_rental');
		$data['product_price']=Tools::getValue('product_price');
		$data['security_deposited']=Tools::getValue('security_deposited');
		$data['status']=0;
		$data['year_of_establishment']=Tools::getValue('establishment_year');
		//$data['state']=$this->getStateName(Tools::getValue('state'));
		$zipcode=Tools::getValue('zipcode');
		$data['city']=$this->getCityName($zipcode);
		$data['state']=$this->getStateName($zipcode);
		 if (isset($_FILES['file1']['name']) && !empty($_FILES['file1']['name']) && !empty($_FILES['file1']['tmp_name']))
			 {
				
                $extension = array('.rtf', '.doc', '.docx', '.pdf', '.jpeg', '.png', '.jpg');
                $filename1 = uniqid() . substr($_FILES['file1']['name'], -5);
                 $fileAttachment['content'] = file_get_contents($_FILES['file1']['tmp_name']);
                $fileAttachment['name'] = $_FILES['file1']['name'];
                $fileAttachment['mime'] = $_FILES['file1']['type'];
				$data['image_url']=$filename1;		
            }
     if (isset($_FILES['file2']['name']) && !empty($_FILES['file2']['name']) && !empty($_FILES['file2']['tmp_name']))
			 {
				
                $extension = array('.rtf', '.doc', '.docx', '.pdf', '.jpeg', '.png', '.jpg');
                $filename2 = uniqid() . substr($_FILES['file2']['name'], -5);
                 $fileAttachment['content'] = file_get_contents($_FILES['file2']['tmp_name']);
                $fileAttachment['name'] = $_FILES['file2']['name'];
                $fileAttachment['mime'] = $_FILES['file2']['type'];
				$data['id_url']=$filename2;		
            }
     if (isset($_FILES['file3']['name']) && !empty($_FILES['file3']['name']) && !empty($_FILES['file3']['tmp_name']))
			 {
				
                $extension = array('.rtf', '.doc', '.docx', '.pdf', '.jpeg', '.png', '.jpg');
                $filename3 = uniqid() . substr($_FILES['file3']['name'], -5);
                 $fileAttachment['content'] = file_get_contents($_FILES['file3']['tmp_name']);
                $fileAttachment['name'] = $_FILES['file3']['name'];
                $fileAttachment['mime'] = $_FILES['file3']['type'];
				$data['address_url']=$filename3;		
            }
   
		if(!empty($data['name']) || !empty($data['email']) ||!empty($data['contact_number']) || !empty($data['address']) || !empty($data['date_of_birth']) 
			|| !empty($data['product_id']) ||
		! empty($data['category_id']) || !empty($data['payment_mode']) || !empty($data['payment_duration']) ||!empty($data['monthly_rental']) ||
		!empty($data['monthly_price']) ||!empty($data['security_deposited']))
		{
		
		
		if($cookie->isLogged())
		{
			$customerId=$cookie->id_customer;
		}else
		{
			
			//here we have to insert the data to the customer table
			$customerData=Customer::getByEmail($data['email']);
		   if(!empty($customerData->id))
			{
				$customerId=$customerData->id;
			}
			else
			{
				$gender='1';
				$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
				$actualPassword=substr(str_shuffle($chars),0,8);
				$pwd=Tools::encrypt($actualPassword);
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
				$sql2 = "INSERT INTO  " . _DB_PREFIX_ . "customer (`id_gender`, `id_default_group`, `id_lang`, `id_risk`, `firstname`, `lastname`, `email`, `passwd`, `last_passwd_gen`, `newsletter`, `ip_registration_newsletter`, `optin`, `active`, `date_add`, `date_upd`, `max_payment_days`, `secure_key`) VALUES ('" . $gender . "', '3', '1', '0', '" . mysql_real_escape_string($data['name']) . "', '" . 'lastname'."', '" . $data['email'] . "', '" . $pwd . "', '" . $last_pass_gen . "', '" . $newsletter . "', '" . $ip . "', '" . $optin . "', '1', '" . $date_added . "', '" . $date_updated . "', '" . $maxpay . "', '" . mysql_real_escape_string($s_key) . "')";
					$result2 = Db::getInstance()->execute($sql2);
					$customerId = (int)Db::getInstance()->Insert_ID();
                $tbl = pSQL(_DB_PREFIX_ . 'customer_group');
                $query = "INSERT into $tbl (`id_customer`,`id_group`) values ('" . $insert_id . "','3') ";
                Db::getInstance()->Execute($query);

                //sending email to customer
                    $url = 'http://milagrowhumantech.com';
                    $sub = "Thank You For Registration at MilagrowHumantech";
                    $vars = array(
                        '{firstname}' => $data['name'],
                        '{lastname}' => '',
                        '{email}' => $data['email'],
                        '{passwd}' => $actualPassword,
                        '{page_url}' => $url
                    );
                    $id_lang = (int)Configuration::get('PS_LANG_DEFAULT');
                    $send = Mail::Send($id_lang, 'account', $sub, $vars, $data['email']); 
			}
		}
			$base_dir= _PS_MODULE_DIR_.'rentingmodel/img/';		
			 if (rename($_FILES['file1']['tmp_name'],$base_dir.'images/'.$data['image_url'])){
					$data['image_url']=$data['image_url'];					
                }
		 if (rename($_FILES['file2']['tmp_name'],$base_dir.'idProofs/'.$data['id_url'])){
					$data['id_url']=$data['id_url'];
                }
		 if (rename($_FILES['file3']['tmp_name'],$base_dir.'addressProofs/'.$data['address_url']))
					$data['address_url']=$data['address_url'];
					
			$date=new DateTime();
			$nowDate=$date->format('Y-m-d');
			$data['monthly_rental_expire']=$this->generateNewDate($nowDate,1);
			$data['tenure_expiration_date']=$this->generateNewDate($nowDate,$data['payment_duration']);
			$data['payment_status']=3;
			$data['sent_monthly_mail']=0;
			$data['sent_tenure_mail']=0;
         	$data['customer_id']=$customerId;
         	
			$result=$this->saveCustomer($data);
         	
			if($result)
			{
				echo '<script>alert("Succesfully Applied For This Request")</script>';
				$_SESSION['data']=$data;
				$_SESSION['server_name']=$_SERVER['SERVER_NAME'];
				$_SESSION['customerId']=$result;
				$_SESSION['pincode']=$zipcode;
				$this->mailToCustomer($result,$type);
				
				//Tools::redirect('myrentslip');
				header('location:myrentslip');
			}
			else
				echo $result;
				
         	
		}
    }
	private function getCityName($pincode)
	{
		$sql="select city from ps_pincode_cod where pincode=".$pincode;
		$row=Db::getInstance()->getRow($sql);
		if($row)
			return $row['city'];
		else 
			return false;
	}
	private function getStateName($pincode)
	{
		$sql="select distinct(p2.name) from ps_pincode_cod as p1,ps_state as p2 where p1.id_state=p2.id_state and pincode=".$pincode;
		$row=Db::getInstance()->getRow($sql);
		if($row)
			return $row['name'];
		else 
			return false;
		
	}
	 private function mailToCustomer($id,$type)
    	{
    		$customer=$_SESSION['data'];
    		$_SESSION['customerId']=$id;
    		if($type)
    			$customer_type="Company";
    		else 
    			$customer_type='Individual';
    		
    		$productName=$this->getProduct($customer['product_id']);
    		$date=new DateTime();
    		$nowDate=$date->format('Y-m-d');
    		$desc=$date->format('d-m-Y').'-to-'.$this->generateNewDate($date->format('d-m-Y'),$customer['payment_duration']);
    		$total=$customer['monthly_rental']+$customer['security_deposited'];
    		$data=array(
    		'{productName}'=>$productName,
    		'{name}'=>$customer['name'],
    		'{order_no}'=>$this->generateApplicationFormat($customer['category_id'],$id),
    		'{security}'=>$customer['security_deposited'],
    		'{installmentDesc}'=>$desc,
    		'{duration}'=>$customer['payment_duration'],
    		'{address}'=>$customer['address'].','.$customer['state'].','.$customer['city'],
    		'{contact_number}'=>$customer['contact_number'],
    		'{email}'=>$customer['email'],
    		'{installment_amount}'=>$customer['monthly_rental'],
    		'{total_amount}'=>$total,
    		'{date}'=>$nowDate,
    		'{link}'=>$_SERVER['SERVER_NAME'].'/view-customer?key='.md5($id),
    		'{payment}'=>'Payment Not Received',
    		'{type}'=>$customer_type
    		);
	       try
	         {
    	       
	           // $cs_Email ='kishor.pant@milagrow.in';
	            //$cs_Email ='hitanshu.malhotra@milagrow.in';
	            $subject='(Payment Not Received) Loan Request Received-'.$productName.'-#'.$id.'--'.strtoupper($customer['name']).'-'.strtoupper($customer['state']).'-'.strtoupper($customer['city']);
	            $template='first_mail';
            	if (!empty($customer['email']))
            	 {
                	 $res =Mail::Send(
                (int)1,
                $template,
                $subject,
                $data,
                $customer['email'],
                $customer['name'],
                null,
                null,
                '',
                null,
                getcwd() . _MODULE_DIR_ . 'rentingmodel/',
                false,
                null
            );
        
            //echo getcwd() . _MODULE_DIR_ . rentingmodel::MODULE_NAME . '/';
            	/*$customerCare=NOTIFICATION_BEFORE_PAYMENT;
            	//$subject="Loan Application Received #-".$id.'-'.$customer['name'];
            	$templateName='company_mail_before_payment';
            	$title="Dear Administrator";
            	if (!empty($customerCare))
            	 {
                	 $res =Mail::Send(
                (int)1,
                $templateName,
                $subject,
                $data,
                $customerCare,
                $title,
                null,
                null,
                '',
                null,
                getcwd() . _MODULE_DIR_ . 'rentingmodel/',
                false,
                null
            );
           }*/
            return $res;
         }
        }catch(Exception $e) {
			Tools::displayError();
        }
    }
    public  function initContent()
    {
    	
    	global $cookie;
    	$data=array();
        parent::initContent();
		$category_id=Tools::getValue('category_id');
		$documents=array('Indivisual','Company');
		$duration=$this->setDuration();
		$name=$this->getProductNames();
		$occupation=$this->getOccupation();
		$db_cat=$this->getCategory();
		
		//echo '<pre>';
		$loginname='';
		$email='';
		//code added by hitanshu for existing login
		if($cookie->isLogged())
		{
			$email=$cookie->email;
			$loginname=$cookie->customer_firstname.' '.$cookie->customer_lastname;
			$birthday=$cookie->birthday;
			$customerId=$cookie->id_customer;
		}
		$existingCustomerDetail=$this->getLoggedInCustomerDetail($customerId);
		$this->context->smarty->assign(array(
		'documents'=>$documents,
		'name'=>json_encode($name),
		'duration'=>$duration,
		'occupation'=>$occupation,
		'db_cat'=>$db_cat,
		'email'=>$email,
		'loginname'=>$loginname,
		'bday'=>$existingCustomerDetail['birthday'],
		'address1'=>$existingCustomerDetail['address1'].'<br>'.$existingCustomerDetail['post_code'].'<br>'.$existingCustomerDetail['city'],
		'contact_number'=>$existingCustomerDetail['phone_mobile'],
		'ajaxurl'=>json_encode($_SERVER['REQUEST_URI']),
		 'states' => $this->getStates()
		));
	
		
		$this->setTemplate('rentingmodel.tpl');
		
    }
    
 	private function getStates()
    {
        return State::getStatesByIdCountry(110);
    }
	//function get customer id from cookie and get customer other detail if customer already logged in
	function getLoggedInCustomerDetail($customerId)
	{
		$sql="select * from ps_customer where id_customer=".$customerId;
		$result=Db::getInstance()->getRow($sql);
		if($result)
		{
			return $result;
		}
		else
			return false;
	}
	function getOccupation()
	{
		$value=array('Individual','Company');
		$occupation='<select name="occupation" id="customer_occupation" onchange="changeLabel();">';
		$occupation.="<option value=''>Select Type</option>";
		
		for($i=0;$i<count($value);$i++)
		{
			$occupation.='<option value="'.$i.'">'.$value[$i].'</option>';
		}
		$occupation.='</select>';
		return $occupation;
	}
	function setDuration()
	{
		$duration='<select name="payment_duration" id="loan_duration" onchange="applyDiscount();">';
		$duration.="<option value=''>Select Duration</option>";
		
		for($i=3;$i<=24;$i+=3)
		{
			$duration.='<option value="'.$i.'">'.$i.'</option>';
		}
		$duration.='</select>';
		return $duration;
	}
	private function getProductNames()
	{


			$product_name=array();
		$catid=$this->getCategoryId();


			if(!empty($catid))
			{
				$sqlprod = 'SELECT p.name, pc.id_category AS categoryid,p.id_product,price,pr1.status FROM ps_product_lang as p  join 
ps_category_product as pc on p.id_product = pc.id_product join ps_product as pr on pr.id_product=pc.id_product join ps_product_rental as pr1 on pr1.product_id=p.id_product
where pr.active=1 and pc.id_category in ('.implode(",", $catid).')';

				if ($res = Db::getInstance()->Executes($sqlprod))
				{
					foreach($res as $product)
					{
						if($product['status'])
						$catwiseproduct[$product['categoryid']][]=array('product_name'=>$product['name'],'id_product'=>$product['id_product'],'price'=>$product['price']);
					}
				}
			}
		return $catwiseproduct;
	}
	private function getCategory()
	{
		$category=array();

		//$sql='select p1.id_category,name from ps_category_lang as p1,ps_category as p2 where p2.active=1 and p1.id_category=p2.id_category and p2.level_depth=2';
		$sql='select distinct(p1.id_category),name from ps_category_lang as p1,ps_category as p2, ps_product_rental as p3 where p2.active=1 
and p1.id_category=p2.id_category and p3.category_id=p1.id_category and p2.level_depth=2';
		$result=Db::getInstance()->executeS($sql);
		$category='<select id="category" name="category" onchange="getid();">';
		$category.="<option value=''>Select Category</option>";
		
		if($result)
		{
			foreach($result as $data)
			{
				$category.='<option value="'.$data['id_category'].'">'.$data['name'].'</option>';
				$catid[]=$data['id_category'];
			}
		}
		$category.='</select>';
		return $category;
	}
	function getCategoryId()
	{
		$catid=array();
		$sql='select p1.id_category,name from ps_category_lang as p1,ps_category as p2 where p2.active=1 and p1.id_category=p2.id_category and p2.level_depth=2';
		$result=Db::getInstance()->executeS($sql);
		if($result)
		{
			foreach ($result as $row_id)
			{
				array_push($catid,$row_id['id_category']);
			}
		}
		return $catid;
	}
	private function saveCustomer($customer)
	{
		$msg='';
		$duration=1;
		Db::getInstance()->insert('rental_customer',$customer);
		echo Db::getInstance()->getMsgError();
		$id=Db::getInstance()->Insert_ID();
		if($id)
		{	
			return $id;
		}
		else 
			return false;
		
	}
	private function getDateByCustomerId($id)
	{
		$sql='select date(applied_on)as date from ps_rental_customer where customer_id='.$id;
		$row=Db::getInstance()->getRow($sql);
		if($row)
			return $row['date'];
		else return false;
	}
	private function generateNewDate($date,$duration)
	{
			//echo 'original date'.$date;
			$date = strtotime(date("d-m-Y", strtotime($date)) . " +".$duration." month");
			$date = date("Y-m-d",$date);
			return $date;
			//echo 'new date'.$date.'duration'.$duration.'<br>';
	}
	private function getProduct($product_id)
	{
		$sql="select name from ps_product_lang where id_product=".$product_id;
		$row=Db::getInstance()->getRow($sql);
		if($row)
			return $row['name'];
		else 
			return false;
	}
 	private function downloadSecurityReceipt($loan_id)
    {
        	$orderInfo = $this->getCustomerDetailById($loan_id);
            $receiptNo = sprintf('%06d', $loan_id); 
            $content = array(
                'securityDeposited'=>$orderInfo['security_deposited'],
                'receiptNo' => $receiptNo,
                'demoDate' => $orderInfo['applied_on'],
                'demoAddress' =>  $orderInfo['name'].'<br>'.$orderInfo['address'].'<br>'.$orderInfo['contact_number'].'<br>'.$orderInfo['email'],
            'product'=>$this->getProductName($orderInfo['product_id'])
               
            );
			
            $pdf = new SecurityPdf($this->context->smarty, $this->context->language->id);
            $pdf->render(true, $content);
        }
	private function generateApplicationFormat($category_id,$customerId)
	{
		$date=new DateTime();
		$year=$date->format('Y');
		$categoryName=$this->getCategoryName($category_id);
		$string1=split(' ',$categoryName);
		$firstChar=substr($string1[0],0,1);
		$secondChar=substr($string1[1],0,1);
		return $year.'/'.$date->format('m').'/'.$firstChar.$secondChar.'/'.$customerId;
	}
	private function getCategoryName($category_id)
	{
		$sql="select name from ps_category_lang where id_category=".$category_id;
		$row=Db::getInstance()->getRow($sql);
		if($row)
			return $row['name'];
		else
			return false;
	}
    private function getPrice($product_id)
    {
    	$sql="select price from ps_product_lang where id_product=".$product_id;
    	$row=Db::getInstance()->getRow($sql);
    	if($row)
			return $row['price'];	  
		else
			return false;
	
    }
 public function getMetaDataByProductId($productId)
    {
        $sql="select * from ps_product_rental where product_id=".$productId;
        $row=Db::getInstance()->getRow($sql);
        if($row)
            return $row;
        else
            return $sql;
    }
}

 
?>