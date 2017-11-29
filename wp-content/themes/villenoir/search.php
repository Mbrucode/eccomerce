<?php
/**
 * Search Results Template
 *
 * @package WordPress
 * @subpackage villenoir
 */
get_header(); ?>

<section id="content">
    <div class="container">
        <div class="row">
            <div class="<?php villenoir_page_container(); ?>">

            <?php if ( have_posts() ) : ?>
    		<div class="gg_posts_grid">
                <ul class="el-grid no_magnific" data-layout-mode="masonry" data-gap="gap" data-columns="2">
                <?php while (have_posts()) : the_post(); ?>

                    <?php if( 'product' == get_post_type() ): ?>      
                        <li class="isotope-item col-xs-6 col-md-6 product"><?php wc_get_template_part( 'content', 'product-vc' ); ?></li>
                    <?php // for any other post type ?>

                    <?php else : ?>
                        <li class="isotope-item col-xs-6 col-md-6"><?php get_template_part( 'parts/post-formats/part', get_post_format() ); ?></li>      
                    <?php endif; ?>

                <?php endwhile; ?>
                </ul>
            </div>

            <?php if (function_exists("villenoir_pagination")) {
                villenoir_pagination();
            } ?>

            <?php // If no content, include the "No posts found" template.
            else :
                get_template_part( 'parts/post-formats/part', 'none' );
            endif;
            ?>

            </div><!-- end page container -->
            <?php villenoir_page_sidebar(); ?>

        </div><!-- .row -->
    </div><!-- .container -->    
</section>

<?php get_footer(); ?>