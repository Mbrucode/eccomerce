<input type="hidden" id="onlineworldpay_payment_method_token"
	name="onlineworldpay_payment_method_token" value="" />
<?php if( owp_manager()->getEnvironment() === 'sandbox' ){?>
<div class="onlineworldpay-active-environment"><?php echo __('Test Mode', 'onlineworldpay')?></div>
<?php
}
WC_OnlineWorldpay::getPaymentMethodIcons ()?>
<div id="onlineworldpay_container">
	<div id="onlineworldpay_dropin_container"></div>
</div>