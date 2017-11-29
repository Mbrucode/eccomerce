<?php
use Worldpay\WorldpayException;
if ( ! defined( 'ABSPATH' ) ) {
	exit(); // Exit if accessed directly
}
/**
 * Main payment class for Online Worldpay payment functionality.
 *
 * @author Clayton Rogers
 * @version 1.1.6
 */
class WC_OnlineWorldpay extends WC_Payment_Gateway
{
	const GATEWAY_NAME = 'online_worldpay_gateway';
	const PAYMENT_METHOD_DELETE = '/\/?online-worldpay-delete\/([\w-]+)/';

	public function __construct()
	{
		$this->enabled = owp_manager()->get_option( 'enabled' ) === 'yes' ? 'yes' : 'no';
		$this->id = self::GATEWAY_NAME;
		$this->method_title = 'Online Worldpay Gateway';
		$this->title = owp_manager()->get_option( 'title_text' );
		$this->method_description = __( 'Accept credit card and PayPal using your Online Worldpay account.', 'onlineworldpay' );
		$this->has_fields = true;
		$this->supports = $this->getSupportedFeatures();
		add_action( 'wp_enqueue_scripts', __CLASS__ . '::enqueueScripts' );
	}

	/**
	 * If 3D Secure is enabled, start the php session.
	 */
	public static function maybe_start_session()
	{
		if ( owp_manager()->isActive( 'enable_3ds_secure' ) ) {
			@session_start();
		}
	}

	public static function init()
	{
		if ( owp_manager()->isActive( 'enabled' ) ) {
			
			add_filter( 'woocommerce_checkout_fields', __CLASS__ . '::updateCheckoutFields', 10, 1 );
			
			add_action( 'init', __CLASS__ . '::handleApmOrderResponse' );
			
			add_filter( 'onlineworldpay_apm_handle_success', __CLASS__ . '::handleApmOrderSuccess', 10, 2 );
			
			add_filter( 'onlineworldpay_apm_handle_cancel', __CLASS__ . '::handleApmOrderCancel', 10, 2 );
			
			add_filter( 'onlineworldpay_apm_handle_pending', __CLASS__ . '::handleApmOrderPending', 10, 2 );
			
			add_filter( 'onlineworldpay_apm_handle_failure', __CLASS__ . '::handleApmOrderFailure', 10, 2 );
			
			add_filter( 'woocommerce_saved_payment_methods_list', __CLASS__ . '::populateMethodsArray' );
			
			add_filter( 'woocommerce_account_payment_methods_column_description', __CLASS__ . '::output_payment_method_description' );
			
			add_action( 'init', __CLASS__ . '::delete_payment_method' );
			
			add_action( 'init', __CLASS__ . '::handle3dsOrderReturn', 99 );
			
			add_action( 'init', __CLASS__ . '::maybe_start_session' );
			
			add_shortcode( 'onlineworldpay_3ds_page', __CLASS__ . '::output_3ds_page' );
			
			add_filter( 'woocommerce_update_order_review_fragments', __CLASS__ . '::update_order_review_fragments' );
		}
	}

	/**
	 * Add the OnlineWorldpay_Payments class to the array accepted payment gateways.
	 *
	 * @param unknown $methods        	
	 */
	public static function addGateway( $methods = array() )
	{
		$methods [] = 'WC_OnlineWorldpay';
		return $methods;
	}

	/**
	 * Display the payment fields.
	 * The client key is output to a hidden input field and jQuery triggers an event
	 * that will start the template form integration.
	 *
	 * {@inheritDoc}
	 *
	 * @see WC_Payment_Gateway::payment_fields()
	 */
	public function payment_fields()
	{
		if ( is_checkout() ) {
			include ONLINEWORLDPAY_PAYMENTS . 'forms/payment-fields.php';
		} else if ( is_add_payment_method_page() ) {
			include ONLINEWORLDPAY_PAYMENTS . 'forms/add-payment-method.php';
		}
	}

	/**
	 * Process the WooCommerce order.
	 *
	 * {@inheritDoc}
	 *
	 * @see WC_Payment_Gateway::process_payment()
	 */
	public function process_payment( $order_id )
	{
		$order = wc_get_order( $order_id );
		
		if ( self::isPaymentChangeRequest() ) {
			return self::prepareSuccessResponse( $order );
		}
		if ( owp_manager()->woocommerceSubscriptionsActive() && wcs_order_contains_subscription( $order ) ) {
			return $this->processSubscriptionOrder( $order );
		} else {
			return $this->processStandardOrder( $order );
		}
	}

	/**
	 * Process the standard WooCommerce order.
	 *
	 * @param WC_Order $order        	
	 */
	public function processStandardOrder( WC_Order $order )
	{
		$attribs = array (
				'token' => owp_manager()->getPaymentMethodToken(), 
				'amount' => $order->get_total() * pow( 10, owp_get_currency_code_exponent( get_woocommerce_currency() ) ), 
				'currencyCode' => get_woocommerce_currency() 
		);
		
		self::addOrderAttributes( $attribs, $order );
		$isAPM = false;
		
		if ( owp_manager()->getRequestParameter( 'onlineworldpay_token_type' ) === 'APM' ) {
			self::addPayPalUrls( $attribs, $order );
			$isAPM = true;
		}
		if ( ! $isAPM && owp_manager()->isActive( 'enable_3ds_secure' ) ) {
			self::add3dsOrderAttributes( $attribs );
		}
		$response = $isAPM == true ? owp_manager()->createApmOrder( $attribs ) : owp_manager()->createOrder( $attribs );
		if ( $response instanceof Exception ) {
			wc_add_notice( sprintf( __( 'There was an error processing your payment. Message: %s', 'onlineworldpay' ), $response->getMessage() ), 'error' );
			$result = self::prepareErrorResponse();
		} else {
			if ( $isAPM ) {
				$result = array (
						'result' => 'success', 
						'redirect' => $response [ 'redirectURL' ] 
				);
			} else {
				if ( owp_manager()->isActive( 'enable_3ds_secure' ) && isset( $response [ 'redirectURL' ] ) ) {
					owp_manager()->maybeSavePaymentMethod( wp_get_current_user()->ID, $response );
					$_SESSION [ 'ONLINEWORLDPAY_3DS_URL' ] = $response [ 'redirectURL' ];
					$_SESSION [ 'ONLINEWORLDPAY_PAREQ' ] = $response [ 'oneTime3DsToken' ];
					$_SESSION [ 'ONLINEWORLDPAY_ORDERCODE' ] = $response [ 'orderCode' ];
					$_SESSION [ 'WOOCOMMERCE_ORDER_ID' ] = owp_get_order_property( 'id', $order );
					owp_manager()->saveWooCommerceOrderMeta( $response, $order );
					$result = array (
							'result' => 'success', 
							'redirect' => get_permalink( owp_manager()->get_option( '3ds_secure_page' ) ) 
					);
				} else {
					owp_manager()->maybeSavePaymentMethod( wp_get_current_user()->ID, $response );
					owp_manager()->saveWooCommerceOrderMeta( $response, $order );
					$order->payment_complete();
					$result = self::prepareSuccessResponse( $order );
				}
			}
		}
		return $result;
	}

	/**
	 * Process the subscription order.
	 *
	 * @param WC_Order $order        	
	 * @return array
	 */
	public function processSubscriptionOrder( WC_Order $order )
	{
		$attribs = array (
				'token' => owp_manager()->getPaymentMethodToken(), 
				'amount' => $order->get_total() * pow( 10, owp_get_currency_code_exponent( get_woocommerce_currency() ) ), 
				'currencyCode' => get_woocommerce_currency() 
		);
		self::addSubscriptionAttributes( $attribs, $order );
		$isAPM = false;
		
		if ( owp_manager()->getRequestParameter( 'onlineworldpay_token_type' ) === 'APM' ) {
			self::addPayPalUrls( $attribs, $order );
			$isAPM = true;
		}
		if ( ! $isAPM && owp_manager()->isActive( 'enable_3ds_secure' ) ) {
			self::add3dsOrderAttributes( $attribs );
		}
		if ( $order->get_total() == 0 ) {
			$result = array (
					'result' => 'success', 
					'redirect' => $order->get_checkout_order_received_url() 
			);
			owp_manager()->maybeSavePaymentMethodForSubscription( wp_get_current_user()->ID, $attribs [ 'token' ] );
			owp_manager()->saveSynchronizedSubscriptionMeta( $order, $attribs );
			$order->payment_complete();
		} else {
			$response = $isAPM == true ? owp_manager()->createApmOrder( $attribs ) : owp_manager()->createOrder( $attribs );
			if ( $response instanceof Exception ) {
				wc_add_notice( sprintf( __( 'There was an error processing your payments. Message: %s', 'onlineworldpay' ), $response->getMessage() ), 'error' );
				$result = self::prepareErrorResponse();
			} else {
				if ( $isAPM ) {
					$result = array (
							'result' => 'success', 
							'redirect' => $response [ 'redirectURL' ] 
					);
				} else {
					if ( owp_manager()->isActive( 'enable_3ds_secure' ) && isset( $response [ 'redirectURL' ] ) ) {
						owp_manager()->maybeSavePaymentMethod( wp_get_current_user()->id, $response );
						$_SESSION [ 'ONLINEWORLDPAY_3DS_URL' ] = $response [ 'redirectURL' ];
						$_SESSION [ 'ONLINEWORLDPAY_PAREQ' ] = $response [ 'oneTime3DsToken' ];
						$_SESSION [ 'ONLINEWORLDPAY_ORDERCODE' ] = $response [ 'orderCode' ];
						$_SESSION [ 'WOOCOMMERCE_ORDER_ID' ] = owp_get_order_property( 'id', $order );
						owp_manager()->saveWooCommerceOrderMeta( $response, $order );
						owp_manager()->saveSubscriptionMeta( $response, $order );
						$result = array (
								'result' => 'success', 
								'redirect' => get_permalink( owp_manager()->get_option( '3ds_secure_page' ) ) 
						);
					} else {
						owp_manager()->savePaymentMethod( wp_get_current_user()->ID, $response );
						owp_manager()->saveWooCommerceOrderMeta( $response, $order );
						owp_manager()->saveSubscriptionMeta( $response, $order );
						$order->payment_complete();
						$result = self::prepareSuccessResponse( $order );
					}
				}
			}
		}
		return $result;
	}

	/**
	 * Add the payment method for the customer.
	 * This method is called by the WooCommerce add-payment-method.php page.
	 */
	public function add_payment_method()
	{
		$token = owp_manager()->getRequestParameter( 'onlineworldpay_payment_method_token' );
		$payment_method = owp_manager()->getPaymentMethod( $token );
		owp_manager()->add_payment_method( wp_get_current_user()->ID, $token, $payment_method );
		wc_add_notice( __( 'Your payment method has been saved', 'onlineworldpay' ), 'success' );
		return array (
				'result' => 'success', 
				'redirect' => wc_get_endpoint_url( 'payment-methods' ) 
		);
	}

	/**
	 * Method that adds all of the required fields needed to process a Online Worldpay Order.
	 *
	 * @param array $attribs        	
	 * @param WC_Order $order        	
	 */
	public static function addOrderAttributes( &$attribs, WC_Order $order )
	{
		self::addCustomerName( $attribs, $order );
		self::addBillingAddress( $attribs, $order );
		self::addShippingAddress( $attribs, $order );
		self::addOrderIdentifiers( $attribs, $order );
		self::addOrderDescription( $attribs, $order );
		self::addSettlementCurrency( $attribs );
		self::addShopperEmailAddress( $attribs, $order );
	}

	public static function addSubscriptionAttributes( &$attribs, WC_Order $order )
	{
		self::addCustomerName( $attribs, $order );
		self::addBillingAddress( $attribs, $order );
		self::addShippingAddress( $attribs, $order );
		self::addSubscriptionIdentifiers( $attribs, $order );
		self::addSubscriptionDescription( $attribs, $order );
		self::addSettlementCurrency( $attribs );
		self::addShopperEmailAddress( $attribs, $order );
	}

	/**
	 * Add the customer name to the order.
	 *
	 * @param array $attribs        	
	 * @param WC_Order $order        	
	 */
	public static function addCustomerName( &$attribs, WC_Order $order )
	{
		$attribs [ 'name' ] = owp_get_order_property( 'billing_first_name', $order ) . ' ' . owp_get_order_property( 'billing_last_name', $order );
	}

	/**
	 * Method that adds the order billing information to the attribs array.
	 *
	 * @param array $attribs        	
	 * @param WC_Order $order        	
	 */
	public static function addBillingAddress( &$attribs, WC_Order $order )
	{
		$attribs [ 'billingAddress' ] = array (
				'address1' => owp_get_order_property( 'billing_address_1', $order ), 
				'address2' => owp_get_order_property( 'billing_address_2', $order ), 
				'postalCode' => owp_get_order_property( 'billing_postcode', $order ), 
				'city' => owp_get_order_property( 'billing_city', $order ), 
				'state' => owp_get_order_property( 'billing_state', $order ), 
				'countryCode' => owp_get_order_property( 'billing_country', $order ) 
		);
	}

	/**
	 * Method that adds the order shipping information to the attribs array.
	 *
	 * @param array $attribs        	
	 * @param WC_Order $order        	
	 */
	public static function addShippingAddress( &$attribs, WC_Order $order )
	{
		$attribs [ 'deliveryAddress' ] = array (
				'address1' => owp_get_order_property( 'shipping_address_1', $order ), 
				'address2' => owp_get_order_property( 'shipping_address_2', $order ), 
				'postalCode' => owp_get_order_property( 'shipping_postcode', $order ), 
				'city' => owp_get_order_property( 'shipping_city', $order ), 
				'state' => owp_get_order_property( 'shipping_state', $order ), 
				'countryCode' => owp_get_order_property( 'shipping_country', $order ) 
		);
	}

	/**
	 * Add the order identifiers such as prefix and suffix.
	 *
	 * @param unknown $attribs        	
	 * @param WC_Order $order        	
	 */
	public static function addOrderIdentifiers( &$attribs, WC_Order $order )
	{
		$prefix = owp_manager()->get_option( 'order_prefix' );
		$suffix = owp_manager()->get_option( 'order_suffix' );
		if ( ! empty( $prefix ) ) {
			$attribs [ 'orderCodePrefix' ] = $prefix;
		}
		if ( ! empty( $suffix ) ) {
			$attribs [ 'orderCodeSuffix' ] = $suffix;
		}
		$attribs [ 'customerOrderCode' ] = owp_get_order_property( 'id', $order );
	}

	/**
	 * Add the order description to the attribs array.
	 *
	 * @param array $attribs        	
	 * @param WC_Order $order        	
	 */
	public static function addOrderDescription( &$attribs, WC_Order $order )
	{
		$description = owp_manager()->get_option( 'order_description' );
		
		if ( ! empty( $description ) ) {
			$attribs [ 'orderDescription' ] = $description;
		} else {
			$attribs [ 'orderDescription' ] = owp_get_order_property( 'id', $order );
		}
	}

	public static function addSettlementCurrency( &$attribs )
	{
		$attribs [ 'settlementCurrency' ] = owp_manager()->get_option( 'settlement_cuurrency' );
	}

	public static function addShopperEmailAddress( &$attribs, WC_Order $order )
	{
		$attribs [ 'shopperEmailAddress' ] = owp_get_order_property( 'billing_email', $order );
	}

	public static function addSubscriptionIdentifiers( &$attribs, WC_Order $order )
	{
		$prefix = owp_manager()->get_option( 'subscription_prefix' );
		$suffix = owp_manager()->get_option( 'subscription_suffix' );
		if ( ! empty( $prefix ) ) {
			$attribs [ 'orderCodePrefix' ] = $prefix;
		}
		if ( ! empty( $suffix ) ) {
			$attribs [ 'orderCodeSuffix' ] = $suffix;
		}
		$attribs [ 'customerOrderCode' ] = owp_get_order_property( 'id', $order );
	}

	public static function addSubscriptionDescription( &$attribs, WC_Order $order )
	{
		$description = owp_manager()->get_option( 'subscription_description' );
		
		if ( ! empty( $description ) ) {
			$attribs [ 'orderDescription' ] = $description;
		} else {
			$attribs [ 'orderDescription' ] = owp_get_order_property( 'id', $order );
		}
	}

	/**
	 * Create the PayPal result urls.
	 *
	 * @param array $attribs        	
	 * @param WC_Order $order        	
	 */
	public static function addPayPalUrls( &$attribs, WC_Order $order )
	{
		$results = array (
				'success', 
				'pending', 
				'failure', 
				'cancel' 
		);
		foreach ( $results as $result ) {
			$attribs [ $result . 'Url' ] = add_query_arg( array (
					'order-type' => 'apm_order', 
					'apm-result' => $result, 
					'order' => owp_get_order_property( 'id', $order ) 
			), get_site_url() );
		}
		return $attribs;
	}

	/**
	 * Set is3DSOrder to true.
	 *
	 * @param array $attribs        	
	 */
	public static function add3dsOrderAttributes( &$attribs )
	{
		$attribs [ 'is3DSOrder' ] = true;
		if ( owp_manager()->getEnvironment() === 'sandbox' ) {
			$attribs [ 'name' ] = '3D';
		}
	}

	/**
	 * Returns an array containing the failure result.
	 *
	 * @return array
	 */
	public static function prepareErrorResponse()
	{
		return array (
				'result' => 'failure', 
				'redirect' => '' 
		);
	}

	/**
	 * Returns an array containing the success result.
	 *
	 * @param WC_Order $order        	
	 */
	public static function prepareSuccessResponse( WC_Order $order )
	{
		return array (
				'result' => 'success', 
				'redirect' => $order->get_checkout_order_received_url() 
		);
	}

	public static function enqueueScripts()
	{
		if ( owp_manager()->isActive( 'enabled' ) ) {
			wp_enqueue_script( 'online-worldpay-js', 'https://cdn.worldpay.com/v1/worldpay.js', array (
					'jquery' 
			), owp_manager()->version, true );
			wp_enqueue_style( 'online-worldpay-checkoout-css', ONLINEWORLDPAY_ASSETS . 'css/checkout.css', null, owp_manager()->version );
			if ( is_checkout() ) {
				wp_enqueue_script( 'online-worldpay-checkout-js', ONLINEWORLDPAY_ASSETS . 'js/checkout-script.js', array (
						'jquery' 
				), owp_manager()->version, true );
				wp_localize_script( 'online-worldpay-checkout-js', 'onlineworldpay_checkout_vars', self::getCheckoutVars() );
			}
			if ( is_add_payment_method_page() ) {
				wp_enqueue_script( 'online-worldpay-add-payment-method-js', ONLINEWORLDPAY_ASSETS . 'js/add-payment-method.js', array (
						'jquery' 
				), owp_manager()->version, true );
				wp_localize_script( 'online-worldpay-add-payment-method-js', 'onlineworldpay_add_payment_vars', self::get_add_payment_vars() );
			}
		}
	}

	/**
	 * Get the accepted payment method icons.
	 */
	public static function getPaymentMethodIcons()
	{
		$methods = owp_manager()->get_option( 'payment_methods' );
		echo '<div class="onlineworldpay-accepted-methods">';
		if ( ! empty( $methods ) ) {
			foreach ( $methods as $type => $method ) {
				if ( ! empty( $method ) ) {
					$accepted_methods = owp_get_payment_methods();
					$accepted_method = $accepted_methods [ $type ];
					echo '<span><img src="' . $accepted_method [ 'src' ] . '"/></span>';
				}
			}
		}
		echo '</div>';
	}

	/**
	 * Return the html for saving a payment method.
	 */
	public static function getSavePaymentMethodCheckBox()
	{
		include ONLINEWORLDPAY_PAYMENTS . 'forms/save-payment-method.php';
	}

	/**
	 * output html for customer's saved payment methods.
	 *
	 * @param int $user_id        	
	 */
	public static function getCustomerPaymentMethods( $user_id )
	{
		if ( owp_manager()->customerHasPaymentMethods( $user_id ) ) {
			$methods = owp_manager()->getCustomerPaymentMethods( $user_id );
			echo '<div id="onlineworldpay_saved_methods" class="onlineworldpay-saved-methods">';
			echo '<div class="payment-method-button"><span id="onlineworldpay_add_new">' . __( 'Add New', 'onlineworldpay' ) . '</span></div>';
			foreach ( $methods as $index => $method ) {
				echo '<div class="payment-method-item card-label ' . self::isCardDefault( $method [ 'default' ] ) . '" token="' . $method [ 'token' ] . '"><span class="payment-method-type ' . $method [ 'cardType' ] . '"></span><span class="payment-method-description">' . $method [ 'cardType' ] . ' ' . $method [ 'maskedNumber' ] . '</span></div>';
			}
			echo '<div class="onlineworldpay-cvc-description"></div>';
			echo '<div id="onlineworldpay_cvc_container"></div>';
		}
	}

	public static function isCardDefault( $default )
	{
		if ( $default === 'true' ) {
			return 'selected';
		}
	}

	/**
	 * Return an array of values to be used as javascript variables in the checkout script.
	 *
	 * @return array
	 */
	public static function getCheckoutVars()
	{
		$vars = array (
				'clientKey' => owp_manager()->getClientKey(), 
				'cardTemplateCode' => owp_manager()->getCardTemplateCode(), 
				'cvcTemplateCode' => owp_manager()->getCVCTemplateCode(), 
				'paypalEnabled' => owp_manager()->get_option( 'enable_paypal' ) === 'yes' ? 'true' : 'false' 
		);
		if ( owp_manager()->woocommerceSubscriptionsActive() ) {
			if ( WC_Subscriptions_Cart::cart_contains_subscription() || self::isPaymentChangeRequest() ) {
				$vars [ 'cartContainsSubscription' ] = 'true';
			} else {
				$vars [ 'cartContainsSubscription' ] = 'false';
			}
		} else {
			$vars [ 'cartContainsSubscription' ] = 'false';
		}
		return $vars;
	}

	public static function get_add_payment_vars()
	{
		$vars = array (
				'clientKey' => owp_manager()->getClientKey(), 
				'cardTemplateCode' => owp_manager()->getCardTemplateCode(), 
				'cvcTemplateCode' => owp_manager()->getCVCTemplateCode() 
		);
		return $vars;
	}

	public function getSupportedFeatures()
	{
		$supports = array (
				'products', 
				'refunds', 
				'add_payment_method' 
		);
		
		if ( owp_manager()->isActive( 'woocommerce_subscriptions' ) ) {
			$supports = array_merge( $supports, array (
					'subscriptions', 
					'subscription_cancellation', 
					'multiple_subscriptions', 
					'subscription_amount_changes', 
					'subscription_date_changes', 
					'default_credit_card_form', 
					// 'gateway_scheduled_payments',
					'subscription_reactivation', 
					'subscription_suspension', 
					'pre-orders', 
					'subscription_payment_method_change_admin', 
					'subscription_payment_method_change_customer' 
			) );
		}
		
		return $supports;
	}

	/**
	 * Return true of the requests is for a payment change.
	 */
	public static function isPaymentChangeRequest()
	{
		return ( isset( $_REQUEST [ 'woocommerce_change_payment' ] ) || isset( $_REQUEST [ 'change_payment_method' ] ) );
	}

	/**
	 * Process the refund for the order.
	 *
	 * {@inheritDoc}
	 *
	 * @see WC_Payment_Gateway::process_refund()
	 */
	public function process_refund( $order_id, $amount = null, $reason = '' )
	{
		$order = wc_get_order( $order_id );
		if ( ! $this->canRefund( $order ) ) {
			owp_manager()->log->writeErrorToLog( sprintf( 'Order %s cannot be refunded as there is not transaction Id 
					associated with the order.', $order_id ) );
			return new WP_Error( 'transaction', sprintf( __( 'Order %s cannot be refunded because there is no transaction id associated with the order.', 'onlineworldpay' ), $order_id ) );
		}
		$amount = $amount * pow( 10, owp_get_currency_code_exponent( owp_get_order_property( 'order_currency', $order ) ) );
		$response = owp_manager()->refundOrder( $order, $amount );
		return $response;
	}

	/**
	 * Check if the order has a transaction id.
	 *
	 * @param WC_Order $order        	
	 */
	public function canRefund( WC_Order $order )
	{
		$transaction_id = $order->get_transaction_id();
		return ! empty( $transaction_id );
	}

	/**
	 * Return the html for the PayPal Button if enabled.
	 * PayPal is not available during a payment method change.
	 */
	public static function getPayPalButton()
	{
		if ( owp_manager()->isActive( 'enable_paypal' ) ) {
			if ( ! self::isPaymentChangeRequest() ) {
				if ( owp_manager()->woocommerceSubscriptionsActive() && WC_Subscriptions_Cart::cart_contains_subscription() ) {
					return;
				}
				$button = owp_get_paypal_button( owp_manager()->get_option( 'paypal_button' ) );
				echo '<div class="onlineworldpay-paypal"><span><input id="paypal_button" type="' . $button [ 'type' ] . '" style="' . $button [ 'style' ] . '" src="' . $button [ 'src' ] . '"/></span></div>';
				echo '<input id="apm-name" type="hidden" data-worldpay="apm-name" value="paypal">';
				echo '<input type="hidden" id="country-code" name="countryCode" data-worldpay="country-code" value="" />';
			}
		}
	}

	/**
	 * Update the WooCommerce checkout fields with necessary data.
	 *
	 * @param unknown $fields        	
	 */
	public static function updateCheckoutFields( $fields )
	{
		$fields [ 'billing' ] [ 'billing_country' ] [ 'custom_attributes' ] [ 'data-worldpay' ] = 'billing_country';
		
		return $fields;
	}

	/**
	 * Looks for a URI pattern match.
	 * If so, then the request came from Online Worldpay for an APM order.
	 */
	public static function handleApmOrderResponse()
	{
		$uri = $_SERVER [ 'REQUEST_URI' ];
		if ( isset( $_REQUEST [ 'order-type' ] ) && $_REQUEST [ 'order-type' ] === 'apm_order' ) {
			$type = 'apm_order';
			$result = $_REQUEST [ 'apm-result' ];
			$order_id = $_REQUEST [ 'order' ];
			$order = wc_get_order( $order_id );
			$orderCode = $_REQUEST [ 'orderCode' ];
			
			owp_manager()->log->writeToLog( sprintf( 'APM order url has been called. URI: %s. Type: %s. Order ID: %s. Order Code: %s.', $uri, $type, $order_id, $orderCode ) );
			
			$result = apply_filters( 'onlineworldpay_apm_handle_' . $result, $order, $orderCode );
			
			wp_redirect( $result [ 'redirect' ] );
			exit();
		}
	}

	/**
	 *
	 * @param WC_Order $order        	
	 * @param string $orderCode        	
	 */
	public static function handleApmOrderSuccess( $order, $orderCode )
	{
		update_post_meta( owp_get_order_property( 'id', $order ), '_transaction_id', $orderCode );
		$response = owp_manager()->getOrderDetails( $orderCode );
		if ( $response instanceof Exception ) {
			wc_add_notice( __( 'Your order has been processed. However some data was not saved correctly. Please contact support.', 'onlineworldpay' ), 'error' );
			$result = self::prepareSuccessResponse( $order );
		} else {
			owp_manager()->saveWooCommerceOrderMeta( $response, $order );
			if ( owp_manager()->woocommerceSubscriptionsActive() && wcs_order_contains_subscription( $order ) ) {
				owp_manager()->saveSubscriptionMeta( $response, $order );
			}
			$order->payment_complete();
			WC()->cart->empty_cart();
			$result = self::prepareSuccessResponse( $order );
		}
		return $result;
	}

	/**
	 *
	 * @param WC_Order $order        	
	 */
	public static function handleApmOrderCancel( $order )
	{
		wc_add_notice( __( 'Your PayPal payment has been cancelled.', 'onlineworldpay' ), 'success' );
		return array (
				'result' => 'success', 
				'redirect' => wc_get_checkout_url() 
		);
	}

	/**
	 *
	 * @param WC_Order $order        	
	 */
	public static function handleApmOrderPending( $order )
	{
		update_post_meta( owp_get_order_property( 'id', $order ), '_transaction_id', $orderCode );
		$response = owp_manager()->getOrderDetails( $orderCode );
		if ( $response instanceof Exception ) {
			wc_add_notice( __( 'Your order has been processed. However some data was not saved correctly. Please contact support.', 'onlineworldpay' ), 'error' );
			$result = self::prepareSuccessResponse( $order );
		} else {
			owp_manager()->saveWooCommerceOrderMeta( $response, $order );
			$order->payment_complete();
			WC()->cart->empty_cart();
			$result = self::prepareSuccessResponse( $order );
		}
		return $result;
	}

	/**
	 *
	 * @param WC_Order $order        	
	 */
	public static function handleApmOrderFailure( $order )
	{
		wc_add_notice( __( 'There has been an authentication error with your PayPal account.', 'onlineworldpay' ), 'error' );
		return array (
				'success' => 'failure', 
				'redirect' => wc_get_checkout_url() 
		);
	}

	/**
	 * Populate an array of payment methods to be used by the payment-methods.php page.
	 *
	 * @param unknown $methods        	
	 */
	public static function populateMethodsArray( $saved_methods )
	{
		$payment_methods = owp_manager()->getCustomerPaymentMethods( wp_get_current_user()->ID );
		if ( ! empty( $payment_methods ) ) {
			$saved_methods [ self::GATEWAY_NAME ] = array ();
			foreach ( $payment_methods as $method ) {
				$payment_method = owp_manager()->getPaymentMethod( $method [ 'token' ] );
				if ( $payment_method ) {
					preg_match( '/[\d]{4}/', $payment_method [ 'maskedCardNumber' ], $matches );
					$wc_method = array (
							'method' => array (
									'brand' => $payment_method [ 'cardType' ], 
									'last4' => $matches [ 0 ] 
							) 
					);
					$wc_method [ 'expires' ] = $payment_method [ 'expiryMonth' ] . '/' . $payment_method [ 'expiryYear' ];
					$wc_method [ 'actions' ] = array (
							'delete' => array (
									'url' => wp_nonce_url( add_query_arg( array (
											'online-worldpay-delete' => $method [ 'token' ] 
									), get_site_url() ), 'owp-delete-method', 'owp-delete-method-nonce' ), 
									'name' => __( 'Delete', 'onlineworldpay' ) 
							) 
					);
					$saved_methods [ self::GATEWAY_NAME ] [] = $wc_method;
				}
			}
		}
		return $saved_methods;
	}

	/**
	 * Tied to the init method.
	 * Deletes the given payment method.
	 */
	public static function delete_payment_method()
	{
		$uri = $_SERVER [ 'REQUEST_URI' ];
		if ( isset( $_GET [ 'owp-delete-method-nonce' ] ) && wp_verify_nonce( $_GET [ 'owp-delete-method-nonce' ], 'owp-delete-method' ) ) {
			$token = isset( $_GET [ 'online-worldpay-delete' ] ) ? $_GET [ 'online-worldpay-delete' ] : '';
			owp_manager()->deletePaymentMethod( $token );
			$payment_methods = owp_manager()->getCustomerPaymentMethods( wp_get_current_user()->ID );
			unset( $payment_methods [ $token ] );
			update_user_meta( wp_get_current_user()->ID, 'onlineworldpay_' . owp_manager()->getEnvironment() . '_paymentmethods', $payment_methods );
			wc_add_notice( __( 'Your payment method has been deleted.', 'onlineworldpay' ) );
			wp_redirect( wc_get_endpoint_url( 'payment-methods', '', wc_get_page_permalink( 'myaccount' ) ) );
			exit();
		}
	}

	/**
	 * Output the 3DS form that is used to post data to the payment method 3DS secure url.
	 */
	public static function output_3ds_page()
	{
		$_3dsUrl = $_SESSION [ 'ONLINEWORLDPAY_3DS_URL' ];
		$_termUrl = add_query_arg( array (
				'online-worldpay-3ds-order' => $_SESSION [ 'WOOCOMMERCE_ORDER_ID' ], 
				'3ds-checkout-nonce' => wp_create_nonce( '3ds-checkout-nonce' ) 
		), trailingslashit( get_site_url() ) . 'index.php' );
		$_paReq = $_SESSION [ 'ONLINEWORLDPAY_PAREQ' ];
		include ONLINEWORLDPAY_PAYMENTS . 'forms/3ds-form.php';
	}

	public static function handle3dsOrderReturn()
	{
		if ( isset( $_GET [ '3ds-checkout-nonce' ] ) && wp_verify_nonce( $_GET [ '3ds-checkout-nonce' ], '3ds-checkout-nonce' ) ) {
			$order_id = $_GET [ 'online-worldpay-3ds-order' ];
			$paRes = $_POST [ 'PaRes' ];
			$orderCode = $_SESSION [ 'ONLINEWORLDPAY_ORDERCODE' ];
			$order = wc_get_order( $order_id );
			$response = owp_manager()->create3dsOrder( $orderCode, $paRes );
			if ( $response instanceof WorldpayException ) {
				wc_add_notice( sprintf( __( 'There was an error authorizing your 3DS payment. Reason: %s.', 'onlineworldpay' ), $response->getMessage() ), 'error' );
				wp_redirect( wc_get_checkout_url() );
				exit();
			} else {
				$order->payment_complete();
				wp_redirect( $order->get_checkout_order_received_url() );
				exit();
			}
		}
	}

	public static function update_order_review_fragments( $fragments )
	{
		unset( $fragments [ '.woocommerce-checkout-payment' ] );
		return $fragments;
	}

	public function admin_options()
	{
		include ONLINEWORLDPAY_ADMIN . 'forms/admin-options.php';
	}
}
add_filter( 'woocommerce_payment_gateways', 'WC_OnlineWorldpay::addGateway' );
WC_OnlineWorldpay::init();