<?php
$headings_array = array(
	esc_html__("Heading 1", "villenoir-shortcodes")         => "h1", 
	esc_html__("Heading 2", "villenoir-shortcodes")         => "h2", 
	esc_html__("Heading 3", "villenoir-shortcodes")         => "h3", 
	esc_html__("Heading 4", "villenoir-shortcodes")         => "h4",
	esc_html__("Heading 5", "villenoir-shortcodes")         => "h5",
	esc_html__("Heading 6", "villenoir-shortcodes")         => "h6"
);

$add_css_animation = array(
	"type"        => "dropdown",
	"heading"     => esc_html__("CSS Animation", "villenoir-shortcodes"),
	"param_name"  => "css_animation",
	"admin_label" => true,
	"value"       => array(esc_html__("No", "villenoir-shortcodes") => '', esc_html__("Top to bottom", "villenoir-shortcodes") => "top-to-bottom", esc_html__("Bottom to top", "villenoir-shortcodes") => "bottom-to-top", esc_html__("Left to right", "villenoir-shortcodes") => "left-to-right", esc_html__("Right to left", "villenoir-shortcodes") => "right-to-left", esc_html__("Appear from center", "villenoir-shortcodes") => "appear"),
	"description" => esc_html__("Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "villenoir-shortcodes")
  );

$img_style_arr = array(
	esc_html__( 'Default (Square corners)', 'villenoir-shortcodes' ) => "default",
	esc_html__( 'Rounded corners', 'villenoir-shortcodes' )          => "rounded",
	esc_html__( 'Circle', 'villenoir-shortcodes' )                   => "circle"
);

// Initialising Shortcodes
if ( class_exists('WPBakeryVisualComposerAbstract') ) {

   /**
	* Taxonomy checkbox list field.
	*
	*/
   if ( ! function_exists( 'gg_taxonomy_settings_field' ) ) {
   	
   function gg_taxonomy_settings_field($settings, $value) {
	  $dependency = vc_generate_dependencies_attributes($settings);

	  $terms_fields = array();
	  $terms_slugs = array();

	  $value_arr = $value;
	  if ( !is_array($value_arr) ) {
		 $value_arr = array_map( 'trim', explode(',', $value_arr) );
	  }

	  if ( !empty($settings['taxonomy']) ) {

		 $terms = get_terms( $settings['taxonomy'] );
		 if ( $terms && !is_wp_error($terms) ) {

			foreach( $terms as $term ) {
			   $terms_slugs[] = $term->slug;

			   $terms_fields[] = sprintf(
				  '<label><input id="%s" class="%s" type="checkbox" name="%s" value="%s" %s/>%s</label>',
				  $settings['param_name'] . '-' . $term->slug,
				  $settings['param_name'].' '.$settings['type'],
				  $settings['param_name'],
				  $term->term_id,
				  checked( in_array( $term->term_id, $value_arr ), true, false ),
				  $term->name
			   );
			}
		 }
	  }

	  return '<div class="gg_taxonomy_block">'
			.'<input type="hidden" name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-checkboxes '.$settings['param_name'].' '.$settings['type'].'_field" value="'.$value.'" '.$dependency.' />'
			 .'<div class="gg_taxonomy_terms">'
			 .implode( $terms_fields )
			 .'</div>'
		  .'</div>';
   }
   vc_add_shortcode_param('gg_taxonomy', 'gg_taxonomy_settings_field', VILLENOIR_SHORTCODES_DIR . '/shortcodes/js/gg-taxonomy.js' );
   }

   /**
	* Posts checkbox list field.
	*
	*/
   if ( ! function_exists( 'gg_posttype_settings_field' ) ) {
   function gg_posttype_settings_field($settings, $value) {
	  $dependency = vc_generate_dependencies_attributes($settings);

	  $posts_fields = array();
	  $terms_slugs = array();

	  $value_arr = $value;
	  if ( !is_array($value_arr) ) {
		 $value_arr = array_map( 'trim', explode(',', $value_arr) );
	  }

	  if ( !empty($settings['posttype']) ) {

		 $args = array(
			'no_found_rows' => 1,
			'ignore_sticky_posts' => 1,
			'posts_per_page' => -1,
			'post_type' => $settings['posttype'],
			'post_status' => 'publish',
			'orderby' => 'date',
			'order' => 'DESC'
		 );

		 $gg_query = new WP_Query( $args );
		 if ( $gg_query->have_posts() ) {

			foreach( $gg_query->posts as $p ) {

			   $posts_fields[] = sprintf(
				  '<label><input id="%s" class="%s" type="checkbox" name="%s" value="%s" %s/>%s</label>',
				  $settings['param_name'] . '-' . $p->post_name,
				  $settings['param_name'] . ' ' . $settings['type'],
				  $settings['param_name'],
				  $p->post_name,
				  checked( in_array( $p->post_name, $value_arr ), true, false ),
				  $p->post_title
			   );
			}
		 }
	  }

	  return '<div class="gg_posttype_block">'
			.'<input type="hidden" name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-checkboxes '.$settings['param_name'].' '.$settings['type'].'_field" value="'.$value.'" '.$dependency.' />'
			 .'<div class="gg_posttype_post">'
			 .implode( $posts_fields )
			 .'</div>'
		  .'</div>';
   }
   
   vc_add_shortcode_param('gg_posttype', 'gg_posttype_settings_field', VILLENOIR_SHORTCODES_DIR . '/shortcodes/js/gg-posttype.js' );
  }
}