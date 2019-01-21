<?php
/**
 * Essence Pro.
 *
 * This file adds the header wrapper functions to the Essence Pro Theme.
 *
 * @package Essence
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/essence/
 */

/**
 * Opens the hero image section.
 *
 * @since 1.0.0
 */
function essence_header_hero_start() {

	genesis_markup(
		array(
			'open'    => '<div %s>',
			'context' => 'header-hero',
		)
	);

}

/**
 * Closes the hero image section.
 *
 * @since 1.0.0
 */
function essence_header_hero_end() {

	genesis_markup(
		array(
			'close'   => '</div>',
			'context' => 'header-hero',
		)
	);

}

// Adds attributes for off screen navigation.
add_filter( 'genesis_attr_nav-off-screen', 'genesis_attributes_nav' );

add_action( 'genesis_header', 'essence_header_right_menu', 9 );
/**
 * Adds header-right menu.
 *
 * @since 1.0.0
 */
function essence_header_right_menu() {

	if ( has_nav_menu( 'off-screen' ) ) {
		echo '<div class="off-screen-menu off-screen-content"><div class="off-screen-container"><div class="off-screen-wrapper"><div class="wrap">';
		echo '<button class="toggle-off-screen-menu-area close">X</button>';
		genesis_nav_menu(
			array(
				'theme_location' => 'off-screen',
				'depth'          => 1,
				'fallback_cb'    => false,
			)
		);
		echo '</div></div></div></div>';
		echo '<div class="header-right">';
		echo '<button class="off-screen-item toggle-off-screen-menu-area"><i class="icon ion-md-menu"></i> Menu</button>';
		echo '</div>';
	}

}


add_action( 'genesis_header', 'essence_header_left_widget', 9 );
/**
 * Adds header-right search area to header.
 *
 * @since 1.0.0
 */
function essence_header_left_widget() {

	echo '<div class="header-left">';
	get_search_form();
	echo '</div>';

}

add_filter( 'body_class', 'essence_header_menu_body_class' );
/**
 * Defines the header-menu body class.
 *
 * @since 1.0.0
 *
 * @param array $classes Classes array.
 * @return array $classes Updated class array.
 */
function essence_header_menu_body_class( $classes ) {

	$menu_locations = get_theme_mod( 'nav_menu_locations' );

	if ( ! empty( $menu_locations['primary'] ) ) {
		$classes[] = 'header-menu';
	}

	return $classes;

}

add_filter( 'body_class', 'essence_no_off_screen_menu_body_class' );
/**
 * Defines the no-off-screen-menu body class.
 *
 * @since 1.0.0
 *
 * @param array $classes Classes array.
 * @return array $classes Updated class array.
 */
function essence_no_off_screen_menu_body_class( $classes ) {

	if ( ! has_nav_menu( 'off-screen' ) ) {
		$classes[] = 'no-off-screen-menu';
	}

	return $classes;

}

add_filter( 'genesis_customizer_theme_settings_config', 'genesis_sample_remove_customizer_settings' );
/**
 * Removes output of genesis header settings in the Customizer.
 *
 * @since 1.0.0
 *
 * @param array $config Original Customizer items.
 * @return array Filtered Customizer items.
 */
function genesis_sample_remove_customizer_settings( $config ) {

	unset( $config['genesis']['sections']['genesis_header'] );
	return $config;

}

/**
 * Modifies the default CSS output for custom-header.
 *
 * @since 1.0.0
 */
function essence_header_style() {

	$output   = '';
	$bg_image = '';

	$is_woocommerce_shop_or_product = class_exists( 'WooCommerce' ) && ( is_post_type_archive( 'product' ) || is_singular( 'product' ) );
	$is_woocommerce_archive         = class_exists( 'WooCommerce' ) && ( is_product_category() || is_product_tag() );

	if ( has_post_thumbnail() && is_singular() && ! is_singular( 'product' ) ) {
		$bg_image = genesis_get_image(
			array(
				'format' => 'url',
				'size'   => 'header-hero',
			)
		);
	} elseif ( $is_woocommerce_shop_or_product || $is_woocommerce_archive ) {
		$bg_image = genesis_get_image(
			array(
				'format'  => 'url',
				'size'    => 'header-hero',
				'post_id' => wc_get_page_id( 'shop' ),
			)
		);
	}

	if ( ! $bg_image ) {
		$bg_image = get_header_image();
	}

	if ( $bg_image ) {
		$output = '<style type="text/css">.header-hero { background-image: linear-gradient(0deg, rgba(0,0,0,0.5) 50%, rgba(0,0,0,0.85) 100%), url(' . esc_url( $bg_image ) . '); }</style>';
	}

	echo $output;

}
