{if $products|@count > 0}
    <table style="font-family:arial;" width="100%" cellpadding="5">
        <tr>
            {assign var=totalProducts value=count($products)}
            {if $totalProducts==1}
                {assign var=width value=50}
            {elseif $totalProducts==2}
                {assign var=width value=33.33}
            {elseif $totalProducts==3}
                {assign var=width value=25}
            {elseif $totalProducts==4}
                {assign var=width value=20}
            {/if}
            <td style=" width:{$width}%;border-left: 1px solid #bde2ee; border-top: 1px solid #bde2ee;border-right: 1px solid #bde2ee;">
            </td>
            {foreach from = $products item = product}
                <td style="width: {$width}%; border-top: 1px solid #bde2ee;border-right: 1px solid #bde2ee;font-size: 20px;text-align:center; padding:50px">
                    <div class="fc_name">
                        <a style="font-size: 28px"
                           href="{$link->getProductLink($product->id)}">{$product->name|escape:'htmlall':'UTF-8'|truncate:40:'...'} </a>
                    </div>
                </td>
            {/foreach}
        </tr>
        <tr>
            <td style=" width:{$width}%;border-left: 1px solid #bde2ee; border-top: 1px solid #bde2ee;border-right: 1px solid #bde2ee;">
            </td>
            {foreach from = $products item = product}
                <td style="width: {$width}%; border-top: 1px solid #bde2ee;border-right: 1px solid #bde2ee;font-size: 20px;text-align:center; padding:1px">
                    <div class="fc_image">
                        <img src="{$link->getImageLink($product->link_rewrite, $product->id_image, 'large_default')}"
                             style="width:150px;height:150px;"/>
                    </div>
                </td>
            {/foreach}
        </tr>
        <tr class="fc_price_value">
            <td style="border-left: 1px solid #bde2ee;border-top: 1px solid #bde2ee;border-right: 1px solid #bde2ee;font-size: 24px;padding-left: 10px;padding-right: 10px;padding-top: 10px;padding-bottom: 10px">
                <strong>Price</strong></td>
            {foreach from = $products item = product}
                <td style="border-right: 1px solid #bde2ee; vertical-align: top;border-top: 1px solid #bde2ee;font-size: 20px;padding: 50px">
                    Rs. {$helper->getFormattedPrice($product)}</td>
            {/foreach}
        </tr>

        <tr class="fc_price_value">
            <td style="border-left: 1px solid #bde2ee;border-top: 1px solid #bde2ee;border-right: 1px solid #bde2ee;font-size: 24px;padding-left: 10px;padding-right: 10px;padding-top: 10px;padding-bottom: 10px">
                Product Condition</td>
            {foreach from = $products item = product}
                <td style="border-right: 1px solid #bde2ee; vertical-align: top;border-top: 1px solid #bde2ee;font-size: 20px;padding: 50px">
                    {if (isset($product->condition)&& $product->condition)}{ucfirst($product->condition)}{else}-{/if}</td>
            {/foreach}
        </tr>

        
        {assign var=cat_index value=0}
        {foreach from=$features_by_categories key=category item=feature_ids}
            {if $helper->checkAllowCategories($category)==false}
                {continue}
            {/if}
            <tr style="min-height: 80px;">
                <td colspan="{$product_count+1}"
                    style="border-left: 1px solid #bde2ee;background-color: #d7eaf0;vertical-align: top;font-size: 24px;padding: 50px"
                    class="category"
                    id="{$cat_index}">
                    <strong>{$category}</strong>
                </td>
            </tr>
            {foreach from = $feature_ids item = feature_id}
                {if $helper->isNotEmptyValues($feature_id, $products) == true}
                    <tr class="fc_feature_value {$cat_index}" style="min-height: 80px;">
                        <td style="border-left: 1px solid #bde2ee;border-right: 1px solid #bde2ee;vertical-align: top;border-bottom: 1px solid #bde2ee;font-size: 20px;padding: 50px">{$helper->getFeatureName({$feature_id})}</td>
                        {foreach from = $products item = product}
                            <td style="border-right: 1px solid #bde2ee; border-bottom: 1px solid #bde2ee;vertical-align: top;font-size: 20px;padding: 50px">{$helper->getFeatureVal({$product->id},{$feature_id})}</td>
                        {/foreach}

                    </tr>
                {/if}
            {/foreach}
            {assign var=cat_index value=$cat_index+1}
        {/foreach}
    </table>
{else}
    {l s='No products to compare' mod='featurecategories'}
{/if}
