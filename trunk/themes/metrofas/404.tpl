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


        <div class="main">
	   <div class="main-inner">
          
            <div class="col-main">
                <div class="account-login input-type-field">

                    <div class="page-title">
                        <h1>{l s='This page is not available'}</h1>
                    </div>


                    <div class="pagenotfound">

                        <p>
                            {l s='We\'re sorry, but the Web address you\'ve entered is no longer available.'}
                        </p>

                        <h3>{l s='To find a product, please type its name in the field below.'}</h3>
                        <form action="{$link->getPageLink('search')}" method="post" class="std">
                            <fieldset>
                                <p>
                                    <label for="search">{l s='Search our product catalog:'}</label>
                                    <input id="search_query" name="search_query" type="text" />
                                    <button type="submit" name="Submit"  class="button" ><span><span>{l s="OK"}</span></span></button>
                                </p>
                            </fieldset>
                        </form>

                        <p><a href="{$base_dir}" title="{l s='Home'}"><img src="{$img_dir}icon/home.gif" class="icon" alt="{l s='Home'}" /> {l s='Home'}</a></p>
                    </div>

                </div>
            </div>
        </div>
    </div>


<!-- END page --