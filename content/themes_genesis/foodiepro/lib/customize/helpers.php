<?php
/**
 * Set up and include all necessary customizer files.
 *
 * @package   FoodiePro\Functions\Customizer
 * @copyright Copyright (c) 2018, Feast Design Co.
 * @license   GPL-2.0+
 * @since     3.0.0
 */

defined( 'WPINC' ) || die;

/**
 * An array of the color settings used in Foodie Pro.
 *
 * @since  2.0.3
 * @return array $colors
 */
function foodie_pro_get_colors() {
	$colors = array(
		'foodie_bg_color' => array(
			'default'  => '#ffffff',
			'label'    => __( 'Main Background Color', 'foodiepro' ),
			'section'  => 'general',
			'selector' => 'body',
			'rule'     => 'background',
		),
		'foodie_container_bg_color' => array(
			'default'  => '#ffffff',
			'label'    => __( 'Container Background Color', 'foodiepro' ),
			'section'  => 'general',
			'selector' => '.site-inner',
			'rule'     => 'background',
		),
		'foodie_accent_color' => array(
			'default'  => '#f5f5f5',
			'label'    => __( 'Accent Background Color', 'foodiepro' ),
			'section'  => 'general',
			'selector' => '.before-header, .enews-widget, .footer-widgets, .form-allowed-tags',
			'rule'     => 'background',
		),
		'foodie_site_title_color' => array(
			'default'  => '#101010',
			'label'    => __( 'Site Title Color', 'foodiepro' ),
			'section'  => 'general',
			'selector' => '.site-title a, .site-title a:hover',
			'rule'     => 'color',
		),
		'foodie_border_color' => array(
			'default'  => '#eee',
			'label'    => __( 'Border Color', 'foodiepro' ),
			'section'  => 'general',
			'selector' => '.genesis-nav-menu, .genesis-nav-menu .sub-menu, .entry-footer .entry-meta, .post-meta, li.comment',
			'rule'     => 'border-color',
		),
		'foodie_text_color' => array(
			'default'  => '#010101',
			'label'    => __( 'Text Color', 'foodiepro' ),
			'section'  => 'content',
			'selector' => 'body, .site-description, .sidebar a',
			'rule'     => 'color',
		),
		'foodie_entry_title_color' => array(
			'default'  => '#010101',
			'label'    => __( 'Title Color', 'foodiepro' ),
			'section'  => 'content',
			'selector' => 'h1.entry-title, .entry-title a, .widgettitle, .recipe-index-search .widgettitle, .footer-widgets .widgettitle',
			'rule'     => 'color',
		),
		'foodie_secondary_text_color' => array(
			'default'  => '#aaaaaa',
			'label'    => __( 'Secondary Text Color', 'foodiepro' ),
			'section'  => 'content',
			'selector' => '.entry-meta, .post-info, .post-meta, .site-footer',
			'rule'     => 'color',
		),
		'foodie_accent_text_color' => array(
			'default'  => '#010101',
			'label'    => __( 'Accent Text Color', 'foodiepro' ),
			'section'  => 'content',
			'selector' => '.before-header, .enews-widget, .before-header .widgettitle, .enews-widget .widgettitle, .footer-widgets, .form-allowed-tags',
			'rule'     => 'color',
		),
		'foodie_link_color' => array(
			'default'  => '#fb6a4a',
			'label'    => __( 'Link Color', 'foodiepro' ),
			'section'  => 'content',
			'selector' => 'a, .entry-meta a, .post-info a, .post-meta a, .site-footer a, .entry-content a',
			'rule'     => 'color',
		),
		'foodie_link_hover_color' => array(
			'default'  => '#fb6a4a',
			'label'    => __( 'Link Hover Color', 'foodiepro' ),
			'section'  => 'content',
			'selector' => 'a:hover, .entry-meta a:hover, .post-info a:hover, .post-meta a:hover, .site-footer a:hover',
			'rule'     => 'color',
		),
		'foodie_menu_bg_color' => array(
			'default'  => '#ffffff',
			'label'    => __( 'Menu Background Color', 'foodiepro' ),
			'section'  => 'menus',
			'selector' => '.genesis-nav-menu',
			'rule'     => 'background',
		),
		'foodie_menu_link_color' => array(
			'default'  => '#101010',
			'label'    => __( 'Menu Link Color', 'foodiepro' ),
			'section'  => 'menus',
			'selector' => '.genesis-nav-menu > li > a',
			'rule'     => 'color',
		),
		'foodie_menu_link_hover_color' => array(
			'default'  => '#fb6a4a',
			'label'    => __( 'Menu Link Hover Color', 'foodiepro' ),
			'section'  => 'menus',
			'selector' => '.genesis-nav-menu > li > a:hover, .genesis-nav-menu > .current-menu-item > a',
			'rule'     => 'color',
		),
		'foodie_button_color' => array(
			'default'  => '#010101',
			'label'    => __( 'Button Color', 'foodiepro' ),
			'section'  => 'buttons',
			'selector' => '.button, button, .enews-widget input[type="submit"], a.more-link, .more-from-category a, .sidebar .button, .sidebar .more-from-category a',
			'rule'     => 'background',
		),
		'foodie_button_border_color' => array(
			'default'  => '#010101',
			'label'    => __( 'Button Border Color', 'foodiepro' ),
			'section'  => 'buttons',
			'selector' => '.button, button, .enews-widget input[type="submit"], a.more-link, .more-from-category a',
			'rule'     => 'border-color',
		),
		'foodie_button_hover_color' => array(
			'default'  => '#ffffff',
			'label'    => __( 'Button Hover Color', 'foodiepro' ),
			'section'  => 'buttons',
			'selector' => '.button:hover, button:hover, .enews-widget input[type="submit"]:hover, a.more-link:hover, .more-from-category a:hover',
			'rule'     => 'background',
		),
		'foodie_button_text_color' => array(
			'default'  => '#ffffff',
			'label'    => __( 'Button Text Color', 'foodiepro' ),
			'section'  => 'buttons',
			'selector' => '.button, button, .enews-widget input[type="submit"], a.more-link, .more-from-category a',
			'rule'     => 'color',
		),
		'foodie_button_text_hover_color' => array(
			'default'  => '#010101',
			'label'    => __( 'Button Hover Text Color', 'foodiepro' ),
			'section'  => 'buttons',
			'selector' => '.button:hover, button:hover, .enews-widget input[type="submit"]:hover, a.more-link:hover, .more-from-category a:hover',
			'rule'     => 'color',
		),
	);
	return apply_filters( 'foodie_pro_get_colors', $colors );
}

/**
 * An array of the font settings used in Foodie Pro.
 *
 * @since  2.0.0
 *
 * @return array $fonts
 */
function foodie_pro_get_fonts() {
	$fonts = array(
		'foodie_body_font' => array(
			'default_family' => 'Muli',
			'default_size'   => '16px',
			'default_style'  => 'disabled',
			'default_weight' => '300',
			'label'          => __( 'Body Font', 'foodiepro' ),
			'description'    => __( 'Customize your body font by changing the options below.', 'foodiepro' ),
			'selector'       => 'body, .site-description, .sidebar .featured-content .entry-title ',
		),
		'foodie_accent_font' => array(
			'default_family' => 'Karla',
			'default_size'   => 'disabled',
			'default_style'  => 'normal',
			'default_weight' => '300',
			'label'          => __( 'Menu Font', 'foodiepro' ),
			'description'    => __( 'Customize your menu font by changing the options below.', 'foodiepro' ),
			'selector'       => '.genesis-nav-menu',
		),
		'foodie_heading_font' => array(
			'default_family' => 'Karla',
			'default_size'   => 'disabled',
			'default_style'  => 'normal',
			'default_weight' => '700',
			'label'          => __( 'Heading Font', 'foodiepro' ),
			'description'    => __( 'Customize your heading font by changing the options below.', 'foodiepro' ),
			'selector'       => 'h1, h2, h3, h4, h5, h6, .site-title, .entry-title, .widgettitle',
		),
		'foodie_entry_title_font' => array(
			'default_family' => 'Karla',
			'default_size'   => '19px',
			'default_style'  => 'normal',
			'default_weight' => '700',
			'label'          => __( 'Entry Title Font', 'foodiepro' ),
			'description'    => __( 'Customize your entry title font by changing the options below.', 'foodiepro' ),
			'selector'       => '.entry-title',
		),
		'foodie_button_font' => array(
			'default_family' => 'Karla',
			'default_size'   => 'disabled',
			'default_style'  => 'normal',
			'default_weight' => '700',
			'label'          => __( 'Button Font', 'foodiepro' ),
			'description'    => __( 'Customize your button font by changing the options below.', 'foodiepro' ),
			'selector'       => '.button, .button-secondary, button, input[type="button"], input[type="reset"], input[type="submit"], a.more-link, .more-from-category a',
		),
	);
	return apply_filters( 'foodie_pro_get_fonts', $fonts );
}
