<?php
if (!defined('ABSPATH')) :
    exit; // Exit if accessed directly
endif;

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 * 
 * @version		1.0.0
 * @package		Woo_Bag/Core Functions/
 * @subpackage          Woo_Bag/includes
 * @category            Class
 * @author 		Gatelogixs
 */
function wb_load_files() {
    /**
     * The class responsible for defining internationalization functionality
     * of the plugin.
     */
    include_once('class-woo-bag-i18n.php');


    /**
     * The code that runs during plugin activation.
     */
    include_once( 'class-woo-bag-activator.php');

    /**
     * The code that runs during plugin deactivation.
     */
    include_once( 'class-woo-bag-deactivator.php');
}

/**
 * Get other templates (e.g. product attributes) passing attributes and including the file.
 *
 * @access public
 * @param string $template_name
 */
function wb_get_admin_template($template_name) {
    $template = '';
    if ($template_name):

        if (!$template && $template_name && file_exists(WB()->wb_plugin_path() . "/admin/templates/{$template_name}.php")) :
            $template = WB()->wb_plugin_path() . "/admin/templates/{$template_name}.php";
        endif;
        if ($template) :
            include( $template );
        endif;
    else:
    endif;
}

/**
 * Get other templates (e.g. product attributes) passing attributes and including the file.
 *
 * @access public
 * @param string $template_name
 */
function wb_get_template($template_name) {
    $template = '';
    if ($template_name):

        if (!$template && $template_name && file_exists(WB()->wb_plugin_path() . "/public/templates/{$template_name}.php")) :
            $template = WB()->wb_plugin_path() . "/public/templates/{$template_name}.php";
        endif;
        if ($template) :
            include( $template );
        endif;
    else:
    endif;
}

/**
 * Extract after some string
 * 
 * @param string $string
 * @param string $substring
 * @return String
 */
function wb_string_after($string, $substring) {
    $pos = strpos($string, $substring);
    if ($pos === false):
        return $string;
    else:
        return(substr($string, $pos + strlen($substring)));
    endif;
}

/**
 * Extract Before some string
 * 
 * @param string $string
 * @param string $substring
 * @return String
 */
function wb_string_before($string, $substring) {
    $pos = strpos($string, $substring);
    if ($pos === false):
        return $string;
    else:
        return(substr($string, 0, $pos));
    endif;
}

/** Shortcode for Admin Side */
function wb_cart_shortcode_admin() {
    ?>
    <div class="wb_display_widget_backend" id="wb_display_widget_backend">
        <div class="wb_admin_icon_wrapper">
            <h3>
                Preview
            </h3>
        </div>
        <?php wb_woo_bag_admin_template(); ?>
    </div>
    <?php
}

add_shortcode('wb_woo_bag_admin', 'wb_cart_shortcode_admin');

/**
 * General Setting
 * 
 * @param Array $wb_all_option All Option of Single Setting
 * @param string $wb_template_name_part First Part of Setting Name
 * @return string
 */
function wb_general_setting($wb_all_option, $wb_template_name_part) {

    $wb_style = '';

    $wb_section_id = 'general_setting';

    $wb_bg_option = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_bg_option'];
    $wb_bg_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_bg_color'];
    $wb_bg_image = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_bg_image'];
    $wb_bg_image_repeat = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_bg_image_repeat'];
    $wb_bg_image_position_x = (isset($wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_bg_image_position_x'])) ? $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_bg_image_position_x'] : 0;
    $wb_bg_image_position_y = (isset($wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_bg_image_position_y'])) ? $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_bg_image_position_y'] : 0;
    $wb_woobag_border_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_woobag_border_color'];
    $wb_woobag_border_radius = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_woobag_border_radius'];
    $wb_woobag_border_width = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_woobag_border_width'];
    $wb_woobag_border_style = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_woobag_border_style'];
    $wb_woobag_custom_width = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_woobag_custom_width'];
    if ($wb_woobag_custom_width == ''):
        $wb_woobag_custom_width = '351';
    endif;
    $woobag_loader_icon_size = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'woobag_loader_icon_size'];
    $woobag_loader_icon_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'woobag_loader_icon_color'];
    $wb_opacity = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_opacity'];



    $wb_style .= "#wb_all_content_in_footer .wb_display_widget_cart,.wb_display_widget_cart_shortcode .wb_display_widget_cart, .wb_display_widget_backend .wb_display_widget_cart{";
    if ($wb_bg_image && $wb_bg_image != '#' && $wb_bg_option === 'image'):
        $wb_style .= "background-image: url('" . $wb_bg_image . "')!important;background-repeat: " . $wb_bg_image_repeat . "!important;";
        $wb_style .= "background-position: " . $wb_bg_image_position_x . "px " . $wb_bg_image_position_y . "px !important;";
        $wb_style .= "background-color:transparent !important ;";
    endif;
    if ($wb_bg_option === 'color'):
        $wb_style .= "background:transparent !important ;";
        $wb_style .= "background-color:" . $wb_bg_color . "!important ;";
    endif;
    if ($wb_bg_option === 'both'):
        $wb_style .= "background-image: url('" . $wb_bg_image . "')!important;background-repeat: " . $wb_bg_image_repeat . "!important;";
        $wb_style .= "background-position: " . $wb_bg_image_position_x . "px " . $wb_bg_image_position_y . "px !important;";
        $wb_style .= "background-color:" . $wb_bg_color . "!important ;";
    endif;
    if ($wb_woobag_border_style):
        $wb_style .= "border-style:" . $wb_woobag_border_style . "!important ;";
    endif;
    $wb_style .= "border-color : " . $wb_woobag_border_color . "!important ;
        -webkit-border-radius: " . $wb_woobag_border_radius . "px !important ;
        -moz-border-radius: " . $wb_woobag_border_radius . "px !important ;
        -khtml-border-radius: " . $wb_woobag_border_radius . "px !important ;
        border-radius : " . $wb_woobag_border_radius . "px !important ;
        opacity : " . $wb_opacity . "!important ;
        border-width : " . $wb_woobag_border_width . "px !important;";
    if ($wb_woobag_custom_width):
        $wb_style .='width : ' . $wb_woobag_custom_width . 'px !important;';
    endif;
    $wb_style .= "}";



    if ($woobag_loader_icon_size):
        $wb_style .= ".wb_display_loading_image i{font-size:" . $woobag_loader_icon_size . "px !important;}";
    endif;

    if ($woobag_loader_icon_color):
        $wb_style .= ".wb_display_loading_image i{color:" . $woobag_loader_icon_color . " !important;}";
    endif;
    return $wb_style;
}

/**
 * Header Setting
 * 
 * @param Array $wb_all_option All Option of Single Setting
 * @param string $wb_template_name_part First Part of Setting Name
 * @return string
 */
function wb_header_setting($wb_all_option, $wb_template_name_part) {
    $wb_style = '';
    $wb_section_id = 'header_setting';

    $show_header_text = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'show_header_text'];
    $wb_header_height = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_header_height'];
    $header_text_position = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'header_text_position'];
    $header_text_vertical_position = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'header_text_vertical_position'];
    $header_text_size = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'header_text_size'];
    $wb_head_text_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_head_text_color'];
    $wb_header_bg_option = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_header_bg_option'];
    $wb_header_bg_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_header_bg_color'];
    $wb_header_bg_image = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_header_bg_image'];
    $wb_header_bg_image_repeat = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_header_bg_image_repeat'];
    $wb_header_bg_image_position_x = (isset($wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_header_bg_image_position_x'])) ? $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_header_bg_image_position_x'] : 0;
    $wb_header_bg_image_position_y = (isset($wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_header_bg_image_position_y'])) ? $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_header_bg_image_position_y'] : 0;
    $show_count = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'show_count'];
    $wb_close_bag_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_close_bag_color'];
    $wb_close_bag_hover_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_close_bag_hover_color'];
    $wb_close_bag_size = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_close_bag_size'];
    $wb_close_bag_button_position = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_close_bag_button_position'];
    $wb_header_border_bottom = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_header_border_bottom'];
    $wb_header_border_option = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_header_border_option'];
    $wb_header_border_width = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_header_border_width'];
    $wb_header_seprator_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_header_seprator_color'];


    if ($show_header_text == 'no'):
        $wb_style .= ".product_list_widget .wb_window_top{display:none !important;}";
    endif;
    if ($wb_header_height):
        $wb_style .= ".product_list_widget .wb_window_top{height:" . $wb_header_height . "px !important;}";
    endif;
    $wb_style .= ".wb_top_text{text-align:" . $header_text_position . " !important;}";
    $wb_style .= ".wb_top_text{vertical-align:" . $header_text_vertical_position . " !important;}";
    $wb_style .= ".wb_window_top .wb_top_text span, .wb_window_top .wb_top_text b {";
    if ($wb_head_text_color):
        $wb_style .= "color:" . $wb_head_text_color . " !important;";
    endif;
    if ($header_text_size):
        $wb_style .= "font-size:" . $header_text_size . "px !important;";
    endif;
    $wb_style .= "}";
    $wb_style .= ".product_list_widget .wb_window_top {";
    if ($wb_header_bg_image && ($wb_header_bg_option === 'image' || $wb_header_bg_option === 'both')):
        $wb_style .= "background-image: url('" . $wb_header_bg_image . "');background-repeat: " . $wb_header_bg_image_repeat . ";";
        $wb_style .= "background-position: " . $wb_header_bg_image_position_x . "px " . $wb_header_bg_image_position_y . "px !important;";
    endif;
    if ($wb_header_bg_color && ($wb_header_bg_option === 'color' || $wb_header_bg_option === 'both')):
        $wb_style .= "background-color:" . $wb_header_bg_color . " !important;";
    endif;
    if ($wb_header_border_bottom === 'yes'):
        $wb_style .= 'border-bottom: ' . $wb_header_border_width . 'px ' . $wb_header_border_option . ' ' . $wb_header_seprator_color . ' !important;';
    else:
        $wb_style .= "border-bottom:0 !important;";
    endif;

    $wb_style .= "}";
    if ($show_count === 'no'):
        $wb_style .= ".wb_window_top .wb_top_text b{display:none !important;}";
    endif;
    if ($wb_close_bag_color):
        $wb_style .= ".wb_close_window i{color:" . $wb_close_bag_color . " !important;}";
    endif;
    if ($wb_close_bag_hover_color):
        $wb_style .= ".wb_close_window i:hover{color:" . $wb_close_bag_hover_color . " !important;}";
    endif;
    if ($wb_close_bag_size):
        $wb_style .= ".wb_close_window i{font-size:" . $wb_close_bag_size . "px !important;}";
    endif;
    if ($wb_close_bag_button_position):
        $wb_style .= ".wb_close_window{vertical-align:" . $wb_close_bag_button_position . " !important;}";
    endif;
    return $wb_style;
}

/**
 * Product Settings
 * 
 * @param Array $wb_all_option All Option of Single Setting
 * @param string $wb_template_name_part First Part of Setting Name
 * @return string
 */
function wb_product_setting($wb_all_option, $wb_template_name_part) {
    $wb_style = '';
    $wb_section_id = 'product_setting';

    $wb_item_padding_left_right = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_item_padding_left_right'];
    $wb_item_seprator_show = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_item_seprator_show'];
    $wb_border_option = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_border_option'];
    $wb_border_width = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_border_width'];
    $wb_seprator_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_seprator_color'];
    $wb_show_product_no = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_show_product_no'];
    $wb_woobag_custom_width = $wb_all_option[$wb_template_name_part . '_general_setting_' . 'wb_woobag_custom_width'];
    $wb_single_product_height = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_single_product_height'];
    $show_product_quantity = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'show_product_quantity'];
    $wb_quantity_label_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_quantity_label_color'];
    $wb_quantity_value_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_quantity_value_color'];
    $show_product_price = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'show_product_price'];
    $wb_price_label_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_price_label_color'];
    $wb_price_value_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_price_value_color'];
    $show_product_saving = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'show_product_saving'];
    $show_tax_per_item = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'show_tax_per_item'];
    $show_product_image = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'show_product_image'];
    $wb_product_image_width = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_product_image_width'];
    $wb_content_width = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_content_width'];
    $show_remove_button = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'show_remove_button'];
    $wb_remove_button_position = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_remove_button_position'];
    $wb_remove_button_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_remove_button_color'];
    $wb_remove_button_hover_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_remove_button_hover_color'];
    $wb_content_text_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_content_text_color'];
    $wb_content_text_position = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_content_text_position'];
    $wb_content_text_padding_left = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_content_text_padding_left'];
    $wb_item_title_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_item_title_color'];
    if ($wb_show_product_no !== 'unlimited'):
        if ($wb_show_product_no == 3):
            $wb_style .= '.wb_display_widget_backend .wb_all_product_wrapper{overflow-y: hidden !important;}';
            $wb_style .= '.wb_display_widget_backend .wb_scroll_button{display: none !important;}';
        endif;
        if ($wb_single_product_height):
            $wb_default_height = $wb_single_product_height;
        else:
            $wb_default_height = 120;
        endif;
        $wb_cover_height = ($wb_default_height * $wb_show_product_no);
        $wb_style .= ".wb_all_product_wrapper{max-height:" . $wb_cover_height . "px !important;";
        if ($wb_single_product_height) :
            $wb_style .="margin-bottom:0 !important";
        endif;
        $wb_style .="}";
        if ($wb_single_product_height):
            $wb_style .= ".wb_cart_single_product{height:" . $wb_single_product_height . "px !important;}";
        endif;
        if ($wb_show_product_no == 1):
            $wb_style .= '.mCSB_scrollTools .mCSB_dragger{
                height:' . ($wb_single_product_height / 2) . 'px !important;
            }';
        endif;
    else:
        if ($wb_woobag_custom_width > '351'):
            $wb_style .= ".woobagcontainer{max-height:" . $wb_woobag_custom_width . "px !important;}";
            $wb_style .= ".wb_all_product_wrapper{max-height:" . $wb_woobag_custom_width . "px !important;}";
        endif;
    endif;

    if ($wb_item_padding_left_right):
        $wb_style .= ".product_list_widget .wb_all_product_wrapper{padding:0 " . $wb_item_padding_left_right . "px !important;}";
    endif;
    if ($wb_item_seprator_show == 'yes'):
        $wb_style .= ".wb_cart_single_product{ ";
        $wb_style .= 'border-bottom: ' . $wb_border_width . 'px ' . $wb_border_option . ' ' . $wb_seprator_color . ' !important;';
        $wb_style .= '}';
    else:
        $wb_style .= ".wb_cart_single_product{ "
                . "border-bottom: 0 !important;";
        if ($wb_seprator_color):
            $wb_style .= "border-bottom-color:" . $wb_seprator_color . " !important;";
        endif;
        $wb_style .="}";
    endif;


    if ($show_product_quantity == 'no'):
        $wb_style .= ".wb_cart_single_product .quantity{display:none !important;}";
    endif;
    if ($wb_quantity_label_color):
        $wb_style .= ".wb_cart_single_product .wb_quantity_label{color:" . $wb_quantity_label_color . " !important;}";
    endif;
    if ($wb_quantity_value_color):
        $wb_style .= ".wb_cart_single_product .wb_total_quentity{color:" . $wb_quantity_value_color . " !important;}";
    endif;
    if ($show_product_price == 'no'):
        $wb_style .= ".wb_cart_single_product .price{display:none !important;}";
    elseif ($show_product_price == 'only_price'):
        $wb_style .= ".wb_cart_single_product .price .wb_product_reqular_amount{display:none !important;}";
    endif;
    if ($wb_price_label_color):
        $wb_style .= ".wb_cart_single_product .wb_price_label{color:" . $wb_price_label_color . " !important;}";
    endif;
    if ($wb_price_value_color):
        $wb_style .= ".wb_cart_single_product .wb_product_reqular_amount,.wb_cart_single_product .wb_product_amount{color:" . $wb_price_value_color . " !important;}";
    endif;
    if ($show_product_saving == 'no'):
        $wb_style .= ".wb_cart_single_product .wb_saving_percentage{display:none !important;}";
    endif;
    if ($show_tax_per_item == 'no'):
        $wb_style .= ".wb_cart_single_product .wb_tax_per_item{display:none !important;}";
    endif;
    if ($show_product_image == 'no'):
        $wb_style .= ".wb_cart_single_product .wb_product_thumbnail{display:none !important;}";
        $wb_style .= ".wb_cart_single_product .wb_product_detail{width:90% !important;}";
    endif;
    if ($wb_product_image_width && $show_product_image == 'no'):
        $wb_style .= ".wb_cart_single_product .wb_product_thumbnail{width:" . $wb_product_image_width . "% !important;}";
    endif;
    if ($wb_content_width && $show_product_image == 'no'):
        $wb_style .= ".wb_cart_single_product .wb_product_detail{width:" . $wb_content_width . "% !important;}";
    endif;
    if (isset($wb_product_image_width) && isset($wb_content_width) && $show_product_image === 'yes'):
        $wb_style .= ".wb_cart_single_product .wb_product_thumbnail{width:" . $wb_product_image_width . "% !important;}";
        $wb_style .= ".wb_cart_single_product .wb_product_detail{width:" . $wb_content_width . "% !important;}";
    endif;
    if ($wb_remove_button_position):
        $wb_style .= ".wb_cart_single_product .wb_remove_button{vertical-align:" . $wb_remove_button_position . " !important;}";
    endif;
    if ($show_remove_button == 'no'):
        $wb_style .= ".wb_cart_single_product .wb_remove_product{display:none !important;}";
    endif;
    if ($wb_remove_button_color):
        $wb_style .= ".wb_cart_single_product .wb_remove_product i{color:" . $wb_remove_button_color . " !important;}";
    endif;
    if ($wb_remove_button_hover_color):
        $wb_style .= ".wb_cart_single_product .wb_remove_product i:hover{color:" . $wb_remove_button_hover_color . " !important;}";
    endif;
    $wb_style .= ".woobagcontainer .wb_product_detail{";
    if ($wb_content_text_color):
        $wb_style .= "color: " . $wb_content_text_color . " !important;";
    endif;
    if ($wb_content_text_position):
        $wb_style .= "text-align: " . $wb_content_text_position . " !important;";
    endif;
    if ($wb_content_text_padding_left):
        $wb_style .= "padding-left: " . $wb_content_text_padding_left . "px !important;";
    endif;
    $wb_style .= "}";
    if ($wb_item_title_color):
        $wb_style .= ".wb_cart_single_product .wb_product_name,.wb_cart_single_product .wb_product_name a{color: " . $wb_item_title_color . " !important;}";
    endif;
    return $wb_style;
}

/**
 * Subtotal Setting
 * 
 * @param Array $wb_all_option All Option of Single Setting
 * @param string $wb_template_name_part First Part of Setting Name
 * @return string
 */
function wb_subtotal_setting($wb_all_option, $wb_template_name_part) {
    $wb_style = '';
    $wb_section_id = 'subtotal_setting';

    $wb_subtotal_padding_left_right = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_subtotal_padding_left_right'];
    $wb_subtotal_vertical_position = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_subtotal_vertical_position'];
    $wb_subtotal_height = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_subtotal_height'];
    $show_subtotal = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'show_subtotal'];
    $wb_subtotal_position = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_subtotal_position'];
    $wb_subtotal_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_subtotal_color'];
    $subtotal_text_size = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'subtotal_text_size'];

    $wb_subtotal_border_top = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_subtotal_border_top'];
    $wb_subtotal_border_option = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_subtotal_border_option'];
    $wb_subtotal_border_width = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_subtotal_border_width'];
    $wb_subtotal_seprator_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_subtotal_seprator_color'];

    $wb_subtotal_button_position = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_subtotal_button_position'];

    $show_viewbag_button = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'show_viewbag_button'];
    $wb_viewbag_button_width = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_viewbag_button_width'];
    $wb_viewbag_button_height = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_viewbag_button_height'];
    $wb_viewbag_button_bg_option = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_viewbag_button_bg_option'];
    $wb_viewbag_button_bg_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_viewbag_button_bg_color'];
    $wb_viewbag_button_bg_image = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_viewbag_button_bg_image'];
    $wb_viewbag_button_bg_image_repeat = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_viewbag_button_bg_image_repeat'];
    $wb_viewbag_button_bg_image_position_x = (isset($wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_viewbag_button_bg_image_position_x'])) ? $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_viewbag_button_bg_image_position_x'] : 0;
    $wb_viewbag_button_bg_image_position_y = (isset($wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_viewbag_button_bg_image_position_y'])) ? $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_viewbag_button_bg_image_position_y'] : 0;
    $wb_viewbag_button_text_size = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_viewbag_button_text_size'];
    $wb_viewbag_button_text_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_viewbag_button_text_color'];
    $wb_viewbag_button_border_width = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_viewbag_button_border_width'];
    $wb_viewbag_button_border_radius = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_viewbag_button_border_radius'];
    $wb_viewbag_button_border_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_viewbag_button_border_color'];
    $wb_viewbag_button_border_style = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_viewbag_button_border_style'];
    $wb_viewbag_button_hover_border_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_viewbag_button_hover_border_color'];
    $wb_viewbag_button_hover_bg_option = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_viewbag_button_hover_bg_option'];
    $wb_viewbag_button_hover_bg_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_viewbag_button_hover_bg_color'];
    $wb_viewbag_button_hover_bg_image = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_viewbag_button_hover_bg_image'];
    $wb_viewbag_button_hover_bg_image_repeat = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_viewbag_button_hover_bg_image_repeat'];
    $wb_viewbag_button_hover_bg_image_position_x = (isset($wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_viewbag_button_hover_bg_image_position_x'])) ? $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_viewbag_button_hover_bg_image_position_x'] : 0;
    $wb_viewbag_button_hover_bg_image_position_y = (isset($wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_viewbag_button_hover_bg_image_position_y'])) ? $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_viewbag_button_hover_bg_image_position_y'] : 0;
    $wb_viewbag_button_hover_text_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_viewbag_button_hover_text_color'];

    $show_checkout_button = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'show_checkout_button'];
    $wb_checkout_button_width = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_checkout_button_width'];
    $wb_checkout_button_height = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_checkout_button_height'];
    $wb_checkout_button_bg_option = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_checkout_button_bg_option'];
    $wb_checkout_button_bg_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_checkout_button_bg_color'];
    $wb_checkout_button_bg_image = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_checkout_button_bg_image'];
    $wb_checkout_button_bg_image_repeat = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_checkout_button_bg_image_repeat'];
    $wb_checkout_button_bg_image_position_x = (isset($wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_checkout_button_bg_image_position_x'])) ? $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_checkout_button_bg_image_position_x'] : 0;
    $wb_checkout_button_bg_image_position_y = (isset($wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_checkout_button_bg_image_position_y'])) ? $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_checkout_button_bg_image_position_y'] : 0;
    $wb_checkout_button_text_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_checkout_button_text_color'];
    $wb_checkout_button_text_size = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_checkout_button_text_size'];
    $wb_checkout_button_border_radius = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_checkout_button_border_radius'];
    $wb_checkout_button_border_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_checkout_button_border_color'];
    $wb_checkout_button_border_style = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_checkout_button_border_style'];
    $wb_checkout_button_border_width = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_checkout_button_border_width'];
    $wb_checkout_button_hover_border_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_checkout_button_hover_border_color'];
    $wb_checkout_button_hover_bg_option = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_checkout_button_hover_bg_option'];
    $wb_checkout_button_hover_bg_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_checkout_button_hover_bg_color'];
    $wb_checkout_button_hover_bg_image = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_checkout_button_hover_bg_image'];
    $wb_checkout_button_hover_bg_image_repeat = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_checkout_button_hover_bg_image_repeat'];
    $wb_checkout_button_hover_bg_image_position_x = (isset($wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_checkout_button_hover_bg_image_position_x'])) ? $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_checkout_button_hover_bg_image_position_x'] : 0;
    $wb_checkout_button_hover_bg_image_position_y = (isset($wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_checkout_button_hover_bg_image_position_y'])) ? $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_checkout_button_hover_bg_image_position_y'] : 0;
    $wb_checkout_button_hover_text_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_checkout_button_hover_text_color'];

    $show_empty_cart_button = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'show_empty_cart_button'];
    $wb_empty_cart_button_width = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_empty_cart_button_width'];
    $wb_empty_cart_button_height = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_empty_cart_button_height'];
    $wb_empty_cart_button_bg_option = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_empty_cart_button_bg_option'];
    $wb_empty_cart_button_bg_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_empty_cart_button_bg_color'];
    $wb_empty_cart_button_bg_image = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_empty_cart_button_bg_image'];
    $wb_empty_cart_button_bg_image_repeat = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_empty_cart_button_bg_image_repeat'];
    $wb_empty_cart_button_bg_image_position_x = (isset($wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_empty_cart_button_bg_image_position_x'])) ? $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_empty_cart_button_bg_image_position_x'] : 0;
    $wb_empty_cart_button_bg_image_position_y = (isset($wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_empty_cart_button_bg_image_position_y'])) ? $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_empty_cart_button_bg_image_position_y'] : 0;
    $wb_empty_cart_button_text_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_empty_cart_button_text_color'];
    $wb_empty_cart_button_text_size = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_empty_cart_button_text_size'];
    $wb_empty_cart_button_border_radius = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_empty_cart_button_border_radius'];
    $wb_empty_cart_button_border_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_empty_cart_button_border_color'];
    $wb_empty_cart_button_border_style = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_empty_cart_button_border_style'];
    $wb_empty_cart_button_border_width = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_empty_cart_button_border_width'];
    $wb_empty_cart_button_hover_border_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_empty_cart_button_hover_border_color'];
    $wb_empty_cart_button_hover_bg_option = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_empty_cart_button_hover_bg_option'];
    $wb_empty_cart_button_hover_bg_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_empty_cart_button_hover_bg_color'];
    $wb_empty_cart_button_hover_bg_image = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_empty_cart_button_hover_bg_image'];
    $wb_empty_cart_button_hover_bg_image_repeat = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_empty_cart_button_hover_bg_image_repeat'];
    $wb_empty_cart_button_hover_bg_image_position_x = (isset($wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_empty_cart_button_hover_bg_image_position_x'])) ? $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_empty_cart_button_hover_bg_image_position_x'] : 0;
    $wb_empty_cart_button_hover_bg_image_position_y = (isset($wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_empty_cart_button_hover_bg_image_position_y'])) ? $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_empty_cart_button_hover_bg_image_position_y'] : 0;
    $wb_empty_cart_button_hover_text_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_empty_cart_button_hover_text_color'];

    $show_custom_button = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'show_custom_button'];
    $wb_custom_button_width = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_custom_button_width'];
    $wb_custom_button_height = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_custom_button_height'];
    $wb_custom_button_bg_option = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_custom_button_bg_option'];
    $wb_custom_button_bg_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_custom_button_bg_color'];
    $wb_custom_button_bg_image = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_custom_button_bg_image'];
    $wb_custom_button_bg_image_repeat = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_custom_button_bg_image_repeat'];
    $wb_custom_button_bg_image_position_x = (isset($wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_custom_button_bg_image_position_x'])) ? $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_custom_button_bg_image_position_x'] : 0;
    $wb_custom_button_bg_image_position_y = (isset($wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_custom_button_bg_image_position_y'])) ? $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_custom_button_bg_image_position_y'] : 0;
    $wb_custom_button_text_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_custom_button_text_color'];
    $wb_custom_button_text_size = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_custom_button_text_size'];
    $wb_custom_button_border_radius = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_custom_button_border_radius'];
    $wb_custom_button_border_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_custom_button_border_color'];
    $wb_custom_button_border_style = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_custom_button_border_style'];
    $wb_custom_button_border_width = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_custom_button_border_width'];
    $wb_custom_button_hover_border_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_custom_button_hover_border_color'];
    $wb_custom_button_hover_bg_option = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_custom_button_hover_bg_option'];
    $wb_custom_button_hover_bg_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_custom_button_hover_bg_color'];
    $wb_custom_button_hover_bg_image = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_custom_button_hover_bg_image'];
    $wb_custom_button_hover_bg_image_repeat = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_custom_button_hover_bg_image_repeat'];
    $wb_custom_button_hover_bg_image_position_x = (isset($wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_custom_button_hover_bg_image_position_x'])) ? $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_custom_button_hover_bg_image_position_x'] : 0;
    $wb_custom_button_hover_bg_image_position_y = (isset($wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_custom_button_hover_bg_image_position_y'])) ? $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_custom_button_hover_bg_image_position_y'] : 0;
    $wb_custom_button_hover_text_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_custom_button_hover_text_color'];

    $wb_style .= ".product_list_widget .wb_cart_total_wrapper{";
    if ($wb_subtotal_border_top === 'yes'):
        $wb_style .= 'border-top: ' . $wb_subtotal_border_width . 'px ' . $wb_subtotal_border_option . ' ' . $wb_subtotal_seprator_color . ' !important;';
    else:
        $wb_style .= 'border-top: 0 !important;';
    endif;
    if ($wb_subtotal_padding_left_right):
        $wb_style .= 'padding:0 ' . $wb_subtotal_padding_left_right . 'px !important;';
    endif;
    if ($wb_subtotal_height):
        $wb_style .= 'height:' . $wb_subtotal_height . 'px !important;';
    endif;
    if ($wb_subtotal_vertical_position):
        $wb_style .= 'vertical-align:' . $wb_subtotal_vertical_position . ' !important;';
    endif;
    $wb_style .= "}";

    if ($show_subtotal == 'no'):
        $wb_style .= ".wb_cart_total_wrapper .total{display:none !important;}";
        $wb_style .= ".wb_cart_total_wrapper {padding-top:10px !important;}";
    elseif ($show_subtotal == 'price_tax'):
        $wb_style .= ".wb_cart_total_wrapper .total .wb_subtotal_only_price{display:none !important;}";
    elseif ($show_subtotal == 'only_price'):
        $wb_style .= ".wb_cart_total_wrapper .total .wb_total_content_table{display:none !important;}";

    endif;
    if ($wb_subtotal_color):
        $wb_style .= ".wb_cart_total_wrapper .total{color: " . $wb_subtotal_color . " !important;}";
    endif;
    $wb_style .= ".wb_cart_total_wrapper .total{text-align: " . $wb_subtotal_position . " !important;}";
    if ($subtotal_text_size):
        $wb_style .= ".wb_cart_total_wrapper .total{font-size: " . $subtotal_text_size . "px !important;}";
    endif;
    if ($show_viewbag_button == 'no' && $show_checkout_button == 'no' && $show_empty_cart_button == 'no' && $show_custom_button == 'no'):
        $wb_style .= ".wb_cart_total_wrapper .buttons{display:none !important;}";
    endif;
    if ($wb_subtotal_button_position):
        $wb_style .= ".wb_cart_total_wrapper .buttons{text-align:" . $wb_subtotal_button_position . " !important;}";
    endif;
    if ($show_viewbag_button == 'no'):
        $wb_style .= ".wb_cart_total_wrapper .buttons .wb_viewbag_button{display:none !important;}";
    endif;
    $wb_style .= ".wb_cart_total_wrapper .buttons .wb_viewbag_button{";

    if ($wb_viewbag_button_bg_image && ($wb_viewbag_button_bg_option === 'image' || $wb_viewbag_button_bg_option === 'both')):
        $wb_style .= "background-image: url('" . $wb_viewbag_button_bg_image . "') !important;background-repeat: " . $wb_viewbag_button_bg_image_repeat . " !important;";
        $wb_style .= "background-position: " . $wb_viewbag_button_bg_image_position_x . "px " . $wb_viewbag_button_bg_image_position_y . "px !important;";
    else:
        if ($wb_viewbag_button_bg_image !== 'both'):
            $wb_style .= "background:transparent  !important;";
        endif;
    endif;
    if ($wb_viewbag_button_bg_color && ($wb_viewbag_button_bg_option === 'color' || $wb_viewbag_button_bg_option === 'both')):
        $wb_style .= "background-color:" . $wb_viewbag_button_bg_color . " !important;";
    else:
        if ($wb_viewbag_button_bg_image !== 'both'):
            $wb_style .= "background-color:transparent  !important;";
        endif;
    endif;
    if ($wb_viewbag_button_bg_option === 'no'):
        $wb_style .= "background:transparent !important;";
    endif;
    $wb_style .= "border-radius:" . $wb_viewbag_button_border_radius . "px !important;"
            . "font-size: " . $wb_viewbag_button_text_size . "px !important;"
            . "color: " . $wb_viewbag_button_text_color . " !important;";
    $wb_style .= 'border: ' . $wb_viewbag_button_border_width . 'px ' . $wb_viewbag_button_border_style . ' ' . $wb_viewbag_button_border_color . ' !important;';
    $wb_style .= "}";
    $wb_style .= ".wb_cart_total_wrapper .buttons .wb_viewbag_button span{";
    if ($wb_viewbag_button_width):
        $wb_style .= "width:" . $wb_viewbag_button_width . "px !important;";
    endif;
    if ($wb_viewbag_button_height):
        $wb_style .= "height:" . $wb_viewbag_button_height . "px !important;";
    else:
        $wb_style .= "height: inherit !important;";
    endif;
    $wb_style .= "}";
    $wb_style .= ".wb_cart_total_wrapper .buttons .wb_viewbag_button:hover{";
    $wb_style .= "color:" . $wb_viewbag_button_hover_text_color . " !important;"
            . "border-color:" . $wb_viewbag_button_hover_border_color . " !important;";
    if ($wb_viewbag_button_hover_bg_image && $wb_viewbag_button_hover_bg_image !== '#' && $wb_viewbag_button_hover_bg_option === 'image'):
        $wb_style .= "background-image: url('" . $wb_viewbag_button_hover_bg_image . "') !important;background-repeat: " . $wb_viewbag_button_hover_bg_image_repeat . " !important;";
        $wb_style .= "background-position: " . $wb_viewbag_button_hover_bg_image_position_x . "px " . $wb_viewbag_button_hover_bg_image_position_y . "px !important;";
    else:
        if ($wb_viewbag_button_hover_bg_option !== 'both'):
            $wb_style .= "background:transparent  !important;";
        endif;
    endif;
    if ($wb_viewbag_button_hover_bg_color && $wb_viewbag_button_hover_bg_option === 'color'):
        $wb_style .= "background-color:" . $wb_viewbag_button_hover_bg_color . " !important;";
    else:
        if ($wb_viewbag_button_hover_bg_option !== 'both'):
            $wb_style .= "background-color:transparent  !important;";
        endif;
    endif;
    if ($wb_viewbag_button_hover_bg_option === 'both'):
        $wb_style .= "background-image: url('" . $wb_viewbag_button_hover_bg_image . "') !important;background-repeat: " . $wb_viewbag_button_hover_bg_image_repeat . " !important;";
        $wb_style .= "background-position: " . $wb_viewbag_button_hover_bg_image_position_x . "px " . $wb_viewbag_button_hover_bg_image_position_y . "px !important;";
        $wb_style .= "background-color:" . $wb_viewbag_button_hover_bg_color . " !important;";
    endif;
    if ($wb_viewbag_button_hover_bg_option === 'no'):
        $wb_style .= "background: transparent !important;";
    endif;
    $wb_style .= "}";

    if ($show_checkout_button == 'no'):
        $wb_style .= ".wb_cart_total_wrapper .buttons .wb_checkout_button{display:none !important;}";
    endif;
    $wb_style .= ".wb_cart_total_wrapper .buttons .wb_checkout_button{";

    if ($wb_checkout_button_bg_image && ($wb_checkout_button_bg_option === 'image' || $wb_checkout_button_bg_option === 'both')):
        $wb_style .= "background-image: url('" . $wb_checkout_button_bg_image . "') !important;background-repeat: " . $wb_checkout_button_bg_image_repeat . " !important;";
        $wb_style .= "background-position: " . $wb_checkout_button_bg_image_position_x . "px " . $wb_checkout_button_bg_image_position_y . "px !important;";
    else:
        if ($wb_checkout_button_bg_image !== 'both'):
            $wb_style .= "background:transparent  !important;";
        endif;
    endif;
    if ($wb_checkout_button_bg_color && ($wb_checkout_button_bg_option === 'color' || $wb_checkout_button_bg_option === 'both')):
        $wb_style .= "background-color:" . $wb_checkout_button_bg_color . " !important;";
    else:
        if ($wb_checkout_button_bg_image !== 'both'):
            $wb_style .= "background-color:transparent  !important;";
        endif;
    endif;
    if ($wb_checkout_button_bg_option === 'no'):
        $wb_style .= "background:transparent !important;";
    endif;
    $wb_style .= "border-radius:" . $wb_checkout_button_border_radius . "px !important;"
            . "font-size:  " . $wb_checkout_button_text_size . "px !important;"
            . "color:  " . $wb_checkout_button_text_color . " !important;";
    $wb_style .= 'border: ' . $wb_checkout_button_border_width . 'px ' . $wb_checkout_button_border_style . ' ' . $wb_checkout_button_border_color . ' !important;';
    $wb_style .= "}";
    $wb_style .= ".wb_cart_total_wrapper .buttons .wb_checkout_button span{";
    if ($wb_checkout_button_width):
        $wb_style .= "width:" . $wb_checkout_button_width . "px !important;";
    endif;
    if ($wb_checkout_button_height):
        $wb_style .= "height:" . $wb_checkout_button_height . "px !important;";
    else:
        $wb_style .= "height: inherit !important;";
    endif;
    $wb_style .= "}";

    $wb_style .= ".wb_cart_total_wrapper .buttons .wb_checkout_button:hover{";

    if ($wb_checkout_button_hover_bg_image && $wb_checkout_button_hover_bg_image !== '#' && $wb_checkout_button_hover_bg_option === 'image'):
        $wb_style .= "background-image: url('" . $wb_checkout_button_hover_bg_image . "') !important;background-repeat: " . $wb_checkout_button_hover_bg_image_repeat . " !important;";
        $wb_style .= "background-position: " . $wb_checkout_button_hover_bg_image_position_x . "px " . $wb_checkout_button_hover_bg_image_position_y . "px !important;";
    else:
        if ($wb_checkout_button_hover_bg_image !== 'both'):
            $wb_style .= "background:transparent  !important;";
        endif;
    endif;
    if ($wb_checkout_button_hover_bg_color && $wb_checkout_button_hover_bg_option === 'color'):
        $wb_style .= "background-color:" . $wb_checkout_button_hover_bg_color . " !important;";
    else:
        if ($wb_checkout_button_hover_bg_image !== 'both'):
            $wb_style .= "background-color:transparent  !important;";
        endif;
    endif;
    if ($wb_checkout_button_hover_bg_option === 'both'):
        $wb_style .= "background-image: url('" . $wb_checkout_button_hover_bg_image . "') !important;background-repeat: " . $wb_checkout_button_hover_bg_image_repeat . " !important;";
        $wb_style .= "background-position: " . $wb_checkout_button_hover_bg_image_position_x . "px " . $wb_checkout_button_hover_bg_image_position_y . "px !important;";
        $wb_style .= "background-color:" . $wb_checkout_button_hover_bg_color . " !important;";
    endif;
    if ($wb_checkout_button_hover_bg_option === 'no'):
        $wb_style .= "background: transparent !important;";
    endif;
    $wb_style .= "color:" . $wb_checkout_button_hover_text_color . " !important;"
            . "border-color:" . $wb_checkout_button_hover_border_color . " !important;";

    $wb_style .= "}";

    if ($show_empty_cart_button == 'no'):
        $wb_style .= ".wb_cart_total_wrapper .buttons .wb_empty_cart_button{display:none !important;}";
    endif;
    $wb_style .= ".wb_cart_total_wrapper .buttons .wb_empty_cart_button{";
    if ($wb_empty_cart_button_bg_image && ($wb_empty_cart_button_bg_option === 'image' || $wb_empty_cart_button_bg_option === 'both')):
        $wb_style .= "background-image: url('" . $wb_empty_cart_button_bg_image . "') !important;background-repeat: " . $wb_empty_cart_button_bg_image_repeat . " !important;";
        $wb_style .= "background-position: " . $wb_empty_cart_button_bg_image_position_x . "px " . $wb_empty_cart_button_bg_image_position_y . "px !important;";
    else:
        if ($wb_empty_cart_button_bg_image !== 'both'):
            $wb_style .= "background:transparent  !important;";
        endif;
    endif;
    if ($wb_empty_cart_button_bg_color && ($wb_empty_cart_button_bg_option === 'color' || $wb_empty_cart_button_bg_option === 'both')):
        $wb_style .= "background-color:" . $wb_empty_cart_button_bg_color . " !important;";
    else:
        if ($wb_empty_cart_button_bg_image !== 'both'):
            $wb_style .= "background-color:transparent  !important;";
        endif;
    endif;
    if ($wb_empty_cart_button_bg_option === 'no'):
        $wb_style .= "background:transparent !important;";
    endif;
    $wb_style .= "border-radius:" . $wb_empty_cart_button_border_radius . "px !important;"
            . "font-size: " . $wb_empty_cart_button_text_size . "px !important;"
            . "color: " . $wb_empty_cart_button_text_color . " !important;";
    $wb_style .= 'border: ' . $wb_empty_cart_button_border_width . 'px ' . $wb_empty_cart_button_border_style . ' ' . $wb_empty_cart_button_border_color . ' !important;';
    $wb_style .= "}";
    $wb_style .= ".wb_cart_total_wrapper .buttons .wb_empty_cart_button span{";
    if ($wb_empty_cart_button_width):
        $wb_style .= "width:" . $wb_empty_cart_button_width . "px !important;";
    endif;
    if ($wb_empty_cart_button_height):
        $wb_style .= "height:" . $wb_empty_cart_button_height . "px !important;";
    else:
        $wb_style .= "height: inherit !important;";
    endif;
    $wb_style .= "}";

    $wb_style .= ".wb_cart_total_wrapper .buttons .wb_empty_cart_button:hover{";
    if ($wb_empty_cart_button_hover_bg_image && $wb_empty_cart_button_hover_bg_image !== '#' && $wb_empty_cart_button_hover_bg_option === 'image'):
        $wb_style .= "background-image: url('" . $wb_empty_cart_button_hover_bg_image . "') !important;background-repeat: " . $wb_empty_cart_button_hover_bg_image_repeat . " !important;";
        $wb_style .= "background-position: " . $wb_empty_cart_button_hover_bg_image_position_x . "px " . $wb_empty_cart_button_hover_bg_image_position_y . "px !important;";
    else:
        if ($wb_empty_cart_button_hover_bg_image !== 'both'):
            $wb_style .= "background:transparent  !important;";
        endif;
    endif;
    if ($wb_empty_cart_button_hover_bg_color && $wb_empty_cart_button_hover_bg_option === 'color'):
        $wb_style .= "background-color:" . $wb_empty_cart_button_hover_bg_color . " !important;";
    else:
        if ($wb_empty_cart_button_hover_bg_image !== 'both'):
            $wb_style .= "background-color:transparent  !important;";
        endif;
    endif;
    if ($wb_empty_cart_button_hover_bg_option === 'both'):
        $wb_style .= "background-image: url('" . $wb_empty_cart_button_hover_bg_image . "') !important;background-repeat: " . $wb_empty_cart_button_hover_bg_image_repeat . " !important;";
        $wb_style .= "background-position: " . $wb_empty_cart_button_hover_bg_image_position_x . "px " . $wb_empty_cart_button_hover_bg_image_position_y . "px !important;";
        $wb_style .= "background-color:" . $wb_empty_cart_button_hover_bg_color . " !important;";
    endif;
    if ($wb_empty_cart_button_hover_bg_option === 'no'):
        $wb_style .= "background: transparent !important;";
    endif;
    $wb_style .= "color:" . $wb_empty_cart_button_hover_text_color . " !important;"
            . "border-color:" . $wb_empty_cart_button_hover_border_color . " !important;";

    $wb_style .= "}";

    if ($show_custom_button == 'no'):
        $wb_style .= ".wb_cart_total_wrapper .buttons .wb_custom_button{display:none !important;}";
    endif;
    $wb_style .= ".wb_cart_total_wrapper .buttons .wb_custom_button{";
    if ($wb_custom_button_bg_image && ($wb_custom_button_bg_option === 'image' || $wb_custom_button_bg_option === 'both')):
        $wb_style .= "background-image: url('" . $wb_custom_button_bg_image . "') !important;background-repeat: " . $wb_custom_button_bg_image_repeat . " !important;";
        $wb_style .= "background-position: " . $wb_custom_button_bg_image_position_x . "px " . $wb_custom_button_bg_image_position_y . "px !important;";
    else:
        if ($wb_custom_button_bg_image !== 'both'):
            $wb_style .= "background:transparent  !important;";
        endif;
    endif;
    if ($wb_custom_button_bg_color && ($wb_custom_button_bg_option === 'color' || $wb_custom_button_bg_option === 'both')):
        $wb_style .= "background-color:" . $wb_custom_button_bg_color . " !important;";
    else:
        if ($wb_custom_button_bg_image !== 'both'):
            $wb_style .= "background-color:transparent  !important;";
        endif;
    endif;
    if ($wb_custom_button_bg_option === 'no'):
        $wb_style .= "background:transparent !important;";
    endif;
    $wb_style .= "border-radius:" . $wb_custom_button_border_radius . "px !important;"
            . "font-size: " . $wb_custom_button_text_size . "px !important;"
            . "color: " . $wb_custom_button_text_color . " !important;";
    $wb_style .= 'border: ' . $wb_custom_button_border_width . 'px ' . $wb_custom_button_border_style . ' ' . $wb_custom_button_border_color . ' !important;';

    $wb_style .= "}";
    $wb_style .= ".wb_cart_total_wrapper .buttons .wb_custom_button span{";
    if ($wb_custom_button_width):
        $wb_style .= "width:" . $wb_custom_button_width . "px !important;";
    endif;
    if ($wb_custom_button_height):
        $wb_style .= "height:" . $wb_custom_button_height . "px !important;";
    else:
        $wb_style .= "height: inherit !important;";
    endif;
    $wb_style .= "}";

    $wb_style .= ".wb_cart_total_wrapper .buttons .wb_custom_button:hover{";
    if ($wb_custom_button_hover_bg_image && $wb_custom_button_hover_bg_image !== '#' && $wb_custom_button_hover_bg_option === 'image'):
        $wb_style .= "background-image: url('" . $wb_custom_button_hover_bg_image . "') !important;background-repeat: " . $wb_custom_button_hover_bg_image_repeat . " !important;";
        $wb_style .= "background-position: " . $wb_custom_button_hover_bg_image_position_x . "px " . $wb_custom_button_hover_bg_image_position_y . "px !important;";
    else:
        if ($wb_custom_button_hover_bg_image !== 'both'):
            $wb_style .= "background:transparent  !important;";
        endif;
    endif;
    if ($wb_custom_button_hover_bg_color && $wb_custom_button_hover_bg_option === 'color'):
        $wb_style .= "background-color:" . $wb_custom_button_hover_bg_color . " !important;";
    else:
        if ($wb_custom_button_hover_bg_image !== 'both'):
            $wb_style .= "background-color:transparent  !important;";
        endif;
    endif;
    if ($wb_custom_button_hover_bg_option === 'both'):
        $wb_style .= "background-image: url('" . $wb_custom_button_hover_bg_image . "') !important;background-repeat: " . $wb_custom_button_hover_bg_image_repeat . " !important;";
        $wb_style .= "background-position: " . $wb_custom_button_hover_bg_image_position_x . "px " . $wb_custom_button_hover_bg_image_position_y . "px !important;";
        $wb_style .= "background-color:" . $wb_custom_button_hover_bg_color . " !important;";
    endif;
    if ($wb_custom_button_hover_bg_option === 'no'):
        $wb_style .= "background: transparent !important;";
    endif;
    $wb_style .= "color:" . $wb_custom_button_hover_text_color . " !important;"
            . "border-color:" . $wb_custom_button_hover_border_color . " !important;";
    $wb_style .= "}";

    return $wb_style;
}

/**
 * Footer Setting
 * 
 * @param Array $wb_all_option All Option of Single Setting
 * @param string $wb_template_name_part First Part of Setting Name
 * @return string
 */
function wb_footer_setting($wb_all_option, $wb_template_name_part) {
    $wb_style = '';
    $wb_section_id = 'footer_setting';

    $wb_show_footer = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_show_footer'];
    $footer_text_position = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'footer_text_position'];
    $footer_text_vertical_position = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'footer_text_vertical_position'];
    $wb_footer_height = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_footer_height'];
    $wb_footer_bg_option = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_footer_bg_option'];
    $wb_footer_bg_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_footer_bg_color'];
    $wb_footer_bg_image = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_footer_bg_image'];
    $wb_footer_bg_image_repeat = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_footer_bg_image_repeat'];
    $wb_footer_bg_image_position_x = (isset($wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_footer_bg_image_position_x'])) ? $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_footer_bg_image_position_x'] : 0;
    $wb_footer_bg_image_position_y = (isset($wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_footer_bg_image_position_y'])) ? $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_footer_bg_image_position_y'] : 0;
    $wb_footer_text_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_footer_text_color'];
    $wb_footer_text_size = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_footer_text_size'];

    $wb_footer_border_top = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_footer_border_top'];
    $wb_footer_border_option = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_footer_border_option'];
    $wb_footer_border_width = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_footer_border_width'];
    $wb_footer_seprator_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_footer_seprator_color'];

    $wb_style .= '.product_list_widget .wb_window_bottom{';
    if ($wb_show_footer === 'no'):
        $wb_style .= 'display: none !important;';
    endif;
    if ($wb_footer_bg_image && ($wb_footer_bg_option === 'image' || $wb_footer_bg_option === 'both')):
        $wb_style .= "background-image: url('" . $wb_footer_bg_image . "');background-repeat: " . $wb_footer_bg_image_repeat . ";";
        $wb_style .= "background-position: " . $wb_footer_bg_image_position_x . "px " . $wb_footer_bg_image_position_y . "px !important;";
    endif;
    if ($wb_footer_bg_color && ($wb_footer_bg_option === 'color' || $wb_footer_bg_option === 'both')):
        $wb_style .= 'background-color: ' . $wb_footer_bg_color . ' !important;';
    endif;
    if ($wb_footer_border_top === 'yes'):
        $wb_style .= 'border-top: ' . $wb_footer_border_width . 'px ' . $wb_footer_border_option . ' ' . $wb_footer_seprator_color . ' !important;';
    else:
        $wb_style .= 'border-top: 0 !important;';
    endif;
    if ($wb_footer_height):
        $wb_style .= 'height: ' . $wb_footer_height . 'px !important;';
    endif;
    $wb_style .= 'vertical-align : ' . $footer_text_vertical_position . ' !important; ';
    $wb_style .= '}';
    $wb_style .= '.wb_window_bottom .wb_bottom_text{';
    if ($wb_footer_text_color):
        $wb_style .= 'color : ' . $wb_footer_text_color . '  !important; ';
    endif;
    if ($wb_footer_text_size):
        $wb_style .= 'font-size : ' . $wb_footer_text_size . 'px  !important; ';
    endif;
    $wb_style .= 'text-align : ' . $footer_text_position . ' !important; ';

    $wb_style .= '}';
    return $wb_style;
}

/**
 * Scroller Setting
 * 
 * @param Array $wb_all_option All Option of Single Setting
 * @param string $wb_template_name_part First Part of Setting Name
 * @return string
 */
function wb_scroll_setting($wb_all_option, $wb_template_name_part) {

    $wb_style = '';
    $wb_section_id = 'scroll_setting';
    $wb_scroll_option = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_scroll_option'];
    $wb_scroll_wheel_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_scroll_wheel_color'];

    $wb_scroll_padding_left_right = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_scroll_padding_left_right'];
    $wb_scroll_width = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_scroll_width'];
    $wb_scroll_position = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_scroll_position'];
    $wb_scroll_bg_option = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_scroll_bg_option'];
    $wb_scroll_bg_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_scroll_bg_color'];
    $wb_scroll_bg_image = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_scroll_bg_image'];
    $wb_scroll_bg_image_repeat = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_scroll_bg_image_repeat'];
    $wb_scroll_bg_image_position_x = (isset($wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_scroll_bg_image_position_x'])) ? $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_scroll_bg_image_position_x'] : 0;
    $wb_scroll_bg_image_position_y = (isset($wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_scroll_bg_image_position_y'])) ? $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_scroll_bg_image_position_y'] : 0;
    $wb_scroll_arrow_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_scroll_arrow_color'];
    $wb_scroll_hover_bg_option = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_scroll_hover_bg_option'];
    $wb_scroll_hover_bg_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_scroll_hover_bg_color'];
    $wb_scroll_hover_bg_image = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_scroll_hover_bg_image'];
    $wb_scroll_hover_bg_image_repeat = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_scroll_hover_bg_image_repeat'];
    $wb_scroll_hover_bg_image_position_x = (isset($wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_scroll_hover_bg_image_position_x'])) ? $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_scroll_hover_bg_image_position_x'] : 0;
    $wb_scroll_hover_bg_image_position_y = (isset($wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_scroll_hover_bg_image_position_y'])) ? $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_scroll_hover_bg_image_position_y'] : 0;
    $wb_scroll_arrow_hover_color = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'wb_scroll_arrow_hover_color'];

    if ($wb_scroll_option == 'wheel'):
        $wb_style .= ".wb_scroll_button{display:none !important;}";
        $wb_style .= "#bag_carousel_prev, #bag_carousel_next{display:none !important;}";
        $wb_style .= ".woobagcontainer{padding-right:0 !important;}";
        if ($wb_scroll_wheel_color):
            $wb_style .= ".mCS-minimal-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{background-color:" . $wb_scroll_wheel_color . " !important;}";
            $wb_style .= ".mCS-minimal-dark.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar, 
                        .mCS-minimal-dark.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar{
                        background-color:" . $wb_scroll_wheel_color . " !important;"
                    . "}";
        endif;
    endif;
    $wb_style .= ".product_list_widget .wb_scroll_button_wrapper{";
    if ($wb_scroll_position):
        $wb_style .= "text-align:" . $wb_scroll_position . " !important;";
    endif;
    if ($wb_scroll_padding_left_right):
        $wb_style .= "padding:0 " . $wb_scroll_padding_left_right . "px !important;";
    endif;
    $wb_style .= "}";
    $wb_style .= ".wb_scroll_button_wrapper .wb_scroll_button{";

    if ($wb_scroll_width):
        $wb_style .= "width:" . $wb_scroll_width . "% !important;";
    endif;
    if ($wb_scroll_bg_image && ($wb_scroll_bg_option === 'image')):
        $wb_style .= "background-image: url('" . $wb_scroll_bg_image . "') !important;background-repeat: " . $wb_scroll_bg_image_repeat . " !important;";
        $wb_style .= "background-position: " . $wb_scroll_bg_image_position_x . "px " . $wb_scroll_bg_image_position_y . "px !important;";
    else:
        if ($wb_scroll_bg_option !== 'both'):
            $wb_style .= "background:transparent !important;";
        endif;
    endif;
    if ($wb_scroll_bg_color && ($wb_scroll_bg_option === 'color')):
        $wb_style .= "background-color:" . $wb_scroll_bg_color . " !important;";
    else:
        if ($wb_scroll_bg_option !== 'both'):
            $wb_style .= "background-color:transparent !important;";
        endif;
    endif;
    if ($wb_scroll_bg_option === 'both'):
        $wb_style .= "background-image: url('" . $wb_scroll_bg_image . "') !important;background-repeat: " . $wb_scroll_bg_image_repeat . " !important;";
        $wb_style .= "background-position: " . $wb_scroll_bg_image_position_x . "px " . $wb_scroll_bg_image_position_y . "px !important;";
        $wb_style .= "background-color:" . $wb_scroll_bg_color . " !important;";
    endif;
    if ($wb_scroll_bg_option === 'no'):
        $wb_style .= "background:transparent !important;";
    endif;
    $wb_style .= "}";
    $wb_style .= ".wb_scroll_button_wrapper .wb_scroll_button:hover{";

    if ($wb_scroll_hover_bg_image && ($wb_scroll_hover_bg_option === 'image')):
        $wb_style .= "background-image: url('" . $wb_scroll_hover_bg_image . "') !important;background-repeat: " . $wb_scroll_hover_bg_image_repeat . " !important;";
        $wb_style .= "background-position: " . $wb_scroll_hover_bg_image_position_x . "px " . $wb_scroll_hover_bg_image_position_y . "px !important;";
        $wb_style .= "background-color:transparent !important;";
    endif;
    if ($wb_scroll_hover_bg_color && ($wb_scroll_hover_bg_option === 'color')):
        $wb_style .= "background:transparent !important;";
        $wb_style .= "background-color:" . $wb_scroll_hover_bg_color . " !important;";
    endif;
    if ($wb_scroll_hover_bg_option === 'both'):
        $wb_style .= "background-image: url('" . $wb_scroll_hover_bg_image . "') !important;background-repeat: " . $wb_scroll_hover_bg_image_repeat . " !important;";
        $wb_style .= "background-position: " . $wb_scroll_hover_bg_image_position_x . "px " . $wb_scroll_hover_bg_image_position_y . "px !important;";
        $wb_style .= "background-color:" . $wb_scroll_hover_bg_color . " !important;";
    endif;
    if ($wb_scroll_hover_bg_option === 'no'):
        $wb_style .= "background:transparent !important;";
    endif;
    $wb_style .= "}";
    if ($wb_scroll_arrow_color):
        $wb_style .= ".wb_scroll_button_wrapper .wb_scroll_button i{color:" . $wb_scroll_arrow_color . " !important;}";
    endif;
    if ($wb_scroll_arrow_hover_color):
        $wb_style .= ".wb_scroll_button:hover i{color:" . $wb_scroll_arrow_hover_color . " !important;}";
    endif;
    return $wb_style;
}


/**
 * Write Custom Style To CSS File
 */
function wb_write_user_style($wb_call_option = NULL, $wb_setting_name = NULL) {
    if (!$wb_setting_name):
        $wb_setting_name = WB()->wb_get_setting_name($wb_call_option);
    endif;
    $wb_all_option = wb_get_all_setting($wb_setting_name);
    $wb_template_name_part = WB()->wb_get_setting_name('new');
    /**
     * General/Product/Subtotal Setting
     */
    $title_font = $wb_all_option[$wb_template_name_part . '_product_setting_title_font'];
    $content_font = $wb_all_option[$wb_template_name_part . '_product_setting_content_font'];
    $viewbag_button_font = $wb_all_option[$wb_template_name_part . '_subtotal_setting_viewbag_button_font'];
    $checkout_button_font = $wb_all_option[$wb_template_name_part . '_subtotal_setting_checkout_button_font'];
    $empty_cart_button_font = $wb_all_option[$wb_template_name_part . '_subtotal_setting_empty_cart_button_font'];
    $custom_button_font = $wb_all_option[$wb_template_name_part . '_subtotal_setting_custom_button_font'];
    $subtotal_text_font = $wb_all_option[$wb_template_name_part . '_subtotal_setting_subtotal_text_font'];
    $footer_font = $wb_all_option[$wb_template_name_part . '_footer_setting_footer_font'];
    $header_font = $wb_all_option[$wb_template_name_part . '_header_setting_header_font'];
    $wb_custom_css = $wb_all_option[$wb_template_name_part . '_custom_setting_wb_custom_css'];
    $wb_woobag_custom_width = $wb_all_option[$wb_template_name_part . '_general_setting_' . 'wb_woobag_custom_width'];
    if (!$wb_woobag_custom_width):
        $wb_woobag_custom_width = '351';
    endif;


    $wb_user_style = '';


    if ($viewbag_button_font):
        $wb_user_style .= '@import url("http://fonts.googleapis.com/css?family=' . $viewbag_button_font . '" );';
    endif;

    if ($checkout_button_font):
        $wb_user_style .= '@import url("http://fonts.googleapis.com/css?family=' . $checkout_button_font . '" );';
    endif;
    if ($empty_cart_button_font):
        $wb_user_style .= '@import url("http://fonts.googleapis.com/css?family=' . $empty_cart_button_font . '" );';
    endif;
    if ($custom_button_font):
        $wb_user_style .= '@import url("http://fonts.googleapis.com/css?family=' . $custom_button_font . '" );';
    endif;
    if ($subtotal_text_font):
        $wb_user_style .= '@import url("http://fonts.googleapis.com/css?family=' . $subtotal_text_font . '" );';
    endif;
    if ($header_font):
        $wb_user_style .= '@import url("http://fonts.googleapis.com/css?family=' . $header_font . '" );';
    endif;
    if ($footer_font):
        $wb_user_style .= '@import url("http://fonts.googleapis.com/css?family=' . $footer_font . '" );';
    endif;

    if ($content_font):
        $wb_user_style .= '@import url("http://fonts.googleapis.com/css?family=' . $content_font . '" );';
        $wb_user_style .= "";
    endif;
    if ($title_font):
        $wb_user_style .= '@import url("http://fonts.googleapis.com/css?family=' . $title_font . '" );';
    endif;

    if ($viewbag_button_font):
        $wb_user_style .= ".wb_cart_total_wrapper .buttons .wb_viewbag_button span{font-family: " . $viewbag_button_font . "!important;}";
    endif;

    if ($checkout_button_font):
        $wb_user_style .= ".wb_cart_total_wrapper .buttons .wb_checkout_button span{font-family: " . $checkout_button_font . "!important;}";
    endif;
    if ($empty_cart_button_font):
        $wb_user_style .= ".wb_cart_total_wrapper .buttons .wb_empty_cart_button span{font-family: " . $empty_cart_button_font . "!important;}";
    endif;
    if ($custom_button_font):
        $wb_user_style .= ".wb_cart_total_wrapper .buttons .wb_custom_button span{font-family: " . $custom_button_font . "!important;}";
    endif;
    if ($subtotal_text_font):
        $wb_user_style .= ".wb_cart_total_wrapper .total .wb_total_content_table strong, "
                . ".wb_cart_total_wrapper .total .wb_total_content_table span, "
                . ".wb_cart_total_wrapper .total .wb_subtotal_only_price strong, "
                . ".wb_cart_total_wrapper .total .wb_subtotal_only_price span{font-family: " . $subtotal_text_font . "!important;}";
    endif;
    if ($header_font):
        $wb_user_style .= ".wb_window_top .wb_top_text span{font-family: " . $header_font . "!important;}";
        $wb_user_style .= ".wb_window_top .wb_top_text b{font-family: " . $header_font . "!important;}";
    endif;
    if ($footer_font):
        $wb_user_style .= ".wb_window_bottom .wb_bottom_text{font-family: " . $footer_font . "!important;}";
    endif;

    if ($content_font):
        $wb_user_style .= ".wb_product_detail .quantity,"
                . ".wb_product_detail .wb_quantity_label,"
                . ".wb_product_detail .wb_total_quentity,"
                . ".wb_product_detail .wb_custom_attributes .wb_custom_single,"
                . ".wb_product_detail .price,"
                . ".wb_product_detail .price span,"
                . ".wb_product_detail .wb_currency,"
                . ".wb_product_detail .wb_product_amount,"
                . ".wb_product_detail .wb_saving_percentage,"
                . ".wb_product_detail .wb_tax_per_item"
                . " {font-family: " . $content_font . "!important;}";
    endif;
    if ($title_font):
        $wb_user_style .= ".wb_product_detail .wb_product_name a{font-family: " . $title_font . "!important;}";
    endif;

    $wb_user_style .= wb_general_setting($wb_all_option, $wb_template_name_part);
    $wb_user_style .= wb_header_setting($wb_all_option, $wb_template_name_part);
    $wb_user_style .= wb_product_setting($wb_all_option, $wb_template_name_part);
    $wb_user_style .= wb_subtotal_setting($wb_all_option, $wb_template_name_part);
    $wb_user_style .= wb_footer_setting($wb_all_option, $wb_template_name_part);
    $wb_user_style .= wb_scroll_setting($wb_all_option, $wb_template_name_part);

    if ($wb_custom_css):
        $wb_user_style .= '/****Custom CSS Start****/' . $wb_custom_css . '/***** Custom CSS End****/';
    endif;
    $wb_user_style .= '@media (max-width: ' . $wb_woobag_custom_width . 'px) {
            #wb_all_content_in_footer .wb_display_widget_cart, .wb_display_widget_cart_shortcode .wb_display_widget_cart{
                width:90% !important;
            }
        }';

    $wb_user_file = WB()->wb_get_setting_name('new');
    if ($wb_call_option == 'activate_template' || $wb_call_option == 'activate' || $wb_call_option == 'new'):
        $wb_file_path = WB()->wb_plugin_path() . '/public/css/';
        $wb_file_name = wb_create_file_name() . '.css';
        $wb_file_db_name = $wb_user_file . '_active_style';
        $wb_old_file_name = get_option($wb_file_db_name);
        wb_write_file_content($wb_file_path, $wb_user_style, $wb_file_name, $wb_file_db_name, $wb_old_file_name);
        $wb_file_path = WB()->wb_plugin_path() . '/admin/css/';
        wb_write_file_content($wb_file_path, str_replace('!important', '', $wb_user_style), $wb_file_name, $wb_file_db_name, $wb_old_file_name);
    else:
        $wb_file_path = WB()->wb_plugin_path() . '/admin/css/';
        $wb_file_name = wb_create_file_name() . '.css';
        $wb_file_db_name = $wb_user_file . '_edit_style';
        $wb_old_file_name = get_option($wb_file_db_name);
        wb_write_file_content($wb_file_path, str_replace('!important', '', $wb_user_style), $wb_file_name, $wb_file_db_name, $wb_old_file_name);
    endif;
    wb_write_user_script($wb_call_option, $wb_setting_name);
    return;
}

/**
 * This is create unquie file name everytime
 * 
 * @return String
 */
function wb_create_file_name() {
    $wb_user_file = WB()->wb_get_setting_name('new');
    $current_time = time();
    return $wb_user_file . '_' . $current_time;
}

/**
 * Write content in file
 * 
 * @param string $wb_file_path Full path of file
 * @param string $file_content content of the file
 * @param string $wb_file_name name of the file
 * @param string $wb_file_db_name Database id that contain filename
 */
function wb_write_file_content($wb_file_path, $file_content, $wb_file_name = null, $wb_file_db_name = null, $wb_old_file_name = null) {
    try {
        if (isset($wb_old_file_name) && !empty($wb_old_file_name)):
            if (file_exists($wb_file_path . $wb_old_file_name)):
                unlink($wb_file_path . $wb_old_file_name);
            endif;
            update_option($wb_file_db_name, $wb_file_name);
        else:
            add_option($wb_file_db_name, $wb_file_name);
        endif;
        if (!file_exists($wb_file_path . $wb_file_name)) :
            $fp = fopen($wb_file_path . $wb_file_name, "w");
            if (!$fp) :
                $wb_status['status'] = 'error';
                $wb_status['message'] = 'Filed to open file. Change Permission';
            else:
                $wb_status['status'] = 'success';
                $wb_status['message'] = 'Setting Saved';
                fwrite($fp, $file_content);
                fclose($fp);
            endif;
        else:
            $fp = fopen($wb_file_path . $wb_file_name, "w");
            if (!$fp) :
                $wb_status['status'] = 'error';
                $wb_status['message'] = 'Filed to open file. Change Permission';
            else:
                $wb_status['status'] = 'success';
                $wb_status['message'] = 'Setting Saved';
                fwrite($fp, $file_content);
                fclose($fp);
            endif;
        endif;
    } catch (Exception $e) {
        $wb_status['status'] = 'error';
        $wb_status['message'] = 'Please Try Again';
    }
}

/**
 * Write active js setting to file
 * 
 * @param String $wb_call_option
 */
function wb_write_user_script($wb_call_option = NULL, $wb_setting_name = NULL) {


    if (!$wb_setting_name):
        $wb_setting_name = 'wb_setting';
    endif;

    $wb_all_option = wb_get_all_setting($wb_setting_name);
    $wb_template_name_part = WB()->wb_get_setting_name();

    /** General Setting */
    $wb_scroll_option = $wb_all_option[$wb_template_name_part . '_scroll_setting_wb_scroll_option'];
    $wb_onclick_scroll_option = $wb_all_option[$wb_template_name_part . '_scroll_setting_wb_onclick_scroll_option'];
    $wb_single_product_height = $wb_all_option[$wb_template_name_part . '_product_setting_wb_single_product_height'];

    /** Product Remove Conformation */
    $wb_section_id = 'product_setting';
    $show_conform = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'show_conform'];
    $conform_header_text = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'conform_header_text'];
    $conform_message = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'conform_message'];
    $conform_btn_ok = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'conform_btn_ok'];
    $conform_btn_cancle = $wb_all_option[$wb_template_name_part . '_' . $wb_section_id . '_' . 'conform_btn_cancle'];



    $show_woobag_small_screen = $wb_all_option[$wb_template_name_part . '_smallscreen_setting_show_woobag_small_screen'];


    $wb_user_script = '';
    $wb_user_script .= "(function($, window) {";

    /**
     * Show Bag When Add To Cart Button Click
     */
    $wb_user_script .= "$(document).on('click','.add_to_cart_button',function() {";

    $wb_user_script .= "if ($('#wb_all_content_in_footer .wb_display_widget_cart').length) {";
    $wb_user_script .= "$.wb_show_woo_bag();
        };
        });
        ";

    /**
     * Write WooBag Show Function
     */
    $wb_user_script .= "$.wb_show_woo_bag = function () {";
    $wb_user_script .= '$("#wb_all_content_in_footer .wb_display_widget_cart").css("top", "initial");
                $("#wb_all_content_in_footer .wb_display_widget_cart").css("bottom", "initial");
                $("#wb_all_content_in_footer .wb_display_widget_cart").css("lrft", "initial");
                $("#wb_all_content_in_footer .wb_display_widget_cart").css("right", "initial");';
    $wb_user_script .= '$("#wb_all_content_in_footer .wb_display_widget_cart").fadeIn(500);';
    $wb_user_script .= '$("#wb_all_content_in_footer .wb_display_widget_cart").wb_bag_position("");';
    $wb_user_script .= 'var menu = $("#wb_all_content_in_footer .wb_display_widget_cart").show();
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
        });';
    $wb_user_script .= "};";


    /**
     * Smaill Screen Script
     */
    if ($show_woobag_small_screen === 'no'):
        $wb_user_script .= "function wb_small_screen_option() {
            if ($(window).width() < 400) {
                $('#wb_all_content_in_footer').html('');
            }
    }
    wb_small_screen_option();
    $(window).on('resize', function () {
        wb_small_screen_option();
    });";
    endif;

    $wb_user_script .= " })(jQuery, window, document);";

    /**
     * Write Scrolling Script
     */
    $wb_user_script .= "function wb_scrolling_option(){";
    if ($wb_scroll_option === 'wheel'):
        $wb_user_script .= "jQuery('.wb_all_product_wrapper').mCustomScrollbar({
            theme: 'minimal-dark',
            mouseWheelPixels: 100
        });";
    elseif ($wb_onclick_scroll_option == 'scroll_to_next_product'):
        if (empty($wb_single_product_height)):
            $wb_single_product_height = 120;
        endif;
        $wb_user_script .= "var scrolled = 0;
        jQuery('.bag_carousel_next').on('click', function () {
            var wb_all_product = jQuery(this).closest('tbody').children().find('.wb_all_product_wrapper');
            scrolled = scrolled + " . $wb_single_product_height . ";
            jQuery(wb_all_product).animate({
                scrollTop: scrolled
            });
        });

        jQuery('.bag_carousel_prev').on('click', function () {
            var wb_all_product = jQuery(this).closest('tbody').children().find('.wb_all_product_wrapper');
            scrolled = scrolled - " . $wb_single_product_height . ";
            jQuery(wb_all_product).animate({
                scrollTop: scrolled
            });
        });
        ";
    elseif ($wb_onclick_scroll_option == 'scroll_onkeypress'):
        $wb_user_script .= '
            var amount = "";
            jQuery(".bag_carousel_next").on("mousedown mouseup mouseleave", function mouseState(e) {
                var wb_current_elem = jQuery(this).closest("tbody");
                if (e.type == "mousedown") {
                    amount = "+=10";
                    scroll(wb_current_elem);
                } else {
                    amount = 0;
                }
            });

            jQuery(".bag_carousel_prev").on("mousedown mouseup mouseleave", function mouseState(e) {
                var wb_current_elem = jQuery(this).closest("tbody");
                if (e.type == "mousedown") {
                    amount = "-=10";
                    scroll(wb_current_elem);
                } else {
                    amount = 0;
                }
            });
            function scroll(wb_current_elem) {
                var wb_scroll_elem = jQuery(wb_current_elem).children().find(".wb_all_product_wrapper");
                jQuery(wb_scroll_elem).animate({
                    scrollTop: amount
                }, 100, "linear", function () {
                    if (amount != 0) {
                        scroll(wb_current_elem);
                    }
                });
            }
        ';
    elseif ($wb_onclick_scroll_option == 'scroll_slowly'):
        $wb_user_script .= "var scrolled = 0;
            jQuery('.bag_carousel_next').on('click', function () {
                var wb_all_product = jQuery(this).closest('tbody').children().find('.wb_all_product_wrapper');
                scrolled = scrolled + 100;
                jQuery(wb_all_product).animate({
                    scrollTop: scrolled
                });
            });

            jQuery('.bag_carousel_prev').on('click', function () {
                var wb_all_product = jQuery(this).closest('tbody').children().find('.wb_all_product_wrapper');
                scrolled = scrolled - 100;
                jQuery(wb_all_product).animate({
                    scrollTop: scrolled
                });
            });
        ";
    else:
        $wb_user_script .= "var amount = '';
        function scroll(wb_current_elem) {
            var wb_scroll_elem = jQuery(wb_current_elem).children().find('.wb_all_product_wrapper');
            jQuery(wb_scroll_elem).animate({
                scrollTop: amount
            }, 100, 'linear', function () {
                if (amount != '') {
                    scroll(wb_current_elem);
                }
            });
        }
        jQuery('.bag_carousel_prev').hover(function () {
            amount = '-=10';
            var wb_current_elem = jQuery(this).closest('tbody');
            scroll(wb_current_elem);
        }, function () {
            amount = '';
        });
        jQuery('.bag_carousel_next').hover(function () {
            amount = '+=10';
            var wb_current_elem = jQuery(this).closest('tbody');
            scroll(wb_current_elem);
        }, function () {
            amount = '';
        });";
    endif;
    $wb_user_script .= "}";

    /**
     *  Product Remove Conformation
     */
    if (!$conform_header_text):
        $conform_header_text = 'Conformation Required';
    endif;
    if ($conform_message):
        $conform_message = str_replace('"', "'", $conform_message);
    else:
        $conform_message = 'Are you sure you want to remove product from cart!';
    endif;
    if (!$conform_btn_ok):
        $conform_btn_ok = 'Yes I am';
    endif;
    if (!$conform_btn_cancle):
        $conform_btn_cancle = 'Cancel';
    endif;
    if ($show_conform === 'yes'):
        $wb_user_script .= '
            function wb_remove_conform(wb_product_link) {
                jQuery.confirm({
                    title: "' . $conform_header_text . '",
                    text: "' . $conform_message . '", confirm: function (button) {
                        wb_remove_product(wb_product_link, "");
                    },
                    cancel: function (button) {
                        // nothing to do
                    },
                    confirmButton: "' . $conform_btn_ok . '",
                    cancelButton: "' . $conform_btn_cancle . '",
                    post: true,
                    confirmButtonClass: "btn-danger",
                    cancelButtonClass: "btn-default",
                    zIndex: 99999
               });
           }';
    else:
        $wb_user_script .= 'function wb_remove_conform(wb_product_link) {
                wb_remove_product(wb_product_link, "");
            }';
    endif;

    /**
     * Write Script in File
     */
    $wb_user_file = WB()->wb_get_setting_name('new');
    if ($wb_call_option == 'activate_template' || $wb_call_option == 'activate' || $wb_call_option == 'new'):
        $wb_file_path = WB()->wb_plugin_path() . '/admin/js/';
        $wb_file_name = wb_create_file_name() . '.js';
        $wb_file_db_name = $wb_user_file . '_active_script';
        $wb_old_file_name = get_option($wb_file_db_name);
        wb_write_file_content($wb_file_path, $wb_user_script, $wb_file_name, $wb_file_db_name, $wb_old_file_name);
    else:
        $wb_file_path = WB()->wb_plugin_path() . '/admin/js/';
        $wb_file_name = wb_create_file_name() . '.js';
        $wb_file_db_name = $wb_user_file . '_edit_script';
        $wb_old_file_name = get_option($wb_file_db_name);
        wb_write_file_content($wb_file_path, $wb_user_script, $wb_file_name, $wb_file_db_name, $wb_old_file_name);
    endif;
    return;
}

/**
 * Function To Display Setting Section on backend
 * 
 * @global type $wp_settings_sections
 * @global type $wp_settings_fields
 * @param type $page


 * @return type
 */
function wb_do_settings_sections($page) {
    global $wp_settings_sections, $wp_settings_fields;

    if (!isset($wp_settings_sections[$page])):
        return;
    endif;
    $i = 1;
    foreach ((array) $wp_settings_sections[$page] as $section) :
        echo '<div class="wb_tables_data accordion-container">';
        if ($section['title']):
            echo "<h3 id = 'wb_sec_title' class = 'wb_section_title-" . $i . " accordion-toggle' >" . __($section['title'], 'woo-bag') . "<span class='toggle-icon'><i class='fa fa-plus-circle'></i></span></h3>\n";
        endif;

        if (!isset($wp_settings_fields) || !isset($wp_settings_fields[$page]) || !isset($wp_settings_fields[$page][$section['id']]))
            continue;
        echo '<div class="wb_fields_data accordion-content">';
        if ($section['callback']):
            echo '<div class="wb_setting_section_description">';
            call_user_func($section['callback'], $section);
            echo '</div>';
        endif;
        echo '<table class="form-table wb_setting_fields" id="wb_section_title-' . $i . '">';
        do_settings_fields($page, $section['id']);
        echo '</table>';
        echo '</div>';
        echo '</div>';
        $i++;
    endforeach;
}

/**
 *  Function of all Google Fonts
 * 
 * @return array
 */
function wb_google_fonts() {
    $googlefonts = array(
        "Georgia, serif" => "Georgia, serif",
        "Palatino Linotype, Book Antiqua, Palatino, serif" => "Palatino Linotype, Book Antiqua, Palatino, serif",
        "Times New Roman, Times, serif" => "Times New Roman, Times, serif",
        "Arial, Helvetica, sans-serif" => "Arial, Helvetica, sans-serif",
        "Arial Black, Gadget, sans-serif" => "Arial Black, Gadget, sans-serif",
        "Comic Sans MS, cursive, sans-serif" => "Comic Sans MS, cursive, sans-serif",
        "Impact, Charcoal, sans-serif" => "Impact, Charcoal, sans-serif",
        "Lucida Sans Unicode, Lucida Grande, sans-serif" => "Lucida Sans Unicode, Lucida Grande, sans-serif",
        "Tahoma, Geneva, sans-serif" => "Tahoma, Geneva, sans-serif",
        "Trebuchet MS, Helvetica, sans-serif" => "Trebuchet MS, Helvetica, sans-serif",
        "Verdana, Geneva, sans-serif" => "Verdana, Geneva, sans-serif",
        "Courier New, Courier, monospace" => "Courier New, Courier, monospace",
        "Lucida Console, Monaco, monospace" => "Lucida Console, Monaco, monospace",
        "ABeeZee" => "ABeeZee",
        "Abel" => "Abel",
        "Aclonica" => "Aclonica",
        "Acme" => "Acme",
        "Actor" => "Actor",
        "Adamina" => "Adamina",
        "Akronim" => "Akronim",
        "Asul" => "Asul",
        "Aubrey" => "Aubrey",
        "Audiowide" => "Audiowide",
        "Average" => "Average",
        "Balthazar" => "Balthazar",
        "Bangers" => "Bangers",
        "Bilbo" => "Bilbo",
        "Bitter" => "Bitter",
        "Bokor" => "Bokor",
        "Bonbon" => "Bonbon",
        "Boogaloo" => "Boogaloo",
        "Brawler" => "Brawler",
        "Buda" => "Buda",
        "Buenard" => "Buenard",
        "Butcherman" => "Butcherman",
        "Cabin" => "Cabin",
        "Cagliostro" => "Cagliostro",
        "Cousine" => "Cousine",
        "Coustard" => "Coustard",
        "Creepster" => "Creepster",
        "Crushed" => "Crushed",
        "Cuprum" => "Cuprum",
        "Diplomata" => "Diplomata",
        "Domine" => "Domine",
        "Dorsa" => "Dorsa",
        "Dosis" => "Dosis",
        "Dynalight" => "Dynalight",
        "Eater" => "Eater",
        "Economica" => "Economica",
        "Electrolize" => "Electrolize",
        "Elsie" => "Elsie",
        "Engagement" => "Engagement",
        "Englebert" => "Englebert",
        "Exo" => "Exo",
        "Fascinate" => "Fascinate",
        "Fasthand" => "Fasthand",
        "Federant" => "Federant",
        "Flavors" => "Flavors",
        "Fondamento" => "Fondamento",
        "Galindo" => "Galindo",
        "Geo" => "Geo",
        "Geostar" => "Geostar",
        "Glegoo" => "Glegoo",
        "Gorditas" => "Gorditas",
        "Graduate" => "Graduate",
        "Griffy" => "Griffy",
        "Gruppo" => "Gruppo",
        "Gudea" => "Gudea",
        "Habibi" => "Habibi",
        "Hanuman" => "Hanuman",
        "Homenaje" => "Homenaje",
        "Iceberg" => "Iceberg",
        "Iceland" => "Iceland",
        "Inika" => "Inika",
        "Italiana" => "Italiana",
        "Italianno" => "Italianno",
        "Judson" => "Judson",
        "Julee" => "Julee",
        "Junge" => "Junge",
        "Jura" => "Jura",
        "Kameron" => "Kameron",
        "Khmer" => "Khmer",
        "Knewave" => "Knewave",
        "Kristi" => "Kristi",
        "Lancelot" => "Lancelot",
        "Lato" => "Lato",
        "Lemon" => "Lemon",
        "Lora" => "Lora",
        "Lusitana" => "Lusitana",
        "Lustria" => "Lustria",
        "Macondo" => "Macondo",
        "Magra" => "Magra",
        "Mako" => "Mako",
        "Marcellus" => "Marcellus",
        "Margarine" => "Margarine",
        "Marmelad" => "Marmelad",
        "Megrim" => "Megrim",
        "Merienda" => "Merienda",
        "Miniver" => "Miniver",
        "Moulpali" => "Moulpali",
        "Muli" => "Muli",
        "Neucha" => "Neucha",
        "Neuton" => "Neuton",
        "Niconne" => "Niconne",
        "Orbitron" => "Orbitron",
        "Oregano" => "Oregano",
        "Orienta" => "Orienta",
        "Oswald" => "Oswald",
        "Overlock" => "Overlock",
        "Ovo" => "Ovo",
        "Oxygen" => "Oxygen",
        "Pacifico" => "Pacifico",
        "Paprika" => "Paprika",
        "Prata" => "Prata",
        "Preahvihear" => "Preahvihear",
        "Prociono" => "Prociono",
        "Puritan" => "Puritan",
        "Quando" => "Quando",
        "Quantico" => "Quantico",
        "Quattrocento" => "Quattrocento",
        "Questrial" => "Questrial",
        "Quicksand" => "Quicksand",
        "Quintessential" => "Quintessential",
        "Qwigley" => "Qwigley",
        "Radley" => "Radley",
        "Raleway" => "Raleway",
        "Redressed" => "Redressed",
        "Revalia" => "Revalia",
        "Ribeye" => "Ribeye",
        "Ruthie" => "Ruthie",
        "Rye" => "Rye",
        "Sacramento" => "Sacramento",
        "Sail" => "Sail",
        "Salsa" => "Salsa",
        "Sanchez" => "Sanchez",
        "Sofia" => "Sofia",
        "Spinnaker" => "Spinnaker",
        "Spirax" => "Spirax",
        "Stalemate" => "Stalemate",
        "Stoke" => "Stoke",
        "Strait" => "Strait",
        "Sunshiney" => "Sunshiney",
        "Suwannaphum" => "Suwannaphum",
        "Syncopate" => "Syncopate",
        "Tangerine" => "Tangerine",
        "Ultra" => "Ultra",
        "Underdog" => "Underdog",
        "UnifrakturCook" => "UnifrakturCook",
        "UnifrakturMaguntia" => "UnifrakturMaguntia",
        "Unkempt" => "Unkempt",
        "Unlock" => "Unlock",
        "Unna" => "Unna",
        "VT323" => "VT323",
        "Varela" => "Varela",
        "Vibur" => "Vibur",
        "Vidaloka" => "Vidaloka",
        "Viga" => "Viga",
        "Voces" => "Voces",
        "Volkhov" => "Volkhov",
        "Vollkorn" => "Vollkorn",
        "Voltaire" => "Voltaire",
        "Wallpoet" => "Wallpoet",
        "Warnes" => "Warnes",
        "Wellfleet" => "Wellfleet",
        "Yellowtail" => "Yellowtail",
        "Yesteryear" => "Yesteryear",
        "Zeyada" => "Zeyada",
    );
    return $googlefonts;
}

/**
 * WooBag Default Options
 * 
 * @return array
 */
function wb_default_options($wb_call_option = NULL) {
    $return_option = '';
    $wb_template_name_part = WB()->wb_get_setting_name($wb_call_option);
    $options = WB()->wb_default_settings($wb_call_option);
    foreach ($options as $option):
        $wb_section_id = $option['section_id'];
        foreach ($option['fields'] as $field):
            if (isset($field['std']) && (!empty($field['std']))):
                $field_id = $field['id'];
                $wb_option_id = $wb_template_name_part . '_' . $wb_section_id . '_' . $field_id;
                $return_option[$wb_option_id] = $field['std'];
            endif;
        endforeach;
    endforeach;
    return $return_option;
}

if (!function_exists('wb_product_dummp_data')):

    /**
     * Product Dummy Data for admin side
     * 
     * @return array
     */
    function wb_product_dummp_data() {
        $wb_data = '';
        $wb_data[] = array(
            'product_id' => '1',
            'product_name' => 'Dummy Product 1',
            'product_img' => 'dummy-product-image.png',
            'product_price' => '20.99',
            'product_regular_price' => '23.99',
            'product_quantity' => '3',
            'product_tax' => ''
        );
        $wb_data[] = array(
            'product_id' => '2',
            'product_name' => 'Dummy Product 2 ',
            'product_img' => 'dummy-product-image.png',
            'product_price' => '12.49',
            'product_regular_price' => '',
            'product_quantity' => '1',
            'product_tax' => '2.5'
        );
        $wb_data[] = array(
            'product_id' => '3',
            'product_name' => 'Dummy Product 3 ',
            'product_img' => 'dummy-product-image.png',
            'product_price' => '9.33',
            'product_regular_price' => '15.99',
            'product_quantity' => '1',
            'product_tax' => ''
        );

        return $wb_data;
    }

endif;

function wb_get_user_script_name($wb_db_name) {
    $wb_setting_name = WB()->wb_get_setting_name('new');
    $wb_user_script_name = '';
    if (get_option($wb_setting_name . $wb_db_name)):
        return get_option($wb_setting_name . $wb_db_name);
    else:
        return $wb_user_script_name;
    endif;
}

/**
 * Place WooBag Box in Footer
 */
add_action('wp_footer', 'wb_add_woo_bag_to_footer');

function wb_add_woo_bag_to_footer() {
    echo '<div clas="wb_all_content_in_footer" id="wb_all_content_in_footer">';
    $wb_data = '<div class="wb_loading_image">';
    $wb_data .= '</div>';
    echo $wb_data;
    wb_public_display_html();
    echo '</div>';
}

/**
 * Get list of User Define Menus
 * 
 * @return array Menu name with id
 */
function wb_get_menu_list() {
    $wb_all_menus = wp_get_nav_menus();
    $wb_return_menu_list = array();
    foreach ($wb_all_menus as $menu):
        $wb_return_menu_list[$menu->term_id] = $menu->name;
    endforeach;
    return $wb_return_menu_list;
}

function wb_woocommerce_data() {
    $wb_data = '';
    if (function_exists('WC')):
        $wb_data = WC();
    else:
        global $woocommerce;
        $wb_data = $woocommerce;
    endif;
    return $wb_data;
}

/**
 * Get first part of settings
 * 
 * @param type $wb_call
 * @return type String
 */
function wb_get_setting_name($wb_call = null) {
    return 'wb_setting';
}
