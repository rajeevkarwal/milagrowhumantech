<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hitanshu
 * Date: 31/8/13
 * Time: 1:27 PM
 * To change this template use File | Settings | File Templates.
 */

class HTMLTemplateDemoPdf1 extends HTMLTemplate
{
    public $content;

    public function __construct()
    {

        // header informations
        $this->title = 'Rental Receipt';
        $this->date = date('Y-m-d');
        $this->context = Context::getContext();
        $this->smarty = $this->context->smarty;
    }
    /**
     * Returns the template's HTML content
     * @return string HTML content
     */
    public function getContent()
    {
        $this->smarty->assign($this->content);
        $output = $this->smarty->fetch(dirname(__FILE__) . '/views/templates/front/mailer/rental_product_receipt.tpl');
        return $output;
    }
    public function getFooter()
    {
        return '';
    }

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

        return $this->smarty->fetch(dirname(__FILE__) . '/views/templates/front/mailer/HeaderForRental.tpl');
    }

    public function getFilename($demoid=null)
    {
        if(empty($demoid))
        return 'Monthly Rental Receipt.pdf';
        return 'Monthly Rental Receipt Receipt-'.$demoid.'.pdf';
    }

    public function getBulkFilename()
    {
        return 'Home-demo-receipts.pdf';
    }
}