<?php
/*
Plugin Name: OKThemes Villenoir Shortcodes (Posted by Dospel & GanjaParker)
Plugin URI: http://www.okthemes.com
Description: Custom shortcodes for Villenoir theme
Version: 1.1
Author: Gogoneata Cristian
Author URI: http://okthemes.com/
License: GPLv2
*/

// Do not load this file directly!
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

if(!defined('VILLENOIR_SHORTCODES_VERSION')) 
	define( 'VILLENOIR_SHORTCODES_VERSION', '1.1' );
if(!defined('VILLENOIR_SHORTCODES_PATH')) 
	define( 'VILLENOIR_SHORTCODES_PATH', plugin_dir_path(__FILE__) );
if(!defined('VILLENOIR_SHORTCODES_DIR')) 
	define( 'VILLENOIR_SHORTCODES_DIR', plugin_dir_url(__FILE__) );

load_plugin_textdomain( 'villenoir-shortcodes', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

// Do not proceed if VC class WPBakeryShortCode does not exists
if ( ! class_exists( 'WPBakeryShortCode' ) ) {
    return;
}

//Include each file from the visualcomposer directory
foreach (glob(VILLENOIR_SHORTCODES_PATH.'/shortcodes/'."*.php") as $filename) {
    require_once $filename;
}

//Include functions file
require_once VILLENOIR_SHORTCODES_PATH . 'functions.php';
