<?php
/**
 * Subscriptions class used to process subscription payments.
 * @author Clayton Rogers
 *
 */
class WC_OnlineWorldpay_Subscriptions extends WC_OnlineWorldpay
{

	public static function init()
	{
		
		/* Display payment method on account page. */
		add_filter( 'woocommerce_my_subscriptions_payment_method', __CLASS__ . '::displayPaymentMethod', 10, 2 );
		
		/* Cancel the subscription. */
		add_action( 'woocommerce_subscription_cancelled_' . self::GATEWAY_NAME, __CLASS__ . '::cancelSubscription', 10, 1 );
		
		/* Payment method change. */
		add_action( 'woocommerce_subscription_payment_method_updated_to_' . self::GATEWAY_NAME, __CLASS__ . '::updatePaymentMethod', 10, 2 );
		
		/* Recurring payment charge. */
		add_action( 'woocommerce_scheduled_subscription_payment_' . self::GATEWAY_NAME, __CLASS__ . '::processRecurringPayment', 10, 2 );
	}

	public static function displayPaymentMethod( $payment_method_to_display, WC_Subscription $subscription )
	{
		$payment_method = get_post_meta( $subscription->id, '_payment_method_title', true );
		if ( ! empty( $payment_method ) ) {
			$payment_method_to_display = $payment_method;
		}
		return $payment_method_to_display;
	}

	public static function cancelSubscription( WC_Subscription $subscription )
	{
		if ( self::isPaymentChangeRequest() ) {
			return;
		} else {
			try {
				$subscription->update_status( owp_manager()->get_option( 'subscriptions_cancelled_status' ) );
				owp_manager()->log->writeToLog( sprintf( 'Subscription %s has been cancelled and set to status %s', $subscription->id, owp_manager()->get_option( 'subscriptions_cancelled_status' ) ) );
			} catch( Exception $e ) {
				owp_manager()->log->writeToLog( sprintf( 'There was an exception thrown while updating the status of subscription %s. Messages: %s', $subscription->id, $e->getMessage() ) );
			}
		}
	}

	/**
	 * Update the payment method of the subscription.
	 *
	 * @param WC_Subscription $subscription        	
	 * @param unknown $old_payment_method        	
	 */
	public static function updatePaymentMethod( WC_Subscription $subscription, $old_payment_method )
	{
		$token = owp_manager()->getPaymentMethodToken();
		$cardDetails = owp_manager()->getPaymentMethod( $token );
		if ( $cardDetails ) {
			$response [ 'token' ] = $token;
			$response [ 'paymentResponse' ] = $cardDetails;
			update_post_meta( $subscription->id, '_payment_method_title', owp_manager()->getPaymentMethodTitle( $cardDetails ) );
			update_post_meta( $subscription->id, '_payment_method_token', $token );
			update_post_meta( $subscription->id, '_payment_method_type', $cardDetails [ 'type' ] );
			owp_manager()->savePaymentMethod( wp_get_current_user()->ID, $response );
			owp_manager()->log->writeToLog( sprintf( 'Payment method %s was succesffully added to subscription %s.', 'onlineworldpay' ), $response [ 'token' ], $subscription->id );
		} else {
			wc_add_notice( __( 'The payment method could not be found. Please try again. If the issue continues please contact support.', 'onlineworldpay' ), 'error' );
			owp_manager()->log->writeToLog( sprintf( 'There was an error while updating the payment method for subscription %s.', $subscription->id ) );
		}
	}

	/**
	 * Process the subscription order.
	 *
	 * @param int $amount        	
	 * @param WC_Order $order        	
	 */
	public static function processRecurringPayment( $amount, $order )
	{
		$subscription = wcs_get_subscription( owp_get_order_property( 'subscription_renewal', $order ) );
		$attribs = array (
				'token' => $subscription != null ? get_post_meta( owp_get_order_property( 'id', $subscription ), '_payment_method_token', true ) : get_post_meta( owp_get_order_property( 'id', $order ), '_payment_method_token', true ), 
				'amount' => $amount * pow( 10, owp_get_currency_code_exponent( owp_get_order_property( 'order_currency', $order ) ) ), 
				'currencyCode' => owp_get_order_property( 'order_currency', $order ) 
		);
		
		self::addSubscriptionAttributes( $attribs, $order );
		$attribs [ 'orderType' ] = 'RECURRING';
		
		if ( self::isSubscriptionApm( $order ) ) {
			$attribs [ 'customerIdentifiers' ] = array (
					'originalOrderCode' => $order->get_transaction_id() 
			);
		}
		
		$response = owp_manager()->createOrder( $attribs );
		
		if ( $response instanceof Exception ) {
			owp_manager()->log->writeToLog( sprintf( 'There was an error while processing the payment for subscription %s. Message: %s', 'onlineworldpay' ), owp_get_order_property( 'id', $order ), $response->getMessage() );
			$order->add_order_note( sprintf( __( 'There was an error while processing the subscription payment for order %s. Message: %s', 'onlineworldpay' ), owp_get_order_property( 'id', $order ), $response->getMessage() ) );
			$order->update_status( 'failed' );
		} else {
			owp_manager()->log->writeToLog( sprintf( 'The subscription payment for order %s was charged succesfully in the amount of %s %s. Transaction ID: %s.', owp_get_order_property( 'id', $order ), owp_get_currency_symbol( owp_get_order_property( 'order_currency', $order ) ), $amount, $response [ 'orderCode' ] ) );
			$order->add_order_note( sprintf( __( 'The payment for subscription %s was charged succesfully in the amount of %s%s. Transaction ID: %s.', 'onlineworldpay' ), owp_get_order_property( 'id', $order ), owp_get_currency_symbol( owp_get_order_property( 'order_currency', $order ) ), $amount, $response [ 'orderCode' ] ) );
			update_post_meta( owp_get_order_property( 'id', $order ), '_transaction_id', $response [ 'orderCode' ] );
			owp_manager()->saveWooCommerceOrderMeta( $response, $order );
			$order->payment_complete();
		}
	}

	public static function isSubscriptionApm( WC_Order $order )
	{
		return get_post_meta( owp_get_order_property( 'id', $order ), '_payment_method_type', true ) === 'APM';
	}
}
WC_OnlineWorldpay_Subscriptions::init();