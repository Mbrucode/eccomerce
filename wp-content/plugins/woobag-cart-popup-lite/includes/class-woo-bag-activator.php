<?php

if (!defined('ABSPATH')) :
    exit; // Exit if accessed directly
endif;

/**
 * Fired during plugin activation
 * 
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @class 		Woo_Bag_Activator
 * @version		1.0.0
 * @package		Woo_Bag/Classes/
 * @subpackage          Woo_Bag/includes
 * @category            Class
 * @author 		Gatelogixs
 */
class Woo_Bag_Activator {

    /**
     * Hook in tabs.
     */
    public static function init() {
        add_filter('plugin_action_links_' . WB_PLUGIN_BASENAME, array(__CLASS__, 'wb_plugin_action_links'));
        add_action('admin_init', array(__CLASS__, 'wb_after_install_actions'));
    }

    /**
     * Show action links on the plugin screen.
     *
     * @param	mixed $links Plugin Action links
     * @return	array
     */
    public static function wb_plugin_action_links($links) {

        $action_links = array(
            'settings' => '<a href="' . admin_url('admin.php?page=woo-setting') . '" title="' . esc_attr(__('View WooBag Settings', 'woo-bag')) . '">' . __('Settings', 'woo-bag') . '</a>',
        );

        return array_merge($action_links, $links);
    }

    /**
     * Redirect after Activation
     */
    public static function wb_after_install_actions() {
        if (get_option('wb_setting_install') && get_option('wb_setting_install') == 'yes'):
            update_option('wb_setting_install', 'no');
            wp_redirect(admin_url('admin.php?page=woo-bag'));
            exit;
        endif;
    }

    /**
     * Install WooBag
     */
    public static function wb_install() {

        if (!defined('WB_INSTALLING')) {
            define('WB_INSTALLING', true);
        }

        self::wb_default_create_options('');
    }

    

    /**
     * Default options
     *
     * Sets up the default options used on the settings page
     */
    public static function wb_default_create_options($wb_call_option = NULL) {
        $wb_template_part = WB()->wb_get_setting_name($wb_call_option);
        if ($wb_call_option == 'new'):
        else:
            if (!get_option('wb_setting_install')):
                add_option('wb_setting_install', 'yes');
            else:
                update_option('wb_setting_install', 'yes');
            endif;
        endif;
        if (!get_option($wb_template_part)):
            if ($wb_call_option == 'new'):
                wb_activate_plugin($wb_call_option);
            else:
                wb_activate_plugin('activate');
            endif;
        endif;
    }

}

Woo_Bag_Activator::init();
