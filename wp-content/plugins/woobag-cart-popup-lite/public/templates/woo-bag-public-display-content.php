<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the Main Content of the WooBag.
 *
 * @author Gatelogixs
 * @package Woo_Bag/
 * @subpackage Woo_Bag/public/templates
 * @version 1.0.0
 */
function wb_built_bag($wb_call_option = NULL) {
    $wb_new_product_id = '';
    $wb_count_product = 0;
    if (isset($wb_call_option) && !empty($wb_call_option)):
        if ($wb_call_option['add_cart'] == 'yes'):
            if (isset($_SESSION) && isset($_SESSION['wb_user_id']) && !empty($_SESSION['wb_user_id'])):
            else:
                $wb_user_id = md5(time() . uniqid());
                $_SESSION['wb_user_id'] = $wb_user_id;
            endif;
            $wb_new_product_id = $wb_call_option['product_id'];
        endif;
    endif;
    $wb_woocommerce = wb_woocommerce_data();
    $wb_p_data = $wb_woocommerce->cart->get_cart();
    $wb_products_data = array_reverse($wb_p_data);
    $wb_total_product = sizeof($wb_products_data);
    $wb_currency_symbol = get_woocommerce_currency_symbol();
    $wb_data = '';
    $wb_template_name_part = WB()->wb_get_setting_name();
    $wb_all_option = wb_get_all_setting($wb_template_name_part);
    $wb_show_product_no = $wb_all_option[$wb_template_name_part . '_product_setting_wb_show_product_no'];
    if ($wb_show_product_no == 'unlimited'):
        $wb_show_product_no = 3;
    endif;
    $woobag_loader_icon = $wb_all_option[$wb_template_name_part . '_general_setting_woobag_loader_icon'];
    $show_header_text = $wb_all_option[$wb_template_name_part . '_header_setting_show_header_text'];
    $wb_close_bag_icon = $wb_all_option[$wb_template_name_part . '_header_setting_wb_close_bag_icon'];
    $wb_show_footer = $wb_all_option[$wb_template_name_part . '_footer_setting_wb_show_footer'];
    $footer_text = $wb_all_option[$wb_template_name_part . '_footer_setting_footer_text'];
    $show_subtotal = $wb_all_option[$wb_template_name_part . '_subtotal_setting_show_subtotal'];
    $wb_subtotal_label = $wb_all_option[$wb_template_name_part . '_subtotal_setting_wb_subtotal_label'];
    $wb_ordertotal_label = $wb_all_option[$wb_template_name_part . '_subtotal_setting_wb_ordertotal_label'];
    $viewbag_button_text = $wb_all_option[$wb_template_name_part . '_subtotal_setting_viewbag_button_text'];

    $show_viewbag_button = $wb_all_option[$wb_template_name_part . '_subtotal_setting_show_viewbag_button'];
    $show_checkout_button = $wb_all_option[$wb_template_name_part . '_subtotal_setting_show_checkout_button'];
    $show_empty_cart_button = $wb_all_option[$wb_template_name_part . '_subtotal_setting_show_empty_cart_button'];
    $show_custom_button = $wb_all_option[$wb_template_name_part . '_subtotal_setting_show_custom_button'];

    $checkout_button_text = $wb_all_option[$wb_template_name_part . '_subtotal_setting_checkout_button_text'];
    $empty_cart_button_text = $wb_all_option[$wb_template_name_part . '_subtotal_setting_empty_cart_button_text'];
    $custom_button_text = $wb_all_option[$wb_template_name_part . '_subtotal_setting_custom_button_text'];
    $custom_button_url = $wb_all_option[$wb_template_name_part . '_subtotal_setting_custom_button_url'];
    $header_text = $wb_all_option[$wb_template_name_part . '_header_setting_header_text'];
    $header_text_multiple = $wb_all_option[$wb_template_name_part . '_header_setting_header_text_multiple'];

    $show_woobag_small_screen = $wb_all_option[$wb_template_name_part . '_smallscreen_setting_show_woobag_small_screen'];

    if ($wb_show_product_no == 'unlimited'):
        $wb_show_product_no = 4;
    endif;

    $wb_data .= '<table>';
    if ($show_woobag_small_screen == 'yes'):
        $wb_data .= '<span class="hidden wb_small_scrren_link" ></span>';
    endif;
    if (isset($show_header_text) && $show_header_text === 'yes'):
        $wb_data .= '<tr>
                            <td class="wb_window_top">
                                <table>
                                    <tr>
                                        <td class="wb_top_text">';
        $wb_data .= '<b>' . __($wb_total_product, 'woo-bag') . ' </b>';
        if ($header_text):
            if (isset($wb_total_product) && !empty($wb_total_product) && $wb_total_product > 1):
                $wb_data .= '<span class="wb_single_multiple_top_text">
                                    ' . __($header_text_multiple, 'woo-bag') . '
                                </span>';
            else:
                $wb_data .= '<span class="wb_single_product_top_text">
                                    ' . __($header_text, 'woo-bag');
                $wb_data .= '</span>';
            endif;


        endif;
        $wb_data .= '</td>
                                        <td class="wb_close_window">';
        if ($wb_close_bag_icon) :
            $wb_data .= '<i class="' . $wb_close_bag_icon . '"></i>';
        else:
            $wb_data .= '<i class="fa fa-times"></i>';
        endif;
        $wb_data .= '</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>';
    endif;

    if ($wb_total_product > 0) :
        $wb_data .= '<tr>
                                <td class="woobagcontainer">
                                    <div>
                                        <table>
                                            <tr class="wb_scolls">
                                                <td class="wb_scroll_button_wrapper">';
        if (($wb_total_product > $wb_show_product_no) || $wb_total_product > 3) :
            $wb_data .= '<div id="bag_carousel_prev" class="wb_scroll_button bag_carousel_prev">
                                                            <div id="prev_button" class="bag_prev_button">
                                                                <i class="fa fa-chevron-up"></i>
                                                            </div>
                                                        </div>';
        endif;
        $wb_data .= '</td>
                                            </tr>
                                            <tr class="wb_all_items">
                                                <td>
                                                    <div class="wb_all_product_wrapper" >
                                                        <div class="wb_all_product_cover" id="wb_all_products">';
        $wb_all_product = wb_product_list($wb_call_option, $wb_all_option, $wb_template_name_part);
        if (isset($wb_call_option) && !empty($wb_call_option) && $wb_call_option['add_cart'] == 'yes'):
            $wb_data .= $wb_all_product["product_data"];
        else:
            $wb_data .= $wb_all_product;
        endif;

        $wb_data .= '</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="wb_scolls">
                                                <td class="wb_scroll_button_wrapper">';
        if (($wb_total_product > $wb_show_product_no) || $wb_total_product > 3) :
            $wb_data .= '<div id="bag_carousel_next" class="next_button wb_scroll_button bag_carousel_next">
                                                            <div class="bag_next_button" id="next_button"><i class="fa fa-chevron-down"></i></div>
                                                        </div>';
        endif;
        $wb_data .= '</td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            <tr class="wb_subtotal_tr">
                                <td class="wb_cart_total_wrapper">
                                        <table>
                                            <tr>
                                                <td class="total">';
        $wb_total_tax = 0;
        $wb_total_amount = $wb_woocommerce->cart->cart_contents_total;

        if ($wb_woocommerce->cart->tax_display_cart == 'excl') {
            foreach ($wb_woocommerce->cart->get_tax_totals() as $code => $tax) {
                $wb_total_tax += $tax->amount;
            }
        }
        $wb_toal = $wb_total_tax + $wb_total_amount;
        $wb_data .= '<div class="wb_total_content">';
        if (isset($show_subtotal) && $show_subtotal == 'only_price' || $show_subtotal == 'both'):
            $wb_data .= '<div class="wb_subtotal_only_price">';
            if ($wb_subtotal_label):
                $wb_data .= '<strong>' . __($wb_subtotal_label, 'woo-bag') . '</strong> ';
            endif;
            $wb_data .= '<span>';
            $wb_data .= __($wb_currency_symbol . number_format($wb_total_amount, 2), 'woo-bag');
            $wb_data .= '</span>';
            $wb_data .= '</div>';
        endif;
        if (isset($show_subtotal) && $show_subtotal == 'price_tax' || $show_subtotal == 'both'):
            $wb_data .= '<div class="wb_total_content_table">';
            if ($wb_ordertotal_label):
                $wb_data .= '<strong>' . __($wb_ordertotal_label, 'woo-bag') . '</strong>';
            endif;
            $wb_data .= '<span>';
            $wb_data .= __($wb_currency_symbol . number_format($wb_toal, 2), 'woo-bag');
            $wb_data .= '</span>
                                                            </div>';
        endif;

        if (isset($show_subtotal) && $show_subtotal === 'price_tax'):
            $wb_data .= '<span class="number hidden" >' . __(number_format($wb_toal, 2), 'woo-bag') . '</span>';
        else:
            $wb_data .= '<span class="number hidden" >' . __(number_format($wb_total_amount, 2), 'woo-bag') . '</span>';
        endif;
        $wb_data .= '</div>
                                                </td>
                                            </tr>
                                            <tr class="wb_cart_buttons">
                                                <td class="buttons">';
        if ($show_viewbag_button == 'yes'):
            $wb_data .= '<a href="' . $wb_woocommerce->cart->get_cart_url() . '" class="wb_viewbag_button">';
            $wb_data .= '<span>';
            if ($viewbag_button_text):
                $wb_data .= __($viewbag_button_text, 'woo-bag');
            else:
                $wb_data .= __('', 'woo-bag');
            endif;
            $wb_data .= '</span>
                                                        </a>';
        endif;
        if ($show_checkout_button == 'yes'):
            $wb_data .= '<a href="' . $wb_woocommerce->cart->get_checkout_url() . '" class="checkout wb_checkout_button">';
            $wb_data .= '<span>';
            if ($checkout_button_text):
                $wb_data .= __($checkout_button_text, 'woo-bag');
            else:
                $wb_data .= __('', 'woo-bag');
            endif;
            $wb_data .= '</span>
                                                        </a>';
        endif;
        if ($show_empty_cart_button == 'yes'):
            $wb_data .= '<a href="#" class="empty_cart wb_empty_cart_button">
                                                            <span>';
            if ($empty_cart_button_text):
                $wb_data .= __($empty_cart_button_text, 'woo-bag');
            else:
                $wb_data .= __('', 'woo-bag');
            endif;
            $wb_data .= '</span>
                                                        </a>';
        endif;
        if ($show_custom_button == 'yes'):
            $wb_data .= '<a href="' . $custom_button_url . '" class="custom wb_custom_button">
                                                            <span>';
            if ($custom_button_text):
                $wb_data .= __($custom_button_text, 'woo-bag');
            else:
                $wb_data .= __('', 'woo-bag');
            endif;
            $wb_data .= '</span>
                                                        </a>';
        endif;
        $wb_data .= ' </td>
                                            </tr>';

        $wb_data .= '</table>
                                </td>
                            </tr>';
    else :
        
    endif;
    $wb_data .= '<p class="wb_count_product">' . $wb_total_product . '</p>';
    $wb_data .= '<span class="wb_current_currency">' . __($wb_currency_symbol, 'woo-bag') . '</span>';
    if ($wb_show_footer === 'yes'):
        if (!isset($footer_text) && empty($footer_text)):
            $footer_text = 'FREE RETURNS AVAILABLE ON ALL ORDERS';
        endif;
        $wb_data .= '<tr><td class="wb_window_bottom">';
        $wb_data .= '<div class="wb_bottom_text">' . __($footer_text, 'woo-bag') . '</div>';
        $wb_data .= '</td></tr>';
    endif;
    $wb_data .= '<div class="wb_message_wrapper" id="wb_message_wrapper"></div><div class="wb_message"></div>';
    $wb_data .= '<div class="wb_display_loading_image">';
    if ($woobag_loader_icon) :
        $wb_data .= '<i class="' . $woobag_loader_icon . ' "></i>';
    else:
        $wb_data .= '<i class="fa fa-spinner fa-spin"></i>';
    endif;
    $wb_data .= '</div>';
    $wb_data .= '</table>';
    if (isset($wb_call_option) && !empty($wb_call_option) && $wb_call_option['add_cart'] == 'yes'):
        $wb_full_cart = array();
        $wb_full_cart['product_data'] = $wb_data;
        return $wb_full_cart;
    else:
        return $wb_data;
    endif;
}

function wb_product_list($wb_call_option = NULL, $wb_all_option, $wb_template_name_part) {
    $wb_new_product_id = '';
    if (isset($wb_call_option) && !empty($wb_call_option)):
        if ($wb_call_option['add_cart'] == 'yes'):
            $wb_new_product_id = $wb_call_option['product_id'];
        endif;
    endif;
    $wb_woocommerce = wb_woocommerce_data();
    if ($wb_woocommerce) :
        if ($wb_woocommerce->cart):
            $wb_data = '';
            $wb_product_list = '';
            $wb_p_data = $wb_woocommerce->cart->get_cart();
            $wb_products_data = array_reverse($wb_p_data);
            $wb_count_product = 0;
            $wb_top_product = '';
            $wb_remove_class = '';
            $wb_other_product = '';
            $wb_reduce_quantity = '';
            $wb_remove_product_link = '';
            $wb_text_after_product_price = $wb_all_option[$wb_template_name_part . '_product_setting_wb_text_after_product_price'];
            $show_product_image = $wb_all_option[$wb_template_name_part . '_product_setting_show_product_image'];
            $wb_remove_button_icon = $wb_all_option[$wb_template_name_part . '_product_setting_wb_remove_button_icon'];

            $show_product_price = $wb_all_option[$wb_template_name_part . '_product_setting_show_product_price'];

            $wb_currency_symbol = get_woocommerce_currency_symbol();
            $wb_product_list .= '<table>';

            foreach ($wb_products_data as $cart_item_key => $cart_item) :
                $wb_count_product++;
                $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key)) :
                    $wb_product_quantity = $cart_item['quantity'];
                    $product_name = apply_filters('woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key);

                    if (isset($wb_new_product_id) && !empty($wb_new_product_id) && $product_id == $wb_new_product_id) :
                        $wb_other_product = $wb_data;
                        $wb_data = '';
                        $wb_data .='<tr '
                                . 'id="wb_cart_single_product_' . $wb_count_product . '" '
                                . 'class="wb_cart_single_product wb_cart_single_product_' . $wb_count_product . ' ' . $wb_remove_class . '" '
                                . '>';
                    else:
                        $wb_data .='<tr '
                                . 'class="wb_cart_single_product wb_cart_single_product_' . $wb_count_product . '" '
                                . 'id="wb_cart_single_product_' . $wb_count_product . '"'
                                . '>';
                    endif;


                    if (has_post_thumbnail($product_id)):
                        $wb_product_image_url = wp_get_attachment_url(get_post_thumbnail_id($product_id));
                    else:
                        $wb_product_image_url = wc_placeholder_img_src();
                    endif;
                    if ($show_product_image == 'yes'):
                        $wb_data .= '<td class="wb_product_thumbnail">';
                        if (!$_product->is_visible()) :
                            $wb_data .= '<img src="' . $wb_product_image_url . '" >';
                        else :
                            $wb_data .= '<a href="' . esc_url(get_permalink($product_id)) . '">';
                            $wb_data .= '<img src="' . $wb_product_image_url . '" >';
                            $wb_data .= '</a>';
                        endif;
                        $wb_data .= '</td>';
                    endif;

                    $wb_data .= '<td class="wb_product_detail">
                            <div class="wb_product_name">';
                    if (!$_product->is_visible()) :
                        $wb_data .= __($product_name, 'woo-bag');
                    else :
                        $wb_data .= '<a href="' . esc_url(get_permalink($product_id)) . '">';
                        $wb_data .= __($product_name, 'woo-bag');
                        $wb_data .= '</a>';
                    endif;
                    $wb_data .= '</div>';

                    $wb_data .= apply_filters('woocommerce_widget_cart_item_quantity', '<span class="quantity"><span class="wb_quantity_label">' . __('Quantity', 'woo-bag') . ': </span><span class="wb_total_quentity">' . __($wb_product_quantity, 'woo-bag') . '</span></span>', $cart_item, $cart_item_key);
                    /** Product Price Start */
                    $product_regular_price = apply_filters('woocommerce_cart_item_price', $_product->regular_price, $cart_item, $cart_item_key);

                    if ($_product->get_price() && $_product->is_on_sale() && isset($show_product_price) && $show_product_price == 'regular_sale') :
                        $wb_sales_price = $_product->sale_price;
                        $wb_data .= apply_filters('woocommerce_widget_cart_item_price', '<div class="price"><span class="wb_price_label">' . __('Price', 'woo-bag') . ':</span> '
                                . '<span class="wb_product_reqular_amount">' . $wb_currency_symbol . ''
                                . __(number_format($product_regular_price, 2), 'woo-bag') . ''
                                . '</span> '
                                . '<span class="wb_product_amount">' . $wb_currency_symbol . ''
                                . __(number_format($wb_sales_price, 2), 'woo-bag') . ' <span class="wb_text_after_product_price">' . __($wb_text_after_product_price, 'woo-bag') . '</span></span>'
                                . '</div>'
                                , $cart_item, $cart_item_key);
                    else:
                        $wb_data .= apply_filters('woocommerce_widget_cart_item_price', '<div class="price"><span class="wb_price_label">' . __('Price', 'woo-bag') . ':</span> '
                                . '<span class="wb_product_amount">' . $wb_currency_symbol . '' . __(number_format($product_regular_price, 2), 'woo-bag') . '<span class="wb_text_after_product_price">' . __($wb_text_after_product_price, 'woo-bag') . '</span></span></div>'
                                , $cart_item, $cart_item_key);
                    endif;
                    if ($_product->get_price() && $_product->is_on_sale()) :
                        $percentage = round(( ( $_product->regular_price - $_product->sale_price ) / $_product->regular_price ) * 100);
                        $wb_data .= '<span class="wb_saving_percentage"> ' . sprintf(__('Save: %s', 'woo-bag'), $percentage . '%') . '</span>';
                    endif;
                    if ($cart_item['line_tax'] == 0):
                        $wb_tax_per_product = __('0.00', 'woo-bag');
                    else:
                        $wb_tax_per_product = __($cart_item['line_tax'], 'woo-bag');
                    endif;
                    $wb_data .='<span class="wb_tax_per_item"> 
                           ' . __('Tax', 'woo-bag') . ': ' . $wb_currency_symbol . __($wb_tax_per_product, 'woo-bag') . '
                        </span>';
                    /** Product Price End */
                    /** Product Custom Attributes Start */
                    $wb_data .= '<div class="wb_custom_attributes">';

                    $wb_variable_data = wb_get_item_data($cart_item);
                    if ($wb_variable_data):
                        foreach ($wb_variable_data as $data):
                            $wb_attribute_key = strtolower($data['key']);
                            $wb_custom_attributes = $wb_all_option[$wb_template_name_part . '_product_setting_wb_custom_attributes_' . $wb_attribute_key];
                            if ($wb_custom_attributes):
                                $wb_data .= '<span class="wb_custom_single">' . __($data['key'], 'woo-bag') . ': ' . __($data['value'], 'woo-bag') . '</span>';
                            endif;
                        endforeach;
                    endif;
                    $wb_data .= '</div>';
                    /** Product Custom Attributes End */
                    $wb_data .= '<div class="wb_single_product_id wb_hidden_fields"  id="' . $product_id . '">' . $product_id . '</div>';
                    $wb_data .= '<div class="wb_single_product_tax wb_hidden_fields" id="' . $cart_item["line_tax"] . '"></div>';
                    $wb_data .= '</td>';
                    $wb_data .= '<td class="wb_remove_button">';
                    $wb_data .= '<p class="buttons wb_remove_product">
                            <span onclick="wb_remove_conform(\'wb_cart_single_product_' . $wb_count_product . '\');" id="' . $wb_woocommerce->cart->get_remove_url($cart_item_key) . '">';
                    if ($wb_remove_button_icon):
                        $wb_data .= '<i class="' . $wb_remove_button_icon . '"></i></span></span>';
                    else:
                        $wb_data .= '<i class="fa fa-times-circle"></i></span></span>';
                    endif;
                    $wb_data .= '</p>';
                    $wb_data .= '</td>';
                    $wb_data .= '</tr>';

                    if (isset($wb_new_product_id) && !empty($wb_new_product_id) && $product_id == $wb_new_product_id) :
                        $wb_top_product = $wb_data;
                        $wb_data = $wb_other_product;
                    endif;
                endif;
                $wb_count_product++;
            endforeach;
            $wb_product_list .= $wb_top_product . $wb_data;
            $wb_product_list .= '</table>';
        endif;
    endif;
    if (isset($wb_call_option) && !empty($wb_call_option) && $wb_call_option['add_cart'] === 'yes'):
        $wb_data = array();
        $wb_data['product_data'] = $wb_product_list;
        return $wb_data;
    else:
        return $wb_product_list;
    endif;
}
