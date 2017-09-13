<?php
/**
 * Outfitter Pro.
 *
 * This file adds the Customizer additions to the Outfitter Pro Theme.
 *
 * @package Outfitter_Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/outfitter/
 */

add_action( 'customize_register', 'outfitter_customizer_register' );
/**
 * Registers settings and controls with the Customizer.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function outfitter_customizer_register( $wp_customize ) {

	$wp_customize->add_section( 'outfitter_theme_options', array(
		'description' => __( 'Personalize the Outfitter Pro theme with these available options.', 'outfitter-pro' ),
		'title'       => __( 'Theme Options', 'outfitter-pro' ),
		'priority'    => 30,
	) );

	$wp_customize->add_setting( 'outfitter_link_color', array(
		'default'           => outfitter_customizer_get_default_link_color(),
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'outfitter_link_color', array(
		'description' => __( 'Change the link color, hover color for linked titles, and the color of the hover line effect on menu links and post info links. This option will also change the base WooCommerce color.', 'outfitter-pro' ),
		'label'       => __( 'Link Color', 'outfitter-pro' ),
		'section'     => 'colors',
		'settings'    => 'outfitter_link_color',
	) ) );

	$wp_customize->add_setting( 'outfitter_accent_color', array(
		'default'           => outfitter_customizer_get_default_accent_color(),
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'outfitter_accent_color', array(
		'description' => __( 'Change the color of buttons using the .primary class and WooCommerce sale badges and prices.', 'outfitter-pro' ),
		'label'       => __( 'Accent Color', 'outfitter-pro' ),
		'section'     => 'colors',
		'settings'    => 'outfitter_accent_color',
	) ) );

	// Add single image setting to the Customizer.
	$wp_customize->add_setting( 'outfitter_single_image_setting', array(
		'default'           => outfitter_customizer_get_default_image_setting(),
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'outfitter_single_image_setting', array(
			'label'       => __( 'Show featured image on posts?', 'outfitter-pro' ),
			'description' => __( 'Check the box if you would like to display the featured image above the content on single posts.', 'outfitter-pro' ),
			'section'     => 'outfitter_theme_options',
			'type'        => 'checkbox',
			'settings'    => 'outfitter_single_image_setting',
	) );

	// Adds control for search option.
	$wp_customize->add_setting( 'outfitter_header_search', array(
		'default'           => outfitter_customizer_get_default_search_setting(),
		'sanitize_callback' => 'absint',
	) );

	// Adds setting for search option.
	$wp_customize->add_control( 'outfitter_header_search', array(
		'label'       => __( 'Show Header Search Icon?', 'outfitter-pro' ),
		'description' => __( 'Check the box to show a search icon in the header menu.', 'outfitter-pro' ),
		'section'     => 'outfitter_theme_options',
		'type'        => 'checkbox',
		'settings'    => 'outfitter_header_search',
	) );

}
