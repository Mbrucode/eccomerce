var OnlineWorldpay = function() {
	this.initializeVariables();
	this.setForm();
	this.events();
	this.setupTemplate();
};

OnlineWorldpay.instance = function() {
	window.onlineWorldpay = new OnlineWorldpay();
}

OnlineWorldpay.prototype.initializeVariables = function() {
	this.clientKey = onlineworldpay_add_payment_vars.clientKey;
	this.cardTemplateCode = onlineworldpay_add_payment_vars.cardTemplateCode;
}

OnlineWorldpay.prototype.events = function(e) {
	jQuery(this.form).on('submit', this.validate);
	jQuery(document.body).on('click', '#place_order', this.submitTemplateForm);
}

OnlineWorldpay.prototype.setForm = function() {
	this.form = jQuery('#add_payment_method')[0];
}

OnlineWorldpay.prototype.submitTemplateForm = function(e) {
	if (onlineWorldpay.isSelected()) {
		e.preventDefault();
		Worldpay.submitTemplateForm();
	}
}

OnlineWorldpay.prototype.validate = function(e) {
	if (onlineWorldpay.isSelected()) {
		if (onlineWorldpay.paymentMethodReceived) {
			return true;
		} else {
			return false;
		}
	}
}

OnlineWorldpay.prototype.isSelected = function() {
	return jQuery('#payment_method_online_worldpay_gateway').is(':checked');
}

OnlineWorldpay.prototype.setupTemplate = function() {
	var attribs = {
		'clientKey' : this.clientKey,
		'form' : this.form.id,
		'paymentSection' : 'onlineworldpay_dropin_container',
		'display' : 'inline',
		'type' : 'card',
		'reusable' : true,
		'saveButton' : false,
		'callback' : function(response) {
			onlineWorldpay.onPaymentMethodReceived(response);
		}
	}
	if (this.cardTemplateCode !== "") {
		attribs.code = this.cardTemplateCode;
	}
	Worldpay.useTemplateForm(attribs);
}

OnlineWorldpay.prototype.onPaymentMethodReceived = function(response) {
	if (onlineWorldpay.paymentMethodReceived) {
		return;
	}

	if (response && response.token) {
		onlineWorldpay.paymentMethodReceived = true;

		var element = document
				.getElementById('onlineworldpay_payment_method_token');
		if (element) {
			element.value = response.token;
		} else {
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

jQuery(document.body).on('init_add_payment_method', OnlineWorldpay.instance);