<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hitanshu
 * Date: 12/8/13
 * Time: 12:58 PM
 * To change this template use File | Settings | File Templates.
 */
define('_WORKING_KEY', 'f6srdljv9krmyof389tjdixf86bgmc55');
define('_SMS_URL', 'https://control.msg91.com/sendhttp.php');
define('_SMS_USERNAME', '56096');
define('_SMS_PASSWORD', 'milagrowHelpdesk');
define('_SMS_SENDERID', 'MLGROW');
define('_CCAVENUE_COD_SUCCESS', 'Thank you for placing the order, %s.We have received Rs.%s. Your order is being processed. Please check your email for additional details.-MILAGROW');
define('_CCAVENUE_COD_ADMIN_EMAIL', 'outboundlogistics@milagrow.in');
define('_CCAVENUE_COD_RECEIVABLE_EMAIL', 'receivables@milagrow.in');

class CodPaymentNotificationModuleFrontController extends ModuleFrontController
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
            $billing_cust_state = isset($_REQUEST["billing_cust_state"]) ? $_REQUEST["billing_cust_state"] : '';
            $billing_cust_city = isset($_REQUEST["billing_cust_city"]) ? $_REQUEST["billing_cust_city"] : '';
            $billing_zip_code = isset($_REQUEST["billing_zip_code"]) ? $_REQUEST["billing_zip_code"] : '';
            $billing_cust_country = isset($_REQUEST["billing_cust_country"]) ? $_REQUEST["billing_cust_country"] : '';
            $billing_cust_tel = isset($_REQUEST["billing_cust_tel"]) ? $_REQUEST['billing_cust_tel'] : '';
            $billing_cust_email = isset($_REQUEST["billing_cust_email"]) ? $_REQUEST["billing_cust_email"] : '';
            $Merchant_Param = isset($_REQUEST["Merchant_Param"]) ? $_REQUEST["Merchant_Param"] : '';

            $card_category = isset($_REQUEST["card_category"]) ? $_REQUEST["card_category"] : '';
            $listOfOrders = $this->getOrdersFromReference($OrderId);
            if ($Checksum && $AuthDesc === "Y") {

                // Getting payment row already exist from order reference number
                try {
                    //getting list of orders for which advance payment has received
                    //logging payment received

                    $orderWiseAdvancePaymentMapping = array();
                    if (!empty($listOfOrders)) {
                        $sql = 'SELECT * from ' . _DB_PREFIX_ . 'order_payment WHERE order_reference=\'' . $OrderId . '\'';
                        $existing_id_currency = 1;
                        $existing_conversion_rate = 1.0000000;
                        if ($row = Db::getInstance()->getRow($sql)) {
                            $existing_id_currency = $row['id_currency'];
                            $existing_conversion_rate = $row['conversion_rate'];
                        }
                        $orderwiseAdvanceCODPayment = $this->getAdvanceCODAmount($listOfOrders);
                        foreach ($listOfOrders as $key => $singleOrder) {
                            $advancePayment = $orderwiseAdvanceCODPayment[$singleOrder['id_order']];
                            Db::getInstance()->insert('order_payment', array(
                                'id_currency' => (int)$existing_id_currency,
                                'amount' => $advancePayment,
                                'payment_method' => pSQL('ccavenue'),
                                'conversion_rate' => $existing_conversion_rate,
                                'transaction_id' => $nb_order_no,
                                'card_number' => $card_number,
                                'card_brand' => $card_category,
                                'card_expiration' => $card_expiration,
                                'card_holder' => $card_holder,
                                'date_add' => date('Y-m-d H:i:s'),
                                'order_reference' => $OrderId
                            ));
                            $last_insert_payment_id = Db::getInstance()->insert_id();
                            Db::getInstance()->insert('order_invoice_payment', array(
                                'id_order_invoice' => (int)$singleOrder['invoice_number'],
                                'id_order_payment' => (int)($last_insert_payment_id),
                                'id_order' => (int)($singleOrder['id_order']),
                            ));
                            $orderWiseAdvancePaymentMapping[] = array('amount' => $advancePayment, 'orderId' => $singleOrder['id_order'], 'reference' => $singleOrder['reference'] . '#' . ($key + 1), 'id_address_delivery' => $singleOrder['id_address_delivery']);
                        }

                        $billingAddress = array('firstname' => $billing_cust_name, 'lastname' => '', 'state' => $billing_cust_state, 'phone' => $billing_cust_tel, 'postcode' => $billing_zip_code, 'city' => $billing_cust_city, 'address1' => $billing_cust_address, 'address2' => '', 'country' => $billing_cust_country);
                        foreach ($orderWiseAdvancePaymentMapping as $orderEntry) {
                            $delivery = new Address($orderEntry['id_address_delivery']);
                            if (!empty($delivery) && !empty($delivery->phone_mobile)) {
                                $this->sendMessage($orderEntry['reference'], $orderEntry['amount'], $delivery->phone_mobile);
                            }
                            $this->sendEmailToCustomer($billingAddress, $orderEntry['reference'], $orderEntry['orderId'], $orderEntry['amount']);
                        }

                        $redirect = __PS_BASE_URI__ . 'module/cod/success';
                        header('Location: ' . $redirect);
                        exit;
                    }
                } catch
                (Exception $e) {
                    throw new PrestaShopExceptionCore();
                }

            } else
                if ($Checksum && $AuthDesc === "B") {
                    //if payment status in pending from ccavenue then dont change the order status
                    $redirect = __PS_BASE_URI__ . 'module/cod/error';
                    header('Location: ' . $redirect);
                    exit;

                    //Here you need to put in the routines/e-mail for a  "Batch Processing" order
                    //This is only if payment for this transaction has been made by an American Express Card or by any netbank and status is not known is real time  the authorisation status will be  available only after 5-6 hours  at the "View Pending Orders" or you may do an order status query to fetch the status . Refer inetegrtaion document for order status tracker documentation"
                } else if ($Checksum && $AuthDesc === "N") {
                    foreach ($listOfOrders as $rowOrder) {
                        $new_history = new OrderHistory();

                        if ($rowOrder['id_order']) {
                            $new_history->id_order = (int)$rowOrder['id_order'];
                            $new_history->changeIdOrderState(Configuration::get('PS_OS_ERROR'), $rowOrder['id_order'], true);
                        }
                    }
                    $redirect = __PS_BASE_URI__ . 'module/cod/error';
                    header('Location: ' . $redirect);
                    exit;
                    //Here you need to put in the routines for a failed
                    //transaction such as sending an email to customer
                    //setting database status etc etc
                } else {

                    foreach ($listOfOrders as $rowOrder) {
                        $new_history = new OrderHistory();

                        if ($rowOrder['id_order']) {
                            $new_history->id_order = (int)$rowOrder['id_order'];
                            $new_history->changeIdOrderState(Configuration::get('PS_OS_ERROR'), $rowOrder['id_order'], true);
                        }
                    }
                    $redirect = __PS_BASE_URI__ . 'module/cod/error';
                    header('Location: ' . $redirect);
                    exit;
                }

        }
    }


//    public function postProcess()
//    {
////        $WorkingKey = _WORKING_KEY; //put in the 32 bit working key in the quotes provided here
////        $card_number = '';
////        $card_expiration = '';
////        $card_holder = '';
////        $MerchantId = isset($_REQUEST["Merchant_Id"]) ? $_REQUEST["Merchant_Id"] : '';
////        $OrderId = isset($_REQUEST["Order_Id"]) ? $_REQUEST["Order_Id"] : '';
////        $Amount = isset($_REQUEST["Amount"]) ? $_REQUEST["Amount"] : '';
////        $AuthDesc = isset($_REQUEST["AuthDesc"]) ? $_REQUEST["AuthDesc"] : '';
////        $avnChecksum = isset($_REQUEST["Checksum"]) ? $_REQUEST["Checksum"] : '';
////        $nb_order_no = isset($_REQUEST["nb_order_no"]) ? $_REQUEST['nb_order_no'] : '';
////        $Checksum = verifyChecksum($MerchantId, $OrderId, $Amount, $AuthDesc, $WorkingKey, $avnChecksum);
////        $billing_cust_name = isset($_REQUEST["billing_cust_name"]) ? $_REQUEST["billing_cust_name"] : '';
////        $billing_cust_address = isset($_REQUEST["billing_cust_address"]) ? $_REQUEST["billing_cust_address"] : '';
////        $billing_cust_state = isset($_REQUEST["billing_cust_state"]) ? $_REQUEST["billing_cust_state"] : '';
////        $billing_cust_city = isset($_REQUEST["billing_cust_city"]) ? $_REQUEST["billing_cust_city"] : '';
////        $billing_zip_code = isset($_REQUEST["billing_zip_code"]) ? $_REQUEST["billing_zip_code"] : '';
////        $billing_cust_country = isset($_REQUEST["billing_cust_country"]) ? $_REQUEST["billing_cust_country"] : '';
////        $billing_cust_tel = isset($_REQUEST["billing_cust_tel"]) ? $_REQUEST['billing_cust_tel'] : '';
////        $billing_cust_email = isset($_REQUEST["billing_cust_email"]) ? $_REQUEST["billing_cust_email"] : '';
////        $Merchant_Param = isset($_REQUEST["Merchant_Param"]) ? $_REQUEST["Merchant_Param"] : '';
////
////        $card_category = isset($_REQUEST["card_category"]) ? $_REQUEST["card_category"] : '';
//
//
//        // Getting payment row already exist from order reference number
//        try {
//            //getting list of orders for which advance payment has received
//            //logging payment received
////            Logger::AddLog('Advance COD Payment received for order reference' . $OrderId . ' and transaction number is=' . $nb_order_no . 'and amount is ' . $Amount);
//            $listOfOrders = $this->getOrdersFromReference("WSYJAGDFV");
//            $orderWiseAdvancePaymentMapping = array();
//            if (!empty($listOfOrders)) {
//                $sql = 'SELECT * from ' . _DB_PREFIX_ . 'order_payment WHERE order_reference=\'' . $OrderId . '\'';
//                $existing_id_currency = 1;
//                $existing_conversion_rate = 1.0000000;
//                if ($row = Db::getInstance()->getRow($sql)) {
//                    $existing_id_currency = $row['id_currency'];
//                    $existing_conversion_rate = $row['conversion_rate'];
//                }
//                $orderwiseAdvanceCODPayment = $this->getAdvanceCODAmount($listOfOrders);
//                foreach ($listOfOrders as $key => $singleOrder) {
//                    $advancePayment = $orderwiseAdvanceCODPayment[$singleOrder['id_order']];
//                    Db::getInstance()->insert('order_payment', array(
//                        'id_currency' => (int)$existing_id_currency,
//                        'amount' => $advancePayment,
//                        'payment_method' => pSQL('ccavenue'),
//                        'conversion_rate' => $existing_conversion_rate,
//                        'transaction_id' => $nb_order_no,
//                        'card_number' => $card_number,
//                        'card_brand' => $card_category,
//                        'card_expiration' => $card_expiration,
//                        'card_holder' => $card_holder,
//                        'date_add' => date('Y-m-d H:i:s'),
//                        'order_reference' => $OrderId
//                    ));
//                    $last_insert_payment_id = Db::getInstance()->insert_id();
//                    Db::getInstance()->insert('order_invoice_payment', array(
//                        'id_order_invoice' => (int)$singleOrder['invoice_number'],
//                        'id_order_payment' => (int)($last_insert_payment_id),
//                        'id_order' => (int)($singleOrder['id_order']),
//                    ));
//                    $orderWiseAdvancePaymentMapping[] = array('amount' => $advancePayment, 'orderId' => $singleOrder['id_order'], 'reference' => $singleOrder['reference'] . '#' . ($key + 1), 'id_address_delivery' => $singleOrder['id_address_delivery']);
//                }
//
//                $billingAddress = array('firstname' => $billing_cust_name, 'lastname' => '', 'state' => $billing_cust_state, 'phone' => $billing_cust_tel, 'postcode' => $billing_zip_code, 'city' => $billing_cust_city, 'address1' => $billing_cust_address, 'address2' => '', 'country' => $billing_cust_country);
//                foreach ($orderWiseAdvancePaymentMapping as $orderEntry) {
//                    $delivery = new Address($orderEntry['id_address_delivery']);
////                    if (!empty($delivery) && !empty($delivery->phone_mobile)) {
////                        $this->sendMessage($orderEntry['reference'], $orderEntry['amount'], $delivery->phone_mobile);
////                    }
//                    $this->sendEmailToCustomer($billingAddress, $orderEntry['reference'], $orderEntry['orderId'], $orderEntry['amount']);
//                }
//                $redirect = __PS_BASE_URI__ . 'module/cod/success';
//                header('Location: ' . $redirect);
//                exit;
//            }
//        } catch
//        (Exception $e) {
//            throw new PrestaShopExceptionCore();
//        }
//
//
//    }

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
//
//        $Checksum = verifyChecksum($MerchantId, $OrderId, $Amount, $AuthDesc, $WorkingKey, $avnChecksum);
//        $billing_cust_name = isset($_REQUEST["billing_cust_name"]) ? $_REQUEST["billing_cust_name"] : '';
//        $billing_cust_address = isset($_REQUEST["billing_cust_address"]) ? $_REQUEST["billing_cust_address"] : '';
//        $billing_cust_state = isset($_REQUEST["billing_cust_state"]) ? $_REQUEST["billing_cust_state"] : '';
//        $billing_cust_city = isset($_REQUEST["billing_cust_city"]) ? $_REQUEST["billing_cust_city"] : '';
//        $billing_zip_code = isset($_REQUEST["billing_zip_code"]) ? $_REQUEST["billing_zip_code"] : '';
//        $billing_cust_country = isset($_REQUEST["billing_cust_country"]) ? $_REQUEST["billing_cust_country"] : '';
//        $billing_cust_tel = isset($_REQUEST["billing_cust_tel"]) ? $_REQUEST['billing_cust_tel'] : '';
//        $billing_cust_email = isset($_REQUEST["billing_cust_email"]) ? $_REQUEST["billing_cust_email"] : '';
//        $Merchant_Param = isset($_REQUEST["Merchant_Param"]) ? $_REQUEST["Merchant_Param"] : '';
//
//        $card_category = isset($_REQUEST["card_category"]) ? $_REQUEST["card_category"] : '';
//        $listOfOrders = $this->getOrdersFromReference($OrderId);
//        foreach ($listOfOrders as $rowOrder) {
//            $new_history = new OrderHistory();
//
//            if ($rowOrder['id_order']) {
//                $new_history->id_order = (int)$rowOrder['id_order'];
//                $new_history->changeIdOrderState(Configuration::get('PS_OS_ERROR'), $rowOrder['id_order'], true);
//            }
//        }
//        $this->setTemplate('error.tpl');
//    }

    function sendMessage($orderReference, $amount, $mobile)
    {
        try {
            $message = sprintf(_CCAVENUE_COD_SUCCESS, $orderReference, $amount);

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

    private
    function sendEmailToCustomer($billingAddress, $orderReference, $orderId, $amount)
    {
        $order = new Order($orderId);
        $products_list = '';
        $cartList = '';
        $virtual_product = true;
        $products = $order->getProducts();
        $cartRules = $order->getCartRules();
        foreach ($products as $key => $product) {
            $productName = ProductCore::getProductName($product['product_id']);
            $unit_price = $product['product_price_wt'];

            $customization_text = '';
            if (isset($customized_datas[$product['product_id']][$product['product_attribute_id']])) {

                foreach ($customized_datas[$product['product_id']][$product['product_attribute_id']] as $customization) {
                    if (isset($customization['datas'][_CUSTOMIZE_TEXTFIELD_]))
                        foreach ($customization['datas'][_CUSTOMIZE_TEXTFIELD_] as $text)
                            $customization_text .= $text['name'] . ': ' . $text['value'] . '<br />';

                    if (isset($customization['datas'][_CUSTOMIZE_FILE_]))
                        $customization_text .= count($customization['datas'][_CUSTOMIZE_FILE_]) . ' ' . $this->l('image(s)') . '<br />';

                    $customization_text .= '---<br />';
                }

                $customization_text = rtrim($customization_text, '---<br />');
            }

            $products_list .=
                '<tr style="background-color:' . ($key % 2 ? '#DDE2E6' : '#EBECEE') . ';">
					<td style="padding:0.6em 0.4em;">' . $product['product_reference'] . '</td>
					<td style="padding:0.6em 0.4em;">
						<strong>'
                    . $productName .
                    '</strong>
                </td>
                <td style="padding:0.6em 0.4em; text-align:right;">' . Tools::displayPrice($unit_price, $this->context->currency, false) . '</td>
					<td style="padding:0.6em 0.4em; text-align:center;">' . (int)$product['product_quantity'] . '</td>
					<td style="padding:0.6em 0.4em; text-align:right;">' . Tools::displayPrice(($unit_price * $product['product_quantity']), $this->context->currency, false) . '</td>
				</tr>';
        }

        foreach ($cartRules as $discount) {
            $cartList .=
                '<tr style="background-color:#EBECEE;">
                        <td colspan="4" style="padding:0.6em 0.4em; text-align:right;">' . $this->l('Voucher code:') . ' ' . $discount['name'] . '</td>
					<td style="padding:0.6em 0.4em; text-align:right;">-' . Tools::displayPrice($discount['value'], $this->context->currency, false) . '</td>
			</tr>';
        }

        $delivery = new Address($order->id_address_delivery);
        $delivery_state = $delivery->id_state ? new State($delivery->id_state) : false;
        $amountToPaid = $order->total_paid - $amount;
        $adminSubject = "New Order";
        $adminEmailTemplate = "order_conf_admin";
        $customerEmailTemplate = "order_conf";
        if ($amountToPaid == 0) {
            $paymentMode = "CCAVENUE";
            $adminEmailTemplate = "order_conf_admin";
            $customerEmailTemplate = "order_conf";
        } else {
            $paymentMode = "COD";
            $adminSubject = "New COD Order";
            $adminEmailTemplate = "cod_order_conf_admin";
            $customerEmailTemplate = "cod_order_conf";

        }

        $data = array(
            '{firstname}' => $this->context->customer->firstname,
            '{lastname}' => $this->context->customer->lastname,
            '{email}' => $this->context->customer->email,
            '{delivery_block_txt}' => $this->getFormattedDeliveryAddress($delivery, false),
            '{invoice_block_txt}' => $this->getFormattedBillingAddress($billingAddress, false),
            '{delivery_block_html}' => $this->getFormattedDeliveryAddress($delivery, true),
            '{invoice_block_html}' => $this->getFormattedBillingAddress($billingAddress, true),
            '{delivery_company}' => $delivery->company,
            '{delivery_firstname}' => $delivery->firstname,
            '{delivery_lastname}' => $delivery->lastname,
            '{delivery_address1}' => $delivery->address1,
            '{delivery_address2}' => $delivery->address2,
            '{delivery_city}' => $delivery->city,
            '{delivery_postal_code}' => $delivery->postcode,
            '{delivery_country}' => $delivery->country,
            '{delivery_state}' => $delivery->id_state ? $delivery_state->name : '',
            '{delivery_phone}' => ($delivery->phone) ? $delivery->phone : $delivery->phone_mobile,
            '{delivery_other}' => $delivery->other,
            '{invoice_company}' => '',
            '{invoice_vat_number}' => '',
            '{invoice_firstname}' => $billingAddress['firstname'],
            '{invoice_lastname}' => $billingAddress['lastname'],
            '{invoice_address2}' => $billingAddress['address2'],
            '{invoice_address1}' => $billingAddress['address1'],
            '{invoice_city}' => $billingAddress['city'],
            '{invoice_postal_code}' => $billingAddress['postcode'],
            '{invoice_country}' => $billingAddress['country'],
            '{invoice_state}' => $billingAddress['state'],
            '{invoice_phone}' => $billingAddress['phone'],
            '{invoice_other}' => '',
            '{order_name}' => $orderReference,
            '{date}' => Tools::displayDate(date('Y-m-d H:i:s'), (int)$order->id_lang, 1),
            '{carrier}' => Tools::displayError('No carrier'),
            '{payment}' => $paymentMode,
            '{products}' => $products_list,
            '{discounts}' => $cartList,
            '{ccavenuePayment}' => $amount,
            '{total_paid}' => Tools::displayPrice($order->total_paid - $amount, $this->context->currency, false),
            '{total_products}' => Tools::displayPrice($order->total_paid - $order->total_shipping - $order->total_wrapping + $order->total_discounts, $this->context->currency, false),
            '{total_discounts}' => Tools::displayPrice($order->total_discounts, $this->context->currency, false),
            '{total_shipping}' => Tools::displayPrice($order->total_shipping, $this->context->currency, false),
            '{total_wrapping}' => Tools::displayPrice($order->total_wrapping, $this->context->currency, false));


        /*
           * dated 5-9-2015 check if user has used ship 2 myid option
           */
        $ship2cartQuery='Select receiver_email,receiver_firstname from ps_shiptomyid_cart where id_cart='.$order->id_cart.' order by id_shipto_cart desc limit 1;';
        $ship2ReceiverDetail=Db::getInstance()->getRow($ship2cartQuery);

        $data['{ship2myidtext}']='';
        if(!empty($ship2ReceiverDetail))
        {

            $data['{ship2myidtext}']="<tr>
                        <td align='left'><strong style='color: {color};'>You have used ship2myid option. Your gift to recipient will be shipped upon confirmation of the address by the recipient.</strong>
                        </td>
                        </tr><tr>
        <td>&nbsp;</td>
    </tr>";

            if(!empty($ship2ReceiverDetail['receiver_email']))
            {
                $data['{ship2myidtext}']="<tr>
                            <td align='left'><strong style='color: {color};'>You have used ship2myid option. Your gift to {$ship2ReceiverDetail['receiver_email']} will be shipped upon confirmation of the address by the recipient.</strong>
                            </td>
                                </tr><tr>
        <td>&nbsp;</td>
    </tr>";
            }
            else if(!empty($ship2ReceiverDetail['receiver_firstname']))
            {
                $data['{ship2myidtext}']="<tr>
                            <td align='left'><strong style='color: {color};'>You have used ship2myid option. Your gift to {$ship2ReceiverDetail['receiver_firstname']} will be shipped upon confirmation of the address by the recipient.</strong>
                            </td>
                                </tr><tr>
        <td>&nbsp;</td>
    </tr>";
            }

        }

        // Join PDF invoice
        if ((int)Configuration::get('PS_INVOICE') && $order->invoice_number) {
            $pdf = new PDF($order->getInvoicesCollection(), PDF::TEMPLATE_INVOICE, $this->context->smarty);
            $file_attachement['content'] = $pdf->render(false);
            $file_attachement['name'] = Configuration::get('PS_INVOICE_PREFIX', (int)$order->id_lang, null, $order->id_shop) . sprintf('%06d', $order->invoice_number) . '.pdf';
            $file_attachement['mime'] = 'application/pdf';
        } else
            $file_attachement = null;

        if (Validate::isEmail($this->context->customer->email)) {
            Mail::Send(
                (int)$order->id_lang,
                $customerEmailTemplate,
                Mail::l('Order confirmation', (int)$order->id_lang),
                $data,
                $this->context->customer->email,
                $this->context->customer->firstname . ' ' . $this->context->customer->lastname,
                null,
                null,
                $file_attachement,
                null, getcwd() . _MODULE_DIR_ . 'cod/', false, (int)$order->id_shop
            );

        }

//        if (_PS_ENVIRONMENTS) {
//            sending mail to admin
            $logisticEmail = _CCAVENUE_COD_ADMIN_EMAIL;
            $receivableEmail = _CCAVENUE_COD_RECEIVABLE_EMAIL;
            Mail::Send(
                (int)$order->id_lang,
                $adminEmailTemplate,
                Mail::l($adminSubject, (int)$order->id_lang),
                $data,
                $logisticEmail,
                'Administrator',
                null,
                null,
                $file_attachement,
                null, getcwd() . _MODULE_DIR_ . 'cod/', false, (int)$order->id_shop
            );

            Mail::Send(
                (int)$order->id_lang,
                $adminEmailTemplate,
                Mail::l($adminSubject, (int)$order->id_lang),
                $data,
                $receivableEmail,
                'Administrator',
                null,
                null,
                $file_attachement,
                null, getcwd() . _MODULE_DIR_ . 'cod/', false, (int)$order->id_shop
            );


//        } else {
//            Mail::Send(
//                (int)$order->id_lang,
//                $adminEmailTemplate,
//                Mail::l($adminSubject, (int)$order->id_lang),
//                $data,
//                Configuration::get('PS_SHOP_EMAIL'),
//                'Administrator',
//                null,
//                null,
//                $file_attachement,
//                null, getcwd() . _MODULE_DIR_ . 'cod/', false, (int)$order->id_shop
//            );
//
//
//        }

        // updates stock in shops
        if (Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT')) {
            $product_list = $order->getProducts();
            foreach ($product_list as $product) {
                // if the available quantities depends on the physical stock
                if (StockAvailable::dependsOnStock($product['product_id'])) {
                    // synchronizes
                    StockAvailable::synchronize($product['product_id'], $order->id_shop);
                }


            }
        }

    }

    private
    function getFormattedDeliveryAddress($address, $html = true)
    {
        if ($html) {
            return '<strong>' . $address->firstname . '' . $address->lastname . '</strong><br/>' . $address->address1 .
                '<br>' . $address->address2 . '<br>' . $address->city . ',' . $address->state . '<br>' . $address->country . '<br>' . $address->postcode;

        }

        return $address->firstname . ' ' . $address->lastname . '\r\n' . $address->address1 .
            '\r\n' . $address->address2 . '\r\n' . $address->city . ',' . $address->state . '\r\n' . $address->country . '\r\n' . $address->postcode;
    }

    private
    function getFormattedBillingAddress($address, $html = true)
    {

        if ($html) {
            return '<strong>' . $address['firstname'] . '' . $address['lastname'] . '</strong><br/>' . $address['address1'] .
                '<br>' . $address['address2'] . '<br>' . $address['city'] . ',' . $address['state'] . '<br>' . $address['country'] . '<br>' . $address['postcode'];

        }

        return $address['firstname'] . ' ' . $address['lastname'] . '\r\n' . $address['address1'] .
            '\r\n' . $address['address2'] . '\r\n' . $address['city'] . ',' . $address['state'] . '\r\n' . $address['country'] . '\r\n' . $address['postcode'];
    }

    private
    function getOrdersFromReference($referenceNumber)
    {
        $sql = 'Select * from ' . _DB_PREFIX_ . 'orders where reference=\'' . $referenceNumber . '\' order by id_order';
        if ($results = Db::getInstance()->ExecuteS($sql)) {
            return $results;
        }
        return array();
    }

    private
    function getAdvanceCODAmount($ordersList)
    {
        $orderWiseTotalAmount = array();
        foreach ($ordersList as $row) {
            $orderIds[] = $row['id_order'];
            $orderWiseTotalAmount[$row['id_order']] = $row['total_paid'];
        }
        $orderDetailKeyValuePair = array();
        if (!empty($orderIds)) {
            $ordersDetailsSQl = 'Select * from ' . _DB_PREFIX_ . 'order_detail where id_order in (' . implode(',', $orderIds) . ')';
            if ($ordersDetails = Db::getInstance()->ExecuteS($ordersDetailsSQl)) {
                foreach ($ordersDetails as $row) {
                    $orderDetailKeyValuePair[$row['id_order']][] = $row;
                }
            }

            $orderandadvanceAmountKeyValue = array();
            foreach ($orderDetailKeyValuePair as $orderid => $entry) {
                $countCODDisableStatus = 0;
                $productWiseArray = array();
                $orderAmount = $orderWiseTotalAmount[$orderid];
                $advancePayment = 0;
                foreach ($entry as $product) {
                    if ($product['unit_price_tax_incl'] >= 2000 && $product['unit_price_tax_incl'] <= 20000) {
                        $codStatus = true;
                    } else {
                        $countCODDisableStatus++;
                        $codStatus = false;
                    }
                    $productWiseArray['product'][] = array('codStatus' => $codStatus, 'price' => $product['unit_price_tax_incl'], 'quantity' => $product['product_quantity']);
                }
                if ($countCODDisableStatus == count($productWiseArray['product'])) {
                    $advancePayment += $orderAmount;
                } else {
                    foreach ($productWiseArray['product'] as $row) {
                        if ($row['price'] >= 2000 && $row['price'] <= 20000) {
                            $advancePayment += (750 * $row['quantity']);
                        } else {
                            $advancePayment += ($row['price'] * $row['quantity']);
                        }

                    }
                }
                if ($orderAmount >= 20000)
                    $advancePayment = ($orderAmount - 20000);
                $orderandadvanceAmountKeyValue[$orderid] = $advancePayment;

            }
            return $orderandadvanceAmountKeyValue;
        }

    }

}