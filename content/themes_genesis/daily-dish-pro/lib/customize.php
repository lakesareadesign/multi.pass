<?php
/**
 * Daily Dish Pro.
 *
 * This file adds the Customizer additions to the Daily Dish Pro Theme.
 *
 * @package Daily Dish Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/daily-dish/
 */

add_action( 'customize_register', 'daily_dish_customizer_register' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 1.1.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function daily_dish_customizer_register( $wp_customize ) {

	$wp_customize->add_section( 'daily_dish_theme_options', array(
		'description' => __( 'Personalize the Daily Dish Pro theme with these available options.', 'daily-dish-pro' ),
		'title'       => __( 'Daily Dish Pro Settings', 'daily-dish-pro' ),
		'priority'    => 80,
	) );

	$wp_customize->add_setting(
		'daily_dish_link_color',
		array(
			'default'           => daily_dish_customizer_get_default_link_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'daily_dish_link_color',
			array(
				'description' => __( 'Change the color for links, menu links on a light background, the hover color for linked titles, and more.', 'daily-dish-pro' ),
				'label'       => __( 'Link Color', 'daily-dish-pro' ),
				'section'     => 'colors',
				'settings'    => 'daily_dish_link_color',
			)
		)
	);

	$wp_customize->add_setting(
		'daily_dish_accent_color',
		array(
			'default'           => daily_dish_customizer_get_default_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'daily_dish_accent_color',
			array(
				'description' => __( 'Change the color for button hovers, menu links on a dark background, and more.', 'daily-dish-pro' ),
				'label'       => __( 'Accent Color', 'daily-dish-pro' ),
				'section'     => 'colors',
				'settings'    => 'daily_dish_accent_color',
			)
		)
	);

	// Add control for search option.
	$wp_customize->add_setting(
		'daily_dish_header_search',
		array(
			'default'           => daily_dish_customizer_get_default_search_setting(),
			'sanitize_callback' => 'absint',
		)
	);

	// Add setting for search option.
	$wp_customize->add_control(
		'daily_dish_header_search',
		array(
			'label'       => __( 'Show Menu Search Icon?', 'daily-dish-pro' ),
			'description' => __( 'Check the box to show a search icon in the menu.', 'daily-dish-pro' ),
			'section'     => 'daily_dish_theme_options',
			'type'        => 'checkbox',
			'settings'    => 'daily_dish_header_search',
		)
	);

}
