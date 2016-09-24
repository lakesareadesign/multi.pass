<?php
/**
 * This file adds all the functions to the Elegance theme.
 *
 * @package      Elegance
 * @link         http://stephaniehellwig.com/themes
 * @author       Stephanie Hellwig
 * @copyright    Copyright (c) 2016, Stephanie Hellwig, Released 06/04/2016
 * @license      GPL-2.0+
 */
 
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Add theme plugins to dashboard
require_once( get_stylesheet_directory() . '/lib/class-tgm-plugin-activation.php' );
require_once( get_stylesheet_directory() . '/lib/theme-require-plugins.php' );

//* Add Color selections to Elegance Theme Customizer
require_once( get_stylesheet_directory() . '/lib/customize.php' );

//* Include Customizer CSS
include_once( get_stylesheet_directory() . '/lib/output.php' );

//* Add Color Selection & Newsletter image upload to WordPress Theme Customizer
require_once( get_stylesheet_directory() . '/lib/customize.php' );
require_once( get_stylesheet_directory() . '/lib/cta-customize.php' );

// Enqueue Scripts and Styles
add_action( 'wp_enqueue_scripts', 'elegance_enqueue_scripts_styles' );
function elegance_enqueue_scripts_styles() {

	wp_enqueue_style( 'dashicons' );

	wp_enqueue_script( 'responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0', true );
	$output = array(
		'mainMenu' => __( 'Menu', 'elegance' ),
		'subMenu'  => __( 'Menu', 'elegance' ),
	);
	wp_localize_script( 'responsive-menu', 'ResponsiveMenuL10n', $output );

}

add_action( 'wp_enqueue_scripts', 'elegance_google_fonts' );
function elegance_google_fonts() {

	wp_enqueue_style( 'google-font', '//fonts.googleapis.com/css?family=Rouge+Script|Monsieur+La+Doulaise|Miss+Fajardose|Josefin+Sans|Quattrocento', array() );

}

//* Add HTML5 markup structure
add_theme_support( 'html5' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add new image sizes
add_image_size( 'home-bottom', 400, 300, TRUE );
add_image_size( 'portfolio', 300, 200, TRUE );
add_image_size( 'home-middle', 600, 600, TRUE );
add_image_size( 'blog-image', 800, 500, TRUE );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'width'           => 700,
	'height'          => 270,
	'header-selector' => '.site-title a',
	'header-text'     => false
) );

//* Add Genesis Responsive Slider Defaults
add_filter( 'genesis_responsive_slider_settings_defaults', 'elegance_responsive_slider_defaults' );
function elegance_responsive_slider_defaults( $defaults ) {
    
    $defaults = array(
    	'slideshow_height' => 800,
    	'slideshow_width'  => 1200
    );

    return $defaults;

}

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Remove footer widgets from home page only
add_action( 'genesis_before', 'elegance_footer_widgets' );
function elegance_footer_widgets() {
	
	if( ! is_front_page() )
		return;

	remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );

}

//* Hooks widget area above header
add_action( 'genesis_before', 'elegance_widget_above_header' ); 
function elegance_widget_above_header() {

    genesis_widget_area( 'widget-above-header', array(
		'before' => '<div class="widget-above-header widget-area"><div class="wrap">',
		'after'  => '</div></div>',
    ) );

}

//* Customize the post info function
add_filter( 'genesis_post_info', 'elegance_post_info_filter' );
function elegance_post_info_filter($post_info) {
	
	if ( ! is_page() ) {
	    
	    $post_info = '[post_date] [post_edit]';
	    return $post_info;
	
	}

}

//* Customize the post meta function
add_filter( 'genesis_post_meta', 'elegance_post_meta_filter' );
function elegance_post_meta_filter($post_meta) {
	
	if ( ! is_page() ) {
	    
	    $post_meta = '[post_categories]';
	    return $post_meta;

	}

}

// Move image above post title in Genesis Framework 2.0
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'genesis_do_post_image', 8 );

//* Hooks after-entry widget area to single posts
add_action( 'genesis_entry_footer', 'elegance_after_post' );
function elegance_after_post() {

    if ( ! is_singular( 'post' ) )
    	return;

    genesis_widget_area( 'after-entry', array(
		'before' => '<div class="after-entry widget-area"><div class="wrap">',
		'after'  => '</div></div>',
    ) );

}

//* Customize the credits 
add_filter( 'genesis_footer_creds_text', 'elegance_custom_footer_creds_text' );
function elegance_custom_footer_creds_text() {

	$custom_footer_text = get_theme_mod( 'elegance_footer_text' );

	if ( '' === $custom_footer_text || false === $custom_footer_text ) {
    
		echo '<div class="creds"><p>';
		echo 'Copyright &copy; ';
		echo date( 'Y' );
		echo ' &middot; <a target="_blank" href="http://stephaniehellwig.com/themes">elegance theme</a> by <a target="_blank" href="http://www.stephaniehellwig.com">StephanieHellwig.com</a>';
		echo '</p></div>';

	} else {

		echo '<div class="creds"><p>';
		echo $custom_footer_text;
		echo '</p></div>';

	}

}

//* Reposition the footer
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );
add_action( 'genesis_after', 'genesis_footer_markup_open', 11 );
add_action( 'genesis_after', 'genesis_do_footer', 12 );
add_action( 'genesis_after', 'genesis_footer_markup_close', 13 );

//* Rename Menus
add_theme_support( 'genesis-menus' , array( 
	'primary'   => 'Left Menu',
	'secondary' => 'Right Menu'
) );

//* Add header widget areas
genesis_register_sidebar( array(
    'id'          => 'header-left',
    'name'        => __( 'Header Left', 'elegance' ),
    'description' => __( 'Header left widget area', 'elegance' ),
) );

add_action( 'genesis_after_header', 'elegance_left_header_widget', 11 );
function elegance_left_header_widget() {

	if( is_active_sidebar( 'header-left' ) ) {
	
	 	genesis_widget_area( 'header-left', array(
	    	'before' => '<div class="header-left widget-area">',
	    	'after'	 => '</div>',
		) ); 
  	
  	}

}

//* Remove the header right widget area
unregister_sidebar( 'header-right' );

genesis_register_sidebar( array(
	'id'          => 'right-header',
	'name'        => __( 'Right Header', 'elegance' ),
	'description' => __( 'Header Right widget area', 'elegance' ),
) );

add_action( 'genesis_after_header', 'elegance_right_header_widget', 11 );
function elegance_right_header_widget() {
	
	if( is_active_sidebar( 'right-header' ) ) {
	 	
	 	genesis_widget_area( 'right-header', array(
			'before' => '<div class="right-header widget-area">',
			'after'	 => '</div>',
		) ); 

	}

}

//* Hooks widget area before content
add_action( 'genesis_before_footer', 'elegance_cta_widget', 2 );
function elegance_cta_widget() {
	
	if ( is_front_page() ) {
		return;
	} else {
	    genesis_widget_area( 'cta-widget', array(
			'before' => '<div class="cta-widget widget-area"><div class="wrap">',
			'after'  => '</div></div>',
	    ) );
	}
}

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'widget-above-header',
	'name'        => __( 'Above Header', 'elegance' ),
	'description' => __( 'This is the section above the header.', 'elegance' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-top',
	'name'        => __( 'Home - Top', 'elegance' ),
	'description' => __( 'This is the top section of the homepage where the demo slider is located.', 'elegance' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-middle-left',
	'name'        => __( 'Home - Middle Left', 'elegance' ),
	'description' => __( 'This is the bottom left section of the homepage.', 'elegance' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-middle-right',
	'name'        => __( 'Home - Middle Right', 'elegance' ),
	'description' => __( 'This is the bottom right section of the homepage.', 'elegance' ),
) );
genesis_register_sidebar( array(
	'id'		  => 'cta-widget',
	'name'		  => __( 'CTA Widget', 'elegance	' ),
	'description' => __( 'This is the widget area above the header', 'elegance' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-bottom',
	'name'        => __( 'Home - Bottom', 'elegance' ),
	'description' => __( 'This is the bottom section of the homepage.', 'elegance' ),
) );
genesis_register_sidebar( array(
	'id'          => 'after-entry',
	'name'        => __( 'After Entry', 'elegance' ),
	'description' => __( 'This is the after entry section.', 'elegance' ),
) );
