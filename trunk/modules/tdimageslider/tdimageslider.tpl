{if $themesdev.td_slider_type=='content_slider'}

   <!-- start enable -->
                <div class="ma-banner7-container">		
                    <div class="flexslider">
                        <div class="ma-loading"></div>
                           
            {if $themesdev.td_slider_layout=='fixedwidth_slider'}
                <style>
                          .ma-banner7-container .flexslider{
     {if ($themesdev.td_product_bgimages=='enable') && ($themesdev.td_product_custombg)}
        background:url("{$themesdev.td_product_custombg}");
      {elseif ($themesdev.td_product_bgimages=='enable') && ($themesdev.td_product_bg_pattern)}
         background:url("{$themesdev.td_product_bg_pattern}");
      {else}
       background-color:{$themesdev.td_body_background};
      {/if}    
                          }
                    </style>
                        <div class="container">
         <div class="contain-size">
             {/if}
             
                        <ul class="slides">

                            {foreach from=$tdimageslider item=slider}
                        <li>
                            {if $slider.image_link!=''}
                                <a href="{$slider.image_link}" {if ($slider.new_page==1)} target="_blank" {/if} >
                                {/if}
                                <img  src="{$base_url}{$slider.image_url}" alt="{$slider.image_title}" />
                                {if $slider.image_link!=''}
                                </a>{/if}
                            </li>
                            {/foreach}
                        </ul>
                    {if $themesdev.td_slider_layout=='fixedwidth_slider'}
                            </div>
                        </div>
                    {/if}
                        <script type="text/javascript">
$jq(window).load(function(){
$jq('.ma-banner7-container .flexslider').flexslider({
animation: "fade",
slideshowSpeed: {if $themesdev.td_slideshowSpeed!=''}{$themesdev.td_slideshowSpeed}{else}300{/if},
animationSpeed: {if $themesdev.td_anumaSpeed!=''}{$themesdev.td_anumaSpeed}{else}600{/if},
directionNav: true,
start: function(slider){
$jq('.ma-loading').css("display","none");
}
});
});
                        </script>
                    </div>

                </div>
                <!-- end enable -->
        {/if}   
