<?php

if (!defined('_PS_VERSION_'))
    exit;

class PSModThemeOptionPanel extends Module {

    public $sccthemename = "metro";
    public $_html, $pattern, $_fields, $_tabs, $Defaults;
    public $sccoptions = array();

    public function __construct() {
        $this->name = 'psmodthemeoptionpanel';
        $this->tab = 'front_office_features';
        $this->version = '1.1.0';
        $this->author = 'Any-Themes';
        $this->need_instance = 0;
        parent::__construct();
        $this->displayName = $this->l('Theme Options panel');
        $this->description = $this->l('MetroShop Themes Option Panel By Any-Themes');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall your details ?');
        $this->secure_key = Tools::encrypt($this->name);

        $this->getAllPatern();
        $this->sccThemeOption();
    }

    public function install() {
        if (!parent::install() || !$this->registerHook('header') || !$this->registerHook('top') || !$this->registerHook('home') || !$this->registerHook('leftColumn') ||
                !$this->registerHook('rightColumn') || !$this->installData() || !$this->registerHook('footer')
        )
            return false;

        return true;
    }

    public function installData() {
        $sccoptions = $this->sccoptions;
        foreach ($sccoptions as $option_result):
            $stdvalue = $option_result['std'];
            if (isset($stdvalue)) :
                if (is_array($stdvalue)) {
                    foreach ($stdvalue as $key => $output_value) {
                        Configuration::updateValue($option_result['id'] . "_" . $key, htmlspecialchars($output_value));
                    }
                } else {
                    $languages = Language::getLanguages(false);
                    if (isset($option_result['lang']) && $option_result['lang'] == true) {
                        foreach ($languages as $lang) {
                            Configuration::updateValue($option_result['id'] . '_' . $lang['id_lang'], htmlspecialchars($option_result['std']));
                        }
                    } else {
                        Configuration::updateValue($option_result['id'], htmlspecialchars($option_result['std']));
                    }
                }
            endif;

        endforeach;
        return true;
    }

    public function sccOptionDataDelete() {
        $sccoptions = $this->sccoptions;
        foreach ($sccoptions as $option_result):
            $stdvalue = $option_result['std'];
            if (isset($stdvalue)) :
                if (is_array($stdvalue)) {
                    foreach ($stdvalue as $key => $output_value) {
                        Configuration::deleteByName($option_result['id'] . '_' . $key);
                    }
                } else {
                    $languages = Language::getLanguages(false);
                    if (isset($option_result['lang']) && $option_result['lang'] == true) {
                        foreach ($languages as $lang) {
                            Configuration::deleteByName($option_result['id'] . '_' . $lang['id_lang']);
                        }
                    } else {
                        Configuration::deleteByName($option_result['id']);
                    }
                }
            endif;

        endforeach;
    }

    public function uninstall() {
        if (!parent::uninstall())
            return false;
        $this->sccOptionDataDelete();
        return true;
    }

    public function getContent() {
        $this->_html = '';
        global $cookie;
        require_once '../config/config.inc.php';
        require_once '../init.php';
        $this->_includeAdminFile();
        $this->_sccOptionForm();
        return $this->_html;
    }

    public function sccThemeOption() {
        $languages = Language::getLanguages(false);
        $pattern = $this->pattern;
        $optionimageurl = __PS_BASE_URI__ . 'modules/psmodthemeoptionpanel/admin/images/';
        $logourl = __PS_BASE_URI__ . 'modules/psmodthemeoptionpanel/upload/logo.png';
        $scc_options = array();

        /* Start Theme Option **********************************  */
        $scc_options[] = array("name" => 'Theme settings',
            "type" => "heading");


        $scc_options[] = array("name" => "Body Font Style",
            "desc" => "You can change body font style.",
            "id" => $this->sccthemename . "_shop_body_font",
            "std" => array('face' => 'Source Sans Pro'),
            "section" => "google",
            "type" => "typography");
        $scc_options[] = array("name" => 'Left Sidebar',
            "desc" => 'You can enable or disable left sidebar',
            "id" => $this->sccthemename . '_withleft_sidebar',
            "std" => "enable",
            "button_id" => array(3, 4),
            "type" => "iphonebutton");
        $scc_options[] = array("name" => 'Disable slider mini advertise images',
            "desc" => 'You can enable or disable slider mini advertise images',
            "id" => $this->sccthemename . '_mini_advertise_images',
            "std" => "enable",
            "button_id" => array(9, 10),
            "type" => "iphonebutton");

        $scc_options[] = array("name" => 'Responsive layout',
            "desc" => 'You can enable or disable Responsive support for theme',
            "id" => $this->sccthemename . '_respinsive_support',
            "std" => "enable",
            "button_id" => array(7, 8),
            "type" => "iphonebutton");
            $scc_options[] = array("name" => 'Category Page Subcategory',
            "desc" => 'You can enable or disable Subcategory on Category page',
            "id" => $this->sccthemename . '_subcategory',
            "std" => "disable",
            "button_id" => array(11, 12),
            "type" => "iphonebutton");
        $scc_options[] = array("name" => 'Sale & New badges style',
            "desc" => 'You can change to sell and new icon button style.',
            "id" => $this->sccthemename . '_sell_newicon',
            "std" => "default",
            "options" => array('circle' => 'Circle', 'rounded_rectangle' => 'Rounded Rectangle', 'default' => 'Rectangle'),
            "type" => "select");

        $scc_options[] = array("name" => "Category Page view mode",
            "desc" => "If you want to change catalog page default view style.",
            "id" => $this->sccthemename . "_product_view_style",
            "std" => "grid",
            "type" => "images",
            "options" => array(
                'list' => $optionimageurl . 'list.png',
                'grid' => $optionimageurl . 'grid.png'
            )
        );



        /* Start Social Media **********************************  */



        $scc_options[] = array("name" => 'Colors and backgrounds',
            "type" => "heading");

        $scc_options[] = array("name" => 'Main Color',
            "desc" => 'Default color:#008C8D. If you want to change this color.',
            "id" => $this->sccthemename . '_main_color',
            "std" => "#008C8D",
            "type" => "color");
        $scc_options[] = array("name" => 'Second Color',
            "desc" => 'Default color: #58BAE9. If you want to change this color.',
            "id" => $this->sccthemename . '_second_color',
            "std" => "#58BAE9",
            "type" => "color");
        $scc_options[] = array("name" => 'Button Background Color',
            "desc" => 'Default color:#6CBE42. If you want to change this color.',
            "id" => $this->sccthemename . '_buttonbg_color',
            "std" => "#6CBE42",
            "type" => "color");
        $scc_options[] = array("name" => 'Item Box Color',
            "desc" => 'Default color:#414E5B. If you want to change this color.',
            "id" => $this->sccthemename . '_itembox_color',
            "std" => "#414E5B",
            "type" => "color");
        $scc_options[] = array("name" => 'Body Background Color',
            "desc" => 'Default color: #F7F7F9. If you want to change this color.',
            "id" => $this->sccthemename . '_bodybg_color',
            "std" => "#F7F7F9",
            "type" => "color");
         $scc_options[] = array("name" => 'Body font Color',
            "desc" => 'Default color: #151617. If you want to change this color.',
            "id" => $this->sccthemename . '_body_fonttext_color',
            "std" => "#151617",
            "type" => "color");
        $scc_options[] = array("name" => 'Background Images',
            "desc" => 'If you want to change main body background color.',
            "id" => $this->sccthemename . '_bgimages',
            "std" => "disable",
            "button_id" => array(1, 2),
            "type" => "iphonebutton");

        $scc_options[] = array("name" => 'Upload Custom Pattern',
            "desc" => 'You can upload your custom pattern from here.',
            "id" => $this->sccthemename . "_custom_pattern",
            "std" => '',
            "type" => "upload");
        $scc_options[] = array("name" => "Background Patterns",
            "id" => $this->sccthemename . "_bg_pattern",
            "std" => "",
            "type" => "tiles",
            "options" => $pattern,
        );




        /* Start Social Media **********************************  */
        $scc_options[] = array("name" => 'Social Media',
            "type" => "heading");

       $scc_options[] = array("name" => 'Facebook title',
        "desc" => "Show facebook titel page on footer.",
        "id" => $this->sccthemename . "_facebook_titel",
        "lang" => true,
        "std" =>'Facebook',
        "type" => "text");
        $scc_options[] = array("name" => 'Facebook Like Box',
            "type" => "head_block");
        $scc_options[] = array("sub_name" => 'Facebook Page URL',
            "desc" => "Enter your facebook page url.",
            "id" => $this->sccthemename . "_facebook_page_url",
            "std" => "http://www.facebook.com/pages/dx/115403961948855",
            "type" => "block_text");
        $scc_options[] = array("sub_name" => 'Facebook Page ID',
            "desc" => "Enter your facebook Fun page id.",
            "id" => $this->sccthemename . "_facebook_page_id",
            "std" => "",
            "type" => "block_text");
        $scc_options[] = array("name" => 'Twitter title',
      "desc" => "Show twitter titel page on footer.",
      "id" => $this->sccthemename . "_twitter_titel",
      "lang" => true,
      "std" =>'Twitter',
      "type" => "text");
        $scc_options[] = array("name" => 'Twitter Feed Box',
            "type" => "head_block");
        $scc_options[] = array("sub_name" => 'Twitter ID',
            "desc" => "Enter your Twitter id.",
            "id" => $this->sccthemename . "_twitter_id",
            "std" => "dedalx",
            "type" => "text");
        $scc_options[] = array("sub_name" => 'Tweets to show',
            "desc" => "Tweets count",
            "id" => $this->sccthemename . "_tweet_count",
            "std" => "3",
            "type" => "block_text");
        $scc_options[] = array("sub_name" => 'Consumer key',
            "desc" => "Enter your Consumer key.",
            "id" => $this->sccthemename . "_consumer_key",
            "std" => "123456789",
            "type" => "block_text");
             $scc_options[] = array("sub_name" => 'Consumer secret',
            "desc" => "Enter your Consumer secret.",
            "id" => $this->sccthemename . "_consumer_secret",
            "std" => "123456789",
            "type" => "block_text");
             
                  $scc_options[] = array("sub_name" => 'Access token',
            "desc" => "Enter your Access token.",
            "id" => $this->sccthemename . "_consumer_token",
            "std" => "123456789",
            "type" => "block_text");
             
              $scc_options[] = array("sub_name" => 'Access token secret',
            "desc" => "Enter your Access token secret.",
            "id" => $this->sccthemename . "_consumer_tsecret",
            "std" => "123456789",
            "type" => "block_text");
        
              

        $scc_options[] = array("name" => 'Social Footer Link',
            "type" => "head_block");
        $scc_options[] = array("sub_name" => 'Facebook URL',
            "desc" => "Enter your facebook url.",
            "id" => $this->sccthemename . "_facebook_url",
            "std" => "http://yourlink.com",
            "type" => "block_text");

        $scc_options[] = array("sub_name" => 'Twitter URL',
            "desc" => "Enter your Twitter url.",
            "id" => $this->sccthemename . "_twitter_url",
            "std" => "http://yourlink.com",
            "type" => "block_text");
        $scc_options[] = array("sub_name" => 'Google URL',
            "desc" => "Enter your google url.",
            "id" => $this->sccthemename . "_google_url",
            "std" => "http://yourlink.com",
            "type" => "block_text");

        $scc_options[] = array("sub_name" => 'Pinterest URL',
            "desc" => "Enter your pinterest url.",
            "id" => $this->sccthemename . "_pinterest_url",
            "std" => "http://yourlink.com",
            "type" => "block_text");
        $scc_options[] = array("sub_name" => 'RSS URL',
            "desc" => "Enter your Rss url.",
            "id" => $this->sccthemename . "_rss_url",
            "std" => "http://yourlink.com",
            "type" => "block_text");
        $scc_options[] = array("sub_name" => 'Skype URL',
            "desc" => "Enter your skype url.",
            "id" => $this->sccthemename . "_skype_url",
            "std" => "http://yourlink.com",
            "type" => "block_text");


        /* Start Theme Info **********************************  */
        $scc_options[] = array("name" => 'Main Theme Blocks',
            "type" => "heading");
        $scc_options[] = array("name" => 'Homepage header support number',
            "desc" => "You can use this number on your store home page.",
            "id" => $this->sccthemename . "_support_number",
            "lang" => true,
            "std" => '
                    <p><strong>8(802)234-5678</strong> <br /> <span>Call us Monday - Saturday: 8:30 am - 6:00 pm</span></p>
               ',
            "type" => "textarea");
        $scc_options[] = array("name" => 'Homepage about block',
            "desc" => "You can use this text on your store home page.",
            "id" => $this->sccthemename . "_about_us",
            "lang" => true,
            "std" => '
                    <div class="text">
                    <h1>About MetroShop</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit...</p>
                    <p>This about text can be edited from theme admin panel!</p>
                </div>
               ',
            "type" => "textarea");

        $scc_options[] = array("name" => 'Custom Footer contact column',
            "desc" => "You can use this text box for showing contact detail on footer.",
            "id" => $this->sccthemename . "_address",
            "lang" => true,
            "std" => ' 
                <div class="social">
                    <h1>Contact us</h1>
                    <div class="contact">
                        <div class="phone"><strong>Phone:</strong> 8(802)234-5678, 8(803)234-5678</div>
                        <div class="fax"><strong>Fax:</strong> 8(800)234-5678</div>
                        <div class="email"><a href="mailto:support@shop.com">support@shop.com</a></div>
                        <div class="email"><a href="mailto:sales@shop.com">sales@shop.com</a></div>
                    </div>
                </div>',
            "type" => "textarea");

        $scc_options[] = array("name" => 'Footer links',
            "desc" => "You can put your own links on footer.",
            "id" => $this->sccthemename . "_aditional_links",
            "lang" => true,
            "std" => ' <ul class="links">
                    <li class="first" ><a href="http://yourlink.com" title="Site Map" >Site Map</a></li>
                    <li ><a href="http://yourlink.com" title="Search Terms" >Search Terms</a></li>
                    <li ><a href="http://yourlink.com" title="Advanced Search" >Advanced Search</a></li>
                    <li ><a href="http://yourlink.com" title="Orders and Returns" >Orders and Returns</a></li>
                    <li class=" last" ><a href="index.php?controller=contact" title="Contact Us" >Contact Us</a></li>
                </ul>',
            "type" => "textarea");

        $scc_options[] = array("name" => 'Copyright Information',
            "desc" => "You can use this text box for showing copyright message on footer.",
            "id" => $this->sccthemename . "_copyright",
            "std" => '&copy; 2013 Prestashop Demo Store. All Rights Reserved.',
            "type" => "text");

        $scc_options[] = array("name" => 'Tracking Code',
            "desc" => 'You can use Google Analytics or other tracking code in this text box.',
            "id" => $this->sccthemename . "_tracking_code",
            "std" => "",
            "type" => "textarea");

        /* custome html block */

        $scc_options[] = array("name" => 'Custom Theme Blocks',
            "type" => "heading");
        $scc_options[] = array("name" => 'Custom menu block',
            "desc" => "Show custom block with any HTML as main menu item.",
            "id" => $this->sccthemename . "_header_menu_customhtml",
            "lang" => true,
            "std" => '
            <a href="#" class="level-top"><span>Custom item</span></a>
        <ul>
        <div class="custom_menu_item">
            <div class="nav-demo-block right">
            <h3 style="margin-top: -5px;">Custom HTML - add from admin panel</h3>
            <img alt="" src="'. __PS_BASE_URI__ . 'themes/metroshop/img/metroshop/banner185.png" style="float: left; margin: 0 20px 10px 0;">
            Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam.
            </div>
        </div>
        </ul>',
            "type" => "textarea");

        $scc_options[] = array("name" => 'Left Sidebar Block',
            "desc" => "Custom HTML design to show  on left sidebar.",
            "id" => $this->sccthemename . "_left_sidebar_customhtml",
            "lang" => true,
            "std" => ' <div class="block-title">
                    <strong><span>Custom block</span></strong>
                </div>
                <div class="block-content">
                    <div class="category-block-2-content" style="border-bottom: 1px solid #efefef;">
                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                    </div>
                    <div class="category-block-2-txt" style="margin-top: 10px;">
                        <p>You can add and change this block from admin panel.</p>
                    </div>  
                </div>',
            "type" => "textarea");
        $scc_options[] = array("name" => 'Product Advertise Block',
            "desc" => 'Custom HTML design to show on product page.',
            "id" => $this->sccthemename . "_product_page_customhtml",
            "lang" => true,
            "std" => '<div class="left_banner" style="margin-bottom: 15px; background: none;"><a href="#"><img src="'. __PS_BASE_URI__ .'themes/metroshop/img/metroshop/banner145.png" alt="" /></a></div>
                    <div class="left_banner" style="margin-bottom: 15px; background: none;"><a href="#"><img src="'. __PS_BASE_URI__ .'themes/metroshop/img/metroshop/banner145.png" alt="" /></a></div>
                    <div class="left_banner" style="margin-bottom: 15px; background: none;"><a href="#"><img src="'. __PS_BASE_URI__ .'themes/metroshop/img/metroshop/banner145.png" alt="" /></a></div>  
               ',
            "type" => "textarea");
        $scc_options[] = array("name" => 'Change Custom tab title',
            "desc" => 'Custom HTMl title design to show on product page.',
            "id" => $this->sccthemename . "_product_page_custitle",
            "lang" => true,
            "std" => 'Custom tab',
            "type" => "text");
        $scc_options[] = array("name" => 'Product page Custom tab content',
            "desc" => 'Custom HTML design to show on product page.',
            "id" => $this->sccthemename . "_product_page_customtabs",
            "lang" => true,
            "std" => '<div style="width: 421px; padding-right: 20px; margin-right: 20px; border-right: 1px solid #efefef;" class="left">
<h3 style="margin-top: -5px;">Custom HTML</h3>
<img alt="" src="'.__PS_BASE_URI__ .'themes/metroshop/img/metroshop/banner185.png" style="float: left; margin: 0 10px 10px 0;"> Ultricies sociis ut vel parturient! Tempor! Nec quis turpis placerat ac hac tincidunt, velit, vel sit mauris a, dolor, natoque enim! Etiam risus? Elit, adipiscing dignissim ut et risus sit placerat, penatibus tincidunt, diam sed dignissim rhoncus mus lectus, penatibus arcu sit in mattis porta placerat. Ultricies velit odio. Vel? Aliquam nunc dolor! Nisi, cras, nunc, et auctor? Augue facilisis! Augue eu dis platea sed, placerat hac pid, lectus dapibus turpis in tincidunt arcu rhoncus auctor. Sit duis nascetur vut! Pulvinar egestas, aenean, sagittis odio enim magna, etiam platea nec lundium, nisi, mauris porttitor elementum a, tempor turpis.
    </div>
<div style="width: 458px;" class="right">
<h3 style="margin-top: -5px;">Custom HTML</h3>
<img alt="" src="'.__PS_BASE_URI__ .'themes/metroshop/img/metroshop/banner185.png" style="float: left; margin: 0 10px 10px 0;">Ultricies sociis ut vel parturient! Tempor! Nec quis turpis placerat ac hac tincidunt, velit, vel sit mauris a, dolor, natoque enim! Etiam risus? Elit, adipiscing dignissim ut et risus sit placerat, penatibus tincidunt, diam sed dignissim rhoncus mus lectus, penatibus arcu sit in mattis porta placerat. Ultricies velit odio. Vel? Aliquam nunc dolor! Nisi, cras, nunc, et auctor? Augue facilisis! Augue eu dis platea sed, placerat hac pid, lectus dapibus turpis in tincidunt arcu rhoncus auctor. Sit duis nascetur vut! Pulvinar egestas, aenean, sagittis odio enim magna, etiam platea nec lundium, nisi, mauris porttitor elementum a, tempor turpis.
</div>',
            "type" => "textarea");

        $scc_options[] = array("name" => 'Add Custom CSS',
            "desc" => 'Add custom css to show page on header.',
            "id" => $this->sccthemename . "_add_custom_css",
  
            "std" => '',
            "type" => "textarea");
        $scc_options[] = array("name" => 'Add Custom  JS',
            "desc" => 'Add custom js to show page on header.',
            "id" => $this->sccthemename . "_add_custom_js",
            "std" => '',
            "type" => "textarea");



        /*  payment option */


        $scc_options[] = array("name" => 'Payment icons',
            "type" => "heading");
        $scc_options[] = array("sub_name" => 'PayPal URL',
            "desc" => "Enter your PayPal url.",
            "id" => $this->sccthemename . "_paypal_url",
            "std" => 'http://paypal.com',
            "type" => "block_text");
        $scc_options[] = array("sub_name" => 'Visa URL',
            "desc" => "Enter your Visa url.",
            "id" => $this->sccthemename . "_visa_url",
            "std" => 'http://www.visa.com/',
            "type" => "block_text");
        $scc_options[] = array("sub_name" => 'MasterCard URL',
            "desc" => "Enter your MasterCard url.",
            "id" => $this->sccthemename . "_mastercard_url",
            "std" => 'http://www.mastercard.com',
            "type" => "block_text");
        $scc_options[] = array("sub_name" => 'Discover URL',
            "desc" => "Enter your Discover url.",
            "id" => $this->sccthemename . "_discover_url",
            "std" => 'https://www.discover.com/',
            "type" => "block_text");
        $scc_options[] = array("sub_name" => 'Maestro URL',
            "desc" => "Enter your Maestro url.",
            "id" => $this->sccthemename . "_maestro_url",
            "std" => 'http://yourlink.com',
            "type" => "block_text");
        $scc_options[] = array("sub_name" => 'AmericanExpress URL',
            "desc" => "Enter your AmericanExpress url.",
            "id" => $this->sccthemename . "_americanexpress_url",
            "std" => 'https://www.americanexpress.com/',
            "type" => "block_text");

        $scc_options[] = array("sub_name" => 'Cirrus URL',
            "desc" => "Enter your Cirrus url.",
            "id" => $this->sccthemename . "_cirrus_url",
            "std" => 'http://www.cirrus.com/',
            "type" => "block_text");

        $scc_options[] = array("sub_name" => 'VisaElectron URL',
            "desc" => "Enter your VisaElectron url.",
            "id" => $this->sccthemename . "_visaelectron_url",
            "std" => 'http://maestrocard.com//',
            "type" => "block_text");











        $this->sccoptions = $scc_options;
    }

    private function _includeAdminFile() {

        $this->_html = '
<link href="' . __PS_BASE_URI__ . 'modules/psmodthemeoptionpanel/admin/css/admin-style.css" rel="stylesheet" type="text/css" />
<link href="' . __PS_BASE_URI__ . 'modules/psmodthemeoptionpanel/admin/css/colorpicker.css" rel="stylesheet" type="text/css" />
<script type="text/javascript"  src="' . __PS_BASE_URI__ . 'modules/psmodthemeoptionpanel/admin/js/jquery.maskedinput-1.2.2.js"></script>
<script type="text/javascript"  src="' . __PS_BASE_URI__ . 'modules/psmodthemeoptionpanel/admin/js/colorpicker.js"></script>
<script type="text/javascript"  src="' . __PS_BASE_URI__ . 'modules/psmodthemeoptionpanel/admin/js/medialibrary-uploader.js"></script>
<script type="text/javascript"  src="' . __PS_BASE_URI__ . 'modules/psmodthemeoptionpanel/admin/js/jquery.maskedinput-1.2.2.js"></script>
<script type="text/javascript"  src="' . __PS_BASE_URI__ . 'modules/psmodthemeoptionpanel/admin/js/jquery.tipsy.js"></script>
<link href="' . __PS_BASE_URI__ . 'modules/psmodthemeoptionpanel/admin/css/bootstrap-trim.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript"  src="' . __PS_BASE_URI__ . 'modules/psmodthemeoptionpanel/admin/js/prettify.js"></script>
<script type="text/javascript"  src="' . __PS_BASE_URI__ . 'modules/psmodthemeoptionpanel/admin/js/bootstrap-trim.min.js"></script>
<script type="text/javascript"  src="' . __PS_BASE_URI__ . 'modules/psmodthemeoptionpanel/admin/js/options-custom.js"></script>
    ';
    }

    public function getSaveOption($id) {
        return Configuration::get($id);
    }

    private function _sccOptionForm() {
        global $cookie;

        $sccoptionfields = $this->sccOptionPanelFields();

        $this->_fields = $sccoptionfields[0];
        $this->_tabs = $sccoptionfields[1];


        $this->_html .= '
            
           <div class="container custome-bg">
          <div id="scc-popup-patterns-save" class="of-save-popup">
		<div class="for-button-save">Pattern Uploaded Successfully</div>
	</div>
         <div id="scc-popup-save" class="of-save-popup">
		<div class="for-button-save">Theme Options Updated</div>
	</div>
        
	<div id="for-popup-reset" class="of-save-popup">
		<div class="for-button-reset">Theme Options Reset</div>
	</div>
        <form id="for_form" method="post" action="" enctype="multipart/form-data" >
            <div class="page-header">
                            <img src="' . __PS_BASE_URI__ . 'modules/psmodthemeoptionpanel/upload/logo.png" >
                                <h2>' . $this->displayName . '</h2>
                                <span>' . $this->version . '</span>
                        </div>
           

            <div class="row-fluid">
                <div id="sidebar" class="tabbable">
                    <div class="span3">
                        <div class="well">
                            <ul id="sidenav" class="nav nav-pills nav-stacked">
                                 ' . $this->_tabs . ' 
                            </ul>
                        </div><!-- .well -->

                    </div><!-- .span3 -->
                    <div class="span9">				
                        <div class="tab-content content-gbcolr">

 ' . $this->_fields . ' 
                        </div><!-- .tab-content -->
                    </div><!-- .span7 -->
                </div><!-- .tabbable -->
               
            </div>
              <div class="page-footer">
                     <button type="submit" class="btn-button save-button">Save Update</button>
               </div>
            	</form>
	
	<div style="clear:both;"></div>
        </div>';

        return $this->_html;
    }

    public function sccOptionPanelFields() {

        $sccoptions = $this->sccoptions;
        $optiondata = array();
        $count = 0;
        $tabs = '';
        $sccfieldsoutput = '';

        foreach ($sccoptions as $result) {

            $count++;
            if ($result['type'] != "heading") {
                $heading_class = '';
                if (isset($result['class'])) {
                    $heading_class = $result['class'];
                }
                $sccfieldsoutput .= '<div class="sectionupload  section-' . $result['type'] . ' ' . $heading_class . '">';

                if (isset($result['name']))
                    $sccfieldsoutput .= '<h3 class="heading">' . $result['name'] . '</h3>';

                if (isset($result['sub_name']))
                    $sccfieldsoutput .= '<h5>' . $result['sub_name'] . '</h5>';

                $sccfieldsoutput .= '<div class="option">';
                if (!$result['desc']):
                    $sccfieldsoutput .= '<div class="manage managefull">';
                else:
                    $sccfieldsoutput .= '<div class="manage">';
                endif;
            }
            switch ($result['type']) {
                case 'block_text':

                    $type_value = $this->getSaveOption($result['id']);


                    $std = $this->getSaveOption($result['id']);
                    if ($std != "") {
                        $type_value = stripslashes($std);
                    }
                    $sccfieldsoutput .= '<input class="scc-input" name="' . $result['id'] . '" id="' . $result['id'] . '" type="' . $result['type'] . '" value="' . $type_value . '" />';
                    break;
                case 'text':
                    $type_value = '';

                    if (isset($result['options'])) {
                        $text_option = $result['options'];
                        if (isset($text_option['cols'])) {
                            $cols = $text_option['cols'];
                        }
                    }
                    $defaultLanguage = (int) (Configuration::get('PS_LANG_DEFAULT'));
                    $divLangName = $result['id'];

                    if (isset($result['lang']) && $result['lang'] == true)
                        $sscc = $this->getSaveOption($result['id'] . '_' . $defaultLanguage);
                    else
                        $sscc = $this->getSaveOption($result['id']);


                    if ($sscc != "") {
                        $type_value = stripslashes($sscc);
                    }
                    $languages = Language::getLanguages(false);
                    if (isset($result['lang']) && $result['lang'] == true):
                        foreach ($languages as $lang) {
                            $sscc = $this->getSaveOption($result['id'] . '_' . $lang['id_lang']);
                            if ($sscc != "") {
                                $type_value = stripslashes($sscc);
                            }

                            $sccfieldsoutput .='<div id="' . $result['id'] . '_' . $lang['id_lang'] . '" style="display: ' . ($lang['id_lang'] == $defaultLanguage ? 'block' : 'none') . ';float: left;">';
                            $sccfieldsoutput .= '<input class="scc-input" name="' . $result['id'] . '_' . $lang['id_lang'] . '" id="' . $result['id'] . '_' . $lang['id_lang'] . '" value="' . $type_value . '" />';
                            $sccfieldsoutput .= '</div>';
                        }

                        $sccfieldsoutput .=$this->displayFlags($languages, $defaultLanguage, $divLangName, $result['id'], true);
                    else:
                        $sscc = $this->getSaveOption($result['id']);
                        if ($sscc != "") {
                            $type_value = stripslashes($sscc);
                        }
                        $sccfieldsoutput .= '<input class="scc-input" name="' . $result['id'] . '" id="' . $result['id'] . '" value="' . $type_value . '" />';
                    endif;

                    break;

                case 'select':


                    $sccfieldsoutput .= '<div class="for-body-selected">';
                    $sccfieldsoutput .= '<select class="of-typography of-typography-size select" name="' . $result['id'] . '" id="' . $result['id'] . '">';

                    foreach ($result['options'] as $select_key => $option_val) {


                        $selected_value = $this->getSaveOption($result['id']);

                        if ($selected_value != '') {
                            if ($selected_value == $select_key) {
                                $selected_value = ' selected="selected"';
                            }
                        } else {
                            if ($result['std'] == $select_key) {
                                $selected_value = ' selected="selected"';
                            }
                        }


                        $sccfieldsoutput .= '<option id="' . $select_key . '" value="' . $select_key . '" ' . $selected_value . ' />' . $option_val . '</option>';
                    }
                    $sccfieldsoutput .= '</select></div>';
                    break;

                case 'textarea':
                    $cols = '10';
                    $type_value = '';

                    if (isset($result['options'])) {
                        $text_option = $result['options'];
                        if (isset($text_option['cols'])) {
                            $cols = $text_option['cols'];
                        }
                    }
                    $defaultLanguage = (int) (Configuration::get('PS_LANG_DEFAULT'));
                    $divLangName = $result['id'];

                    if (isset($result['lang']) && $result['lang'] == true)
                        $std = $this->getSaveOption($result['id'] . '_' . $defaultLanguage);
                    else
                        $std = $this->getSaveOption($result['id']);


                    if ($std != "") {
                        $type_value = stripslashes($std);
                    }



                    $languages = Language::getLanguages(false);
                    if (isset($result['lang']) && $result['lang'] == true):
                        foreach ($languages as $lang) {
                            $std = $this->getSaveOption($result['id'] . '_' . $lang['id_lang']);
                            if ($std != "") {
                                $type_value = stripslashes($std);
                            }

                            $sccfieldsoutput .='<div id="' . $result['id'] . '_' . $lang['id_lang'] . '" style="display: ' . ($lang['id_lang'] == $defaultLanguage ? 'block' : 'none') . ';float: left;">';
                            $sccfieldsoutput .= '<textarea class="scc-input" name="' . $result['id'] . '_' . $lang['id_lang'] . '" id="' . $result['id'] . '_' . $lang['id_lang'] . '" cols="' . $cols . '" rows="8">' . $type_value . '</textarea>';
                            $sccfieldsoutput .= '</div>';
                        }

                        $sccfieldsoutput .=$this->displayFlags($languages, $defaultLanguage, $divLangName, $result['id'], true);
                    else:
                        $std = $this->getSaveOption($result['id']);
                        if ($std != "") {
                            $type_value = stripslashes($std);
                        }
                        $sccfieldsoutput .= '<textarea class="scc-input" name="' . $result['id'] . '" id="' . $result['id'] . '" cols="' . $cols . '" rows="8">' . $type_value . '</textarea>';
                    endif;


                    break;

                case "radio":

                    $selected_value = $this->getSaveOption($result['id']);

                    foreach ($result['options'] as $option_val => $name) {
                        $checked = '';

                        if ($selected_value = '') {

                            if ($selected_value == $option_val) {
                                $checked = ' checked';
                            }
                        } else {

                            if ($result['std'] == $option_val) {
                                $checked = ' checked';
                            }
                        }



                        $sccfieldsoutput .= '<input class="scc-input of-radio" name="' . $result['id'] . '" type="radio" value="' . $option_val . '" ' . $checked . ' /><label class="radio">' . $name . '</label><br/>';
                    }
                    break;

                case 'checkbox':
                    if (!isset($optiondata[$result['id']])) {
                        $optiondata[$result['id']] = 0;
                    }

                    $get_std = $this->getSaveOption($result['id']);
                    $std = $result['std'];
                    $checked = '';

                    if (!empty($get_std)) {
                        if ($get_std == '1') {
                            $checked = 'checked="checked"';
                        } else {
                            $checked = '';
                        }
                    } elseif ($std == '1') {
                        $checked = 'checked="checked"';
                    } else {
                        $checked = '';
                    }

                    $sccfieldsoutput .= '<input type="hidden" class="' . 'checkbox aq-input" name="' . $result['id'] . '" id="' . $result['id'] . '" value="0"/>';
                    $sccfieldsoutput .= '<input type="checkbox" class="' . 'checkbox scc-input" name="' . $result['id'] . '" id="' . $result['id'] . '" value="1" ' . $checked . ' />';
                    break;
                case 'upload':
                    $sccfieldsoutput .= $this->sccUploadImage($result['id'], $result['std']);
                    break;
                case 'color':
                    $type_value = '';
                    $std = $this->getSaveOption($result['id']);
                    if ($std != "") {
                        $type_value = stripslashes($std);
                    }
                    $sccfieldsoutput .= '<div id="' . $result['id'] . '_picker" class="selectColor"><div style="background-color: ' . $type_value . '"></div></div>';
                    $sccfieldsoutput .= '<input class="of-color" name="' . $result['id'] . '" id="' . $result['id'] . '" type="text" value="' . $type_value . '" />';
                    break;

                case 'typography':


                    $get_face = $this->getSaveOption($result['id'] . '_face');

                    $typography = $result['std'];

                    if (isset($typography['face'])) {
                        if ($result['section'] == 'google') {
                            $sccfieldsoutput .= '<div id="demo_google" ><h5>Lorem ipsum dolor sit amet</h5></div>';
                        } else {
                            $sccfieldsoutput .= '<div id="demo_system"><h5>Lorem ipsum dolor sit amet</h5></div>';
                        }
                        $sccfieldsoutput .= '<div class="for-body-selected typography-face" original-title="Font family">';

                        $sccfieldsoutput .= '<select class="of-typography of-typography-face select" name="' . $result['id'] . '[face]" id="' . $result['id'] . '_face">';

                        $systemfont = array(
                            'Verdana, Geneva, sans-serif' => 'Verdana, Geneva, sans-serif',
                            'Georgia, Times New Roman, Times, serif' => 'Georgia, Times New Roman, Times, serif',
                            'Arial, Helvetica, sans-serif' => 'Arial, Helvetica, sans-serif',
                            'Tahoma, Geneva, sans-serif' => 'Tahoma, Geneva, sans-serif',
                            'Trebuchet MS, Arial, Helvetica, sans-serif' => 'Trebuchet MS, Arial, Helvetica, sans-serif',
                            'Times New Roman, Times, serif' => 'Times New Roman, Times, serif',
                            'MS Serif, New York, serif' => 'MS Serif, New York, serif',
                            'Courier New, Courier, monospace' => 'Courier New, Courier, monospace',
                            'Palatino Linotype, Book Antiqua, Palatino, serif' => 'Palatino Linotype, Book Antiqua, Palatino, serif',
                        );


                        $json = file_get_contents("https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyApfgGNkp7IY5ZqtJ8EhCySpT6ySPBirkQ", true);
                        $decode = json_decode($json, true);
                        $google_web_fonts = array();
                        //print_r($json);
                        foreach ($decode['items'] as $key => $value) {

                            $item_family = $decode['items'][$key]['family'];
                            $fontvariants = $decode['items'][$key]['variants'];


                            $item_family_trunc = str_replace(' ', '+', $item_family);

                            $google_web_fonts[$item_family_trunc] = $item_family;
                        }

                        if ($result['section'] == 'google') {
                            $webfont = $google_web_fonts;
                        } else {
                            $webfont = $systemfont;
                        }
                        foreach ($webfont as $key => $fontfamily) {

                            $idfont = trim($key);
                            if (!empty($get_face)) {

                                if ($result['section'] == 'google') {
                                    if (trim($get_face) == $fontfamily)
                                        $selected_gval = 'selected="selected"';
                                    else
                                        $selected_gval = '';
                                }else {
                                    if (trim($get_face) == $idfont)
                                        $selected_value = 'selected="selected"';
                                    else
                                        $selected_value = '';
                                }
                            }else {
                                if ($result['section'] == 'google') {
                                    if (trim($typography['face']) == $fontfamily)
                                        $selected_gval = 'selected="selected"';
                                    else
                                        $selected_gval = '';
                                }else {
                                    if (trim($typography['face']) == $idfont)
                                        $selected_value = 'selected="selected"';
                                    else
                                        $selected_value = '';
                                }
                            }



                            if ($result['section'] == 'google') {
                                $sccfieldsoutput .= '<option value="' . $fontfamily . '" ' . $selected_gval . '>' . $fontfamily . '</option>';
                            } else {
                                $sccfieldsoutput .= '<option value="' . $key . '" ' . $selected_value . '>' . $fontfamily . '</option>';
                            }
                        }

                        $sccfieldsoutput .= '</select>';



                        $sccfieldsoutput .= '</div>';
                    }
                    if (isset($typography['color'])) {

                        if (!empty($get_color)) {
                            $selected_value = $get_color;
                        } else {
                            $selected_value = $typography['color'];
                        }

                        $sccfieldsoutput .= '<div id="' . $result['id'] . '_color_picker" class="selectColor typography-color"><div style="background-color: ' . $selected_value . '"></div></div>';
                        $sccfieldsoutput .= '<input class="of-color of-typography of-typography-color" original-title="Font color" name="' . $result['id'] . '[color]" id="' . $result['id'] . '_color" type="text" value="' . $selected_value . '" />';
                    }

                    break;
                case 'images':

                    $i = 0;
                    $get_std = $this->getSaveOption($result['id']);
                    $std = $result['std'];
                    foreach ($result['options'] as $key => $option_val) {
                        $i++;
                        if (!empty($get_std)) {
                            if ($get_std == $key) {
                                $selected_value = 'add-radio-picture';
                            } else {
                                $selected_value = '';
                            }
                        } elseif ($std == $key) {
                            $selected_value = 'add-radio-picture';
                        } else {
                            $selected_value = '';
                        }

                        $sccfieldsoutput .= '<span>';
                        $sccfieldsoutput .= '<input type="radio" id="of-radio-img-' . $result['id'] . $i . '" class="checkbox of-radio-img-radio" value="' . $key . '" name="' . $result['id'] . '" ' . $selected_value . ' />';
                        $sccfieldsoutput .= '<div class="for-radio-picture-label">' . $key . '</div>';
                        $sccfieldsoutput .= '<img src="' . $option_val . '" alt="" class="radio-box-picture ' . $selected_value . '" onClick="document.getElementById(\'of-radio-img-' . $result['id'] . $i . '\').checked = true;" />';
                        $sccfieldsoutput .= '</span>';
                    }

                    break;
                case "image":
                    $src = $result['std'];
                    $sccfieldsoutput .= '<img src="' . $src . '">';
                    break;
                case 'heading':
                    if ($count >= 2) {
                        $sccfieldsoutput .= '</div>';
                    }

                    $tabs_class = str_replace(' ', '', strtolower($result['name']));
                    $click_heading = str_replace(' ', '', strtolower($result['name']));
                    $click_heading = "of-option-" . $click_heading;
                    $tabs .= '<li class="' . $tabs_class . ' "><a  data-toggle="tab" title="' . $result['name'] . '" href="#' . $click_heading . '">' . $result['name'] . '</a></li>';
                    $sccfieldsoutput .= '<div class="tab-pane" id="' . $click_heading . '"> <div class="alerts alert-success"><h4>' . $result['name'] . '</h4></div>' . "\n";
                    break;
                case 'iphonebutton':
                    $get_std = $this->getSaveOption($result['id']);
                      $checked = '';

                        if ($get_std != '') {

                            if ($get_std == 'enable') {
                                $checked = ' checked';
                            }
                        } else {

                            if ($result['std'] == 'enable') {
                                $checked = ' checked';
                            }
                        }
                    $anaselect = ($get_std == "enable") ? "selected" : ' ';
                    $disselet = ($get_std == "disable") ? "selected" : ' ';

                    $sccfieldsoutput .='<p class="field switch">
                            <input type="radio" id="radio'.$result['button_id'][0].'" name="' . $result['id'] . '" value="enable" $checked />
                            <input type="radio" id="radio'.$result['button_id'][1].'" name="' . $result['id'] . '" value="disable" />
                            
                            <label for="radio'.$result['button_id'][0].'" class="cb-enable ' . $anaselect . '"><span>Enable</span></label>
                            <label for="radio'.$result['button_id'][1].'" class="cb-disable ' . $disselet . '"><span>Disable</span></label>
                        </p>';
                    break;
                case 'tiles':
                    $i = 0;
                    $get_std = $this->getSaveOption($result['id']);
                    $std = $result['std'];
                    foreach ($result['options'] as $key => $option_val) {
                        $i++;


                        if (!empty($get_std)) {
                            if ($get_std == $option_val) {
                                $selected_value = 'scc-radio-tile-selected';
                            } else {
                                $selected_value = '';
                            }
                        } elseif ($std == $option_val) {
                            $selected_value = 'scc-radio-tile-selected';
                        } else {
                            $selected_value = '';
                        }

                        $sccfieldsoutput .= '<span>';
                        $sccfieldsoutput .= '<input type="radio" id="scc-radio-tile-' . $result['id'] . $i . '" class="checkbox scc-radio-tile-radio" value="' . $option_val . '" name="' . $result['id'] . '" />';
                        $sccfieldsoutput .= '<div class="scc-radio-tile-img ' . $selected_value . '" onClick="document.getElementById(\'scc-radio-tile-' . $result['id'] . $i . '\').checked = true;"><img src="' . $option_val . '" width="50" height="50"></div>';
                        $sccfieldsoutput .= '</span>';
                    }

                    break;
            }
            if ($result['type'] != 'heading') {
                if (!isset($result['desc'])) {
                    $explain_value = '';
                } else {
                    $explain_value = '<div class="explain">' . $result['desc'] . '</div>';
                }
                $sccfieldsoutput .= '</div>' . $explain_value;
                $sccfieldsoutput .= '<div class="clear"> </div></div></div>';
            }
        }
        $sccfieldsoutput .= '</div>';

        return array($sccfieldsoutput, $tabs);
    }

    public function getAllPatern() {
        $all_paterns = array();
        $paterns_path = _PS_MODULE_DIR_ . 'psmodthemeoptionpanel/patterns/';
        $paterns_url = __PS_BASE_URI__ . 'modules/psmodthemeoptionpanel/patterns/';

        if (is_dir($paterns_path)) {
            if ($image_dir = opendir($paterns_path)) {
                while (($patern_name = readdir($image_dir)) !== false) {
                    if (stristr($patern_name, ".gif") !== false || stristr($patern_name, ".png") !== false || stristr($patern_name, ".jpg") !== false) {
                        $all_paterns[] = $paterns_url . $patern_name;
                    }
                }
            }
        }

        $this->pattern = $all_paterns;
    }

    private function sccUploadImage($id, $std) {

        $upload_markup = '';
        $upload_image = $this->getSaveOption($id);

        if ($upload_image != "") {
            $value = $upload_image;
        } else {
            $value = $std;
        }

        $upload_markup .= '<input class="upload scc-input" name="' . $id . '" id="' . $id . '_upload" value="' . $value . '" />';

        $upload_markup .= '<div class="upload_button_div"><span class="button upload_button" id="' . $id . '">Upload</span>';

        if (!empty($upload_image)) {
            $hidden = '';
        } else {
            $hidden = 'hidden';
        }
        $upload_markup .= '<span class="button reset_button ' . $hidden . '" id="reset_' . $id . '" title="' . $id . '">Remove</span>';
        $upload_markup .='</div><div class="clear"></div>';
        if (!empty($upload_image)) {
            $upload_markup .= '<div class="screenshot">';
            $upload_markup .= '<a class="scc-uploaded-image" href="' . $upload_image . '">';
            $upload_markup .= '<img class="for-body-picture" id="image_' . $id . '" src="' . $upload_image . '" alt="" />';
            $upload_markup .= '</a>';
            $upload_markup .= '</div><div class="clear"></div>';
        }
        return $upload_markup;
    }

    public function hookTop() {
        global $smarty;
        $sccpsthemeoptionpanel = array();
        foreach ($this->sccoptions as $option_value):
            if ($option_value['type'] == 'typography') {
                foreach ($option_value as $values) {
                    if (is_array($values)) {
                        foreach ($values as $key => $typovalue) {
                            $sccpsthemeoptionpanel[$option_value['id'] . '_' . $key] = Configuration::get($option_value['id'] . '_' . $key);
                        }
                    }
                }
            }
            if (isset($option_value['id'])):
                $sccpsthemeoptionpanel[$option_value['id']] = Configuration::get($option_value['id']);
            endif;


            $languages = Language::getLanguages(false);
            if (isset($option_value['lang']) && $option_value['lang'] == true):

                foreach ($languages as $lang) {
                    $sccpsthemeoptionpanel[$option_value['id'] . '_' . $lang['id_lang']] = Configuration::get($option_value['id'] . '_' . $lang['id_lang']);
                }
                $sccpsthemeoptionpanel[$option_value['id']] = Configuration::get($option_value['id'] . '_' . $this->context->language->id);
            endif;
        endforeach;

        $smarty->assign('dedalx', $sccpsthemeoptionpanel);
    }

    public function hookHeader() {
        return $this->hookTop();
    }

    public function hookHome() {
        return $this->hookTop();
    }

    public function hookfooter() {
        return $this->hookTop();
    }

    public function hookleftColumn() {
        return $this->hookTop();
    }

    public function hookrightColumn() {
        return $this->hookTop();
    }

}

?>