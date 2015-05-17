{include file="$tpl_dir./errors.tpl"}
<div class="page-title custom-page">
    <h1>{l s='Product Comparison' mod='featurecategories'}</h1>
</div>

<div class="fc_compare_container">

    <!-- AddThis Button BEGIN -->
    <!-- AddThis Button BEGIN -->
    <div class="printCompare">
        <a class="prnt_icon" title="Print" href="{$pdfPath}">Print Comparison <img
                    src="{$smarty.const._PS_JS_DIR_}../modules/featurecategories/printer_blue.png"/></a>
    </div>

    <link type="text/css" rel="stylesheet"
          href="{$smarty.const._PS_JS_DIR_}../modules/featurecategories/views/css/comparison_style_embed.css"/>
    <script type="text/javascript"
            src="{$smarty.const._PS_JS_DIR_}../modules/featurecategories/views/js/comparison.js"></script>

    {if $products|@count > 0}
        <table class="fc_compare_table">
            <tr>
                {assign var=totalProducts value=count($products)}

                <td class="compare-col1">
                </td>
                {foreach from = $products item = product}
                    <td class="compare-col2">
                        <div class="fc_image">
                            <a class="remove" href="{$product->id}"> </a>
                            <img src="{$link->getImageLink($product->link_rewrite, $product->id_image, 'large_default')}"/>
                        </div>
                        <div class="fc_name">
                            <a href="{$link->getProductLink($product->id)}">{$product->name|escape:'htmlall':'UTF-8'|truncate:40:'...'} </a>
                            <br>{$product->rating}
                        </div>
                        {*<a class="remove" href="{$product->id}"> </a>*}
                    </td>
                {/foreach}
                {for $product_description=1 to (4-$totalProducts)}
                    <td style="vertical-align: middle">
                        <div align="center">

                            <div class="input-box">
                                <select name="category" id="{$product_description}"
                                        class="product_select category" {if $product_description>1}disabled{/if}>
                                    <option value="">Select Category</option>
                                    {foreach from=$categories key=myId item=i}
                                        <option value="{$i.id}">{$i.name}</option>
                                    {/foreach}
                                </select>
                                                <span
                                                        id="ajax-loader-category-{$product_description}"
                                                        style="display: none"><img
                                                            src="{$this_path}ajax-loader.gif"
                                                            alt="{l s='ajax-loader' mod='featurecategories'}"/></span>
                            </div>


                            <div class="input-box">
                                <select name="product" id="product_{$product_description}"
                                        class="product_select productChange" disabled="">
                                    <option value="">Select Product</option>
                                </select>
                            </div>
                        </div>
                    </td>
                {/for}
            </tr>
            <tr class="fc_price_value">
                <td>Price</td>
                {foreach from = $products item = product}
                    <td class="price-block">{convertPrice price=$product->price+(($product->price*$product->tax_rate)/100)}</td>
                {/foreach}
                {for $product_description=1 to (4-$totalProducts)}
                    <td class="price-block"></td>
                {/for}
            </tr>

            <tr class="fc_product_condition">
                <td>Product Condition</td>
                {foreach from = $products item = product}
                    <td class="product-condition-block">{if (isset($product->condition)&& $product->condition)}{ucfirst($product->condition)}{else}-{/if}</td>
                {/foreach}
                {for $product_description=1 to (4-$totalProducts)}
                    <td class="price-block"></td>
                {/for}
            </tr>

            {assign var=cat_index value=0}
            {foreach from=$features_by_categories key=category item=feature_ids}
                {if $helper->checkAllowCategories($category)==false}
                    {continue}
                {/if}
                <tr>
                    <td colspan={$product_count+1}  class=
                    "category" id="{$cat_index}
                    " {literal}onclick="handleCategoryClick($(this)){/literal}">
                    {if $cat_index==0}
                        <img src="{$smarty.const._PS_JS_DIR_}../modules/featurecategories/views/img/menu_up.jpg"
                             class="img_{$cat_index}"/>
                    {else}
                        <img src="{$smarty.const._PS_JS_DIR_}../modules/featurecategories/views/img/menu_down.jpg"
                             class="img_{$cat_index}"/>
                    {/if}

                    {$category}
                    {if $helper->getDescription($category) !=null}
                        <img src="{$smarty.const._PS_JS_DIR_}../modules/featurecategories/views/img/question_icon.gif"
                             style="float:right; margin:3px 5px 0px 0px" class="question_image"/>
                        <div class="tooltip_val" style="display:none;">{$helper->getDescription($category)}</div>
                    {/if}
                    </td>
                    {for $product_description=1 to (4-$totalProducts)}
                        <td class="category"></td>
                    {/for}
                </tr>
                {foreach from = $feature_ids item = feature_id}
                    {if $helper->isNotEmptyValues($feature_id, $products) == true}
                        <tr class="fc_feature_value {$cat_index}" {if $cat_index>0}style="display: none"{/if}>
                            <td>{$helper->getFeatureName({$feature_id})}
                                {assign var=productDescription value=$helper->getProductDescription($feature_id)}
                                {if $productDescription!=null}
                                    <img src="{$smarty.const._PS_JS_DIR_}../modules/featurecategories/views/img/question_icon.gif"
                                         style="float:right;margin:3px 5px 0px 0px" class="question_image"/>
                                    <div class="tooltip_val"
                                         style="display:none;">{$productDescription}</div>
                                {/if}
                            </td>
                            {foreach from = $products item = product}
                                <td>{$helper->getFeatureVal({$product->id},{$feature_id})}</td>
                            {/foreach}
                            {for $product_description=1 to (4-$totalProducts)}
                                <td></td>
                            {/for}

                        </tr>
                    {/if}
                {/foreach}
                {assign var=cat_index value=$cat_index+1}
            {/foreach}
        </table>
        <div class="specification_disclaimer_block" style="text-align:left;margin-bottom: 20px;">
            <p><strong>Disclaimers:</strong></p>
            <ol>
                <li>Specifications are subject to change without notice. Please call or write to us in case you would
                    like to be doubly sure. For material which is not as per specifications, full refund is possible
                    within 3 days of delivery or free replacement is available within 30 days of purchase.
                </li>
                <li>Press on <img
                            src="{$smarty.const._PS_JS_DIR_}../modules/featurecategories/views/img/menu_down.jpg"
                            class="specification_collapse"/> to expand
                    and <img src="{$smarty.const._PS_JS_DIR_}../modules/featurecategories/views/img/menu_up.jpg"
                             class="specification_collapse"/> to collapse the rows.
                </li>
            </ol>
            {*<p style="float:left"><strong>Note: </strong>Press on <img src="/js/../modules/featurecategories/views/img/menu_down.jpg"*}
            {*class="specification_collapse"> to expand*}
            {*and <img src="/js/../modules/featurecategories/views/img/menu_up.jpg"*}
            {*class="specification_collapse"> to collapse the rows.</p>*}
        </div>
    {else}
        {l s='No products to compare' mod='featurecategories'}
    {/if}
</div>