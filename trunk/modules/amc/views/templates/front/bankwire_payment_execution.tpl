{capture name=path}{l s='Order Confirmation'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}
<div class="main">
    <div class="main-inner">
        <div class="row-fluid show-grid">
            <div class="span9">
                <div class="page-title">
                    <h1>{l s='Order confirmation'}</h1>
                </div>

                <p>Your order on Milagrow HumanTech is complete.
                    <br><br>
                    Please send us a bank wire with
                    <br><br>- Amount <span class="price"> <strong>Rs {$amount}</strong></span>
                    <br><br>- Name of account owner  <strong>{if $bankwireOwner}{$bankwireOwner}{else}___________{/if}</strong>
                    <br><br>- Include these details  <strong>{if $bankwireDetails}{$bankwireDetails}{else}___________{/if}</strong>
                    <br><br>- Bank name  <strong>{if $bankwireAddress}{$bankwireAddress}{else}___________{/if}</strong>
                    <br><br>- Do not forget to insert your order reference {$reference} in the subject of your bank wire.
                    <br><br>An email has been sent with this information.
                    <br><br> <strong>Your order will be sent as soon as we receive payment.</strong>
                    <br><br>If you have questions, comments or concerns, please contact our <a href="/customer-care">expert customer support team. </a>.
                </p>

                <br/>
            </div>
        </div>
    </div>
</div>
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

