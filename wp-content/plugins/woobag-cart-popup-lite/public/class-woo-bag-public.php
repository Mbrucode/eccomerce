<?php

if (!defined('ABSPATH')) :
    exit; // Exit if accessed directly
endif;

/**
 * The public-facing functionality of the plugin.
 *
 * @class 		Woo_Bag_Public
 * @version		1.0.0
 * @package		Woo_Bag/Classes/
 * @category            Class
 * @author 		Gatelogixs
 */
class Woo_Bag_Public {

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
     * @var      string    $name       The name of the plugin.
     * @var      string    $version    The version of this plugin.
     */
    public function __construct($name, $version) {

        $this->name = $name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        wp_enqueue_style($this->name . '-font-awesome', plugin_dir_url(__FILE__) . 'css/font-awesome.css', array(), $this->version, 'all');
        
        wp_enqueue_style($this->name . '-jquery.mCustomScrollbar.min', plugin_dir_url(__FILE__) . 'css/jquery.mCustomScrollbar.min.css', array(), $this->version, 'all');
        
        wp_enqueue_style($this->name . '-frontend', plugin_dir_url(__FILE__) . 'css/woo-bag-public.css', array(), $this->version, 'all');
        
        wp_enqueue_style($this->name . '-custom-css', plugin_dir_url(__FILE__) .  'css/'.wb_get_user_script_name('_active_style'), array(), $this->version, 'all');

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        $wb_plugin_url = WB()->wb_plugin_url();        
        wp_enqueue_script($this->name . '-jquery.mCustomScrollbar.concat.min', plugin_dir_url(__FILE__) . 'js/jquery.mCustomScrollbar.concat.min.js', array('jquery'), '', TRUE);

        wp_enqueue_script($this->name . '-jquery.confirm', plugin_dir_url(__FILE__) . 'js/jquery.confirm.min.js', array('jquery'), '', TRUE);
        
        wp_enqueue_script($this->name . '-position-calculator', plugin_dir_url(__FILE__) . 'js/woo-bag-public-position-calculator.js', array('jquery'), '', TRUE);

        wp_enqueue_script($this->name . '-jquery.cookie', plugin_dir_url(__FILE__) . 'js/jquery.cookie.js', array('jquery'), '', TRUE);

        wp_enqueue_script($this->name . '-functions', plugin_dir_url(__FILE__) . 'js/woo-bag-public-functions.js', array('jquery'), $this->version, TRUE);

        wp_enqueue_script($this->name . '-user-script', $wb_plugin_url . '/admin/js/' . wb_get_user_script_name('_active_script'), array('jquery'), $this->version, TRUE);

        wp_enqueue_script($this->name . '-frontend', plugin_dir_url(__FILE__) . 'js/woo-bag-public.js', array('jquery'), $this->version, TRUE);

        wp_localize_script($this->name . '-frontend', 'wb_ajax_url', array('ajaxurl' => admin_url('admin-ajax.php')), $this->version, TRUE);
    }

}
