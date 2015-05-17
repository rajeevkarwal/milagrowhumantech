{capture name=path}{l s='Annual Maintenance Contract'}{/capture}
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
                    Your cheque must include:
                    <br><br>- Payment amount. <span class="price"><strong>Rs {$amount}</strong></span>
                    <br><br>- Payable to the order of <strong>{if $chequeName}{$chequeName}{else}___________{/if}</strong>
                    <br><br>- Mail to <strong>{if $chequeAddress}{$chequeAddress}{else}___________{/if}</strong>
                    <br><br>- Do not forget to include your order reference {$reference}.
                    <br><br>An email has been sent to you with this information.
                    <br><br><strong>Your order will be sent as soon as we receive your payment.</strong>
                    <br><br>For any questions or for further information, please contact our <a href="/customer-care">customer
                        service department.</a>.
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

