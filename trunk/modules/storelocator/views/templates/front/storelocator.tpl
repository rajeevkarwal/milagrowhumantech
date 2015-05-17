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

    function updateStates(products, selectedproduct) {
        var option = '<option value="">Select State</option>';
        if (selectedproduct) {
            $.each(products[selectedproduct], function (i, el) {
                if (i)
                    option += '<option value="' + i + '">' + i + '</option>'
            });
            $('#state').removeAttr('disabled');
        }
        else {
            var disabledObj = new Object();
            disabledObj.disabled = 'disabled';
            $('#state').attr(disabledObj);

        }
        $('#state')
                .find('option')
                .remove()
                .end()
                .append(option);
        var disabledObj = new Object();
        disabledObj.disabled = 'disabled';
        $('#city').find('option').remove().end().append("<option value=''>Select City</option>").attr(disabledObj);

    }

    function updateCities(products, selectedProduct, selectedState) {
        var option = '<option value="">Select City</option>';
        if (selectedProduct && selectedState) {
            $.each(products[selectedProduct][selectedState], function (i, el) {
                if (el)
                    option += '<option value="' + el + '">' + el + '</option>'
            });
            $('#city').removeAttr('disabled');
        }
        else {
            var disabledObj = new Object();
            disabledObj.disabled = 'disabled';
            $('#city').attr(disabledObj);
        }
        $('#city')
                .find('option')
                .remove()
                .end()
                .append(option);
    }
    $(document).ready(function () {
        var products = {$products};
        console.log(products);
        var option = '<option value="">Select Product</option>';
        $.each(products, function (i, el) {
            option += '<option value="' + i + '">' + i + '</option>'
        });
        $('#product')
                .find('option')
                .remove()
                .end()
                .append(option);

        var disabledObj = new Object();
        disabledObj.disabled = 'disabled';
        $('#state').attr(disabledObj);
        $('#city').attr(disabledObj);
        $('#product').change(function () {
            var selectedProduct = $(this).val();
            updateStates(products, selectedProduct);
        });

        $('#state').change(function () {
            var selectedProduct = $('#product').val();
            var selectedState = $(this).val();
            updateCities(products, selectedProduct, selectedState);
        });

        {if isset($selectedProduct)&& !empty($selectedProduct)}
        $('#product').val('{$selectedProduct}');
        updateStates(products, '{$selectedProduct}');
        {/if}
        {if isset($selectedState) && !empty($selectedState)}
        $('#state').val('{$selectedState}');
        updateCities(products, '{$selectedProduct}', '{$selectedState}');
        {/if}
        {if isset($selectedCity) && !empty($selectedCity)}
        $('#city').val('{$selectedCity}');
        {/if}

        $('#previous-btn').click(function (e) {
            e.preventDefault();
            var product = $('#product').val();
            var state = $('#state').val();
            var city = $('#city').val();
            window.location.href = 'store-locator?product=' + product + '&state=' + state + '&city=' + city + '&page=' + {$previous};
        });

        $('#next-btn').click(function (e) {
            e.preventDefault();
            var product = $('#product').val();
            var state = $('#state').val();
            var city = $('#city').val();
            window.location.href = 'store-locator?product=' + product + '&state=' + state + '&city=' + city + '&page=' + {$next};
        });
    });
</script>
<style>
    #storeLocator-submit {
        padding-top: 15px;
    }

    a.nextButton, a.prevButton {
        overflow: visible;
        width: auto;
        border: 0;
        padding: 0;
        margin: 0;
        background: transparent;
        cursor: pointer;
        background: #ffa930;
        color: white;
        padding: 7px;
    }

    a.nextButton:hover, a.prevButton:hover {
        color: white !important;
    }

    .width-12 {
        width: 12%;
    }
</style>

{capture name=path}{l s='Store Locator'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}

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
                    <h1>{l s='Store Locator'}</h1>
                </div>
                <div class="row-fluid">
                    <form>

                        <div class="row-fluid">
                            <div class="span3">
                                <div class="control-group">
                                    <label for="product">{l s='Product*'}</label>

                                    <div class="controls">
                                        <select name="product" id="product">
                                            <option value=''>Select Product</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="span3">
                                <div class="control-group">
                                    <label for="state">{l s="State*"}</label>

                                    <div class="controls">
                                        <select name="state" id="state">
                                            <option value=''>Select State</option>
                                        </select>
                                    </div>
                                </div>


                            </div>
                            <div class="span3">
                                <div class="control-group">
                                    <label for="city">{l s="City*"}</label>

                                    <div class="controls">
                                        <select name="city" id="city">
                                            <option value=''>Select City</option>
                                        </select>
                                    </div>
                                </div>


                            </div>
                            <div class="span3">
                                <div class="control-group" id="storeLocator-submit">

                                    <div class="controls">
                                        <button type="submit" class="button">
                                            <span><span>Submit</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                {if isset($storeLocatorResults) && count($storeLocatorResults)>0}
                    <div class="row-fluid" style="margin-bottom: 20px;">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="width-12">Product</th>
                                <th class="width-12">State</th>
                                <th class="width-12">City</th>
                                <th class="width-12">Location</th>
                                <th class="width-12">Store Name</th>
                                <th class="width-12">Phone Number</th>
                                <th>Address</th>
                            </tr>
                            </thead>
                            <tbody>
                            {foreach from=$storeLocatorResults key=stores item=i}
                                <tr>
                                    <td class="width-12">{$i['product']}</td>
                                    <td class="width-12">{$i['state']}</td>
                                    <td class="width-12">{$i['city']}</td>
                                    <td class="width-12">{$i['location']}</td>
                                    <td class="width-12">{$i['store_name']}</td>
                                    <td class="width-12">{$i['landline']}</td>
                                    <td>{$i['address']}</td>
                                </tr>
                            {/foreach}
                            </tbody>
                        </table>
                        <div class="page">
                            {if $previous>0}
                                <a class="prevButton" id="previous-btn">Previous</a>
                            {/if}
                            {if $next>0}
                                <a class="nextButton" id="next-btn">Next</a>
                            {/if}
                        </div>
                    </div>
                {/if}

            </div>
        </div>
    </div>
</div>

