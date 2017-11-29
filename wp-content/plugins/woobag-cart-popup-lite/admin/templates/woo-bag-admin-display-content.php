<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the Main Content of the WooBag.
 *
 * @author Gatelogixs
 * @package Woo_Bag/
 * @subpackage Woo_Bag/admin/templates
 * @version 1.0.0
 */
if (class_exists('Woo_Bag')) :
    $wb_product_id = 1;
    $wb_data = wb_product_dummp_data();
    if ($wb_data) :
        if (function_exists('get_woocommerce_currency_symbol')):
            $wb_currency_symbol = get_woocommerce_currency_symbol();
        else:
            $wb_currency_symbol = '$';
        endif;
        $wb_active_template_id = WB()->wb_get_setting_name();
        $wb_text_after_product_price = wb_get_single_setting($wb_active_template_id, 'product_setting', 'wb_text_after_product_price');
        $wb_remove_button_icon = wb_get_single_setting($wb_active_template_id, 'product_setting', 'wb_remove_button_icon');
        $show_remove_button = wb_get_single_setting($wb_active_template_id, 'product_setting', 'show_remove_button');
        ?>
        <table>
            <?php foreach ($wb_data as $data) : ?>
                <tr id="wb_cart_single_product_<?php echo $data['product_id']; ?>" class="wb_cart_single_product">
                    <td class="wb_product_thumbnail">
                        <a href="#">
                            <img src="<?php echo WB()->wb_plugin_url(); ?>/admin/images/<?php echo $data['product_img']; ?>"/>
                        </a>
                    </td>
                    <td class="wb_product_detail">
                        <div class="wb_product_name">
                            <a href="#">
                                <?php _e($data['product_name'], 'woo-bag'); ?>
                            </a>
                        </div>
                        <?php echo '<span class="quantity">' . '<span class="wb_quantity_label">Quantity:</span> <span class="wb_total_quentity">' . $data['product_quantity'] . '</span>' . '</span>'; ?>
                        <?php
                        echo '<div class="price"><span class="wb_price_label">' . 'Price:</span> ';
                        if ($data['product_regular_price']):
                            echo '<span class="wb_product_reqular_amount">' . $wb_currency_symbol . $data['product_regular_price'] . '</span> ';
                        endif;
                        echo '<span class="wb_product_amount">' . $wb_currency_symbol
                        . $data['product_price'] . '<span class="wb_text_after_product_price">' . __($wb_text_after_product_price, 'woo-bag') . '</span></div>';
                        ?>
                        <?php
                        if (isset($data['product_regular_price']) && !empty($data['product_regular_price'])) :
                            $percentage = round(( ( $data['product_regular_price'] - $data['product_price'] ) / $data['product_regular_price'] ) * 100);
                            echo $wb_saving_percentage = '<div class="wb_saving_percentage">';
                            echo $text = sprintf(__('Save: %s', 'woo-bag'), $percentage . '%');
                            echo '</div>';
                        endif;
                        ?>
                        <?php
                        if ($data['product_tax'] == 0):
                            $wb_tax_per_product = '0.00';
                        else:
                            $wb_tax_per_product = $data['product_tax'];
                        endif;
                        ?>
                        <div class="wb_tax_per_item"> 
                            <?php _e('Tax: ', 'woo-bag'); ?>
                            <?php echo '$' . $wb_tax_per_product; ?>
                        </div>
                        <div class="wb_custom_attributes">
                            <?php ?>
                        </div>
                    </td>
                <div class="wb_single_product_id">
                    <?php echo $data['product_id']; ?>
                </div>
                <td class="wb_remove_button">
                    <p class="buttons wb_remove_product">
                        <span>
                            <?php if ($show_remove_button === 'yes'): ?>
                                <i class="<?php echo $wb_remove_button_icon; ?>"></i>
                            <?php endif; ?>
                        </span>
                    </p>
                </td>
            </tr>
        <?php endforeach; ?>
        </table>
    <?php endif; ?>
    <?php



endif;