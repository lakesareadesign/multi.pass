<?php
/**
 * Breakthrough Pro.
 *
 * This file adds the Customizer additions to the Breakthrough Pro Theme.
 *
 * @package Breakthrough_Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/breakthrough/
 */

add_action( 'customize_register', 'breakthrough_customizer_register' );
/**
 * Registers settings and controls with the Customizer.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function breakthrough_customizer_register( $wp_customize ) {

	$wp_customize->add_panel(
		'breakthrough_settings', array(
			'description' => __( 'Customize the Breakthrough Pro Theme.', 'breakthrough-pro' ),
			'priority'    => 80,
			'title'       => __( 'Breakthrough Pro Settings', 'breakthrough-pro' ),
		)
	);

	// Hero Section.
	$wp_customize->add_section(
		'breakthrough_hero_section_settings', array(
			'active_callback' => 'is_front_page',
			'description'     => sprintf( '<strong>%s</strong>', __( 'Modify the settings for the front page hero section.', 'breakthrough-pro' ) ),
			'title'           => __( 'Hero Section Settings', 'breakthrough-pro' ),
			'panel'           => 'breakthrough_settings',
		)
	);

	// Hero Visiblity.
	$wp_customize->add_setting(
		'breakthrough_show_hero_section', array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'breakthrough_show_hero_section', array(
			'label'       => __( 'Show the front page hero section?', 'breakthrough-pro' ),
			'description' => __( 'Check the box to display the hero section on the top of the front page.', 'breakthrough-pro' ),
			'section'     => 'breakthrough_hero_section_settings',
			'settings'    => 'breakthrough_show_hero_section',
			'type'        => 'checkbox',
		)
	);

	// Hero Title.
	$wp_customize->add_setting(
		'breakthrough_hero_title_text', array(
			'default'           => breakthrough_get_default_hero_title_text(),
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh',
		)
	);

	$wp_customize->add_control(
		'breakthrough_hero_title_text', array(
			'description' => __( 'Change the title text for the front page hero section.', 'breakthrough-pro' ),
			'label'       => __( 'Hero Title', 'breakthrough-pro' ),
			'section'     => 'breakthrough_hero_section_settings',
			'settings'    => 'breakthrough_hero_title_text',
			'type'        => 'textarea',
		)
	);

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'breakthrough_hero_title_text', array(
				'selector'        => '.hero-title',
				'settings'        => array( 'breakthrough_hero_title_text' ),
				'render_callback' => function() {
					return get_theme_mod( 'breakthrough_hero_title_text' );
				},
			)
		);
	}

	// Hero Button.
	$wp_customize->add_setting(
		'breakthrough_hero_button_text', array(
			'default'           => breakthrough_get_default_hero_button_text(),
			'sanitize_callback' => 'esc_html',
			'transport'         => isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh',
		)
	);

	$wp_customize->add_control(
		'breakthrough_hero_button_text', array(
			'description' => __( 'Change the text for the colored button in the front page hero section.', 'breakthrough-pro' ),
			'label'       => __( 'Hero Colored Button Text', 'breakthrough-pro' ),
			'section'     => 'breakthrough_hero_section_settings',
			'settings'    => 'breakthrough_hero_button_text',
		)
	);

	$wp_customize->add_setting(
		'breakthrough_hero_button_url', array(
			'sanitize_callback' => 'esc_url',
			'transport'         => isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh',
		)
	);

	$wp_customize->add_control(
		'breakthrough_hero_button_url', array(
			'description' => __( 'Change the url for the colored button in the front page hero section.', 'breakthrough-pro' ),
			'label'       => __( 'Hero Colored Button URL', 'breakthrough-pro' ),
			'section'     => 'breakthrough_hero_section_settings',
			'settings'    => 'breakthrough_hero_button_url',
		)
	);

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'breakthrough_hero_button_text', array(
				'selector'        => '.hero-section .button',
				'settings'        => array( 'breakthrough_hero_button_text' ),
				'render_callback' => function() {
					return get_theme_mod( 'breakthrough_hero_button_text' );
				},
			)
		);
	}

	// Image Settings section.
	$wp_customize->add_section(
		'breakthrough_image_settings', array(
			'description' => sprintf( '<strong>%s</strong>', __( 'Modify the images displayed on the front page, the default image shown on inside pages, and the footer image. The recommended image size is 1600px wide by 420px tall. Larger images will be cropped to that size.', 'breakthrough-pro' ) ),
			'title'       => __( 'Image Settings', 'breakthrough-pro' ),
			'panel'       => 'breakthrough_settings',
		)
	);

	// Front Page Image 1.
	$wp_customize->add_setting(
		'breakthrough_front_page_image_1', array(
			'default'           => breakthrough_get_default_front_page_image_1(),
			'sanitize_callback' => 'esc_attr',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize, 'breakthrough_front_page_image_1', array(
				'description' => __( 'Select an image for the hero section of the front page.', 'breakthrough-pro' ),
				'label'       => __( 'Front Page Image 1', 'breakthrough-pro' ),
				'section'     => 'breakthrough_image_settings',
				'settings'    => 'breakthrough_front_page_image_1',
			)
		)
	);

	// Front Page Image 2.
	$wp_customize->add_setting(
		'breakthrough_front_page_image_2', array(
			'default'           => breakthrough_get_default_front_page_image_2(),
			'sanitize_callback' => 'esc_attr',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize, 'breakthrough_front_page_image_2', array(
				'description' => __( 'Select an image to appear if the Front Page 1, Front Page 2 or Front Page 3 sections are in use.', 'breakthrough-pro' ),
				'label'       => __( 'Front Page Image 2', 'breakthrough-pro' ),
				'section'     => 'breakthrough_image_settings',
				'settings'    => 'breakthrough_front_page_image_2',
			)
		)
	);

	// Front Page Image 3.
	$wp_customize->add_setting(
		'breakthrough_front_page_image_3', array(
			'default'           => breakthrough_get_default_front_page_image_3(),
			'sanitize_callback' => 'esc_attr',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize, 'breakthrough_front_page_image_3', array(
				'description' => __( 'Select an image to appear if the Front Page 4 or Front Page 5 sections are in use.', 'breakthrough-pro' ),
				'label'       => __( 'Front Page Image 3', 'breakthrough-pro' ),
				'section'     => 'breakthrough_image_settings',
				'settings'    => 'breakthrough_front_page_image_3',
			)
		)
	);

	// Default Posts and Page Image.
	$wp_customize->add_setting(
		'breakthrough_default_image', array(
			'default'           => breakthrough_get_default_front_page_image_1(), // Use same default as front page 1.
			'sanitize_callback' => 'esc_attr',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize, 'breakthrough_default_image', array(
				'description' => __( 'Select an image to use at the top of posts, pages, and portfolio items if a featured image is not set.', 'breakthrough-pro' ),
				'label'       => __( 'Default Post, Page, and Portfolio Image', 'breakthrough-pro' ),
				'section'     => 'breakthrough_image_settings',
				'settings'    => 'breakthrough_default_image',
			)
		)
	);

	// Footer image.
	$wp_customize->add_setting(
		'breakthrough_footer_image', array(
			'default'           => breakthrough_get_default_page_footer_image(),
			'sanitize_callback' => 'esc_attr',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize, 'breakthrough_footer_image', array(
				'description' => __( 'Select an image for the call to action section above the footer.', 'breakthrough-pro' ),
				'label'       => __( 'Footer Image', 'breakthrough-pro' ),
				'section'     => 'breakthrough_image_settings',
				'settings'    => 'breakthrough_footer_image',
			)
		)
	);

	// Color 1 settings.
	$wp_customize->add_setting(
		'breakthrough_primary_color', array(
			'default'           => breakthrough_customizer_get_primary_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'breakthrough_primary_color', array(
				'description' => __( 'Change the first color used in titles, menu links, post info links, default buttons, image overlays and more.', 'breakthrough-pro' ),
				'label'       => __( 'Color 1', 'breakthrough-pro' ),
				'section'     => 'colors',
				'settings'    => 'breakthrough_primary_color',
			)
		)
	);

	// Color 2 settings.
	$wp_customize->add_setting(
		'breakthrough_secondary_color', array(
			'default'           => breakthrough_customizer_get_secondary_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'breakthrough_secondary_color', array(
				'description' => __( 'Change the second color used in call-to-action and primary buttons, breadcrumbs, links, and more.', 'breakthrough-pro' ),
				'label'       => __( 'Color 2', 'breakthrough-pro' ),
				'section'     => 'colors',
				'settings'    => 'breakthrough_secondary_color',
			)
		)
	);

	// Basic settings section.
	$wp_customize->add_section(
		'breakthrough_basic_settings', array(
			'description' => sprintf( '<strong>%s</strong>', __( 'Modify the Breakthrough Pro Theme basic settings.', 'breakthrough-pro' ) ),
			'title'       => __( 'Basic Settings', 'breakthrough-pro' ),
			'panel'       => 'breakthrough_settings',
		)
	);

	// Styled paragraph settings.
	$wp_customize->add_setting(
		'breakthrough_use_paragraph_styling', array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'breakthrough_use_paragraph_styling', array(
			'label'       => __( 'Enable the "intro" paragraph style on single posts?', 'breakthrough-pro' ),
			'description' => __( 'Check the box to automatically apply the "intro" font size and style to the first paragraph of all single posts.', 'breakthrough-pro' ),
			'section'     => 'breakthrough_basic_settings',
			'settings'    => 'breakthrough_use_paragraph_styling',
			'type'        => 'checkbox',
		)
	);

	// Add single post image setting to the Customizer.
	$wp_customize->add_setting(
		'breakthrough_post_image_setting', array(
			'default'           => breakthrough_customizer_get_default_post_image_setting(),
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'breakthrough_post_image_setting', array(
			'label'       => __( 'Show featured image on posts?', 'breakthrough-pro' ),
			'description' => __( 'Check the box if you would like to display the featured image above the content on single posts.', 'breakthrough-pro' ),
			'section'     => 'breakthrough_basic_settings',
			'type'        => 'checkbox',
			'settings'    => 'breakthrough_post_image_setting',
		)
	);

	// Add page setting to the Customizer.
	$wp_customize->add_setting(
		'breakthrough_page_image_setting', array(
			'default'           => breakthrough_customizer_get_default_page_image_setting(),
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'breakthrough_page_image_setting', array(
			'label'       => __( 'Show featured image on pages?', 'breakthrough-pro' ),
			'description' => __( 'Check the box if you would like to display the featured image above the content on single pages.', 'breakthrough-pro' ),
			'section'     => 'breakthrough_basic_settings',
			'type'        => 'checkbox',
			'settings'    => 'breakthrough_page_image_setting',
		)
	);

	// Add portfolio image setting to the Customizer if portfolio in use.
	if ( post_type_exists( 'portfolio' ) ) {
		$wp_customize->add_setting(
			'breakthrough_portfolio_image_setting', array(
				'default'           => breakthrough_customizer_get_default_portfolio_image_setting(),
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			'breakthrough_portfolio_image_setting', array(
				'label'       => __( 'Show featured image on portfolio items?', 'breakthrough-pro' ),
				'description' => __( 'Check the box if you would like to display the featured image above the content on single portfolio items.', 'breakthrough-pro' ),
				'section'     => 'breakthrough_basic_settings',
				'type'        => 'checkbox',
				'settings'    => 'breakthrough_portfolio_image_setting',
			)
		);
	}

	// Add option to turn off image tints/overlays.
	$wp_customize->add_setting(
		'breakthrough_color_overlay_setting', array(
			'default'           => breakthrough_customizer_get_default_color_overlay_setting(),
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'breakthrough_color_overlay_setting', array(
			'label'       => __( 'Show a colored overlay on featured images?', 'breakthrough-pro' ),
			'description' => __( 'Check the box to display a colored overlay on featured and front page images in supported browsers. Alter the tint by changing Color 1 in the Colors settings. The overlay will not appear on product images.', 'breakthrough-pro' ),
			'section'     => 'breakthrough_basic_settings',
			'type'        => 'checkbox',
			'settings'    => 'breakthrough_color_overlay_setting',
		)
	);

}
