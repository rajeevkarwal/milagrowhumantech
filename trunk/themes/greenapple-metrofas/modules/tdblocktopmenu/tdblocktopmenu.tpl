</div>
</div>
<div class="ma-nav-mobile-container hidden-desktop">
    <div class="container">
        <div class="navbar">
            <div class="navbar-inner navbar-active" id="navbar-inner">
                <a class="btn btn-navbar" style="">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <span class="brand">{l s='Menu' mod='tdblocktopmenu'}</span>           
                <ul id="ma-mobilemenu" class="mobilemenu nav-collapse collapse">
                    <li>
                        <a href="{$base_uri}">{l s='Home' mod='tdblocktopmenu'}</a>
                    </li>
                    {if $MobileMENU !=''}
                        {$MobileMENU}  
                    {/if} 
                </ul>


            </div>
        </div>
    </div>
</div>	

<div class="ma-nav-container visible-desktop">
    <div class="container">
         <div class="contain-size">
        <div class="ma-nav-inner">
            {if $MENU != ''} 
                <ul id="nav" class="fish_menu">
                    <li class="home active">
                        <a href="{$base_uri}"><span>{l s='Home' mod='tdblocktopmenu'}</span></a>
                    </li>
                    {$MENU}  
                </ul>
            {/if}
           </div>
        </div>
    </div>
</div>

<!-- Menu -->




