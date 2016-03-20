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

// Include Models
//include_once(dirname(__FILE__) . '/ProductComment.php');
//include_once(dirname(__FILE__) . '/ProductCommentCriterion.php');

class Tabsreorder extends Module
{

    public function __construct()
    {
        $this->name = 'tabsreorder';
        $this->tab = 'front_office_features';
        $this->version = '2.3';
        $this->author = 'PrestaShop';
        $this->need_instance = 0;
        $this->secure_key = Tools::encrypt($this->name);

        parent::__construct();

        $this->displayName = $this->l('Tabs Reorder');
        $this->description = $this->l('Tabs Reorder');
    }

    public function install()
    {
        if (parent::install() == false ||
            !$this->registerHook('productTab')
        )
            return false;
        return true;
    }

    public function uninstall()
    {
        if (!parent::uninstall() ||
            !$this->unregisterHook('productTab')
        )
            return false;
        return true;
    }

    public function hookProductTab($params)
    {


        $tabHtml='<li class="spec"><a href="#idTabFeatures" id="more_info_tab_features_by_category">Specifications</a></li>

<li><a id="more_info_tab_more_info" href="#idTab1">Features</a></li>';

        $id_product = Tools::getValue('id_product');

        $tabs = PETTabContentClass::getTabsByProduct((int)($id_product), (int)($this->cookie->id_lang));
//        print_r($tabs);
        foreach($tabs as $tabItem)
        {
            if(!in_array($tabItem['name_tab'],array('Advantages','Videos')))
        $tabHtml.='<li class="hidden-phone hidden-tablet" ><a id="product_extra_tab_'.$tabItem['id_tab'].'" href="#idTab'.($tabItem['id_tab']+20).'">'.$tabItem['name_tab'].'</a></li>';
        }

        return $tabHtml;
    }


}



