jQuery(document).ready(function($) {

	$( '.menu-item.menu-item-depth-0' ).each(function() {

		var $container = $(this);

		var menu_type_wrapper      = $container.find('.gg-menu-type');
		var columns_wrapper        = $container.find('.gg-menu-columns');
		var force_megamenu_wrapper = $container.find('.gg-force-megamenu');

		var menu_type          = $container.find('.gg-menu-type select');
		var menu_type_selected = $container.find('.gg-menu-type select option[value="wide"]');
		var columns            = $container.find('.gg-menu-columns select');
		var force_megamenu     = $container.find('.gg-force-megamenu input');


		force_megamenu_wrapper.css('display', 'none');
		columns_wrapper.css('display', 'none');

		//Menu type
		if (menu_type_selected.attr('selected')) {

			force_megamenu_wrapper.css('display', 'block');
			columns_wrapper.css('display', 'block');
		}

		menu_type.change( function() {
			if( $(this).val() == 'wide') {
				force_megamenu_wrapper.css('display', 'block');
				columns_wrapper.css('display', 'block');
			} else {
				force_megamenu_wrapper.css('display', 'none');
				columns_wrapper.css('display', 'none');
			}
		});

		//Force megamenu
		if (force_megamenu.is(':checked')) {
			columns_wrapper.css('display', 'none');
		} else {
			if ( menu_type.val() == 'wide' ) {
				columns_wrapper.css('display', 'block');
			} else {
				columns_wrapper.css('display', 'none');
			}
			
		}

		force_megamenu.change( function() {
			if (force_megamenu.is(':checked')) {
				columns_wrapper.css('display', 'none');
			} else {
				columns_wrapper.css('display', 'block');
			}
		});

	}); //each

});