<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'mpp', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'mpp' ) );

//* Add custom site initial field to Theme Customizer
add_action( 'customize_register', 'mpp_customizer' );
function mpp_customizer(){

	require_once( get_stylesheet_directory() . '/lib/customize.php' );
	
}

//* Include custom site initial CSS output
include_once( get_stylesheet_directory() . '/lib/output.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Modern Portfolio Pro Theme', 'mpp' ) );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/modern-portfolio/' );
define( 'CHILD_THEME_VERSION', '2.1' );

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Enqueue Scripts
add_action( 'wp_enqueue_scripts', 'mpp_load_scripts' );
function mpp_load_scripts() {

	wp_enqueue_script( 'mpp-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );

	wp_enqueue_style( 'dashicons' );

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato:300,400|Merriweather:400,300', array(), CHILD_THEME_VERSION );
	
}

//* Add new image sizes
add_image_size( 'blog', 340, 140, TRUE );
add_image_size( 'portfolio', 340, 230, TRUE );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'header_image'    => '',
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'height'          => 90,
	'width'           => 300,
) );

//* Add support for additional color style options
add_theme_support( 'genesis-style-selector', array(
	'modern-portfolio-pro-blue'   => __( 'Modern Portfolio Pro Blue', 'mpp' ),
	'modern-portfolio-pro-orange' => __( 'Modern Portfolio Pro Orange', 'mpp' ),
	'modern-portfolio-pro-red'    => __( 'Modern Portfolio Pro Red', 'mpp' ),
	'modern-portfolio-pro-purple' => __( 'Modern Portfolio Pro Purple', 'mpp' ),
) );

//* Unregister layout settings
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Unregister secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//* Reposition the secondary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 7 );

//* Reduce the secondary navigation menu to one level depth
add_filter( 'wp_nav_menu_args', 'mpp_secondary_menu_args' );
function mpp_secondary_menu_args( $args ){

	if( 'secondary' != $args['theme_location'] )
	return $args;

	$args['depth'] = 1;
	return $args;

}

//* Modify the size of the Gravatar in author box
add_filter( 'genesis_author_box_gravatar_size', 'mpp_author_box_gravatar_size' );
function mpp_author_box_gravatar_size( $size ) {

	return 80;
	
}

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'mpp_remove_comment_form_allowed_tags' );
function mpp_remove_comment_form_allowed_tags( $defaults ) {
	
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

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'home-about',
	'name'        => __( 'Home - About','mpp' ),
	'description' => __( 'This is the about section of the homepage.','mpp' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-portfolio',
	'name'        => __( 'Home - Portfolio','mpp' ),
	'description' => __( 'This is the portfolio section of the homepage.','mpp' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-services',
	'name'        => __( 'Home - Services','mpp' ),
	'description' => __( 'This is the Services section of the homepage.','mpp' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-blog',
	'name'        => __( 'Home - Blog','mpp' ),
	'description' => __( 'This is the Blog section of the homepage.','mpp' ),
) );
