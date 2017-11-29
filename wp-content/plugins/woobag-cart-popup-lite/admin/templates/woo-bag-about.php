<?php

function wb_about_template() { ?>
    <div class="wb_about_wrapper">
        <div class="row nopadding">
            <div class="col-lg-12 nopadding">
                <div class="col-md-3 wb_about_logo_wrapper">
                    <div class="wb_about_logo">
                        <img class="img-responsive" src="<?php echo WB()->wb_plugin_url() ?>/admin/images/wb_logo.png" />
                    </div>
                </div>
                <div class="col-md-9 wb_about_title nopadding">
                    <div class="col-md-12 nopadding">
                        <h1 class=""> <?php _e('About WooBag', 'woo-bag'); ?></h1>
                    </div>
                    <div class="col-md-12 wb_about_text_wrapper">
                        <div class="about-text wb_about_text">
                            <?php _e('WooBag Lite is a must have Wordpress WooCommerce Addon Plugin that gives you full control over design and behaviour of your cart popup.', 'woo-bag'); ?>

                        </div>
                    </div>
                    <div class="col-md-12 nopadding">
                        <div class="wb_about_actions">
                            <?php $wb_setting_url = admin_url('admin.php?page=woo-setting'); ?>
                            <p class="wb_actions">
                                <a class="button" href="<?php echo $wb_setting_url; ?>"><?php _e('Edit Settings  ', 'woo-bag'); ?></a>
                            </p>
                            <p class="wb_actions">
                                <a class="button" href="http://codecanyon.net/item/woobag-customize-your-cart-easily/12908527?ref=gatelogix">WooBag <?php _e('Premium', 'woo-bag'); ?></a>
                            </p>
                            <p class="wb_actions">
                                <a class="button" href="http://woobag.gatelogix.com/documentation/" target="_blank"><?php _e('Help  ', 'woo-bag'); ?></a>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-12 nopadding">
                <div class="text-center">
                    <hr class="fancy-line"/>
                </div>
            </div>
        </div>
        <div class="row nopadding">
            <div class="col-lg-12 nopadding">
                <div class="wb_features">
                    <div class="feature-section col four-col col-md-12 nopadding">
                        <div>
                            <h4><?php _e('Fully Customizable', 'woo-bag'); ?></h4>
                            <p>
                                <?php _e('Customize background, text, color, size, font, borders, buttons etc.', 'woo-bag'); ?>
                            </p>
                        </div>
                        <div>
                            <h4><?php _e('Preview Options', 'woo-bag'); ?></h4>
                            <p>
                                <?php _e('Amazing previewing option at the backend before making it live on your shop.', 'woo-bag'); ?>
                            </p>
                        </div>
                        <div>
                            <h4><?php _e('Scroll Options', 'woo-bag'); ?></h4>
                            <p>
                                <?php _e('Set the scroll feature and Set the number of items to list above the fold.', 'woo-bag'); ?>
                            </p>
                        </div>
                        <div>
                            <h4><?php _e('Custom Alerts', 'woo-bag'); ?></h4>
                            <p>
                                <?php _e('Improve conversion by setting custom alerts on cart item removal.', 'woo-bag'); ?>
                            </p>
                        </div>

                    </div>
                    <div class="feature-section col four-col col-md-12 nopadding">
                        <div>
                            <h4><?php _e('Custom Attributes', 'woo-bag'); ?></h4>
                            <p>
                                <?php _e('Full control on Showing Custom Attributes of cart items.', 'woo-bag'); ?>
                            </p>
                        </div>
                        <div>
                            <h4><?php _e('Responsive Design', 'woo-bag'); ?></h4>
                            <p>
                                <?php _e('Multiscreen friendly design to show your cart on small screens', 'woo-bag'); ?>
                            </p>
                        </div>
                    </div>
                    <div class="feature-section col one-col col-md-12 nopadding">
                        <div class="text-center">
                            <h2><?php _e('Premium Features', 'woo-bag'); ?></h2>
                            <p>Not Available in Lite Version</p>
                        </div>
                    </div>
                    <div class="feature-section col four-col col-md-12 nopadding">
                        <div>
                            <h4><?php _e('Cart in Menu', 'woo-bag'); ?></h4>
                            <p>
                                <?php _e('Show Ajax dropdown cart in menu of your site. Also set pages where you need to show it in menu. ', 'woo-bag'); ?>
                            </p>
                        </div>
                        <div>
                            <h4><?php _e('Cart in Fixed Position', 'woo-bag'); ?></h4>
                            <p>
                                <?php _e('Show Ajax cart in fixed position using shortcode. ', 'woo-bag'); ?>
                            </p>
                        </div>
                        <div>
                            <h4><?php _e('Cart in Sidebars', 'woo-bag'); ?></h4>
                            <p>
                                <?php _e('Show Ajax cart in siderbars using Widget.', 'woo-bag'); ?>
                            </p>
                        </div>
                        <div>
                            <h4><?php _e('Cart Icon Customization', 'woo-bag'); ?></h4>
                            <p>
                                <?php _e('Customize Cart icons image, color, size, text etc. ', 'woo-bag'); ?>
                            </p>
                        </div>


                    </div>
                    <div class="feature-section col four-col col-md-12 nopadding">
                        <div>
                            <h4><?php _e('Shortcodes and Widgets', 'woo-bag'); ?></h4>
                            <p>
                                <?php _e('Shortcode and widgets to help you easily use the WooBag cart anywhere you want. ', 'woo-bag'); ?>
                            </p>
                        </div>
                        <div>
                            <h4><?php _e('Import/Export', 'woo-bag'); ?></h4>
                            <p>
                                <?php _e('Export your template designs and easily import them on the same or another site. ', 'woo-bag'); ?>
                            </p>
                        </div>
                        <div>
                            <h4><?php _e('Templating System', 'woo-bag'); ?></h4>
                            <p>
                                <?php _e('Create unlimited cart designs of your shop using the built-in templating system.', 'woo-bag'); ?>
                            </p>
                        </div>
                        <div>
                            <h4><?php _e('Cart Countdown', 'woo-bag'); ?></h4>
                            <p>
                                <?php _e('Create scarcity using countdown and reserve product features.', 'woo-bag'); ?>
                            </p>
                        </div>
                    </div>
                    <div class="feature-section col four-col col-md-12 nopadding">
                        <div>
                            <h4><?php _e('Customize Empty Cart', 'woo-bag'); ?></h4>
                            <p>
                                <?php _e('Many options to Customize Empty cart to improve conversions.', 'woo-bag'); ?>
                            </p>
                        </div>
                    </div>
                    <div class="feature-section col one-col col-md-12 nopadding">
                        <div class="text-center">
                            <h4>...<?php _e('and Many More', 'woo-bag'); ?></h4>
                            <p>
                                <?php _e('To see all other features go to ', 'woo-bag'); ?>
                                <a href="http://woobag.gatelogix.com/lite">
                                    <?php _e('Demo ', 'woo-bag'); ?>
                                </a>
                                <?php _e('or check ', 'woo-bag'); ?>
                                <a href="http://woobag.gatelogix.com/documentation">
                                    <?php _e('Documentation. ', 'woo-bag'); ?>
                                </a>
                            </p>
                            <div class="wb_cart_setting_banner ">
                                <a class="button-primary" href="http://codecanyon.net/item/woobag-customize-your-cart-easily/12908527?ref=gatelogix">
                                    GET WOOBAG PREMIUM
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <?php
}
