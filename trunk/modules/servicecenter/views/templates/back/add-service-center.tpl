<fieldset style="margin-top: 80px;">
    <form action="{$url|escape:'htmlall':'UTF-8'}" method="post">

        <legend><img src="{$module_dir}img/icon-config.gif" alt=""/>{l s='Add New Service Center' mod='servicecenter'}
        </legend>

        <label for="ascName">ASC Name</label>

        <div class="margin-form">
            <input type="text" name="ascName" id="ascName" style="width:230px;" {if !empty($ascName)}value="{$ascName}" {/if}> <sup>*</sup>
        </div>
        <label for="contactPerson">Contact Person</label>

        <div class="margin-form">
            <input type="text" name="contactPerson" id="contactPerson" style="width:230px;" {if !empty($contactPerson)}value="{$contactPerson}" {/if}> <sup>*</sup>
        </div>
        <label for="contactNumber">Contact Number</label>

        <div class="margin-form">
            <input type="text" name="contactNumber" id="contactNumber" style="width:230px;" {if !empty($contactNumber)}value="{$contactNumber}" {/if}> <sup>*</sup>
        </div>
        <label for="mobileNumber">Mobile Number</label>

        <div class="margin-form">
            <input type="text" name="mobileNumber" id="mobileNumber" style="width:230px;" {if !empty($mobileNumber)}value="{$mobileNumber}" {/if}>
        </div>
        <label for="email">Email ID</label>
        <div class="margin-form">
            <input type="text" name="email" id="email" style="width:230px;" {if !empty($email)}value="{$email}" {/if}> <sup>*</sup>
        </div>
        <label for="state">Select State</label>

        <div class="margin-form">
            <select name="state" id="state" style="width:230px;">
                <option value=""
                        {if $selectedState eq ''}selected="selected" {/if}>{l s='-- Choose State --'}</option>
                {foreach from=$states item=state}
                    <option value="{$state.state}"
                            {if $selectedState eq $state.state}selected="selected" {/if}>{$state.state|escape:'htmlall':'UTF-8'}</option>
                {/foreach}
            </select>
            <sup>*</sup>
        </div>
        <label for="city">Select City</label>

        <div class="margin-form">
            <input type="text" name="city" id="city" style="width:230px;"
                   {if !empty($selectedCity)}value="{$selectedCity}" {/if}> <sup>*</sup>
        </div>
        <label for="pincode">Pin Code</label>

        <div class="margin-form">
            <input type="text" name="pincode" id="pincode" style="width:230px;" {if !empty($pincode)}value="{$pincode}" {/if}> <sup>*</sup>
        </div>
        <label for="aspAddress">ASP Address</label>

        <div class="margin-form">
            <textarea name="aspAddress" id="aspAddress" rows="10" cols="50">{if !empty($aspAddress)}{$aspAddress}{/if}</textarea> <sup>*</sup>
        </div>
        <label>&nbsp;</label>

        <div class="margin-form">
            <input type="submit" name="saveServiceCenter" value="Save"/>
        </div>
        <span class="small"><sup>*</sup> {l s='Required fields' mod='servicecenter'}</span>

    </form>
</fieldset>