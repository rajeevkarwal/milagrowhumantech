{capture name=path}{l s='Bulk Purchase'}{/capture}
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
                    <h1>{l s='Bulk Purchase'}</h1>
                </div>

                <fieldset>
                    <p class="cms-banner-img"><img src="/img/cms/cms-banners/bulk-orders.png" alt="milagrow-bulk-purchase">
                    </p>

                    <p>Many thanks for your bulk purchase enquiry. Our team would get back to you very soon. In case you want
                to contact us before our team reaches to you, you can call us on 09953476189 and 0124-4309570/71/72
                Timings: 10:00 AM - 7.00 PM or email us at sales@milagrow.in.</p>
                    <ul class="footer_links">
                        <li><a href="{$base_dir}"><img class="icon" alt="" src="{$img_dir}icon/home.gif"/></a><a
                                    href="{$base_dir}">{l s='Home'}</a></li>
                    </ul>

                </fieldset>

            </div>
        </div>
    </div>
</div>

<!-- Google Code for MilagrowHumantech Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 968875551;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "VZV0CJnS7xEQn7z_zQM";
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/968875551/?label=VZV0CJnS7xEQn7z_zQM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>


