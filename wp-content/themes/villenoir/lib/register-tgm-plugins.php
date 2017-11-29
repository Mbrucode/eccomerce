<?php
add_action( 'tgmpa_register', 'villenoir_register_required_plugins' );

function villenoir_register_required_plugins() {
    $plugins = array(
        array(
            'name'               => 'OKThemes Villenoir Shortcodes', // The plugin name
            'slug'               => 'okthemes-villenoir-shortcodes', // The plugin slug (typically the folder name)
            'source'             => get_stylesheet_directory() . '/plugins/okthemes-villenoir-shortcodes.zip', // The plugin source
            'required'           => true, // If false, the plugin is only 'recommended' instead of required
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'       => '', // If set, overrides default API URL and points to an external URL
            'version'            => '1.1',
        ),
        array(
            'name'               => 'Advanced Custom Fields Pro', // The plugin name
            'slug'               => 'advanced-custom-fields-pro', // The plugin slug (typically the folder name)
            'source'             => get_stylesheet_directory() . '/plugins/advanced-custom-fields-pro.zip', // The plugin source
            'required'           => true, // If false, the plugin is only 'recommended' instead of required
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'       => '', // If set, overrides default API URL and points to an external URL
            'version'            => '5.4.8',
        ),        
        array(
            'name'               => 'WPBakery Visual Composer', // The plugin name
            'slug'               => 'js_composer', // The plugin slug (typically the folder name)
            'source'             => get_stylesheet_directory() . '/plugins/js_composer.zip', // The plugin source
            'required'           => true, // If false, the plugin is only 'recommended' instead of required
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'       => '', // If set, overrides default API URL and points to an external URL
            'version'            => '4.12.1',
        ),
        array(
            'name'               => 'Slider Revolution', // The plugin name
            'slug'               => 'revslider', // The plugin slug (typically the folder name)
            'source'             => get_stylesheet_directory() . '/plugins/revslider.zip', // The plugin source
            'required'           => false, // If false, the plugin is only 'recommended' instead of required
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'       => '', // If set, overrides default API URL and points to an external URL
            'version'            => '5.2.6',
        ),
        array(
            'name'      => 'WooCommerce',
            'slug'      => 'woocommerce',
            'required'  => false,
        ),
        array(
            'name'     => 'MailChimp for WordPress',
            'slug'     => 'mailchimp-for-wp',
            'required' => false,
        ),
        array(
            'name'     => 'Age Verify',
            'slug'     => 'age-verify',
            'required' => false,
        ),
        array(
            'name'     => 'The Events Calendar',
            'slug'     => 'the-events-calendar',
            'required' => false,
        ),
    );

    $config = array(
        'id'           => 'villenoir',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'parent_slug'  => 'themes.php',            // Parent menu slug.
        'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '', 
    );
    tgmpa( $plugins, $config );
}
?>