<?php
/**
 * News Pro.
 *
 * This file adds the Customizer additions to the News Pro Theme.
 *
 * @package News
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/news/
 */

add_action( 'customize_register', 'news_customizer_register' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 3.2.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function news_customizer_register() {

	global $wp_customize;

	$wp_customize->add_setting(
		'news_link_color',
		array(
			'default'           => news_customizer_get_default_link_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'news_link_color',
			array(
				'description' => __( 'Change the color for links, the hover color for linked titles, and more.', 'news-pro' ),
				'label'       => __( 'Link Color', 'news-pro' ),
				'section'     => 'colors',
				'settings'    => 'news_link_color',
			)
		)
	);

	// Footer Link color.
	$wp_customize->add_setting(
		'news_footer_link_color',
		array(
			'default'           => news_customizer_get_default_link_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'news_footer_link_color',
			array(
				'description' => __( 'Change the hover color for links in the footer widgets and footer area.', 'news-pro' ),
				'label'       => __( 'Footer Link Color', 'news-pro' ),
				'section'     => 'colors',
				'settings'    => 'news_footer_link_color',
			)
		)
	);

	$wp_customize->add_setting(
		'news_accent_color',
		array(
			'default'           => news_customizer_get_default_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'news_accent_color',
			array(
				'description' => __( 'Change the hover color for buttons and more.', 'news-pro' ),
				'label'       => __( 'Accent Color', 'news-pro' ),
				'section'     => 'colors',
				'settings'    => 'news_accent_color',
			)
		)
	);

}
