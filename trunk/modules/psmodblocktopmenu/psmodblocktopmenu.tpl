</div>
</div>
</div>

</div>
<div class="clear"></div>   

</div>      
</div>
</div>
</div> 

<!-- /MODULE Block cart -->

<div class="container">
    <div class="mobile-menu-toggle" style="display: none;">Menu <img src="{$img_dir}toggle.png"></div>
    <div class="box mobile-menu" style="display: none;">
        <div class="box-content">
            <div class="box-category">
                <ul>
                <li>
                <a href="index.php">Home</a>
                </li>
                {if $MobileMENU !=''}
                    {$MobileMENU}  
                {/if} 
                </ul>
            </div>
        </div>
    </div>
    <div id="notification"></div>
</div> 

{if $MENU != ''} 
 <div id="menu" class="clearfix">
     <ul class="menu">
        <li>
            <a href="index.php"><img src="{$img_dir}home-icon.png"></a>
        </li>
         {$MENU}  
        <li class="li-custom-block">
           
                {$dedalx.perfec_header_menu_customhtml|html_entity_decode}
            
        </li>  
    </ul>
</div> 
{/if}




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
		
                    $('.box-category ul li div.menuclose').removeClass("menuclose").addClass("menuopen");
                    $(this).removeClass("menuopen").addClass("menuclose");
		
                    $('.box-category ul li a.active').removeClass("active");
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