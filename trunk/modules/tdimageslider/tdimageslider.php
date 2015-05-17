<?php
if (!defined('_CAN_LOAD_FILES_'))
    exit;

include_once(dirname(__FILE__) . '/tdimagesliderModel.php');
include_once(dirname(__FILE__) . '/tdimagesliderClass.php');

class TDImageSlider extends Module {
    private $_html;
    private $_display;
    
    public function __construct() {
        $this->name = 'tdimageslider';
        $this->tab = 'front_office_features';
        $this->version = '1.1.0';
        $this->author = 'ThemesDeveloper';
        $this->need_instance = 0;
        parent::__construct();
        $this->displayName = $this->l('ThemesDeveloper  Images Slider');
        $this->description = $this->l('Show Images Slider on Home page.');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall your details ?');
        $this->secure_key = Tools::encrypt($this->name);
    }

    public function install() {
        /* Adds Module */
        if (parent::install() && $this->registerHook('home') && $this->registerHook('header')) {
            /* Install tables */
            $res = TdImagesliderModel::createTables();
            return $res;
        }
        return false;
    }

    public function uninstall() {
        /* Deletes Module */
        if (parent::uninstall()) {
            /* Deletes tables */
            $res = TdImagesliderModel::DropTables();
            return $res;
        }
        return false;
    }

    public function getContent() {
        $this->_html = '';


        if (Tools::isSubmit('tdSubmitValue') || Tools::isSubmit('deleteSlider')) {
            if ($this->_postValidation())
                $this->_insertSlider();
            $this->_displaySlider();
        }
        elseif (Tools::isSubmit('addNewSlider') || (Tools::isSubmit('id_tdimageslider')))
            $this->_displayForm();
        else
            $this->_displaySlider();

        return $this->_html;
    }

    private function _insertSlider() {
        global $currentIndex;
        $errors = array();
        if (Tools::isSubmit('tdSubmitValue')) {
            $languages = Language::getLanguages(false);

            if (Tools::isSubmit('addNewSlider')) {
                $position = Db::getInstance()->getValue('
			SELECT COUNT(*) 
			FROM `' . _DB_PREFIX_ . 'tdimageslider`');




                Db::getInstance()->Execute('
            INSERT INTO `' . _DB_PREFIX_ . 'tdimageslider` (`image_link`,`active`,`position`,`new_page`) 
            VALUES("' . Tools::getValue('td_link') . '", ' . (int) Tools::getValue('td_active_slide') . ',' . (int) $position . ',' . (int) Tools::getValue('td_new_page') . ')');

                $id_tdimageslider = Db::getInstance()->Insert_ID();
                foreach ($languages as $language) {
                    $name = $_FILES['td_image_' . $language['id_lang']]['name'];
                    $image_url = TD_IMAGESSLIDER_IMAGE_URL . $name;

                    $path = TD_IMAGESSLIDER_MODULE_IMAGE_DIR . $name;
                    $tmpname = $_FILES['td_image_' . $language['id_lang']]['tmp_name'];
                    move_uploaded_file($tmpname, $path);


                    Db::getInstance()->Execute('
                INSERT INTO `' . _DB_PREFIX_ . 'tdimageslider_lang` (`id_tdimageslider`, `id_lang`, `image_title`, `image_url`) 
                VALUES(' . (int) $id_tdimageslider . ', ' . (int) $language['id_lang'] . ', 
                "' . pSQL(Tools::getValue('td_title_' . $language['id_lang'])) . '", 
                 "' . $image_url . '")');
                }
            } elseif (Tools::isSubmit('updateSlider')) {

                $tdsliderid = Tools::getvalue('id_tdimageslider');



                Db::getInstance()->Execute('
                UPDATE `' . _DB_PREFIX_ . 'tdimageslider`
                SET `image_link` = "' . Tools::getvalue('td_link') . '",
                `active` = ' . (int) Tools::getValue('td_active_slide') . ',
                `new_page` = ' . (int) Tools::getValue('td_new_page') . '
                WHERE `id_tdimageslider` = ' . (int) ($tdsliderid));

                $languages = Language::getLanguages(false);
                foreach ($languages as $language) {


                    if ($_FILES['td_image_' . $language['id_lang']]['name']):

                        $name = $_FILES['td_image_' . $language['id_lang']]['name'];
                        $image_url = TD_IMAGESSLIDER_IMAGE_URL . $name;

                        $path = TD_IMAGESSLIDER_MODULE_IMAGE_DIR . $name;
                        $tmpname = $_FILES['td_image_' . $language['id_lang']]['tmp_name'];
                        move_uploaded_file($tmpname, $path);

                    else:
                        $image_url = Tools::getvalue('image_old_link_' . $language['id_lang']);
                    endif;


                    Db::getInstance()->Execute('
                            UPDATE `' . _DB_PREFIX_ . 'tdimageslider_lang` 
                            SET `image_title` = "' . pSQL(Tools::getValue('td_title_' . $language['id_lang'])) . '",                    
                            `image_url` = "' . $image_url . '"
                            WHERE `id_tdimageslider` = ' . (int) $tdsliderid . '  AND `id_lang`= ' . (int) $language['id_lang']);
                }
            }
        }
        elseif (Tools::isSubmit('deleteSlider') AND Tools::getValue('id_tdimageslider')) {
            Db::getInstance()->Execute('
                DELETE FROM `' . _DB_PREFIX_ . 'tdimageslider`
                WHERE `id_tdimageslider` = ' . (int) (Tools::getValue('id_tdimageslider')));

            Db::getInstance()->Execute('
				DELETE FROM `' . _DB_PREFIX_ . 'tdimageslider_lang` 
				WHERE `id_tdimageslider` = ' . (int) (Tools::getValue('id_tdimageslider')));
        }
        if (count($errors))
            $this->_html .= $this->displayError(implode('<br />', $errors));
        elseif (Tools::isSubmit('tdSubmitValue') && Tools::getValue('id_tdimageslider'))
            $this->_html .= $this->displayConfirmation($this->l('Advertise Update Successfully'));
        elseif (Tools::isSubmit('tdSubmitValue'))
            $this->_html .= $this->displayConfirmation($this->l('Advertise added Successfully'));
        elseif (Tools::isSubmit('deleteSlider'))
            $this->_html .= $this->displayConfirmation($this->l('Deletion successful'));
    }

    private function _postValidation() {
        $errors = array();
        if (Tools::isSubmit('tdSubmitValue')) {
            $languages = Language::getLanguages(false);

            if (!Validate::isUrl(Tools::getValue('td_link')))
                $errors[] = $this->l('Invalid Image URL ');
        }
        elseif (Tools::isSubmit('deleteSlider') AND !Validate::isInt(Tools::getValue('id_tdimageslider')))
            $errors[] = $this->l('Invalid ID');

        if (sizeof($errors)) {
            $this->_html .= $this->displayError(implode('<br />', $errors));
            return false;
        }
        return true;
    }

    private function _displayForm() {

        global $currentIndex, $cookie;
        $updatevalue = NULL;
        if (Tools::isSubmit('updateSlider') AND Tools::getValue('id_tdimageslider'))
            $updatevalue = TdImagesliderModel::getSliderByID((int) Tools::getValue('id_tdimageslider'));
//print_r($updatevalue);
        /* Languages preliminaries */
        $defaultLanguage = (int) (Configuration::get('PS_LANG_DEFAULT'));
        $languages = Language::getLanguages(false);
        $iso = Language::getIsoById((int) ($cookie->id_lang));
        $divLangName = 'title¤image¤up_image';



        /* Begin fieldset slides */
        $this->_html .= '
		<fieldset>
			<legend><img src="' . _PS_BASE_URL_ . __PS_BASE_URI__ . 'modules/' . $this->name . '/logo.gif" alt="" /> ' . $this->l('About Slider') . '</legend>
			';

        $this->_html.= '<form method="post" action="' . Tools::safeOutput($_SERVER['REQUEST_URI']) . '" enctype="multipart/form-data">
      <fieldset>
        <legend>' . $this->l('Add A New Slider') . '</legend>';


        $this->_html .= '
		<label for="active_on">' . $this->l('Active:') . '</label>
		<div class="margin-form">
			<img src="../img/admin/enabled.gif" alt="Yes" title="Yes" />
			<input type="radio" name="td_active_slide" id="active_on" ' . ((isset($updatevalue[0]['active']) && $updatevalue[0]['active'] == 0) ? '' : 'checked="checked" ') . ' value="1" />
			<label class="t" for="active_on">' . $this->l('Yes') . '</label>
			<img src="../img/admin/disabled.gif" alt="No" title="No" style="margin-left: 10px;" />
			<input type="radio" name="td_active_slide" id="active_off" ' . ((isset($updatevalue[0]['active']) && $updatevalue[0]['active'] == 0) ? 'checked="checked" ' : '') . ' value="0" />
			<label class="t" for="active_off">' . $this->l('No') . '</label>
		</div>
 <label>' . $this->l('Target New Page') . '</label>
        <div class="margin-form">
			<img src="../img/admin/enabled.gif" alt="Yes" title="Yes" />
			<input type="radio" name="td_new_page" id="newpage_on" ' . (($updatevalue[0]['new_page'] == 0) ? '' : 'checked="checked" ') . ' value="1" />
			<label class="t" for="newpage_on">' . $this->l('Yes') . '</label>
			<img src="../img/admin/disabled.gif" alt="No" title="No" style="margin-left: 10px;" />
			<input type="radio" name="td_new_page" id="newpage_off" ' . (($updatevalue[0]['new_page'] == 0) ? 'checked="checked" ' : '') . ' value="0" />
			<label class="t" for="newpage_off">' . $this->l('No') . '</label>
		</div>       
';

        $this->_html .='<label>' . $this->l('Title') . '</label>
	<div class="margin-form">';
        foreach ($languages as $language) {
            $this->_html.= '
            <div id="title_' . $language['id_lang'] . '" style="display: ' . ($language['id_lang'] == $defaultLanguage ? 'block' : 'none') . ';float: left;">
                    <input type="text" name="td_title_' . $language['id_lang'] . '" id="td_title_' . $language['id_lang'] . '" size="64"  value="' . (Tools::getValue('td_title_' . $language['id_lang']) ? Tools::getValue('td_title_' . $language['id_lang']) : (isset($updatevalue['image_title'][$language['id_lang']]) ? $updatevalue['image_title'][$language['id_lang']] : '')) . '"/>
            </div>';
        }
        $this->_html .=$this->displayFlags($languages, $defaultLanguage, $divLangName, 'title', true);
        $this->_html .='<div class="clear"></div>
            </div>';
        $this->_html.='<label>' . $this->l('Link') . '</label>
	<div class="margin-form">
          <div class="option_control">
                <input type="text" id="td_link" class="upload_option" size="64" name="td_link" value="' . $updatevalue[0]['image_link'] . '">
            </div>';
        $this->_html .='<div class="clear"></div>
            </div>
	';
        if (Tools::isSubmit('updateSlider') AND Tools::getValue('id_tdimageslider')) {
            $this->_html.= '<div class="margin-form">';
            foreach ($languages as $language) {
                $this->_html.= '<div id="image_' . $language['id_lang'] . '" style="display: ' . ($language['id_lang'] == $defaultLanguage ? 'block' : 'none') . ';float: left;">
                    <input type="hidden" name="image_old_link_' . $language['id_lang'] . '" value="' . $updatevalue['image_url'][$language['id_lang']] . '" />
                    <img src="' . __PS_BASE_URI__ . $updatevalue['image_url'][$language['id_lang']] . '" width=60 height=60></div> ';
            }
            $this->_html .= $this->displayFlags($languages, $defaultLanguage, $divLangName, 'image', true);
            $this->_html.= '</div>';
        }
        $this->_html .='<div class="clear"></div>';
        $this->_html.= '<label>' . $this->l('Upload Image') . '</label>';

        foreach ($languages as $language) {
            $this->_html .= '
                    <div id="up_image_' . $language['id_lang'] . '" style="display: ' . ($language['id_lang'] == $defaultLanguage ? 'block' : 'none') . ';float: left;">
                            <input type="file" name="td_image_' . $language['id_lang'] . '" />
                    </div>';
        }
        $this->_html .= $this->displayFlags($languages, $defaultLanguage, $divLangName, 'up_image', true);

        $this->_html.= '
               <div class="clear"></div><br/>
        <div class="clear center">
             
            <input type="submit" class="button" name="tdSubmitValue" value="' . $this->l('Save') . '" />
            <a class="button" style="position:relative; padding:2px 3px 2px 3px; top:1px" href="' . $currentIndex . '&configure=' . $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules') . '">' . $this->l('Cancel') . '</a>
 
        </div>
      </fieldset>
    </form>
   
';
    }

    private function _displaySlider() {

        global $currentIndex, $cookie;

        $slider = TdImagesliderModel::getAllSlider();

        $this->_html .= '<script type="text/javascript" src="' . __PS_BASE_URI__ . 'js/jquery/plugins/jquery.tablednd.js"></script>
<script type="text/javascript" src="' . _PS_BASE_URL_ . __PS_BASE_URI__ . 'modules/' . $this->name . '/' . $this->name . '.js"></script>
<script type="text/javascript">TDImageSlider(\'' . $this->secure_key . '\');</script>';

        $this->_html .= '<p><a href="' . $currentIndex . '&configure=' . $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules') . '&addNewSlider"><img src="' . _PS_ADMIN_IMG_ . 'add.gif" alt="" /> ' . $this->l('Add a new Slider') . '</a></p>';
        if ($slider):
            $this->_html.= '<table width="100%" id="sliderdata" class="table" cellspacing="0" cellpadding="0">
			<thead>
			<tr class="nodrag nodrop">
				<th width="5%">' . $this->l('ID') . '</th>
                                <th width="20%">' . $this->l('Images') . '</th>
				<th width="25%" >' . $this->l('Title') . '</th>
				<th width="20%" >' . $this->l('Link') . '</th>
				<th width="10%" >' . $this->l('Active') . '</th>
                                <th width="10%">' . $this->l('Position') . '</th>
				<th width="10%">' . $this->l('Actions') . '</th>
			</tr>
			</thead>
			<tbody>';
        endif;
        $i = 1;
        $irow = 0;
        foreach ($slider as $tdsliderdata):

            $this->_html .= '<tr id="tr_0_' . $tdsliderdata['id_tdimageslider'] . '_' . $tdsliderdata['position'] . '" ' . ($irow++ % 2 ? 'class="alt_row"' : '') . '>
                             <td>' . $tdsliderdata['id_tdimageslider'] . '</td>
                                 <td><img src="' . __PS_BASE_URI__ . $tdsliderdata['image_url'] . '" width=180 height=120></td>
                             <td>' . $tdsliderdata['image_title'] . '</td>
                             <td>' . $tdsliderdata['image_link'] . '</td>
                             <td>';
            if ($tdsliderdata['active'] == 1) :

                $this->_html .= '<img title="Enabled" alt="Enabled" src="../img/admin/enabled.gif">';
            else :
                $this->_html .= '<img title="Disabled" alt="Disabled" src="../img/admin/disabled.gif">';
            endif;
            $this->_html .= '</td> 
                       
                            <td class="center pointer dragHandle">
                                    <a' . (($tdsliderdata['position'] == (sizeof($tdsliderdata) - 1) OR sizeof($tdsliderdata) == 1) ? ' style="display: none;"' : '') . ' href="' . $currentIndex . '&configure=tdimageslider&id_tdimageslider=' . $tdsliderdata['id_tdimageslider'] . '&token=' . Tools::getAdminTokenLite('AdminModules') . '">
                                    <img src="../img/admin/down.gif" alt="' . $this->l('Down') . '" title="' . $this->l('Down') . '" /></a>
                                    <a' . ($tdsliderdata['position'] == 0 ? ' style="display: none;"' : '') . ' href="' . $currentIndex . '&configure=tdimageslider&id_tdimageslider=' . $tdsliderdata['id_tdimageslider'] . '&token=' . Tools::getAdminTokenLite('AdminModules') . '">
                                    <img src="../img/admin/up.gif" alt="' . $this->l('Up') . '" title="' . $this->l('Up') . '" /></a>
                            </td>
                              <td width="10%" class="center">
                            
                                        <a href="' . $currentIndex . '&configure=' . $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules') . '&updateSlider&id_tdimageslider=' . (int) ($tdsliderdata['id_tdimageslider']) . '" title="' . $this->l('Edit') . '"><img src="' . _PS_ADMIN_IMG_ . 'edit.gif" alt="" /></a> 
                                        <a href="' . $currentIndex . '&configure=' . $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules') . '&deleteSlider&id_tdimageslider=' . (int) ($tdsliderdata['id_tdimageslider']) . '" title="' . $this->l('Delete') . '"><img src="' . _PS_ADMIN_IMG_ . 'delete.gif" alt="" /></a>
					
                                </td>
                        </tr>';
            $i++;
        endforeach;



        $this->_html .= '</table>';
    }

    function hookHome($params) {
        global $smarty;
            $tdslider = Db::getInstance()->ExecuteS('
            SELECT td.`id_tdimageslider`, td.`image_link`, td.`active`, td.`position`, td.`new_page`,td1.image_title, td1.`image_url`
            FROM `' . _DB_PREFIX_ . 'tdimageslider` td
            INNER JOIN `' . _DB_PREFIX_ . 'tdimageslider_lang` td1 ON (td.`id_tdimageslider` = td1.`id_tdimageslider`)
            WHERE td1.`id_lang` = ' . (int) $params['cookie']->id_lang . '
            ORDER BY td.`position`');
            $data = array();
            foreach ($tdslider as $slider):
                if ($slider['active'])
                    $data[] = $slider;
            endforeach;

            $smarty->assign(array(
                'default_lang' => (int) $params['cookie']->id_lang,
                'id_lang' => (int) $params['cookie']->id_lang,
                'tdimageslider' => $data,
                'base_url' => __PS_BASE_URI__
            ));
       
            return $this->display(__FILE__, 'tdimageslider.tpl');

    }

}