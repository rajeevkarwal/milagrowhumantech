<?php

/**
 * This file is part of a NewQuest Project
 *
 * (c) NewQuest <contact@newquest.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author    NewQuest
 * @copyright NewQuest
 * @license   NewQuest
 */
class ShiptomyidFrontModuleFrontController extends ModuleFrontController {

    public function init() {
        parent::init();

        $this->display_column_left = false;
    }

    public function setMedia() {
        parent::setMedia();

        // Add CSS files //
        $this->addCSS(_THEME_CSS_DIR_ . 'addresses.css');
        if (class_exists('Tools') && method_exists('Tools', 'version_compare') && Tools::version_compare(_PS_VERSION_, '1.6', '>=') === true)
            $this->addCSS(__PS_BASE_URI__ . 'modules/' . $this->module->name . '/views/css/shiptomyid-16.css', 'all');
        else
            $this->addCSS(__PS_BASE_URI__ . 'modules/' . $this->module->name . '/views/css/shiptomyid.css', 'all');

        // Add JS files //
        $this->addJS(_THEME_JS_DIR_ . 'tools.js');
        if (class_exists('Tools') && method_exists('Tools', 'version_compare') && Tools::version_compare(_PS_VERSION_, '1.6', '>=') === true)
            $this->addJS(__PS_BASE_URI__ . 'modules/' . $this->module->name . '/views/js/shipto-address-16.js');
        else
            $this->addJS(__PS_BASE_URI__ . 'modules/' . $this->module->name . '/views/js/shipto-address.js');
    }

    public function initContent() {
        parent::initContent();

        $customer = $this->context->customer;

        if (!isset($_SESSION)) {
            @session_start();
        }

        if (isset($_SESSION['giftnow']) && !empty($_SESSION['giftnow'])) {
            $this->createShip2MyIdAddress($_SESSION['giftnow']);
        }


        /*
         * Get delivery address and data.
         */
        if ((int) $this->context->cart->id_address_delivery) {
            $shipto_delivery_address = new Address((int) $this->context->cart->id_address_delivery);

            $country_name = Db::getInstance()->getValue('SELECT name FROM ' . _DB_PREFIX_ . 'country_lang
		WHERE id_country = ' . (int) Configuration::get('SHIPTOMYID_DEFAULT_ADDR_COUNTRY') . ' ');

            $state_name = Db::getInstance()->getValue('SELECT name FROM ' . _DB_PREFIX_ . 'state
		WHERE id_state = ' . (int) Configuration::get('SHIPTOMYID_DEFAULT_ADDR_STATE') . ' ');

            $default_delivery_address = array(
	'address1' => Configuration::get('SHIPTOMYID_DEFAULT_ADDR_ADDRESS'),
	'address2' => Configuration::get('SHIPTOMYID_DEFAULT_ADDR_ADDRESS2'),
	'city' => Configuration::get('SHIPTOMYID_DEFAULT_ADDR_CITY'),
	'zip' => Configuration::get('SHIPTOMYID_DEFAULT_ADDR_POSTCODE'),
	'phone' => Configuration::get('SHIPTOMYID_DEFAULT_ADDR_PHONE'),
	'alise' => Configuration::get('SHIPTOMYID_DEFAULT_ADDR_ALIAS'),
	'country' => $country_name,
	'state' => $state_name
            );

            $this->context->smarty->assign(array(
	'shipto_delivery_address' => $shipto_delivery_address,
	'shipto_default_delivery_address' => $default_delivery_address
            ));
        }

        /*
         * Get addresses.
         */
        $customer_addresses = $customer->getAddresses($this->context->language->id, false);

        // On supprime de la liste les addresse shipto
        foreach ($customer_addresses as $key => $address)
            if (strpos(Tools::strtolower($address['alias']), 'ship2myid') !== false)
	$customer_addresses[$key]['shipto_addr'] = 1;

        // Getting a list of formated address fields with associated values
        $formated_address_fields_values_list = array();

        foreach ($customer_addresses as $i => $address) {
            if (!Address::isCountryActiveById((int) $address['id_address']))
	unset($customer_addresses[$i]);
            $tmp_address = new Address($address['id_address']);
            $formated_address_fields_values_list[$address['id_address']]['ordered_fields'] = AddressFormat::getOrderedAddressFields($address['id_country']);
            $formated_address_fields_values_list[$address['id_address']]['formated_fields_values'] = AddressFormat::getFormattedAddressFieldsValues(
	            $tmp_address, $formated_address_fields_values_list[$address['id_address']]['ordered_fields']);

            unset($tmp_address);
        }
        if (key($customer_addresses) != 0)
            $customer_addresses = array_values($customer_addresses);
        $this->context->smarty->assign(array(
            'addresses' => $customer_addresses,
            'formatedAddressFieldsValuesList' => $formated_address_fields_values_list
        ));

        if (class_exists('Tools') && method_exists('Tools', 'version_compare') && Tools::version_compare(_PS_VERSION_, '1.6', '>=') === true)
            $this->setTemplate('front-16.tpl');
        else
            $this->setTemplate('front.tpl');
    }

    public function createShip2MyIdAddress($data = array()) {

        if (!empty($data)) {
            $module = Module::getInstanceByName('shiptomyid');
            $context = $this->context;
            $current_cart = new Cart((int) $this->context->cart->id);
            $receiver_type = $data['receiver_type'];
            $receiver_linkedin_id = $data['receiver_linkedin_id'];
            $receiver_facebook_id = $data['receiver_facebook_id'];
            $postcode = $data['postcode'];
            $telephone = Toolbox::cleanPhone($data['telephone']);
            $rec_name = Toolbox::cleanName($data['firstname']);
            $rec_name = explode(' ', $rec_name, 2);
            if (is_array($rec_name) && !empty($rec_name)) {
	$firstname = $rec_name[0];
	$lastname = isset($rec_name[1]) && !empty($rec_name[1]) ? $rec_name[1] : "--"; //$rec_name[0];
            } else {
	$firstname = Toolbox::cleanName($data['firstname']);
	$lastname = Toolbox::cleanName($data['lastname']);
            }
            $email = $data['email'];
            $country_iso = $data['country_id'];
            $telephone_no = Toolbox::cleanPhone($data['telephone_no']);
            $region = $data['region'];
            $city = $data['city'];

            if (!Validate::isEmail($email))
	die('<script language="javascript" type="text/javascript">top.location.href = "' . $context->link->getPageLink('order') . '?step=1" ;</script>');

            /*
             * Check if address already registered on ship2myid.
             */
            /*
             * $sender_email = Db::getInstance()->getValue('SELECT email FROM '._DB_PREFIX_.'customer WHERE id_customer = '.(int)$current_cart->id_customer);
             */
            if ($receiver_type == 'email') {
	$info = array(
	    'receiver_type' => $receiver_type,
	    'receiver_email_address' => $email,
	);
            } elseif ($receiver_type == 'facebook') {
	$info = array(
	    'receiver_type' => $receiver_type,
	    'receiver_facebook_id' => $receiver_facebook_id,
	);
            } elseif ($receiver_type == 'linkedin') {
	$info = array(
	    'receiver_type' => $receiver_type,
	    'receiver_linkedin_id' => $receiver_linkedin_id,
	);
            } else {
	$info = array(
	    'receiver_type' => 'email',
	    'receiver_email_address' => $email,
	);
            }
            $results = $module->api->getZipAndState($info);
            if (isset($results['Address'])) {
	$postcode = isset($results['Address']['zipcode']) ? $results['Address']['zipcode'] : $postcode;
	$country_iso = isset($results['Address']['country_code']) ? $results['Address']['country_code'] : $country_iso;
	$region = isset($results['Address']['state_name']) ? $results['Address']['state_name'] : $region;
            }

            /*
             * Find country id
             */
            $id_country = (int) Db::getInstance()->getValue('SELECT id_country FROM ' . _DB_PREFIX_ . 'country
		            WHERE LOWER("' . pSQL($country_iso) . '") = LOWER(iso_code)');

            /*
             * Find state id if needed
             */
            $id_state = 0;
            if (!empty($region) && $id_country)
	$id_state = (int) Db::getInstance()->getValue(
		'SELECT id_state FROM ' . _DB_PREFIX_ . 'state WHERE LOWER(name) = LOWER("' . pSQL($region) . '") AND id_country = ' . (int) $id_country
	);





            $new_address = new Address();
            $new_address->alias = 'SHIP2MYID-' . Tools::passwdGen(6);

            $new_address->lastname = $lastname;
            $new_address->firstname = $firstname;
            $new_address->address1 = 'waiting...';
            $new_address->postcode = $postcode;
            $new_address->city = $city;
            $new_address->phone = $telephone_no;
            $new_address->id_country = $id_country;
            $new_address->id_state = $id_state;
            $new_address->id_customer = (int) $this->context->cart->id_customer;

            $new_address->id_manufacturer = 0;
            $new_address->id_supplier = 0;
            $new_address->id_warehouse = 0;

            if (!$new_address->add())
	die('<script language="javascript" type="text/javascript">top.location.href = "' . $context->link->getPageLink('order') . '?step=1" ;</script>');

            /*
             * Save shipto data in shipto cart object.
             */
            $shipto_cart = ShiptomyidCart::getByIdCart($this->context->cart->id);
            if (!$shipto_cart) {
	$shipto_cart = new ShiptomyidCart();
	$shipto_cart->id_cart = $this->context->cart->id;
            }

            $shipto_cart->receiver_email = $email;
            $shipto_cart->receiver_lastname = $lastname;
            $shipto_cart->receiver_firstname = $firstname;
            $shipto_cart->receiver_city = $city;
            $shipto_cart->receiver_postcode = $postcode;
            $shipto_cart->receiver_id_country = $id_country;
            $shipto_cart->receiver_id_state = $id_state;
            $shipto_cart->receiver_phone = $telephone_no;
            $shipto_cart->receiver_type = $receiver_type;
            $shipto_cart->receiver_linkedin_id = $receiver_linkedin_id;
            $shipto_cart->receiver_facebook_id = $receiver_facebook_id;
            if (!$shipto_cart->save())
	die('<script language="javascript" type="text/javascript">top.location.href = "' . $context->link->getPageLink('order') . '?step=1" ;</script>');


            /*
             * Assign this delivery to current cart.
             */
            $this->context->cart->id_address_delivery = (int) $new_address->id;
            $this->context->cart->update();
            //rint_r($this->context->cart);
        }
    }

}
