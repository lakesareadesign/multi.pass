<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'cafe', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'cafe' ) );

//* Add Image Upload and Color Selection to WordPress Theme Customizer
require_once( get_stylesheet_directory() . '/lib/customize.php' );

//* Include Section Image and Color CSS
include_once( get_stylesheet_directory() . '/lib/output.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Cafe Pro Theme', 'cafe' ) );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/cafe/' );
define( 'CHILD_THEME_VERSION', '1.0.1' );

//* Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'cafe_enqueue_scripts_styles' );
function cafe_enqueue_scripts_styles() {

	wp_enqueue_script( 'global-script', get_bloginfo( 'stylesheet_directory' ) . '/js/global.js', array( 'jquery' ), '1.0.0' );
	wp_enqueue_script( 'localScroll', get_stylesheet_directory_uri() . '/js/jquery.localScroll.min.js', array( 'scrollTo' ), '1.2.8b', true );
	wp_enqueue_script( 'scrollTo', get_stylesheet_directory_uri() . '/js/jquery.scrollTo.min.js', array( 'jquery' ), '1.4.5-beta', true );

	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Dosis:400,600|Crimson+Text:400,400italic,700', array(), CHILD_THEME_VERSION );

}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add support for footer menu
add_theme_support ( 'genesis-menus' , array ( 'primary' => 'Primary Navigation Menu', 'secondary' => 'Secondary Navigation Menu', 'footer' => 'Footer Navigation Menu' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'flex-height'     => true,
	'flex-width'      => true,
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'height'          => 140,
	'width'           => 350,
) );

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Unregister layout settings
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Unregister the header right widget area
unregister_sidebar( 'header-right' );

//* Unregister secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//* Remove output of primary navigation right extras
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

//* Reposition the secondary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_before_header', 'genesis_do_subnav', 11 );

//* Hook menu in footer
add_action( 'genesis_footer', 'rainmaker_footer_menu', 7 );
function rainmaker_footer_menu() {

	printf( '<nav %s>', genesis_attr( 'nav-footer' ) );

	wp_nav_menu( array(
		'theme_location' => 'footer',
		'container'      => false,
		'depth'          => 1,
		'fallback_cb'    => false,
		'menu_class'     => 'genesis-nav-menu',		
		
	) );
	
	echo '</nav>';

}

//* Hook before header widget area above header
add_action( 'genesis_before_header', 'cafe_before_header' );
function cafe_before_header() {

	genesis_widget_area( 'before-header', array(
		'before' => '<div class="before-header widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

}

//* Reposition the post info
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
add_action( 'genesis_entry_header', 'genesis_post_info', 5 );

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'cafe_author_box_gravatar' );
function cafe_author_box_gravatar( $size ) {

	return 180;

}

//* Modify the size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'cafe_comments_gravatar' );
function cafe_comments_gravatar( $args ) {

	$args['avatar_size'] = 96;

	return $args;

}

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'cafe_remove_comment_form_allowed_tags' );
function cafe_remove_comment_form_allowed_tags( $defaults ) {

	$defaults['comment_notes_after'] = '';
	return $defaults;

}

//* Customize the site footer
add_filter( 'genesis_footer_output', 'filter_custom_footer' );
function filter_custom_footer( $output ) {

	$output = sprintf( '<p>%s<span class="dashicons dashicons-heart"></span>%s<a href="http://www.studiopress.com/">%s</a></p>',  __( 'Handcrafted with ', 'filter' ), __( ' on the', 'filter' ), __( ' Genesis Framework', 'filter' ) );
	return $output;

}

//* Add Site Title to Primary Nav
add_filter( 'genesis_nav_items', 'cafe_nav_site_title', 10, 2 );
add_filter( 'wp_nav_menu_items', 'cafe_nav_site_title', 10, 2 );
function cafe_nav_site_title($menu, $args) {

	$args = (array)$args;
	if ( 'primary' !== $args['theme_location']  )
		return $menu;
	$output = sprintf( '<li class="small-site-title"><a href="%s">%s</a></li>', trailingslashit( home_url() ), get_bloginfo( 'name' ) );
	return $output . $menu;

}

//* Setup widget counts
function cafe_count_widgets( $id ) {
	global $sidebars_widgets;

	if ( isset( $sidebars_widgets[ $id ] ) ) {
		return count( $sidebars_widgets[ $id ] );
	}

}

function cafe_widget_area_class( $id ) {
	$count = cafe_count_widgets( $id );

	$class = '';

	if( $count == 1 || $count < 9 ) {

		$classes = array(
			'zero',
			'one',
			'two',
			'three',
			'four',
			'five',
			'six',
			'seven',
			'eight',
		);

		$class = $classes[ $count ] . '-widget';
		$class = $count == 1 ? $class : $class . 's';

		return $class;

	} else {

		$class = 'widget-thirds';
		
		return $class;

	}

}

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'before-header',
	'name'        => __( 'Before Header', 'cafe' ),
	'description' => __( 'This is the section before the header.', 'cafe' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-1',
	'name'        => __( 'Front Page 1', 'cafe' ),
	'description' => __( 'This is the Front Page 1 section.', 'cafe' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-2',
	'name'        => __( 'Front Page 2', 'cafe' ),
	'description' => __( 'This is the Front Page 2 section.', 'cafe' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-3',
	'name'        => __( 'Front Page 3', 'cafe' ),
	'description' => __( 'This is the Front Page 3 section.', 'cafe' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-4',
	'name'        => __( 'Front Page 4', 'cafe' ),
	'description' => __( 'This is the Front Page 4 section.', 'cafe' ),
) );
