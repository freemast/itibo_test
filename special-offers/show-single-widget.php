<?php

// Add featured image support
if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
    add_image_size('special-offers-image', 300, 200, true);
}

// First create the widget for the admin panel
class special_offers_show_single_widget extends WP_Widget {
	function __construct() {
		parent::__construct(

			// Base ID of your widget
			'special_offers_show_single_widget',

			// Widget name will appear in UI
			esc_html__('Special offers (Single)','special-offers-show-single-widget'),

			// Widget description
			array( 'description' => esc_html__( 'A widget for special offers', 'special-offers' ), )
		);
	}

	function form( $instance ) {
		$special_offers_post_id = ''; // Initialize the variable
		if (isset($instance['special_offers_post_id'])) {
			$special_offers_post_id = esc_attr($instance['special_offers_post_id']);
		};
		$show_special_offers_post_title  = isset( $instance['show_special_offers_post_title'] ) ? $instance['show_special_offers_post_title'] : true;
		$show_featured_image  = isset( $instance['show_featured_image'] ) ? $instance['show_featured_image'] : true;
		$apply_content_filters  = isset( $instance['apply_content_filters'] ) ? $instance['apply_content_filters'] : true;

        $show_special_offers_meta_info  = isset( $instance['show_special_offers_meta_info'] ) ? $instance['show_special_offers_meta_info'] : true;
        $show_special_offers_meta_fp  = isset( $instance['show_special_offers_meta_fp'] ) ? $instance['show_special_offers_meta_fp'] : true;
        $show_special_offers_meta_sp  = isset( $instance['show_special_offers_meta_sp'] ) ? $instance['show_special_offers_meta_sp'] : true;
        $show_special_offers_meta_actual  = isset( $instance['show_special_offers_meta_actual'] ) ? $instance['show_special_offers_meta_actual'] : true;
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'special_offers_post_id' ); ?>"> <?php echo esc_html__( 'Special offers to Display:', 'special-offers' ) ?>
				<select class="widefat" id="<?php echo $this->get_field_id( 'special_offers_post_id' ); ?>" name="<?php echo $this->get_field_name( 'special_offers_post_id' ); ?>">
				<?php
					$args = array( 'post_type' => 'special_offers', 'suppress_filters' => 0, 'numberposts' => -1, 'order' => 'ASC' );
					$special_offers = get_posts( $args );
					if ($special_offers) {
						foreach( $special_offers as $special_offers ) : setup_postdata( $special_offers );
							echo '<option value="' . $special_offers -> ID . '"';
							if( $special_offers_post_id == $special_offers -> ID ) {
								echo ' selected';
								$widgetExtraTitle = $special_offers -> post_title;
							};
							echo '>' . $special_offers -> post_title . '</option>';
						endforeach;
					} else {
						echo '<option value="">' . esc_html__( 'No special offers available', 'special-offers' ) . '</option>';
					};
				?>
				</select>
			</label>
		</p>

		<input type="hidden" id="<?php echo $this -> get_field_id( 'title' ); ?>" name="<?php echo $this -> get_field_name( 'title' ); ?>" value="<?php if ( !empty( $widgetExtraTitle ) ) { echo $widgetExtraTitle; } ?>" />

		<p>
			<?php
				echo '<a href="post.php?post=' . $special_offers_post_id . '&action=edit">' . esc_html__( 'Edit special offers', 'special-offers' ) . '</a>' ;
			?>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( (bool) isset( $instance['show_special_offers_post_title'] ), true ); ?> id="<?php echo $this->get_field_id( 'show_special_offers_post_title' ); ?>" name="<?php echo $this->get_field_name( 'show_special_offers_post_title' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_special_offers_post_title' ); ?>"><?php echo esc_html__( 'Show title', 'special-offers' ) ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( (bool) isset( $instance['show_post_content'] ), true ); ?> id="<?php echo $this->get_field_id( 'show_post_content' ); ?>" name="<?php echo $this->get_field_name( 'show_post_content' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_post_content' ); ?>"><?php echo esc_html__( 'Show content', 'special-offers' ) ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( (bool) isset( $instance['show_featured_image'] ), true ); ?> id="<?php echo $this->get_field_id( 'show_featured_image' ); ?>" name="<?php echo $this->get_field_name( 'show_featured_image' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_featured_image' ); ?>"><?php echo esc_html__( 'Show featured image', 'special-offers' ) ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( (bool) isset( $instance['apply_content_filters'] ), true ); ?> id="<?php echo $this->get_field_id( 'apply_content_filters' ); ?>" name="<?php echo $this->get_field_name( 'apply_content_filters' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'apply_content_filters' ); ?>"><?php echo esc_html__( 'Do not apply content filters', 'special-offers' ) ?></label>
		</p>


		<p>
			<input class="checkbox" type="checkbox" <?php checked( (bool) isset( $instance['show_special_offers_meta_info'] ), true ); ?> id="<?php echo $this->get_field_id( 'show_special_offers_meta_info' ); ?>" name="<?php echo $this->get_field_name( 'show_special_offers_meta_info' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_special_offers_meta_info' ); ?>"><?php echo esc_html__( 'Show information', 'special-offers' ) ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( (bool) isset( $instance['show_special_offers_meta_fp'] ), true ); ?> id="<?php echo $this->get_field_id( 'show_special_offers_meta_fp' ); ?>" name="<?php echo $this->get_field_name( 'show_special_offers_meta_fp' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_special_offers_meta_fp' ); ?>"><?php echo esc_html__( 'Show fixed price', 'special-offers' ) ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( (bool) isset( $instance['show_special_offers_meta_sp'] ), true ); ?> id="<?php echo $this->get_field_id( 'show_special_offers_meta_sp' ); ?>" name="<?php echo $this->get_field_name( 'show_special_offers_meta_sp' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_special_offers_meta_sp' ); ?>"><?php echo esc_html__( 'Show special price', 'special-offers' ) ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( (bool) isset( $instance['show_special_offers_meta_actual'] ), true ); ?> id="<?php echo $this->get_field_id( 'show_special_offers_meta_actual' ); ?>" name="<?php echo $this->get_field_name( 'show_special_offers_meta_actual' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_special_offers_meta_actual' ); ?>"><?php echo esc_html__( 'Show actual', 'special-offers' ) ?></label>
		</p>


<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['special_offers_post_id'] = strip_tags( $new_instance['special_offers_post_id'] );
		$instance['show_special_offers_post_title'] = $new_instance['show_special_offers_post_title'];
		$instance['show_featured_image'] = $new_instance['show_featured_image'];
		$instance['apply_content_filters'] = $new_instance['apply_content_filters'];
        $instance['show_post_content'] = $new_instance['show_post_content'];
        $instance['show_special_offers_meta_info'] = $new_instance['show_special_offers_meta_info'];
        $instance['show_special_offers_meta_fp'] = $new_instance['show_special_offers_meta_fp'];
        $instance['show_special_offers_meta_sp'] = $new_instance['show_special_offers_meta_sp'];
        $instance['show_special_offers_meta_actual'] = $new_instance['show_special_offers_meta_actual'];
		return $instance;
	}

	// Display the content block content in the widget area
	function widget($args, $instance) {

        $content = "";
		extract($args);
		$special_offers_post_id  = ( $instance['special_offers_post_id'] != '' ) ? esc_attr($instance['special_offers_post_id']) : esc_html__( 'Find', 'special-offers' );
		// Add support for WPML Plugin.
		if ( function_exists( 'icl_object_id' ) ){
			$special_offers_post_id = icl_object_id( $special_offers_post_id, 'special_offers', true );
		}
		// Variables from the widget settings.
		$show_special_offers_post_title = isset( $instance['show_special_offers_post_title'] ) ? $instance['show_special_offers_post_title'] : false;
		$show_featured_image  = isset($instance['show_featured_image']) ? $instance['show_featured_image'] : false;
		$apply_content_filters  = isset($instance['apply_content_filters']) ? $instance['apply_content_filters'] : false;
        $show_post_content = isset( $instance['show_post_content'] ) ? $instance['show_post_content'] : false;
		$show_special_offers_meta_info = isset( $instance['show_special_offers_meta_info'] ) ? $instance['show_special_offers_meta_info'] : false;
        $show_special_offers_meta_fp = isset( $instance['show_special_offers_meta_fp'] ) ? $instance['show_special_offers_meta_fp'] : false;
        $show_special_offers_meta_sp = isset( $instance['show_special_offers_meta_sp'] ) ? $instance['show_special_offers_meta_sp'] : false;
        $show_special_offers_meta_actual = isset( $instance['show_special_offers_meta_actual'] ) ? $instance['show_special_offers_meta_actual'] : false;
		$content_post = get_post( $special_offers_post_id );
		$post_status = get_post_status( $special_offers_post_id );
		$post_content = $content_post->post_content;
		if ( $post_status == 'publish' ) {
			// Display custom widget frontend
			if ( $located = locate_template( 'special-offers-show-widget.php' ) ) {
				require $located;
				return;
			}

            $content .= $before_widget;

            if ( $show_special_offers_post_title ) {
				$content .= $before_title . apply_filters( 'widget_title',$content_post->post_title) . $after_title; // This is the line that displays the title (only if show title is set)
			}

			if ( $show_featured_image ) {
                $content .=  get_the_post_thumbnail( $content_post -> ID, 'special-offers-image' );
			}

            if ( $show_post_content ) {
    			if ( !$apply_content_filters ) { // Don't apply the content filter if checkbox selected
    				$content .= apply_filters( 'the_content', $post_content);
    			}else{
                    $content .= $content_post->post_content;
    			}
            }

            if ( $show_special_offers_meta_info ) {
                $content .= '<p><b>'.esc_html__('Information', 'special-offers' ).':</b> '.get_post_meta($content_post -> ID, 'special_offers_information', true).'</p>';
            }

            if ( $show_special_offers_meta_fp ) {
                $content .= '<p><b>'.esc_html__('Fixed price', 'special-offers' ).':</b> '.get_post_meta($content_post -> ID, 'special_offers_fixed_price', true).'</p>';
            }

            if ( $show_special_offers_meta_sp ) {
                $content .= '<p><b>'.esc_html__('Special price', 'special-offers' ).':</b> '.get_post_meta($content_post -> ID, 'special_offers_special_price', true).'</p>';
            }

            if ( $show_special_offers_meta_actual ) {
                $content .= '<p><b>'.esc_html__('Actual', 'special-offers' ).':</b> '.get_post_meta($content_post -> ID, 'special_offers_actual', true).'</p>';
            }

            $content .= $after_widget;

            echo do_shortcode( $content ); // This is where the actual content of the special offers is being displayed
		}
	}
}

// Create the Special offers special offers type
function sow_post_type_init() {
	$labels = array(
		'name' => esc_html__( 'Special offers', 'special-offers' ),
		'singular_name' => esc_html__( 'Special offers', 'special-offers' ),
		'plural_name' => esc_html__( 'Special offers', 'special-offers' ),
		'add_new' => esc_html__( 'Add special offers', 'special-offers' ),
		'add_new_item' => esc_html__( 'Add new special offers', 'special-offers' ),
		'edit_item' => esc_html__( 'Edit special offers', 'special-offers' ),
		'new_item' => esc_html__( 'New special offers', 'special-offers' ),
		'view_item' => esc_html__( 'View special offers', 'special-offers' ),
		'search_items' => esc_html__( 'Search special offers', 'special-offers' ),
		'not_found' =>  esc_html__( 'Special offers no found', 'special-offers' ),
		'not_found_in_trash' => esc_html__( 'Special offers no found in trash', 'special-offers' )
	);
	$special_offers_public = false; // added to make this a filterable option
	$options = array(
		'labels' => $labels,
		'public' => apply_filters( 'special_offers_post_type', $special_offers_public ),
		'publicly_queryable' => false,
		'exclude_from_search' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_icon' => 'dashicons-screenoptions',
		'supports' => array( 'title','editor','revisions','thumbnail' ),
        'taxonomies' => array( 'category' ),
	);
	register_post_type( 'special_offers',$options );
}
add_action( 'init', 'sow_post_type_init' );

function special_offers_messages( $messages ) {
	$messages['special_offers'] = array(
		0 => '',
		1 => current_user_can( 'edit_theme_options' ) ? sprintf( esc_html__( 'Special offers updated.', 'special-offers' ), esc_url( 'widgets.php' ) ) : sprintf( esc_html__( 'Special offers updated.', 'special-offers' ), esc_url( 'widgets.php' ) ),
		2 => esc_html__( 'Custom field updated.', 'special-offers' ),
		3 => esc_html__( 'Custom field deleted.', 'special-offers' ),
		4 => esc_html__( 'Special offers updated.', 'special-offers' ),
		5 => isset($_GET['revision']) ? sprintf( esc_html__( 'Special offers restored to revision from %s', 'special-offers' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => current_user_can( 'edit_theme_options' ) ? sprintf( esc_html__( 'Special offers published.', 'special-offers' ), esc_url( 'widgets.php' ) ) : sprintf( esc_html__( 'Special offers published.', 'special-offers' ), esc_url( 'widgets.php' ) ),
		7 => esc_html__( 'Special offers saved.', 'special-offers' ),
		8 => current_user_can( 'edit_theme_options' ) ? sprintf( esc_html__( 'Special offers submitted.', 'special-offers' ), esc_url( 'widgets.php' ) ) : sprintf( esc_html__( 'Special offers submitted.', 'special-offers' ), esc_url( 'widgets.php' ) ),
		9 => sprintf( esc_html__( 'Special offers scheduled for: <strong>%1$s</strong>.', 'special-offers' ), date_i18n( esc_html__( 'M j, Y @ G:i' , 'special-offers' ), strtotime(isset($post->post_date) ? $post->post_date : null) ), esc_url( 'widgets.php' ) ),
		10 => current_user_can( 'edit_theme_options' ) ? sprintf( esc_html__( 'Special offers draft updated.', 'special-offers' ), esc_url( 'widgets.php' ) ) : sprintf( esc_html__( 'Special offers draft updated.', 'special-offers' ), esc_url( 'widgets.php' ) ),
	);
	return $messages;
}
add_filter( 'post_updated_messages', 'special_offers_messages' );

// Add the ability to display the content block in a reqular post using a shortcode
function special_offers_show_widget_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'id' => '',
		'slug' => '',
		'class' => 'special_offers_wrap',
		'suppress_content_filters' => 'no',
		'featured_image' => 'yes',
		'featured_image_size' => 'special-offers-image',
		'title' => 'no',
		'title_tag' => 'h3',
        'text' => 'no',
        'meta_info' => 'yes',
        'meta_fp' => 'yes',
        'meta_sp' => 'yes',
        'meta_actual' => 'yes'
	), $atts ) );

	if ( $slug ) {
		$block = get_page_by_path( $slug, OBJECT, 'special_offers' );
		if ( $block ) {
			$id = $block->ID;
		}
	}

	$content = "";

	if( $id != "" ) {
		$args = array(
			'post__in' => array( $id ),
			'post_type' => 'special_offers',
		);

		$content_post = get_posts( $args );

		foreach( $content_post as $post ) :
			$content .= '<div class="'. esc_attr( $class ) .'" id="special_offers_show_widget-' . $id . '">';
			if ( $title === 'yes' ) {
				$content .= '<' . esc_attr( $title_tag ) . '>' . $post -> post_title . '</' . esc_attr( $title_tag ) . '>';
			}

			if ( $featured_image === 'yes' ) {
				$content .= get_the_post_thumbnail( $post -> ID, $featured_image_size );
			}

            if ( $text === 'yes' ) {
      			if ( $suppress_content_filters === 'no' ) {
      				$content .= apply_filters( 'the_content', $post -> post_content );
      			} else {
      				$content .= $post -> post_content;
      			}
            }

            if ( $meta_info === 'yes' ) {
                $content .= '<p><b>'.esc_html__('Information', 'special-offers' ).':</b> '.get_post_meta($post->ID, 'special_offers_information', true).'</p>';
            }

            if ( $meta_fp === 'yes' ) {
                $content .= '<p><b>'.esc_html__('Fixed price', 'special-offers' ).':</b> '.get_post_meta($post->ID, 'special_offers_fixed_price', true).'</p>';
            }

            if ( $meta_sp === 'yes' ) {
                $content .= '<p><b>'.esc_html__('Special price', 'special-offers' ).':</b> '.get_post_meta($post->ID, 'special_offers_special_price', true).'</p>';
            }

            if ( $meta_actual === 'yes' ) {
                $content .= '<p><b>'.esc_html__('Actual', 'special-offers' ).':</b> '.get_post_meta($post->ID, 'special_offers_actual', true).'</p>';
            }

			$content .= '</div>';
		endforeach;
	}

	return $content;
}
add_shortcode( 'special_offers', 'special_offers_show_widget_shortcode' );

// Only add special_offers icon above posts and pages
function sow_add_special_offers_button() {
	global $current_screen;
    if ( ( 'special_offers' != $current_screen -> post_type ) && ( 'toplevel_page_revslider' != $current_screen -> id ) ) {
		add_action( 'media_buttons', 'add_special_offers_icon' );
		add_action( 'admin_footer', 'add_special_offers_popup' );
	}
}
add_action( 'admin_head', 'sow_add_special_offers_button' );