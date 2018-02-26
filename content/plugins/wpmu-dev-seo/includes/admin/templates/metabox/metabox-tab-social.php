<?php
	$post = empty( $post ) ? null : $post;
	$og_setting_enabled = empty( $og_setting_enabled ) ? false : $og_setting_enabled;
	$og_post_type_enabled = empty( $og_post_type_enabled ) ? false : $og_post_type_enabled;
	$twitter_setting_enabled = empty( $twitter_setting_enabled ) ? false : $twitter_setting_enabled;

if ( ! is_a( $post, 'WP_Post' ) ) {
	return;
}

	$og = smartcrawl_get_value( 'opengraph' );
if ( ! is_array( $og ) ) {
	$og = array();
}

	$og = wp_parse_args($og, array(
		'title'       => false,
		'description' => false,
		'images'      => false,
		'disabled'    => false,
	));

	if ( ! class_exists( 'Smartcrawl_OpenGraph_Printer' ) ) { require_once( SMARTCRAWL_PLUGIN_DIR . 'tools/class_wds_opengraph_printer.php' ); }
	$og_printer = Smartcrawl_OpenGraph_Printer::get();
	$og_meta_disabled = (bool) smartcrawl_get_array_value( $og, 'disabled' );

	$twitter = smartcrawl_get_value( 'twitter' );
	if ( ! is_array( $twitter ) ) {
		$twitter = array();
	}

	$twitter = wp_parse_args($twitter, array(
		'title'       => false,
		'description' => false,
		'disabled'    => false,
	));

	if ( ! class_exists( 'Smartcrawl_Twitter_Printer' ) ) { require_once( SMARTCRAWL_PLUGIN_DIR . '/tools/class_wds_twitter_printer.php' ); }
	$twitter_printer = Smartcrawl_Twitter_Printer::get();
	$twitter_meta_disabled = smartcrawl_get_array_value( $twitter, 'disabled' );

	$resolver = Smartcrawl_Endpoint_Resolver::resolve();
	$resolver->simulate_post( $post->ID );
?>
<div class="wds-metabox-section wds-social-settings-metabox-section wds-form">
	<p>
		<?php
			printf(
				esc_html__( "Customize this posts title, description and featured images for social shares. You can also configure the default settings for this post type in SmartCrawl's %s area.", 'wds' ),
				sprintf(
					'<a href="%s">%s</a>',
					Smartcrawl_Settings_Admin::admin_url( Smartcrawl_Settings::TAB_ONPAGE ),
					esc_html__( 'Titles & Meta', 'wds' )
				)
			);
		?>
	</p>
	<?php if ( $og_setting_enabled && $og_post_type_enabled ) :  ?>
		<div class="wds-table-fields-group wds-separator-top">
			<div class="wds-table-fields">
				<div class="label">
					<label class="wds-label"><?php esc_html_e( 'OpenGraph', 'wds' ); ?></label>
					<p class="wds-label-description"><?php esc_html_e( 'OpenGraph is used on many social networks such as Facebook.', 'wds' ); ?></p>
				</div>
				<div class="fields">
					<div class="wds-toggleable inverted <?php echo $og_meta_disabled ? 'inactive' : ''; ?>">
							<?php
								$this->_render('toggle-item', array(
									'inverted'   => true,
									'field_name' => 'wds-opengraph[disabled]',
									'checked'    => checked( $og_meta_disabled, true, false ),
									'item_label' => esc_html__( 'Enable OpenGraph for this post', 'wds' ),
								));
							?>
							<div class="wds-toggleable-inside wds-toggleable-inside-box wds-table-fields-group wds-opengraph-meta">
								<div class="wds-table-fields wds-table-fields-stacked">
									<div class="label">
										<label for="og-title" class="wds-label"><?php esc_html_e( 'Title', 'wds' ); ?></label>
									</div>
									<div class="fields">
										<input type="text"
											   id="og-title"
											   name="wds-opengraph[title]"
											   placeholder="<?php echo $og['title'] ? '' : esc_attr( smartcrawl_replace_vars( $og_printer->get_tag_value( 'title' ), $post ) ); ?>"
											   value="<?php echo esc_attr( $og['title'] ); ?>"/>
									</div>
								</div>

								<div class="wds-table-fields wds-table-fields-stacked">
									<div class="label">
										<label for="og-description" class="wds-label"><?php esc_html_e( 'Description', 'wds' ); ?></label>
									</div>
									<div class="fields">
										<textarea name="wds-opengraph[description]"
												  placeholder="<?php echo $og['description'] ? '' : esc_attr( smartcrawl_replace_vars( $og_printer->get_tag_value( 'description' ), $post ) ); ?>"
												  id="og-description"><?php echo esc_textarea( $og['description'] ); ?></textarea>
									</div>
								</div>

								<div class="wds-table-fields wds-table-fields-stacked">
									<div class="label">
										<label for="og-images" class="wds-label"><?php esc_html_e( 'Featured Images', 'wds' ); ?></label>
									</div>
									<div class="fields og-images"
										 data-name="wds-opengraph[og-images]">
										<div class="add-action-wrapper item">
											<a href="#add" title="<?php esc_attr_e( 'Add image', 'wds' ); ?>">
												<i class="wds-icon-plus"></i>
											</a>
										</div>
										<?php if ( ! empty( $og['images'] ) && is_array( $og['images'] ) ) :  ?>
											<?php foreach ( $og['images'] as $img ) :  ?>
												<input type="text" class="widefat"
													   name="wds-opengraph[images][]"
													   value="<?php echo esc_attr( $img ); ?>" />
											<?php endforeach; ?>
										<?php endif; ?>
									</div>
								</div>

								<p class="wds-label-description"><?php esc_html_e( 'Each of these images will be available to use as the featured image when the post is shared.', 'wds' ); ?></p>
							</div>
						</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( $twitter_setting_enabled ) :  ?>
		<div class="wds-table-fields-group wds-separator-top">
			<div class="wds-table-fields">
				<div class="label">
					<label class="wds-label" for="wds-twitter-use-og"><?php esc_html_e( 'Twitter', 'wds' ); ?></label>
					<p class="wds-label-description"><?php esc_html_e( 'OpenGraph is used on many social networks such as Facebook.', 'wds' ); ?></p>
				</div>
				<div class="fields">
					<div class="wds-toggleable inverted <?php echo $twitter_meta_disabled ? 'inactive' : ''; ?>">
							<?php
								$this->_render('toggle-item', array(
									'inverted'   => true,
									'field_name' => 'wds-twitter[disabled]',
									'checked'    => checked( $twitter_meta_disabled, true, false ),
									'item_label' => esc_html__( 'Enable Twitter Cards for this post', 'wds' ),
								));
							?>
							<div class="wds-toggleable-inside wds-toggleable-inside-box wds-table-fields-group wds-twitter-meta">
								<div class="wds-table-fields wds-table-fields-stacked">
									<div class="label">
										<label for="twitter-title" class="wds-label"><?php esc_html_e( 'Title', 'wds' ); ?></label>
									</div>
									<div class="fields">
										<input type="text"
											   id="twitter-title"
											   name="wds-twitter[title]"
											   placeholder="<?php echo $twitter['title'] ? '' : esc_attr( $twitter_printer->get_title_content() ); ?>"
											   value="<?php echo esc_attr( $twitter['title'] ); ?>"/>
									</div>
								</div>

								<div class="wds-table-fields wds-table-fields-stacked">
									<div class="label">
										<label for="twitter-description" class="wds-label"><?php esc_html_e( 'Description', 'wds' ); ?></label>
									</div>
									<div class="fields">
										<textarea name="wds-twitter[description]"
												  placeholder="<?php echo $twitter['description'] ? '' : esc_attr( $twitter_printer->get_description_content() ); ?>"
												  id="twitter-description"><?php echo esc_textarea( $twitter['description'] ); ?></textarea>
									</div>
								</div>
							</div>
						</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<?php
		$resolver->stop_simulation();
	?>
</div>