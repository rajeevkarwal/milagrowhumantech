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
	.small-gap{
		padding-top:10px;
		padding-bottom:10px;
	}
	.mybutton{
		    width: 100px !important;
   			 background-color: #ffa930 !important;
   		 	height: 30px;
    		color: white;
    		border:none;
		
	}
	.heading{
		font-weight:600;
	}
	.content{
		color:black;
		font-weight:1000;
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
{if isset($customer)}
		<div class="">
			<div class="small-gap"></div>
				<p>
					This is the data you have filled. Please double check and proceed to pay or go back to edit the details.
				</p><br>
				<div class="small-gap"></div>
				
				<div class="row-fluid">
					<div class="span3">
						<span class="heading">Customer Name</span>
					</div>
					<div class="span9">
						<span class="content">{$customer['name']}</span>
					</div>
				
				</div>
				<div class="row-fluid">
					<div class="span3">
						<span class="heading">Customer Email</span>
					</div>
					<div class="span9">
						<span class="content">{$customer['email']}</span>
					</div>
				
				</div>
				<div class="row-fluid">
					<div class="span3">
						<span class="heading">Date Of Birth</span>
					</div>
					<div class="span3">
						<span class="content">{$customer['date_of_birth']}{$customer['year_of_establishment']}</span>
					</div>
					<div class="span3">
						<span class="heading">Contact Number</span>
					</div>
					<div class="span3">
						<span class="content">{$customer['contact_number']}</span>
					</div>
				
				</div>
				<div class="row-fluid">
					<div class="span3">
						<span class="heading">Customer Address</span>
					</div>
					<div class="span9">
						<span class="content">{$customer['address']}&nbsp;,{$customer['state']}&nbsp;{$customer['city']}</span>
					</div>
				
				</div>
				<div class="row-fluid">
					<div class="span3">
						<span class="heading">Product Category</span>
					</div>
					<div class="span3">
						<span class="content">{$categoryName}</span>
					</div>
					<div class="span3">
						<span class="heading">Product Name</span>
					</div>
					<div class="span3">
						<span class="content">{$productName}</span>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span3">
						<span class="heading">Rental Duration(in Months)</span>
					</div>
					
					<div class="span3">
						<span class="content">{$customer['payment_duration']}&nbsp;Months</span>
					</div>
			</div>
			<div class="row-fluid">
					<div class="span3">
						<span class="heading">Monthly Installment</span>
					</div>
					<div class="span1"></div>
					<div class="span3" style="text-align:right">
						<span class="content" >{displayPrice currency=1 price=$customer['monthly_rental']}</span>
					</div>
					
				</div>
				<div class="row-fluid">
					
					<div class="span3">
						<span class="heading">Security Deposit</span>
					</div>
					<div class="span1"></div>
					<div class="span3" style="text-align:right">
						<span class="content">{displayPrice currency=1 price=$customer['security_deposited']}</span>
					</div>
					
				</div>
				<div class="row-fluid">
					<div class="span4"><label class="heading">Total Amount(Security Deposit+1st Rental Payment)</label>				
					</div>
					
					<div class="span3" style="text-align:right">
							{displayPrice currency=1 price=$total}
					</div>
					
				</div>
				<div class="row-fluid">
					<div class="span12">
						<center>
							
                       		<a href="payNow" class="mybutton"><input class="mybutton" type="submit" value="Pay Now"/></a>
						</form>
						<form action="" method="post">
							<input type="hidden" value="1" name="cheque">
							<input class="mybutton" type="submit" value="Pay By Cheque"/>
						</form>
						</center>
					</div>
				
				</div>
			
	
	</div>
{/if}
</div>
</div>
</div>
</div>

