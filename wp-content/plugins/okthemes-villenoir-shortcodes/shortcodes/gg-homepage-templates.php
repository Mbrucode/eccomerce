<?php

add_filter( 'vc_load_default_templates', 'my_custom_template_modify_array' ); // Hook in
function my_custom_template_modify_array( $data ) {
    return array(); // This will remove all default templates. Basically you should use native PHP functions to modify existing array and then return it.
}

//Homepage v5
add_filter( 'vc_load_default_templates', 'villenoir_custom_template_homepage_v5' ); // Hook in
function villenoir_custom_template_homepage_v5( $data ) {
    $template               = array();
    $template['name']       = esc_html__( 'Homepage V5', 'villenoir-shortcodes' ); // Assign name for your custom template
    $template['image_path'] = preg_replace( '/\s/', '%20', get_template_directory_uri() . '/lib/visualcomposer/vc_custom_templates/template_homepage_v5.jpg'); // Always use preg replace to be sure that "space" will not break logic. Thumbnail should have this dimensions: 114x154px.
    $template['custom_class'] = 'custom_template_homepage_v5'; // CSS class name
    $template['content']    = <<<CONTENT
        [vc_row css=".vc_custom_1443177500143{padding-top: 0px !important;padding-bottom: 0px !important;}"][vc_column][infobox_item][infobox_inner_item title="Free worldwide shipping" subtitle="On orders of $50 or more"][infobox_inner_item title="One day delivery" subtitle="With Royal Mail Service"][infobox_inner_item title="30 Days returns" subtitle="You can return it later"][/infobox_item][/vc_column][/vc_row][vc_row css=".vc_custom_1443177804178{padding-top: 30px !important;}"][vc_column width="1/3"][featured_image featured_box_style="overlay" featured_box_text_align="center" image="" featured_title="Check our lookbook for inspiration"][/vc_column][vc_column width="1/3"][featured_image featured_box_style="overlay" featured_box_text_align="center" image="" featured_title="Follow us on instagram @villenoir-shortcodes"][/vc_column][vc_column width="1/3"][featured_image featured_box_style="overlay" featured_box_text_align="center" image="" featured_title="Discover our New collection"][/vc_column][/vc_row][vc_row css=".vc_custom_1443179183964{padding-top: 0px !important;padding-bottom: 0px !important;}"][vc_column][title_subtitle title_type="h4" font_transform="uppercase" title_special_style="line_over_text" title="Featured products"][featured_products per_page="2" columns="2" orderby="" order=""][/vc_column][/vc_row][vc_row css=".vc_custom_1443178939226{padding-top: 30px !important;padding-bottom: 30px !important;}"][vc_column][title_subtitle title_type="h4" font_transform="uppercase" title_special_style="line_over_text" title="Sale products"][sale_products per_page="2" columns="2" orderby="" order=""][/vc_column][/vc_row][vc_row css=".vc_custom_1443179230380{padding-top: 0px !important;padding-bottom: 0px !important;}"][vc_column][title_subtitle title_type="h4" font_transform="uppercase" title_special_style="line_over_text" title="Check our blog posts"][posts_grid grid_layout_mode="carousel" grid_layout_style="default_no_img" slides_per_view="2" carousel_nav="yes" posts_grid_no_posts="4"][/vc_column][/vc_row]
CONTENT;
 
    array_unshift( $data, $template );
    return $data;
}

//Homepage v4
add_filter( 'vc_load_default_templates', 'villenoir_custom_template_homepage_v4' ); // Hook in
function villenoir_custom_template_homepage_v4( $data ) {
    $template               = array();
    $template['name']       = esc_html__( 'Homepage V4', 'villenoir-shortcodes' ); // Assign name for your custom template
    $template['image_path'] = preg_replace( '/\s/', '%20', get_template_directory_uri() . '/lib/visualcomposer/vc_custom_templates/template_homepage_v4.jpg'); // Always use preg replace to be sure that "space" will not break logic. Thumbnail should have this dimensions: 114x154px.
    $template['custom_class'] = 'custom_template_homepage_v4'; // CSS class name
    $template['content']    = <<<CONTENT
        [vc_row css=".vc_custom_1443965547254{padding-top: 30px !important;padding-bottom: 30px !important;}"][vc_column][products_grid products_grid_title="Our best collection to date" products_grid_col_select="4" products_grid_no_posts="8" show_filter="yes" products_grid_pagination="yes" products_grid_terms=""][/vc_column][/vc_row]
CONTENT;
 
    array_unshift( $data, $template );
    return $data;
}

//Homepage v3
add_filter( 'vc_load_default_templates', 'villenoir_custom_template_homepage_v3' ); // Hook in
function villenoir_custom_template_homepage_v3( $data ) {
    $template               = array();
    $template['name']       = esc_html__( 'Homepage V3', 'villenoir-shortcodes' ); // Assign name for your custom template
    $template['image_path'] = preg_replace( '/\s/', '%20', get_template_directory_uri() . '/lib/visualcomposer/vc_custom_templates/template_homepage_v3.jpg'); // Always use preg replace to be sure that "space" will not break logic. Thumbnail should have this dimensions: 114x154px.
    $template['custom_class'] = 'custom_template_homepage_v3'; // CSS class name
    $template['content']    = <<<CONTENT
        [vc_row el_class="collections" css=".vc_custom_1443175265145{padding-top: 30px !important;padding-bottom: 0px !important;}"][vc_column width="2/4"][featured_image featured_box_style="overlay" featured_box_text_align="center" image="" img_size="customsize" featured_title="Women Fall-Winter 2015" featured_link="url:%23||" customsize_width="555" customsize_height="385"][/vc_column][vc_column width="1/4"][product id=""][/vc_column][vc_column width="1/4"][product id=""][/vc_column][/vc_row][vc_row el_class="collections" css=".vc_custom_1443175218610{padding-top: 0px !important;padding-bottom: 0px !important;}"][vc_column width="1/4"][product id=""][/vc_column][vc_column width="1/4"][product id=""][/vc_column][vc_column width="2/4"][featured_image featured_box_style="overlay" featured_box_text_align="center" image="" img_size="customsize" featured_title="Men Fall-Winter 2015" featured_link="url:%23||" customsize_width="555" customsize_height="385"][/vc_column][/vc_row][vc_row][vc_column][products columns="4" orderby="ID" order="" ids=""][/vc_column][/vc_row]
CONTENT;
 
    array_unshift( $data, $template );
    return $data;
}

//Homepage v2
add_filter( 'vc_load_default_templates', 'villenoir_custom_template_homepage_v2' ); // Hook in
function villenoir_custom_template_homepage_v2( $data ) {
    $template               = array();
    $template['name']       = esc_html__( 'Homepage V2', 'villenoir-shortcodes' ); // Assign name for your custom template
    $template['image_path'] = preg_replace( '/\s/', '%20', get_template_directory_uri() . '/lib/visualcomposer/vc_custom_templates/template_homepage_v2.jpg'); // Always use preg replace to be sure that "space" will not break logic. Thumbnail should have this dimensions: 114x154px.
    $template['custom_class'] = 'custom_template_homepage_v2'; // CSS class name
    $template['content']    = <<<CONTENT
        [vc_row css=".vc_custom_1443965354110{padding-top: 30px !important;}"][vc_column width="1/3"][product_categories orderby="" order="" columns="1" number="1" ids=""][/vc_column][vc_column width="1/3" css=".vc_custom_1443707365766{padding-top: 70px !important;}"][infobox_item infobox_style="vertical" infobox_border_style="fine-line"][infobox_inner_item title="Free worldwide shipping" subtitle="On orders of $50 or more" link="url:http%3A%2F%2Flocalhost%3A8888%2Fvillenoir-shortcodes%2Fabout%2F||"][infobox_inner_item title="One day delivery" subtitle="With Royal Mail Service" link="url:#"][infobox_inner_item title="30 Days returns" subtitle="You can return it later" link="url:#"][/infobox_item][/vc_column][vc_column width="1/3"][product_categories orderby="" order="" columns="1" number="1" ids=""][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1443703689778{padding-bottom: 0px !important;background-color: #f4f6f8 !important;}"][vc_column][products_grid products_grid_title="New in" grid_layout_mode="carousel" carousel_nav="yes" products_grid_col_select="4" products_grid_no_posts="10" products_grid_terms=""][/vc_column][/vc_row][vc_row css=".vc_custom_1445258164135{padding-top: 90px !important;padding-bottom: 0px !important;}"][vc_column][posts_grid grid_layout_style="overlay" posts_grid_col_select="2" posts_grid_no_posts="2" posts_in="" posts_grid_terms=""][/vc_column][/vc_row][vc_row css=".vc_custom_1443965457827{padding-top: 0px !important;padding-bottom: 30px !important;}"][vc_column][widget_instagram title="Instagram" username="voguemagazine" link="Follow us" limit="4" followers="23K" number="5"][/vc_column][/vc_row]
CONTENT;
 
    array_unshift( $data, $template );
    return $data;
}

//Homepage v1
add_filter( 'vc_load_default_templates', 'villenoir_custom_template_homepage_v1' ); // Hook in
function villenoir_custom_template_homepage_v1( $data ) {
    $template               = array();
    $template['name']       = esc_html__( 'Homepage', 'villenoir-shortcodes' ); // Assign name for your custom template
    $template['custom_class'] = 'custom_template_homepage_v1'; // CSS class name
    $template['content']    = <<<CONTENT
        [vc_row full_width="stretch_row_content" css=".vc_custom_1443186369315{margin-top: -61px !important;padding-top: 0px !important;padding-bottom: 0px !important;}"][vc_column][infobox_item][infobox_inner_item title="Free shipping" subtitle="On orders of $50 or more"][infobox_inner_item title="One day delivery" subtitle="With Royal Mail Service"][infobox_inner_item title="30 Days returns" subtitle="You can return it later"][/infobox_item][/vc_column][/vc_row][vc_row css=".vc_custom_1443261539033{padding-bottom: 0px !important;}"][vc_column][products_grid products_grid_title="New in" grid_layout_mode="carousel" carousel_nav="yes" products_grid_col_select="4" show_filter="yes" products_grid_terms=""][/vc_column][/vc_row][vc_row css=".vc_custom_1446117548440{padding-top: 0px !important;}"][vc_column width="1/4"][vc_cta h2="The return of the jeans" txt_align="center" shape="square" style="outline" color="grey" add_button="bottom" btn_title="Shop collection" btn_style="outline" btn_shape="square" btn_color="black" btn_size="sm" btn_align="center" btn_link="url:#||"]Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.[/vc_cta][vc_single_image image="" img_size="full" alignment="center" css=".vc_custom_1446626451172{margin-bottom: 30px !important;}"][/vc_column][vc_column width="1/2"][vc_single_image image="" img_size="full" alignment="center" css=".vc_custom_1446626428312{margin-bottom: 30px !important;}"][/vc_column][vc_column width="1/4"][vc_single_image image="" img_size="full" css=".vc_custom_1446626488516{margin-bottom: 30px !important;}"][vc_cta h2="The return of the jacket" txt_align="center" shape="square" style="outline" color="grey" add_button="bottom" btn_title="Shop collection" btn_style="outline" btn_shape="square" btn_color="black" btn_size="sm" btn_align="center" btn_link="url:#||"]Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.[/vc_cta][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1443261762639{padding-top: 90px !important;padding-bottom: 45px !important;background-image: url(#) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column][products_grid products_grid_title="End of summer sales" grid_layout_mode="carousel" carousel_nav="yes" products_grid_col_select="4" products_grid_no_posts="10" products_grid_terms=""][/vc_column][/vc_row][vc_row css=".vc_custom_1446136048406{padding-top: 90px !important;padding-bottom: 30px !important;}"][vc_column][vc_row_inner][vc_column_inner width="1/4" css=".vc_custom_1446627045290{margin-bottom: 30px !important;}"][title_subtitle title_type="h5" font_transform="uppercase" title="Dress Sale" margin_bottom="0" title_font_color="#ababab"][title_subtitle font_transform="uppercase" title_special_style="line_over_text" add_subtitle="use_subtitle" title="up to 40% off" margin_bottom="15" subtitle="On selected styles. Use promo code: SALE at checkout."][vc_btn title="Shop Women" style="classic" shape="square" color="black" size="sm" align="center" link="url:%23||" button_block="true"][vc_btn title="Shop Girls" style="outline" shape="square" color="black" size="sm" align="center" link="url:%23||" button_block="true"][/vc_column_inner][vc_column_inner width="1/4" css=".vc_custom_1446627052569{margin-bottom: 30px !important;}"][vc_single_image image="" img_size="full" alignment="center"][/vc_column_inner][vc_column_inner width="1/4" css=".vc_custom_1446627060059{margin-bottom: 30px !important;}"][vc_single_image image="" img_size="full" alignment="center"][/vc_column_inner][vc_column_inner width="1/4" css=".vc_custom_1446627070147{margin-bottom: 30px !important;}"][title_subtitle title_type="h5" font_transform="uppercase" title="Sweater Sale" margin_bottom="0" title_font_color="#ababab"][title_subtitle font_transform="uppercase" title_special_style="line_over_text" add_subtitle="use_subtitle" title="up to 40% off" margin_bottom="15" subtitle="On selected styles. Use promo code: SALE at checkout."][vc_btn title="Shop Men" style="classic" shape="square" color="black" size="sm" align="center" link="url:%23||" button_block="true"][vc_btn title="Shop Boys" style="outline" shape="square" color="black" size="sm" align="center" link="url:%23||" button_block="true"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]
CONTENT;
 
    array_unshift( $data, $template );
    return $data;
}

