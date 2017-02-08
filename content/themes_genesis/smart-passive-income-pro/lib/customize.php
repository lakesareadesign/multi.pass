<?php
/**
 * Smart Passive Income Pro.
 *
 * This file adds the Customizer additions to the Smart Passive Income Pro.
 *
 * @package Smart Passive Income Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://www.studiopress.com/
 */

add_action( 'customize_preview_init', 'spi_customizer_scripts' );
/**
 * Register scripts in the Customizer for live preview.
 *
 * @since 1.0.0
 */
function spi_customizer_scripts() {
	wp_enqueue_script( 'spi-customizer-scripts', get_stylesheet_directory_uri() . '/lib/customizer-scripts.js', array( 'jquery', 'customize-preview' ), '', true );
}

add_action( 'customize_register', 'spi_customizer_register' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function spi_customizer_register( $wp_customize ) {

	$wp_customize->add_section(
		'spi_theme_settings',
		array(
			'title'           => __( 'Front Page Background Image', 'smart-passive-income-pro' ),
			'description'     => sprintf(
				'<p>%s</p><p>%s<strong>%s</strong></p>',
				__( 'Use the included default image or personalize your site by uploading your own image.', 'smart-passive-income-pro' ),
				__( 'The default image is ', 'smart-passive-income-pro' ),
				__( '2000 pixels wide and 833 pixels tall.', 'smart-passive-income-pro' )
			),
			'priority'        => '30',
			'capability'      => 'edit_theme_options',
			'active_callback' => 'is_front_page',
		)
	);

	$wp_customize->add_setting(
		'spi_primary_color',
		array(
			'default'           => spi_customizer_get_default_primary_color(),
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'spi_primary_color',
			array(
				'description' => __( 'Change the default primary color including links, primary buttons, etc...', 'smart-passive-income-pro' ),
				'label'       => __( 'Primary Color', 'smart-passive-income-pro' ),
				'section'     => 'colors',
				'settings'    => 'spi_primary_color',
			)
		)
	);

	$wp_customize->add_setting(
		'spi_secondary_color',
		array(
			'default'           => spi_customizer_get_default_secondary_color(),
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'spi_secondary_color',
			array(
				'description' => __( 'Change the background color of the Front Page 1 section, Footer Banner section, and menus.', 'smart-passive-income-pro' ),
				'label'       => __( 'Secondary Color', 'smart-passive-income-pro' ),
				'section'     => 'colors',
				'settings'    => 'spi_secondary_color',
			)
		)
	);

	// Set the Front Page 3 - BG Color.
	$wp_customize->add_setting(
		'spi_home_widget_3_background',
		array(
			'default'           => spi_customizer_get_default_front_page_3_color(),
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'spi_home_widget_3_background',
			array(
				'description' => __( 'Change the default background color for the "Front Page - 3" section.', 'smart-passive-income-pro' ),
				'label'       => __( 'Front Page 3 - Background Color', 'smart-passive-income-pro' ),
				'section'     => 'colors',
				'settings'    => 'spi_home_widget_3_background',
			)
		)
	);

	// Set the background image for Front Page 2.
	$wp_customize->add_setting(
		'spi_front_page_2_bg_image',
		array(
			'default'   => spi_customizer_get_default_front_page_2_image(),
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Upload_Control(
			$wp_customize,
			'spi_front_page_2_bg_image',
			array(
				'label'    => __( 'Front Page 2 - Background Image', 'smart-passive-income-pro' ),
				'section'  => 'spi_theme_settings',
				'settings' => 'spi_front_page_2_bg_image',
			)
		)
	);

	// Add featured image settings.
	$wp_customize->add_section(
		'spi_single_image_section',
		array(
			'title'       => __( 'Post and Page Images', 'smart-passive-income-pro' ),
			'description' => __( 'Choose if you would like to display the featured image above the content.', 'smart-passive-income-pro' ),
			'priority'    => 158.85,
		)
	);

	$wp_customize->add_setting(
		'spi_single_image_setting',
		array(
			'default'    => true,
			'capability' => 'edit_theme_options',
		)
	);

	$wp_customize->add_control(
		'spi_single_image_setting',
		array(
			'section'  => 'spi_single_image_section',
			'settings' => 'spi_single_image_setting',
			'label'    => __( 'Show featured image above post content?', 'smart-passive-income-pro' ),
			'type'     => 'checkbox',
		)
	);

}
