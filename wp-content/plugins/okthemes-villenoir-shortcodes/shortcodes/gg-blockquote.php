<?php
if ( ! class_exists( 'WPBakeryShortCode_gg_blockquote' ) ) {
	
	class WPBakeryShortCode_gg_blockquote extends WPBakeryShortCode {

		public function __construct() {  
			add_shortcode('blockquote', array($this, 'gg_blockquote'));  
		}

		public function gg_blockquote( $atts, $content = null ) { 

			$output = $quote = $quote_color_style = $quote_color = '';
			extract(shortcode_atts(array(
				 'quote'       => '',
				 'quote_color' => ''
			), $atts));

			if ($quote_color != '') {
				$quote_color_style = 'style="color: '.$quote_color.';"';
			}

			$output .= "\n\t".'<blockquote '.$quote_color_style.' class="gg-vc-quote">';
			$output .= "\n\t".$quote;
			$output .= "\n\t".'</blockquote>';

			return $output;
		}
		
	}// END class WPBakeryShortCode_gg_blockquote

	$WPBakeryShortCode_gg_blockquote = new WPBakeryShortCode_gg_blockquote();

}// END if ( ! class_exists( 'WPBakeryShortCode_gg_blockquote' ) ) {


if ( function_exists( 'vc_map' ) ) {

	vc_map( array(
		 "name" => esc_html__("Blockquote", "villenoir-shortcodes"),
		 "description" => esc_html__('Display a blockquote.', 'villenoir-shortcodes'),
		 "base" => "blockquote",
		 "icon"              => "gg_vc_icon",
		 'admin_enqueue_css' => array(VILLENOIR_SHORTCODES_DIR . '/shortcodes/css/styles.css'),
		 'admin_enqueue_js' => array(VILLENOIR_SHORTCODES_DIR . '/shortcodes/js/custom-vc.js'),
		 "category" => esc_html__('Villenoir', 'villenoir-shortcodes'),
		 "params" => array(
				array(
					 "type" => "textarea",
					 "heading" => esc_html__("Quote", "villenoir-shortcodes"),
					 "param_name" => "quote",
					 "admin_label" => true,
					 "description" => esc_html__("Insert quote content here", "villenoir-shortcodes")
				),
				array(
					"type" => "colorpicker",
					"heading" => esc_html__("Quote color", "villenoir-shortcodes"),
					"param_name" => "quote_color"
				),
		 ),
	) );
}

?>