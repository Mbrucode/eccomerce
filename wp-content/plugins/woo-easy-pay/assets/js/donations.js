var OnlineWorldpay_Donations = function(){
	this.clientKey = onlineworldpay_donation_vars.clientKey;
	this.cardTemplateCode = onlineworldpay_donation_vars.cardTemplateCode;
	this.ajax_url = onlineworldpay_donation_vars.ajax_url;
	this.form = jQuery('#donation_form')[0];
	this.paypalEnabled = onlineworldpay_donation_vars.paypalEnabled === 'true' ? true : false;
	this.setupEvents();
	this.addInvalidFieldsHTML();
}

OnlineWorldpay_Donations.prototype.setupEvents = function(){
	jQuery(document.body).on('click', '#modal_button', this.modalButtonClicked);
	jQuery(document.body).on('click', '#cancel_donation', this.cancelDonationClicked);
	jQuery(document.body).on('keyup', '#donation_form input', this.clearInvalidEntries)
	jQuery(document.body).on('click', '.submit-donation', this.submitTemplateForm);
	jQuery(document.body).on('submit', this.validatePaymentSubmit);
	if(this.paypalEnabled){
		this.setupPaypalEvents();
	}
}

OnlineWorldpay_Donations.prototype.setupPaypalEvents = function(){
	jQuery(document.body).on('click', '#donation_paypal_button', this.paypalClicked);
}

OnlineWorldpay_Donations.prototype.displayDonationForm = function(callback){
	worldpayDonation.displayOverlay(callback);
}

OnlineWorldpay_Donations.prototype.modalButtonClicked = function(){
	worldpayDonation.displayDonationForm();
}

OnlineWorldpay_Donations.prototype.setupCardForm = function(){
	var attribs = {
			'clientKey': worldpayDonation.clientKey,
			'form': worldpayDonation.id,
			'paymentSection': 'hosted_container',
			'display': 'inline',
			'type': 'card',
			'reusable': false,
			'saveButton': false,
			'callback': function(response){
				worldpayDonation.onPaymentMethodReceived(response);
			}
	}
	if( worldpayDonation.cardTemplateCode !== "" ){
		attribs.code = worldpayDonation.cardTemplateCode;
	}
	Worldpay.useTemplateForm(attribs);
}

OnlineWorldpay_Donations.prototype.onPaymentMethodReceived = function(response){
	if(response && response.token){
		worldpayDonation.paymentMethodReceived = true;
		worldpayDonation.updateTokenType(response.paymentMethod.type)
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
			jQuery(worldpayDonation.form).append(element);
		}
		worldpayDonation.submitPayment();
	}
}

OnlineWorldpay_Donations.prototype.paypalClicked = function(e){
	if(worldpayDonation.validateInputFields()){
		Worldpay.reusable = false;
		Worldpay.tokenType = 'apm';
		Worldpay.setClientKey(worldpayDonation.clientKey);
		worldpayDonation.updatePayPalBillingCountry();
		Worldpay.useForm(worldpayDonation.form, function(status, response){
			worldpayDonation.onPaymentMethodReceived(response);
		});
	}
}

OnlineWorldpay_Donations.prototype.submitTemplateForm = function(e){
	e.preventDefault();
	if(worldpayDonation.validateInputFields()){
		Worldpay.submitTemplateForm();
	}
}

OnlineWorldpay_Donations.prototype.updatePayPalBillingCountry = function(){
	jQuery('#country-code').val(jQuery('#billing_country').val());
}

OnlineWorldpay_Donations.prototype.updateTokenType = function(type){
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
		jQuery(worldpayDonation.form).append(element);
	}
}

OnlineWorldpay_Donations.prototype.displayOverlay = function(callback){
	jQuery('.onlineworldpay-modal-container').fadeIn(400, callback);
}

OnlineWorldpay_Donations.prototype.hideOverlay = function(callback){
	jQuery('.onlineworldpay-modal-container').fadeOut(400, callback);
}

OnlineWorldpay_Donations.prototype.cancelDonationClicked = function(){
	worldpayDonation.hideOverlay();
	worldpayDonation.clearErrorMessages();
}

/*Validate the inputs*/
OnlineWorldpay_Donations.prototype.validateInputFields = function(){
	var hasFailures = false;
	jQuery('#donation_form input[type="text"]').each(function(){
		if(jQuery(this).val() === ""){
			jQuery(this).parent().find('div.invalid-input-field').show().addClass('active');
			hasFailures = true;
		}
	});
	if(! hasFailures){
		return true;
	}
}

OnlineWorldpay_Donations.prototype.donationFormSubmit = function(){
	jQuery(document.body).trigger('donation_payment_placed');
}

OnlineWorldpay_Donations.prototype.validatePaymentSubmit = function(){
	if(worldpayDonation.paymentMethodReceived){
		return true;
	}
	else{
		return false;
	}
}

OnlineWorldpay_Donations.prototype.addInvalidFieldsHTML = function(){
	jQuery('#donation_form input').each(function(){
		if(jQuery(this).val() === ""){
			jQuery(this).parent().prepend('<div class="invalid-input-field"></div>');
		}
	});
}

OnlineWorldpay_Donations.prototype.clearInvalidEntries = function(){
	jQuery(this).parent().find('div.invalid-input-field').hide().removeClass('active');
}

OnlineWorldpay_Donations.prototype.clearErrorMessages = function(){
	jQuery('#error_messages').empty();
}

OnlineWorldpay_Donations.prototype.showErrorMessage = function(message){
	jQuery('#error_messages').html(message);
}

OnlineWorldpay_Donations.prototype.redirect = function(url){
	window.location = url;
}

OnlineWorldpay_Donations.prototype.submitPayment = function(){
	var data = jQuery('#donation_form').serialize();
	var url = worldpayDonation.ajax_url;
	jQuery('.overlay-payment-processing').fadeIn();
	jQuery.ajax({
			type:'POST',
			url: url,
			dataType: 'json',
			data: data
	}).done(function(response){
		jQuery('.overlay-payment-processing').fadeOut();
		if(response.result === 'success'){
			worldpayDonation.redirect(response.url);
		}
		else{
			worldpayDonation.showErrorMessage(response.message);
		}
	}).fail(function(response){
		jQuery('.overlay-payment-processing').fadeOut();
		worldpayDonation.showErrorMessage(response.message);
	});
}

var worldpayDonation = new OnlineWorldpay_Donations();
worldpayDonation.setupCardForm();

