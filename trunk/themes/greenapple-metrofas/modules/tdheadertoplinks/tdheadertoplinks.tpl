</div>
</div>
<div class="span7">
    <p class="welcome-msg">{if $logged}
            {l s='Welcome' mod='tdheadertoplinks'}
            <a href="{$link->getPageLink('my-account', true)}">({$cookie->customer_lastname})</a>
        {else}
        {l s='Welcome visitor you can' mod='tdheadertoplinks'} <a href="{$link->getPageLink('my-account', true)}">{l s='login' mod='tdheadertoplinks'}</a> or <a href="{$link->getPageLink('my-account', true)}">{l s='create an account' mod='tdheadertoplinks'}</a>
        {/if} </p>
    <ul class="links">
        <li {*class="first" *}><a href="{$base_dir_ssl}customer-care"  title="{l s='Customer Care' mod='tdheadertoplinks'}">{l s='Customer Care' mod='tdheadertoplinks'}</a></li>
                    {*<li *}{*class="first" *}{*><a href="http://milagrow.letshelp.io/users/sign_in" target="_blank" title="{l s='contact-us' mod='tdheadertoplinks'}">{l s='Contact Us' mod='tdheadertoplinks'}</a></li>*}
                    <li ><a href="{$link->getPageLink('my-account', true)}" title="{l s='My Account' mod='tdheadertoplinks'}">{l s='My Account' mod='tdheadertoplinks'}</a></li>
                    <li ><a href="{$base_dir_ssl}index.php?fc=module&module=blockwishlist&controller=mywishlist" title="My Wishlist" >{l s='My Wishlist' mod='tdheadertoplinks'}</a></li>
    <li ><a href="{$base_dir_ssl}order-history" title="Track Order" >{l s='Track Order' mod='tdheadertoplinks'}</a></li>
                    {*<li > <a href="{$link->getPageLink('products-comparison')}" title="" class="compaate_button">{l s='Compare' mod='tdheadertoplinks'}</a></li>*}
                    {*<li > <a href="{$base_dir_ssl}index.php?fc=module&module=featurecategories&controller=compare&action=display" title="" class="compaate_button">{l s='Compare' mod='tdheadertoplinks'}</a></li>*}
                    <li ><a href="{$link->getPageLink($order_process, true)}"
                            title="{l s='Your Shopping Cart' mod='tdheadertoplinks'}" class="top-link-checkout">{l s='Checkout' mod='tdheadertoplinks'}</a></li>
                        {if $logged}
                        <li class=" last" ><a href="{$link->getPageLink('index', true, NULL, "mylogout")}" title="{l s='Log me out' mod='tdheadertoplinks'}">{l s='Log out' mod='tdheadertoplinks'}</a></li>
                    {else}
                        <li class=" last" ><a href="{$link->getPageLink('my-account', true)}" title="{l s='Log In' mod='tdheadertoplinks'}" >
                                {l s='Log In' mod='tdheadertoplinks'}</a></li>
                            {/if}
                </ul>
</div>
</div>
</div>
<div class="header-content">
    <div class="row-fluid">
        <div class="span4">
            <a class="logo" href="{$base_dir}" title="{$shop_name|escape:'htmlall':'UTF-8'}">
                <img src="{$logo_url}" alt="{$shop_name|escape:'htmlall':'UTF-8'}"/>
            </a>
        </div>

        <div class="span8">

            <div class="quick-access">
                <div class="top-cart-wrapper">

                    <div class="top-cart-contain">
                        <div class="block-cart">