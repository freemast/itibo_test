<?php

// Meta boxes on special_offers edit page
function sow_add_meta_boxes() {
    add_meta_box( 'sow_fixed_price', esc_html__( 'Fixed price', 'special-offers' ), 'sow_fixed_price_meta_box', 'special_offers', 'side' );
    add_meta_box( 'sow_special_price', esc_html__( 'Special price', 'special-offers' ), 'sow_special_price_meta_box', 'special_offers', 'side' );
    add_meta_box( 'sow_actual', esc_html__( 'Actual', 'special-offers' ), 'sow_actual_meta_box', 'special_offers', 'side' );
	add_meta_box( 'sow_info', esc_html__( 'Information', 'special-offers' ), 'sow_info_meta_box', 'special_offers', 'side' );
	add_meta_box( 'sow_shortcode', esc_html__( 'Shortcodes', 'special-offers' ), 'sow_shortcode_meta_box', 'special_offers', 'side' );
}
add_action( 'add_meta_boxes_special_offers', 'sow_add_meta_boxes' );

// Shortcode meta box
function sow_shortcode_meta_box( $post ) { ?>
	<p><?php esc_html_e( 'To output, use any of the following code options:', 'special-offers' ); ?></p>
	<code class="sow-code" id="sow-shortcode-1"><?php echo '[special_offers id=' . $post -> ID . ']'; ?></code>

	<code class="sow-code" id="sow-shortcode-2"><?php echo '[special_offers slug=' . $post -> post_name . ']'; ?></code>

	<code class="sow-code" id="sow-shortcode-3"><?php echo '[special_offers id=' . $post -> ID . ' title=yes title_tag=h3 text=yes]'; ?></code>
<?php
}
// fixed price meta box
function sow_fixed_price_meta_box( $post ) {
	wp_nonce_field( 'sow_fixed_price_meta_box', 'sow_fixed_price_meta_box_nonce' );
	$value = get_post_meta( $post -> ID, '_special_offers_fixed_price', true );
	echo '<p>' . esc_html__( 'Regular price:', 'special-offers' ) . '</p>';
	echo '<input type="number" class="sow-fixed-price" id="sow_special_offers_fixed_price" name="sow_special_offers_fixed_price" value="' . esc_attr( $value ) . '">';
}

// Special price meta box
function sow_special_price_meta_box( $post ) {
	wp_nonce_field( 'sow_special_price_meta_box', 'sow_special_price_meta_box_nonce' );
	$value = get_post_meta( $post -> ID, '_special_offers_special_price', true );
	echo '<p>' . esc_html__( 'Special price:', 'special-offers' ) . '</p>';
	echo '<input type="number" class="sow-special-price" id="sow_special_offers_special_price" name="sow_special_offers_special_price" value="' . esc_attr( $value ) . '">';
}


// Actual meta box
function sow_actual_meta_box( $post ) {
	wp_nonce_field( 'sow_actual_meta_box', 'sow_actual_meta_box_nonce' );
	$value = get_post_meta( $post -> ID, '_special_offers_actual', true );
	echo '<p>' . esc_html__( 'Actual:', 'special-offers' ) . '</p>';
	echo '<input type="date" class="sow-actual" id="sow_special_offers_actual" name="sow_special_offers_actual" value="' . esc_attr( $value ) . '">';
}


// Info meta box
function sow_info_meta_box( $post ) {
	wp_nonce_field( 'sow_info_meta_box', 'sow_info_meta_box_nonce' );
	$value = get_post_meta( $post -> ID, '_special_offers_information', true );
	echo '<p>' . esc_html__( 'You can use this field to describe this special offers:', 'special-offers' ) . '</p>';
	echo '<textarea class="sow-information" id="sow_special_offers_information" cols="40" rows="4" name="sow_special_offers_information">' . esc_attr( $value ) . '</textarea>';
}

function sow_test_postdata( $nonce, $action, $posts ) {
	if ( ! isset( $_POST[$nonce] ) ) {
        return FALSE;
	}else{
	    if ( ! wp_verify_nonce( $_POST[$nonce], $action ) ) {
            return FALSE;
	    }else{
            return sanitize_text_field($_POST[$posts]);
	    }
	}
}

function sow_save_postdata( $post_id ) {

    $arr = array(
        'special_offers_fixed_price' => sow_test_postdata( 'sow_fixed_price_meta_box_nonce', 'sow_fixed_price_meta_box', 'sow_special_offers_fixed_price' ),
        'special_offers_special_price' => sow_test_postdata( 'sow_special_price_meta_box_nonce', 'sow_special_price_meta_box', 'sow_special_offers_special_price' ),
        'special_offers_actual' => sow_test_postdata( 'sow_actual_meta_box_nonce', 'sow_actual_meta_box', 'sow_special_offers_actual' ),
        'special_offers_information' => sow_test_postdata( 'sow_info_meta_box_nonce', 'sow_info_meta_box', 'sow_special_offers_information' ),
    );
    foreach ( $arr as $key => $value ) {
    	update_post_meta( $post_id, $key, $value );
    }
}
add_action( 'save_post', 'sow_save_postdata' );


add_filter('manage_special_offers_posts_columns', 'add_views_column', 4);
function add_views_column( $columns ){
	$num = 4;

	$new_columns = array(
		'special_offers_information'    => esc_html__( 'Information', 'special-offers' ),
        'special_offers_fixed_price'    => esc_html__( 'Fixed price', 'special-offers' ),
        'special_offers_special_price'  => esc_html__( 'Special price', 'special-offers' ),
        'special_offers_actual'         => esc_html__( 'Actual', 'special-offers' ),
	);

	return array_slice( $columns, 0, $num ) + $new_columns + array_slice( $columns, $num );
}

add_filter('manage_special_offers_posts_custom_column', 'fill_views_column', 5, 2);
function fill_views_column( $colname, $post_id ){
    echo get_post_meta($post_id, $colname, true);
}

