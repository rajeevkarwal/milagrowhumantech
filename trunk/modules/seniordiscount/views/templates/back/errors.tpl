
{if isset($errors) && $errors}
    <div class="error" style="margin-top: 60px;">
        <p>{if $errors|@count > 1}{l s='There are %d errors' sprintf=$errors|@count}{else}{l s='There is %d error' sprintf=$errors|@count}{/if}</p>
        <ol>
            {foreach from=$errors key=k item=error}
                <li>{$error}</li>
            {/foreach}
        </ol>
    </div>
{/if}