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
<script type="text/javascript">
    var productcomments_controller_url = '{$productcomments_controller_url}';
    var confirm_report_message = "{l s='Are you sure you want report this comment?' mod='productcomments'}";
    var secure_key = "{$secure_key}";
    var productcomments_url_rewrite = '{$productcomments_url_rewriting_activated}';
    $(document).ready(function () {
        $('#review_sort_by').change(function (e) {
            e.preventDefault();
            var productId = $('#product_id').val();
            window.location.href = productcomments_controller_url + '?id_product=' + productId + '&sort_order=' + $(this).val();
        });

        $('#review-previous-btn').click(function (e) {
            e.preventDefault();
            var productId = $('#product_id').val();
            var previous = $('#previous').val();
            var sort_by = $('#review_sort_by option:selected').val();
            window.location.href = productcomments_controller_url + '?id_product=' + productId + '&page=' + previous + '&sort_order=' + sort_by;
        });

        $('#review-next-btn').click(function (e) {
            e.preventDefault();
            var productId = $('#product_id').val();
            var next = $('#next').val();
            var sort_by = $('#review_sort_by option:selected').val();
            window.location.href = productcomments_controller_url + '?id_product=' + productId + '&page=' + next + '&sort_order=' + sort_by;
        });
    });
</script>
<style>
    a#review-next-btn, a#review-previous-btn {
        overflow: visible;
        width: auto;
        border: 0;
        padding: 0;
        margin: 0;
        background: transparent;
        cursor: pointer;
        background: #ffa930;
        color: white;
        padding: 7px;
    }

    a#review-next-btn:hover, a#review-previous-btn:hover {
        color: white !important;
    }
</style>
<script type="text/javascript" src="{$jsSource1}"></script>
<script type="text/javascript" src="{$jsSource2}"></script>
<script type="text/javascript" src="{$jsSource3}"></script>

<div class="container">
    <div class="contain-size">
        {capture name=path}{l s='product review' mod='productcomments'}{/capture}
        {include file="$tpl_dir./breadcrumb.tpl"}
        <div class="main">
            <div class="main-inner">
                <div class="row-fluid">
                    <div class="span3">
                      {$HOOK_LEFT_COLUMN}
                    </div>
                    <div class="span9">
                        <div class="page-title">
                            <h1>{$product->name[$product->id]} Reviews</h1>
                        </div>

                        {if $comments}
                            <span>{$showing} <div style="float:right" class="comment_sort_block">
                             <input type="hidden" name="productid" id="product_id" value="{$product->id}"/>
                             <input type="hidden" name="previous" value="{$previous}" id="previous"/>
                             <input type="hidden" name="next" value="{$next}" id="next"/>
                                    <label for="review_sort_by">Sort By</label>
                             <select name="sortby" id="review_sort_by">
                                 <option value="date" {if $sortBy=='date'} selected="selected"{/if}>Most Recent</option>
                                 <option value="useful" {if $sortBy=='useful'} selected="selected"{/if}>Most Helpful
                                 </option>
                                 <option value="grade" {if $sortBy=='grade'} selected="selected"{/if}>Rating</option>
                             </select>
                            </div></span>
                            {foreach from=$comments item=comment}
                                {if $comment.content}
                                    <div class="row-fluid">
                                        <div class="span3">
                                            <div id="product_comments_block_tab">
                                                <div class="comment_author">
                                                    <span>{l s='Grade' mod='productcomments'}&nbsp</span>

                                                    <div class="star_content clearfix">
                                                        {section name="i" start=0 loop=5 step=1}
                                                            {if $comment.grade le $smarty.section.i.index}
                                                                <div class="star"></div>
                                                            {else}
                                                                <div class="star star_on"></div>
                                                            {/if}
                                                        {/section}
                                                    </div>
                                                    <div class="comment_author_infos">
                                                        <strong>{$comment.customer_name|escape:'html':'UTF-8'}</strong><br/>
                                                        <em>{dateFormat date=$comment.date_add|escape:'html':'UTF-8' full=0}</em>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span9">
                                            <div class="comment_details">
                                                <p class="title_block">{$comment.title}</p>

                                                <p>{$comment.content|escape:'html':'UTF-8'|nl2br}</p>
                                                <ul>
                                                    {if $comment.total_advice > 0}
                                                        <li>{l s='%1$d out of %2$d people found this review useful.' sprintf=[$comment.total_useful,$comment.total_advice] mod='productcomments'}</li>
                                                    {/if}
                                                    {if $logged == 1}
                                                        {if !$comment.customer_advice}
                                                            <li>{l s='Was this comment useful to you?' mod='productcomments'}
                                                                <button class="button comments_btn usefulness_btn"
                                                                        data-is-usefull="1"
                                                                        data-id-product-comment="{$comment.id_product_comment}">
                                                                    <span><span>{l s='yes' mod='productcomments'}</span></span>
                                                                </button>
                                                                <button class="button usefulness_btn"
                                                                        data-is-usefull="0"
                                                                        data-id-product-comment="{$comment.id_product_comment}">
                                                                    <span><span>{l s='no' mod='productcomments'}</span></span>
                                                                </button>
                                                            </li>
                                                        {/if}
                                                        {if !$comment.customer_report}
                                                            <li><span class="report_btn"
                                                                      data-id-product-comment="{$comment.id_product_comment}">{l s='Report abuse' mod='productcomments'}</span>
                                                            </li>
                                                        {/if}
                                                    {/if}
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                {/if}
                                <hr>
                            {/foreach}
                            <div class="page">
                                {if $previous>0}
                                    <a class="button" id="review-previous-btn">Prev</a>
                                {/if}
                                {if $next>0}
                                    <a class="button" id="review-next-btn">Next</a>
                                {/if}
                            </div>
                        {else}
                            {if ($too_early == false AND ($logged OR $allow_guests))}
                                <div class="row-fluid">
                                    <p class="align_center">
                                        <a id="new_comment_tab_btn" class="open-comment-form"
                                           href="#new_comment_form">{l s='Be the first to write your review' mod='productcomments'}
                                            !</a>
                                    </p>
                                </div>
                            {else}
                                <div class="row-fluid">
                                    <p class="align_center">{l s='No customer comments for the moment.' mod='productcomments'}</p>
                                </div>
                            {/if}
                        {/if}

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{*<!-- Fancybox -->*}
{*<div style="display: none;">*}
{*<div id="new_comment_form">*}
{*<form action="#">*}
{*<h2 class="title">{l s='Write your review' mod='productcomments'}</h2>*}
{*<div class="product clearfix">*}
{*<img src="{$link->getImageLink($product->link_rewrite, $productcomment_cover, 'home_default')}" height="{$homeSize.height}" width="{$homeSize.width}" alt="{$product->name|escape:html:'UTF-8'}" />*}
{*<div class="product_desc">*}
{*<p class="product_name"><strong>{$product->name}</strong></p>*}
{*{$product->description_short}*}
{*</div>*}
{*</div>*}

{*<div class="new_comment_form_content">*}
{*<h2>{l s='Write your review' mod='productcomments'}</h2>*}

{*<div id="new_comment_form_error" class="error" style="display: none;">*}
{*<ul></ul>*}
{*</div>*}

{*{if $criterions|@count > 0}*}
{*<ul id="criterions_list">*}
{*{foreach from=$criterions item='criterion'}*}
{*<li>*}
{*<label>{$criterion.name|escape:'html':'UTF-8'}:</label>*}
{*<div class="star_content">*}
{*<input class="star" type="radio" name="criterion[{$criterion.id_product_comment_criterion|round}]" value="1" />*}
{*<input class="star" type="radio" name="criterion[{$criterion.id_product_comment_criterion|round}]" value="2" />*}
{*<input class="star" type="radio" name="criterion[{$criterion.id_product_comment_criterion|round}]" value="3" checked="checked" />*}
{*<input class="star" type="radio" name="criterion[{$criterion.id_product_comment_criterion|round}]" value="4" />*}
{*<input class="star" type="radio" name="criterion[{$criterion.id_product_comment_criterion|round}]" value="5" />*}
{*</div>*}
{*<div class="clearfix"></div>*}
{*</li>*}
{*{/foreach}*}
{*</ul>*}
{*{/if}*}

{*<label for="comment_title">{l s='Title' mod='productcomments'}: <sup class="required">*</sup></label>*}
{*<input id="comment_title" name="title" type="text" value=""/>*}

{*<label for="content">{l s='Comment' mod='productcomments'}: <sup class="required">*</sup></label>*}
{*<textarea id="content" name="content"></textarea>*}

{*{if $allow_guests == true && $logged == 0}*}
{*<label>{l s='Your name' mod='productcomments'}: <sup class="required">*</sup></label>*}
{*<input id="commentCustomerName" name="customer_name" type="text" value=""/>*}
{*{/if}*}

{*<div id="new_comment_form_footer">*}
{*<input id="id_product_comment_send" name="id_product" type="hidden" value='{$id_product_comment_form}'></input>*}
{*<p class="fl required"><sup>*</sup> {l s='Required fields' mod='productcomments'}</p>*}
{*<p class="fr">*}
{*<button id="submitNewMessage" name="submitMessage" type="submit">{l s='Send' mod='productcomments'}</button>&nbsp;*}
{*{l s='or' mod='productcomments'}&nbsp;<a href="#" onclick="$.fancybox.close();">{l s='Cancel' mod='productcomments'}</a>*}
{*</p>*}
{*<div class="clearfix"></div>*}
{*</div>*}
{*</div>*}
{*</form><!-- /end new_comment_form_content -->*}
{*</div>*}
{*</div>*}
{*<!-- End fancybox -->*}
