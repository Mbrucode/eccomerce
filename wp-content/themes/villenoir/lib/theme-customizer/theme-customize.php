<?php
//Inline custom_css print
function villenoir_generate_dynamic_css() {
	/** Capture CSS output **/
	ob_start();// Capture all output into buffer
	require('custom_css.php');
	$css = ob_get_clean();// Store output in a variable, then flush the buffer
	$css = strip_tags($css);
	echo '<style id=\'gg-dynamic-css\' type=\'text/css\'>'.$css.'</style>';
}

if ( ! is_admin() ) {
	add_action( 'wp_head', 'villenoir_generate_dynamic_css');
}

?>