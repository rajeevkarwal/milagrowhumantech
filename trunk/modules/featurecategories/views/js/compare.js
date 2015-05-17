$(document).ready(function () {
    $('.question_image').each(function () {
        $(this).qtip({
            content: {
                title: {
                    text: 'Description',
                    button: true
                },
                text: $(this).parent().children('.tooltip_val')[0].innerHTML
            },
            show: {
                event: 'mouseenter',
                solo: true
            },
            hide: {event: false},
            position: {
                at: 'bottom right',
                my: 'top left',
                adjust: {
                    method: 'shift none'
                }
            }, style: {
                width: 1000, // Overrides width set by CSS (but no max-width!)
                classes: 'qtip-light',
                overflow: 'scroll'
            }
        });
    });

    $('.question_image_product_block').live('click', function (event) {
        // Bind the qTip within the event handler
        $(this).qtip({
            overwrite: false, // Make sure the tooltip won't be overridden once created
            content: {
                title: {
                    text: 'Description',
                    button: true
                },
                text: $(this).find('.tooltip_val')[0].innerHTML
            },
            show: {
                event: event.type, // Use the same show event as the one that triggered the event handler
                ready: true,// Show the tooltip as soon as it's bound, vital so it shows up the first time you hover!
                solo: true
            },
            hide: {event: false},
            position: {
                at: 'bottom left',
                my: 'top left',
                adjust: {
                    method: 'flip'
                },
                viewport: true
            }, style: {
                width: 400, // Overrides width set by CSS (but no max-width!)
                classes: 'qtip-light',
                overflow: 'scroll'
            }

        }, event); // Pass through our original event to qTip
    })

// Store our title attribute in 'oldtitle' attribute instead
        .each(function (i) {
            $.attr(this, 'oldtitle', $.attr(this, 'title'));
            this.removeAttribute('title');
        });


//    $('.question_image').each(function () {
//        $(this).qtip({
//            content: {
//                title: {
//                    text: 'Description',
//                    button: true
//                },
//                text: $(this).parent().children('.tooltip_val')[0].innerHTML
//            },
//            show: {when: 'mouseover', solo: true},
//            hide: false,
//            style: {
//                width: 500,
//                height: 100,
//                //                background: '#ffffca',
//                color: 'black',
//                textAlign: 'left',
//                overflow:'scroll',
//                border: {
//                    width: 7,
//                    radius: 5,
//                    color: '#ffffca'
//                }, name: 'cream' },
//            position: {
//                corner: {
//                    target: 'topRight',
//                    tooltip: 'bottomLeft'
//                }
//            }
//        });
//    });


    $.ajax({
        type: 'POST',
        url: baseDir + 'index.php?fc=module&module=featurecategories&controller=compare',
        async: true,
        cache: false,
        data: 'action=show',
        success: function (jsonData, textStatus, jqXHR) {
                jsonData=$.trim(jsonData);
            if (jsonData) {
                $('#compare_block').addClass('compare_block_height');
                $('#fc_comparison').empty().html(jsonData);
                updateRenderPosition();
            }
            else {
                $('#compare_block').removeClass('compare_block_height');
                $('#fc_comparison').empty().html(jsonData);
                updateRenderPosition();
            }
        }
    });

//    $('.fc_btn_compare').click(function (e) {
//        e.preventDefault();
//        var productId = $(this).attr('name');//.split('&productId=')[1];
//        $.ajax({
//            type: 'POST',
//            url: baseDir + 'index.php?fc=module&module=featurecategories&controller=compare',
//            async: true,
//            cache: false,
//            data: 'action=add&productId=' + productId,
//            success: function (jsonData, textStatus, jqXHR) {
//                $('#fc_comparison').empty().html(jsonData);
//                $('html, body').animate({
//                    scrollTop: $("#fc_comparison").offset().top - 100}, 1000);
//            }
//        });
//        return false;
//    });


});

function deleteItem(data) {
    var productId = data.attr('href').split('&productId=')[1];
    $.ajax({
        type: 'POST',
        url: baseDir + 'index.php?fc=module&module=featurecategories&controller=compare',
        async: true,
        cache: false,
        data: 'action=delete&productId=' + productId,
        success: function (jsonData, textStatus, jqXHR) {
            jsonData=$.trim(jsonData);
            if (jsonData) {
                $('#compare_block').addClass('compare_block_height');
                $('#fc_comparison').empty().html(jsonData);
                updateRenderPosition();
            }
            else {
                $('#compare_block').removeClass('compare_block_height');
                $('#fc_comparison').empty().html(jsonData);
                updateRenderPosition();
            }
        }
    });
}

function deleteAllItems() {
    $.ajax({
        type: 'POST',
        url: baseDir + 'index.php?fc=module&module=featurecategories&controller=compare',
        async: true,
        cache: false,
        data: 'action=deleteall',
        success: function (jsonData, textStatus, jqXHR) {
            jsonData=$.trim(jsonData);
            if (jsonData) {
                $('#compare_block').addClass('compare_block_height');
                $('#fc_comparison').empty().html(jsonData);
                updateRenderPosition();
            }
            else {
                $('#compare_block').removeClass('compare_block_height');
                $('#fc_comparison').empty().html(jsonData);
                updateRenderPosition();
            }
        }
    });
}

function handleCategoryClickproduct(element) {
    var category = element.attr('id');
    var filterCategory = $.trim(category);
    if ($('.feature_' + filterCategory).css('display') != 'none') {
        $('.img_' + filterCategory).attr('src', '/modules/featurecategories/views/img/menu_down.jpg');

        $('.feature_' + filterCategory).each(function () {
            $(this).slideUp(0);
        });
    }

    else {
        $('.img_' + filterCategory).attr('src', '/modules/featurecategories/views/img/menu_up.jpg');
        $('.feature_' + filterCategory).each(function () {
            $(this).slideDown(0);
        });
    }
}
