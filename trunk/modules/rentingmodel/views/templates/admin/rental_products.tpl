{*
* 2007-2015 PrestaShop
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
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2015 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
<style>
    table tr th,td{
        padding: 8px;
        text-align: center;
    }
</style>
<script>
    function deleteRow(num)
    {
        $.ajax(
                {
                    type:'GET',
                    url:'/modules/rentingmodel/library.php?row_id='+num,
                    success:function(data)
                    {
                        $data=jQuery.parseJSON(data);
                        if($data)
                        {
                            if(data.status)
                            {
                                alert('Row Deleted');
                            }

                        }}})}
</script>
<table style="width: 100%;">
    <tr style="background-color:#B5BCBF;padding:10px;">
        <th>Product Name</th>
        <th>Category Name</th>
        <th>Offer For</th>
        <th>Product Amount</th>
        <th>Security Deposite</th>
        <th>Installment Mode</th>
        <th>Amount/%</th>
        <th>Min Period<br><small>In Months</small></th>
        <th>Max Period<br><small>In Months</small></th>
        <th>Visit Per<br><small>In Months</small></th>
        <th>Status</th>
        <th>Date Time</th>
		<th>City List</th>
        <th>Action</th>
    </tr>
    {$data}
    {if isset($customer)}
        {foreach from=$products key=stores item=data}
            <tr>
                <td>{$data['name']}</td>
                <td>{$data['category_name']}</td>
                <td>{if $data['offer_for']==0}{l s='Indivisual'}{/if}{if $data['offer_for']==1}{l s='Company'}{/if}{if $data['offer_for']==2}{l s='Both'}{/if}</td>
                <td>{$data['product_value']}</td>
                <td>{$data['security_value']}</td>
                <td>{if $data['installment_mode']==0}%{/if}{if $data['installment_mode']==1}Amount{/if}</td>
                <td>{$data['installment_amount']}</td>
                <td>{$data['min_period']}</td>
                <td>{$data['max_period']}</td>
                <td>{$data['visit_per_month']} </td>
                <td>{if $data['status']==0}Inactive{/if}
                    {if $data['status']==1}Active{/if}
                    </td>
                <td>{$data['creation_date']}</td>
				<td><a href="{$url}&ProductId={$data['id_product']}&tab_name=viewCity">Available City</td></td>>
                <td>
                    <form id="roleForm" action="{$url}" method="post" onsubmit="deleteRow({$data['rowId']});">
                        
                        <input type="submit" value="Delete">
                    </form>
                   <a href="{$url}&tab_name=edit&edit_id={$data['id_product']}"><input type="button" value="Edit"></a>
                </td>
            </tr>
        {/foreach}
    {/if}
</table>