<?php
if (! defined ( 'ABSPATH' )) {
	exit (); // Exit if accessed directly
}
/**
 * Returns an array contain the settings used for configuring the plugin.
 */
return array (
		'apisettings_title' => array (
				'type' => 'title',
				'title' => __ ( 'API Settings', 'onlineworldpay' ),
				'class' => array (),
				'value' => '',
				'description' => __ ( 'In order to start accepting payments using your Online Worldpay account, you will need
						to configure your Online Worldpay API Keys. The API keys can be located by logging in to your
						<a target="_blank" href="https://online.worldpay.com/login">Online Worldpay</a> account. Navigate to the Settings page and click the API Keys tab. You will have API keys for both your test and production environment.
						<div class="onlineworldpay-testing">If you are testing, you can use test cards and read about different scenarios at <a target="_blank" href="https://online.worldpay.com/docs/testing">Online Worldpay Test Cards</a></div>', 'onlineworldpay' ) 
		),
		'woocommerce_title' => array (
				'type' => 'title',
				'title' => __ ( 'WooCommerce Settings', 'onlineworldpay' ),
				'class' => array (),
				'value' => '',
				'description' => __ ( 'On this page, you can maintain settings as they pertain to WooCommerce. To enable WooCommerce payments, you must
						click the checkbox that says <span>Enable</span>. Once enabled, a payment option for Online Worldpay will become available
						on the checkout page of your site. ' ) 
		),
		'debug_title' => array (
				'type' => 'title',
				'title' => __ ( 'Debug Log', 'onlineworldpay' ),
				'class' => array (),
				'value' => '',
				'description' => __ ( 'You can enable debug mode from this page. By enabling debug mode, you can view messages related to transactions within the plugin.
						This can be helpful when troublshooting payment issues.', 'onlineworldpay' ) 
		),
		'license_title' => array (
				'type' => 'title',
				'title' => __ ( 'License Activation', 'Online Worldpay' ),
				'class' => array (),
				'value' => '',
				'description' => __ ( 'You can activate your license from this page. Once you have purchased a license from <a target="_blank" href="https://wordpress.paymentplugins.com/product-category/worldpay/">Payment Plugins</a>
						 you can activate it here. Enter the license key you receive in your order in the license field and click save. If the license activation is not successful, check the debug log for a detailed error message.', 'onlineworldpay' ) 
		),
		'subscriptions_title' => array (
				'type' => 'title',
				'title' => __ ( 'Subscriptions', 'onlineworldpay' ),
				'class' => array (),
				'value' => '',
				'description' => __ ( 'This plugin integrates with the <a target="_blank" href="https://www.woothemes.com/products/woocommerce-subscriptions/">WooCommerce Subscriptions</a> plugin. If you sell subscription products, you will be able to use Your Online Worldpay account to charge
						the subscription payments.', 'onlineworldpay' ) 
		),
		'donations_title' => array (
				'type' => 'title',
				'title' => __ ( 'Donations Settings', 'onlineworldpay' ),
				'class' => array (),
				'value' => '',
				'description' => __ ( 'On this page you can configure the settings for your donation form. By using short code <span>[onlineworldpay_donations]</span> on any of your pages, you can accept
						donations. If you would like to set pre-configured donation amounts, you can add them to the short code. <strong>Example:</strong> <strong>[onlineworldpay_donations 1="5" 2="10" 3="15"]</strong> will add a drop down on the payment form and allow the donor to select from those three amounts. If you only want
						one amount to be possible then simply write the shortcode as <strong>[onlineworldpay_donations 1="50"]</strong>. By doing this, you can actually sell products using the donation functionality.', 'onlineworldpay' ) 
		),
		'license_status' => array (
				'type' => 'custom',
				'title' => __ ( 'License Status', 'onlineworldpay' ),
				'value' => '',
				'default' => 'inactive',
				'class' => array (),
				'tool_tip' => true,
				'function' => 'OnlineWorldpay_Admin::getLicenseStatus',
				'description' => __ ( 'Once you have purchased a license from <a href="https://wordpress.paymentplugins.com">Payment Plugins</a> you will
						be provided with a license key. You can active the license on the license activate page and this will allow you to configure the
						production mode of the plugin. ', 'onlineworldpay' ) 
		),
		'license_status_notice' => array (
				'type' => 'custom',
				'title' => __ ( 'License Status', 'onlineworldpay' ),
				'value' => '',
				'default' => 'Inactive',
				'class' => array (),
				'tool_tip' => true,
				'function' => 'OnlineWorldpay_Admin::getLicenseStatus',
				'description' => __ ( 'Once you have purchased a license from <a href="https://wordpress.paymentplugins.com">Payment Plugins</a> you will
						be provided with a license key. You can active the license on the license activate page and this will allow you to configure the
						production mode of the plugin. ', 'onlineworldpay' ) 
		),
		'license' => array (
				'type' => 'text',
				'value' => '',
				'default' => '',
				'title' => __ ( 'License Number', 'onlineworldpay' ),
				'class' => array (),
				'tool_tip' => true,
				'description' => __ ( 'This field contains the value of your license key if you have purchased one. It will appear once you have
						activated your license.', 'onlineworldpay' ) 
		),
		'enabled' => array (
				'type' => 'checkbox',
				'value' => 'yes',
				'default' => 'yes',
				'title' => __ ( 'Enable OnlineWorldpay', 'onlineworldpay' ),
				'class' => array (),
				'tool_tip' => true,
				'description' => __ ( 'If enabled, this payment plugin can be used with WooCommerce. You must enable it for the payment option to appear on the checkout page.', 'onlineworldpay' ) 
		),
		'environment' => array (
				'type' => 'select',
				'options' => array (
						'sandbox' => __ ( 'Test Mode', 'onlineworldpay' ),
						'production' => __ ( 'Live Mode', 'onlineworldpay' ) 
				),
				'default' => 'sandbox',
				'title' => __ ( 'Active Environment', 'onlineworldpay' ),
				'class' => array (
						'onlineworldpay-active-environment' 
				),
				'tool_tip' => true,
				'description' => __ ( 'You can enable Test mode or Live mode with this setting. When testing the plugin, enable Test mode and you can run test transactions using your Online Worldpay account.
					When you are ready to go live, enable Live mode and purchase a license from Payment Plugins.', 'onlineworldpay' ) 
		),
		'production_merchant_id' => array (
				'type' => 'text',
				'title' => __ ( 'Live Merchant ID', 'onlineworldpay' ),
				'value' => '',
				'default' => '',
				'class' => array (
						'merchantId' 
				),
				'tool_tip' => true,
				'description' => __ ( 'Your Merchant ID is used to identify you within the Online Worldpay environment. You can find your merchant Id by logging
						into the <a target="_blank" href="https://online.worldpay.com/login">Online Worldpay</a> and navigating to <span>Settings</span> > <span>API Keys</span>', 'onlineworldpay' ) 
		),
		'production_service_key' => array (
				'type' => 'password',
				'title' => __ ( 'Live Service Key', 'onlineworldpay' ),
				'value' => '',
				'default' => '',
				'class' => array (
						'privateKey' 
				),
				'tool_tip' => true,
				'description' => __ ( 'The service key is used by Worldpay to authenticate each request. You should not share this key with anyone. You can find your service key by logging
						into the <a target="_blank" href="https://online.worldpay.com/settings/keys">Online Worldpay</a> and navigating to <span>Settings</span> > <span>API Keys</span>.', 'onlineworldpay' ) 
		),
		'production_client_key' => array (
				'type' => 'text',
				'title' => __ ( 'Live Client Key', 'onlineworldpay' ),
				'value' => '',
				'default' => '',
				'class' => array (
						'publicKey' 
				),
				'tool_tip' => true,
				'description' => __ ( 'The public key is used by Worldpay to authenticate each request. You can find your merchant Id by logging
						into the <a target="_blank" href="https://online.worldpay.com/login">Online Worldpay</a> and navigating to <span>Settings</span> > <span>API Keys</span>', 'onlineworldpay' ) 
		),
		'sandbox_merchant_id' => array (
				'type' => 'text',
				'title' => __ ( 'Test Merchant ID', 'onlineworldpay' ),
				'value' => '',
				'default' => '',
				'class' => array (
						'merchantId' 
				),
				'tool_tip' => true,
				'description' => __ ( 'Your Merchant ID is used to identify you within the Online Worldpay environment. You can find your merchant Id by logging
						into the <a target="_blank" href="https://online.worldpay.com/login">Online Worldpay</a> and navigating to <span>Settings</span> > <span>API Keys</span>', 'onlineworldpay' ) 
		),
		'sandbox_service_key' => array (
				'type' => 'password',
				'title' => __ ( 'Test Service Key', 'onlineworldpay' ),
				'value' => '',
				'default' => '',
				'class' => array (
						'privateKey' 
				),
				'tool_tip' => true,
				'description' => __ ( 'The service key is used by Worldpay to authenticate each request. You should not share this key with anyone. You can find your service key by logging
						into the <a target="_blank" href="https://online.worldpay.com/settings/keys">Online Worldpay</a> and navigating to <span>Settings</span> > <span>API Keys</span>.', 'onlineworldpay' ) 
		),
		'sandbox_client_key' => array (
				'type' => 'text',
				'title' => __ ( 'Test Client Key', 'onlineworldpay' ),
				'value' => '',
				'default' => '',
				'class' => array (
						'publicKey' 
				),
				'tool_tip' => true,
				'description' => __ ( 'The public key is used by Worldpay to authenticate each request. You can find your merchant Id by logging into 
				        <a target="_blank" href="https://online.worldpay.com/settings/keys">Online Worldpay</a> and navigating to <span>Settings</span> > <span>API Keys</span>', 'onlineworldpay' ) 
		),
		'title_text' => array (
				'type' => 'text',
				'title' => __ ( 'Title Text', 'onlineworldpay' ),
				'value' => '',
				'default' => 'Online Worldpay',
				'class' => array (),
				'tool_tip' => true,
				'description' => __ ( 'The title text is the text that will be displayed on the checkout page. Common values are Credit Card / PayPal.', 'onlineworldpay' ) 
		),
		'order_status' => array (
				'type' => 'select',
				'title' => __ ( 'Order Status', 'onlineworldpay' ),
				'options' => owp_get_order_statuses (),
				'default' => 'wc-completed',
				'class' => array (),
				'tool_tip' => true,
				'description' => __ ( 'This is the order status assigned to the order once the payment has been processed by Worldpay. Most merchants
						use processing or complete.', 'onlineworldpay' ) 
		),
		'order_prefix' => array (
				'type' => 'text',
				'title' => __ ( 'Order Prefix', 'onlineworldpay' ),
				'value' => '',
				'default' => '',
				'attributes' => array (
						'maxlength' => 20 
				),
				'attributes' => array (
						'maxlength' => 20 
				),
				'class' => array (),
				'tool_tip' => true,
				'description' => __ ( 'The order prefix is prepended to the transaction id (order code) and will appear as the order code in Worldpay. This settings can be helpful if you want to distinguish
						orders that came from this particular site or plugin.', 'onlineworldpay' ) 
		),
		'order_suffix' => array (
				'type' => 'text',
				'title' => __ ( 'Order Suffix', 'onlineworldpay' ),
				'value' => '',
				'default' => '',
				'attributes' => array (
						'maxlength' => 20 
				),
				'class' => array (),
				'tool_tip' => true,
				'description' => __ ( 'The order suffix is appended to the order id and used by Online Worldpay. This settings can be helpful if you want to distinguish
						orders that came from this particular site or plugin.', 'onlineworldpay' ) 
		),
		'order_description' => array (
				'type' => 'textarea',
				'title' => __ ( 'Order Description', 'onlineworldpay' ),
				'default' => '',
				'tool_tip' => true,
				'class' => array (
						'orderDescription' 
				),
				'description' => __ ( 'The order description allows you to add information for each order. It can be a way to track orders for your varying sites or to add notes on the origin of the order.', 'onlineworldpay' ) 
		),
		'payment_methods' => array (
				'type' => 'checkbox',
				'value' => owp_get_payment_methods (),
				'default' => '',
				'title' => __ ( 'Display Payment Methods', 'onlineworldpay' ),
				'class' => array (),
				'tool_tip' => true,
				'description' => __ ( 'If you want to display an image of the payment methods on the
						checkout page that your Worldpay account accepts, select the checkboxes.', 'onlineworldpay' ) 
		),
		'paypal_only' => array (
				'type' => 'checkbox',
				'value' => 'yes',
				'default' => '',
				'title' => __ ( 'Only Allow Paypal', 'onlineworldpay' ),
				'class' => array (),
				'tool_tip' => true,
				'description' => __ ( 'If you only want to use this plugin to accept PayPal, enable it here. In addition to this setting, you
						must make sure you enabled PayPal from within the Worldpay Control Panel.', 'onlineworldpay' ) 
		),
		'enable_paypal' => array (
				'type' => 'checkbox',
				'value' => 'yes',
				'default' => '',
				'title' => __ ( 'Enable Paypal', 'onlineworldpay' ),
				'class' => array (),
				'tool_tip' => true,
				'description' => __ ( 'If you want to accept PayPal payments, then you can enable it with this setting. Be sure and configure your Online Worldpay acount to accept PayPal. You can find
						detailed instruction on <a target="_blank" href="https://online.worldpay.com/docs/paypal">Online Worldpay</a>.', 'onlineworldpay' ) 
		),
		'paypal_button' => array (
				'type' => 'custom',
				'function' => 'OnlineWorldpay_Admin::getPayPalButtons',
				'title' => __ ( 'PayPal Buttons' ),
				'class' => array (
						'subItem paypal' 
				),
				'default' => 0,
				'tool_tip' => true,
				'description' => __ ( 'If PayPal has been enabled, you can select the button design that should appear on the checkout page.' ) 
		),
		'enable_debug' => array (
				'type' => 'checkbox',
				'value' => 'yes',
				'default' => 'yes',
				'title' => __ ( 'Enable Debug Mode', 'onlineworldpay' ),
				'class' => array (),
				'tool_tip' => true,
				'description' => __ ( 'If you need to troubleshoot payment transactions, enable debug mode. You can view the debug messages on this page.', 'onlineworldpay' ) 
		),
		'woocommerce_subscriptions' => array (
				'type' => 'checkbox',
				'value' => 'yes',
				'default' => 'yes',
				'title' => __ ( 'WooCommerce Subscriptions', 'onlineworldpay' ),
				'class' => array (),
				'tool_tip' => true,
				'description' => __ ( 'Enable this mode if you want the WooCommerce Subscriptions plugin to handle the subscription payment.', 'onlineworldpay' ) 
		),
		'subscriptions_payment_success_status' => array (
				'type' => 'select',
				'options' => array (
						'wc-pending' => _x ( 'Pending', 'Subscription status', 'woocommerce-subscriptions' ),
						'wc-active' => _x ( 'Active', 'Subscription status', 'woocommerce-subscriptions' ) ,
						'wc-on-hold' => _x ( 'On Hold', 'Subscription status', 'woocommerce-subscriptions' ) 
				),
				'default' => 'wc-active',
				'title' => __ ( 'Subscription Status - Payment Success', 'onlineworldpay' ),
				'class' => array (
						'subItem' 
				),
				'tool_tip' => true,
				'description' => __ ( 'This setting determines the status of the subscription when the payment is processed successfully during checkout.', 'onlineworldpay' ) 
		),
		'subscriptions_payment_failed_status' => array (
				'type' => 'select',
				'options' => owp_get_subscription_statuses (),
				'default' => 'wc-on-hold',
				'title' => __ ( 'Subscription Status - Payment Failed', 'onlineworldpay' ),
				'class' => array (
						'subItem' 
				),
				'tool_tip' => true,
				'description' => __ ( 'This setting determines the status of the subscription when the payment fails during subscription processing.
						<span class="example">Example:If you want the customer\'s subscription to be cancelled if their payment fails during a recurring payment, set the status to cancelled.</span>', 'onlineworldpay' ) 
		),
		'subscriptions_cancelled_status' => array (
				'type' => 'select',
				'options' => owp_get_subscription_statuses (),
				'default' => 'wc-cancelled',
				'title' => __ ( 'Subscription Status - Cancelled', 'onlineworldpay' ),
				'class' => array (
						'subItem' 
				),
				'tool_tip' => true,
				'description' => __ ( 'This setting determines the status of the subscription when the subscription has been cancelled. Most merchants set this value to Cancelled but in some cases
						you may want to set the status to Pending Cancel in order to review the cancellation first.', 'onlineworldpay' ) 
		),
		'subscription_prefix' => array (
				'type' => 'text',
				'value' => '',
				'default' => '',
				'attributes' => array (
						'maxlength' => 20 
				),
				'title' => __ ( 'Subscription Prefix', 'onlineworldpay' ),
				'class' => array (
						'subItem',
						'prefixInput' 
				),
				'tool_tip' => true,
				'description' => __ ( 'If you would like the subscription orderId to contain an order prefix, you can add one here. If left blank, the subscription prefix
						will not be added.', 'onlineworldpay' ) 
		),
		'subscription_suffix' => array (
				'type' => 'text',
				'value' => '',
				'default' => '',
				'attributes' => array (
						'maxlength' => 20 
				),
				'title' => __ ( 'Subscription Suffix', 'onlineworldpay' ),
				'class' => array (
						'subItem',
						'prefixInput' 
				),
				'tool_tip' => true,
				'description' => __ ( 'If you would like the subscription orderId to contain an order suffix, you can add one here. If left blank, the subscription suffix
						will not be added.', 'onlineworldpay' ) 
		),
		'subscription_description' => array (
				'type' => 'textarea',
				'title' => __ ( 'Subscription Description', 'onlineworldpay' ),
				'default' => '',
				'tool_tip' => true,
				'class' => array (
						'subItem',
						'orderDescription' 
				),
				'description' => __ ( 'The subscription description allows you to add information for the subscription. It can be a way to track subscription orders for your varying sites or to add notes on the origin of the order.', 'onlineworldpay' ) 
		),
		'donation_button_design' => array (
				'type' => 'title',
				'title' => __ ( 'Button Design Settings', 'onlineworldpay' ),
				'class' => array (
						'h1--DonationButtonDesign' 
				),
				'value' => '',
				'description' => __ ( 'You can configure the look and feel of your donation button with the following settings.', 'onlineworldpay' ) 
		),
		'donation_form_layout' => array (
				'type' => 'select',
				'value' => array (
						'modal',
						'inline' 
				),
				'default' => 'modal',
				'title' => __ ( 'Form Layout', 'onlineworldpay' ),
				'class' => array (),
				'tool_tip' => true,
				'description' => __ ( 'The form layout has two options. If modal is selected, the form will appear as a popup when the donator
						clicks the donation button. If inline is selected, the donation form will appear inside the html of the page.', 'onlineworldpay' ) 
		),
		'donation_button_text' => array (
				'type' => 'text',
				'value' => 'Donate',
				'default' => __ ( 'Donate', 'onlineworldpay' ),
				'title' => __ ( 'Button Text', 'onlineworldpay' ),
				'class' => array (),
				'tool_tip' => true,
				'description' => __ ( 'You can customize the text that appears on the donation button by entering the text here.', 'onlineworldpay' ) 
		),
		'donation_button_background' => array (
				'type' => 'text',
				'value' => '#61D395',
				'default' => '#61D395',
				'title' => __ ( 'Background Color', 'onlineworldpay' ),
				'class' => array (
						'donationColor' 
				),
				'tool_tip' => true,
				'description' => __ ( 'You can customize the background color of the donation button by selecting a color from the color picker.', 'onlineworldpay' ) 
		),
		'donation_button_border' => array (
				'type' => 'text',
				'value' => '#61D395',
				'default' => '#61D395',
				'title' => __ ( 'Border Color', 'onlineworldpay' ),
				'class' => array (
						'donationColor' 
				),
				'tool_tip' => true,
				'description' => __ ( 'You can customize the border color of the donation button by selecting a color from the color picker.', 'onlineworldpay' ) 
		),
		'donation_button_text_color' => array (
				'type' => 'text',
				'value' => '#61D395',
				'default' => '#ffffff',
				'title' => __ ( 'Text Color', 'onlineworldpay' ),
				'class' => array (
						'donationColor' 
				),
				'tool_tip' => true,
				'description' => __ ( 'You can customize the text color of the button.', 'onlineworldpay' ) 
		),
		'donation_modal_button_text' => array (
				'type' => 'text',
				'value' => 'Some Text',
				'default' => __ ( 'Donate', 'onlineworldpay' ),
				'title' => __ ( 'Modal Button Text', 'onlineworldpay' ),
				'class' => array (
						'subItem',
						'modalOption' 
				),
				'tool_tip' => true,
				'description' => __ ( 'If you have enabled the modal donation form, you can control the text that is displayed for the button that when clicked displays
						the modal donation form.', 'onlineworldpay' ) 
		),
		'donation_modal_button_background' => array (
				'type' => 'text',
				'value' => '#61D395',
				'default' => '#61D395',
				'title' => __ ( 'Background Color', 'onlineworldpay' ),
				'class' => array (
						'donationColor',
						'subItem',
						'modalOption' 
				),
				'tool_tip' => true,
				'description' => __ ( 'You can customize the the background color of the modal donation button by selecting a color from the color picker.', 'onlineworldpay' ) 
		),
		'donation_modal_button_border' => array (
				'type' => 'text',
				'value' => '#61D395',
				'default' => '#61D395',
				'title' => __ ( 'Border Color', 'onlineworldpay' ),
				'class' => array (
						'donationColor',
						'subItem',
						'modalOption' 
				),
				'tool_tip' => true,
				'description' => __ ( 'You can customize the border color of the modal donation button by selecting a color from the color picker.', 'onlineworldpay' ) 
		),
		'donation_modal_button_text_color' => array (
				'type' => 'text',
				'value' => '#61D395',
				'default' => '#ffffff',
				'title' => __ ( 'Text Color', 'onlineworldpay' ),
				'class' => array (
						'donationColor',
						'subItem',
						'modalOption' 
				),
				'tool_tip' => true,
				'description' => __ ( 'You can customize the color of the text with this option.', 'onlineworldpay' ) 
		),
		'donation_address' => array (
				'type' => 'checkbox',
				'value' => 'yes',
				'default' => 'yes',
				'title' => __ ( 'Capture Billing Address', 'onlineworldpay' ),
				'class' => array (),
				'tool_tip' => true,
				'description' => __ ( 'If enabled, the donation form will have address fields for capturing the donor\'s billing address.', 'onlineworldpay' ) 
		),
		'donation_email' => array (
				'type' => 'checkbox',
				'value' => 'yes',
				'default' => 'yes',
				'title' => __ ( 'Capture Email', 'onlineworldpay' ),
				'class' => array (),
				'tool_tip' => true,
				'description' => __ ( 'If enabled, the donation form will have a field for capturing the donor\'s email address. If you have enabled email receipts from within Worldpay,
						then this is a required setting.', 'onlineworldpay' ) 
		),
		'donation_name' => array (
				'type' => 'checkbox',
				'value' => 'yes',
				'default' => 'yes',
				'title' => __ ( 'Capture Donor Name', 'onlineworldpay' ),
				'class' => array (),
				'tool_tip' => true,
				'description' => __ ( 'If enabled, the donation form will have fields for capturing the donor\'s name.', 'onlineworldpay' ) 
		),
		'donation_success_url' => array (
				'type' => 'text',
				'value' => '',
				'default' => '',
				'title' => __ ( 'Success URL', 'onlineworldpay' ),
				'class' => array (
						'donation-url' 
				),
				'tool_tip' => true,
				'description' => __ ( 'Enter the url of the page/site you would like the customer to be redirected to after the donation is made successfully.', 'onlineworldpay' ) 
		),
		'donation_cancel_url' => array (
				'type' => 'text',
				'value' => '',
				'default' => '',
				'title' => __ ( 'Cancel URL', 'onlineworldpay' ),
				'class' => array (
						'donation-url' 
				),
				'tool_tip' => true,
				'description' => __ ( 'Enter the url of the page/site you would like the customer to be redirected to if they choose PayPal and decide to cancel the order.', 'onlineworldpay' ) 
		),
		'donation_currency' => array (
				'type' => 'select',
				'options' => owp_get_currencies (),
				'default' => 'GBP',
				'title' => __ ( 'Donation Currency', 'onlineworldpay' ),
				'class' => array (
						'' 
				),
				'tool_tip' => true,
				'description' => __ ( 'You can set the currency that will display on the amount field. Ensure this currencyy matches the currency for your Worldpay Account.', 'onlineworldpay' ) 
		),
		'donation_default_country' => array (
				'type' => 'select',
				'options' => owp_get_countries (),
				'title' => __ ( 'Donation Country', 'onlineworldpay' ),
				'class' => array (
						'subItem',
						'addressOption' 
				),
				'default' => 'GB',
				'tool_tip' => true,
				'description' => __ ( 'You can set the default country that will appear on the donation form.', 'onlineworldpay' ) 
		),
		'donation_payment_methods' => array (
				'type' => 'checkbox',
				'value' => owp_get_payment_methods (),
				'default' => '',
				'title' => __ ( 'Display Payment Methods', 'onlineworldpay' ),
				'class' => array (),
				'tool_tip' => true,
				'description' => __ ( 'If you want to display an image of the payment methods on the
						checkout page that your Worldpay account accepts, select the checkboxes.', 'onlineworldpay' ) 
		),
		'enable_webhooks' => array (
				'type' => 'checkbox',
				'value' => 'yes',
				'default' => '',
				'title' => __ ( 'Enable Webhooks', 'onlineworldpay' ),
				'class' => array (),
				'tool_tip' => true,
				'description' => __ ( 'If Webhooks are enabled, you must enable Worldpay Subscriptions on the Subscriptions page.', 'onlineworldpay' ) 
		),
		'sandbox_connection_test' => array (
				'type' => 'custom',
				'title' => __ ( 'Sandbox Connection Test', 'onlineworldpay' ),
				'value' => '',
				'default' => 'Inactive',
				'class' => array (),
				'tool_tip' => true,
				'function' => 'OnlineWorldpay_Admin::testSandboxConnection',
				'description' => __ ( 'Once you have entered and saved your API keys, you can perform a connection test to ensure you have entered them correctly.', 'onlineworldpay' ) 
		),
		'production_connection_test' => array (
				'type' => 'custom',
				'title' => __ ( 'Production Connection Test', 'onlineworldpay' ),
				'value' => '',
				'default' => 'Inactive',
				'class' => array (),
				'tool_tip' => true,
				'function' => 'OnlineWorldpay_Admin::testProductionConnection',
				'description' => __ ( 'Once you have entered and saved your API keys, you can perform a connection test to ensure you have entered them correctly.', 'onlineworldpay' ) 
		),
		'production_card_template' => array (
				'type' => 'text',
				'title' => __ ( 'Production Card Template Code', 'onlineworldpay' ),
				'class' => array (
						'templateCode' 
				),
				'default' => '',
				'tool_tip' => true,
				'description' => __ ( 'The template is token template value that represents the hosted payment form that you want to use. To create a payment form,
						login to <a target="_blank" href="">Online Worldpay</a> and navigate to <strong>Settings</strong> <strong>Templates</strong>.', 'onlineworldpay' ) 
		),
		'sandbox_card_template' => array (
				'type' => 'text',
				'title' => __ ( 'Sandbox Card Template Code', 'onlineworldpay' ),
				'class' => array (
						'templateCode' 
				),
				'default' => '',
				'tool_tip' => true,
				'description' => __ ( 'The template is token template value that represents the hosted payment form that you want to use. To create a payment form,
						login to <a target="_blank" href="">Online Worldpay</a> and navigate to <strong>Settings</strong> <strong>Templates</strong>.', 'onlineworldpay' ) 
		),
		'production_cvc_template' => array (
				'type' => 'text',
				'title' => __ ( 'Production CVC Template Code', 'onlineworldpay' ),
				'class' => array (
						'templateCode' 
				),
				'default' => '',
				'tool_tip' => true,
				'description' => __ ( 'The CVC template is token template value that represents the hosted cvc form that you want to use when customers are using a saved payment method. They will be prompted to enter the CVC which
						increases security. To create a CVC template, login to <a target="_blank" href="">Online Worldpay</a> and navigate to <strong>Settings</strong> <strong>Templates</strong>.', 'onlineworldpay' ) 
		),
		'sandbox_cvc_template' => array (
				'type' => 'text',
				'title' => __ ( 'Sandbox CVC Template Code', 'onlineworldpay' ),
				'class' => array (
						'templateCode' 
				),
				'default' => '',
				'tool_tip' => true,
				'description' => __ ( 'The CVC template is token template value that represents the hosted cvc form that you want to use when customers are using a saved payment method. They will be prompted to enter the CVC which
						increases security. To create a CVC template, login to <a target="_blank" href="">Online Worldpay</a> and navigate to <strong>Settings</strong> <strong>Templates</strong>.', 'onlineworldpay' ) 
		),
		'settlement_currency' => array (
				'type' => 'select',
				'options' => owp_get_settlement_currencies (),
				'title' => __ ( 'Settlement Currency', 'onlineworldpay' ),
				'class' => array (),
				'default' => 'GBP',
				'tool_tip' => true,
				'description' => __ ( 'The settlement currency is the currency that you are paid in via Worldpay. For more information, you can read about settlement currency on <a target="_blank"
						href="https://online.worldpay.com/support/articles/how-do-i-add-settlement-currencies-to-my-account">Online Worldpay</a>.', 'onlineworldpay' ) 
		),
		'donation_settlement_currency' => array (
				'type' => 'select',
				'options' => owp_get_settlement_currencies (),
				'title' => __ ( 'Settlement Currency', 'onlineworldpay' ),
				'default' => 'GBP',
				'class' => array (),
				'tool_tip' => true,
				'description' => __ ( 'The settlement currency is the currency that all of your transactions are settled to. You can add settlement currencies to your Online Worldpay account but you are limited to one settlement currency in these options.
						More info can be found <a target="_blank" href="https://online.worldpay.com/settings/currencies">here</a>.', 'onlineworldpay' ) 
		),
		'donation_order_description' => array (
				'type' => 'textarea',
				'title' => __ ( 'Donation Description', 'onlineworldpay' ),
				'default' => sprintf ( __ ( 'Donation for %s', 'onlineworldpay' ), get_site_url () ),
				'tool_tip' => true,
				'class' => array (
						'orderDescription' 
				),
				'description' => __ ( 'The order description allows you to add information for each Donation. It can be a way to track donation for your varying sites or to add notes on the origin of the donation.', 'onlineworldpay' ) 
		),
		'donations_paypal_enabled' => array (
				'type' => 'checkbox',
				'value' => 'yes',
				'default' => '',
				'title' => __ ( 'Enable Paypal', 'onlineworldpay' ),
				'class' => array (),
				'tool_tip' => true,
				'description' => __ ( 'If you want to accept PayPal for donation payments, then you can enable it with this setting. Be sure and configure your Online Worldpay acount to accept PayPal. You can find
						detailed instruction on <a target="_blank" href="https://online.worldpay.com/docs/paypal">Online Worldpay</a>.', 'onlineworldpay' ) 
		),
		'donation_paypal_button' => array (
				'type' => 'custom',
				'function' => 'OnlineWorldpay_Admin::getDonationPayPalButtons',
				'title' => __ ( 'PayPal Buttons' ),
				'class' => array (
						'subItem paypal' 
				),
				'default' => 0,
				'tool_tip' => true,
				'description' => __ ( 'If PayPal has been enabled, you can select the button design that should appear on the checkout page.' ) 
		),
		'webhooks_title' => array (
				'type' => 'title',
				'title' => __ ( 'Webhooks', 'onlineworldpay' ),
				'class' => array (),
				'value' => '',
				'description' => __ ( 'Webhooks are a great way to receive on demand information about orders from Online Worldpay. When the status of an order changes, Online Worldpay will send a notification to your
						server. The message will be parsed and the information added to the order as a note. You can enable admin email notifications when a webhook has been triggered. The email functionality relies on the 
						<a target="_blank" href="https://developer.wordpress.org/reference/functions/wp_mail/">wp_mail()</a> function so ensure you have maintained all of the correct settings. WooCommerce relies on the same function so if your order emails are
						working then there should be no extra steps. If you don\'t have email configured, <a target="_blank" href="https://sendgrid.com/home/c">Send Grid</a> is a great option.', 'onlineworldpay' ) 
		),
		'webhooks_enable' => array (
				'type' => 'checkbox',
				'value' => 'yes',
				'default' => '',
				'title' => __ ( 'Enable Webhooks', 'onlineworldpay' ),
				'class' => array (),
				'tool_tip' => true,
				'description' => __ ( 'In order to receive webhooks, you must enable them here. If enabled, Online Worldpay will send order status updates to your server.', 'onlineworldpay' ) 
		),
		'webhooks_url' => array (
				'type' => 'custom',
				'function' => 'OnlineWorldpay_Admin::displayWebhooksUrl',
				'title' => __ ( 'Webhooks Url', 'onlineworldpay' ),
				'class' => array (),
				'tool_tip' => true,
				'description' => __ ( 'In order for Worldpay to send messages to your server, it needs an endpoint. You must copy and paste this value into the webhooks settings within Online Worldpay.
						To add the webhooks logon to <a target="_blank" href="https://online.worldpay.com">Online Worldpay</a> and click <strong>Settings</strong> > <strong>Webhooks</strong> > <strong>Add Webhook</strong>. To generate a new url for security
						reasons, click "New Key."', 'onlineworldpay' ) 
		),
		'webhooks_success' => array (
				'type' => 'checkbox',
				'value' => 'yes',
				'default' => '',
				'title' => __ ( 'Success', 'onlineworldpay' ),
				'tool_tip' => true,
				'description' => __ ( 'If enabled, you will receive notifications when a payment for an order is successful.', 'onlineworldpay' ) 
		),
		'webhooks_failed' => array (
				'type' => 'checkbox',
				'value' => 'yes',
				'default' => '',
				'title' => __ ( 'Failed', 'onlineworldpay' ),
				'tool_tip' => true,
				'description' => __ ( 'If enabled, you will receive notifications when a payment for an order has failed.', 'onlineworldpay' ) 
		),
		'webhooks_settled' => array (
				'type' => 'checkbox',
				'value' => 'yes',
				'default' => '',
				'title' => __ ( 'Settled', 'onlineworldpay' ),
				'tool_tip' => true,
				'description' => __ ( 'If enabled, you will receive notifications when a payment for an order has settled.', 'onlineworldpay' ) 
		),
		'webhooks_refunded' => array (
				'type' => 'checkbox',
				'value' => 'yes',
				'default' => '',
				'title' => __ ( 'Refunded', 'onlineworldpay' ),
				'tool_tip' => true,
				'description' => __ ( 'If enabled, you will receive notifications when a payment for an order has been refunded.', 'onlineworldpay' ) 
		),
		'webhooks_sent_for_refund' => array (
				'type' => 'checkbox',
				'value' => 'yes',
				'default' => '',
				'title' => __ ( 'Sent For Refund', 'onlineworldpay' ),
				'tool_tip' => true,
				'description' => __ ( 'If enabled, you will receive notifications when a payment for an order has been sent for refund.', 'onlineworldpay' ) 
		),
		'webhooks_partially_refunded' => array (
				'type' => 'checkbox',
				'value' => 'yes',
				'default' => '',
				'title' => __ ( 'Partial Refund', 'onlineworldpay' ),
				'tool_tip' => true,
				'description' => __ ( 'If enabled, you will receive notifications when a payment for an order has been partially refunded.', 'onlineworldpay' ) 
		),
		'webhooks_charged_back' => array (
				'type' => 'checkbox',
				'value' => 'yes',
				'default' => '',
				'title' => __ ( 'Charge Back', 'onlineworldpay' ),
				'tool_tip' => true,
				'description' => __ ( 'If enabled, you will receive notifications when a payment for an order has been charged back.', 'onlineworldpay' ) 
		),
		'webhooks_chargeback_reversed' => Array (
				'type' => 'checkbox',
				'value' => 'yes',
				'default' => '',
				'title' => __ ( 'Charge Back Reversed', 'onlineworldpay' ),
				'tool_tip' => true,
				'description' => __ ( 'If enabled, you will receive notifications when a charge back has been reversed.', 'onlineworldpay' ) 
		),
		'webhooks_success_email_admin' => array (
				'type' => 'checkbox',
				'value' => 'yes',
				'default' => '',
				'title' => __ ( 'Send Admin Email', 'onlineworldpay' ),
				'class' => array (
						'subItem' 
				),
				'attributes' => array (
						'parent-setting' => 'webhooks_success' 
				),
				'tool_tip' => true,
				'description' => __ ( 'If enabled, you will receive an email notification when a payment has been made successfully.', 'onlineworldpay' ) 
		),
		'webhooks_failed_email_admin' => array (
				'type' => 'checkbox',
				'value' => 'yes',
				'default' => '',
				'title' => __ ( 'Send Admin Email', 'onlineworldpay' ),
				'class' => array (
						'subItem' 
				),
				'attributes' => array (
						'parent-setting' => 'webhooks_failed' 
				),
				'tool_tip' => true,
				'description' => __ ( 'If enabled, you will receive an email notification when a payment has failed.', 'onlineworldpay' ) 
		),
		'webhooks_settled_email_admin' => array (
				'type' => 'checkbox',
				'value' => 'yes',
				'default' => '',
				'title' => __ ( 'Send Admin Email', 'onlineworldpay' ),
				'class' => array (
						'subItem' 
				),
				'attributes' => array (
						'parent-setting' => 'webhooks_settled' 
				),
				'tool_tip' => true,
				'description' => __ ( 'If enabled, you will receive an email notification when a payment has settled.', 'onlineworldpay' ) 
		),
		'webhooks_refunded_email_admin' => array (
				'type' => 'checkbox',
				'value' => 'yes',
				'default' => '',
				'title' => __ ( 'Send Admin Email', 'onlineworldpay' ),
				'class' => array (
						'subItem' 
				),
				'attributes' => array (
						'parent-setting' => 'webhooks_refunded' 
				),
				'tool_tip' => true,
				'description' => __ ( 'If enabled, you will receive an email notification when a payment has been refunded.', 'onlineworldpay' ) 
		),
		'webhooks_sent_for_refund_email_admin' => array (
				'type' => 'checkbox',
				'value' => 'yes',
				'default' => '',
				'title' => __ ( 'Send Admin Email', 'onlineworldpay' ),
				'class' => array (
						'subItem' 
				),
				'attributes' => array (
						'parent-setting' => 'webhooks_sent_for_refund' 
				),
				'tool_tip' => true,
				'description' => __ ( 'If enabled, you will receive an email notification when a payment has been sent for refund.', 'onlineworldpay' ) 
		),
		'webhooks_partially_refunded_email_admin' => array (
				'type' => 'checkbox',
				'value' => 'yes',
				'default' => '',
				'title' => __ ( 'Send Admin Email', 'onlineworldpay' ),
				'class' => array (
						'subItem' 
				),
				'attributes' => array (
						'parent-setting' => 'webhooks_partially_refunded' 
				),
				'tool_tip' => true,
				'description' => __ ( 'If enabled, you will receive an email notification when a payment has been partially refunded.', 'onlineworldpay' ) 
		),
		'webhooks_charged_back_email_admin' => array (
				'type' => 'checkbox',
				'value' => 'yes',
				'default' => '',
				'title' => __ ( 'Send Admin Email', 'onlineworldpay' ),
				'class' => array (
						'subItem' 
				),
				'attributes' => array (
						'parent-setting' => 'webhooks_charged_back' 
				),
				'tool_tip' => true,
				'description' => __ ( 'If enabled, you will receive an email notification when a payment has been charged back.', 'onlineworldpay' ) 
		),
		'webhooks_chargeback_reversed_email_admin' => array (
				'type' => 'checkbox',
				'value' => 'yes',
				'default' => '',
				'title' => __ ( 'Send Admin Email', 'onlineworldpay' ),
				'class' => array (
						'subItem' 
				),
				'attributes' => array (
						'parent-setting' => 'webhooks_chargeback_reversed' 
				),
				'tool_tip' => true,
				'description' => __ ( 'If enabled, you will receive an email notification when a payment has failed.', 'onlineworldpay' ) 
		),
		'add_payment_method' => array (
				'type' => 'checkbox',
				'value' => 'yes',
				'default' => 'yes',
				'title' => __ ( 'Add Payment Methods', 'onlineworldpay' ),
				'class' => array (
						'' 
				),
				'tool_tip' => true,
				'description' => __ ( 'If enabled, customers can add payment methods to their profile on the my account page.', 'onlineworldpay' ) 
		),
		'enable_3ds_secure' => array (
				'type' => 'checkbox',
				'value' => 'yes',
				'default' => 'yes',
				'title' => __ ( '3DS Secure', 'onlineworldpay' ),
				'class' => array (),
				'tool_tip' => true,
				'description' => __ ( 'If enabled and the credit card supports 3DS, your customers will be redirected to the 3DS secure site for their payment method.', 'onlineworldpay' ) 
		),
		'3ds_secure_page' => array (
				'type' => 'custom',
				'function' => 'OnlineWorldpay_Admin::getPagePostsHtml',
				'default' => 'yes',
				'title' => __ ( 'Short Code Page', 'onlineworldpay' ),
				'class' => array (
						'subItem 3dsSecure' 
				),
				'tool_tip' => true,
				'description' => __ ( 'You must place the shortcode [onlineworldpay_3ds_page] on a blank wordpress page and select it here.', 'onlineworldpay' ) 
		) 
);