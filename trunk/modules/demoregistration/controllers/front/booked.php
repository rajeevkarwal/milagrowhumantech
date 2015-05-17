<?php

//define('BOOK_DEMO_BEFORE_PAYMENT_CUSTOMER_CARE', 'customercare@milagrow.in');
//define('BOOK_DEMO_BEFORE_PAYMENT_CS', 'cs@milagrow.in');
//define('BOOK_DEMO_BEFORE_PAYMENT_CUSTOMER_CARE', 'ptailor@greenapplesolutions.com');
//define('BOOK_DEMO_BEFORE_PAYMENT_CS', 'ptailor@greenapplesolutions.com');

class DemoRegistrationBookedModuleFrontController extends ModuleFrontController
{
   // public $display_column_left = true;
//    private $category = 13;
    //private $price = 750;

//    private $productIdsForRoboticFloorCleaner = array(18, 21, 97, 98);
//    private $productIdsForRoboticWindowCleaner = array(40, 22);
////    private $productIdsForRoboticWindowCleaner = array(1, 22);


   
    public function initContent()
    {

        parent::initContent();
             

      
//        echo "<pre>";print_r($categorywiseProduct);echo "</pre>";exit;

       /* $this->context->smarty->assign(array(
            'products' => $productshtml,
            'captchaName' => $captchaVariable,
            'captchaText' => $captchas[$key]['key'],
            'this_path' => $this->module->getPathUri()));*/

        $this->setTemplate('booked.tpl');

    }

//    private function getProducts()
//    {
//        $sql = "SELECT " . _DB_PREFIX_ . "product_lang.id_product as id, " . _DB_PREFIX_ . "product_lang.name as name
//                FROM " . _DB_PREFIX_ . "category_product JOIN " . _DB_PREFIX_ . "product_lang
//                ON " . _DB_PREFIX_ . "product_lang.id_product=" . _DB_PREFIX_ . "category_product.id_product where " . _DB_PREFIX_ . "category_product.id_category=" . $this->category . ";";
//        if ($results = Db::getInstance()->ExecuteS($sql))
//            return $results;
//        return array();
//    }


    //getting products for window cleaner and
//    private function getProducts()
//    {
//        $sql = "SELECT * from " . _DB_PREFIX_ . "product_lang where id_product in ('" . implode('\',\'', array_merge($this->productIdsForRoboticFloorCleaner, $this->productIdsForRoboticWindowCleaner)) . "')";
//        if ($results = Db::getInstance()->ExecuteS($sql))
//            return $results;
//        return array();
//    }

    

//    private function getCategoryNameForGivenProduct($id_product)
//    {
//        if (in_array($id_product, $this->productIdsForRoboticFloorCleaner))
//            return 'Robotic Floor Cleaners';
//        else
//            return 'Window Floor Cleaners';
//    }
    
}
