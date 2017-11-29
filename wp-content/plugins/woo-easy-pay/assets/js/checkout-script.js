/*Online Worldpay scripts*/
var OnlineWorldpay = function(){
	this.construct();
	this.setupEvents();
}

OnlineWorldpay.instance = function(){
	onlineWorldpay = new OnlineWorldpay();
	onlineWorldpay.maybeSetSelectedPaymentMethod();
	onlineWorldpay.cvcErrors = 0;
}

OnlineWorldpay.prototype.construct = function(){
	this.clientKey = onlineworldpay_checkout_vars.clientKey;
	this.cardTemplateCode = onlineworldpay_checkout_vars.cardTemplateCode;
	this.cvcTemplateCode = onlineworldpay_checkout_vars.cvcTemplateCode;
	this.cartContainsSubscription = onlineworldpay_checkout_vars.cartContainsSubscription === 'true' ? true : false;
	this.paypalEnabled = onlineworldpay_checkout_vars.paypalEnabled === 'true' ? true : false;
	this.setForm();
}

OnlineWorldpay.prototype.maybe_unblock_checkout_payment = function(){
	jQuery('.woocommerce-checkout-payment').unblock();
}

OnlineWorldpay.prototype.setupEvents = function(){
	jQuery('form.checkout').on('checkout_place_order', this.checkoutPlaceOrder);
	jQuery(document.body).on('change', '#onlineworldpay_save_method', this.setSavePaymentMethod);
	jQuery(document.body).on('click', '#place_order', this.submitTemplateForm);
	jQuery(document.body).on('click', '.payment-method-item.card-label', this.savedMethodSelected);
	jQuery(document.body).on('click', '#onlineworldpay_add_new', this.addNewSelected);
	jQuery(document.body).on('click', '#onlineworldpay_cancel_add_new', this.cancelAddNew);
	jQuery(document.body).on('checkout_error', this.checkoutError);
	jQuery(document.body).on('updated_checkout', this.maybe_unblock_checkout_payment);
	if(this.paypalEnabled){
		this.setupPayPalEvents();
	}
}

OnlineWorldpay.prototype.setupPayPalEvents = function(){
	jQuery(document.body).on('click', '#paypal_button', this.paypalCheckout);
}

OnlineWorldpay.prototype.setForm = function(){
	if(jQuery('form.checkout').length > 0){
		this.form = jQuery('form.checkout')[0];
		this.form.id = 'checkout';
	}
	else{
		this.form = jQuery('#order_review')[0];
	}
}

OnlineWorldpay.prototype.setupCardForm = function(){
	var attribs = {
			'clientKey': onlineWorldpay.clientKey,
			'form': onlineWorldpay.form.id,
			'paymentSection': 'onlineworldpay_dropin_container',
			'display': 'inline',
			'type': 'card',
			'saveButton': false,
			'callback': function(response){
				onlineWorldpay.onPaymentMethodReceived(response);
			}
		}
	if( onlineWorldpay.cardTemplateCode !== "" ){
		attribs.code = onlineWorldpay.cardTemplateCode;
	}
	if(onlineWorldpay.cartContainsSubscription){
		attribs.reusable = true;
	}
	else{
		attribs.reusable = document.getElementById('onlineworldpay_save_method') ? document.getElementById('onlineworldpay_save_method').checked : false;
	}
	Worldpay.useTemplateForm(attribs);
}

OnlineWorldpay.prototype.setupCVCForm = function(){
	var attribs = {
			'clientKey': onlineWorldpay.clientKey,
			'token': document.getElementById('onlineworldpay_payment_method_token').value,
			'form': onlineWorldpay.form.id,
			'paymentSection': 'onlineworldpay_cvc_container',
			'display': 'inline',
			'type': 'cvc',
			'saveButton': false,
			'validationError': function(err){
				onlineWorldpay.cvcErrors++;
				if(onlineWorldpay.cvcErrors <= 1){
					jQuery('#place_order').click();
				}
			},
			'callback': function(response){
				onlineWorldpay.onPaymentMethodReceived(response);
			}	
	}
	if( onlineWorldpay.cvcTemplateCode !== ""){
		attribs.code = onlineWorldpay.cvcTemplateCode;
	}
	Worldpay.useTemplateForm(attribs);
}

OnlineWorldpay.prototype.paypalCheckout = function(e){
	Worldpay.tokenType = 'apm';
	if(onlineWorldpay.cartContainsSubscription){
		Worldpay.reusable = true;
	}
	Worldpay.setClientKey(onlineWorldpay.clientKey);
	onlineWorldpay.updatePayPalBillingCountry();
	onlineWorldpay.selectedPaymentMethod = false;
	Worldpay.useForm(onlineWorldpay.form, function(status, response){
		onlineWorldpay.onPaymentMethodReceived(response);
	});
}

OnlineWorldpay.prototype.onPaymentMethodReceived = function(response){
	if(onlineWorldpay.paymentMethodReceived){
		return;
	}
	if(onlineWorldpay.selectedPaymentMethod){
		onlineWorldpay.paymentMethodReceived= true;
		jQuery(onlineWorldpay.form).submit();
	}
	else{
		if( response && response.token ){
			onlineWorldpay.paymentMethodReceived = true;
			
			onlineWorldpay.updateTokenType(response.paymentMethod.type);
			
			var element = document.getElementById('onlineworldpay_payment_method_token');
			if(element){
				element.value = response.token;
			}
			else{
				element = document.createElement('input');
				element.type = 'hidden';
				element.name = 'onlineworldpay_payment_method_token';
				element.id = 'onlineworldpay_payment_method_token';
				element.value = response.token;
				jQuery(onlineWorldpay.form).append(element);
			}
			jQuery(onlineWorldpay.form).submit();
		}
	}
}

OnlineWorldpay.prototype.updateTokenType = function(type){
	var element = document.getElementById('onlineworldpay_token_type');
	if(element){
		element.value = type;
	}
	else{
		element = document.createElement('input');
		element.type = 'hidden';
		element.name = 'onlineworldpay_token_type';
		element.id = 'onlineworldpay_token_type';
		element.value = type;
		jQuery(onlineWorldpay.form).append(element);
	}
}

OnlineWorldpay.prototype.checkoutPlaceOrder = function(){
	if(onlineWorldpay.isGatewaySelected()){
		if(onlineWorldpay.paymentMethodReceived){
			return true;
		}
		else{
			return false;
		}
	}
}

OnlineWorldpay.prototype.setSavePaymentMethod = function(){
	if(onlineWorldpay.selectedPaymentMethod){
		return;
	}
	onlineWorldpay.setupCardForm();
}
OnlineWorldpay.prototype.isGatewaySelected = function(){
	return document.getElementById('payment_method_online_worldpay_gateway').checked;
}
OnlineWorldpay.prototype.submitTemplateForm = function(e){
	if(onlineWorldpay.isGatewaySelected()){
		e.preventDefault();
		Worldpay.submitTemplateForm();
	}
}

OnlineWorldpay.prototype.savedMethodSelected = function(){
	jQuery('.payment-method-item.card-label').each(function(){
		jQuery(this).removeClass('selected');
	});
	jQuery(this).addClass('selected');
	onlineWorldpay.updateSelectedPaymentMethod(onlineWorldpay.getSelectedPaymentMethodKey());
	onlineWorldpay.setupCVCForm();
}

OnlineWorldpay.prototype.maybeSetSelectedPaymentMethod = function(){
	if( onlineWorldpay.hasSavedMethods()){
		onlineWorldpay.updateSelectedPaymentMethod(this.getSelectedPaymentMethodKey());
		onlineWorldpay.setupCVCForm();
		
	}
	else{
		onlineWorldpay.setupCardForm();
	}
}

OnlineWorldpay.prototype.checkoutError = function(){
	onlineWorldpay.paymentMethodReceived = false;
}

OnlineWorldpay.prototype.updateSelectedPaymentMethod = function(value, type){
	onlineWorldpay.selectedPaymentMethod = true;
	onlineWorldpay.updatePaymentMethodToken(value);
	var text = jQuery('.payment-method-item.card-label.selected .payment-method-description').text();
	jQuery('.onlineworldpay-cvc-description').text(text);
}

OnlineWorldpay.prototype.updatePaymentMethodToken = function(value, type){
	jQuery('#onlineworldpay_payment_method_token').val(value);
}

OnlineWorldpay.prototype.getSelectedPaymentMethodKey = function(){
	return jQuery('.payment-method-item.card-label.selected').attr('token');
}

OnlineWorldpay.prototype.hasSavedMethods = function(){
	return jQuery('#onlineworldpay_saved_methods').length > 0;
}

OnlineWorldpay.prototype.addNewSelected = function(){
	onlineWorldpay.setupCardForm();
	onlineWorldpay.selectedPaymentMethod = false;
	onlineWorldpay.hideSavedMethods();
	onlineWorldpay.displayCardForm()
}

OnlineWorldpay.prototype.displaySavedMethods = function(){
	jQuery('#onlineworldpay_saved_methods').slideDown(400);
}

OnlineWorldpay.prototype.displayCardForm = function(){
	jQuery('#onlineworldpay_container').slideDown(400);
}

OnlineWorldpay.prototype.displayCancelAddNewButton = function(){
	jQuery('#onlineworldpay_cancel_add_new').closest('div').slideDown(400);
}

OnlineWorldpay.prototype.hideSavedMethods = function(){
	jQuery('#onlineworldpay_saved_methods').slideUp(400);
}

OnlineWorldpay.prototype.hideCardForm = function(){
	jQuery('#onlineworldpay_container').slideUp(400);
}

OnlineWorldpay.prototype.hideCancelAddNewButton = function(){
	jQuery('#onlineworldpay_cancel_add_new').closest('div').slideUp(400);
}

OnlineWorldpay.prototype.cancelAddNew = function(){
	onlineWorldpay.hideCardForm();
	onlineWorldpay.displaySavedMethods();
	onlineWorldpay.selectedPaymentMethod = true;
	onlineWorldpay.updatePaymentMethodToken(onlineWorldpay.getSelectedPaymentMethodKey());
	jQuery('#onlineworldpay_dropin_container').empty();
	jQuery('#onlineworldpay_cvc_container').empty();
	onlineWorldpay.setupCVCForm();
}

OnlineWorldpay.prototype.updatePayPalBillingCountry = function(){
	jQuery('#country-code').val(jQuery('#billing_country').val());
}

var onlineWorldpay = null;
OnlineWorldpay.instance();
