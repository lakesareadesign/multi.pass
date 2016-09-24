<?php

/**
 * This file adds the Customizer to the Elegance Theme.
 *
 * @package      Elegance
 * @subpackage   Customizations
 * @link         http://stephaniehellwig.com/themes
 * @author       Stephanie Hellwig
 * @copyright    Copyright (c) 2016, Stephanie Hellwig, Released 06/04/2016
 * @license      GPL-2.0+
 */
 
//* Get default primary colors for Customizer.
function elegance_customizer_get_default_text_color() {
	return '#7a7a7a';
}

function elegance_customizer_get_default_links_color() {
	return '#829da5';
}

function elegance_customizer_get_default_titles_color() {
	return '#6b6b6b';
}

function elegance_customizer_get_default_accent_color() {
	return '#829da5';
}

function elegance_customizer_get_default_primary_color() {
	return '#000';
}

function elegance_customizer_get_default_line_color() {
	return '#000';
}

function elegance_customizer_get_default_navigation_color() {
	return '#6b6b6b';
}

function elegance_customizer_get_default_crtext_color() {
	return '#fff';
}

function elegance_customizer_get_default_crlinkhvr_color() {
	return '#829da5';
}

//* Register settings and controls with the Customizer.
add_action( 'customize_register', 'elegance_customizer_register' );
function elegance_customizer_register() {

	global $wp_customize;

	//* Footer Text
	$wp_customize->add_setting(
		'elegance_footer_text',
		array(
			'default' => ''
		)
	);
	$wp_customize->add_control(
		'elegance_footer_text',
		array(
			'description' => __( 'Update the footer text with something custom.', 'elegance' ),
			'label'       => __( 'Footer Text', 'elegance' ),
			'section'     => 'title_tagline',
			'settings'    => 'elegance_footer_text'
		)
	);

	//* Text Color
	$wp_customize->add_setting(
		'elegance_text_color',
		array(
			'default'           => elegance_customizer_get_default_text_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'elegance_text_color',
			array(
				'description' => __( 'Change the color for the content text across the site.', 'elegance' ),
			    'label'       => __( 'Text Color', 'elegance' ),
			    'section'     => 'colors',
			    'settings'    => 'elegance_text_color',
			)
		)
	);

	//* Text Color
	$wp_customize->add_setting(
		'elegance_text_color',
		array(
			'default'           => elegance_customizer_get_default_text_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'elegance_text_color',
			array(
				'description' => __( 'Change the color for the content text across the site.', 'elegance' ),
			    'label'       => __( 'Text Color', 'elegance' ),
			    'section'     => 'colors',
			    'settings'    => 'elegance_text_color',
			)
		)
	);

	//* Links Color
	$wp_customize->add_setting(
		'elegance_links_color',
		array(
			'default'           => elegance_customizer_get_default_links_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'elegance_links_color',
			array(
				'description' => __( 'Change the color for all your text links.', 'elegance' ),
			    'label'       => __( 'Links Color', 'elegance' ),
			    'section'     => 'colors',
			    'settings'    => 'elegance_links_color',
			)
		)
	);
	
	//* Titles Color
	$wp_customize->add_setting(
		'elegance_titles_color',
		array(
			'default'           => elegance_customizer_get_default_titles_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'elegance_titles_color',
			array(
				'description' => __( 'Change the default color for all the titles.', 'elegance' ),
			    'label'       => __( 'Title Color', 'elegance' ),
			    'section'     => 'colors',
			    'settings'    => 'elegance_titles_color',
			)
		)
	);
	
	//* Navigation Color
	$wp_customize->add_setting(
		'elegance_navigation_color',
		array(
			'default'           => elegance_customizer_get_default_navigation_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'elegance_navigation_color',
			array(
				'description' => __( 'Change the main color of the header navigation menu items.', 'elegance' ),
			    'label'       => __( 'Navigation Color', 'elegance' ),
			    'section'     => 'colors',
			    'settings'    => 'elegance_navigation_color',
			)
		)
	);
	
	//* Accent Color
	$wp_customize->add_setting(
		'elegance_accent_color',
		array(
			'default'           => elegance_customizer_get_default_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'elegance_accent_color',
			array(
				'description' => __( 'Change the accent color from the default teal.', 'elegance' ),
			    'label'       => __( 'Accent Color', 'elegance' ),
			    'section'     => 'colors',
			    'settings'    => 'elegance_accent_color',
			)
		)
	);
	
	$wp_customize->add_setting(
		'elegance_primary_color',
		array(
			'default'           => elegance_customizer_get_default_primary_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'elegance_primary_color',
			array(
				'description' => __( 'Change the primary color for widget above header background, footer background, button hover color.', 'elegance' ),
			    'label'       => __( 'Primary Color', 'elegance' ),
			    'section'     => 'colors',
			    'settings'    => 'elegance_primary_color',
			)
		)
	);
	
	$wp_customize->add_setting(
		'elegance_line_color',
		array(
			'default'           => elegance_customizer_get_default_line_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'elegance_line_color',
			array(
				'description' => __( 'Change the line color in the header and on homepage.', 'elegance' ),
			    'label'       => __( 'Line Color', 'elegance' ),
			    'section'     => 'colors',
			    'settings'    => 'elegance_line_color',
			)
		)
	);
	
	//* Credit Color
	$wp_customize->add_setting(
		'elegance_crtext_color',
		array(
			'default'           => elegance_customizer_get_default_crtext_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'elegance_crtext_color',
			array(
				'description' => __( 'Change the color of the text for the footer credits & above header widget text.', 'elegance' ),
			    'label'       => __( 'Footer & Above Header Text', 'elegance' ),
			    'section'     => 'colors',
			    'settings'    => 'elegance_crtext_color',
			)
		)
	);
	
	//* Credit Link Hover
	$wp_customize->add_setting(
		'elegance_crlinkhvr_color',
		array(
			'default'           => elegance_customizer_get_default_crlinkhvr_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'elegance_crlinkhvr_color',
			array(
				'description' => __( 'Change the color of the links in the footer credits when hovered.', 'elegance' ),
			    'label'       => __( 'Footer Credit link hover color', 'elegance' ),
			    'section'     => 'colors',
			    'settings'    => 'elegance_crlinkhvr_color',
			)
		)
	);   

}
