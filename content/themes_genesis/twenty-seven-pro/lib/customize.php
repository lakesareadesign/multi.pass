<?php
/**
 * Twenty Seven.
 *
 * This file adds the Customizer additions to the Twenty Seven Pro Theme.
 *
 * @package Twenty Seven
 * @author  Brian Gardner
 * @license GPL-2.0+
 * @link    http://briangardner.com/
 */

/**
 * Get default link color for Customizer.
 *
 * Abstracted here since at least two functions use it.
 *
 * @since 2.2.3
 *
 * @return string Hex color code for link color.
 */
function twenty_seven_customizer_get_default_link_color() {
	return '#fe595e';
}

/**
 * Get default accent color for Customizer.
 *
 * Abstracted here since at least two functions use it.
 *
 * @since 2.2.3
 *
 * @return string Hex color code for accent color.
 */
function twenty_seven_customizer_get_default_accent_color() {
	return '#fe595e';
}

add_action( 'customize_register', 'twenty_seven_customizer_register' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 2.2.3
 * 
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function twenty_seven_customizer_register() {

	global $wp_customize;

	$wp_customize->add_setting(
		'twenty_seven_link_color',
		array(
			'default'           => twenty_seven_customizer_get_default_link_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'twenty_seven_link_color',
			array(
				'description' => __( 'Change the default color for linked titles, menu links, post info links and more.', 'genesis-sample' ),
			    'label'       => __( 'Link Color', 'genesis-sample' ),
			    'section'     => 'colors',
			    'settings'    => 'twenty_seven_link_color',
			)
		)
	);

	$wp_customize->add_setting(
		'twenty_seven_accent_color',
		array(
			'default'           => twenty_seven_customizer_get_default_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'twenty_seven_accent_color',
			array(
				'description' => __( 'Change the default color for button hovers.', 'genesis-sample' ),
			    'label'       => __( 'Accent Color', 'genesis-sample' ),
			    'section'     => 'colors',
			    'settings'    => 'twenty_seven_accent_color',
			)
		)
	);

}
