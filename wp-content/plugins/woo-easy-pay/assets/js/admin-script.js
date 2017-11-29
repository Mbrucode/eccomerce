/*Admin function for Online Worldpay plugin*/
function WorldpayAdmin(){
	this.construct();
}

WorldpayAdmin.prototype.construct = function(){
	this.setupEvents();
	this.displayEnvironmentFields();
}

WorldpayAdmin.prototype.setupEvents = function(){
	jQuery(document.body).on('change', '.onlineworldpay-active-environment',  this.displayEnvironmentFields);
	jQuery(document.body).on('click', '.donationColor', this.displayColorPicker);
	jQuery(document.body).on('change', '#donation_address', this.handleAddressClick);
	jQuery(document.body).on('change', '#donation_form_layout', this.displayModalOptions);
	jQuery(document.body).on('change', '#enable_paypal, #donations_paypal_enabled', this.displayPayPalButtons)
	jQuery(document.body).on('change', '.onlineworldpay-settings-td input', this.updateChildElements);
}

WorldpayAdmin.prototype.displayEnvironmentFields = function(environment, hideEnvironment){
	var environment = jQuery('.onlineworldpay-active-environment').val();
	var hideEnvironment = jQuery('.onlineworldpay-active-environment').val() === 'sandbox' ? 'production' : 'sandbox';
	jQuery('[name*="'+hideEnvironment+'"').each(function(){
		jQuery(this).closest('tr').hide();
	});
	
	jQuery('[name*="'+environment+'"').each(function(){
		jQuery(this).closest('tr').show();
	})
}

WorldpayAdmin.prototype.displayColorPicker = function(){
	jQuery('.donationColor').colorPicker();

}

WorldpayAdmin.prototype.displayModalOptions = function(){
	if(jQuery(this).val() === 'modal'){
		jQuery('.modalOption').each(function(){
			jQuery(this).closest('tr').slideDown(200);
		})
	}
	else{
		jQuery('.modalOption').each(function(){
			jQuery(this).closest('tr').slideUp(200);
		})
	}
}

WorldpayAdmin.prototype.displayPayPalButtons = function(){
	if(jQuery('#enable_paypal').is(':checked') || jQuery('#donations_paypal_enabled').is(':checked')){
		jQuery('.subItem.paypal').each(function(){
			jQuery(this).closest('tr').slideDown(200);
		})
	}
	else{
		jQuery('.subItem.paypal').each(function(){
			jQuery(this).closest('tr').slideUp(200);
		})
	}
}

WorldpayAdmin.prototype.initializeModalOptions = function(){
	if(jQuery('#donation_form_layout').val() === 'modal'){
		jQuery('.modalOption').each(function(){
			jQuery(this).closest('tr').slideDown(200);
		})
	}
	else{
		jQuery('.modalOption').each(function(){
			jQuery(this).closest('tr').slideUp(200);
		})
	}
}

WorldpayAdmin.prototype.initializeColorPickers = function(){
	jQuery('.donationColor').each(function(){
		worldpayAdmin.displayColorPicker();
	})
}

WorldpayAdmin.prototype.initializeAddressOptions = function(){
	if(jQuery('#donation_address').val() !== 'yes'){
		jQuery('.addressOption').each(function(){
			jQuery(this).closest('tr').hide();
		})
	}
}

WorldpayAdmin.prototype.handleAddressClick = function(){
	if(jQuery(this).is(':checked')){
		jQuery('.addressOption').each(function(){
			jQuery(this).closest('tr').show();
		});
	}
	else{
		jQuery('.addressOption').each(function(){
			jQuery(this).closest('tr').hide();
		});
	}
}

WorldpayAdmin.prototype.updateSubItems = function(){
	jQuery('.subItem').each(function(index){
		jQuery(this).closest('tr').addClass('tr--subItem');
	});
}

WorldpayAdmin.prototype.updateChildElements = function(){
	jQuery('.subItem').each(function(){
		var id = '#' + jQuery(this).closest('input').attr('parent-setting');
		if( jQuery(id).length > 0 && !jQuery(id).is(':checked')){
			jQuery(this).closest('tr').hide();
		}
		else{
			jQuery(this).closest('tr').show();
		}
	});
}

jQuery(document).ready(function(){
	window.worldpayAdmin = new WorldpayAdmin();
	
	worldpayAdmin.initializeColorPickers();
	worldpayAdmin.updateSubItems();
	worldpayAdmin.initializeModalOptions();
	worldpayAdmin.displayPayPalButtons();
	worldpayAdmin.initializeAddressOptions();
	worldpayAdmin.updateChildElements();
});