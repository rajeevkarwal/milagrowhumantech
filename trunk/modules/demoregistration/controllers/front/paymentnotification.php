<?php
/**
 * Created by JetBrains PhpStorm.
 * User: keshav
 * Date: 9/8/13
 * Time: 1:30 PM
 * To change this template use File | Settings | File Templates.
 */
include_once(dirname(__FILE__) . '/../../../../config/config.inc.php');
include_once(dirname(__FILE__) . '/../../../../init.php');
require_once(dirname(__FILE__) . '/../../DemoPdf.php');

require(getcwd() . _MODULE_DIR_ . "demoregistration/libFunctions.php");
define('_SMS_URL', 'https://control.msg91.com/api/sendhttp.php');
define('_WORKING_KEY', 'f6srdljv9krmyof389tjdixf86bgmc55');
//define('_SMS_USERNAME', '56096');
//define('_SMS_PASSWORD', 'milagrowHelpdesk');
define('_SMS_SENDERID', 'MLGROW');
define('_SMS_AUTH_KEY','81204AaZ37SnJuk550d8fe4');
define('_SMS_MESSAGE', 'Your demo request for %s has been registered successfully. Please check your email for additional details.-MILAGROW');
define('BOOK_DEMO_EMAIL_ADMIN', 'customercare@milagrow.in');
define('BOOK_DEMO_EMAIL_2_ADMIN', 'receivables@milagrow.in');
define('CUSTOMER_CARE_EMAIL_ID', 'cs@milagrow.in');
//define('BOOK_DEMO_EMAIL_ADMIN', 'ptailor@greenapplesolutions.com');
//define('BOOK_DEMO_EMAIL_2_ADMIN', 'ptailor@greenapplesolutions.com');
//define('CUSTOMER_CARE_EMAIL_ID', 'ptailor@greenapplesolutions.com');

class DemoRegistrationPaymentNotificationModuleFrontController extends ModuleFrontController
{
    public $display_column_left = false;

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
                    $data = array('status' => 'paid', 'updated_at' => $currentTime, 'nb_order_no' => $nb_order_no);
                    Db::getInstance()->update('demos', $data, 'order_id=\'' . $OrderId . '\'');
                    $affectedRows = Db::getInstance()->Affected_Rows();
                    if ($affectedRows) {
                        $this->context->smarty->assign(array(
                            'message' => $message,
                        ));
                        $orderInfo = $this->getOrderInfo($OrderId);
                        $coupon = false;
                        if (!empty($orderInfo)) {
                            $orderSql = "Select amount from ". _DB_PREFIX_ ."demos where order_id = '". $OrderId ."' ";
                            $orderData = Db::getInstance()->executeS($orderSql);

                            $coupon = $this->autoAddDiscountCouponCodeAgainstDemoOrder($orderData[0]['amount']);

                            $demoTotalPrice = $orderData[0]['amount'];

                            $demoTax = 12.36;
                            $demoPrice = round(($demoTotalPrice * 100) / (100 + $demoTax), 2);
                            $receiptNo = sprintf('%06d', $orderInfo['demos_id']);
                            $content = array(
                                'demoPriceTaxExcl' => $demoPrice,
                                'demoPriceTaxIncl' => $demoTotalPrice,
                                'demoPriceTotal' => $demoTotalPrice,
                                'demoTax' => $demoTax,
                                'receiptNo' => $receiptNo,
                                'demoDate' => $orderInfo['created_at'],
                                'demoAddress' => $this->getFormattedAddress($orderInfo['name'], $orderInfo['address'], $orderInfo['city'], $orderInfo['state'], $orderInfo['zip']),
                                'category' => $orderInfo['product']
                            );

                            $pdf = new DemoPdf($this->context->smarty, $this->context->language->id);
                            $content = $pdf->render(false, $content);
                            $fileAttachment = array();
                            $fileAttachment['content'] = $content;
                            $fileAttachment['name'] = 'Home_Demo_Receipt';
                            $fileAttachment['mime'] = 'application/pdf';
                            $data = array('{id}'=>$orderInfo['demos_id'],'{date}' => $orderInfo['date'],
                                '{order_id}' => $orderInfo['order_id'], '{name}' => $orderInfo['name'], '{product}' => $orderInfo['product'],
                                '{nb_order_no}' => $nb_order_no, '{address}' => $orderInfo['address'], '{country}' => $orderInfo['country'],
                                '{state}' => $orderInfo['state'], '{city}' => $orderInfo['city'], '{zip}' => $orderInfo['zip'],
                                '{mobile}' => $orderInfo['mobile'], '{email}' => $orderInfo['email'], '{coupon}' => $orderInfo['coupon'],
                                '{category}' => $orderInfo['category'], '{specialComments}' => $orderInfo['special_comments']);
                            $this->sendEmails($data, $fileAttachment, $coupon);
                            $this->sendMessage($orderInfo['category'], $orderInfo['mobile']);

                        }
                        $this->context->smarty->assign(array('coupon' => $coupon));
                        $this->setTemplate('success.tpl');

                    }
                } catch (Exception $e) {
                    throw new PrestaShopExceptionCore();
                }

            } else if ($Checksum && $AuthDesc === "B") {
//                echo "<br>Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail";
                $this->setTemplate('error.tpl');
                //Here you need to put in the routines/e-mail for a  "Batch Processing" order
                //This is only if payment for this transaction has been made by an American Express Card or by any netbank and status is not known is real time  the authorisation status will be  available only after 5-6 hours  at the "View Pending Orders" or you may do an order status query to fetch the status . Refer inetegrtaion document for order status tracker documentation"
            } else if ($Checksum && $AuthDesc === "N") {
                $this->setTemplate('error.tpl');

                //Here you need to put in the routines for a failed
                //transaction such as sending an email to customer
                //setting database status etc etc
            } else {

//    Tools::redirect('index.php?controller=my-account');
                //Here you need to check for the checksum, the checksum did not match hence the error.
                $this->setTemplate('error.tpl');
            }

        }

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
//
//    }

    private function addMonthToDate($date, $monthToAdd = 1)
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

    private function getFormattedAddress($name, $address, $city, $state, $zip)
    {
        $address = '&nbsp;&nbsp;' . ucfirst($name) . '<br>&nbsp;&nbsp;' . $address . '<br>&nbsp;&nbsp;' . $city . '<br>&nbsp;&nbsp;' . $state . '<br>&nbsp;&nbsp;' . $zip;
        return $address;

    }

    private function getOrderInfo($orderId)
    {
        $sql = "SELECT * from " . _DB_PREFIX_ . "demos where " . _DB_PREFIX_ . "demos.order_id='" . $orderId . "';";
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
		    $auth_key = _SMS_AUTH_KEY;
                    //create api url to hit
                    $sms_url = _SMS_URL;
                    $senderId = _SMS_SENDERID;
                    $sms_url = "$sms_url?authkey=$auth_key&sender=$senderId&mobiles=$mobile&message=" . urlencode($message)."&route=4";
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

    private
    function sendEmails($data, $fileAttachment, $couponDetail)
    {
        try {
            $adminTemplate = 'admin_mail';
            $template = 'customer_mail';
            if (!empty($couponDetail)) {
                $data['{coupon}'] = $couponDetail['couponCode'];
                $data['{fromDate}'] = date("d-m-Y", strtotime($couponDetail['fromDate']));
                $data['{toDate}'] = date("d-m-Y", strtotime($couponDetail['toDate']));
                $adminTemplate = 'admin_mail_with_coupon';
                $template = 'customer_mail_coupon';
            }

//            if (_PS_ENVIRONMENTS) {
//            $adminEmail = 'ptailor@reenapplesolutions.com';
                $adminEmail = BOOK_DEMO_EMAIL_ADMIN;
                $res = Mail::Send(
                    (int)1,
                    $adminTemplate,
                    Mail::l("Pre Sales Demo - #" . $data['{id}'] ." - ". $data['{product}'] ." - ". $data['{city}'] ." - ". $data['{name}'] , (int)1),
                    $data,
                    $adminEmail,
                    'Administrator',
                    null,
                    null,
                    $fileAttachment,
                    null,
                    getcwd() . _MODULE_DIR_ . DemoRegistration::MODULE_NAME . '/',
                    false,
                    null
                );

                //sending email to receivable
                $receivableEmail = BOOK_DEMO_EMAIL_2_ADMIN;
//                $receivableEmail = 'ptailor@reenapplesolutions.com';
                if (!empty($receivableEmail)) {
                    $res = Mail::Send(
                        (int)1,
                        $adminTemplate,
                        Mail::l("Pre Sales Demo - #" . $data['{id}'] ." - ". $data['{product}'] ." - ". $data['{city}'] ." - ". $data['{name}'] , (int)1),
                        $data,
                        $receivableEmail,
                        'Administrator',
                        null,
                        null,
                        $fileAttachment,
                        null,
                        getcwd() . _MODULE_DIR_ . DemoRegistration::MODULE_NAME . '/',
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
                    Mail::l("Pre Sales Demo - #" . $data['{id}'] ." - ". $data['{product}'] ." - ". $data['{city}'] ." - ". $data['{name}'] , (int)1),
                    $data,
                    $customerCareEmail,
                    'Administrator',
                    null,
                    null,
                    $fileAttachment,
                    null,
                    getcwd() . _MODULE_DIR_ . DemoRegistration::MODULE_NAME . '/',
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
                Mail::l("Pre Sales Demo Request - #" . $data['{id}'] ." - ". $data['{product}'] ." - ". $data['{city}'] ." - ". $data['{name}'] , (int)1),
                $data,
                $data['{email}'],
                $data['{name}'],
                null,
                null,
                $fileAttachment,
                null,
                getcwd() . _MODULE_DIR_ . DemoRegistration::MODULE_NAME . '/',
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
            'country_restriction' => 0, 'carrier_restriction' => 0, 'group_restriction' => 0, 'cart_rule_restriction' => 0, 'product_restriction' => 0, 'shop_restriction' => 0, 'free_shipping' => 0, 'reduction_percent' => 0, 'reduction_amount' => $orderAmount, 'reduction_tax' => 1, 'reduction_currency' => 1, 'reduction_product' => 0,
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
