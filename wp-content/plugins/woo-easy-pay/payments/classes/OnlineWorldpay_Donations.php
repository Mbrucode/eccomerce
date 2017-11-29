<?php
/**
 * Donation class
 * @author Clayton Rogers
 *
 */
class OnlineWorldpay_Donations {

	public static $modal;

	public static function init(){

		add_action( 'wp_ajax_onlineworldpay_process_donation', __CLASS__.'::processDonation' );

		add_action( 'wp_ajax_nopriv_onlineworldpay_process_donation', __CLASS__.'::processDonation');

		add_shortcode( 'onlineworldpay_donations', __CLASS__.'::displayDonationForm' );

		/*Added for compatability with version 1.1.4 and lower.*/
		add_shortcode( 'worldpay_donations', __CLASS__.'::displayDonationForm' );

		add_action( 'onlineworldpay_donations_action', __CLASS__.'::enqueueScripts' );

		add_action( 'init', __CLASS__.'::handleApmDonationResponse' );

		add_filter( 'onlineworldpay_apm_donation_response', __CLASS__.'::redirectAfterApmReceived' );

		self::$modal = owp_manager()->get_option( 'donation_form_layout' ) === 'modal' ? true : false;

	}

	/**
	 * Process the donation payment.
	 */
	public static function processDonation(){
		$attribs = array(
				'token'=>owp_manager()->getRequestParameter( 'onlineworldpay_payment_method_token' ),
				'amount'=>owp_manager()->getRequestParameter( 'donation_amount' ) * pow( 10, owp_get_currency_code_exponent( owp_manager()->get_option( 'donation_currency')) ),
				'currencyCode'=>owp_manager()->get_option( 'donation_currency' ),
				'customerOrderCode'=>'donation_' . rand()

		);

		self::addOrderDescription( $attribs );
		$isAPM = false;
		if( owp_manager()->getRequestParameter( 'onlineworldpay_token_type' ) === 'APM' ){
			$isAPM = true;
			self::addApmUrls( $attribs );
		}

		if( owp_manager()->isActive( 'donation_address' ) ){
			self::addBillingAddress( $attribs );
		}
		if( owp_manager()->isActive( 'donation_name' ) ){
			self::addDonorName( $attribs );
		}
		if( owp_manager()->isActive( 'donation_email' ) ){
			self::addEmailAddress( $attribs );
		}

		$response = $isAPM ? owp_manager()->createApmOrder( $attribs ) : owp_manager()->createOrder( $attribs );
		$result = array();
		if( $response instanceof Exception ){
			$result['result'] = 'failure';
			$result['message'] = sprintf(__('There was an error processing your payment. Reason: %s', 'onlineworldpay'), $response->getMessage() );
		}
		else{
			if( $isAPM ){
				$result['result'] = 'success';
				$result['url'] = $response['redirectURL'];
			}
			else{
				$result['result'] = 'success';
				$result['url'] = owp_manager()->get_option( 'donation_success_url' );
			}
		}
		wp_send_json( $result );
	}

	/**
	 * Display the OnlineWorldpay donation container.
	 * @param unknown $attribs
	 */
	public static function displayDonationForm( $attribs ){

		do_action( 'onlineworldpay_donations_action' );

		ob_start();
		if( self::$modal ){
			self::displayModalForm( $attribs );
		}
		else{
			self::displayInlineForm( $attribs );
		}
		return ob_get_clean();
	}

	public static function displayModalForm( $attribs = null ){

		self::getModalDonationButton();

		echo '<div id="modal_button"class=""></div>';
		echo '<div class="onlineworldpay-modal-container" style="display: none;">';
		echo '<div class="overlay-payment-processing">' . self::getPaymentLoader() . '</div>';
		echo '<div class="form-container"><div id="error_messages" class="errorMessages"></div><div class="modal-button"><span id="cancel_donation">' . __('Cancel', 'onlineworldpay') . '</span></div>';

		echo '<form id="donation_form" name="donation_form" action="post">';

		self::displayInputFields( $attribs );

		echo '<div id="donation_payment_form">';
		self::getAcceptedPaymentMethods();
		self::getPayPalButton();
		self::getHostedPaymentForm();
		self::getSubmitDonationButton();
		echo '</div>';

		echo '</form></div></div>';
	}

	public static function displayInlineForm( $attribs = null ){
		echo '<div class="onlineworldpay-inline-container">';
		echo '<div class="overlay-payment-processing">' . self::getPaymentLoader() . '</div>';
		echo '<div class="form-container"><div id="error_messages" class="errorMessages"></div>';

		echo '<form id="donation_form" name="donation_form" action="post">';

		self::displayInputFields( $attribs );

		echo '<div id="donation_payment_form">';
		self::getAcceptedPaymentMethods();
		self::getPayPalButton();
		self::getHostedPaymentForm();
		self::getSubmitDonationButton();
		echo '</div>';

		echo '</form></div></div>';
	}

	public static function displayInputFields( $attribs ){

		if( owp_manager()->isActive( 'donation_name' ) ){
			owp_get_input_html( array(
					'id'=>'donation_name',
					'name'=>'donation_name',
					'class'=>'donation-input',
					'wrapper_class'=>'input-container',
					'attributes'=>array(
							'placeholder'=>__( 'Full Name', 'onlineworldpay' )
					)
			) );
		}
		/*If paypal is active, display the address fields as a requirement.*/
		if( owp_manager()->isActive( 'donation_address') || owp_manager()->isActive( 'donations_paypal_enabled') ){
			owp_get_input_html( array(
					'id'=>'billing_address',
					'name'=>'billing_address',
					'class'=>'donation-input',
					'wrapper_class'=>'input-container',
					'attributes'=>array(
							'placeholder'=>__( 'Billing Address', 'onlineworldpay' ),
					)
			) );
			owp_get_input_html( array(
					'id'=>'billing_city',
					'name'=>'billing_city',
					'class'=>'donation-input',
					'wrapper_class'=>'input-container',
					'attributes'=>array(
							'placeholder'=>__( 'City', 'onlineworldpay')
					)
			) );
			owp_get_input_html( array(
					'id'=>'billing_postalcode',
					'name'=>'billing_postalcode',
					'class'=>'donation-input',
					'wrapper_class'=>'input-container',
					'attributes'=>array(
							'placeholder'=>__( 'Postal Code', 'onlineworldpay' ),
					)
			) );
			owp_get_select_html( array(
					'options'=>owp_get_countries(),
					'id'=>'billing_country',
					'name'=>'billing_country',
					'class'=>'donation-input',
					'wrapper_class'=>'input-container',
					'value'=>owp_manager()->get_option( 'donation_default_country' )
			) );
		}
		if( owp_manager()->isActive( 'donation_email' ) ){
			owp_get_input_html( array(
					'id'=>'donation_email',
					'name'=>'donation_email',
					'class'=>'donation-input',
					'wrapper_class'=>'input-container',
					'attributes'=>array(
							'placeholder'=>__( 'Email Address', 'onlineworldpay' ),
					)
			) );
		}
		self::getAmountField( $attribs );

	}

	public static function getAmountField( $attribs = null ){
		if( ! empty( $attribs ) ){
			$options = array();
			foreach( $attribs as $attrib ){
				$options[ $attrib ] = sprintf( '%s%s', owp_get_currency_symbol( owp_manager()->get_option( 'donation_currency' ) ), $attrib );
			}
			owp_get_select_html( array(
					'options'=>$options,
					'id'=>'donation_amount',
					'name'=>'donation_amount',
					'class'=>'select-donation-amount donation-input',
					'wrapper_class'=>'input-container',
			) );
		}
		else{
			owp_get_input_html( array(
					'id'=>'donation_amount',
					'name'=>'donation_amount',
					'class'=>'donation-input',
					'wrapper_class'=>'input-container',
					'attributes'=>array(
							'placeholder'=>sprintf(__( '%s Amount', 'onlineworldpay' ), owp_get_currency_symbol( owp_manager()->get_option( 'donation_currency' ) ) )
					)
			) );
		}
	}

	public static function getAcceptedPaymentMethods(){
		$methods = owp_manager()->get_option( 'donation_payment_methods' );
		echo '<div class="onlineworldpay-accepted-methods">';
		if( ! empty( $methods ) ){
			foreach( $methods as $type => $method ){
				if( !empty( $method ) ){
					$accepted_methods = owp_get_payment_methods();
					$accepted_method = $accepted_methods[ $type ];
					echo '<span><img src="' . $accepted_method['src'] .'"/></span>';
				}
			}
		}
		echo '</div>';
	}

	public static function getHostedPaymentForm(){
		echo '<div id="hosted_container"></div>';
	}

	public static function getModalDonationButton(){
		$style = 'background-color: ' . owp_manager()->get_option( 'donation_modal_button_background' ) . '
				; border-color: ' . owp_manager()->get_option( 'donation_modal_button_border' ) . '; color: ' . owp_manager()->get_option( 'donation_modal_button_text_color' );
		$button = '<button id="modal_button" style="' . $style . '">' . owp_manager()->get_option( 'donation_modal_button_text' ) .'</button>';
		echo '<div class="onlineworldpay-modal-button">' . $button . '</div>';
	}

	public static function getSubmitDonationButton(){
		$style = 'background-color: ' . owp_manager()->get_option( 'donation_button_background' ) . '
				; border-color: ' . owp_manager()->get_option( 'donation_button_border' ) . '; color: ' . owp_manager()->get_option( 'donation_modal_button_text_color' );
		$button = '<button class="submit-donation" style="' . $style . '">' . owp_manager()->get_option( 'donation_button_text' ) .'</button>';
		echo '<div class="donation-button">' . $button . '</div>';
	}

	public static function getJavascriptVars(){
		return array(
				'clientKey'=>owp_manager()->getClientKey(),
				'cardTemplateCode'=>owp_manager()->getCardTemplateCode(),
				'paypalEnabled'=>owp_manager()->isActive( 'donations_paypal_enabled' ) ? 'true' : 'false',
				'ajax_url'=>admin_url(). 'admin-ajax.php?action=onlineworldpay_process_donation'
		);
	}

	public static function enqueueScripts(){
		wp_enqueue_script( 'online-worldpay-js', 'https://cdn.worldpay.com/v1/worldpay.js', array( 'jquery' ), owp_manager()->version, true );
		wp_enqueue_script( 'onlineworldpay-donations', ONLINEWORLDPAY_ASSETS . 'js/donations.js', array('online-worldpay-js'), owp_manager()->version, true );
		wp_localize_script( 'onlineworldpay-donations', 'onlineworldpay_donation_vars', self::getJavascriptVars() );
		wp_enqueue_style( 'onlineworldpay-donations-css', ONLINEWORLDPAY_ASSETS . 'css/donations.css', null, owp_manager()->version );
	}

	public static function getPaymentLoader(){
		return
		'<div class="loader"></div>
		<div class="indicator">
			<svg id="loader-svg-icon" width="14px" height="16px" viewBox="0 0 28 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
			<g id="New-Customer" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
			<g id="Loading" sketch:type="MSArtboardGroup" transform="translate(-526.000000, -915.000000)" fill="#FFFFFF">
			<g id="Loading-Indicator" sketch:type="MSLayerGroup" transform="translate(468.000000, 862.000000)">
			<g id="Secure" transform="translate(58.000000, 53.000000)" sketch:type="MSShapeGroup">
			<path d="M6,10 L6,7.9998866 C6,3.57774184 9.581722,0 14,0 C18.4092877,0 22,3.58167123 22,7.9998866 L22,10 L18,10 L18,7.9947834 C18,5.78852545 16.2046438,4 14,4 C11.790861,4 10,5.79171562 10,7.9947834 L10,10 L6,10 Z M0.996534824,14 C0.446163838,14 0,14.4449463 0,14.9933977 L0,31.0066023 C0,31.5552407 0.439813137,32 0.996534824,32 L27.0034652,32 C27.5538362,32 28,31.5550537 28,31.0066023 L28,14.9933977 C28,14.4447593 27.5601869,14 27.0034652,14 L0.996534824,14 Z" id="Rectangle-520"></path>
			</g>
			</g>
			</g>
			</g>
			</svg>
		</div>';
	}

	public static function getPayPalButton(){
		if( owp_manager()->isActive( 'donations_paypal_enabled') ){
			$button = owp_get_paypal_button( owp_manager()->get_option( 'donation_paypal_button' ) );
			echo '<div class="onlineworldpay-paypal"><span><input id="donation_paypal_button" type="' . $button['type'] . '" style="' . $button['style'] . '" src="' . $button['src'] . '"/></span></div>';
			echo '<input id="apm-name" type="hidden" data-worldpay="apm-name" value="paypal">';
			echo '<input type="hidden" id="country-code" name="countryCode" data-worldpay="country-code" value="" />';
		}
	}

	public static function addDonorName( &$attribs ){
		$attribs['name'] = owp_manager()->getRequestParameter( 'donation_name' );
	}

	public static function addBillingAddress( &$attribs ){
		$attribs['billingAddress'] = array(
				'address1'=>owp_manager()->getRequestParameter( 'billing_address' ),
				'postalCode'=>owp_manager()->getRequestParameter( 'billing_postalcode' ),
				'city'=>owp_manager()->getRequestParameter( 'billing_city' ),
				'countryCode'=>owp_manager()->getRequestParameter( 'billing_country' )
		);
	}

	public static function addEmailAddress( &$attribs ){
		$attribs['shopperEmailAddress'] = owp_manager()->getRequestParameter( 'donation_email' );
	}

	public static function addOrderDescription( &$attribs ){
		$description = owp_manager()->get_option( 'donation_description' );
		if( empty( $description ) ){
			$attribs['orderDescription'] = sprintf(__( 'Donation for %s', 'onlineworldpay'), get_site_url() );
		}
		else{
			$attribs['orderDescription'] = $description;
		}
	}

	public static function addApmUrls( &$attribs ){
		$attribs['successUrl'] = get_site_url() . '/donation/apm_order/success';
		$attribs['pendingUrl'] = get_site_url() . '/donation/apm_order/pending';
		$attribs['cancelUrl'] = get_site_url() . '/donation/apm_order/cancel';
		$attribs['failureUrl'] = get_site_url() . '/donation/apm_order/failure';
	}

	public static function handleApmDonationResponse(){
		if( preg_match( '/\/?donation\/apm_order\/([a-z]+)/', $_SERVER['REQUEST_URI'], $matches ) ){
			$type = $matches[1];
			$orderCode = $_REQUEST['orderCode'];
			owp_manager()->log->writeToLog( sprintf( 'APM Donation response triggered. URI: %s. Type: %s.', $_SERVER['REQUEST_URI'], $type ) );
			apply_filters( 'onlineworldpay_apm_donation_response', $type );
		}
	}

	public static function redirectAfterApmReceived( $type = 'success' ){
		$url = null;
		switch ( $type ){
			case 'success':
			case 'pending':
				$url = owp_manager()->get_option( 'donation_success_url' );
				break;
			case 'cancel':
			case 'failure':
				$url = owp_manager()->get_option( 'donation_cancel_url' );
				break;
		}
		wp_redirect( $url );
		exit();
	}
}
OnlineWorldpay_Donations::init();