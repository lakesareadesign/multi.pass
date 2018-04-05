<?php
/**
 *
 * Template Name: Landing
 *
 * @package Pretty Chic
 * @author  Lindsey Riel
 * @link    https://prettydarncute.com
 */

// Add landing page body class to the head.
add_filter( 'body_class', 'genesis_prettychic_add_body_class' );
function genesis_prettychic_add_body_class( $classes ) {

	$classes[] = 'landing-page';

	return $classes;

}

// Remove Skip Links.
remove_action ( 'genesis_before_header', 'genesis_skip_links', 5 );

// Dequeue Skip Links Script.
add_action( 'wp_enqueue_scripts', 'genesis_prettychic_dequeue_skip_links' );
function genesis_prettychic_dequeue_skip_links() {
	wp_dequeue_script( 'skip-links' );
}

// Force full width content layout.
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Remove site header elements.
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
remove_action( 'genesis_after_header', 'pdcd_adspace_widget');
remove_action( 'genesis_after_content', 'pdcd_every_page_widget');
remove_action('genesis_footer', 'sp_custom_footer');


// Remove navigation.
remove_theme_support( 'genesis-menus' );

// Remove breadcrumbs.
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

// Remove footer widgets.
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );
remove_action( 'genesis_after_footer', 'instagram', 2);

// Run the Genesis loop.
genesis();
