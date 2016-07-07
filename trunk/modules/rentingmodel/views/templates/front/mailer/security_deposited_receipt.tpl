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
<div style="line-height: 10px"></div>
<div style="font-size: 8pt; color: #444;">
    <!-- ADDRESSES -->
    <table style="width: 100%" cellpadding="1">
        <tr>

            <td style="width:40%;text-align: left;border-left: 1px solid #333;border-top: 1px solid #333;">&nbsp;&nbsp;Milagrow
                Business
                & Knowledge Solutions (P) Ltd.
            </td>
            <td rowspan="6"
                style="width:35%;text-align: left;border-left:1px solid #333;border-top: 1px solid #333;border-bottom: 1px solid #333;">
                <span style="font-weight: bold; font-size: 7pt; color: black">{l s='Customer Details' pdf='true'}</span><br/>
                {$demoAddress}
            </td>
            <td rowspan="3" align="center" valign="middle"
                style="width:25%;border-left:1px solid #333;border-top: 1px solid #333;border-bottom: 1px solid #333;border-right:1px solid #333">
                <strong>File No.</strong><br>{$receiptNo|escape:'htmlall':'UTF-8'}</td>
        </tr>
        <tr>
            <td style="width:40%;text-align: left;border-left: 1px solid #333;">&nbsp;&nbsp;796,</td>
        </tr>
        <tr>
            <td style="width:40%;text-align: left;border-left: 1px solid #333;">&nbsp;&nbsp;Phase V,</td>
        </tr>
        <tr>
            <td style="width:40%;text-align: left;border-left: 1px solid #333;">&nbsp;&nbsp;Udyog Vihar</td>
            <td rowspan="3"
                style="width:25%;text-align:center;margin-top:50%;border-left:1px solid #333;border-top: 1px solid #333;border-right: 1px solid #333;border-bottom: 1px solid #333;">
                <strong>Date</strong><br>
                {$demoDate|date_format:"%d-%m-%Y"}
            </td>
        </tr>
        <tr>

            <td style="width:40%;text-align: left;border-left: 1px solid #333;">&nbsp;&nbsp;Gurgaon</td>

        </tr>
        <tr>

            <td style="width:40%;text-align: left;border-left: 1px solid #333;border-bottom: 1px solid #333;">&nbsp;&nbsp;Email:
                receivables@milagrow.in
            </td>
        </tr>

    </table>
    <!-- / ADDRESSES -->

    <div style="line-height: 1pt">&nbsp;</div>

    <!-- PRODUCTS TAB -->
    <table style="width: 100%" border="0.7" cellpadding="1">
        <tr>
            <td style="width: 100%;">
                <table style="width: 100%; font-size: 8pt;">
                    <tr style="line-height:4px;">
                        <td style="text-align: left; background-color: #4D4D4D; color: #FFF;font-weight: bold; width: 50%">{l s='Item' pdf='true'}</td>

                        <td style="background-color: #4D4D4D; color: #FFF; text-align: right; font-weight: bold; width: 12%">
                            </td>

                        <td style="background-color: #4D4D4D; color: #FFF; text-align: center; font-weight: bold; width: 10%"></td>
                        <td style="background-color: #4D4D4D; color: #FFF; text-align: right; font-weight: bold; width: 12%">
                           

                        </td>
                        <td style="background-color: #4D4D4D; color: #FFF; text-align: right; font-weight: bold; width: 16%">
                            {l s='Total' pdf='true'}
                            {l s='(Tax Incl.)' pdf='true'}

                        </td>
                    </tr>
                    <!-- PRODUCTS -->


                    <tr style="line-height:6px;background-color:#DDD;">
                        <td style="text-align: left; width: 50%">Security Deposit Against {$product}</td>
                        <td style="text-align: right; width: 12%">
                           
                        </td>

                        <td style="text-align: right; width: 10%">
                           
                        </td>
                        <td style="text-align: right; width: 12%">
                            
                        </td>
                        <td style="text-align: right;  width:16%">
                            {displayPrice currency=1 price=$securityDeposited}
                        </td>
                    </tr>
                    
                   	<tr style="line-height:35px;">
                   		 <td style="text-align: left; width: 50%">&nbsp;</td>
                        <td style="text-align: right; width: 12%">&nbsp;
                        </td>

                        <td style="text-align: right; width: 10%">
                           &nbsp;
                        </td>
                        <td style="text-align: right; width: 12%">
                          &nbsp;  
                        </td>
                        <td style="text-align: right;  width:16%">
                          &nbsp;
                        </td>
                   	</tr>
                    <tr style="line-height:5px;">
                    	 <td style="text-align: left; width: 50%">&nbsp;</td>
                        <td style="text-align: right; width: 12%">&nbsp;
                        </td>

                        <td style="text-align: right; width: 10%">
                           &nbsp;
                        </td>
                        <td style="text-align: right; width: 12%;font-weight:bold">
                          &nbsp; {l s='Total' pdf='true'} 
                        </td>
                        <td style="text-align: right;  width:16%">
                          &nbsp;{displayPrice currency=1 price=$securityDeposited}
                        </td>
                       
                    </tr>
                    <tr>
                    	<th style="text-align:left;" colspan="2">
                    	 	Security deposit will be returned as per the terms and conditions of the rental agreement.
                    	</th>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
	<table style="width: 100%">
        <tr>
             <td align="center"><b>In  case you have opted for payment by cheque, this acknowledgement will be valid only when company realizes the money.<br>
                    	 The agreement will be active from the date of installation of the product.</b></td>
        </tr>
    </table>
    <!-- / PRODUCTS TAB -->

    <div style="line-height: 1pt">&nbsp;</div>
    <table style="width: 100%">
        <tr>
            <td style="text-align: right; font-weight: bold">&nbsp;Received with thanks <br> Accounts Department,
                Milagrow
            </td>
        </tr>
    </table>

</div>


