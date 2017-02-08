<?php
/**
 * Workstation Pro.
 *
 * This file adds the customizer additions to the Workstation Pro Theme.
 *
 * @package Workstation
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/workstation/
 */

add_action( 'customize_register', 'workstation_customizer_register' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function workstation_customizer_register( $wp_customize ) {

	$images = apply_filters( 'workstation_images', array( '1', '2' ) );

	$wp_customize->add_section( 'workstation-settings', array(
		'description' => __( 'Use the included default images or personalize your site by uploading your own images.<br /><br />The default images are <strong>1800 pixels wide and 500 pixels tall</strong>.', 'workstation-pro' ),
		'title'       => __( 'Front Page Background Images', 'workstation-pro' ),
		'priority'    => 35,
	) );

	foreach( $images as $image ){

		$wp_customize->add_setting( $image .'-workstation-image', array(
			'default' => sprintf( '%s/images/bg-%s.jpg', get_stylesheet_directory_uri(), $image ),
			'type'    => 'option',
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $image .'-workstation-image', array(
			'label'    => sprintf( __( 'Featured Section %s Image:', 'workstation-pro' ), $image ),
			'section'  => 'workstation-settings',
			'settings' => $image .'-workstation-image',
			'priority' => $image+1,
		) ) );

	}

	$wp_customize->add_setting(
		'workstation_primary_color',
		array(
			'default'           => workstation_customizer_get_default_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'workstation_primary_color',
			array(
				'description' => __( 'Change the color for links, the color of front page widget titles, the hover color for linked titles, borders, and more.', 'workstation-pro' ),
				'label'       => __( 'Accent Color', 'workstation-pro' ),
				'section'     => 'colors',
				'settings'    => 'workstation_primary_color',
			)
		)
	);

	$wp_customize->add_setting(
		'workstation_accent_color',
		array(
			'default'           => workstation_customizer_get_default_secondary_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'workstation_accent_color',
			array(
				'description' => __( 'Change the accent color for button backgrounds, and more.', 'workstation-pro' ),
				'label'       => __( 'Secondary Accent Color', 'workstation-pro' ),
				'section'     => 'colors',
				'settings'    => 'workstation_accent_color',
			)
		)
	);

	$wp_customize->add_setting(
		'workstation_front_page_3_color',
		array(
			'default'           => workstation_customizer_get_default_front_page_3_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'workstation_front_page_3_color',
			array(
				'description' => __( 'Change the background color for front page 3 section.', 'workstation-pro' ),
				'label'       => __( 'Front Page 3 Color', 'workstation-pro' ),
				'section'     => 'colors',
				'settings'    => 'workstation_front_page_3_color',
			)
		)
	);

}
