<?php
/** Start the engine */
include_once( get_template_directory() . '/lib/init.php' );

/** Child theme (do not remove) */
define( 'CHILD_THEME_NAME', 'Mocha Theme' );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/mocha' );

/** Create additional color style options */
add_theme_support( 'genesis-style-selector', array( 'mocha-blue' => 'Blue', 'mocha-green' => 'Green', 'mocha-orange' => 'Orange', 'mocha-pink' => 'Pink' ) );

/** Add Viewport meta tag for mobile browsers */
add_action( 'genesis_meta', 'mocha_add_viewport_meta_tag' );
function mocha_add_viewport_meta_tag() {
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>';
}

/** Register default layout setting */
genesis_set_default_layout( 'sidebar-content-sidebar' );

/** Unregister content/sidebar layout setting */
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

/** Add support for custom background */
add_theme_support( 'custom-background' );

/** Add support for structural wraps */
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'inner', 'footer-widgets', 'footer' ) );

/** Customize the post info function */
add_filter( 'genesis_post_info', 'post_info_filter' );
function post_info_filter($post_info) {
if (!is_page()) {
	$post_info = 'Posted on [post_date] &middot; [post_comments] [post_edit]';
	return $post_info;
}}

/** Add the after post section */
add_action( 'genesis_after_post_content', 'mocha_after_post' );
function mocha_after_post() {
	if ( ! is_singular( 'post' ) )
	return;
		genesis_widget_area( 'after-post', array(
		'before' => '<div class="after-post widget-area">',
   ) );
}

/** Add support for 3-column footer widgets */
add_theme_support( 'genesis-footer-widgets', 3 );

/** Register widget areas */
genesis_register_sidebar( array(
	'id'			=> 'after-post',
	'name'			=> __( 'After Post', 'mocha' ),
	'description'	=> __( 'This is the after post section.', 'mocha' ),
) );