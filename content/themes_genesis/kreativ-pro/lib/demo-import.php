<?php
/**
 * Kreativ Pro.
 *
 * This file adds required config for One Click Demo Import plugin to use with Kreativ Pro Theme.
 *
 * @package Kreativ
 * @author  ThemeSquare
 * @license GPL-2.0+
 * @link    http://themesquare.com/themes/kreativ/
 */

/**
 * Disable Import Plugin Branding
 */
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );


add_filter( 'pt-ocdi/import_files', 'kreativ_demo_import' );
/**
 * Import your demo content, widgets and settings with one click.
 */
function kreativ_demo_import() {
	return array(
		array(
			'import_file_name'             => 'Kreativ Pro',
			'local_import_file'            => trailingslashit( get_stylesheet_directory() ) . '/xml/kreativ-demo.xml',
			'local_import_widget_file'     => trailingslashit( get_stylesheet_directory() ) . '/xml/kreativ-widgets.wie',
			'local_import_customizer_file' => trailingslashit( get_stylesheet_directory() ) . '/xml/kreativ-settings.dat',
			'import_notice'                => __( 'After you import this demo, it is recommended to save permalinks in Settings > Permalinks menu.', 'kreativ-pro' ),
		),
	);
}

add_action( 'pt-ocdi/after_import', 'kreativ_after_import_setup' );
/**
 * Setup front page, posts page and menus after demo content import.
 */
function kreativ_after_import_setup() {

	// Assign menus to their locations.
	$nav_primary = get_term_by( 'name', 'Primary Nav', 'nav_menu' );
	$nav_footer  = get_term_by( 'name', 'Footer Nav', 'nav_menu' );

	set_theme_mod( 'nav_menu_locations',
		array(
			'primary' => $nav_primary->term_id,
			'footer'  => $nav_footer->term_id,
		)
	);

	// Assign front page and posts page (blog page).
	$front_page_id = get_page_by_title( 'Home' );
	$blog_page_id  = get_page_by_title( 'Blog' );

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $front_page_id->ID );
	update_option( 'page_for_posts', $blog_page_id->ID );

	// Set default front page BG images.
	update_option( 'kreativ-image-1', get_stylesheet_directory_uri() . '/images/bg-1.jpg' );

	// Set empty blog description.
	update_option( 'blogdescription', '' );

	// Update WooCommerce Page Layouts.
	$shop_page_id     = get_option( 'woocommerce_shop_page_id' );
	$cart_page_id     = get_option( 'woocommerce_cart_page_id' );
	$checkout_page_id = get_option( 'woocommerce_checkout_page_id' );
	$account_page_id  = get_option( 'woocommerce_myaccount_page_id' );

	if ( $shop_page_id ) {
		update_post_meta( $shop_page_id, '_genesis_layout', 'full-width-content', true );
	}

	if ( $cart_page_id ) {
		update_post_meta( $cart_page_id, '_genesis_layout', 'full-width-content', true );
	}

	if ( $checkout_page_id ) {
		update_post_meta( $checkout_page_id, '_genesis_layout', 'full-width-content', true );
	}

	if ( $account_page_id ) {
		update_post_meta( $account_page_id, '_genesis_layout', 'full-width-content', true );
	}

}
