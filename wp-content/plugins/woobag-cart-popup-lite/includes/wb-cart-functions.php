<?php
if (!defined('ABSPATH')) :
    exit; // Exit if accessed directly
endif;

/**
 * Cart Related Operations
 *
 * @version		1.0.0
 * @package		Woo_Bag/Cart Functions/
 * @subpackage          Woo_Bag/includes
 * @category            Class
 * @author 		Gatelogixs
 */
/**
 * Function to get Cart Data call from jQuery
 */
add_action('wp_ajax_wb_get_cart_data', 'wb_get_cart_data');
add_action('wp_ajax_nopriv_wb_get_cart_data', 'wb_get_cart_data');

function wb_get_cart_data() {
    if (isset($_SESSION) && isset($_SESSION['wb_user_id']) && !empty($_SESSION['wb_user_id'])):
    else:
        $wb_user_id = md5(time() . uniqid());
        $_SESSION['wb_user_id'] = $wb_user_id;
    endif;
    $wb_data = array();
    $wb_data['reduce_quantity'] = '';
    $user_data = $_POST['data'];
    $p_link = $user_data["product_link"];
    $p_id = substr(strrchr($p_link, '='), 1);
    $wb_call_option['add_cart'] = 'yes';
    $wb_call_option['product_id'] = $p_id;
    $wb_full_cart = wb_built_bag($wb_call_option);

    $wb_data["command"] = "success";
    $wb_data["reduce_quantity"] = $wb_full_cart["reduce_quantity"];
    $wb_data["remove_link"] = $wb_full_cart["remove_link"];
    $wb_data["product_data"] = $wb_full_cart["product_data"];
    echo json_encode($wb_data);
    die();
}

add_action('wp_ajax_wb_get_cart_data_on_delete', 'wb_get_cart_data_on_delete');
add_action('wp_ajax_nopriv_wb_get_cart_data_on_delete', 'wb_get_cart_data_on_delete');

function wb_get_cart_data_on_delete() {
    $wb_data = array();
    $wb_full_cart = wb_built_bag();
    $wb_data["command"] = "success";
    $wb_data["product_data"] = $wb_full_cart;
    echo json_encode($wb_data);
    die();
}

/**
 * 
 * @param type $cart_item
 * @param type $flat
 * @return string
 */
function wb_get_item_data($cart_item, $flat = false) {
    $item_data = array();
    if (!empty($cart_item['data']->variation_id) && is_array($cart_item['variation'])) {
        foreach ($cart_item['variation'] as $name => $value) {
            if ('' === $value)
                continue;
            $taxonomy = wc_attribute_taxonomy_name(str_replace('attribute_pa_', '', urldecode($name)));
            if (taxonomy_exists($taxonomy)) {
                $term = get_term_by('slug', $value, $taxonomy);
                if (!is_wp_error($term) && $term && $term->name) {
                    $value = $term->name;
                }
                $label = wc_attribute_label($taxonomy);
            } else {
                $value = apply_filters('woocommerce_variation_option_name', $value);
                $product_attributes = $cart_item['data']->get_attributes();
                if (isset($product_attributes[str_replace('attribute_', '', $name)])) {
                    $label = wc_attribute_label($product_attributes[str_replace('attribute_', '', $name)]['name']);
                } else {
                    $label = $name;
                }
            }
            $item_data[] = array(
                'key' => $label,
                'value' => $value
            );
        }
    }
    $other_data = apply_filters('woocommerce_get_item_data', array(), $cart_item);
    if ($other_data && is_array($other_data) && sizeof($other_data) > 0) {
        foreach ($other_data as $data) {
            if (empty($data['hidden'])) {
                $display_value = !empty($data['display']) ? $data['display'] : $data['value'];
                $item_data[] = array(
                    'key' => $data['name'],
                    'value' => $display_value
                );
            }
        }
    }
    if (sizeof($item_data) > 0) {
        return $item_data;
    }
    return '';
}

/**
 * 
 * @global type $wpdb
 * @return type
 */
function wb_get_custom_attribute() {
    $transient_name = 'wc_attribute_taxonomies';
    $attribute_taxonomies = '';
    $wb_custom_attribute = array();
    if (false === ( $attribute_taxonomies = get_transient($transient_name) )) {
        global $wpdb;
        $attribute_taxonomies = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies");
        set_transient($transient_name, $attribute_taxonomies);
    }
    foreach ($attribute_taxonomies as $data):
        $wb_custom_attribute[$data->attribute_name] = $data->attribute_label;
    endforeach;
    return $wb_custom_attribute;
}



add_action('wp_ajax_wb_clear_cart', 'wb_clear_cart');
add_action('wp_ajax_nopriv_wb_clear_cart', 'wb_clear_cart');

function wb_clear_cart() {
    $wb_woocommerce = wb_woocommerce_data();
    if ($wb_woocommerce) :
        if ($wb_woocommerce->cart):
            $wb_woocommerce->cart->empty_cart();
        endif;
    endif;
    $wb_data = array();
    $wb_full_cart = wb_built_bag();
    $wb_data["command"] = "success";
    $wb_data["product_data"] = $wb_full_cart;
    echo json_encode($wb_data);
    die();
}
