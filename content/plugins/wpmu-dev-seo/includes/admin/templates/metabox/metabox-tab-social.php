<?php
	$post = empty( $post ) ? null : $post;
	$og_setting_enabled = empty( $og_setting_enabled ) ? false : $og_setting_enabled;
	$og_post_type_enabled = empty( $og_post_type_enabled ) ? false : $og_post_type_enabled;
	$twitter_setting_enabled = empty( $twitter_setting_enabled ) ? false : $twitter_setting_enabled;
	$twitter_post_type_enabled = empty( $twitter_post_type_enabled ) ? false : $twitter_post_type_enabled;

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
		'images'      => false,
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
		<?php
			$this->_render('metabox/metabox-social-meta-tags', array(
				'post'                    => $post,
				'main_title'              => __('OpenGraph', 'wds'),
				'main_description'        => __('OpenGraph is used on many social networks such as Facebook.', 'wds'),
				'field_name'              => 'wds-opengraph',
				'disabled'                => $og_meta_disabled,
				'current_title'           => $og['title'],
				'title_placeholder'       => $og_printer->get_tag_value('title'),
				'current_description'     => $og['description'],
				'description_placeholder' => $og_printer->get_tag_value('description'),
				'images'                  => $og['images'],
				'single_image'            => false
			));
		?>
	<?php endif; ?>

	<?php if ( $twitter_setting_enabled && $twitter_post_type_enabled ) :  ?>
		<?php
			$this->_render('metabox/metabox-social-meta-tags', array(
				'post'                    => $post,
				'main_title'              => __('Twitter', 'wds'),
				'main_description'        => __('These details will be used in Twitter cards.', 'wds'),
				'field_name'              => 'wds-twitter',
				'disabled'                => $twitter_meta_disabled,
				'current_title'           => $twitter['title'],
				'title_placeholder'       => $twitter_printer->get_title_content(),
				'current_description'     => $twitter['description'],
				'description_placeholder' => $twitter_printer->get_description_content(),
				'images'                  => $twitter['images'],
				'single_image'            => true
			));
		?>
	<?php endif; ?>

	<?php
		$resolver->stop_simulation();
	?>
</div>