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
            window.location.href = '{$url}&sl_tab=storelocatorlist&product=' + product + '&state=' + state + '&city=' + city + '&page=' + {$previous};
        });

        $('#next-btn').click(function (e) {
            e.preventDefault();
            var product = $('#product').val();
            var state = $('#state').val();
            var city = $('#city').val();
            window.location.href = '{$url}&sl_tab=storelocatorlist&product=' + product + '&state=' + state + '&city=' + city + '&page=' + {$next};
        });
    });
</script>
<style>
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

    .page{
        margin-top:15px;
    }

    .width-12 {
        width: 8%;
    }
</style>
<fieldset style="margin-top:80px;">
    <legend>Store Locators Overview</legend>
    {if isset($storeLocatorResults) && count($storeLocatorResults)>0}
        <form action="{$url}&sl_tab=storelocatorlist" method="post">

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
                        <label>&nbsp;</label>
                        <div class="controls">
                            <button type="submit" class="button">
                                <span><span>Submit</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </form>

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
                    <th>Actions</th>
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
                        <td>
                            <a style="text-decoration:underline; color:#0000FF;" href="{$url}'&sl_tab=edit_store&id_store_locator={$i['id_store_locator']}">Edit</a>
                           | <a onclick="return confirm('Are you sure?') ? true : false;" style="text-decoration:underline; color:#0000FF;" href="{$url}&sl_tab=delete_store&id_store_locator={$i['id_store_locator']}">Delete</a>
                        </td>
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
    {else}
        No Result Found
    {/if}
</fieldset>
