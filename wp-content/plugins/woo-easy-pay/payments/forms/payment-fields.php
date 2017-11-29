<?php
?>
<input type="hidden" id="onlineworldpay_payment_method_token"
	name="onlineworldpay_payment_method_token" value="" />

<?php if( owp_manager()->getEnvironment() === 'sandbox' ){?>
<div class="onlineworldpay-active-environment"><?php echo __('Test Mode', 'onlineworldpay')?></div>
<?php }?>
		
		<?php WC_OnlineWorldpay::getPaymentMethodIcons()?>
		<?php WC_OnlineWorldpay::getPayPalButton()?>
<div id="onlineworldpay_container" style="display: <?php echo owp_manager()->customerHasPaymentMethods( wp_get_current_user()->ID ) ? 'none' : 'block'?>">
	<div class="online-worldpay-row">
		<?php WC_OnlineWorldpay::getSavePaymentMethodCheckBox()?>
			
		<?php if( owp_manager()->customerHasPaymentMethods( wp_get_current_user()->ID )){?>
		<div class="payment-method-button">
			<span id="onlineworldpay_cancel_add_new"><?php echo __('Cancel', 'onlineWorldpay')?></span>
		</div>
		<?php }?>
	</div>
	<div id="onlineworldpay_dropin_container"></div>
</div>

<?php WC_OnlineWorldpay::getCustomerPaymentMethods( wp_get_current_user()->ID )?>

<script>
	jQuery(document).ready(function(){
		jQuery(document.body).trigger('online_worldpay_ready');
	});
</script>
