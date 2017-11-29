<?php
/**
 * Adds villenoir_Contact_Widget widget.
 */
class villenoir_Flickr_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'villenoir_Flickr_Widget', // Base ID
			esc_html__('Flickr Widget', 'villenoir'), // Name
			array( 'description' => esc_html__( 'Display up to 20 of your latest Flickr submissions', 'villenoir' ), 'classname' => 'flickr-widget', ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 */
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );

		$username = ! empty( $instance['username'] ) ? $instance['username'] : '';
		$count = ! empty( $instance['count'] ) ? $instance['count'] : '';

		echo wp_kses_post($args['before_widget']);

		if ( ! empty( $title ) )
			echo wp_kses_post( $args['before_title'] . $title . $args['after_title'] );
				
		echo '<div class="clearfix"></div>';
		
		echo '<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count='. esc_html($count) . '&amp;display=latest&amp;size=s&amp;layout=x&amp;source=user&amp;user='. esc_html($username) .'"></script>';
		echo '<p class="flickr_stream_wrap"><a class="wpb_follow_btn wpb_flickr_stream" href="http://www.flickr.com/photos/'. esc_html($username) .'"><i class="fa fa-flickr"></i>'.esc_html__("View stream on flickr", "villenoir").'</a></p>';

		echo wp_kses_post($args['after_widget']);
	}
	

	/**
	 * Back-end widget form.
	 */
	public function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'username' => '', 'count' => '') );
		
		$title = isset( $instance['title'] ) ? $instance['title'] : esc_html__( 'Photostream', 'villenoir' );
		$username = isset( $instance['username'] ) ? $instance['username'] : '';
		$count = isset( $instance['count'] ) ? absint( $instance['count'] ) : 10;

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'villenoir' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>">
			<?php printf( wp_kses( __( 'Flickr ID (To find your flickID visit <a href="%s" target="_blank">idGettr</a>)', 'villenoir' ), array(  'a' => array( 'href' => array() ) ) ), 'http://idgettr.com/' ); ?>
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'username' ) ); ?>" type="text" value="<?php echo esc_attr( $username ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Count:', 'villenoir' ); ?></label><br />
			<input type="number" min="1" max="20" value="<?php echo esc_attr( $count ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" />
		</p>
		<?php 
	}


	/**
	 * Sanitize widget form values as they are saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();

		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['username'] = ( ! empty( $new_instance['username'] ) ) ? strip_tags( $new_instance['username'] ) : '';
		$instance['count'] = ( ! empty( $new_instance['count'] ) ) ? absint( $new_instance['count'] ) : '';
		
		return $instance;
	}


} // class villenoir_Flickr_Widget

// register villenoir_Flickr_Widget 
function register_villenoir_Flickr_Widget() {
    register_widget( 'villenoir_Flickr_Widget' );
}
add_action( 'widgets_init', 'register_villenoir_Flickr_Widget' );