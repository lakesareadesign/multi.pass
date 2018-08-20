<?php
/**
 * Infinity Pro.
 *
 * This file adds the Customizer additions to the Infinity Pro Theme.
 *
 * @package Infinity
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/infinity/
 */

add_action( 'customize_register', 'infinity_customizer_register' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 1.0.0
 * 
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function infinity_customizer_register() {

	global $wp_customize;

	$images = apply_filters( 'infinity_images', array( '1', '3', '5', '7' ) );

	$wp_customize->add_section( 'infinity-settings', array(
		'description' => __( 'Use the included default images or personalize your site by uploading your own images.<br /><br />The default images are <strong>1600 pixels wide and 1000 pixels tall</strong>.', 'infinity-pro' ),
		'title'       => __( 'Front Page Background Images', 'infinity-pro' ),
		'priority'    => 35,
	) );

	foreach( $images as $key => $image ) {

		$wp_customize->add_setting( $image .'-infinity-image', array(
			'default'           => sprintf( '%s/images/bg-%s.jpg', get_stylesheet_directory_uri(), $image ),
			'sanitize_callback' => 'esc_url_raw',
			'type'              => 'option',
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $image .'-infinity-image', array(
			'label'    => sprintf( __( 'Featured Section %s Image:', 'infinity-pro' ), $image ),
			'section'  => 'infinity-settings',
			'settings' => $image .'-infinity-image',
			'priority' => $key + 1,
		) ) );

	}

	$wp_customize->add_setting(
		'infinity_accent_color',
		array(
			'default'           => infinity_customizer_get_default_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'infinity_accent_color',
			array(
				'description' => __( 'Change the default color for some links, link hovers, buttons, and button hovers.', 'infinity-pro' ),
				'label'       => __( 'Accent Color', 'infinity-pro' ),
				'section'     => 'colors',
				'settings'    => 'infinity_accent_color',
			)
		)
	);

}
