<?php

if (!defined('ABSPATH')) :
    exit; // Exit if accessed directly
endif;

/**
 * Handle Backend Functionality
 *
 * @class 		Woo_Bag_Admin
 * @version		1.0.0
 * @package		Woo_Bag/Classes/
 * @category            Class
 * @author 		Gatelogixs
 */
class Woo_Bag_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $name    The ID of this plugin.
     */
    private $name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @var      string    $name       The name of this plugin.
     * @var      string    $version    The version of this plugin.
     */
    public function __construct($name, $version) {

        $this->name = $name;
        $this->version = $version;
        $this->wb_load_admin_files();
    }

    /**
     * Register the stylesheets for the Dashboard.
     *
     * @since    1.0.0
     */
    public function enqueue_styles($hook) {

        if (('toplevel_page_woo-bag' != $hook) && ('woobag_page_woo-setting' != $hook) && ('woobag_page_woo-templates' != $hook) && ('woobag_page_woo-premium-features' != $hook)) :
            return;
        endif;
        $wb_plugin_url = WB()->wb_plugin_url();

        wp_enqueue_style($this->name . '-font-awesome', $wb_plugin_url . '/public/css/font-awesome.css', array(), $this->version, 'all');

        wp_enqueue_style($this->name . '-bootstrap', $wb_plugin_url . '/public/css/bootstrap.css', array(), $this->version, 'all');

        wp_enqueue_style($this->name . '-jquery.mCustomScrollbar.min', $wb_plugin_url . '/public/css/jquery.mCustomScrollbar.min.css', array(), $this->version, 'all');

        wp_enqueue_style($this->name . '-colpick', plugin_dir_url(__FILE__) . 'css/colpick.css', array(), $this->version, 'all');

        wp_enqueue_style($this->name . '-woo-bag-public', $wb_plugin_url . '/public/css/woo-bag-public.css', array(), $this->version, 'all');

        wp_enqueue_style($this->name, plugin_dir_url(__FILE__) . 'css/woo-bag-admin.css', array(), $this->version, 'all');

        if ($_GET && isset($_GET['action']) && $_GET['action'] == 'edit'):
            $wb_style = wb_get_user_script_name('_edit_style');
        else:
            $wb_style = wb_get_user_script_name('_active_style');
        endif;
        wp_enqueue_style($this->name . '-custom-style', plugin_dir_url(__FILE__) . 'css/' . $wb_style, array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the dashboard.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts($hook) {

        if (('toplevel_page_woo-bag' != $hook) && ('woobag_page_woo-setting' != $hook) && ('woobag_page_woo-templates' != $hook) && ('woobag_page_woo-premium-features' != $hook)) :
            return;
        endif;
        $wb_plugin_url = WB()->wb_plugin_url();
        

        wp_enqueue_script($this->name . '-style', plugin_dir_url(__FILE__) . 'js/style.js', array('jquery'), $this->version, true);

        wp_enqueue_script($this->name . '-bootstrap.min', $wb_plugin_url . '/public/js/bootstrap.min.js', array('jquery'), $this->version, true);

        wp_enqueue_script($this->name . '-jquery.mCustomScrollbar.concat.min', $wb_plugin_url . '/public/js/jquery.mCustomScrollbar.concat.min.js', array('jquery'), $this->version, true);

        wp_enqueue_script($this->name . '-colpick', plugin_dir_url(__FILE__) . 'js/colpick.js', array('jquery'), $this->version, true);

        wp_enqueue_script($this->name . 'woo-bag-public-functions', $wb_plugin_url . '/public/js/woo-bag-public-functions.js', array('jquery'), $this->version, true);

        if ($_GET && isset($_GET['action']) && $_GET['action'] == 'edit'):
            wp_enqueue_script($this->name . '-user-script', plugin_dir_url(__FILE__) . 'js/' . wb_get_user_script_name('_edit_script'), array('jquery'), $this->version, true);
        else:
            wp_enqueue_script($this->name . '-user-active-script', plugin_dir_url(__FILE__) . 'js/' . wb_get_user_script_name('_active_script'), array('jquery'), $this->version, true);
        endif;

        wp_enqueue_script($this->name . 'woo-bag-public', $wb_plugin_url . '/public/js/woo-bag-public.js', array('jquery'), $this->version, true);

        wp_enqueue_script($this->name, plugin_dir_url(__FILE__) . 'js/woo-bag-admin.js', array('jquery'), $this->version, true);

        wp_enqueue_script($this->name . '-woo-bag-admin-show', plugin_dir_url(__FILE__) . 'js/woo-bag-admin-show.js', array('jquery'), $this->version, true);

        wp_localize_script($this->name, 'wb_admin_ajax_url', array('wb_ajax' => admin_url('admin-ajax.php')), $this->version);
    }

    /**
     * Loading Admin Side files and Templates
     * 
     * @since    1.0.0
     */
    private function wb_load_admin_files() {
        /**
         * Include and create a new Woo_Bag_Setting_framework.
         */
        require_once( 'class-woo-bag-setting-framework.php' );

        require_once( 'templates/woo-bag-admin-display.php' );

        require_once( 'templates/woo-bag-about.php' );
    }

    /**
     * WooCommerce Activate Notice
     * 
     * @since    1.0.0
     */
    public function wb_woocommerce_active_notice() {
        if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            $pointer_content = '<h3>' . __('Active WooCommerce', 'woo-bag') . ' | ' . __('Notice', 'woo-bag') . '</h3>';
            $pointer_content .= '<p>' . __('WooBag requires WooCommerce. Activate WooCommerce before make changes', 'woo-bag') . '</p>';
            echo '<div class="error">
                        ' . $pointer_content . '
                    </div>';
        }
    }

}
