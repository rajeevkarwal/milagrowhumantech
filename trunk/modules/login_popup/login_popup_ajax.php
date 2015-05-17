<?php
/**
 * Created by PhpStorm.
 * User: hitanshu
 * Date: 25/11/13
 * Time: 10:33 PM
 */

require_once(dirname(__FILE__) . '/../../config/config.inc.php');
require_once(dirname(__FILE__) . '/../../init.php');
$context = Context::getContext();
$action = Tools::getValue('action');
if ($action == 'showLoginPopup') {
    $html = $context->smarty->fetch(dirname(__FILE__) . '/login_pop_up_form.tpl');
    echo json_encode(array('html' => $html));
    exit;
} elseif ($action == 'submitLogin') {
    $hasError = false;
    $passwd = trim(Tools::getValue('passwd'));
    $email = trim(Tools::getValue('email'));
    //$email = trim($_POST['email']);
    $errors = array();
    if (empty($email))
        $errors[] = 'empty_email';
    if (!Validate::isEmail($email))
        $errors[] = 'invalid_email';
    if (empty($passwd))
        $errors[] = 'empty_passwd';
    if (Tools::strlen($passwd) > 32)
        $errors[] = 'empty_passwd';
    if (!Validate::isPasswd($passwd))
        $errors[] = 'invalid password';
    if (empty($errors)) {
        $customer = new Customer();
        $authentication = $customer->getByemail(trim($email), trim($passwd));
        /* Handle brute force attacks */
        //sleep(1);
        if (!$authentication OR !$customer->id) {
            $hasError = true;
            $errors[] = 'authentication_failed';
            echo json_encode(array('hasError' => $hasError, 'errors' => $errors));
            exit;

        } else {
            $cookie->id_customer = intval($customer->id);
            $cookie->customer_lastname = $customer->lastname;
            $cookie->customer_firstname = $customer->firstname;
            $cookie->logged = 1;
            $cookie->secure_key = $customer->secure;
            $cookie->passwd = $customer->passwd;
            $cookie->email = $customer->email;
            if (Configuration::get('PS_CART_FOLLOWING') AND (empty($cookie->id_cart) OR Cart::getNbProducts($cookie->id_cart) == 0))
                $cookie->id_cart = intval(Cart::lastNoneOrderedCart(intval($customer->id)));
            $id_address = intval(Address::getFirstCustomerAddressId(intval($customer->id)));
            $cookie->id_address_delivery = $id_address;
            $cookie->id_address_invoice = $id_address;
            $hasError = false;
            echo json_encode(array('hasError' => $hasError));
            exit;
        }
    } else {
        $hasError = true;
        echo json_encode(array('hasError' => $hasError, 'errors' => $errors));
        exit;
    }
}
