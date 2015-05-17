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
</body>
</html>        









  
