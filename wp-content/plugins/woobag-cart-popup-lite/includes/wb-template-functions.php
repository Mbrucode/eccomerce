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
 * @package		Woo_Bag/WooBag Functions/
 * @subpackage          Woo_Bag/includes
 * @category            Class
 * @author 		Gatelogixs
 */
/**
 *  Update Template whan click on Save Changes
 * 
 * @access public
 */
add_action('wp_ajax_wb_update_template', 'wb_update_template');

function wb_update_template() {

    $wb_template_name_part = WB()->wb_get_setting_name('new');
    $wb_status = array();
    wb_write_user_style('activate_template', $wb_template_name_part);
    $wb_status['status'] = 'success';
    $wb_status['message'] = 'Settings has been successfully updated.';
    echo json_encode($wb_status);
    die();
}


/**
 * Restore To Default setting
 * 
 * @param string $wb_call_option
 * @return void
 * @access public
 */
function wb_activate_plugin($wb_call_option) {
    $wb_template_name_part = WB()->wb_get_setting_name($wb_call_option);
    $wb_default_options = wb_default_options($wb_call_option);
    if (get_option($wb_template_name_part)):
        update_option($wb_template_name_part, $wb_default_options);
    else:
        add_option($wb_template_name_part, $wb_default_options);
    endif;
    wb_write_user_style($wb_call_option);
}


