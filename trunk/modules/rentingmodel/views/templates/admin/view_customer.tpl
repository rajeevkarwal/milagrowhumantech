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
        text-transform:Capitalize;
    }
</style>
<table style="width: 100%;">
    <tr style="background-color:#B5BCBF;padding:10px;">
        <th>Name</th>
        <th>DOB</th>
        <th>Email</th>
        <th>Number</th>
        <th>Address</th>
        <th>Product Name</th>
        <th>Product Category</th>
        <th>Amount<br><small>In Rs</small></th>
        <th>Security<br><small>In Rs</small></th>
        <th>Duration<br><small>in Months</small></th>
        <th>Installment</th>
        <th>Payment Mode</th>
        <th>Status</th>
        <th>Date Time</th>
        <th>Action</th>
    </tr>
    {if isset($customer)}
        {foreach from=$customer key=store item=data}
            <tr {if $data['status']==0} style="background-color:#D6D6D6";{/if}{if $data['status']==4}style="background-color:#98D298";{/if}{if $data['status']==2}style="background-color:#A5DAB1";{/if}
                {if $data['status']==8}style="background-color:#DCBABA";{/if}>
                <td><a href="{$url}&customerNumber={$data['rent_id']}&tab_name=full">{$data['name']}</a></td>
                <td>{$data['date_of_birth']}{$data['year_of_establishment']}</td>
                <td>{$data['email']}</td>
                <td>{$data['contact_number']}</td>
                <td>{$data['address']}</td>
                <td>{$data['productName']}</td>
                <td>{$data['categoryName']}</td>
                <td>{$data['product_price']}</td>
                <td>{$data['security_deposited']}</td>
                <td>{$data['payment_duration']}</td>
                <td>{$data['monthly_rental']}</td>
                <td>{if $data['payment_mode']==0}By Cheque{/if}
                {if $data['payment_mode']==1}By Credit Card{/if}
                </td>
                <td>
                	{if $data['status']==0}{l s='Peyment Pending'}{/if}
                    {if $data['status']==1}{l s='Payment Awaited/By Cheque'}{/if}
                	{if $data['status']==2}{l s='Awaiting Approval'}{/if}
                    {if $data['status']==3}{l s='Document Verified'}{/if}
                    {if $data['status']==4}{l s='Product Sent'}{/if}
                    {if $data['status']==5}{l s='Product Delivered'}{/if}
                    {if $data['status']==6}{l s='Loan Active'}{/if}
                    {if $data['status']==7}{l s='Loan Completed'}{/if}
                    {if $data['status']==8}{l s='Loan Settelled'}{/if}
                    {if $data['status']==9}{l s='Application Cancelled'}{/if}
                     {if $data['status']==10}Rejected{/if}
                </td>
                <td>{$data['applied_on']}</td>
                <td>
                <form name="DeleteAjax" method="post" action="{$url}" onsubmit="deleteExistingCustomer({$data['rent_id']});">
                		<input type="hidden" value="{$data['rent_id']}" id="customer_id" name="customer_id">
                		<input type="submit" value="Delete">
                </form>
             

            </tr>
        {/foreach}

    {/if}
<script>
	function deleteExistingCustomer(val)
	{
			
			if(confirm('Are You Sure Want To Delete'))
			{
				 $.ajax(
			                {
			                    type:'GET',
			                    url:'/modules/rentingmodel/library.php?CustomerId='+val,
			                    success:function(data)
			                    {
			                        $data=jQuery.parseJSON(data);
			                        if($data)
			                        {
			                            if(data.status)
			                            {
			                                window.alert('Row Deletes');
			                            }

			                        }
			                    }
			                }
			        )
			}
			
	}
</script>
</table>