<ul class="links">
<li class="first" ><a href="{$link->getPageLink('my-account', true)}" title="{l s='my-account' mod='psmodheadertoplinks'}">{l s='My Account' mod='psmodheadertoplinks'}</a></li>
<li ><a href="{$base_dir_ssl}modules/blockwishlist/mywishlist.php" title="My Wishlist" >{l s='My Wishlist' mod='psmodheadertoplinks'}</a></li>

<li ><a href="{$link->getPageLink($order_process, true)}" 
        title="{l s='Your Shopping Cart' mod='psmodheadertoplinks'}" class="top-link-checkout">{l s='Checkout' mod='psmodheadertoplinks'}</a></li>
{if $logged}
    <li class=" last" ><a href="{$link->getPageLink('index', true, NULL, "mylogout")}" title="{l s='Log me out' mod='psmodheadertoplinks'}">{l s='Log out' mod='psmodheadertoplinks'}</a></li>
{else}
    <li class=" last" ><a href="{$link->getPageLink('my-account', true)}" title="{l s='Log In' mod='psmodheadertoplinks'}" >
            {l s='Log In' mod='psmodheadertoplinks'}</a></li>
       {/if}
</ul>
</div>
 