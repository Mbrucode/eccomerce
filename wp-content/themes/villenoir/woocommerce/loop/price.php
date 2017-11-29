<?php
/**
 * Loop Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

?>

<?php
// Get the year
$wine_year = get_post_meta( get_the_ID(), '_year_field', true );
//Check if year field is hidden from the theme options
if ( _get_field('gg_store_year_field','option', true) !== true ) {
	$wine_year = false;
}
// Get the shop style
$shop_style = _get_field('gg_shop_product_style','option', 'style1');

if ( isset( $_GET['shop_style'] ) ) {
   $shop_style = $_GET['shop_style'];
}

?>

<?php if ( $shop_style == 'style1' ) : ?>
<dl>
	<?php if ( $wine_year ) : ?>
	<dt>
		<?php esc_html_e('Year','woocommerce'); ?>
	</dt>
	<dd>
		<span class="year"><?php echo esc_html($wine_year); ?></span>
	</dd>
	<?php endif; ?>

	<?php if ( $price_html = $product->get_price_html() ) : ?>
	<dt>
		<?php esc_html_e('Price','woocommerce'); ?>
	</dt>
	<dd>
		<span class="price"><?php echo $price_html; ?></span>
	</dd>
	<?php endif; ?>
</dl>
<?php elseif ( $shop_style == 'style2' ) : ?>
<dl>
	<?php if ( $wine_year ) : ?>
	<dt>
		<span class="year"><?php echo esc_html($wine_year); ?></span>
	</dt>
	<?php endif; ?>

	<?php if ( $price_html = $product->get_price_html() ) : ?>
	<dd>
		<span class="price"><?php echo $price_html; ?></span>
	</dd>
	<?php endif; ?>
</dl>
<?php elseif ( $shop_style == 'style3' ) : ?>
	<?php if ( $price_html = $product->get_price_html() ) : ?>
		<span class="price"><?php echo $price_html; ?></span>
	<?php endif; ?>
<?php else: ?>
	<?php if ( $price_html = $product->get_price_html() ) : ?>
		<span class="price"><?php echo $price_html; ?></span>
	<?php endif; ?>
<?php endif; ?>




