(function ($) {

    var wb_ajax_url = wb_admin_ajax_url.wb_ajax;
    $('.accordion-toggle').on('click', function (event) {
        event.preventDefault();
        // create accordion variables
        var accordion = $(this);
        var accordionContent = accordion.next('.accordion-content');
        var accordionToggleIcon = $(this).children('.toggle-icon');
        // toggle accordion link open class
        accordion.toggleClass("open");
        // toggle accordion content
        accordionContent.slideToggle(350);
        // change plus/minus icon
        if (accordion.hasClass("open")) {
            accordionToggleIcon.html("<i class='fa fa-minus-circle'></i>");
        } else {
            accordionToggleIcon.html("<i class='fa fa-plus-circle'></i>");
        }
    });
    /**
     * Message And spinner
     */
    $.wb_spinner_show = function () {
        $(".wb_setting_spinner").wb_admin_message_position(-100, 0);
        $(".wb_setting_spinner_overlay").fadeIn(100);
        $(".wb_setting_message").hide();
        $(".wb_setting_spinner_wrapper").show();
        $(".wb_setting_spinner").show();
    };
    $.wb_spinner_hide = function () {
        $(".wb_setting_spinner").hide();
    };
    $.wb_message_show = function (message) {
        $(".wb_setting_message").show();
        $(".wb_setting_message").wb_admin_message_position(-100, -160);
        $(".wb_setting_message").html(message);
    };
    $.wb_message_hide = function () {
        setTimeout(function () {
            $(".wb_setting_spinner_overlay").hide();
            $(".wb_setting_spinner_wrapper").hide();
        }, 10000);
    };
    /**
     * 
     * @returns {woo-bag-admin_L1.$.fn}
     */
    $.fn.wb_admin_message_position = function (wb_top_value, wb_left_value) {
        this.css("position", "fixed");
        this.css("top", ($(window).height() / 2) - (this.outerHeight() / 2) + wb_top_value);
        this.css("left", ($(window).width() / 2) - (this.outerWidth() / 2) + wb_left_value);
        return this;
    };
   
    
    /**
     * Validate Height
     * 
     * @returns {Boolean}
     */
    wb_validate_height_field();
    function wb_validate_height_field() {
        var wb_selected_value = $(".wb_show_product_no :selected").val();
        var wb_return_value = '';
        if (wb_selected_value === "unlimited") {
        }
        else {
            if ($(".wb_single_product_height").val() === '') {
                wb_return_value = true;
            }
        }
        $(".wb_show_product_no").on('change', function () {
            var wb_selected_value = $(".wb_show_product_no :selected").val();
            if (wb_selected_value === "unlimited") {
            }
            else {
                if ($(".wb_single_product_height").val() === '') {
                    wb_return_value = true;
                }
            }
        });
        return wb_return_value;
    }


   

    /**
     * Active Template confirmation. When click on Preview This change.
     */
    $('.wb_front_preview_template').click(function (e) {
        e.preventDefault();
        $.confirm({
            text: "Are you sure you want to Save these Settings?",
            title: "Confirmation required",
            confirm: function (button) {
                $.wb_update_template('preview');
            },
            cancel: function (button) {
                // nothing to do
            },
            confirmButton: "Yes I am",
            cancelButton: "No",
            post: true,
            confirmButtonClass: "btn-danger",
            cancelButtonClass: "btn-default"
        });
    });
    /**
     * When Click on Save Changes
     */
    $('.woo_bag_submit_button').on('click', function (e) {
        e.preventDefault();
        var wb_button_id = $(this).attr('id');
        $.wb_update_template(wb_button_id);
    });
    /**
     * Update Template
     */
    $.wb_update_template = function (wb_button_id) {
        $.wb_spinner_show();
        var wb_validation = wb_validate_height_field();
        if (wb_validation === true) {
            $(".wb_single_product_height").css('border', '1px solid red');
            $.wb_spinner_hide();
            $.wb_message_show('<div class="wb_setting_error">All fields are required.</div>');
            $.wb_message_hide();
        } else {
            var wb_data = $('#wb_setting_form').serializeArray();
            $.ajax({
                type: 'post',
                url: 'options.php',
                data: wb_data,
                success: function (success) {
                    $.post(wb_ajax_url, {
                        type: "post",
                        action: "wb_update_template",
                        data: {
                            form_data: wb_button_id,
                        }
                    }).done(function (success) {
                        $.wb_spinner_hide();
                        var obj = jQuery.parseJSON(success);
                        if (obj.status === 'success') {
                            $.wb_message_show('<div class="wb_setting_success">' + obj.message + '</div>');
                        } else {
                            $.wb_message_show('<div class="wb_setting_error">' + obj.message + '</div>');
                        }
                        if ($(document).wb_get_ie_version() > 0) {
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        } else {
                            location.reload();
                        }
                    }).fail(function (error) {
                        $.wb_spinner_hide();
                        $.wb_message_show('<div class="wb_setting_error">Error Occured! Please try again</div>');
                        $.wb_message_hide();
                        location.reload();
                    });
                },
                error: function (error_reporting) {
                    $.wb_spinner_hide();
                    $.wb_message_show('<div class="wb_setting_error">Error Occured! Please try again</div>');
                    $.wb_message_hide();
                    location.reload();
                }
            });
        }

    };
    $.fn.wb_get_ie_version = function () {
        var sAgent = window.navigator.userAgent;
        var Idx = sAgent.indexOf("MSIE");
        // If IE, return version number.
        if (Idx > 0) {
            return parseInt(sAgent.substring(Idx + 5, sAgent.indexOf(".", Idx)));
        }
        // If IE 11 then look for Updated user agent string.
        else if (!!navigator.userAgent.match(/Trident\/7\./)) {
            return 11;
        } else {
            return 0; //It is not IE
        }
    };

    /**
     * Tooltip
     */
    $('.description').on('click', function () {
        if ($(this).hasClass('wb_open_desc')) {

        } else {
            $('.wb_open_desc').tooltip('hide');
            $('.wb_open_desc').removeClass('wb_open_desc');
            $(this).addClass('wb_open_desc');
        }
        $(this).tooltip('toggle');
    });

    $(window).on('click', function () {
        if ($('.description:hover').length <= 0) {
            $('.wb_open_desc').tooltip('hide');
            $('.wb_open_desc').removeClass('wb_open_desc');
        }
    });
    $(document).on('click', '.tooltip i', function () {
        $('.wb_open_desc').tooltip('hide');
        $('.wb_open_desc').removeClass('wb_open_desc');

    });

    $('.description').tooltip({
        container: 'body',
        html: true,
        template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><i class="fa fa-times"></i><div class="tooltip-inner"></div></div>'
    });


    $('.wb_modals').on('shown.bs.modal', function () {
        $(this).find('input[type=text],textarea,select').filter(':visible:first').focus();
    });
    $('.wb_modals').on('hidden.bs.modal', function () {
        $('.wb_modals form .alert').hide();
        $('.wb_modals form input[type="text"]').val('');
        $('.wb_modals form input[type="text"]').css('border-color', '#ddd');
    });
    if (!escape) {
        escape = function (value) {
            return value.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, "\\$&");
        };
    }


    $("input[type='number']").on('input paste', function () {
        var wb_value = $(this).val();
        if ($(this).attr('max').length) {
            var wb_max_value = $(this).attr('max');
            if (+wb_value > +wb_max_value) {
                $(this).val(wb_max_value);
            }
        }
        if ($(this).attr('min').length) {
            var wb_min_value = $(this).attr('min');
            if (+wb_value < +wb_min_value) {
                $(this).val(wb_min_value);
            }
        }

    });
    /**
     * Hide Show Fields
     */
    $("*[has_dependent='yes']").change(function () {
        $(document).wb_show_hide_fields(this);
    });
    $.fn.wb_show_hide_fields = function (wb_current_field) {
        var has_dependent = $(wb_current_field).attr('has_dependent');
        var dependent_id = $(wb_current_field).attr('dependent_id');
        var wb_value;
        if ($(wb_current_field).is("input")) {
            wb_value = $('*[dependent_id=' + dependent_id + ' ]:checked').val();
        } else {
            wb_value = $('*[dependent_id=' + dependent_id + ' ]').val();
        }
        if (has_dependent && dependent_id !== 'wb_menu_icon') {
            if (wb_value === 'no') {
                $('*[dependent_from*="' + dependent_id + '"]').closest("tr").fadeOut(300);
            } else {
                var wb_add_default = wb_value;
                var regex = new RegExp(wb_add_default.split(/\s+/).map(function (value) {
                    return '(\\b' + escape(value) + '\\b)';
                }).join('|'));
                $('*[dependent_from*="' + dependent_id + '"]').each(function () {
                    var count = 0;
                    var wb_sub_dependent_value = '';
                    var dependent_from = $(this).attr('dependent_from').split(' ');
                    var dependent_condation = $(this).attr('dependent_condation').split(' ');
                    if (dependent_from.length > 1) {
                        for (var i = 0; i < dependent_from.length; i++) {
                            if (dependent_from[i] !== dependent_id) {
                                var wb_sub_dependent_id = $('*[dependent_id*="' + dependent_from[i] + '"]');
                                if (wb_sub_dependent_id.is("input")) {
                                    var wb_sub_dependent_class = wb_sub_dependent_id.attr('class');
                                    wb_sub_dependent_value = $('*[class=' + wb_sub_dependent_class + ' ]:checked').val();
                                    for (var j = 0; j < dependent_condation.length; j++) {
                                        if (dependent_condation[j] === wb_sub_dependent_value) {
                                            count++;
                                        }
                                    }
                                } else {
                                    var wb_sub_dependent_class = wb_sub_dependent_id.attr('id');
                                    wb_sub_dependent_value = $('*[id=' + wb_sub_dependent_class + ' ]').val();
                                    for (var j = 0; j < dependent_condation.length; j++) {
                                        if (dependent_condation[j] === wb_sub_dependent_value) {
                                            count++;
                                        }
                                    }
                                }
                            }
                        }
                        if (count > 0) {
                            condation = $(this).attr('dependent_condation');
                            if (regex.test(condation)) {
                                $(this).closest("tr").fadeIn(300);
                            } else {
                                $(this).closest("tr").fadeOut(300);
                            }
                        } else {
                            $(this).closest("tr").fadeOut(300);
                        }
                    } else {
                        var condation = $(this).attr('dependent_condation');
                        if (regex.test(condation)) {
                            $(this).closest("tr").fadeIn(300);
                        } else {
                            $(this).closest("tr").fadeOut(300);
                        }
                    }
                });
            }
        }
    };
    $("*[has_dependent='yes']").each(function () {
        $(document).wb_show_hide_fields(this);
    });
    $('#wb_setting_menu_icon_setting_wb_menu_icon').change(function () {
        var wb_value = $(this).val();
        if (wb_value === 'upload_icon') {
            $('#wb_setting_menu_icon_setting_wb_menu_custom_icon').closest("tr").fadeIn(300);
            $('#wb_setting_menu_icon_setting_wb_menu_icon_size').closest("tr").fadeOut(300);
            $('#wb_setting_menu_icon_setting_wb_menu_icon_color').closest("tr").fadeOut(300);
            $('#wb_setting_menu_icon_setting_wb_menu_hover_icon_color').closest("tr").fadeOut(300);
        } else {
            $('#wb_setting_menu_icon_setting_wb_menu_custom_icon').closest("tr").fadeOut(300);
            $('#wb_setting_menu_icon_setting_wb_menu_icon_size').closest("tr").fadeIn(300);
            $('#wb_setting_menu_icon_setting_wb_menu_icon_color').closest("tr").fadeIn(300);
            $('#wb_setting_menu_icon_setting_wb_menu_hover_icon_color').closest("tr").fadeIn(300);
        }
    });
    $('#wb_setting_menu_icon_setting_wb_menu_icon').each(function () {
        var wb_value = $(this).val();
        if (wb_value === 'upload_icon') {
            $('#wb_setting_menu_icon_setting_wb_menu_custom_icon').closest("tr").fadeIn(300);
            $('#wb_setting_menu_icon_setting_wb_menu_icon_size').closest("tr").fadeOut(300);
            $('#wb_setting_menu_icon_setting_wb_menu_icon_color').closest("tr").fadeOut(300);
            $('#wb_setting_menu_icon_setting_wb_menu_hover_icon_color').closest("tr").fadeOut(300);
        } else {
            $('#wb_setting_menu_icon_setting_wb_menu_custom_icon').closest("tr").fadeOut(300);
            $('#wb_setting_menu_icon_setting_wb_menu_icon_size').closest("tr").fadeIn(300);
            $('#wb_setting_menu_icon_setting_wb_menu_icon_color').closest("tr").fadeIn(300);
            $('#wb_setting_menu_icon_setting_wb_menu_hover_icon_color').closest("tr").fadeIn(300);
        }
    });
    


})(jQuery);
