<?php
use Worldpay\Worldpay;
use Worldpay\WorldpayException;
/**
 * Main class used by plugin.
 *
 * @author Clayton Rogers
 *        
 */
class OnlineWorldpay_Manager
{
	public static $_instance = null;
	public $version = '1.2.3';
	const Settings = 'onlineworldpay_payment_settings';
	public $worldpay;
	public $log;
	public $settings;

	public static function instance()
	{
		if ( self::$_instance == null ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct()
	{
		$this->log = new OnlineWorldpay_DebugLog();
		$this->required_settings = include_once ONLINEWORLDPAY_ADMIN . '/includes/onlineworldpay-settings.php';
		$this->debug = $this->get_option( 'enable_debug' ) === 'yes' ? true : false;
		$this->initializeWorldpay();
	}

	private function init_settings()
	{
		$this->settings = $this->get_payments_config( self::Settings );
	}

	/**
	 * Initialize the Worldpay object.
	 */
	private function initializeWorldpay()
	{
		try {
			$this->worldpay = new Worldpay( $this->getServiceKey() );
			if ( $this->getEnvironment() === 'sandbox' ) {
				$this->worldpay->disableSSLCheck( true ); // disable SSL check for sandbox.
			}
		} catch( WorldpayException $e ) {
		}
	}

	public function isActive( $option )
	{
		return $this->get_option( $option ) === 'yes' ? true : false;
	}

	public function get_option( $key )
	{
		if ( $this->settings == null ) {
			$this->init_settings();
		}
		if ( ! isset( $this->settings [ $key ] ) ) {
			$this->settings [ $key ] = isset( $this->required_settings [ $key ] [ 'default' ] ) ? $this->required_settings [ $key ] [ 'default' ] : '';
		}
		return $this->settings [ $key ];
	}

	public function set_option( $key, $value = '' )
	{
		$this->settings [ $key ] = $value;
	}

	public function update_settings( $settings = null )
	{
		if ( $this->settings == null ) {
			$this->init_settings();
		}
		if ( $settings != null ) {
			$this->settings = $settings;
		}
		$this->update_payments_config( self::Settings, $this->settings );
	}

	private function update_payments_config( $option, $value )
	{
		update_option( base64_encode( $option ), base64_encode( maybe_serialize( $value ) ) );
	}

	public function get_payments_config( $option )
	{
		return maybe_unserialize( base64_decode( get_option( base64_encode( $option ) ) ) );
	}

	public function delete_payments_config( $option )
	{
		delete_option( base64_encode( $option ) );
	}

	public function display_debugLog()
	{
		$log = new OnlineWorldpay_DebugLog();
		return $log->display_debugLog();
	}

	public function getServiceKey()
	{
		return $this->get_option( $this->getEnvironment() . '_service_key' );
	}

	public function getClientKey()
	{
		return $this->get_option( $this->getEnvironment() . '_client_key' );
	}

	public function getCardTemplateCode()
	{
		return $this->get_option( $this->getEnvironment() . '_card_template' );
	}

	public function getCVCTemplateCode()
	{
		return $this->get_option( $this->getEnvironment() . '_cvc_template' );
	}

	public function getEnvironment()
	{
		$environment = $this->get_option( 'environment' ) === 'sandbox' ? 'sandbox' : 'production';
		if ( strtolower( $this->get_option( 'license_status' ) ) === 'inactive' ) {
			$environment = 'sandbox';
		}
		return $environment;
	}

	public function activateLicense( $license_key )
	{
		$url_args = array (
				'slm_action' => 'slm_activate', 
				'secret_key' => ONLINEWORLDPAY_LICENSE_VERIFICATION_KEY, 
				'license_key' => $license_key 
		);
		$url = add_query_arg( $url_args, ONLINEWORLDPAY_LICENSE_ACTIVATION_URL );
		$headers = array (
				'Content-type: text/html' 
		);
		$options = array (
				CURLOPT_URL => $url, 
				CURLOPT_CONNECTTIMEOUT => 60, 
				CURLOPT_RETURNTRANSFER => true, 
				CURLOPT_SSL_VERIFYPEER => false, 
				CURLOPT_SSL_VERIFYHOST => false, 
				CURLOPT_CAINFO => ONLINEWORLDPAY_PLUGIN_PATH . 'ssl/wordpress_paymentplugins_com.crt', 
				CURLOPT_HTTPHEADER => $headers 
		);
		$response = $this->executeCurl( $options );
		if ( $response [ 'result' ] === 'success' ) {
			$this->set_option( 'license_status', 'active' );
			$this->set_option( 'license', $license_key );
			$this->update_settings();
			$this->log->writeToLog( 'License activated. Message - ' . $response [ 'message' ] );
			$this->addAdminNotice( array (
					'type' => 'success', 
					'text' => __( 'Your license has been activated!', 'onlineworldpay' ) 
			) );
		} else {
			$this->log->writeErrorToLog( 'There was an error activating your license. Message - ' . $response [ 'message' ] );
			$message [ 'type' ] = 'error';
			$message [ 'text' ] = sprintf( __( 'There was an error activating your license. Message: %s', 'onlineworldpay' ), $response [ 'message' ] );
			$this->addAdminNotice( $message );
		}
	}

	public function executeCurl( $options = array() )
	{
		$ch = curl_init();
		curl_setopt_array( $ch, $options );
		$response = curl_exec( $ch );
		$errNo = curl_errno( $ch );
		curl_close( $ch );
		return json_decode( $response, true );
	}

	public static function licenseActivationFailureNotice()
	{
		echo '<div class="notice notice-error">
			  <p>' . __( 'Your license could not be activated. Please check the debug log to view the error
			  		message.', 'onlineworldpay' ) . '</p></div>';
	}

	/**
	 * Deletes the debug log entries.
	 */
	public function deleteDebugLog()
	{
		$log = new OnlineWorldpay_DebugLog();
		$log->delete_log();
	}

	/**
	 * Method that determines if WooCommerce Subscriptions is active.
	 */
	public function woocommerceSubscriptionsActive()
	{
		$array = $this->getActivePlugins();
		return ( in_array( 'woocommerce-subscriptions/woocommerce-subscriptions.php', $array ) || array_key_exists( 'woocommerce-subscriptions/woocommerce-subscriptions.php', $array ) );
	}

	public function getActivePlugins()
	{
		return get_option( 'active_plugins' );
	}

	/**
	 * Retrieve the parameter from the $_POST, $_GET, or $_REQUEST
	 *
	 * @param string $string        	
	 */
	public function getRequestParameter( $string )
	{
		$parameter;
		if ( isset( $_POST [ $string ] ) ) {
			$parameter = $_POST [ $string ];
		} elseif ( isset( $_GET [ $string ] ) ) {
			$parameter = $_GET [ $string ];
		} elseif ( isset( $_REQUEST [ $string ] ) ) {
			$parameter = $_REQUEST [ $string ];
		} else {
			$parameter = null;
		}
		return $parameter;
	}

	/**
	 * Create an order within the Worldpay environment.
	 *
	 * @param array $attribs        	
	 * @return array|Exception|WorldpayException
	 */
	public function createOrder( $attribs )
	{
		$response = null;
		try {
			$response = $this->worldpay->createOrder( $attribs );
			
			if ( $response [ 'paymentStatus' ] === 'SUCCESS' || $response [ 'paymentStatus' ] === 'PRE_AUTHORIZED' ) {
				$this->log->writeToLog( sprintf( 'Payment Success: %s', print_r( $response, true ) ) );
			} else {
				throw new WorldpayException( $response [ 'paymentStatusReason' ] );
			}
		} catch( WorldpayException $e ) {
			$this->log->writeErrorToLog( sprintf( 'Payment failure: %s.', print_r( $response, true ) ) );
			$response = $e;
		} catch( Exception $e ) {
			$this->log->writeErrorToLog( sprintf( 'Error Code: %s. Error Messages: %s.', $e->getCode(), $e->getMessage() ) );
			$response = $e;
		}
		return $response;
	}

	public function create3dsOrder( $orderCode, $paRes )
	{
		$response = null;
		try {
			$response = $this->worldpay->authorize3DSOrder( $orderCode, $paRes );
			if ( $response [ 'paymentStatus' ] === 'SUCCESS' || $response [ 'paymentStatus' ] === 'PRE_AUTHORIZED' ) {
				$this->log->writeToLog( sprintf( 'Payment Success: %s', print_r( $response, true ) ) );
			} else {
				throw new WorldpayException( $response [ 'iso8583Status' ] );
			}
		} catch( WorldpayException $e ) {
			$this->log->writeToLog( sprintf( 'There was an error authorizing the 3DS secure payment for orderCode %s. Message: %s', $orderCode, $e->getMessage() ) );
			$response = $e;
		}
		return $response;
	}

	/**
	 * Process the PayPal order.
	 *
	 * @param array $attribs        	
	 * @param WC_Order $order        	
	 */
	public function createApmOrder( $attribs )
	{
		$response = null;
		try {
			$response = $this->worldpay->createApmOrder( $attribs );
			if ( $response [ 'paymentStatus' ] === 'SUCCESS' || $response [ 'paymentStatus' ] === 'PRE_AUTHORIZED' ) {
				$this->log->writeToLog( sprintf( 'Payment Success: %s', print_r( $response, true ) ) );
			} else {
				throw new WorldpayException( print_r( $response ), true );
			}
		} catch( WorldpayException $e ) {
			$response = $e;
			$this->log->writeErrorToLog( sprintf( 'Error Code: %s. Http Status Code: %s. Error Description: %s.
					Error Message: %s.', $e->getCustomCode(), $e->getHttpStatusCode(), $e->getDescription(), $e->getMessage() ) );
		} catch( Exception $e ) {
			$this->log->writeErrorToLog( sprintf( 'Error Code: %s. Error Messages: %s.', $e->getCode(), $e->getMessage() ) );
			$response = $e;
		}
		return $response;
	}

	/**
	 * Refund the order for the amount given.
	 *
	 * @param WC_Order $order        	
	 * @param unknown $amount        	
	 */
	public function refundOrder( WC_Order $order, $amount )
	{
		$response = null;
		try {
			$this->worldpay->refundOrder( $order->get_transaction_id(), $amount );
			$this->log->writeToLog( sprintf( 'Order %s has been refunded in the amount of %s%s.', $order->id, owp_get_currency_symbol( $order->order_currency ), $amount / pow( 10, owp_get_currency_code_exponent( $order->order_currency ) ) ) );
			$response = true;
		} catch( WorldpayException $e ) {
			$response = new WP_Error( 'transaction', sprintf( __( 'Order %s could not be refunded. Reason: %s', 'onlineworldpay' ), $order->id, $e->getMessage() ) );
			$this->log->writeToLog( sprintf( 'There was an error while refunding transaction %s. Message: %s', 'onlineworldpay' ), $transaction_id, $e->getMessage() );
		}
		return $response;
	}

	/**
	 * Save the meta data from the Worldpay Response to the order meta data.
	 *
	 * @param array $response        	
	 * @param WC_Order $order        	
	 */
	public function saveWooCommerceOrderMeta( $response, WC_Order $order )
	{
		update_post_meta( owp_get_order_property( 'id', $order ), '_payment_method_token', $response [ 'token' ] );
		update_post_meta( owp_get_order_property( 'id', $order ), '_payment_method_title', $this->getPaymentMethodTitle( $response [ 'paymentResponse' ] ) );
		update_post_meta( owp_get_order_property( 'id', $order ), '_transaction_id', $response [ 'orderCode' ] );
		update_post_meta( owp_get_order_property( 'id', $order ), '_payment_method_type', $response [ 'paymentResponse' ] [ 'type' ] );
	}

	/**
	 * Save the meta data from the Worldpay Response to the subscription meta data.
	 *
	 * @param array $response        	
	 * @param WC_Order $order        	
	 */
	public function saveSubscriptionMeta( $response, WC_Order $order )
	{
		$subscriptions = wcs_get_subscriptions_for_order( $order );
		foreach ( $subscriptions as $subsciption ) {
			$this->saveWooCommerceOrderMeta( $response, $subsciption );
		}
	}

	/**
	 * Update the Subscriptions contained within the order with the configured status.
	 * 
	 * @deprecated
	 *
	 * @param WC_Order $order        	
	 */
	public function updateSubscriptionStatus( WC_Order $order )
	{
		$subscriptions = wcs_get_subscriptions_for_order( $order );
		foreach ( $subscriptions as $subsciption ) {
			$subsciption->update_status( $this->get_option( 'subscriptions_payment_success_status' ) );
		}
	}

	/**
	 * Retrieve the payment method title from the response array.
	 *
	 * @param array $response        	
	 * @return string
	 */
	public function getPaymentMethodTitle( $response )
	{
		$paymentMethodTitle = null;
		
		if ( $response [ 'type' ] === 'ObfuscatedCard' ) {
			$paymentMethodTitle = sprintf( '%s %s', $response [ 'cardType' ], $response [ 'maskedCardNumber' ] );
		} else if ( $response [ 'type' ] === 'APM' ) {
			$paymentMethodTitle = sprintf( '%s - %s', $response [ 'apmName' ], $response [ 'name' ] );
		}
		return $paymentMethodTitle;
	}

	/**
	 * Return true if the user has saved payment methods.
	 *
	 * @param int $user_id        	
	 * @return bool
	 */
	public function customerHasPaymentMethods( $user_id )
	{
		$hasMethods = false;
		if ( $user_id ) {
			$methods = $this->getCustomerPaymentMethods( $user_id );
			if ( $methods ) {
				$hasMethods = true;
			}
		}
		return $hasMethods;
	}

	/**
	 * Return the usermeta for saved payment methods.
	 *
	 * @param unknown $user_id        	
	 */
	public function getCustomerPaymentMethods( $user_id )
	{
		return get_user_meta( $user_id, 'onlineworldpay_' . $this->getEnvironment() . '_paymentmethods', true );
	}

	/**
	 * If the customer has selected to save the payment method, store it in the usermeta table.
	 *
	 * @param int $user_id        	
	 * @param array $order        	
	 */
	public function maybeSavePaymentMethod( $user_id, $response )
	{
		if ( $user_id && $this->getRequestParameter( 'onlineworldpay_save_method' ) ) {
			$this->updateCustomerPaymentMethods( $user_id, $response );
		}
	}

	public function maybeSavePaymentMethodForSubscription( $user_id, $token )
	{
		$payment_methods = $this->getCustomerPaymentMethods( $user_id );
		if ( empty( $payment_methods ) ) {
			$payment_method = array ();
		} else {
			$this->updateDefaultCard( $payment_methods );
		}
		$save_method = true;
		foreach ( $payment_methods as $method ) {
			if ( $method [ 'token' ] === $token ) {
				$save_method = false;
			}
		}
		if ( $save_method ) {
			$payment_method = $this->getPaymentMethod( $token );
			$payment_methods [ $token ] = array (
					'token' => $token, 
					'maskedNumber' => $payment_method [ 'maskedCardNumber' ], 
					'cardType' => $payment_method [ 'cardType' ], 
					'expMonth' => $payment_method [ 'expiryMonth' ], 
					'default' => 'true' 
			);
			
			update_user_meta( $user_id, 'onlineworldpay_' . $this->getEnvironment() . '_paymentmethods', $payment_methods );
			$this->log->writeToLog( sprintf( 'Payment method added for user %s.', $user_id ) );
		}
	}

	/**
	 * Update the customer payment methods.
	 *
	 * @param int $user_id        	
	 * @param array $response        	
	 */
	public function updateCustomerPaymentMethods( $user_id, $response )
	{
		$methods = $this->getCustomerPaymentMethods( $user_id );
		if ( empty( $methods ) ) {
			$methods = array ();
		} else {
			$this->updateDefaultCard( $methods );
		}
		
		$methods [ $response [ 'token' ] ] = array (
				'token' => $response [ 'token' ], 
				'maskedNumber' => $response [ 'paymentResponse' ] [ 'maskedCardNumber' ], 
				'cardType' => $response [ 'paymentResponse' ] [ 'cardType' ], 
				'expMonth' => $response [ 'paymentResponse' ] [ 'expiryMonth' ], 
				'default' => 'true' 
		);
		
		update_user_meta( $user_id, 'onlineworldpay_' . $this->getEnvironment() . '_paymentmethods', $methods );
		$this->log->writeToLog( sprintf( 'Payment method added for user %s.', $user_id ) );
	}

	/**
	 * Reset the all the default payment methods to false.
	 *
	 * @param unknown $methods        	
	 */
	public function updateDefaultCard( &$methods )
	{
		foreach ( $methods as &$method ) {
			$method [ 'default' ] = 'false';
		}
	}

	/**
	 *
	 * @param int $user_id        	
	 * @param array $response        	
	 */
	public function savePaymentMethod( $user_id, $response )
	{
		$this->updateCustomerPaymentMethods( $user_id, $response );
	}

	/**
	 * Return the OnlineWorldpay payment method token from the request.
	 */
	public function getPaymentMethodToken()
	{
		return $this->getRequestParameter( 'onlineworldpay_payment_method_token' );
	}

	/**
	 *
	 * @param array $message        	
	 */
	public function addAdminNotice( $message )
	{
		$messages = get_transient( 'onlineworlpay_admin_notices' );
		if ( empty( $messages ) ) {
			$messages = array ();
		}
		$messages [] = $message;
		set_transient( 'onlineworlpay_admin_notices', $messages );
	}

	/**
	 * Retrieve the payment method from Online Worldpay.
	 *
	 * @param unknown $token        	
	 */
	public function getPaymentMethod( $token )
	{
		$response = null;
		try {
			$response = $this->worldpay->getStoredCardDetails( $token );
		} catch( WorldpayException $e ) {
			$this->log->writeToLog( sprintf( 'There was error retrieving payment method %s. Message: %s', $token, $e->getMessage() ) );
		}
		return $response;
	}

	/**
	 * Delete the payment method from Online Worldpay.
	 *
	 * @param unknown $token        	
	 */
	public function deletePaymentMethod( $token )
	{
		$response = null;
		try {
			$response = $this->worldpay->deleteToken( $token );
		} catch( WorldpayException $e ) {
			$this->log->writeErrorToLog( sprintf( 'Payment method %s does not exist in the Online Worldpa environment.' ) );
		}
		return $response;
	}

	public function getOrderDetails( $order_code )
	{
		$response = null;
		try {
			$response = $this->worldpay->getOrder( $order_code );
		} catch( WorldpayException $e ) {
			$response = $e;
			$this->log->writeErrorToLog( sprintf( 'There was an error while fetching order %s. Message: %s' ), $order_code, $e->getMessage() );
		}
		return $response;
	}

	/**
	 * Save the order and subscription meta for the synchronized subscription.
	 *
	 * @param WC_Order $order        	
	 * @param unknown $attribs        	
	 */
	public function saveSynchronizedSubscriptionMeta( WC_Order $order, $attribs )
	{
		$subscriptions = wcs_get_subscriptions_for_order( $order );
		$payment_method = $this->getPaymentMethod( $attribs [ 'token' ] );
		foreach ( $subscriptions as $subscription ) {
			update_post_meta( $subscription->id, '_payment_method_token', $attribs [ 'token' ] );
			update_post_meta( $subscription->id, '_payment_method_title', $this->getPaymentMethodTitle( $payment_method ) );
		}
		update_post_meta( $order->id, '_payment_method_token', $attribs [ 'token' ] );
		update_post_meta( $order->id, '_payment_method_title', $this->getPaymentMethodTitle( $payment_method ) );
	}

	/**
	 * Add the payment method to the usermeta table.
	 *
	 * @param array $payment_method        	
	 */
	public function add_payment_method( $user_id, $token, $payment_method )
	{
		$payment_methods = $this->getCustomerPaymentMethods( $user_id );
		$payment_methods = ! empty( $payment_methods ) ? $payment_methods : array ();
		$this->updateDefaultCard( $payment_methods );
		$payment_methods [ $token ] = array (
				'token' => $token, 
				'maskedNumber' => $payment_method [ 'maskedCardNumber' ], 
				'cardType' => $payment_method [ 'cardType' ], 
				'expMonth' => $payment_method [ 'expiryMonth' ], 
				'default' => 'true' 
		);
		update_user_meta( $user_id, 'onlineworldpay_' . $this->getEnvironment() . '_paymentmethods', $payment_methods );
	}
}

/**
 * Function that returns an instance of WorldayUK_Manager.
 *
 * @return OnlineWorldpay_Manager
 */
function owp_manager()
{
	return OnlineWorldpay_Manager::instance ();
}