<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * Uninstalling Woo Bag options.
 *
 * @author      author
 * @category    Core
 * @package     Woo_Bag/Uninstaller
 * @version     1.0.0
 */
// If uninstall not called from WordPress, then exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}
global $wpdb;

// Delete options
$wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE 'wb_setting%';");
