<?php
/**
 * Wellness Pro.
 *
 * This file adds the Customizer additions to the Wellness Pro Theme.
 *
 * @package Wellness
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/wellness/
 */

add_action( 'customize_register', 'wellness_customizer_register' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function wellness_customizer_register( $wp_customize ) {

	$images = apply_filters( 'wellness_images', array( '1', '3', '5' ) );

	$wp_customize->add_section( 'wellness-settings', array(
		'description' => __( 'Use the included default images or personalize your site by uploading your own images.<br /><br />The default images are <strong>1800 pixels wide and 1000 pixels tall</strong>.', 'wellness-pro' ),
		'title'       => __( 'Front Page Background Images', 'wellness-pro' ),
		'priority'    => 80.1,
	) );

	foreach( $images as $image ){

		$wp_customize->add_setting( $image .'-wellness-image', array(
			'default' => sprintf( '%s/images/bg-%s.jpg', get_stylesheet_directory_uri(), $image ),
			'type'    => 'option',
		) );

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				$image .'-wellness-image',
				array(
					'label'    => sprintf( __( 'Featured Section %s Image:', 'wellness-pro' ), $image ),
					'section'  => 'wellness-settings',
					'settings' => $image .'-wellness-image',
					'priority' => $image+1,
				)
			)
		);

	}

	$wp_customize->add_setting(
		'wellness_link_color',
		array(
			'default'           => wellness_customizer_get_default_link_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'wellness_link_color',
			array(
				'description' => __( 'Change the default color for post meta links, the hover color for linked titles, menu links, pagination buttons, and more.', 'wellness-pro' ),
			    'label'       => __( 'Link Color', 'wellness-pro' ),
			    'section'     => 'colors',
			    'settings'    => 'wellness_link_color',
			)
		)
	);

	$wp_customize->add_setting(
		'wellness_accent_color',
		array(
			'default'           => wellness_customizer_get_default_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'wellness_accent_color',
			array(
				'description' => __( 'Change the default hover color for buttons, sub-menu links, footer links, and other accents.', 'wellness-pro' ),
			    'label'       => __( 'Accent Color', 'wellness-pro' ),
			    'section'     => 'colors',
			    'settings'    => 'wellness_accent_color',
			)
		)
	);

    // Add single image section to the Customizer.
    $wp_customize->add_section(
		'wellness_single_image_section',
		array(
			'title'       => __( 'Post and Page Images', 'wellness-pro' ),
			'description' => __( 'Choose if you would like to display the featured image above the content on single posts and pages.', 'wellness-pro' ),
			'priority'    => 158.85,
		)
	);

    // Add single image setting to the Customizer.
    $wp_customize->add_setting(
		'wellness_single_image_setting',
		array(
			'default'    => true,
			'capability' => 'edit_theme_options',
		)
	);

    $wp_customize->add_control(
		'wellness_single_image_setting',
		array(
			'section'  => 'wellness_single_image_section',
			'settings' => 'wellness_single_image_setting',
			'label'    => __( 'Show featured image on posts and pages?', 'wellness-pro' ),
			'type'     => 'checkbox',
		)
	);

}
