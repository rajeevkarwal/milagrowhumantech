{*
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
*}
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{$lang_iso}">
    <head>
       <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
        <title>{$meta_title|escape:'htmlall':'UTF-8'}</title>
        {if isset($meta_description) AND $meta_description}
            <meta name="description" content="{$meta_description|escape:html:'UTF-8'}" />
        {/if}
        {if isset($meta_keywords) AND $meta_keywords}
            <meta name="keywords" content="{$meta_keywords|escape:html:'UTF-8'}" />
        {/if}
        <meta http-equiv="X-UA-Compatible" content="IE=9" />
        <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
        <meta http-equiv="content-language" content="{$meta_language}" />
        <meta name="generator" content="PrestaShop" />
        <meta name="robots" content="{if isset($nobots)}no{/if}index,{if isset($nofollow) && $nofollow}no{/if}follow" />
        <link rel="icon" type="image/vnd.microsoft.icon" href="{$favicon_url}?{$img_update_time}" />
        <link rel="shortcut icon" type="image/x-icon" href="{$favicon_url}?{$img_update_time}" />
        <script type="text/javascript">
            var baseDir = '{$content_dir}';
            var baseUri = '{$base_uri}';
            var static_token = '{$static_token}';
            var token = '{$token}';
            var priceDisplayPrecision = {$priceDisplayPrecision*$currency->decimals};
            var priceDisplayMethod = {$priceDisplay};
            var roundMode = {$roundMode};
        </script>
        <!--[if lt IE 7]>
        <script type="text/javascript">
        //<![CDATA[
            var BLANK_URL = '{$js_dir}theme/blank.html';
            var BLANK_IMG = '{$js_dir}theme/spacer.gif';
        //]]>
        </script>
        <![endif]-->
        {if isset($css_files)}
            {foreach from=$css_files key=css_uri item=media}
                <link href="{$css_uri}" rel="stylesheet" type="text/css" media="{$media}" />
            {/foreach}
        {/if}
        <link rel="stylesheet" type="text/css" href="{$css_dir}theme/styles.css" media="all" />
        {if $dedalx.metro_respinsive_support=="enable"}
            <link rel="stylesheet" type="text/css" href="{$css_dir}theme/responsive.css" media="all" />
          {/if}
        {if $page_name=="module-blockwishlist-mywishlist"}
            <script type="text/javascript" src="{$js_dir}jquery-1.7.2.min.js"></script>
        {/if}
        <script type="text/javascript" src="{$js_dir}theme/jquery.js"></script>
        {if isset($js_files)}
            {foreach from=$js_files item=js_uri}
                <script type="text/javascript" src="{$js_uri}"></script>
            {/foreach}
        {/if}
       <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="{$css_dir}theme/styles-ie.css" media="all" />
        <![endif]-->
        <!--[if lt IE 7]>
        <script type="text/javascript" src="{$js_dir}theme/ds-sleight.js"></script>
        <script type="text/javascript" src="{$js_dir}theme/ie6.js"></script>
        <![endif]-->
        <!-- SKIN ZOOM -->
       <script type="text/javascript" src="{$js_dir}theme/easyzoom.js"></script>
      {if $page_name=="product"} 
        <link rel="stylesheet" type="text/css" href="{$css_dir}theme/easyzoom.css" media="screen"/>
      {/if}
        <script type="text/javascript" src="{$js_dir}theme/jquery.prettyPhoto.js"></script>
        <script type="text/javascript" src="{$js_dir}theme/jquery.slider.js"></script>
      {if $page_name=="product" || $page_name=="index"} 
        <link rel="stylesheet" type="text/css" href="{$css_dir}theme/slider.css" media="all" />
       {/if}
        <link href='//fonts.googleapis.com/css?family={$dedalx.metro_shop_body_font_face}:regular,italic,700,700italic&subset=latin' rel='stylesheet' type='text/css'> 
        <link rel="stylesheet" type="text/css" href="{$css_dir}theme/menu2.css" media="screen"/>
        <script type="text/javascript" src="{$js_dir}theme/superfish.js"></script>
        <script type="text/javascript" src="{$js_dir}theme/script.js"></script>
       <link rel="stylesheet" type="text/css" href="{$css_dir}/custom.css" media="all" />
        <script type="text/javascript">
        jQuery(document).ready(function() {
        jQuery('.iosSlider').iosSlider({
        desktopClickDrag: true,
        touchMoveThreshold:4,
        snapToChildren: true,
        infiniteSlider: true,
        autoSlide:true,
        autoSlideTimer:8000,
        navSlideSelector: '.sliderNavi .naviItem',                
        navNextSelector: '.iosSlider .next',
        navPrevSelector: '.iosSlider .prev'
        }); 

        }); 
        </script>
            <script type="text/javascript">
                jQuery(document).ready(function() {
                // Image animation
                jQuery(".fade-image").live({
                mouseenter:
                    function()
                       {
                           jQuery(this).stop().fadeTo(300, 0.6);
                       },
                       mouseleave:
                           function()
                       {
                       jQuery(this).stop().fadeTo(300, 1);
                   }
               }
           );
           });
           </script>
           <style type="text/css">
                       body{
                   color:{$dedalx.metro_body_fonttext_color};
            {if $dedalx.metro_bgimages=="enable"}
                {if $dedalx.metro_custom_pattern}
                     background-image: url({$dedalx.metro_custom_pattern});  
                 {else}
                      background-image: url({$dedalx.metro_bg_pattern}); 
                 {/if}
              {else}
                background-image:none; 
              {/if}
              {if $dedalx.metro_bodybg_color}
                     background-color:{$dedalx.metro_bodybg_color}; 
               {/if}

                }  
           
            body, .buttons-cart-text, .box-product-item .name a, .box-product-item .price, h1, h2, button.button, .block .block-title strong span, #narrow-by-list dt, .block-cart-header .btn-checkout span, .form-subscribe-header h4, .product-view .product-shop .price-box .price, .price-box .price  {
		font-family:{if isset($dedalx.metro_shop_body_font_face)}{$dedalx.metro_shop_body_font_face}{else}Source Sans Pro{/if};
              }
                /* Colors */
        /* primary color  */        
       .mobile-menu-toggle,#header_mainmenu .mm_logo,.newproduct_grid, #nav > li:hover, #layered_block_left div.block_content,.left-categorys a,  .view-first:hover .bottom-block {
	    background-color:{$dedalx.metro_main_color} ; 
      }     
      /* all button color  */
      .search-bar,#header_mainmenu a.mm_wishlist,#header_mainmenu a.mm_checkout,.product-view .product-img-box .main-image .lightbox-btn a,input.button,button.button,
      #footer #message a,a.button,ul.step li.step_current span, ul.step li.step_done a, ul.step li.step_current_end span,.cart_total_price .total_price_container p,.pager .view-mode a.list,.view-mode strong.grid
     {
         background-color:{$dedalx.metro_buttonbg_color} ; 
           
      }
      #product_comments_block_extra a {
         
         color:{$dedalx.metro_buttonbg_color} ; 
      }
      
       .idTabs a{
            background-color:{$dedalx.metro_buttonbg_color} !important; 
       } 
      
      /** secend color  */
       .product-view .product-img-box .main-image .lightbox-btn a:hover,input.button:hover,button.button:hover,
      #footer #message a:hover,a.button:hover,#nav ul li a:hover,.search .button-search:hover,.prev:hover, .prev:focus, .next:hover, 
      .next:focus,.product-view-buttons-advance .btn-compare:hover,.product-view-buttons-advance .btn-wish:hover,
      .quantity_box_button_up:hover,.quantity_box_button_down:hover,#header_mainmenu .mm_shopcart,.box-product-item .btn-wish:hover, .box-product-item .btn-compare:hover,.products-list .btn-product .btn-wish:hover, .products-list .btn-product .btn-compare:hover,.left-categorys a:hover
     {
          background-color:{$dedalx.metro_second_color};
           
      }
      #product_comments_block_extra a:hover {
         
         color:{$dedalx.metro_second_color};
      }
      .footer-about .text h1,.footer-about .social h1 {
          color:{$dedalx.metro_second_color};
      }
      
       .idTabs a:hover,.idTabs a.select,.view-mode strong.grid:hover, .pager .view-mode a.list:hover, .view-mode strong.grid-active, .pager .view-mode a.list-active{
             background-color:{$dedalx.metro_second_color} !important; 
       }
       
      /* box color  */
      
      .view-first .bottom-block,.products-list li.item{
           background-color:{$dedalx.metro_itembox_color};   
       }

    {if $dedalx.metro_sell_newicon=="circle"}
      .newproduct_grid,.saleproduct{
        border-radius: 25px 25px 25px 25px;
     }
    {elseif $dedalx.metro_sell_newicon=="rounded_rectangle"}
         .newproduct_grid,.saleproduct{
        border-radius: 5px 5px 5px 5px;
      }  
    {else}
   
    {/if} 
            </style>
                    <script type="text/javascript">
                       jQuery(document).ready(function($){
                        {if $dedalx.metro_mini_advertise_images!='enable'}
                           $(".mini-sliders").hide(); 
                           $(".iosSlider").css("width", "100%"); 
                       {/if}
                       
                      {if $dedalx.metro_withleft_sidebar!='enable'}
                           $("#center_column div.main-container").removeClass('col2-left-layout');
                           $("#center_column div.main-container").addClass('col1-layout');
                           $("#center_column div.col-left").hide();
                           $("#center_column div.col1-layout ul.products-grid").css("width", "auto");
                           $("#center_column div.col1-layout ul.products-grid li").removeClass('margin-right');
                           $("#center_column div.col1-layout ul.products-grid li:nth-child(5n)").addClass('margin-right');    
                       {/if}

                       $(".grid").click(function(e) {
                       $(".category-products ol.products-list").hide();
                       $(".category-products ul.products-grid").show();
                       $('.list').removeClass('list-active');
                       $(this).addClass('grid-active');
                       e.preventDefault();
                    });
                    $(".list").click(function(e) {
                    $(".category-products ol.products-list").show();
                    $(".category-products ul.products-grid").hide();
                    $(this).addClass('list-active');
                    $('.grid').removeClass('grid-active');
                    e.preventDefault(); });
                    $(".link-compare").click(function(e) {
                    var idProduct = $(this).attr('id').replace('comparator_item_', '');
                    $.ajax({
                    url: 'index.php?controller=products-comparison&ajax=1&action=add&id_product=' + idProduct,
                    async: true,
                    dataType: "json",
                    success: function(responseData) {
                    if(responseData==0){   
                    alert("Allready added 3 products because  max value 3 products!");
                    }
                    else{
                    alert("Compare list Added Successfully!");  
                    }
                    },
                    error: function(){
                    }
                    });	
                    e.preventDefault();
                    });
                    $(".link-compare").click(function(e) {
                    e.preventDefault();
                    });
                    })
                       {if $dedalx.metro_product_view_style=="grid"}
                    jQuery(document).ready(function($){
                    $(".category-products ol.products-list").hide();
                    $(".category-products ul.products-grid").show();
                    $('.list').removeClass('list-active');
                    $('.grid').addClass('grid-active');
                    });
                       {else}
                    jQuery(document).ready(function($){
                    $(".category-products ol.products-list").show();
                    $(".category-products ul.products-grid").hide();
                    $('.list').addClass('list-active');
                    $('.grid').removeClass('grid-active');
                    });
                       {/if}
                    </script>
            
            
            
            {$HOOK_HEADER}
    </head>
    <body  {if isset($page_name)}id="{$page_name|escape:'htmlall':'UTF-8'}"{/if} class="{if $hide_left_column}hide-left-column{/if} {if $hide_right_column}hide-right-column{/if} {if $content_only} content_only {/if} cms-index-index cms-home">
        {if !$content_only}
            {if isset($restricted_country_mode) && $restricted_country_mode}
                <div id="restricted-country">
                    <p>{l s='You cannot place a new order from your country.'} <span class="bold">{$geolocation_country}</span></p>
                </div>
            {/if}
            <div class="wrapper">
                <div class="page">
                    <div id="top"></div>
                    <div id="header" >
                    <div id="header_menu" {if $PS_CATALOG_MODE}style="overflow: hidden;"{/if}>  
                        {$HOOK_TOP}
                    </div>         
       <div id="center_column">             
         {if $page_name=="index"}            
             <div class="main-container col1-layout">
                <div class="main">
                   <div class="col-main">
                      <div class="std">        
                        
                {/if}      
            {/if}     
            
            
      