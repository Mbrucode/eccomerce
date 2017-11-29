<?php
/**
 * Footer
 *
 * @package WordPress
 * @subpackage villenoir
 */
?>
    
    
    <footer class="site-footer">

        <div class="container">
            <div class="row">

            <?php villenoir_footer_info_module(); ?>

            <?php if( _get_field('gg_footer_widgets', 'option', false) ) : ?>
            <div class="footer-widgets col-md-12">
                <?php get_sidebar("footer"); ?>
            </div>
            <?php endif; ?>
            
            <?php villenoir_footer_extras(); ?>

            </div><!-- .row -->
        </div><!-- /.container -->
    </footer>


    <?php villenoir_footer_scripts(); ?>

    <?php wp_footer(); ?>
    </body>
</html>