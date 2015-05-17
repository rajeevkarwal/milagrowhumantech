<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hitanshu
 * Date: 31/8/13
 * Time: 1:27 PM
 * To change this template use File | Settings | File Templates.
 */

class HTMLTemplateComparePdf extends HTMLTemplate
{

    public function __construct()
    {

        // header informations
        $this->title = 'Product Comparison';
        $this->date = date('Y-m-d');
        $this->context = Context::getContext();
        $this->smarty = $this->context->smarty;

    }

    /**
     * Returns the template's HTML content
     * @return string HTML content
     */

    public function getFooter()
    {
        return '';
    }

    public function getContent()
    {
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
                $product = new Product($id, true, intval($this->context->language->id));
                $product->id_image = Tools::htmlentitiesUTF8(Product::defineProductImage(array('id_image' => $cover['id_image'], 'id_product' => $id), $this->context->language->id));
                $product->rating = $this->getProductRating($id);
                $products[] = $product;

            }
        }
        $not_distributed_features = array_diff($all_feature_ids, $distributed_features);
        if (count($not_distributed_features) > 0)
            $features_by_categories['Other Features'] = $not_distributed_features;
        $count = count($productIds);

        $this->context->smarty->assign(array('features_by_categories' => $features_by_categories, 'helper' => $helper, 'products' => $products, 'product_count' => $count));


        $output = $this->smarty->fetch(dirname(__FILE__) . '/views/templates/front/comparison_pdf.tpl');
        return $output;
//        echo $output;
//        exit;
    }

    public function getProductRating($id_product)
    {
        $average = $this->getAverageGrade((int)$id_product);
        $ratingTotal = $this->getTotalGrade((int)$id_product);
        $smartData = array(
            'averageTotal' => !empty($average['grade']) ? round($average['grade'], 2) : 0,
            'totalRating' => (int)$ratingTotal['total']);
        $this->context->smarty->assign($smartData);

        $output = $this->context->smarty->fetch(dirname(__FILE__) . '/views/templates/front/productcomments-extra-pdf.tpl');
        return $output;
    }

    public function getTotalGrade($id_product)
    {
        $validate = Configuration::get('PRODUCT_COMMENTS_MODERATE');

        return Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
		SELECT COUNT(*) AS total
		FROM `' . _DB_PREFIX_ . 'product_comment` pc
		WHERE pc.`id_product` = ' . (int)$id_product . '
		AND pc.`deleted` = 0' .
            ($validate == '1' ? ' AND pc.`validate` = 1' : ''));
    }

    public function getAverageGrade($id_product)
    {
        $validate = Configuration::get('PRODUCT_COMMENTS_MODERATE');

        return Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
		SELECT AVG(pc.`grade`) AS grade
		FROM `' . _DB_PREFIX_ . 'product_comment` pc
		WHERE pc.`id_product` = ' . (int)$id_product . '
		AND pc.`deleted` = 0' .
            ($validate == '1' ? ' AND pc.`validate` = 1' : ''));
    }

    public function getFilename()
    {
        return 'Product-Comparison.pdf';
    }

    public function getBulkFilename()
    {
        return '';
    }
}