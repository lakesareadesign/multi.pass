<?php
/**
 * Outfitter Pro.
 *
 * This file adds the WooCommerce Customizer additions to the Outfitter Pro Theme.
 *
 * @package Outfitter_Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/outfitter/
 */

/**
 * Gets default cart icon settings for Customizer.
 *
 * @since 1.0.0
 *
 * @return int 1 for true, in order to show the icon.
 */
function outfitter_customizer_get_default_cart_setting() {

	return 1;

}

add_action( 'customize_register', 'outfitter_woocommerce_customizer_register' );
/**
 * Registers settings and controls with the Customizer for WooCommerce.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function outfitter_woocommerce_customizer_register( $wp_customize ) {

	// Adds control for cart option.
	$wp_customize->add_setting( 'outfitter_header_cart', array(
		'default'           => outfitter_customizer_get_default_cart_setting(),
		'sanitize_callback' => 'absint',
	) );

	if ( class_exists( 'WooCommerce' ) && current_theme_supports( 'woocommerce' ) ) {

		// Adds setting for cart option.
		$wp_customize->add_control( 'outfitter_header_cart', array(
			'label'          => __( 'Show Header Cart Icon?', 'outfitter-pro' ),
			'description'    => __( 'Check the box to show a cart icon in the header menu.', 'outfitter-pro' ),
			'section'        => 'outfitter_theme_options',
			'type'           => 'checkbox',
			'theme_supports' => array('woocommerce'),
			'settings'       => 'outfitter_header_cart',
		) );

	}

}
