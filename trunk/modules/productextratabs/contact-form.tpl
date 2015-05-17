<link type="text/css" rel="stylesheet" href="{$css_dir}contact-form.css"/>

<div id="contact">
    <p class="bold">{l s='Do you have questions or want more information about this product? Leave your message and we will contact you soon.' mod='productextratabs'}</p>
    
    <form action="{$actionUrl|escape:'htmlall':'UTF-8'}" method="post" class="std" enctype="multipart/form-data">
        <fieldset>
            <h3>{l s='send a message' mod='productextratabs'}</h3>
            <p class="select">
                <label for="id_contact">{l s='Subject Heading' mod='productextratabs'}</label>
                {if isset($customerThread.id_contact)}
                    {foreach from=$contacts item=contact}
                        {if $contact.id_contact == $customerThread.id_contact}
                            <input type="text" id="contact_name" name="contact_name" value="{$contact.name|escape:'htmlall':'UTF-8'}" readonly="readonly" />
                            <input type="hidden" name="id_contact" value="{$contact.id_contact}" />
                        {/if}
                    {/foreach}
                </p>
            {else}
                <select id="id_contact" name="id_contact" onchange="showElemFromSelect('id_contact', 'desc_contact')">
                    <option value="0">{l s='-- Choose --' mod='productextratabs'}</option>
                    {foreach from=$contacts item=contact}
                        <option value="{$contact.id_contact|intval}" {if isset($smarty.post.id_contact) && $smarty.post.id_contact == $contact.id_contact}selected="selected"{/if}>{$contact.name|escape:'htmlall':'UTF-8'}</option>
                    {/foreach}
                </select>
                <br />
                {foreach from=$contacts item=contact}
                    <p id="desc_contact{$contact.id_contact|intval}" class="desc_contact" style="display:none; text-align: center;">
                        {$contact.description|escape:'htmlall':'UTF-8'}
                    </p>
                {/foreach}
                <script>
                    showElemFromSelect('id_contact', 'desc_contact');
                </script>
            {/if}
            <p class="text">
                <label for="email">{l s='Email address' mod='productextratabs'}</label>
                <input type="text" id="email" name="from" value="{$email|escape:'htmlall':'UTF-8'}" />
            </p>
            <input type="hidden" name="id_product" value="{$id_product}" />
            {if $fileupload == 1}
                <p class="text">
                    <label for="fileUpload">{l s='Attach File' mod='productextratabs'}</label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
                    <input type="file" name="fileUpload" id="fileUpload" />
                </p>
            {/if}
            <p class="textarea">
                <label for="message">{l s='Message' mod='productextratabs'}</label>
                <textarea id="message" name="message" rows="15" cols="40">{if isset($message)}{$message|escape:'htmlall':'UTF-8'|stripslashes}{/if}</textarea>
            </p>
            <p class="submit">
                <input type="submit" name="submitMessage" id="submitMessage" value="{l s='Send' mod='productextratabs'}" class="button_large" onclick="$(this).hide();" />
            </p>
        </fieldset>
    </form>
</div>