<?php
/**
 * Minimum Pro.
 *
 * This file adds the Customizer additions to the Minimum Pro Theme.
 *
 * @package Minimum
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/minimum/
 */
 
 /**
 * Get default accent color for Customizer.
 *
 * Abstracted here since at least two functions use it.
 *
 * @since 3.2.0
 *
 * @return string Hex color code for accent color.
 */
function minimum_customizer_get_default_accent_color() {

	return '#0ebfe9';

}

add_action( 'customize_register', 'minimum_customizer' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 3.0.0
 * 
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function minimum_customizer(){

	global $wp_customize;

	$wp_customize->add_section( 'minimum-image', array(
		'title'    => __( 'Backstretch Image', 'minimum' ),
		'description'    => __( '<p>Use the included default image or personalize your site by uploading your own image for the homepage and landing page template background.</p><p>The default image is <strong>1600 x 1050 pixels</strong>.</p>', 'minimum' ),
		'priority' => 75,
	) );

	$wp_customize->add_setting( 'minimum-backstretch-image', array(
		'default'  => sprintf( '%s/images/bg.jpg', get_stylesheet_directory_uri() ),
		'type'     => 'option',
	) );
	 
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'backstretch-image',
			array(
				'label'       => __( 'Backstretch Image Upload', 'minimum' ),
				'section'     => 'minimum-image',
				'settings'    => 'minimum-backstretch-image'
			)
		)
	);

}
