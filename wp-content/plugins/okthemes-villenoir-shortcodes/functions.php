<?php
/**
 * Get tax term slug
 */
if (!function_exists('villenoir_shortcodes_tax_terms_slug')) :
	function villenoir_shortcodes_tax_terms_slug($taxonomy) {
		global $post, $post_id;
		$return = '';
		// get post by post id
		$post = get_post($post->ID);
		// get post type by post
		$post_type = $post->post_type;
		// get post type taxonomies
		$terms = get_the_terms( $post->ID, $taxonomy );
		if ( !empty( $terms ) ) {
			$out = array();
			foreach ( $terms as $term )
				$out[] = 'grid-cat-' . $term->slug;
			$return = join( ' ', $out );
		}
		return $return;
	}
endif;