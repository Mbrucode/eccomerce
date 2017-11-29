<?php
/**
 * Plugin Name:       WooBag Lite
 * Plugin URI:        http://woobag.gatelogix.com/
 * Description:        WooBag is a must have Wordpress WooCommerce Addon Plugin that gives you full control over design and behaviour of your cart icons and cart popup.
 * Version:           1.1.0
 * Author:            Gatelogix
 * Author URI:        http://woobag.gatelogix.com/
 * Requires at least: 4.0
 * Tested up to:      4.5
 * Text Domain:       woo-bag
 * Domain Path:       /languages
 * @package           Woo_Bag
 * @category          Core
 * @author            Gatelogix
 * @since             1.0.0
 * 
 */
if (!defined('ABSPATH')) :
    exit; // Exit if accessed directly
endif;

if (!defined('WOOBAG_LITE')) {
    define('WOOBAG_LITE', 'yes');
}


// This version can't be activate if premium version is active
if (defined('WOOBAG_PREMIUM')) {

    function wb_install_free_admin_notice() {
        ?>
        <div class="error">
            <p><?php _e('You can\'t activate the free version of WooBag while you are using the premium one.', 'woo-bag'); ?></p>
        </div>
        <?php
    }

    add_action('admin_notices', 'wb_install_free_admin_notice');
    deactivate_plugins(plugin_basename(__FILE__));
    return;
}


if (!class_exists('Woo_Bag')) :

    /**
     * Main WooBag Class
     *
     * @class Woo_Bag
     * @version	1.0.0
     */
    class Woo_Bag {

        /**
         * The loader that's responsible for maintaining and registering all hooks that power
         * the plugin.
         *
         * @since    1.0.0
         * @access   protected
         * @var      Woo_Bag_Loader    $loader    Maintains and registers all hooks for the plugin.
         */
        protected $loader;

        /**
         * The unique identifier of this plugin.
         *
         * @since    1.0.0
         * @access   protected
         * @var      string    $Woo_Bag    The string used to uniquely identify this plugin.
         */
        protected $Woo_Bag;

        /**
         * @var WooBag The single instance of the class
         * @since 1.0.0
         */
        protected static $_wooinstance = null;

        /**
         * The current version of the plugin.
         *
         * @since    1.0.0
         * @access   protected
         * @var      string    $version    The current version of the plugin.
         */
        protected $version;

        public static function wb_get_instance() {
            if (!isset(self::$_this)) {
                self::$_wooinstance = new self;
            }
            return self::$_wooinstance;
        }

        /**
         * Define the core functionality of the plugin.
         *
         * Set the plugin name and the plugin version that can be used throughout the plugin.
         * Load the dependencies, define the locale, and set the hooks for the Dashboard and
         * the public-facing side of the site.
         *
         * @since    1.0.0
         */
        public function __construct() {

            $this->plugin_name = 'woo-bag';
            $this->version = '1.0.0';
            $this->wb_setting_name = 'wb_setting';

            $this->wb_define_constants();
            $this->load_dependencies();
            wb_load_files();
            $this->set_locale();
            $this->define_admin_hooks();
            $this->define_public_hooks();
            $this->init_hooks();

            $this->plugin_path = plugin_dir_path(__FILE__);
            add_action('admin_menu', array(&$this, 'wb_admin_menu'), 79);

            $this->wb_setting_framework = new Woo_Bag_Setting_framework($this->plugin_path . 'includes/settings/wb-product-settings.php', $this->wb_get_setting_name('new'));
            // Add an optional settings validation filter (recommended)
            add_filter($this->wb_setting_framework->get_option_group() . '_settings_validate', array(&$this, 'validate_settings'));
        }

        /**
         * Define WB Constants
         * 
         * @since     1.0.0
         */
        private function wb_define_constants() {
            $this->wb_define('WB_PLUGIN_FILE', __FILE__);
            $this->wb_define('WB_PLUGIN_BASENAME', plugin_basename(__FILE__));
        }

        /**
         * Define constant if not already set
         * @param  string $name
         * @param  string|bool $value
         * 
         * @since     1.0.0
         */
        private function wb_define($name, $value) {
            if (!defined($name)) {
                define($name, $value);
            }
        }

        /**
         * Load the required dependencies for this plugin.
         *
         * Include the following files that make up the plugin:
         *
         * - Woo_Bag_Loader. Orchestrates the hooks of the plugin.
         * - Woo_Bag_i18n. Defines internationalization functionality.
         * - Woo_Bag_Admin. Defines all hooks for the dashboard.
         * - Woo_Bag_Public. Defines all hooks for the public side of the site.
         *
         * Create an instance of the loader which will be used to register the hooks
         * with WordPress.
         *
         * @since    1.0.0
         * @access   private
         */
        private function load_dependencies() {

            /**
             * WooBag Icon HTML
             */
            include_once( 'public/templates/woo-bag-public-icon.php');

            /**
             * The file responsible for core functionality of WooBag
             */
            include_once('includes/wb-core-functions.php');

            /**
             * The file responsible for Cart related Operations
             */
            include_once('includes/wb-cart-functions.php');

            /**
             * The file responsible for templates related Operations
             */
            include_once('includes/wb-template-functions.php');

            /**
             * The class responsible for defining all actions that occur in the public-facing
             * side of the site.
             */
            include_once( 'public/class-woo-bag-public.php');

            /**
             * The class responsible for orchestrating the actions and filters of the
             * core plugin.
             */
            include_once('includes/class-woo-bag-loader.php');
            /**
             * The class responsible for defining all actions that occur in the public-facing
             * side of the site.
             */
            include_once( 'public/templates/woo-bag-public-display.php');

            /**
             * The class responsible for defining all actions that occur in the public-facing
             * side of the site.
             */
            include_once( 'public/templates/woo-bag-public-display-content.php');

            /**
             * The class responsible for defining all actions that occur in the Dashboard.
             */
            include_once('admin/class-woo-bag-admin.php');

            $this->loader = new Woo_Bag_Loader();
        }

        /**
         * Define the locale for this plugin for internationalization.
         *
         * Uses the Woo_Bag_i18n class in order to set the domain and to register the hook
         * with WordPress.
         *
         * @since    1.0.0
         * @access   private
         */
        private function set_locale() {

            $plugin_i18n = new Woo_Bag_i18n();
            $plugin_i18n->set_domain($this->get_plugin_name());

            $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
        }

        /**
         * Register all of the hooks related to the dashboard functionality
         * of the plugin.
         *
         * @since    1.0.0
         * @access   private
         */
        private function define_admin_hooks() {

            $plugin_admin = new Woo_Bag_Admin($this->get_plugin_name(), $this->get_version());

            $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
            $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');

            $this->loader->add_action('admin_notices', $plugin_admin, 'wb_woocommerce_active_notice');
        }

        /**
         * Register all of the hooks related to the public-facing functionality
         * of the plugin.
         *
         * @since    1.0.0
         * @access   private
         */
        private function define_public_hooks() {

            $plugin_public = new Woo_Bag_Public($this->get_plugin_name(), $this->get_version());

            $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
            $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
        }

        /**
         * Run the loader to execute all of the hooks with WordPress.
         *
         * @since    1.0.0
         */
        public function wb_run() {
            $this->loader->run();
        }

        /**
         * The name of the plugin used to uniquely identify it within the context of
         * WordPress and to define internationalization functionality.
         *
         * @since     1.0.0
         * @return    string    The name of the plugin.
         */
        public function get_plugin_name() {
            return $this->plugin_name;
        }

        /**
         * Get the plugin url.
         * 
         * @since     1.0.0
         * @return string
         */
        public function wb_plugin_url() {
            return untrailingslashit(plugins_url('/', __FILE__));
        }

        /**
         * Get the plugin path.
         * 
         * @since     1.0.0
         * @return string
         */
        public function wb_plugin_path() {
            return untrailingslashit(plugin_dir_path(__FILE__));
        }

        /**
         * Get the template path.
         * 
         * @since     1.0.0
         * @return string
         */
        public function wb_template_path() {
            return apply_filters('woo_bag_template_path', 'woo-bag/');
        }

        /**
         * The reference to the class that orchestrates the hooks with the plugin.
         *
         * @since     1.0.0
         * @return    Woo_Bag_Loader    Orchestrates the hooks of the plugin.
         */
        public function get_loader() {
            return $this->loader;
        }

        /**
         * Retrieve the version number of the plugin.
         *
         * @since     1.0.0
         * @return    string    The version number of the plugin.
         */
        public function get_version() {
            return $this->version;
        }

        public function wb_default_settings($wb_call_option = NULL) {
            $options = wb_plugin_setting('');
            return $options;
        }

        /**
         * Hook into actions and filters
         * @since  1.0.0
         */
        private function init_hooks() {
            /** This action is documented in includes/class-woo-bag-activator.php */
            register_activation_hook(__FILE__, array('Woo_Bag_Activator', 'wb_install'));

            /** This action is documented in includes/class-woo-bag-deactivator.php */
            register_activation_hook(__FILE__, array('Woo_Bag_Deactivator', 'deactivate'));
        }

        /**
         * WooBag Menu
         * 
         * @since     1.0.0
         */
        function wb_admin_menu() {
            $wb_Menu_icon = $this->wb_plugin_url() . '/admin/images/wb_menu_icon.png';
            add_menu_page(__('WooBag', 'woo-bag'), __('WooBag', 'woo-bag'), 'manage_options', 'woo-bag', array(&$this, 'wb_about'), $wb_Menu_icon, 59);
            add_submenu_page('woo-bag', __('WooBag Lite – Customize Woocommerce Cart Popup', 'woo-bag'), __('About ', 'woo-bag'), 'manage_options', 'woo-bag', array(&$this, 'wb_about'));
            add_submenu_page('woo-bag', __('WooBag Lite – Customize Woocommerce Cart Popup', 'woo-bag'), __('Premium Features', 'woo-bag'), 'manage_options', 'woo-premium-features', array(&$this, 'wb_premium_features'));
            add_submenu_page('woo-bag', __('WooBag Lite – Customize Woocommerce Cart Popup', 'woo-bag'), __('Edit Setting', 'woo-bag'), 'manage_options', 'woo-setting', array(&$this, 'settings_page'));
            add_submenu_page('woo-bag', __('WooBag Lite – Customize Woocommerce Cart Popup', 'woo-bag'), __('Templates', 'woo-bag'), 'manage_options', 'woo-templates', array(&$this, 'wb_templates'));
        }

        /**
         * Setting Options
         * 
         * @since     1.0.0
         */
        function settings_page() {
            ?>
            <div class="wrap row wb_setting_wrapper nopadding">
                <div class="col-md-12 nopadding">
                    <div class="wb_cart_setting_banner">
                        <a class="button-primary" href="http://codecanyon.net/item/woobag-customize-your-cart-easily/12908527?ref=gatelogix">
                            GET WOOBAG PREMIUM
                        </a>
                        <h1>
                            WooBag Popup Lite
                        </h1>
                        <p>
                            Why go pro? Ability to do dropdown ajax cart in fixed position, in menu, sidebars, customize any 
                            settings without CSS and coding and many more   
                        </p>
                    </div>
                </div>
                <div class="col-md-7 nopadding">
                    <div class="col-md-12 nopadding">
                        <div class="col-md-12 nopadding">
                            <h2 class="wb_setting_logo"> WooBag <i class="fa fa-arrow-right"></i> <?php _e(' Setting', 'woo-bag'); ?>

                            </h2>
                        </div>

                    </div>
                    <div class="col-md-12 nopadding">
                        <?php
                        // Output settings form
                        $this->wb_setting_framework->settings();
                        ?>
                    </div>
                </div>
                <div class="col-md-5 nopadding wb_admin_cart_arear">
                    <div class="col-md-12 nopadding wb_admin_cart_wrapper">
                        <div class="wb_admin_cart"><div class="wb_admin_cart_shortcode"><?php echo do_shortcode('[wb_woo_bag_admin]') ?></div></div>
                    </div>
                </div>
            </div>
            <?php
        }

        /**
         * Display Premium Features
         * 
         * @since     1.0.0
         */
        function wb_premium_features() {
            ?>
            <div class="wrap about-wrap">
                <?php include_once 'admin/templates/woo-bag-premium-features.php'; ?>
            </div>
            <?php
        }

        /**
         * Display Templates
         * 
         * @since     1.0.0
         */
        function wb_templates() {
            ?>
            <div class="wrap about-wrap">
                <?php include_once 'admin/templates/woo-bag-template.php'; ?>
            </div>
            <?php
        }

        /**
         * About WooBag
         * 
         * @since     1.0.0
         */
        function wb_about() {
            ?>
            <div class="wrap about-wrap">
                <?php wb_about_template(); ?>
            </div>
            <?php
        }

        /**
         * Validate setting input fields
         * 
         * @since     1.0.0
         * @param type $input
         * @return type
         */
        function validate_settings($input) {
            // Do your settings validation here
            return $input;
        }

        /**
         * Get first part of settings
         * 
         * @since     1.0.0
         * 
         * @param type $wb_call
         * @return type
         */
        public function wb_get_setting_name($wb_call = null) {
            return $this->wb_setting_name;
        }

    }

    endif;

/**
 * Returns the main instance of WB to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return Woo_Bag
 */
function WB() {
    $plugin = new Woo_Bag();
    return $plugin;
}

WB()->wb_run();
