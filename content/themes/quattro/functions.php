<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Quattro Theme' );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/quattro' );
define( 'CHILD_THEME_VERSION', '1.0.1' );

//* Load Google fonts
add_action( 'wp_enqueue_scripts', 'quattro_load_google_fonts' );
function quattro_load_google_fonts() {
    wp_enqueue_style( 
    	'google-fonts', 
    	'//fonts.googleapis.com/css?family=Quattrocento|Quattrocento+Sans', 
    	array(), 
    	CHILD_THEME_VERSION 
    );
}

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Create additional color style options
add_theme_support( 'genesis-style-selector', array(
	'quattro-blue'		=> 'Blue',
	'quattro-brown'		=> 'Brown',
) );

//* Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array( 
	'header', 
	'nav', 
	'subnav', 
	'inner', 
	'footer-widgets', 
	'footer' 
) );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'header-selector' => '#title-area a',
	'header-text'     => false,
	'height'          => 100,
	'width'           => 400,
) );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Content wrap
add_action( 'genesis_before_header', 'content_opening_wrap' );
add_action( 'genesis_after_footer', 'content_closing_wrap' );

function content_opening_wrap() {
	echo '<div class="inner">';
}

function content_closing_wrap() {
	echo '</div>';
}

//* Modify the read more link
add_filter( 'the_content_more_link', 'quattro_read_more_link' );
function quattro_read_more_link() {
    return '<a class="more-link" href="' . get_permalink() . '">[Continue Reading...]</a>';
}

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'quattro_author_box_gravatar_size' );
function quattro_author_box_gravatar_size( $size ) {
    return '80';
}

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Reposition the footer
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );
add_action( 'genesis_after', 'genesis_footer_markup_open', 5 );
add_action( 'genesis_after', 'genesis_do_footer');
add_action( 'genesis_after', 'genesis_footer_markup_close', 15 );