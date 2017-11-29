<?php

if ( class_exists('MC4WP_Form_Widget')  || ! class_exists( 'WPBakeryShortCode_gg_Widget_MailChimp' )) {

class WPBakeryShortCode_gg_Widget_MailChimp extends WPBakeryShortCode {

   public function __construct() {  
         add_shortcode('widget_mailchimp', array($this, 'gg_widget_mailchimp'));  
   }

   public function gg_widget_mailchimp( $atts, $content = null ) { 

         $output = $title = '';
         extract(shortcode_atts(array(
             'title'        => '',
             'extra_class' => ''
         ), $atts));

         
         $output = '<div class="vc_widget vc_widget_mailchimp '.$extra_class.'">';
         $type = 'MC4WP_Form_Widget';
         $args = array();

         ob_start();
         the_widget( $type, $atts, $args );
         $output .= ob_get_clean();

         $output .= '</div>';

         return $output;
   }
}// END class WPBakeryShortCode_gg_Widget_MailChimp

$WPBakeryShortCode_gg_Widget_MailChimp = new WPBakeryShortCode_gg_Widget_MailChimp();

}// END if ( ! class_exists( 'WPBakeryShortCode_gg_Widget_MailChimp' ) ) { 

if ( function_exists( 'vc_map' ) ) {

vc_map( array(
   "name"              => esc_html__("Widget: MailChimp", "villenoir-shortcodes"),
   "description"       => esc_html__('Display a MailChimp newsletter form', 'villenoir-shortcodes'),
   "base"              => "widget_mailchimp",
   "icon"              => "gg_vc_icon",
   "weight"            => -50,
   'admin_enqueue_css' => array(VILLENOIR_SHORTCODES_DIR . '/shortcodes/css/styles.css'),
   "category"          => esc_html__('Villenoir', 'villenoir-shortcodes'),
   "params" => array(
      array(
         "type" => "textfield",
         "heading" => esc_html__("Title", "villenoir-shortcodes"),
         "param_name" => "title",
         "description" => esc_html__("Insert title here", "villenoir-shortcodes")
      ),
      array(
         "type" => "textfield",
         "heading" => esc_html__("Extra class", "villenoir-shortcodes"),
         "param_name" => "extra_class",
         "description" => esc_html__("Insert an extra class to style the widget differently. This widget has already a class styled for dark background: contact_widget_dark ", "villenoir-shortcodes")
      ),

   )
) );

}

?>