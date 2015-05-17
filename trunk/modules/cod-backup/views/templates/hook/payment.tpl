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
    $(document).ready(function () {
        $('.cod_disable').click(function (e) {
            e.preventDefault();
            var id = $(this).attr('id');
            if (id == 'no_cod') {
                alert('Sorry currently we are not providing COD service to your location.Go back and change Address or choose different payment option')
            }
            else if (id == 'minimum_cod_amount') {
                alert('For using COD amount must be between Rs 4000 to Rs 25000.')
            }
        });
    })
</script>
{if $enable==true}
    {if $cod_available==1}
        <p class="payment_module">
            <a class="payment-link" href="{$link->getModuleLink('cod', 'validation', [], true)}"
               title="{l s='Pay with cash on delivery (COD)' mod='cod'}">
                <img src="{$this_path}cod.gif" alt="{l s='Pay with cash on delivery (COD)' mod='cod'}"
                     style="float:left;"/>
                {l s='Pay with cash on delivery (COD)' mod='cod'}
                {l s=', Rs 750 advance. Rest pay with cash on delivery (COD)' mod='cod'}
                <br style="clear:both;"/>
            </a>
        </p>
    {else}
        <p class="payment_module">
            <a  href="#" class="cod_disable payment-link" id="no_cod" title="{l s='Pay with cash on delivery (COD)' mod='cod'}">
                <img src="{$this_path}cod.gif" alt="{l s='Pay with cash on delivery (COD)' mod='cod'}"
                     style="float:left;"/>
                {l s='Pay with cash on delivery (COD)' mod='cod'}
                {l s=', Rs 750 advance. Rest pay with cash on delivery (COD)' mod='cod'}
                <br style="clear:both;"/>
            </a>
        </p>
    {/if}

{else}
    <p class="payment_module">
        <a href="#" class="cod_disable payment-link" id="minimum_cod_amount"
           title="{l s='Pay with cash on delivery (COD)' mod='cod'}">
            <img src="{$this_path}cod.gif" alt="{l s='Pay with cash on delivery (COD)' mod='cod'}" style="float:left;"/>
            {l s='Pay with cash on delivery (COD)' mod='cod'}
            {l s=', Rs 750 advance. Rest pay with cash on delivery (COD)' mod='cod'}
            <br style="clear:both;"/>
        </a>
    </p>
{/if}
