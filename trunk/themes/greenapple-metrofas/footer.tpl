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
{if !$content_only}

    {if $page_name=='index'}
        </div>

        </div>
        </div>
        </div>
        </div>
        </div>
    {/if}

    {if $page_name!="index"}
        </div>
        </div>
        </div>
    {/if}
    <div class="ma-footer-static-container">
        <div class="container">
            <div class="contain-size">
                <div class="ma-footer-static">
                    <div class="row-fluid show-grid">
                        {$HOOK_FOOTER}
                        <div class="span3 fcol1">
                            <div class="footer-static-title">
                                <h3>About Milagrow</h3>
                            </div>
                            <div class="footer-static-content">
                                <ul class="last">

                                    <li><a href="/content/4-about-us">About Us</a></li>
                                    <li><a href="/careers">Careers</a></li>
                                    <li><a href="/content/45-media-coverage">Media Coverage</a></li>
                                    <li><a href="/content/21-media-kit">Media Kit</a></li>
                                    {*<li><a href="#">Press Releases</a></li>*}
                                    {*<li><a href="#">Blogs</a></li>*}
                                    <li><a href="/content/24-privacy-policy">Privacy Policy</a></li>
                                    <li><a href="/sitemap">Sitemap</a></li>
                                    <li><a href="/content/20-testimonials">Testimonials</a></li>
                                    <li><a href="/content/93-electronic-waste-management">Electronic Waste Management</a></li>
                                   
                                </ul>
                            </div>
                        </div>
                        <div class="span3 fcol1">
                            <div class="footer-static-title">
                                {*<h3><a style="text-decoration: none;" href="/content/8-downloads">Useful Links</a></h3>*}
                                <h3>Useful Links</h3>
                            </div>
                            <div class="footer-static-content">
                                <ul class="last">

                                    <li><a href="/content/26-apps-for-tabtops">Apps For TabTops</a></li>
                                    <li><a href="/content/category/2-buying-guides">Buying Guides</a></li>
                                    {*<li><a href="#">User Manuals</a></li>
                                    <li><a href="#">Video Manuals</a></li>*}
                                    <li><a href="/content/25-latest-upgrades">Latest Upgrades</a></li>
									<li><a href="/student-discount">Student Discount Form</a></li>
                                    <li><a href="/senior-citizen-discount">Senior Citizen Discount Form</a></li>
                                    <li><a href="/content/23-terms-of-cancellations-refunds-and-returns">Terms of
                                            Cancellations
                                            and Returns</a></li>
                                    <li><a href="/content/30-warranty-policy">Warranty Policy</a></li>
                                    <li><a href="/annual-maintenance-contract">Annual Maintenance Contract</a></li>
                                </ul>
                            </div>
                        </div>


                        <div class="span3 fcol1">
                            <div class="footer-static-title">
                                <h3>Reach Us</h3>
                            </div>
                            <div class="footer-static-content">
                                <ul class="last">
                                    {*<li><a href="/service-center">Service Centres</a></li>*}
                                    <li><a href="/book-demo">Book a Demo</a></li>
                                    {*<li><a href="/annual-maintenance-contract">Buy Annual Maintenance Contract</a></li>*}
                                    <li><a href="/bulk-purchase">Bulk Purchase Query</a></li>
                                    <li><a href="/content/38-contact-us">Contact Us</a></li>
                                    <li><a href="/customer-care" target="_blank">Customer Service Query</a></li>
                                    <li><a href="/content/category/5-etailers">E-tailers</a></li>
                                    <li><a href="/content/37-service-centres">Service Centres</a></li>
                                    {*<li><a href="/store-locator">Store Locator</a></li>*}
                                    <li><a href="/partners-with-us">Trade Partners Query</a></li>
                                </ul>
                            </div>
                            {*{$themesdev.td_conact_us|html_entity_decode}*}
                        </div>
                        {*<div class="span3 fcol3">
                            <div class="footer-static-title">
                                <h3>{l s='Latest Tweet'}</h3>
                            </div>
                            <div class="footer-static-content">


                    <link rel="stylesheet" type="text/css" href="{$css_dir}theme/ma.lastesttweet.css" media="all" />

                    <div id="twitter-feed"></div>
                    <script type="text/javascript">
                    $jq(document).ready(function () {
                    var displaylimit = {$themesdev.td_tweet_count};
                    var twitterprofile = "";
                    var screenname = "";
                    var showdirecttweets = false;
                    var showretweets = true;
                    var showtweetlinks = true;
                    var showprofilepic = true;

                    var headerHTML = '';
                    var loadingHTML = '';
                    loadingHTML += 'loading twitter feed...';

                    $jq('#twitter-feed').html(headerHTML + loadingHTML);

                    $jq.getJSON('{$base_dir}themes/metrofas/twitter/get-tweets.php',
                    function(feeds) {

                    var feedHTML = '<div class="tweet-content">';
                    var displayCounter = 1;
                    for (var i=0; i<feeds.length; i++) {
                    var tweetscreenname = feeds[i].user.name;
                    var tweetusername = feeds[i].user.screen_name;
                    var profileimage = feeds[i].user.profile_image_url_https;
                    var status = feeds[i].text;
                    var isaretweet = false;
                    var isdirect = false;
                    var tweetid = feeds[i].id_str;

                    //If the tweet has been retweeted, get the profile pic of the tweeter
                    if(typeof feeds[i].retweeted_status != 'undefined'){
                    profileimage = feeds[i].retweeted_status.user.profile_image_url_https;
                    tweetscreenname = feeds[i].retweeted_status.user.name;
                    tweetusername = feeds[i].retweeted_status.user.screen_name;
                    tweetid = feeds[i].retweeted_status.id_str
                    isaretweet = true;
                    };


                    //Check to see if the tweet is a direct message
                    if (feeds[i].text.substr(0,1) == "@") {
                    isdirect = true;
                    }

                    //console.log(feeds[i]);

                    if (((showretweets == true) || ((isaretweet == false) && (showretweets == false))) && ((showdirecttweets == true) || ((showdirecttweets == false) && (isdirect == false)))) {
                    if ((feeds[i].text.length > 1) && (displayCounter <= displaylimit)) {
                    if (showtweetlinks == true) {
                    status = addlinks(status);
                    }

                    if (displayCounter == 1) {
                    feedHTML += headerHTML;
                    }

                    feedHTML += '<div class="twitter-article">';
                    feedHTML += '<div class="twitter-pic"><a href="https://twitter.com/'+tweetusername+'" ><img src="'+profileimage+'"images/twitter-feed-icon.png" width="42" height="42" alt="twitter icon" /></a></div>';
                    feedHTML += '<div class="twitter-text"><span class="tweetprofilelink"><strong><a href="https://twitter.com/'+tweetusername+'" >'+tweetscreenname+'</a></strong> <a href="https://twitter.com/'+tweetusername+'" >@'+tweetusername+'</a></span><br/>'+status+'<br/>';
                                            feedHTML += '</div></div>';
                    displayCounter++;
                    }
                    }
                    }
                    feedHTML += '</div>';
                    $jq('#twitter-feed').html(feedHTML);
                    });

                    //Function modified from Stack Overflow
                    function addlinks(data) {
                    //Add link to all http:// links within tweets
                    data = data.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g, function(url) {
                    return '<a href="'+url+'" >'+url+'</a>';
                    });

                    //Add link to @usernames used within tweets
                    data = data.replace(/\B@([_a-z0-9]+)/ig, function(reply) {
                    return '<a href="http://twitter.com/'+reply.substring(1)+'" style="font-weight:lighter;" >'+reply.charAt(0)+reply.substring(1)+'</a>';
                    });
                    return data;
                    }


                    function relative_time(time_value) {
                    var values = time_value.split(" ");
                    time_value = values[1] + " " + values[2] + ", " + values[5] + " " + values[3];
                    var parsed_date = Date.parse(time_value);
                    var relative_to = (arguments.length > 1) ? arguments[1] : new Date();
                    var delta = parseInt((relative_to.getTime() - parsed_date) / 1000);
                    var shortdate = time_value.substr(4,2) + " " + time_value.substr(0,3);
                    delta = delta + (relative_to.getTimezoneOffset() * 60);

                    if (delta < 60) {
                    return '1m';
                    } else if(delta < 120) {
                    return '1m';
                    } else if(delta < (60*60)) {
                    return (parseInt(delta / 60)).toString() + 'm';
                    } else if(delta < (120*60)) {
                    return '1h';
                    } else if(delta < (24*60*60)) {
                    return (parseInt(delta / 3600)).toString() + 'h';
                    } else if(delta < (48*60*60)) {
                    //return '1 day';
                    return shortdate;
                    } else {
                    return shortdate;
                    }
                    }

                    });

                    </script>


                                <div id="twitter">
                                </div>
                            </div>
                        </div>*}

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="ma-footer-container">
        <div class="container">
            <div class="contain-size">
                <div class="footer">
                    <div id="fancybox-accessory-comparison-error" style="display: none">
                        <p>Sorry! Accessories can't be compared. Please use the filters on the product category screen
                            to choose the correct accessory.</p>

                        <p>In case you need help in selecting the correct accessory, please contact us via email on <a
                                    href="mailto:customercare@milagrow.in" target="_top">customercare@milagrow.in</a> or
                            call us at 09953476189, 0124-4309570/71/72.
                        </p>

                        <p>
                            Timings: 9:30 AM - 6:30 PM.
                        </p>

                    </div>
                    <div class="row-fluid">
                        <div class="span4">
                            <div class="footer-payment">
                                {if $themesdev.td_payment_icon_link!='' && $themesdev.td_paymenticon!=''}
                                    <a href="{$themesdev.td_payment_icon_link}">
                                        <img src="{$themesdev.td_paymenticon}" alt=""/>
                                    </a>
                                {else}
                                    <img src="{$themesdev.td_paymenticon}" alt=""/>
                                {/if}

                            </div>
                        </div>
                        <div class="span4">
                            <address>{$themesdev.td_copyright|html_entity_decode}</address>
                        </div>
                        <div class="span4">

                            <div class="footer-social">
                                <ul>
                                    {if $themesdev.td_facebook_url !=''}
                                        <li class="facebook"><a href="{$themesdev.td_facebook_url|html_entity_decode}"
                                                                title="{l s='facebook'}"
                                                                rel="tooltip">{l s='Facebook'}</a></li>{/if}
                                    {if $themesdev.td_twitter_url !=''}
                                        <li class="twitter"><a href="{$themesdev.td_twitter_url|html_entity_decode}"
                                                               rel="tooltip" title="{l s='twitter'}">{l s='Twitter'}</a>
                                        </li>{/if}
                                    {if $themesdev.td_email_url !=''}
                                        <li class="email"><a href="{$themesdev.td_email|html_entity_decode}"
                                                             rel="tooltip" title="{l s='email'}">{l s='Email'}</a>
                                        </li>{/if}
                                    {if $themesdev.td_pinit !=''}
                                        <li class="pinit"><a href="{$themesdev.td_pinit|html_entity_decode}"
                                                             rel="tooltip" title="{l s='pinit'}">{l s='Pinit'}</a>
                                        </li>{/if}
                                    {if $themesdev.td_gplus !=''}
                                        <li class="gplus"><a href="{$themesdev.td_gplus|html_entity_decode}"
                                                             rel="tooltip"
                                                             title="{l s='Google Plus'}">{l s='Google Plus'}</a>
                                        </li>{/if}

                                </ul>
                            </div>

                        </div>
                        {*{if $themesdev.td_additionallinks=='enable'}
                            <ul class="links">
                                {$themesdev.td_additional_links|html_entity_decode}
                            </ul>
                        {/if}*}
                    </div>
                    {if $themesdev.td_additionallinks=='enable'}
                        <ul class="links">
                            {$themesdev.td_additional_links|html_entity_decode}
                        </ul>
                    {/if}
                    <div class="row-fluid"><div class="span12"><br /><h1 class="ftr_title">MOST SEARCHED FOR ON MILAGROW HUMANTECH:</h1>
<div class="ftr_link">CATEGORY: <a href="http://milagrowhumantech.com/content/27-offers-zone-">OFFERS PAGE</a> | <a href="http://milagrowhumantech.com/85-floor-robots" target="_new">Milagrow Floor Cleaning Robots</a> | <a href="http://milagrowhumantech.com/105-lawn-robots">Milagrow Lawn Mowing Robots</a> | <a href="http://milagrowhumantech.com/113-pool-robots">Milagrow Pool Cleaning Robots</a> | <a href="http://milagrowhumantech.com/86-window-robots">Milagrow Window Cleaning Robots</a> | <a href="http://milagrowhumantech.com/87-body-robots">Milagrow Body Massaging Robots</a></div> </br>

<div class="ftr_link">TABLETS: <a href="http://milagrowhumantech.com/89-dual-core">Milagrow Dual Core Tablet PCs</a> | <a href="http://milagrowhumantech.com/90-quad-core">Milagrow Quad Core Tablet PCs</a> | <a href="http://milagrowhumantech.com/89-dual-core">Milagrow Calling Tablet PCs</a> | <a href="http://milagrowhumantech.com/6-tabtop-pcs">Milagrow TabTops</a> | <a href="http://milagrowhumantech.com/11-android-models">Milagrow Android Tablets</a></div></br>
<div class="ftr_link">TV MOUNTS :<a href="http://milagrowhumantech.com/17-wall-mount-models">Milagrow LED TV  Mounts</a> | <a href="http://milagrowhumantech.com/17-wall-mount-models">Milagrow LCD TV Mounts </a>| <a href="http://milagrowhumantech.com/10-mounts">Milagrow TV Racks & Mounts </a>| <a href="http://milagrowhumantech.com/15-ceiling-mount-models">Milagrow Ceiling Mounts</a> | <a href="http://milagrowhumantech.com/17-wall-mount-models">Milagrow Articulating Mounts</a></div></br>
<div class="ftr_link">ACCESSORIES : <a href="http://milagrowhumantech.com/27-tabtop-accessories">Milagrow TABLET PC  Accessories </a> | <a href="http://milagrowhumantech.com/67-floor-robot-accessories">Robotic Vacuum Cleaner Accessories</a> | <a href="http://milagrowhumantech.com/122-pool-robot-accessories">Automatic Pool Cleaner Accessories</a> | <a href="http://milagrowhumantech.com/123-lawn-robot-accessories">Robotic Lawn Mower Accessories</a> | <a href="http://milagrowhumantech.com/77-window-robot-accessories">Windoro & WinBot Accessories</a></div></br>
<div class="ftr_link">SPECIFIC MODELS :<a href="http://milagrowhumantech.com/floor-robots/575-milagrow-aguabot-5-0-indias-1st-full-wetmopping-and-drycleaning-floor-robovac-8908002152081.html">Aguabot 5.0</a> | <a href="http://milagrowhumantech.com/floor-robots/503-milagrow-redhawk3-0-india-s-number-1-floor-robots-8908002152012.html">RedHawk 3.0</a> | <a href="http://milagrowhumantech.com/floor-robots/504-milagrow-aguabot-4-0-robotic-floor-cleaner-with-water-tank-8908002152081.html">Aguabot 4.0</a> | <a href="http://milagrowhumantech.com/floor-robots/505-milagrow-blackcat3-0-india-s-longest-battery-life-floor-cleaner-8908002152678.html">BlackCat 3.0</a> | <a href="http://milagrowhumantech.com/floor-robots/224-milagrow-robocop-20-india-s-number-1-floor-robot.html">RoboCop</a> | <a href="http://milagrowhumantech.com/floor-robots/223-ecovacs-3d-deebot-77.html">DeeBot</a>|<a href="http://milagrowhumantech.com/floor-robots/219-cloud-sniper.html"> CloudSniper</a> |<a href="http://milagrowhumantech.com/body-robots/23-robotic-body-massager.html">Wheeme</a> | <a href="http://milagrowhumantech.com/pool-robots/233-robophelps-true-blue-8908002152753.html">RoboPhelps 15</a> | <a href="http://milagrowhumantech.com/pool-robots/419-milagrow-robophelps20-8908002152111.html">RoboPhelps 20</a> | <a href="http://milagrowhumantech.com/pool-robots/420-milagrow-robophelps25-8908002152135.html">RoboPhelps 25</a> | <a href="http://milagrowhumantech.com/pool-robots/421-milagrow-robophelps30-8908002152142.html">RoboPhelps 30</a> | <a href="http://milagrowhumantech.com/pool-robots/502-milagrow-robophelps40turbo.html">RoboPhelps 40 Turbo</a> </div>
<div class="ftr_link" style="margin-top:0px;">
    <a href="http://milagrowhumantech.com/86-window-robots">WinBot </a>| <a href="http://milagrowhumantech.com/lawn-robots/229-robonicklaus-20.html">RoboNicklaus</a> | <a href="http://milagrowhumantech.com/lawn-robots/232-robotiger-10-8908002152715.html">RoboTiger 1.0</a> | <a href="http://milagrowhumantech.com/lawn-robots/231-robotiger-20-8908002152692.html">RoboTiger 2.0</a> | <a href="http://milagrowhumantech.com/window-robots/556-milagrow-robosnail10.html">RoboSnail 10</a> |
     <a href="http://milagrowhumantech.com/window-robots/557-milagrow-robosnail12.html">RoboSnail 12</a> | <a href="http://milagrowhumantech.com/window-robots/555-milagrow-hobot188.html">Hobot 188</a> | <a href="http://milagrowhumantech.com/quad-core/75-104-pro-3g-sim-quad-core-16gb-8908002152630.html">M8PRO</a> | <a href="http://milagrowhumantech.com/quad-core/226-m2-pro-3g-32gb-84-quad-core.html">M2PRO</a> | <a href="http://milagrowhumantech.com/quad-core/75-104-pro-3g-sim-quad-core-16gb-8908002152630.html">M8</a> | <a href="http://milagrowhumantech.com/tabtop-pcs/295-m2pro-3gcall-16gb-84-quad-core-with-designer-slim-cover-.html">M2</a> | <a href="http://milagrowhumantech.com/floor-robots/506-milagrow-ecovacs-deebot-dm-85.html">DeeBot M85</a> | <a href="http://milagrowhumantech.com/floor-robots/507-milagrow-ecovacs-3d-deebot-79.html">DeeBot D79</a> | <a href="http://milagrowhumantech.com/frameless-windows/509-milagrow-ecovacs-winbot-930.html">WinBot 930</a>
</div>    
<br /><br />
                     <br/>

                    {foreach from=$catHtml key=k item=htmlVal}
                        {if $page_name=='index' && $k==0}
                    <div class="ftr_text">  {$htmlVal}</div>
                            <br/>
                            {break}
                        {else}
                        {if $k==$category->id}
                            <div class="ftr_text">  {$htmlVal}</div>
                            <br/>
                            {break}
                        {/if}
                        {/if}
                    {/foreach}

{*{if $page_name == 'index'}*}
{*<div class="ftr_text">Milagrow Humatech is a leading destination for online shopping of Robots, Tablet PCs, TV Mounts and Accessories in India, offering some of the best prices and a completely hassle-free experience with options of paying through Cash on Delivery, Debit Card, Credit Card and Net Banking processed through secure and trusted gateways. Now shop for your favorite consumer robots, service robots, home robots, industrial robots, domestic robots, Companion Robots, Pet Robots for floor cleaning, lawn mowing, window cleaning, swimming pool cleaning & body massaging. You can also shop for Tablet PCs, TabTop Pcs to replace your desktop computers, laptops and smart phones, mobile phones from our range of quad core tablets, dual core tablet Pcs, windows tablets, calling tablets. TV Mounts and Racks for LED TVs, LCD TVs for any VESA standards compliant TVs for any brand like Sony, Samsung, LG, Panasonic, Toshiba, Philips, Micromax, Onida, Videocon etc. We also have accessories for all the above product categories and all the after sales ervice is completely owned by us. We also help customers who are stuck with unserviceable robots like iroomba & scooba from irobot, neato,  moneual, yujin iclebo, infinuvo, pleo, electrolux, dolphin, pentair, polaris, robomow, smartmow, husqvarna, hobot etc. Most our products come with 2 year or 1 year comprehensive warranty or guarantee. We also offer extended warranty or <a href="http://milagrowhumantech.com/annual-maintenance-contract">annual maintenance contracts</a> for most of our products. <a href="http://milagrowhumantech.com/book-demo">Pre Sales or Post Sales  home demonstrations</a> are also provided to help you decide the utlity of our robots in the comfort of your home. Browse through the products featured on our site with expert descriptions, detailed specifications, perfect product comparisions, video manuals, price comparisions to help you arrive at the right buying decision. Milagrow also offers free home delivery for many of our products along with easy <a href="http://milagrowhumantech.com/authentication?back=my-account">EMI options</a>, <a href="http://milagrowhumantech.com/content/28-shipping-and-delivery-faqs#cod">COD</a>, payment by cheque. Get the best prices and the best online shopping experience every time, guaranteed.</div>*}

{*{elseif $category->id == 87 || $category->id == 137}*}
{*<br />*}
{*<div class="ftr_text">*}
{*World's First Robotic Body Massager gently massages and caresses as it rolls over your body and relaxes your tired muscles. Milagrow Body Robot has 3 settings for vibration massage, gentle pressure massage or light tickling massage . Mialgrow Wheeme navigates gently and safely on a human body without falling off if the angle is less than 45 degrees. Milagrow BodyBot is very Effective for lower back pains.<br />*}

{*Tough day? Lie down and place WheeMe on your back or stomach for unassisted stress relief and relaxation. With its unique tilt sensor technology, Milagrow WheeMe slowly rolls along without falling off or losing its grip, gently stroking and caressing with its nylon fingerettes. Simply choose from 3 settings, for anything from soothing vibration to a delightful light tickle. Then let WheeMe do the pampering while you relax or watch TV!<br />*}

{*Attachable "fingertte tip" gently spins and skims over tired muscles and improves blood circulation as well even as it stimulates the nerves. Works best on your body's large horizontal areas i.e. lie down and put it on your back or stomach. Works completely autonomously and wheels stop if you pick it up and turn it over. Easy to use and maintain*}
{*Can be used by all age groups except kids below of age five.<br />*}

{*A massage can benefit a person in many ways. Enhancing the function of a certain body part, promoting muscular relaxation, aiding in the process of healing are some of the benefits of a massage. Nothing can invigorate you more than a soothing massage after a tiring day. You never get full satisfaction with an electric, manual or personal massage. A person can become their own massage therapist with the Mialgrow Wheeme and soothe the aching muscles of their back without anyone's help. Be it a full body massager, a hand-held one or a even a therapeutic massager, no one can match the effectiveness of the Milagrow body massaging robot, if used continuously. Make the right buying decision. <br />*}

{*Milagrow Wheeme comes with 1 year comprehensive warranty or guarantee. Browse through the models featured on our site with expert descriptions, detailed specifications, videos, perfect product comparisons, price comparisons to help you arrive at the right buying decision.<br />*}

{*Milagrow also offers free home delivery for most of its products along with easy EMI options, COD, payment by cheque. Get the best prices and the best online shopping experience every time, guaranteed. Milagrow Humantech is the best place to buy a robot massager . Just place your order today and forget the hassles of bringing it home. We will ship it to your address absolutely free in two business days. So, order today and let back aches be history.*}
{*</div>*}

{*{elseif $category->id == 85 || $category->id == 67 || $category->id == 68 || $category->id == 69 || $category->id == 70 || $category->id == 71 || $category->id == 72 || $category->id == 73 || $category->id == 74 || $category->id == 75 || $category->id == 106 || $category->id == 107 || $category->id == 108 || $category->id == 109 || $category->id == 110}*}
{*<br />*}
{*<h1 class="ftr_title">BUY FLOOR CLEANING ROBOTS, VACUUM CLEANERS, ROBOTIC FLOOR CLEANERS ONLINE:</h1>*}
{*<div class="ftr_text">Robots are the in thing. Humans serving humans must get replaced by*}
{*robots serving humans for domestic chores. If you are passionate about*}
{*your spic-and-span home and like to keep it clean always, vacuum*}
{*cleaners can be your best friends if they are automatic. Robotic*}
{*vacuum cleaners use the unique technology of cleaning things by*}
{*sucking in the dust and not by blowing it off only to make it settle*}
{*at other places. Keeping your house and surrounding clean is important*}
{*as it prevents you and your family from catching dust allergies.*}
{*Milagrow domestic robots for floor come with HEPA filters, UV*}
{*disinfection and anti bacterial body to make your home fully germ free*}
{*and keeping you healthy. These robots also pick up pet hair and hard*}
{*dirt from most kinds of floor surfaces including flat carpets. They*}
{*are stylish, powerful and truly a must have in your home. There were*}
{*times when vacuum cleaners were seen rare and were considered as a*}
{*status symbol. However, today they have become an essential part of*}
{*every household. Milagrow home cleaning robots reach accessible areas*}
{*below the beds, sofas or furniture. When the vacuum cleaner is almost*}
{*full, all you have to do is open and empty the dirt into a dustbin. We*}
{*also sell a model which cleans its dustbin by itself and can do 3*}
{*dimensional cleaning of floor, wall and roof. Take your pick from our*}
{*collection of trendy and handy vacuum cleaners from famous brands,*}
{*such as Milagrow and Ecovacs Deebots. None of the other traditional*}
{*brands like Eureka Forbes, Black & Decker, Inalsa, Karcher, Panasonic,*}
{*Philips, Russel Hobbs, Softel, LG, Samsung can match our range of*}
{*Cleaning Robots in India. Our small handheld vacuum cleaner is*}
{*portable and can be used to clean your car. They either run on a*}
{*rechargeable batteries or connect to the cigarette lighter for power.*}
{*It is so powerful that it can suck even coins from the floor.<br />*}
{*We also have accessories like brushes, batteries, virtual walls,*}
{*mopping pads, charging stations, adapters etc for all the above*}
{*product categories. All the after sales service is completely owned by*}
{*us. We also help customers who are stuck with unserviceable robots*}
{*like iroomba & scooba from irobot, neato,  moneual, yujin iclebo,*}
{*infinuvo, pleo, electrolux, dolphin, pentair, polaris, robomow,*}
{*smartmow, husqvarna, hobot etc. Most our products come with 2 year or*}
{*1 year comprehensive warranty or guarantee. We also offer extended*}
{*warranty or annual maintenance contracts for most of our products. Pre*}
{*Sales or Post Sales  home demonstrations are also provided to help you*}
{*decide the utility of our robots in the comfort of your home. Browse*}
{*through the products featured on our site with expert descriptions,*}
{*detailed specifications, perfect product comparisons, video manuals,*}
{*price comparisons to help you arrive at the right buying decision.*}
{*Milagrow also offers free home delivery for many of our products along*}
{*with easy EMI options, COD, payment by cheque. Get the best prices and*}
{*the best online shopping experience every time, guaranteed.<br />*}
{*Gone are the days of brooms and mops, because of modern and innovative*}
{*technologies of Milagrow consumer robots. Let the places be easy or*}
{*hard to reach or whether you've got a big sprawling mansion for a*}
{*house or a small one our, Milagrow floor cleaning robots will make you*}
{*happy. Get a wet and dry robotic vacuum cleaner instead of buying mops*}
{*to save your time, water and energy. Milagrow Humantech is the the*}
{*best place to buy vacuum cleaners as you will get all types of*}
{*assortment here, ranging from dry vacuum cleaners, wet cleaners and*}
{*robotic vacuum cleaners. Just place your order today and forget the*}
{*hassles of bringing it home. We will ship it to your address*}
{*absolutely free in two business days. So, order today and make clean*}
{*your home effortlessly fast.</div>*}

{*{elseif $category->id == 105}*}
{*<br />*}
{*<div class="ftr_text">Welcome to the world of robotic & autonomous mowing – a modern, hassle-free solution that saves you time and delivers a perfectly maintained lawn. A lawn mower is a machine that uses one or more revolving blades to cut a lawn to an even height. There are several types of mowers, each suited to a particular scale and purpose. The smallest types are pushed by a human user and are suitable for small residential lawns and gardens. Riding mowers are larger than push mowers and are suitable for large lawns. The largest multi-gang mowers are mounted to tractors and are designed for large expanses of grass such as golf courses and municipal parks. A transition from traditional hand-guided or ride-on mowers to automatic electric mowers is beginning to take place, with the growth in robotic lawn mower sales of 2012 being 15 times the growth in sales of the traditional styles. At current rates of growth automated lawn mowers are set to soon reach the point of outselling traditional mowers in some regions.<br />*}

{*Cut the hassle out of cutting your grass with Milagrow's lawn robots. Robo Nicklaus. Robo Tiger are there to serve the most demanding garden lovers. Our R&D is located in China and is dedicated to robot technical research, appearance design as well as structural design. It has already got 6 Design Patents & 18 Utility Patents. These lawn mowing robots were mainly being sold in Europe and America till now. 1000s of customers in Scandinavian region, Germany, France, Poland, Netherlands, Belgium and the USA have liked our Robotic Lawn Mowers due their technological superiority, performance and design. Now Milagrow has brought them to India. <br />*}

{*Our robots possess 6th sense to have Robotic Obstacle Sensors, Pressure Sensors, Bump Detection Sensors, Touch Sensors, Rain Sensors, Lift Sensors, Steep Slope Sensors, Navigation Sensors, Overload Detection Sensors etc. Robotic Scheduling, Robotic Auto Charge, Robotic Area & Sub Area Selection, Robotic Cutting Patterns using AI, Robotic Self Diagnosis are some other advance features in our lawn mowers. All Milagrow Lawn Robots are equipped  lawn test function. Milagrow Robots can cover up-to a maximum of 2600 Sq m or 0.64 Acre or 28000 Sq Ft on a single charge. On a single charge they can cut up-to 800 Sq m or 0.2 Acre or 8600 Sq Ft. They can cut from 2.5 cm to 6 cm of grass as required at a maximum speed of 2.1 km/h. These are extremely high standards for lawn mowing robots. Milagrow lawn robots are the best lawn mowers in their category with world's best technology being used.  Milagrow Lawn Robots are totally safe especially for children and pets. <br />*}

{*Air pollution from cutting grass for an hour with a gasoline-powered lawn mower is about the same as that from a 150 kilometer automobile ride. Because they are electrically powered, Milagrow Robots produce no harmful emissions. They are 'green', battery powered. mowers. No oil or petrol is used and no smoke is generated. Traditional lawn mowers, gasoline lawn mowers, riding lawn mowers, hover mowers, motorized or hand operated can trigger asthmatic people and aggravate other respiratory conditions. Milagrow Lawn Robots do not pollute and since you are not next to them when they mow the lawn, you do not breathe any dust or grass particles. They save you from the frustrations of pull cords, mixing and storing of gas and oil, costly maintenance and they save the environment from harmful emissions<br />*}

{*Milagrow Robots comply with the international certification of water proof rating for electronic products. Milagrow Robots are certified for performance, safety and hazardous substances from the best labs in the world thereby making them acceptable in the most demanding markets of EU and USA. Milagrow Lawn Robots offer multi language Options on the Menu - 9 Languages namely English, French, German, Danish, Swedish, Spanish, Italian, Finish, Norwegian (Norge). <br />*}

{*We also have accessories like blades, batteries, pegs, charging or docking stations, adapters, remotes, virtual wire, rain hood etc for all the above product categories. All the after sales service is completely owned by Milagrow. We also try to help customers who are stuck with unserviceable robots like Robomow, BigMow, ParkMow, LawnBotts, Husqvarna Automower, John Deere Tango, Bosch Indego, Honda Miimo, AL-KO Robolinho, Flymo etc who currently have no or negligible after sales service in India. <br />*}

{*Most our products come with 2 year or 1 year comprehensive warranty or guarantee. We also offer extended warranty or annual maintenance contracts for most of our products. Pre Sales or Post Sales  home demonstrations are also provided to help you decide the utility of our robots in the comfort of your home or lawn. Browse through the products featured on our site with expert descriptions, detailed specifications, perfect product comparisons, video manuals, price comparisons to help you arrive at the right buying decision. <br />*}

{*Milagrow also offers free home delivery for many of our products along with easy EMI options, COD, payment by cheque. Get the best prices and the best online shopping experience every time, guaranteed. Milagrow Humantech is the best place to buy a <font color="#0000ff">lawn mulching robot</font>  as you will get a choice of models here. Just place your order today and forget the hassles of bringing it home. We will ship it to your address absolutely free in two business days. So, order today and let unkempt, uncut farmhouses, lawns and gardens be history. </div>*}

{*{elseif $category->id == 113}*}
{*<br />*}
{*<div class="ftr_text">A pool should create memories. A pool should have clean water.  A pool*}
{*should be safe. A pool should not be a chemical tank or an energy*}
{*guzzler. It's time to change the way we keep or clean our swimming*}
{*pools. Here comes Phelps…Milagrow RoboPhelps to not only clean your*}
{*pool better and protect your family but also to enable you to spend*}
{*more time with them. Milagrow Robot pool cleaners are highly*}
{*intelligent and efficient machines that clean your pool for you by*}
{*bypassing the main filtering system of your pool.<br />*}

{*Enjoy a pool with pure water as close to nature as it can be. Keep*}
{*your soft skin. Open eyes underwater and have a tea party at the*}
{*bottom of the pool.<br />*}

{*Milagrow RoboPhelps has very advanced robotic functions like Smart Z*}
{*programming, Robotic Balance, Robotic Reverse, Robotic Injury*}
{*Protection, Robotic Self Preservation, Robotic Shut off etc. The*}
{*RoboPhelps series suits all types of pools, tackles pools of all*}
{*shapes, any pool terrain and climbs over obstacles without getting*}
{*stuck  whether above ground or in-ground residential pools. The*}
{*RoboPhelps cleans all surface types - Tile (large & small), Vinyl,*}
{*Gunite or Fiberglass etc . It scrubs the floor, walls,  coves and tile*}
{*line. It has a self contained vacuum bag  and it eliminates the need*}
{*to clean your cartridge filter or sand filter after the vacuuming the*}
{*swimming pool.<br />*}

{*Milagrow swimming pool robots move with linear jet propulsion*}
{*technology at a maximum speed of 120㎡/h  and cleans up to an area of*}
{*200㎡ or 2100 Sq Ft approximately in about 2 hours. With 2 drive motors*}
{*it can climb walls up to 1.8 meters (6 ft) without any difficulty. Its*}
{*filtering or suction rate is a phenomenal 18000 liters / hour or 60*}
{*gallons/minute giving it an operating cost per hour of just 0.05 US$*}
{*per hour or Rs 3 per hour. The porosity of the default filter bag is*}
{*70 microns which is much smaller than the thickness of  human hair*}
{*which ensures that the pool is clean of all dirt and debris or*}
{*floating objects.<br />*}

{*Milagrow automatic pool cleaner cleans stubborn dirt, chemicals or*}
{*algae too. The RoboPhelps vacuums all types of debris and helps remove*}
{*algae substantially reducing the amount of chemicals needed to ensure*}
{*a safer, cleaner and healthier pool for you, your family and friends.*}
{*Its 4 sponge wheels (2 front and  2 back) with 2 drive motors and*}
{*strong impeller movement  ensure a thorough abrasion proof scrubbing*}
{*to clear even stubborn dirt and algae. With the remote control you can*}
{*repeat spot cleaning.<br />*}

{*Milagrow pool robots offer better filtration, fewer chemicals, better*}
{*water mix . Milagrow RoboPhelps robotic pool cleaner is engineered*}
{*with the strongest pumps and finest filtration in the industry. They*}
{*remove more and finer particulate, while thoroughly mixing the water*}
{*in your pool, substantially reducing the amount of chemicals needed.*}
{*It all adds up to Fewer Chemicals and a Healthier Clean.<br />*}

{*Milagrow robots offer 93% energy saving. Milagrow RobPhelps is powered*}
{*by low-voltage electricity, rather than a pool or booster pump. Since*}
{*the pump runs less, energy costs are reduced. Totally independent of*}
{*pool circulation system, RoboPhelps provides on-demand cleaning*}
{*without running pumps. Its built-in filter further reduces use of a*}
{*pool's primary filtration system lowering energy costs even more. It*}
{*also extends the life of both the pump and filter, and increases the*}
{*amount of time between filter cleanings. Milagrow RoboPhelps cleaning*}
{*cycle cost is about 5 cents per hour, saving you almost 40% on your*}
{*pool electric usage. A recent independent study by the National*}
{*Plasterers Council, USA concluded that the use of self contained*}
{*robotic pool cleaners was 93% more energy efficient than a standard*}
{*main pool filter system. Actual savings rates may however vary based*}
{*on cleaner type, pool size and usage.<br />*}

{*Milagrow swimming robots offer 30% saving on chemical usage. Better*}
{*water circulation with the finest filtration in the industry helps you*}
{*save up to 30% on your total chemical usage (actual savings rates may*}
{*vary based on cleaner type, pool size and usage)<br />*}

{*Milagrow pool bots save water too. Milagrow pool robot saves on*}
{*back-washing. All debris is self-contained in the unit and does not*}
{*add strain to your filter system. It all adds up to less back-washing*}
{*and meaningful savings. You can pre program a Milagrow swimming pool*}
{*robot. Simply set it and forget it and the motion sensors allow the*}
{*robot to automatically sense its position in the pool and adapt its*}
{*path for optimized cleaning while reducing cord tangling. You can*}
{*choose the setting according to the size of the pool -  0.5h ( Pool*}
{*size < 50 Sq m)  , 1h (Pool Size 50 to 100 Sq m) or 2h Pool Size > 100*}
{*Sq m). Milagrow Robo Phelps comes in 4 variations of cable length. 15,*}
{*20, 25 and 30 meters. You can clean any pool length including an*}
{*Olympic size swimming pool, in-ground, above ground for domestic or*}
{*commercial purpose.<br />*}

{*The main unit of Milagrow RoboPhelps pool cleaning robot has the*}
{*highest Water 'Ingress Protection' (IP) rating of 68. This is as good*}
{*as it get in the electronics products. Even the remote control and*}
{*power box are more than splash proof with IP rating of 21 and 23*}
{*respectively.<br />*}

{*Robotic pool cleaners convenient. Customers can just plug it in and*}
{*place it in their pool. Milagrow swim bots require no installation, no*}
{*booster pump, no hoses and are totally self-contained cleaning and*}
{*filtration system. Milagrow pool robots come with an optional caddy*}
{*cart and are available in 4 Attractive Colors - true Blue, Egyptian*}
{*blue, aureolin yellow, vanilla white.<br />*}

{*We also have accessories like charges, cables, controllers, remote,*}
{*filter bags, caddy cart etc. All the after sales service is completely*}
{*owned by Milagrow. We also try to help customers who are stuck with*}
{*un-serviceable robots like Maytronics, Dolphin, Pentair, Hayward,*}
{*Aquabot, Polaris, iRobot Mirra, Blue wave, Kokido, Jetma, Ultramax*}
{*Gemini. Robot Pool, Roboter etc who currently have no or negligible*}
{*after sales service in India.<br />*}

{*Most our products come with 2 year or 1 year comprehensive warranty or*}
{*guarantee. We also offer extended warranty or annual maintenance*}
{*contracts for most of our products. Pre Sales or Post Sales  home*}
{*demonstrations are also provided to help you decide the utility of our*}
{*robots in the comfort of your home or lawn. Browse through the*}
{*products featured on our site with expert descriptions, detailed*}
{*specifications, perfect product comparisons, video manuals, price*}
{*comparisons to help you arrive at the right buying decision.<br />*}

{*Milagrow also offers free home delivery for many of our products along*}
{*with easy EMI options, COD, payment by cheque. Get the best prices and*}
{*the best online shopping experience every time, guaranteed. Milagrow*}
{*Humantech is the best place to buy a <font color="#0000ff">pool cleaning robot</font>  as you will*}
{*get a choice of models here. Just place your order today and forget*}
{*the hassles of bringing it home. We will ship it to your address*}
{*absolutely free in two business days. So, order today and let dirty*}
{*and unhygienic pools be history. </div>*}

{*{elseif $category->id == 86}*}
{*<br />*}
{*<div class="ftr_text">Welcome to the world of Milagrow Robots. The era of humans serving humans is over<br />*}

{*Milagrow presents technology that makes life simpler, easier & allows you more time with minimum effort. Milagrow's range of Domestic Robots is Intelligent, obedient and created for the sole purpose of serving humans. These robots can help you perform a wide array of domestic chores, without the tension of any supervision.<br />*}

{*World's 1st & World's No.1 Window Cleaning Robots. It can be difficult and dangerous to clean glass window panes, especially if you are living in a high-rise apartment. It can also be cumbersome to clean office windows and glass partitions. Now you can clean smartly and easily with Milagrow Window Robots.  <br />*}

{*The WinBot 730 has a smart all-in-one Module for Cleaning & Navigation. The Windoro consists of 2 Modules. 1st for Cleaning Module & 2nd for Navigation Module. The two modules are held together by permanent Neodymium Magnets. <br />*}

{*A robot is supposed to work without human intervention to deliver most of its tasks. Milagrow Window Cleaning Robots possess Robotic 6th Sense for minimal interaction between humans and technology providing huge benefits in time and effort. They possess Robotic Area Measurement, Robotic Path Management, Robotic Frame less Cleaning, Robotic Edge Cleaning. Robotic Return to Origin, Robotic Obstacle Sensing, Robotic Fall Proof, Robotic Suction Power Sensor , Robotic Mobility<br />*}

{*Extra Fall Safety. Windoro remains tightly attached to the window whether or not the power has been turned off. It consists of two modules that fit excellently on opposite sides of the window and hold each other using permanent magnets.<br />*}

{*WinBot 7 has Real Time Malfunction monitoring. Should a problem occur, it will stop cleaning and the Indicator Light will flash and an alarm will sound. It also comes with a safety pod. In case of low battery the Robot will stop & retain some back up. In case it is out of reach, Remote can be used to bring it back.<br />*}

{*Thorough Cleaning Process. WinBot has a Three-Stage Cleaning for Maximum Efficiency for it to enable cleaning glass windows or doors etc and leave them shining and spotless. First, the front Cleaning Pad, sprayed with cleaning solution, moistens, loosens and absorbs dirt. Second, the Squeegee draws the remaining water-borne dirt and dampness off the window. Third, the rear Cleaning Pad wipes the window to a dry, spotless condition. Windoro has a two stage cleaning. The first is automatic release of precise amount of detergent spray and second the the spinning of 4 microfiber pads to clean the windows perfectly.<br />*}

{*No Limit to Glass Thickness. WinBot 7 is the world's only window cleaning robot that can clean glass of any thickness – even Thermopane windows. The WINBOT W730 is equipped with a frame-less window detection system so you can clean glass doors, railings and shower stalls with ease. Robot window cleaners help you clean hard to reach, high or large glass surfaces. They can also help in areas where it is not safe for a humans to clean.<br />*}

{*Very soon we will also have Hobot Multi-Surface Cleaning Robot, the first multi-surface robot cleaner in the world. Unlike many vertical surface cleaning and window cleaning robots, this robot is only mounted to one side. Because of this "single-side" design, it can clean windows of any thickness including double-glass windows, show windows, store windows, and so on. It has a vacuum motor that enables the robot to stick to the glass surface. An embedded UPS (Un-interrupted Power System) will prevent the robot from falling from the window even when no power is supplied. It has two specially-designed cleaning wheels that can freely move across the window's surface and even up a wall. The easily replaceable micro-fiber cloths are used on both of the cleaning wheels. These Micro-fiber based cloths are great for cleaning glass. It also has a table cleaning mode.<br />*}

{*We also have accessories like charges, cables, safety pods, hangers, controllers, remote, mopping & cleaning pads, edge cleaners, cupule gasket sets, detergent, etc. All the after sales service is completely owned by Milagrow is the only company in India which has a full fledged after sales service for robots in general and window robots in particular, in India. <br />*}

{*Most our products come with 2 year or 1 year comprehensive warranty or guarantee. We also offer extended warranty or annual maintenance contracts for most of our products. Pre Sales or Post Sales  home demonstrations are also provided to help you decide the utility of our robots in the comfort of your home or lawn. Browse through the*}
{*products featured on our site with expert descriptions, detailed specifications, perfect product comparisons, video manuals, price comparisons to help you arrive at the right buying decision.<br />*}

{*Milagrow also offers free home delivery for many of our products along with easy EMI options, COD, payment by cheque. Get the best prices and the best online shopping experience every time, guaranteed. Milagrow Humantech is the best place to buy a window robot  as you will get a choice of models here. Just place your order today and forget the hassles of bringing it home. We will ship it to your address absolutely free in two business days. So, order today and let dirty and unhygienic windows be history.</div>*}

{*{elseif $category->id == 10}*}
{*<br />*}
{*<div class="ftr_text">*}
{*Gift a perfect partner to your TV . Milagrow ready to mount TV racks and articulating mounts. There is a range of single arm, dual arm, quad arm articulating wall mounts which can rotate, 90, 180, 270 and even 360 degrees. They can swivel, tilt, pan, rotate, slide up or down , forward or back to provide the best view and best access to the TV and its ports. Chose the wall mounts, ceiling mounts or wall racks from Milagrow.  Milagrow TV mounts and racks can handle from 10-52'' LCD or LED TVs and accessories. They can hold from 5 to 60 kgs of weight.  Material used is high grade metal, aluminum extrusion. All come with a life time warranty against manufacturing defects. They are fall and theft proof. Milagrow flat panel TV mounts work with all major brands of TVs like Sony, Samsung, LG, Panasonic, Onida, Videocon etc due their VESA certification. <br />*}

{*Browse through the models featured on our site with expert descriptions, detailed specifications, videos, perfect product comparisons, price comparisons to help you arrive at the right buying decision.<br />*}

{*Milagrow also offers free home delivery for most of its products along with easy EMI options, COD, payment by cheque. Get the best prices and the best online shopping experience every time, guaranteed. Milagrow Humantech is the best place to buy a LED or LCD TV mount and rack . Just place your order today and forget the hassles of bringing it home. We will ship it to your address absolutely free in two business days.<br />*}
{*</div>*}

{*{elseif $category->id == 6}*}
{*<br />*}
{*<div class="ftr_text">Milagrow TabTops have been designed to replace laptops, desktops, netbooks and ordinary tablets. Milagrow Humantech offers an exhaustive selection of tablets . You are sure to find a tablet that can meet virtually every budget and need. but we do not deal in single core and poor quality tablets.*}

{*Milagrow has further raised the bar in the tablet with the launch of India's most powerful TabTop PCs – the new M8 Pro and M2 Pro Series. They feature upto 9.4" screen, Rockhip 3188 A9 quadcore SOC that clocks speeds up to 1.6Ghz. It delivers a speed upto 3 times & 1.8 times faster than other quadcore processors based on A5 cortex & A7quadcore architecture, respectively. The device offers productivity and serious performance akin to the latest Laptops. <br /><br />*}
{*<p>Other important features include:-</p> <br />*}

{*<div style="margin-left:20px;">*}
{*<p>&bull; Highest Storage – upto 32GB internal, 2GB Double channel Ram, supports 2TB external HDD & 64GB micro sd card.</p>*}
{*<p>&bull; Display Features - upto 10 finger touch panel, 1280x800 resolution, Gorilla glass & a wide IPS angle of 178 degrees.</p>*}
{*<p>&bull; Mobile Sensors -  upto 10 inbuilt mobile sensors such as ECompass, EyeProtect etc for a perfect mobile experience.</p>*}
{*<p>&bull; Unparalleled Connectivity - 5G Wi-Fi, Inbuilt Turbo 3G, Bluetooth 4.0, GPS, Wireless & Wired HDMI, LAN.</p>*}
{*<p>&bull; Multi User & Multi Windows – Supports upto 8 users & multiple windows including floating videos.</p>*}
{*<p>&bull; Unmatched Camera - upto 8MP primary camera with LED flash,  2MP secondary camera, HD Recording.</p>*}
{*<p>&bull; Powerful Battery – upto 6500Mah battery with a life of over 12 hours under normal usage.</p>*}
{*<p>&bull; Dual Speakers - For surround sound effect. </p>*}
{*</div>*}


{*<br />*}
{*The kind of detailing which we have done on our website We have customized our website, making it easier for you to choose your tablet as per your requirement. Our site can even list all the available tablets as per your choice of brand, price, screen size, operating system, feature, type of touch screen, and connectivity preferences.<br />*}

{*You can choose your ideal tablet with your choice of screen, from assistive, capacitive, or resistive displays. Our customers can choose different connectivity options like 3G ready tablets, tablets with Bluetooth & GPS, tablets with single & dual SIM calling, EVDO, GPRS, and WiFi, 5G Wi-Fi are available on our website. For those who love to shoot pictures and videos on the move, we offer the best tablets that feature front and rear facing cameras of up to 13 mega pixles. Buy from a range of best tablets that run on Android or Windows operating systems. Tablets with varying features like 3D, calling enabled tablets, tablets with HDMI, and USB ports and more are also on sale. All the tablets and their related accessories that are being sold on Milagrow are 100% genuine products.<br />*}

{*Technically a tablet is a mobile computer that has single unit which consists of a display, circuitry and battery. Tablet PCs have made our lives simpler with features like mobile computing and wireless connectivity at our fingertips. In this digital age, almost all big mobile computer brands have entered the tablet market with advanced features like 3G and Wi-Fi connectivity. You can connect it with or without wires for your presentations. Milagrow TabTops and tablets can be used to connect USB hubs, upto 64 GB micro SD cards. Milagrow TabTops are 2nd to none and you can compare them with Samsung, Apple, Dell, LG, Lenovo, Asus, Micromax, iBall, HCL and various other brands directly from our product page. With Milagrow TabTops you will always be just a tap away from surfing the internet, writing an email or video chatting with loved ones as they are loaded with great network applications, reliable operating systems and amazing battery life.<br />*}

{*When purchasing a tablet, it is best preferred to read reviews from popular websites and even compare the prices and buy the one that best meets your requirements and budget.<br />*}

{*We also have accessories like chargers, cables, batteries, HDMI, cases, covers, power bank, TV dongles, screen guards, ear phones etc. All the after sales service is completely owned by Milagrow.<br />*}

{*Milagrow TabTops come with 1 year comprehensive warranty or guarantee. Browse through the products featured on our site with expert descriptions, detailed specifications, perfect product comparisons, price comparisons to help you arrive at the right buying decision.<br />*}

{*Milagrow also offers free home delivery for many of our products along with easy EMI options, COD, payment by cheque. Get the best prices and the best online shopping experience every time, guaranteed. Milagrow Humantech is the best place to buy a TabTop or a Tablet PC  as you will get a choice of models here. Just place your order today and forget the hassles of bringing it home. We will ship it to your address absolutely free in two business days. So, order today and let laptops and ordinary tablets be history.<br />*}
{*</div>*}

{*{else}*}
{*<div class="ftr_text">&nbsp;</div>*}
{*{/if}*}

<br /></div></div>
                    
                    <div id="back-top" class="hidden-phone"><a href="#" rel="tooltip" title="Top"></a></div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="{$css_dir}theme/styles-ie.css" media="all"/>
    <![endif]-->
    <!--[if lt IE 9]>
    <link rel="stylesheet" type="text/css" href="{$css_dir}theme/styles-ie8.css" media="all"/>
    <![endif]-->
    <!--[if lt IE 7]>
    <script type="text/javascript" src="{$js_dir}theme/ds-sleight.js"></script>
    <script type="text/javascript" src="{$js_dir}theme/ie6.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="{$css_dir}theme/selectbox.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="{$css_dir}theme/widgets.css" media="all"/>
    <link rel="stylesheet" type="text/css" href="{$css_dir}theme/ma.banner7.css" media="all"/>
    <link rel="stylesheet" type="text/css" href="{$css_dir}theme/ma.thumbslider.css" media="all"/>
    <link rel="stylesheet" type="text/css" href="{$css_dir}theme/ma.newvertscroller.css" media="all"/>
    <link rel="stylesheet" type="text/css" href="{$css_dir}theme/ma.thumbslider.css" media="all"/>
    <link rel="stylesheet" type="text/css" href="{$css_dir}theme/ma.zoom.css" media="all"/>
    <link rel="stylesheet" type="text/css" href="{$css_dir}theme/print.css" media="print"/>
    {if $themesdev.td_google_analytics}{$themesdev.td_google_analytics|html_entity_decode}{/if}


    </div>
{/if}


<!-- new chnages for optimise the load time -->

{if $themesdev.td_facebook_likebox=='enable'}
    <div class="{if $themesdev.td_diaplay_fblikebox=='enable'}fb_right{else}fb_left{/if} hidden-phone">
        <div id="fb_icon"></div>
        <div class="fb_box">


            {if $themesdev.td_fb_page_url}
                <iframe src="https://www.facebook.com/plugins/likebox.php?href={$themesdev.td_fb_page_url|html_entity_decode}&amp;width=292&amp;height=375&amp;colorscheme=light&amp;show_faces=true&amp;border_color&amp;stream=false&amp;header=false"
                        scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:292px; height:385px;"
                        allowTransparency="true"></iframe>
            {else}
                <iframe src="https://www.facebook.com/plugins/likebox.php?id={$themesdev.td_fb_page_id|html_entity_decode}&amp;width=292&amp;colorscheme=light&amp;border_color&amp;show_faces=true&amp;connections=6&amp;stream=false&amp;header=375&amp;height=false"
                        scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:292px; height:385px;"
                        allowTransparency="true"></iframe>
            {/if}

            <script type="text/javascript">
                $(function () {
                    $(".fb_right").hover(function () {
                                $(".fb_right").stop(true, false).animate({ right: "0" }, 800, 'easeOutQuint');
                            },
                            function () {
                                $(".fb_right").stop(true, false).animate({ right: "-300" }, 800, 'easeInQuint');
                            }, 1000);
                });
                $(function () {
                    $(".fb_left").hover(function () {
                                $(".fb_left").stop(true, false).animate({ left: "0" }, 800, 'easeOutQuint');
                            },
                            function () {
                                $(".fb_left").stop(true, false).animate({ left: "-300" }, 800, 'easeInQuint');
                            }, 1000);
                });
            </script>

        </div>
    </div>
{/if}

<script type="text/javascript">
    var login_popup_active = false;
    var contact_popup_active = false;
    login_popup_active = true;
    var login_popup_errors = [];
    login_popup_errors['empty_email'] = 'E-mail address required';
    login_popup_errors['invalid_email'] = 'Invalid e-mail address';
    login_popup_errors['empty_passwd'] = 'Password is required';
    login_popup_errors['long_passwd'] = 'Password is too long';
    login_popup_errors['invalid_passwd'] = 'Invalid password';
    login_popup_errors['authentication_failed'] = 'Authentication failed';
    login_popup_errors['account_exists'] = 'An account is already registered with this e-mail, please fill in the password or request a new one.';

    login_url_rewrite = 'my-account';

    contact_popup_active = true;
    var contact_popup_errors = [];
    contact_popup_errors['empty_name'] = 'Name is required';
    contact_popup_errors['empty_email'] = 'E-mail is required';
    contact_popup_errors['invalid_email'] = 'Invalid e-mail address';
    contact_popup_errors['empty_heading'] = 'Subject heading is required';
    contact_popup_errors['empty_subject'] = 'Subject is required';
    contact_popup_errors['empty_message'] = 'Message is required';
    contact_popup_errors['invalid_message'] = 'Invalid message';
    contact_popup_errors['success'] = 'Your message has been successfully sent to our team.';
    contact_popup_errors['fail'] = 'An error occurred while sending message.';
    contact_popup_errors['no_contact'] = '';

    contact_url_rewrite = 'contact-us';
</script>

<script type="text/javascript">
    var fixed = false;

    $(document).ready(function () {
//        $("li.left-sub-submenu").parent().css("left", "-210px").css("z-index", 10000).css("border-right", "white").css("border-left", "1px");

        $('#search_query_top').click(function () {
            $(this).removeAttr('placeholder');
        });
        $('#search_query_top').focusout(function () {
            var obj = new Object();
            obj.placeholder = 'Search Products Here';
            $(this).attr(obj);
        })
        var scrollHeight = 100;
        if ($('body').attr('id') == 'index')
            scrollHeight = 770;


        $(document).scroll(function () {
            var isCompareWrapperExist = $('.block_content').find('.compare-cart-wrapper');
            if (isCompareWrapperExist.length != 0) {
                if ($(this).scrollTop() > scrollHeight) {
                    if (!fixed) {
                        fixed = true;
                        $('.compare-cart-wrapper').addClass('compare-scroll');
                    }
                } else {
                    fixed = false;
                    $('.compare-cart-wrapper').removeClass('compare-scroll');

                }
            }
        });
		
		 $(".question_image").mouseout(function(){
		 $(".qtip-focus").hide();
		 });
    });
    jQuery(document).ready(function ($) {
        /*  $('.language-switcher select').selectbox();*/


        $(".grid").click(function (e) {
            $("#products_wrapper ol.products-list").hide();
            $("#products_wrapper ul#grid_view_product").show();
            $('.list').removeClass('');
            $(this).addClass('grid-active');
            e.preventDefault();
        });
        $(".list").click(function (e) {
            $("#products_wrapper ol.products-list").show();
            $("#products_wrapper ul#grid_view_product").hide();
            $(this).addClass('list-active');
            $('.grid').removeClass('grid-active');
            e.preventDefault();
        });

    })

    {if $themesdev.td_proviewstyle=="gridview"}
    jQuery(document).ready(function ($) {
        $("#products_wrapper ol.products-list").hide();
        $("#products_wrapper ul#grid_view_product").show();
        $('.list').removeClass('list-active');
        $('.grid').addClass('grid-active');
    });
    {else}
    jQuery(document).ready(function ($) {
        $("#products_wrapper ol.products-list").show();
        $("#products_wrapper ul#grid_view_product").hide();
        $('.list').addClass('list-active');
        $('.grid').removeClass('grid-active');
    });
    {/if}

    {*{if $product->id}*}

    {*alert('product page id'+{$product->id});*}
    {*{elseif $category->id}*}
    {*alert('category page id'+{$category->id});*}
    {*{/if}*}

</script>




<!--<style type="text/css">
    {$themesdev.td_custom_style|html_entity_decode}
</style>
<script type="text/javascript">
    {$themesdev.td_custom_js|html_entity_decode}
</script>
<script src="http://cdn.webrupee.com/js" type="text/javascript"></script>-->
<!--  end new chnages-->
<style type="text/css"> 
.ftr_link{ float:left;}
.ftr_text{ text-align:justify; float:left;}
h1.ftr_title{ float:left; font-size:13px;}

</style>
<!-- Google Code for Remarketing Tag -->
<!--------------------------------------------------
Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. See more information and instructions on how to setup the tag on: http://google.com/ads/remarketingsetup
--------------------------------------------------->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 968875551;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/968875551/?value=0&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
</body>

</html>        









  
