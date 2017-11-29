<?php
/**
 * Fullscreen Search Form
 *
 * @package WordPress
 * @subpackage villenoir
 */
?>

<div id="fullscreen-searchform">
    <button type="button" class="close">x</button>
    <form method="get" id="searchform" class="" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<input type="search" value="<?php the_search_query(); ?>" placeholder="<?php esc_attr_e( 'search for products', 'villenoir' ); ?>" name="s" id="s" />
		<button type="submit" id="searchsubmit" class="btn btn-primary"><?php esc_attr_e( 'Search', 'villenoir' ); ?></button>
	</form>
</div>
