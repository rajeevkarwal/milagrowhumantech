{if $themesdev.td_slider_type=='product_slider'}
{if $products_slider}    
    <style>
      .ma-banner7-container .slides li{
     {if ($themesdev.td_product_bgimages=='enable') && ($themesdev.td_product_custombg)}
        background:url("{$themesdev.td_product_custombg}");
      {elseif ($themesdev.td_product_bgimages=='enable') && ($themesdev.td_product_bg_pattern)}
         background:url("{$themesdev.td_product_bg_pattern}");
      {else}
       background-color:{$themesdev.td_body_background};
      {/if} 
      
    transition: background-color 1000ms linear 0s;

    }
    
    
    .ma-banner7-container .slides li .productdetail h1 a{
          color:{$themesdev.td_product_title_color};
        display: block;
        margin-top: 20px;
        text-transform: uppercase;
     }
     .ma-banner7-container .slides li .productdetail p{
          color:{$themesdev.td_product_slitextcolor};
     }
  .flexslider .productdetail  .price-top{
    display: block;
    font-size: x-large;
    margin-bottom: 20px;
    color:{$themesdev.td_pricecolor} !important;
   }
     
    .flexslider .productdetail {
    padding: 20px;
}
.productslide a.btn-large {
    margin-left: 162px;
}
  {if $themesdev.td_slider_layout!='fixedwidth_slider'}  
.flexslider .productimg {
    float: right!important;
    padding: 20px 20px 20px 0!important;
    text-align: right!important;
}
 {/if}
    </style>
    

    <div class="ma-banner7-container">		
                    <div class="flexslider">
                        <div class="ma-loading"></div>
                         {if $themesdev.td_slider_layout=='fixedwidth_slider'}
                                       <style>
                                           .flexslider .productimg {
    padding: 20px 20px 20px 0!important;
    text-align: right!important;
}
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

                             {foreach from=$products_slider item=productslider name=products_slider}
                        <li>
                               <div class="container-fluid">
			      	<div class="row-fluid">
			      		<div class="span4 visible-desktop">
			      			<div class="productimg">
			      				<a class="product_image" title="{$productslider.name|escape:html:'UTF-8'}" href="{$productslider.link}"><img src="{$link->getImageLink($productslider.link_rewrite, $productslider.id_image, 'home_default')}" alt="{$productslider.name|escape:html:'UTF-8'}<"></a>
			      			</div>
                                                
			      		</div>
                                        
			      		<div class="span8">
                                             <a class="product_image" style="display:none" title="{$productslider.name|escape:html:'UTF-8'}" href="{$productslider.link}"><img src="{$link->getImageLink($productslider.link_rewrite, $productslider.id_image, 'home_default')}" alt="{$productslider.name|escape:html:'UTF-8'}<"></a>
			      			<div class="productdetail">
			      				<h1><a href="{$productslider.link}">{$productslider.name|truncate:60:'...'}</a></h1>
				      			<p>{$productslider.description_short|strip_tags:'UTF-8'|truncate:300:'...'}</p>
                                                            <div class="price-top">  
                                                        <span class="old_price">
                                                            {if ($slider_type=='special_products')}
                                                                {if !$priceDisplay}{displayWtPrice p=$productslider.price_without_reduction}{else}{displayWtPrice p=$priceWithoutReduction_tax_excl}{/if}
                                                            {/if}
                                                        </span>
                                                         {if isset($productslider.show_price) && $productslider.show_price && !isset($restricted_country_mode)}<span class="pro_price">{if !$priceDisplay}{convertPrice price=$productslider.price}{else}{convertPrice price=$productslider.price_tax_exc}{/if}</span>{/if}
                                                        
                                                            </div>
                                                         
                                                         {if ($productslider.quantity > 0 OR $productslider.allow_oosp)}  
                                                             <button class="exclusive ajax_add_to_cart_button button btn-cart productsliderbutton" rel="ajax_id_product_{$productslider.id_product}" onclik="{$link->getPageLink('cart',false, NULL, "add&amp;id_product={$productslider.id_product|intval}&amp;token={$static_token}", false)}" title="{l s='ADD TO CART' mod='tdproductsslider'}"><span><span>{l s='ADD TO CART' mod='tdproductsslider'}</span></span></button>

                                                        {/if}
			      			</div>
			      		</div>
			      	</div>
			      </div>
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
directionNav: false,
start: function(slider){
$jq('.ma-loading').css("display","none");
}
});
});
        </script>
                    </div>

                </div>   
    

       {/if} 
{/if}

