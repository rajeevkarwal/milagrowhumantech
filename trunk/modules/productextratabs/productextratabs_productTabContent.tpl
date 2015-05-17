{*
 * @author PresTeamShop.com
 * @copyright PresTeamShop.com - 2012
 *}
 
{foreach from=$tabs item='tab' name='f_tabs'}
    <div id="idTab{$tab.id_tab+20}" class="rte">
        {$tab.content}
    </div>
{/foreach}