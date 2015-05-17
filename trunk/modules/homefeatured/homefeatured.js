/**
 * Created with JetBrains PhpStorm.
 * User: hitanshu
 * Date: 6/9/13
 * Time: 12:39 PM
 * To change this template use File | Settings | File Templates.
 */
$(document).ready(function () {
    var new_products_ids = $(".newproductslider-item").map(function () {
        return this.id;
    });
    //array of ids
    var new_products_idsArray = new_products_ids.toArray();
    if (new_products_idsArray.length > 0) {

        $.ajax({
            type: 'POST',
            url: baseDir + 'index.php?fc=module&module=featurecategories&controller=compare',
            async: true,
            cache: false,
            data: 'action=productWiseIcons&productIds=' + new_products_idsArray,
            success: function (jsonData, textStatus, jqXHR) {
                var obj = jQuery.parseJSON(jsonData);
                $.each(obj, function (key, value) {
                    $.each(value, function (key1, value1) {

                        key1 = key1.toLowerCase();
                        if (key1 == 'rating') {
                            $('#' + key1 + '_block_new_' + key).html(value1);
                        }
                        else {
                            if (value1.status) {

                                if (key1 == 'video') {
                                    var videoId = value1.description;
                                    if (videoId) {
                                        $('#' + key1 + '_new_' + key).find('a').attr('href', 'http://www.youtube.com/embed/' + videoId);
                                        $('#' + key1 + '_new_' + key).show();
                                    }
                                }
                                else if (key1 == 'producthighlightfeatures') {
                                    if (value1.description) {
                                        $('#product_highlight_feature_' + key).html(value1.description);
                                    }

                                }
                                else {
                                    $('#' + key1 + '_new_' + key).show();
                                }

                            }
                        }
                    });
                });
            }
        });
    }
	var fancyBoxObjNew=new Object();
    fancyBoxObjNew.showNavArrows=false;
    $('a.iframe_new').fancybox(fancyBoxObjNew);

    var ids = $(".ajax_block_product").map(function () {
        return this.id;
    });
    //array of ids
    var idsArray = ids.toArray();
    idsArray = jQuery.grep(idsArray, function (n, i) {
        return (n !== "" && n != null);
    });
    if (idsArray.length > 0) {
        $.ajax({
            type: 'POST',
            url: baseDir + 'index.php?fc=module&module=featurecategories&controller=compare',
            async: true,
            cache: false,
            data: 'action=productWiseIcons&productIds=' + idsArray,
            success: function (jsonData, textStatus, jqXHR) {
                var obj = jQuery.parseJSON(jsonData);
                $.each(obj, function (key, value) {
                    $.each(value, function (key1, value1) {

                        key1 = key1.toLowerCase();
                        if (key1 == 'rating') {
                            $('#' + key1 + '_block_' + key).html(value1);
                        }
                        else {
                            if (value1.status) {

                                if (key1 == 'video') {
                                    var videoId = value1.description;
                                    if (videoId) {
                                        $('.' + key1 + '_' + key).find('a').attr('href', 'http://www.youtube.com/embed/' + videoId);
                                        $('.' + key1 + '_' + key).show();
                                    }
                                }
                                else if (key1 == 'producthighlightfeatures') {
                                    if (value1.description) {
                                        $('#product_highlight_feature_fp_' + key).html(value1.description);
                                    }

                                }
                                else {
                                    $('.' + key1 + '_' + key).show();
                                }

                            }
                        }
                    });
                });
            }
        });
    }
    var fancyBoxObj=new Object();
    fancyBoxObj.showNavArrows=false;
    $('a.iframe').fancybox(fancyBoxObj);
});
