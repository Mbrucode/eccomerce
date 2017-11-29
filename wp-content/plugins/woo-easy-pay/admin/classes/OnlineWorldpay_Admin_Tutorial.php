<?php
class OnlineWorldpay_Admin_Tutorial{


	/**
	 * Display the tutorials page.
	 */
	public static function showTutorialsView(){
		OnlineWorldpay_Admin::getAdminHeader();
		self::tutorialsHeader();
		self::apiKeys();
		self::woocommerce();
		self::subscriptions();
		self::webhooks();
	}

	public static function tutorialsHeader(){
		?>
		<div class="div--tutorialHeader">
		  <ul>
		    <li><a tutorial-container="api_keys" href="#"><?php echo __('API Keys', 'onlineworldpay')?></a></li>
		  	<li><a tutorial-container="woocommerce" href="#"><?php echo __('WooCommerce Config', 'onlineworldpay')?></a></li>
		  	<li><a tutorial-container="subscriptions" href="#"><?php echo __('Subscriptions', 'onlineworldpay')?></a></li>
		  	<li><a tutorial-container="webhooks" href="#"><?php echo __('Webhooks', 'onlineworldpay')?></a></li>
		  </ul>
		</div>
		<?php
	}
	
	public static function apiKeys(){
		?>
		<div id="api_keys" class="onlineworldpay-explanation-container display">
	      <div class="div--title">
			<h2><?php echo __('API Keys Configuration', 'onlineworldpay')?></h2>
			  </div>
				 <div class="explanation">
				    <div><strong><?php echo __('API Keys: ', 'braintree')?></strong>
				      <?php echo __('The API Keys are used to communicate securely with Online Worldpay from your Wordpress site. In order for the plugin to send and receive data to and from Worldpay, 
				      		it is required that you add your API keys.', 'onlineworldpay')?>
				    </div>
				 </div>
				 <div class="explanation">
				      <?php echo __('To access your API Keys, login to your <a target="_blank" href="https://online.worldpay.com">Online Worldpay</a> account and click <strong>Settings</strong> > <strong>API Keys</strong>.' 
				      		.'"></a>', 'braintree')?>
				 </div>
				<div class="explanation-img"><img src="<?php echo 'https://tutorials.paymentplugins.com/woo-easy-pay/images/api-keys.png'?>"/></div>
				<div>
				  <p><?php echo __('Copy and paste the Merchant ID, Client Key, and Service Key into the <a target="_blank" href="'.admin_url().'admin.php?page=onlineworldpay-payment-settings'.'">API Settings</a> page.', 'onlineworldpay')?></p>
				  <div class="explanation-img"><img src="<?php echo 'https://tutorials.paymentplugins.com/woo-easy-pay/images/api-keys-settings.png'?>"/></div>
				</div>
		</div>
		<?php 
	}
	
	public static function woocommerce(){
		?>
		<div id="woocommerce" class="onlineworldpay-explanation-container">
		  <div class="div--title">
		    <h2><?php echo __('WooCommerce Config', 'onlineworldpay')?></h2>
		  </div>
		  <div class="explanation">
		      <?php echo __('In order to start using Online Worldpay on your Wordpress site there are several options that need to be configured for WooCommerce. ', 'braintree')?>
		  </div>
	      <div class="explanation">
	        <h4><?php echo __('Enable OnlineWorldpay', 'onlineworldpay')?></h4>
	        <p><?php echo __('By clicking this checkbox and saving, OnlineWorldpay will be an available payment options on your WooCommerce checkout page.')?></p>
	      </div>
		  <div class="explanation">
		    <h4><?php echo __('Enable PayPal', 'onlineworldpay')?></h4>
		    <p><?php echo __('If you wish to offer PayPal as a payment option, you can select the chcekbox. If enabled, you must be sure and link your PayPal account with your Online Worldpay account. 
		    		Instructions on how to configure PayPal can be found on the <a target="_blank" href="https://online.worldpay.com/docs/paypal">Online Worldpay site</a>. PayPal is enabled by default in Test Mode.')?></p>
		  </div>
		  <div class="explanation">
		    <h4><?php echo __('Settlement Currency', 'onlineworldpay')?></h4>
		    <p><?php echo __('The settlement currency is the currency that you are paid in by Worldpay. An in depth explanation of <a target="_blank" href="https://online.worldpay.com/support/articles/how-do-i-add-settlement-currencies-to-my-account">settlement currency</a> can be found on the 
		    		<a target="_blank: href="https://online.worldpay.com/support/articles/how-do-i-add-settlement-currencies-to-my-account">Online Worldpay</a> site.', 'onlineworldpay')?></p>
		  </div>
		  <div class="explanation">
		    <h4><?php echo __('Title Text', 'onlineworldpay')?></h4>
		    <p><?php echo __('The title text is the text that will appear next to the Online Worldpay payment options on the checkout page.', 'onlineworldpay')?></p>
		  </div>
		  <div class="explanation">
		    <h4><?php echo __('Order Status', 'onlineworldpay')?></h4>
		    <p><?php echo __('The order status is the status that is assigned to the order when the payment is successful. Merchants that ship goods typically will set this value to Processing and when the item ships they will update the status to Complete.', 'onlineworldpay')?></p>
		  </div>
		  <div class="explanation">
		    <h4><?php echo __('Order Prefix', 'onlineworldpay')?></h4>
		    <p><?php echo __('The order prefix is an optional text that can be prepended to the beggining of an orderCode. It is a way to add unique identifiers to your orders.', 'onlineworldpay')?></p>
		  </div>
		  <div class="explanation">
		    <h4><?php echo __('Order Suffix', 'onlineworldpay')?></h4>
		    <p><?php echo __('The order suffix is an optional text that can be appended to the end of an orderCode. It is a way to add unique identifiers to your orders.', 'onlineworldpay')?></p>
		  </div>
		  <div class="explanation">
		    <h4><?php echo __('Order Description', 'onlineworldpay')?></h4>
		    <p><?php echo __('The order description is an optional text that is added to the order. Information about where the order came from, etc can be used here.', 'onlineworldpay')?></p>
		  </div>
		  <div class="explanation">
		    <h4><?php echo __('Display Payment Methods', 'onlineworldpay')?></h4>
		    <p><?php echo __('By selecting the payment method checkboxes, the icon for the payment method will display on the checkout form. This is a good way to show customers what payment methods you accept.', 'onlineworldpay')?></p>
		  </div>
		</div>
		<?php 
	}
	
	public static function subscriptions(){
		?>
		<div id="subscriptions" class="onlineworldpay-explanation-container">
		  <div class="div--title">
		    <h2><?php echo __('WooCommerce Subscription Config', 'onlineworldpay')?></h2>
		  </div>
		  <div class="explanation">
		      <?php echo __('In order to sell subscriptions, you must have the <a target="_blank" href="https://www.woothemes.com/products/woocommerce-subscriptions/">WooCommerce Subscriptions</a> plugin installed.', 'onlineworldpay')?>
		  </div>
		  <div class="explanation">
		    <h4><?php echo __('Subscription Prefix', 'onlineworldpay')?></h4>
		    <p><?php echo __('This optional text will be appended to the beginning of the transaction id. <strong>Example:</strong> subscription_6456-3454', 'onlineworldpay')?></p>
		  </div>
		  <div class="explanation">
		    <h4><?php echo __('Subscription Suffix', 'onlineworldpay')?></h4>
		    <p><?php echo __('This optional text will be appended to the end of the transaction id. <strong>Example:</strong> subscription_6456-3454_widgets', 'onlineworldpay')?></p>
		  </div>
		  <div class="explanation">
		    <h4><?php echo __('Subscription Description', 'onlineworldpay')?></h4>
		    <p><?php echo __('You can provide a description which will appear on the order within Worldpay. This can be a good way to distinguish orders from your site or to add extra information.', 'onlineworldpay')?></p>
		  </div>
		  <div class="explanation">
		    <h4><?php echo __('Subscription Status - Payment Success', 'onlineworldpay')?></h4>
		    <p><?php echo __('This is the status that the WooCommerce Subscription will be set to if the payment is successful during checkout.', 'onlineworldpay')?></p>
		  </div>
		  <div class="explanation">
		    <h4><?php echo __('Subscription Status - Failed', 'onlineworldpay')?></h4>
		    <p><?php echo __('This is the status that the WooCommerce Subscription will be set to if the recurring payment fails.', 'onlineworldpay')?></p>
		  </div>
		  <div class="explanation">
		    <h4><?php echo __('Subscription Status - Cancelled', 'onlineworldpay')?></h4>
		    <p><?php echo __('This is the status that the WooCommerce Subscription will be set to if the subscription is cancelled.', 'onlineworldpay')?></p>
		  </div>
		</div>
		<?php 
	}
	
	public static function webhooks(){
		?>
		<div id="webhooks" class="onlineworldpay-explanation-container">
		  <div class="div--title">
			 <h2><?php echo __('Webhook Configuration', 'onlineworldpay')?></h2>
		  </div>
		  <div class="explanation">
		    <div><strong><?php echo __('Webhooks: ', 'onlineworldpay')?></strong>
		    <?php echo __('Online Worldpay has the ability to send Webhook notifications to your server whenever an event related to an order has occurred. This is a great way to track your orders and update the status of orders 
		    		based on the different payment statuses. In order to enable webhooks, there are several configruation steps that you must complete.', 'onlineworldpay')?>
		    </div>
		  </div>
		  <div class="explanation">
		    <div><h4><?php echo __('Step 1: Create Webhooks')?></h4></div>
		    <p><?php echo __('The first step is to create a webhooks. Login to your <a target="_blank" href="">Online Worldpay</a> account and navigate to <strong>Settings</strong> > <strong>Webhooks</strong>.')?></p>
		    <div class="explanation-img"><img src="https://tutorials.paymentplugins.com/woo-easy-pay/images/webhooks.png"/></div>
		    <p><?php echo __('Now click the <strong>Add Webhook</strong> button. You will see a popup where you can paste your webhook url which can be located on the 
		    		<a target="_blank" href="' . admin_url() . 'admin.php?page=onlineworldpay-webhooks-page">Webhooks Settings</a> page of the plugin. Also, ensure you have enabled webhooks.', 'onlineworldpay')?></p>
		    <div class="explanation-img"><img src="https://tutorials.paymentplugins.com/woo-easy-pay/images/webhooks-settings.png"/></div>
		  </div>
		  <div>
		    <div><h4><?php echo __('Step 2: Test Connection', 'onlineworldpay')?></h4></div>
		    <p><?php echo __('The next step is to perform a connection test to ensure your url is working properly. Online Worldpay requires that the webhook url uses https. Click the <strong>Test</strong> link and a pop will appear. 
		    		Select the type of webhook to test from the drop down and click test. When the tests completes, the response code will be visible. 200 means the connection test was successull. If you receive a 400, make sure you have enabled webhooks in the plugin configuration.')?></p>
		  	<div class="explanation-img"><img src="https://tutorials.paymentplugins.com/woo-easy-pay/images/webhooks-test.png"/></div>
		  </div>
		  <div class="explanation">
		    <div><h4><?php echo __('Step 3: Check Debug Log', 'onlineworldpayl')?></h4></div>
		    <p><?php echo __('When performing the connection test, messages will be written to the debug log. Ensure the debug log is enabled before running your test. After performing the connetion test, check the debug log for details.')?></p>
		  	<div class="explanation-img"><img src="https://tutorials.paymentplugins.com/woo-easy-pay/images/webhooks-debug.png"/></div>
		  </div>
		</div>
		<?php 
	}
}