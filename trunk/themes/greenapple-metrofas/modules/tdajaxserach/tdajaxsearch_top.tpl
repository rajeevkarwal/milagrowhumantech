</div></div></div><form id="search_mini_form" action="{$link->getPageLink('search')}" method="get">    <div class="form-search">        <div class="search-content">            <input type="hidden" name="controller" value="search" />            <input type="hidden" name="orderby" value="position" />            <input type="hidden" name="orderway" value="desc" />            <input class="search_query input-text" type="text" id="search_query_top" name="search_query" value="{if isset($smarty.get.search_query)}{$smarty.get.search_query|htmlentities:$ENT_QUOTES:'utf-8'|stripslashes}{/if}" placeholder="{l s='Search Products Here' mod='tdajaxserach'}" />            <button class="button"  name="submit_search"  title="{l s='Go' mod='tdajaxserach'}" type="submit">                <span><span>{l s='Search' mod='tdajaxserach'}</span></span>            </button>            <div id="search_autocomplete" class="search-autocomplete" style="display:none;"></div>        </div>    </div></form>{include file="$self/tdajaxserach_instant.tpl"}