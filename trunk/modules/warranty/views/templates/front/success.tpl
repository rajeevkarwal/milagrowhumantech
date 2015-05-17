{capture name=path}{l s='Product Warranty Registration'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}
<style>
    fieldset {
        background-color: #FFFFFF;
        border: 2px solid #F5F5F5;
        margin: 0 auto 15px;
        padding: 15px;
    }
</style>
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
                <div class="page-title">
                    <h1>{l s='Product Warranty Registration'}</h1>
                </div>
                <form>
                <fieldset>
                    <p class="cms-banner-img"><img src="/img/cms/cms-banners/warranty-registration.png" alt="milagrow-product-warranty-registration">
                    </p>

                    <p>Thank you for registering your product with us. Online registration of product helps you with enhanced
                        technical support and faster warranty claims. It also helps you get notified of system updates and new
                        promotions from Milagrow HumanTech.</p>

                    <p>
                        For any queries, complaints or suggestions, please email us at customercare@milagrow.in or call
                        09953476189 and 0124-4309570/71/72. Timings: 9:30 AM - 7:30 PM.
                    </p>
                    <ul class="footer_links">
                        <li><a href="{$base_dir}"><img class="icon" alt="" src="{$img_dir}icon/home.gif"/></a><a
                                    href="{$base_dir}">{l s='Home'}</a></li>
                    </ul>

                </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>



