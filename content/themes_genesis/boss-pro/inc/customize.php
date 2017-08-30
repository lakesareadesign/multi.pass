<?php
/**
 * Boss Pro
 *
 * This file adds the customizer functions to the Boss Pro Theme.
 *
 * @package Boss
 * @author  Bloom
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/boss/
 */


/**
 * Get default base and accent colors for the Customizer
 *
 * @return string Hex color code for base and accent color.
 *
 * @since 1.0.0
 */
function boss_customizer_get_default_link_color() {
	return '#d2c2b8';
}

function boss_customizer_get_default_button_color() {
	return '#000000';
}

function boss_customizer_get_default_front_page_2_color() {
	return '#000000';
}

function boss_customizer_get_default_light_accent_color() {
	return '#fffbfa';
}

add_action( 'customize_register', 'boss_customizer_register' );
/**
 * Register settings and controls with the Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 * @return void
 *
 * @since 1.0.0
 */
function boss_customizer_register( $wp_customize ) {

	// Alternate Header Image.
	$wp_customize->add_setting( 'boss-header-image', array(
		'default' => sprintf( '%s/assets/images/logo_light.png', get_stylesheet_directory_uri() ),
		'type'    => 'option',
	) );

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'front-header-image',
			array(
				'label'    => __( 'Front Page Light Header Image', 'boss-pro' ),
				'description' => __( '<p>Upload a version of the logo that will appear on the darker background on the home page. <strong>Note: you must first upload a logo above for this option to work.</strong></p>', 'boss-pro' ),
				'section'  => 'header_image',
				'settings' => 'boss-header-image',
			)
		)
	);

	$wp_customize->add_section( 'boss-images', array(
		'title'       => __( 'Front Page Images', 'boss-pro' ),
		'description' => __( '<p>Use the default images or personalize your site by uploading your own images for the front page 1, front page 4, and front page 7 widget backgrounds.</p><p>The default image is <strong>1600 x 1050 pixels</strong>.</p>', 'boss-pro' ),
		'priority'    => 75,
	) );

	// Page Header.
	$wp_customize->add_setting( 'boss-page-header-image', array(
		'default' => sprintf( '%s/assets/images/demo-01.jpg', get_stylesheet_directory_uri() ),
		'type'    => 'option',
	) );

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'page-header-image',
			array(
				'label'    => __( 'Page Header Image Upload', 'boss-pro' ),
				'section'  => 'boss-images',
				'settings' => 'boss-page-header-image',
			)
		)
	);

	// Front Page 4.
	$wp_customize->add_setting( 'boss-front-page-image-2', array(
		'default' => sprintf( '%s/assets/images/demo-02.jpg', get_stylesheet_directory_uri() ),
		'type'    => 'option',
	) );

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'front-page-image-2',
			array(
				'label'    => __( 'Front Page 4 Image Upload', 'boss-pro' ),
				'section'  => 'boss-images',
				'settings' => 'boss-front-page-image-2',
			)
		)
	);

	// Front Page 7.
	$wp_customize->add_setting( 'boss-front-page-image-3', array(
		'default'  => sprintf( '%s/assets/images/demo-03.jpg', get_stylesheet_directory_uri() ),
		'type'     => 'option',
	) );

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'front-page-image-3',
			array(
				'label'    => __( 'Front Page 7 Image Upload', 'boss-pro' ),
				'section'  => 'boss-images',
				'settings' => 'boss-front-page-image-3',
			)
		)
	);

	// Link Color.
	$wp_customize->add_setting(
		'boss_link_color',
		array(
			'default'           => boss_customizer_get_default_link_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'boss_link_color',
			array(
				'description' => __( 'Set the default link color. This color is also used as the highlight color for inputs.', 'boss-pro' ),
			    'label'       => __( 'Link Color', 'boss-pro' ),
			    'section'     => 'colors',
			    'settings'    => 'boss_link_color',
			)
		)
	);

	// Button Color.
	$wp_customize->add_setting(
		'boss_button_color',
		array(
			'default'           => boss_customizer_get_default_button_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'boss_button_color',
			array(
				'description' => __( 'Set the default button color.', 'boss-pro' ),
			    'label'       => __( 'Button Color', 'boss-pro' ),
			    'section'     => 'colors',
			    'settings'    => 'boss_button_color',
			)
		)
	);

	// Front Page 2 Color.
	$wp_customize->add_setting(
		'boss_front_page_2_color',
		array(
			'default'           => boss_customizer_get_default_front_page_2_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'boss_front_page_2_color',
			array(
				'description' => __( 'Set the background color for the Front Page 2 widget area.', 'boss-pro' ),
			    'label'       => __( 'Front Page 2 Background Color', 'boss-pro' ),
			    'section'     => 'colors',
			    'settings'    => 'boss_front_page_2_color',
			)
		)
	);

	// Light Accent Color.
	$wp_customize->add_setting(
		'boss_light_accent_color',
		array(
			'default'           => boss_customizer_get_default_light_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'boss_light_accent_color',
			array(
				'description' => __( 'Set the light accent color. This shows up in the Front Page 4 card, the Front Page 6 background color, and the Genesis Recent Posts background color.', 'boss-pro' ),
			    'label'       => __( 'Light Accent Color', 'boss-pro' ),
			    'section'     => 'colors',
			    'settings'    => 'boss_light_accent_color',
			)
		)
	);

}
