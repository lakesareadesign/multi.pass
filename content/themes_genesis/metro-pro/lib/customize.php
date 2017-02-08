<?php
/**
 * Metro Pro.
 *
 * This file adds the customizer additions to the Metro Pro Theme.
 *
 * @package Metro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/metro/
 */

add_action( 'customize_register', 'metro_customizer_register' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 2.2.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function metro_customizer_register( $wp_customize ) {

	$wp_customize->add_setting(
		'metro_link_color',
		array(
			'default'           => metro_customizer_get_default_link_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'metro_link_color',
			array(
				'description' => __( 'Change the color of links, the hover color of linked titles, and more.', 'metro-pro' ),
				'label'       => __( 'Link Color', 'metro-pro' ),
				'section'     => 'colors',
				'settings'    => 'metro_link_color',
			)
		)
	);

	$wp_customize->add_setting(
		'metro_accent_color',
		array(
			'default'           => metro_customizer_get_default_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'metro_accent_color',
			array(
				'description' => __( 'Change the color of the site title background, the button hover color, and more.', 'metro-pro' ),
				'label'       => __( 'Accent Color', 'metro-pro' ),
				'section'     => 'colors',
				'settings'    => 'metro_accent_color',
			)
		)
	);

	$wp_customize->add_section( 'metro-image', array(
		'title'       => __( 'Backstretch Image', 'metro-pro' ),
		'description' => __( '<p>Use the included default image or personalize your site by uploading your own image for the background.</p><p>The default image is <strong>1600 x 900 pixels</strong>.</p>', 'metro-pro' ),
		'priority'    => 75,
	) );

	$wp_customize->add_setting( 'metro-backstretch-image', array(
		'default' => sprintf( '%s/images/bg.jpg', get_stylesheet_directory_uri() ),
		'type'    => 'option',
	) );

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'backstretch-image',
			array(
				'label'    => __( 'Backstretch Image Upload', 'metro-pro' ),
				'section'  => 'metro-image',
				'settings' => 'metro-backstretch-image'
			)
		)
	);

}
