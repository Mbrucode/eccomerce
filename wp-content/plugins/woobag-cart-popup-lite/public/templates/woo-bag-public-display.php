<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @author Gatelogixs
 * @package Woo_Bag/
 * @subpackage Woo_Bag/public/templates
 * @version 1.0.0
 */
if (!session_id()):
    session_start();
endif;

function wb_public_display_html() {

    $wb_woocommerce = wb_woocommerce_data();
    if ($wb_woocommerce) :
        if ($wb_woocommerce->cart):
            
            ?>
            <div class="wb_display_widget_cart">
                <div class="cart_list product_list_widget wb_cart_product wb_cart_front_end_wrapper" id="wb_cart_front_end_wrapper">
                    <?php
                    $wb_data = wb_built_bag();
                    echo $wb_data;
                    ?>
                </div>
            </div>
            <?php
            
        endif;
    endif;
}
