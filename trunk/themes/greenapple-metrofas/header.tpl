<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7 " lang="{$lang_iso}"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8 ie7" lang="{$lang_iso}"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9 ie8" lang="{$lang_iso}"> <![endif]-->
<!--[if gt IE 8]>
<html class="no-js ie9" lang="{$lang_iso}"> <![endif]-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{$lang_iso}">
<head>

    <link rel="dns-prefetch" href="//sg12.zopim.com" />	
    <link rel="dns-prefetch" href="//v2.zopim.com" />	
    <link rel="dns-prefetch" href="//connect.facebook.net" />
    <link rel="dns-prefetch" href="//facebook.com" />
    <link rel="dns-prefetch" href="//google.co.in" />
    <link rel="dns-prefetch" href="//google.com" />
    <link rel="dns-prefetch" href="//google.com" />
    <link rel="dns-prefetch" href="//googleads.g.doubleclick.net" />
    <link rel="dns-prefetch" href="//googleadservices.com" />
    <link rel="dns-prefetch" href="//google-analytics.com" />
    <link rel="dns-prefetch" href="//gstatic.com" />
    <link rel="dns-prefetch" href="//apis.google.com" />
    <link rel="dns-prefetch" href="//ajax.googleapis.com" />
    <link rel="dns-prefetch" href="//hub.loginradius.com" />
    <link rel="dns-prefetch" href="//share.loginradius.com" />
    <link rel="dns-prefetch" href="//cdn.loginradius.com" />
    <link rel="dns-prefetch" href="//assets.pinterest.com" />
    <link rel="dns-prefetch" href="//fonts.gstatic.com" />
    <link rel="dns-prefetch" href="//partner.googleadservices.com" />
    <link rel="dns-prefetch" href="//pagead2.googlesyndication.com" />
    <link rel="dns-prefetch" href="//tpc.googlesyndication.com" />

<meta name="google-site-verification" content="eSfGY8v6gYYwG0uEf9q4A7YB4qlOOm29tsG1N78f-TY" />
<title>{$meta_title|escape:'htmlall':'UTF-8'}</title>
{if isset($meta_description) AND $meta_description}
    <meta name="description" content="{$meta_description|escape:html:'UTF-8'}"/>
{/if}
{if isset($meta_keywords) AND $meta_keywords}
    <meta name="keywords" content="{$meta_keywords|escape:html:'UTF-8'}"/>
{/if}
    {if $base_uri=='http://milagrowhumantech.com/'}
    <meta name="p:domain_verify" content="73c4080908b3ed59b1b2605545bfc4f1"/>
    {/if}
<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1"/>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8"/>
<meta http-equiv="content-language" content="{$meta_language}"/>
<meta name="generator" content="Milagrowhumantech.com"/>
<meta name="robots" content="{if isset($nobots)}no{/if}index,{if isset($nofollow) && $nofollow}no{/if}follow"/>
<link rel="icon" type="image/vnd.microsoft.icon" href="{$favicon_url}?{$img_update_time}"/>
<link rel="shortcut icon" type="image/x-icon" href="{$favicon_url}?{$img_update_time}"/>
<script type="text/javascript">
    var baseDir = '{$content_dir}';
    var baseUri = '{$base_uri}';
    var static_token = '{$static_token}';
    var token = '{$token}';
    var priceDisplayPrecision = {$priceDisplayPrecision*$currency->decimals};
    var priceDisplayMethod = {$priceDisplay};
    var roundMode = {$roundMode};
</script>
{if isset($css_files)}
    {foreach from=$css_files key=css_uri item=media}
        <link href="{$css_uri}" rel="stylesheet" type="text/css" media="{$media}"/>
    {/foreach}
{/if}
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script type="text/javascript" src="{$js_dir}theme/jquery.js"></script>
<script type="text/javascript" src="{$js_dir}theme/ma.jq.slide.js"></script>
<script type="text/javascript" src="{$js_dir}theme/ma.flexslider.js"></script>
<script type="text/javascript" src="{$js_dir}theme/ma.mobilemenu.js"></script>
<script type="text/javascript" src="{$js_dir}theme/bootstrap.min.js"></script>
<script type="text/javascript" src="{$js_dir}theme/bootstrap-tooltip.js"></script>
<script type="text/javascript" src="{$js_dir}theme/ma.accordion.js"></script>
<script type="text/javascript" src="{$js_dir}theme/ma.script.vert.js"></script>
{if isset($js_files)}
    {foreach from=$js_files item=js_uri}
        <script type="text/javascript" src="{$js_uri}"></script>
    {/foreach}
{/if}

<script type="text/javascript" src="{$js_dir}theme/jquery.carouFredSel-6.2.1-packed.js"></script>
<!--[if lt IE 7]>
<script type="text/javascript">
    //<![CDATA[
        var BLANK_URL = '{$js_dir}theme/blank.html';
        var BLANK_IMG = '{$js_dir}theme/spacer.gif';
    //]]>
    </script>
    <![endif]-->

<link rel="stylesheet" type="text/css" href="{$css_dir}theme/bootstrap.css" media="all"/>
<link rel="stylesheet" type="text/css" href="{$css_dir}theme/bootstrap-responsive.css" media="all"/>
<link rel="stylesheet" type="text/css" href="{$css_dir}theme/styles_skin3.css" media="all"/>
<link rel="stylesheet" type="text/css" href="/js/jquery/plugins/fancybox/jquery.fancybox.css" media="all"/>

<script type="text/javascript" src="{$js_dir}theme/backtotop.js"></script>
<script type="text/javascript" src="{$js_dir}theme/js.js"></script>
<script type="text/javascript" src="{$js_dir}lazyload.js"></script>


<!--<script type="text/javascript" src="{$js_dir}theme/jquery.selectbox.js"></script>-->
<link rel="stylesheet" type="text/css" href="{$css_dir}theme/ma.newslider.css" media="all"/>
<script type="text/javascript" src="{$js_dir}theme/ma.zoom.js"></script>
{*<script type="text/javascript" src="{$js_dir}theme/superfish.js"></script>*}
{*<script type="text/javascript" src="{$js_dir}theme/superfish.js"></script>*}
<script type="text/javascript" src="{$js_dir}theme/menu/jquery.hoverIntent.minified.js"></script>
<script type="text/javascript" src="{$js_dir}theme/menu/jquery.dcmegamenu.1.3.3.js"></script>
<script type="text/javascript" src="/js/jquery/plugins/fancybox/jquery.fancybox.js"></script>
<link href="//fonts.googleapis.com/css?family={$themesdev.td_shop_heading_font_face}" rel="stylesheet" type="text/css"
      media="all"/>
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>

{*<link rel="stylesheet" type="text/css" href="{$css_dir}theme/fish_menu.css" media="screen"/>*}
<link id="test" href="{$css_dir}/theme/menu/default.css" rel="stylesheet" type="text/css" />
<link id="test" href="{$css_dir}/theme/wide_menu.css" rel="stylesheet" type="text/css" />

<style type="text/css">
    body {
    {if $themesdev.td_enableordisable_bg=="enable"} {if $themesdev.td_body_bg_custom!=""} background: url("{$themesdev.td_body_bg_custom}") {$themesdev.td_bgrepeat} {$themesdev.td_bgattachment} {$themesdev.td_bgposition} {$themesdev.td_body_bg_color} !important;
    {else} background: url("{$themesdev.td_body_bg}") {$themesdev.td_bgrepeat} {$themesdev.td_bgattachment} {$themesdev.td_bgposition} {$themesdev.td_body_bg_color} !important;
    {/if} {else} background: none repeat scroll 0 0 {$themesdev.td_body_bg_color} !important;
    {/if} color: {$themesdev.td_body_font_color};
        font-family: '{$themesdev.td_shop_body_font_face}';
    }

    .page-title h1, .page-title h2, .block .block-title strong, .block-right-static .block-title h3, .block-subscribe-right .block-title h3, .ma-mostviewed-product-title h2, .ma-upsellslider-container .product-name, .ma-newproductslider-container .product-name, .products-grid .product-name, .ma-featured-product-title h2, .ma-newproductslider-title h2, .products-list .product-name, .product-collateral h2, .product-view .product-shop .product-name h1, .product-view .box-up-sell h2, .footer-freeshipping h3, .footer-subscribe .form-subscribe-header h4, .ma-footer-static .footer-static-title h3, .product-tabs a, .wine_menu a, .fish_menu a, .wine_menu ul li a {
        font-family: '{$themesdev.td_shop_heading_font_face}';
    }

    ul.step li.step_current span, .view-mode strong.grid:hover, .product-view .product-shop .add-to-links .link-compare:hover span, .product-view .product-shop .add-to-links .link-wishlist:hover span, .pager .view-mode a.list:hover, .view-mode strong.grid-active, .pager .view-mode a.list-active, .ac_over, .selectbox li.selected, .selectbox li:hover, ul.step li.step_done a, .cart_total_price .total_price_container p, ul.step li.step_current_end span, .label-pro-new, #add_to_cart .btn-cart, .fish_menu li.active a, div.alert, .product-view button.btn-cart span {
        background-color: {$themesdev.td_mainColor} !important;
    }

    .custom_block_left #custom_box_icon, .custom_block_right #custom_box_icon, button.button span, .products-list .link-compare:hover span, .products-list .link-wishlist:hover span, a.button span, .header .form-search button.button:hover span, .ma-newproductslider-container .item-inner:hover .actions, .products-grid .item:hover .actions, .ma-brand-slider-contain .flex-direction-nav a, .ma-brand-slider-contain .flex-direction-nav .flex-next, .ma-new-vertscroller-wrap .jcarousel-next-vertical:hover, .ma-new-vertscroller-wrap .jcarousel-prev-vertical:hover, .add-to-cart input.qty-decrease:hover, .add-to-cart input.qty-increase:hover, .product-prev:hover, .product-next:hover, .ma-thumbnail-container .flex-direction-nav a:hover, .footer-freeshipping .shipping-icon, .wine_menu li.active a, .fish_menu li.active a, .wine_menu li.over a, .fish_menu li.over a, .wine_menu a:hover, .fish_menu a:hover, #back-top, .content-sample-block .block2 img, .productpage-sample-block .block1 img {
        background-color: {$themesdev.td_mainColor};
    }

    .selectbox li.selected a, .selectbox li:hover a {
        color: #FFFFFF !important;
    }

    .products-list button.button:hover span, .productdetail button.button:hover span {
        background-color: {$themesdev.td_mainColor} !important;
    }

    a:hover, .fish_menu li ul li a:hover, #availability_statut #availability_value {
        color: {$themesdev.td_mainColor} !important;
    }

    .products-grid .item-inner:hover, .ma-newproductslider-container .item-inner:hover {
        border-color: {$themesdev.td_mainColor};
    }

    .custom_block_right .custom_box, .custom_block_left .custom_box {
        border: 4px solid {$themesdev.td_mainColor} !important;
    }

    .fish_menu ul,
    .fish_menu div {
        border: 1px solid {$themesdev.td_mainColor};
    }

    .fish_menu ul ul,
    .fish_menu ul div {
        border: 1px solid {$themesdev.td_mainColor};
    }

    .ma-newproductslider-container .actions, .product-view .product-shop .add-to-links .link-compare span, .product-view .product-shop .add-to-links .link-wishlist span, .products-list .link-compare span, .products-list .link-wishlist span, .view-mode strong.grid, .pager .view-mode a.list, .label-pro-sale, .products-grid .actions, .ma-brand-slider-contain .flex-direction-nav a:hover, .ma-footer-static-container, .ma-nav-mobile-container, .ma-nav-container, .content-sample-block .block1 img, .productpage-sample-block .block2 img {
        background-color: {$themesdev.td_secondcolor};
    }

    #add_to_cart .btn-cart:hover, .product-view button.btn-cart:hover span {
        background-color: {$themesdev.td_secondcolor} !important;
    }

    .idTabs a.selected, .idTabs a:hover {
        border-top: 3px solid {$themesdev.td_mainColor};
    }

    a, .breadcrumbs li strong, .pager .pages a:hover, .pager .pages .current, .header .welcome-msg a, .header .currency-language .language-switcher a:hover, .header .links li a:hover, .top-cart-contain .price, .block .block-title strong .word2, .block-right-static .block-title strong, .block-subscribe-right .block-title strong, .block-account .block-content li a:hover, .block-account .block-content li.current, .block-layered-nav li:hover, .block-layered-nav li a:hover, .ma-featured-product-title h2 .word2, .ma-newproductslider-title h2 .word2, .products-list .product-name a:hover, .product-view .product-shop .availability span, .price-box .price, .regular-price, .regular-price .price, .block .regular-price, .block .regular-price .price, .special-price .price-label, .special-price .price, .add-to-cart .qty, .product-collateral h2 .word2, .product-view .product-shop .product-sku span, .product-view .product-shop .product-brand span, .product-view .product-shop .add-to-links a:hover, .email-friend a:hover, .ma-footer-static .fcol1 li:hover, .ma-footer-static .fcol1 li a:hover, .mobilemenu li.active a, .mobilemenu a:hover, #ticker a {
        color: {$themesdev.td_mainColor};
    }

    .alert {
        z-index: 100000;
        position: fixed;
        top: 0px;
        right: 40%;
        color: white;
        text-shadow: none;
    }


</style>



<script type="text/javascript">
    function updateRenderPosition() {
        var scrollHeight = 100;
        if ($('body').attr('id') == 'index')
            scrollHeight = 770;
        if ($(document).scrollTop() > scrollHeight) {
            $('.compare-cart-wrapper').addClass('compare-scroll');
        }

    }
    function getCompareProducts() {
        $.ajax({
            type: 'POST',
            url: baseDir + 'index.php?fc=module&module=featurecategories&controller=compare',
            async: true,
            cache: false,
            data: 'action=show',
            success: function (jsonData, textStatus, jqXHR) {
                if ($.trim(jsonData)) {
                    $('#compare_block').addClass('compare_block_height');
                    $('#fc_comparison').empty().html(jsonData);
                    updateRenderPosition();
                }
                else {
                    $('#compare_block').removeClass('compare_block_height');
                    $('#fc_comparison').empty().html(jsonData);
                    updateRenderPosition();
                }
            }
        });
    }
    jQuery(document).ready(function ($) {
        $("img.lazy").lazyload({
            effect : "fadeIn",
            failurelimit : 25
        });

        $('.link-compare').live('click', function () {
            var idProduct = $(this).attr('id').replace('comparator_item_', '');
            $.ajax({
                url: baseDir + 'index.php?fc=module&module=featurecategories&controller=compare&action=add&productId=' + idProduct,
                async: true,
                dataType: "json",
                success: function (responseData) {
                    if (responseData == 0) {

                        jQuery('body').append('<div class="alert"></div>');
                        var $alert = jQuery('.alert');
                        $alert.fadeIn(400);
                        var message = "<p>{l s='Allready added max value products!'}</p>";
                        $alert.html(message);
                        $alert.fadeIn('400', function () {
                            setTimeout(function () {
                                $alert.fadeOut('400', function () {
                                    jQuery(this).fadeOut(400, function () {
                                        jQuery(this).detach();
                                    })
                                });
                            }, 2000)
                        });
                        getCompareProducts();

                    }
                    else if (responseData == 3) {
                        jQuery('body').append('<div class="alert"></div>');
                        var $alert = jQuery('.alert');
                        $alert.fadeIn(400);
                        var message = "<p>{l s='You can\'t compare selected item with existing products '}</p>";
                        $alert.html(message);
                        $alert.fadeIn('400', function () {
                            setTimeout(function () {
                                $alert.fadeOut('400', function () {
                                    jQuery(this).fadeOut(400, function () {
                                        jQuery(this).detach();
                                    })
                                });
                            }, 2000)
                        });
                        getCompareProducts();
                    }
                    else if (responseData == 4) {
                        var content = $('#fancybox-accessory-comparison-error').html();
                        var accessoryErrorFancyBox = new Object();
                        accessoryErrorFancyBox.content = content;
                        accessoryErrorFancyBox.height = 110;
                        accessoryErrorFancyBox.width = 600;
                        accessoryErrorFancyBox.autoDimensions = false;

                        $.fancybox(accessoryErrorFancyBox);
                        {*jQuery('body').append('<div class="alert"></div>');*}
                        {*var $alert = jQuery('.alert');*}
                        {*$alert.fadeIn(400);*}
                        {*var message = "<p>{l s='Sorry! Accessories can\'t be compared. Please use the filters on the product category screen to choose the correct accessory. \n In case you need help in selecting the correct accessory, please contact us via email on <a href="mailto:customercare@milagrow.in" target="_top">customercare@milagrow.in</a> or call us at 09953476189, 0124-4309570/71/72.\nTimings: 9:30 AM - 6:30 PM.'}</p>";*}
                        {*$alert.html(message);*}
                        {*$alert.fadeIn('400', function () {*}
                        {*setTimeout(function () {*}
                        {*$alert.fadeOut('400', function () {*}
                        {*jQuery(this).fadeOut(400, function () {*}
                        {*jQuery(this).detach();*}
                        {*})*}
                        {*});*}
                        {*}, 8000)*}
                        {*});*}
                        getCompareProducts();
                    }

                    else if (responseData == 1) {
                        jQuery('body').append('<div class="alert"></div>');
                        var $alert = jQuery('.alert');
                        $alert.fadeIn(400);
                        var message = "<p>{l s='Compare list Added Successfully!'}</p>";
                        $alert.html(message);
                        $alert.fadeIn('400', function () {
                            setTimeout(function () {
                                $alert.fadeOut('400', function () {
                                    jQuery(this).fadeOut(400, function () {
                                        jQuery(this).detach();
                                    })
                                });
                            }, 2000)
                        });
                        getCompareProducts();

                    }

                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {

                }
            });
        });

        $(".link-compare").live('click', function (e) {
            e.preventDefault();
        });
    })

    function WishlistCart(id, action, id_product, id_product_attribute, quantity) {
        $.ajax({
            type: 'GET',
            url: baseDir + 'modules/blockwishlist/cart.php',
            async: false,
            cache: false,
            data: 'action=' + action + '&id_product=' + id_product + '&quantity=' + quantity + '&token=' + static_token + '&id_product_attribute=' + id_product_attribute,
            success: function (data) {
                data = $.trim(data);
                if (action == 'add' && data == 'You must be logged in to manage your wishlist.') {
                    showLoginPopup();
                }
                if (action == 'add' && data != 'You must be logged in to manage your wishlist.') {
                    jQuery('body').append('<div class="alert"></div>');
                    var $alert = jQuery('.alert');
                    $alert.fadeIn(400);
                    var message = "<span></span><p>{l s='Wishilist Added Successfully!'}</p>";
                    $alert.html(message);

                    $alert.fadeIn('400', function () {
                        setTimeout(function () {
                            $alert.fadeOut('400', function () {
                                $(this).fadeOut(400, function () {
                                    jQuery(this);
                                })
                            });
                        }, 7000)
                    });
                }
                if (action == 'delete' && data != 'You must be logged in to manage your wishlist.') {
                    jQuery('body').append('<div class="alert"></div>');
                    var $alert = jQuery('.alert');
                    $alert.fadeIn(400);
                    var message = "<span></span><p>{l s='Wishilist Delete Successfully!'}</p>";
                    $alert.html(message);

                    $alert.fadeIn('400', function () {
                        setTimeout(function () {
                            $alert.fadeOut('400', function () {
                                $(this).fadeOut(400, function () {
                                    jQuery(this);
                                })
                            });
                        }, 7000)
                    });
                }

                if ($('#' + id).length != 0) {
                    $('#' + id).slideUp('normal');
                    document.getElementById(id).innerHTML = data;
                    $('#' + id).slideDown('normal');
                }
            }
        });
    }


</script>

{$HOOK_HEADER}


{*<script type="text/javascript" src="/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" href="/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />*}
<script type="text/javascript" src="{$js_dir}custom.js"></script>
<link rel="stylesheet" type="text/css" href="{$css_dir}custom.css" media="all"/>
<link rel="stylesheet" media='screen and (max-width: 1024px)' href="{$css_dir}tablet.css"/>
</head>
<body {if isset($page_name)}id="{$page_name|escape:'htmlall':'UTF-8'}"{/if}
      class="{if $hide_left_column} {/if} {if $hide_right_column} {/if} {if $content_only}{/if} cms-index-index cms-home">
{if !$content_only}
{if isset($restricted_country_mode) && $restricted_country_mode}
    <div id="restricted-country">
        <p>{l s='You cannot place a new order from your country.'} <span class="bold">{$geolocation_country}</span></p>
    </div>
{/if}

<div class="ma-wrapper">
    <div class="ma-page">
        <div class="ma-header-wrapper" id="header">

            {$HOOK_TOP}
        </div>
        <div id="center_column">
            {if $page_name!="index"}
            <div class="ma-main-container {if $page_name=="index" || $page_name=="category" || $page_name=="supplier" || $page_name=="best-sales" || $page_name=="cms" || $page_name=="contact" || $page_name=="manufacturer" || $page_name=="my-account" ||
            $page_name=="product" ||  $page_name=="new-products" || $page_name=="prices-drop" || $page_name=="search" ||  $page_name=="sitemap" || $page_name=="stores" || $page_name=="module-blockwishlist-mywishlist"} col2-left-layout{else}col1-layout{/if}">
                <div class="container">
                    <div class="contain-size">
                        {/if}
                        {/if}
