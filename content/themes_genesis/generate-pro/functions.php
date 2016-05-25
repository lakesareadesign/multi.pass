<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'generate', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'generate' ) );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Generate Pro Theme', 'generate' ) );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/generate/' );
define( 'CHILD_THEME_VERSION', '2.1.1' );

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Enqueue Scripts
add_action( 'wp_enqueue_scripts', 'generate_load_scripts' );
function generate_load_scripts() {

	wp_enqueue_script( 'generate-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );
	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'google-font', '//fonts.googleapis.com/css?family=Source+Sans+Pro:300,600', array(), CHILD_THEME_VERSION );
	
}

//* Add new image sizes
add_image_size( 'blog', 700, 300, TRUE );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'width'           => 360,
	'height'          => 140,
	'header-selector' => '.site-title a',
	'header-text'     => false,
) );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for additional color style options
add_theme_support( 'genesis-style-selector', array(
	'generate-pro-blue'   => __( 'Generate Pro Blue', 'generate' ),
	'generate-pro-green'  => __( 'Generate Pro Green', 'generate' ),
	'generate-pro-orange' => __( 'Generate Pro Orange', 'generate' ),
) );

//* Unregister layout settings
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Unregister secondary sidebar 
unregister_sidebar( 'sidebar-alt' );

//* Remove unused sections from Genesis Customizer
add_action( 'customize_register', 'generate_customize_register', 16 );
function generate_customize_register( $wp_customize ) {

	$wp_customize->remove_control( 'genesis_image_alignment' );
	
}

//* Rename menus
add_theme_support( 'genesis-menus', array( 'primary' => __( 'After Header Menu', 'generate' ), 'secondary' => __( 'Footer Menu', 'generate' ) ) );

//* Reposition the secondary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 7 );

//* Reduce the secondary navigation menu to one level depth
add_filter( 'wp_nav_menu_args', 'generate_secondary_menu_args' );
function generate_secondary_menu_args( $args ){

	if( 'secondary' != $args['theme_location'] )
	return $args;

	$args['depth'] = 1;
	return $args;

}

//* Remove default post image
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );

//* Add featured image above the entry content
add_action( 'genesis_entry_content', 'generate_featured_photo', 8 );
function generate_featured_photo() {
	if ( is_page() || ! genesis_get_option( 'content_archive_thumbnail' ) )
		return;

	if ( $image = genesis_get_image( array( 'format' => 'url', 'size' => genesis_get_option( 'image_size' ) ) ) ) {
		printf( '<div class="featured-image"><img src="%s" alt="%s" class="entry-image"/></div>', $image, the_title_attribute( 'echo=0' ) );
	}
}

//* Reposition the post info
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
add_action( 'genesis_entry_header', 'genesis_post_info', 5 );

//* Hook after home featured widget before the content
add_action( 'genesis_after_header', 'generate_home_featured' );
function generate_home_featured() {

	if ( is_front_page() )
		genesis_widget_area( 'home-featured', array(
			'before' => '<div class="home-featured widget-area"><div class="wrap">',
			'after'  => '</div></div>',
		) );

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
	'id'          => 'home-featured',
	'name'        => __( 'Home Featured', 'generate' ),
	'description' => __( 'Widgets in this section are featured at the top of the homepage.', 'generate' ),
) );
