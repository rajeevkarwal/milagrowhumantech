<div class="header-container">
    <div class="header">
        <div id="header_mainmenu" class="clearfix">
            <a  href="{$base_dir}" title="{$shop_name|escape:'htmlall':'UTF-8'}" class="mm_logo"  style="background-image: url('{$logo_url}');">
            </a>
            <a href="{$base_dir}" class="mm_home">{l s='Home'  mod='psmodheadertoplinks'}</a>
            <a class="mm_wishlist" href="{$base_dir_ssl}modules/blockwishlist/mywishlist.php" title="{l s='My Wishlist' mod='psmodheadertoplinks'}"  id="wishlist-total">{l s='My Wishlist' mod='psmodheadertoplinks'}</a>
            <a class="mm_account" href="{$link->getPageLink('my-account', true)}" title="{l s='my-account' mod='psmodheadertoplinks'}">{l s='My Account' mod='psmodheadertoplinks'}</a>
            <a class="mm_checkout" href="{$link->getPageLink("$order_process.php", true)}{if $order_process == "order"}?step=1{/if}" 
               title="{l s='Your Shopping Cart' mod='psmodheadertoplinks'}" class="top-link-checkout">{l s='Checkout' mod='psmodheadertoplinks'}</a>
