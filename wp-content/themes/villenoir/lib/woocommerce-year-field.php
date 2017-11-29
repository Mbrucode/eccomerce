<?php
// Display Fields
add_action( 'woocommerce_product_options_general_product_data', 'villenoir_product_year_field' );

// Save Fields
add_action( 'woocommerce_process_product_meta', 'villenoir_product_year_field_save' );

function villenoir_product_year_field() {

    global $woocommerce, $post;
    
    // Year Field
    woocommerce_wp_text_input( 
        array( 
            'id'                => '_year_field', 
            'label'             => esc_html__( 'Year', 'villenoir' ), 
            'placeholder'       => '', 
            'description'       => esc_html__( 'Enter the year here', 'villenoir' ),
            'type'              => 'text'
        )
    );
    // Bottle size Field
    woocommerce_wp_text_input( 
        array( 
            'id'                => '_bottle_size_field', 
            'label'             => esc_html__( 'Bottle size', 'villenoir' ), 
            'placeholder'       => '', 
            'description'       => esc_html__( 'Enter the bottle size here', 'villenoir' ),
            'type'              => 'text', 
        )
    );
}
function villenoir_product_year_field_save( $post_id ){

    // Year
    $woocommerce_year_field = $_POST['_year_field'];

    if( !empty( $woocommerce_year_field ) )
    update_post_meta( $post_id, '_year_field', esc_html( $woocommerce_year_field ) );

    // Bottle size
    $woocommerce_bottle_size = $_POST['_bottle_size_field'];

    if( !empty( $woocommerce_bottle_size ) )
    update_post_meta( $post_id, '_bottle_size_field', esc_html( $woocommerce_bottle_size ) );

}
?>