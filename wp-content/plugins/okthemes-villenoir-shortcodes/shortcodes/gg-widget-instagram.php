<?php
if ( ! class_exists( 'WPBakeryShortCode_gg_Widget_Instagram' ) ) {
class WPBakeryShortCode_gg_Widget_Instagram extends WPBakeryShortCode {

   public function __construct() {  
         add_shortcode('widget_instagram', array($this, 'gg_widget_instagram'));  
   }

   public function gg_widget_instagram( $atts, $content = null ) { 

         $output = $title = $username = $posts = '';
         extract(shortcode_atts(array(
               'title'    => '',
               'username' => '',
               'link'     => 'Follow us',
               'number'    => 9,
               'followers'    => ''
         ), $atts));

         
         $output = '<div class="vc_widget vc_widget_instagram">';
         $type = 'villenoir_Instagram_Widget';
         $args = array();

         ob_start();
         the_widget( $type, $atts, $args );
         $output .= ob_get_clean();

         $output .= '</div>';

         return $output;
   }
}// END class WPBakeryShortCode_gg_Widget_Instagram

$WPBakeryShortCode_gg_Widget_Instagram = new WPBakeryShortCode_gg_Widget_Instagram();

}// END if ( ! class_exists( 'WPBakeryShortCode_gg_Widget_Instagram' ) ) { 

if ( function_exists( 'vc_map' ) ) {

vc_map( array(
   "name"              => esc_html__("Widget: Instagram", "villenoir-shortcodes"),
   "description"       => esc_html__('Display Instagram posts.', 'villenoir-shortcodes'),
   "base"              => "widget_instagram",
   "weight"            => -50,
   "icon"              => "gg_vc_icon",
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
         "heading" => esc_html__("Username", "villenoir-shortcodes"),
         "param_name" => "username",
         "admin_label" => true,
         "description" => esc_html__("Insert username here.", "villenoir-shortcodes")
      ),
      array(
         "type" => "textfield",
         "heading" => esc_html__("Link", "villenoir-shortcodes"),
         "param_name" => "link",
         "description" => esc_html__("Insert your link text", "villenoir-shortcodes")
      ),
      array(
         "type" => "textfield",
         "heading" => esc_html__("Number of posts to display", "villenoir-shortcodes"),
         "param_name" => "number",
         "description" => esc_html__("Insert number of posts to display here.", "villenoir-shortcodes")
      ),
      array(
         "type" => "textfield",
         "heading" => esc_html__("Number of followers", "villenoir-shortcodes"),
         "param_name" => "followers",
         "description" => esc_html__("Insert number of followers.", "villenoir-shortcodes")
      ),
   )
) );
}

?>