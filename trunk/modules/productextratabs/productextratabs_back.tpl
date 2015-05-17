{*
* @author PresTeamShop.com
* @copyright PresTeamShop.com - 2013
*}

<script type="text/javascript">
    var productextratabs_dir = '{$paramsBack.PRODUCTEXTRATABS_DIR}';
    var productextratabs_img = '{$paramsBack.PRODUCTEXTRATABS_IMG}';
    var id_language = Number({$paramsBack.DEFAULT_LENGUAGE});
    var GLOBALS = {$paramsBack.GLOBALS};
    
    var languages = new Array();
        {foreach from=$paramsBack.LANGUAGES item=language name=f_languages}
        languages.push({$language.id_lang});
    {/foreach}
    
    {if isset($TYNY_15) && $TYNY_15}
        {literal}
        $(function(){
            tinySetup({
                editor_selector :"autoload_rte"
            }); 
        });
        {/literal}
    {/if}
    
    {if isset($TINY_ISO_LANG)}
        var iso = '{$TINY_ISO_LANG}';
        var pathCSS = '{$TINY_PATH_CSS}';
        var ad = '{$TINY_AD}';               
    {else}
        {literal}
        function tinyMCEInit(element)
		{
			$().ready(function() {
				$(element).tinymce({
        {/literal}
            // General options
            theme : "advanced",
            plugins : "safari,pagebreak,style,layer,table,advimage,advlink,inlinepopups,media,searchreplace,contextmenu,paste,directionality,fullscreen",
            // Theme options
            theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
            theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,,|,forecolor,backcolor",
            theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,media,|,ltr,rtl,|,fullscreen",
            theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,pagebreak",
            theme_advanced_toolbar_location : "top",
            theme_advanced_toolbar_align : "left",
            theme_advanced_statusbar_location : "bottom",
            theme_advanced_resizing : true,
            content_css : "{$TINY_CONTENT_CSS}",
            document_base_url : "{$TINY_DOC_BASE_URL}",
            template_external_list_url : "lists/template_list.js",
            external_link_list_url : "lists/link_list.js",
            external_image_list_url : "lists/image_list.js",
            media_external_list_url : "lists/media_list.js",
            elements : "nourlconvert",
            convert_urls : false,
            language : "{$TINY_LANG}",
            width : "600"
        {literal}
				});
			});                
		}
        tinyMCEInit("textarea.rte");
        {/literal}
    {/if}
</script>

{literal}
    <script type="text/javascript">
        var Messages = function(){
    {/literal}
            this.names_tab_empty = "{l s='You must enter a tab name at least one language.' mod='productextratabs'}";
            this.edit = "{l s='Edit' mod='productextratabs'}";
            this.remove = "{l s='Remove' mod='productextratabs'}";
            this.yes = "{l s='Yes' mod='productextratabs'}";
            this.no = "{l s='No' mod='productextratabs'}";
            this.all_products = "{l s='All products' mod='productextratabs'}";
            this.all_categories = "{l s='All categories' mod='productextratabs'}";
            this.choose_type = "{l s='Choose a type' mod='productextratabs'}";
    {literal}
        }
            
        var Types = function() {
            {/literal}
                {foreach from=$paramsBack.GLOBALS_SMARTY.TYPES item=type key=value}
                    this.{$value} = "{$type}";
                {/foreach}
            {literal}
        }
            
    </script>
{/literal}

{foreach from=$paramsBack.JS_FILES item="file"}
    <script type="text/javascript" src="{$file}"></script>
{/foreach}
{foreach from=$paramsBack.CSS_FILES item="file"}
    <link type="text/css" rel="stylesheet" href="{$file}"/>
{/foreach}

<div id="pet_content" class="pts">
    {if !$paramsBack.CONFIGS.PET_RM}
        <button type="button" id="display_form_register" onclick="$('#frm_register_product').toggle(500);">Register and validate your module!</button>    
        <div id="pet_register_product">        
            <form id="frm_register_product" name="frm_register_product" method="post">
                <fieldset>
                    <legend>Register and validate</legend>
                    
                    <p style="font-weight: bold;">
                        Discover the latest updates and news about this module, free and easy registering from this short form.
                    </p>
                    
                    <table>
                        <tr>
                            <td>
                                <label>Email:</label>
                                <sup>*</sup>
                            </td>
                            <td>
                                <input type="text" id="txt_email" name="email" size="50"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Seller:</label>
                                <sup>*</sup>
                            </td>
                            <td>
                                <select id="lst_sellet" name="seller">
                                    <option value="">Choose...</option>                                
                                    <option value="presteamshop.com">PresTeamShop.com</option>
                                    <option value="prestashop.com">Addons PrestaShop</option>                                
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>&numero; Order:</label>
                                <sup>*</sup>
                            </td>
                            <td>
                                <input type="text" id="txt_number_order" name="number_order" />
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <button type="submit" id="btn_sent_register" name="sent_register">Sent</button> 
                            </td>
                        </tr>
                    </table>                
                    <table>
                        <tr>
                            <td>
                                <p style="font-weight: bold;">
                                    Do you already have your license number?
                                </p>
                            </td> 
                        </tr>
                        <tr>                     
                            <td>
                                <input type="text" id="txt_license_number" name="license_number" size="40"/>
                                <button type="submit" id="btn_validate_license" name="validate_license">Validate</button>
                            </td>
                        </tr>
                    </table>                             
                </fieldset>
            </form>                          
        </div>
    {/if}

    <div id="pet_right_column">        
        <ul>
            <li><a href="#content_main-1">{l s='Settings of tabs' mod='productextratabs'}</a></li>
            <li><a href="#content_main-2">{l s='Settings content tabs' mod='productextratabs'}</a></li>
        </ul>

        <div id="content_main-1">
            <input type="hidden" name="id_tab" id="id_tab" />                
            <table>
                <thead>                    
                    <tr>
                        <td>
                            <label>{l s='Name of tab' mod='productextratabs'}:</label>
                        </td>
                        <td>                                       
                            {foreach from=$paramsBack.LANGUAGES item="language" name="f_languages"}  
                                <div id="lang_name_tab_{$language.id_lang}" style="display: {if $language.id_lang == $paramsBack.DEFAULT_LENGUAGE}block{else}none{/if}; float: left;">
                                    <input type="text" id="name_tab_{$language.id_lang}" name="name_tab_{$language.id_lang}" />
                                </div>                            
                            {/foreach}                                               
                        </td>
                        <td>{$paramsBack.FLAGS_TAB}</td>
                    </tr>
                    <tr>
                        <td>
                            <label for="type_tab">{l s='Tab type' mod='productextratabs'}:</label>
                        </td>
                        <td>
                            <select id="type_tab">                                
                                {foreach from=$paramsBack.GLOBALS_SMARTY.TYPES item=type key=value}
                                    <option value="{$value}">{$type}</option>
                                {/foreach}
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="active_tab">{l s='Active' mod='productextratabs'}:</label>
                        </td>
                        <td>                                                                                                                                                             
                            <label class="t"><img title="{l s='Enabled' mod='productextratabs'}" alt="{l s='Enabled' mod='productextratabs'}" src="{$paramsBack.PRODUCTEXTRATABS_IMG}icon/enabled.gif" /></label>
                            <input type="radio" id="active_tab_on" name="active_tab" value="1" checked="true"/>

                            <label class="t"><img title="{l s='Disabled' mod='productextratabs'}" alt="{l s='Disabled' mod='productextratabs'}" src="{$paramsBack.PRODUCTEXTRATABS_IMG}icon/disabled.gif" /></label>
                            <input type="radio" id="active_tab_off" name="active_tab" value="0"/>                                   
                        </td>   
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td></td>
                        <td>
                            <br />
                            <button id="btn_update_tab" name="btn_update_tab">{l s='Update' mod='productextratabs'}</button>
                            <button id="btn_clear_tab" name="btn_clear_tab">{l s='Clear form' mod='productextratabs'}</button>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <br />
            <div id="div_loading_tab"></div>
            <br />
            <table class="table" id="table_tab">
                <thead>
                    <tr>
                        <th>{l s='ID' mod='productextratabs'}</th>
                        <th>{l s='Name' mod='productextratabs'}</th>
                        <th>{l s='Type' mod='productextratabs'}</th>
                        <th>{l s='Active' mod='productextratabs'}</th>
                        <th style="width:65px" class="text_center">{l s='Action' mod='productextratabs'}</th>
                    </tr>
                </thead>
                <tbody class="sortable sortable_connect">
                    {foreach from=$paramsBack.LIST_TABS item='tab' name='f_list_tab'}
                        <tr id="{$tab.id_tab}" style="cursor: pointer;">
                            <td>
                                <div style="white-space:nowrap; display: inline-block; height: 16px;">
                                    <span style="display: inline-block;" class="ui-icon ui-icon-arrow-4-diag"></span>
                                    <span style="position: relative;left: 1px; top: -3px;">{$tab.id_tab}</span>
                                </div>
                            </td>
                            <td>{$tab.name}</td>
                            <td>{$paramsBack.GLOBALS_SMARTY.TYPES[$tab.type]}</td>
                            <td>{if $tab.active}{l s='Yes' mod='productextratabs'}{else}{l s='No' mod='productextratabs'}{/if}</td>
                            <td class="accions">
                                <img onclick="editTab({$tab.id_tab})" src="{$paramsBack.PRODUCTEXTRATABS_IMG}icon/edit.png" title="{l s='Edit' mod='productextratabs'}"/>
                                <img onclick="deleteTab({$tab.id_tab})" src="{$paramsBack.PRODUCTEXTRATABS_IMG}icon/delete.png" title="{l s='Remove' mod='productextratabs'}"/>
                            </td>
                        </tr>
                    {/foreach}
                </tbody>        
            </table>                            
        </div>

        <div id="content_main-2">            
            <input type="hidden" name="id_tab_content" id="id_tab_content" />
            <table>
                <thead>                    
                    <tr>
                        <td>
                            <label for="lst_id_tab">{l s='Tab' mod='productextratabs'}:</label>
                        </td>
                        <td>
                            <select id="lst_id_tab" name="lst_id_tab">                                       
                                {foreach from=$paramsBack.LIST_TABS item="tab" name="f_tabs"}  
                                    <option value="{$tab.id_tab}">{$tab.name}</option>                            
                                {/foreach}
                            </select>                                              
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="id_category">{l s='Category' mod='productextratabs'}:</label>
                        </td>
                        <td>                                                                                                                                                             
                            <select id="id_category" name="id_category">                                       
                                {$paramsBack.CATEGORIES}
                            </select>                                    
                        </td>   
                    </tr>
                    <tr>
                        <td>
                            <label for="id_product">{l s='Product' mod='productextratabs'}:</label>
                        </td>
                        <td>
                            <select id="id_product" name="id_product">
                                <option value="-1">{l s='All products' mod='productextratabs'}</option>                                       
                                {foreach from=$paramsBack.PRODUCTS item="product" name="f_products"}  
                                    <option value="{$product.id_product}">{$product.name}</option>                            
                                {/foreach}
                            </select>                                              
                        </td>
                    </tr> 
                    <tr id="tr_content_tab">
                        <td class="valign_top" colspan="2">
                            <label>{l s='Content' mod='productextratabs'}:</label>
                            <br />
                            {foreach from=$paramsBack.LANGUAGES item="language" name="f_languages"}  
                                <div id="ctab_content_{$language.id_lang}" style="display: {if $language.id_lang == $paramsBack.DEFAULT_LENGUAGE}block{else}none{/if}; float: left;">
                                    <textarea class="rte autoload_rte" cols="30" rows="30" id="tab_content_{$language.id_lang}" name="tab_content_{$language.id_lang}"></textarea>
                                </div>                            
                            {/foreach}                                           
                        </td>
                        <td class="valign_top">
                            <br />
                            {$paramsBack.FLAGS_TAB_CONTENT}
                        </td>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td></td>
                        <td>
                            <br />
                            <button id="btn_update_tab_content" name="btn_update_tab_content">{l s='Update' mod='productextratabs'}</button>
                            <button id="btn_clear_tab_content" name="btn_clear_tab_content">{l s='Clear form' mod='productextratabs'}</button>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <br />
            <div id="div_loading_tab_content"></div>
            <br />
            <table class="table" id="table_tab_content">
                <thead>
                    <tr>
                        <th>{l s='ID' mod='productextratabs'}</th>
                        <th>{l s='Tab' mod='productextratabs'}</th>
                        <th>{l s='Category' mod='productextratabs'}</th>
                        <th>{l s='Product' mod='productextratabs'}</th>
                        <th style="width:65px" class="text_center">{l s='Action' mod='productextratabs'}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            &nbsp;
                        </td>
                        <td>
                            <select id="lst_id_tab_search" name="lst_id_tab_search">
                                <option value="0">--</option>
                                {foreach from=$paramsBack.LIST_TABS item="tab" name="f_tabs"}  
                                    <option value="{$tab.id_tab}">{$tab.name}</option>                            
                                {/foreach}
                            </select>
                        </td>
                        <td>
                            <select id="id_category_search" name="id_category_search">
                                <option value="0">--</option>
                                {$paramsBack.CATEGORIES}
                            </select>
                        </td>
                        <td>
                            <select id="id_product_search" name="id_product_search">
                                <option value="0">--</option>
                                <option value="-1">{l s='All products' mod='productextratabs'}</option>                                       
                                {foreach from=$paramsBack.PRODUCTS item="product" name="f_products"}  
                                    <option value="{$product.id_product}">{$product.name}</option>                            
                                {/foreach}
                            </select>
                        </td>
                        <td class="accions">
                            <button id="btn_search_product_extra_tabs" name="btn_search_product_extra_tabs">
                                {l s='Search' mod='productextratabs'}
                            </button>
                        </td>
                    </tr>
                </tbody>        
            </table>            
        </div>        
    </div>
    
    <br class="clear"/>    
    
    <fieldset id="pet_content_credits">
        <legend>
            User guides
        </legend>
                
        <div>
            <a style="text-decoration: underline; color: blue" target="_blank" href="{$paramsBack.PRODUCTEXTRATABS_DIR}user_guide_es.pdf">User guide module(Spanish)</span></a>
            &nbsp;&nbsp;&nbsp;
            <a style="text-decoration: underline; color: blue" target="_blank" href="{$paramsBack.PRODUCTEXTRATABS_DIR}user_guide_en.pdf">User guide module(English)</span></a>            
        </div>                                             
     </fieldset>
</div>