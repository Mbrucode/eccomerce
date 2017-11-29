<?php
if ( ! class_exists( 'WPBakeryShortCode_gg_List' ) ) {
	
	class WPBakeryShortCode_gg_List extends WPBakeryShortCode {

	   public function __construct() {  
			 add_shortcode('list', array($this, 'gg_list'));  
	   }

	   public function gg_list( $atts, $content = null ) { 

			 $output = '';
			 extract(shortcode_atts(array(
				'list_style'  => 'remove', //remove,check
				'list_border' => '',
			 ), $atts));

			  $newcontent = preg_replace("/<p[^>]*?>/", "", $content);
			  $newcontent = str_replace("</p>", "<br />", $newcontent);

			 //Start the insanity
			 $output = '';
			 $output .= "\n\t".'<div class="gg_list list_style_'.$list_style.' ' . ( ($list_border == "yes") ? 'list_border_bottom' : '' ). '">'.wpb_js_remove_wpautop( $newcontent ).'</div>'; 
			 //return the output
			 return $output;
			 
	   }
	}// END class WPBakeryShortCode_gg_List

	$WPBakeryShortCode_gg_List = new WPBakeryShortCode_gg_List();

}// END if ( ! class_exists( 'WPBakeryShortCode_gg_List' ) ) { 

if ( function_exists( 'vc_map' ) ) {

vc_map( array(
   "name"              => esc_html__("List","villenoir-shortcodes"),
   "description"       => esc_html__('List element', 'villenoir-shortcodes'),
   "base"              => "list",
   "icon"              => "gg_vc_icon",
   "weight"            => -50,
   'admin_enqueue_css' => array(VILLENOIR_SHORTCODES_DIR . '/shortcodes/css/styles.css'),
   "category"          => esc_html__('Villenoir', 'villenoir-shortcodes'),
   "params" => array(
	  array(
		'type' => 'dropdown',
		'heading' => esc_html__( 'List style', 'villenoir-shortcodes' ),
		'param_name' => 'list_style',
		'value' => array(

		  esc_html__( 'Remove icn', 'villenoir-shortcodes' )       => 'remove',
		  esc_html__( 'Check icn', 'villenoir-shortcodes' )        => 'check',
		  esc_html__( 'Circle icn', 'villenoir-shortcodes' )       => 'circle',
		  esc_html__( 'Angle icn', 'villenoir-shortcodes' )        => 'angle',
		  esc_html__( 'Double angle icn', 'villenoir-shortcodes' ) => 'double-angle',
		  esc_html__( 'Caret', 'villenoir-shortcodes' )            => 'caret',
		  esc_html__( 'Heart', 'villenoir-shortcodes' )            => 'heart',
		  esc_html__( 'Horizontal line', 'villenoir-shortcodes' )  => 'line'
		),
		'description' => esc_html__( 'Select list icon', 'villenoir-shortcodes' ),
		"admin_label" => true,
	  ),
	  array(
		'type' => 'checkbox',
		'heading' => esc_html__( 'Show list item border?', 'villenoir-shortcodes' ),
		'param_name' => 'list_border',
		'description' => esc_html__( 'If checked, the list item will have a border', 'villenoir-shortcodes' ),
		'value' => array( esc_html__( 'Yes', 'villenoir-shortcodes' ) => 'yes' )
	  ),
	  array(
		'type' => 'textarea_html',
		'holder' => 'div',
		'heading' => esc_html__( 'Text', 'villenoir-shortcodes' ),
		'param_name' => 'content',
		'value' => wp_kses_post( '<ul><li>List item 1</li><li>List item 2</li><li>List item 3</li><li>List item 4</li></ul>', 'villenoir-shortcodes' )
	  ),
	  
   ),
) );
}

?>