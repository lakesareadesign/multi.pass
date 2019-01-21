<?php
/**
 * Authority Pro.
 *
 * This file adds the Customizer additions to the Authority Pro Theme.
 *
 * @package Authority
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/authority/
 */

add_action( 'customize_register', 'authority_customizer_register' );
/**
 * Registers settings and controls with the Customizer.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function authority_customizer_register( $wp_customize ) {

	// Adds custom heading controls to WordPress Theme Customizer.
	require_once get_stylesheet_directory() . '/lib/customizer/controls.php';

	// Main settings panel.
	$wp_customize->add_panel(
		'authority-settings', array(
			'description' => __( 'Set up the Authority Pro settings and defaults.', 'authority-pro' ),
			'priority'    => 80,
			'title'       => __( 'Authority Pro Settings', 'authority-pro' ),
		)
	);

	// Basic settings section.
	$wp_customize->add_section(
		'authority-basic-settings', array(
			'description' => sprintf( '<strong>%s</strong>', __( 'Modify the Authority Pro Theme basic settings.', 'authority-pro' ) ),
			'title'       => __( 'Basic Settings', 'authority-pro' ),
			'panel'       => 'authority-settings',
		)
	);

	// Hero Visiblity.
	$wp_customize->add_setting(
		'authority-show-hero-section', array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'authority-show-hero-section', array(
			'label'       => __( 'Show the front page hero section?', 'authority-pro' ),
			'description' => __( 'Check the box to display the hero section on the top of the front page.', 'authority-pro' ),
			'section'     => 'authority-basic-settings',
			'settings'    => 'authority-show-hero-section',
			'type'        => 'checkbox',
		)
	);

	// Styled paragraph settings.
	$wp_customize->add_setting(
		'authority-use-paragraph-styling', array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'authority-use-paragraph-styling', array(
			'label'       => __( 'Enable the "intro" paragraph style on single posts?', 'authority-pro' ),
			'description' => __( 'Check the box to automatically apply the "intro" font size and style to the first paragraph of all single posts.', 'authority-pro' ),
			'section'     => 'authority-basic-settings',
			'settings'    => 'authority-use-paragraph-styling',
			'type'        => 'checkbox',
		)
	);

	// Add single image setting to the Customizer.
	$wp_customize->add_setting(
		'authority_single_image_setting', array(
			'default'           => authority_customizer_get_default_image_setting(),
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'authority_single_image_setting', array(
			'label'       => __( 'Show featured image on posts?', 'authority-pro' ),
			'description' => __( 'Check the box if you would like to display the featured image above the content on single posts.', 'authority-pro' ),
			'section'     => 'authority-basic-settings',
			'type'        => 'checkbox',
			'settings'    => 'authority_single_image_setting',
		)
	);

	// Top Banner Section.
	$wp_customize->add_section(
		'authority-top-banner-settings', array(
			'description' => sprintf( '<strong>%s</strong><p>%s</p>', __( 'Modify the settings for the top banner section.', 'authority-pro' ), __( 'Each time the customizer is opened, the top banner will be displayed in the live preview so you can easily customize the content.', 'authority-pro' ) ),
			'title'       => __( 'Top Banner Section', 'authority-pro' ),
			'panel'       => 'authority-settings',
		)
	);

	$wp_customize->add_setting(
		'authority-top-banner-visibility', array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'authority-top-banner-visibility', array(
			'description' => __( 'Check the box to display a dismissible banner at the top of all pages.', 'authority-pro' ),
			'label'       => __( 'Show Top Banner?', 'authority-pro' ),
			'section'     => 'authority-top-banner-settings',
			'settings'    => 'authority-top-banner-visibility',
			'type'        => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'authority-top-banner-text', array(
			'default'           => authority_get_default_top_banner_text(),
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh',
		)
	);

	$wp_customize->add_control(
		'authority-top-banner-text', array(
			'description' => __( 'Change the text for the dismissible banner (allows HTML).', 'authority-pro' ),
			'label'       => __( 'Top Banner Text', 'authority-pro' ),
			'section'     => 'authority-top-banner-settings',
			'settings'    => 'authority-top-banner-text',
			'type'        => 'textarea',
		)
	);

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'authority-top-banner-text', array(
				'selector'        => '.authority-top-banner',
				'settings'        => array( 'authority-top-banner-text' ),
				'render_callback' => function() {
					return get_theme_mod( 'authority-top-banner-text' );
				},
			)
		);
	}

	// Hero Portrait Section.
	$wp_customize->add_section(
		'authority-front-page-hero-portrait', array(
			'active_callback' => 'is_front_page',
			'description'     => sprintf( '<strong>%s</strong>', __( 'Modify the settings for the front page hero portrait section.', 'authority-pro' ) ),
			'title'           => __( 'Hero Portrait Section', 'authority-pro' ),
			'panel'           => 'authority-settings',
		)
	);

	// Hero Title.
	$wp_customize->add_setting(
		'authority-hero-title-text', array(
			'default'           => authority_get_default_hero_title_text(),
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh',
		)
	);

	$wp_customize->add_control(
		'authority-hero-title-text', array(
			'description' => __( 'Change the title text for the front page hero section.', 'authority-pro' ),
			'label'       => __( 'Hero Title', 'authority-pro' ),
			'section'     => 'authority-front-page-hero-portrait',
			'settings'    => 'authority-hero-title-text',
			'type'        => 'textarea',
		)
	);

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'authority-hero-title-text', array(
				'selector'        => '.hero-title',
				'settings'        => array( 'authority-hero-title-text' ),
				'render_callback' => function() {
					return get_theme_mod( 'authority-hero-title-text' );
				},
			)
		);
	}

	// Hero Intro Paragraph.
	$wp_customize->add_setting(
		'authority-hero-description-text', array(
			'default'           => authority_get_default_hero_desc_text(),
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh',
		)
	);

	$wp_customize->add_control(
		'authority-hero-description-text', array(
			'description' => __( 'Change the description text for the front page hero section.', 'authority-pro' ),
			'label'       => __( 'Hero Intro Paragraph', 'authority-pro' ),
			'section'     => 'authority-front-page-hero-portrait',
			'settings'    => 'authority-hero-description-text',
			'type'        => 'textarea',
		)
	);

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'authority-hero-description-text', array(
				'selector'        => '.hero-description',
				'settings'        => array( 'authority-hero-description-text' ),
				'render_callback' => function() {
					return get_theme_mod( 'authority-hero-description-text' );
				},
			)
		);
	}

	// Hero Portrait.
	$wp_customize->add_setting(
		'authority-hero-portrait-image', array(
			'default'           => authority_get_default_portrait_image(),
			'sanitize_callback' => 'esc_attr',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize, 'authority-hero-portrait-image', array(
				'description' => __( 'Select a portrait image. For best results on all devices, the recommended image size is about 800px by 1200px.', 'authority-pro' ),
				'label'       => __( 'Hero Portrait Image', 'authority-pro' ),
				'section'     => 'authority-front-page-hero-portrait',
				'settings'    => 'authority-hero-portrait-image',
			)
		)
	);

	// Portrait caption.
	$wp_customize->add_setting(
		'authority-hero-caption-text', array(
			'default'           => authority_get_default_hero_caption_text(),
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh',
		)
	);

	$wp_customize->add_control(
		'authority-hero-caption-text', array(
			'description'     => __( 'Change the caption text for the portrait image.', 'authority-pro' ),
			'label'           => __( 'Hero Portrait Caption', 'authority-pro' ),
			'section'         => 'authority-front-page-hero-portrait',
			'settings'        => 'authority-hero-caption-text',
			'active_callback' => 'authority_is_portait_set',
		)
	);

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'authority-hero-caption-text', array(
				'selector'        => '.hero-portrait-caption',
				'settings'        => array( 'authority-hero-caption-text' ),
				'render_callback' => function() {
					return get_theme_mod( 'authority-hero-caption-text' );
				},
			)
		);
	}

	// Hero Logo Section.
	$wp_customize->add_section(
		'authority-front-page-hero-logos', array(
			'description'     => sprintf( '<strong>%s</strong>', __( 'Modify the settings for the front page logo section.', 'authority-pro' ) ),
			'title'           => __( 'Hero Logo Section', 'authority-pro' ),
			'active_callback' => 'is_front_page',
			'panel'           => 'authority-settings',
		)
	);

	// Logo header.
	$wp_customize->add_setting(
		'authority-hero-logo-heading', array(
			'default'           => authority_get_default_hero_logo_heading(),
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh',
		)
	);

	$wp_customize->add_control(
		'authority-hero-logo-heading', array(
			'description' => __( 'Change the heading text that displays above the logo section if any logos are uploaded.', 'authority-pro' ),
			'label'       => __( 'Hero Logos Heading Text', 'authority-pro' ),
			'section'     => 'authority-front-page-hero-logos',
			'settings'    => 'authority-hero-logo-heading',
		)
	);

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'authority-hero-logo-heading', array(
				'selector'        => '.hero-logos-header',
				'settings'        => array( 'authority-hero-logo-heading' ),
				'render_callback' => function() {
					return get_theme_mod( 'authority-hero-logo-heading' );
				},
			)
		);
	}

	$wp_customize->add_control(
		new Authority_Customizer_Heading_Control(
			$wp_customize, 'authority-logo-heading', array(
				'section'         => 'authority-front-page-hero-logos',
				'settings'        => array(),
				'label'           => __( 'Hero Logo Images', 'authority-pro' ),
				'instructions'    => sprintf( '<p>%s</p>', __( 'You can upload and crop up to 6 logo images.', 'authority-pro' ) ),
				'description'     => __( 'Each logo will be displayed at a maximum size of 200px by 40px. The recommended logo size is 400px wide by 80px tall.', 'authority-pro' ),
				'active_callback' => 'is_front_page',
				'type'            => 'heading',
			)
		)
	);

	// Hero Logo Images.
	$logos = array(
		'logo1' => __( 'Logo 1', 'authority-pro' ),
		'logo2' => __( 'Logo 2', 'authority-pro' ),
		'logo3' => __( 'Logo 3', 'authority-pro' ),
		'logo4' => __( 'Logo 4', 'authority-pro' ),
		'logo5' => __( 'Logo 5', 'authority-pro' ),
		'logo6' => __( 'Logo 6', 'authority-pro' ),
	);

	foreach ( $logos as $field => $label ) {
		$wp_customize->add_setting(
			"authority-hero-logos-images[$field]", array(
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Cropped_Image_Control(
				$wp_customize, "authority-hero-logos-images[$field]", array(
					'description' => sprintf( __( 'Select an image to display for %s.', 'authority-pro' ), $label ),
					'label'       => sprintf( __( '%s', 'authority-pro' ), $label ),
					'section'     => 'authority-front-page-hero-logos',
					'settings'    => "authority-hero-logos-images[$field]",
					'flex_width'  => true,
					'flex_height' => true,
					'height'      => 80,
					'width'       => 400,
				)
			)
		);
	}

	// Color customization.
	$wp_customize->add_setting(
		'authority_primary_color', array(
			'default'           => authority_customizer_get_default_primary_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'authority_primary_color', array(
				'description' => __( 'Change the default primary color (i.e. linked titles, menu links, post info links, buttons, and more).', 'authority-pro' ),
				'label'       => __( 'Primary Color', 'authority-pro' ),
				'section'     => 'colors',
				'settings'    => 'authority_primary_color',
			)
		)
	);

	// Grid layout options.
	$wp_customize->add_control(
		new Authority_Customizer_Heading_Control(
			$wp_customize, 'authority_grid_options_link', array(
				'label'        => __( 'Grid Layout Options', 'authority-pro' ),
				'instructions' => sprintf( '<p>%s</p>', __( 'These options apply to the Grid Layout if selected for categories and tags.', 'authority-pro' ) ),
				'priority'     => 98,
				'section'      => 'genesis_archives',
				'settings'     => array(),
				'type'         => 'heading',
			)
		)
	);

	$wp_customize->add_setting(
		'authority-grid-option', array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'authority-grid-option', array(
			'label'    => __( 'Apply the grid layout as the default layout for categories and tags?', 'authority-pro' ),
			'priority' => 99,
			'section'  => 'genesis_archives',
			'settings' => 'authority-grid-option',
			'type'     => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'authority-grid-thumbnail', array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'authority-grid-thumbnail', array(
			'label'    => __( 'Display the featured image above the title?', 'authority-pro' ),
			'priority' => 100,
			'section'  => 'genesis_archives',
			'settings' => 'authority-grid-thumbnail',
			'type'     => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'authority-content-archive', array(
			'default'           => authority_content_archive_option(),
			'sanitize_callback' => 'authority_sanitize_select',
		)
	);

	$wp_customize->add_control(
		'authority-content-archive', array(
			'label'    => __( 'Select one of the following', 'authority-pro' ),
			'priority' => 101,
			'section'  => 'genesis_archives',
			'settings' => 'authority-content-archive',
			'type'     => 'select',
			'choices'  => array(
				'full'     => __( 'Entry content', 'authority-pro' ),
				'excerpts' => __( 'Entry excerpts', 'authority-pro' ),
			),
		)
	);

	$wp_customize->add_setting(
		'authority-grid-archive-limit', array(
			'default'           => authority_get_default_grid_limit(),
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'authority-grid-archive-limit', array(
			'label'    => __( 'Limit content to how many characters? (Enter 0 for no limit)', 'authority-pro' ),
			'priority' => 102,
			'section'  => 'genesis_archives',
			'settings' => 'authority-grid-archive-limit',
			'type'     => 'number',
		)
	);

	$wp_customize->add_setting(
		'authority-grid-posts-per-page', array(
			'default'           => authority_get_default_grid_posts_per_page(),
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'authority-grid-posts-per-page', array(
			'label'    => __( 'Grid Layout Posts Per Page', 'authority-pro' ),
			'priority' => 103,
			'section'  => 'genesis_archives',
			'settings' => 'authority-grid-posts-per-page',
			'type'     => 'number',
		)
	);

}

/**
 * Sanitizes select option to ensure they're among the custom control's choices.
 *
 * @since 1.0.0
 *
 * @param string               $input   The select key.
 * @param WP_Customize_Setting $setting The setting object.
 * @return string The sanitized select key.
 */
function authority_sanitize_select( $input, $setting ) {

	// Ensures input is a slug.
	$input = sanitize_key( $input );

	// Gets a list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;

	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );

}

/**
 * Determines if portrait image is active.
 *
 * @since 1.0.0
 *
 * @return bool True if set.
 */
function authority_is_portait_set() {

	$portrait = get_theme_mod( 'authority-hero-portrait-image', authority_get_default_portrait_image() );

	if ( '' === $portrait ) {
		return false;
	}

	return true;

}
