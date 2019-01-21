<?php
/**
 * Magazine Pro.
 *
 * This file adds options to the Customizer for customizing the Magainze Pro Theme.
 *
 * @package Magazine
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    http://my.studiopress.com/themes/magazine/
 */

add_action( 'customize_register', 'magazine_customizer_register' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 3.2.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function magazine_customizer_register( $wp_customize ) {

	// Add the primary nav accent color.
	$wp_customize->add_setting(
		'magazine_link_color',
		array(
			'default'           => magazine_get_default_link_color(),
			'sanatize_callback' => 'sanatize_hex_color',
		)
	);

	// Add the link color picker.
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'magazine_link_color',
			array(
				'description' => __( 'Change the hover color of links, linked titles, After Header Menu links, post info links, and more.', 'magazine-pro' ),
				'label'       => __( 'Link Color', 'magazine-pro' ),
				'section'     => 'colors',
				'settings'    => 'magazine_link_color',
			)
		)
	);

	// Add the accent color picker.
	$wp_customize->add_setting(
		'magazine_accent_color',
		array(
			'default'           => magazine_get_default_accent_color(),
			'sanatize_callback' => 'sanatize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'magazine_accent_color',
			array(
				'description' => __( 'Change the front page featured post date backgrounds, the button hover background color, and more.', 'magazine-pro' ),
				'label'       => __( 'Accent Color', 'magazine-pro' ),
				'section'     => 'colors',
				'settings'    => 'magazine_accent_color',
			)
		)
	);

}
