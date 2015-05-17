/**
 * @author PresTeamShop.com
 * @copyright PresTeamShop.com - 2013
 */
var msg = new Messages(); 
var types = new Types(); 

$(function(){    
    $('body').addClass('pts');
        
    $('#pet_right_column').tabs({
        cookie : {
            expires : 1
        }
    });
    
    $('#pet_right_column').show();
    
    $('#pet_content :button').button();
    
    getType();
    
    $('#lst_id_tab').change(function() {
        getType();
    });
        
    $('#btn_update_tab').click(function(){
       
       //valida que ingresen el texto por lo menos de un idioma
        var tmp = 0;
        for (i=0; i<languages.length;i++){
            var name_tab = $('#name_tab_'+languages[i]).val();
            if (name_tab == '')
                tmp += 1;            
        }
        if (tmp == languages.length){
            alert(msg.names_tab_empty);
            return false;
        }
        
        //Arma cadena de idioma y nombre de la pestana
        var name = "";        
        for (i=0; i<languages.length;i++){
            var name_tab = $('#name_tab_'+languages[i]).val();
            
            name += languages[i]+'|'+name_tab;

            if (i+1 != languages.length)
                name += '@';
        }
        
        var id_tab = $('#id_tab').val() == '' ? 0 : $('#id_tab').val();
        var active_tab = $('input[name=active_tab]:checked').val();
                      
        var type = $('#type_tab').val();
        if (type == 0) {
            return false;
        }
                      
        $.ajax({
           type: 'POST',
           url: productextratabs_dir + 'actions.php',
           async: true,
           cache: false,
           dataType : 'json',
           data: 'action=updateTab' +
                 '&id_tab=' + id_tab +
                 '&name=' + name +
                 '&type=' + type +
                 '&active=' + active_tab,
           beforeSend: function()
           {
                $("#div_loading_tab").empty().html('<center><img src="'+productextratabs_dir+'img/loader.gif" /></center>');
           },
           success: function(json)
           {                
                if(json.message_code == 0){
                    getListTab();
                    clearTab();
                    refreshListTabs();                                        
                    
                    $('#div_loading_tab').removeAttr('class').empty().addClass('conf').html(json.message);                                            
                }else{
                    $('#div_loading_tab').removeAttr('class').empty().addClass('error').html(json.message);
                }                                                                                                                                           
           },
           error: function(XMLHttpRequest, textStatus, errorThrown) {
                $('#div_loading_tab').removeAttr('class').empty().addClass('error').html(XMLHttpRequest.responseText);
           }
        });
    });
        
    $('#btn_update_tab_content').click(function(){
        //Arma cadena de idioma y contenido de la pestana 
        var content_tab = new Array();
        for (var i=0; i<languages.length;i++){
            var id_lang = languages[i];
            var ed = tinyMCE.get('tab_content_' + id_lang);            
            var content_lang = Base64.encode(ed.getContent());

            var _content = new Object();

            _content.id_lang = id_lang;
            _content.content = content_lang;

            content_tab[i] = _content;
        }

        var id_tab_content = $('#id_tab_content').val() == '' ? 0 : $('#id_tab_content').val();
        var id_tab = $('#lst_id_tab').val();
        var id_product = $('#id_product').val();
        var id_category = $('#id_category').val();

        $.ajax({
           type: 'POST',
           url: productextratabs_dir + 'actions.php',
           async: true,
           cache: false,
           dataType : 'json',
           data: {
               'action': 'updateTabContent',
               'id_tab_content': id_tab_content,
               'id_tab': id_tab,
               'id_product': id_product,
               'id_category': id_category,
               'content': JSON.stringify(content_tab)
           },
           beforeSend: function()
           {
                $("#div_loading_tab_content").empty().html('<center><img src="'+productextratabs_dir+'img/loader.gif" /></center>');
           },
           success: function(json)
           {                
                if(json.message_code == 0){
                    clearTabContent();
                    
                    $('#div_loading_tab_content').removeAttr('class').empty().addClass('conf').html(json.message);                                            
                }else{
                    $('#div_loading_tab_content').removeAttr('class').empty().addClass('error').html(json.message);
                }      
                
                getType();
           },
           error: function(XMLHttpRequest, textStatus, errorThrown) {
                $('#div_loading_tab_content').removeAttr('class').empty().addClass('error').html(XMLHttpRequest.responseText);                
           }
        });
    });    
    
    $('#id_category').change(function(){
        $.ajax({
           type: 'POST',
           url: productextratabs_dir + 'actions.php',
           async: false,
           cache: false,
           dataType : 'json',
           data: 'action=getProductByCategory' +
                 '&id_category=' + ($(this).val() == -1 ? 1 : $(this).val()),
           success: function(json)
           {                                
                $('#id_product').html('<option value="-1">'+msg.all_products+'</option>');
                $.each(json, function(i, product){
                    $('#id_product').append('<option value="'+product.id_product+'">'+product.name+'</option>');
                });                                                                                                                                     
           }
        });        
    }); 
    
    $('#id_category_search').change(function(){
        $.ajax({
           type: 'POST',
           url: productextratabs_dir + 'actions.php',
           async: false,
           cache: false,
           dataType : 'json',
           data: 'action=getProductByCategory' +
                 '&id_category=' + $(this).val(),
           success: function(json)
           {                                
                $('#id_product_search').html('<option value="0">--</option>');
                $('#id_product_search').append('<option value="-1">'+msg.all_products+'</option>');
                $.each(json, function(i, product){
                    $('#id_product_search').append('<option value="'+product.id_product+'">'+product.name+'</option>');
                });                                                                                                                                     
           }
        });        
    }); 
    
    $('#btn_clear_tab').click(function(){
        clearTab();
    }); 
    
    $('#btn_clear_tab_content').click(function(){
        clearTabContent();
    }); 
    
    $('#btn_sent_register').click(function(e){
        if (!$.isEmpty($('#txt_email').val()) && !$.isEmpty($('#lst_sellet').val()) && !$.isEmpty($('#txt_number_order').val())){
            $('#frm_register_product').submit();                
        }else{
            e.preventDefault();
            e.stopPropagation();
        }       
    });
    
    $('#btn_validate_license').click(function(e){
        if (!$.isEmpty($('#txt_license_number').val())){
            $('#frm_register_product').submit();                
        }else{
            e.preventDefault();
            e.stopPropagation();
        }       
    });
    
    $('#btn_search_product_extra_tabs').click(function(e) {
        var tab_id = $('#lst_id_tab_search').val();
        var category_id = $('#id_category_search').val();
        var product_id = $('#id_product_search').val();
        
        $.ajax({
           type: 'POST',
           url: productextratabs_dir + 'actions.php',
           async: false,
           cache: false,
           dataType : 'json',
           data: {
               action: 'getExtraTabsFilter',
               id_tab: tab_id,
               id_category: category_id,
               id_product: product_id
           },
           beforeSend: function()
           {
                $('#div_loading_tab_content').empty().html('<center><img src="'+productextratabs_dir+'img/loader.gif" /></center>');
           },
           success: function(json)
           {               
               
               $("#table_tab_content tbody tr:not(:first)").remove();
            
               $.each(json, function(key, tab_content){
                    var html = '';

                    html += '<tr>';
                    html += '   <td>'+tab_content.id_tab_content+'</td>';
                    html += '   <td>'+tab_content.name_tab+'</td>';
                    html += '   <td>'+(tab_content.id_category == -1 ? msg.all_categories : tab_content.name_category)+'</td>';
                    html += '   <td>'+(tab_content.id_product == -1 ? msg.all_products : tab_content.name_product)+'</td>';
                    html += '   <td align="center" class="accions">';
                    html += '       <img onclick="editTabContent(' + tab_content.id_tab_content + ')" src="' + productextratabs_img + 'icon/edit.png" title="' + msg.edit + '"/>';
                    html += '       <img onclick="deleteTabContent(' + tab_content.id_tab_content + ')" src="' + productextratabs_img + 'icon/delete.png" title="' + msg.remove + '"/>';
                    html += '   </td>';
                    html += '</tr>';

                    $('#table_tab_content tbody').append(html);
               });
               
               $('#div_loading_tab_content').empty().removeClass('conf').removeClass('error');
           }
        }); 
        
    });
    
    var fixHelperModified = function(e, tr) {
        var $originals = tr.children();
        var $helper = tr.clone();
        $helper.children().each(function(index) {
            $(this).width($originals.eq(index).width())
            $(this).css('background', '#CCCCCC')
        });
        return $helper;
    };
    
    $('.sortable_connect').sortable({
        placeholder: 'ui-state-highlight',
        helper: fixHelperModified,
        stop: stopSortableTabs
    }); 
    
});

function getType() {
    var id_tab = $('#lst_id_tab').val();
        $.ajax({
           type: 'POST',
           url: productextratabs_dir + 'actions.php',
           async: true,
           cache: false,
           dataType : 'json',
           data: 'action=getType' +
                 '&id_tab=' + id_tab,
           success: function(json)
           {                
                if(json.message_code == 0){
                    if (json.type == 'content')
                        $('#tr_content_tab').show();
                    else 
                        $('#tr_content_tab').hide();
                }                                                                                                                                         
           },
           error: function(XMLHttpRequest, textStatus, errorThrown) {
                $('#div_loading_tab').removeAttr('class').empty().addClass('error').html(XMLHttpRequest.responseText);                
           }
        });
}

function refreshListTabs(){
    $.ajax({
       type: 'POST',
       url: productextratabs_dir + 'actions.php',
       async: true,
       cache: false,
       dataType : 'json',
       data: 'action=getListTab',
       success: function(json)
       {                                
            $('#lst_id_tab').html('');
            $.each(json, function(i, tab){
                $('#lst_id_tab').append('<option value="'+tab.id_tab+'">'+tab.name+'</option>');
            });
            
            getType();  
            
            //update filter tab list
            $('#lst_id_tab_search').html('');
            $('#lst_id_tab_search').append('<option value="0">--</option>');
            $.each(json, function(i, tab){
                $('#lst_id_tab_search').append('<option value="'+tab.id_tab+'">'+tab.name+'</option>');
            });  
            
       }
    });
}

function clearTab()
{
    $('#id_tab').val('');
    $('#active_tab_on').attr('checked', true);
    
    for(var i=0; i<languages.length;i++){
        $('#name_tab_' + languages[i]).val('');        
    }
}

function clearTabContent()
{
    $('#id_tab_content').val('');
    $('#id_product').val('-1');
    $('#id_category').val('-1').trigger('change');
    $('#lst_id_tab option:eq(0)').attr('selected', true);
    
    for(var i=0; i<languages.length;i++){
        var ed = tinyMCE.get('tab_content_' + languages[i]);            
        ed.setContent('');        
    }
}

function editTab(id_tab){
    $.ajax({
       type: 'POST',
       url: productextratabs_dir + 'actions.php',
       async: true,
       cache: false,
       dataType : 'json',
       data: 'action=editTab&id_tab=' + id_tab,
       beforeSend: function()
       {
            $("#div_loading_tab").empty().html('<center><img src="'+productextratabs_dir+'img/loader.gif" /></center>');
       },
       success: function(json)
       {
            $('#div_loading_tab').removeAttr('class').empty();
        
            $('#id_tab').val(json.id);
            
            $('#type_tab').val(json.type);
            
            if (json.active == '1')
                $('#active_tab_on').attr('checked', 'true');
            else
                $('#active_tab_off').attr('checked', 'true');
            
            $.each(json.name, function(id_lang, name){
                $('#name_tab_'+id_lang).val(name);
            });
       },
       error: function(XMLHttpRequest, textStatus, errorThrown) {
            $('#div_loading_tab').removeAttr('class').empty().addClass('error').html(XMLHttpRequest.responseText);
       }
    });
}

function deleteTab(id_tab){
    $.ajax({
       type: 'POST',
       url: productextratabs_dir + 'actions.php',
       async: true,
       cache: false,
       dataType : 'json',
       data: 'action=deleteTab&id_tab=' + id_tab,
       beforeSend: function()
       {
            $("#div_loading_tab").empty().html('<center><img src="'+productextratabs_dir+'img/loader.gif" /></center>');
       },
       success: function(json)
       {
            if(json.message_code == 0){
                $('#div_loading_tab').removeAttr('class').empty().addClass('conf').html(json.message);
                
                getListTab(); 
            }else{
                $('#div_loading_tab').removeAttr('class').empty().addClass('error').html(json.message);
            }                                                                                                                                                    
       },
       error: function(XMLHttpRequest, textStatus, errorThrown) {
            $('#div_loading_tab').removeAttr('class').empty().addClass('error').html(XMLHttpRequest.responseText);
       }
    });
}

function getListTab(){
    $.ajax({
       type: 'POST',
       url: productextratabs_dir + 'actions.php',
       async: true,
       cache: false,
       data: 'action=getListTab',
       dataType : 'json',
       beforeSend: function()
       {
            $('#table_tab tbody').empty().html('<center><img src="'+productextratabs_dir+'img/loader.gif" /></center>');
       },
       success: function(json)
       {
            $('#table_tab tbody').empty();
            
            $.each(json, function(key, tab){
                var html = '';
                
                html += '<tr id="'+tab.id_tab+'" style="cursor: pointer;">';
                html += '   <td>';
                html += '       <div style="white-space:nowrap; display: inline-block; height: 16px;">';
                html += '           <span style="display: inline-block;" class="ui-icon ui-icon-arrow-4-diag"></span>';
                html += '           <span style="position: relative;left: 1px; top: -3px;">' + tab.id_tab + '</span>';
                html += '       </div>';
                html += '   </td>';
                html += '   <td>'+tab.name+'</td>';
                html += '   <td>'+types[tab.type]+'</td>';
                html += '   <td>'+( tab.active == '1' ? msg.yes : msg.no )+'</td>';
                html += '   <td align="center" class="accions">';
                html += '       <img onclick="editTab(' + tab.id_tab + ')" src="' + productextratabs_img + 'icon/edit.png" title="' + msg.edit + '"/>';
                html += '       <img onclick="deleteTab(' + tab.id_tab + ')" src="' + productextratabs_img + 'icon/delete.png" title="' + msg.remove + '"/>';                
                html += '   </td>';
                html += '</tr>';
                
                $('#table_tab tbody').append(html);
            });
            
            $('#table_tab tbody').addClass('sortable sortable_connect');
            
            $('.sortable_connect').sortable({
                placeholder: 'ui-state-highlight',
                stop: stopSortableTabs
            }); 
                                            
       },
       error: function(XMLHttpRequest, textStatus, errorThrown) {
            $('#table_tab tbody').removeAttr('class').empty().addClass('error').html(XMLHttpRequest.responseText);
       }
    });
}

function stopSortableTabs(event, ui) {
    var order_tabs = $('.sortable').sortable('toArray');
   
    $.ajax({
        type: 'POST',
        url: productextratabs_dir + 'actions.php',
        async: true,
        cache: false,
        dataType : 'json',
        data: {
            action: 'updateOptionsPosition',
            $order_tabs: order_tabs
        },
        beforeSend: function()
        {
            $('#table_tab tbody').addOverlay();
        },
        success: function(json)
        {     
            
        },
        complete: function(){
            $('#table_tab tbody').delOverlay();                
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest.responseText);                
        }
    });
    
   
}

function editTabContent(id_tab_content){
    $.ajax({
       type: 'POST',
       url: productextratabs_dir + 'actions.php',
       async: true,
       cache: false,
       dataType : 'json',
       data: 'action=editTabContent&id_tab_content=' + id_tab_content,
       beforeSend: function()
       {
            $("#div_loading_tab_content").empty().html('<center><img src="'+productextratabs_dir+'img/loader.gif" /></center>');
       },
       success: function(json)
       {
            $('#div_loading_tab_content').removeAttr('class').empty();
        
            $('#id_tab_content').val(json.id);
            $('#lst_id_tab').val(json.id_tab)            
            $('#id_category').val(json.id_category).trigger('change');
            $('#id_product').val(json.id_product);            
            
            $('#lst_id_tab').trigger('change');
            
            $.each(json.content, function(id_lang, content){                
                var ed = tinyMCE.get('tab_content_'+id_lang);            
                ed.setContent(content);                
            });
       },
       error: function(XMLHttpRequest, textStatus, errorThrown) {
            $('#div_loading_tab_content').removeAttr('class').empty().addClass('error').html(XMLHttpRequest.responseText);
       }
    });
}

function deleteTabContent(id_tab_content){
    $.ajax({
       type: 'POST',
       url: productextratabs_dir + 'actions.php',
       async: true,
       cache: false,
       dataType : 'json',
       data: 'action=deleteTabContent&id_tab_content=' + id_tab_content,
       beforeSend: function()
       {
            $("#div_loading_tab_content").empty().html('<center><img src="'+productextratabs_dir+'img/loader.gif" /></center>');
       },
       success: function(json)
       {
            if(json.message_code == 0){
                $('#div_loading_tab_content').removeAttr('class').empty().addClass('conf').html(json.message);
                
                $('#btn_search_product_extra_tabs').trigger('click');
            }else{
                $('#div_loading_tab_content').removeAttr('class').empty().addClass('error').html(json.message);
            }                                                                                                                                                    
       },
       error: function(XMLHttpRequest, textStatus, errorThrown) {
            $('#div_loading_tab_content').removeAttr('class').empty().addClass('error').html(XMLHttpRequest.responseText);
       }
    });
}

function getListTabsContent(){
    $.ajax({
       type: 'POST',
       url: productextratabs_dir + 'actions.php',
       async: true,
       cache: false,
       data: 'action=getListTabsContent',
       dataType : 'json',
       beforeSend: function()
       {
            $("#table_tab_content tbody tr:not(':first')").remove().html('<center><img src="'+productextratabs_dir+'img/loader.gif" /></center>');
       },
       success: function(json)
       {
            $("#table_tab_content tbody tr:not(':first')").remove();
            
            $.each(json, function(key, tab_content){
                var html = '';
                
                html += '<tr>';
                html += '   <td>'+tab_content.id_tab_content+'</td>';
                html += '   <td>'+tab_content.name_tab+'</td>';
                html += '   <td>'+(tab_content.id_category == -1 ? msg.all_categories : tab_content.name_category)+'</td>';
                html += '   <td>'+(tab_content.id_product == -1 ? msg.all_products : tab_content.name_product)+'</td>';
                html += '   <td align="center" class="accions">';
                html += '       <img onclick="editTabContent(' + tab_content.id_tab_content + ')" src="' + productextratabs_img + 'icon/edit.png" title="' + msg.edit + '"/>';
                html += '       <img onclick="deleteTabContent(' + tab_content.id_tab_content + ')" src="' + productextratabs_img + 'icon/delete.png" title="' + msg.remove + '"/>';
                html += '   </td>';
                html += '</tr>';

                $('#table_tab_content tbody').append(html);
            });                                                                     
       },
       error: function(XMLHttpRequest, textStatus, errorThrown) {
            $('#table_tab_content tbody').removeAttr('class').empty().addClass('error').html(XMLHttpRequest.responseText);
       }
    });
}