<?php
/**
 * Created by JetBrains PhpStorm.
 * User: priyanka
 * Date: 15/7/13
 * Time: 1:30 PM
 * To change this template use File | Settings | File Templates.
 */
include_once(dirname(__FILE__) . '/../../../../config/config.inc.php');
include_once(dirname(__FILE__) . '/../../../../init.php');
require_once(dirname(__FILE__) . '/../../DemoPdf.php');

require(getcwd() . _MODULE_DIR_ . "amc/libFunctions.php");
define('_SMS_URL', 'https://control.msg91.com/sendhttp.php');
define('_WORKING_KEY', 'f6srdljv9krmyof389tjdixf86bgmc55');
define('_SMS_USERNAME', '56096');
define('_SMS_PASSWORD', 'milagrowHelpdesk');
define('_SMS_SENDERID', 'MLGROW');
define('_SMS_MESSAGE', 'Your AMC request for %s has been registered successfully. Please check your email for additional details.-MILAGROW');
define('AMC_EMAIL_ADMIN', 'customercare@milagrow.in');
define('AMC_EMAIL_2_ADMIN', 'receivables@milagrow.in');
define('CUSTOMER_CARE_EMAIL_ID', 'cs@milagrow.in');
//define('AMC_EMAIL_ADMIN', 'ptailor@greenapplesolutions.com');
//define('AMC_EMAIL_2_ADMIN', 'ptailor@greenapplesolutions.com');
//define('CUSTOMER_CARE_EMAIL_ID', 'ptailor@greenapplesolutions.com');

class AMCPaymentNotificationModuleFrontController extends ModuleFrontController
{
    public $display_column_left = false;

   /* public function initContent()
    {

        parent::initContent();

        $formValue = Tools::getValue('paymentType');
        $OrderId = Tools::getValue("order_id");

        $products_list = '';
        if($formValue){
            if ($OrderId) {
                $amcSql = "select * from " . _DB_PREFIX_ . "amc where order_id = '" . $OrderId . "' ";
                $amcData = Db::getInstance()->executeS($amcSql);

                $categorySql = "select name from " . _DB_PREFIX_ . "category_lang where id_category = ". $amcData[0]['category'] ."";
                $categoryData = Db::getInstance()->executeS($categorySql);

                $productSql = "select name from " . _DB_PREFIX_ . "product_lang where id_product = ". $amcData[0]['product'] ."";
                $productData = Db::getInstance()->executeS($productSql);

                $currentDate = new DateTime('now', new DateTimeZone('UTC'));
                $currentTime = $currentDate->format("Y-m-d H:i:s");

                $nb_order_no = Order::generateReference();
                $data = array('payment_type' => $formValue, 'updated_at' => $currentTime ,'nb_order_no' => $nb_order_no);
                Db::getInstance()->update('amc', $data, 'order_id=\'' . $OrderId . '\'');

                $amc_rate = $amcData[0]['amount'];
                $amc_amount = number_format($amc_rate, 2, '.', '');
//                $payment_type = $amcData[0]['payment_type'];
                $chequeName = "Milagrow Business & Knowledge Solutions Private Limited ";
                $chequeAddress ="<strong>Milagrow Business &amp; Knowledge Solutions Private Limited<br>796, Phase - V, Udyog Vihar, Gurgaon - 122016, Haryana.<br>Tel: +91 124 4309570-80</strong>";

                $bankwireOwner='Milagrow Business & Knowledge Solutions Private Limited ';
                $bankwireDetails='<strong>Beneficiary Bank Name: State Bank of Travancore<br>Current Account No. 67033272492<br>IFS code: SBTR0000699</strong>';
                $bankwireAddress='<strong>Commercial and Personal Banking Branch (Sector-18),<br>Udyog Minar, Udyog Vihar Phase V, Gurgaon - 122016,<br>Haryana</strong>';

                $this->context->smarty->assign(
                    array(
                        'amount' => $amc_amount,
                        'reference' => $nb_order_no,
                        'this_path' => $this->module->getPathUri(),
                        'chequeName' => $chequeName,
                        'chequeAddress' => $chequeAddress,
                        'bankwireOwner' => $bankwireOwner,
                        'bankwireDetails' => $bankwireDetails,
                        'bankwireAddress' => $bankwireAddress
                    )
                );

                $orderInfo = $this->getOrderInfo($OrderId);
//                        $coupon = false;
                if (!empty($orderInfo)) {
                    $amcTotalPrice = $amcData[0]['amount'];

                    $amcTax = 12.36;
                    $amcPrice = round(($amcTotalPrice * 100) / (100 + $amcTax), 2);
                    $receiptNo = sprintf('%06d', $orderInfo['amc_id']);
                    $content = array(
                        'demoPriceTaxExcl' => $amcPrice,
                        'demoPriceTaxIncl' => $amcTotalPrice,
                        'demoPriceTotal' => $amcTotalPrice,
                        'demoTax' => $amcTax,
                        'receiptNo' => $receiptNo,
                        'demoDate' => $orderInfo['created_at'],
                        'demoAddress' => $this->getFormattedAddress($orderInfo['name'], $orderInfo['address'], $orderInfo['city'], $orderInfo['state'], $orderInfo['zip']),
                        'category' => $categoryData[0]['name']
                    );

                    $pdf = new DemoPdf($this->context->smarty, $this->context->language->id);
                    $content = $pdf->render(false, $content);
                    $fileAttachment = array();
                    $fileAttachment['content'] = $content;
                    $fileAttachment['name'] = 'AMC_Receipt';
                    $fileAttachment['mime'] = 'application/pdf';

                    $products_list .=
                        '<tr style="background-color:#EBECEE;">
                            <td style="padding:0.6em 0.4em;">' . $nb_order_no. '</td>
                            <td style="padding:0.6em 0.4em;">
                                <strong>'
                                . $productData[0]['name'].
                                '</strong>
                            </td>
                            <td style="padding:0.6em 0.4em; text-align:right;">' . $amc_amount . '</td>
                            <td style="padding:0.6em 0.4em; text-align:center;">1</td>
                            <td style="padding:0.6em 0.4em; text-align:right;">' . $amc_amount . '</td>
				        </tr>';

                    $data = array('{id}' => $orderInfo['amc_id'], '{date}' => $orderInfo['purchase_date'],'productName' => $productData[0]['name'],
                        '{order_id}' => $orderInfo['order_id'], '{name}' => $orderInfo['name'], '{product}' => $products_list,
                        '{nb_order_no}' => $nb_order_no,'{address}' => $orderInfo['address'], '{country}' => $orderInfo['country'],
                        '{state}' => $orderInfo['state'], '{city}' => $orderInfo['city'], '{zip}' => $orderInfo['zip'],
                        '{mobile}' => $orderInfo['mobile'], '{email}' => $orderInfo['email'], '{coupon}' => $orderInfo['coupon'],
                        '{category}' => $categoryData[0]['name'], '{specialComments}' => $orderInfo['special_comments'],
                        '{total_amount}' => $amc_amount,'{payment}' => $formValue );

                    $this->sendEmails($data, $fileAttachment);
                    $this->sendMessage($categoryData[0]['name'], $orderInfo['mobile']);

                    if ($formValue == 'cheque') {
                        $updateData = array('status' => 'Awaiting cheque payment');
                        Db::getInstance()->update('amc', $updateData, 'order_id=\'' . $OrderId . '\'');

                        $emailSubject = 'Awaiting cheque payment';
                        $userTemplate = 'awaiting_payment_cheque';

                        $data = array('{email}' => $orderInfo['email'],'{order_name}' => $nb_order_no,'{name}' => $orderInfo['name'],
                            '{total_paid}'=> $amc_amount,'{cheque_name}'=> $chequeName,
                            '{cheque_address_html}' => $chequeAddress);

                        $this->sendConfirmationEmails($data,$userTemplate,$emailSubject);
                        return $this->setTemplate('cheque_payment_execution.tpl');

                    } else if ($formValue == 'bankwire') {
                        $updateData = array('status' => 'Awaiting bank wire payment');
                        Db::getInstance()->update('amc', $updateData, 'order_id=\'' . $OrderId . '\'');

                        $emailSubject = 'Awaiting bank wire payment';
                        $userTemplate = 'awaiting_payment_bankwire';

                        $data = array('{email}' => $orderInfo['email'],'{order_name}' => $nb_order_no,'{name}' => $orderInfo['name'],
                            '{total_paid}'=>$amc_amount,'{bankwire_owner}'=> $bankwireOwner,
                            '{bankwire_details}' => $bankwireDetails,'{bankwire_address}'=>$bankwireAddress);

                        $this->sendConfirmationEmails($data,$userTemplate,$emailSubject);
                        return $this->setTemplate('bankwire_payment_execution.tpl');
                    }
                }

            } else {
                $error = "Error in finding your order";
            }
        }else{
            $amcSql = "select * from " . _DB_PREFIX_ . "amc where order_id = '" . $OrderId . "' ";
            $amcData = Db::getInstance()->executeS($amcSql);

            $payment_type = $amcData[0]['payment_type'];
            if(!empty($payment_type)){
                $error = "Payment already received for this order";
            }
        }

        $this->context->smarty->assign(array(
            'message' => $error,
        ));
		 echo "<br>testing-1";
        $this->setTemplate('error.tpl');
    }*/

//    public function postProcess1(){
//        $WorkingKey = _WORKING_KEY; //put in the 32 bit working key in the quotes provided here
//        $card_number = '';
//        $card_expiration = '';
//        $card_holder = '';
//        $MerchantId = isset($_REQUEST["Merchant_Id"]) ? $_REQUEST["Merchant_Id"] : '';
//        $OrderId = isset($_REQUEST["Order_Id"]) ? $_REQUEST["Order_Id"] : '';
//        $Amount = isset($_REQUEST["Amount"]) ? $_REQUEST["Amount"] : '';
//        $AuthDesc = isset($_REQUEST["AuthDesc"]) ? $_REQUEST["AuthDesc"] : '';
//        $avnChecksum = isset($_REQUEST["Checksum"]) ? $_REQUEST["Checksum"] : '';
//        $nb_order_no = isset($_REQUEST["nb_order_no"]) ? $_REQUEST['nb_order_no'] : '';
//        if (empty($MerchantId) || empty($OrderId) || empty($Amount) || empty($AuthDesc) || empty($avnChecksum) || empty($nb_order_no))
//            $this->setTemplate('illegal_access.tpl');
//        else {
//            $Checksum = verifyChecksum($MerchantId, $OrderId, $Amount, $AuthDesc, $WorkingKey, $avnChecksum);
//            $billing_cust_name = isset($_REQUEST["billing_cust_name"]) ? $_REQUEST["billing_cust_name"] : '';
//            $billing_cust_address = isset($_REQUEST["billing_cust_address"]) ? $_REQUEST["billing_cust_address"] : '';
//            $billing_cust_country = isset($_REQUEST["billing_cust_country"]) ? $_REQUEST["billing_cust_country"] : '';
//            $billing_cust_tel = isset($_REQUEST["billing_cust_tel"]) ? $_REQUEST['billing_cust_tel'] : '';
//            $billing_cust_email = isset($_REQUEST["billing_cust_email"]) ? $_REQUEST["billing_cust_email"] : '';
//            $delivery_cust_name = isset($_REQUEST["delivery_cust_name"]) ? $_REQUEST["delivery_cust_name"] : '';
//            $delivery_cust_address = isset($_REQUEST["delivery_cust_address"]) ? $_REQUEST["delivery_cust_address"] : '';
//            $delivery_cust_tel = isset($_REQUEST["delivery_cust_tel"]) ? $_REQUEST["delivery_cust_tel"] : '';
//            $delivery_cust_notes = isset($_REQUEST["delivery_cust_notes"]) ? $_REQUEST["delivery_cust_notes"] : '';
//            $Merchant_Param = isset($_REQUEST["Merchant_Param"]) ? $_REQUEST["Merchant_Param"] : '';
//
//            $card_category = isset($_REQUEST["card_category"]) ? $_REQUEST["card_category"] : '';
//
//            if (true && $AuthDesc === "Y") {
//                $message = "<br>Thank you for shopping with us. Your credit card has been charged and your transaction is successful. We will be shipping your order to you soon.";
//                // Getting payment row already exist from order reference number
//                try {
//                    $currentDate = new DateTime('now', new DateTimeZone('UTC'));
//                    $currentTime = $currentDate->format("Y-m-d H:i:s");
//                    $nb_order_no = Order::generateReference();
//
//                    $data = array('status' => 'paid', 'updated_at' => $currentTime, 'nb_order_no' => $nb_order_no);
//                    Db::getInstance()->update('amc', $data, 'order_id=\'' . $OrderId . '\'');
//                    $affectedRows = Db::getInstance()->Affected_Rows();
//                    if ($affectedRows) {
//                        $this->context->smarty->assign(array(
//                            'message' => $message,
//                        ));
//                        $orderInfo = $this->getOrderInfo($OrderId);
////                        $coupon = false;
//                        if (!empty($orderInfo)) {
//                            $amcSql = "Select amount from " . _DB_PREFIX_ . "amc where order_id = '" . $OrderId . "' ";
//                            $amcData = Db::getInstance()->executeS($amcSql);
//
//                            $categorySql = "select name from " . _DB_PREFIX_ . "category_lang where id_category = ". $amcData[0]['category'] ."";
//                            $categoryData = Db::getInstance()->executeS($categorySql);
//
//                            $productSql = "select name from " . _DB_PREFIX_ . "product_lang where id_product = ". $amcData[0]['product'] ."";
//                            $productData = Db::getInstance()->executeS($productSql);
//
////                            $coupon = $this->autoAddDiscountCouponCodeAgainstDemoOrder($orderData[0]['amount']);
//
//                            $amcTotalPrice = $amcData[0]['amount'];
//
//                            $amcTax = 12.36;
//                            $amcPrice = round(($amcTotalPrice * 100) / (100 + $amcTax), 2);
//                            $receiptNo = sprintf('%06d', $orderInfo['amc_id']);
//                            $content = array(
//                                'demoPriceTaxExcl' => $amcPrice,
//                                'demoPriceTaxIncl' => $amcTotalPrice,
//                                'demoPriceTotal' => $amcTotalPrice,
//                                'demoTax' => $amcTax,
//                                'receiptNo' => $receiptNo,
//                                'demoDate' => $orderInfo['created_at'],
//                                'demoAddress' => $this->getFormattedAddress($orderInfo['name'], $orderInfo['address'], $orderInfo['city'], $orderInfo['state'], $orderInfo['zip']),
//                                'category' => $categoryData[0]['name']
//                            );
//
//                            $pdf = new DemoPdf($this->context->smarty, $this->context->language->id);
//                            $content = $pdf->render(false, $content);
//                            $fileAttachment = array();
//                            $fileAttachment['content'] = $content;
//                            $fileAttachment['name'] = 'AMC_Receipt';
//                            $fileAttachment['mime'] = 'application/pdf';
//                            $data = array('{id}' => $orderInfo['amc_id'], '{date}' => $orderInfo['purchase_date'],
//                                '{order_id}' => $orderInfo['order_id'], '{name}' => $orderInfo['name'], '{product}' => $productData[0]['name'],
//                                '{nb_order_no}' => $nb_order_no, '{address}' => $orderInfo['address'], '{country}' => $orderInfo['country'],
//                                '{state}' => $orderInfo['state'], '{city}' => $orderInfo['city'], '{zip}' => $orderInfo['zip'],
//                                '{mobile}' => $orderInfo['mobile'], '{email}' => $orderInfo['email'],  '{category}' => $categoryData[0]['name'],
//                                '{specialComments}' => $orderInfo['special_comments']);
//                            $this->sendEmails($data, $fileAttachment);
//                            $this->sendMessage($orderInfo['category'], $orderInfo['mobile']);
//
//                        }
////                        $this->context->smarty->assign(array('coupon' => $coupon));
//                        $this->setTemplate('success.tpl');
//
//                    }
//                } catch (Exception $e) {
//                    throw new PrestaShopExceptionCore();
//                }
//
//            } else if ($Checksum && $AuthDesc === "B") {
////                echo "<br>Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail";
//                $this->setTemplate('error.tpl');
//                //Here you need to put in the routines/e-mail for a  "Batch Processing" order
//                //This is only if payment for this transaction has been made by an American Express Card or by any netbank and status is not known is real time  the authorisation status will be  available only after 5-6 hours  at the "View Pending Orders" or you may do an order status query to fetch the status . Refer inetegrtaion document for order status tracker documentation"
//            } else if ($Checksum && $AuthDesc === "N") {
//                $this->setTemplate('error.tpl');
//
//                //Here you need to put in the routines for a failed
//                //transaction such as sending an email to customer
//                //setting database status etc etc
//            } else {
//
////    Tools::redirect('index.php?controller=my-account');
//                //Here you need to check for the checksum, the checksum did not match hence the error.
//                $this->setTemplate('error.tpl');
//            }
//        }
//    }

    public function postProcess()
    {
        $WorkingKey = _WORKING_KEY; //put in the 32 bit working key in the quotes provided here
        $card_number = '';
        $card_expiration = '';
        $card_holder = '';
        $MerchantId = isset($_REQUEST["Merchant_Id"]) ? $_REQUEST["Merchant_Id"] : '';
        $OrderId = isset($_REQUEST["Order_Id"]) ? $_REQUEST["Order_Id"] : '';
        $Amount = isset($_REQUEST["Amount"]) ? $_REQUEST["Amount"] : '';
        $AuthDesc = isset($_REQUEST["AuthDesc"]) ? $_REQUEST["AuthDesc"] : '';
        $avnChecksum = isset($_REQUEST["Checksum"]) ? $_REQUEST["Checksum"] : '';
        $nb_order_no = isset($_REQUEST["nb_order_no"]) ? $_REQUEST['nb_order_no'] : '';
        if (empty($MerchantId) || empty($OrderId) || empty($Amount) || empty($AuthDesc) || empty($avnChecksum) || empty($nb_order_no))
            $this->setTemplate('illegal_access.tpl');
        else {
            $Checksum = verifyChecksum($MerchantId, $OrderId, $Amount, $AuthDesc, $WorkingKey, $avnChecksum);
            $billing_cust_name = isset($_REQUEST["billing_cust_name"]) ? $_REQUEST["billing_cust_name"] : '';
            $billing_cust_address = isset($_REQUEST["billing_cust_address"]) ? $_REQUEST["billing_cust_address"] : '';
            $billing_cust_country = isset($_REQUEST["billing_cust_country"]) ? $_REQUEST["billing_cust_country"] : '';
            $billing_cust_tel = isset($_REQUEST["billing_cust_tel"]) ? $_REQUEST['billing_cust_tel'] : '';
            $billing_cust_email = isset($_REQUEST["billing_cust_email"]) ? $_REQUEST["billing_cust_email"] : '';
            $delivery_cust_name = isset($_REQUEST["delivery_cust_name"]) ? $_REQUEST["delivery_cust_name"] : '';
            $delivery_cust_address = isset($_REQUEST["delivery_cust_address"]) ? $_REQUEST["delivery_cust_address"] : '';
            $delivery_cust_tel = isset($_REQUEST["delivery_cust_tel"]) ? $_REQUEST["delivery_cust_tel"] : '';
            $delivery_cust_notes = isset($_REQUEST["delivery_cust_notes"]) ? $_REQUEST["delivery_cust_notes"] : '';
            $Merchant_Param = isset($_REQUEST["Merchant_Param"]) ? $_REQUEST["Merchant_Param"] : '';

            $card_category = isset($_REQUEST["card_category"]) ? $_REQUEST["card_category"] : '';

            if (true && $AuthDesc === "Y") {
                $message = "<br>Thank you for shopping with us. Your credit card has been charged and your transaction is successful. We will be shipping your order to you soon.";
                // Getting payment row already exist from order reference number
                try {
                    $currentDate = new DateTime('now', new DateTimeZone('UTC'));
                    $currentTime = $currentDate->format("Y-m-d H:i:s");
                    $nb_order_no = Order::generateReference();

                    $data = array('status' => 'paid', 'updated_at' => $currentTime, 'nb_order_no' => $nb_order_no);
                    Db::getInstance()->update('amc', $data, 'order_id=\'' . $OrderId . '\'');
                    $affectedRows = Db::getInstance()->Affected_Rows();

                    $products_list = '';
                    if ($affectedRows) {
                        $this->context->smarty->assign(array(
                            'message' => $message,
                        ));
                        $orderInfo = $this->getOrderInfo($OrderId);
//                        $coupon = false;
                        if (!empty($orderInfo)) {
                            $amcSql = "Select * from " . _DB_PREFIX_ . "amc where order_id = '" . $OrderId . "' ";
                            $amcData = Db::getInstance()->executeS($amcSql);

                            $categorySql = "select name from " . _DB_PREFIX_ . "category_lang where id_category = ". $amcData[0]['category'] ."";
                            $categoryData = Db::getInstance()->executeS($categorySql);

                            $productSql = "select name from " . _DB_PREFIX_ . "product_lang where id_product = ". $amcData[0]['product'] ."";
                            $productData = Db::getInstance()->executeS($productSql);

//                            $coupon = $this->autoAddDiscountCouponCodeAgainstDemoOrder($orderData[0]['amount']);

                            $amcTotalPrice = $amcData[0]['amount'];
                            $amc_amount = number_format($amcTotalPrice, 2, '.', '');

                            //$amcTax = 12.36;
                            //$amcTax = 14;
			                $amcTax = 14.5;

                            if(strtotime(date('Y-m-d'))>=strtotime(date('2016-06-01')))
                                $amcTax=15;


                            $updata = array('tax_rate' => $amcTax);
                            Db::getInstance()->update('amc', $updata, 'order_id=\'' . $OrderId . '\'');

                            $amcPrice = round(($amcTotalPrice * 100) / (100 + $amcTax), 2);
                            $receiptNo = sprintf('%06d', $orderInfo['amc_id']);
                            $quantity=1;
                            if(!empty($amcData['period']))
                                $quantity=$amcData['period'];

                            $content = array(
                                'demoPriceTaxExcl' => $amcPrice,
                                'demoPriceTaxIncl' => $amcTotalPrice,
                                'demoPriceTotal' => $amcTotalPrice,
                                'demoTax' => $amcTax,
                                'receiptNo' => $receiptNo,
                                'period'=>$quantity,
                                'demoDate' => $orderInfo['created_at'],
                                'demoAddress' => $this->getFormattedAddress($orderInfo['name'], $orderInfo['address'], $orderInfo['city'], $orderInfo['state'], $orderInfo['zip']),
                                'category' => $categoryData[0]['name']
                            );

                            $pdf = new DemoPdf($this->context->smarty, $this->context->language->id);
                            $content = $pdf->render(false, $content);
                            $fileAttachment = array();
                            $fileAttachment['content'] = $content;
                            $fileAttachment['name'] = 'AMC_Receipt';
                            $fileAttachment['mime'] = 'application/pdf';

                            $products_list .=
                                '<tr style="background-color:#EBECEE;">
                                    <td style="padding:0.6em 0.4em;">' . $nb_order_no. '</td>
                            <td style="padding:0.6em 0.4em;">
                                <strong>'
                                . $productData[0]['name'].
                                '</strong>
                            </td>
                            <td style="padding:0.6em 0.4em; text-align:center;">'.$quantity.'</td>
                            <td style="padding:0.6em 0.4em; text-align:right;">' . $amc_amount . '</td>
				        </tr>';

                            $data = array('{id}' => $orderInfo['amc_id'], '{date}' => $orderInfo['purchase_date'],'{productName}' => $productData[0]['name'],
                                '{order_id}' => $orderInfo['order_id'], '{name}' => $orderInfo['name'], '{product}' => $products_list,
                                '{nb_order_no}' => $nb_order_no, '{address}' => $orderInfo['address'], '{country}' => $orderInfo['country'],
                                '{state}' => $orderInfo['state'], '{city}' => $orderInfo['city'], '{zip}' => $orderInfo['zip'],
                                '{mobile}' => $orderInfo['mobile'], '{email}' => $orderInfo['email'],  '{category}' => $categoryData[0]['name'],
                                '{specialComments}' => $orderInfo['special_comments'],'{total_amount}' => $amc_amount,'{payment}' => 'CCAvenue');
                            $this->sendEmails($data, $fileAttachment);
                            $this->sendMessage($orderInfo['category'], $orderInfo['mobile']);

                        }
//                        $this->context->smarty->assign(array('coupon' => $coupon));
                        $this->setTemplate('success.tpl');

                    }
                } catch (Exception $e) {
                    throw new PrestaShopExceptionCore();
                }

            } else if ($Checksum && $AuthDesc === "B") {
//                echo "<br>Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail";
//				 echo "<br>Testing-2";
                $this->setTemplate('error.tpl');
                //Here you need to put in the routines/e-mail for a  "Batch Processing" order
                //This is only if payment for this transaction has been made by an American Express Card or by any netbank and status is not known is real time  the authorisation status will be  available only after 5-6 hours  at the "View Pending Orders" or you may do an order status query to fetch the status . Refer inetegrtaion document for order status tracker documentation"
            } else if ($Checksum && $AuthDesc === "N") {
//				 echo "<br>Testing-3";
                $this->setTemplate('error.tpl');

                //Here you need to put in the routines for a failed
                //transaction such as sending an email to customer
                //setting database status etc etc
            } else {

//    Tools::redirect('index.php?controller=my-account');
                //Here you need to check for the checksum, the checksum did not match hence the error.
//				 echo "<br>Testing-4";
                $this->setTemplate('error.tpl');
            }
        }
    }

    private
    function addMonthToDate($date, $monthToAdd = 1)
    {
        $year = $date->format('Y');
        $month = $date->format('n');
        $day = $date->format('d');

        $year += floor($monthToAdd / 12);
        $monthToAdd = $monthToAdd % 12;
        $month += $monthToAdd;
        if ($month > 12) {
            $year++;
            $month = $month % 12;
            if ($month === 0)
                $month = 12;
        }

        if (!checkdate($month, $day, $year)) {
            $d2 = DateTime::createFromFormat('Y-n-j', $year . '-' . $month . '-1');
            $d2->modify('last day of');
        } else {
            $d2 = DateTime::createFromFormat('Y-n-d', $year . '-' . $month . '-' . $day);
        }
        $d2->setTime($date->format('H'), $date->format('i'), $date->format('s'));
        return $d2;
    }

//    public function postProcess()
//    {
//        $WorkingKey = _WORKING_KEY; //put in the 32 bit working key in the quotes provided here
//        $card_number = '';
//        $card_expiration = '';
//        $card_holder = '';
//        $MerchantId = isset($_REQUEST["Merchant_Id"]) ? $_REQUEST["Merchant_Id"] : '';
//        $OrderId = isset($_REQUEST["Order_Id"]) ? $_REQUEST["Order_Id"] : '';
//        $Amount = isset($_REQUEST["Amount"]) ? $_REQUEST["Amount"] : '';
//        $AuthDesc = isset($_REQUEST["AuthDesc"]) ? $_REQUEST["AuthDesc"] : '';
//        $avnChecksum = isset($_REQUEST["Checksum"]) ? $_REQUEST["Checksum"] : '';
//        $nb_order_no = isset($_REQUEST["nb_order_no"]) ? $_REQUEST['nb_order_no'] : '';
////        if (empty($MerchantId) || empty($OrderId) || empty($Amount) || empty($AuthDesc) || empty($avnChecksum) || empty($nb_order_no))
////            $this->setTemplate('illegal_access.tpl');
////        else {
//            $Checksum = verifyChecksum($MerchantId, $OrderId, $Amount, $AuthDesc, $WorkingKey, $avnChecksum);
//            $billing_cust_name = isset($_REQUEST["billing_cust_name"]) ? $_REQUEST["billing_cust_name"] : '';
//            $billing_cust_address = isset($_REQUEST["billing_cust_address"]) ? $_REQUEST["billing_cust_address"] : '';
//            $billing_cust_country = isset($_REQUEST["billing_cust_country"]) ? $_REQUEST["billing_cust_country"] : '';
//            $billing_cust_tel = isset($_REQUEST["billing_cust_tel"]) ? $_REQUEST['billing_cust_tel'] : '';
//            $billing_cust_email = isset($_REQUEST["billing_cust_email"]) ? $_REQUEST["billing_cust_email"] : '';
//            $delivery_cust_name = isset($_REQUEST["delivery_cust_name"]) ? $_REQUEST["delivery_cust_name"] : '';
//            $delivery_cust_address = isset($_REQUEST["delivery_cust_address"]) ? $_REQUEST["delivery_cust_address"] : '';
//            $delivery_cust_tel = isset($_REQUEST["delivery_cust_tel"]) ? $_REQUEST["delivery_cust_tel"] : '';
//            $delivery_cust_notes = isset($_REQUEST["delivery_cust_notes"]) ? $_REQUEST["delivery_cust_notes"] : '';
//            $Merchant_Param = isset($_REQUEST["Merchant_Param"]) ? $_REQUEST["Merchant_Param"] : '';
//
//            $card_category = isset($_REQUEST["card_category"]) ? $_REQUEST["card_category"] : '';
//
////            if (true && $AuthDesc === "Y") {
//                $message = "<br>Thank you for shopping with us. Your credit card has been charged and your transaction is successful. We will be shipping your order to you soon.";
//                // Getting payment row already exist from order reference number
//                try {
//                    $currentDate = new DateTime('now', new DateTimeZone('UTC'));
//                    $currentTime = $currentDate->format("Y-m-d H:i:s");
//                    $data = array('status' => 'paid', 'updated_at' => $currentTime, 'nb_order_no' => $nb_order_no);
//                    Db::getInstance()->update('demos', $data, 'order_id=\'' . $OrderId . '\'');
//                    $affectedRows = Db::getInstance()->Affected_Rows();
//                    if ($affectedRows) {
//                        $this->context->smarty->assign(array(
//                            'message' => $message,
//                        ));
//                        $orderInfo = $this->getOrderInfo($OrderId);
//                        $coupon = false;
//                        if (!empty($orderInfo)) {
//                            $orderSql = "Select amount from ". _DB_PREFIX_ ."demos where order_id = '". $OrderId ."' ";
//                            $orderData = Db::getInstance()->executeS($orderSql);
//
//                            $coupon = $this->autoAddDiscountCouponCodeAgainstDemoOrder($orderData[0]['amount']);
//
//                            $demoTotalPrice = $orderData[0]['amount'];
//
//                            $demoTax = 12.36;
//                            $demoPrice = round(($demoTotalPrice * 100) / (100 + $demoTax), 2);
//                            $receiptNo = sprintf('%06d', $orderInfo['demos_id']);
//                            $content = array(
//                                'demoPriceTaxExcl' => $demoPrice,
//                                'demoPriceTaxIncl' => $demoTotalPrice,
//                                'demoPriceTotal' => $demoTotalPrice,
//                                'demoTax' => $demoTax,
//                                'receiptNo' => $receiptNo,
//                                'demoDate' => $orderInfo['created_at'],
//                                'demoAddress' => $this->getFormattedAddress($orderInfo['name'], $orderInfo['address'], $orderInfo['city'], $orderInfo['state'], $orderInfo['zip']),
//                                'category' => $orderInfo['product']
//                            );
//
//                            $pdf = new DemoPdf($this->context->smarty, $this->context->language->id);
//                            $content = $pdf->render(false, $content);
//                            $fileAttachment = array();
//                            $fileAttachment['content'] = $content;
//                            $fileAttachment['name'] = 'Home_Demo_Receipt';
//                            $fileAttachment['mime'] = 'application/pdf';
//                            $data = array('{id}'=>$orderInfo['demos_id'],'{date}' => $orderInfo['date'],
//                                '{order_id}' => $orderInfo['order_id'], '{name}' => $orderInfo['name'], '{product}' => $orderInfo['product'],
//                                '{nb_order_no}' => $nb_order_no, '{address}' => $orderInfo['address'], '{country}' => $orderInfo['country'],
//                                '{state}' => $orderInfo['state'], '{city}' => $orderInfo['city'], '{zip}' => $orderInfo['zip'],
//                                '{mobile}' => $orderInfo['mobile'], '{email}' => $orderInfo['email'], '{coupon}' => $orderInfo['coupon'],
//                                '{category}' => $orderInfo['category'], '{specialComments}' => $orderInfo['special_comments']);
//                            $this->sendEmails($data, $fileAttachment, $coupon);
//                            $this->sendMessage($orderInfo['category'], $orderInfo['mobile']);
//
//                        }
//                        $this->context->smarty->assign(array('coupon' => $coupon));
//                        $this->setTemplate('success.tpl');
//
//                    }
//                } catch (Exception $e) {
//                    throw new PrestaShopExceptionCore();
//                }
//
////            } else if ($Checksum && $AuthDesc === "B") {
//////                echo "<br>Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail";
////                $this->setTemplate('error.tpl');
////                //Here you need to put in the routines/e-mail for a  "Batch Processing" order
////                //This is only if payment for this transaction has been made by an American Express Card or by any netbank and status is not known is real time  the authorisation status will be  available only after 5-6 hours  at the "View Pending Orders" or you may do an order status query to fetch the status . Refer inetegrtaion document for order status tracker documentation"
////            } else if ($Checksum && $AuthDesc === "N") {
////                $this->setTemplate('error.tpl');
////
////                //Here you need to put in the routines for a failed
////                //transaction such as sending an email to customer
////                //setting database status etc etc
////            } else {
////
//////    Tools::redirect('index.php?controller=my-account');
////                //Here you need to check for the checksum, the checksum did not match hence the error.
////                $this->setTemplate('error.tpl');
////            }
//
////        }
//    }

    private
    function getFormattedAddress($name, $address, $city, $state, $zip)
    {
        $address = '&nbsp;&nbsp;' . ucfirst($name) . '<br>&nbsp;&nbsp;' . $address . '<br>&nbsp;&nbsp;' . $city . '<br>&nbsp;&nbsp;' . $state . '<br>&nbsp;&nbsp;' . $zip;
        return $address;

    }

    private
    function getOrderInfo($orderId)
    {
        $sql = "SELECT * from " . _DB_PREFIX_ . "amc where " . _DB_PREFIX_ . "amc.order_id='" . $orderId . "';";
        if ($results = Db::getInstance()->getRow($sql))
            return $results;
        return array();
    }

    private
    function sendMessage($category, $mobile)
    {
        try {
            $message = sprintf(_SMS_MESSAGE, $category);

            $username = _SMS_USERNAME;
            $password = _SMS_PASSWORD;
            //create api url to hit
            $sms_url = _SMS_URL;
            $senderId = _SMS_SENDERID;
            $sms_url = "$sms_url?user=$username&password=$password&sender=$senderId&mobiles=$mobile&message=" . urlencode($message);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $sms_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, '6');
            $result = curl_exec($ch);
            $error = curl_error($ch);
            $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

        } catch (Exception $e) {
            //consuming exception
        }

    }

    private function sendEmails($data, $fileAttachment)
    {
        try {
            $adminTemplate = 'admin_mail';
            $template = 'customer_mail';
//            if (!empty($couponDetail)) {
//                $data['{coupon}'] = $couponDetail['couponCode'];
//                $data['{fromDate}'] = date("d-m-Y", strtotime($couponDetail['fromDate']));
//                $data['{toDate}'] = date("d-m-Y", strtotime($couponDetail['toDate']));
//                $adminTemplate = 'admin_mail_with_coupon';
//                $template = 'customer_mail_coupon';
//            }

//            if (_PS_ENVIRONMENTS) {
//            $adminEmail = 'ptailor@reenapplesolutions.com';
            $adminEmail = AMC_EMAIL_ADMIN;
            $res = Mail::Send(
                (int)1,
                $adminTemplate,
                Mail::l("Annual Maintenance Contract - #" . $data['{id}'] . " - " . $data['{productName}'] . " - " . $data['{city}'] . " - " . $data['{name}'], (int)1),
                $data,
                $adminEmail,
                'Administrator',
                null,
                null,
                $fileAttachment,
                null,
                getcwd() . _MODULE_DIR_ . AMC::MODULE_NAME . '/',
                false,
                null
            );

            //sending email to receivable
            $receivableEmail = AMC_EMAIL_2_ADMIN;
//                $receivableEmail = 'ptailor@reenapplesolutions.com';
            if (!empty($receivableEmail)) {
                $res = Mail::Send(
                    (int)1,
                    $adminTemplate,
                    Mail::l("Annual Maintenance Contract - #" . $data['{id}'] . " - " . $data['{productName}'] . " - " . $data['{city}'] . " - " . $data['{name}'], (int)1),
                    $data,
                    $receivableEmail,
                    'Administrator',
                    null,
                    null,
                    $fileAttachment,
                    null,
                    getcwd() . _MODULE_DIR_ . AMC::MODULE_NAME . '/',
                    false,
                    null
                );
            }

            $customerCareEmail = CUSTOMER_CARE_EMAIL_ID;
//            $customerCareEmail = 'ptailor@reenapplesolutions.com';
            // Sending mail to customer care
            $res = Mail::Send(
                (int)1,
                $adminTemplate,
                Mail::l("Annual Maintenance Contract - #" . $data['{id}'] . " - " . $data['{productName}'] . " - " . $data['{city}'] . " - " . $data['{name}'], (int)1),
                $data,
                $customerCareEmail,
                'Administrator',
                null,
                null,
                $fileAttachment,
                null,
                getcwd() . _MODULE_DIR_ . AMC::MODULE_NAME . '/',
                false,
                null
            );

//            } else {
//                $res = Mail::Send(
//                    (int)1,
//                    $adminTemplate,
//                    Mail::l($data['{name}']." - Pre Sales Demo", (int)1),
//                    $data,
//                    Configuration::get('PS_SHOP_EMAIL'),
//                    'Administrator',
//                    null,
//                    null,
//                    $fileAttachment,
//                    null,
//                    getcwd() . _MODULE_DIR_ . DemoRegistration::MODULE_NAME . '/',
//                    false,
//                    null
//                );
//            }
        } catch
        (Exception $e) {

        }

        try {

            $res = Mail::Send(
                (int)1,
                $template,
                Mail::l("Annual Maintenance Contract- #" . $data['{id}'] . " - " . $data['{productName}'] . " - " . $data['{city}'] . " - " . $data['{name}'], (int)1),
                $data,
                $data['{email}'],
                $data['{name}'],
                null,
                null,
                $fileAttachment,
                null,
                getcwd() . _MODULE_DIR_ . AMC::MODULE_NAME . '/',
                false,
                null
            );

        } catch (Exception $e) {

        }

    }

    private function sendConfirmationEmails($data,$userTemplate,$emailSubject)
    {
        try {

            $res = Mail::Send(
                (int)1,
                $userTemplate,
                $emailSubject,
                $data,
                $data['{email}'],
                $data['{name}'],
                null,
                null,
                '',
                null,
                getcwd() . _MODULE_DIR_ . AMC::MODULE_NAME . '/',
                false,
                null
            );

        } catch (Exception $e) {

        }
    }

    private function autoAddDiscountCouponCodeAgainstDemoOrder($orderAmount)
    {
        //insert coupon to cart rule table
        $fromDate = new DateTime();
        $finalfromDate = $fromDate->format('Y-m-d H:00:00');
        $toDate = $this->addMonthToDate($fromDate);
        $toDate = $toDate->format('Y-m-d H:00:00');
        $discountName = 'Discount Coupon Against Pre-Sales Demo Charges Paid Earlier';
        $couponCode = $this->getCouponCode();
        $cart_rule_data = array('id_customer' => 0, 'date_from' => $finalfromDate, 'date_to' => $toDate, 'description' => $discountName,
            'quantity' => 1, 'quantity_per_user' => 1, 'priority' => 1, 'partial_use' => 1, 'code' => $couponCode, 'minimum_amount' => 1000, 'minimum_amount_tax' => 1, 'minimum_amount_currency' => 1, 'minimum_amount_shipping' => 1,
            'country_restriction' => 0, 'carrier_restriction' => 0, 'group_restriction' => 0, 'cart_rule_restriction' => 0, 'product_restriction' => 1, 'shop_restriction' => 0, 'free_shipping' => 0, 'reduction_percent' => 0, 'reduction_amount' => $orderAmount, 'reduction_tax' => 1, 'reduction_currency' => 1, 'reduction_product' => 0,
            'gift_product' => 0, 'gift_product_attribute' => 0, 'highlight' => 0, 'active' => 1, 'date_add' => date("Y-m-d H:i:s"), 'date_upd' => date("Y-m-d H:i:s"));
        Db::getInstance()->insert('cart_rule', $cart_rule_data);
        $id_cart_rule = Db::getInstance()->Insert_ID();
        if ($id_cart_rule) {
            $cart_rule_lang_data = array('id_cart_rule' => (int)$id_cart_rule, 'id_lang' => 1, 'name' => $discountName);
            Db::getInstance()->insert('cart_rule_lang', $cart_rule_lang_data);
            $cart_rule_product_rule_group = array('id_cart_rule' => (int)$id_cart_rule, 'quantity' => 1);
            Db::getInstance()->insert('cart_rule_product_rule_group', $cart_rule_product_rule_group);
            $id_product_rule_group = Db::getInstance()->Insert_ID();
            $cart_rule_product_rule_data = array('id_product_rule_group' => (int)$id_product_rule_group, 'type' => 'categories');
            Db::getInstance()->insert('cart_rule_product_rule', $cart_rule_product_rule_data);
            $id_product_rule = Db::getInstance()->Insert_ID();

            $categorySql = "SELECT  '_DB_PREFIX_'.category_lang.id_category as 'categgory_id' FROM '_DB_PREFIX_'.demos JOIN  '_DB_PREFIX_'.category_lang ON  '_DB_PREFIX_'.demos.category =  '_DB_PREFIX_'.category_lang.name ";
            $category = Db::getInstance()->executeS($categorySql);

            $cart_rule_product_rule_value = array('id_product_rule' => (int)$id_product_rule, 'id_item' => $category[0]['category_id']);
            Db::getInstance()->insert('cart_rule_product_rule_value', $cart_rule_product_rule_value);
            return array('couponCode' => $couponCode, 'fromDate' => $finalfromDate, 'toDate' => $toDate);
        }
        return array();
    }

    private function getCouponCode()
    {
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $res = "";
        for ($i = 0; $i < 10; $i++) {
            $res .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $res;
    }


}
