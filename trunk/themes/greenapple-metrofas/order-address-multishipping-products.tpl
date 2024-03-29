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
*  @version  Release: $Revision$
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
<p>{l s='Choose the delivery addresses'}</p>
<script type="text/javascript">
    CloseTxt = '{l s='Submit' js=1}';
    QtyChanged = '{l s='Some product quantities have changed. Please check them' js=1}';
    ShipToAnOtherAddress = '{l s='Ship to multiple addresses' js=1}';
</script>
<div id="order-detail-content" class="table_block">
    <table  id="cart_summary" class="multishipping-cart data-table cart-table">
        <col width="1" />
        <col />
        <col width="1" />
        <col width="1" />
        <col width="1" />
        <col width="1" />
        <col width="1" />
        <tr>
            <th class="cart_product first_item" rowspan="1">{l s='Product'}</th>
            <th class="cart_description item" rowspan="1">{l s='Description'}</th>
            <th class="cart_ref item" rowspan="1">{l s='Ref.'}</th>
            <th class="cart_quantity item" rowspan="1">{l s='Qty'}</th>
            <th class="shipping_address last_item" rowspan="1">{l s='Shipping address'}</th>
            <th class="delete_item">{l s=''}</th>
        </tr>
        </thead>
        <tbody>
            {foreach $product_list as $product}
                {assign var='productId' value=$product.id_product}
                {assign var='productAttributeId' value=$product.id_product_attribute}
                {assign var='quantityDisplayed' value=0}
                {assign var='odd' value=$product@iteration%2}
                {* Display the product line *}
                {include file="$tpl_dir./order-address-product-line.tpl" productLast=$product@last productFirst=$product@first}
            {/foreach}
        </tbody>
    </table>
</div>
