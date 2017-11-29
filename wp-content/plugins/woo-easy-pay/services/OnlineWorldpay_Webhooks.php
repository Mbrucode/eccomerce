<?php
/**
 * Webhooks class that receives all messages sent from Worldpay.
 * @author Clayton Rogers
 * @since 1.1.6
 *
 */
class OnlineWorldpay_Webhooks{
	
	
	private static $pattern = '/\/?online~worldpay\/webhooks\/orders\/([\w]{32})/';
	/**
	 * Add webhooks methods to actions.
	 */
	public static function init(){
		
		add_action( 'init', __CLASS__.'::handleWebhookRequest' );
		
		add_action( 'onlineworldpay_webhooks_process', __CLASS__.'::processWebhook' );
		
	}
	
	/**
	 * Process the webhook data sent by Worldpay.
	 */
	public static function handleWebhookRequest(){
		if( preg_match( self::$pattern, $_SERVER['REQUEST_URI'], $matches ) ){
			if( !owp_manager()->isActive( 'webhooks_enable' ) ){
				owp_manager()->log->writeToLog( sprintf('Webhook message received but webhooks are not enabled on your site so the server did not accept the message.
						You must enable webhooks on the <a target="_blank" href="' . admin_url() . 'admin.php?page=onlineworldpay-webhooks-page">Webhooks Settings</a> page of the plugin.'));
				http_response_code( 400 );
				exit();
			}
			$key = $matches[1];
			if( !self::validateKey( $key ) ){
				owp_manager()->log->writeToLog( sprintf( 'API Key %s is not valid. Please check your webhooks url and ensure 
						it matches the value configured in your plugin settings.', $key ) );
				http_response_code(401);
				exit();
			}
			$body = file_get_contents( 'php://input' );
			$body = trim( $body );
			
			owp_manager()->log->writeToLog( sprintf( 'Webhook: OnineWorlday POST Body = %s', $body ) );
			
			$message = json_decode( $body, true );
			
			do_action( 'onlineworldpay_webhooks_process', $message );
			
			http_response_code( 200 );
			exit();
		}
	}
	
	/**
	 * Process the webhook message.
	 * @param array $message
	 */
	public static function processWebhook( $message ){
		$option = 'webhooks_' . strtolower( $message['paymentStatus'] );
		if( owp_manager()->isActive( $option ) ) {
			
			$order = self::getOrderFromMessage( $message );
			if( !$order ){
				owp_manager()->log->writeToLog( sprintf( 'Webhook: The message did not contain a valid order code. Order Code: %s', $message['orderCode'] ) );
			}
			else{
				$order->add_order_note( sprintf(__( 'The status of order %s has been updated. Status: %s.', 'onlineworldpay'), $order->id, $message['paymentStatus'] ) );
				owp_manager()->log->writeToLog( sprintf( 'The status of order %s has been updated. Status: %s. Environment: %s', $order->id, $message['paymentStatus'], $message['environment'] ) );
				self::maybeSendEmail( $message, $order );
			}
		}
		else{
			owp_manager()->log->writeToLog( sprintf( 'In order to receive webhooks for Order Status Change Event %s you must 
					enable them in the <a target="_blank" href="%s">Webhooks Settings</a> page of the plugin.', $message['paymentStatus'], admin_url() . 'admin.php?page=onlineworldpay-webhooks-page' ) );
		}
	}
	
	/**
	 * If configured, send the email related to the webhook.
	 * @param unknown $message
	 */
	public static function maybeSendEmail( $message, WC_Order $order ){
		if( owp_manager()->isActive( 'webhooks_' . strtolower( $message['paymentStatus'] ) . '_email_admin' ) ){
			$email = self::getEmailContents( $message, $order );
			wp_mail( $email['to'], $email['subject'], $email['message'] );
		}
	}
	
	/**
	 * Return the WC_Order using the $message['orderCode'].
	 * @param array $message
	 * @return WC_Order $order|null
	 */
	private static function getOrderFromMessage( $message ){
		global $wpdb;
		$order = null;
		$query = $wpdb->prepare( "SELECT post_id FROM {$wpdb->prefix}postmeta WHERE meta_key = %s AND meta_value = %s", '_transaction_id', $message['orderCode'] );
		$result = $wpdb->get_results( $query, OBJECT );
		if( $result ){
			$order = wc_get_order( $result[0]->post_id );
		}
		return $order;
	}
	
	private static function validateKey( $key ){
		$saved_key = get_option( 'onlineworldpay_webhooks_key' );
		$result = false;
		if( $key === $saved_key ){
			$result = true;
		}
		return $result;
	}
	
	/**
	 * 
	 * @param array $message
	 */
	public static function getEmailContents( $message, WC_Order $order ){
		$contents = array(
				'to'=>get_option( 'admin_email' ),
				'subject'=>sprintf( 'Order %s Update', $order->id ),
				'message'=>self::getEmailMessage( $message, $order )
		);
		return $contents;
	}
	
	public static function getEmailMessage( $message, WC_Order $order ){
		$message = sprintf(__( 'There has been a status update for order %s within Worldpay. Status: %s', 'onlineworldpay'), $order->id, $message['paymentStatus'] );
		return $message;
	}
}
OnlineWorldpay_Webhooks::init();