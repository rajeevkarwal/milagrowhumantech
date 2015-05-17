<!-- /MODULE Block cart -->
 <div class="container">
   <div id="mobile-menu" class="mobile-menu-toggle">{l s='Menu' mod='psmodblocktopmenu'} <img src="{$img_dir}toggle.png"></div>
   <div class="box mobile-menu" style="display: none;">
       <div class="box-content">
           <div class="box-category left-categorys">
               <ul>
               <li>
               <a href="{$base_uri}">{l s='Home' mod='psmodblocktopmenu'}</a>
               </li>
{if $MobileMENU !=''}
    {$MobileMENU}  
{/if} 
</ul>
</div>
</div>
</div>
</div> 



<div class="nav-container">
    <div class="right-bg">
    {if $MENU != ''} 
    <ul id="nav">
    <li>
        <a href="{$base_uri}" class="level0 first homelink"><span>{l s='Home' mod='psmodblocktopmenu'}</span></a>
    </li>
     {$MENU}  
     
    <li class="level0 block_li parent">
       {$dedalx.metro_header_menu_customhtml|html_entity_decode}
    </li>
     <li class="level0 custommenuitem"><a href="{$link->getPageLink(contact, true)}" title="{l s='Contact us' mod='psmodblocktopmenu'}"><span>{l s='Contact us' mod='psmodblocktopmenu'}</span></a></li>

    </ul>
    {/if}
      
    </div>
</div> 



  
    
    
    
    




<!-- Menu -->


<script type="text/javascript">

    $(document).ready(function() {
      
    // Image animation
    $(".fade-image, .box-category .menuopen, .box-category .menuclose").live({
    mouseenter:
        function()
                    {
                        $(this).stop().fadeTo(300, 0.6);
                    },
                    mouseleave:
                        function()
                    {
                    $(this).stop().fadeTo(300, 1);
                }
            }
        );
      
            $(".box-category div.menuopen").live('click', function(event) {
	 
            event.preventDefault();
		
            $('.box-category a + ul').slideUp();
            $('+ a + ul', this).slideDown();
      
		
            $('.box-category li div.menuclose').removeClass("menuclose").addClass("menuopen");
            $(this).removeClass("menuopen").addClass("menuclose");
		
            $('.box-category li a.active').removeClass("active");
            $('+ a', this).addClass("active");
            
            
           
            
        });
       
        var mobilemenuOpened = false;
       
        $(".mobile-menu-toggle").live('click', function(event) {

        if(mobilemenuOpened == false)
                    {
            $(".mobile-menu").slideDown();
		  
        mobilemenuOpened = true;
    }
    else
                    {
        $(".mobile-menu").slideUp();
		  
    mobilemenuOpened = false;
}
});

   
});

</script>  