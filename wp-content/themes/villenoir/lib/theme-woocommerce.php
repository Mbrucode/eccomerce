<?php
/*
 * Remove default stylesheet
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Suppress certain WooCommerce admin notices
 */
function villenoir_wc_suppress_nags() {
    if ( class_exists( 'WC_Admin_Notices' ) ) {
        // Remove the "you have outdated template files" nag
        WC_Admin_Notices::remove_notice( 'template_files' );
        
        // Remove the "install pages" and "wc-install" nag
        WC_Admin_Notices::remove_notice( 'install' );
    }
}
add_action( 'wp_loaded', 'villenoir_wc_suppress_nags', 99 );

/**
 * Load JavaScript for WC
 */
add_action('wp_enqueue_scripts', 'villenoir_wc_scripts_loader');
function villenoir_wc_scripts_loader() {
    wp_enqueue_script('woo-inputs', get_template_directory_uri() . '/js/woocommerce.js', array('jquery'), VILLENOIR_THEMEVERSION, true); 
}

/**
 * Define image sizes - filter
 */

function villenoir_filter_single_catalog_wc_image_size( array $size = array() ){
    $size = array(
        'width'  => '9999',
        'height' => '9999',
        'crop'   => 1
    );
    return $size;
}

function villenoir_filter_thumbnail_wc_image_size( array $size = array() ){
    $size = array(
        'width'  => '70',
        'height' => '100',
        'crop'   => 1
    );
    return $size;
}

// single
add_filter( 'woocommerce_get_image_size_shop_single', 'villenoir_filter_single_catalog_wc_image_size' );
// catalog
add_filter( 'woocommerce_get_image_size_shop_catalog', 'villenoir_filter_single_catalog_wc_image_size' );
// thumbnail
add_filter( 'woocommerce_get_image_size_shop_thumbnail', 'villenoir_filter_thumbnail_wc_image_size' );

//Remove the filters at user input
if ( _get_field('gg_activate_product_image_sizes','option', false) === true ) {
    // single
    remove_filter( 'woocommerce_get_image_size_shop_single', 'villenoir_filter_single_catalog_wc_image_size' );
    // catalog
    remove_filter( 'woocommerce_get_image_size_shop_catalog', 'villenoir_filter_single_catalog_wc_image_size' );
    // thumbnail
    remove_filter( 'woocommerce_get_image_size_shop_thumbnail', 'villenoir_filter_thumbnail_wc_image_size' );
}


/**
 * WooCommerce Breadcrubs
 */
function villenoir_wc_breadcrumbs() {
    return array(
            'delimiter'   => ' <span class="delimiter">&frasl;</span> ',
            'wrap_before' => '<div class="gg-breadcrumbs"><i class="icon_house_alt"></i> ',
            'wrap_after'  => '</div>',
            'before'      => '',
            'after'       => '',
            'home'        => _x('Home', 'breadcrumb', 'villenoir'),
        );
}
add_filter( 'woocommerce_breadcrumb_defaults', 'villenoir_wc_breadcrumbs' );


/**
 * Add Sold out badge
 */
include (get_template_directory().'/lib/woocommerce-sold-out.php');

/**
 * Add Year custom field
 */
include (get_template_directory().'/lib/woocommerce-year-field.php');


/**
 * Hide shop page title
 */
add_filter('woocommerce_show_page_title', 'villenoir_remove_shop_title' );
function villenoir_remove_shop_title() {
    return false;
}

/** 
 * Remove tab headings
 */
add_filter('woocommerce_product_description_heading', 'villenoir_clear_tab_headings');
add_filter('woocommerce_product_additional_information_heading', 'villenoir_clear_tab_headings');
function villenoir_clear_tab_headings() {
    return '';
}

/** 
 * Remove product rating display on product loops
 */
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

/** 
 * Remove product rating display on product single
 */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );

/** 
 * Move product tabs 
 */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 60 );



/*
 * Add custom pagination
 */
function villenoir_wc_pagination() {
    villenoir_pagination();       
}
remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);
add_action( 'woocommerce_after_shop_loop', 'villenoir_wc_pagination', 10);


/*
 * Allow shortcodes in product excerpts
 */
if (!function_exists('woocommerce_template_single_excerpt')) {
   function woocommerce_template_single_excerpt( $post ) {
       global $post;
       if ($post->post_excerpt) echo '<div itemprop="description">' . do_shortcode(wpautop(wptexturize($post->post_excerpt))) . '</div>';
   }
}

/*
 * Shop page - Number of products per row
 */
add_filter('loop_shop_columns', 'villenoir_shop_columns');
if (!function_exists('villenoir_shop_columns')) {
    function villenoir_shop_columns() {
        return _get_field('gg_shop_product_columns','option', '3');
    }
}

/*
 * Shop page - Number of products per page
 */
add_filter('loop_shop_per_page',  'villenoir_shop_products_per_page', 20);
if (!function_exists('villenoir_shop_products_per_page')) {
    function villenoir_shop_products_per_page() {
        $product_per_page = _get_field('gg_product_per_page','option', '12');
        return $product_per_page;
    }
}


/**
 * Enable/Disable Sale Flash
 */
if ( _get_field('gg_store_sale_flash','option', true) === true ) {
    remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
    add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
} else {
    remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
}

/**
 * Enable/Disable Products price
 */
if ( _get_field('gg_store_products_price','option', true) === true ) {
    remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
    add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);    
} else {
    remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
}

/**
 * Enable/Disable Add to cart
 */
if ( _get_field('gg_store_add_to_cart','option', true) === true ) {
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
    add_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_add_to_cart',30);
} else {
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart',10);
}

/**
 * Options for product page
 */

/*Sale flash*/
if ( _get_field('gg_product_sale_flash','option', true) === false ) {
    remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
}

/*Price*/
if ( _get_field('gg_product_products_price','option', true) === false ) {
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
}

/*Product summary*/
if ( _get_field('gg_product_products_excerpt','option', true) === false ) {
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
} 

/*Add to cart*/
if ( _get_field('gg_product_add_to_cart','option', true) === false ) {
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
}

/*Meta*/
if ( _get_field('gg_product_products_meta','option', true) === false ) {
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 40 );
    
}

/**
 * Move price bellow short description
 */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 25);


/**
 * Remove Description tab
 */
add_filter( 'woocommerce_product_tabs', 'villenoir_product_remove_description_tab', 98);
function villenoir_product_remove_description_tab($tabs) {
    unset($tabs['description']);
    return $tabs;
}

/**
 * Remove Review tab
 */
add_filter( 'woocommerce_product_tabs', 'villenoir_product_remove_reviews_tab', 98);
function villenoir_product_remove_reviews_tab($tabs) {
    unset($tabs['reviews']);
    return $tabs;
}

/**
 * Remove Attributes tab
 */
add_filter( 'woocommerce_product_tabs', 'villenoir_product_remove_attributes_tab', 98);
function villenoir_product_remove_attributes_tab($tabs) {
    unset($tabs['additional_information']);
    return $tabs;
}

//Move product description under all
function villenoir_woocommerce_template_product_description() {
    woocommerce_get_template( 'single-product/tabs/description.php' );
}
add_action( 'woocommerce_after_single_product_summary', 'villenoir_woocommerce_template_product_description', 10 );

//Move product attributes under add to cart
function villenoir_woocommerce_template_product_attributes() {
    woocommerce_get_template( 'single-product/tabs/additional-information.php' );
}
add_action( 'woocommerce_single_product_summary', 'villenoir_woocommerce_template_product_attributes', 60 );

//Move product reviews under product attributes
function villenoir_woocommerce_template_product_reviews() {
    comments_template();
}
//add_action( 'woocommerce_single_product_summary', 'villenoir_woocommerce_template_product_reviews', 65 );


/**
 * Enable/Disable Related products
 */
if ( _get_field('gg_product_related_products','option', true) === true ) {
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
    add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

    add_filter( 'woocommerce_output_related_products_args', 'villenoir_related_products_args' );
      function villenoir_related_products_args( $args ) {
        $args['posts_per_page'] = 2; // 4 related products
        $args['columns'] = 2; // arranged in 2 columns
        return $args;
    }

} else {
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
}

/**
 * Enable/Disable Up Sells products
 */
if ( _get_field('gg_product_upsells_products','option', true) === true ) {
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
    add_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

    if ( ! function_exists( 'woocommerce_upsell_display_output' ) ) {
        function woocommerce_upsell_display_output() {
            woocommerce_upsell_display( 2,2 ); // Display 2 products in rows of 2
        }
    }

} else {
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
}


/**
 * Enable/Disable Cross Sells products
 */
if ( _get_field('gg_product_crosssells_products','option', true) === true ) {
    remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
    add_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_output',5 );

    if ( ! function_exists( 'woocommerce_cross_sell_output' ) ) {
        function woocommerce_cross_sell_output() {
            woocommerce_cross_sell_display( 2,2 ); // Display 2 products in rows of 2
        }
    }
} else {
    remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
}

/**
 * Catalog mode functions (must be always the last function)
 */
if ( _get_field('gg_store_catalog_mode','option', false ) === true ) {
    // Remove add to cart button from the product loop
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart',10);
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
    remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_add_to_cart',30);

    // Remove add to cart button from the product details page
    remove_action( 'woocommerce_before_add_to_cart_form', 'woocommerce_template_single_product_add_to_cart', 10, 2);
    
    add_filter( 'woocommerce_add_to_cart_validation', '__return_false', 10, 2 );

    // check for clear-cart get param to clear the cart
    add_action( 'init', 'villenoir_wc_clear_cart_url' );
    function villenoir_wc_clear_cart_url() {    
        global $woocommerce;
        if ( isset( $_GET['empty-cart'] ) ) { 
            $woocommerce->cart->empty_cart(); 
        }  
    }

    add_action( 'wp', 'villenoir_check_pages_redirect');
    function villenoir_check_pages_redirect() {
        $cart     = is_page( wc_get_page_id( 'cart' ) );
        $checkout = is_page( wc_get_page_id( 'checkout' ) );

        if ( $cart || $checkout ) {
            wp_redirect( esc_url( home_url( '/' ) ) );
            exit;
        }
    }
    
}

/**
 * Remove product category description - its included in page_header function
 **/

remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );



/**
 * Minicart function
 **/
if ( ! function_exists('villenoir_wc_minicart') ) { 
function villenoir_wc_minicart() {
ob_start();
?>
    <a href="<?php echo esc_url(WC()->cart->get_cart_url()); ?>" title="<?php esc_html_e('View your shopping cart', 'villenoir'); ?>">
        <span><i class="fa fa-shopping-cart"></i></span>
        <?php
            if (WC()->cart->get_cart_contents_count() > 0) {
                echo sprintf ( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(),'villenoir' ), WC()->cart->get_cart_contents_count() ); ?> - <?php echo WC()->cart->get_cart_total();
            } 
        ?>
    </a>

    <?php return ob_get_clean(); ?>

<?php } 

}

add_filter( 'add_to_cart_fragments', 'villenoir_wc_minicart_fragment' );
if ( ! function_exists( 'villenoir_wc_minicart_fragment' ) ) {
    function villenoir_wc_minicart_fragment( $fragments ) {
        $fragments['.gg-woo-mini-cart'] = '<li class="gg-woo-mini-cart">' . villenoir_wc_minicart() .'</li>';
        return $fragments;
    }
}

//WC
$shop_style = _get_field('gg_shop_product_style','option', 'style1');

if ( isset( $_GET['shop_style'] ) ) {
   $shop_style = $_GET['shop_style'];
}

//Style 1
if ( $shop_style == 'style1' ) {

    //Move product title before the image
    remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
    add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_title', 5 );

    //Wrap the product image in a div
    add_action( 'woocommerce_before_shop_loop_item_title', 'villenoir_wrap_product_image_begin', 5 );
    function villenoir_wrap_product_image_begin() {
        echo '<div class="gg-product-image-wrapper">';
    }

    add_action( 'woocommerce_before_shop_loop_item_title', 'villenoir_wrap_product_image_end', 15 );
    function villenoir_wrap_product_image_end() {
        echo '</div>';
    }

    //Close the link right after the image wrapper div
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
    add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 15 );

    //Wrap the price/add to cart in a wrapper div
    add_action( 'woocommerce_after_shop_loop_item_title', 'villenoir_wrap_product_meta_begin', 5 );
    function villenoir_wrap_product_meta_begin() {
        echo '<div class="gg-product-meta-wrapper">';
    }

    add_action( 'woocommerce_after_shop_loop_item', 'villenoir_wrap_product_meta_end', 10 );
    function villenoir_wrap_product_meta_end() {
        echo '</div>';
    }
} elseif ( $shop_style == 'style2' ) {

    //Wrap the product image in a div
    add_action( 'woocommerce_before_shop_loop_item_title', 'villenoir_wrap_product_image_begin', 5 );
    function villenoir_wrap_product_image_begin() {
        echo '<div class="gg-product-image-wrapper">';
    }

    add_action( 'woocommerce_before_shop_loop_item_title', 'villenoir_wrap_product_image_end', 15 );
    function villenoir_wrap_product_image_end() {
        echo '</div>';
    }

    //Close the link right after the image wrapper div
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
    add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 15 );

    //Wrap the price/add to cart in a wrapper div
    add_action( 'woocommerce_after_shop_loop_item_title', 'villenoir_wrap_product_meta_begin', 5 );
    function villenoir_wrap_product_meta_begin() {
        echo '<div class="gg-product-meta-wrapper">';
    }

    add_action( 'woocommerce_after_shop_loop_item', 'villenoir_wrap_product_meta_end', 10 );
    function villenoir_wrap_product_meta_end() {
        echo '</div>';
    }

} elseif ( $shop_style == 'style3' ) {
    
    //Wrap the whole product in figure
    add_action( 'woocommerce_before_shop_loop_item', 'villenoir_wrap_product_begin', 5 );
    function villenoir_wrap_product_begin() {
        echo '<figure class="gg-product-image-wrapper effect-zoe">';
    }

    add_action( 'woocommerce_after_shop_loop_item', 'villenoir_wrap_product_end', 15 );
    function villenoir_wrap_product_end() {
        echo '</figure>';
    }

    //Close the link right before the image 
    remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

    //Wrap the others in a figcaption wrapper
    add_action( 'woocommerce_shop_loop_item_title', 'villenoir_wrap_product_meta_begin', 5 );
    add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 6 );
    add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 6 );
    function villenoir_wrap_product_meta_begin() {
        echo '<figcaption class="product-image-overlay">';
        echo '<span class="product-overlay-meta">';
    }

    
    add_action( 'woocommerce_after_shop_loop_item', 'villenoir_wrap_product_meta_end', 15 );
    function villenoir_wrap_product_meta_end() {
        echo '</span class="product-overlay-meta">';
        echo '</figcaption>';
    }

    //Put the year above the title
    add_action( 'woocommerce_shop_loop_item_title', 'villenoir_add_year_above_title', 5 );
    function villenoir_add_year_above_title() {
        $wine_year = get_post_meta( get_the_ID(), '_year_field', true );
        if ( $wine_year ) {
            echo '<span class="year">'.esc_html($wine_year).'</span>';
        }
    }

} elseif ( $shop_style == 'style4' ) {

    //Wrap the product image in a div
    add_action( 'woocommerce_before_shop_loop_item_title', 'villenoir_wrap_product_image_begin', 5 );
    function villenoir_wrap_product_image_begin() {
        echo '<div class="gg-product-image-wrapper">';
    }

    add_action( 'woocommerce_before_shop_loop_item_title', 'villenoir_wrap_product_image_end', 15 );
    function villenoir_wrap_product_image_end() {
        echo '</div>';
    }

    //Close the link right after the image wrapper div
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
    add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 15 );

    //Wrap the price/add to cart in a wrapper div
    add_action( 'woocommerce_shop_loop_item_title', 'villenoir_wrap_product_meta_begin', 5 );
    function villenoir_wrap_product_meta_begin() {
        echo '<div class="gg-product-meta-wrapper">';
    }

    add_action( 'woocommerce_after_shop_loop_item', 'villenoir_wrap_product_meta_end', 10 );
    function villenoir_wrap_product_meta_end() {
        echo '</div>';
    }

    //Put the year above the title
    add_action( 'woocommerce_shop_loop_item_title', 'villenoir_add_year_above_title', 5 );
    function villenoir_add_year_above_title() {
        $wine_year = get_post_meta( get_the_ID(), '_year_field', true );
        if ( _get_field('gg_store_year_field','option', true) !== true ) {
            $wine_year = false;
        }
        if ( $wine_year ) {
            echo '<span class="year">'.esc_html($wine_year).'</span>';
        }
    }

}