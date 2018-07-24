<?php
/*
 Plugin Name: Special offers
 Description: Специальные предложения
 Version: 1.0.0 beta
 Author: freemast
 Text Domain: special-offers
 Domain Path: /languages

*/

// Launch the plugin.
function special_offers_show_widget_plugin_init() {
	add_action( 'widgets_init', 'special_offers_load_widget' );
}
add_action( 'plugins_loaded', 'special_offers_show_widget_plugin_init' );

// Load plugin textdomain.
add_action( 'plugins_loaded', 'special_offers_load_textdomain' );
function special_offers_load_textdomain() {
  load_plugin_textdomain( 'special-offers', false, basename( dirname( __FILE__ ) ) . '/lang' );
}

//enqueue scripts
function special_offers_scripts(){

	wp_enqueue_style('special-offers-styles',plugin_dir_url( __FILE__ ).'css/ajax-filter-stylesheet.css');

	wp_enqueue_script('jquery');
	wp_register_script( 'sow_ajax_filter', plugin_dir_url( __FILE__ ).'js/ajax-filter.js','jquery','1.0');
	wp_enqueue_script('sow_ajax_filter');

	wp_localize_script( 'sow_ajax_filter', 'sow_ajax_params', array(
        'sow_ajax_nonce' => wp_create_nonce( 'sow_ajax_nonce' ),
        'sow_ajax_url' => admin_url( 'admin-ajax.php' ),
    )
  );
}

add_action( 'wp_enqueue_scripts', 'special_offers_scripts' );

//shortcode function
function special_offers_shortcode_mapper(){
	$taxonomy = 'category';
	$terms = get_terms($taxonomy); // Get all terms of a taxonomy
	if ( $terms && !is_wp_error( $terms ) ){
		echo '<div class="sow-filter-div"><ul>';
        foreach( $terms as $term ) {
            echo '<li class="sow_texonomy" data_id="'.$term->term_id.'">'.$term->name.'</li>';
        }
        echo '</ul></div>';
    }
    $content = '
    <div class="sow-ajax-container">
	    <div class="sow-loader">
	    	<img src="'.plugin_dir_url( __FILE__ ).'img/ajax-loader.gif'.'" alt="">
	    </div>
	    <div class="special-offers-filter-result"></div>
    </div>';

    echo $content;
}
add_shortcode( 'sow_ajax', 'special_offers_shortcode_mapper' );

//ajax actions
add_action('wp_ajax_sow_filter_posts', 'special_offers_ajax_functions');
add_action('wp_ajax_nopriv_sow_filter_posts', 'special_offers_ajax_functions');

//ajax main function
function special_offers_ajax_functions(){
	// Verify nonce
  	if( !isset( $_POST['sow_ajax_nonce'] ) || !wp_verify_nonce( $_POST['sow_ajax_nonce'], 'sow_ajax_nonce' ) )
    die('Permission denied');

	$term_ID = sanitize_text_field( intval($_POST['term_ID']) );

	//post query
	$query = new WP_Query( array(
		'post_type' => 'special_offers',
		'post_per_pages' => -1,
		'tax_query' => array(
			array(
				'taxonomy' => 'category',
				'field' => 'term_id',
				'terms' => $term_ID,
			)
		)

	) );

	if( $query->have_posts() ):

		while( $query->have_posts()): $query->the_post();
            $pid = get_the_id();
			$results = '<div class="sow-single-special-offers">';
            $results .=  get_the_post_thumbnail( $pid, 'special-offers-image' );
			$results .= '<p><b>'.get_the_title().'</b></p>';
            $results .= '<p><i>'.get_the_content().'</i></p>';
			// $results .= '<p>'.get_the_excerpt().'</p>';
            $results .= '<p><b>'.esc_html__('Information', 'special-offers' ).':</b> '.get_post_meta($pid, 'special_offers_information', true).'</p>';
            $results .= '<p><b>'.esc_html__('Fixed price', 'special-offers' ).':</b> '.get_post_meta($pid, 'special_offers_fixed_price', true).'</p>';
            $results .= '<p><b>'.esc_html__('Special price', 'special-offers' ).':</b> '.get_post_meta($pid, 'special_offers_special_price', true).'</p>';
            $results .= '<p><b>'.esc_html__('Actual', 'special-offers' ).':</b> '.get_post_meta($pid, 'special_offers_actual', true).'</p>';
			$results .= '</div>';

			echo $results;

		endwhile;
	else:
		echo esc_html__('<h2>Special offers no found</h2>', 'special-offers');
	endif;
	wp_reset_query();
	die();
}

require_once( 'show-ajax-widget.php' );

require_once( 'show-single-widget.php' );

// Register and load the widget

function special_offers_load_widget() {
    register_widget( 'special_offers_show_ajax_widget' );
    register_widget( 'special_offers_show_single_widget' );
}

// Admin-only functions
if ( is_admin() ) {

	require_once( 'meta-box.php' );
	require_once( 'window-popup.php' );

	// Enqueue styles and scripts on special_offers edit page
	function sow_enqueue() {
		$screen = get_current_screen();
		// Check screen base and current post type
		if ( 'post' === $screen -> base && 'special_offers' === $screen -> post_type ) {
			wp_enqueue_style( 'sow-style', plugins_url( '/css/special-offers-show-widget.css', __FILE__ ) );
		}
	}
	add_action( 'admin_enqueue_scripts', 'sow_enqueue' );

}

