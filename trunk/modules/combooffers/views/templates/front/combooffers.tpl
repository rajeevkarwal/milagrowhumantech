{capture name=path}{l s='Combo Offers'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}

<div class="main">
    <div class="main-inner">
        <div class="row-fluid show-grid">
            {if $themesdev.td_siderbar_without=="enable"}
                <div class="col-left sidebar span3">
                    {$HOOK_LEFT_COLUMN}
                    {$themesdev.td_left_sidebar_customhtml|html_entity_decode}

                </div>
            {/if}

            <div class="span9">
                <form class="std">
                    <h1>{l s='Combo Offers'}</h1>
                    <fieldset>
                        <div class="rte">

                            <div class="row-fluid">
                                <img src="/img/cms/cms-banners/combo-offer-banner.png" alt="" width="804" height="191">
                            </div>
                            <div class="row-fluid">

                                    {$firstProduct=1}
                                    {$totalProducts=$products|count}
                                    {*{$totalProducts}*}
                                    {if $totalProducts>0}
                                    {foreach from=$products key=productkey item=product}
                                        {if $firstProduct==1}
                                        <div class="row-fluid" style="padding-top:20px;">
                                        {/if}
                                        <div class="span6 app-box" style="padding-top: 0px; padding-right: 0px;">
                                            <div class="row-fluid">
                                                <div class="span6"><img
                                                            src="{$link->getImageLink($product['link_rewrite'], $product['cover']['id_image'], 'large_default')}"
                                                            alt="" width="120" height="120"><br>
                                                </div>
                                                <div class="span6" style="font-size: 16px;">
                                                    <div class="priceInfo">
                                                        <div class="offerTag DISCOUNT">
                                                            <div class="offerDesc row-fluid">
                                                                <div class="offerText">
                                                                    <div style="font-size: 16px;" title="">Save {($product['reductionPrice']-$product['productPrice'])|round}<br><br></div>
                                                                </div>
                                                                <div class="offerTag DISCOUNT">
                                                                    <div class="offerDesc row-fluid"><a class="viewMore"
                                                                                                        href="{$product['product_link']}">Products
                                                                            on offer</a></div>
                                                                    <div class="flap DISCOUNT">&nbsp;</div>
                                                                </div>
                                                                <div class="fk_titleInfo"><a class="title fk_darkGrey"
                                                                                             href="{$product['product_link']}">{$product['name']}</a></div>
                                                            </div>
                                                        </div>
                                                        <div class="priceBox fk_roboto"><span
                                                                    class="fk_striked fk_lightGrey beforeDiscount">{convertPrice price=$product['reductionPrice']}</span>&nbsp;&nbsp;
                                                            <span class="price">{convertPrice price=$product['productPrice']}</span></div>
                                                        <div style="margin-top: 5px;"><a
                                                                    href="{$product['product_link']}"
                                                                    style="font-size: 14px; font-weight: 300; border: 1px solid #ccc; background: linear-gradient(to bottom, #484848 0, #4e4e4e 13%, #4d4d4d 23%, #383838 47%, #343434 53%, #2c2c2c 100%); color: #fff; padding: 2px 5px 2px 5px;">Click
                                                                for details</a></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                            {if $firstProduct==2}
                                                </div>
                                                {$firstProduct=1}
                                            {else}
                                                {$firstProduct=$firstProduct+1}
                                            {/if}



                                    {/foreach}
                                    {if $firstProduct==$totalProducts}
                                        </div>
                                        {/if}
                            {else}
                            <p>No Active Combos at this time</p>
                            {/if}

                            </div>
                        </div>
                    </fieldset>
                </form>




            </div>
        </div>
    </div>
</div>
