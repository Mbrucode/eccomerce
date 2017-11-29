<?php
if ( ! class_exists( 'WPBakeryShortCode_gg_products_grid' ) ) {
class WPBakeryShortCode_gg_products_grid extends WPBakeryShortCode {

   public function __construct() {  
         add_shortcode('products_grid', array($this, 'gg_products_grid'));  
   }

   public function gg_products_grid( $atts, $content = null ) { 

         $output = $products_grid_title = $carousel_data = $carousel_data_html = $product_featured = $product_onsale = $product_best_seller = $link_html = $image = $el_class = $isotope_item = $is_carousel = $carousel_data = $is_unlimited = '';
         extract(shortcode_atts(array(
            'products_grid_title'      => '',
            'products_grid_col_select' => '',
            'products_grid_no_posts'   => '',
            'products_grid_terms'      => '',
            'posts_in'                 => '',
            'posts_not_in'             => '',
            'orderby'                  => '',
            'order'                    => '',
            'meta_key'                 => '',
            'grid_layout_mode'         => 'fitRows',
            'grid_layout_style'        => 'gap',
            'el_class'                 => '',
            'css_animation'            => '',
            'carousel_nav'             => '',
            'carousel_pag'             => '',
            'carousel_autoplay'        => '',
            'products_grid_pagination' => '',
            'show_filter'              => '',

         ), $atts));

        

        //Defaults
        global $gg_is_vc;

        //Apply columns class based on column selection 
        switch ($products_grid_col_select) {
          case "2":
            $products_grid_col_class = 'col-xs-12 col-sm-6 col-md-6';
            break;
          case "3":
            $products_grid_col_class = 'col-xs-12 col-sm-6 col-md-4';
            break;
          case "4":
            $products_grid_col_class = 'col-xs-12 col-sm-6 col-md-3';
            break;
        }

        //If the user does not insert the no of posts display all by default
        if ($products_grid_no_posts == '') {
          $products_grid_no_posts = '-1';  
        }

        //Animation
        $css_class = $this->getCSSAnimation($css_animation);
        //Extra class
        $css_class .= $this->getExtraClass( $el_class );

        if ( $grid_layout_mode == 'carousel' ) {

          //Load carousel
          $isotope_item = '';
          $is_carousel = 'gg-slick-carousel';
          $convert_ul = 'div';
          $convert_li = 'div';
          $products_grid_col_class ='';
          $products_grid_pagination = false;
          $data_pagination = 'none';

          $carousel_data .= ' "slidesToShow": '.$products_grid_col_select.', ';
          $carousel_data .= ' "arrows": '.($carousel_nav == 'yes' ? 'true' : 'false').', ';
          $carousel_data .= ' "dots": '.($carousel_pag == 'yes' ? 'true' : 'false').', ';
          $carousel_data .= ' "autoplay": '.($carousel_autoplay == 'yes' ? 'true' : 'false').', ';
          $carousel_data .= ' "infinite": true, ';
          $carousel_data .= ' "slidesToScroll": 1, ';
          if (is_rtl()) {
            $carousel_data .= ' "rtl": true, ';
          }
          $carousel_data .= ' "responsive": [{"breakpoint": 1024, "settings": {"slidesToShow": 3, "slidesToScroll": 1}}, {"breakpoint": 600, "settings": {"slidesToShow": 2, "slidesToScroll": 1}}, {"breakpoint": 480, "settings": {"slidesToShow": 1, "slidesToScroll": 1}}] ';

          $carousel_data_html .= ' data-slick=\'{ '.$carousel_data.' }\' ';

        } else {
          $isotope_item = ' isotope-item';
          $is_carousel = '';
          $convert_ul = 'ul';
          $convert_li = 'li';
          $data_pagination = 'ajax_load';
        }

        //Start the insanity
        $output .= "\n\t".'<div class="'.$css_class.' woocommerce">';
        $output .= "\n\t".'<div class="gg_posts_grid">';

        //Title
        if ($products_grid_title) {
          $output .= "\n\t\t\t\t".'<h4 class="grid-title">'.$products_grid_title.'</h4>';
        }

        //Grid filter
        if ( $products_grid_terms ) {
          $ids = explode( ',', $products_grid_terms );
          $ids = array_map( 'trim', $ids );
        } else {
            //If post_in display in filter the categories that the post is in
            if ( $posts_in != '' ) {
              $posts_in_arr = explode( ',', $posts_in );
              $posts_in_arr = array_map( 'trim', $posts_in_arr );
              foreach ($posts_in_arr as $posts_in_arr_id) {
                $ids_in[] = wp_get_post_terms($posts_in_arr_id, 'product_cat', array("fields" => "ids"));
                foreach ($ids_in as $key => $value) {
                  $ids[] = implode( ',', $value );
                }
              }
              $ids = implode( ',', $ids );
              $ids = array_unique(explode( ',', $ids ));
            } else {
              $ids = get_terms( 'product_cat', 'fields=ids');
            }
          
        }

        if ( count($ids) > 1 && $show_filter == 'yes') {
          $output .= "\n\t\t\t\t".'<ul class="gg_filter '.$is_carousel.'">';
          $output .= "\n\t\t\t\t\t".'<li class="active"><a href="#" data-filter="*">'.esc_html__("All", "villenoir-shortcodes").'</a></li>';

          foreach ( $ids as $prod_id ) {
            $term = get_term_by( 'id', $prod_id, 'product_cat' );
            $output .= "\n\t\t\t\t\t".'<li><a data-filter=".grid-cat-'.$term->slug.'">' . $term->name . ' </a></li>';
          }

          $output .= "\n\t\t\t\t".'</ul>';
        }

        $paged = 1;
        if(get_query_var('paged')) {
          $paged = get_query_var('paged');
        } elseif(get_query_var('page')) {
          $paged = get_query_var('page');
        }
       
        $args = array (
            'post_type'              => 'product',
            'post_status'            => 'publish',
            'posts_per_page'         => $products_grid_no_posts,
            'orderby'                => $orderby,
            'meta_key'               => $orderby == 'meta_key' ? $meta_key : '',
            'order'                  => $order,
            'ignore_sticky_posts'    => true,
            'paged'                  => $paged,
        );
        
        if (($products_grid_terms != '')) {
            $args['tax_query'] = array(
              array(
                'taxonomy' => 'product_cat',
                //'field' => 'slug',
                'include_children' => false,
                'terms' => $ids,
              ),
            );
        }

        $not_in = array();
        if ( $posts_not_in != '' ) {
          $posts_not_in = str_ireplace(" ", "", $posts_not_in);
          $not_in = explode(",", $posts_not_in);
        }

        //exclude current post from query
        if ( $posts_in == '' ) {
            global $post;
            array_push($not_in, $post->ID);
        } else if ( $posts_in != '' ) {
            $posts_in = str_ireplace(" ", "", $posts_in);
            $args['post__in'] = explode(",", $posts_in);
        }

        if ( $posts_in == '' || $posts_not_in != '' ) {
            $args['post__not_in'] = $not_in;
        }

        // The Query
        $wc_products_query = new WP_Query( $args );

        // The Loop
        if ( $wc_products_query->have_posts() ) {

          $output .= "\n\t".'<div class="clearfix"></div><'.$convert_ul.' '.$carousel_data_html.' class="el-grid no_magnific products row '.$is_carousel.' " data-layout-mode="'.$grid_layout_mode.'" data-pagination="'.$data_pagination.'">';

          while ( $wc_products_query->have_posts() ) : $wc_products_query->the_post();

            $output .= "\n\t".'<'.$convert_li.' class="'.$isotope_item.' product '.$products_grid_col_class.' '.villenoir_shortcodes_tax_terms_slug('product_cat').' ">';

            ob_start(); 
            wc_get_template_part( 'content', 'product-vc' );
            $output .= "\n\t".ob_get_contents();
            ob_end_clean();

            $output .= "\n\t".'</'.$convert_li.'>';
           
          endwhile; 
          wp_reset_postdata();
           
          $output .= "\n\t".'</'.$convert_ul.'>';

        } else {
         
          $output .= "\n\t".'<p>No posts found</p>';
         
        }

        if ( $products_grid_pagination ) {
          $output .= "\n\t".'<div class="load-more-anim"></div>';
          $output .= "\n\t".'<div class="pagination-load-more">';
          $output .= "\n\t\t".'<span class="pagination-span">';
          $output .= "\n\t\t".get_next_posts_link('Load more', $wc_products_query->max_num_pages);
          $output .= "\n\t\t".'</span>';
          $output .= "\n\t".'</div>';
        }

        $output .= "\n\t".'</div>';
        $output .= "\n\t".'</div>';

        return $output;
   }

}// END class WPBakeryShortCode_gg_products_grid

$WPBakeryShortCode_gg_products_grid = new WPBakeryShortCode_gg_products_grid();

}// END if ( ! class_exists( 'WPBakeryShortCode_gg_products_grid' ) ) { 

if ( function_exists( 'vc_map' ) ) {

vc_map( array(
   "name"              => esc_html__("Products filter","villenoir-shortcodes"),
   "description"       => esc_html__('Display WooCommerce products with filter and load more button.', 'villenoir-shortcodes'),
   "base"              => "products_grid",
   "weight"            => -50,
   "icon"              => "gg_vc_icon",
   'admin_enqueue_css' => array(VILLENOIR_SHORTCODES_DIR . '/shortcodes/css/styles.css'),
   "category"          => esc_html__('Villenoir', 'villenoir-shortcodes'),
   "params" => array(
      array(
         "type" => "textfield",
         "heading" => esc_html__("Title","villenoir-shortcodes"),
         "param_name" => "products_grid_title",
         "value" =>'',
         "description" => esc_html__("Insert the title","villenoir-shortcodes"),
      ),
      array(
         "type" => "dropdown",
         "heading" => esc_html__("Layout mode", "villenoir-shortcodes"),
         "param_name" => "grid_layout_mode",
         "value" => array(esc_html__("Grid Fit rows", "villenoir-shortcodes") => "fitRows",  esc_html__('Carousel', "villenoir-shortcodes") => 'carousel'),
         "description" => esc_html__("Layout template.", "villenoir-shortcodes")
      ),
      array(
        "type" => "checkbox",
        "heading" => esc_html__("Use navigation?","villenoir-shortcodes"),
        "value" => array(esc_html__("Yes, please","villenoir-shortcodes") => "yes" ),
        "param_name" => "carousel_nav",
        "description" => esc_html__("Show the carousel next/prev arrows","villenoir-shortcodes"),
        "dependency" => Array('element' => 'grid_layout_mode', 'value' => array('carousel'))
      ),
      array(
        "type" => "checkbox",
        "heading" => esc_html__("Use pagination?","villenoir-shortcodes"),
        "value" => array(esc_html__("Yes, please","villenoir-shortcodes") => "yes" ),
        "param_name" => "carousel_pag",
        "description" => esc_html__("Show the carousel dots navigation","villenoir-shortcodes"),
        "dependency" => Array('element' => 'grid_layout_mode', 'value' => array('carousel'))
      ),
      array(
        "type" => "checkbox",
        "heading" => esc_html__("Use autoplay?","villenoir-shortcodes"),
        "value" => array(esc_html__("Yes, please","villenoir-shortcodes") => "yes" ),
        "param_name" => "carousel_autoplay",
        "description" => esc_html__("Make the carousel autoplay","villenoir-shortcodes"),
        "dependency" => Array('element' => 'grid_layout_mode', 'value' => array('carousel'))
      ),
      array(
         "type" => "dropdown",
         "heading" => esc_html__("Columns count", "villenoir-shortcodes"),
         "param_name" => "products_grid_col_select",
         "value" => array(2,3,4),
         "admin_label" => true,
         "description" => esc_html__("Select columns count.", "villenoir-shortcodes"),
      ),
      array(
         "type" => "textfield",
         "heading" => esc_html__("Number of posts","villenoir-shortcodes"),
         "param_name" => "products_grid_no_posts",
         "value" => '-1',
         "description" => esc_html__("Insert the number of posts to display. Leave empty or insert -1 to display all. Default: -1","villenoir-shortcodes"),
         //"dependency" => Array('element' => 'grid_layout_mode', 'value' => array('fitRows','masonry'))
      ),

      array(
        'type' => 'checkbox',
        'heading' => esc_html__( 'Show filter', 'villenoir-shortcodes' ),
        'param_name' => 'show_filter',
        'value' => array( esc_html__( 'Yes', 'villenoir-shortcodes' ) => 'yes' ),
        'description' => esc_html__( 'Append filter to grid.', 'villenoir-shortcodes' ),
      ),

      array(
        "type" => "checkbox",
        "heading" => esc_html__("Use load more pagination?","villenoir-shortcodes"),
        "value" => array(esc_html__("Yes, please","villenoir-shortcodes") => "yes" ),
        "param_name" => "products_grid_pagination",
        "description" => esc_html__("Use load more button pagination","villenoir-shortcodes"),
        "dependency" => Array('element' => 'grid_layout_mode', 'value' => array('fitRows','masonry'))
      ),

      array(
          'type' => 'autocomplete',
          'heading' => esc_html__( 'Categories', 'villenoir-shortcodes' ),
          'param_name' => 'products_grid_terms',
          'settings' => array(
            'multiple' => true,
            'sortable' => true,
          ),
          'group' => esc_html__( 'Data filter', 'villenoir-shortcodes' ),
          'description' => esc_html__( 'List of product categories', 'villenoir-shortcodes' ),
      ),
    
      
      
      array(
         "type" => "textfield",
         "heading" => esc_html__("Post IDs", "villenoir-shortcodes"),
         "param_name" => "posts_in",
         "description" => esc_html__('Fill this field with posts IDs separated by commas (,) to retrieve only them.', "villenoir-shortcodes"),
         'group' => esc_html__( 'Data filter', 'villenoir-shortcodes' ),
      ),
       array(
         "type" => "textfield",
         "heading" => esc_html__("Exclude Post IDs", "villenoir-shortcodes"),
         "param_name" => "posts_not_in",
         "description" => esc_html__('Fill this field with posts IDs separated by commas (,) to exclude them from query.', "villenoir-shortcodes"),
         'group' => esc_html__( 'Data filter', 'villenoir-shortcodes' ),
      ),
      array(
         "type" => "dropdown",
         "heading" => esc_html__("Order by", "villenoir-shortcodes"),
         "param_name" => "orderby",
         "value" => array(
            esc_html__( 'Date', 'villenoir-shortcodes' ) => 'date',
            esc_html__( 'Order by post ID', 'villenoir-shortcodes' ) => 'ID',
            esc_html__( 'Author', 'villenoir-shortcodes' ) => 'author',
            esc_html__( 'Title', 'villenoir-shortcodes' ) => 'title',
            esc_html__( 'Last modified date', 'villenoir-shortcodes' ) => 'modified',
            esc_html__( 'Post/page parent ID', 'villenoir-shortcodes' ) => 'parent',
            esc_html__( 'Number of comments', 'villenoir-shortcodes' ) => 'comment_count',
            esc_html__( 'Menu order/Page Order', 'villenoir-shortcodes' ) => 'menu_order',
            esc_html__( 'Meta value', 'villenoir-shortcodes' ) => 'meta_value',
            esc_html__( 'Meta value number', 'villenoir-shortcodes' ) => 'meta_value_num',
            // esc_html__('Matches same order you passed in via the 'include' parameter.', 'villenoir-shortcodes') => 'post__in'
            esc_html__( 'Random order', 'villenoir-shortcodes' ) => 'rand',
         ),
         "description" => esc_html__("Select how to sort retrieved posts.", "villenoir-shortcodes"),
         'group' => esc_html__( 'Data filter', 'villenoir-shortcodes' ),
      ),
      array(
          'type' => 'textfield',
          'heading' => esc_html__( 'Meta key', 'villenoir-shortcodes' ),
          'param_name' => 'meta_key',
          'description' => esc_html__( 'Input meta key for grid ordering.', 'villenoir-shortcodes' ),
          'group' => esc_html__( 'Data filter', 'villenoir-shortcodes' ),
          'dependency' => array(
            'element' => 'orderby',
            'value' => array( 'meta_value', 'meta_value_num' ),
          ),
        ),
      array(
         "type" => "dropdown",
         "heading" => esc_html__("Sorting", "villenoir-shortcodes"),
         "param_name" => "order",
         "value" => array(
            "Descending" => "desc",
            "Ascending" => "asc"
         ),
         "description" => esc_html__("Designates the ascending or descending order.", "villenoir-shortcodes"),
         'group' => esc_html__( 'Data filter', 'villenoir-shortcodes' ),
      ),
      array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Extra class name', 'villenoir-shortcodes' ),
        'param_name' => 'el_class',
        'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file. For example add "rem_filter_border_top" to remove the filter border-top style.', 'villenoir-shortcodes' )
      ),
      $add_css_animation,

   )
) );
}

if ( !function_exists( 'productCategoryCategoryAutocompleteSuggester' ) ) {
  function productCategoryCategoryAutocompleteSuggester( $query, $slug = false ) {
    global $wpdb;
    $cat_id = (int) $query;
    $query = trim( $query );
    $post_meta_infos = $wpdb->get_results(
      $wpdb->prepare( "SELECT a.term_id AS id, b.name as name, b.slug AS slug
            FROM {$wpdb->term_taxonomy} AS a
            INNER JOIN {$wpdb->terms} AS b ON b.term_id = a.term_id
            WHERE a.taxonomy = 'product_cat' AND (a.term_id = '%d' OR b.slug LIKE '%%%s%%' OR b.name LIKE '%%%s%%' )",
        $cat_id > 0 ? $cat_id : - 1, stripslashes( $query ), stripslashes( $query ) ), ARRAY_A );

    $result = array();
    if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
      foreach ( $post_meta_infos as $value ) {
        $data = array();
        $data['value'] = $slug ? $value['slug'] : $value['id'];
        $data['label'] = esc_html__( 'Id', 'villenoir-shortcodes' ) . ': ' .
                         $value['id'] .
                         ( ( strlen( $value['name'] ) > 0 ) ? ' - ' . esc_html__( 'Name', 'villenoir-shortcodes' ) . ': ' .
                                                              $value['name'] : '' ) .
                         ( ( strlen( $value['slug'] ) > 0 ) ? ' - ' . esc_html__( 'Slug', 'villenoir-shortcodes' ) . ': ' .
                                                              $value['slug'] : '' );
        $result[] = $data;
      }
    }

    return $result;
  }
add_filter( 'vc_autocomplete_products_grid_products_grid_terms_callback', 'productCategoryCategoryAutocompleteSuggester', 10, 1 ); // Get suggestion(find). Must return an array
}

if ( !function_exists( 'productCategoryCategoryRenderByIdExact' ) ) {
    function productCategoryCategoryRenderByIdExact( $query ) {
        global $wpdb;
        $query = $query['value'];
        $cat_id = (int) $query;
        $term = get_term( $cat_id, 'product_cat' );

        return productCategoryTermOutput( $term );
    }

    add_filter( 'vc_autocomplete_products_grid_products_grid_terms_render', 'productCategoryCategoryRenderByIdExact', 10, 1 ); // Render exact category by id. Must return an array (label,value)
}

if ( !function_exists( 'productCategoryCategoryAutocompleteSuggesterBySlug' ) ) {
    function productCategoryCategoryAutocompleteSuggesterBySlug( $query ) {
        $result = productCategoryCategoryAutocompleteSuggester( $query, true );

        return $result;
    }
}

if ( !function_exists( 'productCategoryCategoryRenderBySlugExact' ) ) {
    function productCategoryCategoryRenderBySlugExact( $query ) {
        global $wpdb;
        $query = $query['value'];
        $query = trim( $query );
        $term = get_term_by( 'slug', $query, 'product_cat' );

        return productCategoryTermOutput( $term );
    }
}

if ( !function_exists( 'productCategoryCategoryRenderBySlugExact' ) ) {
    function productCategoryCategoryRenderBySlugExact( $term ) {
        $term_slug = $term->slug;
        $term_title = $term->name;
        $term_id = $term->term_id;

        $term_slug_display = '';
        if ( ! empty( $term_sku ) ) {
        $term_slug_display = ' - ' . esc_html__( 'Sku', 'villenoir-shortcodes' ) . ': ' . $term_slug;
        }

        $term_title_display = '';
        if ( ! empty( $product_title ) ) {
        $term_title_display = ' - ' . esc_html__( 'Title', 'villenoir-shortcodes' ) . ': ' . $term_title;
        }

        $term_id_display = esc_html__( 'Id', 'villenoir-shortcodes' ) . ': ' . $term_id;

        $data = array();
        $data['value'] = $term_id;
        $data['label'] = $term_id_display . $term_title_display . $term_slug_display;

        return ! empty( $data ) ? $data : false;
    }
}



?>