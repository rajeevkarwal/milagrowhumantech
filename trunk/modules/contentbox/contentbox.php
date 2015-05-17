<?php
/**
* 2015 emotionLoop
*
* NOTE
* You are free edit and play around with the module.
* Please visit contentbox.org for more information.
*
*  @author    Miguel Costa for emotionLoop
*  @copyright emotionLoop
*  @version   1.1.1
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  http://emotionloop.com
*  http://contentbox.org/
*/

if (!defined( '_PS_VERSION_' ))
	exit;



class CONTENTBOX extends Module
{
	public function __construct()
	{
		$this->name = 'contentbox';
		$this->description = 'Place your content at the footer';
		$this->tab = 'front_office_features';
		$this->version = '1.1.1';
		$this->author = 'Hitanshu';
		$this->need_instance = 0;
		$this->ps_versions_compliancy = array('min' => '1.5', 'max' => '1.6');
		$this->bootstrap = true;
		$this->_html = '';

		parent::__construct();

		$this->displayName = $this->l('contentBox');
		$this->description = $this->l('Place your content at the footer!');

		$this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
	}

	public function install()
	{
		if (Shop::isFeatureActive())
			Shop::setContext(Shop::CONTEXT_ALL);

		if (!parent::install() || !CONTENTBOXModel::createTables())
			return false;

		return true;
	}

	public function uninstall()
	{
		if (!parent::uninstall())
		{
			return false;
		}
		return true;
	}


    public function getContent()
    {

        $this->html = '<style>
        ul li.fc_admin_tab {
    padding-top: 13px;
    border: 1px solid #CCCCCC;
    display: block;
    float: left;
    height: 29px;
    list-style: none outside none;
    margin: 0 1px 0 0;
}

ul li.fc_admin_tab_active {
    padding-top: 13px;
    border: 1px solid #CCCCCC;
    display: block;
    float: left;
    height: 29px;
    list-style: none outside none;
    margin: 0 1px 0 0;
    background-color: #49B2FF;
}
        </style>
        <h2>' . $this->displayName . '</h2>';
        $this->html .= '<link media="all" type="text/css" rel="stylesheet" href="' . $this->_path . 'css/contentbox.css"/>';
//        $this->processSubmit();

        if (Tools::getValue('saveCategory') != NULL || Tools::getValue('editCategory') != NULL) {
            $data=$this->postProcess();
            $this->html .= '<p style="color:'.$data['class'].'">'.$data['message'].'</p>';
            $_GET['fc_tab'] = 'category'; //redirect to overview after post action
        }

        $url = $_SERVER['REQUEST_URI'];
//        echo $url;
        if (strpos($url, '&fc_tab') > 0)
            $url = substr($url, 0, strpos($url, '&fc_tab'));
//        echo $url;

        $this->html .= '<ul><li ' . (Tools::getValue('fc_tab') == "category" || Tools::getValue('fc_tab') == NULL || Tools::getValue('fc_tab') == '' ? 'class="fc_admin_tab_active"' : 'class="fc_admin_tab"') . '><a style="padding:8px 8px 4px 4px;" href="' . $url . '&fc_tab=\'\'" id = "fc_categories">' . $this->l('Categories') . '</a></li>
		<li ' . (Tools::getValue('fc_tab') == "create_category" ? 'class="fc_admin_tab_active"' : 'class="fc_admin_tab"') . '><a style="padding:8px 8px 4px 4px;" href="' . $url . '&fc_tab=create_category" id = "fc_create_category">' . $this->l('Create Category') . '</a></li></ul>';

        if (Tools::getValue('fc_tab') == 'create_category')
            $this->html .= $this->displayCreateCategory();
        else if (Tools::getValue('fc_tab') == 'edit_category') {
            $categoryId = Tools::getValue('id');
            $this->html .= $this->displayCreateCategory($categoryId);
        } else if (Tools::getValue('fc_tab') == 'delete_category') {
            $categoryId = Tools::getValue('id');
            $this->html .= $this->deleteCategory($categoryId, $url);
        }  else
            $this->html .= $this->displayCategories($url);
        return $this->html;
    }

    private function displayCategories()
    {
        $editUrl=AdminController::$currentIndex.'&configure='.$this->name.'&tab_module=front_office_features&module_name='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&fc_tab=edit_category';
        $categories = CONTENTBOXModel::getAllCategoryHTML();
        $txt = '<fieldset style="margin-top:80px;"><legend>' . $this->l('Category Wise HTML') . '</legend>';
        if (count($categories) > 0) {
            $txt .= '<table border="1" class="table" style="width:100%; border-collapse:collapse;"><tr>
                <th>' . $this->l('Category Name') .
                '</th><th>' . $this->l('Content') . '</th><th>Actions</th></tr>';
            foreach ($categories as $cat) {

                if(empty($cat['name']))
                    $catName='Home';
                else
                    $catName=$cat['name'];
                $txt .= '<tr><td>' . $catName . '</td><td style="width:50%">'.$cat['content_text'].'</td><td><a href="'.$editUrl.'&id='.$cat['content_id'].'">Edit</a></td></tr>';
            }
            $txt .= '</table>';
        } else {
            $txt .= '<p>' . $this->l('No Data Found') . '</p>';
        }
        $txt .= '</fieldset>';
        return $txt;
    }

    private function displayCreateCategory($contentId='')
    {
		$fields_form[]['form'] = array(
				'tinymce' => true,
				'legend' => array(
					'title' => $this->l('Content Configuration'),
				),
				'input' => array(
					array(
						'type' => 'textarea',
						'name' => 'content_text',
						'label' => $this->l("Module's Content"),
						'cols' => 50,
						'rows' => 20,
						'class' => 'rte',
						'autoload_rte' => true,
					),
                    array(
                        'type' => 'select',
                        'name' => 'category',
                        'label' => $this->l('Use only the main language settings'),
                        'options' => array(
                            'query' => $this->getActiveCategoriesArr(),
                            'id' => 'value',
                            'name' => 'text'
                        )
                    ),
                    array(
                        'type'=>'hidden',
                        'name'=>'content_id'
                    )

				),
				'submit' => array(
					'title' => $this->l('Save'),
                    'name'=> 'saveCategory'
				),
			);

		$helper = new HelperForm();
		// Module, t    oken and currentIndex
//		$helper->module = $this;
//		$helper->name_controller = $this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name.'&tab_module=front_office_features&module_name='.$this->name;
        $helper->submit_action = 'submit'.$this->name;

		// Title and toolbar
//		$helper->title = $this->displayName;

        if(!empty($contentId))
        {
            $contentData=CONTENTBOXModel::getContent($contentId);
            $helper->fields_value['content_text'] =$contentData['content_text'] ;
            $helper->fields_value['category']=$contentData['id_category'];
            $helper->fields_value['content_id']=$contentData['content_id'];
        }

		if (isset( $this->context ) && isset( $this->context->controller ))
		{
			$this->context->controller->addJs($this->_path.'/js/contentbox.js');
			$this->context->controller->addCss($this->_path.'/css/contentbox.css');

		}
		else
		{
			Tools::addJs($this->_path.'/js/contentbox.js');
			Tools::addCss($this->_path.'/css/contentbox.css');

		}
		return $this->_html.$helper->generateForm($fields_form);
    }

    public function postProcess()
    {

        if (Tools::getValue('submitcontentbox') != NULL)
        {
            return CONTENTBOXModel::setContent(Tools::getValue('content_text'),Tools::getValue('category'),Tools::getValue('content_id'));
        }
    }

    private function getActiveCategoriesArr($contentId='')
    {
        $categoriesHtmlAlreadyExist=array();
        //$categoriesHtml = Db::getInstance()->ExecuteS('SELECT id_category FROM ' . _DB_PREFIX_ . 'contentbox');
        //$isHomeContentExist=false;
        $categoryOptionArr=array();


        //fetching list of categories
            $categoryOptionArr[]=array('value'=>0,'text'=>'Home');

        $activeCategories=Db::getInstance()->ExecuteS('select pc.id_category,pcl.name from ps_category_lang pcl join ps_category pc on pcl.id_category=pc.id_category where pc.active=1 and pc.id_parent=2');
       foreach($activeCategories as $row)
       {
           $categoryOptionArr[]=array('value'=>$row['id_category'],'text'=>$row['name']);
       }

       return $categoryOptionArr;
    }
}

/**
* The model in the same file because of the module generator
*/

class CONTENTBOXModel extends ObjectModel
{

	public static $definition = array(
		'table' => 'contentbox',
		'primary' => 'file_id',
		'multishop' => true,
		'multilang' => true,
		'fields' => array(
			'file_id' =>       array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true),
			'file_name' =>    		array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true,'size' => 255),
			'file_type' =>		    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true),
			'id_store' =>      array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true)
		),
	);

	public static function createTables()
	{
		//main table for the files
		return ( CONTENTBOXModel::createContentTable());
	}

	public static function createContentTable()
	{
		$sql = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.self::$definition['table'].'` (
			`content_id` int(10) unsigned NOT NULL auto_increment,
			`content_text` text NOT NULL,
			`id_category` int(11) Default 0,
			PRIMARY KEY (`content_id`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8';

		return Db::getInstance()->execute($sql);
	}

	public static function setContent($content_text = null, $id_category=0,$contentId)
	{
        $content_text = pSQL( $content_text, true );
        $id_category=(int)$id_category;
        if(!empty($contentId))
        {
            $sql='Select * from '._DB_PREFIX_.self::$definition['table'].' where id_category='.$id_category.' and content_id!='.$contentId;
            $contentRow=Db::getInstance()->getRow($sql);

            if(empty($contentRow))
            {
                $updateSql='Update '._DB_PREFIX_.self::$definition['table'].' set content_text="'.$content_text.'" where content_id='.$contentId;
                Db::getInstance()->execute($updateSql);
                return array('message'=>'Content Updated successfully','class'=>'green');
            }
            else
            {
                return array('message'=>'Content already exist for selected category','class'=>'red');
            }
        }
        else
        {
            $sql='Select * from '._DB_PREFIX_.self::$definition['table'].' where id_category='.$id_category;
            $contentRow=Db::getInstance()->getRow($sql);
            if(!empty($contentRow))
            {

                return array('message'=>'Content already exist for selected category','class'=>'red');
            }
            else
            {
                $sql = 'INSERT INTO `'._DB_PREFIX_.self::$definition['table'].'` (`content_text`,`id_category`)
					VALUES ("'.$content_text.'","'.$id_category.'")
				';
                //echo $sql;
                Db::getInstance()->execute( $sql );
                return array('message'=>'Content Updated successfully','class'=>'green');
            }

        }
	}

	public static function getContent($id)
	{
		$sql = 'SELECT * FROM '._DB_PREFIX_.self::$definition['table'].' WHERE `content_id` = "'.(int)$id.'"';
		return Db::getInstance()->getRow($sql);
	}

    public static function getAllCategoryHTML()
    {
        $categoriesHtml = Db::getInstance()->ExecuteS('SELECT cb.content_text,cb.content_id,pcl.name FROM ' . _DB_PREFIX_ . 'contentbox cb left join ps_category_lang pcl on pcl.id_category=cb.id_category left join ps_category pc on pcl.id_category=pc.id_category');
        return $categoriesHtml;
    }
}