<?php

if (!defined('ABSPATH')) :
    exit; // Exit if accessed directly
endif;

/**
 * Define Options with different Section
 *
 * @version		1.0.0
 * @package		Woo_Bag/Functions/
 * @subpackage          Woo_Bag/includes
 * @category            Setting function
 * @author 		Gatelogix
 */
add_filter('wb_register_settings', 'wb_plugin_setting');

function wb_plugin_setting($wb_setting) {

    $wb_font_url = wb_google_fonts();
    $wb_custom_attr = wb_get_custom_attribute();
    $wb_products_attribute_list = '';

    if ($wb_custom_attr):
        $wb_products_attribute_list = array(
            'id' => 'wb_custom_attributes',
            'title' => 'Show Custom Attributes',
            'type' => 'checkboxes',
            'desc' => 'Select Custom attributes to Show on WooBag',
            'choices' => $wb_custom_attr,
            'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change'
        );
    endif;
    $wb_setting[] = array(
        'section_id' => 'wb_menu_icon_setting',
        'section_title' => 'Menu Icon Settings',
        'section_order' => 1,
        'section_description' => '<div class="wb_section_description wb_red wb_bold">"Sorry this feature is only available in our '
        . 'premium version, it just costs $18! <a href="http://codecanyon.net/item/woobag-customize-your-cart-easily/12908527?ref=gatelogix">Click here</a> to get it from CodeCanyon"</div>',
        'fields' => array(
            array(
                'id' => 'wb_menu_hidden_field',
                'title' => 'Premium Features',
                'type' => 'hidden',
                'class' => 'form-control',
            ),
        )
    );
    $wb_setting[] = array(
        'section_id' => 'wb_block_icon_setting',
        'section_title' => 'Block Icon Settings',
        'section_order' => 1,
        'section_description' => '<div class="wb_section_description wb_red wb_bold">"Sorry this feature is only available in our '
        . 'premium version, it just costs $18! <a href="http://codecanyon.net/item/woobag-customize-your-cart-easily/12908527?ref=gatelogix">Click here</a> to get it from CodeCanyon"</div>',
        'fields' => array(
            array(
                'id' => 'wb_block_hidden_field',
                'title' => 'Premium Features',
                'type' => 'hidden',
                'class' => 'form-control',
            ),
        )
    );
    $wb_setting[] = array(
        'section_id' => 'wb_timer_setting',
        'section_title' => 'Timer Settings',
        'section_order' => 1,
        'section_description' => '<div class="wb_section_description wb_red wb_bold">"Sorry this feature is only available in our '
        . 'premium version, it just costs $18! <a href="http://codecanyon.net/item/woobag-customize-your-cart-easily/12908527?ref=gatelogix">Click here</a> to get it from CodeCanyon"</div>',
        'fields' => array(
            array(
                'id' => 'wb_timer_hidden_field',
                'title' => 'Premium Features',
                'type' => 'hidden',
                'class' => 'form-control',
            ),
        )
    );
    // General Settings section
    $wb_setting[] = array(
        'section_id' => 'general_setting',
        'section_title' => 'General Settings',
        'section_order' => 10,
        'fields' => array(
            array(
                'id' => 'wb_bg_option',
                'title' => 'WooBag Background Option',
                'type' => 'select',
                'class' => 'form-control',
                'std' => 'color',
                'desc' => '<p>
                                This option lets you setup the whole background of WooBag popup.</p>
                            <p>Following are the ways to set up the background:</p>
                            <ul>
                                <li><strong>Image: </strong>Using this option, you can use image as your background.</li>
                                <li><strong>Color: </strong>Using this option, you can use color as your background.</li>
                                <li><strong>Both: </strong>Using this option, you can use both image and color as your background.</li>
                            </ul>
                            <p>Note that the Header’s and Footer’s backgrounds can also be changed from the “Header Area” and 
                                “Footer Area” settings menu.
                            </p>
                        ',
                'choices' => array(
                    'image' => 'Image',
                    'color' => 'Color',
                    'both' => 'Both',
                ),
                'has_dependent' => 'yes',
                'dependent_id' => 'wb_bg_option',
                'dependent_condation' => 'image color both',
            ),
            array(
                'id' => 'wb_bg_color',
                'title' => 'Background Color',
                'type' => 'color',
                'class' => 'form-control',
                'std' => '#ffffff',
                'desc' => ' <p>
                                This option lets you choose the color for the background from the colour palette.
                            </p>
                            <p>
                                Note that this option only works if “WooBag Background Option” is set to “Color” or “Both”.
                            </p>',
                'change_property' => 'background-color',
                'change_property_id' => '.wb_display_widget_cart',
                'dependent_from' => 'wb_bg_option',
                'dependent_condation' => 'color both',
            ),
            array(
                'id' => 'wb_bg_image',
                'title' => 'Background Image',
                'type' => 'file',
                'class' => 'form-control wb_display_widget_cart',
                'std' => '#',
                'desc' => '<p>
                                This option lets you upload/choose the image for the background of WooBag popup.
                            </p>
                            <p>
                                Note that this option only works if “WooBag Background Option” is set to “Image” or “Both”.
                            </p>',
                'change_property' => 'background-image',
                'change_property_id' => '.wb_display_widget_cart',
                'dependent_from' => 'wb_bg_option',
                'dependent_condation' => 'image both',
            ),
            array(
                'id' => 'wb_bg_image_repeat',
                'title' => 'Background Image Repeat',
                'type' => 'radio',
                'class' => 'wb_bg_image_repeat',
                'std' => 'repeat',
                'desc' => '<p>
                                This option lets you set the repetition behaviour of the background image for WooBag popup.</p>
                            <ul>
                                <li><strong>Repeat-x</strong>: To repeat the image horizontally.</li>
                                <li><strong>Repeat-y</strong>: To repeat the image vertically.</li>
                                <li><strong>Both</strong>: To repeat the image both horizontally and vertically.</li>
                                <li><strong>No-Repeat</strong>: To disable the repeat option and showing the single image.</li>
                            </ul>
                            <p>
                                Note that this option only works if “WooBag Background Option” is set to “Image” or “Both”.
                            </p>',
                'choices' => array(
                    'repeat-x' => 'Repeat-x',
                    'repeat-y' => 'Repeat-y',
                    'repeat' => 'Both',
                    'no-repeat' => 'No-Repeat',
                ),
                'change_property' => 'background-repeat',
                'change_property_id' => '.wb_display_widget_cart',
                'dependent_from' => 'wb_bg_option',
                'dependent_condation' => 'image both',
            ),
            array(
                'id' => 'wb_bg_image_position',
                'title' => 'Background Image Position',
                'type' => 'image_position',
                'class' => 'wb_bg_image_position',
                'std' => '1',
                'desc' => '<p>
                                This option lets you set the position of the background image both vertically and horizontally.
                            </p>
                            <ul>
                                <li><strong>Arrow Left</strong>: To move the image to the left hand side.</li>
                                <li><strong>Arrow Up</strong>: To move the image upwards.</li>
                                <li><strong>Arrow Right</strong>: To move the image to the right hand side.</li>
                                <li><strong>Arrow Down</strong>: To move the image downwards.</li>
                                <li><strong>Reset</strong>: To reset the image position to the default settings.</li>
                            </ul>
                            <p>
                                Note that this option only works if “WooBag Background Option” is set to “Image” or “Both”.
                            </p>',
                'change_property' => 'background-repeat',
                'change_property_id' => '.wb_display_widget_cart',
                'dependent_from' => 'wb_bg_option',
                'dependent_condation' => 'image both',
            ),
            array(
                'id' => 'wb_woobag_border_color',
                'title' => 'Border Color',
                'type' => 'color',
                'class' => 'form-control',
                'desc' => '<p>
                                This option lets you set the color of the Border of WooBag Popup. You can use the color palette to give the border any color of your choice. 
                            </p>',
                'std' => '#a8a8a8',
                'change_property' => 'border-color',
                'change_property_id' => '.wb_display_widget_cart',
            ),
            array(
                'id' => 'wb_woobag_border_radius',
                'title' => 'Border Radius',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'std' => '1',
                'desc' => '<p>
                                This option lets you make the corners of your WooBag popup rounded. 
                            </p>',
                'help' => 'px',
                'change_property' => 'border-radius',
                'change_property_id' => '.wb_display_widget_cart',
            ),
            array(
                'id' => 'wb_woobag_border_width',
                'title' => 'Border Width',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'std' => '1',
                'desc' => '<p>
                                This option lets you set the width of the border of your WooBag popup. 
                            </p>',
                'help' => 'px',
                'change_property' => 'border-width',
                'change_property_id' => '.wb_display_widget_cart',
            ),
            array(
                'id' => 'wb_woobag_border_style',
                'title' => 'Border Style',
                'type' => 'select',
                'class' => 'form-control',
                'std' => 'solid',
                'desc' => '<p>
                                This option lets you choose the style of the outer border of WooBag popup. 
                            </p>
                            <ul>
                                <li><strong>Solid</strong>: To give plain solid line effect to the border.</li>
                                <li><strong>Dotted</strong>: To give dotted line effect to the border.</li>
                                <li><strong>Dashed</strong>: To give dashed line effect to the border.</li>
                                <li><strong>Double</strong>: To give double plain solid line effect to the border. To use this option, 
                                    you will need to increase the “Border width” to at least 3px.</li>
                            </ul>',
                'choices' => array(
                    'solid' => 'Solid',
                    'dotted' => 'Dotted',
                    'dashed' => 'Dashed',
                    'double' => 'Double'
                ),
                'change_property' => 'border-style',
                'change_property_id' => '.wb_display_widget_cart',
            ),
            array(
                'id' => 'wb_woobag_custom_width',
                'title' => 'Set Custom Width',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'desc' => '<p>
                                This option lets you set custom width of your WooBag popup. You can choose any width and the items 
                                inside will adjust accordingly. In case, your width is greater than the width of small screens 
                                such as mobile phones and tabs, the popup will automatically adjust to 90% of the 
                                width of the small screen.
                            </p>',
                'std' => '325',
                'help' => 'px',
                'change_property' => 'width',
                'change_property_id' => '.wb_display_widget_cart',
            ),
            array(
                'id' => 'woobag_loader_icon',
                'title' => 'Loader Icon',
                'type' => 'select',
                'class' => 'form-control fontawesome-select',
                'std' => 'fa fa-spinner fa-pulse',
                'desc' => '<p>
                                Loader Icon shows when the WooBag Popup is loading. You have 5 different icon styles to choose from. 
                            </p>',
                'choices' => array(
                    "fa fa-spinner fa-spin" => "&#xf110; Icon 1",
                    "fa fa-refresh fa-spin" => "&#xf021; Icon 2",
                    "fa fa-cog fa-spin" => "&#xf013; Icon 3",
                    "fa fa-circle-o-notch fa-spin" => "&#xf1ce; Icon 4",
                    "fa fa-spinner fa-pulse" => "&#xf110; Icon 5",
                )
            ),
            array(
                'id' => 'woobag_loader_icon_size',
                'title' => 'Loader Icon Size',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'std' => '70',
                'desc' => '<p>
                                This option lets you set the size of the icon. 
                            </p>',
                'help' => 'px'
            ),
            array(
                'id' => 'woobag_loader_icon_color',
                'title' => 'Loader Icon Color',
                'type' => 'color',
                'class' => 'form-control',
                'std' => '#bababa',
                'desc' => '<p>
                                This option lets you set the color of your choice for the Loader Icon. 
                            </p>',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change'
            ),
            array(
                'id' => 'wb_opacity',
                'title' => 'Opacity',
                'type' => 'select',
                'class' => 'form-control',
                'std' => '1',
                'desc' => '<p>
                                This option lets you set the Opacity(Transparency) of your WooBag popup. The value “0” is the lightest and the value “1” is the darkest. 
                            </p>',
                'choices' => array(
                    '0' => '0',
                    '0.1' => '0.1',
                    '0.2' => '0.2',
                    '0.3' => '0.3',
                    '0.4' => '0.4',
                    '0.5' => '0.5',
                    '0.6' => '0.6',
                    '0.7' => '0.7',
                    '0.8' => '0.8',
                    '0.9' => '0.9',
                    '1' => '1'
                )
            )
        )
    );
    /** Header Setting */
    $wb_setting[] = array(
        'section_id' => 'header_setting',
        'section_title' => 'Header Area',
        'section_description' => '<div class="wb_section_description">Header Area is the top section of your WooBag Popup. '
        . 'It gives you the ability to set any label of your choice to display the number of items in the cart. The WooBag’s '
        . 'Close button is also shown in the right side of the header.</div>',
        'section_order' => 40,
        'fields' => array(
            array(
                'id' => 'show_header_text',
                'title' => 'Show Header Area',
                'type' => 'radio',
                'std' => 'yes',
                'desc' => '<p>
                                This option lets you set your WooBag’s header to on or off. 
                            </p>
                            <ul>
                                <li><strong>Yes</strong>: To show the header area</li>
                                <li><strong>No</strong>: To hide the header area</li>
                            </ul>',
                'class' => 'show_header_text',
                'choices' => array(
                    'yes' => 'Yes',
                    'no' => 'No'
                ),
                'has_dependent' => 'yes',
                'dependent_id' => 'show_header_text',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_header_height',
                'title' => 'Header Height',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'std' => '35',
                'desc' => '<p>
                                As the customer will add more than one product, Woo-bag’s interface header text 
                                can be changed using this field to show a customized heading as compare to the 
                                customers having single product in their cart.  
                            </p>',
                'help' => 'px',
                'change_property' => 'height',
                'change_property_id' => '.wb_window_top',
                'dependent_from' => 'show_header_text',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'header_text',
                'title' => 'Header Label for Single Item',
                'type' => 'text',
                'class' => 'form-control',
                'desc' => '<p>
                                This option lets you set the Label of the Header when there is a single item in the cart. 
                                The total number of items is a auto value and your defined label shows afterwards. 
                                For example “1 Item in Cart” where “1” is an auto value which counts automatically as per 
                                the number of items in the cart, and “Item in Cart” is the dynamic value that you can set 
                                yourself. You can also hide this auto value using the option named “Show Items Count in Header”
                                in the “Header Area” setting tab. 
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Header Area” is set to yes.</li>
                            </ul>',
                'std' => 'ITEM IN BAG',
                'dependent_from' => 'show_header_text',
                'dependent_condation' => 'yes',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
            ),
            array(
                'id' => 'header_text_multiple',
                'title' => 'Header Label for Multiple Items',
                'type' => 'text',
                'class' => 'form-control',
                'desc' => '<p>
                                This option lets you set the Label of the Header when there are multiple items in the 
                                cart. The total number of items is an auto value and your defined label shows afterwards.
                                For example “4 Items in Cart” where “4” is an auto value which counts automatically as per the 
                                number of items in the cart, and “Items in Cart” is the dynamic value that you can set yourself.
                                You can also hide this auto value using the option named “Show Items Count in Header” in the 
                                “Header Area” setting tab.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Header Area” is set to yes.</li>
                            </ul>',
                'std' => 'ITEMS IN BAG',
                'change_property' => 'text',
                'change_property_id' => '.wb_single_multiple_top_text',
                'dependent_from' => 'show_header_text',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'header_text_position',
                'title' => 'Header Label Position',
                'type' => 'radio',
                'class' => 'header_text_position',
                'std' => 'left',
                'desc' => '<p>
                                This option lets you set the horizontal position of your header text.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Header Area” is set to yes.</li>
                            </ul>',
                'choices' => array(
                    'left' => 'Left',
                    'center' => 'Center',
                    'right' => 'Right',
                ),
                'change_property' => 'text-align',
                'change_property_id' => '.wb_top_text',
                'dependent_from' => 'show_header_text',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'header_text_vertical_position',
                'title' => 'Header Text Vertical Position',
                'type' => 'radio',
                'class' => 'header_text_vertical_position',
                'std' => 'middle',
                'desc' => '<p>
                                This option lets you set the vertical position of your header text.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Header Area” is set to yes.</li>
                            </ul>',
                'choices' => array(
                    'top' => 'Top',
                    'middle' => 'Middle',
                    'bottom' => 'Bottom',
                ),
                'change_property' => 'vertical-align',
                'change_property_id' => '.wb_top_text',
                'dependent_from' => 'show_header_text',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'header_text_size',
                'title' => 'Header Label Font Size',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'std' => '15',
                'desc' => '<p>
                                This option lets you set the size of the text shown in the header. 
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Header Area” is set to yes.</li>
                            </ul>',
                'help' => 'px',
                'change_property' => 'font-size',
                'change_property_id' => '.wb_top_text b,.wb_top_text .wb_single_multiple_top_text',
                'dependent_from' => 'show_header_text',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'header_font',
                'title' => 'Header Label Font',
                'type' => 'select',
                'class' => 'form-control',
                'choices' => $wb_font_url,
                'std' => 'ABeeZee',
                'desc' => '<p>
                                This option lets you set the font of the text shown in the header. 
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Header Area” is set to yes.</li>
                            </ul>',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'show_header_text',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_head_text_color',
                'title' => 'Header Text Color',
                'type' => 'color',
                'std' => '#404040',
                'desc' => '<p>
                                This option lets you set the color of the text shown in the header.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Header Area” is set to yes.</li>
                            </ul>',
                'change_property' => 'color',
                'change_property_id' => '.wb_top_text b,.wb_top_text .wb_single_multiple_top_text',
                'dependent_from' => 'show_header_text',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_header_bg_option',
                'title' => 'Header Background Option',
                'type' => 'select',
                'class' => 'form-control',
                'std' => 'color',
                'desc' => '<p>
                                This option lets you setup the background of  header. 
                            </p>
                            <p>
                                Following are the ways to set up the background:
                            </p>
                            <ul>
                                <li><strong>Image: </strong>Using this option, you can use image as your background.</li>
                                <li><strong>Color: </strong>Using this option, you can use color as your background.</li>
                                <li><strong>Both: </strong>Using this option, you can use both image and color as your background.</li>
                                <li><strong>None: </strong>If you don’t want to use any background, choose this option.</li>
                            </ul>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Header Area” is set to yes.</li>
                            </ul>',
                'choices' => array(
                    'image' => 'Image',
                    'color' => 'Color',
                    'both' => 'Both',
                    'no' => 'None',
                ),
                'has_dependent' => 'yes',
                'dependent_id' => 'wb_header_bg_option',
                'dependent_condation' => 'yes image color both',
                'dependent_from' => 'show_header_text',
            ),
            array(
                'id' => 'wb_header_bg_color',
                'title' => 'Header Background Color',
                'type' => 'color',
                'std' => '#ffffff',
                'desc' => '<p>
                                This option lets you set the background color of your header.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Header Area” is set to yes.</li>
                                <li>“Header Background Option” is set to “Color” or “Both”.</li>
                            </ul>',
                'change_property' => 'background-color',
                'change_property_id' => '.wb_window_top',
                'dependent_from' => 'show_header_text wb_header_bg_option',
                'dependent_condation' => 'yes color both',
            ),
            array(
                'id' => 'wb_header_bg_image',
                'title' => 'Header Background Image',
                'type' => 'file',
                'class' => 'form-control wb_window_top',
                'std' => '#',
                'desc' => '<p>
                                This option lets you upload/choose the image for the background of Header.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Header Area” is set to yes.</li>
                                <li>“Header Background Option” is set to “Image” or “Both”.</li>
                            </ul>',
                'change_property' => 'background-image',
                'change_property_id' => '.wb_window_top',
                'dependent_from' => 'show_header_text wb_header_bg_option',
                'dependent_condation' => 'yes image both',
            ),
            array(
                'id' => 'wb_header_bg_image_repeat',
                'title' => 'Header Background Image Repeat',
                'type' => 'radio',
                'class' => 'wb_header_bg_image_repeat',
                'std' => 'repeat',
                'desc' => '<p>
                                This option lets you set the repetition behaviour of the background image for Header.
                            </p>
                            <ul>
                                <li><strong>Repeat-x</strong>: To repeat the image horizontally.</li>
                                <li><strong>Repeat-y</strong>: To repeat the image vertically.</li>
                                <li><strong>Both</strong>: To repeat the image both horizontally and vertically.</li>
                                <li><strong>No-Repeat</strong>: To disable the repeat option and showing the single image.</li>
                            </ul>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Header Area” is set to yes.</li>
                                <li>“Header Background Option” is set to “Image” or “Both”.</li>
                            </ul>',
                'choices' => array(
                    'repeat-x' => 'Repeat-x',
                    'repeat-y' => 'Repeat-y',
                    'repeat' => 'Both',
                    'no-repeat' => 'No-Repeat',
                ),
                'change_property' => 'background-repeat',
                'change_property_id' => '.wb_window_top',
                'dependent_from' => 'show_header_text wb_header_bg_option',
                'dependent_condation' => 'yes image both',
            ),
            array(
                'id' => 'wb_header_bg_image_position',
                'title' => 'Header Background Image Position',
                'type' => 'image_position',
                'class' => 'wb_header_bg_image_position',
                'std' => '1',
                'desc' => '<p>
                                This option lets you set the position of the background image both vertically and horizontally. 
                            </p>
                            <ul>
                                <li><strong>Arrow Left</strong>: To move the image to the left hand side.</li>
                                <li><strong>Arrow Up</strong>: To move the image upwards.</li>
                                <li><strong>Arrow Right</strong>: To move the image to the right hand side.</li>
                                <li><strong>Arrow Down</strong>: To move the image downwards.</li>
                                <li><strong>Reset</strong>: To reset the image position to the default settings.</li>
                            </ul>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Header Area” is set to yes.</li>
                                <li>“Header Background Option” is set to “Imge” or “Both”.</li>
                            </ul>',
                'change_property' => 'background-position',
                'change_property_id' => '.wb_window_top',
                'dependent_from' => 'show_header_text wb_header_bg_option',
                'dependent_condation' => 'yes image both',
            ),
            array(
                'id' => 'show_count',
                'title' => 'Show Items Count in Header',
                'type' => 'radio',
                'std' => 'yes',
                'desc' => '<p>
                                This option lets you show/hide the Items count in the header 
                            </p>
                            <ul>
                                <li><strong>Yes</strong>: To show the items count</li>
                                <li><strong>No</strong>: To hide the items count</li>
                            </ul>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Header Area” is set to yes.</li>
                            </ul>',
                'class' => 'show_count',
                'desc' => 'If you want to Show total number of product in WooBag then select "Yes"',
                'choices' => array(
                    'yes' => 'Yes',
                    'no' => 'No'
                ),
                'dependent_from' => 'show_header_text',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'show_close_window_button',
                'title' => 'Show Close Button in Header',
                'type' => 'radio',
                'std' => 'yes',
                'desc' => '<p>
                                This option lets you show/hide the Close Button in the header 
                            </p>
                            <ul>
                                <li><strong>Yes</strong>: To show the Close Button</li>
                                <li><strong>No</strong>: To hide the Close Button</li>
                            </ul>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Header Area” is set to yes.</li>
                            </ul>',
                'class' => 'show_close_window_button',
                'choices' => array(
                    'yes' => 'Yes',
                    'no' => 'No'
                ),
                'has_dependent' => 'yes',
                'dependent_id' => 'show_close_window_button',
                'dependent_condation' => 'yes',
                'dependent_from' => 'show_header_text',
            ),
            array(
                'id' => 'wb_close_bag_icon',
                'title' => 'Choose Close Button Icon',
                'type' => 'select',
                'class' => 'form-control fontawesome-select',
                'std' => 'fa fa-times-circle',
                'desc' => '<p>
                                This option lets you set what icon you want to use for the Close button of the WooBag Popup. You can choose any of the provided icons in the dropdown. 
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Header Area” is set to yes.</li>
                                <li>“Show Close Button in Header” is set to yes.</li>
                            </ul>',
                'choices' => array(
                    "fa fa-times-circle" => "&#xf057; Icon 1",
                    "fa fa-times-circle-o" => "&#xf05c; Icon 2",
                    "fa fa-times" => "&#xf00d; Icon 3"
                ),
                'dependent_from' => 'show_header_text show_close_window_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_close_bag_color',
                'title' => 'Close Button Icon Color',
                'type' => 'color',
                'std' => '#b4b4b4',
                'desc' => '<p>
                                This option lets you set the color of the icon of your Close Button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Header Area” is set to yes.</li>
                                <li>“Show Close Button in Header” is set to yes.</li>
                            </ul>',
                'change_property' => 'color',
                'change_property_id' => '.wb_close_window i',
                'dependent_from' => 'show_header_text show_close_window_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_close_bag_hover_color',
                'title' => 'Close Button Icon Color on Mouse Over',
                'type' => 'color',
                'std' => '#cccccc',
                'desc' => '<p>
                                This option lets you set the color of the icon of your Close Button when mouse pointer is brought over it.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Header Area” is set to yes.</li>
                                <li>“Show Close Button in Header” is set to yes.</li>
                            </ul>',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'show_header_text show_close_window_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_close_bag_size',
                'title' => 'Close Button Icon Size',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'std' => '23',
                'desc' => '<p>
                                This option lets you set the size of close button icon.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Header Area” is set to yes.</li>
                                <li>“Show Close Button in Header” is set to yes.</li>
                            </ul>',
                'help' => 'px',
                'change_property' => 'font-size',
                'change_property_id' => '.wb_close_window i',
                'dependent_from' => 'show_header_text show_close_window_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_close_bag_button_position',
                'title' => 'Close Button Position',
                'type' => 'radio',
                'class' => 'wb_close_bag_button_position',
                'std' => 'middle',
                'desc' => '<p>
                                This option lets you set the horizontal position of the close button icon.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Header Area” is set to yes.</li>
                                <li>“Show Close Button in Header” is set to yes.</li>
                            </ul>',
                'choices' => array(
                    'top' => 'Top',
                    'middle' => 'Middle',
                    'bottom' => 'Bottom',
                ),
                'dependent_from' => 'show_header_text show_close_window_button',
                'dependent_condation' => 'yes',
                'change_property' => 'vertical-align',
                'change_property_id' => '.wb_close_window',
            ),
            array(
                'id' => 'wb_header_border_bottom',
                'title' => 'Show Header Bottom Separator',
                'type' => 'radio',
                'class' => 'wb_header_border_bottom',
                'std' => 'yes',
                'desc' => '<p>
                                This option lets you show/hide the bottom border of the header.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Header Area” is set to yes.</li>
                            </ul>',
                'choices' => array(
                    'yes' => 'Yes',
                    'no' => 'No'
                ),
                'has_dependent' => 'yes',
                'dependent_id' => 'wb_header_border_bottom',
                'dependent_from' => 'show_header_text',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_header_border_option',
                'title' => 'Header Separator Style',
                'type' => 'select',
                'class' => 'form-control',
                'std' => 'dashed',
                'desc' => '<p>
                                This option lets you choose the style of the bottom border of the Header. 
                            </p>
                            <ul>
                                <li><strong>Solid</strong>: To give plain solid line effect to the border.</li>
                                <li><strong>Dotted</strong>: To give dotted line effect to the border.</li>
                                <li><strong>Dashed</strong>: To give dashed line effect to the border.</li>
                                <li><strong>Double</strong>: To give double plain solid line effect to the border. To use this option, you will need to increase the “Border width” to at least 3px.</li>
                            </ul>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Header Area” is set to yes.</li>
                                <li>“Show Header Bottom Separator” is set to yes.</li>
                            </ul>',
                'choices' => array(
                    'solid' => 'Solid',
                    'dotted' => 'Dotted',
                    'dashed' => 'Dashed',
                    'double' => 'Double'
                ),
                'change_property' => 'border-bottom-style',
                'change_property_id' => '.wb_window_top',
                'dependent_from' => 'show_header_text wb_header_border_bottom',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_header_border_width',
                'title' => 'Header Separator width',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'desc' => ' <p>
                                 This option lets you set the width of the bottom border of the Header. 
                            </p>
                            
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Header Area” is set to yes.</li>
                                <li>“Show Header Bottom Separator” is set to yes.</li>
                            </ul>',
                'std' => '1',
                'help' => 'px',
                'change_property' => 'border-bottom-width',
                'change_property_id' => '.wb_window_top',
                'dependent_from' => 'show_header_text wb_header_border_bottom',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_header_seprator_color',
                'title' => 'Header Separator color',
                'type' => 'color',
                'class' => 'form-control wb_border_color',
                'std' => '#a8a8a8',
                'desc' => '<p>
                                 This option lets you set the color of the bottom border of the Header. You can use the color palette to give the border any color of your choice. 
                            </p>
                            
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Header Area” is set to yes.</li>
                                <li>“Show Header Bottom Separator” is set to yes.</li>
                            </ul>',
                'change_property' => 'border-bottom-color',
                'change_property_id' => '.wb_window_top',
                'dependent_from' => 'show_header_text wb_header_border_bottom',
                'dependent_condation' => 'yes',
            ),
        )
    );
    $wb_setting[] = array(
        'section_id' => 'product_setting',
        'section_title' => 'Items Area',
        'section_order' => 50,
        'fields' => array(
            array(
                'id' => 'wb_item_padding_left_right',
                'title' => 'Item Area Padding Sideways',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'std' => '12',
                'desc' => '<p>
                                This option lets you set the width of the items area by adjusting padding on both (right and left) sides. 
                            </p>',
                'help' => 'px',
            ),
            array(
                'id' => 'wb_item_seprator_show',
                'title' => 'Show Item Separator',
                'type' => 'radio',
                'class' => 'wb_item_seprator_show',
                'std' => 'yes',
                'desc' => '<p>
                                This option lets you set the separator row between the items in the cart. 
                            </p>',
                'choices' => array(
                    'yes' => 'Yes',
                    'no' => 'No'
                ),
                'has_dependent' => 'yes',
                'dependent_id' => 'wb_item_seprator_show',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_border_option',
                'title' => 'Items Separator Style',
                'type' => 'select',
                'class' => 'form-control',
                'std' => 'dotted',
                'desc' => '<p>
                                This option lets you choose the item separators style. 
                            </p>
                            <ul>
                                <li><strong>Solid:</strong> To use plain solid line separator to separate every item present in the cart.</li>
                                <li><strong>Dotted:</strong> To use dotted line separator to separate every item present in the cart.</li>
                                <li><strong>Dashed:</strong> To use dashed line separator to separate every item present in the cart.</li>
                                <li><strong>Double:</strong> To use double plain solid line separator to separate every item present in the cart. To use this option, you will need to increase the “Item Separator width” to at least 3px.</li>
                            </ul>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Items Separator” is set to “Yes”.</li>
                            </ul>',
                'choices' => array(
                    'solid' => 'Solid',
                    'dotted' => 'Dotted',
                    'dashed' => 'Dashed',
                    'double' => 'Double'
                ),
                'dependent_from' => 'wb_item_seprator_show',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_border_width',
                'title' => 'Items Separator width',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'desc' => '<p>
                                This option lets you set custom width of the Item separators. 
                            </p>

                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Items Separator” is set to “Yes”.</li>
                            </ul>',
                'std' => '1',
                'help' => 'px',
                'dependent_from' => 'wb_item_seprator_show',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_seprator_color',
                'title' => 'Items Separator color',
                'type' => 'color',
                'class' => 'form-control wb_border_color',
                'std' => '#cccccc',
                'desc' => '<p>
                                This option lets you set Color of the Item separators.
                            </p>

                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Items Separator” is set to “Yes”.</li>
                            </ul>',
                'change_property' => 'border-bottom-color',
                'change_property_id' => '.wb_cart_single_product',
                'dependent_from' => 'wb_item_seprator_show',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_show_product_no',
                'title' => 'WooBag Visible Window',
                'type' => 'select',
                'class' => 'form-control wb_show_product_no',
                'std' => '2',
                'desc' => '<p>
                                This option lets you set how many items you want to make visible in the WooBag. The rest of the items will go in the scrolling (below the fold). 
                            </p>
                            <ul>
                                <li><strong>1, 2 or 3:</strong> By choosing any of these options will set the items window accordingly. For example, if you choose “2” and there are 3 items in the cart, the rest of the items will go under the fold and customer will have to scroll down to see the third item.</li>
                                <li>Auto Adjust: This option will auto adjust the height of the Items visible window as per the screen size of the customer/visitor.</li>
                            </ul>',
                'choices' => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    'unlimited' => 'Auto Adjust',
                ),
                'has_dependent' => 'yes',
                'dependent_id' => 'wb_show_product_no',
                'dependent_condation' => '1 2 3',
            ),
            array(
                'id' => 'wb_single_product_height',
                'title' => 'Set Height of an Individual Item',
                'type' => 'number',
                'min' => '0',
                'desc' => '<p>
                                If you choose to display 1,2 or 3 items in the visible window, then you are required to enter an estimated height of an individual item when it shows in the cart. The recommended value is between 110 and 140. This value is required for the amazing item to item scroll jump feature. 
                            </p>

                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Items Area Visible Window” is set to value “1”, “2” or “3”.</li>
                            </ul>',
                'class' => 'form-control wb_single_product_height',
                'std' => '78',
                'help' => 'px',
                'dependent_from' => 'wb_show_product_no',
                'dependent_condation' => '1 2 3',
            ),
            array(
                'id' => 'show_product_quantity',
                'title' => 'Show Items Quantity',
                'type' => 'radio',
                'class' => 'show_product_quantity',
                'std' => 'yes',
                'desc' => '<p>
                                This option lets you hide/show the quantity of an individual item in cart.
                            </p>
                            <ul>
                                <li><strong>Yes</strong>: To show the quantity of an item.</li>
                                <li><strong>No</strong>: To hide the quantity of an item.</li>
                            </ul>',
                'choices' => array(
                    'yes' => 'Yes',
                    'no' => 'No'
                ),
                'has_dependent' => 'yes',
                'dependent_id' => 'show_product_quantity',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_quantity_label_color',
                'title' => 'Quantity Label Color',
                'type' => 'color',
                'std' => '#8a8a8a',
                'desc' => '<p>
                                This option lets you set the color of the quantity label in items area. 
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Items Quantity” is set to yes.</li>
                            </ul>',
                'change_property' => 'color',
                'change_property_id' => '.wb_cart_single_product .wb_quantity_label',
                'dependent_from' => 'show_product_quantity',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_quantity_value_color',
                'title' => 'Quantity Value Color',
                'type' => 'color',
                'std' => '#8a8a8a',
                'desc' => '<p>
                                This option lets you set the color of the quantity label in items area. 
                            </p>',
                'change_property' => 'color',
                'change_property_id' => '.wb_cart_single_product .wb_total_quentity',
                'dependent_from' => 'show_product_quantity',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'show_product_price',
                'title' => 'Show Items Price',
                'type' => 'select',
                'class' => 'form-control show_product_price',
                'std' => 'only_price',
                'desc' => '<p>
                                This option lets you set the way price of an individual item shows in the cart. </p>
                            <ul>
                                <li>Sale Price Only: To show only the sale price of an individual item.</li>
                                <li>Regular Price + Sale Price: To show both Regular Price and the Sale price.</li>
                                <li>Don’t Show: To hide the price of an individual item in the cart.</li>
                            </ul>',
                'choices' => array(
                    'only_price' => 'Sale Price Only',
                    'regular_sale' => 'Regular Price + Sale Price',
                    'no' => "Don't Show",
                ),
                'has_dependent' => 'yes',
                'dependent_id' => 'show_product_price',
                'dependent_condation' => 'only_price regular_sale',
            ),
            array(
                'id' => 'wb_price_label_color',
                'title' => 'Price Label Color',
                'type' => 'color',
                'std' => '#8a8a8a',
                'desc' => '<p>
                                This option lets you set the color of the Price label in items area. 
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Items Price” is set to yes.</li>
                            </ul>',
                'change_property' => 'color',
                'change_property_id' => '.wb_cart_single_product .wb_price_label',
                'dependent_from' => 'show_product_price',
                'dependent_condation' => 'only_price regular_sale',
            ),
            array(
                'id' => 'wb_price_value_color',
                'title' => 'Price Value Color',
                'type' => 'color',
                'std' => '#8f0404',
                'desc' => '<p>
                                This option lets you set the color of the Price label in items area. 
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Items Price” is set to yes.</li>
                            </ul>',
                'change_property' => 'color',
                'change_property_id' => '.wb_cart_single_product .wb_product_reqular_amount,.wb_cart_single_product .wb_product_amount',
                'dependent_from' => 'show_product_price',
                'dependent_condation' => 'only_price regular_sale',
            ),
            array(
                'id' => 'wb_text_after_product_price',
                'title' => 'Text After Items Price',
                'type' => 'text',
                'class' => 'form-control',
                'std' => '/ product',
                'desc' => '<p>
                                This option lets you set any custom text after the price of each item in the cart.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Items Price” is set to yes.</li>
                            </ul>',
                'change_property' => 'text',
                'change_property_id' => '.wb_text_after_product_price',
                'dependent_from' => 'show_product_price',
                'dependent_condation' => 'only_price regular_sale',
            ),
            array(
                'id' => 'show_product_saving',
                'title' => 'Show Items Saving',
                'type' => 'radio',
                'class' => 'show_product_saving',
                'std' => 'no',
                'desc' => '<p>
                                This option lets you show/hide the Savings % on an individual item in cart. It will automatically hide for an item that is having 0% saving. 
                            </p>
                            <ul>
                                <li>Yes: Show savings % on an individual item in the cart.</li>
                                <li>No: Hide Savings % on an individual item in the cart.</li>
                            </ul>',
                'choices' => array(
                    'yes' => 'Yes',
                    'no' => 'No'
                )
            ),
            array(
                'id' => 'show_tax_per_item',
                'title' => 'Show Tax per Item',
                'type' => 'radio',
                'class' => 'show_tax_per_item',
                'std' => 'no',
                'desc' => '<p>
                                This option lets you show/hide the Tax amount on an individual item in cart. 
                            </p>
                            <ul>
                                <li>Yes: Show Tax amount on an individual item in the cart.</li>
                                <li>No: Hide Tax amount on an individual item in the cart.</li>
                            </ul>',
                'choices' => array(
                    'yes' => 'Yes',
                    'no' => 'No'
                )
            ),
            array(
                'id' => 'show_product_image',
                'title' => 'Show Items Image',
                'type' => 'radio',
                'class' => 'show_product_image',
                'std' => 'yes',
                'desc' => '<p>
                                This option lets you show/hide the Image of an individual item in cart. 
                            </p>
                            <ul>
                                <li>Yes: Show Image of an individual item in the cart.</li>
                                <li>No: Hide Image of an individual item in the cart.</li>
                            </ul>',
                'choices' => array(
                    'yes' => 'Yes',
                    'no' => 'No'
                ),
                'has_dependent' => 'yes',
                'dependent_id' => 'show_product_image',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_product_image_width',
                'title' => 'Set width of Items image',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'desc' => '<p>
                                This option lets you set the width of an item’s image. You have full control on how you want to set the
                                Image and Text ratio. The maximum you can distribute among image in text is 90% of the WooBag Popup
                                because the rest of the 10% is for the item remove button. 
                            </p>',
                'std' => '21',
                'help' => '%',
                'dependent_from' => 'show_product_image',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_content_width',
                'title' => 'Set width of Item content',
                'type' => 'number',
                'min' => '0',
                'desc' => '<p>
                                This option lets you set the width of an item’s text. You have full control on how you want to set the Image and Text ratio. The maximum you can distribute among image in text is 90% of the WooBag Popup because the rest of the 10% is for the item remove button.
                            </p>',
                'class' => 'form-control',
                'std' => '69',
                'help' => '%',
                'dependent_from' => 'show_product_image',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_content_text_color',
                'title' => 'Item’s Content Text Color',
                'type' => 'color',
                'std' => '#000000',
                'desc' => '<p>
                                This option lets you set the color for rest of the text shown for an individual item e.g. custom attributes such as Size, Color, Tax etc. 
                            </p>',
                'change_property' => 'color',
                'change_property_id' => '.wb_cart_single_product .wb_product_detail,.wb_product_detail .wb_product_name a',
            ),
            array(
                'id' => 'wb_content_text_position',
                'title' => 'Item’s Content Text Position',
                'type' => 'radio',
                'class' => 'wb_content_text_position',
                'std' => 'left',
                'desc' => '<p>
                                This option lets you set the horizontal position of the content of items area.
                            </p>',
                'choices' => array(
                    'left' => 'Left',
                    'center' => 'Center',
                    'right' => 'Right',
                ),
                'change_property' => 'text-align',
                'change_property_id' => '.wb_product_detail',
            ),
            array(
                'id' => 'wb_content_text_padding_left',
                'title' => 'Item’s Content Text Padding Left',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'std' => '8',
                'desc' => '<p>
                                This option lets you set the padding of the item’s content area from the left hand side.
                            </p>',
                'help' => 'px',
                'change_property' => 'padding-left',
                'change_property_id' => '.wb_product_detail',
            ),
            array(
                'id' => 'wb_item_title_color',
                'title' => 'Item Title Color',
                'type' => 'color',
                'std' => '#404040',
                'desc' => '<p>
                                The option lets you sent the color of the title of an individual item in cart.
                            </p>',
                'change_property' => 'color',
                'change_property_id' => '.wb_cart_single_product .wb_product_name a',
            ),
            array(
                'id' => 'title_font',
                'title' => 'Items Title Font',
                'type' => 'select',
                'class' => 'form-control',
                'choices' => $wb_font_url,
                'std' => 'ABeeZee',
                'desc' => '<p>
                                The option lets you sent the font of the title of an individual item in cart.
                            </p>',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change'
            ),
            array(
                'id' => 'content_font',
                'title' => 'Content Font',
                'type' => 'select',
                'class' => 'form-control',
                'choices' => $wb_font_url,
                'std' => 'ABeeZee',
                'desc' => '<p>
                                The option lets you sent the font of the content of an individual item in cart other than the item title.
                            </p>',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change'
            ),
            $wb_products_attribute_list,
            array(
                'id' => 'show_remove_button',
                'title' => 'Show Remove Item button',
                'type' => 'radio',
                'std' => 'yes',
                'desc' => '<p>
                                This option lets you show/hide the remove button icon of an individual item in the cart. 
                            </p>
                            <ul>
                                <li><strong>Yes</strong>: This option will show Remove Button next to each item in the cart.</li>
                                <li><strong>No</strong>: This option will hide Remove Button for all items in the cart.</li>
                            </ul>',
                'class' => 'show_remove_button',
                'choices' => array(
                    'yes' => 'Yes',
                    'no' => 'No'
                ),
                'has_dependent' => 'yes',
                'dependent_id' => 'show_remove_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_remove_button_icon',
                'title' => 'Choose Remove Item button',
                'type' => 'select',
                'class' => 'form-control fontawesome-select',
                'std' => 'fa fa-times',
                'desc' => '<p>
                                This option lets you set what icon you want to use for the Remove Button of an individual item in the cart. You can choose any of the provided icons in the dropdown.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Remove Item Button” is set to “Yes”.</li>
                            </ul>',
                'choices' => array(
                    "fa fa-times-circle" => "&#xf057; Icon 1",
                    "fa fa-times-circle-o" => "&#xf05c; Icon 2",
                    "fa fa-times" => "&#xf00d; Icon 3"
                ),
                'dependent_from' => 'show_remove_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_remove_button_position',
                'title' => 'Remove Item button Position',
                'type' => 'radio',
                'class' => 'wb_remove_button_position',
                'std' => 'middle',
                'desc' => '<p>
                                This option lets you set the vertical position of the remove button icon.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Remove Item Button” is set to “Yes”.</li>
                            </ul>',
                'choices' => array(
                    'top' => 'Top',
                    'middle' => 'Middle',
                    'bottom' => 'Bottom',
                ),
                'dependent_from' => 'show_remove_button',
                'dependent_condation' => 'yes',
                'change_property' => 'vertical-align',
                'change_property_id' => '.wb_remove_button',
            ),
            array(
                'id' => 'wb_remove_button_color',
                'title' => 'Remove Button Icon Color',
                'type' => 'color',
                'std' => '#cccccc',
                'desc' => '<p>
                                This option lets you set the color of the icon of your Remove Button for an individual item in cart.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Remove Item Button” is set to “Yes”.</li>
                            </ul>',
                'change_property' => 'color',
                'change_property_id' => '.wb_remove_product span i',
                'dependent_from' => 'show_remove_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_remove_button_hover_color',
                'title' => 'Remove Button Icon Color on Mouse Over”',
                'type' => 'color',
                'std' => '#858585',
                'desc' => '<p>
                                This option lets you set the color of the icon of your Remove Button for an individual item in cart when mouse pointer is brought over it.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Remove Item Button” is set to “Yes”.</li>
                            </ul>',
                'dependent_from' => 'show_remove_button',
                'dependent_condation' => 'yes',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
            ),
            array(
                'id' => 'show_conform',
                'title' => 'Show Remove Items Confirmation ',
                'type' => 'radio',
                'std' => 'yes',
                'desc' => '<p>
                                This option lets you show/hide the confirmation alert box at the time when customer removes an item from the cart.
                            </p>
                            <ul>
                                <li>Yes: To show the confirmation box when an item is removed from the cart.</li>
                                <li>No: To hide the confirmation box when an item is removed from the cart.</li>
                            </ul>',
                'choices' => array(
                    'yes' => 'Yes',
                    'no' => 'No'
                ),
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'has_dependent' => 'yes',
                'dependent_id' => 'show_conform',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'conform_header_text',
                'title' => 'Confirmation box heading',
                'type' => 'text', 'class' => 'form-control',
                'std' => 'Confirmation  Required',
                'desc' => '<p>
                                This option lets you set the heading of your confirmation alert box. 
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Remove Items Confirmation” is set to “Yes”.</li>
                            </ul>',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'show_conform',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'conform_message',
                'title' => 'Confirmation Message',
                'type' => 'text',
                'class' => 'form-control',
                'std' => 'Are you sure you want to remove product from WooBag!',
                'desc' => '<p>
                                This option lets you set the message to show on the confirmation message. Using this option you can show a teaser message to your customers to convince them note to remove it. A Good example would be: “This item might be out of stock in a couple of hours, are you sure you don’t want it?”
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Remove Items Confirmation” is set to “Yes”.</li>
                            </ul>',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'show_conform',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'conform_btn_ok',
                'title' => 'Confirmation box Ok button Text',
                'type' => 'text',
                'class' => 'form-control',
                'std' => 'Yes I am',
                'desc' => '<p>
                                This option lets you set the text for the OK button of your Item Removal Confirmation Message Box.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Remove Items Confirmation” is set to “Yes”.</li>
                            </ul>',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'show_conform',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'conform_btn_cancle',
                'title' => 'Confirmation box Cancel button text',
                'type' => 'text',
                'class' => 'form-control',
                'std' => 'No',
                'desc' => '<p>
                                This option lets you set the text for the Cancel button of your Item Removal Confirmation Message Box.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Remove Items Confirmation” is set to “Yes”.</li>
                            </ul>',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'show_conform',
                'dependent_condation' => 'yes',
            ),
        )
    );
    $wb_setting[] = array(
        'section_id' => 'subtotal_setting',
        'section_title' => 'Subtotal Area',
        'section_description' => '<div class="wb_section_description">
                            This is the area above the footer of the WooBag Popup. You can use this area to show Price in different 
                            combinations and also you can show different buttons like “View Cart”, “Checkout” and/or “Empty Cart”.
                        </div>',
        'section_order' => 60,
        'fields' => array(
            array(
                'id' => 'wb_subtotal_padding_left_right',
                'title' => 'Subtotal Area Padding Sideways',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'std' => '8',
                'desc' => '<p>
                                This feature lets you set the width of the subtotal area by giving padding on both (Right and Left) sides.
                            </p>',
                'help' => 'px',
            ),
            array(
                'id' => 'wb_subtotal_vertical_position',
                'title' => 'Subtotal Area Vertical Position',
                'type' => 'radio',
                'class' => 'wb_subtotal_vertical_position',
                'std' => 'middle',
                'desc' => '<p>
                                This option lets you set the vertical position of subtotal area.
                            </p>',
                'choices' => array(
                    'top' => 'Top',
                    'middle' => 'Middle',
                    'bottom' => 'Bottom',
                ),
                'change_property' => 'vertical-align',
                'change_property_id' => '.wb_cart_total_wrapper',
            ),
            array(
                'id' => 'wb_subtotal_height',
                'title' => 'Subtotal Area Height',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'std' => '83',
                'desc' => '<p>
                                This option lets you set the height of the Subtotal Area.
                            </p>',
                'help' => 'px',
                'change_property' => 'height',
                'change_property_id' => '.wb_cart_total_wrapper',
            ),
            array(
                'id' => 'show_subtotal',
                'title' => 'Show Total Price',
                'type' => 'select',
                'class' => 'form-control show_subtotal',
                'std' => 'price_tax',
                'desc' => '<p>
                                This options lets you choose how you want to show the price summary of the items present in the cart. The price can even be hidden, if you do not want to show it. 
                            </p>
                            <ul>
                                <li><strong>Show Subtotal</strong>: To show just the Subtotal of the items present in the cart.</li>
                                <li><strong>Show Order Total</strong>: To show the Order Total of the items present in the cart.</li>
                                <li><strong>Don’t Show</strong>: To hide the price from this section.</li>
                            </ul>',
                'choices' => array(
                    'only_price' => 'Show Subtotal',
                    'price_tax' => 'Show Order Total',
                    'both' => 'Show Both',
                    'no' => "Don't Show",
                ),
                'has_dependent' => 'yes',
                'dependent_id' => 'show_subtotal',
                'dependent_condation' => 'yes only_price price_tax both',
            ),
            array(
                'id' => 'wb_subtotal_label',
                'title' => 'Subtotal Label',
                'type' => 'text',
                'class' => 'form-control',
                'std' => 'Subtotal:',
                'desc' => '<p>
                                This option lets to set a label for the Subtotal. You can leave this field empty if you don’t want to show a label. 
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Total Price” is set to “Show Subtotal”.</li>
                            </ul>',
                'change_property' => 'text',
                'change_property_id' => '.wb_cart_total_wrapper .wb_subtotal_only_price strong',
                'dependent_from' => 'show_subtotal',
                'dependent_condation' => 'only_price both',
            ),
            array(
                'id' => 'wb_ordertotal_label',
                'title' => 'Order Total Label',
                'type' => 'text',
                'class' => 'form-control',
                'std' => 'Total:',
                'desc' => '<p>
                                This option lets to set a label for the Order Total. You can leave this field empty if you don’t want to show a label.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Total Price” is set to “Show Order Total”.</li>
                            </ul>',
                'change_property' => 'text',
                'change_property_id' => '.wb_cart_total_wrapper .wb_total_content_table strong',
                'dependent_from' => 'show_subtotal',
                'dependent_condation' => 'price_tax both',
            ),
            array(
                'id' => 'wb_subtotal_position',
                'title' => 'Total Text Position',
                'type' => 'radio',
                'class' => 'wb_subtotal_position',
                'std' => 'center',
                'desc' => '<p>
                                This option lets you set the horizontal position of Total text.
                            </p>',
                'choices' => array(
                    'left' => 'Left',
                    'center' => 'Center',
                    'right' => 'Right',
                ),
                'change_property' => 'text-align',
                'change_property_id' => '.wb_cart_total_wrapper .total',
                'dependent_from' => 'show_subtotal',
                'dependent_condation' => 'price_tax both',
            ),
            array(
                'id' => 'wb_subtotal_color',
                'title' => 'Font Color of the Price',
                'type' => 'color',
                'class' => 'form-control',
                'std' => '#404040',
                'desc' => '<p>
                                This option lets you set the color of the price section. 
                            </p>
                            <p>
                                Note that this option doesn’t work, if:
                            </p>
                            <ul>
                                <li>“Show Total Price” is set to “Don’t Show”.</li>
                            </ul>',
                'change_property' => 'color',
                'change_property_id' => '.wb_cart_total_wrapper .total',
                'dependent_from' => 'show_subtotal',
                'dependent_condation' => 'only_price price_tax both',
            ),
            array(
                'id' => 'subtotal_text_size',
                'title' => 'Subtotal Font Size',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'std' => '16',
                'desc' => '<p>
                                This option lets you set the Font size of the price section.
                            </p>
                            <p>
                                Note that this option doesn’t work, if:
                            </p>
                            <ul>
                                <li>“Show Total Price” is set to “Don’t Show”.</li>
                            </ul>',
                'help' => 'px',
                'change_property' => 'font-size',
                'change_property_id' => '.wb_cart_total_wrapper .total .wb_total_content',
                'dependent_from' => 'show_subtotal',
                'dependent_condation' => 'only_price price_tax both',
            ),
            array(
                'id' => 'subtotal_text_font',
                'title' => 'Subtotal Font',
                'type' => 'select',
                'class' => 'form-control',
                'choices' => $wb_font_url,
                'std' => 'ABeeZee',
                'desc' => '<p>
                                This option lets you set the Font of the price section.
                            </p>
                            <p>
                                Note that this option doesn’t work, if:
                            </p>
                            <ul>
                                <li>“Show Total Price” is set to “Don’t Show”.</li>
                            </ul>',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'show_subtotal',
                'dependent_condation' => 'only_price price_tax both',
            ),
            array(
                'id' => 'wb_subtotal_border_top',
                'title' => 'Show Subtotal Top Separator',
                'type' => 'radio',
                'class' => 'wb_subtotal_border_top',
                'std' => 'yes',
                'desc' => '<p>
                                This option lets you show/hide the top separator the subtotal area. 
                            </p>
                            <ul>
                                <li><strong>Yes</strong>: To show the subtotal separator.</li>
                                <li><strong>No</strong>: To hide the subtotal separator.</li>
                            </ul>',
                'choices' => array(
                    'yes' => 'Yes',
                    'no' => 'No'
                ),
                'has_dependent' => 'yes',
                'dependent_id' => 'wb_subtotal_border_top',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_subtotal_border_option',
                'title' => 'Subtotal Separator Style',
                'type' => 'select',
                'class' => 'form-control',
                'std' => 'dashed',
                'desc' => '<p>
                                This option lets you choose the subtotal separators style. 
                            </p>
                            <ul>
                                <li>Solid: To use plain solid line separator.</li>
                                <li>Dotted: To use dotted line separator.</li>
                                <li>Dashed: To use dashed line separator.</li>
                                <li>Double: To use double plain solid line separator. To use this option, you will need to increase the “Subtotal Separator width” to at least 3px.</li>
                            </ul>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Subtotal Top Separator” is set to “Yes”.</li>
                            </ul>',
                'choices' => array(
                    'solid' => 'Solid',
                    'dotted' => 'Dotted',
                    'dashed' => 'Dashed',
                    'double' => 'Double'
                ),
//                'change_property' => 'border-top-style',
//                'change_property_id' => '.wb_cart_total_wrapper',
                'dependent_from' => 'wb_subtotal_border_top',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_subtotal_border_width',
                'title' => 'Subtotal Separator width',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'desc' => '<p>
                                This option lets you set custom width of the Subtotal separator. 
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Subtotal Top Separator” is set to “Yes”.</li>
                            </ul>',
                'std' => '1',
                'help' => 'px',
                'dependent_from' => 'wb_subtotal_border_top',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_subtotal_seprator_color',
                'title' => 'Subtotal Separator color',
                'type' => 'color',
                'class' => 'form-control wb_border_color',
                'std' => '#a8a8a8',
                'desc' => '<p>
                                This option lets you set Color of the Subtotal separator.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Subtotal Top Separator” is set to “Yes”.</li>
                            </ul>',
                'change_property' => 'border-top-color',
                'change_property_id' => '.wb_cart_total_wrapper',
                'dependent_from' => 'wb_subtotal_border_top',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_subtotal_button_position',
                'title' => 'Button Position',
                'type' => 'radio',
                'class' => 'wb_subtotal_button_position',
                'std' => 'center',
                'desc' => '<p>
                                This option lets you set the horizontal position of the buttons in Subtotal area.
                            </p>',
                'choices' => array(
                    'left' => 'Left',
                    'center' => 'Center',
                    'right' => 'Right',
                ),
                'change_property' => 'text-align',
                'change_property_id' => '.wb_cart_total_wrapper .buttons',
            ),
            array(
                'id' => 'show_viewbag_button',
                'title' => 'Show View Bag Button',
                'type' => 'radio',
                'class' => 'show_viewbag_button',
                'std' => 'yes',
                'desc' => '<p>
                                This option lets you show/hide the “View Bag/Cart” button above the footer. 
                            </p>
                            <ul>
                                <li><strong>Yes</strong>: To show the “View Bag” button.</li>
                                <li><strong>No</strong>: To hide the “View Bag” button.</li>
                            </ul>',
                'choices' => array(
                    'yes' => 'Yes',
                    'no' => 'No'
                ),
                'has_dependent' => 'yes',
                'dependent_id' => 'show_viewbag_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_viewbag_button_width',
                'title' => 'View Bag Button Width',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'std' => '111',
                'desc' => '<p>
                                This option lets you set the width of the View Bag button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show View Bag Button” is set to “Yes”.</li>
                            </ul>',
                'help' => 'px',
                'change_property' => 'width',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_viewbag_button span',
                'dependent_from' => 'show_viewbag_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_viewbag_button_height',
                'title' => 'View Bag Button Height',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'std' => '26',
                'desc' => '<p>
                                This option lets you set the height of the View Bag button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show View Bag Button” is set to “Yes”.</li>
                            </ul>',
                'help' => 'px',
                'change_property' => 'height',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_viewbag_button span',
                'dependent_from' => 'show_viewbag_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'viewbag_button_text',
                'title' => 'View Bag Button Text',
                'type' => 'text',
                'class' => 'form-control',
                'std' => 'View Bag',
                'desc' => '<p>
                                This option lets you set the custom text of the “View Bag” button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show View Bag Button” is set to “Yes”.</li>
                            </ul>',
                'change_property' => 'text',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_viewbag_button span',
                'dependent_from' => 'show_viewbag_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_viewbag_button_bg_option',
                'title' => 'View Bag Button Background Option',
                'type' => 'select',
                'class' => 'form-control',
                'std' => 'color',
                'desc' => '<p>
                                This option lets you setup the background of View Bag Button. 
                            </p>
                            <ul>
                                <li><strong>Image: </strong>Using this option, you can use image as your background.</li>
                                <li><strong>Color: </strong>Using this option, you can use color as your background.</li>
                                <li><strong>Both: </strong>Using this option, you can use both image and color as your background.</li>
                                <li><strong>None: </strong>If you don’t want to use any background, choose this option.</li>
                            </ul>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show View Bag Button” is set to “Yes”.</li>
                            </ul>',
                'choices' => array(
                    'image' => 'Image',
                    'color' => 'Color',
                    'both' => 'Both',
                    'no' => 'None',
                ),
                'has_dependent' => 'yes',
                'dependent_id' => 'wb_viewbag_button_bg_option',
                'dependent_from' => 'show_viewbag_button',
                'dependent_condation' => 'yes image color both',
            ),
            array(
                'id' => 'wb_viewbag_button_bg_color',
                'title' => 'View Bag Button Background Color',
                'type' => 'color',
                'class' => 'form-control',
                'std' => '#ffffff',
                'desc' => '<p>
                                This option lets you set the background color of your View Bag Button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show View Bag Button” is set to “Yes”.</li>
                                <li>“View Bag Button Background Option” is set to “Color” or “Both”.</li>
                            </ul>',
                'change_property' => 'background-color',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_viewbag_button',
                'dependent_from' => 'show_viewbag_button wb_viewbag_button_bg_option',
                'dependent_condation' => 'yes color both',
            ),
            array(
                'id' => 'wb_viewbag_button_bg_image',
                'title' => 'View Bag Button Background Image',
                'type' => 'file',
                'class' => 'form-control wb_viewbag_button',
                'std' => '#',
                'desc' => '<p>
                                This option lets you upload/choose the image for the background of View Bag Button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show View Bag Button” is set to “Yes”.</li>
                                <li>“View Bag Button Background Option” is set to “Image” or “Both”.</li>
                            </ul>',
                'change_property' => 'background-image',
                'change_property_id' => '.wb_viewbag_button',
                'dependent_from' => 'show_viewbag_button wb_viewbag_button_bg_option',
                'dependent_condation' => 'yes image both',
            ),
            array(
                'id' => 'wb_viewbag_button_bg_image_repeat',
                'title' => 'View Bag Button Background Image Repeat',
                'type' => 'radio',
                'class' => 'wb_viewbag_button_bg_image_repeat',
                'std' => 'repeat',
                'desc' => '<p>
                                This option lets you set the repetition behaviour of the background image for View Bag Button.
                            </p>
                            <ul>
                                <li><strong>Repeat-x</strong>: To repeat the image horizontally.</li>
                                <li><strong>Repeat-y</strong>: To repeat the image vertically.</li>
                                <li><strong>Both</strong>: To repeat the image both horizontally and vertically.</li>
                                <li><strong>No-Repeat</strong>: To disable the repeat option and showing the single image.</li>
                            </ul>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show View Bag Button” is set to “Yes”.</li>
                                <li>“View Bag Button Background Option” is set to “Image” or “Both”.</li>
                            </ul>',
                'choices' => array(
                    'repeat-x' => 'Repeat-x',
                    'repeat-y' => 'Repeat-y',
                    'repeat' => 'Both',
                    'no-repeat' => 'No-Repeat',
                ),
                'change_property' => 'background-repeat',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_viewbag_button',
                'dependent_from' => 'show_viewbag_button wb_viewbag_button_bg_option',
                'dependent_condation' => 'yes image both',
            ),
            array(
                'id' => 'wb_viewbag_button_bg_image_position',
                'title' => 'View Bag Button Background Image Position',
                'type' => 'image_position',
                'class' => 'wb_viewbag_button_bg_image_position',
                'std' => '1',
                'desc' => '<p>
                                This option lets you set the position of the background image both vertically and horizontally. 
                            </p>
                            <ul>
                                <li><strong>Arrow Left</strong>: To move the image to the left hand side.</li>
                                <li><strong>Arrow Up</strong>: To move the image upwards.</li>
                                <li><strong>Arrow Right</strong>: To move the image to the right hand side.</li>
                                <li><strong>Arrow Down</strong>: To move the image downwards.</li>
                                <li><strong>Reset</strong>: To reset the image position to the default settings.</li>
                            </ul>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show View Bag Button” is set to “Yes”.</li>
                                <li>“View Bag Button Background Option” is set to “Image” or “Both”.</li>
                            </ul>',
                'change_property' => 'background-position',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_viewbag_button',
                'dependent_from' => 'show_viewbag_button wb_viewbag_button_bg_option',
                'dependent_condation' => 'yes image both',
            ),
            array(
                'id' => 'wb_viewbag_button_text_size',
                'title' => 'View Bag Button Font Size',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'std' => '14',
                'desc' => '<p>
                                This option lets you set the font size of the “View Bag” button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show View Bag Button” is set to “Yes”.</li>
                            </ul>',
                'help' => 'px',
                'change_property' => 'font-size',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_viewbag_button',
                'dependent_from' => 'show_viewbag_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_viewbag_button_text_color',
                'title' => 'View Bag Button Text Color',
                'type' => 'color',
                'class' => 'form-control',
                'std' => '#4d4d4d',
                'desc' => '<p>
                                This option lets you set the text color of the “View Bag” button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show View Bag Button” is set to “Yes”.</li>
                            </ul>',
                'change_property' => 'color',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_viewbag_button',
                'dependent_from' => 'show_viewbag_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'viewbag_button_font',
                'title' => 'View Bag Button Font',
                'type' => 'select',
                'class' => 'form-control',
                'choices' => $wb_font_url,
                'std' => 'ABeeZee',
                'desc' => '<p>
                                This option lets you set the font of the text of “View Bag” button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show View Bag Button” is set to “Yes”.</li>
                            </ul>',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'show_viewbag_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_viewbag_button_border_width',
                'title' => 'View Bag Button Border Width',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'std' => '1',
                'desc' => '<p>
                                This option lets you set the border width of the “View Bag” button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show View Bag Button” is set to “Yes”.</li>
                            </ul>',
                'help' => 'px',
                'change_property' => 'border-width',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_viewbag_button',
                'dependent_from' => 'show_viewbag_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_viewbag_button_border_radius',
                'title' => 'View Bag Button Border Radius',
                'type' => 'number',
                'min' => '0',
                'desc' => '<p>
                                This option lets you set the border radius of the “View Bag” button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show View Bag Button” is set to “Yes”.</li>
                            </ul>',
                'class' => 'form-control',
                'std' => '4',
                'help' => 'px',
                'change_property' => 'border-radius',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_viewbag_button',
                'dependent_from' => 'show_viewbag_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_viewbag_button_border_color',
                'title' => 'View Bag Button Border Color',
                'type' => 'color',
                'class' => 'form-control',
                'std' => '#7a7a7a',
                'desc' => '<p>
                                This option lets you set the border color of the “View Bag” button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show View Bag Button” is set to “Yes”.</li>
                            </ul>',
                'change_property' => 'border-color',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_viewbag_button',
                'dependent_from' => 'show_viewbag_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_viewbag_button_border_style',
                'title' => 'View Bag Button border Style',
                'type' => 'select',
                'class' => 'form-control',
                'std' => 'solid',
                'desc' => '<p>
                                This option lets you choose the View Bag button border style. 
                            </p>
                            <ul>
                                <li><strong>Solid</strong>: To use plain solid line border.</li>
                                <li><strong>Dotted</strong>: To use dotted line border.</li>
                                <li><strong>Dashed</strong>: To use dashed line border.</li>
                                <li><strong>Double</strong>: To use double plain solid line border. To use this option, you will need to increase the “View Bag Button Border Width” to at least 3px.</li>
                            </ul>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show View Bag Button” is set to “Yes”.</li>
                            </ul>',
                'choices' => array(
                    'solid' => 'Solid',
                    'dotted' => 'Dotted',
                    'dashed' => 'Dashed',
                    'double' => 'Double'
                ),
                'change_property' => 'border-style',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_viewbag_button',
                'dependent_from' => 'show_viewbag_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_viewbag_button_hover_border_color',
                'title' => 'View Bag Button Mouse Over Border Color',
                'type' => 'color',
                'class' => 'form-control',
                'std' => '#7a7a7a',
                'desc' => '<p>
                                This option lets you set the border color of the “View Bag” button when mouse pointer is brought over it.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show View Bag Button” is set to “Yes”.</li>
                            </ul>',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'show_viewbag_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_viewbag_button_hover_bg_option',
                'title' => 'View Bag Button Mouse Over Background Option',
                'type' => 'select',
                'class' => 'form-control',
                'std' => 'color',
                'desc' => '<p>
                                This option lets you setup the background of View Bag Button on mouse over. 
                            </p>
                            <p>
                                Following are the ways to set up the background: 
                            </p>
                            <ul>
                                <li><strong>Image: </strong>Using this option, you can use image as your background.</li>
                                <li><strong>Color: </strong>Using this option, you can use color as your background.</li>
                                <li><strong>Both: </strong>Using this option, you can use both image and color as your background.</li>
                                <li><strong>None: </strong>If you don’t want to use any background, choose this option.</li>
                            </ul>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show View Bag Button” is set to “Yes”.</li>
                            </ul>',
                'choices' => array(
                    'image' => 'Image',
                    'color' => 'Color',
                    'both' => 'Both',
                    'no' => 'None',
                ),
                'has_dependent' => 'yes',
                'dependent_id' => 'wb_viewbag_button_hover_bg_option',
                'dependent_from' => 'show_viewbag_button',
                'dependent_condation' => 'yes color both image',
            ),
            array(
                'id' => 'wb_viewbag_button_hover_bg_color',
                'title' => 'View Bag Button Mouse Over Background Color',
                'type' => 'color',
                'class' => 'form-control',
                'std' => '#e3e3e3',
                'desc' => '<p>
                                This option lets you choose the color for the background of View Bag Button on mouse over.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show View Bag Button” is set to “Yes”.</li>
                                <li>“View Bag Button Background Option” is set to “Color” or “Both”.</li>
                            </ul>',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'show_viewbag_button wb_viewbag_button_hover_bg_option',
                'dependent_condation' => 'yes color both',
            ),
            array(
                'id' => 'wb_viewbag_button_hover_bg_image',
                'title' => 'View Bag Button Mouse Over Background Image',
                'type' => 'file',
                'class' => 'form-control',
                'std' => '#',
                'desc' => ' <p>
                                This option lets you upload/choose the image for the background of View Bag Button on mouse over.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show View Bag Button” is set to “Yes”.</li>
                                <li>“View Bag Button Background Option” is set to “Image” or “Both”.</li>
                            </ul>',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'show_viewbag_button wb_viewbag_button_hover_bg_option',
                'dependent_condation' => 'yes both image',
            ),
            array(
                'id' => 'wb_viewbag_button_hover_bg_image_repeat',
                'title' => 'View Bag Button Mouse Over Background Image Repeat',
                'type' => 'radio',
                'class' => 'wb_viewbag_button_hover_bg_image_repeat',
                'std' => 'repeat',
                'desc' => '<p>
                                This option lets you set the repetition behaviour of the background image for View Bag Button on mouse over.
                            </p>
                            <ul>
                                <li><strong>Repeat-x</strong>: To repeat the image horizontally.</li>
                                <li><strong>Repeat-y</strong>: To repeat the image vertically.</li>
                                <li><strong>Both</strong>: To repeat the image both horizontally and vertically.</li>
                                <li><strong>No-Repeat</strong>: To disable the repeat option and showing the single image.</li>
                            </ul>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show View Bag Button” is set to “Yes”.</li>
                                <li>“View Bag Button Background Option” is set to “Image” or “Both”.</li>
                            </ul>',
                'choices' => array(
                    'repeat-x' => 'Repeat-x',
                    'repeat-y' => 'Repeat-y',
                    'repeat' => 'Both',
                    'no-repeat' => 'No-Repeat',
                ),
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'show_viewbag_button wb_viewbag_button_hover_bg_option',
                'dependent_condation' => 'yes both image',
            ),
            array(
                'id' => 'wb_viewbag_button_hover_bg_image_position',
                'title' => 'View Bag Button Mouse Over Background Image Position',
                'type' => 'image_position',
                'class' => 'wb_viewbag_button_hover_bg_image_position',
                'std' => '1',
                'desc' => '<p>
                                This option lets you set the position of the background image on mouse over both vertically and horizontally. 
                            </p>
                            <ul>
                                <li><strong>Arrow Left</strong>: To move the image to the left hand side.</li>
                                <li><strong>Arrow Up</strong>: To move the image upwards.</li>
                                <li><strong>Arrow Right</strong>: To move the image to the right hand side.</li>
                                <li><strong>Arrow Down</strong>: To move the image downwards.</li>
                                <li><strong>Reset</strong>: To reset the image position to the default settings.</li>
                            </ul>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show View Bag Button” is set to “Yes”.</li>
                                <li>“View Bag Button Background Option” is set to “Image” or “Both”.</li>
                            </ul>',
                'dependent_from' => 'show_viewbag_button wb_viewbag_button_hover_bg_option',
                'dependent_condation' => 'yes image both',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
            ),
            array(
                'id' => 'wb_viewbag_button_hover_text_color',
                'title' => 'View Bag Button Mouse Over Text Color',
                'type' => 'color',
                'class' => 'form-control',
                'std' => '#000000',
                'desc' => '<p>
                                This option lets you set the text color of the “View Bag” button when mouse pointer is brought over it.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show View Bag Button” is set to “Yes”.</li>
                            </ul>',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'show_viewbag_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'show_checkout_button',
                'title' => 'Show Checkout Button',
                'type' => 'radio',
                'class' => 'show_checkout_button',
                'std' => 'yes',
                'desc' => '<p>
                                This option lets you show/hide the “Checkout” button above the footer. 
                            </p>
                            <ul>
                                <li><strong>Yes</strong>: To show the “Checkout” button.</li>
                                <li><strong>No</strong>: To hide the “Checkout” button.</li>
                            </ul>',
                'choices' => array(
                    'yes' => 'Yes',
                    'no' => 'No'
                ),
                'has_dependent' => 'yes',
                'dependent_id' => 'show_checkout_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_checkout_button_width',
                'title' => 'Checkout Button Width',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'std' => '111',
                'desc' => '<p>
                                This option lets you set the width of the Checkout button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Checkout Button” is set to “Yes”.</li>
                            </ul>',
                'help' => 'px',
                'change_property' => 'width',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_checkout_button span',
                'dependent_from' => 'show_checkout_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_checkout_button_height',
                'title' => 'Checkout Button Height',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'std' => '26',
                'desc' => '<p>
                                This option lets you set the height of the Checkout button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Checkout Button” is set to “Yes”.</li>
                            </ul>',
                'help' => 'px',
                'change_property' => 'height',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_checkout_button span',
                'dependent_from' => 'show_checkout_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'checkout_button_text',
                'title' => 'Checkout Button Text',
                'type' => 'text',
                'class' => 'form-control',
                'std' => 'Checkout',
                'desc' => '<p>
                                This option lets you set the custom text of the “Checkout” button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Checkout Button” is set to “Yes”.</li>
                            </ul>',
                'change_property' => 'text',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_checkout_button span',
                'dependent_from' => 'show_checkout_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_checkout_button_bg_option',
                'title' => 'Checkout Button Background Option',
                'type' => 'select',
                'class' => 'form-control',
                'std' => 'color',
                'desc' => '<p>
                                This option lets you setup the background of Checkout Button. 
                            </p>
                            <ul>
                                <li><strong>Image: </strong>Using this option, you can use image as your background.</li>
                                <li><strong>Color: </strong>Using this option, you can use color as your background.</li>
                                <li><strong>Both: </strong>Using this option, you can use both image and color as your background.</li>
                                <li><strong>None: </strong>If you don’t want to use any background, choose this option.</li>
                            </ul>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Checkout Button” is set to “Yes”.</li>
                            </ul>',
                'choices' => array(
                    'image' => 'Image',
                    'color' => 'Color',
                    'both' => 'Both',
                    'no' => 'None',
                ),
                'has_dependent' => 'yes',
                'dependent_id' => 'wb_checkout_button_bg_option',
                'dependent_from' => 'show_checkout_button',
                'dependent_condation' => 'yes image color both',
            ),
            array(
                'id' => 'wb_checkout_button_bg_color',
                'title' => 'Checkout Button Background Color',
                'type' => 'color',
                'class' => 'form-control',
                'std' => '#919191',
                'desc' => '<p>
                                This option lets you set the background color of your Checkout Button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Checkout Button” is set to “Yes”.</li>
                                <li>“Checkout Button Background Option” is set to “Color” or “Both”.</li>
                            </ul>',
                'change_property' => 'background-color',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_checkout_button',
                'dependent_from' => 'show_checkout_button wb_checkout_button_bg_option',
                'dependent_condation' => 'yes color both',
            ),
            array(
                'id' => 'wb_checkout_button_bg_image',
                'title' => 'Checkout Button Background Image',
                'type' => 'file',
                'class' => 'form-control wb_checkout_button',
                'std' => '#',
                'desc' => '<p>
                                This option lets you upload/choose the image for the background of Checkout Button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Checkout Button” is set to “Yes”.</li>
                                <li>“Checkout Button Background Option” is set to “Image” or “Both”.</li>
                            </ul>',
                'change_property' => 'background-image',
                'change_property_id' => '.wb_checkout_button',
                'dependent_from' => 'show_checkout_button wb_checkout_button_bg_option',
                'dependent_condation' => 'yes image both',
            ),
            array(
                'id' => 'wb_checkout_button_bg_image_repeat',
                'title' => 'Checkout Button Background Image Repeat',
                'type' => 'radio',
                'class' => 'wb_checkout_button_bg_image_repeat',
                'std' => 'repeat',
                'desc' => '<p>
                                This option lets you set the repetition behaviour of the background image for Checkout Button.
                            </p>
                            <ul>
                                <li><strong>Repeat-x</strong>: To repeat the image horizontally.</li>
                                <li><strong>Repeat-y</strong>: To repeat the image vertically.</li>
                                <li><strong>Both</strong>: To repeat the image both horizontally and vertically.</li>
                                <li><strong>No-Repeat</strong>: To disable the repeat option and showing the single image.</li>
                            </ul>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Checkout Button” is set to “Yes”.</li>
                                <li>“Checkout Button Background Option” is set to “Image” or “Both”.</li>
                            </ul>',
                'choices' => array(
                    'repeat-x' => 'Repeat-x',
                    'repeat-y' => 'Repeat-y',
                    'repeat' => 'Both',
                    'no-repeat' => 'No-Repeat',
                ),
                'change_property' => 'background-repeat',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_checkout_button',
                'dependent_from' => 'show_checkout_button wb_checkout_button_bg_option',
                'dependent_condation' => 'yes image both',
            ),
            array(
                'id' => 'wb_checkout_button_bg_image_position',
                'title' => 'Checkout Button Background Image Position',
                'type' => 'image_position',
                'class' => 'wb_checkout_button_bg_image_position',
                'std' => '1',
                'desc' => '<p>
                                This option lets you set the position of the background image both vertically and horizontally. 
                            </p>
                            <ul>
                                <li><strong>Arrow Left</strong>: To move the image to the left hand side.</li>
                                <li><strong>Arrow Up</strong>: To move the image upwards.</li>
                                <li><strong>Arrow Right</strong>: To move the image to the right hand side.</li>
                                <li><strong>Arrow Down</strong>: To move the image downwards.</li>
                                <li><strong>Reset</strong>: To reset the image position to the default settings.</li>
                            </ul>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Checkout Button” is set to “Yes”.</li>
                                <li>“Checkout Button Background Option” is set to “Image” or “Both”.</li>
                            </ul>',
                'change_property' => 'background-position',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_checkout_button',
                'dependent_from' => 'show_checkout_button wb_checkout_button_bg_option',
                'dependent_condation' => 'yes image both',
            ),
            array(
                'id' => 'wb_checkout_button_text_color',
                'title' => 'Checkout Button Text Color',
                'type' => 'color',
                'class' => 'form-control',
                'std' => '#ffffff',
                'desc' => '<p>
                                This option lets you set the text color of the “Checkout” button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Checkout Button” is set to “Yes”.</li>
                            </ul>',
                'change_property' => 'color',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_checkout_button',
                'dependent_from' => 'show_checkout_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_checkout_button_text_size',
                'title' => 'Checkout Button Font Size',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'std' => '14',
                'desc' => '<p>
                                This option lets you set the font size of the “Checkout” button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Checkout Button” is set to “Yes”.</li>
                            </ul>',
                'help' => 'px',
                'change_property' => 'font-size',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_checkout_button',
                'dependent_from' => 'show_checkout_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'checkout_button_font',
                'title' => 'Checkout Button Font',
                'type' => 'select',
                'class' => 'form-control',
                'choices' => $wb_font_url,
                'std' => 'ABeeZee',
                'desc' => '<p>
                                This option lets you set the font of the text of “Checkout” button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Checkout Button” is set to “Yes”.</li>
                            </ul>',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'show_checkout_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_checkout_button_border_width',
                'title' => 'Checkout Button Border Width',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'std' => '1',
                'desc' => '<p>
                                This option lets you set the border width of the “Checkout” button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Checkout Button” is set to “Yes”.</li>
                            </ul>',
                'help' => 'px',
                'change_property' => 'border-width',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_checkout_button',
                'dependent_from' => 'show_checkout_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_checkout_button_border_color',
                'title' => 'Checkout Button Border Color',
                'type' => 'color',
                'class' => 'form-control',
                'std' => '#595959',
                'desc' => '<p>
                                This option lets you set the border color of the “Checkout” button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Checkout Button” is set to “Yes”.</li>
                            </ul>',
                'change_property' => 'border-color',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_checkout_button',
                'dependent_from' => 'show_checkout_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_checkout_button_border_radius',
                'title' => 'Checkout Button Border Radius',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'std' => '4',
                'desc' => ' <p>
                                This option lets you set the border radius of the “Checkout” button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Checkout Button” is set to “Yes”.</li>
                            </ul>',
                'help' => 'px',
                'change_property' => 'border-radius',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_checkout_button',
                'dependent_from' => 'show_checkout_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_checkout_button_border_style',
                'title' => 'Checkout Button border Style',
                'type' => 'select',
                'class' => 'form-control',
                'std' => 'solid',
                'desc' => '<p>
                                This option lets you choose the Checkout button border style. 
                            </p>
                            <ul>
                                <li><strong>Solid</strong>: To use plain solid line border.</li>
                                <li><strong>Dotted</strong>: To use dotted line border.</li>
                                <li><strong>Dashed</strong>: To use dashed line border.</li>
                                <li><strong>Double</strong>: To use double plain solid line border. To use this option, you will need to increase the “Checkout Button Border Width” to at least 3px.</li>
                            </ul>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Checkout Button” is set to “Yes”.</li>
                            </ul>',
                'choices' => array(
                    'solid' => 'Solid',
                    'dotted' => 'Dotted',
                    'dashed' => 'Dashed',
                    'double' => 'Double'
                ),
                'change_property' => 'border-style',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_checkout_button',
                'dependent_from' => 'show_checkout_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_checkout_button_hover_border_color',
                'title' => 'Checkout Button Mouse Over Border Color',
                'type' => 'color',
                'class' => 'form-control',
                'std' => '#595959',
                'desc' => '<p>
                                This option lets you set the border color of the “Checkout” button when mouse pointer is brought over it.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Checkout Button” is set to “Yes”.</li>
                            </ul>',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'show_checkout_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_checkout_button_hover_bg_option',
                'title' => 'Checkout Button Mouse Over Background Option',
                'type' => 'select',
                'class' => 'form-control',
                'std' => 'color',
                'desc' => '<p>
                                This option lets you setup the background of Checkout Button on mouse over. 
                            </p>
                            <p>
                                Following are the ways to set up the background: 
                            </p>
                            <ul>
                                <li><strong>Image: </strong>Using this option, you can use image as your background.</li>
                                <li><strong>Color: </strong>Using this option, you can use color as your background.</li>
                                <li><strong>Both: </strong>Using this option, you can use both image and color as your background.</li>
                                <li><strong>None: </strong>If you don’t want to use any background, choose this option.</li>
                            </ul>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Checkout Button” is set to “Yes”.</li>
                            </ul>',
                'choices' => array(
                    'image' => 'Image',
                    'color' => 'Color',
                    'both' => 'Both',
                    'no' => 'None',
                ),
                'has_dependent' => 'yes',
                'dependent_id' => 'wb_checkout_button_hover_bg_option',
                'dependent_from' => 'show_checkout_button',
                'dependent_condation' => 'yes image color both',
            ),
            array(
                'id' => 'wb_checkout_button_hover_bg_color',
                'title' => 'Checkout Button Mouse Over Background Color',
                'type' => 'color',
                'class' => 'form-control',
                'std' => '#c7c7c7',
                'desc' => '<p>

                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Checkout Button” is set to “Yes”.</li>
                                <li>“Checkout Button Background Option” is set to “Color” or “Both”.</li>
                            </ul>',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'show_checkout_button wb_checkout_button_hover_bg_option',
                'dependent_condation' => 'yes color both',
            ),
            array(
                'id' => 'wb_checkout_button_hover_bg_image',
                'title' => 'Checkout Button Mouse Over Background Image',
                'type' => 'file',
                'class' => 'form-control',
                'std' => '#',
                'desc' => '<p>
                                This option lets you upload/choose the image for the background of Checkout Button on mouse over.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Checkout Button” is set to “Yes”.</li>
                                <li>“Checkout Button Background Option” is set to “Image” or “Both”.</li>
                            </ul>',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'show_checkout_button wb_checkout_button_hover_bg_option',
                'dependent_condation' => 'yes image both',
            ),
            array(
                'id' => 'wb_checkout_button_hover_bg_image_repeat',
                'title' => 'Checkout Button Mouse Over Background Image Repeat',
                'type' => 'radio',
                'class' => 'wb_checkout_button_hover_bg_image_repeat',
                'std' => 'repeat',
                'desc' => '<p>
                                This option lets you set the repetition behaviour of the background image for Checkout Button on mouse over.
                            </p>
                            <ul>
                                <li><strong>Repeat-x</strong>: To repeat the image horizontally.</li>
                                <li><strong>Repeat-y</strong>: To repeat the image vertically.</li>
                                <li><strong>Both</strong>: To repeat the image both horizontally and vertically.</li>
                                <li><strong>No-Repeat</strong>: To disable the repeat option and showing the single image.</li>
                            </ul>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Checkout Button” is set to “Yes”.</li>
                                <li>“Checkout Button Background Option” is set to “Image” or “Both”.</li>
                            </ul>',
                'choices' => array(
                    'repeat-x' => 'Repeat-x',
                    'repeat-y' => 'Repeat-y',
                    'repeat' => 'Both',
                    'no-repeat' => 'No-Repeat',
                ),
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'show_checkout_button wb_checkout_button_hover_bg_option',
                'dependent_condation' => 'yes image both',
            ),
            array(
                'id' => 'wb_checkout_button_hover_bg_image_position',
                'title' => 'Checkout Button Mouse Over Background Image Position',
                'type' => 'image_position',
                'class' => 'wb_checkout_button_hover_bg_image_position',
                'std' => '1',
                'desc' => '<p>
                                This option lets you set the position of the background image on mouse over both vertically and horizontally. 
                            </p>
                            <ul>
                                <li><strong>Arrow Left</strong>: To move the image to the left hand side.</li>
                                <li><strong>Arrow Up</strong>: To move the image upwards.</li>
                                <li><strong>Arrow Right</strong>: To move the image to the right hand side.</li>
                                <li><strong>Arrow Down</strong>: To move the image downwards.</li>
                                <li><strong>Reset</strong>: To reset the image position to the default settings.</li>
                            </ul>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Checkout Button” is set to “Yes”.</li>
                                <li>“Checkout Button Background Option” is set to “Image” or “Both”.</li>
                            </ul>',
                'dependent_from' => 'show_checkout_button wb_checkout_button_hover_bg_option',
                'dependent_condation' => 'yes image both',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
            ),
            array(
                'id' => 'wb_checkout_button_hover_text_color',
                'title' => 'Checkout Button Mouse Over Text Color',
                'type' => 'color',
                'class' => 'form-control',
                'std' => '#525252',
                'desc' => '<p>
                                This option lets you set the text color of the “Checkout” button when mouse pointer is brought over it.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Checkout Button” is set to “Yes”.</li>
                            </ul>',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'show_checkout_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'show_empty_cart_button',
                'title' => 'Show Empty Cart Button',
                'type' => 'radio',
                'class' => 'show_empty_cart_button',
                'std' => 'no',
                'desc' => '<p>
                                This option lets you show/hide the “Empty Cart” button above the footer. 
                            </p>
                            <ul>
                                <li><strong>Yes</strong>: To show the “Empty Cart” button.</li>
                                <li><strong>No</strong>: To hide the “Empty Cart” button.</li>
                            </ul>',
                'choices' => array(
                    'yes' => 'Yes',
                    'no' => 'No'
                ),
                'has_dependent' => 'yes',
                'dependent_id' => 'show_empty_cart_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_empty_cart_button_width',
                'title' => 'Empty Cart Button Width',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'std' => '90',
                'desc' => '<p>
                                This option lets you set the width of the Empty Cart  button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Empty Cart  Button” is set to “Yes”.</li>
                            </ul>',
                'help' => 'px',
                'change_property' => 'width',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_empty_cart_button span',
                'dependent_from' => 'show_empty_cart_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_empty_cart_button_height',
                'title' => 'Empty Cart Button Height',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'std' => '29',
                'desc' => '<p>
                                This option lets you set the height of the Empty Cart  button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Empty Cart  Button” is set to “Yes”.</li>
                            </ul>',
                'help' => 'px',
                'change_property' => 'height',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_empty_cart_button span',
                'dependent_from' => 'show_empty_cart_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'empty_cart_button_text',
                'title' => 'Empty Cart Button Text',
                'type' => 'text',
                'class' => 'form-control',
                'std' => 'Empty Cart',
                'desc' => '<p>
                                This option lets you set the custom text of the “Empty Cart” button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Empty Cart  Button” is set to “Yes”.</li>
                            </ul>',
                'change_property' => 'text',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_empty_cart_button span',
                'dependent_from' => 'show_empty_cart_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_empty_cart_button_bg_option',
                'title' => 'Empty Cart Button Background Option',
                'type' => 'select',
                'class' => 'form-control',
                'std' => 'color',
                'desc' => '<ul>
                                <li><strong>Image: </strong>Using this option, you can use image as your background.</li>
                                <li><strong>Color: </strong>Using this option, you can use color as your background.</li>
                                <li><strong>Both: </strong>Using this option, you can use both image and color as your background.</li>
                                <li><strong>None: </strong>If you don’t want to use any background, choose this option.</li>
                            </ul>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Empty Cart  Button” is set to “Yes”.</li>
                            </ul>',
                'choices' => array(
                    'image' => 'Image',
                    'color' => 'Color',
                    'both' => 'Both',
                    'no' => 'None',
                ),
                'has_dependent' => 'yes',
                'dependent_id' => 'wb_empty_cart_button_bg_option',
                'dependent_from' => 'show_empty_cart_button',
                'dependent_condation' => 'yes image color both',
            ),
            array(
                'id' => 'wb_empty_cart_button_bg_color',
                'title' => 'Empty Cart Button Background Color',
                'type' => 'color',
                'class' => 'form-control',
                'std' => '#ffffff',
                'desc' => '<p>
                                This option lets you set the background color of your Empty Cart  Button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Empty Cart  Button” is set to “Yes”.</li>
                                <li>“Empty Cart  Button Background Option” is set to “Color” or “Both”.</li>
                            </ul>',
                'change_property' => 'background-color',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_empty_cart_button',
                'dependent_from' => 'show_empty_cart_button wb_empty_cart_button_bg_option',
                'dependent_condation' => 'yes color both',
            ),
            array(
                'id' => 'wb_empty_cart_button_bg_image',
                'title' => 'Empty Cart Background Image',
                'type' => 'file',
                'class' => 'form-control wb_empty_cart_button',
                'std' => '#',
                'desc' => '<p>
                                This option lets you upload/choose the image for the background of Empty Cart  Button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Empty Cart  Button” is set to “Yes”.</li>
                                <li>“Empty Cart  Button Background Option” is set to “Image” or “Both”.</li>
                            </ul>',
                'change_property' => 'background-image',
                'change_property_id' => '.wb_empty_cart_button',
                'dependent_from' => 'show_empty_cart_button wb_empty_cart_button_bg_option',
                'dependent_condation' => 'yes image both',
            ),
            array(
                'id' => 'wb_empty_cart_button_bg_image_repeat',
                'title' => 'Empty Cart Background Image Repeat',
                'type' => 'radio',
                'class' => 'wb_empty_cart_button_bg_image_repeat',
                'std' => 'repeat',
                'desc' => '<p>
                                This option lets you set the repetition behaviour of the background image for Empty Cart  Button.
                            </p>
                            <ul>
                                <li><strong>Repeat-x</strong>: To repeat the image horizontally.</li>
                                <li><strong>Repeat-y</strong>: To repeat the image vertically.</li>
                                <li><strong>Both</strong>: To repeat the image both horizontally and vertically.</li>
                                <li><strong>No-Repeat</strong>: To disable the repeat option and showing the single image.</li>
                            </ul>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Empty Cart  Button” is set to “Yes”.</li>
                                <li>“Empty Cart  Button Background Option” is set to “Image” or “Both”.</li>
                            </ul>',
                'choices' => array(
                    'repeat-x' => 'Repeat-x',
                    'repeat-y' => 'Repeat-y',
                    'repeat' => 'Both',
                    'no-repeat' => 'No-Repeat',
                ),
                'change_property' => 'background-repeat',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_empty_cart_button',
                'dependent_from' => 'show_empty_cart_button wb_empty_cart_button_bg_option',
                'dependent_condation' => 'yes image both',
            ),
            array(
                'id' => 'wb_empty_cart_button_bg_image_position',
                'title' => 'Empty Cart Button Background Image Position',
                'type' => 'image_position',
                'class' => 'wb_empty_cart_button_bg_image_position',
                'std' => '1',
                'desc' => '<p>
                                This option lets you set the position of the background image both vertically and horizontally. 
                            </p>
                            <ul>
                                <li><strong>Arrow Left</strong>: To move the image to the left hand side.</li>
                                <li><strong>Arrow Up</strong>: To move the image upwards.</li>
                                <li><strong>Arrow Right</strong>: To move the image to the right hand side.</li>
                                <li><strong>Arrow Down</strong>: To move the image downwards.</li>
                                <li><strong>Reset</strong>: To reset the image position to the default settings.</li>
                            </ul>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Empty Cart  Button” is set to “Yes”.</li>
                                <li>“Empty Cart  Button Background Option” is set to “Image” or “Both”.</li>
                            </ul>',
                'change_property' => 'background-position',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_empty_cart_button',
                'dependent_from' => 'show_empty_cart_button wb_empty_cart_button_bg_option',
                'dependent_condation' => 'yes image both',
            ),
            array(
                'id' => 'wb_empty_cart_button_text_color',
                'title' => 'Empty Cart Button Text Color',
                'type' => 'color',
                'class' => 'form-control',
                'std' => '#000000',
                'desc' => '<p>
                                This option lets you set the text color of the “Empty Cart” button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Empty Cart  Button” is set to “Yes”.</li>
                            </ul>',
                'change_property' => 'color',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_empty_cart_button',
                'dependent_from' => 'show_empty_cart_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_empty_cart_button_text_size',
                'title' => 'Empty Cart Button Font Size',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'std' => '14',
                'desc' => '<p>
                                This option lets you set the font size of the “Empty Cart” button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Empty Cart  Button” is set to “Yes”.</li>
                            </ul>',
                'help' => 'px',
                'change_property' => 'font-size',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_empty_cart_button',
                'dependent_from' => 'show_empty_cart_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'empty_cart_button_font',
                'title' => 'Empty Cart Button Font',
                'type' => 'select',
                'class' => 'form-control',
                'choices' => $wb_font_url,
                'std' => 'ABeeZee',
                'desc' => '<p>
                                This option lets you set the font of the text of “Empty Cart” button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Empty Cart  Button” is set to “Yes”.</li>
                            </ul>',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'show_empty_cart_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_empty_cart_button_border_width',
                'title' => 'Empty Cart Button Border Width',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'std' => '1',
                'desc' => '<p>
                                This option lets you set the border width of the “Empty Cart” button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Empty Cart  Button” is set to “Yes”.</li>
                            </ul>',
                'help' => 'px',
                'change_property' => 'border-width',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_empty_cart_button',
                'dependent_from' => 'show_empty_cart_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_empty_cart_button_border_color',
                'title' => 'Empty Cart Button Border Color',
                'type' => 'color',
                'class' => 'form-control',
                'std' => '#000000',
                'desc' => '<p>
                                This option lets you set the border color of the “Empty Cart” button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Empty Cart  Button” is set to “Yes”.</li>
                            </ul>',
                'change_property' => 'border-color',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_empty_cart_button',
                'dependent_from' => 'show_empty_cart_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_empty_cart_button_border_radius',
                'title' => 'Empty Cart Button Border Radius',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'std' => '1',
                'desc' => '<p>
                                This option lets you set the border radius of the “Empty Cart” button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Empty Cart  Button” is set to “Yes”.</li>
                            </ul>',
                'help' => 'px',
                'change_property' => 'border-radius',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_empty_cart_button',
                'dependent_from' => 'show_empty_cart_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_empty_cart_button_border_style',
                'title' => 'Empty Cart Button border Style',
                'type' => 'select',
                'class' => 'form-control',
                'std' => 'solid',
                'desc' => '<p>
                                This option lets you choose the Empty Cart  button border style. 
                            </p>
                            <ul>
                                <li><strong>Solid</strong>: To use plain solid line border.</li>
                                <li><strong>Dotted</strong>: To use dotted line border.</li>
                                <li><strong>Dashed</strong>: To use dashed line border.</li>
                                <li><strong>Double</strong>: To use double plain solid line border. To use this option, you will need to increase the “Empty Cart  Button Border Width” to at least 3px.</li>
                            </ul>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Empty Cart  Button” is set to “Yes”.</li>
                            </ul>',
                'choices' => array(
                    'solid' => 'Solid',
                    'dotted' => 'Dotted',
                    'dashed' => 'Dashed',
                    'double' => 'Double'
                ),
                'change_property' => 'border-style',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_empty_cart_button',
                'dependent_from' => 'show_empty_cart_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_empty_cart_button_hover_border_color',
                'title' => 'Empty Cart Button Mouse Over Border Color',
                'type' => 'color',
                'class' => 'form-control',
                'std' => '#cccccc',
                'desc' => '<p>
                                This option lets you set the border color of the “Empty Cart” button when mouse pointer is brought over it.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Empty Cart  Button” is set to “Yes”.</li>
                            </ul>',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'show_empty_cart_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_empty_cart_button_hover_bg_option',
                'title' => 'Empty Cart Button Mouse Over Background Option',
                'type' => 'select',
                'class' => 'form-control',
                'std' => 'color',
                'desc' => '<p>
                                This option lets you setup the background of Empty Cart  Button on mouse over. 
                            </p>
                            <p>
                                Following are the ways to set up the background: 
                            </p>
                            <ul>
                                <li><strong>Image: </strong>Using this option, you can use image as your background.</li>
                                <li><strong>Color: </strong>Using this option, you can use color as your background.</li>
                                <li><strong>Both: </strong>Using this option, you can use both image and color as your background.</li>
                                <li><strong>None: </strong>If you don’t want to use any background, choose this option.</li>
                            </ul>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Empty Cart  Button” is set to “Yes”.</li>
                            </ul>',
                'choices' => array(
                    'image' => 'Image',
                    'color' => 'Color',
                    'both' => 'Both',
                    'no' => 'None',
                ),
                'has_dependent' => 'yes',
                'dependent_id' => 'wb_empty_cart_button_hover_bg_option',
                'dependent_from' => 'show_empty_cart_button',
                'dependent_condation' => 'yes image both color',
            ),
            array(
                'id' => 'wb_empty_cart_button_hover_bg_color',
                'title' => 'Empty Cart Button Mouse Over Background Color',
                'type' => 'color',
                'class' => 'form-control',
                'std' => '#cccccc',
                'desc' => '<p>
                                This option lets you choose the color for the background of Empty Cart  Button on mouse over.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Empty Cart  Button” is set to “Yes”.</li>
                                <li>“Empty Cart  Button Background Option” is set to “Color” or “Both”.</li>
                            </ul>',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'show_empty_cart_button wb_empty_cart_button_hover_bg_option',
                'dependent_condation' => 'yes both color',
            ),
            array(
                'id' => 'wb_empty_cart_button_hover_bg_image',
                'title' => 'Empty Cart Mouse Over Background Image',
                'type' => 'file',
                'class' => 'form-control',
                'std' => '#',
                'desc' => '<p>
                                This option lets you upload/choose the image for the background of Empty Cart  Button on mouse over.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Empty Cart  Button” is set to “Yes”.</li>
                                <li>“Empty Cart  Button Background Option” is set to “Image” or “Both”.</li>
                            </ul>',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'show_empty_cart_button wb_empty_cart_button_hover_bg_option',
                'dependent_condation' => 'yes image both',
            ),
            array(
                'id' => 'wb_empty_cart_button_hover_bg_image_repeat',
                'title' => 'Empty Cart Mouse Over Background Image Repeat',
                'type' => 'radio',
                'class' => 'wb_empty_cart_button_hover_bg_image_repeat',
                'std' => 'repeat',
                'desc' => '<p>
                                This option lets you set the repetition behaviour of the background image for Empty Cart  Button on mouse over.
                            </p>
                            <ul>
                                <li><strong>Repeat-x</strong>: To repeat the image horizontally.</li>
                                <li><strong>Repeat-y</strong>: To repeat the image vertically.</li>
                                <li><strong>Both</strong>: To repeat the image both horizontally and vertically.</li>
                                <li><strong>No-Repeat</strong>: To disable the repeat option and showing the single image.</li>
                            </ul>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Empty Cart  Button” is set to “Yes”.</li>
                                <li>“Empty Cart  Button Background Option” is set to “Image” or “Both”.</li>
                            </ul>',
                'choices' => array(
                    'repeat-x' => 'Repeat-x',
                    'repeat-y' => 'Repeat-y',
                    'repeat' => 'Both',
                    'no-repeat' => 'No-Repeat',
                ),
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'show_empty_cart_button wb_empty_cart_button_hover_bg_option',
                'dependent_condation' => 'yes image both',
            ),
            array(
                'id' => 'wb_empty_cart_button_hover_bg_image_position',
                'title' => 'Empty Cart Button Mouse Over Background Image Position',
                'type' => 'image_position',
                'class' => 'wb_empty_cart_button_hover_bg_image_position',
                'std' => '1',
                'desc' => '<p>
                                This option lets you set the position of the background image on mouse over both vertically and horizontally. 
                            </p>
                            <ul>
                                <li><strong>Arrow Left</strong>: To move the image to the left hand side.</li>
                                <li><strong>Arrow Up</strong>: To move the image upwards.</li>
                                <li><strong>Arrow Right</strong>: To move the image to the right hand side.</li>
                                <li><strong>Arrow Down</strong>: To move the image downwards.</li>
                                <li><strong>Reset</strong>: To reset the image position to the default settings.</li>
                            </ul>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Empty Cart  Button” is set to “Yes”.</li>
                                <li>“Empty Cart  Button Background Option” is set to “Image” or “Both”.</li>
                            </ul>',
                'dependent_from' => 'show_empty_cart_button wb_empty_cart_button_hover_bg_option',
                'dependent_condation' => 'yes image both',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
            ),
            array(
                'id' => 'wb_empty_cart_button_hover_text_color',
                'title' => 'Empty Cart Button Mouse Over Text Color',
                'type' => 'color',
                'class' => 'form-control',
                'std' => '#000000',
                'desc' => '<p>
                                This option lets you set the text color of the “Empty Cart” button when mouse pointer is brought over it.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Empty Cart Button” is set to “Yes”.</li>
                            </ul>',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'show_empty_cart_button',
                'dependent_condation' => 'yes',
            ),
            /** Custom Button * */
            array(
                'id' => 'show_custom_button',
                'title' => 'Create Custom Button ',
                'type' => 'radio',
                'class' => 'show_custom_button',
                'std' => 'no',
                'desc' => '<p>
                                This option lets you show/hide the “Custom/User-defined” button above the footer where you 
                                can set the Text and URL of your own choice. 
                            </p>
                            <ul>
                                <li><strong>Yes</strong>: To show the “Custom” button.</li>
                                <li><strong>No</strong>: To hide the “Custom” button.</li>
                            </ul>',
                'choices' => array(
                    'yes' => 'Yes',
                    'no' => 'No'
                ),
                'has_dependent' => 'yes',
                'dependent_id' => 'show_custom_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_custom_button_width',
                'title' => 'Custom Button Width',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'std' => '75',
                'desc' => '<p>
                                This option lets you set the width of the Custom  button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Custom  Button” is set to “Yes”.</li>
                            </ul>',
                'help' => 'px',
                'change_property' => 'width',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_custom_button span',
                'dependent_from' => 'show_custom_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_custom_button_height',
                'title' => 'Custom Button Height',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'std' => '29',
                'desc' => '<p>
                                This option lets you set the height of the Custom  button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Custom  Button” is set to “Yes”.</li>
                            </ul>',
                'help' => 'px',
                'change_property' => 'height',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_custom_button span',
                'dependent_from' => 'show_custom_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'custom_button_text',
                'title' => 'Custom Button Text',
                'type' => 'text',
                'class' => 'form-control',
                'std' => 'Custom',
                'desc' => '<p>
                                This option lets you set the custom text of the “Custom” button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Custom  Button” is set to “Yes”.</li>
                            </ul>',
                'change_property' => 'text',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_custom_button span',
                'dependent_from' => 'show_custom_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'custom_button_url',
                'title' => 'Custom Button URL',
                'type' => 'text',
                'class' => 'form-control',
                'std' => '#',
                'desc' => '<p>
                                This option lets you put in any URL of your choice to link the button to. 
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Custom  Button” is set to “Yes”.</li>
                            </ul>',
                'dependent_from' => 'show_custom_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_custom_button_bg_option',
                'title' => 'Custom Button Background Option',
                'type' => 'select',
                'class' => 'form-control',
                'std' => 'color',
                'desc' => '<p>
                                This option lets you setup the background of Custom  Button. 
                            </p>
                            <ul>
                                <li><strong>Image: </strong>Using this option, you can use image as your background.</li>
                                <li><strong>Color: </strong>Using this option, you can use color as your background.</li>
                                <li><strong>Both: </strong>Using this option, you can use both image and color as your background.</li>
                                <li><strong>None: </strong>If you don’t want to use any background, choose this option.</li>
                            </ul>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Custom  Button” is set to “Yes”.</li>
                            </ul>',
                'choices' => array(
                    'image' => 'Image',
                    'color' => 'Color',
                    'both' => 'Both',
                    'no' => 'None',
                ),
                'has_dependent' => 'yes',
                'dependent_id' => 'wb_custom_button_bg_option',
                'dependent_from' => 'show_custom_button',
                'dependent_condation' => 'yes image both color',
            ),
            array(
                'id' => 'wb_custom_button_bg_color',
                'title' => 'Custom Button Background Color',
                'type' => 'color',
                'class' => 'form-control',
                'std' => '#ffffff',
                'desc' => '<p>
                                This option lets you set the background color of your Custom  Button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Custom  Button” is set to “Yes”.</li>
                                <li>“Custom  Button Background Option” is set to “Color” or “Both”.</li>
                            </ul>',
                'change_property' => 'background-color',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_custom_button',
                'dependent_from' => 'show_custom_button wb_custom_button_bg_option',
                'dependent_condation' => 'yes color both',
            ),
            array(
                'id' => 'wb_custom_button_bg_image',
                'title' => 'Custom Button Background Image',
                'type' => 'file',
                'class' => 'form-control wb_custom_button',
                'std' => '#',
                'desc' => '<p>
                                This option lets you upload/choose the image for the background of Custom  Button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Custom  Button” is set to “Yes”.</li>
                                <li>“Custom  Button Background Option” is set to “Image” or “Both”.</li>
                            </ul>',
                'change_property' => 'background-image',
                'change_property_id' => '.wb_custom_button',
                'dependent_from' => 'show_custom_button wb_custom_button_bg_option',
                'dependent_condation' => 'yes image both',
            ),
            array(
                'id' => 'wb_custom_button_bg_image_repeat',
                'title' => 'Custom Button Background Image Repeat',
                'type' => 'radio',
                'class' => 'wb_custom_button_bg_image_repeat',
                'std' => 'repeat',
                'desc' => '<p>
                                This option lets you set the repetition behaviour of the background image for Custom  Button.
                            </p>
                            <ul>
                                <li><strong>Repeat-x</strong>: To repeat the image horizontally.</li>
                                <li><strong>Repeat-y</strong>: To repeat the image vertically.</li>
                                <li><strong>Both</strong>: To repeat the image both horizontally and vertically.</li>
                                <li><strong>No-Repeat</strong>: To disable the repeat option and showing the single image.</li>
                            </ul>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Custom  Button” is set to “Yes”.</li>
                                <li>“Custom  Button Background Option” is set to “Image” or “Both”.</li>
                            </ul>',
                'choices' => array(
                    'repeat-x' => 'Repeat-x',
                    'repeat-y' => 'Repeat-y',
                    'repeat' => 'Both',
                    'no-repeat' => 'No-Repeat',
                ),
                'change_property' => 'background-repeat',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_custom_button',
                'dependent_from' => 'show_custom_button wb_custom_button_bg_option',
                'dependent_condation' => 'yes image both',
            ),
            array(
                'id' => 'wb_custom_button_bg_image_position',
                'title' => 'Custom Button Background Image Position',
                'type' => 'image_position',
                'class' => 'wb_custom_button_bg_image_position',
                'std' => '1',
                'desc' => '<p>
                                This option lets you set the position of the background image both vertically and horizontally. 
                            </p>
                            <ul>
                                <li><strong>Arrow Left</strong>: To move the image to the left hand side.</li>
                                <li><strong>Arrow Up</strong>: To move the image upwards.</li>
                                <li><strong>Arrow Right</strong>: To move the image to the right hand side.</li>
                                <li><strong>Arrow Down</strong>: To move the image downwards.</li>
                                <li><strong>Reset</strong>: To reset the image position to the default settings.</li>
                            </ul>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Custom  Button” is set to “Yes”.</li>
                                <li>“Custom  Button Background Option” is set to “Image” or “Both”.</li>
                            </ul>',
                'change_property' => 'background-position',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_custom_button',
                'dependent_from' => 'show_custom_button wb_custom_button_bg_option',
                'dependent_condation' => 'yes image both',
            ),
            array(
                'id' => 'wb_custom_button_text_color',
                'title' => 'Custom Button Text Color',
                'type' => 'color',
                'class' => 'form-control',
                'std' => '#000000',
                'desc' => '<p>
                                This option lets you set the text color of the “Custom” button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Custom  Button” is set to “Yes”.</li>
                            </ul>',
                'change_property' => 'color',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_custom_button',
                'dependent_from' => 'show_custom_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_custom_button_text_size',
                'title' => 'Custom Button Font Size',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'std' => '14',
                'desc' => '<p>
                                This option lets you set the font size of the “Custom” button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Custom  Button” is set to “Yes”.</li>
                            </ul>',
                'help' => 'px',
                'change_property' => 'font-size',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_custom_button',
                'dependent_from' => 'show_custom_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'custom_button_font',
                'title' => 'Custom Button Font',
                'type' => 'select',
                'class' => 'form-control',
                'choices' => $wb_font_url,
                'std' => 'ABeeZee',
                'desc' => '<p>
                                This option lets you set the font of the text of “Custom” button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Custom  Button” is set to “Yes”.</li>
                            </ul>',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'show_custom_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_custom_button_border_width',
                'title' => 'Custom Button Border Width',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'std' => '1',
                'desc' => '<p>
                                This option lets you set the border width of the “Custom” button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Custom  Button” is set to “Yes”.</li>
                            </ul>',
                'help' => 'px',
                'change_property' => 'border-width',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_custom_button',
                'dependent_from' => 'show_custom_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_custom_button_border_color',
                'title' => 'Custom Button Border Color',
                'type' => 'color',
                'class' => 'form-control',
                'std' => '#000000',
                'desc' => '<p>
                                This option lets you set the border color of the “Custom” button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Custom  Button” is set to “Yes”.</li>
                            </ul>',
                'change_property' => 'border-color',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_custom_button',
                'dependent_from' => 'show_custom_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_custom_button_border_radius',
                'title' => 'Custom Button Border Radius',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'std' => '1',
                'desc' => '<p>
                                This option lets you set the border radius of the “Custom” button.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Custom  Button” is set to “Yes”.</li>
                            </ul>',
                'help' => 'px',
                'change_property' => 'border-radius',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_custom_button',
                'dependent_from' => 'show_custom_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_custom_button_border_style',
                'title' => 'Custom Button border Style',
                'type' => 'select',
                'class' => 'form-control',
                'std' => 'solid',
                'desc' => '<p>
                                This option lets you choose the Custom  button border style. 
                            </p>
                            <ul>
                                <li><strong>Solid</strong>: To use plain solid line border.</li>
                                <li><strong>Dotted</strong>: To use dotted line border.</li>
                                <li><strong>Dashed</strong>: To use dashed line border.</li>
                                <li><strong>Double</strong>: To use double plain solid line border. To use this option, you will need to increase the “Custom  Button Border Width” to at least 3px.</li>
                            </ul>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Custom  Button” is set to “Yes”.</li>
                            </ul>',
                'choices' => array(
                    'solid' => 'Solid',
                    'dotted' => 'Dotted',
                    'dashed' => 'Dashed',
                    'double' => 'Double'
                ),
                'change_property' => 'border-style',
                'change_property_id' => '.wb_cart_total_wrapper .buttons .wb_custom_button',
                'dependent_from' => 'show_custom_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_custom_button_hover_border_color',
                'title' => 'Custom Button Mouse Over Border Color',
                'type' => 'color',
                'class' => 'form-control',
                'std' => '#cccccc',
                'desc' => '<p>
                                This option lets you set the border color of the “Custom” button when mouse pointer is brought over it.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Custom  Button” is set to “Yes”.</li>
                            </ul>',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'show_custom_button',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_custom_button_hover_bg_option',
                'title' => 'Custom Button Mouse Over Background Option',
                'type' => 'select',
                'class' => 'form-control',
                'std' => 'color',
                'desc' => '<p>
                                This option lets you setup the background of Custom  Button on mouse over. 
                            </p>
                            <p>
                                Following are the ways to set up the background: 
                            </p>
                            <ul>
                                <li><strong>Image: </strong>Using this option, you can use image as your background.</li>
                                <li><strong>Color: </strong>Using this option, you can use color as your background.</li>
                                <li><strong>Both: </strong>Using this option, you can use both image and color as your background.</li>
                                <li><strong>None: </strong>If you don’t want to use any background, choose this option.</li>
                            </ul>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Custom  Button” is set to “Yes”.</li>
                            </ul>',
                'choices' => array(
                    'image' => 'Image',
                    'color' => 'Color',
                    'both' => 'Both',
                    'no' => 'None',
                ),
                'has_dependent' => 'yes',
                'dependent_id' => 'wb_custom_button_hover_bg_option',
                'dependent_from' => 'show_custom_button',
                'dependent_condation' => 'yes image both color',
            ),
            array(
                'id' => 'wb_custom_button_hover_bg_color',
                'title' => 'Custom Button Mouse Over Background Color',
                'type' => 'color',
                'class' => 'form-control',
                'std' => '#cccccc',
                'desc' => '<p>

                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Custom  Button” is set to “Yes”.</li>
                                <li>“Custom  Button Background Option” is set to “Color” or “Both”.</li>
                            </ul>',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'show_custom_button wb_custom_button_hover_bg_option',
                'dependent_condation' => 'yes both color',
            ),
            array(
                'id' => 'wb_custom_button_hover_bg_image',
                'title' => 'Custom Button Background Image',
                'type' => 'file',
                'class' => 'form-control',
                'std' => '#',
                'desc' => '<p>
                                This option lets you upload/choose the image for the background of Custom  Button on mouse over.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Custom  Button” is set to “Yes”.</li>
                                <li>“Custom  Button Background Option” is set to “Image” or “Both”.</li>
                            </ul>',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'show_custom_button wb_custom_button_hover_bg_option',
                'dependent_condation' => 'yes image both',
            ),
            array(
                'id' => 'wb_custom_button_hover_bg_image_repeat',
                'title' => 'Custom Button Background Image Repeat',
                'type' => 'radio',
                'class' => 'wb_custom_button_hover_bg_image_repeat',
                'std' => 'repeat',
                'desc' => '<p>
                                This option lets you set the repetition behaviour of the background image for Custom  Button on mouse over.
                            </p>
                            <ul>
                                <li><strong>Repeat-x</strong>: To repeat the image horizontally.</li>
                                <li><strong>Repeat-y</strong>: To repeat the image vertically.</li>
                                <li><strong>Both</strong>: To repeat the image both horizontally and vertically.</li>
                                <li><strong>No-Repeat</strong>: To disable the repeat option and showing the single image.</li>
                            </ul>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Custom  Button” is set to “Yes”.</li>
                                <li>“Custom  Button Background Option” is set to “Image” or “Both”.</li>
                            </ul>',
                'choices' => array(
                    'repeat-x' => 'Repeat-x',
                    'repeat-y' => 'Repeat-y',
                    'repeat' => 'Both',
                    'no-repeat' => 'No-Repeat',
                ),
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'show_custom_button wb_custom_button_hover_bg_option',
                'dependent_condation' => 'yes image both',
            ),
            array(
                'id' => 'wb_custom_button_hover_bg_image_position',
                'title' => 'Custom Button Mouse Over Background Image Position',
                'type' => 'image_position',
                'class' => 'wb_custom_button_hover_bg_image_position',
                'std' => '1',
                'desc' => '<p>
                                This option lets you set the position of the background image on mouse over both vertically and horizontally. 
                            </p>
                            <ul>
                                <li><strong>Arrow Left</strong>: To move the image to the left hand side.</li>
                                <li><strong>Arrow Up</strong>: To move the image upwards.</li>
                                <li><strong>Arrow Right</strong>: To move the image to the right hand side.</li>
                                <li><strong>Arrow Down</strong>: To move the image downwards.</li>
                                <li><strong>Reset</strong>: To reset the image position to the default settings.</li>
                            </ul>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Custom  Button” is set to “Yes”.</li>
                                <li>“Custom  Button Background Option” is set to “Image” or “Both”.</li>
                            </ul>',
                'dependent_from' => 'show_custom_button wb_custom_button_hover_bg_option',
                'dependent_condation' => 'yes image both',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
            ),
            array(
                'id' => 'wb_custom_button_hover_text_color',
                'title' => 'Custom Button Mouse Over Text Color',
                'type' => 'color',
                'class' => 'form-control',
                'std' => '#000000',
                'desc' => ' <p>
                                This option lets you set the text color of the “Custom” button when mouse pointer is brought over it.
                            </p>
                            <p>Note that this option only works if:</p>
                            <ul>
                                <li>“Show Custom Button” is set to “Yes”.</li>
                            </ul>',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'show_custom_button',
                'dependent_condation' => 'yes',
            ),
        )
    );
    $wb_setting[] = array(
        'section_id' => 'wb_menu_empty_cart',
        'section_title' => ' Empty Cart Settings',
        'section_order' => 60,
        'section_description' => '<div class="wb_section_description wb_red wb_bold">"Sorry this feature is only available in our '
        . 'premium version, it just costs $18! <a href="http://codecanyon.net/item/woobag-customize-your-cart-easily/12908527?ref=gatelogix">Click here</a> to get it from CodeCanyon"</div>',
        'fields' => array(
            array(
                'id' => 'wb_empty_cart_hidden_field',
                'title' => 'Premium Features',
                'type' => 'hidden',
                'class' => 'form-control',
            ),
        )
    );
    $wb_setting[] = array(
        'section_id' => 'footer_setting',
        'section_title' => 'Footer Area',
        'section_description' => '<div class="wb_section_description">
            This is the bottom section of the WooBag Popup. You have full control to set the custom text, color,
                                font and background for this area. You can put an effective punch line here to increase your 
                                store’s conversions. For example showing footer text: “Free Shipping and Returns”.</div>',
        'section_order' => 70,
        'fields' => array(
            array(
                'id' => 'wb_show_footer',
                'title' => 'Show Footer Area',
                'type' => 'radio',
                'class' => 'wb_show_footer',
                'std' => 'yes',
                'desc' => '<p>
                                This option lets you show/hide the footer area.
                            </p>
                            <ul>
                                <li><strong>Yes</strong>: To show the footer area.</li>
                                <li><strong>No</strong>: To hide the footer area.</li>
                            </ul>',
                'choices' => array(
                    'yes' => 'Yes',
                    'no' => 'No'
                ),
                'has_dependent' => 'yes',
                'dependent_id' => 'wb_show_footer',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_footer_height',
                'title' => 'Footer Height',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'std' => '32',
                'desc' => '<p>
                                This option lets you set the height of the Footer section. 
                            </p>
                            <p>Note that this option doesn’t work, if:</p>
                            <ul>
                                <li>“Show Footer Area” is set to “Yes”.</li>
                            </ul>',
                'help' => 'px',
                'change_property' => 'height',
                'change_property_id' => '.wb_window_bottom',
                'dependent_from' => 'wb_show_footer',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'footer_text',
                'title' => 'Footer Text',
                'type' => 'text', 'class' => 'form-control',
                'std' => 'FREE SHIPPING & RETURNS',
                'desc' => '<p>
                                This option lets you set the text of your own choice to show in the footer area.
                            </p>
                            <p>Note that this option doesn’t work, if:</p>
                            <ul>
                                <li>“Show Footer Area” is set to “Yes”.</li>
                            </ul>',
                'change_property' => 'text',
                'change_property_id' => '.wb_window_bottom .wb_bottom_text',
                'dependent_from' => 'wb_show_footer',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'footer_text_position',
                'title' => 'Footer Text Position',
                'type' => 'radio',
                'class' => 'footer_text_position',
                'std' => 'center',
                'desc' => '<p>
                                This option lets you set the horizontal position of the text shown in the footer area.
                            </p>
                            <p>Note that this option doesn’t work, if:</p>
                            <ul>
                                <li>“Show Footer Area” is set to “Yes”.</li>
                            </ul>',
                'choices' => array(
                    'left' => 'Left',
                    'center' => 'Center',
                    'right' => 'Right',
                ),
                'change_property' => 'text-align',
                'change_property_id' => '.wb_window_bottom .wb_bottom_text',
                'dependent_from' => 'wb_show_footer',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'footer_text_vertical_position',
                'title' => 'Footer Text Vertical Position',
                'type' => 'radio',
                'class' => 'footer_text_vertical_position',
                'std' => 'middle',
                'desc' => '<p>
                                This option lets you set the vertical position of the text shown in the footer area.
                            </p>
                            <p>Note that this option doesn’t work, if:</p>
                            <ul>
                                <li>“Show Footer Area” is set to “Yes”.</li>
                            </ul>',
                'choices' => array(
                    'top' => 'Top',
                    'middle' => 'Middle',
                    'bottom' => 'Bottom',
                ),
                'change_property' => 'vertical-align',
                'change_property_id' => '.wb_window_bottom',
                'dependent_from' => 'wb_show_footer',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_footer_bg_option',
                'title' => 'WooBag Footer Background Option',
                'type' => 'select',
                'class' => 'form-control',
                'std' => 'color',
                'desc' => '<p>
                                This option lets you setup the background of Footer section. 
                            </p>
                            <p>
                                Following are the ways to set up the background: 
                            </p>
                            <ul>
                                <li><strong>Image: </strong>Using this option, you can use image as your background.</li>
                                <li><strong>Color: </strong>Using this option, you can use color as your background.</li>
                                <li><strong>Both: </strong>Using this option, you can use both image and color as your background.</li>
                                <li><strong>None: </strong>If you don’t want to use any background, choose this option.</li>
                            </ul>
                            <p>Note that this option doesn’t work, if:</p>
                            <ul>
                                <li>“Show Footer Area” is set to “Yes”.</li>
                            </ul>',
                'choices' => array(
                    'image' => 'Image',
                    'color' => 'Color',
                    'both' => 'Both',
                    'no' => 'None',
                ),
                'has_dependent' => 'yes',
                'dependent_id' => 'wb_footer_bg_option',
                'dependent_from' => 'wb_show_footer',
                'dependent_condation' => 'yes image color both',
            ),
            array(
                'id' => 'wb_footer_bg_color',
                'title' => 'WooBag Footer Background Color',
                'type' => 'color',
                'std' => '#ffffff',
                'desc' => '<p>
                                This option lets you set the background color of your Footer section.
                            </p>
                            <p>Note that this option doesn’t work, if:</p>
                            <ul>
                                <li>“Show Footer Area” is set to “Yes”.</li>
                                <li>“Footer Background Option” is set to “Color” or “Both”.</li>
                            </ul>',
                'change_property' => 'background-color',
                'change_property_id' => '.wb_window_bottom',
                'dependent_from' => 'wb_show_footer wb_footer_bg_option',
                'dependent_condation' => 'yes color both',
            ),
            array(
                'id' => 'wb_footer_bg_image',
                'title' => 'WooBag Footer Background Image',
                'type' => 'file',
                'class' => 'form-control wb_window_bottom',
                'std' => '#',
                'desc' => '<p>
                                This option lets you upload/choose the image for the background of Footer section.
                            </p>
                            <p>Note that this option doesn’t work, if:</p>
                            <ul>
                                <li>“Show Footer Area” is set to “Yes”.</li>
                                <li>“Footer Background Option” is set to “Image” or “Both”.</li>
                            </ul>',
                'change_property' => 'background-image',
                'change_property_id' => '.wb_window_bottom',
                'dependent_from' => 'wb_show_footer wb_footer_bg_option',
                'dependent_condation' => 'yes image both',
            ),
            array(
                'id' => 'wb_footer_bg_image_repeat',
                'title' => 'WooBag Footer Background Image Repeat',
                'type' => 'radio',
                'class' => 'wb_footer_bg_image_repeat',
                'std' => 'repeat',
                'desc' => '<p>
                                This option lets you set the repetition behaviour of the background image for Footer section.
                            </p>
                            <ul>
                                <li><strong>Repeat-x</strong>: To repeat the image horizontally.</li>
                                <li><strong>Repeat-y</strong>: To repeat the image vertically.</li>
                                <li><strong>Both</strong>: To repeat the image both horizontally and vertically.</li>
                                <li><strong>No-Repeat</strong>: To disable the repeat option and showing the single image.</li>
                            </ul>
                            <p>Note that this option doesn’t work, if:</p>
                            <ul>
                                <li>“Show Footer Area” is set to “Yes”.</li>
                                <li>“Footer Background Option” is set to “Image” or “Both”.</li>
                            </ul>',
                'choices' => array(
                    'repeat-x' => 'Repeat-x',
                    'repeat-y' => 'Repeat-y',
                    'repeat' => 'Both',
                    'no-repeat' => 'No-Repeat',
                ),
                'change_property' => 'background-repeat',
                'change_property_id' => '.wb_window_bottom',
                'dependent_from' => 'wb_show_footer wb_footer_bg_option',
                'dependent_condation' => 'yes image both',
            ),
            array(
                'id' => 'wb_footer_bg_image_position',
                'title' => 'WooBag Footer Background Image Position',
                'type' => 'image_position',
                'class' => 'wb_footer_bg_image_position',
                'std' => '1',
                'desc' => '<p>
                                This option lets you set the position of the background image both vertically and horizontally. 
                            </p>
                            <ul>
                                <li><strong>Arrow Left</strong>: To move the image to the left hand side.</li>
                                <li><strong>Arrow Up</strong>: To move the image upwards.</li>
                                <li><strong>Arrow Right</strong>: To move the image to the right hand side.</li>
                                <li><strong>Arrow Down</strong>: To move the image downwards.</li>
                                <li><strong>Reset</strong>: To reset the image position to the default settings.</li>
                            </ul>
                            <p>Note that this option doesn’t work, if:</p>
                            <ul>
                                <li>“Show Footer Area” is set to “Yes”.</li>
                                <li>“Footer Background Option” is set to “Image” or “Both”.</li>
                            </ul>',
                'change_property' => 'background-position',
                'change_property_id' => '.wb_window_bottom',
                'dependent_from' => 'wb_show_footer wb_footer_bg_option',
                'dependent_condation' => 'yes image both',
            ),
            array(
                'id' => 'wb_footer_text_color',
                'title' => 'WooBag Footer Text Color',
                'type' => 'color',
                'std' => '#404040',
                'desc' => '<p>
                                This option lets you set the Color of your custom text shown in the footer area.
                            </p>

                            <p>Note that this option doesn’t work, if:</p>
                            <ul>
                                <li>“Show Footer Area” is set to “Yes”.</li>
                            </ul>',
                'change_property' => 'color',
                'change_property_id' => '.wb_window_bottom .wb_bottom_text',
                'dependent_from' => 'wb_show_footer',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_footer_text_size',
                'title' => 'WooBag Footer Font Size',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'std' => '16',
                'desc' => '<p>
                                This option lets you set the Font size of your custom text shown in the footer area.
                            </p>

                            <p>Note that this option doesn’t work, if:</p>
                            <ul>
                                <li>“Show Footer Area” is set to “Yes”.</li>
                            </ul>',
                'help' => 'px',
                'change_property' => 'font-size',
                'change_property_id' => '.wb_window_bottom .wb_bottom_text',
                'dependent_from' => 'wb_show_footer',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'footer_font',
                'title' => 'Footer Font',
                'type' => 'select',
                'class' => 'form-control',
                'choices' => $wb_font_url,
                'std' => 'ABeeZee',
                'desc' => '<p>
                                This option lets you set the Font of your custom text shown in the footer area.
                            </p>

                            <p>Note that this option doesn’t work, if:</p>
                            <ul>
                                <li>“Show Footer Area” is set to “Yes”.</li>
                            </ul>',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'wb_show_footer',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_footer_border_top',
                'title' => 'Show Footer Top Separator',
                'type' => 'radio',
                'class' => 'wb_footer_border_top',
                'std' => 'yes',
                'desc' => '<p>
                                This option lets you show/hide the top separator the Footer area. 
                            </p>
                            <ul>
                                <li><strong>Yes</strong>: To show the Footer separator.</li>
                                <li><strong>No</strong>: To hide the Footer separator.</li>
                            </ul>
                            <p>Note that this option doesn’t work, if:</p>
                            <ul>
                                <li>“Show Footer Area” is set to “Yes”.</li>
                            </ul>',
                'choices' => array(
                    'yes' => 'Yes',
                    'no' => 'No'
                ),
                'has_dependent' => 'yes',
                'dependent_id' => 'wb_footer_border_top',
                'dependent_from' => 'wb_show_footer',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_footer_border_option',
                'title' => 'Footer Separator Style',
                'type' => 'select',
                'class' => 'form-control',
                'std' => 'solid',
                'desc' => '<p>
                                This option lets you choose the Footer separator style. 
                            </p>
                            <ul>
                                <li>Solid: To use plain solid line separator.</li>
                                <li>Dotted: To use dotted line separator.</li>
                                <li>Dashed: To use dashed line separator.</li>
                                <li>Double: To use double plain solid line separator. To use this option, you will need to increase the “Subtotal Separator width” to at least 3px.</li>
                            </ul>
                            <p>Note that this option doesn’t work, if:</p>
                            <ul>
                                <li>“Show Footer Area” is set to “Yes”.</li>
                                <li>“Show Footer Top Separator” is set to “Yes”.</li>
                            </ul>',
                'choices' => array(
                    'solid' => 'Solid',
                    'dotted' => 'Dotted',
                    'dashed' => 'Dashed',
                    'double' => 'Double'
                ),
                'change_property' => 'border-top-style',
                'change_property_id' => '.wb_window_bottom',
                'dependent_from' => 'wb_show_footer wb_footer_border_top',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_footer_border_width',
                'title' => 'Footer Separator width',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'desc' => '<p>
                                This option lets you set custom width of the Footer separator. 
                            </p>
                            <p>Note that this option doesn’t work, if:</p>
                            <ul>
                                <li>“Show Footer Area” is set to “Yes”.</li>
                                <li>“Show Footer Top Separator” is set to “Yes”.</li>
                            </ul>',
                'std' => '1',
                'help' => 'px',
                'change_property' => 'border-top-width',
                'change_property_id' => '.wb_window_bottom',
                'dependent_from' => 'wb_show_footer wb_footer_border_top',
                'dependent_condation' => 'yes',
            ),
            array(
                'id' => 'wb_footer_seprator_color',
                'title' => 'Footer Separator color',
                'type' => 'color',
                'class' => 'form-control wb_border_color',
                'std' => '#a8a8a8',
                'desc' => '<p>
                                This option lets you set Color of the Footer separator.
                            </p>

                            <p>Note that this option doesn’t work, if:</p>
                            <ul>
                                <li>“Show Footer Area” is set to “Yes”.</li>
                                <li>“Show Footer Top Separator” is set to “Yes”.</li>
                            </ul>',
                'change_property' => 'border-top-color',
                'change_property_id' => '.wb_window_bottom',
                'dependent_from' => 'wb_show_footer wb_footer_border_top',
                'dependent_condation' => 'yes',
            ),
        )
    );
    $wb_setting[] = array(
        'section_id' => 'scroll_setting',
        'section_title' => 'Scroll Settings',
        'section_description' => '<div class="wb_section_description">
                This amazing feature lets you decide how you want to set cart items scrolling of 
                your WooBag. You can set the scrolling type and also how the scrolling behaves. </div>',
        'section_order' => 80,
        'fields' => array(
            array(
                'id' => 'wb_scroll_option',
                'title' => ' Scroll Type',
                'type' => 'select',
                'class' => 'form-control',
                'std' => 'wheel',
                'desc' => '<p>
                                This amazing feature lets you decide how you want to set cart items scrolling of your WooBag. You can set the scrolling type and also how the scrolling behaves. 
                            </p>
                            <ul>
                                <li><strong>Button Scroll</strong>: Lets you show the buttons to scroll the cart items up or down.</li>
                                <li><strong>Mouse Wheel Scroll</strong>: Enables the default scrolling feature using mouse or scroll wheel.</li>
                            </ul>',
                'choices' => array(
                    'button' => 'Button Scroll',
                    'wheel' => 'Mouse wheel Scroll'
                ),
                'has_dependent' => 'yes',
                'dependent_id' => 'wb_scroll_option',
                'dependent_condation' => 'button wheel',
            ),
            array(
                'id' => 'wb_scroll_wheel_color',
                'title' => 'Scroll Bar Color',
                'type' => 'color',
                'class' => 'form-control',
                'std' => '#cccccc',
                'desc' => '<p>
                                This option lets you set the color of the scroll bar on the right hand side.
                            </p>
                            <p>
                                Note that this option only works if:
                            </p>
                            <ul>
                                <li>“Scroll Type” is set to “Mouse wheel Scroll”.</li>
                            </ul>',
                'change_property' => 'background-color',
                'change_property_id' => '.mCS-minimal-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar',
                'dependent_from' => 'wb_scroll_option',
                'dependent_condation' => 'wheel',
            ),
            array(
                'id' => 'wb_onclick_scroll_option',
                'title' => 'Scroll Behaviour',
                'type' => 'select',
                'class' => 'form-control',
                'std' => 'mouseover_scroll',
                'desc' => '<p>
                                This option lets you set the action with which the scrolling takes place. 
                            </p>
                            <ul>
                                <li><strong>Mouseover Scroll</strong>: To scroll up/down when user brings mouse over the scroll buttons.</li>
                                <li><strong>Mouseclick Micro Scroll</strong>: To scroll a little up/down when user clicks on the scroll buttons.</li>
                                <li><strong>Mouseclick Mini Scroll</strong>: To scroll up/down slightly more than the Micro scroll when user clicks on the scroll buttons.</li>
                                <li><strong>Mouseclick Item to Item Scroll</strong>: To scroll a directly to the next item in the cart when user clicks on the scroll buttons.</li>
                            </ul>
                            <p>
                                Note that this option only works if:
                            </p>
                            <ul>
                                <li>“Scroll Type” is set to “Button Scroll”.</li>
                            </ul>',
                'choices' => array(
                    'mouseover_scroll' => 'Mouseover Scroll',
                    'scroll_onkeypress' => 'Mouseclick Micro scroll',
                    'scroll_slowly' => 'Mouseclick Mini Scroll',
                    'scroll_to_next_product' => 'Mouseclick Item to Item Scroll'
                ),
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'wb_scroll_option',
                'dependent_condation' => 'button',
            ),
            array(
                'id' => 'wb_scroll_padding_left_right',
                'title' => 'Scroll Button Sideways',
                'type' => 'number',
                'min' => '0',
                'class' => 'form-control',
                'std' => '8',
                'desc' => '<p>
                                This feature lets you adjust the position from both side (Right and Left) by using the padding feature.
                            </p>
                            <p>
                                Note that this option only works if:
                            </p>
                            <ul>
                                <li>“Scroll Type” is set to “Button Scroll”.</li>
                            </ul>',
                'help' => 'px',
                'dependent_from' => 'wb_scroll_option',
                'dependent_condation' => 'button',
            ),
            array(
                'id' => 'wb_scroll_width',
                'title' => 'Scroll Button Width',
                'type' => 'number',
                'max' => '100',
                'min' => '0',
                'class' => 'form-control',
                'std' => '100',
                'desc' => '<p>
                                This option lets you set the width percentage of your scroll buttons. 
                            </p>
                            <p>
                                Note that this option only works if:
                            </p>
                            <ul>
                                <li>“Scroll Type” is set to “Button Scroll”.</li>
                            </ul>',
                'help' => '%',
                'change_property' => 'width',
                'change_property_id' => '.wb_scroll_button_wrapper .wb_scroll_button',
                'dependent_from' => 'wb_scroll_option',
                'dependent_condation' => 'button',
            ),
            array(
                'id' => 'wb_scroll_position',
                'title' => 'Scroll Button Position',
                'type' => 'radio',
                'class' => 'wb_scroll_position',
                'std' => 'center',
                'desc' => '<p>
                                This option lets you set the horizontal position of your scroll buttons settings. 
                            </p>
                            <p>
                                Note that this option only works if:
                            </p>
                            <ul>
                                <li>“Scroll Type” is set to “Button Scroll”.</li>
                            </ul>',
                'choices' => array(
                    'left' => 'Left',
                    'center' => 'Center',
                    'right' => 'Right',
                ),
                'change_property' => 'text-align',
                'change_property_id' => '.wb_scroll_button_wrapper',
                'dependent_from' => 'wb_scroll_option',
                'dependent_condation' => 'button',
            ),
            array(
                'id' => 'wb_scroll_bg_option',
                'title' => 'Scroll Button Background Option',
                'type' => 'select',
                'class' => 'form-control',
                'std' => 'color',
                'desc' => '<p>
                                This option lets you setup the background of scroll buttons. 
                            </p>
                            <p>
                                Following are the ways to set up the background: 
                            </p>
                            <ul>
                                <li><strong>Image: </strong>Using this option, you can use image as your background.</li>
                                <li><strong>Color: </strong>Using this option, you can use color as your background.</li>
                                <li><strong>Both: </strong>Using this option, you can use both image and color as your background.</li>
                                <li><strong>None: </strong>If you don’t want to use any background, choose this option.</li>
                            </ul>
                            <p>
                                Note that this option only works if:
                            </p>
                            <ul>
                                <li>“Scroll Type” is set to “Button Scroll”.</li>
                            </ul>',
                'choices' => array(
                    'image' => 'Image',
                    'color' => 'Color',
                    'both' => 'Both',
                    'no' => 'None',
                ),
                'has_dependent' => 'yes',
                'dependent_id' => 'wb_scroll_bg_option',
                'dependent_from' => 'wb_scroll_option',
                'dependent_condation' => 'button image color both',
            ),
            array(
                'id' => 'wb_scroll_bg_color',
                'title' => 'Scroll Button Background Color',
                'type' => 'color',
                'class' => 'form-control',
                'std' => '#CCCCCC',
                'desc' => '<p>
                                This option lets you set the background color of your scroll buttons.
                            </p>
                            <p>
                                Note that this option only works if:
                            </p>
                            <ul>
                                <li>“Scroll Type” is set to “Button Scroll”.</li>
                                <li>“Scroll Button Background Option” is set to “Color” or “Both”.</li>
                            </ul>',
                'change_property' => 'background-color',
                'change_property_id' => '.wb_scroll_button',
                'dependent_from' => 'wb_scroll_option wb_scroll_bg_option',
                'dependent_condation' => 'button color both',
            ),
            array(
                'id' => 'wb_scroll_bg_image',
                'title' => 'Scroll Button Background Image',
                'type' => 'file',
                'class' => 'form-control wb_scroll_button',
                'std' => '#',
                'desc' => '<p>
                                This option lets you upload/choose the image for the background of scroll buttons.
                            </p>
                            <p>
                                Note that this option only works if:
                            </p>
                            <ul>
                                <li>“Scroll Type” is set to “Button Scroll”.</li>
                                <li>“Scroll Button Background Option” is set to “Image” or “Both”.</li>
                            </ul>',
                'change_property' => 'background-image',
                'change_property_id' => '.wb_scroll_button',
                'dependent_from' => 'wb_scroll_option wb_scroll_bg_option',
                'dependent_condation' => 'button image both',
            ),
            array(
                'id' => 'wb_scroll_bg_image_repeat',
                'title' => 'Scroll Button Background Image Repeat',
                'type' => 'radio',
                'class' => 'wb_scroll_bg_image_repeat',
                'std' => 'repeat',
                'desc' => '<p>
                                This option lets you set the repetition behaviour of the background image for scroll buttons.
                            </p>
                            <ul>
                                <li><strong>Repeat-x</strong>: To repeat the image horizontally.</li>
                                <li><strong>Repeat-y</strong>: To repeat the image vertically.</li>
                                <li><strong>Both</strong>: To repeat the image both horizontally and vertically.</li>
                                <li><strong>No-Repeat</strong>: To disable the repeat option and showing the single image.</li>
                            </ul>
                            <p>
                                Note that this option only works if:
                            </p>
                            <ul>
                                <li>“Scroll Type” is set to “Button Scroll”.</li>
                                <li>“Scroll Button Background Option” is set to “Image” or “Both”.</li>
                            </ul>',
                'choices' => array(
                    'repeat-x' => 'Repeat-x',
                    'repeat-y' => 'Repeat-y',
                    'repeat' => 'Both',
                    'no-repeat' => 'No-Repeat',
                ),
                'change_property' => 'background-repeat',
                'change_property_id' => '.wb_scroll_button',
                'dependent_from' => 'wb_scroll_option wb_scroll_bg_option',
                'dependent_condation' => 'button image both',
            ),
            array(
                'id' => 'wb_scroll_bg_image_position',
                'title' => 'Scroll Button Background Image Position',
                'type' => 'image_position',
                'class' => 'wb_scroll_bg_image_position',
                'std' => '1',
                'desc' => '<p>
                                This option lets you set the position of the background image both vertically and horizontally. 
                            </p>
                            <ul>
                                <li><strong>Arrow Left</strong>: To move the image to the left hand side.</li>
                                <li><strong>Arrow Up</strong>: To move the image upwards.</li>
                                <li><strong>Arrow Right</strong>: To move the image to the right hand side.</li>
                                <li><strong>Arrow Down</strong>: To move the image downwards.</li>
                                <li><strong>Reset</strong>: To reset the image position to the default settings.</li>
                            </ul>
                            <p>
                                Note that this option only works if:
                            </p>
                            <ul>
                                <li>“Scroll Type” is set to “Button Scroll”.</li>
                                <li>“Scroll Button Background Option” is set to “Image” or “Both”.</li>
                            </ul>',
                'change_property' => 'background-position',
                'change_property_id' => '.wb_scroll_button',
                'dependent_from' => 'wb_scroll_option wb_scroll_bg_option',
                'dependent_condation' => 'button image both',
            ),
            array(
                'id' => 'wb_scroll_arrow_color',
                'title' => 'Scroll Button Arrow Color',
                'type' => 'color',
                'class' => 'form-control',
                'std' => '#000000',
                'desc' => '<p>
                                This option lets you set the color of the arrows used in the scroll buttons.
                            </p>
                            <p>
                                Note that this option only works if:
                            </p>
                            <ul>
                                <li>“Scroll Type” is set to “Button Scroll”.</li>
                            </ul>',
                'change_property' => 'color',
                'change_property_id' => '.wb_scroll_button_wrapper .wb_scroll_button i',
                'dependent_from' => 'wb_scroll_option',
                'dependent_condation' => 'button',
            ),
            array(
                'id' => 'wb_scroll_hover_bg_option',
                'title' => 'Scroll Button Mouse Over Background Option',
                'type' => 'select',
                'class' => 'form-control',
                'std' => 'color',
                'desc' => '<p>
                                This option lets you setup the background of scroll buttons on mouse over. 
                            </p>
                            <ul>
                                <li><strong>Image: </strong>Using this option, you can use image as your background.</li>
                                <li><strong>Color: </strong>Using this option, you can use color as your background.</li>
                                <li><strong>Both: </strong>Using this option, you can use both image and color as your background.</li>
                                <li><strong>None: </strong>If you don’t want to use any background, choose this option.</li>
                            </ul>
                            <p>
                                Note that this option only works if:
                            </p>
                            <ul>
                                <li>“Scroll Type” is set to “Button Scroll”.</li>
                            </ul>',
                'choices' => array(
                    'image' => 'Image',
                    'color' => 'Color',
                    'both' => 'Both',
                    'no' => 'None',
                ),
                'has_dependent' => 'yes',
                'dependent_id' => 'wb_scroll_hover_bg_option',
                'dependent_from' => 'wb_scroll_option',
                'dependent_condation' => 'button image color both',
            ),
            array(
                'id' => 'wb_scroll_hover_bg_color',
                'title' => 'Scroll Button Mouse Over Background Color',
                'type' => 'color',
                'class' => 'form-control',
                'std' => '#CCCCCC',
                'desc' => '<p>
                                This option lets you set the background color of your scroll buttons on mouse over.
                            </p>
                            <p>
                                Note that this option only works if:
                            </p>
                            <ul>
                                <li>“Scroll Type” is set to “Button Scroll”.</li>
                                <li>“Scroll Button Background Option” is set to “Color” or “Both”.</li>
                            </ul>',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'wb_scroll_option wb_scroll_hover_bg_option',
                'dependent_condation' => 'button color both',
            ),
            array(
                'id' => 'wb_scroll_hover_bg_image',
                'title' => 'Scroll Button Mouse Over Background Image',
                'type' => 'file',
                'class' => 'form-control',
                'std' => '#',
                'desc' => '<p>
                                This option lets you upload/choose the image for the background of scroll buttons on mouse over.
                            </p>
                            <p>
                                Note that this option only works if:
                            </p>
                            <ul>
                                <li>“Scroll Type” is set to “Button Scroll”.</li>
                                <li>“Scroll Button Background Option” is set to “Image” or “Both”.</li>
                            </ul>',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'wb_scroll_option wb_scroll_hover_bg_option',
                'dependent_condation' => 'button image both',
            ),
            array(
                'id' => 'wb_scroll_hover_bg_image_repeat',
                'title' => 'Scroll Button Mouse Over Background Image Repeat',
                'type' => 'radio',
                'class' => 'wb_scroll_hover_bg_image_repeat',
                'std' => 'repeat',
                'desc' => '<p>
                                This option lets you set the repetition behaviour of the background image for scroll buttons on mouse over.
                            </p>
                             <ul>
                                <li><strong>Repeat-x</strong>: To repeat the image horizontally.</li>
                                <li><strong>Repeat-y</strong>: To repeat the image vertically.</li>
                                <li><strong>Both</strong>: To repeat the image both horizontally and vertically.</li>
                                <li><strong>No-Repeat</strong>: To disable the repeat option and showing the single image.</li>
                            </ul>
                            <p>
                                Note that this option only works if:
                            </p>
                            <ul>
                                <li>“Scroll Type” is set to “Button Scroll”.</li>
                                <li>“Scroll Button Background Option” is set to “Image” or “Both”.</li>
                            </ul>',
                'choices' => array(
                    'repeat-x' => 'Repeat-x',
                    'repeat-y' => 'Repeat-y',
                    'repeat' => 'Both',
                    'no-repeat' => 'No-Repeat',
                ),
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'wb_scroll_option wb_scroll_hover_bg_option',
                'dependent_condation' => 'button image both',
            ),
            array(
                'id' => 'wb_scroll_hover_bg_image_position',
                'title' => 'Scroll Button Mouse Over Background Image Position',
                'type' => 'image_position',
                'class' => 'wb_scroll_hover_bg_image_position',
                'std' => '1',
                'desc' => '<p>
                                This option lets you set the position of the background image both vertically and horizontally. 
                            </p>
                            <ul>
                                <li><strong>Arrow Left</strong>: To move the image to the left hand side.</li>
                                <li><strong>Arrow Up</strong>: To move the image upwards.</li>
                                <li><strong>Arrow Right</strong>: To move the image to the right hand side.</li>
                                <li><strong>Arrow Down</strong>: To move the image downwards.</li>
                                <li><strong>Reset</strong>: To reset the image position to the default settings.</li>
                            </ul>
                            <p>
                                Note that this option only works if:
                            </p>
                            <ul>
                                <li>“Scroll Type” is set to “Button Scroll”.</li>
                                <li>“Scroll Button Background Option” is set to “Image” or “Both”.</li>
                            </ul>',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'wb_scroll_option wb_scroll_hover_bg_option',
                'dependent_condation' => 'button image both',
            ),
            array(
                'id' => 'wb_scroll_arrow_hover_color',
                'title' => 'Scroll Button Mouse Over Arrow Color',
                'type' => 'color',
                'class' => 'form-control',
                'std' => '#000000',
                'desc' => '<p>
                                This option lets you set the mouse over color of the arrows used in the scroll buttons.
                            </p>
                            <p>
                                Note that this option only works if:
                            </p>
                            <ul>
                                <li>“Scroll Type” is set to “Button Scroll”.</li>
                            </ul>',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'dependent_from' => 'wb_scroll_option',
                'dependent_condation' => 'button',
            ),
        )
    );

    $wb_setting[] = array(
        'section_id' => 'smallscreen_setting',
        'section_title' => 'Small Screen Settings',
        'section_description' => '<div class="wb_section_description">This feature lets you control your cart display on small screens size i.e. Mobiles and Tablets.</div>',
        'section_order' => 110,
        'fields' => array(
            array(
                'id' => 'show_woobag_small_screen',
                'title' => 'Show WooBag on Small Screens',
                'type' => 'radio',
                'std' => 'no',
                'desc' => '<p>
                                This option lets you set whether you want to display the WooBag popup on small screens.
                            </p>
                            <ul>
                                <li><strong>Yes</strong>: To show only the icon in small screens.</li>
                                <li><strong>No</strong>: To show the full popup in small screens.</li>
                            </ul>',
                'choices' => array(
                    'yes' => 'Yes',
                    'no' => 'No'
                ),
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
                'has_dependent' => 'yes',
                'dependent_id' => 'show_woobag_small_screen',
                'dependent_condation' => 'yes',
            )
        )
    );

    $wb_setting[] = array(
        'section_id' => 'custom_setting',
        'section_title' => 'Custom CSS',
        'section_order' => 130,
        'fields' => array(
            array(
                'id' => 'wb_custom_css',
                'title' => 'Custom CSS',
                'type' => 'textarea',
                'class' => 'form-control',
                'std' => '/**Custom Style*/',
                'desc' => '<ul>
                                    <li>This section is for advanced users. A good understanding of CSS (Cascading Style Sheet) is the pre-requisite of this feature. This section lets you set your own custom styling which over-writes the current styling.</li>
                                    <li>You just have to write in your custom CSS and it will be overwritten by the current one thus your own styling will be used for the WooBag.</li>
                                    <li>Click here to see the WooBag’s CSS which is fully commented to help the advanced users easily understand it and make the modifications their choice.</li>
                                </ul>',
                'front_end' => '<a href="#" class="wb_front_preview_template">Save</a> to Preview this Change',
            )
        )
    );

    return $wb_setting;
}
