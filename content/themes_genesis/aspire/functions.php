<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'aspire', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'aspire' ) );

//* Add Image upload and Color select to WordPress Theme Customizer
require_once( get_stylesheet_directory() . '/lib/customize.php' );

//* Include Customizer CSS
include_once( get_stylesheet_directory() . '/lib/output.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Aspire Pro' );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/aspire/' );
define( 'CHILD_THEME_VERSION', '1.0.0' );

//* Enqueue Scripts
add_action( 'wp_enqueue_scripts', 'aspire_enqueue_scripts_styles' );
function aspire_enqueue_scripts_styles() {

	wp_enqueue_script( 'aspire-fadeup-script', get_stylesheet_directory_uri() . '/js/fadeup.js', array( 'jquery' ), '1.0.0', true );
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'dashicons' );
	wp_enqueue_script( 'aspire-global', get_bloginfo( 'stylesheet_directory' ) . '/js/global.js', array( 'jquery' ), '1.0.0' );

}

//* Add Font Awesome Support
add_action( 'wp_enqueue_scripts', 'enqueue_font_awesome' );
function enqueue_font_awesome() {
	wp_enqueue_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', array(), '4.5.0' );
}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add accessibility support
add_theme_support( 'genesis-accessibility', array( 'drop-down-menu', 'search-form', 'skip-links' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'flex-height'     => true,
	'width'           => 300,
	'height'          => 60,
	'header-selector' => '.site-title a',
	'header-text'     => false,
) );

//* Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'nav',
	'subnav',
	'footer-widgets',
	'footer',
) );

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Add new image sizes
add_image_size( 'featured-content-lg', 1200, 600, TRUE );
add_image_size( 'featured-content-sm', 600, 400, TRUE );
add_image_size( 'featured-content-th', 600, 600, TRUE );

//* Unregister layout settings
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Unregister secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//* Unregister the header right widget area
unregister_sidebar( 'header-right' );

//* Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

//* Remove output of primary navigation right extras
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

//* Reposition the secondary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_header', 'genesis_do_subnav', 5 );

//* Add featured image above the entry content
add_action( 'genesis_entry_header', 'aspire_featured_photo', 5 );
function aspire_featured_photo() {

	if ( is_attachment() || ! genesis_get_option( 'content_archive_thumbnail' ) )
		return;

	if ( is_singular() && $image = genesis_get_image( array( 'format' => 'url', 'size' => genesis_get_option( 'image_size' ) ) ) ) {
		printf( '<div class="featured-image"><img src="%s" alt="%s" class="entry-image"/></div>', $image, the_title_attribute( 'echo=0' ) );
	}

}

/*//* Add support for 1-column footer widget area
add_theme_support( 'genesis-footer-widgets', 1 );*/

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Add support for footer menu
add_theme_support ( 'genesis-menus' , array ( 'primary' => 'Primary Navigation Menu', 'secondary' => 'Secondary Navigation Menu', 'footer' => 'Footer Navigation Menu' ) );

//* Hook menu in footer
add_action( 'genesis_footer', 'aspire_footer_menu', 7 );
function aspire_footer_menu() {
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

// Enable shortcodes in widgets
add_filter('widget_text', 'do_shortcode');

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'front-page-1',
	'name'        => __( 'Front Page 1', 'aspire' ),
	'description' => __( 'This is the front page 1 section.', 'aspire' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-2',
	'name'        => __( 'Front Page 2', 'aspire' ),
	'description' => __( 'This is the front page 2 section.', 'aspire' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-3',
	'name'        => __( 'Front Page 3', 'aspire' ),
	'description' => __( 'This is the front page 3 section.', 'aspire' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-4',
	'name'        => __( 'Front Page 4', 'aspire' ),
	'description' => __( 'This is the front page 4 section.', 'aspire' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-mid-left',
	'name'        => __( 'Home Mid Left Sidebar', 'aspire' ),
	'description' => __( 'This is the Home Mid Left section.', 'aspire' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-mid-right',
	'name'        => __( 'Home Mid Right Sidebar', 'aspire' ),
	'description' => __( 'This is the Home Mid Right section.', 'aspire' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-mid-wide',
	'name'        => __( 'Home Mid Wide Sidebar', 'aspire' ),
	'description' => __( 'This is the Home Mid Wide section.', 'aspire' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-5',
	'name'        => __( 'Front Page 5', 'aspire' ),
	'description' => __( 'This is the front page 5 section.', 'aspire' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-6',
	'name'        => __( 'Front Page 6', 'aspire' ),
	'description' => __( 'This is the front page 6 section.', 'aspire' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-7',
	'name'        => __( 'Front Page 7', 'aspire' ),
	'description' => __( 'This is the front page 7 section.', 'aspire' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-8',
	'name'        => __( 'Front Page 8', 'aspire' ),
	'description' => __( 'This is the front page 8 section.', 'aspire' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-9',
	'name'        => __( 'Front Page 9', 'aspire' ),
	'description' => __( 'This is the front page 9 section.', 'aspire' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-10',
	'name'        => __( 'Front Page 10', 'aspire' ),
	'description' => __( 'This is the front page 10 section.', 'aspire' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-11',
	'name'        => __( 'Front Page 11', 'aspire' ),
	'description' => __( 'This is the front page 11 section.', 'aspire' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-12',
	'name'        => __( 'Front Page 12', 'aspire' ),
	'description' => __( 'This is the front page 12 section.', 'aspire' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-13',
	'name'        => __( 'Front Page 13', 'aspire' ),
	'description' => __( 'This is the front page 13 section.', 'aspire' ),
) );