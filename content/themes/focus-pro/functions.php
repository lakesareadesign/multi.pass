<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'focus', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'focus' ) );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Focus Pro Theme', 'focus' ) );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/focus/' );
define( 'CHILD_THEME_VERSION', '3.1.1' );

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Enqueue Scripts
add_action( 'wp_enqueue_scripts', 'focus_load_scripts' );
function focus_load_scripts() {

	wp_enqueue_script( 'focus-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );
	
	wp_enqueue_style( 'dashicons' );
	
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Economica:700|Lora:400,400italic', array(), CHILD_THEME_VERSION );
	
}

//* Add new featured image sizes
add_image_size( 'home-grid-thumbnail', 317, 120, TRUE );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'header_image'    => '',
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'height'          => 100,
	'width'           => 320,
) );

//* Add support for additional color style options
add_theme_support( 'genesis-style-selector', array(
	'focus-pro-brown' => __( 'Focus Pro Brown', 'focus' ),
	'focus-pro-gray'  => __( 'Focus Pro Gray', 'focus' ),
) );

//* Reposition the primary navigation
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before_header', 'genesis_do_nav' );

//* Reposition the breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
add_action( 'genesis_after_header', 'genesis_do_breadcrumbs' );

//* Customize breadcrumbs display
add_filter( 'genesis_breadcrumb_args', 'focus_breadcrumb_args' );
function focus_breadcrumb_args( $args ) {

	$args['home'] = 'Home';
	$args['sep'] = ' ';
	$args['list_sep'] = ', '; // Genesis 1.5 and later
	$args['prefix'] = '<div class="breadcrumb"><div class="wrap">';
	$args['suffix'] = '</div></div>';
	$args['labels']['prefix'] = '';
	return $args;
	
}

//* Customize the post info function
add_filter( 'genesis_post_info', 'post_info_filter' );
function post_info_filter($post_info) {

	if ( !is_page() ) {
		$post_info = __( 'Posted on', 'focus' ) . ' [post_date] ' . __( 'Written by', 'focus' ) . ' [post_author_posts_link] [post_comments] [post_edit]';
		return $post_info;
	}
	
}

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'focus_author_box_gravatar_size' );
function focus_author_box_gravatar_size( $size ) {

    return '80';
    
}

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'focus_remove_comment_form_allowed_tags' );
function focus_remove_comment_form_allowed_tags( $defaults ) {
	
	$defaults['comment_notes_after'] = '';
	return $defaults;

}

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Relocate after entry widget
remove_action( 'genesis_after_entry', 'genesis_after_entry_widget_area' );
add_action( 'genesis_after_entry', 'genesis_after_entry_widget_area', 5 );
