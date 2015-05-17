       
  <div class="mini-sliders">
        {foreach from=$sccsliderdata item=slider}
            <a  href="{$slider.image_link}" {if ($slider.new_page==1)} target="_blank" {/if} >
                <img  class="fade-image" src="{$base_url}{$slider.image_url}" alt="{$slider.image_title}" />
            </a> 
         {/foreach}
</div>
<div class="clear">&nbsp;</div>
                           