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
*  @version  Release: $Revision$
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
<script type="text/javascript">
    $(function () {
        $('#showReview').click(function (e) {
            e.preventDefault();
            $('*[id^="idTab"]').addClass('block_hidden_only_for_screen');
            $('div#idTab5').removeClass('block_hidden_only_for_screen');
            $('ul#more_info_tabs a[href^="#idTab"]').removeClass('selected');
            $('a[href="#idTab5"]').addClass('selected');
            $.scrollTo('#idTab5');
        });

        $('#require_login').click(function (e) {
            e.preventDefault();
//            $.fancybox('Please <a href="/my-account">login here</a> to add review');
            showLoginPopup();
        })
    });
</script>

<div id="product_comments_block_extra">
    <p class="rating-link">

    <div class="mg-stars-small" title="{$average} stars">
        <div class="product_rating" style="width:{($average/5)*100}%;">
        </div>
    </div>
    <span style="padding-left: 5px;padding-right:5px;color: #ffa930;">{$totalRating} Rating(s) </span>
    <span class="separator">|</span>
    {if $cookie->isLogged()==true}
        {if $newReview==true}
            <a href="#" id="showReview">{$totalReviews} {l s='Review(s)' mod='productcomments'}</a>
            <span class="separator"> |</span>
            <a href="#new_comment_form"
               class="open-comment-form last">{l s='Add Rating / Review' mod='productcomments'}</a>
        {else}
            <a href="#" id="showReview">{$totalReviews} {l s='Review(s)' mod='productcomments'}</a>
            <span class="separator"> |</span>
            <a href="#new_comment_form"
               class="open-comment-form last">{l s='Edit Review' mod='productcomments'}</a>
        {/if}
    {else}
        <a href="#" id="showReview">{$totalReviews} {l s='Review(s)' mod='productcomments'}</a>
        <span class="separator"> |</span>
        <a href="#" id="require_login"
           class="">{l s='Add Rating / Review' mod='productcomments'}</a>
    {/if}

    </p>

</div>

