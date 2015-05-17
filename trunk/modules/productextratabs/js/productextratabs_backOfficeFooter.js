
function onUpdate() {    
    var id_product = $("#id_product").val();
    
    $(".hdn_id_tab").each(function(i, element) {
        var id_tab = $(element).val();
            
        var upd = $("#chk_update_tab_content_" + id_tab).is(":checked");

        var content = new Array();

        $(".hdn_id_lang_" + id_tab).each(function(ei, elang){
            var id_lang = $(elang).val();
            var content_lang = tinymce.get('tab_content_' + id_tab + '_' + id_lang).getContent();

            var _content = new Object();

            _content.id_lang = id_lang;
            _content.content = Base64.encode(content_lang);

            content[ei] = _content;

        });

        $.ajax({
            type: 'POST',
            url: productextratabs_dir + 'actions.php',
            async: true,
            cache: false,
            dataType : 'json',
            data: {
                action: 'saveTabContentByTabLang',
                id_product: id_product,
                id_tab: id_tab,
                content: JSON.stringify(content),
                upd: upd
            },
            beforeSend: function() 
            {
                $("#div_loading_tab").empty().html('<center><img src="'+productextratabs_dir+'img/loader.gif" /></center>');
            },
            success: function(json)
            {
                json = JSON.parse(json);
                if(json.message_code == 0){
                    $('#div_loading_tab').removeAttr('class').empty().addClass('conf').html(json.message);                                            
                }
                else {
                    $('#div_loading_tab').removeAttr('class').empty().addClass('error').html(json.message);
                }          
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                $('#div_loading_tab').removeAttr('class').empty().addClass('error').html(XMLHttpRequest.responseText);   
            }
         });        
    });    
}