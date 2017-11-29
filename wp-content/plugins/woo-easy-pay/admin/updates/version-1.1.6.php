<?php
/**
 * Version 1.1.6 data update.
 * @author Clayton Rogers
 * @version 1.1.6
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$license_status = owp_manager()->get_payments_config( 'worldpay_payments_license_status' );

if( !empty( $license_status) ){
	owp_manager()->set_option( 'license_status', $license_status );
}

$license_key = owp_manager()->get_payments_config( 'worldpay_payments_license' );
if( !empty( $license_key ) ){
	owp_manager()->set_option( 'license', $license_key );
	owp_manager()->update_settings();
	owp_manager()->delete_payments_config( 'worldpay_payments_license' );
}

$woocommerce = owp_manager()->get_payments_config( 'worldpay_payments_woocommerce_config' );
$api_keys = owp_manager()->get_payments_config( 'worldpay_api_keys_config' );
$merchant_accounts = owp_manager()->get_payments_config( 'worldpay_merchant_account_id_config' );
$woocommerce_config = owp_manager()->get_payments_config( 'woocommerce_worldpay_payment_gateway_settings' );
$subscriptions = owp_manager()->get_payments_config( 'worldpay_subscription_config' );
$donations = owp_manager()->get_payments_config( 'worldpay_donation_form_settings' );

if( ! empty( $api_keys) ){

	owp_manager()->settings['settlement_currency'] = isset( $api_keys['production']['settlement_currency'] ) ? $api_keys['production']['settlement_currency']  : 'GBP';

	owp_manager()->settings['environment'] = isset( $api_keys['environment'] ) ? $api_keys['environment'] : 'sandbox';
	owp_manager()->settings['production_client_key'] = isset( $api_keys['production']['client_key'] ) ? $api_keys['production']['client_key'] : '';
	owp_manager()->settings['production_service_key'] = isset( $api_keys['production']['service_key'] ) ? $api_keys['production']['service_key'] : '';
	owp_manager()->settings['production_merchant_id'] = isset( $api_keys['production']['merchantId'] ) ? $api_keys['production']['merchantId'] : '';

	owp_manager()->settings['sandbox_client_key'] = isset( $api_keys['sandbox']['client_key'] ) ? $api_keys['sandbox']['client_key'] : '';
	owp_manager()->settings['sandbox_service_key'] = isset( $api_keys['sandbox']['service_key'] ) ? $api_keys['sandbox']['service_key'] : '';
	owp_manager()->settings['sandbox_merchant_id'] = isset( $api_keys['sandbox']['merchantId'] ) ? $api_keys['sandbox']['merchantId'] : '';

	owp_manager()->update_settings();

	owp_manager()->delete_payments_config( 'worldpay_api_keys_config' );
}

if( !empty( $woocommerce ) ){

	owp_manager()->settings['enable_paypal'] = isset( $woocommerce['woopayments_paypal_enabled'] ) && $woocommerce['woopayments_paypal_enabled'] === 'true' ? 'yes' : 'no';
	owp_manager()->settings['production_card_template'] = isset( $woocommerce['template_form_code'] ) ? $woocommerce['template_form_code'] : '';
	owp_manager()->settings['sandbox_card_template'] = isset( $woocommerce['template_form_code'] ) ? $woocommerce['template_form_code'] : '';
	owp_manager()->settings['order_status'] = isset( $woocommerce['order_status'] ) ? $woocommerce['order_status'] : owp_manager()->get_option('order_status');
	owp_manager()->settings['title_text'] = isset( $woocommerce['payment_title'] ) ? $woocommerce['payment_title'] : owp_manager()->get_option('title_text');
	owp_manager()->settings['enabled'] = 'yes';

	owp_manager()->update_settings();

	owp_manager()->delete_payments_config( 'worldpay_payments_woocommerce_config' );
}

if( !empty( $subscriptions ) ){

	owp_manager()->settings['subscription_prefix'] = isset( $subscriptions['order_prefix'] ) ? $subscriptions['order_prefix'] : owp_manager()->get_option( 'subscription_prefix' );

	owp_manager()->update_settings();

	owp_manager()->delete_payments_config( 'worldpay_subscription_config' );
}

if( !empty( $donations) ){

	owp_manager()->settings['donation'] = isset( $donations['donation_form_style'] ) ? $donations['donation_form_style'] : owp_manager()->get_option( 'donation_form_layout' );
	owp_manager()->settings['donations_paypal_enabled'] = isset( $donations['paypal_active'] ) && $donations['paypal_active'] === 'true' ? 'yes' : 'no';
	owp_manager()->settings['donation_settlement_currency'] = owp_manager()->get_option( 'settlement_currency' );
	owp_manager()->settings['donation_button_background'] = isset( $donations['donation_button']['background_color'] ) ? $donations['donation_button']['background_color'] : owp_manager()->get_option( 'donation_button_background' );
	owp_manager()->settings['donation_button_border'] = isset( $donations['donation_button']['border_color'] ) ? $donations['donation_button']['border_color'] : owp_manager()->get_option( 'donation_button_border' );
}

/* $posts = get_posts( array(
 'posts_per_page'=>-1,
 'post_type'=>array('shop_order', 'shop_subscription'),
 'post_status'=>'any'
 ) ); */
global $wpdb;
$query = $wpdb->prepare( "SELECT post_id FROM {$wpdb->prefix}postmeta WHERE meta_key = %s AND meta_value = %s ", '_payment_method', 'worldpay_payment_gateway' );

$results = $wpdb->get_results( $query, ARRAY_A );

if( $results ){
	$count = 0;
	foreach( $results as $post ){
		update_post_meta( $post['post_id'], '_payment_method', 'online_worldpay_gateway' );
		$count++;
	}
	owp_manager()->log->writeToLog( sprintf( 'During upgrade to version %s, %s orders were updated with the new payment gateway name.', owp_manager()->version, $count ) );
}


owp_manager()->addAdminNotice( array(
		'type'=>'success',
		'text'=>__('Online Worldpay - Your data has been updated to the new format. Please check your config to ensure your settings have not been altered.' , 'onlineworldpay' )
));