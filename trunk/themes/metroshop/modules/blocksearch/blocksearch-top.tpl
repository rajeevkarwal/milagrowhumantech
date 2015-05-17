{*
* 2007-2013 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2013 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<!-- Block search module -->
</div>
</div>
</div>
</div>
</div>
</div>



<div class="search-bar">
<div id="phone">
     {$dedalx.metro_support_number|html_entity_decode}
</div>

<form id="search_mini_form" action="{$link->getPageLink('search')}" method="get">
       <div class="search">
        <div class="search-input form-search">
        <input type="hidden" name="controller" value="search" />
        <input type="hidden" name="orderby" value="position" />
        <input type="hidden" name="orderway" value="desc" />
        <input class="search_query input-text" type="text" id="search_query_top" name="search_query" value="{if isset($smarty.get.search_query)}{$smarty.get.search_query|htmlentities:$ENT_QUOTES:'utf-8'|stripslashes}{/if}" placeholder="{l s='Search Entire Store Here' mod='blocksearch'}" />
        </div>
        <button type="submit" class="button-search" name="submit_search"  ></button>
        <button class="button" title="{l s='Go' mod='blocksearch'}" type="submit" style="display:none;">
            <span><span>{l s='Go' mod='blocksearch'}</span></span>
        </button>
        <div id="search_autocomplete" class="search-autocomplete" style="display:none;"></div>
    </div>
</form>  
</div>

       <script>
           jQuery('document').ready( function($) {
            $("#search_query_top").autocomplete(
            '{if $search_ssl == 1}{$link->getPageLink('search', true)}{else}{$link->getPageLink('search')}{/if}', {
            minChars: 3,
            max:7,
            width: 500,
            selectFirst: false,
            scroll: false,
            dataType: "json",
            formatItem: function(data, i, max, value, term) {
            return value;
        },
        parse: function(data) {
        var mytab = new Array();
        for (var i = 0; i < data.length; i++)
            if(i==6){
        data[i].pname = 'nolink';
						
        data[i].product_link = $('#search_autocomplete').val();
        //mytab[mytab.length] = { data: data[i], value:  '<div id="scc_more_view"> '+ $("#more_view").html()+' </div>'};
}
else
                                                           
mytab[mytab.length] = { data: data[i], value:  ' <span class="search_title">'  + data[i].pname + ' </span> '};
return mytab;
},
extraParams: {
ajaxSearch: 1,
id_lang: 1
}
}
)
.result(function(event, data, formatted) {
if(data.pname!='nolink'){
$('#search_autocomplete').val(data.pname);
document.location.href = data.product_link;
}
else{
$('#search_autocomplete').val(data.product_link);
	
$("#searchbox").submit();
}
				
})
}); 
                
          
            </script> 
   
</div>


        <!-- /Block search module -->
