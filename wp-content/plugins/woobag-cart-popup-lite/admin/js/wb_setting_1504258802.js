(function($, window) {$(document).on('click','.add_to_cart_button',function() {if ($('#wb_all_content_in_footer .wb_display_widget_cart').length) {$.wb_show_woo_bag();
        };
        });
        $.wb_show_woo_bag = function () {$("#wb_all_content_in_footer .wb_display_widget_cart").css("top", "initial");
                $("#wb_all_content_in_footer .wb_display_widget_cart").css("bottom", "initial");
                $("#wb_all_content_in_footer .wb_display_widget_cart").css("lrft", "initial");
                $("#wb_all_content_in_footer .wb_display_widget_cart").css("right", "initial");$("#wb_all_content_in_footer .wb_display_widget_cart").fadeIn(500);$("#wb_all_content_in_footer .wb_display_widget_cart").wb_bag_position("");var menu = $("#wb_all_content_in_footer .wb_display_widget_cart").show();
        var pos = $.PositionCalculator({
            target: ".wb_show_bag",
            targetAt: "bottom center",
            item: menu,
            itemAt: "top left",
            flip: "both"
        }).calculate();
        menu.css({
            top: parseInt(menu.css("top")) + pos.moveBy.y + "px",
            left: parseInt(menu.css("left")) + pos.moveBy.x + "px"
        });};function wb_small_screen_option() {
            if ($(window).width() < 400) {
                $('#wb_all_content_in_footer').html('');
            }
    }
    wb_small_screen_option();
    $(window).on('resize', function () {
        wb_small_screen_option();
    }); })(jQuery, window, document);function wb_scrolling_option(){jQuery('.wb_all_product_wrapper').mCustomScrollbar({
            theme: 'minimal-dark',
            mouseWheelPixels: 100
        });}
            function wb_remove_conform(wb_product_link) {
                jQuery.confirm({
                    title: "Confirmation  Required",
                    text: "Are you sure you want to remove product from WooBag!", confirm: function (button) {
                        wb_remove_product(wb_product_link, "");
                    },
                    cancel: function (button) {
                        // nothing to do
                    },
                    confirmButton: "Yes I am",
                    cancelButton: "No",
                    post: true,
                    confirmButtonClass: "btn-danger",
                    cancelButtonClass: "btn-default",
                    zIndex: 99999
               });
           }