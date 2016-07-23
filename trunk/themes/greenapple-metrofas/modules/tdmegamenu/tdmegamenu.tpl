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
                <span class="brand">{l s='Menu' mod='tdmegamenu'}</span>           
                <ul id="ma-mobilemenu" class="mobilemenu nav-collapse collapse">
                    <li>
                        <a href="{$base_uri}">{l s='Home' mod='tdmegamenu'}</a>
                    </li>
                    {if $tdMENU != ''} 
                       {$tdMENU} 
                    {/if} 
                </ul>


            </div>
        </div>
    </div>
</div>	

<div class="ma-nav-container visible-desktop">
    <div class="container-fluid">
         <div class="contain-size">
        <div id="megamenu_wrapper" class="default ma-nav-inner">
           {if $tdMENU != ''} 
    <ul id="nav" class="mega-menu menu wine_menu" >
      {$tdMENU} 
    </ul>
{/if}
           </div>
        </div>
    </div>
</div>

<!-- Menu -->


    {*<script type="text/javascript">*}
   {*$('#nav').dcMegaMenu({*}
        {*rowItems: '{if $themesdev.td_mrowitem!=''}{$themesdev.td_mrowitem}{else}5{/if}',*}
        {*speed: '{if $themesdev.td_mspeed!=''}{$themesdev.td_mspeed}{else}first{/if}'*}
    {*});*}
{*</script>*}

<script type="text/javascript">
$('#nav').dcMegaMenu({
rowItems: '5',
speed: 'first'
});
</script>


    
    


             	
