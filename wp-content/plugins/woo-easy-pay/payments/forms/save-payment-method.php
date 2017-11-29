<?php
if (owp_manager ()->woocommerceSubscriptionsActive () && WC_Subscriptions_Cart::cart_contains_subscription ()) { // If the cart contains subscriptions, don't show the save payment method checkbox since it's set to true as default.
	return;
}
if (! wp_get_current_user ()->ID) {
	return;
}
?>
<label class="save-payment-method-label"> <span class="save-cc-helper"><?php echo __('Save', 'onlineworldpay')?></span>
	<div class="save-payment-method">
		<input type="checkbox" id="onlineworldpay_save_method"
			name="onlineworldpay_save_method"><label
			for="onlineworldpay_save_method"></label>
	</div>
</label>
