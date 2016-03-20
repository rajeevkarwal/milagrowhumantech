<?php
/*
* 2007-2013 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
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
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_'))
    exit;

class DAMCProducts extends Module
{

    function __construct()
    {
        $this->name = 'damcproducts';
        $this->tab = 'front_office_features';
        $this->version = '1.0';
        $this->author = 'Hitanshu';
        $this->need_instance = 0;

        parent::__construct();

        $this->displayName = $this->l('DAMC Products');
        $this->description = $this->l('Manage DAMC Products');
    }

    function install()
    {
        if (!parent::install() || !$this->registerHook('header'))
            return false;
        return true;
    }

    public function uninstall()
    {
        if (!parent::uninstall())
            return false;
        return true;
    }


    public function hookDisplayHeader($params)
    {
        $this->hookHeader($params);
    }

    public function hookHeader($params)
    {
        $this->context->controller->addCSS(_THEME_CSS_DIR_ . 'contact-form.css');

    }

    public static function getShopDomainSsl($http = false, $entities = false)
    {
        if (method_exists('Tools', 'getShopDomainSsl'))
            return Tools::getShopDomainSsl($http, $entities);
        else {
            if (!($domain = Configuration::get('PS_SHOP_DOMAIN_SSL')))
                $domain = self::getHttpHost();
            if ($entities)
                $domain = htmlspecialchars($domain, ENT_COMPAT, 'UTF-8');
            if ($http)
                $domain = (Configuration::get('PS_SSL_ENABLED') ? 'https://' : 'http://') . $domain;
            return $domain;
        }
    }

    protected function getCurrentUrl()
    {
        $protocol_link = Tools::usingSecureMode() ? 'https://' : 'http://';
        $request = $_SERVER['REQUEST_URI'];
        $pos = strpos($request, '?');

        if (($pos !== false) && ($pos >= 0))
            $request = substr($request, 0, $pos);

        $params = urlencode($_SERVER['QUERY_STRING']);

        return $protocol_link . Tools::getShopDomainSsl() . $request . '?' . $params;
    }

    public function fetchTemplate($name)
    {
        if (_PS_VERSION_ < '1.4')
            $this->context->smarty->currentTemplate = $name;
        elseif (_PS_VERSION_ < '1.5') {
            $views = 'views/templates/';
            if (@filemtime(dirname(__FILE__) . '/' . $name))
                return $this->display(__FILE__, $name);
            elseif (@filemtime(dirname(__FILE__) . '/' . $views . 'hook/' . $name))
                return $this->display(__FILE__, $views . 'hook/' . $name);
            elseif (@filemtime(dirname(__FILE__) . '/' . $views . 'front/' . $name))
                return $this->display(__FILE__, $views . 'front/' . $name);
            elseif (@filemtime(dirname(__FILE__) . '/' . $views . 'back/' . $name))
                return $this->display(__FILE__, $views . 'back/' . $name);
        }

        return $this->display(__FILE__, $name);
    }

    public function getContent()
    {
        $this->html = '<h2>' . $this->displayName . '</h2>';
        $this->html .= '<link media="all" type="text/css" rel="stylesheet" href="' .
            $this->_path . 'views/css/back.css"/>';
        $url = $_SERVER['REQUEST_URI'];
        if (strpos($url, '&sd_tab') > 0)
            $url = substr($url, 0, strpos($url, '&sd_tab'));

        $this->html .= '<ul><li '.('class="sd_admin_tab_active sd_admin_tab"').'><a style="padding:8px 8px 4px 4px;" href="' .
            $url . '&sd_tab=products" id = "sd_configprod">' . $this->l('Add NEW') . '</a></li>

			<li '.('class="sd_admin_tab sd_admin_tab_active"').'><a style="padding:8px 8px 4px 4px;" href="' .
            $url . '&sd_tab=deleteactivepage" id = "sd_delete">' . $this->l('List DAMC Products') . '</a></li></ul>';

        if (Tools::getValue('sd_tab') == 'delete_senior') {
            $id_del = Tools::getValue('id_delete');
            $this->html .= $this->deletesenior($id_del, $url);
        }
        if (Tools::getValue('sd_tab') == 'active_senior') {
            $id_act = Tools::getValue('id_active');
            $this->html .= $this->activesenior($id_act, $url);
        }
        if (Tools::getValue('sd_tab') == 'edit_damc_products') {
            $id_ed = Tools::getValue('damc_id');
//            print_r($_GET);
            $this->html .= $this->editDAMCProducts($id_ed, $url);
        }
        else if (Tools::getValue('sd_tab') == 'products')
            $this->html .= $this->products_configure($url);
        else
            $this->html .= $this->displayDAMCList($url);
        return $this->html;

    }

    private function errorBlock($errors)
    {
        $this->context->smarty->assign(array(
            'errors' => $errors
        ));
        return $this->fetchTemplate('/views/templates/back/errors.tpl');
    }

    public function products_configure($url)
    {
        $messageToShow='';
        if($_POST['submit']){
            $selectedProduct = Tools::getValue('product')?Tools::getValue('product'):0;
            $selectedCategory = Tools::getValue('category')?Tools::getValue('category'):0;
            $selectamcperiod = Tools::getValue('amcperiod')?Tools::getValue('amcperiod'):0;
            $selectamcper = Tools::getValue('amcper')?Tools::getValue('amcper'):0;
            $senioramt = Tools::getValue('senioramt')?Tools::getValue('senioramt'):0;
            $senioramtper = Tools::getValue('senioramtper')?Tools::getValue('senioramtper'):0;
            $studentamt = Tools::getValue('studentamt')?Tools::getValue('studentamt'):0;
            $studentamtper = Tools::getValue('studentamtper')?Tools::getValue('studentamtper'):0;
            $senior = Tools::getValue('senior')?Tools::getValue('senior'):0;
            $student = Tools::getValue('student')?Tools::getValue('student'):0;
            $amc = Tools::getValue('amc')?Tools::getValue('amc'):0;
            $warranty = Tools::getValue('warranty')?Tools::getValue('warranty'):0;

            if(empty($selectedProduct) || empty($selectedCategory))
            {
                $messageToShow='Please select category and product';
            }

            if(empty($messageToShow))
            {

                //firstly check if the product id already exist then fetch the same
                $existingProductSQl = 'select * from ' . _DB_PREFIX_ . 'damc_products as dp where productID='.$selectedProduct.' ORDER BY created_at ';
//                 echo $existingProductSQl;
                if ($results = Db::getInstance()->getRow($existingProductSQl)) {

                    $updateData=array();
                    if($student && $results['is_student_active']==0)
                    {
                        $updateData['is_student_active']=1;
                        $updateData['is_studentamtper']=$studentamt;
                        if($studentamt==2 && $studentamtper>10)
                        {
                            $studentamtper=10;
                        }
                        $updateData['studentamt']=$studentamtper;
                    }

                    if($senior && $results['is_senior_active']==0)
                    {
                        $updateData['is_senior_active']=1;
                        $updateData['is_senioramtper']=$senioramt;
                        if($senioramt==2 && $senioramtper>10)
                        {
                            $senioramtper=10;
                        }
                        $updateData['senioramt']=$senioramtper;
                    }

                    if($amc)
                    {
                        $updateData['is_amc_active']=1;
                        $updateData['warranty']=$warranty;
                        $amcPeriodsSql='select id,period from '._DB_PREFIX_.'damc_products_period where damc_id='.$results['id'];
                        $periodResults=Db::getInstance()->executeS($amcPeriodsSql);
                        $amcPeriodArrKeyMap=array();
                        $periodArr=array();
                        foreach($periodResults as $row)
                        {
                            $amcPeriodArrKeyMap[$row['period']]=$row['id'];
                        }

                        if(!empty($amcPeriodArrKeyMap))
                        {

                            $periodArr=array_keys($amcPeriodArrKeyMap);
                        }

                        if(!in_array($selectamcperiod,$periodArr))
                        {
                            //product already exist but incoming product having different period
                            if($results['id'] && !empty($selectamcperiod) && !empty($selectamcper))
                            {
                                $amcPeriodData=array('damc_id'=>$results['id'],'period'=>$selectamcperiod,'amc_percentage'=>$selectamcper);
                                Db::getInstance()->insert('damc_products_period',$amcPeriodData);
                            }

                        }
                        else
                        {
                            $periodTableId=$amcPeriodArrKeyMap[$selectamcperiod];
                            Db::getInstance()->update('damc_products_period',array('amc_percentage'=>$selectamcper),"id=$periodTableId");
                        }


                    }

                    Db::getInstance()->update('damc_products',$updateData,"id={$results['id']}");

                    $messageToShow='Added SuccessFully!!';
                }
                else
                {
                    $insertData=array();
                    $insertData['productId']=$selectedProduct;
                    $insertData['categoryId']=$selectedCategory;
                    $insertData['created_at']=date('Y-m-d H:i:s');

                    if($student)
                    {
                        $insertData['is_student_active']=1;
                        $insertData['is_studentamtper']=$studentamt;
                        if($studentamt==2 && $studentamtper>10)
                        {
                            $studentamtper=10;
                        }
                        $insertData['studentamt']=$studentamtper;
                    }
                    else
                    {
                        $insertData['is_student_active']=0;
                        $insertData['is_studentamtper']=1;
                        $insertData['studentamt']=0;
                    }

                    if($senior)
                    {
                        $insertData['is_senior_active']=1;
                        $insertData['is_senioramtper']=$senioramt;
                        if($senioramt==2 && $senioramtper>10)
                        {
                            $senioramtper=10;
                        }
                        $insertData['senioramt']=$senioramtper;
                    }
                    else
                    {
                        $insertData['is_senior_active']=0;
                        $insertData['is_senioramtper']=1;
                        $insertData['senioramt']=0;
                    }


                    if($amc)
                    {
                        $insertData['is_amc_active']=1;
                        $insertData['warranty']=$warranty;
                    }
                    else
                    {
                        $insertData['is_amc_active']=0;
                        $insertData['warranty']='';
                    }
                    Db::getInstance()->insert('damc_products',$insertData);
                    $lastInsertId=Db::getInstance()->Insert_ID();

                    if($amc && $lastInsertId && !empty($selectamcperiod) && !empty($selectamcper))
                    {
                        $amcPeriodData=array('damc_id'=>$lastInsertId,'period'=>$selectamcperiod,'amc_percentage'=>$selectamcper);
                        Db::getInstance()->insert('damc_products_period',$amcPeriodData);

                    }

                    $messageToShow='Added SuccessFully!!';
                }
            }
        }

        /*code for category select list*/

        $sqlcat = 'SELECT p.id_category AS categoryid,p.name AS category_name FROM ps_category_lang as p left join ps_category as pd on p.id_category = pd.id_category where pd.active = 1 and pd.level_depth = 2';
        $category ='';
        $category .= '<label> <strong>Category :</strong></label>';
        $category .= '<select name="category" id="category" onchange="getid()">';
        $category .= '<option value="">Select Category</option>';

        $catid = array();
        if ($results = Db::getInstance()->Executes($sqlcat))
        {
            foreach ($results as $row)
            {
                $category .= '<option value="'.$row['categoryid'].'">'.$row['category_name'].'</option>';
                $catid[] = $row['categoryid'];
            }

            $category .=  '</select>';
        }

        $catwiseproduct=array();
        if(!empty($catid))
        {
            $sqlprod = 'SELECT p.name, pc.id_category AS categoryid,p.id_product FROM ps_product_lang as p join ps_category_product as pc on p.id_product = pc.id_product join ps_product pr on pr.id_product=pc.id_product where pr.active=1 and pc.id_category in ('.implode(",", $catid).')';
            if ($res = Db::getInstance()->Executes($sqlprod))
            {
                foreach($res as $product)
                {
                    $catwiseproduct[$product['categoryid']][]=array('product_name'=>$product['name'],'id_product'=>$product['id_product']);
                }
            }
        }
        $this->context->smarty->assign(array(
            'url' => $url,
            'category' => $category,
            'finprolist' => json_encode($catwiseproduct),
            'messageToShow'=>$messageToShow
        ));

        return $this->fetchTemplate('/views/templates/back/products1.tpl');

    }

    public function products_delete($url){
        $del = 'SELECT pd.id as id ,pd.is_del as is_del,pd.is_amc_active as amc,pd.is_senior_active as senior,pd.is_student_active as student, pc.name as cat_name,p.name  as prod_name FROM ps_category_lang as pc join ps_damc_products as pd on pd.categoryID= pc.id_category join ps_product_lang as p on pd.productID = p.id_product ';
        $result = Db::getInstance()->Executes($del);
        $this->context->smarty->assign(array(
            'url' => $url,
            'result' => $result
        ));
        return $this->fetchTemplate('/views/templates/back/deleteproduct.tpl');
    }


    private function displayDAMCList($url)
    {
        $page = Tools::getValue('page');
        $page = !empty($page) ? $page : 1;
        $previousPage = 0;
        $nextPage = 0;
        $pageCount = 10;
        $queriesList = $this->getDAMCProductsList($page, $pageCount);
        $totalQueries = $this->countDAMCProducts();
        if (($page * $pageCount) < (int)$totalQueries) {
            $nextPage = $page + 1;
        }
        if ($page > 1)
            $previousPage = $page - 1;

        $this->context->smarty->assign(array(
            'queriesList' => $queriesList,
            'page' => $page,
            'previous' => $previousPage,
            'next' => $nextPage,
            'url' => $url
        ));

        return $this->fetchTemplate('/views/templates/back/enquiry-list.tpl');
    }

    private function getDAMCProductsList($p = 1, $n = null)
    {
        $sql = "select dp.*,pp.name as productName,cl.name as categoryName from ps_damc_products dp join ps_product_lang pp on dp.productID=pp.id_product join ps_category_lang cl on cl.id_category=dp.CategoryID  ORDER BY created_at ".($n ? ' LIMIT ' . (int)(($p - 1) * $n) . ', ' . (int)($n) : '');
        $damcProductsKeyMap=array();
        $damcWisePeriodKeyMap=array();
        if ($results = Db::getInstance()->ExecuteS($sql)) {
            $damcProductsIds=array();
            foreach($results as $resultRow)
            {
                $damcProductsKeyMap[$resultRow['id']]=$resultRow;
                if($resultRow['is_amc_active']==1)
                $damcProductsIds[]=$resultRow['id'];
            }

            if(!empty($damcProductsIds))
            {
                $periodSql='Select id, damc_id, period, amc_percentage from ps_damc_products_period where damc_id in ('.implode(',',$damcProductsIds).')';
                $periodResult = Db::getInstance()->ExecuteS($periodSql);

                if(!empty($results))
                {
                    foreach($periodResult as $resultRow)
                    {
                        $damcWisePeriodKeyMap[$resultRow['damc_id']][]=$resultRow;
                    }
                }
            }
        }

        foreach($damcProductsKeyMap as $damcId=>$val)
        {

            if(!empty($damcWisePeriodKeyMap[$damcId]))
            {
                $damcProductsKeyMap[$damcId]['amcData']=$damcWisePeriodKeyMap[$damcId];
            }
        }
        return $damcProductsKeyMap;
    }

    private function countDAMCProducts()
    {
        $sql = 'select count(*) from ' . _DB_PREFIX_ . 'damc_products';
        if ($results = Db::getInstance()->getValue($sql)) {
            return $results;
        }

        return 0;
    }


    public function deletesenior($id, $url){

        $id = intval($id);

        $sql1 = 'UPDATE `ps_damc_products` SET `is_del`=1 WHERE `id`="'.$id.'"';
        Db::getInstance()->execute( $sql1 );


        $error = Db::getInstance()->getMsgError();
        $html = '';
        if ($error) {
            $this->_errors[] = 'Sorry error occured while deleting store';
            $html = $this->errorBlock($this->_errors);
        }
        $html .= $this->products_delete($url);
        return $html;

    }
    public function activesenior($id, $url)
    {

        $id = intval($id);

        $sql1 = 'UPDATE `ps_damc_products` SET `is_del`=0 WHERE `id`="'.$id.'"';
        Db::getInstance()->execute( $sql1 );


        $error = Db::getInstance()->getMsgError();
        $html = '';
        if ($error) {
            $this->_errors[] = 'Sorry error occured while deleting store';
            $html = $this->errorBlock($this->_errors);
        }
        $html .= $this->products_delete($url);
        return $html;

    }
    public function editDAMCProducts($id, $url)
    {
        $id = intval($id);
        $messageToShow='';


        if($_POST['submit']){
            $selectedProduct = Tools::getValue('product')?Tools::getValue('product'):0;
            $selectedCategory = Tools::getValue('category')?Tools::getValue('category'):0;
            $selectamcperiod = Tools::getValue('amcperiod')?Tools::getValue('amcperiod'):0;
            $selectamcper = Tools::getValue('amcper')?Tools::getValue('amcper'):0;
            $senioramt = Tools::getValue('senioramt')?Tools::getValue('senioramt'):0;
            $senioramtper = Tools::getValue('senioramtper')?Tools::getValue('senioramtper'):0;
            $studentamt = Tools::getValue('studentamt')?Tools::getValue('studentamt'):0;
            $studentamtper = Tools::getValue('studentamtper')?Tools::getValue('studentamtper'):0;
            $senior = Tools::getValue('senior')?Tools::getValue('senior'):0;
            $student = Tools::getValue('student')?Tools::getValue('student'):0;
            $amc = Tools::getValue('amc')?Tools::getValue('amc'):0;
            $warranty = Tools::getValue('warranty')?Tools::getValue('warranty'):0;

            if(empty($selectedProduct) || empty($selectedCategory))
            {
                $messageToShow='Please select category and product';
            }

            if(empty($messageToShow))
            {
                //firstly check if the product id already exist then fetch the same
                $existingProductSQl = 'select count(*) as productCount from ' . _DB_PREFIX_ . 'damc_products as dp where id!='.$id.' and productID='.$selectedProduct;
                 echo $existingProductSQl;
                $results = Db::getInstance()->getRow($existingProductSQl);
                if ($results['productCount']==0) {
                    $updateData=array();
                    $updateData['is_student_active']=0;
                    $updateData['is_senior_active']=0;
                    $updateData['is_amc_active']=0;
                    $updateData['is_studentamtper']=1;
                    $updateData['is_senioramtper']=0;
                    $updateData['studentamt']=0;
                    $updateData['senioramt']=0;
                    if($student)
                    {
                        $updateData['is_student_active']=1;
                        $updateData['is_studentamtper']=$studentamt;
                        if($studentamt==2 && $studentamtper>10)
                        {
                            $studentamtper=10;
                        }
                        $updateData['studentamt']=$studentamtper;
                    }

                    if($senior)
                    {
                        $updateData['is_senior_active']=1;
                        $updateData['is_senioramtper']=$senioramt;
                        if($senioramt==2 && $senioramtper>10)
                        {
                            $senioramtper=10;
                        }
                        $updateData['senioramt']=$senioramtper;
                    }

                    if($amc)
                    {
                        $updateData['is_amc_active']=1;
                        $updateData['warranty']=$warranty;
                        $amcPeriodsSql='select id,period from '._DB_PREFIX_.'damc_products_period where damc_id='.$id;
                        $periodResults=Db::getInstance()->executeS($amcPeriodsSql);
                        $amcPeriodArrKeyMap=array();
                        $periodArr=array();
                        foreach($periodResults as $row)
                        {
                            $amcPeriodArrKeyMap[$row['period']]=$row['id'];
                        }

                        if(!empty($amcPeriodArrKeyMap))
                        {

                            $periodArr=array_keys($amcPeriodArrKeyMap);
                        }

                        if(!in_array($selectamcperiod,$periodArr))
                        {
                            //product already exist but incoming product having different period
                            if($id && !empty($selectamcperiod) && !empty($selectamcper))
                            {
                                $amcPeriodData=array('damc_id'=>$id,'period'=>$selectamcperiod,'amc_percentage'=>$selectamcper);
                                Db::getInstance()->insert('damc_products_period',$amcPeriodData);
                            }
                        }
                        else
                        {
                            $periodTableId=$amcPeriodArrKeyMap[$selectamcperiod];
                            Db::getInstance()->update('damc_products_period',array('amc_percentage'=>$selectamcper),"id=$periodTableId");
                        }


                    }
                    else
                    {
                        Db::getInstance()->executeS("delete from ps_damc_products_period where damc_id=$id");
                    }

//                    print_r($updateData);
                    Db::getInstance()->update('damc_products',$updateData,"id=$id");
//                    echo Db::getInstance()->getMsgError();
                    $messageToShow='Updated SuccessFully!!';
                }
                else
                {
                    $messageToShow='Product Already exist please edit that product';
                }
            }
        }

        $sql = "Select * from ps_damc_products where id=$id";
//        echo $sql;
        $productDetail=Db::getInstance()->getRow($sql);

        $productDetail['amcData']=array();
        $productDetail['amcDataCount']=0;
        if($productDetail['is_amc_active']==1)
        {
            //fetch the amc product rows
            $periodSql='Select id, damc_id, period, amc_percentage from ps_damc_products_period where damc_id='.$id;
            $periodResult = Db::getInstance()->ExecuteS($periodSql);
            $productDetail['amcData']=$periodResult;
            $productDetail['amcDataCount']=count($productDetail['amcData']);
        }

        /*code for category select list*/
        $sqlcat = 'SELECT p.id_category AS categoryid,p.name AS category_name FROM ps_category_lang as p left join ps_category as pd on p.id_category = pd.id_category where pd.active = 1 and pd.level_depth = 2';
        $category ='';
        $category .= '<label> <strong>Category :</strong></label>';
        $category .= '<select name="category" id="category" onchange="getid(0)">';
        $category .= '<option value="">Select Category</option>';

        $catid = array();
        if ($results = Db::getInstance()->Executes($sqlcat))
        {
            foreach ($results as $row)
            {
                $selected='';
                if($row['categoryid']==$productDetail['categoryID'])
                    $selected='selected=selected';
                $category .= '<option value="'.$row['categoryid'].'"'.$selected.' >'.$row['category_name'].'</option>';
                $catid[] = $row['categoryid'];
            }

            $category .=  '</select>';
        }


        $catwiseproduct=array();

        if(!empty($catid))
        {
            $sqlprod = 'SELECT p.name, pc.id_category AS categoryid,p.id_product FROM ps_product_lang as p join ps_category_product as pc on p.id_product = pc.id_product join ps_product pr on pr.id_product=pc.id_product where pr.active=1 and pc.id_category in ('.implode(",", $catid).')';
            if ($res = Db::getInstance()->Executes($sqlprod))
            {
                foreach($res as $product)
                {
                    $catwiseproduct[$product['categoryid']][]=array('product_name'=>$product['name'],'id_product'=>$product['id_product']);
                }
            }
        }

        $this->context->smarty->assign(array(
            'url' => $url,
            'category' => $category,
            'finprolist' => json_encode($catwiseproduct),
            'productDetail'=>$productDetail,
            'messageToShow'=>$messageToShow
        ));

        return $this->fetchTemplate('/views/templates/back/edit.tpl');
    }


    private function updateDAMCProducts()
    {

    }

    public function deleteDAMCPeriod($periodId)
    {
        $periodId = intval($periodId);
        $sql1 = 'Delete from `ps_damc_products_period` WHERE `id`='.$periodId;
        Db::getInstance()->execute( $sql1 );
        $error = Db::getInstance()->getMsgError();
        if ($error) {
            return false;
        }
        return true;
    }
}
