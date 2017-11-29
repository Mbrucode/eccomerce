<?php

/**
 * Class villenoir_OKThemes_Theme_Importer
 *
 * This class provides the capability to import demo content as well as import widgets and WordPress menus
 *
 */
class villenoir_OKThemes_Theme_Importer {

	/**
	 * Holds a copy of the object for easy reference.
	 *
	 * @since 2.2.0
	 *
	 * @var object
	 */
	public $theme_options_file;

	/**
	 * Holds a copy of the object for easy reference.
	 *
	 * @since 2.2.0
	 *
	 * @var object
	 */
	public $widgets;

	/**
	 * Holds a copy of the object for easy reference.
	 *
	 * @since 2.2.0
	 *
	 * @var object
	 */
	public $content_demo;

	/**
	 * Flag imported to prevent duplicates
	 *
	 * @since 2.2.0
	 *
	 * @var object
	 */
	public $flag_as_imported = array();

    /**
     * Holds a copy of the object for easy reference.
     *
     * @since 2.2.0
     *
     * @var object
     */
    private static $instance;

    /**
     * Constructor. Hooks all interactions to initialize the class.
     *
     * @since 2.2.0
     */
    public function __construct() {

        self::$instance = $this;
        
        $this->theme_options_file = $this->demo_files_path . $this->theme_options_file_name;
        $this->widgets = $this->demo_files_path . $this->widgets_file_name;
        $this->content_demo = $this->demo_files_path . $this->content_demo_file_name;
		 
        add_action( 'admin_menu', array($this, 'villenoir_add_admin') );

    }

	/**
	 * Add Panel Page
	 *
	 * @since 2.2.0
	 */
    public function villenoir_add_admin() {
        //Output buffering
        ob_start();
        add_theme_page("Import Demo Data", "Import Demo Data", 'switch_themes', 'okthemes_villenoir_demo_installer', array($this, 'villenoir_demo_installer'));
        if ( class_exists( 'acf' ) ) {
            add_theme_page("Customizer Import", "Import theme options", 'switch_themes', 'import', array($this, 'villenoir_import_option_page'));
            add_theme_page("Customizer Export", "Export theme options", 'switch_themes', 'export', array($this, 'villenoir_export_option_page'));
        }
    }

    /**
     * [Villenoir demo installer]
     *
     * @since 2.2.0
     *
     * @return [type] [description]
     */
    public function villenoir_demo_installer() {

        ?>
        <div id="icon-tools" class="icon32"><br></div>
        <h2><?php esc_html_e('Import Demo Data', 'villenoir');?></h2>
        <div style="background-color: #F5FAFD; margin:10px 0;padding: 10px;color: #0C518F;border: 3px solid #CAE0F3; claer:both; width:90%; line-height:18px;">
            <p class="tie_message_hint"><?php esc_html_e('Importing demo data (post, pages, images, theme settings, ...) is the easiest way to setup your theme. It will
            allow you to quickly edit everything instead of creating content from scratch. When you import the data following things will happen:', 'villenoir'); ?></p>

              <ul style="padding-left: 20px;list-style-position: inside;list-style-type: square;}">
                  <li><?php esc_html_e('No existing posts, pages, categories, images, custom post types or any other data will be deleted or modified.', 'villenoir'); ?></li>
                  <li><?php esc_html_e('No WordPress settings will be modified.', 'villenoir'); ?></li>
                  <li><?php esc_html_e('Posts, pages, some images, some widgets and menus will get imported.', 'villenoir'); ?></li>
                  <li><?php esc_html_e('Images will be downloaded from our server, these images are copyrighted and are for demo use only.', 'villenoir'); ?></li>
                  <li><?php esc_html_e('Please click import only once and wait, it can take a couple of minutes.', 'villenoir'); ?></li>
              </ul>
         </div>

        <!-- Notices -->
        <div style="background-color: #F5FAFD; margin:10px 0;padding: 10px;color: #0C518F;border: 3px solid #CAE0F3; claer:both; width:90%; line-height:18px;">
            <p><?php esc_html_e('Before you begin, make sure all the required plugins are activated.', 'villenoir'); ?></p>
            
            <?php 
            if ( ! class_exists('RevSlider')) 
                echo '<p><strong>Revolution Slider</strong> plugin is not active. Please activate it if you want Sliders to be imported.</p>';
            ?>
        </div>
        
        <form method="post" id="gg-import-demo-form">
            <input type="hidden" name="demononce" value="<?php echo wp_create_nonce('okthemes-demo-code'); ?>" />
            <input id="gg-import-demo-data" name="reset" class="panel-save button-primary" type="submit" value="<?php esc_attr_e( 'Import Demo Data', 'villenoir' ); ?>" />
            <input type="hidden" name="action" value="demo-data" />
        </form>
        <script>
          jQuery.noConflict();
          jQuery('#gg-import-demo-data').click(function () {
              // Adding loading GIF
              jQuery(this).hide();
              jQuery('#gg-import-demo-form').prepend('<p>The import process started, please wait until the page refreshes itself.</p>');
          });
        </script>
        <br />
        <br />

        <?php
        
        $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
        
        if( 'demo-data' == $action && check_admin_referer('okthemes-demo-code' , 'demononce')){

            $this->villenoir_remove_hello_post();

            $this->villenoir_set_demo_data( $this->content_demo );

            $this->villenoir_set_demo_theme_options( $this->theme_options_file ); //import before widgets in case we need more sidebars

            $this->villenoir_set_demo_menus();
            $this->villenoir_set_page_options();
            $this->villenoir_set_revslider_options();
            $this->villenoir_set_events_options();

            $this->villenoir_process_widget_import_file( $this->widgets );

        }

    }

    /**
     * [Import theme options]
     *
     * @since 2.2.0
     *
     */

    public function villenoir_import_option_page() {
        global $wp_filesystem;
        WP_Filesystem();
    ?>
      <div class="wrap">
        <div id="icon-tools" class="icon32"><br></div>
        <h2><?php esc_html_e('Customizer Import', 'villenoir');?></h2>
        <?php
        if ( isset( $_FILES['import'] ) && check_admin_referer( 'gg-customizer-import' ) ) {
          if ( $_FILES['import']['error'] > 0 ) {
            wp_die( 'An error occured.' );
          } else {
            $file_name = $_FILES['import']['name'];
            $file_name = explode( '.', $file_name );
            $file_ext  = strtolower( end( $file_name ) );
            $file_size = $_FILES['import']['size'];
            if ( ( $file_ext == 'json' ) && ( $file_size < 500000 ) ) {
              
              $encode_options = $wp_filesystem->get_contents( $_FILES['import']['tmp_name'] );

              $options        = json_decode( $encode_options, true );

              foreach ( $options as $key => $value ) {
                update_option( $key, $value );
              }

              echo '<div class="updated"><p>'.esc_html__('All options were restored successfully!', 'villenoir').'</p></div>';
            } else {
              echo '<div class="error"><p>'.esc_html__('Invalid file or file size too big.', 'villenoir').'</p></div>';
            }
          }
        }
        ?>
        <form method="post" enctype="multipart/form-data">
          <?php wp_nonce_field( 'gg-customizer-import' ); ?>
          <p><?php esc_html_e('If you have settings in a backup file (json) on your computer, the Import system can import it into this site. To get started, upload your backup file using the form below.', 'villenoir'); ?></p>
          <p><?php esc_html_e('Choose a file (json) from your computer:', 'villenoir');?> <input type="file" id="customizer-upload" name="import"></p>
          <p class="submit">
            <input type="submit" name="submit" id="customizer-submit" class="button" value="Upload file and import">
          </p>
        </form>
      </div>
    <?php
    }

    /**
     * [Export theme options]
     *
     * @since 2.2.0
     *
     */

    public function villenoir_export_option_page() {
      if ( ! isset( $_POST['export'] ) ) {
      ?>
        <div class="wrap">
          <div id="icon-tools" class="icon32"><br></div>
          <h2><?php esc_html_e('Customizer Export', 'villenoir');?></h2>
          <form method="post">
            <?php wp_nonce_field( 'gg-customizer-export' ); ?>
            <p><?php esc_html_e('When you click the button below, the Export system will create a backup file (json) for you to save to your computer.', 'villenoir'); ?></p>
            <p><?php esc_html_e('This text file can be used to restore your settings or to easily setup another website with the same theme settings.', 'villenoir'); ?></p>
            <p><em><?php esc_html_e('Please note that this export manager backs up only your theme settings and not your content. To backup your content, please use the WordPress Export Tool.', 'villenoir'); ?></em></p>
            <p class="submit"><input type="submit" name="export" class="button button-primary" value="Download Backup File"></p>
          </form>
        </div>

      <?php

        $options   = get_theme_mods();

      } elseif ( check_admin_referer( 'gg-customizer-export' ) ) {

        $blogname  = strtolower( str_replace(' ', '', get_option( 'blogname' ) ) );
        $date      = date( 'm-d-Y' );
        $json_name = $blogname . '-customizer-' . $date;

        // global
        global $wpdb;

        // vars
        $theme_options = array();

        $rows = $wpdb->get_results($wpdb->prepare(
            "SELECT option_name, option_value FROM $wpdb->options WHERE option_name LIKE %s OR option_name LIKE %s",
            'options' . '_%' ,
            '_' . 'options' . '_%' 
        ), ARRAY_A);
        
        if( !empty($rows) ) {
            
            foreach( $rows as $row ) {
                
                $theme_options[ $row['option_name'] ] = maybe_unserialize($row['option_value']);
                
            }
            
        }

        ob_clean();

        echo json_encode( $theme_options );

        header( 'Content-Type: text/json; charset=' . get_option( 'blog_charset' ) );
        header( 'Content-Disposition: attachment; filename=' . $json_name . '.json' );

        exit();

      }
    }

    

    /**
     * villenoir_add_widget_to_sidebar Import sidebars
     * @param  string $sidebar_slug    Sidebar slug to add widget
     * @param  string $widget_slug     Widget slug
     * @param  string $count_mod       position in sidebar
     * @param  array  $widget_settings widget settings
     *
     * @since 2.2.0
     *
     * @return null
     */
    public function villenoir_add_widget_to_sidebar($sidebar_slug, $widget_slug, $count_mod, $widget_settings = array()){

        $sidebars_widgets = get_option('sidebars_widgets');

        if(!isset($sidebars_widgets[$sidebar_slug]))
           $sidebars_widgets[$sidebar_slug] = array('_multiwidget' => 1);

        $newWidget = get_option('widget_'.$widget_slug);

        if(!is_array($newWidget))
            $newWidget = array();

        $count = count($newWidget)+1+$count_mod;
        $sidebars_widgets[$sidebar_slug][] = $widget_slug.'-'.$count;

        $newWidget[$count] = $widget_settings;

        update_option('sidebars_widgets', $sidebars_widgets);
        update_option('widget_'.$widget_slug, $newWidget);

    }

    public function villenoir_set_demo_data( $file ) {

	    if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);

        require_once ABSPATH . 'wp-admin/includes/import.php';

        $importer_error = false;

        if ( !class_exists( 'WP_Importer' ) ) {

            $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
	
            if ( file_exists( $class_wp_importer ) ){

                require_once($class_wp_importer);

            } else {

                $importer_error = true;

            }

        }

        if ( !class_exists( 'WP_Import' ) ) {

            $class_wp_import = get_template_directory() . '/admin/importer/importer/wordpress-importer.php';

            if ( file_exists( $class_wp_import ) ) 
                require_once($class_wp_import);
            else
                $importer_error = true;

        }

        if($importer_error){

            die("Error on import");

        } else {
			
			//var_export( $file );
			
            if(!is_file( $file )){

                echo "The XML file containing the dummy content is not available or could not be read .You might want to try to set the file permission to chmod 755.<br/>If this doesn't work please use the Wordpress importer and import the XML file (should be located in your download .zip: Sample Content folder) manually ";

            } else {

               $wp_import = new WP_Import();
               $wp_import->fetch_attachments = true;
               $wp_import->import( $file );

         	}

    	}

    }

    public function villenoir_remove_hello_post() {}
    public function villenoir_set_demo_menus() {}
    public function villenoir_set_page_options() {}
    public function villenoir_set_revslider_options() {}
    public function villenoir_set_events_options() {}

    public function villenoir_set_demo_theme_options( $file ) {

        global $wp_filesystem;
    	// File exists?
		if ( ! $wp_filesystem->exists($file) ) {
			wp_die(
				esc_html__( 'Theme options Import file could not be found. Please try again.', 'villenoir' ),
				'',
				array( 'back_link' => true )
			);
		}

		// Get file contents and decode
		$data = $wp_filesystem->get_contents( $file );

		$data = json_decode( $data, true );

		// Have valid data?
		// If no data or could not decode
		if ( empty( $data ) || ! is_array( $data ) ) {
			wp_die(
				esc_html__( 'Theme options import data could not be read. Please try a different file.', 'villenoir' ),
				'',
				array( 'back_link' => true )
			);
		}

		// Hook before import
		$data = apply_filters( 'okthemes_theme_import_theme_options', $data );

        //Set the options
        foreach ( $data as $key => $value ) {
          update_option( $key, $value );
        }

    }

    /**
     * Available widgets
     *
     * Gather site's widgets into array with ID base, name, etc.
     * Used by export and import functions.
     *
     * @since 2.2.0
     *
     * @global array $wp_registered_widget_updates
     * @return array Widget information
     */
    function villenoir_available_widgets() {

    	global $wp_registered_widget_controls;

    	$widget_controls = $wp_registered_widget_controls;

    	$available_widgets = array();

    	foreach ( $widget_controls as $widget ) {

    		if ( ! empty( $widget['id_base'] ) && ! isset( $available_widgets[$widget['id_base']] ) ) { // no dupes

    			$available_widgets[$widget['id_base']]['id_base'] = $widget['id_base'];
    			$available_widgets[$widget['id_base']]['name'] = $widget['name'];

    		}

    	}

    	return apply_filters( 'okthemes_theme_import_widget_available_widgets', $available_widgets );

    }


    /**
     * Process import file
     *
     * This parses a file and triggers importation of its widgets.
     *
     * @since 2.2.0
     *
     * @param string $file Path to .wie file uploaded
     * @global string $widget_import_results
     */
    function villenoir_process_widget_import_file( $file ) {

        global $wp_filesystem;
    	// File exists?
        if ( ! $wp_filesystem->exists($file) ) {
    		wp_die(
    			esc_html__( 'Widget Import file could not be found. Please try again.', 'villenoir' ),
    			'',
    			array( 'back_link' => true )
    		);
    	}

    	// Get file contents and decode
    	$data = $wp_filesystem->get_contents( $file );
    	$data = json_decode( $data );

    	// Delete import file
    	//unlink( $file );

    	// Import the widget data
    	// Make results available for display on import/export page
    	$this->widget_import_results = $this->villenoir_import_widgets( $data );

    }


    /**
     * Import widget JSON data
     *
     * @since 2.2.0
     * @global array $wp_registered_sidebars
     * @param object $data JSON widget data from .wie file
     * @return array Results array
     */
    public function villenoir_import_widgets( $data ) {

    	global $wp_registered_sidebars;

    	// Have valid data?
    	// If no data or could not decode
    	if ( empty( $data ) || ! is_object( $data ) ) {
    		wp_die(
    			esc_html__( 'Widget import data could not be read. Please try a different file.', 'villenoir' ),
    			'',
    			array( 'back_link' => true )
    		);
    	}

    	// Hook before import
    	$data = apply_filters( 'okthemes_theme_import_widget_data', $data );

    	// Get all available widgets site supports
    	$available_widgets = $this->villenoir_available_widgets();

    	// Get all existing widget instances
    	$widget_instances = array();
    	foreach ( $available_widgets as $widget_data ) {
    		$widget_instances[$widget_data['id_base']] = get_option( 'widget_' . $widget_data['id_base'] );
    	}

    	// Begin results
    	$results = array();

    	// Loop import data's sidebars
    	foreach ( $data as $sidebar_id => $widgets ) {

    		// Skip inactive widgets
    		// (should not be in export file)
    		if ( 'wp_inactive_widgets' == $sidebar_id ) {
    			continue;
    		}

    		// Check if sidebar is available on this site
    		// Otherwise add widgets to inactive, and say so
    		if ( isset( $wp_registered_sidebars[$sidebar_id] ) ) {
    			$sidebar_available = true;
    			$use_sidebar_id = $sidebar_id;
    			$sidebar_message_type = 'success';
    			$sidebar_message = '';
    		} else {
    			$sidebar_available = false;
    			$use_sidebar_id = 'wp_inactive_widgets'; // add to inactive if sidebar does not exist in theme
    			$sidebar_message_type = 'error';
    			$sidebar_message = esc_html__( 'Sidebar does not exist in theme (using Inactive)', 'villenoir' );
    		}

    		// Result for sidebar
    		$results[$sidebar_id]['name'] = ! empty( $wp_registered_sidebars[$sidebar_id]['name'] ) ? $wp_registered_sidebars[$sidebar_id]['name'] : $sidebar_id; // sidebar name if theme supports it; otherwise ID
    		$results[$sidebar_id]['message_type'] = $sidebar_message_type;
    		$results[$sidebar_id]['message'] = $sidebar_message;
    		$results[$sidebar_id]['widgets'] = array();

    		// Loop widgets
    		foreach ( $widgets as $widget_instance_id => $widget ) {

    			$fail = false;

    			// Get id_base (remove -# from end) and instance ID number
    			$id_base = preg_replace( '/-[0-9]+$/', '', $widget_instance_id );
    			$instance_id_number = str_replace( $id_base . '-', '', $widget_instance_id );

    			// Does site support this widget?
    			if ( ! $fail && ! isset( $available_widgets[$id_base] ) ) {
    				$fail = true;
    				$widget_message_type = 'error';
    				$widget_message = esc_html__( 'Site does not support widget', 'villenoir' ); // explain why widget not imported
    			}

    			// Filter to modify settings before import
    			// Do before identical check because changes may make it identical to end result (such as URL replacements)
    			$widget = apply_filters( 'okthemes_theme_import_widget_settings', $widget );

    			// Does widget with identical settings already exist in same sidebar?
    			if ( ! $fail && isset( $widget_instances[$id_base] ) ) {

    				// Get existing widgets in this sidebar
    				$sidebars_widgets = get_option( 'sidebars_widgets' );
    				$sidebar_widgets = isset( $sidebars_widgets[$use_sidebar_id] ) ? $sidebars_widgets[$use_sidebar_id] : array(); // check Inactive if that's where will go

    				// Loop widgets with ID base
    				$single_widget_instances = ! empty( $widget_instances[$id_base] ) ? $widget_instances[$id_base] : array();
    				foreach ( $single_widget_instances as $check_id => $check_widget ) {

    					// Is widget in same sidebar and has identical settings?
    					if ( in_array( "$id_base-$check_id", $sidebar_widgets ) && (array) $widget == $check_widget ) {

    						$fail = true;
    						$widget_message_type = 'warning';
    						$widget_message = esc_html__( 'Widget already exists', 'villenoir' ); // explain why widget not imported

    						break;

    					}

    				}

    			}

    			// No failure
    			if ( ! $fail ) {

    				// Add widget instance
    				$single_widget_instances = get_option( 'widget_' . $id_base ); // all instances for that widget ID base, get fresh every time
    				$single_widget_instances = ! empty( $single_widget_instances ) ? $single_widget_instances : array( '_multiwidget' => 1 ); // start fresh if have to
    				$single_widget_instances[] = (array) $widget; // add it

    					// Get the key it was given
    					end( $single_widget_instances );
    					$new_instance_id_number = key( $single_widget_instances );

    					// If key is 0, make it 1
    					// When 0, an issue can occur where adding a widget causes data from other widget to load, and the widget doesn't stick (reload wipes it)
    					if ( '0' === strval( $new_instance_id_number ) ) {
    						$new_instance_id_number = 1;
    						$single_widget_instances[$new_instance_id_number] = $single_widget_instances[0];
    						unset( $single_widget_instances[0] );
    					}

    					// Move _multiwidget to end of array for uniformity
    					if ( isset( $single_widget_instances['_multiwidget'] ) ) {
    						$multiwidget = $single_widget_instances['_multiwidget'];
    						unset( $single_widget_instances['_multiwidget'] );
    						$single_widget_instances['_multiwidget'] = $multiwidget;
    					}

    					// Update option with new widget
    					update_option( 'widget_' . $id_base, $single_widget_instances );

    				// Assign widget instance to sidebar
    				$sidebars_widgets = get_option( 'sidebars_widgets' ); // which sidebars have which widgets, get fresh every time
    				$new_instance_id = $id_base . '-' . $new_instance_id_number; // use ID number from new widget instance
    				$sidebars_widgets[$use_sidebar_id][] = $new_instance_id; // add new instance to sidebar
    				update_option( 'sidebars_widgets', $sidebars_widgets ); // save the amended data

    				// Success message
    				if ( $sidebar_available ) {
    					$widget_message_type = 'success';
    					$widget_message = esc_html__( 'Imported', 'villenoir' );
    				} else {
    					$widget_message_type = 'warning';
    					$widget_message = esc_html__( 'Imported to Inactive', 'villenoir' );
    				}

    			}

    			// Result for widget instance
    			$results[$sidebar_id]['widgets'][$widget_instance_id]['name'] = isset( $available_widgets[$id_base]['name'] ) ? $available_widgets[$id_base]['name'] : $id_base; // widget name or ID if name not available (not supported by site)
    			$results[$sidebar_id]['widgets'][$widget_instance_id]['title'] = $widget->title ? $widget->title : esc_html__( 'No Title', 'villenoir' ); // show "No Title" if widget instance is untitled
    			$results[$sidebar_id]['widgets'][$widget_instance_id]['message_type'] = $widget_message_type;
    			$results[$sidebar_id]['widgets'][$widget_instance_id]['message'] = $widget_message;

    		}

    	}

    	// Hook after import
    	do_action( 'okthemes_theme_import_widget_after_import' );

    	// Return results
    	return apply_filters( 'okthemes_theme_import_widget_results', $results );

    }

}

?>