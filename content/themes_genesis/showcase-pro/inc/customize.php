<?php
/**
 * Showcase Pro
 *
 * This file adds the customizer functions to the Showcase Pro Theme.
 *
 * @package Showcase
 * @author  Bloom
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/showcase/
 */
 

/**
 * Get default base and accent colors for the Customizer
 *
 * @since 1.0.0
 *
 * @return string Hex color code for base and accent color.
 */

function showcase_customizer_get_default_accent_color() {
	return '#1db3e2';
}

add_action( 'customize_register', 'showcase_customizer_register' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function showcase_customizer_register() {

	global $wp_customize;

	$wp_customize->add_section( 'showcase-image', array(
		'title'          => __( 'Front Page Header Image', 'showcase' ),
		'description'    => __( '<p>Use the default image or personalize your site by uploading your own image for the front page 1 widget background.</p><p>The default image is <strong>1600 x 1050 pixels</strong>.</p>', 'digital' ),
		'priority'       => 75,
	) );

	$wp_customize->add_setting( 'showcase-page-header-image', array(
		'default'  => sprintf( '%s/images/page-header.jpg', get_stylesheet_directory_uri() ),
		'type'     => 'option',
	) );

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'page-header-image',
			array(
				'label'       => __( 'Page Header Image Upload', 'showcase' ),
				'section'     => 'showcase-image',
				'settings'    => 'showcase-page-header-image',
			)
		)
	);

	$wp_customize->add_setting(
		'showcase_accent_color',
		array(
			'default'           => showcase_customizer_get_default_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'showcase_accent_color',
			array(
				'description' => __( 'Set the default accent color.', 'showcase' ),
			    'label'       => __( 'Accent Color', 'showcase' ),
			    'section'     => 'colors',
			    'settings'    => 'showcase_accent_color',
			)
		)
	);

}