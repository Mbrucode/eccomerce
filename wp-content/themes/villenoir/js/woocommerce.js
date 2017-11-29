jQuery( function( $ ) {

	// Quantity buttons
	if ( ! String.prototype.getDecimals ) {
		String.prototype.getDecimals = function() {
			var num = this,
				match = ('' + num).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
			if ( ! match ) {
				return 0;
			}
			return Math.max( 0, ( match[1] ? match[1].length : 0 ) - ( match[2] ? +match[2] : 0 ) );
		}
	}

	function villenoir_refresh_quantity_increments(){
		$( 'div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)' ).addClass( 'buttons_added' ).append( '<input type="button" value="+" class="plus" />' ).prepend( '<input type="button" value="-" class="minus" />' );
	}

	$( document ).on( 'updated_wc_div', function() {
		villenoir_refresh_quantity_increments();
	} );

	$( document ).on( 'click', '.plus, .minus', function() {
		// Get values
		var $qty		= $( this ).closest( '.quantity' ).find( '.qty'),
			currentVal	= parseFloat( $qty.val() ),
			max			= parseFloat( $qty.attr( 'max' ) ),
			min			= parseFloat( $qty.attr( 'min' ) ),
			step		= $qty.attr( 'step' );

		// Format values
		if ( ! currentVal || currentVal === '' || currentVal === 'NaN' ) currentVal = 0;
		if ( max === '' || max === 'NaN' ) max = '';
		if ( min === '' || min === 'NaN' ) min = 0;
		if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) step = 1;

		// Change the value
		if ( $( this ).is( '.plus' ) ) {
			if ( max && ( currentVal >= max ) ) {
				$qty.val( max );
			} else {
				$qty.val( ( currentVal + parseFloat( step )).toFixed( step.getDecimals() ) );
			}
		} else {
			if ( min && ( currentVal <= min ) ) {
				$qty.val( min );
			} else if ( currentVal > 0 ) {
				$qty.val( ( currentVal - parseFloat( step )).toFixed( step.getDecimals() ) );
			}
		}

		// Trigger change event
		$qty.trigger( 'change' );
	});

	villenoir_refresh_quantity_increments();
	
	//EasyZoom
	if( $('.easyzoom').length > 0 ) {

		// Instantiate EasyZoom instances
		var $easyzoom = $('.easyzoom').easyZoom();

		// Setup thumbnails example
		var api1 = $easyzoom.filter('.easyzoom--with-thumbnails').data('easyZoom');

		$('.thumbnails').on('click', 'a', function(e) {
			var $this = $(this);

			e.preventDefault();

			// Use EasyZoom's swap method
			api1.swap($this.data('standard'), $this.attr('href'), '');
		});
	}

	//Scroll to shipping fields
	if($('#ship-to-different-address-checkbox').length > 0) {
		$("#ship-to-different-address-checkbox").change(function() {
			if(this.checked) {
			    $('html,body').animate({
			        scrollTop: $(".woocommerce-shipping-fields").offset().top},
			        'slow');
			}
		});
	}

});