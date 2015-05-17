/**
 * @author PresTeamShop.com
 * @copyright PresTeamShop.com - 2012
 */

var Tools = {
    displayErrors: function(params){
        var p = $.extend({}, {
            prefix: '-',
            breakLine: '\n',
            errors: [],
            dispatcher: {
                fn: 'alert',
                obj: window
            }
        }, params);
        
        var msg = ((p.errors).length > 1 ? OnePageCheckoutPS.Msg.there_are : OnePageCheckoutPS.Msg.there_is) + ' ' + (p.errors).length + ' ' + ((p.errors).length > 1 ? OnePageCheckoutPS.Msg.errors : OnePageCheckoutPS.Msg.error) + p.breakLine;
        $.each(p.errors, function(i, error){
            msg += p.prefix + error + p.breakLine;
        });
        
        if((p.errors).length)
            p.dispatcher.obj[p.dispatcher.fn](msg);
    }
}

jQuery.extend({
    isEmpty: function(){
        var count = 0;
        $.each(arguments, function(i, data){
            if(data != null && data != undefined && data != '' && typeof(data) != 'undefined'){
                count ++;
            }
            else
                return false
        });
        return (arguments).length == count ? false : true;
    },
    isEmail: function(val){
        var regExp = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i;
        return regExp.exec(val);
    },
    strpos: function(haystack, needle, offset){
        // Finds position of first occurrence of a string within another  
        // 
        // version: 1109.2015
        // discuss at: http://phpjs.org/functions/strpos    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
        // +   improved by: Onno Marsman    
        // +   bugfixed by: Daniel Esteban
        // +   improved by: Brett Zamir (http://brett-zamir.me)
        // *     example 1: strpos('Kevin van Zonneveld', 'e', 5);    // *     returns 1: 14
    
        var i = (haystack + '').indexOf(needle, (offset || 0));
        return i === -1 ? false : i;
    }
});

jQuery.fn.extend({
    validName: function(){
        jQuery(this).keypress(function(e){
            var key = (document.all) ? e.keyCode : e.which;
            if(key == 8 || key == 0) return true;

            var character = String.fromCharCode(key).toString();            
            var regExp = /^[a-zA-Zá-úÁ-ÚÄ-Üà-ù'\s]*$/;
            
            return regExp.test(character);
        });
        
        return jQuery(this);
    },
    validAddress: function(){
        jQuery(this).keypress(function(e){
            var key = (document.all) ? e.keyCode : e.which;
            if(key == 8 || key == 0) return true;
            
            var character = String.fromCharCode(key).toString();
            var regExp = /^[a-zA-Zá-úÁ-ÚÄ-Üà-ù0-9#ºª\-\s,]*$/;
            
            return regExp.test(character);
        });
        
        return jQuery(this);
    },
    addOverlay: function(){        
        return jQuery(this).addClass('overlay').fadeTo(0, .4);
    },
    delOverlay: function(){        
        return jQuery(this).fadeTo(100, 1).removeClass('overlay');
    },
    //Deshabilitar boton con la opcion de enviar un texto para setearlo, dado el caso que dentro del arreglo de {Msg}
    //Existe la llave como ID, se toma la propiedad {off} y se omite el texto enviado por parametro 
    disableButton: function(val){
        if(Msg[jQuery(this).attr('id')]){
            return jQuery(this).attr('disabled', true).find('span.ui-button-text').html(Msg[jQuery(this).attr('id')].off);
        }
        else   
            return jQuery(this).attr('disabled', true).find('span.ui-button-text').html(val);
    },
    //Habilitar boton con la opcion de enviar un texto para setearlo, dado el caso que dentro del arreglo de {Msg}
    //Existe la llave como ID, se toma la propiedad {on} y se omite el texto enviado por parametro 
    enableButton: function(val){
        if(Msg[jQuery(this).attr('id')]){
            return jQuery(this).attr('disabled', false).find('span.ui-button-text').html(Msg[jQuery(this).attr('id')].on).parent();
        }
        else   
            return jQuery(this).attr('disabled', false).find('span.ui-button-text').html(val).parent();
    }
});