<?php
/**
 * This file adds the Customizer to the Refined Theme.
 *
 * @package      Refined
 * @subpackage   Customizations
 * @link         http://restored316designs.com/themes
 * @author       Lauren Gaige // Restored 316 LLC
 * @copyright    Copyright (c) 2015, Restored 316 LLC, Released 04/12/2017
 * @license      GPL-2.0+
 */

/**
 * Function to get default text color for Customizer.
 *
 * @since 1.0.0
 *
 * @return string Hex value of the default text color.
 */
function refined_customizer_get_default_text_color() {
	return '#333333';
}

/**
 * Function to get default link color for Customizer.
 *
 * @since 1.0.0
 *
 * @return string Hex value of the default link color.
 */
function refined_customizer_get_default_links_color() {
	return '#ae9d78';
}

/**
 * Function to get default home slider color for Customizer.
 *
 * @since 1.0.0
 *
 * @return string Hex value of the default home slider color.
 */
function refined_customizer_get_default_homeslider_color() {
	return '#ae9d78';
}

/**
 * Function to get default home title color for Customizer.
 *
 * @since 1.0.0
 *
 * @return string Hex value of the default home title color.
 */
function refined_customizer_get_default_hometitles_color() {
	return '#ae9d78';
}

/**
 * Function to get default button color for Customizer.
 *
 * @since 1.0.0
 *
 * @return string Hex value of the default button color.
 */
function refined_customizer_get_default_button_color() {
	return '#ffffff';
}

/**
 * Function to get default button border color for Customizer.
 *
 * @since 1.0.0
 *
 * @return string Hex value of the default button border color.
 */
function refined_customizer_get_default_buttonborder_color() {
	return '#333333';
}

/**
 * Function to get default button text color for Customizer.
 *
 * @since 1.0.0
 *
 * @return string Hex value of the default button text color.
 */
function refined_customizer_get_default_buttontext_color() {
	return '#333333';
}

/**
 * Function to get default button hover color for Customizer.
 *
 * @since 1.0.0
 *
 * @return string Hex value of the default button hover color.
 */
function refined_customizer_get_default_buttonhover_color() {
	return '#ae9d78';
}

/**
 * Function to get default button hover boder color for Customizer.
 *
 * @since 1.0.0
 *
 * @return string Hex value of the default button hover boder color.
 */
function refined_customizer_get_default_buttonhoverborder_color() {
	return '#ae9d78';
}

/**
 * Function to get default button hover text color for Customizer.
 *
 * @since 1.0.0
 *
 * @return string Hex value of the default button hover text color.
 */
function refined_customizer_get_default_buttonhovertext_color() {
	return '#ffffff';
}

/**
 * Function to get default newlsetter color for Customizer.
 *
 * @since 1.0.0
 *
 * @return string Hex value of the default newsletter color.
 */
function refined_customizer_get_default_newsletter_color() {
	return '#faf7f2';
}

/**
 * Function to get default footer color for Customizer.
 *
 * @since 1.0.0
 *
 * @return string Hex value of the default footer color.
 */
function refined_customizer_get_default_footer_color() {
	return '#ae9d78';
}

/**
 * Function to get default footer text color for Customizer.
 *
 * @since 1.0.0
 *
 * @return string Hex value of the default footer text color.
 */
function refined_customizer_get_default_footertext_color() {
	return '#ffffff';
}

/**
 * Function to get default announcement color for Customizer.
 *
 * @since 1.0.0
 *
 * @return string Hex value of the default announcement color.
 */
function refined_customizer_get_default_announcement_color() {
	return '#faf7f2';
}

/**
 * Function to get default announcement text color for Customizer.
 *
 * @since 1.0.0
 *
 * @return string Hex value of the default announcement text color.
 */
function refined_customizer_get_default_announcementtext_color() {
	return '#333333';
}

add_action( 'customize_register', 'refined_customizer_register' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 1.0.0
 *
 * @param stdClass $wp_customize Class object containing available methods.
 */
function refined_customizer_register( $wp_customize ) {

	$wp_customize->add_setting(
		'refined_text_color',
		array(
			'default'           => refined_customizer_get_default_text_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_setting(
		'refined_links_color',
		array(
			'default'           => refined_customizer_get_default_links_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_setting(
		'refined_homeslider_color',
		array(
			'default'           => refined_customizer_get_default_homeslider_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_setting(
		'refined_hometitles_color',
		array(
			'default'           => refined_customizer_get_default_hometitles_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_setting(
		'refined_button_color',
		array(
			'default'           => refined_customizer_get_default_button_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_setting(
		'refined_buttonborder_color',
		array(
			'default'           => refined_customizer_get_default_buttonborder_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_setting(
		'refined_buttontext_color',
		array(
			'default'           => refined_customizer_get_default_buttontext_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_setting(
		'refined_buttonhover_color',
		array(
			'default'           => refined_customizer_get_default_buttonhover_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_setting(
		'refined_buttonhoverborder_color',
		array(
			'default'           => refined_customizer_get_default_buttonhoverborder_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_setting(
		'refined_buttonhovertext_color',
		array(
			'default'           => refined_customizer_get_default_buttonhovertext_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_setting(
		'refined_newsletter_color',
		array(
			'default'           => refined_customizer_get_default_newsletter_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_setting(
		'refined_footer_color',
		array(
			'default'           => refined_customizer_get_default_footer_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_setting(
		'refined_footertext_color',
		array(
			'default'           => refined_customizer_get_default_footertext_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_setting(
		'refined_announcement_color',
		array(
			'default'           => refined_customizer_get_default_announcement_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_setting(
		'refined_announcementtext_color',
		array(
			'default'           => refined_customizer_get_default_announcementtext_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'refined_text_color',
			array(
				'description' => __( 'Change the default color for all the body text across the site.', 'refined' ),
			    'label'       => __( 'Main Text Color', 'refined' ),
			    'section'     => 'colors',
			    'settings'    => 'refined_text_color',
			)
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'refined_links_color',
			array(
				'description' => __( 'Change the default color for all your links across the site', 'refined' ),
			    'label'       => __( 'Link Color', 'refined' ),
			    'section'     => 'colors',
			    'settings'    => 'refined_links_color',
			)
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'refined_homeslider_color',
			array(
				'description' => __( 'Change the default color for the text over the home page slider.', 'refined' ),
			    'label'       => __( 'Home Slider Text Color', 'refined' ),
			    'section'     => 'colors',
			    'settings'    => 'refined_homeslider_color',
			)
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'refined_hometitles_color',
			array(
				'description' => __( 'Change the default color for all the titles across the home page.', 'refined' ),
			    'label'       => __( 'Home Page Title Color', 'refined' ),
			    'section'     => 'colors',
			    'settings'    => 'refined_hometitles_color',
			)
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'refined_button_color',
			array(
				'description' => __( 'Change the default color for all the buttons.', 'refined' ),
			    'label'       => __( 'Button Background Color', 'refined' ),
			    'section'     => 'colors',
			    'settings'    => 'refined_button_color',
			)
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'refined_buttonborder_color',
			array(
				'description' => __( 'Change the default color for the border on all the buttons.', 'refined' ),
			    'label'       => __( 'Button Border Color', 'refined' ),
			    'section'     => 'colors',
			    'settings'    => 'refined_buttonborder_color',
			)
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'refined_buttontext_color',
			array(
				'description' => __( 'Change the default color for the text on your buttons.', 'refined' ),
			    'label'       => __( 'Button Text Color', 'refined' ),
			    'section'     => 'colors',
			    'settings'    => 'refined_buttontext_color',
			)
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'refined_buttonhover_color',
			array(
				'description' => __( 'Change the default color for all the buttons when hovered.', 'refined' ),
			    'label'       => __( 'Button Background Color ON HOVER', 'refined' ),
			    'section'     => 'colors',
			    'settings'    => 'refined_buttonhover_color',
			)
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'refined_buttonhoverborder_color',
			array(
				'description' => __( 'Change the default color for the border on all the buttons when hovered.', 'refined' ),
			    'label'       => __( 'Button Hover Border Color ON HOVER', 'refined' ),
			    'section'     => 'colors',
			    'settings'    => 'refined_buttonhoverborder_color',
			)
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'refined_buttonhovertext_color',
			array(
				'description' => __( 'Change the default color for the text on your buttons when hovered.', 'refined' ),
			    'label'       => __( 'Button Hover Text Color ON HOVER', 'refined' ),
			    'section'     => 'colors',
			    'settings'    => 'refined_buttonhovertext_color',
			)
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'refined_newsletter_color',
			array(
				'description' => __( 'Change the default background color of the newsletter that appears on your sidebar. This color also affects the background color on the dates, the featured titles on the home page, and the background color on the convert kit newsletter.', 'refined' ),
			    'label'       => __( 'Newsletter Background Color', 'refined' ),
			    'section'     => 'colors',
			    'settings'    => 'refined_newsletter_color',
			)
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'refined_footer_color',
			array(
				'description' => __( 'Change the default background color of the footer widgets and footer credits.', 'refined' ),
			    'label'       => __( 'Footer Background Color', 'refined' ),
			    'section'     => 'colors',
			    'settings'    => 'refined_footer_color',
			)
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'refined_footertext_color',
			array(
				'description' => __( 'Change the default text color of the footer widgets and footer credits.', 'refined' ),
			    'label'       => __( 'Footer Text Color', 'refined' ),
			    'section'     => 'colors',
			    'settings'    => 'refined_footertext_color',
			)
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'refined_announcement_color',
			array(
				'description' => __( 'Change the default background color on the top announcement bar.', 'refined' ),
			    'label'       => __( 'Announcement Background Color', 'refined' ),
			    'section'     => 'colors',
			    'settings'    => 'refined_announcement_color',
			)
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'refined_announcementtext_color',
			array(
				'description' => __( 'Change the default text color on the top announcement bar.', 'refined' ),
			    'label'       => __( 'Announcement Text Color', 'refined' ),
			    'section'     => 'colors',
			    'settings'    => 'refined_announcementtext_color',
			)
		)
	);

    // Add front page setting to the Customizer.
    $wp_customize->add_section( 'refined_blog_section', array(
        'title'       => __( 'Front Page Content Settings', 'refined' ),
        'description' => __( 'Choose if you would like to display the content section below widget sections on the front page.', 'refined' ),
        'priority'    => 75.01,
    ));

    // Add front page setting to the Customizer.
    $wp_customize->add_setting( 'refined_blog_setting', array(
        'default'    => 'true',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
    ));

    $wp_customize->add_control( new WP_Customize_Control(
        $wp_customize, 'refined_blog_control', array(
			'label'       => __( 'Front Page Content Section Display', 'refined' ),
			'description' => __( 'Show or Hide the content section. The section will display on the front page by default.', 'refined' ),
			'section'     => 'refined_blog_section',
			'settings'    => 'refined_blog_setting',
			'type'        => 'select',
			'choices'     => array(
				'false' => __( 'Hide content section', 'refined' ),
				'true'  => __( 'Show content section', 'refined' ),
			),
        ))
	);

    $wp_customize->add_setting( 'refined_blog_text', array(
		'default'           => __( 'the Blog', 'refined' ),
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'wp_kses_post',
		'type'              => 'option',
    ));

    $wp_customize->add_control( new WP_Customize_Control(
        $wp_customize, 'refined_blog_text_control', array(
			'label'       => __( 'Blog Section Heading Text', 'refined' ),
			'description' => __( 'Choose the heading text you would like to display above posts on the front page.<br /><br />This text will show when displaying posts and using widgets on the front page.', 'refined' ),
			'section'     => 'refined_blog_section',
			'settings'    => 'refined_blog_text',
			'type'        => 'text',
		))
	);

}
