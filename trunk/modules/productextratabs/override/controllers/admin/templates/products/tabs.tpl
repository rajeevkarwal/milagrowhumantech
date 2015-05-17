<div id="step1" style="max-height: 1000px; overflow: auto;">    
    <h4>{l s='Tabs' mod='productextratabs'}</h4>

    <style type="text/css">
        {literal}
        .tab_content_container {
            display: none;
        }
        #product-tab-content-Tabs label{width: auto; padding:0; margin: 10px 0;}
        #product-tab-content-Tabs input.checkbox{margin: 10px;}                
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
        {/literal}
        
        {literal}        
            tabs_manager.onLoad('Tabs', function(){
                {/literal}
                displayFlags({$languages_flag}, {$default_form_language}, {$allowEmployeeFormLang})
                {literal}
              });
        {/literal}
        
    </script>    
	<div class="hint" style="display: block">{l s='The selected tabs will be saved, otherwise will be deleted.' mod='productextratabs'}</div>
    
    <table>
    {foreach from=$tabs item="tab" name="f_tabs"}        
            <tr>
                <td>
                    <input type='hidden' id='id_tabs[]' name='id_tabs[]' value="{$tab.id_tab}"/>
                    <input type="checkbox" class="checkbox" id="chk_update_tab_content_{$tab.id_tab}" 
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
                    <br />
                        
                        <div class="translatable">
    
                        {foreach from=$languages item=language}
                            <div class="lang_{$language.id_lang}" style="{if !$language.is_default}display:none;{/if}float: left;">
                                    <textarea cols="100" rows="10" type="text" id="tab_content_{$tab.id_tab}_{$language.id_lang}" 
                                            name="tab_content_{$tab.id_tab}_{$language.id_lang}" 
                                            class="autoload_rte_tabs" >{if isset($tab.content[$language.id_lang])}{$tab.content[$language.id_lang]|htmlentitiesUTF8}{/if}</textarea>
                                    <span class="counter" max="{if isset($max)}{$max}{else}none{/if}"></span>
                                    <span class="hint" name="help_box">{$hint|default:''}<span class="hint-pointer">&nbsp;</span></span>
                            </div>
                        {/foreach}
                        </div>
                        <script type="text/javascript">
                                var iso = '{$iso_tiny_mce}';
                                var pathCSS = '{$smarty.const._THEME_CSS_DIR_}';
                                var ad = '{$ad}';
                        </script>
                        
                        
                    <p class="clear"></p>
                </td>
            </tr>                
    {/foreach}
    </table>    
    <script>
        {literal}
            tinySetup({
                editor_selector :"autoload_rte_tabs",
                theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
                theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,,|,forecolor,backcolor",
                theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,media,|,ltr,rtl,|,fullscreen",
                theme_advanced_buttons4 : "styleprops,|,cite,abbr,acronym,del,ins,attribs,pagebreak",
                setup : function(ed) {
                    ed.onInit.add(function(ed)
                    {
                        if (typeof ProductMultishop.load_tinymce[ed.id] != 'undefined')
                        {
                            if (typeof ProductMultishop.load_tinymce[ed.id]) {
                                ed.hide();
                            }
                            else {
                                ed.show();
                            }
                        }
                    });                     
                }
            });
        {/literal}
    </script>
</div>