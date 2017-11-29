<?php
if ( ! class_exists( 'WPBakeryShortCode_gg_featured_image' ) ) {
class WPBakeryShortCode_gg_featured_image extends WPBakeryShortCode {

   public function __construct() {  
		 add_shortcode('featured_image', array($this, 'gg_featured_image'));  
   }

   public function gg_featured_image( $atts, $content = null ) { 

		 $output = $featured_link_open = $featured_link_close = $img_style_class = $featured_box_style_cls = $featured_title = $image = '';
		 extract(shortcode_atts(array(
			 'featured_title'           => '',
			 'featured_desc'            => '',
			 'featured_link'            => '',
			 'featured_box_style'       => 'normal',
			 'featured_box_text_align'  => 'left',
			 'image'                    => $image,
			 'img_size'                 => 'fullsize',
			 'img_style'                => 'default',
			 'customsize_width'         => '',
			 'customsize_height'        => '',
			 'el_class'                 => '',
			 'css_animation'            => ''
		 ), $atts));

		 $img_id = preg_replace('/[^\d]/', '', $image);

		 if ($img_id > 0) {
			$attachment_url = wp_get_attachment_url($img_id , 'full');
			$alt_text = get_post_meta($img_id, '_wp_attachment_image_alt', true);
			if ($img_size !== 'fullsize') {
				$thumbnail = ' <img class="wp-post-image '.$img_style.'" src="'.villenoir-shortcodes_aq_resize( $img_id, $customsize_width, $customsize_height, true, true ).'" alt="'.$alt_text.'" /> ';
			} else {
				$thumbnail = ' <img class="wp-post-image '.$img_style.'" src="'.esc_url($attachment_url).'" alt="'.esc_html($alt_text).'" /> ';          
			}
		}

		 $css_class = $this->getCSSAnimation($css_animation);
		 $css_class .= ' text-align-'.$featured_box_text_align;

		 if ($featured_box_style == 'overlay') {
		  $featured_box_style_cls .= ' sadie';
		 } else {
		  $featured_box_style_cls .= '';
		 }

		 

		$url = vc_build_link( $featured_link );
		
		  if ( strlen( $featured_link ) > 0 && strlen( $url['url'] ) > 0 ) {
			$featured_link_open = '<a href="' . esc_url( $url['url'] ) . '" title="' . esc_attr( $url['title'] ) . '" target="' . ( strlen( $url['target'] ) > 0 ? esc_attr( $url['target'] ) : '_self' ) . '">';
			$featured_link_close = '</a>';
			$featured_title_html = $featured_link_open.$featured_title.$featured_link_close;
			$thumbnail = $featured_link_open.$thumbnail.$featured_link_close;
		  } else {
			$featured_title_html = $featured_title;
		  }
		 
		 $output = "\n\t".'<div class="featured-image-box '.$css_class.'">';

		 $output .= "\n\t\t".'<figure class="'.$featured_box_style_cls.' '.$img_style.'">';
		 $output .= "\n\t\t\t".$thumbnail;
		 $output .= "\n\t\t".'<figcaption>';

		 if ($featured_box_style == 'overlay') {
		 $output .= "\n\t\t\t".$featured_link_open.$featured_link_close; 
		 $output .= "\n\t\t\t".'<h4>'.$featured_title.'</h4>';
		 } else {
		 $output .= "\n\t\t\t".'<h4>'.$featured_title_html.'</h4>'; 
		 }

		 $output .= "\n\t\t\t".'<p>'.$featured_desc.'</p>';
		 $output .= "\n\t\t".'</figcaption>';
		 $output .= "\n\t\t".'</figure>';
		 
		 $output .= "\n\t".'</div> ';

		 return $output;
		 
   }
}// END class WPBakeryShortCode_gg_featured_image

$WPBakeryShortCode_gg_featured_image = new WPBakeryShortCode_gg_featured_image();

}// END if ( ! class_exists( 'WPBakeryShortCode_gg_featured_image' ) ) { 

if ( function_exists( 'vc_map' ) ) {

vc_map( array(
   "name"              => esc_html__("Featured image box","villenoir-shortcodes"),
   "description"       => esc_html__('Image box with title and description.', 'villenoir-shortcodes'),
   "base"              => "featured_image",
   "icon"              => "gg_vc_icon",
   "weight"            => -50,
   'admin_enqueue_css' => array(VILLENOIR_SHORTCODES_DIR . '/shortcodes/css/styles.css'),
   'admin_enqueue_js'  => array(VILLENOIR_SHORTCODES_DIR . '/shortcodes/js/custom-vc.js'),
   "category"          => esc_html__('Villenoir', 'villenoir-shortcodes'),
   "params" => array(
	  array(
			"type" => "dropdown",
			"heading" => esc_html__("Box style", "villenoir-shortcodes"),
			"param_name" => "featured_box_style",
			"value" => array(esc_html__("Normal (text under the image)", "villenoir-shortcodes") => "normal", esc_html__("Overlay (text on the image)", "villenoir-shortcodes") => "overlay"),
			"description" => esc_html__("Choose the image size", "villenoir-shortcodes")
	  ),
	  array(
			"type" => "dropdown",
			"heading" => esc_html__("Box text align", "villenoir-shortcodes"),
			"param_name" => "featured_box_text_align",
			"value" => array(esc_html__("Left", "villenoir-shortcodes") => "left", esc_html__("Right", "villenoir-shortcodes") => "right", esc_html__("Center", "villenoir-shortcodes") => "center" ),
			"description" => esc_html__("Choose the image size", "villenoir-shortcodes")
	  ),
	  array(
		 "type" => "textfield",
		 "heading" => esc_html__("Title","villenoir-shortcodes"),
		 "param_name" => "featured_title",
		 "admin_label" => true,
		 "description" => esc_html__("Insert title here","villenoir-shortcodes")
	  ),
	  array(
		 "type" => "textarea",
		 "heading" => esc_html__("Description","villenoir-shortcodes"),
		 "param_name" => "featured_desc",
		 "description" => esc_html__("Insert short description here","villenoir-shortcodes")
	  ),
	  array(
		"type" => "vc_link",
		"heading" => esc_html__("URL (Link)", "villenoir-shortcodes"),
		"param_name" => "featured_link",
		"description" => esc_html__("Insert the link.", "villenoir-shortcodes"),
		"dependency" => Array('element' => "featured_title", 'not_empty' => true)
	  ),
	  array(
		 "type" => "attach_image",
		 "heading" => esc_html__("Featured image", "villenoir-shortcodes"),
		 "param_name" => "image",
		 "value" => "",
		 "description" => esc_html__("Select image from media library.", "villenoir-shortcodes")
	  ),
	  //Image size
	  array(
			"type" => "dropdown",
			"heading" => esc_html__("Image size", "villenoir-shortcodes"),
			"param_name" => "img_size",
			"value" => array(esc_html__("Full size", "villenoir-shortcodes") => "fullsize", esc_html__("Custom size", "villenoir-shortcodes") => "customsize"),
			"description" => esc_html__("Choose the image size", "villenoir-shortcodes")
	  ),
	  array(
		  "type" => "dropdown",
		  "heading" => esc_html__("Image style", "villenoir-shortcodes"),
		  "param_name" => "img_style",
		  "value" => $img_style_arr,
		  "std" => "default",
		  "description" => esc_html__("Choose the image style", "villenoir-shortcodes")
	  ),
	  array(
			"type" => "textfield",
			"heading" => esc_html__("Custom size - width", "villenoir-shortcodes"),
			"param_name" => "customsize_width",
			"description" => esc_html__("Insert the width of the image", "villenoir-shortcodes"),
			"dependency" => Array('element' => "img_size", 'value' => array('customsize'))
	  ),
	  array(
			"type" => "textfield",
			"heading" => esc_html__("Custom size - height", "villenoir-shortcodes"),
			"param_name" => "customsize_height",
			"description" => esc_html__("Insert the height of the image", "villenoir-shortcodes"),
			"dependency" => Array('element' => "img_size", 'value' => array('customsize'))
	  ),
	  $add_css_animation,
   ),
   'js_view'  => 'villenoir-shortcodesVcFeaturedImageView',
) );
}

?>