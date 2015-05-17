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
{if $page_name=="index"}
</div>
</div>
</div>
</div>
{/if}
</div>
</div>



{if !$content_only}
<div class="footer-about">
    {$dedalx.metro_about_us|html_entity_decode}
    {$dedalx.metro_address|html_entity_decode}

    <div class="clear">&nbsp;</div>
</div>        

<div class="footer-container">
    <div class="additional-footer">

        <div class="social-icons">
            <p>
            {if $dedalx.metro_facebook_url !=''} <a class="soc-img" href="{$dedalx.metro_facebook_url}" target="_blank"><img class="fade-image" src="{$img_dir}metroshop/social/facebook.png" alt="" /></a>{/if} 
        {if $dedalx.metro_twitter_url !=''}<a class="soc-img" title="{l s='Twitter'}" href="{$dedalx.metro_twitter_url}"> <img class="fade-image" src="{$img_dir}metroshop/social/twitter.png" alt="" /></a> {/if}
    {if $dedalx.metro_google_url !=''} <a class="soc-img" href="{$dedalx.metro_google_url}" target="_blank"><img class="fade-image" src="{$img_dir}metroshop/social/google-plus.png" alt="" /></a>{/if}
{if $dedalx.metro_pinterest_url !=''} <a class="soc-img" href="{$dedalx.metro_pinterest_url} " target="_blank"><img class="fade-image" src="{$img_dir}metroshop/social/pinterest.png" alt="" /></a>{/if}
{if $dedalx.metro_rss_url !=''} <a class="soc-img" href="{$dedalx.metro_rss_url}" target="_blank"><img class="fade-image" src="{$img_dir}metroshop/social/rss.png" alt="" /></a>{/if}
{if $dedalx.metro_skype_url !=''} <a class="soc-img" href="{$dedalx.metro_skype_url} " target="_blank"><img class="fade-image" src="{$img_dir}metroshop/social/skype.png" alt="" /></a>{/if}

</p>
</div>
{$HOOK_FOOTER}

<div class="column">
{*    <h3>{$dedalx.metro_twitter_titel}</h3>
   <div class="twitter-posts">
 <script type="text/javascript" charset="utf-8" src="{$js_dir}twitter/jquery.tweet.js"></script>   
<script type="text/javascript">
jQuery(document).ready(function($) {
$('#twitter_update_list').tweet({
 modpath: '{$js_dir}twitter/',
 count:{$dedalx.metro_tweet_count},
 username: '{$dedalx.metro_twitter_id}',
loading_text: 'loading twitter feed...'
});
});
</script>
  
    <ul id="twitter_update_list"></ul>
   
</div>*}
    <h3>Extra</h3>
    <ul>
        <li><a href="#">Deals</a></li>
        <li><a href="#">Combo Offers</a></li>
        <li><a href="#">Demo Videos</a></li>
        <li><a href="#">Videos</a></li>
        <li><a href="#">Buying Guides</a></li>
    </ul>

</div>


<div class="column">
    {*<h3>{$dedalx.metro_facebook_titel}</h3>
    <!-- Facebook -->
    <style type="text/css">
        .facebookOuter {
            background-color:transparent; 

            padding:0px;

            border:none;
        }
        .facebookInner {

            overflow:hidden;
        }

    </style>
    
<div class="facebookOuter">
 <div class="facebookInner">
    
             {if $dedalx.metro_facebook_page_url}
                <div class="fb-like-box" data-href="{$dedalx.metro_facebook_page_url}" data-width="435" data-height="205" data-show-faces="true" data-colorscheme="dark" data-stream="false" data-show-border="false"  data-border-color="#1F2B36" data-header="false"></div>
            {else}
                <iframe src="http://www.facebook.com/plugins/likebox.php?id={$dedalx.metro_facebook_page_id}&amp;width=292&amp;colorscheme=light&amp;border_color&amp;show_faces=true&amp;connections=6&amp;stream=false&amp;header=258&amp;height=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:292px; height:258px;" allowTransparency="true"></iframe>
            {/if}  
  
 </div>
</div>
           
 <div id="fb-root"></div>
    <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    </script>


</div>*}
        <h3>Extra</h3>
            <ul>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Media</a></li>
                <li><a href="#">Testimonials</a></li>
                <li><a href="#">Achievements</a></li>
                <li><a href="#">Downloads</a></li>
            </ul>
</div>

</div>
</div>

<div class="footer">
    <div class="footer-left">
         {$dedalx.metro_aditional_links|html_entity_decode}
            <br />
         {$dedalx.metro_copyright|html_entity_decode}
    </div>
    <div class="footer-right">
        <div id="paymenticons">
                        {if $dedalx.metro_paypal_url !=''}<a href="{$dedalx.metro_paypal_url}" target="_blank"><img src="{$img_dir}payment/PayPal.png" alt="" align="absmiddle" /></a>{/if}
        {if $dedalx.metro_visa_url !=''} <a href="{$dedalx.metro_visa_url}" target="_blank"><img src="{$img_dir}payment/Visa.png" alt="" align="absmiddle" /></a>{/if}
    {if $dedalx.metro_mastercard_url !=''} <a href="{$dedalx.metro_mastercard_url}" target="_blank"><img src="{$img_dir}payment/MasterCard.png" alt="" align="absmiddle" /></a>{/if}
{if $dedalx.metro_discover_url !=''} <a href="{$dedalx.metro_discover_url}" target="_blank"><img src="{$img_dir}payment/Discover.png" alt="" align="absmiddle" /></a>{/if}
{if $dedalx.metro_maestro_url !=''} <a href="{$dedalx.metro_maestro_url}" target="_blank"><img src="{$img_dir}payment/Maestro.png" alt="" align="absmiddle" /></a>{/if}
{if $dedalx.metro_americanexpress_url !=''} <a href="{$dedalx.metro_americanexpress_url}" target="_blank"><img src="{$img_dir}payment/AmericanExpress.png" alt="" align="absmiddle" /></a>{/if}
{if $dedalx.metro_cirrus_url !=''} <a href="{$dedalx.metro_cirrus_url}" target="_blank"><img src="{$img_dir}payment/Cirrus.png" alt="" align="absmiddle" /></a>{/if}
{if $dedalx.metro_visaelectron_url !=''} <a href="{$dedalx.metro_visaelectron_url}" target="_blank"><img src="{$img_dir}payment/VisaElectron.png" alt="" align="absmiddle" /></a>{/if}
        </div>     
    </div>
</div>
</div>
{/if}
 <link rel="stylesheet" type="text/css" href="{$css_dir}theme/widgets.css" media="all" />
 <link rel="stylesheet" type="text/css" href="{$css_dir}theme/print.css" media="print" />
{if isset($dedalx.metro_add_custom_css)}{$dedalx.metro_add_custom_css|html_entity_decode}{/if}
  {if isset($dedalx.metro_add_custom_js)}{$dedalx.metro_add_custom_js|html_entity_decode}{/if}
     <!--[if IE 7]>
              <link rel="stylesheet" type="text/css" href="{$css_dir}theme/ie7.css" media="screen"/>
          <![endif]-->
        <!--[if IE 9]>
            <link rel="stylesheet" type="text/css" href="{$css_dir}theme/ie9.css" media="screen"/>
        <![endif]-->
</body>
</html>
