<?php
/**
 * Agency Pro.
 *
 * This file adds the Customizer additions to the Agency Pro Theme.
 *
 * @package Agency
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/agency/
 */

add_action( 'customize_register', 'agency_customizer_register' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 3.0.2
 * 
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function agency_customizer_register() {

	global $wp_customize;

	$wp_customize->add_section( 'agency-image', array(
		'title'       => __( 'Backstretch Image', 'agency-pro' ),
		'description' => __( '<p>Use the included default image or personalize your site by uploading your own image for the background.</p><p>The default image is <strong>1600 x 1000 pixels</strong>.</p>', 'agency-pro' ),
		'priority'    => 75,
	) );

	$wp_customize->add_setting( 'agency-backstretch-image', array(
		'default'           => sprintf( '%s/images/bg.jpg', get_stylesheet_directory_uri() ),
		'sanitize_callback' => 'esc_url_raw',
		'type'              => 'option',
	) );

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'backstretch-image',
			array(
				'label'    => __( 'Backstretch Image Upload', 'agency-pro' ),
				'section'  => 'agency-image',
				'settings' => 'agency-backstretch-image',
			)
		)
	);

}
