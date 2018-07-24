<?php

// Add button above editor if not editing special_offers
function add_special_offers_icon() {
	echo '<style>
	.sow-button .dashicons-screenoptions {
		color: #888;
		height: 18px;
		margin: 0 4px 0 0;
		vertical-align: text-top;
		width: 18px;
	}
	.sow-button {
		padding-left: 0.4em;
	}
	</style>
	<a id="add-special-offers" class="button thickbox sow-button" title="' . esc_html__("Add special offers", 'special-offers' ) . '" href="' . plugins_url() . 'popup.php?type=add_special_offers_popup&amp;TB_inline=true&amp;inlineId=special-offers-form">
		<div class="dashicons dashicons-screenoptions"></div>' . esc_html__("Add special offers", "special-offers-show-widget") . '
	</a>';
}

// Displays the lightbox popup to insert a content block shortcode to a post/page
function add_special_offers_popup() { ?>
	<script>
		function selectContentBlockId(select) {
			content_id = select.options[select.selectedIndex].value;
			content_slug = select.options[select.selectedIndex].getAttribute("data-slug");
		}
		function insertContentBlockShortcode() {
			if (typeof content_id === 'undefined') {
				alert( "<?php esc_html_e( 'Please select a special offers', 'special-offers' ); ?>" );
				return false;
			}
			var win = window.dialogArguments || opener || parent || top;
			win.send_to_editor( "[special_offers id=" + content_id + " slug=" + content_slug + "]" );
		}
	</script>
	<div id="special-offers-form" style="display: none;">
		<h3>
			<?php esc_html_e( 'Insert special offers', 'special-offers' ); ?>
		</h3>
		<p>
			<?php esc_html_e( 'Select a special offers below to add it to your post or page.', 'special-offers' ); ?>
		</p>
		<p>
			<select class="add-special-offers-id" id="add-special-offers-id" onchange="selectContentBlockId(this)">
				<option value="">
					<?php esc_html_e( 'Select a special offers', 'special-offers' ); ?>
				</option>
				<?php
					$args = array( 'post_type' => 'special_offers', 'suppress_filters' => 0, 'numberposts' => -1, 'order' => 'ASC' );
					$special_offers = get_posts( $args );
					if ( $special_offers ) {
						foreach( $special_offers as $special_offers ) : setup_postdata( $special_offers );
							echo '<option value="' . $special_offers -> ID . '" data-slug="' . $special_offers -> post_name . '">' . esc_html( $special_offers -> post_title ) . '</option>';
						endforeach;
					} else {
						echo '<option value="">' . esc_html__( 'No special offers available', 'special-offers' ) . '</option>';
					};
				?>
			</select>
		</p>
		<p>
			<input type="button" class="button-primary" value="<?php esc_html_e( 'Insert special offers', 'special-offers' ) ?>" onclick="insertContentBlockShortcode();"/>
		</p>
	</div>

<?php }
