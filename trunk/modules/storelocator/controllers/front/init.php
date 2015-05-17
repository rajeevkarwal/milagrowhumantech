<?php


class StoreLocatorInitModuleFrontController extends ModuleFrontController
{
//
//    public function postProcess()
//    {
//        $this->updateStateCityAlphabets();
//        exit;
//
//    }

    public function initContent()
    {
        parent::initContent();
        $page = Tools::getValue('page');
        $page = !empty($page) ? $page : 1;
        $product = Tools::getValue('product');
        $state = Tools::getValue('state');
        $city = Tools::getValue('city');
        $previousPage = 0;
        $nextPage = 0;
        $pageCount = 10;
        $storeLocators = $this->getStoreLocatorList($product, $state, $city, $page, $pageCount);
        $totalStoresLocators = $this->getTotalStoreLocators($product, $state, $city);
        if (($page * $pageCount) < (int)$totalStoresLocators) {
            $nextPage = $page + 1;
        }
        if ($page > 1)
            $previousPage = $page - 1;

        $products = $this->getProductsAndStatesAndCities();

        $this->context->smarty->assign(array(
            'products' => json_encode($products),
            'selectedProduct' => $product,
            'selectedState' => $state,
            'selectedCity' => $city,
            'storeLocatorResults' => $storeLocators,
            'page' => $page,
            'previous' => $previousPage,
            'next' => $nextPage
        ));

        $this->setTemplate('storelocator.tpl');
    }


    private function getProductsAndStatesAndCities()
    {
        $sql = 'select product,state,city from ' . _DB_PREFIX_ . 'store_locator order by product';
        if ($results = Db::getInstance()->ExecuteS($sql)) {
            $products = array();
            foreach ($results as $row) {
                if (!isset($products[$row['product']])) {
                    if (!in_array($row['city'], $products[$row['product']][$row['state']]))
                        $products[$row['product']][$row['state']][] = $row['city'];
                } else if (!in_array($row['city'], $products[$row['product']][$row['state']])) {
                    $products[$row['product']][$row['state']][] = $row['city'];
                }

            }
            return $products;
        }
    }

    private function getStoreLocatorList($product, $state, $city, $p = 1, $n = null)
    {
        $whereQuery = '';
        if (!empty($product) && empty($city) && empty($state))
            $whereQuery .= "where product='$product'";
        elseif (!empty($product) && !empty($state))
            $whereQuery .= "where product='$product' and state='$state'"; elseif (empty($product))
            $whereQuery .= ""; else
            $whereQuery .= "where product=$product and state='$state' and city='$city'";
        $sql = 'select * from ' . _DB_PREFIX_ . 'store_locator ' . $whereQuery . ($n ? 'LIMIT ' . (int)(($p - 1) * $n) . ', ' . (int)($n) : '');
        if ($results = Db::getInstance()->ExecuteS($sql)) {
            return $results;
        }
        return array();
    }

    private function getTotalStoreLocators($product, $state, $city)
    {
        $whereQuery = '';
        if (!empty($product) && empty($city) && empty($state))
            $whereQuery .= "where product='$product'";
        elseif (!empty($product) && !empty($state))
            $whereQuery .= "where product='$product' and state='$state'"; elseif (empty($product))
            $whereQuery .= ""; else
            $whereQuery .= "where product=$product and state='$state' and city='$city'";
        $sql = 'select count(*) as total from ' . _DB_PREFIX_ . 'store_locator ' . $whereQuery;
        if ($results = Db::getInstance()->getValue($sql)) {
            return $results;
        }
        return 0;
    }

    private function updateStateCityAlphabets()
    {
        $sql = 'select * from ' . _DB_PREFIX_ . 'store_locator';
        if ($results = Db::getInstance()->ExecuteS($sql)) {
            foreach ($results as $row) {
                $state = ucwords(strtolower($row['state']));
                $city = ucwords(strtolower($row['city']));
                if ($row['product'] == 'TABTOP' || $row['product'] == 'Tabtop')
                    $product = ucwords(strtolower('TabTop PCs'));
                elseif ($row['product'] == 'Body Massaging Robot')
                    $product = ucwords(strtolower('Robotic Massagers')); elseif ($row['product'] == 'Floor Cleaning Robot')
                    $product = ucwords(strtolower('Robotic Floor Cleaners')); elseif ($row['product'] == 'Window Cleaning Robot')
                    $product = ucwords(strtolower('Robotic Window Cleaners')); elseif ($row['product'] == 'Tv Mount')
                    $product = ucwords(strtolower('TV Mounts'));
                $address = ucwords(strtolower($row['address']));
                $updateData = array('state' => $state, 'city' => $city, 'product' => $product, 'address' => $address);
                Db::getInstance()->update('store_locator', $updateData, "id_store_locator=" . $row['id_store_locator']);
            }
        }
    }
}
