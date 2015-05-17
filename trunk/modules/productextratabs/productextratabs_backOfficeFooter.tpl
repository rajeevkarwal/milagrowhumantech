<div id="step1" style="max-height: 1000px; overflow: auto;">

    <h4>{l s='Tabs' mod='productextratabs'}</h4>

    <style type="text/css">
        {literal}
            .tab_content_container {
                display: none;
            }
            .td_header label{width: auto; padding:0; margin: 10px 0;}
            .td_header input.chk_checkbox{margin: 10px;}
            .valign_top {vertical-align: top;}
            .td_footer {
                padding-top: 10px;
                text-align: center;
                width: 100%;
            }
            .td_footer .button {
                cursor: pointer;
            }
        {/literal}        
    </style>

    <script type="text/javascript">
        
        {literal}
                
        function toogleShowContentTab(id_tab) {
            if ($('#chk_update_tab_content_' + id_tab).is(':checked')) {
                $('#tab_content_container_' + id_tab).show();
            }
            else {
                $('#tab_content_container_' + id_tab).hide();
            }
        }
           
        
        $(function(){

            $("#btn_update").click(function(){
                onUpdate();
            });

        });
           
        {/literal}
        
    </script>    

    <div class="hint" style="display: block">{l s='The selected tabs will be saved, otherwise will be deleted.' mod='productextratabs'}</div>

    <div id="div_loading_tab"></div>
    
    <input type='hidden' id='id_product' name='product' value="{$id_product}"/>

    <table>
        {foreach from=$tabs item="tab" name="f_tabs"}        
            <tr>
                <td class="td_header">
                    <input type='hidden' id='id_tabs[]' name='id_tabs[]' class="hdn_id_tab" value="{$tab.id_tab}"/>
                    <input type="checkbox" class="chk_checkbox" id="chk_update_tab_content_{$tab.id_tab}" 
                           name="update_tab_content_{$tab.id_tab}" 
                           onchange="toogleShowContentTab({$tab.id_tab})"
                    {if $tab.own} checked="true" {/if}/>
                {if $tab.own}
                    <script>
                        toogleShowContentTab({$tab.id_tab});
                    </script>
                {/if}
                <label for="chk_update_tab_content_{$tab.id_tab}"><b>{$tab.name}</b></label>
            </td>
        </tr>
        <tr id="tab_content_container_{$tab.id_tab}" {if !$tab.own} class="tab_content_container" {/if}>
            <td>

                {foreach from=$languages item="language" name="f_languages"}  
                    <input type='hidden' id='id_lang_{$tab.id_tab}[]' name='id_lang_{$tab.id_tab}[]' class="hdn_id_lang_{$tab.id_tab}" value="{$language.id_lang}"/>
                    <div id="ctab_content_{$tab.id_tab}_{$language.id_lang}" style="display: {if $language.id_lang == $default_language}block{else}none{/if}; float: left;">
                        <textarea class="rte autoload_rte" cols="30" rows="30" id="tab_content_{$tab.id_tab}_{$language.id_lang}" name="tab_content_{$tab.id_tab}_{$language.id_lang}">{$tab.content[$language.id_lang]}</textarea>
                    </div>                            
                {/foreach} 

            </td>
            <td class="valign_top">
                {$tab.flags_content}
            </td>
        </tr>
    {/foreach}

    <tr>
        <td colspan="2" class="td_footer">
            <span class="button" id="btn_update">{l s='Update' mod='productextratabs'}</span>
        </td>
    </tr>

</table>

</div>