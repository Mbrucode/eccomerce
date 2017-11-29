(function ($) {
"use strict";

function gg_isotope_init() {

	if($('.el-grid:not(.gg-slick-carousel)').length > 0){
	    var layout_modes = {
	        fitrows: 'fitRows',
	        masonry: 'masonry'
	    }
	    jQuery('.gg_posts_grid').each(function(){
	        var $container = jQuery(this);
	        var $thumbs = $container.find('.el-grid:not(.gg-slick-carousel):not([data-layout-mode="list"])');
	        var layout_mode = $thumbs.attr('data-layout-mode');
	        
	        $thumbs.isotope({
	            // options
	            itemSelector : '.isotope-item',
	            layoutMode : (layout_modes[layout_mode]==undefined ? 'fitRows' : layout_modes[layout_mode]),
	        });


			//Isotope filter
	        if($container.find('.gg_filter:not(.gg-slick-carousel)').length > 0){
		        $container.find('.gg_filter:not(.gg-slick-carousel) a').data('isotope', $thumbs).on('click', function(e) {
		            e.preventDefault();
		            var $thumbs = jQuery(this).data('isotope');
		            jQuery(this).parent().parent().find('.active').removeClass('active');
		            jQuery(this).parent().addClass('active');
		            $thumbs.isotope({filter: jQuery(this).attr('data-filter')});
		        });
	    	}

	        jQuery(window).on('load resize', function() {
				$thumbs.imagesLoaded( function() {
				 	$thumbs.isotope('layout');
				});
	        });

	    });
	}
}

/* Magnific */
function gg_magnific_init() {
	if($('.el-grid:not(.no_magnific), .gg-slick-carousel.has_magnific, .wpb_image_grid.has_magnific, .wpb_single_image.has_magnific, .post-thumbnail.has_magnific, .size-guide-wrapper.has_magnific, .gg-contact-template').length > 0){
		$( '.el-grid:not(.no_magnific), .gg-slick-carousel.has_magnific, .wpb_image_grid.has_magnific, .wpb_single_image.has_magnific, .post-thumbnail.has_magnific, .size-guide-wrapper.has_magnific, .gg-contact-template' ).each(function(){
			$(this).magnificPopup({
				delegate: 'a.lightbox-el',
				type: 'image',
				gallery: {
		            enabled: true
		        },
				callbacks: {
				    elementParse: function(item) {
				    	if(item.el.context.className == 'lightbox-el link-wrapper lightbox-video') {
				        	item.type = 'iframe';
				    	} else if(item.el.context.className == 'lightbox-el gg-popup') {
				        	item.type = 'inline';
				        } else {
				        	item.type = 'image';
				      	}
				    }
				}
			});
		});
	}
}

/* SlickCarousel */
function gg_slickcarousel_init() {
	if($('.gg-slick-carousel:not(.gg_filter)').length > 0){
		$( '.gg-slick-carousel:not(.gg_filter)' ).each(function(){

			var $this = $(this);

			//Initialize slick
			//$this.slick();
			
			var filtered = false;

			$('.gg_filter.gg-slick-carousel a').on('click', function(e){
				e.preventDefault();
				$(this).parent().parent().find('.active').removeClass('active');
				$(this).parent().addClass('active');

		        var gg_filter = $(this).parent().parent().parent().parent().find('.el-grid.gg-slick-carousel');

		        console.log(gg_filter);

		        if ($(this).attr('data-filter') == '*') {
			      	gg_filter.slick('slickUnfilter');
			      	gg_filter.slick('slickGoTo',0);
				    filtered = false;
			    } else {
				  	gg_filter.slick('slickFilter',$(this).attr('data-filter'));
				  	gg_filter.slick('slickGoTo',0);
				    filtered = true;
			    } 
			});

			//Refresh and animate the carousel from the megamenu
			$( ".navbar-default .navbar-nav > li.is-megamenu > a" ).on( "click", function() {
				var cur_slider = $(this).parent().find('.gg-slick-carousel');
				cur_slider.css({"opacity": 0});
				cur_slider.resize().animate({opacity: 1}, 1000);
			});

		});

	}
}



/* Counter */
function gg_counter_init(){
	if($('.counter').length > 0){
		jQuery('.counter-holder').waypoint(function() {
			$('.counter').each(function() {
				if(!$(this).hasClass('initialized')){
					$(this).addClass('initialized');
					var $this = $(this),
					countToNumber = $this.attr('data-number'),
					refreshInt = $this.attr('data-interval'),
					speedInt = $this.attr('data-speed');

					$(this).countTo({
						from: 0,
						to: countToNumber,
						speed: speedInt,
						refreshInterval: refreshInt
					});
				}
			});
		}, { offset: '85%' });
	}
}

$(document).ready(function () {

	gg_slickcarousel_init();
    gg_magnific_init();
    gg_counter_init();
    gg_isotope_init();

    //When megamenu enable location.href for submenu
    $('.navbar-nav > li.is-megamenu > .dropdown-menu > li a.dropdown-toggle').on('click', function() {
        location.href = this.href;
    });

    //WPML menu
    if ($('.sub-menu.submenu-languages').length > 0)  {
    	var submenu = $('.sub-menu.submenu-languages');
    	var menu = submenu.parent();

    	menu.addClass('gg-wpml-menu');
    	menu.find('a').addClass('dropdown-toggle').attr('data-toggle', 'dropdown');
    	submenu.addClass('dropdown-menu noclose');
    }

    //Hover navbar
	function hoverNavbar() {
		if ( $(window).width() > 992 && !$('body').hasClass('gg-theme-is-mobile') ) {
			
			$('.navbar-default .dropdown, .navbar-default .dropdown-submenu').on('mouseover', function(){
				$(this).addClass('open');

			}).on('mouseout', function(){
				$(this).removeClass('open');
			});
			
			$('.dropdown-toggle').on('click', function() {
				if ($(this).next('.dropdown-menu').is(':visible')) {
					window.location = $(this).attr('href');
				}
			});
		}
		else {
			$('.navbar-default .dropdown').off('mouseover').off('mouseout');
		}
	}
	//Load, resize, added to cart
	$(window).bind("load resize added_to_cart",function(e){
	 	hoverNavbar();
	});

	/* Slider under header */
	function gg_slider_position() {
		var header_nav = $('header nav.navbar');
		if( $('body').hasClass('gg-slider-is-beneath_header') ) {
			var headerHeight = header_nav.height();
			var revSlider = $('header .subheader-slider').first();
			revSlider.css({
				'marginTop' : - headerHeight
			});
		}
	}

	//Load, resize, added to cart
	$(window).bind("load resize",function(e){
	 	gg_slider_position();
	});
    

    //Sticky menu
    function gg_sticky_menu() {
		if($('body.gg-has-stiky-menu').length > 0) {
			var main_menu = $('header.site-header .navbar');
			var main_menu_height = main_menu.outerHeight();

			if($('body.admin-bar').length > 0) {
				var admin_bar = 31;
			} else {
				var admin_bar = 0;
			}


       		$(window).on('scroll', function () {

       			if ($(this).scrollTop() > main_menu_height) {

       				main_menu.addClass('navbar-fixed-top');
       				$('body.gg-has-stiky-menu').css('padding-top', main_menu_height +'px');

       				setTimeout(function() {
					    $('header.site-header .navbar.navbar-fixed-top').css('top', admin_bar +'px');
					}, 500);

       			} else {

       				main_menu.removeClass('navbar-fixed-top');
       				$('body.gg-has-stiky-menu').css('padding-top', '0');
       				main_menu.css('top', '');

       			}

       			//Second animation
       			if ($(this).scrollTop() > main_menu_height + 1800) {
       				main_menu.addClass('gg-shrink');
       			} else {
       				main_menu.removeClass('gg-shrink');
       			}

       			

       		});
		}
	}

    //Load, resize, added to cart
	$(window).bind("load resize",function(e){
	 	gg_sticky_menu();
	});

        
	// here for the submit button of the comment reply form
	$( '#submit, input[type="button"], input[type="reset"], input[type="submit"], a.checkout-button' ).addClass( 'btn btn-primary' );	
	
	$( 'table' ).not('.variations, .cart').addClass( 'table');

	$( 'form' ).not('.header-search form, .variations_form').addClass( 'table');

	$('form').attr('role', 'form');

	var inputs = $('input, textarea')
            .not(':input[type=button], :input[type=submit], :input[type=reset]');

	$(inputs).each(function() {
	    $(this).addClass('form-control');
	});

	if($('body.gg-theme-is-mobile').length > 0) {
		$("a.product-image-overlay").on('click', function(event) {
		    event.preventDefault();
		});
	}

	//Fullscreen search form
	if($('li.gg-menu-extras').length > 0) {
	    $('a[href="#fullscreen-searchform"]').on('click', function(event) {
	        event.preventDefault();
	        $('#fullscreen-searchform').addClass('open');
	        $('#fullscreen-searchform > form > input[type="search"]').focus();
	    });
	    
	    $('#fullscreen-searchform, #fullscreen-searchform button.close').on('click keyup', function(event) {
	        if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
	            $(this).removeClass('open');
	        }
	    });
    }

    //Currency switcher
	if($('.site-header .gg-currency-switcher').length > 0) {
	    $('.gg-currency-switcher ul.wcml_currency_switcher').addClass('dropdown-menu noclose');
    }
   

});



	
})(jQuery);