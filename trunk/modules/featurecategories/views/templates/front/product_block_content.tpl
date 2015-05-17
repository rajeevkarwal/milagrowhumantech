<div class="row-fluid">

    {if count($output1)>0}
        <div class="span6">
            <ul class="buy-view-list">
                {foreach from = $output1 item = dataRow}
                    {if $dataRow[1]['value']}
                        {assign var=productTooltip value=$helper->getProductDescription($dataRow[2]['id_feature'])}
                    <li class="{if $productTooltip!=null}question_image_product_block{/if}">
                        {$dataRow[1]['value']}

                        {if $productTooltip!=null}
                            <img src="{$smarty.const._PS_JS_DIR_}../modules/featurecategories/views/img/question_icon.gif"
                                 style="margin:3px 5px 0px 0px"/>
                            <div class="tooltip_val"
                                 style="display:none;">{$productTooltip}</div>
                        {/if}
                    </li>
                    {/if}
                {/foreach}
            </ul>
        </div>
    {/if}
    {if count($output2)>0}
        <div class="span6">
            <ul class="buy-view-list">
                {foreach from = $output2 item = dataRow}
                    {if $dataRow[1]['value']}
                        {assign var=productTooltip value=$helper->getProductDescription($dataRow[2]['id_feature'])}
                        <li class="{if $productTooltip!=null}question_image_product_block{/if}">
                            {$dataRow[1]['value']}

                            {if $productTooltip!=null}
                                <img src="{$smarty.const._PS_JS_DIR_}../modules/featurecategories/views/img/question_icon.gif"
                                     style="margin:3px 5px 0px 0px"/>
                                <div class="tooltip_val"
                                     style="display:none;">{$productTooltip}</div>
                            {/if}
                        </li>
                    {/if}
                {/foreach}
            </ul>
        </div>
    {/if}
</div>