<?php
/** Start the engine */
include_once( get_template_directory() . '/lib/init.php' );

/** Child theme (do not remove) */
define( 'CHILD_THEME_NAME', 'Mindstream Theme' );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/mindstream' );

/** Add Viewport meta tag for mobile browsers */
add_action( 'genesis_meta', 'mindstream_add_viewport_meta_tag' );
function mindstream_add_viewport_meta_tag() {
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>';
}

/** Unregister content/sidebar/sidebar layout setting */
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

/** Unregister secondary sidebar */
unregister_sidebar( 'sidebar-alt' );

/** Add support for structural wraps */
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'inner', 'footer-widgets', 'footer' ) );

/** Add support for custom background */
add_theme_support( 'custom-background' );

/** Add support for post formats */
add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );
add_theme_support( 'genesis-post-format-images' );

add_action( 'genesis_before_post', 'mindstream_remove_elements' );
/**
 * If post has post format, remove the title, post info, and post meta.
 * If post does not have post format, then it is a default post. Add
 * title, post info, and post meta back.
 *
 * @since 1.0
 */
function mindstream_remove_elements() {
	
	// Remove if post has format
	if ( get_post_format() ) {
		remove_action( 'genesis_post_title', 'genesis_do_post_title' );
		remove_action( 'genesis_before_post_content', 'genesis_post_info' );
		remove_action( 'genesis_after_post_content', 'genesis_post_meta' );
	}
	// Add back, as post has no format
	else {
		add_action( 'genesis_post_title', 'genesis_do_post_title' );
		add_action( 'genesis_before_post_content', 'genesis_post_info' );
		add_action( 'genesis_after_post_content', 'genesis_post_meta' );
	}
	
}

/** Customize the post info function */
add_filter( 'genesis_post_info', 'post_info_filter' );
function post_info_filter($post_info) {
if (!is_page()) {
    $post_info = 'Posted on [post_date] &middot; [post_comments] [post_edit]';
    return $post_info;
}}

/** Customize the post meta function */
add_filter( 'genesis_post_meta', 'post_meta_filter' );
function post_meta_filter($post_meta) {
if (!is_page()) {
    $post_meta = '[post_categories before="Filed Under: "] &middot; [post_tags before="Tagged: "]';
    return $post_meta;
}}

/** Add support for 3-column footer widgets */
add_theme_support( 'genesis-footer-widgets', 3 );