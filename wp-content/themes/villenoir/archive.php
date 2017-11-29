<?php
/**
 * The template for displaying Archive pages.
 *
 * @package WordPress
 * @subpackage villenoir
 */
get_header(); ?>

<?php
?>

<section id="content">
    <div class="container">
        <div class="row">
            <div class="<?php villenoir_page_container('special_page'); ?>">

            <?php if (have_posts()) :
            // Queue the first post.
            the_post();
            // Rewind the loop back
            rewind_posts();
            ?>
            <div class="gg_posts_grid">
                <ul class="el-grid no_magnific" data-layout-mode="fitRows" data-gap="gap" data-columns="1">
                
                <?php while (have_posts()) : the_post(); ?>

                    <li class="isotope-item col-xs-6 col-md-12">
                        <?php get_template_part( 'parts/post-formats/part', get_post_format() ); ?>
                    </li>      

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

            </div>
            <?php villenoir_page_sidebar('special_page'); ?>

        </div><!-- .row -->
    </div><!-- .container -->    
</section>

<?php get_footer(); ?>