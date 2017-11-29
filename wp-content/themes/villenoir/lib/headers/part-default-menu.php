<nav class="navbar navbar-default">
    <div class="container navbar-header-wrapper">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar-collapse">
                <span class="sr-only"><?php esc_html_e('Toggle navigation','villenoir'); ?></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <div class="logo-wrapper">
                <?php villenoir_logo(); ?>
            </div><!-- .logo-wrapper -->

        </div><!-- .navbar-header -->

        <div class="navbar-collapse collapse" id="main-navbar-collapse">
            <div class="container-flex">
                
                <div class="navbar-flex">&nbsp;</div>

                <!-- Begin Main Navigation -->
                <?php
                wp_nav_menu(
                    array(
                        'theme_location'    => 'main-menu',
                        'container'         => '',
                        'container_class'   => '',
                        'menu_class'        => 'nav navbar-nav navbar-middle navbar-flex',
                        'fallback_cb'       => 'villenoir_navwalker::fallback',
                        'menu_id'           => 'main-menu',
                        'walker'            => new villenoir_navwalker()
                    )
                ); ?>
                <!-- End Main Navigation -->

                <!-- Begin Second Navigation -->
                <?php villenoir_secondary_navigation(); ?>
                <!-- End Second Navigation -->

            </div>
        </div><!-- .navbar-collapse collapse -->

    </div><!-- .container -->
</nav><!-- nav -->
