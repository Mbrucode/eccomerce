/**
 * Set Header for single and multiple product
 */
function wb_top_text() {
    var total_count = jQuery('.wb_count_product').html();
    if (total_count > 1) {
        jQuery('.wb_single_multiple_top_text').show();
        jQuery('.wb_single_product_top_text').hide();
    } else {
        jQuery('.wb_single_multiple_top_text').hide();
        jQuery('.wb_single_product_top_text').show();
    }
}

function wb_hide_icon_empty() {
    var wb_total_count = jQuery('.wb_count_product').html();
    if (wb_total_count < 1) {
        jQuery('.wb_show_bag').hide();
    } else {
        jQuery('.wb_show_bag').show();
    }
}

/**
 * Set Icon Text
 * 
 * @returns {void}
 */
function wb_icon_text() {

}

/**
 * Remove Product From WooBag
 * 
 * @param {string} wb_current_element
 * @param {string} wb_call_option
 */
function wb_remove_product(wb_current_element, wb_call_option) {
    wb_call_option = wb_call_option || "";
    wb_spinner_show();
    var wb_remove_url = jQuery('#' + wb_current_element + ' .wb_remove_product span').attr('id');
    jQuery.ajax({
        type: "POST",
        url: wb_remove_url,
        success: function () {
            jQuery.post(wb_ajax_url.ajaxurl, {
                action: "wb_get_cart_data_on_delete",
                data: {
                    type: "POST",
                    dataType: "json"
                },
            }).done(function (success) {
                var obj = jQuery.parseJSON(success);

                jQuery('.wb_display_widget_cart .product_list_widget').html(obj.product_data);
                wb_scrolling_option();
                wb_disable_button();
                jQuery.wb_last_product();
                wb_icon_text();
            }).fail(function (error) {
                wb_spinner_hide();
                jQuery(document).wb_message_show('Error Found. Try Again');
            });
        },
        error: function () {
            wb_spinner_hide();
            $(document).wb_message_show('Error Found. Try Again');
            wb_message_hide();
        }
    });
}


/**
 * Show Spinner
 */
function wb_spinner_show() {
    jQuery('.wb_loading_image').fadeIn(300);
    jQuery('.wb_display_loading_image').fadeIn(300);
    jQuery('.wb_display_loading_image i').css("position", "absolute");
    jQuery('.wb_display_loading_image i').css("top", Math.max(0, ((jQuery('.wb_cart_front_end_wrapper').height() - jQuery('.wb_display_loading_image i').outerHeight()) / 2) +
            jQuery('.wb_cart_front_end_wrapper').scrollTop()) + "px");
    jQuery('.wb_display_loading_image i').css("left", Math.max(0, ((jQuery('.wb_cart_front_end_wrapper').width() - jQuery('.wb_display_loading_image i').outerWidth()) / 2) +
            jQuery('.wb_cart_front_end_wrapper').scrollLeft()) + "px");
}
/**
 * Hide spinner
 */
function wb_spinner_hide() {
    jQuery('.wb_loading_image').fadeOut(300);
    jQuery('.wb_display_loading_image').fadeOut(300);
}


/*
 * Hide message after 5 Second
 */
function wb_message_hide() {
    setTimeout(function () {
        jQuery('.wb_cart_front_end_wrapper .wb_message_wrapper').hide();
        jQuery('.wb_cart_front_end_wrapper .wb_message').hide();
    }, 5000);
}

/**
 * Enable/Disable Scrolling Button
 */
function wb_disable_button() {
    jQuery('.bag_carousel_prev').addClass('wb_disable_button');
    jQuery('.wb_all_product_wrapper').scroll(function () {
        var wb_nex_button = jQuery(this).closest('tbody').children().find('.bag_carousel_next');
        var wb_prev_button = jQuery(this).closest('tbody').children().find('.bag_carousel_prev');
        var y = jQuery(this).scrollTop();
        if (y <= 5) {
            jQuery(wb_prev_button).addClass('wb_disable_button');
        } else {
            jQuery(wb_prev_button).removeClass('wb_disable_button');
        }
        if (jQuery(this).scrollTop() == jQuery(this)[0].scrollHeight - jQuery(this).height()) {
            jQuery(wb_nex_button).addClass('wb_disable_button');
        } else {
            jQuery(wb_nex_button).removeClass('wb_disable_button');
        }
    });
}


/**
 * Set Cookie
 * 
 * @type String
 */
function wb_set_cookie(wb_cookie_name, wb_cookie_value, exdays, wb_path) {
    var d = new Date();
    var wb_set_path;
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toGMTString();
    if (typeof wb_path !== 'undefined') {
        wb_set_path = '; path=' + wb_path;
    } else {
        wb_set_path = '';
    }

    document.cookie = wb_cookie_name + "=" + wb_cookie_value + "; " + expires + wb_set_path;
}

/**
 * Get Cookie Value
 * 
 * @param String cname
 * @returns Integer
 */
function getCookie(wb_cookie_name) {
    var name = wb_cookie_name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++)
    {
        var c = ca[i].trim();
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

/**
 * Delete Cookie
 * 
 * @param {string} name
 * @returns {void}
 */
function wb_delete_cookie(name) {
    createCookie(name, "", -1);
}


(function ($) {

    /**
     * Show Message
     * @returns {void}
     */
    $.fn.wb_message_show = function (message) {
        $('.wb_cart_front_end_wrapper .wb_message_wrapper').show();
        $('.wb_cart_front_end_wrapper .wb_message').show();
        $('.wb_cart_front_end_wrapper .wb_message').css("position", "absolute");
        $('.wb_cart_front_end_wrapper .wb_message').css("top", Math.max(0, (($('.wb_cart_front_end_wrapper').height() - $('.wb_cart_front_end_wrapper .wb_message').outerHeight()) / 2) +
                $('.wb_cart_front_end_wrapper').scrollTop()) - 20 + "px");
        $('.wb_cart_front_end_wrapper .wb_message').css("left", Math.max(0, (($('.wb_cart_front_end_wrapper').width() - $('.wb_cart_front_end_wrapper .wb_message').outerWidth()) / 2) +
                $('.wb_cart_front_end_wrapper').scrollLeft()) + "px");
        $('.wb_cart_front_end_wrapper .wb_message').html(message);
    };



    $.fn.wb_bag_position = function (wb_option) {
        this.css("position", "absolute");
        this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) +
                $(window).scrollTop()) + "px");
        if (wb_option === 'left') {
            this.css("left", "3%");
        } else if (wb_option === 'right') {
            this.css("right", '3%');
        } else {
            this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) +
                    $(window).scrollLeft()) + "px");
        }
        return this;
    };

    

    /**
     * Remove All Products from Cart
     * 
     * @returns {void}
     */
    $.wb_empty_cart_products = function () {
        wb_set_cookie('wb_end_time', '', -5, "/");
        var total_count = $('.wb_count_product').html();
        var product_list_widget = $('.wb_display_widget_cart .product_list_widget').attr('id');
        if (total_count > 0 && product_list_widget == 'wb_cart_front_end_wrapper') {
            wb_spinner_show();

            $.post(wb_ajax_url.ajaxurl, {
                action: "wb_clear_cart",
                type: "post"
            }).done(function (success) {
                var obj = $.parseJSON(success);
                $('.wb_display_widget_cart .product_list_widget').html(obj.product_data);
                wb_scrolling_option();
                wb_disable_button();
                $.wb_last_product();
            }).fail(function (error) {
                wb_spinner_hide();
                $(document).wb_message_show('Error Found. Try Again');
            });
        }
    };

    /*
     * Styling Of last Product
     */
    $.wb_last_product = function () {
        jQuery('.wb_cart_single_product:last').attr('style', 'border-bottom: none !important');
    };

})(jQuery, window, document);