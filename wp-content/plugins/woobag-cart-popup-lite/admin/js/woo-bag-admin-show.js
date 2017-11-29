(function ($) {
    /** General Setting Start*/
    var wb_general_setting = 'wb_setting_general_setting_';


    $('#' + wb_general_setting + 'wb_bg_option').on('change', function () {
        var wb_value = $(this).val();
        var wb_dev = $('.wb_display_widget_backend .wb_display_widget_cart');
        var wb_get_image, wb_get_color;
        if (wb_value === 'color') {
            wb_get_color = $('#' + wb_general_setting + 'wb_bg_color').val();
            wb_dev.style('background-image', 'none', 'important');
            wb_dev.style('background-color', wb_get_color, 'important');
        } else if (wb_value === 'image') {
            wb_get_image = $('#' + wb_general_setting + 'wb_bg_image').val();
            wb_dev.style("background-image", "url(" + wb_get_image + ")", 'important');
            wb_dev.style("background-color", "transparent", 'important');
        } else {
            wb_get_image = $('#' + wb_general_setting + 'wb_bg_image').val();
            wb_get_color = $('#' + wb_general_setting + 'wb_bg_color').val();
            if (wb_get_image !== '#') {
                wb_dev.style("background-image", "url(" + wb_get_image + ")", 'important');
            }
            wb_dev.style("background-color", wb_get_color, 'important');
        }
        var wb_repeat = $('input:radio[class=wb_bg_image_repeat]:checked').val();
        wb_dev.style("background-repeat", wb_repeat, "important");
    });


    $('#' + wb_general_setting + 'wb_close_bag').on('change', function () {
        var wb_value = $(this).val();
        var wb_dev = $('.wb_window_top .wb_close_window');
        if (wb_value === 'click') {
            wb_dev.show();
        } else {
            wb_dev.hide();
        }

    });
    var wb_admin_loader;
    $('#' + wb_general_setting + 'woobag_loader_icon').on('change', function () {
        var wb_value = $(this).val();
        $(document).wb_show_loader_admin_side();
        var wb_class = $('.wb_display_loading_image i').attr('class');
        $('.wb_display_loading_image i ').removeClass(wb_class);
        $('.wb_display_loading_image i ').addClass(wb_value);
        $(document).wb_hide_loader_admin_side();
    });

    $('#' + wb_general_setting + 'woobag_loader_icon_size').on('input change paste keyup', function () {
        var wb_value = $(this).val();
        $(document).wb_show_loader_admin_side();
        var wb_dev = $('.wb_display_loading_image i');
        wb_dev.style('font-size', wb_value + 'px', 'important');
        $(document).wb_hide_loader_admin_side();
    });

    $('#' + wb_general_setting + 'woobag_loader_icon_color').on('input change paste keyup', function () {
        var wb_value = $(this).css('backgroundColor');
        var wb_dev = $('.wb_display_loading_image i');
        $(document).wb_show_loader_admin_side();
        wb_dev.style('color', wb_value, 'important');
        $(document).wb_hide_loader_admin_side();
    });
    $('#' + wb_general_setting + 'woobag_loader_icon_color_cp').on('click', function () {
        var wb_value = $('#' + wb_general_setting + 'woobag_loader_icon_color').css('backgroundColor');
        var wb_dev = $('.wb_display_loading_image i');
        $(document).wb_show_loader_admin_side();
        wb_dev.style('color', wb_value, 'important');
        $(document).wb_hide_loader_admin_side();
    });

    $.fn.wb_show_loader_admin_side = function () {
        clearTimeout(wb_admin_loader);
        $(".wb_loading_image").show();
        $('.wb_display_loading_image').css("position", "absolute");
        $('.wb_display_loading_image').css("top", Math.max(0, (($('#wb_cart_back_end_wrapper').height() - $('.wb_display_loading_image').outerHeight()) / 2) +
                $('#wb_cart_back_end_wrapper').scrollTop()) + "px");
        $('.wb_display_loading_image').css("left", Math.max(0, (($('#wb_cart_back_end_wrapper').width() - $('.wb_display_loading_image').outerWidth()) / 2) +
                $('#wb_cart_back_end_wrapper').scrollLeft()) + "px");

    };
    $.fn.wb_hide_loader_admin_side = function () {
        wb_admin_loader = setTimeout(function () {
            $(".wb_loading_image").hide();
        }, 10000);
    };

    $('#' + wb_general_setting + 'wb_opacity').on('change', function () {
        var wb_value = $(this).val();
        $('.wb_display_widget_backend').style('opacity', wb_value, 'important');
        $('.wb_display_widget_backend .wb_display_widget_cart').style('opacity', wb_value, 'important');

    });

    /**
     * Header Setting 
     */
    $('input:radio[class=show_header_text]').on('change', function () {
        if (this.value === 'yes') {
            $('.wb_window_top').show();
        }
        else if (this.value === 'no') {
            $('.wb_window_top').hide();
        }
    });


    $('#wb_setting_header_setting_wb_header_bg_option').on('change', function () {
        var wb_value = $(this).val();
        var wb_dev = $('.wb_display_widget_backend .wb_window_top');
        var wb_get_image, wb_get_color;
        wb_get_color = $('#wb_setting_header_setting_wb_header_bg_color').val();
        wb_get_image = $('#wb_setting_header_setting_wb_header_bg_image').val();
        if (wb_value === 'color') {
            wb_dev.style('background-image', 'none', 'important');
            wb_dev.style('background-color', wb_get_color, 'important');
        } else if (wb_value === 'image') {
            wb_dev.style('background-color', 'transparent', 'important');
            if (wb_get_image !== '#') {
                wb_dev.style("background-image", "url(" + wb_get_image + ")", 'important');
            }
        } else if (wb_value === 'both') {
            if (wb_get_image !== '#') {
                wb_dev.style("background-image", "url(" + wb_get_image + ")", 'important');
            }
            wb_dev.style('background-color', wb_get_color, 'important');
        } else {
            wb_dev.style("background-image", "none", 'important');
            wb_dev.style("background-color", "transparent", 'important');
        }
        var wb_repeat = $('input:radio[class=wb_header_bg_image_repeat]:checked').val();
        wb_dev.style("background-repeat", wb_repeat, "important");
    });


    $('input:radio[class=show_count]').on('change', function () {
        if (this.value === 'yes') {
            $('.wb_top_text b').show();
        }
        else if (this.value === 'no') {
            $('.wb_top_text b').hide();
        }
    });

    $('input:radio[class=show_close_window_button]').on('change', function () {
        if (this.value === 'no') {
            $('.wb_close_window').hide();
        }
        else if (this.value === 'yes') {
            $('.wb_close_window').show();
        }
    });

    $('#wb_setting_header_setting_wb_close_bag_icon').on('change', function () {
        var wb_value = $(this).val();
        var wb_class = $('.wb_close_window i').attr('class');
        $('.wb_close_window i ').removeClass(wb_class);
        $('.wb_close_window i ').addClass(wb_value);
    });

    $('input:radio[class=wb_header_border_bottom]').on('change', function () {
        if (this.value === 'no') {
            $('.wb_display_widget_backend .wb_window_top').style('border-bottom', 'none', 'important');
        }
        else if (this.value === 'yes') {
            var wb_border_style, wb_border_width, wb_border_color;
            wb_border_style = $('#wb_setting_header_setting_wb_header_border_option').val();
            wb_border_width = $('#wb_setting_header_setting_wb_header_border_width').val();
            wb_border_color = $('#wb_setting_header_setting_wb_header_seprator_color').val();
            $('.wb_display_widget_backend .wb_window_top').style('border-bottom-style', wb_border_style, 'important');
            $('.wb_display_widget_backend .wb_window_top').style('border-bottom-width', wb_border_width + 'px', 'important');
            $('.wb_display_widget_backend .wb_window_top').style('border-bottom-color', wb_border_color, 'important');
        }
    });

    /**
     * Item Area Setting    
     */

    $('#wb_setting_product_setting_wb_item_padding_left_right').on('input change paste keyup', function () {
        var wb_value = $(this).val();
        if (wb_value === '') {
            wb_value = '8';
        }
        var wb_dev = $('.product_list_widget .wb_all_product_wrapper');
        wb_dev.style('padding-left', wb_value + 'px', 'important');
        wb_dev.style('padding-right', wb_value + 'px', 'important');
    });

    $('input:radio[class=wb_item_seprator_show]').on('change', function () {
        var wb_value = $(this).val();
        if (wb_value === 'no') {
            $('.wb_cart_single_product').each(function () {
                $(this).style('border-bottom', 'none', 'important');
            });
        }
        else if (wb_value === 'yes') {
            var wb_seprator_style = $('#wb_setting_product_setting_wb_border_option').val();
            var wb_seprator_width = $('#wb_setting_product_setting_wb_border_width').val();
            var wb_seprator_color = $('#wb_setting_product_setting_wb_seprator_color').val();
            $('.wb_cart_single_product').each(function () {
                $(this).style('border-bottom-style', wb_seprator_style, 'important');
                $(this).style('border-bottom-color', wb_seprator_color, 'important');
                $(this).style('border-bottom-width', wb_seprator_width + 'px', 'important');
            });
        }
        $(".woobagcontainer .wb_cart_single_product").last().style("border-bottom", "none", 'important');
    });

    $('#wb_setting_product_setting_wb_border_width').on('input change paste keyup', function () {
        var wb_value = $(this).val();
        $('.wb_cart_single_product').each(function () {
            $(this).style('border-bottom-width', wb_value + 'px', 'important');
        });
        $(".woobagcontainer .wb_cart_single_product").last().style("border-bottom", "none", 'important');
    });

    $('#wb_setting_product_setting_wb_border_option').on('input change paste keyup', function () {
        var wb_value = $(this).val();
        $('.wb_cart_single_product').each(function () {
            $(this).style('border-bottom-style', wb_value, 'important');
        });
        $(".woobagcontainer .wb_cart_single_product").last().style("border-bottom", "none", 'important');
    });

    $('#wb_setting_product_setting_wb_show_product_no').on('change', function () {
        var wb_value = $(this).val();
        var wb_scroll_option = $('#wb_setting_scroll_setting_wb_scroll_option').val();
        var wb_scroll_color = $('#wb_setting_scroll_setting_wb_scroll_wheel_color').val();
        $('.wb_all_product_wrapper').mCustomScrollbar("destroy");
        if (wb_value !== 'unlimited') {
            var wb_height = $('#wb_setting_product_setting_wb_single_product_height').val();
            $('.woobagcontainer .wb_all_product_wrapper').style('max-height', wb_height * wb_value + 'px', 'important');
            $('.wb_cart_single_product').each(function () {
                $(this).style('height', wb_height + 'px', 'important');
            });
            if (wb_value == 3) {
                if (wb_scroll_option === 'button') {
                    $('.wb_display_widget_backend .wb_scroll_button').each(function () {
                        $(this).style('display', 'none', 'important');
                    });
                } else {
                    $('.wb_all_product_wrapper').mCustomScrollbar("destroy");
                }
            } else {
                if (wb_scroll_option === 'button') {
                    $('.wb_display_widget_backend .wb_scroll_button').each(function () {
                        $(this).style('display', 'inline-block', 'important');
                    });
                } else {
                    $('.wb_all_product_wrapper').mCustomScrollbar({
                        theme: 'minimal-dark',
                        mouseWheelPixels: 100
                    });
                    $('.mCS-minimal-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar').style('background-color', wb_scroll_color, 'important');
                }
            }

        } else {
            $('.woobagcontainer .wb_all_product_wrapper').style('height', '338px', 'important');
            $('.woobagcontainer .wb_all_product_wrapper').style('max-height', '338px', 'important');
            $('.wb_cart_single_product').each(function () {
                $(this).style('height', 'inherit', 'important');
            });
            if (wb_scroll_option === 'button') {
                $('.wb_display_widget_backend .wb_scroll_button').each(function () {
                    $(this).style('display', 'inline-block', 'important');
                });
            } else {
                $('.wb_all_product_wrapper').mCustomScrollbar({
                    theme: 'minimal-dark',
                    mouseWheelPixels: 100
                });
                $('.mCS-minimal-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar').style('background-color', wb_scroll_color, 'important');
            }
        }
    });

    $('#wb_setting_product_setting_wb_single_product_height').on('input change paste keyup', function () {
        var wb_value = $(this).val();
        var height = $('#wb_setting_product_setting_wb_show_product_no').val();
        $('.wb_cart_single_product').each(function () {
            $(this).style('height', wb_value + 'px', 'important');
        });
        $('.woobagcontainer .wb_all_product_wrapper').style('max-height', height * wb_value + 'px', 'important');
    });

    $('input:radio[class=show_product_quantity]').on('change', function () {
        if (this.value == 'no') {
            $('.wb_product_detail .quantity').each(function () {
                $(this).hide();
            });
        }
        else if (this.value == 'yes') {
            $('.wb_product_detail .quantity').each(function () {
                $(this).show();
            });
        }
    });

    $('#wb_setting_product_setting_show_product_price').on('change', function () {
        var wb_value = $(this).val();
        if (wb_value === 'no') {
            $('.wb_product_detail .price').each(function () {
                $(this).hide();
            });
        }
        else if (wb_value === 'only_price') {
            $('.wb_product_detail .price').each(function () {
                $(this).show();
            });
            $('.wb_product_detail .price .wb_product_amount').each(function () {
                $(this).show();
            });
            $('.wb_product_detail .price .wb_product_reqular_amount').each(function () {
                $(this).hide();
            });
        } else {
            $('.wb_product_detail .price').each(function () {
                $(this).show();
            });
            $('.wb_product_detail .price .wb_product_amount').each(function () {
                $(this).show();
            });
            $('.wb_product_detail .price .wb_product_reqular_amount').each(function () {
                $(this).show();
            });
        }
    });

    $('input:radio[class=show_product_saving]').on('change', function () {
        if (this.value === 'no') {
            $('.wb_product_detail .wb_saving_percentage').each(function () {
                $(this).hide();
            });
        }
        else if (this.value === 'yes') {
            $('.wb_product_detail .wb_saving_percentage').each(function () {
                $(this).show();
            });
        }
    });

    $('input:radio[class=show_tax_per_item]').on('change', function () {
        if (this.value === 'no') {
            $('.wb_product_detail .wb_tax_per_item').each(function () {
                $(this).hide();
            });
        }
        else if (this.value === 'yes') {
            $('.wb_product_detail .wb_tax_per_item').each(function () {
                $(this).show();
            });
        }
    });

    $('input:radio[class=show_product_image]').on('change', function () {
        if (this.value === 'no') {
            $('.wb_product_thumbnail').each(function () {
                $(this).hide();
            });
        }
        else if (this.value === 'yes') {
            $('.wb_product_thumbnail').each(function () {
                $(this).show();
            });
        }
    });

    $('#wb_setting_product_setting_wb_product_image_width').on('input change paste keyup', function () {
        var wb_image_width = $(this).val();
        var wb_content_width = $('#wb_setting_product_setting_wb_content_width').val();
        var total_width = +wb_image_width + +wb_content_width;
        if (total_width > 90) {
            wb_content_width = 90 - wb_image_width;
        }
        if (wb_image_width < 0) {
            wb_image_width = 0;
            wb_content_width = 90;
        } else if (wb_image_width > 90) {
            wb_image_width = 90;
            wb_content_width = 0;
        } else {
            var wb_content_width = 90 - wb_image_width;
        }

        $(this).val(wb_image_width);
        $('#wb_setting_product_setting_wb_content_width').val(wb_content_width);
        $('.wb_product_thumbnail').each(function () {
            $(this).style('width', wb_image_width + '%', 'important');
        });
        $('.wb_product_detail').each(function () {
            $(this).style('width', wb_content_width + '%', 'important');
        });
    });

    $('#wb_setting_product_setting_wb_content_width').on('input change paste keyup', function () {
        var wb_content_width = $(this).val();
        var wb_image_width = $('#wb_setting_product_setting_wb_product_image_width').val();
        var total_width = +wb_image_width + +wb_content_width;
        if (total_width > 90) {
            wb_image_width = 90 - wb_content_width;
        }
        if (wb_content_width < 0) {
            wb_content_width = 0;
            wb_image_width = 90;
        } else if (wb_content_width > 90) {
            wb_content_width = 90;
            wb_image_width = 0;
        } else {
            var wb_image_width = 90 - wb_content_width;
        }
        $(this).val(wb_content_width);
        $('#wb_setting_product_setting_wb_product_image_width').val(wb_image_width);
        $('.wb_product_thumbnail').each(function () {
            $(this).style('width', wb_image_width + '%', 'important');
        });
        $('.wb_product_detail').each(function () {
            $(this).style('width', wb_content_width + '%', 'important');
        });
    });

    $('#wb_setting_product_setting_wb_remove_button_icon').on('change', function () {
        var wb_value = $(this).val();
        $('.wb_remove_product').show();
        var wb_class = $('.wb_remove_product span i').attr('class');
        $('.wb_remove_product span i ').each(function () {
            $(this).removeClass(wb_class);
            $(this).addClass(wb_value);
        });
        setTimeout(function () {
            $(".wb_remove_product").hide();
        }, 10000);
    });

    $('input:radio[class=show_remove_button]').on('change', function () {
        var wb_icon_class = $('#wb_setting_product_setting_wb_remove_button_icon').val();
        var wb_remove_icon = '<i class="' + wb_icon_class + '"></a>';
        if (this.value === 'no') {
            if ($('.wb_remove_product span i').length) {
                $('.wb_remove_product span').each(function () {
                    $(this).html('');
                });
            }
            $('.wb_remove_product').hide();
        }
        else if (this.value === 'yes') {
            $('.wb_remove_product').show();
            if ($('.wb_remove_product span i').length === 0) {
                $('.wb_remove_product span').each(function () {
                    $(this).html(wb_remove_icon);
                });
            }
        }
    });
    $('input:radio[class=wb_remove_button_position]').on('change', function () {
        $('.wb_remove_product').show();
        setTimeout(function () {
            $(".wb_remove_product").hide();
        }, 10000);
    });


    /**
     * Subtotal Setting
     */

    $('#wb_setting_subtotal_setting_wb_subtotal_padding_left_right').on('input change paste keyup', function () {
        var wb_value = $(this).val();
        if (wb_value === '') {
            wb_value = '8';
        }
        var wb_dev = $('.product_list_widget .wb_cart_total_wrapper');
        wb_dev.style('padding-left', wb_value + 'px', 'important');
        wb_dev.style('padding-right', wb_value + 'px', 'important');
    });

    $('#wb_setting_subtotal_setting_show_subtotal').on('change', function () {
        var wb_value = $(this).val();

        if (wb_value === 'no') {
            $('.wb_cart_total_wrapper .total').hide();
            $('.wb_cart_total_wrapper').style('padding-top', '10px', 'important');
        }
        else if (wb_value === 'only_price') {
            $('.wb_cart_total_wrapper').style('padding-top', '0', 'important');
            $('.wb_cart_total_wrapper .total').show();
            $('.wb_cart_total_wrapper .total .wb_subtotal_only_price').show();
            $('.wb_cart_total_wrapper .total .wb_total_content_table').hide();
        }
        else if (wb_value === 'price_tax') {
            $('.wb_cart_total_wrapper').style('padding-top', '0', 'important');
            $('.wb_cart_total_wrapper .total').show();
            $('.wb_cart_total_wrapper .total .wb_subtotal_only_price').hide();
            $('.wb_cart_total_wrapper .total .wb_total_content_table').show();
        } else {
            $('.wb_cart_total_wrapper').style('padding-top', '0', 'important');
            $('.wb_cart_total_wrapper .total').show();
            $('.wb_cart_total_wrapper .total .wb_subtotal_only_price').show();
            $('.wb_cart_total_wrapper .total .wb_total_content_table').show();
        }
    });

    $('input:radio[class=show_subtotal]').on('change', function () {
        if (this.value === 'no') {
            $('.wb_cart_total_wrapper .total').hide();
        }
        else if (this.value === 'yes') {
            $('.wb_cart_total_wrapper .total').show();
        }
    });

    $('input:radio[class=wb_subtotal_border_top]').on('change', function () {
        var wb_dev = $('.wb_display_widget_backend .wb_cart_total_wrapper');
        if (this.value === 'no') {
            wb_dev.style('border-top', 'none', 'important');
        }
        else if (this.value === 'yes') {
            var wb_border_style, wb_border_width, wb_border_color;
            wb_border_style = $('#wb_setting_subtotal_setting_wb_subtotal_border_option').val();
            wb_border_width = $('#wb_setting_subtotal_setting_wb_subtotal_border_width').val();
            wb_border_color = $('#wb_setting_subtotal_setting_wb_subtotal_seprator_color').val();
            wb_dev.style('border-top', wb_border_width + 'px ' + wb_border_style + ' ' + wb_border_color, 'important');
        }
    });

    $('#wb_setting_subtotal_setting_wb_subtotal_border_option').on('change', function () {
        var wb_dev = $('.wb_display_widget_backend .wb_cart_total_wrapper');
        var wb_border_style, wb_border_width, wb_border_color;
        wb_border_style = $(this).val();
        wb_border_width = $('#wb_setting_subtotal_setting_wb_subtotal_border_width').val();
        wb_border_color = $('#wb_setting_subtotal_setting_wb_subtotal_seprator_color').val();
        wb_dev.style('border-top', wb_border_width + 'px ' + wb_border_style + ' ' + wb_border_color, 'important');
    });

    $('#wb_setting_subtotal_setting_wb_subtotal_border_width').on('input', function () {
        var wb_dev = $('.wb_display_widget_backend .wb_cart_total_wrapper');
        var wb_border_style, wb_border_width, wb_border_color;
        wb_border_style = $('#wb_setting_subtotal_setting_wb_subtotal_border_option').val();
        wb_border_width = $(this).val();
        wb_border_color = $('#wb_setting_subtotal_setting_wb_subtotal_seprator_color').val();
        wb_dev.style('border-top', wb_border_width + 'px ' + wb_border_style + ' ' + wb_border_color, 'important');

    });

    /**
     * Viewbag Button
     */

    $('input:radio[class=show_viewbag_button]').on('change', function () {
        if (this.value === 'no') {
            $('.wb_cart_total_wrapper .buttons .wb_viewbag_button').hide();
        }
        else if (this.value === 'yes') {
            $('.wb_cart_total_wrapper .buttons .wb_viewbag_button').style('display', 'inline-block');
            $('.wb_cart_total_wrapper .buttons').show();
        }
    });

    $('#wb_setting_subtotal_setting_wb_viewbag_button_bg_option').on('change', function () {
        var wb_value = $(this).val();
        var wb_dev = $('.wb_cart_total_wrapper .buttons .wb_viewbag_button');
        var wb_get_image, wb_get_color;
        wb_get_color = $('#wb_setting_subtotal_setting_wb_viewbag_button_bg_color').val();
        wb_get_image = $('#wb_setting_subtotal_setting_wb_viewbag_button_bg_image').val();
        if (wb_value === 'color') {
            wb_dev.style('background-image', 'none', 'important');
            wb_dev.style('background-color', wb_get_color, 'important');
        } else if (wb_value === 'image') {
            wb_dev.style('background-color', 'transparent', 'important');
            if (wb_get_image !== '#') {
                wb_dev.style("background-image", "url(" + wb_get_image + ")", 'important');
            }
        } else if (wb_value === 'both') {
            if (wb_get_image !== '#') {
                wb_dev.style("background-image", "url(" + wb_get_image + ")", 'important');
            }
            wb_dev.style('background-color', wb_get_color, 'important');
        } else {
            wb_dev.style("background-image", "none", 'important');
            wb_dev.style("background-color", "transparent", 'important');
        }
        var wb_repeat = $('input:radio[class=wb_viewbag_button_bg_image_repeat]:checked').val();
        wb_dev.style("background-repeat", wb_repeat, "important");
    });


    /**
     * Checkout Button
     */
    $('input:radio[class=show_checkout_button]').on('change', function () {
        if (this.value === 'no') {
            $('.wb_cart_total_wrapper .buttons .wb_checkout_button').hide();
        }
        else if (this.value === 'yes') {
            $('.wb_cart_total_wrapper .buttons .wb_checkout_button').style('display', 'inline-block');
            $('.wb_cart_total_wrapper .buttons').show();
        }
    });

    $('#wb_setting_subtotal_setting_wb_checkout_button_bg_option').on('change', function () {
        var wb_value = $(this).val();
        var wb_dev = $('.wb_cart_total_wrapper .buttons .wb_checkout_button');
        var wb_get_image, wb_get_color;
        wb_get_color = $('#wb_setting_subtotal_setting_wb_checkout_button_bg_color').val();
        wb_get_image = $('#wb_setting_subtotal_setting_wb_checkout_button_bg_image').val();
        if (wb_value === 'color') {
            wb_dev.style('background-image', 'none', 'important');
            wb_dev.style('background-color', wb_get_color, 'important');
        } else if (wb_value === 'image') {
            wb_dev.style('background-color', 'transparent', 'important');
            if (wb_get_image !== '#') {
                wb_dev.style("background-image", "url(" + wb_get_image + ")", 'important');
            }
        } else if (wb_value === 'both') {
            if (wb_get_image !== '#') {
                wb_dev.style("background-image", "url(" + wb_get_image + ")", 'important');
            }
            wb_dev.style('background-color', wb_get_color, 'important');
        } else {
            wb_dev.style("background-image", "none", 'important');
            wb_dev.style("background-color", "transparent", 'important');
        }
        var wb_repeat = $('input:radio[class=wb_checkout_button_bg_image_repeat]:checked').val();
        wb_dev.style("background-repeat", wb_repeat, "important");
    });

    /**
     * Empty Cart Button
     */
    $('input:radio[class=show_empty_cart_button]').on('change', function () {
        if (this.value === 'no') {
            $('.wb_cart_total_wrapper .buttons .wb_empty_cart_button').hide();
        }
        else if (this.value === 'yes') {
            $('.wb_cart_total_wrapper .buttons .wb_empty_cart_button').style('display', 'inline-block');
            $('.wb_cart_total_wrapper .buttons').show();
        }
    });

    $('#wb_setting_subtotal_setting_wb_empty_cart_button_bg_option').on('change', function () {
        var wb_value = $(this).val();
        var wb_dev = $('.wb_cart_total_wrapper .buttons .wb_empty_cart_button');
        var wb_get_image, wb_get_color;
        wb_get_color = $('#wb_setting_subtotal_setting_wb_empty_cart_button_bg_color').val();
        wb_get_image = $('#wb_setting_subtotal_setting_wb_empty_cart_button_bg_image').val();
        if (wb_value === 'color') {
            wb_dev.style('background-image', 'none', 'important');
            wb_dev.style('background-color', wb_get_color, 'important');
        } else if (wb_value === 'image') {
            wb_dev.style('background-color', 'transparent', 'important');
            if (wb_get_image !== '#') {
                wb_dev.style("background-image", "url(" + wb_get_image + ")", 'important');
            }
        } else if (wb_value === 'both') {
            if (wb_get_image !== '#') {
                wb_dev.style("background-image", "url(" + wb_get_image + ")", 'important');
            }
            wb_dev.style('background-color', wb_get_color, 'important');
        } else {
            wb_dev.style("background-image", "none", 'important');
            wb_dev.style("background-color", "transparent", 'important');
        }
        var wb_repeat = $('input:radio[class=wb_empty_cart_button_bg_image_repeat]:checked').val();
        wb_dev.style("background-repeat", wb_repeat, "important");
    });

    /** Custom Button */
    $('input:radio[class=show_custom_button]').on('change', function () {
        if (this.value === 'no') {
            $('.wb_cart_total_wrapper .buttons .wb_custom_button').hide();
        }
        else if (this.value === 'yes') {
            $('.wb_cart_total_wrapper .buttons .wb_custom_button').style('display', 'inline-block');
            $('.wb_cart_total_wrapper .buttons').show();
        }
    });

    $('#wb_setting_subtotal_setting_wb_custom_button_bg_option').on('change', function () {
        var wb_value = $(this).val();
        var wb_dev = $('.wb_cart_total_wrapper .buttons .wb_custom_button');
        var wb_get_image, wb_get_color;
        wb_get_color = $('#wb_setting_subtotal_setting_wb_custom_button_bg_color').val();
        wb_get_image = $('#wb_setting_subtotal_setting_wb_custom_button_bg_image').val();
        if (wb_value === 'color') {
            wb_dev.style('background-image', 'none', 'important');
            wb_dev.style('background-color', wb_get_color, 'important');
        } else if (wb_value === 'image') {
            wb_dev.style('background-color', 'transparent', 'important');
            if (wb_get_image !== '#') {
                wb_dev.style("background-image", "url(" + wb_get_image + ")", 'important');
            }
        } else if (wb_value === 'both') {
            if (wb_get_image !== '#') {
                wb_dev.style("background-image", "url(" + wb_get_image + ")", 'important');
            }
            wb_dev.style('background-color', wb_get_color, 'important');
        } else {
            wb_dev.style("background-image", "none", 'important');
            wb_dev.style("background-color", "transparent", 'important');
        }
        var wb_repeat = $('input:radio[class=wb_custom_button_bg_image_repeat]:checked').val();
        wb_dev.style("background-repeat", wb_repeat, "important");
    });

    /**
     * Footer Settings
     */

    $('input:radio[class=wb_show_footer]').on('change', function () {
        if (this.value === 'no') {
            $('.wb_display_widget_backend .wb_window_bottom').hide();
        }
        else if (this.value === 'yes') {
            $('.wb_display_widget_backend .wb_window_bottom').show();
        }
    });

    var wb_footer_setting = 'wb_setting_footer_setting_';


    $('#' + wb_footer_setting + 'wb_footer_bg_option').on('change', function () {
        var wb_value = $(this).val();
        var wb_dev = $('.wb_display_widget_backend .wb_window_bottom');
        var wb_get_image, wb_get_color;
        wb_get_color = $('#' + wb_footer_setting + 'wb_footer_bg_color').val();
        wb_get_image = $('#' + wb_footer_setting + 'wb_footer_bg_image').val();
        if (wb_value === 'color') {
            wb_dev.style('background-image', 'none', 'important');
            wb_dev.style('background-color', wb_get_color, 'important');
        } else if (wb_value === 'image') {
            wb_dev.style('background-color', 'transparent', 'important');
            if (wb_get_image !== '#') {
                wb_dev.style("background-image", "url(" + wb_get_image + ")", 'important');
            }
        } else if (wb_value === 'both') {
            if (wb_get_image !== '#') {
                wb_dev.style("background-image", "url(" + wb_get_image + ")", 'important');
            }
            wb_dev.style('background-color', wb_get_color, 'important');
        } else {
            wb_dev.style("background-image", "none", 'important');
            wb_dev.style("background-color", "transparent", 'important');
        }
        var wb_repeat = $('input:radio[class=wb_footer_bg_image_repeat]:checked').val();
        wb_dev.style("background-repeat", wb_repeat, "important");
    });

    $('input:radio[class=wb_footer_border_top]').on('change', function () {
        if (this.value === 'no') {
            $('.wb_display_widget_backend .wb_window_bottom').style('border-top', 'none', 'important');
        }
        else if (this.value === 'yes') {
            var wb_border_style, wb_border_width, wb_border_color;
            wb_border_style = $('#wb_setting_footer_setting_wb_footer_border_option').val();
            wb_border_width = $('#wb_setting_footer_setting_wb_footer_border_width').val();
            wb_border_color = $('#wb_setting_footer_setting_wb_footer_seprator_color').val();
            $('.wb_display_widget_backend .wb_window_bottom').style('border-top-style', wb_border_style, 'important');
            $('.wb_display_widget_backend .wb_window_bottom').style('border-top-width', wb_border_width + 'px', 'important');
            $('.wb_display_widget_backend .wb_window_bottom').style('border-top-color', wb_border_color, 'important');
        }
    });

    /**
     * Scrolling Setting  
     */

    $('#wb_setting_scroll_setting_wb_scroll_option').on('change', function () {
        var wb_value = $(this).val();
        var wb_count_product = $('#wb_setting_product_setting_wb_show_product_no').val();
        var wb_scroll_color = $('#wb_setting_scroll_setting_wb_scroll_wheel_color').val();
        if (wb_value === 'button') {
            $('.wb_all_product_wrapper').mCustomScrollbar("destroy");
            if (wb_count_product != 3) {
                $('.wb_scroll_button_wrapper .wb_scroll_button').each(function () {
                    $(this).style('display', 'inline-block');
                });
            }
        }
        else if (wb_value === 'wheel') {
            if (wb_count_product != 3) {
                $('.wb_scroll_button_wrapper .wb_scroll_button').each(function () {
                    $(this).style('display', 'none');
                });
                $('.wb_all_product_wrapper').mCustomScrollbar({
                    theme: 'minimal-dark',
                    mouseWheelPixels: 100
                });
                $('.mCS-minimal-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar').style('background-color', wb_scroll_color, 'important');
            }
        }
    });

    $('#wb_setting_scroll_setting_wb_scroll_padding_left_right').on('input change paste keyup', function () {
        var wb_value = $(this).val();
        if (wb_value === '') {
            wb_value = '8';
        }
        var wb_dev = $('.product_list_widget .wb_scroll_button_wrapper');
        $(wb_dev).each(function () {
            $(this).style('padding-left', wb_value + 'px', 'important');
            $(this).style('padding-right', wb_value + 'px', 'important');
        });

    });

    $('#wb_setting_scroll_setting_wb_scroll_bg_option').on('input change paste keyup', function () {
        var wb_value = $(this).val();
        var wb_dev = $('.wb_scroll_button_wrapper .wb_scroll_button');
        var wb_get_image, wb_get_color, wb_repeat;
        wb_get_color = $('#wb_setting_scroll_setting_wb_scroll_bg_color').val();
        wb_get_image = $('#wb_setting_scroll_setting_wb_scroll_bg_image').val();
        wb_repeat = $('input:radio[class=wb_scroll_bg_image_repeat]:checked').val();
        if (wb_value === 'color') {
            wb_dev.each(function () {
                $(this).style("background-image", "transparent", 'important');
                $(this).style('background-color', wb_get_color, 'important');
            });
        } else if (wb_value === 'image') {
            wb_dev.each(function () {
                $(this).style("background-color", "transparent", 'important');
                if (wb_get_image !== '#') {
                    $(this).style("background-image", "url(" + wb_get_image + ")", 'important');
                }
            });
        } else if (wb_value === 'both') {
            if (wb_get_image !== '#') {
                wb_dev.each(function () {
                    $(this).style("background-image", "url(" + wb_get_image + ")", 'important');
                    $(this).style("background-color", wb_get_color, "important");
                });
            }
        } else {
            wb_dev.each(function () {
                $(this).style("background", "transparent", 'important');
            });
        }
        wb_dev.each(function () {
            $(this).style("background-repeat", wb_repeat, "important");
        });
    });


    $('.wb_hidden_field').each(function(){
        $(this).closest("tr").fadeOut(300);
    });

    /**
     * Onchange Text Field
     */
    $('input[wb_field_type=text]').on('input change paste keyup', function () {
        var wb_change_property_id = $(this).attr('wb_change_property_id');
        if (wb_change_property_id) {
            var wb_value = $(this).val();
            $(".wb_display_widget_backend " + wb_change_property_id).each(function () {
                $(this).html(wb_value);
            });
        }
    });

    /**
     * Onchange Number/Select field
     */
    $('input[wb_field_type=number],select[wb_field_type=select]').on('input change paste keyup', function () {
        var wb_change_property_id = $(this).attr('wb_change_property_id');
        var wb_change_property = $(this).attr('wb_change_property');
        var wb_help = $(this).attr('wb_help');
        if (wb_change_property_id) {
            var wb_value = $(this).val();
            $(".wb_display_widget_backend " + wb_change_property_id).each(function () {
                $(this).style(wb_change_property, wb_value + wb_help, "important");
            });
        }
    });

    /**
     * Onchange Radio field
     */
    $('input[wb_field_type=radio]').on('change', function () {
        var wb_change_property_id = $(this).attr('wb_change_property_id');
        var wb_change_property = $(this).attr('wb_change_property');
        if (wb_change_property_id) {
            var wb_value = $(this).val();
            $(".wb_display_widget_backend " + wb_change_property_id).each(function () {
                $(this).style(wb_change_property, wb_value, "important");
            });
        }
    });

    /**
     * Create Color picker on color field
     */
    $("input[wb_field_type=color]").each(function () {
        var wb_value = $(this).val();
        var wb_field_id = $(this).attr('wb_field_id');
        $(this).style("border-right-color", wb_value, "important");
        $("#" + wb_field_id).colpick({
            layout: "hex",
            submit: 0,
            color: wb_value,
            colorScheme: "dark",
            onChange: function (hsb, hex, rgb, el, bySetColor) {
                $(el).style("border-right-color", "#" + hex, "important");
                if (!bySetColor) {
                    $(el).val("#" + hex);
                }
                var wb_change_property_id = $(el).attr('wb_change_property_id');
                var wb_change_property = $(el).attr('wb_change_property');
                if (wb_change_property_id) {
                    var wb_value = $(el).val();
                    $(".wb_display_widget_backend " + wb_change_property_id).each(function () {
                        $(this).style(wb_change_property, wb_value, "important");
                    });
                }
            }
        }).keyup(function () {
            $(this).colpickSetColor(this.value);
        });
    });


    /**
     * Background Image Position
     */
    var wb_break_loop = 1;
    var wb_arrow_id, wb_value_x, wb_value_y, wb_image_arrow;
    $(".wb_image_position_wrapper i").on("mousedown mouseup mouseleave", function mouseState(e) {
        if (e.type == "mousedown") {
            wb_break_loop = 1;
            wb_arrow_id = $(this).attr("id");
            wb_image_arrow = $(this).attr("image_arrow");
            wb_value_x = $("#" + wb_arrow_id + "_x").val();
            var wb_change_property_id = $("#" + wb_arrow_id + "_x").attr('wb_change_property_id');
            wb_value_y = $("#" + wb_arrow_id + "_y").val();
            if (wb_value_x === "") {
                wb_value_x = 0;
            }
            if (wb_value_y === "") {
                wb_value_y = 0;
            }
            wb_animate(wb_change_property_id);
        } else {
            wb_break_loop = 0;
        }
    });
    function wb_animate(wb_change_property_id) {
        if (wb_image_arrow === "up") {
            wb_value_y = wb_value_y - 1;
        } else if (wb_image_arrow === "down") {
            wb_value_y = +wb_value_y + +1;
        } else if (wb_image_arrow === "left") {
            wb_value_x = +wb_value_x - +1;
        } else if (wb_image_arrow === "right") {
            wb_value_x = +wb_value_x + +1;
        } else {
            wb_value_x = 0;
            wb_value_y = 0;
        }
        $("#" + wb_arrow_id + "_x").val(wb_value_x);
        $("#" + wb_arrow_id + "_y").val(wb_value_y);
        if (wb_change_property_id) {
            $(".wb_display_widget_backend " + wb_change_property_id).each(function () {
                $(this).style("background-position", wb_value_x + "px " + wb_value_y + "px", "important");
            });
        }
        $("#wb_display_widget_backend " + wb_change_property_id).animate({
            'background-position': '(' + wb_value_x + 'px ' + wb_value_y + 'px)'
        }, 100, "linear", function () {
            if (wb_break_loop != 0) {
                wb_animate(wb_change_property_id);
            }
        });
    }

    /**
     * Image Upload
     */
    $("input[wb_field_type=wb_image_upload_button]").click(function () {
        var wb_field_id = $(this).attr("wb_field_id");
        var wb_change_property_id = $("#" + wb_field_id).attr("wb_change_property_id");
        tb_show("", "media-upload.php?post_id=0&amp;type=image&amp;TB_iframe=true");
        window.original_send_to_editor = window.send_to_editor;
        window.send_to_editor = function (html) {
            var imgurl = $("img", html).attr("src");
            $("#" + wb_field_id).val(imgurl);
            var wb_classes = $("#" + wb_field_id).attr("class").split(" ").pop();
            if (wb_classes === "form-control") {

            } else if (wb_classes === "wb_icon_show_wrapper") {
                var wb_user_img = "<img src=" + imgurl + ">";
                if ($(".wb_admin_menu_icon .wb_icon_in_menu .wb_menu_icon i").length) {
                    $(".wb_admin_menu_icon .wb_icon_in_menu .wb_menu_icon i").hide();
                }
                if ($(".wb_admin_menu_icon .wb_icon_in_menu .wb_menu_icon img").length) {
                    $(".wb_admin_menu_icon .wb_icon_in_menu .wb_menu_icon img").remove();
                }
                $(".wb_admin_menu_icon .wb_icon_in_menu .wb_menu_icon .wb_baloon_wrapper").before(wb_user_img);
            } else if (wb_classes === "woo_bag_mini_cart") {
                var wb_user_img = "<img src=" + imgurl + ">";
                if ($(".wb_admin_icon .woo_bag_mini_cart .wb_icon i").length) {
                    $(".wb_admin_icon .woo_bag_mini_cart .wb_icon i").hide();
                }
                if ($(".wb_admin_icon .woo_bag_mini_cart .wb_icon img").length) {
                    $(".wb_admin_icon .woo_bag_mini_cart .wb_icon img").remove();
                }
                $(".wb_admin_icon .woo_bag_mini_cart .wb_icon .wb_baloon_wrapper").before(wb_user_img);
            } else if (wb_classes === "no_product_image") {
                $(".wb_cart_empty img ").attr("src", imgurl);

            } else {
                $(".wb_display_widget_backend " + wb_change_property_id).each(function () {
                    $(this).style("background-image", "url(" + imgurl + ")", "important");
                });
            }
            tb_remove();
            window.send_to_editor = window.original_send_to_editor;
        };
        return false;
    });

})(jQuery);