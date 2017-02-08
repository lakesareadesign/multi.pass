<?php
/**
 * Executive Pro.
 *
 * This file adds the Customizer additions to the Executive Pro Theme.
 *
 * @package Executive
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/executive/
 */

add_action( 'customize_register', 'executive_customizer_register' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 3.2.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function executive_customizer_register( $wp_customize ) {

	$wp_customize->add_setting(
		'executive_link_color',
		array(
			'default'           => executive_customizer_get_default_link_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'executive_link_color',
			array(
				'description' => __( 'Change the color for content links, linked titles, and more.', 'executive-pro' ),
				'label'       => __( 'Link Color', 'executive-pro' ),
				'section'     => 'colors',
				'settings'    => 'executive_link_color',
			)
		)
	);

	$wp_customize->add_setting(
		'executive_accent_color',
		array(
			'default'           => executive_customizer_get_default_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'executive_accent_color',
			array(
				'description' => __( 'Change the color for button backgrounds, current menu item backgrounds, the comment link background, footer widget links, and more.', 'executive-pro' ),
				'label'       => __( 'Accent Color', 'executive-pro' ),
				'section'     => 'colors',
				'settings'    => 'executive_accent_color',
			)
		)
	);

	$wp_customize->add_setting(
		'executive_hover_color',
		array(
			'default'           => executive_customizer_get_default_hover_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'executive_hover_color',
			array(
				'description' => __( 'Change the hover color for button backgrounds.', 'executive-pro' ),
				'label'       => __( 'Hover Color', 'executive-pro' ),
				'section'     => 'colors',
				'settings'    => 'executive_hover_color',
			)
		)
	);

	$wp_customize->get_setting( 'background_color' )->transport = 'refresh';

}
