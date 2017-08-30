<?php
/**
 * Parallax Pro.
 *
 * This file adds the customizer additions to the Parallax Pro Theme.
 *
 * @package Parallax
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/parallax/
 */

add_action( 'customize_register', 'parallax_customizer' );
/**
 * Add the theme settings and options to the Customizer.
 *
 * @since 1.0.0
 */
function parallax_customizer() {

	global $wp_customize;

	$images = apply_filters( 'parallax_images', array( '1', '3', '5' ) );
	
	$wp_customize->add_section(
		'parallax-settings',
		array(
			'title'    => __( 'Front Page Background Images', 'parallax-pro' ),
			'description' => __( '<p>Use the default images or personalize your site by uploading your own images for the front page background images.</p><p>The default images are <strong>1600 x 1050 pixels</strong>.</p>', 'parallax-pro' ),
			'priority' => 35,
		)
	);

	foreach( $images as $image ){

		$wp_customize->add_setting(
			$image .'-image',
			array(
				'default'  => sprintf( '%s/images/bg-%s.jpg', get_stylesheet_directory_uri(), $image ),
				'type'     => 'option',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				$image .'-image',
				array(
					'label'    => sprintf( __( 'Featured Section %s Image:', 'parallax-pro' ), $image ),
					'section'  => 'parallax-settings',
					'settings' => $image .'-image',
					'priority' => $image+1,
				)
			)
		);

	}

	// Link color.
	$wp_customize->add_setting(
		'parallax_link_color',
		array(
			'default'           => parallax_get_default_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'parallax_link_color',
			array(
				'description' => __( 'Change the color for content links, the hover color for linked titles, and more.', 'parallax-pro' ),
				'label'       => __( 'Link Color', 'parallax-pro' ),
				'section'     => 'colors',
				'settings'    => 'parallax_link_color',
			)
		)
	);

	// Menu Link color.
	$wp_customize->add_setting(
		'parallax_menu_link_color',
		array(
			'default'           => parallax_get_default_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'parallax_menu_link_color',
			array(
				'description' => __( 'Change the hover color for menu links and links in the footer area.', 'parallax-pro' ),
				'label'       => __( 'Menu Link Color', 'parallax-pro' ),
				'section'     => 'colors',
				'settings'    => 'parallax_menu_link_color',
			)
		)
	);

	// Accent color.
	$wp_customize->add_setting(
		'parallax_accent_color',
		array(
			'default'           => parallax_get_default_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'parallax_accent_color',
			array(
				'description' => __( 'Change the hover color for buttons, the footer widget background color, and more.', 'parallax-pro' ),
				'label'       => __( 'Accent Color', 'parallax-pro' ),
				'section'     => 'colors',
				'settings'    => 'parallax_accent_color',
			)
		)
	);

}
