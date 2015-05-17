
<div class="iosSlider"><!-- slider -->
    <div class="slider"><!-- slides -->
        {foreach from=$sccimageslider item=slider}
            <div class="slide">
                {if $slider.image_link!=''}
                    <a href="{$slider.image_link}" {if ($slider.new_page==1)} target="_blank" {/if} >
                    {/if}
                    <img class="royalImage" src="{$base_url}{$slider.image_url}" alt="{$slider.image_title}" />
                    {if $slider.image_link!=''}
                    </a>{/if}
                </div>
                {/foreach}
                </div>
                <div class="prev">&nbsp;</div>
                <div class="next">&nbsp;</div>
            </div>
