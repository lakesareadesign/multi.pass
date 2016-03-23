<?php

/**
 * Customizations
 *
 * @package Showcase Pro
 * @author  JT Grauke
 * @link    http://my.studiopress.com/themes/showcase/
 * @license GPL2-0+
 */

/**
 * Get default primary color for Customizer.
 *
 * Abstracted here since at least two functions use it.
 *
 * @since 1.0.0
 *
 * @return string Hex color code for primary color.
 */

function showcase_customizer_get_default_primary_color() {
	return '#52c0cb';
}

function showcase_customizer_get_default_accent_color() {
	return '#e6413e';
}

function showcase_customizer_get_default_page_header_color() {
	return '#52c0cb';
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
		'title'          => __( 'Front Page Hero Image', 'showcase' ),
		'description'    => __( '<p>Use the default image or personalize your site by uploading your own image for the front page 1 widget background.</p><p>The default image is <strong>1600 x 1050 pixels</strong>.</p>', 'digital' ),
		'priority'       => 75,
	) );

	$wp_customize->add_setting( 'showcase-hero-image', array(
		'default'  => sprintf( '%s/images/hero-image-1.jpg', get_stylesheet_directory_uri() ),
		'type'     => 'option',
	) );

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'hero-background-image',
			array(
				'label'       => __( 'Hero Image Upload', 'showcase' ),
				'section'     => 'showcase-image',
				'settings'    => 'showcase-hero-image',
			)
		)
	);

	//* Add header color setting to the Customizer
    $wp_customize->add_setting( 'showcase_header_color', array(
        'default'           => 'true',
        'capability'        => 'edit_theme_options',
        'type'              => 'option',
    ));

	$wp_customize->add_control( new WP_Customize_Control(
        $wp_customize, 'showcase_header_control', array(
			'label'       => __( 'Header Color', 'showcase' ),
			'description' => __( 'Set the header color to White or Transparent. By default, the header will be transparent to reveal the Page Header color. NOTE: your changes will not be reflected until you save and refresh.', 'showcase' ),
			'section'     => 'colors',
			'settings'    => 'showcase_header_color',
			'type'        => 'select',
			'choices'     => array(
				'transparent'   => __( 'Transparent', 'showcase' ),
				'white'    => __( 'White', 'showcase' ),
			),
        ))
	);

	$wp_customize->add_setting(
		'showcase_primary_color',
		array(
			'default'           => showcase_customizer_get_default_primary_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'showcase_primary_color',
			array(
				'description' => __( 'Set the default color.', 'showcase' ),
			    'label'       => __( 'Primary Color', 'showcase' ),
			    'section'     => 'colors',
			    'settings'    => 'showcase_primary_color',
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
				'description' => __( 'Set the default button color.', 'showcase' ),
			    'label'       => __( 'Accent Color', 'showcase' ),
			    'section'     => 'colors',
			    'settings'    => 'showcase_accent_color',
			)
		)
	);

	$wp_customize->add_setting(
		'showcase_page_header_color',
		array(
			'default'           => showcase_customizer_get_default_page_header_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'showcase_page_header_color',
			array(
				'description' => __( 'Set the default Page Header color.', 'showcase' ),
			    'label'       => __( 'Page Header Color', 'showcase' ),
			    'section'     => 'colors',
			    'settings'    => 'showcase_page_header_color',
			)
		)
	);

}
