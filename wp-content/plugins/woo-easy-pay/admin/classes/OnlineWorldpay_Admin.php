<?php
if (! defined ( 'ABSPATH' )) {
	exit (); // Exit if accessed directly
}

/**
 * Main admin class for the OnlineWorldpay plugin.
 * Controls admin screens for plugin configuration.
 *
 * @author Clayton Rogers
 * @since 3/12/16
 */
class OnlineWorldpay_Admin {
	private static $api_view = array (
			'apisettings_title',
			'license_status_notice',
			'environment',
			'production_merchant_id',
			'production_service_key',
			'production_client_key',
			'production_card_template',
			'production_cvc_template',
			'sandbox_merchant_id',
			'sandbox_service_key',
			'sandbox_client_key',
			'sandbox_card_template',
			'sandbox_cvc_template' 
	);
	private static $woocommerce_view = array (
			'woocommerce_title',
			'enabled',
			'enable_paypal',
			'paypal_button',
			'settlement_currency',
			'title_text',
			//'order_status',
			'order_prefix',
			'order_suffix',
			'order_description',
			'payment_methods',
			'enable_3ds_secure',
			'3ds_secure_page' 
	);
	private static $debugLog_view = array (
			'debug_title',
			'enable_debug' 
	);
	private static $license_view = array (
			'license_title',
			'license_status',
			'license' 
	);
	private static $subscriptions_view = array (
			'subscriptions_title',
			'woocommerce_subscriptions',
			'subscription_prefix',
			'subscription_suffix',
			'subscription_description'
			//'subscriptions_payment_success_status',
			//'subscriptions_payment_failed_status',
			//'subscriptions_cancelled_status' 
	);
	private static $donations_view = array (
			'donations_title',
			'donations_paypal_enabled',
			'donation_paypal_button',
			'donation_form_layout',
			'donation_modal_button_text',
			'donation_modal_button_background',
			'donation_modal_button_border',
			'donation_modal_button_text_color',
			'donation_button_text',
			'donation_button_background',
			'donation_button_border',
			'donation_button_text_color',
			'donation_address',
			'donation_default_country',
			'donation_settlement_currency',
			'donation_email',
			'donation_merchant_account_id',
			'donation_name',
			'donation_currency',
			'donation_order_description',
			'donation_success_url',
			'donation_cancel_url',
			'donation_payment_methods' 
	);
	private static $webhooks_view = array (
			'webhooks_title',
			'webhooks_enable',
			'webhooks_url',
			'webhooks_success',
			'webhooks_success_email_admin',
			'webhooks_failed',
			'webhooks_failed_email_admin',
			'webhooks_settled',
			'webhooks_settled_email_admin',
			'webhooks_refunded',
			'webhooks_refunded_email_admin',
			'webhooks_sent_for_refund',
			'webhooks_sent_for_refund_email_admin',
			'webhooks_partially_refunded',
			'webhooks_partially_refunded_email_admin',
			'webhooks_charged_back',
			'webhooks_charged_back_email_admin',
			'webhooks_chargeback_reversed',
			'webhooks_chargeback_reversed_email_admin' 
	);
	private static $validation_fields = array (
			'order_prefix' => array (
					'pattern' => '/^[\w\-_]{1,20}$/',
					'valid' => 'a-z, A-Z, 0-9, -_' 
			),
			'order_suffix' => array (
					'pattern' => '/^[\w\-_]{1,20}$/',
					'valid' => 'a-z, A-Z, 0-9, -_' 
			),
			'subscription_prefix' => array (
					'pattern' => '/^[\w\-_]{1,20}$/',
					'valid' => 'a-z, A-Z, 0-9, -_' 
			),
			'subscription_suffix' => array (
					'pattern' => '/^[\w\-_]{1,20}$/',
					'valid' => 'a-z, A-Z, 0-9, -_' 
			) 
	);
	
	/**
	 * Set initial values required by the class to function.
	 */
	public static function init() {
		add_action ( 'admin_enqueue_scripts', __CLASS__ . '::loadAdminScripts' );
		add_action ( 'admin_menu', __CLASS__ . '::onlineWorldpayAdminMenu' );
		add_action ( 'admin_init', __CLASS__ . '::saveOnlineWorldpaySettings' );
		add_action ( 'admin_notices', array (
				__CLASS__,
				'displayAdminNotices' 
		) );
		add_action ( 'admin_init', __CLASS__ . '::generateWebhookKey' );
	}
	public static function onlineWorldpayAdminMenu() {
		add_menu_page ( 'OnlineWorlpay Payments', 'Online Worldpay Payments', 'manage_options', 'online-worldpay-admin-menu', null, null, '8.134' );
		add_submenu_page ( 'online-worldpay-admin-menu', 'Worldpay Settings', 'API Settings', 'manage_options', 'onlineworldpay-payment-settings', 'OnlineWorldpay_Admin::showAPISettingsView' );
		add_submenu_page ( 'online-worldpay-admin-menu', 'Woocommerce Settings', 'Woocommerce Settings', 'manage_options', 'onlineworldpay-woocommerce-settings', 'OnlineWorldpay_Admin::showWoocommerceView' );
		add_submenu_page ( 'online-worldpay-admin-menu', 'Activate License', 'Activate License', 'manage_options', 'onlineworldpay-license-page', 'OnlineWorldpay_Admin::showLicenseView' );
		add_submenu_page ( 'online-worldpay-admin-menu', 'Subscriptions', 'Subscriptions', 'manage_options', 'onlineworldpay-subscriptions-page', 'OnlineWorldpay_Admin::showSubscriptionView' );
		add_submenu_page ( 'online-worldpay-admin-menu', 'Webhooks', 'Webhooks', 'manage_options', 'onlineworldpay-webhooks-page', 'OnlineWorldpay_Admin::showWebhookView' );
		add_submenu_page ( 'online-worldpay-admin-menu', 'Donations', 'Donations', 'manage_options', 'onlineworldpay-donations-page', 'OnlineWorldpay_Admin::showDonationsView' );
		add_submenu_page ( 'online-worldpay-admin-menu', 'Debug Log', 'Debug Log', 'manage_options', 'onlineworldpay-debug-log', 'OnlineWorldpay_Admin::showDebugView' );
		add_submenu_page ( 'online-worldpay-admin-menu', 'Tutorials', 'Tutorials', 'manage_options', 'onlineworldpay-payments-tutorials', 'OnlineWorldpay_Admin_Tutorial::showTutorialsView' );
		remove_submenu_page ( 'online-worldpay-admin-menu', 'online-worldpay-admin-menu' );
	}
	public static function loadAdminScripts() {
		if (self::isPage ( array (
				'onlineworldpay-payment-settings',
				'onlineworldpay-woocommerce-settings',
				'onlineworldpay-license-page',
				'onlineworldpay-subscriptions-page',
				'onlineworldpay-webhooks-page',
				'onlineworldpay-debug-log',
				'onlineworldpay-payments-tutorials',
				'onlineworldpay-donations-page' 
		) )) {
			wp_enqueue_script ( 'color-picker-colors-script', ONLINEWORLDPAY_ASSETS . 'js/tinyColorPicker-master/colors.js' );
			wp_enqueue_script ( 'color-picker-script', ONLINEWORLDPAY_ASSETS . 'js/tinyColorPicker-master/jqColorPicker.js', array (
					'color-picker-colors-script' 
			) );
			wp_enqueue_script ( 'onlineworldpay-admin-script', ONLINEWORLDPAY_ASSETS . 'js/admin-script.js', array (
					'jquery',
					'color-picker-script' 
			) );
			wp_enqueue_style ( 'onlineworldpay-admin-style', ONLINEWORLDPAY_ASSETS . 'css/admin-style.css' );
		}
		if (self::isPage ( 'onlineworldpay-payments-tutorials' )) {
			wp_enqueue_script ( 'onlineworldpay-admin-tutorials', ONLINEWORLDPAY_ASSETS . 'js/admin-tutorial.js', array (
					'jquery' 
			) );
		}
	}
	public static function saveOnlineWorldpaySettings() {
		if (isset ( $_POST ['save_onlineworldpay_payment_settings'] )) {
			self::saveSettings ( self::$api_view, 'onlineworldpay-payment-settings' );
		} elseif (isset ( $_POST ['save_onlineworldpay_woocommerce_settings'] )) {
			add_filter ( 'onlineworldpay_save_settings', __CLASS__ . '::validateAdminSettings' );
			self::saveSettings ( self::$woocommerce_view, 'onlineworldpay-woocommerce-settings' );
		} elseif (isset ( $_POST ['save_onlineworldpay_woocommerce_subscription_settings'] )) {
			add_filter ( 'onlineworldpay_save_settings', __CLASS__ . '::validateAdminSettings' );
			self::saveSettings ( self::$subscriptions_view, 'onlineworldpay-subscriptions-page' );
		} elseif (isset ( $_POST ['save_onlineworldpay_donation_settings'] )) {
			self::saveSettings ( self::$donations_view, 'onlineworldpay-donations-page' );
		} elseif (isset ( $_POST ['activate_onlineworldpay_license'] )) {
			$license_key = isset ( $_POST ['license'] ) ? $_POST ['license'] : '';
			owp_manager ()->activateLicense ( $license_key );
		} elseif (isset ( $_POST ['onlineworldpay_save_debug_settings'] )) {
			self::saveSettings ( self::$debugLog_view, 'onlineworldpay-debug-log' );
		} elseif (isset ( $_POST ['save_onlineworldpay_webhooks'] )) {
			self::saveSettings ( self::$webhooks_view, 'onlineworldpay-webhooks-page' );
		} elseif (isset ( $_POST ['onlineworldpay_delete_debug_log'] )) {
			owp_manager ()->deleteDebugLog ();
		} elseif (isset ( $_POST ['test_onlineworldpay_connection'] )) {
			owp_manager ()->testBraintreeConnection ( $_POST ['test_braintree_connection'] );
		} elseif (isset ( $_POST ['onlineworldpay_generate_new_key'] )) {
			self::generateNewWebhooksKey ();
		}
	}
	public static function saveSettings($fields, $page) {
		$defaults = array (
				'title' => '',
				'type' => '',
				'value' => '',
				'type' => '',
				'class' => array (),
				'default' => '' 
		);
		$settings = owp_manager ()->settings;
		$required_settings = owp_manager ()->required_settings;
		foreach ( $fields as $field ) {
			$value = isset ( $required_settings [$field] ) ? $required_settings [$field] : $defaults;
			$value = wp_parse_args ( $value, $defaults );
			if (is_array ( $value ['value'] ) && $value ['type'] === 'checkbox') {
				foreach ( $value ['value'] as $k => $v ) {
					$settings [$field] [$k] = isset ( $_POST [$k] ) ? $_POST [$k] : '';
				}
			} else {
				$settings [$field] = isset ( $_POST [$field] ) ? trim ( $_POST [$field] ) : '';
			}
		}
		$settings = apply_filters ( 'onlineworldpay_save_settings', $settings );
		owp_manager ()->update_settings ( $settings );
	}
	public static function getAdminHeader() {
		?>
<div class="onlineworldpay-header">
	<div class="worldpay-logo-inner">
		<a><img
			src="<?php echo ONLINEWORLDPAY_ASSETS.'images/worldpay_logo.png'?>"
			class="onlineworldpay-logo-header" /></a>
	</div>
	<ul>
		<li><a href="?page=onlineworldpay-payment-settings"><?php echo __('API Settings', 'onlineworldpay')?></a></li>
		<li><a href="?page=onlineworldpay-woocommerce-settings"><?php echo __('WooCommerce Settings', 'onlineworldpay')?></a></li>
		<li><a href="?page=onlineworldpay-subscriptions-page"><?php echo __('Subscriptions', 'onlineworldpay')?></a></li>
		<li><a href="?page=onlineworldpay-donations-page"><?php echo __('Donations', 'onineworldpay')?></a></li>
		<li><a href="?page=onlineworldpay-webhooks-page"><?php echo __('Webhooks', 'onlineworldpay')?></a></li>
		<li><a href="?page=onlineworldpay-debug-log"><?php echo __('Debug Log', 'onlineworldpay')?></a></li>
		<li><a href="?page=onlineworldpay-license-page"><?php echo __('Activate License', 'onlineworldpay')?></a></li>
		<li><a href="?page=onlineworldpay-payments-tutorials"><?php echo __('Tutorials', 'onlineworldpay')?></a></li>
	</ul>
</div>
<?php
	}
	public static function displaySettingsPage($fields_to_display, $page, $button) {
		$form_fields = owp_manager ()->required_settings;
		$html = '<div><form method="POST" action="' . get_admin_url () . 'admin.php?page=' . $page . '">';
		$html .= '<table class="onlineworldpay-woocommerce-settings"><tbody>';
		foreach ( $fields_to_display as $key ) {
			$value = isset ( owp_manager ()->required_settings [$key] ) ? owp_manager ()->required_settings [$key] : array ();
			$html .= OnlineWorldpay_HTML_Helper::buildSettings ( $key, $value, owp_manager ()->settings );
		}
		$html .= '</tbody></table>';
		if ($button != null) {
			$html .= '<div><input name="' . $button . '" class="onlineworldpay-payments-save" type="submit" value="Save"></div>';
		}
		$html .= '</form></div>';
		echo $html;
	}
	public static function showAPISettingsView() {
		self::getAdminHeader ();
		self::displaySettingsPage ( self::$api_view, 'onlineworldpay-payment-settings', 'save_onlineworldpay_payment_settings' );
	}
	public static function showWoocommerceView() {
		self::getAdminHeader ();
		if (class_exists ( 'WC_Payment_Gateway' )) {
			self::displaySettingsPage ( self::$woocommerce_view, 'onlineworldpay-woocommerce-settings', 'save_onlineworldpay_woocommerce_settings' );
		} else {
			?>
<div>
	<h1 class="warning"><?php echo __('You must install and activate the <a target="_blank" href="https://wordpress.org/plugins/woocommerce/">WooCommerce Plugin</a> before this screen is available.', 'onlineworldpay')?></h1>
</div>
<?php
		}
	}
	public static function showDonationsView() {
		self::getAdminHeader ();
		self::displaySettingsPage ( self::$donations_view, 'onlineworldpay-donations-page', 'save_onlineworldpay_donation_settings' );
	}
	public static function showDebugView() {
		self::getAdminHeader ();
		self::displaySettingsPage ( self::$debugLog_view, 'onlineworldpay-debug-log', 'onlineworldpay_save_debug_settings' );
		?>
<form class="onlineworldpay-deletelog-form"
	name="onineworldpay_woocommerce_form" method="post"
	action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'].'?page=onlineworldpay-debug-log') ?>">
	<button name="onlineworldpay_delete_debug_log"
		class="onlineworldpay-payments-save" type="submit">Delete Log</button>
</form>
<div class="config-separator"></div>
<div class="onlineworldpay-debug-log-container">
				<?php echo owp_manager()->display_debugLog()?>
			</div>
<?php
	}
	public static function showLicenseView() {
		self::getAdminHeader ();
		self::displaySettingsPage ( self::$license_view, 'onlineworldpay-license-page', 'activate_onlineworldpay_license' );
	}
	public static function showSubscriptionView() {
		self::getAdminHeader ();
		if (owp_manager ()->woocommerceSubscriptionsActive ()) {
			self::displaySettingsPage ( self::$subscriptions_view, 'onlineworldpay-subscriptions-page', 'save_onlineworldpay_woocommerce_subscription_settings' );
		} else {
			echo '<div class="woocommerce-subscription-not-active"><h2>' . __ ( 'In order to sell subscriptions using your Online Worldpay account, you must install and activate the 
					<a target="_blank" href="https://www.woothemes.com/products/woocommerce-subscriptions/">WooCommerce Subscriptions</a> plugin</h2>.', 'onlineworldpay' );
		}
	}
	public static function showWebhookView() {
		self::getAdminHeader ();
		self::displaySettingsPage ( self::$webhooks_view, 'onlineworldpay-webhooks-page', 'save_onlineworldpay_webhooks' );
	}
	public static function getLicenseStatus() {
		$html = '';
		$license_status = owp_manager ()->get_option ( 'license_status' );
		$license_status = $license_status === 'active' ? 'Active' : 'Inactive';
		$html .= '<div class="license--' . $license_status . '"><span>' . $license_status . '</span>';
		if ($license_status === 'Inactive') {
			$html .= '<span class="onlineworldpay-purchase-license"><a target="_blank" href="https://wordpress.paymentplugins.com/product-category/worldpay/">' . __ ( 'Purchase a license', 'onlineworldpay' ) . '</a></span>';
		}
		return $html;
	}
	public static function displayWebhooksUrl() {
		$key = get_option ( 'onlineworldpay_webhooks_key' );
		$url = get_site_url () . '/online~worldpay/webhooks/orders/' . $key;
		if (! preg_match ( '/^https/', $url )) {
			$url = preg_replace ( '/^http/', 'https', $url );
		}
		$html = '<textarea class="onlineworldpay-webhooks-url">' . $url . '</textarea>';
		$html .= '<div class="webhooks-key-new"><input type="submit" name="onlineworldpay_generate_new_key" class="onlineworldpay-payments-save" value="' . __ ( 'New Key', 'onlineworldpay' ) . '"/>';
		return $html;
	}
	public static function deleteSetting() {
		$name = $_POST ['setting'];
		unset ( owp_manager ()->settings [$name] );
		owp_manager ()->update_settings ();
		wp_send_json ( array (
				'result' => 'success' 
		) );
	}
	public static function isPage($page = '') {
		$requestPage = owp_manager ()->getRequestParameter ( 'page' );
		$page = is_array ( $page ) ? $page : array (
				$page 
		);
		return in_array ( $requestPage, $page ) || array_key_exists ( $requestPage, $page );
	}
	public static function validateAdminSettings($settings) {
		foreach ( self::$validation_fields as $key => $field ) {
			$value = isset ( $settings [$key] ) ? $settings [$key] : '';
			if (! empty ( $value )) {
				if (! preg_match ( $field ['pattern'], $value )) {
					$message = array (
							'type' => 'error',
							'text' => sprintf ( __ ( 'You have entered an incorrect %s. Valid values are %s', 'onlineworldpay' ), $key, $field ['valid'] ) 
					);
					$settings [$key] = owp_manager ()->get_option ( $key );
					owp_manager ()->addAdminNotice ( $message );
				}
			}
		}
		return $settings;
	}
	public static function displayAdminNotices() {
		$messages = get_transient ( 'onlineworlpay_admin_notices' );
		if (! empty ( $messages )) {
			foreach ( $messages as $message ) {
				?>
<div class="notice notice-<?php echo $message['type']?>">
	<p><?php echo $message['text']?></p>
</div>
<?php
			}
			delete_transient ( 'onlineworlpay_admin_notices' );
		}
	}
	public static function getPayPalButtons($field) {
		$html = '';
		$value = owp_manager ()->get_option ( 'paypal_button' );
		foreach ( owp_get_paypal_buttons () as $index => $button ) {
			$html .= '<div class="paypal-button"><span><input type="radio" value="' . $index . '" id=paypal_button" name="paypal_button"' . checked ( $index, $value, false ) . '/></span><span><input type="image" style="' . $button ['style'] . '" src="' . $button ['src'] . '"/></span></div>';
		}
		return $html;
	}
	public static function getDonationPayPalButtons() {
		$html = '';
		$value = owp_manager ()->get_option ( 'donation_paypal_button' );
		foreach ( owp_get_paypal_buttons () as $index => $button ) {
			$html .= '<div class="paypal-button"><span><input type="radio" value="' . $index . '" id=donation_paypal_button" name="donation_paypal_button"' . checked ( $index, $value, false ) . '/></span><span><input type="image" style="' . $button ['style'] . '" src="' . $button ['src'] . '"/></span></div>';
		}
		return $html;
	}
	public static function generateWebhookKey() {
		$key = get_option ( 'onlineworldpay_webhooks_key' );
		if (! $key) {
			self::generateNewWebhooksKey ();
		}
	}
	public static function generateNewWebhooksKey() {
		$key = bin2hex ( openssl_random_pseudo_bytes ( 16 ) );
		update_option ( 'onlineworldpay_webhooks_key', $key );
	}
	public static function getPagePostsHtml() {
		ob_start ();
		$value = owp_manager ()->get_option ( '3ds_secure_page' );
		$posts = get_posts ( array (
				'posts_per_page' => - 1,
				'post_type' => 'page' 
		) );
		echo '<div>' . __ ( 'In order to use 3D Secure, you must assign a page where you have entered the shortcode <strong>[onlineworldpay_3ds_page]</strong>. First, create a new page, then paste the short code in the page and publish. Then,
				select the page from the dropdown and save.' ) . '</div>';
		echo '<select name="3ds_secure_page">';
		foreach ( $posts as $post ) {
			echo '<option value="' . $post->ID . '"' . selected ( $value, $post->ID ) . '>' . $post->post_title . '</option>';
		}
		echo '</select>';
		return ob_get_clean ();
	}
}
OnlineWorldpay_Admin::init ();