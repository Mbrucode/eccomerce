<?php
require_once(  get_template_directory() . '/admin/importer/importer/okthemes-importer.php' ); //load admin theme data importer

class villenoir_OKThemes_Theme_Demo_Data_Importer extends villenoir_OKThemes_Theme_Importer {

    /**
     * Holds a copy of the object for easy reference.
     *
     * @since 2.2.0
     *
     * @var object
     */
    private static $instance;
    
    /**
     * Set the key to be used to store theme options
     *
     * @since 2.2.0
     *
     * @var object
     */
    public $theme_option_name         = 'my_theme_options'; //set theme options name here
    
    public $theme_options_file_name   = 'theme_options.txt';
    
    public $widgets_file_name         =  'widgets.json';
    
    public $content_demo_file_name    =  'content.xml';
	
	/**
	 * Holds a copy of the widget settings 
	 *
	 * @since 2.2.0
	 *
	 * @var object
	 */
	public $widget_import_results;
	
    /**
     * Constructor. Hooks all interactions to initialize the class.
     *
     * @since 2.2.0
     */
    public function __construct() {
        
		$this->demo_files_path = get_template_directory() . '/admin/importer/demo-files/';

        self::$instance = $this;
		parent::__construct();

        add_action( 'admin_init', array($this, 'villenoir_theme_activation') );
        add_action( 'admin_menu', array($this, 'villenoir_add_admin') );
        add_action( 'admin_print_scripts', array($this, 'villenoir_enqueue_admin_assets') );
    }

    // Custom assets for admin pages
    function villenoir_enqueue_admin_assets() {
        wp_enqueue_style( 'villenoir-theme-admin', get_template_directory_uri() . '/admin/importer/assets/admin-style.css' );
    }

    // Redirect to Demo Import page after Theme activation
    public function villenoir_theme_activation() {
        global $pagenow;
        if ( is_admin() AND $pagenow == 'themes.php' AND isset( $_GET['activated'] ) ) {
            //Redirect to demo import
            header( 'Location: ' . admin_url( 'admin.php?page=villenoir-home' ) );
        }
    }

    /**
     * Add Panel Page
     *
     * @since 2.2.0
     */
    public function villenoir_add_admin() {
        //Output buffering
        ob_start();
        add_theme_page("About the theme", "About the theme", 'switch_themes', 'villenoir-home', array($this, 'villenoir_welcome_page'));
        add_theme_page("Import Demo Data", "Import Demo Data", 'switch_themes', 'villenoir-demo-import', array($this, 'villenoir_demo_installer'));
        if ( class_exists( 'acf' ) ) {
            add_theme_page("Customizer Import", "Import theme options", 'switch_themes', 'import', array($this, 'villenoir_import_option_page'));
            add_theme_page("Customizer Export", "Export theme options", 'switch_themes', 'export', array($this, 'villenoir_export_option_page'));
        }
    }


    // Menus to Import and assign
	public function villenoir_set_demo_menus(){
		
        $main_menu   = get_term_by('name', 'Header menu', 'nav_menu');
        $footer_menu = get_term_by('name', 'Footer menu', 'nav_menu');

		set_theme_mod( 'nav_menu_locations', array(
                'main-menu'   => $main_menu->term_id,
                'footer-menu' => $footer_menu->term_id
            )
        );

        //Replace demo url with client url
        $menu_arr = wp_get_nav_menu_items($main_menu);
        foreach ( (array) $menu_arr as $key => $menu_item ) {
            $title = $menu_item->title;
            $url = $menu_item->url;
            $db_id = $menu_item->db_id;
            $position = $menu_item->menu_order;

            if ($url == 'http://okthemes.com/villenoirdemo/') {
                wp_update_nav_menu_item($main_menu->term_id, $db_id, array(
                    'menu-item-title' => 'Home',
                    'menu-item-url' => site_url(),
                    'menu-item-position' => $position
                    )
                );
            }
            
            if ( class_exists('Tribe__Events__Main') ) {
                if ($url == 'http://okthemes.com/villenoirdemo/events') {
                    wp_update_nav_menu_item($main_menu->term_id, $db_id, array(
                        'menu-item-title' => 'Events',
                        'menu-item-url' => site_url( '/events/' ),
                        'menu-item-position' => $position
                        )
                    );
                }
            }
            
        }

	}

    // Remove hello and sample post/page
    public function villenoir_remove_hello_post(){

        //Remove the hello world post
        wp_delete_post(1);

        //Remove the samples pages
        wp_delete_post(2);
    }

    //Set the page options
    public function villenoir_set_page_options(){

        //Set the frontpage and the blog page
        $frontpage = get_page('193');
        $blogpage  = get_page('195');

        update_option('show_on_front', 'page');    // show on front a static page
        update_option('page_on_front', $frontpage->ID);
        update_option('page_for_posts', $blogpage->ID);

        //Set the WC pages
        if ( villenoir_is_wc_activated() ) {

            //Shop Page
            $shop_page = get_page_by_title('Wines');
            if($shop_page && $shop_page->ID){
                update_option('woocommerce_shop_page_id',$shop_page->ID);
            }
            
            //Cart Page
            $cart_page = get_page_by_title('Cart');
            if($cart_page && $cart_page->ID){
                update_option('woocommerce_cart_page_id',$cart_page->ID);
            }
            
            //Checkout Page
            $checkout_page = get_page_by_title('Checkout');
            if($checkout_page && $checkout_page->ID){
                update_option('woocommerce_checkout_page_id',$checkout_page->ID);
            }
            
            //My Account Page
            $myaccount_page = get_page_by_title('My Account');
            if($myaccount_page && $myaccount_page->ID){
                update_option('woocommerce_myaccount_page_id',$myaccount_page->ID);
            }

            //Update permalinks
            global $wp_rewrite;
            $wp_rewrite->set_permalink_structure('/%postname%/');

       
        } else {
            echo 'WooCommerce is not installed. The WC pages were not assigned.';
        }

    }

    //Set the revolution slider
    public function villenoir_set_revslider_options(){

        if( class_exists('RevSlider') ) {
           
            $slider_array = array(
                get_template_directory()."/admin/importer/demo-sliders/main-slideshow.zip",
            );

            $slider = new RevSlider();
             
            foreach($slider_array as $filepath){
                $slider->importSliderFromPost(false,false,$filepath);
            }
            

            echo ' Slider imported';
            
        } else {
            echo '<p>Revolution Slider is not installed. The corresponding settings were not applied.</p>';
        }
    }

    //Set the revolution slider
    public function villenoir_set_events_options(){

        if ( class_exists('Tribe__Events__Main') ) {
            
            tribe_update_option('stylesheetOption', 'full');
            tribe_update_option('viewOption', 'list');

        } else {
            echo '<p>Events calendar is not installed. The corresponding settings were not applied.</p>';
        }
    }

    public function villenoir_welcome_page() {

        $theme = wp_get_theme();
        if ( is_child_theme() ) {
            $theme = wp_get_theme( $theme->get( 'Template' ) );
        }
        $theme_name = $theme->get( 'Name' );
        $theme_version = $theme->get( 'Version' );

        $return_url = admin_url('admin.php?page=villenoir-home');

        
        ?>
        
        <div class="gg-admin-welcome-page">
            

            <div class="welcome-panel" style="padding-bottom: 23px;">
                <div class="welcome-panel-content">

                    <h2><?php echo sprintf( __( 'Welcome to <strong>%s</strong>', 'villenoir' ), $theme_name . ' ' . $theme_version ) ?></h2>
                    <p class="about-description"><?php _e( 'Beautifully crafted WordPress theme ready to take your wine journey to the next level.', 'villenoir' ) ?></p>

                    <div class="welcome-panel-column-container">
                        <div class="welcome-panel-column">
                            <h3><i class="dashicons dashicons-screenoptions"></i><?php _e( 'Install Plugins', 'villenoir' ) ?></h3>
                            <p><?php echo sprintf( __( '%s has bundled popular premium plugins which greatly increases the flexibility of the theme. Install them in order to maximize the theme power.', 'villenoir' ), $theme_name ); ?></p>
                            <a class="button button-primary" href="<?php echo admin_url( 'admin.php?page=tgmpa-install-plugins' ); ?>"><?php _e( 'Install Plugins', 'villenoir' ) ?></a>
                        </div>
                        <div class="welcome-panel-column">
                            <h3><i class="dashicons dashicons-download"></i><?php _ex( 'Import Demo Content', 'noun', 'villenoir' ) ?></h3>
                            <p><?php _e( 'If you have installed this theme on a clean WordPress installation then this is where you\'ll want to go next. This feature imports the demo content.', 'villenoir' ) ?></p>
                            <a class="button button-primary" href="<?php echo admin_url( 'admin.php?page=villenoir-demo-import' ); ?>">
                                <?php _e( 'Import Demo Content', 'villenoir' ) ?></a>
                        </div>
                        <div class="welcome-panel-column welcome-panel-last">
                            <h3><i class="dashicons dashicons-admin-appearance"></i><?php _e( 'Customize Appearance', 'villenoir' ) ?></h3>
                            <p><?php _e( 'Customize the look and feel of your site with the help of the Theme Options panel.', 'villenoir' ) ?></p>
                            <a class="button button-primary" href="<?php echo admin_url( 'admin.php?page=theme-options' ); ?>"><?php _e( 'Go to Theme Options', 'villenoir' ) ?></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer" style="display:none;">
                <ul">
                    <li>
                        <i class="dashicons dashicons-editor-help"></i>
                        <a href="#" target="_blank"><?php _e( 'Online Documentation', 'villenoir' ) ?></a>
                    </li>
                    <li>
                        <i class="dashicons dashicons-sos"></i>
                        <a href="#" target="_blank"><?php _e( 'Support Portal', 'villenoir' ) ?></a>
                    </li>
                    <li>
                        <i class="dashicons dashicons-backup"></i>
                        <a href="#" target="_blank"><?php _e( 'Theme Changelog', 'villenoir' ) ?></a>
                    </li>
                </ul>
            </div>

        </div>
        <?php
    }     


}

new villenoir_OKThemes_Theme_Demo_Data_Importer;