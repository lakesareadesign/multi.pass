<?php
/**
 * Essence Pro.
 *
 * This file adds the Customizer additions to the Essence Pro Theme.
 *
 * @package Essence_Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/essence/
 */

add_action( 'customize_register', 'essence_customizer_register' );
/**
 * Registers settings and controls with the Customizer.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function essence_customizer_register( $wp_customize ) {

	// Adds custom heading controls to WordPress Theme Customizer.
	require_once get_stylesheet_directory() . '/lib/customizer/controls.php';

	// Main settings panel.
	$wp_customize->add_panel(
		'essence-settings', array(
			'description' => __( 'Set up the Essence Pro settings and defaults.', 'essence-pro' ),
			'priority'    => 80,
			'title'       => __( 'Essence Pro Settings', 'essence-pro' ),
		)
	);

	// Basic settings section.
	$wp_customize->add_section(
		'essence-basic-settings', array(
			'description' => sprintf( '<strong>%s</strong>', __( 'Modify the Essence Pro Theme basic settings.', 'essence-pro' ) ),
			'title'       => __( 'Basic Settings', 'essence-pro' ),
			'panel'       => 'essence-settings',
		)
	);

	// Styled paragraph settings.
	$wp_customize->add_setting(
		'essence-use-paragraph-styling', array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'essence-use-paragraph-styling', array(
			'label'       => __( 'Enable the "intro" paragraph style on single posts?', 'essence-pro' ),
			'description' => __( 'Check the box to automatically apply the "intro" font size and style to the first paragraph of all single posts.', 'essence-pro' ),
			'section'     => 'essence-basic-settings',
			'settings'    => 'essence-use-paragraph-styling',
			'type'        => 'checkbox',
		)
	);

	$wp_customize->add_section(
		'header_image', array(
			'title'       => __( 'Header Background Image', 'essence-pro' ),
			'description' => sprintf( '<p><strong>%1$s</strong></p><p>%2$s</p>', __( 'The default header background image is displayed on the front page and all posts and pages where a unique featured image is not available.', 'essence-pro' ), __( 'A default image is included with the theme, but you may choose a different default image below.', 'essence-pro' ) ),
			'panel'       => 'essence-settings',
		)
	);

	// Hero Section.
	$wp_customize->add_section(
		'essence-front-page-hero-section', array(
			'active_callback' => 'is_front_page',
			'description'     => sprintf( '<strong>%s</strong>', __( 'Modify the settings for the front page hero section.', 'essence-pro' ) ),
			'title'           => __( 'Hero Section', 'essence-pro' ),
			'panel'           => 'essence-settings',
		)
	);

	// Hero Visiblity.
	$wp_customize->add_setting(
		'essence-show-hero-section', array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'essence-show-hero-section', array(
			'label'       => __( 'Show the front page hero section?', 'essence-pro' ),
			'description' => __( 'Check the box to display the hero section on the top of the front page.', 'essence-pro' ),
			'section'     => 'essence-front-page-hero-section',
			'settings'    => 'essence-show-hero-section',
			'type'        => 'checkbox',
		)
	);

	// Hero Title.
	$wp_customize->add_setting(
		'essence-hero-title-text', array(
			'default'           => essence_get_default_hero_title_text(),
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh',
		)
	);

	$wp_customize->add_control(
		'essence-hero-title-text', array(
			'description' => __( 'Change the title text for the front page hero section.', 'essence-pro' ),
			'label'       => __( 'Hero Title', 'essence-pro' ),
			'section'     => 'essence-front-page-hero-section',
			'settings'    => 'essence-hero-title-text',
			'type'        => 'textarea',
		)
	);

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'essence-hero-title-text', array(
				'selector'        => '.hero-title',
				'settings'        => array( 'essence-hero-title-text' ),
				'render_callback' => function() {
					return get_theme_mod( 'essence-hero-title-text' );
				},
			)
		);
	}

	// Hero Intro Paragraph.
	$wp_customize->add_setting(
		'essence-hero-description-text', array(
			'default'           => essence_get_default_hero_desc_text(),
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh',
		)
	);

	$wp_customize->add_control(
		'essence-hero-description-text', array(
			'description' => __( 'Change the description text for the front page hero section.', 'essence-pro' ),
			'label'       => __( 'Hero Intro Paragraph', 'essence-pro' ),
			'section'     => 'essence-front-page-hero-section',
			'settings'    => 'essence-hero-description-text',
			'type'        => 'textarea',
		)
	);

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'essence-hero-description-text', array(
				'selector'        => '.hero-description',
				'settings'        => array( 'essence-hero-description-text' ),
				'render_callback' => function() {
					return get_theme_mod( 'essence-hero-description-text' );
				},
			)
		);
	}

	// Link Colors.
	$wp_customize->add_setting(
		'essence_link_color', array(
			'default'           => essence_customizer_get_default_link_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'essence_link_color', array(
				'description' => __( 'Change the default color for linked titles, buttons, post info links and more.', 'essence-pro' ),
				'label'       => __( 'Link Color', 'essence-pro' ),
				'section'     => 'colors',
				'settings'    => 'essence_link_color',
			)
		)
	);

}
