<?php

/**
 * @since 1.0
 * @class FLPostNavigationModule
 */
class FLPostNavigationModule extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(array(
			'name'          	=> __( 'Post Navigation', 'fl-theme-builder' ),
			'description'   	=> __( 'Displays the next / previous post navigation links.', 'fl-theme-builder' ),
			'category'      	=> __( 'Post Modules', 'fl-theme-builder' ),
			'partial_refresh'	=> true,
			'dir'               => FL_THEME_BUILDER_DIR . 'modules/fl-post-navigation/',
			'url'               => FL_THEME_BUILDER_URL . 'modules/fl-post-navigation/',
			'enabled'           => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
		));
	}
}

FLBuilder::register_module( 'FLPostNavigationModule', array() );
