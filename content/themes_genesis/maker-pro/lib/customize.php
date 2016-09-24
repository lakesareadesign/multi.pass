<?php

/**
 * Customizations
 *
 * @package Maker Pro
 * @author  JT Grauke
 * @link    http://my.studiopress.com/themes/maker
 * @license GPL2-0+
 */

/**
 * Get default primary color for Customizer.
 *
 * Abstracted here since at least two functions use it.
 *
 * @since 1.0.0
 *
 * @return string Hex color code for primary color.
 */

function maker_customizer_get_default_primary_color() {
	return '#57e5ae';
}

add_action( 'customize_register', 'maker_customizer_register' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function maker_customizer_register() {

	global $wp_customize;

	$wp_customize->add_setting(
		'maker_primary_color',
		array(
			'default'           => maker_customizer_get_default_primary_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'maker_primary_color',
			array(
				'description' => __( 'Set the default color.', 'maker' ),
			    'label'       => __( 'Primary Color', 'maker' ),
			    'section'     => 'colors',
			    'settings'    => 'maker_primary_color',
			)
		)
	);

}
