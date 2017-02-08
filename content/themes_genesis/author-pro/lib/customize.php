<?php
/**
 * Author Pro.
 *
 * This file adds the customizer additions to the Author Pro Theme.
 *
 * @package Author
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/author/
 */

add_action( 'customize_register', 'author_customizer_register' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function author_customizer_register( $wp_customize ) {

	$wp_customize->add_setting(
		'author_light_color',
		array(
			'default'           => author_customizer_get_default_light_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'author_light_color',
			array(
				'label'       => __( 'Light Color', 'author-pro' ),
				'description' => __( 'Change the light background color for areas such as the secondary navigation and sidebar.', 'author-pro' ),
				'section'     => 'colors',
				'settings'    => 'author_light_color',
			)
		)
	);

	$wp_customize->add_setting(
		'author_dark_color',
		array(
			'default'           => author_customizer_get_default_dark_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'author_dark_color',
			array(
				'label'       => __( 'Dark Color', 'author-pro' ),
				'description' => __( 'Change the dark background color for areas such as submenus, the header on mobile, and footer widgets.', 'author-pro' ),
				'section'     => 'colors',
				'settings'    => 'author_dark_color',
			)
		)
	);

	$wp_customize->add_setting(
		'author_accent_color',
		array(
			'default'           => author_customizer_get_default_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'author_accent_color',
			array(
				'label'       => __( 'Accent Color', 'author-pro' ),
				'description' => __( 'Change the default accent color for links, numeric pagination, and highlighted menu items.', 'author-pro' ),
				'section'     => 'colors',
				'settings'    => 'author_accent_color',
			)
		)
	);

	// Update the custom background color to refresh the page.
	$wp_customize->get_setting( 'background_color' )->transport = 'refresh';

}
