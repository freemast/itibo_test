<?php

// Add featured image support
if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
    add_image_size('special-offers-image', 300, 200, true);
}

// First create the widget for the admin panel
class special_offers_show_ajax_widget extends WP_Widget {

	function __construct() {
		parent::__construct(

			// Base ID of your widget
			'special_offers_show_ajax_widget',

			// Widget name will appear in UI
			esc_html__('Special offers (Ajax)','special-offers-show-ajax-widget'),

			// Widget description
			array( 'description' => esc_html__( 'A widget for Ajax special offers filter', 'special-offers' ), )
		);
	}


// Creating widget front-end

	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );


		// before and after widget arguments are defined by themes

		echo $args['before_widget'];
		if ( ! empty( $title ) )
		echo $args['before_title'] . $title . $args['after_title'];


		// This is where you run the code and display the output

		echo do_shortcode('[sow_ajax]');

		echo $args['after_widget'];
	}


// Widget Backend

	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = esc_html__( 'Special offers filter', 'special-offers' );
		}

	// Widget admin form

	?>
	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:', 'special-offers'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title ; ?>" />
	</p>
	<?php
	}

// Updating widget replacing old instances with new

	public function update($new_instance, $old_instance){
	    $instance = array();
	    $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
	    return $instance;
	}
}
