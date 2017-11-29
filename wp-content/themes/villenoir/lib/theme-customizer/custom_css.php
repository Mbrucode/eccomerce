<?php
/*Custom CSS*/

//Font
$gg_headings_font = _get_field('gg_headings_font', 'option', array('font' => 'Playfair Display' ));
$gg_body_font = _get_field('gg_body_font', 'option',array('font' => 'Lato' ));

//Text color
$gg_text_body_color = _get_field('gg_text_body_color', 'option','#000000');
$gg_headings_color = _get_field('gg_headings_color', 'option','#000000');
$gg_link_color = _get_field('gg_link_color', 'option','#b0976d');

//Primary color
$gg_primary_color = _get_field('gg_primary_color', 'option','#121212');
//Primary color alt
$gg_primary_color_alt = _get_field('gg_primary_color_alt', 'option','#000000');
?>

<?php if ( $gg_headings_font['font'] != 'Playfair Display' ) : ?>
	h1,	h2,	h3,	h4,	h5,	h6, .h1, .h2, .h3, .h4, .h5, .h6,
	blockquote,
	header.site-header .header-page-description,
	.gg-widget.gg-instagram-feed .followers,
	.vc_widget.vc_widget_instagram .followers,
	.counter-holder .counter,
	.woocommerce .shop_table.cart .product-name a,
	.gg-shop-style3 .price,
	.gg-shop-style4 .gg-product-meta-wrapper .price,
	.woocommerce .product .summary .price,
	.woocommerce .shop_table.cart .product-name a,
	.single-product p.stock  {
		font-family: <?php echo esc_html($gg_headings_font['font']); ?>;
	}
<?php endif; ?>

<?php if ( $gg_body_font['font'] != 'Lato' ) : ?>
	body,
	.gg-contact-template .gg-view-map-wrapper a,
	.button,
	.btn,
	select,
	.form-control,
	.site-title,
	.navbar-nav > li > a,
	.dropdown-menu > li > a,
	.dropdown-menu > li > .dropdown-menu > li > a,
	.dropdown-header,
	.dropdown-menu > li div.gg-extra-html ul.gg-slick-carousel .meta-wrapper a,
	.gg-widget.contact,
	.vc_widget_contact_us,
	.gg-widget.working-hours span,
	.vc_widget_working_hours .widget.working-hours span,
	.gg-widget.social-icons ul li a,
	.gg-widget.gg-instagram-feed .followers span,
	.vc_widget.vc_widget_instagram .followers span,
	footer.entry-meta a,
	.counter-holder p,
	.wpb-js-composer .vc_general.vc_btn3,
	body #lang_sel_footer a,
	body #lang_sel_footer a:hover,
	body #lang_sel_footer a.lang_sel_sel,
	body #lang_sel_footer a.lang_sel_sel:hover,
	body #lang_sel_footer a.lang_sel_sel:visited,
	body #lang_sel_footer ul a,
	body #lang_sel_footer ul a:visited,
	body #lang_sel_footer ul a:hover,
	.navbar-nav ul.wcml_currency_switcher.curr_list_vertical li,
	.gg-widget .tagcloud a,
	.gg-widget.widget_product_tag_cloud a,
	.woocommerce form.checkout #customer_details h3#ship-to-different-address label,
	.woocommerce table.wishlist_table thead th,
	.woocommerce table.wishlist_table td.product-name {

		font-family: <?php echo esc_html($gg_body_font['font']); ?>;
}
<?php endif; ?>


<?php if ($gg_text_body_color != '#000000') { ?>
	body,
	caption,
	select option,
	legend,
	.form-control,
	.input-group-addon,
	.has-success .form-control-feedback,
	body.gg-page-header-style2 header.site-header .header-page-description,
	body.gg-page-header-style2 header.site-header .page-meta .page-meta-wrapper,
	.subheader-slider .tparrows,
	.subheader-slider .tparrows:before,
	.gg-widget.flickr-widget .flickr_stream_wrap a,
	.gg-widget.working-hours ul li:before,
	.vc_widget_working_hours .widget.working-hours ul li:before,
	.gg-widget.working-hours span,
	.vc_widget_working_hours .widget.working-hours span,
	.gg-widget.social-icons ul li a i,
	.wpb_content_element .widget.widget_recent_entries ul li a,
	.gg-widget.widget_recent_entries ul li a,
	.gg-widget.twitter-widget ul li a,
	.gg-widget.widget_rss a,
	.pagination-wrapper,
	.pagination-wrapper a,
	.page-links,
	.pagination > li.current > a,
	.pagination > li > a:hover,
	.pagination > li > span:hover,
	.pagination > li > a:focus,
	.pagination > li > span:focus,
	.page-links span:not(.page-links-title):hover,
	.pagination > li > a.next,
	.pagination > li > a.prev,
	.counter-holder .vc_icon_element,
	.vc_toggle .vc_toggle_title,
	.wpb-js-composer .vc_tta-color-grey.vc_tta-style-classic .vc_tta-tab > a,
	.wpb-js-composer .vc_tta-color-grey.vc_tta-style-classic .vc_tta-tab.vc_active > a,
	.wpb-js-composer .vc_tta-color-grey.vc_tta-style-outline .vc_tta-tab.vc_active > a,
	.wpb-js-composer .vc_tta-color-grey.vc_tta-style-outline .vc_tta-tab > a,
	.featured-icon-box .vc_icon_element .vc_icon_element-icon,
	.gg_filter li.active a,
	.gg_filter li.active:hover a,
	.gg_filter li.active > a:focus,
	.gg_filter li:hover a,
	.gg_filter li a:hover,
	.pace,
	#fullscreen-searchform .btn,
	#fullscreen-searchform .close,
	#reviews #comments .comment p.meta strong,
	#reviews #comments .comment .star-rating,
	.woocommerce form.woocommerce-ordering .bootstrap-select.open > .btn,
	.woocommerce-tabs .tabs li.active a,
	.gg-widget.widget_price_filter .price_slider_amount button,
	.woocommerce dl.variation dt,
	.woocommerce .cart-collaterals .cart_totals table,
	.woocommerce .shop_table.cart td.actions .cart-collaterals .cart_totals th,
	.woocommerce .shop_table.cart td.actions .cart-collaterals .cart_totals td,
	.woocommerce form.checkout #order_review .shop_table th,
	.woocommerce form.checkout #order_review .shop_table td,
	.woocommerce form.checkout ul.payment_methods li label,
	.woocommerce form.checkout #customer_details h3#ship-to-different-address label,
	body.woocommerce-account .shop_table td,
	body.woocommerce-order-received ul.order_details li strong,
	body.woocommerce-order-received .shop_table th,
	body.woocommerce-order-received .shop_table td,
	.woocommerce-message,
	.woocommerce-error,
	.woocommerce-info,
	.woocommerce table.wishlist_table thead th,
	.woocommerce #content table.wishlist_table.cart a.remove:hover,
	.woocommerce table.wishlist_table tr td.product-stock-status span.wishlist-in-stock,
	.woocommerce .shop_table.cart th {
		color: <?php echo esc_html($gg_text_body_color); ?>;
	}
	
<?php } ?>


<?php if ($gg_headings_color != '#000000') { ?>
	h1,
	h2,
	h3,
	h4,
	h5,
	h6,
	.h1,
	.h2,
	.h3,
	.h4,
	.h5,
	.h6,
	body.gg-page-header-style2 header.site-header .page-meta h1,
	article.page h2.entry-title a,
	article.post h2.entry-title a,
	#comments .comment h4.media-heading,
	#comments .comment h4.media-heading a,
	.counter-holder .counter,
	.vc_toggle .vc_toggle_title h4,
	.woocommerce .shop_table.cart .product-name a,
	.woocommerce .product .summary .price {
		color: <?php echo esc_html($gg_headings_color); ?>;
	}

	.woocommerce .product .upsells.products h2:after,
	.woocommerce .product .related.products h2:after,
	#reviews #comments h2:after,
	.gg-widget h4.widget-title:after,
	.gg_posts_grid .grid-title:after,
	.wpb_content_element .wpb_heading:after,
	.vc_widget .widgettitle:after,
	.wpb_heading.wpb_flickr_heading:after,
	.wpb_heading.wpb_contactform_heading:after,
	.wpb_content_element .widgettitle:after,
	.contact-form-mini-header:after {
		background-color: <?php echo esc_html($gg_headings_color); ?>;
	}

<?php } ?>

<?php if ($gg_link_color != '#b0976d') { ?>
	a,
	a:hover,
	a:focus,
	.heading p.h_subtitle,
	.input-group-btn:last-child > .btn,
	.input-group-btn:last-child > .btn-group,
	blockquote:before,
	.site-title,
	.site-title a,
	header.site-header .page-meta p.page-header-subtitle,
	.navbar-default .navbar-nav > .open > a,
	.navbar-default .navbar-nav > .open > a:hover,
	.navbar-default .navbar-nav > .open > a:focus,
	.navbar-default .navbar-nav > li > a:hover,
	.navbar-default .navbar-nav > li > a:focus,
	.navbar-default .navbar-nav > .active > a,
	.navbar-default .navbar-nav > .active > a:hover,
	.navbar-default .navbar-nav > .active > a:focus,
	.dropdown-menu > li > a:hover,
	.dropdown-menu > li > a:focus,
	.dropdown-menu > .active > a,
	.dropdown-menu > .active > a:hover,
	.dropdown-menu > .active > a:focus,
	.dropdown-menu > li > .dropdown-menu > li > a:hover,
	.dropdown-menu > li > .dropdown-menu > li > a:focus,
	.dropdown-menu > li > .dropdown-menu > .active > a,
	.dropdown-menu > li > .dropdown-menu > .active > a:hover,
	.dropdown-menu > li > .dropdown-menu > .active > a:focus,
	.navbar-default .navbar-nav .open > .dropdown-menu > .dropdown-submenu.open > a,
	.navbar-default .navbar-nav .open > .dropdown-menu > .dropdown-submenu.open > a:hover,
	.navbar-default .navbar-nav .open > .dropdown-menu > .dropdown-submenu.open > a:focus,
	.navbar-default .navbar-nav > .open > a,
	.navbar-default .navbar-nav > .open > a:hover,
	.navbar-default .navbar-nav > .open > a:focus,
	.dropdown-header,
	footer.site-footer a,
	footer.site-footer a:hover,
	footer.site-footer .footer-extras .gg-footer-menu .navbar-nav > li > a:hover,
	footer.site-footer .footer-extras .footer-social ul li a:hover,
	footer.site-footer .gg-widget.working-hours ul li:before,
	.gg-widget.gg-instagram-feed .followers span,
	.vc_widget.vc_widget_instagram .followers span,
	.post-social ul > li,
	.post-social ul > li > a,
	.title-subtitle-box p,
	.cd-timeline-content .cd-title,
	.counter-holder p,
	.gg_list ul li:before,
	.navbar-nav ul.wcml_currency_switcher.curr_list_vertical li:hover,
	.gg-infobox p.subtitle,
	.gg-horizontal-list p.subtitle,
	.woocommerce .product .summary .year,
	.woocommerce .product .upsells.products h2,
	.woocommerce .product .related.products h2,
	.woocommerce .cart-collaterals .cross-sells h2,
	.gg-shop-style2 ul.products .product .gg-product-meta-wrapper dl,
	.gg-shop-style3 .year,
	.gg-shop-style3 .price,
	.gg-shop-style4 .gg-product-meta-wrapper .year,
	.gg-shop-style4 .gg-product-meta-wrapper .price,
	.woocommerce-MyAccount-navigation ul li.is-active a,
	.woocommerce-MyAccount-navigation ul li a:hover,
	.woocommerce-MyAccount-orders a.button.view {
		color: <?php echo esc_html($gg_link_color); ?>;
	}

 	body.gg-page-header-style2 header.site-header .page-meta p.page-header-subtitle:before,
 	#cd-timeline::before,
 	.cd-timeline-img.cd-picture,
 	.gg_list.list_style_line ul li:before,
 	.wpb-js-composer .flex-control-paging li a:hover,
	.wpb-js-composer .flex-control-paging li a.flex-active,
	.gg-horizontal-list dt:after,
	.woocommerce .cart .quantity input.qty,
	.gg-shop-style1 ul.products .product .gg-product-meta-wrapper dt:after,
	.gg-shop-style2 ul.products .product .gg-product-meta-wrapper dt:after,
	.gg-shop-style3 .add_to_cart_button,
	.woocommerce .shop_attributes th:after {
	 	background-color: <?php echo esc_html($gg_link_color); ?>;
	}

	.woocommerce .cart .quantity input.qty {
	 	border-color: <?php echo esc_html($gg_link_color); ?>;
	}

	.gg-contact-template .gg-view-map-wrapper a:hover,
	.button:hover,
	.btn-primary:hover,
	.gg-contact-template .gg-view-map-wrapper a:focus,
	.button:focus,
	.btn-primary:focus,
	.btn-secondary {
	    background-color: <?php echo esc_html($gg_link_color); ?>;
	    border-color: <?php echo esc_html($gg_link_color); ?>;
	}

	.tp-caption.Villenoir-Subtitle, .Villenoir-Subtitle {
		color: <?php echo esc_html($gg_link_color); ?>;
	}

<?php } ?>

<?php
/* Primary color */
if ($gg_primary_color != '#121212') :
?>	
	
	.navbar-default,
	.dropdown-menu,
	.dropdown-menu > li > .dropdown-menu,
	footer.site-footer,
	.vc_widget.vc_widget_instagram .media-left  {
		background: <?php echo esc_html($gg_primary_color); ?>;
	}

	footer.site-footer,
	footer.site-footer .footer-extras,
	footer.site-footer .footer-extras .gg-footer-menu .navbar-nav > li > a,
	footer.site-footer .footer-extras .footer-social ul li a,
	footer.site-footer .gg-widget.gg-instagram-feed .followers span {
		color: <?php echo villenoir_hex_shift(esc_html($gg_primary_color),'lighter', 50 ) ; ?>;
	}


	footer.site-footer .btn-default:hover, 
	footer.site-footer .btn-default:focus, 
	footer.site-footer .btn-default.focus, 
	footer.site-footer .btn-default:active, 
	footer.site-footer .btn-default.active, 
	footer.site-footer .open > .dropdown-toggle.btn-default,
	.gg-widget.gg-instagram-feed a.btn,
	footer.site-footer select,
	footer.site-footer .form-control,
	footer.site-footer .input-group-btn:last-child > .btn,
	footer.site-footer .input-group-btn:last-child > .btn-group,
	footer.site-footer .table > thead > tr > th,
	footer.site-footer .table > tbody > tr > th,
	footer.site-footer .table > tfoot > tr > th,
	footer.site-footer .table > thead > tr > td,
	footer.site-footer .table > tbody > tr > td,
	footer.site-footer .table > tfoot > tr > td {
		border-color: <?php echo villenoir_hex_shift(esc_html($gg_primary_color),'lighter', 50 ) ; ?>;
	}

<?php endif; ?>

<?php
/* Primary color alt */
if ($gg_primary_color_alt != '#000000') :
?>	

	.btn-default:hover, 
	.btn-default:focus, 
	.btn-default.focus, 
	.btn-default:active, 
	.btn-default.active, 
	.open > .dropdown-toggle.btn-default {
		border-color: <?php echo esc_html($gg_primary_color_alt); ?>;
	}

	.btn-default-alt:hover, 
	.btn-default-alt:focus, 
	.btn-default-alt.focus, 
	.btn-default-alt:active, 
	.btn-default-alt.active, 
	.open > .dropdown-toggle.btn-default-alt {
		border-color: <?php echo esc_html($gg_primary_color_alt); ?>;
    	color: <?php echo esc_html($gg_primary_color_alt); ?>;
	}

	.gg-contact-template .gg-view-map-wrapper a,
	.button,
	.btn-primary,
	.btn-secondary:hover,
	.btn-secondary:focus,
	.nav-links a,
	.wpb-js-composer .vc_btn3.vc_btn3-color-black.vc_btn3-style-outline:hover,
	.wpb-js-composer .vc_btn3.vc_btn3-color-black.vc_btn3-style-outline:focus {
	    background-color: <?php echo esc_html($gg_primary_color_alt); ?>;
	    border-color: <?php echo esc_html($gg_primary_color_alt); ?>;
	}

	footer.site-footer .btn-primary {
		color: <?php echo esc_html($gg_primary_color_alt); ?>;
	}

	header.site-header .page-meta,
	.page-header-image,
	.gg-gallery figure figcaption > i,
	.gg-gallery figure h2,
	.wpb-js-composer .vc_toggle_default .vc_toggle_icon:before, 
	.wpb-js-composer .vc_toggle_default .vc_toggle_icon:after,
	.wpb-js-composer .vc_toggle_default .vc_toggle_icon,
	.wpb-js-composer .vc_progress_bar .vc_single_bar .vc_bar,
	.wpb-js-composer .vc_btn3.vc_btn3-color-black, 
	.wpb-js-composer .vc_btn3.vc_btn3-color-black.vc_btn3-style-flat,
	.wpb-js-composer .vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-black.vc_icon_element-background,
	.featured-image-box figure.sadie,
	body #lang_sel_footer,
	.wpb-js-composer .wpb_gallery .wpb_flexslider .flex-control-nav,
	#fullscreen-searchform,
	p.demo_store,
	span.soldout,
	.woocommerce .cart .quantity input.minus:hover,
	.woocommerce .cart .quantity input.plus:hover,
	.product-image-wrapper.inverse h3 span,
	.gg-widget.widget_price_filter .price_slider_wrapper .ui-widget-content,
	.gg-widget.widget_price_filter .ui-slider .ui-slider-handle,
	.gg-shop-style3 .gg-product-image-wrapper .product-image-overlay {
		background-color: <?php echo esc_html($gg_primary_color_alt); ?>;
	}
	

<?php endif; ?>