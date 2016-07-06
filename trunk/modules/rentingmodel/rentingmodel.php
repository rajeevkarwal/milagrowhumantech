<?php
/**
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2015 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/
if (!defined('_PS_VERSION_')) {
    exit;
}
require_once(dirname(__FILE__) . '/RentingPdf.php');
require_once(dirname(__FILE__) . '/SecurityPdf.php');
define('ADMIN_EMAIL','webadmin@milagrow.in');
define('CUSTOMER_CARE','cs@milagrow.in');
define('DEVELOPER_EMAIL','kishor.pant@milagrow.in');
define('SENDER','webadmin@milagrow.in');
define('PASSWORD','');


class RentingModel extends Module
{
    protected $config_form = false;
     const MODULE_NAME = "RentingModel";
	public function __construct()
    {
        $this->name = 'rentingmodel';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'MilagrowHumantech';
        $this->need_instance = 1;
        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->l('Rent You Product');
        $this->description = $this->l('FOR PRODUCT RENTING .');

        $this->confirmUninstall = $this->l('Are You Sure Want To Confirm Uninstall');
    }
    public function install()
    {
        if (!parent::install())
            return false;

        include(dirname(__FILE__).'/sql/renting_model_install.php');
        $sqlInstall=new renting_model_install();
        $sqlInstall->install_product();//installing product table
        $sqlInstall->install_customer();//installing customer managemet table
		$sqlInstall->install_pincode();//installing pincode for product
		$sqlInstall->managePayment();
		$sqlInstall->install_management();
		$sqlInstall->manage_rental_period();
        return true;
    }

    public function uninstall()
    {
      	include(dirname(__FILE__).'/sql/uninstall.php');
			if(!parent::uninstall())
				return false;
		$dbRemove=new uninstall();
		$dbRemove->uninstall_db();
		return true;
		
        
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        /**
         * If values have been submitted in the form, process.
         */
		$rentalmsg='';
        $this->html = '<h2>' . $this->displayName . '</h2>';
        $this->html .= '<link media="all" type="text/css" rel="stylesheet" href="' . $this->_path . 'views/css/back.css"/>';
        $this->html .= '<link media="all" type="text/css" rel="stylesheet" href="' . $this->_path . 'views/css/back.js"/>';
        if (((bool)Tools::isSubmit('submitRentingModelModule')) == true) {
            $this->postProcess();
        }
        $url = $_SERVER['REQUEST_URI'];
        $name=$this->getProductNames();
        $ShowMsg='';
        if (strpos($url, '&sl_tab') > 0)
            $url = substr($url, 0, strpos($url, '&sl_tab'));

        $this->context->smarty->assign('module_dir', $this->_path);


        $page_name=Tools::getValue('tab_name');
        $customerNumber=Tools::getValue('customerNumber');
        $rowId=Tools::getValue('edit_id');
        $form_name=Tools::getValue('form_name');
		$productId=Tools::getValue('ProductId');
        $this->context->smarty->assign(array(
            'url'=>$url,
            'customer'=>$this->getCustomer(),
            'category'=>$this->getCategory(),
            'name'=>json_encode($name),
            'ShowMsg'=>$ShowMsg,
        	'ajaxurl'=>json_encode(AJAXURL)
        ));
        $html = $this->context->smarty->fetch($this->local_path.'views/templates/admin/menu.tpl');
		
       if($_POST['submit'])
       {
      		 $datetime=new DateTime();
      		 $datetime=$datetime->format();
           $form_name=Tools::getValue('form_code');
          if($form_name==='delete')
          {
          		$customerCode=Tools::getValue('customerCode');
          		$extensionId=Tools::getValue('extensionId');
          		$ePeriod=Tools::getValue('extendPeriod');
          		$msg=$this->deleteExtensionPeriod($ePeriod,$customerCode,$extensionId);
          	
          		$html.=$msg;
          }
           if($form_name==='saveExtendPeriod')
           {
           		
           		$timestamp=new DateTime();
				$stamp=$timestamp->format('Y-m-d H:i:s');
           		$data['rent_id']=Tools::getValue('customer_id');//updated customer id
           		$data['rent_duration']=Tools::getValue('original_duration');//original duration of that perticular customer id
           		$data['extend_period']=Tools::getValue('is_extended');
           		$data['extend_duration']=Tools::getValue('extend_duration');
           		$data['extended_rental']=Tools::getValue('extended_amount');
           		$rentalmsg=$this->saveExtendedPeriod($data);
         		
           }
			if($form_name==='saveCity')
			{
				$product_id=Tools::getValue('product');
				$cityName=Tools::getValue('pincode');
				$default_status=1;
				$result=$this->saveCity($product_id,$cityName,$default_status);
				$ShowMsg=$result;
				
			}
           if($form_name=="arp")
           {
               $category_id=Tools::getValue('category');
               $product_id=Tools::getValue('product');
               $price=Tools::getValue('original_amount');
               $security=Tools::getValue('security_deposit');
               $available_for=Tools::getValue('available_for');
               $installment_mode=Tools::getValue('installment_mode');
               $ins_amount=Tools::getValue('installment_amount');
               $percentage=Tools::getValue('percentage');
               $min_period=Tools::getValue('min_period');
               $max_period=Tools::getValue('max_period');
               $visit_per_month=Tools::getValue('visit_per_month');
               
            //   $html.=$form_name.$category_id.$product_id.$price.$security.$available_for.$installment_mode.$ins_amount.
              // $percentage.$min_period.$max_period.$visit_per_month;

                if(!empty($category_id)|| !empty($product_id) || !empty($price) || !empty($security) || !empty($available_for)
                ||!empty($installment_mode) || !empty($min_period)||
                    !empty($max_period) || !empty($visit_per_month))
                {

                    if(empty($ins_amount))
                    {
                        $ins_amount=$percentage;
                    }
                    $saveData=array('product_id'=>$product_id,
                        'category_id'=>$category_id,
                        'offer_for'=>$available_for,
                        'product_value'=>$price,
                        'security_value'=>$security,
                        'installment_mode'=>$installment_mode,
                        'installment_amount'=> $ins_amount,
                        'min_period'=>$min_period,
                        'max_period'=>$max_period,
                        'visit_per_month'=>$visit_per_month,
                        'status'=>'1'
                    );
                    $myMsg=$this->saveProduct($saveData);
                        $html.=$myMsg;
                        $this->ShowMsg=$myMsg;

                }
               else
                   $html.='any empty field';
           }
           if($form_name=='edit')
           {
           			$id=Tools::getValue('productId');
               	$data['product_id']=$id;
               $data['security_value']=Tools::getValue('security_deposit');
               $data['offer_for']=Tools::getValue('available_for');
               $data['installment_mode']=Tools::getValue('installment_mode');
               $data['installment_amount']=Tools::getValue('installment_amount');
               
               $data['min_period']=Tools::getValue('min_period');
               $data['max_period']=Tools::getValue('max_period');
               $data['visit_per_month']=Tools::getValue('visit_per_month');
               $data['status']=Tools::getValue('status');
             	echo $this->updateRentalProduct($id,$data);
           }
           if($form_name=='payment')
           {
           		$msg='';
           		$data['rent_id']=Tools::getValue('customer_id');
           		$data['payment_received']=Tools::getValue('amount_installment');
           		$data['payment_pending']=Tools::getValue('amount_installment');
           		$data['payment_mode']=Tools::getValue('payment_mode');
           		$data['bank_name']=Tools::getValue('bank_name');
           		$data['document_number']=Tools::getValue('document_number');
           		$data['status']=Tools::getValue('status');
           		$html.=$this->saveCheque($data['rent_id'],$data);
           }
            }
        if($page_name=='view_app')
        {
            $html .= $this->context->smarty->fetch($this->local_path.'views/templates/admin/view_customer.tpl');
        }
        else if($page_name=='edit')
        {
        	$this->context->smarty->assign(array('id'=>$rowId,'name'=>$this->getProductName($rowId)));
        	$html .= $this->context->smarty->fetch($this->local_path.'views/templates/admin/editRentalProduct.tpl');
        }
        else if($page_name=='full')
        {
        	$customer=$this->getCustomerDetailById($customerNumber);
        	$duration=$customer['payment_duration'];
        	$durationBox.="<select name='extend_duration' id='extend_duration' onchange='getMontlyRental();'>";
        	$durationBox.='<option value="">Select Duration</option>';
        	for($i=3;$i<=(24-$duration);$i+=3)
        	{
        		$durationBox.='<option value='.$i.'>'.$i.'Months</option>';
        	}
        	$duration.="</select>";
        	$this->context->smarty->assign(array(
        	'customer'=>$this->getCustomerDetailById($customerNumber),
        	'installment'=>$customer['monthly_rental'],
        	'customer_name'=>$customer['name'],
        	'current_duration'=>$customer['payment_duration'],
        	'product_id'=>$customer['product_id'],
        	'customer_id'=>$customerNumber,
        	'remaining_duration'=>$durationBox,
        	'img1'=>$this->getImageURLs($customerNumber,1),
        	'img2'=>$this->getImageURLs($customerNumber,2),
        	'img3'=>$this->getImageURLs($customerNumber,3),
        	'status'=>$this->getStatus($customerNumber,true),
        	'previousPayments'=>$this->getPayments($customerNumber,true),
        	'extendedPeriods'=>$this->getExtendedPeriods($customerNumber),
        	'totalAmountReceived'=>$this->totalAmountReceived($customerNumber)
        	
        	));
        	$html.=$this->context->smarty->fetch($this->local_path.'views/templates/admin/customer/customerView.tpl');
        }
        else if($page_name==='add_rental')
        {
            //this line of code is use to adding new product for rental.
            $html .= $this->context->smarty->fetch($this->local_path.'views/templates/admin/add_product_rent.tpl');
        }
        else if($page_name==='rental_products')
        {
            //this function is used to view retal products.
            $this->context->smarty->assign(array('products'=>$this->viewProducts()));
            $html .= $this->context->smarty->fetch($this->local_path.'views/templates/admin/rental_products.tpl');
        }
		else if($page_name==='product_cities')
		{

		//this function is used to map product cities which is used to available the cities of the function avalaible .
			
			
		$this->context->smarty->assign(array(
			'showMsg'=>$ShowMsg,
			'category'=>$this->newCategory(),
			'product'=>json_encode($this->getNewProducts()),
			'state'=>$this->stateName(),
			'city'=>json_encode($this->cityName())
			));
			$html .= $this->context->smarty->fetch($this->local_path.'views/templates/admin/product_cities.tpl');
		}
		else if($page_name==='viewCity')
		{
                    //function is used to view city.this option is avalaible with product option
			$this->context->smarty->assign(array(
			'productName'=>$this->getProductName($productId),
			'available_city'=>$this->getAvailableCity($productId)
			));
			
			$html.= $this->context->smarty->fetch($this->local_path.'views/templates/admin/viewCities.tpl');
		}
		else if($page_name=='downloadSecurityReceipt')
		{
                    //function downloading customer security script
			$html.=$this->downloadSecurityReceipt($customerNumber);
		}	
		else if($page_name==='downloadLoanReceipt')
		{	
                    //functioin download loan receipt.
			$html.=$this->downloadLoanReceipt($customerNumber);
		}	
        else
        {
        	$this->context->smarty->assign(array(
        	'customer'=>$this->getCustomerDetailById($customerNumber),
        	'status'=>$this->getStatus('',false),
        	'product'=>$this->productHTML()	
        	));
            $html.= $this->context->smarty->fetch($this->local_path.'views/templates/admin/default.tpl');
        }
        return $html;
    }
    //save customer cheque detail  based on customer duration and cheque number
    private function saveExtendedPeriod($data)
    {
    	$customer=$this->getCustomerDetailById($data['rent_id']);
    	$duration=(int)$customer['payment_duration']+(int)$data['extend_duration'];
    	if($data['extend_duration']==0)
    	{
    		return 'Duration is Mendatory';
    	}
    	else{
    	if($duration<=24)
    	{
        Db::getInstance()->insert('manage_rental',$data);
        //echo Db::getInstance()->getMsgError();
    		if(Db::getInstance()->Affected_Rows()>0)
    		{
    			$tenure_exiration_date=$this->generateNewDate($customer['tenure_expiration_date'],$data['extend_duration']);
    			$newdata=array('payment_duration'=>$duration,'tenure_expiration_date'=>$tenure_exiration_date);
    			Db::getInstance()->update('rental_customer',$newdata,'rent_id='.$data['rent_id']);
    			if(Db::getInstance()->Affected_Rows()>0)
    				return 'Extended Period Successfully Updated';
    			else 
    				return "Unable To Update Period";
	  	  }
	   		 else 
	    		return "Something Wrong Went Happen";
    		}
    	else
    	{
    		return "Can Not Extend More Than 24 Months";
    	}
    }

    }

    private function deleteExtensionPeriod($eDuration,$customerId1,$extensionId)
    {
    	//return 'welcome';
    	
    	$msg='';
    	$customerNo=$this->getCustomerDetailById($customerId1);
    	Db::getInstance()->delete('manage_rental','id='.$extensionId);
    	$newDate=$this->previousDate($customerNo['tenure_expiration_date'],$eDuration);
    	if(Db::getInstance()->Affected_Rows()>0)
    	{
    			$originalPeriod=$customerNo['payment_duration'];
    			$newDuration=$originalPeriod-$eDuration;
    			$data=array('payment_duration'=>$newDuration,'tenure_expiration_date'=>$newDate);
    			Db::getInstance()->update('rental_customer',$data,'customer_id='.$customerId1);
    			
    			return Db::getInstance()->getMsgError();
    	}
		else return false;    	
    }
    private function getExtendedPeriods($customer_id)
    {
    	$sql="select * from ps_manage_rental where rent_id=".$customer_id;
    	$row=Db::getInstance()->ExecuteS($sql);
    	if($row)
    		return $row;
    	else
    		return false;
    }
    public function getMonthlyRental($product_id)
    {
    	$sql="select installment_amount from ps_product_rental where product_id=".$product_id;
    	$row=Db::getInstance()->getRow($sql);
    	if($row)
    		return $row;
    	else
    		return false;
    }
    //this function customer payment it might be any cheque or any online payment
   	private function saveCheque($customer_id,$data)
   	{
   		$counter=0;
   		
   		$customer=$this->getCustomerDetailById($customer_id);
   		$duration=$customer['payment_duration'];
   		$status=$customer['status'];
   		$sql="select count(rent_id) as counter from ps_customer_rent_received where rent_id=".$customer_id;
   		$extended_date=$this->generateNewDate($customer['monthly_rental_expire'],1);
   		$extendsdate=array('monthly_rental_expire'=>$extended_date);
   		$row=Db::getInstance()->getRow($sql);
   		if($row)
   		{
   			$counter=$row['counter'];
   		}
   		if($status==4)
   		{
   			if($duration!=$counter)
   			{
   						Db::getInstance()->insert('customer_rent_received',$data);
   						if(Db::getInstance()->Affected_Rows()>0)
   						{
   								Db::getInstance()->update('rental_customer',$extendsdate,'rent_id='.$customer_id);
   							return "<script>alert('Cheque Updated')</script>";
   						} 
   						else
                return false;
   			}
   			else 
   			{
   				return "<script>alert('Customer Complete His Cheque Limit')</script>";
   			}
   		}
   		else
   		{
   			return "<script>alert('Customer Status is Inactive State!Please UPdate Status')</script>";
   		}
   	}
   	//getting payment table according to customer ID
    private function getPayments($row_id,$key)
    {
    	if($key)
    	{
    		$sql="select payment_id,name,payment_received,p1.payment_mode,p1.status,DateTime,bank_name,document_number from ps_customer_rent_received as p1,ps_rental_customer as p2 where p2.rent_id=p1.rent_id and p1.rent_id=".$row_id;
    		$result=Db::getInstance()->Executes($sql);
    		if($result)
    			return $result;
    		else 
    			return false;
    	}
    }
    //generating security receipt
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
	//Generate New date after certil duration
	private function generateNewDate($date,$duration)
	{
			//echo 'original date'.$date;
			$date = strtotime(date("Y-m-d", strtotime($date)) . " +".$duration." month");
			$date = date("Y-m-d",$date);
			return $date;
			//echo 'new date'.$date.'duration'.$duration.'<br>';
	}
	private function previousDate($date,$duration)
	{
		//echo 'original date'.$date;
			$date = strtotime(date("Y-m-d", strtotime($date)) . " -".$duration." month");
			$date = date("Y-m-d",$date);
			return $date;
			//echo 'new date'.$date.'duration'.$duration.'<br>';
	}
	//Generation of rental receipt
 	private function downloadLoanReceipt($loan_id)
    {	
    		$tax=15.00;
    		
    		$orderInfo = $this->getCustomerDetailById($loan_id);//getting commplete detail by customer id
    		$productMeta=$this->getMetaDataByProductId($orderInfo['product_id']);//get complete detail by product
            $receiptNo = sprintf('%06d', $loan_id); //receipt Number
           	 $taxInInstallment=($orderInfo['monthly_rental']*14/100);//where tax applied on test
           	 $cess2=($orderInfo['monthly_rental']*.5/100);
           	 
            $actualPrice=$this->getProductPrice($orderInfo['product_id']);//actual price of product
            $discount=0;
            if($orderInfo['payment_duration']>9 && $orderInfo['payment_duration']<15)$discount=10;
            else  if($orderInfo['payment_duration']>14 && $orderInfo['payment_duration']<=24)$discount=15;
            
            $discountInRent=($productMeta['installment_amount']*$discount/100);//discount In Rent
            $rentAfterDiscount=ceil($productMeta['installment_amount']-$discountInRent);//Rent Amount after discount
            $rentBeforeTax=$orderInfo['monthly_rental']-$taxInInstallment-$cess2-$cess2;
            $content = array(
            	'originalInstallment'=>$productMeta['installment_amount'],
                'receiptNo' => $receiptNo,
            	'serviceTax'=>$tax,
            	'priceWithoutTax'=>$priceWithoutTax,
            	'taxAmount'=>$amountTax,
            	'endingDate'=>$this->generateNewDate($this->getDateByCustomerId($orderInfo['customer_id']),$orderInfo['payment_duration']),
            	'priceAfterTax'=>round($priceAfterTax,2),
            	'unitPrice'=>$priceWithoutTax,
                'demoDate' => $orderInfo['applied_on'],
            	'actualPrice'=>$actualPrice['price'],
            	'discountedAmount'=>$discountedPrice,
            	'rentAfterDiscount'=>$rentAfterDiscount,
            	'taxInInstallment'=>$taxInInstallment,
            	'rentBeforeTax'=>$rentBeforeTax,
            	'discount'=>$discount,
            	'otherTax'=>$cess2,
            	'duration'=>$orderInfo['payment_duration'],
                'demoAddress' =>  $orderInfo['name'].'<br>'.$orderInfo['address'].'<br>'.$orderInfo['contact_number'].'<br>'.$orderInfo['email'],
            'product'=>$this->getProductName($orderInfo['product_id'])
               
            );
            $pdf = new RentingPdf($this->context->smarty, $this->context->language->id);
            $pdf->render(true, $content);
        }
	private function getDateByCustomerId($id)
	{
		$sql='select date(applied_on)as date from ps_rental_customer where customer_id='.$id;
		$row=Db::getInstance()->getRow($sql);
		if($row)
			return $row['date'];
		else return false;
	}
    private function getStatus($customerId,$request)
    {
    	 $statusList=array('Payment Pending','Payment Awaited/By Cheque','Awaiting Approval','Document Verified','Product Sent','Delivered','Active','Completed','Settelled','Cancelled','Rejected');
    	if($request)
    	{
    
    		$currentStatus=$this->getImageURLs($customerId,4);
    		
    		$status='<select id="status" onchange="changeStatus();">';
    		for($i=$currentStatus;$i<count($statusList);$i++)
    		{
    			$status.='<option value="'.$i.'">'.$statusList[$i].'</option>';
    		}
    		$status.='</select>';
    		return $status;
    	}
    	else
    	{
    		$htmlData.="<select>";
    		$htmlData.='<optgroup label="Select Status"></optgroup>';
    		for($i=0;$i<count($statusList);$i++)
    		{
    			$htmlData.='<option value='.$i.'>'.$statusList[$i].'</option>';
    		}
    		
    		$htmlData.="</select>";
    		return $htmlData;
    	}
    	
    }
   
    private function getImageURLs($customer_id,$key)
    {
    	$sql="select image_url,id_url,address_url,status from ps_rental_customer where rent_id=".$customer_id;
    	$row=Db::getInstance()->getRow($sql);
    	if($row)
    	{
    		if($key==1)
    			return '/modules/rentingmodel/img/images/'.$row['image_url'];
    			else if($key==2)
    				return '/modules/rentingmodel/img/idProofs/'.$row['id_url'];
    			else if($key==3) 
    				return '/modules/rentingmodel/img/addressProofs/'.$row['address_url'];
    				else 
    				return $row['status'];
    				
    	}
    	
    }
	private function saveCity($product_id,$pincode,$d_status)
	{
			
		$data['status']=$d_status;
		$data['product_id']=$product_id;
		$data['pincode']=$pincode;
		/*
		$sql="select distinct(pincode) from ps_pincode_cod where city='$pincode'";
		$result=Db::getInstance()->ExecuteS($sql);
		if($result)
		{
			foreach ($result as $city)
			{
				$data['pincode']=$city['pincode'];
				Db::getInstance()->insert('rental_product_cities',$data);
			}
			return Db::getInstance()->Affected_Row;
		}
		else 
		return $sql;*/
		$resultnew=0;
		$sql="select count(*) as rs from ps_rental_product_cities where pincode='$pincode' and product_id='$product_id'";
		//return $sql;
		$result=Db::getInstance()->getRow($sql);
		if($result)
		{
			foreach ($result as $p)
					$resultnew=$p['rs'];
		}
		if($resultnew) return 'Pincode Already Exist for This Combination';
		else{
		Db::getInstance()->insert('rental_product_cities',$data);
						if(Db::getInstance()->Affected_Rows()>0)
							return 'Pincode Inserted Successfully';
						else 
							return Db::getInstance()->getMsgError();}
	}
	private function getCities($productId)
	{
		$sql="select name,pincode,status from ps_rental_product_cities as p1,ps_product_lang as p2 where p1.product_id=p2.id_product";
	
		$result=Db::getInstance()->ExecuteS($sql);
		if($result)
		{
			foreach($result as $city)
			{
				$htmlCode.='<tr><td>'.$city['name'].'</td><td>'.$city['pincode'].'</td><td>'.$city['status'].'</td></tr>';
			}
		}
		return $htmlCode;
	}

    private function getProductName($id)
    {
    	$sql='select name from ps_product_lang where id_product='.$id;
    	$result=Db::getInstance()->ExecuteS($sql);
    	if($result)
    	{
    		foreach ($result as $value) {
    			return $value['name'];
    		}
    		
    	}
    } 
    private function updateRentalProduct($productId,$data)
    {
    	$msg=0;
    	if(!empty($productId))
    	{
    			
    			 Db::getInstance()->update('product_rental',$data,'product_id='.$productId);
    			 $msg='<script>alert("Record Updated")</script>';
    			 return $msg;
    	}
    	else
    	return '<script>alert("something wrong happening"+'.Db::getInstance()->getMsgError().')</script>';	
    }
    private function viewProducts()
    {
        $sql='select p1.id as rowId,p2.id_product,p2.name as name,p3.name as category_name ,offer_for,product_value,security_value,installment_mode,
              installment_amount,min_period,max_period,visit_per_month,status,creation_date
          from ps_product_rental as p1,ps_product_lang as p2,ps_category_lang as p3 where p1.product_id=p2.id_product and p1.category_id=p3.id_category';

        if($result=Db::getInstance()->ExecuteS($sql))
        {
            return $result;
        }
        else
        {
            return false;
        }
    }
    private function getCustomer()
    {
        $data=array();
        $sql='select p1.rent_id,p1.name,p1.customer_id,email,address,date_of_birth,contact_number,payment_mode,payment_duration,monthly_rental,product_price,security_deposited,p1.status,applied_on
        ,p2.name as productName,p3.name as categoryName from ps_rental_customer as p1, ps_product_lang as 
        p2,ps_category_lang as p3 where p1.product_id=p2.id_product and p1.category_id=p3.id_category order by rent_id desc';
        //$sql='select * from ps_rental_customer as p1,ps_product_lang as p2 where p1.product_id=p2.id_product order by customer_id desc';
        $result=Db::getInstance()->ExecuteS($sql);
        if($result)
            return $result;
        else
            return array();
    }
    public function getProductDetail($key,$value)
    {
        if(!empty($key) || !empty($value))
        {
            if($key=='id')
            {
                $sql="select name from ps_products where id_product=".$value;
                $row=Db::getInstance()->getRow($sql);
                if($row)
                    return $row;
                else
                    return false;

            }
            else if($key='category')
            {
                $sql="select name from ps_category where id_category=".$value;
                $row=Db::getInstance()->getRow($sql);
                if($row)
                    return $row;
                else
                    return false;
            }
            else
            {
                        return false;
            }
        }

    }
	public function fetchTemplate($name)
	{
		 if (_PS_VERSION_ < '1.4')
            $this->context->smarty->currentTemplate = $name;
        elseif (_PS_VERSION_ < '1.5') {
            $views = 'views/templates/';
            if (@filemtime(dirname(__FILE__) . '/' . $name))
                return $this->display(__FILE__, $name);
            elseif (@filemtime(dirname(__FILE__) . '/' . $views . 'hook/' . $name))
                return $this->display(__FILE__, $views . 'hook/' . $name);
            elseif (@filemtime(dirname(__FILE__) . '/' . $views . 'front/' . $name))
                return $this->display(__FILE__, $views . 'front/' . $name);
            elseif (@filemtime(dirname(__FILE__) . '/' . $views . 'back/' . $name))
                return $this->display(__FILE__, $views . 'back/' . $name);
        }

        return $this->display(__FILE__, $name);
	}
    //receive array value to insert into database

    private function saveProduct($productData)
    {
    	if(!$this->checkExistance($productData['product_id']))
    	{
    		 Db::getInstance()->insert('product_rental',$productData);
        	return true;
    	}
    	else return false;
    }
    private function checkExistance($id)
    {
    	$sql="select product_id from ps_rental_product where product_id=".$id;
    	$row=Db::getInstance()->getRow($sql);
    	if($row)return true;
    	else return false;
    }

    //Generally used for form processing
    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

    }

    /**
    * Add the CSS & JavaScript files you want to be loaded in the BO.
    */
    public function hookBackOfficeHeader()
    {
        if (Tools::getValue('module_name') == $this->name) {
            $this->context->controller->addJS($this->_path.'views/js/back.js');
            $this->context->controller->addCSS($this->_path.'views/css/back.css');
        }
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path.'/views/js/front.js');
        $this->context->controller->addCSS($this->_path.'/views/css/front.css');
    }

    public function hookActionWatermark()
    {
        /* Place your code here. */
    }
    //function use to get Product Price by passing the product id to BackEnd
	public function getProductPrice($product_id)
	{
		$sql="select price as price from ps_product where id_product=".$product_id;
		$row=Db::getInstance()->getRow($sql);
		if($row)
		{
				$price=round($row['price']+(($row['price']*13.125)/100),2);
				return array('price'=>$price);
			//return $row;
		}
		else
			return false;
	}
	private function productHTML()
	{
		$sql="select p1.product_id,p2.name from ps_product_rental as p1,ps_product_lang as p2 where p1.product_id=p2.id_product";
		$htmlData="<select>";
			$result=Db::getInstance()->ExecuteS($sql);
			foreach ($result as $data)
			{
				$htmlData.='<option value='.$data['product_id'].'>'.$data['name'].'</option>';
			}
		$htmlData.="<select>";
		return $htmlData;
	}
    //Returning product Name
    private function getProductNames()
    {
        $catid=$this->getCategoryId();
        if(!empty($catid))
        {
            $sqlprod = 'SELECT p.name, pc.id_category AS categoryid,p.id_product,price FROM ps_product_lang as p  join 
ps_category_product as pc on p.id_product = pc.id_product join ps_product pr on pr.id_product=pc.id_product 
where pr.active=1 and pc.id_category in ('.implode(",", $catid).') and p.id_product not in (select product_id from ps_product_rental)';

            if ($res = Db::getInstance()->Executes($sqlprod))
            {
                foreach($res as $product)
                {
                    $catwiseproduct[$product['categoryid']][]=array('product_name'=>$product['name'],'id_product'=>$product['id_product'],'price'=>$product['price']);
                }
            }
        }
        return $catwiseproduct;
    }
    //reverting html category option with onchange function
    private function getCategory()
    {
        $category=array();

        $sql='select p1.id_category,name from ps_category_lang as p1,ps_category as p2 where p2.active=1 
and p1.id_category=p2.id_category and p2.level_depth=2';
        $result=Db::getInstance()->executeS($sql);
        $category='<select id="category" name="category" onchange="getid();">';
        $category.='<option>Select Category</option>';

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
    //getting all category id .
    private function getCategoryId()
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
    //function is use to delete product from admin view
    public function deleteProductFromId($rowId)
    {
        Db::getInstance()->delete('product_rental','id='.$rowId);
        if(Db::getInstance()->Affected_Rows()>0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    //function revert an row of array with complete detail of specific row for customer view.
    public function getMetaDataByProductId($productId)
    {
        $sql="select * from ps_product_rental where product_id=".$productId;
        $row=Db::getInstance()->getRow($sql);
        if($row)
            return $row;
        else
            return $sql;
    }
    // this function is to delete customer from record using customer id
    public function deleteCustomer($customer_id)
    {
    	Db::getInstance()->delete('rental_customer','rent_id='.$customer_id);
    	$result=Db::getInstance()->Affected_Rows();
    	if($result>0)
    	{
    		return true;
    	}
    	else
    	{
    		return false;
    	}
    }
    //this function getting customer detail with the help of customer id
	public function getCustomerDetailById($customer_id)
	{
		$sql='select * from ps_rental_customer where rent_id='.$customer_id;
		if($row=Db::getInstance()->getRow($sql))
			return $row;
		else return array();
	}
	public function updateStatus($row_id,$data)
	{
		$date=$this->getDateByCustomerId($row_id);
		$currentDate=new DateTime();
		$cTimeStamp=$currentDate->format('Y-m-d');
		$customerDetail=$this->getCustomerDetailById($row_id);
		if($data['status']==6)
		{
			$timestamp=new DateTime();
			$stamp=$timestamp->format('Y-m-d H:i:s');
			$newdata=array(
			'status'=>$data['status'],
			'applied_on'=>$stamp,
			'monthly_rental_expire'=>$this->generateNewDate($cTimeStamp,1),
			'tenure_expiration_date'=>$this->generateNewDate($cTimeStamp,$customerDetail['payment_duration'])
			);
			Db::getInstance()->update('rental_customer',$newdata,'rent_id='.$row_id);
			$this->sendMail($row_id,$customerDetail);				
		}
		else 
			Db::getInstance()->update('rental_customer',$data,'rent_id='.$row_id);
			if(Db::getInstance()->Affected_Rows()>0)
					return true;
		else 
		return false;
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
	private function sendMail($customer_id,$customerData)
	{
		
		$dates=$this->getCustomerDetailById($customer_id);
		$template="customer_mail_on_active";
		$subject='Loan Application Approved of---'.$customer_id.'--'.$customerData['name'].'--'.$customerData['city'].'--'.$customer['state'];
		$link_url=$_SERVER['SERVER_NAME'].'/view-customer?key='.md5($customer_id);
		$data=array(
		'{applicationNumber}'=>$this->generateApplicationFormat($customer_id,$dates['category_id']),
		'{name}'=>$customerData['name'],
		'{date}'=>$dates['applied_on'],
		'{startdate}'=>$dates['applied_on'],
		'{enddate}'=>$dates['tenure_expiration_date'],
		'{securitydeposit}'=>$dates['security_deposited'],
		'{duedate}'=>$dates['monthly_rental_expire'],
		'{link}'=>$link_url,
		'{duration}'=>$customerData['payment_duration'],
		'{monthlyinstallment}'=>$customerData['monthly_rental'],
		
		);
		 $res =Mail::Send(
                (int)1,
                $template,
                $subject,
                $data,
                $customerData['email'],
                $customerData['name'],
                null,
                null,
                '',
                null,
                 getcwd().'/',
                false,
                null
            );
            //customer care email
            
            $cs_email='cs@milagrow.in';
            $to='Admin';
       $res =Mail::Send(
                (int)1,
                $template,
                $subject,
                $data,
                $cs_email,
                $to,
                null,
                null,
                '',
                null,
                getcwd().'/',
                false,
                null
            );
       
	}
	public function getCityName($pincode)
	{
		$sql="select city from ps_pincode_cod where pincode=".$pincode;
		$row=Db::getInstance()->getRow($sql);
		if($row)
			return $row['city'];
		else 
			return false;
	}
	public function deleteCheque($document_number)
	{
		Db::getInstance()->delete('customer_rent_received','document_number='.$document_number);
		if(Db::getInstance()->Affected_Rows()>0) return true;
		else return false;
		
	}
	Private function totalAmountReceived($customerId)
	{
		$sql="select sum(payment_received) as total from ps_customer_rent_received where customer_id=".$customerId;
		$row=Db::getInstance()->getRow($sql);
		if($row)
			return $row['total'];
	}
	public static function getShopDomainSsl($http = false, $entities = false)
    {
        if (method_exists('Tools', 'getShopDomainSsl'))
            return Tools::getShopDomainSsl($http, $entities);
        else {
            if (!($domain = Configuration::get('PS_SHOP_DOMAIN_SSL')))
                $domain = self::getHttpHost();
            if ($entities)
                $domain = htmlspecialchars($domain, ENT_COMPAT, 'UTF-8');
            if ($http)
                $domain = (Configuration::get('PS_SSL_ENABLED') ? 'https://' : 'http://') . $domain;
            return $domain;
        }
    }
	public function getPincodeStatus($zipcode)
	{
		$sql="select count(*) as counter from ps_rental_product_cities where status=1 and pincode=".$zipcode;
		$row=Db::getInstance()->getRow($sql);
		if($row)
			return $row;
		else
			return false;
	}
	private function stateName()
	{
		$sql="Select id_state,name from ps_state where id_country=110";
		$html='<select id="stateName" name="stateName" onchange="getCity();">';
		$html.='<option value="">Select State</option>';
		$result=Db::getInstance()->ExecuteS($sql);
		if($result)
		{
			foreach ($result as $state)
			{
				$html.='<option value="'.$state['id_state'].'">'.$state['name'].'</option>';
			}
//			return $html;
			$html.='</select>';
		 return $html;
		}
		else 
		{
			return Db::getInstnace()->getMsgError();
		}
		
	}
	private function cityName()
	{
		$sql="Select distinct(id_state),id,LOWER(city) as city from ps_pincode_cod group by LOWER(city)";
		$cityRes=Db::getInstance()->ExecuteS($sql);
		$stateWiseCityKeyMap=array();
        $cityNameKeyMap=array();
        foreach($cityRes as $cityRow)
        {
            $cityNameKeyMap[$cityRow['id']]=$cityRow['city'];
            $stateWiseCityKeyMap[$cityRow['id_state']][]=$cityRow;
        }
		return $stateWiseCityKeyMap;
	}
	public function getPincodeByCityId($city_id)
	{
		$sql="select pincode from ps_pincode_cod where id=".$city_id;
		$row=Db::getInstance()->getRow($sql);
		if($row)
			return $row;
		else
			return false;	
	}
	private function newCategory()
	{
			$sql="select distinct(category_id),name from ps_category_lang as p1,ps_product_rental as p2 where p1.id_category=p2.category_id";
		$html='<select id="newCategory" name="newCategory" onchange="getid();">';
		$html.='<option value="">Select Category</option>';
		$result=Db::getInstance()->ExecuteS($sql);
		if($result)
		{
			foreach ($result as $state)
			{
				$html.='<option value="'.$state['category_id'].'">'.$state['name'].'</option>';
			}
//			return $html;
			$html.='</select>';
		 return $html;
		}
	}
	private function getNewProducts()
	{
		$catid=$this->getCategoryId();
        if(!empty($catid))
        {
            $sqlprod = 'SELECT p.name, pc.id_category AS categoryid,p.id_product,price FROM ps_product_lang as p  join 
			ps_category_product as pc on p.id_product = pc.id_product join ps_product pr on pr.id_product=pc.id_product 
				where pr.active=1 and pc.id_category in ('.implode(",", $catid).') and p.id_product in (select product_id from ps_product_rental)';

            if ($res = Db::getInstance()->Executes($sqlprod))
            {
                foreach($res as $product)
                {
                    $catwiseproduct[$product['categoryid']][]=array('product_name'=>$product['name'],'id_product'=>$product['id_product'],'price'=>$product['price']);
                }
            }
        }
        return $catwiseproduct;
	}
   private function getAvailableCity($product_id)
   {
   	$sql="SELECT distinct(p1.pincode),p1.id,p3.name FROM ps_rental_product_cities as p1,ps_pincode_cod as p2,ps_state as p3 WHERE p1.pincode=p2.pincode and p2.id_state=p3.id_state and p1.product_id=".$product_id;
   	$result=Db::getInstance()->executeS($sql);
   	if($result)
   		return $result;
   	else 	
   		return false;
   
   
   }
   public function getCityAuthetication($product_id ,$zipcode)
   {
  	 $sql="select count(*) as counter from ps_rental_product_cities where pincode='".$zipcode."'and product_id=".$product_id;
  	 $result=Db::getInstance()->getRow($sql);
  	 if($result)
  	 {
  	 	return $result;
  	 }
  	 else
  	 	return false;
   }
   public function getCounters($singleCheck)
   {
   	$sql="select count(*) as counter from ps_rental_product_cities where pincode=".$singleCheck;
  	 $result=Db::getInstance()->getRow($sql);
  	 if($result)
  	 {
  	 	return $result;
  	 }
  	 else
  	 	return $sql;
   }
   public function deleteCity($id)
   {
   	Db::getInstance()->delete('rental_product_cities','id='.$id);
   	return Db::getInstance()->Affected_Rows();
   }
}
