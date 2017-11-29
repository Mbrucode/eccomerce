(function ($, window, document, undefined) {

    /*
     * When click on 'Add To Cart' Button
     */
    $(document).on('click', '.add_to_cart_button', function () {
        var product_link = $(this).attr('href');
        $(document).wb_get_full_bag(product_link);
    });

    /**
     * Add To Cart Function
     * 
     * @param {string} product_link
     * @returns {void}
     */

    $.fn.wb_get_full_bag = function (product_link) {
        wb_spinner_show();
        setTimeout(function () {
            $.post(wb_ajax_url.ajaxurl, {
                action: "wb_get_cart_data",
                data: {
                    product_link: product_link,
                    type: "POST",
                    dataType: "json"
                },
            }).done(function (success) {
                var obj = jQuery.parseJSON(success);
                $('.wb_display_widget_cart .product_list_widget').html(obj.product_data);

                wb_scrolling_option();
                wb_disable_button();
                $.wb_last_product();
            }).fail(function (error) {
                wb_spinner_hide();
                $(document).wb_message_show('Error Found. Try Again');
            });
        }, 3000);
    };

    /**
     * Styling on last product
     **/
    $.wb_last_product();

    /**
     * Diableable scrolling button when reaching to top or bottom
     **/
    wb_disable_button();

    /**
     * Call to scrill
     **/
    wb_scrolling_option();

    wb_top_text();


    /**
     * Single Product Add To Cart
     */
    $(document).on('submit', 'form.cart', function () {
        wb_set_cookie('wb_add_to_cart', 'yes', 5, "/");
        wb_set_cookie('wb_add_to_cart', 'yes', 5, "/");
    });
    var wb_add_to_cart = getCookie('wb_add_to_cart');
    if (wb_add_to_cart === 'yes') {
        $.wb_show_woo_bag();
        wb_set_cookie('wb_add_to_cart', 'yes', -1, "/");
    }




    $(document).on('click', '.wb_empty_cart_button', function (e) {
        e.preventDefault();
        $.wb_empty_cart_products();
    });

    /**
     *  Show/Hide remove button on single product hover
     *  
     * @param {string} wb_product
     */
    $(document).on('mouseover mouseleave', '.wb_cart_single_product', function (e) {
        if (e.type == "mouseover") {
            $(this).children().find('.wb_remove_product').show();
        } else {
            $(this).children().find('.wb_remove_product').hide();
        }
    });

    $(document).on('click', '.wb_loading_image,.wb_window_top .wb_close_window', function (e) {
        e.preventDefault();
        $('.wb_loading_image').hide();
        $('#wb_all_content_in_footer .wb_display_widget_cart').hide();
    });

    $(document).keyup(function (e) {
        if (e.keyCode == 27) { // escape key maps to keycode `27`
            $('.wb_loading_image').hide();
            $('#wb_all_content_in_footer .wb_display_widget_cart').hide();
        }
    });


})(jQuery, window, document);
