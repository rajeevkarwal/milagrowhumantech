<?php
require_once(dirname(__FILE__) . '/../../Helper.php');
require_once(dirname(__FILE__) . '/../../ComparePdf.php');
//parameter to control max products to compare
define('_MAX_PRODUCT_TO_COMPARE', 4);
define('_CATEGORY_ID_FOR_ACCESSORY', 4);
class FeaturecategoriesCompareModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        if (Tools::getValue('action') == 'display')
            $this->displayComparison();
        else if (Tools::getValue('action') == 'show') {
            $this->returnCompareList();
            exit;
        } else if (Tools::getValue('action') == 'add') {
            $status = $this->addToCompare(Tools::getValue('productId'));
            echo $status;
            exit;
        } else if (Tools::getValue('action') == 'delete') {
            $this->deleteFromCompare(Tools::getValue('productId'));
            die();
        } else if (Tools::getValue('action') == 'deleteall') {
            $this->deleteAll();
            die();
        } else if (Tools::getValue('action') == 'pdf') {
            $this->generatePDF();
            die();
        } else if (Tools::getValue('action') == 'productBlock') {
            $this->getProductPageContent(Tools::getValue('productId'));
            die();
        } else if (Tools::getValue('action') == 'productWiseIcons') {
            $this->getCategoryProductsListContent(Tools::getValue('productIds'));
            die();
        }

    }

    private function addToCompare($productId)
    {
        if ($productId != NULL) {
            if ($this->context->cookie->comparison == NULL || $this->context->cookie->comparison == '') {
                if ($this->checkWhetherProductBelongsToAccessories($productId)) {
                    return 4;
                } else {
                    $this->context->cookie->comparison = $productId;
                    return 1;
                }

            } else {
                if ($this->checkWhetherProductBelongsToAccessories($productId)) {
                    return 4;
                } else {
                    $inCompareArr = explode(',', $this->context->cookie->comparison);
                    if (!in_array($productId, $inCompareArr)) {
                        //checking if count of already existing products to compare is less than equal to max value
                        if (count($inCompareArr) < _MAX_PRODUCT_TO_COMPARE) {
                            //checking if product added is of same category or different
                            $query = 'Select id_product,id_category from ' . _DB_PREFIX_ . 'category_product where id_product in (' . $this->context->cookie->comparison . ',' . $productId . ') and id_category!=2';
                            if ($results = Db::getInstance()->ExecuteS($query)) {
                                $existingProductCategoriesIds = array();
                                $newProductCategoriesIds = array();
                                foreach ($results as $row) {
                                    if (in_array($row['id_product'], $inCompareArr))
                                        $existingProductCategoriesIds[] = $row['id_category'];
                                    if ($row['id_product'] == $productId)
                                        $newProductCategoriesIds[] = $row['id_category'];
                                }
                                if (count(array_intersect($existingProductCategoriesIds, $newProductCategoriesIds)) > 0) {
                                    $this->context->cookie->comparison .= ',' . $productId;
                                    return 1;
                                }
                                return 3;
                            }
                        }

                        return 0;

                    }

                    return 1;
                }
            }
        }
    }

    private function checkWhetherProductBelongsToAccessories($productId)
    {
        $sqlQuery = 'Select id_category from ' . _DB_PREFIX_ . 'category_product where id_product=' . $productId;
        if ($categoryOfExistingProducts = Db::getInstance()->ExecuteS($sqlQuery)) {
            $productInsertingCategoryIds = array();
            foreach ($categoryOfExistingProducts as $row) {
                $productInsertingCategoryIds[] = $row['id_category'];
            }
            if (in_array(_CATEGORY_ID_FOR_ACCESSORY, $productInsertingCategoryIds))
                return true;
            return false;

        }
    }

    private function getProductPageContent($product_id)
    {
        //array containing block names
        $blocksArray = array('\'COD\'', '\'EMI\'', '\'Replacement\'', '\'Refund\'', '\'Warranty\'', '\'Shipping\'', '\'Video\'', '\'BookDemo\'');
        if ($product_id < 1)
            return;
        $product_feature_categories = Db::getInstance()->ExecuteS('SELECT DISTINCT cf.category_id, c.name FROM ' . _DB_PREFIX_ . '_fc_categories_features cf
		LEFT JOIN ' . _DB_PREFIX_ . '_fc_categories c ON (c.category_id = cf.category_id)
		WHERE cf.feature_id IN
		(SELECT id_feature FROM ' . _DB_PREFIX_ . 'feature_product WHERE id_product=' . $product_id . ') and c.name in (' . implode(',', $blocksArray) . ') ORDER BY c.priority');
        $output = array();
        $cat_ids = array();
        foreach ($product_feature_categories as $cat) {
            $feature_names = Db::getInstance()->ExecuteS('SELECT fl.name, fvl.value,f.id_feature  FROM ' . _DB_PREFIX_ . 'feature_lang fl
			LEFT JOIN ' . _DB_PREFIX_ . 'feature_product fp ON (fl.id_feature = fp.id_feature AND fp.id_product = ' . $product_id . ')
			LEFT JOIN ' . _DB_PREFIX_ . 'feature_value_lang fvl ON (fp.id_feature_value = fvl.id_feature_value AND fvl.id_lang = ' . intval($this->context->language->id) . ')
                        LEFT JOIN ' . _DB_PREFIX_ . 'feature f ON(f.id_feature = fl.id_feature)
			WHERE fl.id_lang=' . intval($this->context->language->id) . ' AND fl.id_feature IN
			(SELECT feature_id FROM ' . _DB_PREFIX_ . '_fc_categories_features WHERE category_id=' . $cat['category_id'] . ') ORDER BY f.position');
            $output[$cat['name']] = $feature_names;
            $cat_ids[] = $cat['category_id'];
        }

        $helper = new Helper();
        $fieldsToDisplayArray1 = array();
        $fieldsToDisplayArray2 = array();
        $isVideoPresent = false;
        $videoDescription = '';
        $isDemoPresent = false;
        $demoDescription = '';

        foreach ($output as $key => $itemRow) {
            if ($helper->checkItemStateEnable($itemRow[0]['value'])) {
                if (strcasecmp($key, 'video') == 0) {
                    $isVideoPresent = true;
                    $videoDescription = $itemRow[1]['value'];
                    continue;
                }
                if (strcasecmp($key, 'BookDemo') == 0) {
                    $isDemoPresent = true;
                    $demoDescription = $itemRow[1]['value'];
                    continue;
                }
                if (count($fieldsToDisplayArray1) <= 2)
                    $fieldsToDisplayArray1[] = $itemRow;
                else
                    $fieldsToDisplayArray2[] = $itemRow;
            }
        }

        $this->context->smarty->assign(array('output1' => $fieldsToDisplayArray1, 'output2' => $fieldsToDisplayArray2, 'helper' => $helper));
        $output = $this->context->smarty->fetch(dirname(__FILE__) . '/../../views/templates/front/product_block_content.tpl');
        $product_block_content = array('block' => $output, 'video' => array('status' => $isVideoPresent, 'description' => $videoDescription), 'demo' => array('status' => $isDemoPresent, 'description' => $demoDescription));
        echo json_encode($product_block_content);
        exit;

    }

    private function getCategoryProductsListContent($productIds)
    {
        //array containing block names
        $blocksArray = array('\'COD\'', '\'EMI\'', '\'Video\'', '\'ProductHighlightFeatures\'');
        $productIds = explode(',', $productIds);
        $features_by_categories = array();

        $query = 'SELECT DISTINCT cf.category_id, c.name FROM ' . _DB_PREFIX_ . '_fc_categories_features cf
		LEFT JOIN ' . _DB_PREFIX_ . '_fc_categories c ON (c.category_id = cf.category_id)
		WHERE cf.feature_id IN
		(SELECT id_feature FROM ' . _DB_PREFIX_ . 'feature_product WHERE 0';
        foreach ($productIds as $product_id) {
            if ($product_id != '')
                $query .= ' OR id_product=' . $product_id;
        }
        $query .= ') and c.name in (' . implode(',', $blocksArray) . ') ORDER BY c.priority';
        $product_feature_categories = Db::getInstance()->ExecuteS($query);
        foreach ($product_feature_categories as $pfc) {
            $feature_ids = array();
            $raw_features = Db::getInstance()->ExecuteS('SELECT cf.feature_id FROM ' . _DB_PREFIX_ . '_fc_categories_features cf LEFT JOIN ' . _DB_PREFIX_ . 'feature f ON(f.id_feature = cf.feature_id) WHERE cf.category_id=' . $pfc['category_id'] . ' ORDER BY f.position');
            foreach ($raw_features as $fid) {
                $feature_ids[] = $fid['feature_id'];
                $distributed_features[] = $fid['feature_id'];
            }
            $features_by_categories[$pfc['name']] = $feature_ids;
        }

        $helper = new Helper();

        $productsWithStatus = array();
        foreach ($productIds as $id) {
            foreach ($features_by_categories as $key => $value) {
                $itemVal = $helper->getFeatureVal($id, $value[0]);
                if ($helper->checkItemStateEnable($itemVal)) {
                    $productsWithStatus[$id][$key]['status'] = 'Yes';
                    $productsWithStatus[$id][$key]['description'] = $helper->getFeatureVal($id, $value[1]);
                } else {
                    $productsWithStatus[$id][$key] = 'No';
                }

            }
            $productsWithStatus[$id]['rating'] = $this->getProductRatingForProduct(0, 0);
        }

        $ratingArray = $this->getProductRatingAndReviews($productIds);
        foreach ($ratingArray as $ratingRow) {
            $productsWithStatus[$ratingRow['id_product']]['rating'] = $this->getProductRatingForProduct($ratingRow['grade'], $ratingRow['total']);
        }

        echo json_encode($productsWithStatus);
        exit;

    }

    private
    function deleteFromCompare($productId)
    {
        $productIds = explode(',', $this->context->cookie->comparison);
        if (in_array($productId, $productIds))
            $productIds = array_diff($productIds, array($productId));
        $strIds = implode(",", $productIds);
        $this->context->cookie->comparison = $strIds;
        $this->returnCompareList();
    }

    private
    function deleteAll()
    {
        $this->context->cookie->comparison = '';
        $this->returnCompareList();
    }

    private
    function generatePDF()
    {
        $pdf = new ComparePdf($this->context->smarty, $this->context->language->id);
        $pdf->render(true);
    }

    private
    function returnCompareList()
    {
        $mode = Configuration::get('FEATURECATEGORIES_DISP_MODE');
        if (!empty($this->context->cookie->comparison)) {
            $productIds = explode(',', $this->context->cookie->comparison);
            $html = '<div class="line compare-cart-wrapper">
            <div class="compare-items">';
            foreach ($productIds as $id) {
                $p = new Product($id);
                $cover = Product::getCover((int)$id);
                $imagePath = $this->context->link->getImageLink($p->link_rewrite, $cover['id_image'], 'medium_default');
                $html .= '<div class="compare-item"><div class="thumb_holder"><img src="' . $imagePath . '"/></div><a class="description" href="' . $this->context->link->getProductLink($id) . '">' . $p->name[1] . '</a><span class="delete" title="remove"><a onclick ="deleteItem($(this));return false;" href ="' . __PS_BASE_URI__ . 'modules/featurecategories/compare.php?action=delete&productId=' . $id . '" class="delete_link">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></span></div>';
            }
            $leftProducts = _MAX_PRODUCT_TO_COMPARE - count($productIds);
            if ($leftProducts) {
                for ($i = 0; $i < $leftProducts; $i++) {
                    $html .= '<div class="compare-item empty_item">
                        <div class="thumb_holder">
                          </div>
                        <p class="description">Add Another Item</p>

                    </div>';
                }
            }

            $html .= '</div><div class="compare-controls">
                     <a class="exclusive_small btn" href = "' . __PS_BASE_URI__ . 'index.php?fc=module&module=featurecategories&controller=compare&action=display"' . ($mode == 'separate' ? 'target="_blank"' : '') . '>Compare</a>
                                <span class="close" title="Close" onclick="deleteAllItems(); return false;"></span>

            </div>
            <div class="clear"></div>';
        } else
            $html = '';
        echo $html;
    }

    public
    function displayComparison()
    {
        $mode = Configuration::get('FEATURECATEGORIES_DISP_MODE');
        if ($mode == 'inside')
            parent::initContent();
        $productIds = explode(',', $this->context->cookie->comparison);
        $features_by_categories = array();
        $distributed_features = array();
        $all_feature_ids = array();

        $query = 'SELECT DISTINCT cf.category_id, c.name FROM ' . _DB_PREFIX_ . '_fc_categories_features cf
		LEFT JOIN ' . _DB_PREFIX_ . '_fc_categories c ON (c.category_id = cf.category_id) 
		WHERE cf.feature_id IN 
		(SELECT id_feature FROM ' . _DB_PREFIX_ . 'feature_product WHERE 0';
        foreach ($productIds as $product_id) {
            if ($product_id != '')
                $query .= ' OR id_product=' . $product_id;
        }
        $query .= ') ORDER BY c.priority';
        $product_feature_categories = Db::getInstance()->ExecuteS($query);
        foreach ($product_feature_categories as $pfc) {
            $feature_ids = array();
            $raw_features = Db::getInstance()->ExecuteS('SELECT cf.feature_id FROM ' . _DB_PREFIX_ . '_fc_categories_features cf LEFT JOIN ' . _DB_PREFIX_ . 'feature f ON(f.id_feature = cf.feature_id) WHERE cf.category_id=' . $pfc['category_id'] . ' ORDER BY f.position');
            foreach ($raw_features as $fid) {
                $feature_ids[] = $fid['feature_id'];
                $distributed_features[] = $fid['feature_id'];
            }
            $features_by_categories[$pfc['name']] = $feature_ids;
        }

        $helper = new Helper();

        $products = array();
        foreach ($productIds as $id) {
            if ($id != '') {
                $raw_all_ids = Db::getInstance()->ExecuteS('SELECT id_feature FROM ' . _DB_PREFIX_ . 'feature_product WHERE id_product = ' . $id);
                foreach ($raw_all_ids as $raw_id) {
                    if (!in_array($raw_id['id_feature'], $all_feature_ids))
                        $all_feature_ids[] = $raw_id['id_feature'];
                }
                $cover = Product::getCover((int)$id);
                $product = new Product($id, true, intval($this->context->cookie->id_lang));
                $product->id_image = Tools::htmlentitiesUTF8(Product::defineProductImage(array('id_image' => $cover['id_image'], 'id_product' => $id), $this->context->cookie->id_lang));
                $product->rating = $this->getProductRating($id);
                $products[] = $product;

            }
        }
        $not_distributed_features = array_diff($all_feature_ids, $distributed_features);
        if (count($not_distributed_features) > 0)
            $features_by_categories['Other Features'] = $not_distributed_features;
        $count = count($productIds);
        $pdfUrl = __PS_BASE_URI__ . 'index.php?fc=module&module=featurecategories&controller=compare&action=pdf';
        $this->context->smarty->assign(array('features_by_categories' => $features_by_categories, 'helper' => $helper, 'products' => $products, 'product_count' => $count, 'categories' => $this->getCategories($this->context->cookie->comparison),
            'this_path' => $this->module->getPathUri(), 'pdfPath' => $pdfUrl));

        if ($mode == 'inside')
            $this->setTemplate('comparison_embed.tpl');
        else {
            $this->context->smarty->display(dirname(__FILE__) . '/../../views/templates/front/comparison.tpl');
            die();
        }
    }


    private
    function getCategories($productIds)
    {

        $query = 'select distinct(id_category) from ' . _DB_PREFIX_ . 'category_product where id_product in(' . $productIds . ') and id_category!=2 order by position';
        if ($baseCategories = Db::getInstance()->ExecuteS($query)) {
            $categoryIds = array();
            foreach ($baseCategories as $row) {
                $categoryIds[] = $row['id_category'];
            }
            $sql = 'select distinct(' . _DB_PREFIX_ . 'category.id_category),' . _DB_PREFIX_ . 'category.id_parent,' . _DB_PREFIX_ . 'category_lang.name from ' . _DB_PREFIX_ . 'category_lang join ' . _DB_PREFIX_ . 'category on ' . _DB_PREFIX_ . 'category_lang.id_category=' . _DB_PREFIX_ . 'category.id_category where active=1 and level_depth<=3 and (' . _DB_PREFIX_ . 'category.id_parent in (' . implode(',', $categoryIds) . ') or ' . _DB_PREFIX_ . 'category.id_category in(' . implode(',', $categoryIds) . ')) order by id_parent';

            if ($results = Db::getInstance()->ExecuteS($sql)) {

                $categoryIdsList = array();
                foreach ($results as $row) {
                    $categoryIdsList[] = array('id' => $row['id_category'], 'name' => $row['name']);
                }
//                $categoryIdsList = array();
//                foreach ($results as $key => $value) {
//                    $categoryIdsList[] = array('id' => $key, 'name' => $value['name']);
//                }
                return $categoryIdsList;
            }
        }
        return array();

    }

//    private function getParentCategoryId($categoryArray, $categoryId)
//    {
//        if ($categoryArray[$categoryId]['parent'] == 2)
//            return $categoryId;
//        else
//            $this->getParentCategoryId($categoryArray, $categoryArray[$categoryId]['parent']);
//    }

    public function getProductRatingAndReviews($productIds)
    {
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
		SELECT COUNT(pc.`grade`) AS total,AVG(pc.`grade`) AS grade,pc.id_product as id_product
		FROM `' . _DB_PREFIX_ . 'product_comment` pc
		WHERE pc.`id_product` in (' . implode(',', $productIds) . ')
		AND pc.`deleted` = 0 group by pc.id_product');
    }

    public
    function getProductRating($id_product)
    {
        $average = $this->getAverageGrade((int)$id_product);
        $ratingTotal = $this->getTotalGrade((int)$id_product);
        $smartData = array(
            'averageTotal' => !empty($average['grade']) ? round($average['grade'], 2) : 0,
            'totalRating' => (int)$ratingTotal['total']);
        $this->context->smarty->assign($smartData);

        $output = $this->context->smarty->fetch(dirname(__FILE__) . '/../../views/templates/front/productcomments-extra.tpl');
        return $output;
    }

    public function getProductRatingForProduct($average, $ratingTotal)
    {
        $smartData = array(
            'averageTotal' => !empty($average) ? round($average, 2) : 0,
            'totalRating' => (int)$ratingTotal);
        $this->context->smarty->assign($smartData);

        $output = $this->context->smarty->fetch(dirname(__FILE__) . '/../../views/templates/front/productcomments-extra.tpl');
        return $output;
    }


    public
    function getTotalGrade($id_product)
    {
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
		SELECT COUNT(*) AS total
		FROM `' . _DB_PREFIX_ . 'product_comment` pc
		WHERE pc.`id_product` = ' . (int)$id_product . '
		AND pc.`deleted` = 0');
    }

    public
    function getAverageGrade($id_product)
    {
        $validate = Configuration::get('PRODUCT_COMMENTS_MODERATE');

        return Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
		SELECT AVG(pc.`grade`) AS grade
		FROM `' . _DB_PREFIX_ . 'product_comment` pc
		WHERE pc.`id_product` = ' . (int)$id_product . '
		AND pc.`deleted` = 0');
    }

}
