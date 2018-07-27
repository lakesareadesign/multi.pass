<?php
/**
 * Niche Pro.
 *
 * This file adds the customizer functions to the Niche Pro Theme.
 *
 * @package Niche
 * @author  Bloom
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/niche/
 */

/**
 * Get default base and accent colors for the Customizer.
 *
 * @since 1.0.0
 *
 * @return string Hex color code for base and accent color.
 */

function bloom_customizer_get_default_text_color() {
	return '#424243';
}

function bloom_customizer_get_default_link_color() {
	return '#d54101';
}

function bloom_customizer_get_default_button_color() {
	return '#525252';
}

function bloom_customizer_get_default_light_accent_color() {
	return '#f8f3f1';
}

function bloom_customizer_get_default_dark_accent_color() {
	return '#000000';
}

function bloom_customizer_get_default_border_color() {
	return '#eCe7e6';
}

add_action( 'customize_register', 'bloom_customizer_register' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function bloom_customizer_register() {

	global $wp_customize;

	// Text Color.
	$wp_customize->add_setting(
		'bloom_text_color',
		array(
			'default'           => bloom_customizer_get_default_text_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'bloom_text_color',
			array(
				'description' => __( 'Set the default text color.', 'niche-pro' ),
				'label'       => __( 'Text Color', 'niche-pro' ),
				'section'     => 'colors',
				'settings'    => 'bloom_text_color',
			)
		)
	);

	// Link Color.
	$wp_customize->add_setting(
		'bloom_link_color',
		array(
			'default'           => bloom_customizer_get_default_link_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'bloom_link_color',
			array(
				'description' => __( 'Set the link color. This color also shows up when hovering on menu items.', 'niche-pro' ),
				'label'       => __( 'Link Color', 'niche-pro' ),
				'section'     => 'colors',
				'settings'    => 'bloom_link_color',
			)
		)
	);

	// Button Color.
	$wp_customize->add_setting(
		'bloom_button_color',
		array(
			'default'           => bloom_customizer_get_default_button_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'bloom_button_color',
			array(
				'description' => __( 'Set the button color. By design, the button hover will show a 1px border with a transparent background.', 'niche-pro' ),
				'label'       => __( 'Button Color', 'niche-pro' ),
				'section'     => 'colors',
				'settings'    => 'bloom_button_color',
			)
		)
	);

	// Light Accent Color.
	$wp_customize->add_setting(
		'bloom_light_accent_color',
		array(
			'default'           => bloom_customizer_get_default_light_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'bloom_light_accent_color',
			array(
				'description' => __( 'Set the light accent color. This shows up as the navigation background, pagination background, and the .highlight class for widgets.', 'niche-pro' ),
				'label'       => __( 'Light Accent Color', 'niche-pro' ),
				'section'     => 'colors',
				'settings'    => 'bloom_light_accent_color',
			)
		)
	);

	// Dark Accent Color.
	$wp_customize->add_setting(
		'bloom_dark_accent_color',
		array(
			'default'           => bloom_customizer_get_default_dark_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'bloom_dark_accent_color',
			array(
				'description' => __( 'Set the dark accent color. This shows up as the footer background.', 'niche-pro' ),
				'label'       => __( 'Dark Accent Color', 'niche-pro' ),
				'section'     => 'colors',
				'settings'    => 'bloom_dark_accent_color',
			)
		)
	);

	// Border Color.
	$wp_customize->add_setting(
		'bloom_border_color',
		array(
			'default'           => bloom_customizer_get_default_border_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'bloom_border_color',
			array(
				'description' => __( 'Set the border color.', 'niche-pro' ),
				'label'       => __( 'Border Color', 'niche-pro' ),
				'section'     => 'colors',
				'settings'    => 'bloom_border_color',
			)
		)
	);

}
