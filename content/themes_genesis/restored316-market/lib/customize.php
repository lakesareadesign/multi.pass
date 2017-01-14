<?php

/**
 * This file adds the Customizer to the Market Theme.
 *
 * @package      Market
 * @subpackage   Customizations
 * @link         http://restored316designs.com/themes
 * @author       Lauren Gaige // Restored 316 LLC
 * @copyright    Copyright (c) 2015, Restored 316 LLC, Released 05/03/2016
 * @license      GPL-2.0+
 */
 
//* Get default primary colors for Customizer.
function market_customizer_get_default_text_color() {
	return '#666666';
}

function market_customizer_get_default_links_color() {
	return '#7d947d';
}

function market_customizer_get_default_widgettitles_color() {
	return '#666666';
}

function market_customizer_get_default_homeslider_color() {
	return '#666666';
}

function market_customizer_get_default_hometitles_color() {
	return '#7d947d';
}

function market_customizer_get_default_button_color() {
	return '#ffead7';
}

function market_customizer_get_default_buttonborder_color() {
	return '#f7ddc6';
}

function market_customizer_get_default_buttontext_color() {
	return '#666666';
}

function market_customizer_get_default_buttonhover_color() {
	return '#dee4de';
}

function market_customizer_get_default_buttonhoverborder_color() {
	return '#7d947d';
}

function market_customizer_get_default_buttonhovertext_color() {
	return '#666666';
}

function market_customizer_get_default_footer_color() {
	return '#FAF9F7';
}

function market_customizer_get_default_footertext_color() {
	return '#666666';
}

//* Register settings and controls with the Customizer.
add_action( 'customize_register', 'market_customizer_register' );
function market_customizer_register() {

	global $wp_customize;

	
	$wp_customize->add_setting(
		'market_text_color',
		array(
			'default'           => market_customizer_get_default_text_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_setting(
		'market_links_color',
		array(
			'default'           => market_customizer_get_default_links_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	
	$wp_customize->add_setting(
		'market_widgettitles_color',
		array(
			'default'           => market_customizer_get_default_widgettitles_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	
	$wp_customize->add_setting(
		'market_homeslider_color',
		array(
			'default'           => market_customizer_get_default_homeslider_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	
	$wp_customize->add_setting(
		'market_hometitles_color',
		array(
			'default'           => market_customizer_get_default_hometitles_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	
	$wp_customize->add_setting(
		'market_button_color',
		array(
			'default'           => market_customizer_get_default_button_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	
	$wp_customize->add_setting(
		'market_buttonborder_color',
		array(
			'default'           => market_customizer_get_default_buttonborder_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	
	$wp_customize->add_setting(
		'market_buttontext_color',
		array(
			'default'           => market_customizer_get_default_buttontext_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	
	$wp_customize->add_setting(
		'market_buttonhover_color',
		array(
			'default'           => market_customizer_get_default_buttonhover_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	
	$wp_customize->add_setting(
		'market_buttonhoverborder_color',
		array(
			'default'           => market_customizer_get_default_buttonhoverborder_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	
	$wp_customize->add_setting(
		'market_buttonhovertext_color',
		array(
			'default'           => market_customizer_get_default_buttonhovertext_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	
	$wp_customize->add_setting(
		'market_footer_color',
		array(
			'default'           => market_customizer_get_default_footer_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	
	$wp_customize->add_setting(
		'market_footertext_color',
		array(
			'default'           => market_customizer_get_default_footertext_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'market_text_color',
			array(
				'description' => __( 'Change the default color for all the body text across the site.', 'market' ),
			    'label'       => __( 'Text Color', 'market' ),
			    'section'     => 'colors',
			    'settings'    => 'market_text_color',
			)
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'market_links_color',
			array(
				'description' => __( 'Change the default color for all your links.', 'market' ),
			    'label'       => __( 'Links Color', 'market' ),
			    'section'     => 'colors',
			    'settings'    => 'market_links_color',
			)
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'market_widgettitles_color',
			array(
				'description' => __( 'Change the default color for all the widget titles.', 'market' ),
			    'label'       => __( 'Widget Title Color', 'market' ),
			    'section'     => 'colors',
			    'settings'    => 'market_widgettitles_color',
			)
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'market_homeslider_color',
			array(
				'description' => __( 'Change the default color for the text over the home page slider.', 'market' ),
			    'label'       => __( 'Home Slider Text Color', 'market' ),
			    'section'     => 'colors',
			    'settings'    => 'market_homeslider_color',
			)
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'market_hometitles_color',
			array(
				'description' => __( 'Change the default color for all the titles across the home page.', 'market' ),
			    'label'       => __( 'Home Page Titles Color', 'market' ),
			    'section'     => 'colors',
			    'settings'    => 'market_hometitles_color',
			)
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'market_button_color',
			array(
				'description' => __( 'Change the default color for all the buttons.', 'market' ),
			    'label'       => __( 'Button Background olor', 'market' ),
			    'section'     => 'colors',
			    'settings'    => 'market_button_color',
			)
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'market_buttonborder_color',
			array(
				'description' => __( 'Change the default color for the border on all the buttons.', 'market' ),
			    'label'       => __( 'Button Border Color', 'market' ),
			    'section'     => 'colors',
			    'settings'    => 'market_buttonborder_color',
			)
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'market_buttontext_color',
			array(
				'description' => __( 'Change the default color for the text on your buttons.', 'market' ),
			    'label'       => __( 'Button Text Color', 'market' ),
			    'section'     => 'colors',
			    'settings'    => 'market_buttontext_color',
			)
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'market_buttonhover_color',
			array(
				'description' => __( 'Change the default color for all the buttons on hover.', 'market' ),
			    'label'       => __( 'Button Background Hover Color', 'market' ),
			    'section'     => 'colors',
			    'settings'    => 'market_buttonhover_color',
			)
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'market_buttonhoverborder_color',
			array(
				'description' => __( 'Change the default color for the border on all the buttons when hovered.', 'market' ),
			    'label'       => __( 'Button Hover Border Color', 'market' ),
			    'section'     => 'colors',
			    'settings'    => 'market_buttonhoverborder_color',
			)
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'market_buttonhovertext_color',
			array(
				'description' => __( 'Change the default color for the text on your buttons when hovered.', 'market' ),
			    'label'       => __( 'Button Hover Text Color', 'market' ),
			    'section'     => 'colors',
			    'settings'    => 'market_buttonhovertext_color',
			)
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'market_footer_color',
			array(
				'description' => __( 'Change the default color for the footer and newsletter areas.', 'market' ),
			    'label'       => __( 'Footer & Enews Color', 'market' ),
			    'section'     => 'colors',
			    'settings'    => 'market_footer_color',
			)
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'market_footertext_color',
			array(
				'description' => __( 'Change the default color for the text on the footer and newsletter areas.', 'market' ),
			    'label'       => __( 'Footer & Enews Text Color', 'market' ),
			    'section'     => 'colors',
			    'settings'    => 'market_footertext_color',
			)
		)
	);

    //* Add front page setting to the Customizer
    $wp_customize->add_section( 'market_blog_section', array(
        'title'    => __( 'Front Page Content Settings', 'market' ),
        'description' => __( 'Choose if you would like to display the content section below widget sections on the front page.', 'market' ),
        'priority' => 75.01,
    ));

    //* Add front page setting to the Customizer
    $wp_customize->add_setting( 'market_blog_setting', array(
        'default'           => 'true',
        'capability'        => 'edit_theme_options',
        'type'              => 'option',
    ));

    $wp_customize->add_control( new WP_Customize_Control( 
        $wp_customize, 'market_blog_control', array(
			'label'       => __( 'Front Page Content Section Display', 'market' ),
			'description' => __( 'Show or Hide the content section. The section will display on the front page by default.', 'market' ),
			'section'     => 'market_blog_section',
			'settings'    => 'market_blog_setting',
			'type'        => 'select',
			'choices'     => array(                    
				'false'   => __( 'Hide content section', 'market' ),
				'true'    => __( 'Show content section', 'market' ),
			),
        ))
	);
	
    $wp_customize->add_setting( 'market_blog_text', array(
		'default'           => __( 'the Blog', 'market' ),
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'wp_kses_post',
		'type'              => 'option',
    ));

    $wp_customize->add_control( new WP_Customize_Control( 
        $wp_customize, 'market_blog_text_control', array(
			'label'      => __( 'Blog Section Heading Text', 'market' ),
			'description' => __( 'Choose the heading text you would like to display above posts on the front page.<br /><br />This text will show when displaying posts and using widgets on the front page.', 'market' ),
			'section'    => 'market_blog_section',
			'settings'   => 'market_blog_text',
			'type'       => 'text',
		))
	);

}
