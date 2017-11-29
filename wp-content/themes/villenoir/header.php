<?php
/**
 * Default Page Header
 *
 * @package WordPress
 * @subpackage villenoir
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<header class="site-header default">

<?php get_template_part( 'lib/headers/part','default-menu' ); ?>

<?php villenoir_page_header(); ?>

</header>
<!-- End Header. Begin Template Content -->