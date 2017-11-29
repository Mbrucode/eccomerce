<?php

if(!function_exists('horizontal_list_item_output')){
    
    function horizontal_list_item_output( $atts, $content = null){

        $atts =  extract(shortcode_atts( 
            array( 
            'horizontal_list_style'             => 'horizontal',
            'module_title' => '',
        ),$atts )) ;

        $output = '';
        $output .= '<div class="gg-horizontal-list">';
        $output .= '<p class="subtitle">'.$module_title.'</p>';
        $output .= '<dl class="'.$horizontal_list_style.'">';
        $output .= do_shortcode( $content );
        $output .= '</dl>';
        $output .= '</div>';

        return $output;
    }

    add_shortcode( 'horizontal_list_item' , 'horizontal_list_item_output' );
}

if(!function_exists('horizontal_list_inner_item_output')){
    
    function horizontal_list_inner_item_output($atts, $content = null){

        $output = $title = $description = $description_color = $description_color_style = $title_color_style = '';
         extract(shortcode_atts(array(
             'title'             => '',
             'description'       => '',
             'title_color'       => '',
             'description_color' => '',
         ), $atts));

         if ($title_color != '') {
          $title_color_style = 'style="color: '.$title_color.';"';
        }

        if ($description_color != '') {
          $description_color_style = 'style="color: '.$description_color.';"';
        }

       
        $output  .= "\n\t".'<dt '.$title_color_style.'>'.$title.'</dt>';
        $output  .= "\n\t".'<dd '.$description_color_style.'>'.$description.'</dd>';

        //The list
        return $output;
    }

    add_shortcode( 'horizontal_list_inner_item' , 'horizontal_list_inner_item_output' );
}

if ( function_exists( 'vc_map' ) ) {
// Parent container
vc_map( array(
    'name'                    => esc_html__( 'Horizontal List Item Container' , 'villenoir-shortcodes' ),
    'base'                    => 'horizontal_list_item',
    'icon'                    => 'icon-wpb-row',
    "icon"                    => "gg_vc_icon",
    "weight"                  => -50,
    'admin_enqueue_css'       => array(VILLENOIR_SHORTCODES_DIR . '/shortcodes/css/styles.css'),
    'description'             => esc_html__( 'Container for Item', 'villenoir-shortcodes' ),
    "category"                => esc_html__('Villenoir', 'villenoir-shortcodes'),
    'as_parent'               => array('only' => 'horizontal_list_inner_item'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    'content_element'         => true,
    'show_settings_on_create' => true,
    'params'                  => array(

                //BEGIN ADDING PARAMS
                array(
                      "type" => "dropdown",
                      "heading" => esc_html__("Horizontal list style", "villenoir-shortcodes"),
                      "param_name" => "horizontal_list_style",
                      "value" => array(
                        esc_html__("Horizontal", "villenoir-shortcodes") => "horizontal",
                        esc_html__("Vertical", "villenoir-shortcodes") => "vertical"
                        ),
                      "description" => esc_html__("Choose the style", "villenoir-shortcodes")
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Module Title","villenoir-shortcodes"),
                    "param_name" => "module_title",
                    "admin_label" => true,
                    "description" => esc_html__("Insert the title here","villenoir-shortcodes")
                ),
                //END ADDING PARAMS

    ),
    "js_view" => 'VcColumnView'
) );

// Nested Element
vc_map( array(
    'name'            => esc_html__('Horizontal List Item', 'villenoir-shortcodes'),
    'base'            => 'horizontal_list_inner_item',
    'description'     => esc_html__( 'Items "Item".', 'villenoir-shortcodes' ),
    'icon'            => 'icon-wpb-row',
    'content_element' => true,
    'as_child'        => array('only' => 'horizontal_list_item'), // Use only|except attributes to limit parent (separate multiple values with comma)
    'params'          => array(
                
                //BEGIN ADDING PARAMS
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Title","villenoir-shortcodes"),
                    "param_name" => "title",
                    "admin_label" => true,
                    "description" => esc_html__("Insert the title here","villenoir-shortcodes")
                ),
                array(
                    "type" => "colorpicker",
                    "heading" => esc_html__("Title color", "villenoir-shortcodes"),
                    "param_name" => "title_color"
                  ),
                array(
                    "type" => "textarea",
                    "heading" => esc_html__("Description","villenoir-shortcodes"),
                    "param_name" => "description",
                    "admin_label" => true,
                    "description" => esc_html__("Insert the description here","villenoir-shortcodes")
                ),
                array(
                    "type" => "colorpicker",
                    "heading" => esc_html__("Description color", "villenoir-shortcodes"),
                    "param_name" => "description_color"
                ),
                //END ADDING PARAMS
    ),
) );
}

// A must for container functionality, replace timeline_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer'))
{
    if ( ! class_exists( 'WPBakeryShortCode_Horizontal_List_Item' ) ) {
        class WPBakeryShortCode_Horizontal_List_Item extends WPBakeryShortCodesContainer {
        }
    }
}

// Replace horizontal_list_inner_item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode'))
{
    if ( ! class_exists( 'WPBakeryShortCode_Horizontal_List_Inner_Item' ) ) {
        class WPBakeryShortCode_Horizontal_List_Inner_Item extends WPBakeryShortCode {
        }
    }
}


?>