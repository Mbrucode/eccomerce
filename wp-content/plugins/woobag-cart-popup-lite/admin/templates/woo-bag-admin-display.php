<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @author Gatelogixs
 * @package Woo_Bag/
 * @subpackage Woo_Bag/admin/templates
 * @version 1.0.0
 */
if (class_exists('Woo_Bag')) :
    if (!function_exists('wb_woo_bag_admin_template')):

        function wb_woo_bag_admin_template() {
            $wb_data = wb_product_dummp_data();
            $wb_total_product = sizeof($wb_data);
            $wb_total_price = 0;
            $wb_total_tax = 0;
            if (function_exists('get_woocommerce_currency_symbol')):
                $wb_currency_symbol = get_woocommerce_currency_symbol();
            else:
                $wb_currency_symbol = '$';
            endif;
            foreach ($wb_data as $data):
                $wb_total_price += $data['product_price'] * $data['product_quantity'];
                $wb_total_tax += $data['product_tax'];
            endforeach;
            ?><div class="wb_backend_template_preview_wrapper" id="wb_backend_template_preview_wrapper">
                <div class="wb_display_widget_cart">
                    <div class="cart_list product_list_widget wb_cart_product" id="wb_cart_back_end_wrapper">
                        <!--<span class="arrow"></span>-->
                        <?php
                        $wb_template_name_part = WB()->wb_get_setting_name();
                        $wb_all_option = wb_get_all_setting($wb_template_name_part);

                        $wb_show_product_no = $wb_all_option[$wb_template_name_part . '_product_setting_wb_show_product_no'];
                        $wb_single_product_height = $wb_all_option[$wb_template_name_part . '_product_setting_wb_single_product_height'];

                        $woobag_loader_icon = $wb_all_option[$wb_template_name_part . '_general_setting_woobag_loader_icon'];
                        $wb_close_bag_icon = $wb_all_option[$wb_template_name_part . '_header_setting_wb_close_bag_icon'];
                        $footer_text = $wb_all_option[$wb_template_name_part . '_footer_setting_footer_text'];
                        $wb_subtotal_label = $wb_all_option[$wb_template_name_part . '_subtotal_setting_wb_subtotal_label'];
                        $wb_ordertotal_label = $wb_all_option[$wb_template_name_part . '_subtotal_setting_wb_ordertotal_label'];
                        $viewbag_button_text = $wb_all_option[$wb_template_name_part . '_subtotal_setting_viewbag_button_text'];
                        $checkout_button_text = $wb_all_option[$wb_template_name_part . '_subtotal_setting_checkout_button_text'];
                        $empty_cart_button_text = $wb_all_option[$wb_template_name_part . '_subtotal_setting_empty_cart_button_text'];
                        $custom_button_text = $wb_all_option[$wb_template_name_part . '_subtotal_setting_custom_button_text'];
                        $custom_button_url = $wb_all_option[$wb_template_name_part . '_subtotal_setting_custom_button_url'];
                        $header_text_multiple = $wb_all_option[$wb_template_name_part . '_header_setting_header_text_multiple'];
                        if ($wb_show_product_no == 'unlimited'):
                            $wb_show_product_no = 4;
                        endif;
                        if ($wb_show_product_no == 1):
                            $wb_style = '.mCSB_scrollTools .mCSB_dragger{
                            height:' . ($wb_single_product_height / 2) . 'px !important;
                        }';
                            echo '<style>' . $wb_style . '</style>';
                        endif;
                        $wb_scroll_option = $wb_all_option[$wb_template_name_part . '_scroll_setting_wb_scroll_option'];
                        if ($wb_scroll_option == 'wheel'):
                            echo $wb_style = "<style>.woobagcontainer{padding-right:0 !important;}</style>";
                        endif;
                        ?>
                        <table>
                            <tr class="wb_header_tr">
                                <td class="wb_window_top">
                                    <table>
                                        <tr>
                                            <td class="wb_top_text">
                                                <b><?php _e($wb_total_product, 'woo-bag'); ?></b> 
                                                <span class="wb_single_multiple_top_text">
                                                    <?php _e($header_text_multiple, 'woo-bag'); ?>
                                                </span>
                                            </td>
                                            <td class="wb_close_window">
                                                <i class="<?php echo $wb_close_bag_icon; ?>"></i>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr class="wb_contact_tr">
                                <td class="woobagcontainer">
                                    <table>
                                        <tr>
                                            <td class="wb_scroll_button_wrapper">
                                                <?php if (($wb_total_product > $wb_show_product_no) || $wb_total_product >= 3) : ?>
                                                    <div id="bag_carousel_prev" class="wb_scroll_button bag_carousel_prev">
                                                        <div id="prev_button" class="bag_prev_button">
                                                            <i class="fa fa-chevron-up"></i>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="wb_all_product_wrapper" >
                                                    <div class="wb_all_product_cover" id="wb_all_products">
                                                        <?php include_once('woo-bag-admin-display-content.php'); ?>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="wb_scroll_button_wrapper">
                                                <?php if (($wb_total_product > $wb_show_product_no) || $wb_total_product >= 3) : ?>
                                                    <div id="bag_carousel_next" class="next_button wb_scroll_button bag_carousel_next">
                                                        <div class="bag_next_button" id="next_button"><i class="fa fa-chevron-down"></i></div>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr class="wb_subtotal_tr">
                                <td class="wb_cart_total_wrapper">
                                    <table>
                                        <tr>
                                            <td class="total">
                                                <?php
                                                $wb_toal = $wb_total_tax + $wb_total_price;
                                                ?>
                                                <div class="wb_total_content">
                                                    <div class="wb_subtotal_only_price">
                                                        <strong>
                                                            <?php if ($wb_subtotal_label): ?>
                                                                <?php _e($wb_subtotal_label, 'woo-bag'); ?>
                                                            <?php endif; ?>
                                                        </strong> 
                                                        <span>
                                                            <?php _e($wb_currency_symbol . $wb_total_price, 'woo-bag'); ?>
                                                        </span>
                                                    </div>
                                                    <div class="wb_total_content_table">
                                                        <strong>
                                                            <?php if ($wb_ordertotal_label): ?>
                                                                <?php _e($wb_ordertotal_label, 'woo-bag'); ?>
                                                            <?php endif; ?>
                                                        </strong> 
                                                        <span>
                                                            <?php _e($wb_currency_symbol . $wb_toal, 'woo-bag'); ?>
                                                        </span>
                                                    </div>
                                                    <span class="number hidden"><?php _e($wb_toal, 'woo-bag'); ?></span>
                                                    <span class="wb_current_currency hidden"><?php _e($wb_currency_symbol, 'woo-bag'); ?></span>
                                                    <span class="wb_count_product hidden"><?php _e($wb_total_product, 'woo-bag'); ?></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="wb_cart_buttons">
                                            <td class="buttons">
                                                <a href="#" class="wb_viewbag_button">
                                                    <span>
                                                        <?php if ($viewbag_button_text): ?>
                                                            <?php _e($viewbag_button_text, 'woo-bag'); ?>
                                                        <?php else: ?>
                                                            <?php _e('', 'woo-bag'); ?>
                                                        <?php endif; ?>
                                                    </span>
                                                </a><!--
                                                --><a href="#" class="checkout wb_checkout_button">
                                                    <span><?php if ($checkout_button_text): ?>
                                                            <?php _e($checkout_button_text, 'woo-bag'); ?>
                                                        <?php else: ?>
                                                            <?php _e('', 'woo-bag'); ?>
                                                        <?php endif; ?>
                                                    </span>
                                                </a><!--
                                                --><a href="#" class="empty_cart wb_empty_cart_button">
                                                    <span><?php if ($empty_cart_button_text): ?>
                                                            <?php _e($empty_cart_button_text, 'woo-bag'); ?>
                                                        <?php else: ?>
                                                            <?php _e('', 'woo-bag'); ?>
                                                        <?php endif; ?>
                                                    </span>
                                                </a><!--
                                                --><a href="<?php echo $custom_button_url; ?>" class="custom wb_custom_button">
                                                    <span><?php if ($custom_button_text): ?>
                                                            <?php _e($custom_button_text, 'woo-bag'); ?>
                                                        <?php else: ?>
                                                            <?php _e('', 'woo-bag'); ?>
                                                        <?php endif; ?>
                                                    </span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr class="wb_footer_tr">
                                <td class="wb_window_bottom">
                                    <div class="wb_bottom_text"><?php _e($footer_text, 'woo-bag'); ?></div>
                                </td>
                            </tr>
                        </table>

                        <div class="wb_message_wrapper"><div class="wb_message"></div></div>
                        <div class="wb_loading_image">
                            <div class="wb_display_loading_image">
                                <?php if ($woobag_loader_icon) : ?>
                                    <i class="<?php echo $woobag_loader_icon ?> "></i>
                                <?php else: ?>
                                    <i class="fa fa-spinner fa-spin"></i>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <?php
        }

    endif;
endif;