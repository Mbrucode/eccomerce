<?php

/*
 * Plugin Name: Online Worldpay For WooCommerce
 * Plugin URI: https://wordpress.paymentplugins.com
 * Description: Accept credit card and PayPal payments or donations on your wordpress site using your Online Worldpay merchant account. This plugin is SAQ A compliant.
 * Version: 1.2.3
 * Author: Payment Plugins, support@paymentplugins.com
 * Author URI:
 * Tested up to: 4.8
 */

function wep_invalid_version()
{
	echo '<div class="notice notice-error"><p>' . sprintf( __( 'Online Worldpay For WooCommerce requires at least PHP Version 5.3 but you are using version %s', 'onlineworldpay' ), PHP_VERSION ) . '</p></div>';
}

if ( version_compare( PHP_VERSION, '5.3', '<' ) ) {
	add_action( 'admin_notices', 'wep_invalid_version' );
	return;
}
define( 'ONLINEWORLDPAY_LICENSE_ACTIVATION_URL', 'https://wordpress.paymentplugins.com/' );
define( 'ONLINEWORLDPAY_LICENSE_VERIFICATION_KEY', 'gTys$hsjeScg63dDs35JlWqbx7h' );
define( 'ONLINEWORLDPAY_ADMIN', plugin_dir_path( __FILE__ ) . 'admin/' );
define( 'ONLINEWORLDPAY_PAYMENTS', plugin_dir_path( __FILE__ ) . 'payments/' );
define( 'ONLINEWORLDPAY_ASSETS', plugin_dir_url( __FILE__ ) . 'assets/' );
define( 'ONLINEWORLDPAY_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

include_once ( ONLINEWORLDPAY_PLUGIN_PATH . 'class-loader.php' );