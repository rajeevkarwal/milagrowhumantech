<?php

class Helper
{

    function getFeatureVal($id_product, $id_feature)
    {
        global $cookie;
        $res = Db::getInstance()->ExecuteS('SELECT fvl.value FROM ' . _DB_PREFIX_ . 'feature_value_lang fvl LEFT JOIN ' . _DB_PREFIX_ .
            'feature_product fp ON (fp.id_feature_value = fvl.id_feature_value)
    WHERE fp.id_feature = ' . $id_feature . ' AND fp.id_product =' . $id_product . ' AND fvl.id_lang = ' . intval($cookie->id_lang));
        if (count($res) > 0)
            return $res[0]['value'];
        return '';
    }

    function getFeatureName($id_feature)
    {
        global $cookie;
        $res = Db::getInstance()->ExecuteS('SELECT name FROM ' . _DB_PREFIX_ . 'feature_lang WHERE id_feature =' . $id_feature . ' AND id_lang =' . intval($cookie->id_lang));
        if (count($res) > 0)
            return $res[0]['name'];
        return '';
    }

    function getDescription($cat_name)
    {
        $res = Db::getInstance()->ExecuteS('SELECT description FROM ' . _DB_PREFIX_ . '_fc_categories WHERE name="' . $cat_name . '"');
        if (count($res) > 0 && $res[0]['description'] != '') {
            return html_entity_decode($res[0]['description']);
        }
        return null;
    }

    function getProductDescription($id_feature)
    {
        $res = Db::getInstance()->getRow('SELECT product_description FROM ' . _DB_PREFIX_ . '_fc_features_description WHERE feature_id=' . $id_feature);
        if ($res) {
            return html_entity_decode(trim($res['product_description']));
        }
        return null;
    }


    function isNotEmptyValues($feature_id, $prods)
    {
        global $cookie;
        foreach ($prods as $p) {
            $res = Db::getInstance()->ExecuteS('SELECT fvl.value FROM ' . _DB_PREFIX_ . 'feature_value_lang fvl LEFT JOIN ' . _DB_PREFIX_ .
                'feature_product fp ON (fp.id_feature_value = fvl.id_feature_value)
        WHERE fp.id_feature = ' . $feature_id . ' AND fp.id_product =' . $p->id . ' AND fvl.id_lang = ' . intval($cookie->id_lang));

            if (count($res) > 0 and count($res[0]['value']) > 0)
                return true;
        }
        return false;
    }

    function getFormattedPrice($product)
    {
        return round($product->price + (($product->price * $product->tax_rate) / 100), 2);
    }

    function checkItemStateEnable($itemVal)
    {
        if (((strcasecmp($itemVal, 'Yes') == 0) || strcasecmp($itemVal, 'Y') == 0))
            return true;
    }

    function checkAllowCategories($category)
    {
        $allowed = true;
        $blocksArray = array('COD', 'EMI', 'Replacement', 'Refund', 'Warranty', 'Shipping', 'Video', 'BookDemo','TV Mounts Filter','ProductHighlightFeatures','Additional Connectivity','Milagrow Aditional Features');
        foreach ($blocksArray as $row) {
            if ((strcasecmp($category, $row) == 0))
                $allowed = false;
        }
        return $allowed;
    }

}