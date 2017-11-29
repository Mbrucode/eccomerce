<?php
if ( ! class_exists( 'WPBakeryShortCode_gg_contact_form' ) ) {

	class WPBakeryShortCode_gg_contact_form extends WPBakeryShortCode {

	   public function __construct() {  
			 add_shortcode('contact_form', array($this, 'gg_contact_form'));  
	   }

	   public function gg_contact_form( $atts, $content = null ) { 

			 $output = $email_address = $success_message = $error_message = '';
			 extract(shortcode_atts(array(
				 'form_title' => '',
				 'email_address'    => '',
				 'success_message'  => 'Your message was sent successfully.',
				 'error_message'   => 'There was an error submitting the form.'
			 ), $atts));

			  ob_start();
			  set_query_var( 'form_title', $form_title );
			  set_query_var( 'email_address', $email_address );
			  set_query_var( 'success_message', $success_message );
			  set_query_var( 'error_message', $error_message );

			  get_template_part( 'parts/forms/part','contact-miniform' );
			  $output .= "\n\t".ob_get_contents();
			  ob_end_clean();

			 return $output;
			 
	   }

	}// END class WPBakeryShortCode_gg_contact_form

	$WPBakeryShortCode_gg_contact_form = new WPBakeryShortCode_gg_contact_form();

}// END if ( ! class_exists( 'WPBakeryShortCode_gg_contact_form' ) ) { 

if ( function_exists( 'vc_map' ) ) {

	vc_map( array(
	   "name"              => esc_html__("Contact form","villenoir-shortcodes"),
	   "description"       => esc_html__('Display a mini contact form.', 'villenoir-shortcodes'),
	   "base"              => "contact_form",
	   "icon"              => "gg_vc_icon",
	   "weight"            => -50,
	   'admin_enqueue_css' => array(VILLENOIR_SHORTCODES_DIR . '/shortcodes/css/styles.css'),
	   "category"          => esc_html__('Villenoir', 'villenoir-shortcodes'),
	   "params" => array(
		  array(
			 "type" => "textfield",
			 "heading" => esc_html__("Form title","villenoir-shortcodes"),
			 "param_name" => "form_title",
			 "value" => '',
			 "admin_label" => true,
			 "description" => esc_html__("Insert widget title here","villenoir-shortcodes")
		  ),
		  array(
			 "type" => "textfield",
			 "heading" => esc_html__("Email","villenoir-shortcodes"),
			 "param_name" => "email_address",
			 "admin_label" => true,
			 "description" => esc_html__("Insert the contact form email here.","villenoir-shortcodes")
		  ),
		  array(
			  "type" => "textfield",
			  "heading" => esc_html__('Success message', 'villenoir-shortcodes'),
			  "param_name" => "success_message",
			  "value" => 'Your message was sent successfully.',
			  "description" => esc_html__("Insert the success message.", "villenoir-shortcodes")
		  ),
		  array(
			  "type" => "textfield",
			  "heading" => esc_html__('Error message', 'villenoir-shortcodes'),
			  "param_name" => "error_message",
			  "value" => 'There was an error submitting the form.',
			  "description" => esc_html__("Insert the error message.", "villenoir-shortcodes")
		  ),

		  $add_css_animation,

	   )
	) );

}

?>