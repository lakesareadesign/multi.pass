<?php
/**
 * Interior Pro.
 *
 * This file adds the Customizer additions to the Interior Pro Theme.
 *
 * @package Interior
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/interior/
 */

/**
 * Get defaults for Customizer.
 *
 * Abstracted here since at least two functions use it.
 *
 * @since 1.0.0
 *
 * @return string Hex color code for accent color.
 */
function interior_customizer_get_default_site_title_color() {
	return '#9b938c';
}

function interior_customizer_get_default_image_color() {
	return '#373d3f';
}

function interior_customizer_get_default_primary_link_color() {
	return '#009092';
}

function interior_customizer_get_default_button_color() {
	return '#009092';
}

function interior_customizer_get_default_before_footer_color() {
	return '#373d3f';
}

add_action( 'customize_register', 'interior_customizer_register' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 1.0.0
 * 
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function interior_customizer_register() {

	global $wp_customize;

	$wp_customize->add_section( 'interior-settings', array(
		'description' => __( 'Use the included default images or personalize your site by uploading your own images.<br /><br />The default images are <strong>1800 pixels wide and 800 pixels tall</strong>.', 'interior' ),
		'title'    => __( 'Hero Images', 'interior' ),
		'priority' => 75,
	) );

	$wp_customize->add_setting( 'front-page-interior-image', array(
		'default'  => sprintf( '%s/images/bg-front-page.jpg', get_stylesheet_directory_uri() ),
		'sanitize_callback' => 'esc_url_raw',
		'type'     => 'option',
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'front-page-interior-image', array(
		'label'    => sprintf( __( 'Front Page Hero Image:', 'interior' ) ),
		'section'  => 'interior-settings',
		'settings' => 'front-page-interior-image',
		'priority' => 2,
	) ) );

	$wp_customize->add_setting( 'page-interior-image', array(
		'default'  => sprintf( '%s/images/bg-page.jpg', get_stylesheet_directory_uri() ),
		'sanitize_callback' => 'esc_url_raw',
		'type'     => 'option',
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'page-interior-image', array(
		'label'    => sprintf( __( 'Page Hero Image:', 'interior' ) ),
		'section'  => 'interior-settings',
		'settings' => 'page-interior-image',
		'priority' => 3,
	) ) );

	$wp_customize->add_setting( 'post-interior-image', array(
		'default'  => sprintf( '%s/images/bg-post.jpg', get_stylesheet_directory_uri() ),
		'sanitize_callback' => 'esc_url_raw',
		'type'     => 'option',
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'post-interior-image', array(
		'label'    => sprintf( __( 'Post and Archive Hero Image:', 'interior' ) ),
		'section'  => 'interior-settings',
		'settings' => 'post-interior-image',
		'priority' => 4,
	) ) );

	$wp_customize->add_setting( 'interior_site_title_color', array(
		'default' => interior_customizer_get_default_site_title_color(),
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'interior_site_title_color', array(
		'description' => __( 'Change the default background color for site title area.', 'interior' ),
		'label'       => __( 'Site Title Color', 'interior' ),
		'section'     => 'colors',
		'settings'    => 'interior_site_title_color',
	) ) );

	$wp_customize->add_setting( 'interior_image_color', array(
		'default' => interior_customizer_get_default_image_color(),
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'interior_image_color', array(
		'description' => __( 'Change the default color overlay for the hero image sections.', 'interior' ),
		'label'       => __( 'Hero Image Overlay Color', 'interior' ),
		'section'     => 'colors',
		'settings'    => 'interior_image_color',
	) ) );

	$wp_customize->add_setting( 'interior_primary_link_color', array(
		'default' => interior_customizer_get_default_primary_link_color(),
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'interior_primary_link_color', array(
		'description' => __( 'Change the default link color for primary links.', 'interior' ),
		'label'       => __( 'Primary Link Color', 'interior' ),
		'section'     => 'colors',
		'settings'    => 'interior_primary_link_color',
	) ) );

	$wp_customize->add_setting( 'interior_button_color', array(
		'default' => interior_customizer_get_default_button_color(),
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'interior_button_color', array(
		'description' => __( 'Change the default background color for buttons.', 'interior' ),
		'label'       => __( 'Button Background Color', 'interior' ),
		'section'     => 'colors',
		'settings'    => 'interior_button_color',
	) ) );

	$wp_customize->add_setting( 'interior_before_footer_color', array(
		'default' => interior_customizer_get_default_before_footer_color(),
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'interior_before_footer_color', array(
		'description' => __( 'Change the default background color for the Before Footer Section.', 'interior' ),
		'label'       => __( 'Before Footer Background Color', 'interior' ),
		'section'     => 'colors',
		'settings'    => 'interior_before_footer_color',
	) ) );

}
