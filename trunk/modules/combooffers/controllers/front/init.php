<?php
/**
 * Created by PhpStorm.
 * User: hitanshu
 * Date: 10/5/15
 * Time: 5:33 PM
 */

class ComboOffersInitModuleFrontController extends ModuleFrontController {

    public function initContent()
    {

        parent::initContent();
        global $cookie;
        $productsSql = 'Select id_product from ' . _DB_PREFIX_ . 'product where `condition`=\'combo\' and active=1';
        //echo $productsSql;
        $products = Db::getInstance()->executeS($productsSql);
        //print_r($products);
        $finalProducts=array();
        foreach($products as $key=>$productRow)
        {
            //foreach product get product details

            $product=new Product($productRow['id_product'], true, $this->context->language->id, $this->context->shop->id);

//            echo "<pre>";
//            print_r($product);
//            exit;
            $images = $product->getImages((int)$this->context->cookie->id_lang);
   //         $product_images = array();

//            if(isset($images[0]))
//                $this->context->smarty->assign('mainImage', $images[0]);
            foreach ($images as $k => $image)
            {
                if ($image['cover'])
                {
                    $mainImage=$image;
//                    $this->context->smarty->assign('mainImage', $image);
                    $cover = $image;
                    $cover['id_image'] = (Configuration::get('PS_LEGACY_IMAGES') ? ($product->id.'-'.$image['id_image']) : $image['id_image']);
                    $cover['id_image_only'] = (int)$image['id_image'];
                }
 //               $product_images[(int)$image['id_image']] = $image;
            }

            if (!isset($cover))
            {
                if(isset($images[0]))
                {
                    $cover = $images[0];
                    $cover['id_image'] = (Configuration::get('PS_LEGACY_IMAGES') ? ($product->id.'-'.$images[0]['id_image']) : $images[0]['id_image']);
                    $cover['id_image_only'] = (int)$images[0]['id_image'];
                }
                else
                    $cover = array(
                        'id_image' => $this->context->language->iso_code.'-default',
                        'legend' => 'No picture',
                        'title' => 'No picture'
                    );
            }
            $size = Image::getSize(ImageType::getFormatedName('large'));
            //$product->cover=$cover;
            $productPrice=$product->getPrice(true, null, 2);
            $reductionPrice=$product->getPriceWithoutReduct(false, null);
            $finalProducts[]=array('name'=>$product->name,'product_link'=>'/index.php?controller=product&id_product='.$product->id,'link_rewrite'=>$product->link_rewrite,'productPrice'=>$productPrice,
                'reductionPrice'=>$reductionPrice,'cover'=>array('id_image'=>$cover['id_image']));
        }

        //echo "<pre>";
        print_r($finalProducts);
        $this->context->smarty->assign(array('products'=>$finalProducts));
        $this->setTemplate('combooffers.tpl');
    }



    /**
     * Assign price and tax to the template
     */
    protected function assignPriceAndTax()
    {
        $id_customer = (isset($this->context->customer) ? (int)$this->context->customer->id : 0);
        $id_group = (int)Group::getCurrent()->id;
        $id_country = (int)$id_customer ? Customer::getCurrentCountry($id_customer) : Configuration::get('PS_COUNTRY_DEFAULT');

        $group_reduction = GroupReduction::getValueForProduct($this->product->id, $id_group);
        if ($group_reduction == 0)
            $group_reduction = Group::getReduction((int)$this->context->cookie->id_customer) / 100;

        // Tax
        $tax = (float)$this->product->getTaxesRate(new Address((int)$this->context->cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')}));
        $this->context->smarty->assign('tax_rate', $tax);

        $product_price_with_tax = Product::getPriceStatic($this->product->id, true, null, 6);
        if (Product::$_taxCalculationMethod == PS_TAX_INC)
            $product_price_with_tax = Tools::ps_round($product_price_with_tax, 2);
        $product_price_without_eco_tax = (float)$product_price_with_tax - $this->product->ecotax;

        $ecotax_rate = (float)Tax::getProductEcotaxRate($this->context->cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')});
        $ecotax_tax_amount = Tools::ps_round($this->product->ecotax, 2);
        if (Product::$_taxCalculationMethod == PS_TAX_INC && (int)Configuration::get('PS_TAX'))
            $ecotax_tax_amount = Tools::ps_round($ecotax_tax_amount * (1 + $ecotax_rate / 100), 2);

        $id_currency = (int)$this->context->cookie->id_currency;
        $id_product = (int)$this->product->id;
        $id_shop = $this->context->shop->id;

        $quantity_discounts = SpecificPrice::getQuantityDiscounts($id_product, $id_shop, $id_currency, $id_country, $id_group, null, true, (int)$this->context->customer->id);
        foreach ($quantity_discounts as &$quantity_discount)
            if ($quantity_discount['id_product_attribute'])
            {
                $combination = new Combination((int)$quantity_discount['id_product_attribute']);
                $attributes = $combination->getAttributesName((int)$this->context->language->id);
                foreach ($attributes as $attribute)
                    $quantity_discount['attributes'] = $attribute['name'].' - ';
                $quantity_discount['attributes'] = rtrim($quantity_discount['attributes'], ' - ');
            }

        $product_price = $this->product->getPrice(Product::$_taxCalculationMethod == PS_TAX_INC, false);
        $address = new Address($this->context->cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')});
        $this->context->smarty->assign(array(
            'quantity_discounts' => $this->formatQuantityDiscounts($quantity_discounts, $product_price, (float)$tax, $ecotax_tax_amount),
            'ecotax_tax_inc' => $ecotax_tax_amount,
            'ecotax_tax_exc' => Tools::ps_round($this->product->ecotax, 2),
            'ecotaxTax_rate' => $ecotax_rate,
            'productPriceWithoutEcoTax' => (float)$product_price_without_eco_tax,
            'group_reduction' => (1 - $group_reduction),
            'no_tax' => Tax::excludeTaxeOption() || !$this->product->getTaxesRate($address),
            'ecotax' => (!count($this->errors) && $this->product->ecotax > 0 ? Tools::convertPrice((float)$this->product->ecotax) : 0),
            'tax_enabled' => Configuration::get('PS_TAX')
        ));
    }


}