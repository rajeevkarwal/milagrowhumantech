<?php

if (!defined('_PS_VERSION_'))
    exit;

class TDpsThemeOptionPanel extends Module {

    public $tdthemename = "td";
    public $_html, $pattern, $_fields, $_tabs, $Defaults;
    public $tdoptions = array();

    public function __construct() {
        $this->name = 'tdpsthemeoptionpanel';
        $this->tab = 'front_office_features';
        $this->version = '1.1.0';
        $this->author = 'ThemesDeveloper';
        $this->need_instance = 0;
        parent::__construct();
        $this->displayName = $this->l('MetroFas Theme Options panel');
        $this->description = $this->l('Prestashop Themes Option Panel By ThemesDeveloper');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall your details ?');
        $this->secure_key = Tools::encrypt($this->name);

        $this->getAllPatern();
        $this->tdThemeOption();
    }

    public function install() {
        if (!parent::install() || !$this->registerHook('header') || !$this->registerHook('top') || !$this->registerHook('home') || !$this->registerHook('leftColumn') ||
                !$this->registerHook('rightColumn') || !$this->installData() || !$this->registerHook('footer')
        )
            return false;

        return true;
    }

    public function installData() {
        $tdoptions = $this->tdoptions;
        foreach ($tdoptions as $option_result):
            $stdvalue = isset($option_result['std']) ? $option_result['std'] : '';
            if (isset($stdvalue)):
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
                        if (isset($option_result['id']) && isset($option_result['std']))
                            Configuration::updateValue($option_result['id'], htmlspecialchars($option_result['std']));
                    }
                }
            endif;

        endforeach;
        return true;
    }

    public function tdOptionDataDelete() {
        $tdoptions = $this->tdoptions;
        foreach ($tdoptions as $option_result):

            $stdvalue = isset($option_result['std']) ? $option_result['std'] : '';
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
                        if (isset($option_result['id']))
                            Configuration::deleteByName($option_result['id']);
                    }
                }
            endif;

        endforeach;
        return true;
    }

    public function uninstall() {
        if (!parent::uninstall())
            return false;
        $this->tdOptionDataDelete();
        return true;
    }

    public function getContent() {
        $this->_html = '';
        global $cookie;
        require_once '../config/config.inc.php';
        require_once '../init.php';
        $this->_includeAdminFile();
        $this->_tdOptionForm();
        return $this->_html;
    }

    public function tdThemeOption() {
        $languages = Language::getLanguages(false);
        $pattern = $this->pattern;
        $adminimagepath = __PS_BASE_URI__ . 'modules/tdpsthemeoptionpanel/admin/images/';
        $themesimagepath = __PS_BASE_URI__ . 'themes/metrofas/img/';
        $paterns_url = __PS_BASE_URI__ . 'modules/tdpsthemeoptionpanel/patterns/';
        $td_options = array();

        $td_options[] = array("name" => "General Settings",
            "type" => "heading");


           $td_options[] = array("name" => 'Home Page Sidebar',
            "desc" => 'Can use to sidebar or fullwidth.',
            "id" => $this->tdthemename.'_home_sidebar',
            "std" => "disable",
            "button_id" => array(1,2),
            "options" => array('Enable', 'Disable'),
            "type" => "iphonebutton");
         
        $td_options[] = array("name" => 'Product Page Sidebar',
            "desc" => 'Can use to sidebar or fullwidth.',
            "id" => $this->tdthemename.'_pro_sidebar',
            "std" => "enable",
            "button_id" => array(3,4),
            "options" => array('Enable', 'Disable'),
            "type" => "iphonebutton");
             
             
           $td_options[] = array("name" => 'Sidebar',
            "desc" => 'If you want to show or hide left sidebar on product list page, cms page.',
            "id" => $this->tdthemename.'_siderbar_without',
            "std" => "enable",
            "button_id" => array(5,6),
            "options" => array('Enable', 'Disable'),
            "type" => "iphonebutton");
           
              $td_options[] = array("name" => "Product Default View Mode",
            "desc" => "If you want to change default product view style on product list page.",
            "id" => $this->tdthemename . "_proviewstyle",
            "std" => "gridview",
            "type" => "images",
            "options" => array(
                'listview' => $adminimagepath . 'list.png',
                'gridview' => $adminimagepath . 'grid.png'
            )
        );
           
     $td_options[] = array("name" => 'Display Subcategory',
            "desc" => 'If you want to show or hide subcategory on category page.',
            "id" => $this->tdthemename . '_showsubcat',
            "std" => "disable",
            "button_id" => array(7, 8),
            "options" => array('Yes', 'No'),
            "type" => "iphonebutton");
   $td_options[] = array("name" => 'Display brands on home page?',
            "desc" => 'If you want to show or hide brands on home page.',
            "id" => $this->tdthemename . '_display_brands',
            "std" => "enable",
            "button_id" => array(9, 10),
            "options" => array('Yes', 'No'),
            "type" => "iphonebutton");


       $td_options[] = array("name" => "Styling Options",
            "type" => "heading");

        $td_options[] = array("name" => "Main Theme Color ",
            "desc" => "Set the main color for your theme.",
            "id" => $this->tdthemename . '_mainColor',
            "std" => "#EC5D5D",
            "type" => "color");
        
  $td_options[] = array("name" => "Second Color",
            "desc" => "Set the second color for your theme.",
            "id" => $this->tdthemename .'_secondcolor',
            "std" => "#88C7C5",
            "type" => "color");
  

  $td_options[] = array("name" => "Body Fonts Color",
            "desc" => "Set the body font  color for your theme.",
            "id" => $this->tdthemename . '_body_font_color',
            "std" => "#404040",
            "type" => "color");
        $td_options[] = array("name" => "Body Background Color",
            "desc" => "Set the body Background color for your theme.",
            "id" => $this->tdthemename . "_body_bg_color",
            "std" => "#FFFFFF",
            "type" => "color");
      $td_options[] = array("name" => 'Body Background Pattern',
            "desc" => 'If you want to use Backgrond pattern.',
            "id" => $this->tdthemename.'_enableordisable_bg',
            "std" => "disable",
            "button_id" => array(13,14),
            "options" => array('Enable', 'Disable'),
            "type" => "iphonebutton");
        $td_options[] = array("name" => "Background Pattern",
            "id" =>$this->tdthemename . "_body_bg",
            "std" => $paterns_url . "skelatal_weave.png",
            "type" => "tiles",
            "options" => $pattern,
        );

        $td_options[] = array("name" => "Custom Background",
            "desc" => "Upload a custom background image for your theme. This will override the option above. This is only for the main background pattern.",
            "id" => $this->tdthemename . "_body_bg_custom",
            "std" => "",
            "mod" => "min",
            "type" => "upload");
        

        $td_options[] = array("name" => "background-attachment",
            "desc" => "You can define additional shorthand properties for the background. ",
            "id" => $this->tdthemename . "_bgattachment",
            "std" => "scroll",
            "options"=>array('scroll'=>'scroll','fixed'=>'fixed','inherit'=>'inherit'),
            "type" => "select");
        
        
         $td_options[] = array("name" => "background-repeat",
            "desc" => "You can define additional shorthand properties for the background.",
            "id" => $this->tdthemename . "_bgrepeat",
            "std" => "repeat",
            "options"=>array('repeat'=>'repeat','repeat-x'=>'repeat-x','repeat-y'=>'repeat-y','no-repeat'=>'no-repeat','inherit'=>'inherit'),
            "type" => "select");

     $td_options[] = array("name" => "background-position",
            "desc" => "You can define additional shorthand properties for the background.",
            "id" => $this->tdthemename . "_bgposition",
            "std" => "scroll",
            "options"=>array('left top'=>'left top','left center'=>'left center','left bottom'=>'left bottom',
                'right top'=>'right top','right center'=>'right center','right bottom'=>'right bottom',
                'center top'=>'center top','center center'=>'center center','center bottom'=>'center bottom'),
            "type" => "select");
        $td_options[] = array("name" => "Custom Style",
            "desc" => "Put your custom style here.",
            "id" => $this->tdthemename . "_custom_style",
            "std" => "",
            "type" => "textarea");
            $td_options[] = array("name" => "Custom JS",
            "desc" => "Put your custom Script here.",
            "id" => $this->tdthemename . "_custom_js",
            "std" => "",
            "type" => "textarea");
        
        $td_options[] = array("name" => "Slider options",
            "type" => "heading");
        $td_options[] = array("name" => "Select Type Of Slider",
            "desc" => "You can select type of Slider.",
            "id" => $this->tdthemename . "_slider_type",
            "std" => 'content_slider',
            "options" => array('content_slider' => 'Content Slider', 'product_slider' => 'Product Slider'),
            "type" => "select");
  $td_options[] = array("name" => "Slider Layout",
            "desc" => "You Can Select Full width/ Fixed width Slider.",
            "id" => $this->tdthemename . "_slider_layout",
            "std" => 'fullwidth_slider',
            "options" => array('fullwidth_slider' => 'Full width slider', 'fixedwidth_slider' => 'Fixed width slider'),
            "type" => "select"); 
        $td_options[] = array("name" => "Slide Show Speed",
            "desc" => "Set Transition time (for animation between images) - usually a value between 500ms and 1000ms.",
            "id" => $this->tdthemename . '_slideshowSpeed',
            "std" => "7000",
            "type" => "text");
        $td_options[] = array("name" => "Animation Speed",
            "desc" => "Set how long each slide is shown - usually a value between 5000ms and 10000ms.",
            "id" => $this->tdthemename . '_anumaSpeed',
            "std" => "600",
            "type" => "text");
        
        $td_options[] = array("name" => 'Background Color',
            "desc" => 'If you want to change main body background color.',
            "id" => $this->tdthemename . '_body_background',
            "std" => "#000000",
            "type" => "color");
         $td_options[] = array("name" => 'Background Images',
            "desc" => 'If you want to change main body background color.',
            "id" => $this->tdthemename . '_product_bgimages',
            "std" => "disable",
            "button_id" => array(15, 16),
            "options" => array('Enable', 'Disable'),
            "type" => "iphonebutton");
         
       
          
     $td_options[] = array("name" => "Background Patterns",
            "id" => $this->tdthemename . "_product_bg_pattern",
            "std" => "",
            "type" => "tiles",
            "options" => $pattern,
        );
        $td_options[] = array("name" => 'Custom Background',
            "desc" => 'Coustom Background',
            "id" => $this->tdthemename . "_product_custombg",
            "std" => '',
            "type" => "upload");
         $td_options[] = array("name" => 'Product Slider',
            "type" => "head_block");
         $td_options[] = array("name" => 'Title Color',
            "desc" => 'If you want to change  Product slider title color.',
            "id" => $this->tdthemename . '_product_title_color',
            "std" => "#F0ECE9",
            "type" => "color");
       $td_options[] = array("name" => 'Text Color',
            "desc" => 'If you want to product text color.',
            "id" => $this->tdthemename . '_product_slitextcolor',
            "std" => "#F0ECE9",
            "type" => "color");


        $td_options[] = array("name" => "Typography",
            "type" => "heading");
        $td_options[] = array("name" => "Heading Font Style",
            "desc" => "You can change menu & heading font style.",
            "id" => $this->tdthemename . "_shop_heading_font",
            "std" => array('face' => 'CarroisGothic'),
            "section" => "google", //googoogle
            "type" => "typography");

        $td_options[] = array("name" => "Body Font Style",
            "desc" => "You can change secondary font style.",
            "id" => $this->tdthemename . "_shop_body_font",
            "std" => array('face' => 'Helvetica Neue,Helvetica,Arial,sans-serif'),
            "section" => "system",
            "type" => "typography");
        $td_options[] = array("name" => "Social Options",
            "type" => "heading");

              
     $td_options[] = array("sub_name" => 'Twitter ID',
            "desc" => "Enter your Twitter id.",
            "id" => $this->tdthemename . "_twitter_id",
            "std" => "ThemesDeveloper",
            "type" => "text");
        $td_options[] = array("sub_name" => 'Tweets to show',
            "desc" => "Tweets count",
            "id" => $this->tdthemename . "_tweet_count",
            "std" => "2",
            "type" => "block_text");
      $td_options[] = array("sub_name" => 'Consumer key',
            "desc" => "Put your twitter Consumer key. <br/>See <a href='https://dev.twitter.com/apps' target='_blank'>https://dev.twitter.com/apps</a> for help.",
            "id" => $this->tdthemename . "_consumer_key",
            "std" => "",
            "type" => "block_text");
             $td_options[] = array("sub_name" => 'Consumer secret',
            "desc" => "Put your twitter Consumer secret. <br/>See <a href='https://dev.twitter.com/apps' target='_blank'>https://dev.twitter.com/apps</a> for help.",
            "id" => $this->tdthemename . "_consumer_secret",
            "std" => "",
            "type" => "block_text");
             
                  $td_options[] = array("sub_name" => 'Access token',
            "desc" => "Put your twitter Access token. <br/>See <a href='https://dev.twitter.com/apps' target='_blank'>https://dev.twitter.com/apps</a> for help.",
            "id" => $this->tdthemename . "_consumer_token",
            "std" => "",
            "type" => "block_text");
             
              $td_options[] = array("sub_name" => 'Access token secret',
            "desc" => "Put your twitter Access token secret. <br/>See <a href='https://dev.twitter.com/apps' target='_blank'>https://dev.twitter.com/apps</a> for help.",
            "id" => $this->tdthemename . "_consumer_tsecret",
            "std" => "",
            "type" => "block_text");
              
              
              
           
           $td_options[] = array("name" => 'Facebook Like Box',
            "desc" => 'If you want to use facebook like box in left/right bar.',
            "id" => $this->tdthemename . '_facebook_likebox',
            "std" => "enable",
            "button_id" => array(17, 18),
            "options" => array('Enable', 'Disable'),
            "type" => "iphonebutton");
       $td_options[] = array("name" => 'Display Facebook Like Box',
            "desc" => 'If you want to use facebook like box in left/right bar.',
            "id" => $this->tdthemename . '_diaplay_fblikebox',
            "std" => "enable",
            "button_id" => array(19, 20),
            "options" => array('Right', 'Left'),
            "type" => "iphonebutton");
        $td_options[] = array("sub_name" => 'Facebook Page URL',
            "desc" => "Enter your facebook page url.",
            "id" => $this->tdthemename . "_fb_page_url",
            "std" => "http://www.facebook.com/envato",
            "type" => "block_text");
        
        
        $td_options[] = array("sub_name" => 'Facebook Page ID',
            "desc" => "Enter your facebook Fun page id.",
            "id" => $this->tdthemename . "_fb_page_id",
            "std" => "",
            "type" => "block_text");
        

        $td_options[] = array("name" => 'Social Footer Link',
            "type" => "head_block");
        
            $td_options[] = array("sub_name" => 'Facebook URL',
            "desc" => "Enter your facebook url.",
            "id" => $this->tdthemename . "_facebook_url",
            "std" => "http://yourlink.com",
            "type" => "block_text");
          $td_options[] = array("sub_name" => 'Twitter URL',
            "desc" => "Enter your Twitter url.",
            "id" => $this->tdthemename . "_twitter_url",
            "std" => "http://yourlink.com",
            "type" => "block_text");
        $td_options[] = array("sub_name" => 'Email',
            "desc" => " Enter your email url.",
            "id" => $this->tdthemename . "_email_url",
            "std" => "http://yourlink.com",
            "type" => "block_text");
        
        $td_options[] = array("sub_name" => 'Pinit',
            "desc" => "Enter your Pinit url",
            "id" => $this->tdthemename . "_pinit",
            "std" => "http://yourlink.com",
            "type" => "block_text");
          $td_options[] = array("sub_name" => 'Google Plus',
            "desc" => "Enter your Google+ url",
            "id" => $this->tdthemename . "_gplus",
            "std" => "http://yourlink.com",
            "type" => "block_text");
        
  $td_options[] = array("name" => "Payment Options",
            "type" => "heading");
         $td_options[] = array("name" => "Payment Icon",
            "desc" => "Upload Your Won Payment Icon",
            "id" => $this->tdthemename . "_paymenticon",
            "std" =>$themesimagepath.'payment.png',
            "type" => "upload");
  
            $td_options[] = array("name" => "Upload Payment Icon Link",
            "desc" => "Pyament Icon Link",
            "id" => $this->tdthemename . "_payment_icon_link",
            "std" => "http://yourlink.com",
            "type" => "text");
        
      $td_options[] = array("name" => 'Custom Theme Blocks',
            "type" => "heading");
          $td_options[] = array("name" => "Home Page Custom Statick  Block",
            "id" => $this->tdthemename . '_hcustomb_content',
            "lang" => true,
             "desc" => 'If you want to change custom statick block.',
            "std" => '<div class="block1 span6"><img src="'.$themesimagepath.'static-sample.png" alt="" /></div>
        <div class="block2 span6"><img src="'.$themesimagepath.'static-sample.png" alt="" /></div>',
            "type" => "textarea");
       $td_options[] = array("name" => 'Product Advertise Block',
            "desc" => 'Custom HTML design to show on product page.',
            "id" => $this->tdthemename . "_product_page_customhtml",
            "lang" => true,
            "std" => '
                 <div class="row-fluid">
                    <div class="block1 span6"><img alt="" src="'.$themesimagepath.'static-block.png"></div>
                    <div class="block2 span6"><img alt="" src="'.$themesimagepath.'static-block.png"></div>
                    </div>',
            "type" => "textarea");
  $td_options[] = array("name" => 'Custom Block',
            "desc" => 'If you want to use Custom Block  in left/right bar.',
            "id" => $this->tdthemename . '_edcustomblcok',
            "std" => "enable",
            "button_id" => array(21, 22),
            "options" => array('Enable', 'Disable'),
            "type" => "iphonebutton");
       $td_options[] = array("name" => 'Display Custom Block',
            "desc" => 'If you want to use Custom Block in left/right bar.',
            "id" => $this->tdthemename . '_display_cb',
            "std" => "enable",
            "button_id" => array(23, 24),
            "options" => array('Left', 'Right'),
            "type" => "iphonebutton");
  $td_options[] = array("name" => 'Custom Block',
            "desc" => 'Custom Block in left/right',
            "id" => $this->tdthemename . "_custom_blcok",
            "lang" => true,
            "std" => ' <h2>Custom block</h2>
 <p>You can manage this block From Theme Option Panel also manage laft or right</p>
<p><a href="#"><img src="'.$themesimagepath.'custom_culumn.png" /></a></p>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed velit urna, elementum at dignissim varius, euismod a elit. Praesent ornare metus eget metus commodo rhoncus.</p>
<p>&nbsp;</p>
<p><a href="#">Read more</a></p>',
            "type" => "textarea");
       
      
       
       $td_options[] = array("name" => 'Sidebar Block',
            "desc" => "Custom HTML design to show  on sidebar.",
            "id" => $this->tdthemename . "_left_sidebar_customhtml",
            "lang" => true,
            "std" => '<div class="block block-ads-left"><img alt="" src="'.$themesimagepath.'left_banner.png"></div> ',
            "type" => "textarea");
			
			
			
			$td_options[] = array("name" => 'Left Advertise Block',
            "desc" => 'Custom HTML design to show on Home page.',
            "id" => $this->tdthemename . "_left_one_customhtml",
            "lang" => true,
            "std" => '
                 <div class="row-fluid">
                    <div class="block1 span6"><img alt="" src="'.$themesimagepath.'static-block.png"></div>
                    <div class="block2 span6"><img alt="" src="'.$themesimagepath.'static-block.png"></div>
                    </div>',
            "type" => "textarea");
			
			$td_options[] = array("name" => 'Popup & GOSF Block',
            "desc" => 'Custom HTML design to Popup & GOSF content on Home page.',
            "id" => $this->tdthemename . "_left_pop_customhtml",
            "lang" => true,
            "std" => '
                 <div class="row-fluid">
                    <div class="block1 span6"><img alt="" src="'.$themesimagepath.'static-block.png"></div>
                    <div class="block2 span6"><img alt="" src="'.$themesimagepath.'static-block.png"></div>
                    </div>',
            "type" => "textarea");
			
			
				$td_options[] = array("name" => 'Popup Block for Floor Robot GOSF',
            "desc" => 'Custom HTML design to Popup & GOSF content Floor Robot page.',
            "id" => $this->tdthemename . "_left_fr_customhtml",
            "lang" => true,
            "std" => '
                 <div class="row-fluid">
                    <div class="block1 span6"><img alt="" src="'.$themesimagepath.'static-block.png"></div>
                    <div class="block2 span6"><img alt="" src="'.$themesimagepath.'static-block.png"></div>
                    </div>',
            "type" => "textarea");
			
			$td_options[] = array("name" => 'Popup Block for Body Robot GOSF',
            "desc" => 'Custom HTML design to Popup & GOSF content Body Robot page.',
            "id" => $this->tdthemename . "_left_br_customhtml",
            "lang" => true,
            "std" => '
                 <div class="row-fluid">
                    <div class="block1 span6"><img alt="" src="'.$themesimagepath.'static-block.png"></div>
                    <div class="block2 span6"><img alt="" src="'.$themesimagepath.'static-block.png"></div>
                    </div>',
            "type" => "textarea");
			
			$td_options[] = array("name" => 'Popup Block for Lawn Robot',
            "desc" => 'Custom HTML design to Popup & GOSF content Lawn Robot page.',
            "id" => $this->tdthemename . "_left_ln_customhtml",
            "lang" => true,
            "std" => '
                 <div class="row-fluid">
                    <div class="block1 span6"><img alt="" src="'.$themesimagepath.'static-block.png"></div>
                    <div class="block2 span6"><img alt="" src="'.$themesimagepath.'static-block.png"></div>
                    </div>',
            "type" => "textarea");
			
			$td_options[] = array("name" => 'Popup Block for Pool Robot',
            "desc" => 'Custom HTML design to Popup & GOSF content Pool Robot page.',
            "id" => $this->tdthemename . "_left_pr_customhtml",
            "lang" => true,
            "std" => '
                 <div class="row-fluid">
                    <div class="block1 span6"><img alt="" src="'.$themesimagepath.'static-block.png"></div>
                    <div class="block2 span6"><img alt="" src="'.$themesimagepath.'static-block.png"></div>
                    </div>',
            "type" => "textarea");
			
			$td_options[] = array("name" => 'Popup Block for Window Robot',
            "desc" => 'Custom HTML design to Popup & GOSF content Window Robot page.',
            "id" => $this->tdthemename . "_left_wr_customhtml",
            "lang" => true,
            "std" => '
                 <div class="row-fluid">
                    <div class="block1 span6"><img alt="" src="'.$themesimagepath.'static-block.png"></div>
                    <div class="block2 span6"><img alt="" src="'.$themesimagepath.'static-block.png"></div>
                    </div>',
            "type" => "textarea");
			
			$td_options[] = array("name" => 'Popup Block for TV Mount GOSF',
            "desc" => 'Custom HTML design to Popup & GOSF content TV Mount page.',
            "id" => $this->tdthemename . "_left_tv_customhtml",
            "lang" => true,
            "std" => '
                 <div class="row-fluid">
                    <div class="block1 span6"><img alt="" src="'.$themesimagepath.'static-block.png"></div>
                    <div class="block2 span6"><img alt="" src="'.$themesimagepath.'static-block.png"></div>
                    </div>',
            "type" => "textarea");
			
			$td_options[] = array("name" => 'Popup Block for Tablet-PC GOSF',
            "desc" => 'Custom HTML design to Popup & GOSF content Tablet-PC page.',
            "id" => $this->tdthemename . "_left_pc_customhtml",
            "lang" => true,
            "std" => '
                 <div class="row-fluid">
                    <div class="block1 span6"><img alt="" src="'.$themesimagepath.'static-block.png"></div>
                    <div class="block2 span6"><img alt="" src="'.$themesimagepath.'static-block.png"></div>
                    </div>',
            "type" => "textarea");
			
			
			$td_options[] = array("name" => 'Popup Block for RS GOSF',
            "desc" => 'Custom HTML design to Popup & GOSF content RS page.',
            "id" => $this->tdthemename . "_left_rs_customhtml",
            "lang" => true,
            "std" => '
                 <div class="row-fluid">
                    <div class="block1 span6"><img alt="" src="'.$themesimagepath.'static-block.png"></div>
                    <div class="block2 span6"><img alt="" src="'.$themesimagepath.'static-block.png"></div>
                    </div>',
            "type" => "textarea");
			
			
        $td_options[] = array("name" => "Footer Options",
            "type" => "heading");
          $td_options[] = array("name" => "Contact us",
            "desc" => "Add your Contact us information.",
            "id" => $this->tdthemename . "_conact_us",
             "lang" => true,
            "std" =>' <div class="footer-static-title">
                                            <h3>Contact Us</h3>
                                        </div>
                                        <div class="footer-static-content">
                                            <div class="f-address">
                                                <ul>
                                                    <li>FASHION STORE</li>
                                                    <li>1268 - Street Name, Anyname Road, Tower Name, United State</li>
                                                </ul>
                                            </div>
                                            <div class="f-phone">
                                                <div class="f-phone-icon">&nbsp;</div>
                                                <ul>
                                                    <li>(+123)1344356-675</li>
                                                    <li>(+123)4335356-452</li>
                                                </ul>
                                            </div>
                                            <div class="f-email">
                                                <div class="f-email-icon">&nbsp;</div>
                                                <ul>
                                                    <li>info@metrofas.com</li>
                                                    <li>contact@metrofas.com</li>
                                                </ul>
                                            </div>
                                        </div>',
            "type" => "textarea");
          
               $td_options[] = array("name" => 'Additional Links',
            "desc" => 'Additional Links on Footer.',
            "id" => $this->tdthemename.'_additionallinks',
            "std" => "enable",
            "button_id" => array(25,26),
            "options" => array('Enable', 'Disable'),
            "type" => "iphonebutton");
          
 $td_options[] = array("name" => 'Additional Links',
            "desc" => "You can use links or custom HTML here for showing footer of the page ",
            "id" => $this->tdthemename . "_additional_links",
            "lang" => true,
            "std" => '<li class="item"><a href="index.php?controller=prices-drop">Specials</a></li>
<li class="item"><a href="index.php?controller=new-products">New products</a></li>
<li class="item"><a href="index.php?controller=best-sales">Top sellers</a></li>
<li class="item"><a href="index.php?controller=stores">Our stores</a></li>
<li class="item"><a href="index.php?id_cms=4&controller=cms&id_lang=1">About us</a></li>
<li class="item"><a href="index.php?controller=contact">Contact us</a></li>
',
            "type" => "textarea");
        $td_options[] = array("name" => "Copyright info",
            "desc" => "Add your Copyright or some other notice.",
            "id" => $this->tdthemename . "_copyright",
            "std" => " &copy; 2012. All rights reserved. ThemesDeveloper.",
            "type" => "textarea");
  $td_options[] = array("name" => "Google Analytics",
            "desc" => "Paste your Google analytics code here.",
            "id" => $this->tdthemename . '_google_analytics',
            "std" => "",
            "type" => "textarea");



        $this->tdoptions = $td_options;
    }

    private function _includeAdminFile() {

        $this->_html = '
<link href="' . __PS_BASE_URI__ . 'modules/tdpsthemeoptionpanel/admin/css/admin-style.css" rel="stylesheet" type="text/css" />
<link href="' . __PS_BASE_URI__ . 'modules/tdpsthemeoptionpanel/admin/css/colorpicker.css" rel="stylesheet" type="text/css" />
<script type="text/javascript"  src="' . __PS_BASE_URI__ . 'modules/tdpsthemeoptionpanel/admin/js/jquery.maskedinput-1.2.2.js"></script>
<script type="text/javascript"  src="' . __PS_BASE_URI__ . 'modules/tdpsthemeoptionpanel/admin/js/colorpicker.js"></script>
<script type="text/javascript"  src="' . __PS_BASE_URI__ . 'modules/tdpsthemeoptionpanel/admin/js/medialibrary-uploader.js"></script>
<script type="text/javascript"  src="' . __PS_BASE_URI__ . 'modules/tdpsthemeoptionpanel/admin/js/jquery.maskedinput-1.2.2.js"></script>
<script type="text/javascript"  src="' . __PS_BASE_URI__ . 'modules/tdpsthemeoptionpanel/admin/js/jquery.tipsy.js"></script>
<link href="' . __PS_BASE_URI__ . 'modules/tdpsthemeoptionpanel/admin/css/bootstrap-trim.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript"  src="' . __PS_BASE_URI__ . 'modules/tdpsthemeoptionpanel/admin/js/prettify.js"></script>
<script type="text/javascript"  src="' . __PS_BASE_URI__ . 'modules/tdpsthemeoptionpanel/admin/js/bootstrap-trim.min.js"></script>
<script type="text/javascript"  src="' . __PS_BASE_URI__ . 'modules/tdpsthemeoptionpanel/admin/js/options-custom.js"></script>
    ';
    }

    public function getSaveOption($id) {
        return Configuration::get($id);
    }

    private function _tdOptionForm() {
        global $cookie;

        $tdoptionfields = $this->tdOptionPanelFields();

        $this->_fields = $tdoptionfields[0];
        $this->_tabs = $tdoptionfields[1];


        $this->_html .= '
            
           <div class="container custome-bg">
        <div id="td-popup-patterns-save" class="of-save-popup">
		<div class="for-button-save">Pattern Uploaded Successfully</div>
	</div>
        <div id="td-popup-save" class="of-save-popup">
		<div class="for-button-save">Theme Options Updated</div>
	</div>
        
	<div id="for-popup-reset" class="of-save-popup">
		<div class="for-button-reset">Theme Options Reset</div>
	</div>
        <form id="for_form" method="post" action="" enctype="multipart/form-data" >
            <div class="header_wrap">
                        <h2>' . $this->displayName . '</h2>
                        For future updates follow me <a href="http://themeforest.net/user/themesdev" target="_blank">@themeforest</a> or <a href="https://twitter.com/themesdeveloper" target="_blank">@twitter</a>

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
                     <button type="submit" class="savebutton btn-button save-button">Change Update</button>
               </div>
            	</form>
	
	<div style="clear:both;"></div>
        </div>';

        return $this->_html;
    }

  public function tdOptionPanelFields() {

        $tdoptions = $this->tdoptions;
        $optiondata = array();
        $count = 0;
        $tabs = '';
        $tdfieldsoutput = '';

        foreach ($tdoptions as $result) {

            $count++;
            if ($result['type'] != "heading") {
                $heading_class = '';
                if (isset($result['class'])) {
                    $heading_class = $result['class'];
                }
                
                
                $tdfieldsoutput .= '<div class="sectionupload  section-' . $result['type'] . ' ' . $heading_class . '">';
               
                if ($result['type'] != "innerheading") {
                if (isset($result['name']))
                    $tdfieldsoutput .= '<h3 class="heading">' . $result['name'] . '</h3>';
                }else{
                    $tdfieldsoutput .= '<h3 class="innerheading">' . $result['name'] . '</h3>';
                }
                if (isset($result['sub_name']))
                    $tdfieldsoutput .= '<h5>' . $result['sub_name'] . '</h5>';

                $tdfieldsoutput .= '<div class="option">';
                if (!isset($result['desc'])):
                    $tdfieldsoutput .= '<div class="manage managefull">';
                else:
                    $tdfieldsoutput .= '<div class="manage">';
                endif;
            }
      
            switch ($result['type']) {
                case 'block_text':

                    $type_value = $this->getSaveOption($result['id']);


                    $std = $this->getSaveOption($result['id']);
                    if ($std != "") {
                        $type_value = stripslashes($std);
                    }
                    $tdfieldsoutput .= '<input class="td-input" name="' . $result['id'] . '" id="' . $result['id'] . '" type="' . $result['type'] . '" value="' . $type_value . '" />';
                    break;
                case 'text':
                    $type_value = '';

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
$std = $this->getSaveOption($result['id'].'_'.$lang['id_lang']);
                                if ($std != "") {
                                     $type_value = stripslashes($std);
                                 }
                            $tdfieldsoutput .='<div id="' . $result['id'] . '_' . $lang['id_lang'] . '" style="display: ' . ($lang['id_lang'] == $defaultLanguage ? 'block' : 'none') . ';float: left;">';
                            $tdfieldsoutput .= '<input class="td-input" name="' . $result['id'] . '_' . $lang['id_lang'] . '" id="' . $result['id'] . '_' . $lang['id_lang'] . '" type="' . $result['type'] . '" value="' . $type_value . '" />';
                            $tdfieldsoutput .= '</div>';
                        }

                        $tdfieldsoutput .=$this->displayFlags($languages, $defaultLanguage, $divLangName, $result['id'], true);
                    else:
                        $tdfieldsoutput .= '<input class="td-input" name="' . $result['id'] . '" id="' . $result['id'] . '" type="' . $result['type'] . '" value="' . $type_value . '" />';
                    endif;

                    break;

                case 'select':


                    $tdfieldsoutput .= '<div class="for-body-selected">';
                    $tdfieldsoutput .= '<select class="of-typography of-typography-size select" name="' . $result['id'] . '" id="' . $result['id'] . '">';

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


                        $tdfieldsoutput .= '<option id="' . $select_key . '" value="' . $select_key . '" ' . $selected_value . ' />' . $option_val . '</option>';
                    }
                    $tdfieldsoutput .= '</select></div>';
                    break;

                case 'textarea':
                    $cols = '10';
                    $type_value = '';

                    /*if (isset($result['options'])) {
                        $text_option = $result['options'];
                        if (isset($text_option['cols'])) {
                            $cols = $text_option['cols'];
                        }
                    }*/
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
                                $std = $this->getSaveOption($result['id'].'_'.$lang['id_lang']);
                                if ($std != "") {
                                     $type_value = stripslashes($std);
                                 }
                            $tdfieldsoutput .='<div id="' . $result['id'] . '_' . $lang['id_lang'] . '" style="display: ' . ($lang['id_lang'] == $defaultLanguage ? 'block' : 'none') . ';float: left;">';
                            $tdfieldsoutput .= '<textarea class="td-input" name="' . $result['id'] . '_' . $lang['id_lang'] . '" id="' . $result['id'] . '_' . $lang['id_lang'] . '" cols="' . $cols . '" rows="8">' . $type_value . '</textarea>';
                            $tdfieldsoutput .= '</div>';
                        }

                        $tdfieldsoutput .=$this->displayFlags($languages, $defaultLanguage, $divLangName, $result['id'], true);
                    else:
                        $tdfieldsoutput .= '<textarea class="td-input" name="' . $result['id'] . '" id="' . $result['id'] . '" cols="' . $cols . '" rows="8">' . $type_value . '</textarea>';
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



                        $tdfieldsoutput .= '<input class="td-input of-radio" name="' . $result['id'] . '" type="radio" value="' . $option_val . '" ' . $checked . ' /><label class="radio">' . $name . '</label><br/>';
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

                    $tdfieldsoutput .= '<input type="hidden" class="' . 'checkbox aq-input" name="' . $result['id'] . '" id="' . $result['id'] . '" value="0"/>';
                    $tdfieldsoutput .= '<input type="checkbox" class="' . 'checkbox td-input" name="' . $result['id'] . '" id="' . $result['id'] . '" value="1" ' . $checked . ' />';
                    break;
                case 'upload':
                    $tdfieldsoutput .= $this->tdUploadImage($result['id'], $result['std']);
                    break;
                case 'color':
                    $type_value = '';
                    $std = $this->getSaveOption($result['id']);
                    if ($std != "") {
                        $type_value = stripslashes($std);
                    }
                    $tdfieldsoutput .= '<div id="' . $result['id'] . '_picker" class="selectColor"><div style="background-color: ' . $type_value . '"></div></div>';
                    $tdfieldsoutput .= '<input class="of-color" name="' . $result['id'] . '" id="' . $result['id'] . '" type="text" value="' . $type_value . '" />';
                    break;

                case 'typography':


                    $get_face = $this->getSaveOption($result['id'] . '_face');

                    $typography = $result['std'];

                    if (isset($typography['face'])) {
                        if (isset($result['section']) && $result['section'] == 'google') {
                            $tdfieldsoutput .= '<div id="'. $result['id'].'" ><h3>Lorem ipsum dolor sit amet</h3></div>';
                            
                        } else {
                            $tdfieldsoutput .= '<div id="demo_system"><h6>Lorem ipsum dolor sit amet</h6></div>';
                        }
                        $tdfieldsoutput .= '<div class="for-body-selected typography-face" original-title="Font family">';

                        $tdfieldsoutput .= '<select class="of-typography of-typography-face select" name="' . $result['id'] . '[face]" id="' . $result['id'] . '_face">';

                        $systemfont = array(
                            'arial'=>'Arial',
                            'open_sansregular'=>'open_sansregular',
                            'verdana'=>'Verdana, Geneva',
                            'trebuchet'=>'Trebuchet',
                            'georgia' =>'Georgia',
                            'Helvetica Neue' =>'Helvetica Neue',
                            'times'=>'Times New Roman',
                            'tahoma'=>'Tahoma, Geneva',
                            'Telex' => 'Telex',
                            'Droid%20Sans' => 'Droid Sans',
                            'Convergence' => 'Convergence',
                            'Oswald' => 'Oswald',
                            'News%20Cycle' => 'News Cycle',
                            'Yanone%20Kaffeesatz:300' => 'Yanone Kaffeesatz Light',
                            'Yanone%20Kaffeesatz:200' => 'Yanone Kaffeesatz ExtraLight',
                            'Yanone%20Kaffeesatz:400' => 'Yanone Kaffeesatz Regular',								
                            'Duru%20Sans' => 'Duru Sans',
                            'Open%20Sans' => 'Open Sans',
                            'PT%20Sans%20Narrow' => 'PT Sans Narrow',
                            'Macondo Swash Caps'=>'Macondo Swash Caps',
                            'Telex'=>'Telex' ,
                            'Sirin%20Stencil' => 'Sirin Stencil',
                            'Actor' => 'Actor',
                            'Iceberg' => 'Iceberg',
                            'Ropa%20Sans' => 'Ropa Sans',
                            'Amethysta' => 'Amethysta',
                            'Alegreya' => 'Alegreya',
                            'Germania One' => 'Germania One',
                            'Gudea' => 'Gudea',
                            'Trochut' => 'Trochut',
                            'Ruluko' => 'Ruluko',
                            'Alegreya' => 'Alegreya',
                            'Questrial' => 'Questrial',
                            'Armata' => 'Armata',
                            'PT%20Sans' => 'PT Sans'
                        );


                        $json = file_get_contents("https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyAToyXLB8uHcAgbwUkYIc94FX26pN-7R3M", true);
                        $decode = json_decode($json, true);
                        $google_web_fonts = array();
                        //print_r($json);
                        foreach ($decode['items'] as $key => $value) {

                            $item_family = $decode['items'][$key]['family'];
                            $fontvariants = $decode['items'][$key]['variants'];


                            $item_family_trunc = str_replace(' ', '+', $item_family);

                            $google_web_fonts[$item_family_trunc] = $item_family;
                        }

                        if (isset($result['section']) && $result['section'] == 'google') {
                            $webfont = $google_web_fonts;
                        } else {
                            $webfont = $systemfont;
                        }
                        foreach ($webfont as $key => $fontfamily) {
                                
                            $idfont = trim($key);
                            if (!empty($get_face)) {

                                if (isset($result['section']) && $result['section'] == 'google') {
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
                                if (isset($result['section']) && $result['section'] == 'google') {
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



                            if (isset($result['section']) && $result['section'] == 'google') {
                                $tdfieldsoutput .= '<option value="' . $key . '" ' . $selected_gval . '>' . $fontfamily . '</option>';
                            } else {
                                $tdfieldsoutput .= '<option value="' . $key . '" ' . $selected_value . '>' . $fontfamily . '</option>';
                            }
                        }

                        $tdfieldsoutput .= '</select>';



                        $tdfieldsoutput .= '</div>';
                    }
                    if (isset($typography['color'])) {

                        if (!empty($get_color)) {
                            $selected_value = $get_color;
                        } else {
                            $selected_value = $typography['color'];
                        }

                        $tdfieldsoutput .= '<div id="' . $result['id'] . '_color_picker" class="selectColor typography-color"><div style="background-color: ' . $selected_value . '"></div></div>';
                        $tdfieldsoutput .= '<input class="of-color of-typography of-typography-color" original-title="Font color" name="' . $result['id'] . '[color]" id="' . $result['id'] . '_color" type="text" value="' . $selected_value . '" />';
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

                        $tdfieldsoutput .= '<span>';
                        $tdfieldsoutput .= '<input type="radio" id="of-radio-img-' . $result['id'] . $i . '" class="checkbox of-radio-img-radio" value="' . $key . '" name="' . $result['id'] . '" ' . $selected_value . ' />';
                        $tdfieldsoutput .= '<div class="for-radio-picture-label">' . $key . '</div>';
                        $tdfieldsoutput .= '<img src="' . $option_val . '" alt="" class="radio-box-picture ' . $selected_value . '" onClick="document.getElementById(\'of-radio-img-' . $result['id'] . $i . '\').checked = true;" />';
                        $tdfieldsoutput .= '</span>';
                    }

                    break;
                case "image":
                    $src = $result['std'];
                    $tdfieldsoutput .= '<img src="' . $src . '">';
                    break;
                case 'heading':
                    if ($count >= 2) {
                        $tdfieldsoutput .= '</div>';
                    }

                    $tabs_class = str_replace(' ', '', strtolower($result['name']));
                    $click_heading = str_replace(' ', '', strtolower($result['name']));
                    $click_heading = "of-option-" . $click_heading;
                    $tabs .= '<li class="' . $tabs_class . ' "><a  data-toggle="tab" title="' . $result['name'] . '" href="#' . $click_heading . '">' . $result['name'] . '</a></li>';
                    $tdfieldsoutput .= '<div class="tab-pane" id="' . $click_heading . '"> <div class="alerts alert-success"><h4>' . $result['name'] . '</h4></div>' . "\n";



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

                    $tdfieldsoutput .='<p class="field switch">
                            <input type="radio" id="radio' . $result['button_id'][0] . '" name="' . $result['id'] . '" value="enable" '.$checked.' />
                            <input type="radio" id="radio' . $result['button_id'][1] . '" name="' . $result['id'] . '" value="disable" />
                            
                            <label for="radio' . $result['button_id'][0] . '" class="cb-enable ' . $anaselect . '"><span>' . $result['options'][0] . '</span></label>
                            <label for="radio' . $result['button_id'][1] . '" class="cb-disable ' . $disselet . '"><span>' . $result['options'][1] . '</span></label>
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
                                $selected_value = 'td-radio-tile-selected';
                            } else {
                                $selected_value = '';
                            }
                        } elseif ($std == $option_val) {
                            $selected_value = 'td-radio-tile-selected';
                        } else {
                            $selected_value = '';
                        }

                        $tdfieldsoutput .= '<span>';
                        $tdfieldsoutput .= '<input type="radio" id="td-radio-tile-' . $result['id'] . $i . '" class="checkbox td-radio-tile-radio" value="' . $option_val . '" name="' . $result['id'] . '" />';
                        $tdfieldsoutput .= '<div class="td-radio-tile-img ' . $selected_value . '" onClick="document.getElementById(\'td-radio-tile-' . $result['id'] . $i . '\').checked = true;"><img src="' . $option_val . '" width="50" height="50"></div>';
                        $tdfieldsoutput .= '</span>';
                    }

                    break;
            }
            if ($result['type'] != 'heading') {
                if (!isset($result['desc'])) {
                    $explain_value = '';
                } else {
                    $explain_value = '<div class="explain">' . $result['desc'] . '</div>';
                }
                $tdfieldsoutput .= '</div>' . $explain_value;
                $tdfieldsoutput .= '<div class="clear"> </div></div></div>';
            }
        }
        $tdfieldsoutput .= '</div>';

        return array($tdfieldsoutput, $tabs);
    }

    public function getAllPatern() {
        $all_paterns = array();
        $paterns_path = _PS_MODULE_DIR_ . 'tdpsthemeoptionpanel/patterns/';
        $paterns_url = __PS_BASE_URI__ . 'modules/tdpsthemeoptionpanel/patterns/';

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

    private function tdUploadImage($id, $std) {

        $upload_markup = '';
        $upload_image = $this->getSaveOption($id);

        if ($upload_image != "") {
            $value = $upload_image;
        } else {
            $value = $std;
        }

        $upload_markup .= '<input class="upload td-input" name="' . $id . '" id="' . $id . '_upload" value="' . $value . '" />';

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
            $upload_markup .= '<a class="td-uploaded-image" href="' . $upload_image . '">';
            $upload_markup .= '<img class="for-body-picture" id="image_' . $id . '" src="' . $upload_image . '" alt="" />';
            $upload_markup .= '</a>';
            $upload_markup .= '</div><div class="clear"></div>';
        }
        return $upload_markup;
    }

    public function hookTop() {
        global $smarty;
        $tdpsthemeoptionpanel = array();
        foreach ($this->tdoptions as $option_value):
            if ($option_value['type'] == 'typography') {
                foreach ($option_value as $values) {
                    if (is_array($values)) {
                        foreach ($values as $key => $typovalue) {
                            $tdpsthemeoptionpanel[$option_value['id'] . '_' . $key] = Configuration::get($option_value['id'] . '_' . $key);
                        }
                    }
                }
            }
            if (isset($option_value['id'])):
                $tdpsthemeoptionpanel[$option_value['id']] = Configuration::get($option_value['id']);
            endif;


            $languages = Language::getLanguages(false);
            if (isset($option_value['lang']) && $option_value['lang'] == true):

                foreach ($languages as $lang) {
                    $tdpsthemeoptionpanel[$option_value['id'] . '_' . $lang['id_lang']] = Configuration::get($option_value['id'] . '_' . $lang['id_lang']);
                }
                $tdpsthemeoptionpanel[$option_value['id']] = Configuration::get($option_value['id'] . '_' . $this->context->language->id);
            endif;
        endforeach;
        $smarty->assign('themesdev', $tdpsthemeoptionpanel);
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
   