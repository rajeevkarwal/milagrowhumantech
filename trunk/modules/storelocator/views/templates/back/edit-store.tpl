<fieldset style="margin-top: 80px;">
    <form action="{$url|escape:'htmlall':'UTF-8'}" method="post">

        <legend><img src="{$module_dir}img/icon-config.gif" alt=""/>{l s='Edit Store' mod='storelocator'}</legend>
        <label for="product">Select Product</label>

        <div class="margin-form">
            <select name="product" id="product" style="width:230px;">
                <option value=""
                        {if $selectedProduct eq ''}selected="selected" {/if}>{l s='-- Choose Product --'}</option>
                {foreach from=$products item=product}
                    {if $product.name eq 'Home'}
                        {continue}
                    {/if}
                    <option value="{$product.name}"
                            {if $selectedProduct eq $product.name}selected="selected" {/if}>{$product.name|escape:'htmlall':'UTF-8'}</option>
                {/foreach}
            </select>
            <sup>*</sup>
        </div>
        <label for="state">Select State</label>

        <div class="margin-form">
            <select name="state" id="state" style="width:230px;">
                <option value=""
                        {if $selectedState eq ''}selected="selected" {/if}>{l s='-- Choose State --'}</option>
                {foreach from=$states item=state}
                    <option value="{$state.name}"
                            {if $selectedState eq $state.name}selected="selected" {/if}>{$state.name|escape:'htmlall':'UTF-8'}</option>
                {/foreach}
            </select>
            <sup>*</sup>
        </div>
        <label for="city">Select City</label>

        <div class="margin-form">
            <input type="text" name="city" id="city" style="width:230px;"
                   {if !empty($selectedCity)}value="{$selectedCity}" {/if}> <sup>*</sup>
        </div>
        <label for="location">Location</label>

        <div class="margin-form">
            <input type="text" name="location" id="location" {if !empty($location)}value="{$location}" {/if}
                   style="width:230px;"> <sup>*</sup>
        </div>
        <label for="location">Store Name</label>

        <div class="margin-form">
            <input type="text" name="storeName" id="storeName" {if !empty($storeName)}value="{$storeName}" {/if}
                   style="width:230px;"> <sup>*</sup>
        </div>
        <label for="phoneNumber">Phone Number</label>

        <div class="margin-form">
            <input type="text" name="phoneNumber" id="phoneNumber" {if !empty($phoneNumber)}value="{$phoneNumber}" {/if}
                   style="width:230px;"> <sup>*</sup>
        </div>
        <label for="address">Address</label>

        <div class="margin-form">
            <textarea name="address" id="address" rows="10" cols="50">{if !empty($address)}{$address}{/if}</textarea>
            <sup>*</sup>
        </div>

        <label>&nbsp;</label>

        <div class="margin-form">
            <input type="hidden" value="{$id_store_locator}" name="id_store_locator"/>
            <input type="submit" name="editStore" value="Update"/>
        </div>
        <span class="small"><sup>*</sup> {l s='Required fields' mod='storelocator'}</span>

    </form>
</fieldset>