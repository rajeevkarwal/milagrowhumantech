{*
 * @author PresTeamShop.com
 * @copyright PresTeamShop.com - 2012
 *}
 
{foreach from=$tabs item='tab' name='f_tabs'}
    {if $tab.name_tab=='Advantages' || $tab.name_tab=='Videos'}
    <li class="hidden-phone hidden-tablet" {if $smarty.foreach.f_tabs.last}class="last_item"{/if}><a id="product_extra_tab_{$tab.id_tab}" href="#idTab{$tab.id_tab+20}">{$tab.name_tab}</a></li>
    {/if}
{/foreach}