<?php
/*
* 2007-2013 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2013 PrestaShop SA
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

/**
 * @since 1.5
 */
class HTMLTemplateInvoiceCore extends HTMLTemplate
{
    public $order;
    public $available_in_your_account = false;
    public $marginTop = 40;
    const _CLEANING_REGEX_ = '#([^\w:_]+)#i';
    public $currentPage;
    public $totalPage;

    public function __construct(OrderInvoice $order_invoice, $smarty)
    {
        $this->order_invoice = $order_invoice;
        $this->order = new Order((int)$this->order_invoice->id_order);
        $this->smarty = $smarty;

        // header informations
        $this->date = Tools::displayDate($order_invoice->date_add, (int)$this->order->id_lang);
        $this->date = date("d-m-Y", strtotime($this->date));
        $id_lang = Context::getContext()->language->id;
        $this->title = Configuration::get('PS_INVOICE_PREFIX', $id_lang, null, (int)$this->order->id_shop) . sprintf('%06d', $order_invoice->number);
        // footer informations
        $this->shop = new Shop((int)$this->order->id_shop);

    }

    /**
     * Returns the template's HTML content
     * @return string HTML content
     */
    public function getContent()
    {
        $country = new Country((int)$this->order->id_address_invoice);
        $invoice_address = new Address((int)$this->order->id_address_invoice);
        $formatted_invoice_address = $this->generateAddress($invoice_address, array(), '<br />', ' ');
        $formatted_delivery_address = '';

        if ($this->order->id_address_delivery != $this->order->id_address_invoice) {
            $delivery_address = new Address((int)$this->order->id_address_delivery);
            $formatted_delivery_address = $this->generateAddress($delivery_address, array(), '<br />', ' ');
        }

        $customer = new Customer((int)$this->order->id_customer);
        $assignData = array(
            'title' => $this->title,
            'date' => $this->date,
            'order' => $this->order,
            'order_details' => $this->order_invoice->getProducts(),
            'cart_rules' => $this->order->getCartRules($this->order_invoice->id),
            'delivery_address' => $formatted_delivery_address,
            'invoice_address' => $formatted_invoice_address,
            'tax_excluded_display' => Group::getPriceDisplayMethod($customer->id_default_group),
            'tax_tab' => $this->getTaxTabContent(),
            'customer' => $customer
        );


        $this->smarty->assign($assignData);

        return $this->smarty->fetch($this->getTemplateByCountry($country->iso_code));
//		$output=$this->smarty->fetch($this->getTemplateByCountry($country->iso_code));
//        echo $output;
//        exit;
    }

    /**
     * Returns the tax tab content
     */
    public function getTaxTabContent()
    {
        $address = new Address((int)$this->order->{Configuration::get('PS_TAX_ADDRESS_TYPE')});
        $tax_exempt = Configuration::get('VATNUMBER_MANAGEMENT')
            && !empty($address->vat_number)
            && $address->id_country != Configuration::get('VATNUMBER_COUNTRY');
        $taxData = array(
            'tax_exempt' => $tax_exempt,
            'use_one_after_another_method' => $this->order_invoice->useOneAfterAnotherTaxComputationMethod(),
            'product_tax_breakdown' => $this->order_invoice->getProductTaxesBreakdown(),
            'shipping_tax_breakdown' => $this->order_invoice->getShippingTaxesBreakdown($this->order),
            'ecotax_tax_breakdown' => $this->order_invoice->getEcoTaxTaxesBreakdown(),
            'wrapping_tax_breakdown' => $this->order_invoice->getWrappingTaxesBreakdown(),
            'order' => $this->order,
            'order_invoice' => $this->order_invoice
        );
        $this->smarty->assign($taxData);

        return $this->smarty->fetch($this->getTemplate('invoice.tax-tab'));
    }

    /**
     * Returns the invoice template associated to the country iso_code
     * @param string $iso_country
     */
    protected function getTemplateByCountry($iso_country)
    {
        $file = Configuration::get('PS_INVOICE_MODEL');

        // try to fetch the iso template
        $template = $this->getTemplate($file . '.' . $iso_country);

        // else use the default one
        if (!$template)
            $template = $this->getTemplate($file);

        return $template;
    }

    /**
     * Returns the template filename when using bulk rendering
     * @return string filename
     */
    public function getBulkFilename()
    {
        return 'invoices.pdf';
    }

    /**
     * Returns the template filename
     * @return string filename
     */
    public function getFilename()
    {
        return Configuration::get('PS_INVOICE_PREFIX') . sprintf('%06d', $this->order_invoice->number) . '.pdf';
    }

    /**
     * Returns the template's HTML header
     * @return string HTML header
     */
    public function getHeader()
    {
        $shop_name = Configuration::get('PS_SHOP_NAME', null, null, (int)$this->order->id_shop);
        $path_logo = $this->getLogo();

        $width = 0;
        $height = 0;
        if (!empty($path_logo))
            list($width, $height) = getimagesize($path_logo);

        $this->smarty->assign(array(
            'logo_path' => $path_logo,
            'img_ps_dir' => 'http://' . Tools::getMediaServer(_PS_IMG_) . _PS_IMG_,
            'img_update_time' => Configuration::get('PS_IMG_UPDATE_TIME'),
            'title' => $this->title,
            'date' => $this->date,
            'shop_name' => $shop_name,
            'width_logo' => $width,
            'height_logo' => $height
        ));

        return $this->smarty->fetch($this->getTemplate('invoice-header'));
    }

    /**
     * Returns the template's HTML footer
     * @return string HTML footer
     */
//    public function getFooter()
//    {
//        $shop_address = $this->getShopAddress();
//        $this->smarty->assign(array(
//            'available_in_your_account' => $this->available_in_your_account,
//            'shop_address' => $shop_address,
//            'shop_fax' => Configuration::get('PS_SHOP_FAX', null, null, (int)$this->order->id_shop),
//            'shop_phone' => Configuration::get('PS_SHOP_PHONE', null, null, (int)$this->order->id_shop),
//            'shop_details' => Configuration::get('PS_SHOP_DETAILS', null, null, (int)$this->order->id_shop),
//            'free_text' => Configuration::get('PS_INVOICE_FREE_TEXT', (int)Context::getContext()->language->id, null, (int)$this->order->id_shop)
//        ));
//
//        return $this->smarty->fetch($this->getTemplate('footer'));
//    }
    public function getFooter()
    {
        $shop_address = $this->getShopAddress();
        $this->smarty->assign(array(
            'available_in_your_account' => $this->available_in_your_account,
            'shop_address' => $shop_address,
            'shop_fax' => Configuration::get('PS_SHOP_FAX', null, null, (int)$this->order->id_shop),
            'shop_phone' => Configuration::get('PS_SHOP_PHONE', null, null, (int)$this->order->id_shop),
            'shop_details' => Configuration::get('PS_SHOP_DETAILS', null, null, (int)$this->order->id_shop),
            'free_text' => 'This is a computer generated invoice',
            'currentPage' => $this->currentPage,
            'totalPage' => $this->totalPage
        ));

        return $this->smarty->fetch($this->getTemplate('invoice-footer'));
    }

    private function generateAddress(Address $address, $patternRules = array(), $newLine = "\r\n", $separator = ' ', $style = array())
    {
        $addressFields = AddressFormat::getOrderedAddressFields($address->id_country);
        $addressFormatedValues = AddressFormat::getFormattedAddressFieldsValues($address, $addressFields);

        $addressText = '';
        foreach ($addressFields as $line)
            if (($patternsList = preg_split(self::_CLEANING_REGEX_, $line, -1, PREG_SPLIT_NO_EMPTY))) {
                $tmpText = '';
                foreach ($patternsList as $pattern)
                    if ((!array_key_exists('avoid', $patternRules)) ||
                        (array_key_exists('avoid', $patternRules) && !in_array($pattern, $patternRules['avoid']))
                    )
                        $tmpText .= (isset($addressFormatedValues[$pattern]) && !empty($addressFormatedValues[$pattern])) ?
                            (((isset($style[$pattern])) ?
                                (sprintf($style[$pattern], $addressFormatedValues[$pattern])) :
                                $addressFormatedValues[$pattern]) . $separator) : '';
                $tmpText = trim($tmpText);
                $addressText .= (!empty($tmpText)) ? '&nbsp;&nbsp;' . $tmpText . $newLine : '';
            }

        $addressText = rtrim($addressText, $newLine);
        $addressText = rtrim($addressText, $separator);

        return $addressText;
    }
}

