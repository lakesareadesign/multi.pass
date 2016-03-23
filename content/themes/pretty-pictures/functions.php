<?php
/** Start the engine */
include_once( get_template_directory() . '/lib/init.php' );

load_child_theme_textdomain( 'pictures', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'pictures' ) );

/** Child theme (do not remove) */
define( 'CHILD_THEME_NAME', __( 'Pretty Pictures Theme', 'pictures' ) );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/pretty-pictures' );

/** Add Viewport meta tag for mobile browsers */
add_action( 'genesis_meta', 'pp_add_viewport_meta_tag' );
function pp_add_viewport_meta_tag() {
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>';
}

/** Register default layout setting */
genesis_set_default_layout( 'full-width-content' );

/** Unregister layouts */
genesis_unregister_layout( 'content-sidebar' );
genesis_unregister_layout( 'sidebar-content' );
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

/** Unregister sidebars */
unregister_sidebar( 'sidebar' );
unregister_sidebar( 'sidebar-alt' );

/** Add support for structural wraps */
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'nav',
	'subnav',
	'inner',
	'footer-widgets',
	'footer'
) );

/** Add support for custom header */
add_theme_support( 'custom-header', array(
	'default-image'		=> get_stylesheet_directory_uri() . '/images/header.jpg',
	'flex-height'		=> true,
	'flex-width'		=> true,
	'header-text'		=> false,
	'height'			=> 550,
	'width'				=> 1600
) );

/** Reposition the primary navigation */
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before_header', 'genesis_do_nav' );

/** Unregister secondary navigation menu */
add_theme_support( 'genesis-menus', array( 'primary' => __( 'Primary Navigation Menu', 'pictures' ) ) );

/** Add support for post formats */
add_theme_support( 'post-formats', array(
    'gallery',
    'quote'
) );

/** Remove elements for post formats */
add_action( 'genesis_before_post', 'pp_remove_elements' );
function pp_remove_elements() {

	// Remove if post has quote format
	if ( has_post_format( 'quote' ) ) {
		remove_action( 'genesis_before_post_content', 'genesis_post_info' );
		remove_action( 'genesis_post_title', 'genesis_do_post_title' );
		remove_action( 'genesis_after_post_content', 'genesis_post_meta' );
	}

	// Remove if post has gallery format
	elseif ( has_post_format( 'gallery' ) ) {
		add_action( 'genesis_post_title', 'genesis_do_post_title' );
		add_action( 'genesis_after_post_content', 'genesis_post_meta' );
	}

	// Add back, as post has no format
	else {
		add_action( 'genesis_before_post_content', 'genesis_post_info' );
		add_action( 'genesis_post_title', 'genesis_do_post_title' );
		add_action( 'genesis_after_post_content', 'genesis_post_meta' );
	}

}

global $current_class;
$current_class = 'odd';

/** Add odd/even post class */
add_filter ( 'post_class' , 'pp_alt_post_class' );
function pp_alt_post_class ( $classes ) {
	global $current_class;
	$classes[] = $current_class;
	$current_class = ( $current_class == 'odd' ) ? 'even' : 'odd';
	return $classes;
}

/** Customize the post info function */
add_filter( 'genesis_post_info', 'pp_post_info_filter' );
function pp_post_info_filter( $post_info ) {

    return __( 'Posted on', 'pictures' ) . ' [post_date] [post_comments] [post_edit]';

}

/** Customize the post meta function */
add_filter( 'genesis_post_meta', 'pp_post_meta_filter' );
function pp_post_meta_filter($post_meta) {

    return __( '&copy; Copyright', 'pictures' ) . ' [post_author_posts_link]';

}

/** Modify the size of the Gravatar in the author box */ 
add_filter( 'genesis_author_box_gravatar_size', 'pp_author_box_gravatar_size' );
function pp_author_box_gravatar_size( $size ) {
    return '76';
}

/** Load Backstretch script and prepare images for loading */
add_action( 'wp_enqueue_scripts', 'pp_enqueue_scripts' );
function pp_enqueue_scripts() {

	wp_enqueue_script( 'pp-backstretch', get_bloginfo( 'stylesheet_directory' ) . '/js/backstretch.js', array( 'jquery' ), '1.0.0', true );
	wp_enqueue_script( 'pp-backstretch-set', get_bloginfo('stylesheet_directory').'/js/backstretch-set.js' , array( 'jquery', 'pp-backstretch' ), '1.0.0', true );
	
}

add_action( 'wp_enqueue_scripts', 'pp_set_background_image' );
function pp_set_background_image() {
	
	$image = array( 'src' => get_header_image() );

	wp_localize_script( 'pp-backstretch-set', 'BackStretchImg', $image );

}