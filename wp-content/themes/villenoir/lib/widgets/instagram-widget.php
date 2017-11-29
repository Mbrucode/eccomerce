<?php
function register_villenoir_Instagram_Widget() {
	register_widget( 'villenoir_Instagram_Widget' );
}
add_action( 'widgets_init', 'register_villenoir_Instagram_Widget' );

class villenoir_Instagram_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'gg-instagram-feed',
			esc_html__( 'Instagram', 'villenoir' ),
			array( 'classname' => 'gg-instagram-feed', 'description' => esc_html__( 'Displays your latest Instagram photos', 'villenoir' ) )
		);
	}

	function widget( $args, $instance ) {

		extract( $args, EXTR_SKIP );

		$title = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
		$username = empty( $instance['username'] ) ? '' : $instance['username'];
		$limit = empty( $instance['number'] ) ? 9 : $instance['number'];
		$followers = empty( $instance['followers'] ) ? '' : $instance['followers'];
		$link = empty( $instance['link'] ) ? '' : $instance['link'];

		echo wp_kses_post($before_widget);
		?>
		<div class="media">
		<div class="media-left">
		<?php 
		if ( ! empty( $title ) ) { 
			echo wp_kses_post($before_title . $title . $after_title);
		}
		?>

		<?php
		if ( $followers != '' ) { ?>
		<p class="followers"><?php echo esc_html($followers); ?>
			<span><?php esc_html_e('Instagram Followers', 'villenoir'); ?></span>
		</p>
		<?php } ?>

		<?php if ( $link != '' ) { ?>
		<a class="btn btn-secondary" href="//instagram.com/<?php echo esc_attr( trim( $username ) ); ?>" rel="me"><?php echo esc_html($link); ?></a>
		<?php } ?>
		</div> <!-- .media-left -->

		<div class="media-body">
		<?php
		if ( $username != '' ) {

			$media_array = $this->scrape_instagram( $username, $limit );

			if ( is_wp_error( $media_array ) ) {

				echo wp_kses_post($media_array->get_error_message());

			} else {

				// filter for images only?
				$media_array = array_filter( $media_array, array( $this, 'images_only' ) );
				$media_array = array_slice( $media_array, 0, $limit );

				// filters for custom classes
				$liclass = esc_attr( apply_filters( 'wpiw_item_class', '' ) );
				$aclass = esc_attr( apply_filters( 'wpiw_a_class', '' ) );
				$imgclass = esc_attr( apply_filters( 'wpiw_img_class', '' ) );

				?>
				<ul class="instagram-pics">

				<?php 
				foreach ( $media_array as $item ) {
					echo '<li class="'. $liclass .'"><a href="'. esc_url( $item->link ) .'"   class="'. $aclass .'"><img src="'. esc_url( $item->large ) .'"  alt="'. esc_attr( $item->description ) .'" title="'. esc_attr( $item->description ).'"  class="'. $imgclass .'"/></a></li>';
				}
				?>

				</ul>
				<?php
			}
		}
		?>
		</div><!-- .media-body -->
		</div><!-- .media -->
		
		<?php
		echo wp_kses_post($after_widget);
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => esc_html__( 'Instagram', 'villenoir' ), 'username' => '', 'followers' => '', 'link' => esc_html__( 'Follow Us', 'villenoir' ), 'number' => 9 ) );
		$title     = esc_attr( $instance['title'] );
		$username  = esc_attr( $instance['username'] );
		$number    = absint( $instance['number'] );
		$followers = esc_attr( $instance['followers'] );
		$link      = esc_attr( $instance['link'] );
		?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title', 'villenoir' ); ?>: <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_html($title); ?>" /></label></p>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'username' )); ?>"><?php esc_html_e( 'Username', 'villenoir' ); ?>: <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'username' ) ); ?>" name="<?php echo esc_attr($this->get_field_name( 'username' ) ); ?>" type="text" value="<?php echo esc_html($username); ?>" /></label></p>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e( 'Number of photos', 'villenoir' ); ?>: <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr($this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_html($number); ?>" /></label></p>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'followers' )); ?>"><?php esc_html_e( 'Number of followers', 'villenoir' ); ?>: <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'followers' ) ); ?>" name="<?php echo esc_attr($this->get_field_name( 'followers' ) ); ?>" type="text" value="<?php echo esc_html($followers); ?>" /></label></p>
		
		<p><label for="<?php echo esc_attr($this->get_field_id( 'link' )); ?>"><?php esc_html_e( 'Link text', 'villenoir' ); ?>: <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'link' ) ); ?>" name="<?php echo esc_attr($this->get_field_name( 'link' ) ); ?>" type="text" value="<?php echo esc_attr($link); ?>" /></label></p>
		<?php

	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title']     = strip_tags( $new_instance['title'] );
		$instance['username']  = trim( strip_tags( $new_instance['username'] ) );
		$instance['number']    = ! absint( $new_instance['number'] ) ? 9 : $new_instance['number'];
		$instance['followers'] = trim( strip_tags( $new_instance['followers'] ) );
		$instance['link']      = strip_tags( $new_instance['link'] );
		return $instance;
	}

	// based on https://gist.github.com/cosmocatalano/4544576
	function scrape_instagram( $username, $slice = 9 ) {

		$username = strtolower( $username );
		$username = str_replace( '@', '', $username );

		if ( false === ( $instagram = get_transient( 'instagram-media-5-'.sanitize_title_with_dashes( $username ) ) ) ) {

			$remote = wp_remote_get( 'http://instagram.com/'.trim( $username ) );

			if ( is_wp_error( $remote ) )
				return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'villenoir' ) );

			if ( 200 != wp_remote_retrieve_response_code( $remote ) )
				return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'villenoir' ) );

			$shards = explode( 'window._sharedData = ', $remote['body'] );
			$insta_json = explode( ';</script>', $shards[1] );
			$insta_array = json_decode( $insta_json[0], TRUE );

			if ( ! $insta_array )
				return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'villenoir' ) );

			if ( isset( $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'] ) ) {
				$images = $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'];
			} else {
				return new WP_Error( 'bad_json_2', esc_html__( 'Instagram has returned invalid data.', 'villenoir' ) );
			}

			if ( ! is_array( $images ) )
				return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data.', 'villenoir' ) );

			$instagram = array();

			foreach ( $images as $image ) {

				$image['thumbnail_src'] = preg_replace( "/^https:/i", "", $image['thumbnail_src'] );
				$image['thumbnail']     = str_replace( 's640x640', 's160x160', $image['thumbnail_src'] );
				$image['small']         = str_replace( 's640x640', 's320x320', $image['thumbnail_src'] );
				$image['large']         = $image['thumbnail_src'];
				$image['display_src']   = preg_replace( "/^https:/i", "", $image['display_src'] );

				if ( $image['is_video'] == true ) {
					$type = 'video';
				} else {
					$type = 'image';
				}

				$caption = esc_html__( 'Instagram Image', 'villenoir' );
				if ( ! empty( $image['caption'] ) ) {
					$caption = $image['caption'];
				}

				$instagram[] = array(
					'description'   => $caption,
					'link'		  	=> '//instagram.com/p/' . $image['code'],
					'time'		  	=> $image['date'],
					'comments'	  	=> $image['comments']['count'],
					'likes'		 	=> $image['likes']['count'],
					'thumbnail'	 	=> $image['thumbnail'],
					'small'			=> $image['small'],
					'large'			=> $image['large'],
					'original'		=> $image['display_src'],
					'type'		  	=> $type
				);
			}

			// do not set an empty transient - should help catch private or empty accounts
			if ( ! empty( $instagram ) ) {
				$instagram = json_encode( $instagram );
				set_transient( 'instagram-media-5-'.sanitize_title_with_dashes( $username ), $instagram, apply_filters( 'null_instagram_cache_time', HOUR_IN_SECONDS*2 ) );
			}
		}

		if ( ! empty( $instagram ) ) {

			$instagram = json_decode( $instagram );

			//return array_slice( $instagram, 0, $slice );
			return $instagram;

		} else {

			return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'villenoir' ) );

		}
	}

	function images_only( $media_item ) {

		if ( $media_item->type == 'image' )
			return true;

		return false;
	}
}
