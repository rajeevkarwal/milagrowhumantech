$(document).ready(function () {
    var baseDir = window.location.pathname.split('/modules')[0];
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
                my: 'top left'
            }, style: {
                width: 1000, // Overrides width set by CSS (but no max-width!)
                classes: 'qtip-light',
                overflow: 'scroll'
            }
        });
    });

    $('.remove').click(function (e) {
        e.preventDefault();
        var productId = $(this).attr('href');

        $.ajax({
            type: 'POST',
            url: baseDir + '?fc=module&module=featurecategories&controller=compare',
            async: true,
            cache: false,
            data: 'action=delete&productId=' + productId,
            success: function (jsonData, textStatus, jqXHR) {
                window.location.replace(window.location);
            }
        });

    });

    $(".category").on('change', function () {
        var category = $.trim($(this[this.selectedIndex]).val());
        var productId = $(this).attr('id');
        if (category) {
            $('#ajax-loader-category-' + productId).show();
            $.ajax({
                type: "POST",
                url: '/modules/featurecategories/productlist.php',
                data: {category: category},
                success: function (data) {
                    $('#ajax-loader-category-' + productId).hide();
                    var option = '<option value="">Select Product</option>';
                    $.each(data, function (i, el) {
                        option += '<option value="' + el.id_product + '">' + el.name + '</option>'
                    });
                    $('#product_' + productId)
                        .find('option')
                        .remove()
                        .end()
                        .append(option)
                    ;
                    $('#product_' + productId).removeAttr('disabled');
                },
                dataType: 'json'
            });
        }
        else {
            $('#product_' + productId)
                .find('option')
                .remove()
                .end()
                .append('<option value="">Select Product</option>')
            ;
            $('#product_' + productId).attr({disabled: 'disabled'});
        }
    });

    $(".productChange").change(function () {
        var productId = $.trim($(".productChange option:selected").val());
        if (productId) {
            $.ajax({
                type: 'POST',
                url: baseDir + '?fc=module&module=featurecategories&controller=compare',
                async: true,
                cache: false,
                data: 'action=add&productId=' + productId,
                success: function () {
                    window.location.reload();
                }
            });
        }
    });
});

function handleCategoryClick(element) {
    var category = element.attr('id');
    var filterCategory = $.trim(category);
    if ($('.' + filterCategory).css('display') != 'none') {
        $('.img_' + filterCategory).attr('src', 'modules/featurecategories/views/img/menu_down.jpg');

        $('.' + filterCategory).each(function () {
            $(this).slideUp(0);
        });
    }

    else {
        $('.img_' + filterCategory).attr('src', 'modules/featurecategories/views/img/menu_up.jpg');
        $('.' + filterCategory).each(function () {
            $(this).slideDown(0);
        });
    }
}