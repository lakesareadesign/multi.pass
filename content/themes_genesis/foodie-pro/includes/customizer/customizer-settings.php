<?php
/**
 * Register Customizer settings.
 *
 * @package     FoodiePro
 * @subpackage  Genesis
 * @copyright   Copyright (c) 2014, Shay Bocks
 * @license     GPL-2.0+
 * @since       2.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Continue if the Customizer_Library exists.
if ( class_exists( 'Customizer_Library' ) ) :

add_action( 'customize_register', 'foodie_pro_remove_customizer_defaults' );
/**
 * Remove unwanted default customizer sections for the Foodie Pro theme.
 *
 * @since  2.0.0
 *
 * @param  array $wp_customize
 */
function foodie_pro_remove_customizer_defaults( $wp_customize ) {
	$wp_customize->remove_section( 'colors' );
}

add_action( 'customize_register', 'foodie_pro_register_customizer_settings' );
/**
 * Register custom sections for the Foodie Pro theme.
 *
 * @since  2.0.0
 *
 * @param  array $wp_customize
 */
function foodie_pro_register_customizer_settings() {

	// Stores all the controls that will be added
	$options = array();

	// Stores all the sections to be added
	$sections = array();

	// Adds the sections to the $options array
	$options['sections'] = $sections;

	// Colors
	$section = 'foodie_pro_colors';

	$sections[] = array(
		'id'          => $section,
		'title'       => __( 'Colors', 'foodiepro' ),
		'description' => __( 'You can customize your theme colors by changing any of the options below.', 'foodiepro' ),
		'priority'    => '70',
	);

	$colors = foodie_pro_get_colors();
	$counter = 20;

	foreach ( $colors as $color => $setting ) {

		$options[ $color ] = array(
			'id'       => $color,
			'label'    => $setting['label'],
			'section'  => $section,
			'type'     => 'color',
			'default'  => $setting['default'],
			'priority' => $counter++,
		);
	}
	//* Allow users to disable Google Fonts Output.
	if ( ! apply_filters( 'foodie_pro_disable_google_fonts', false ) ) {
		// Typography
		$section = 'foodie_pro_typography';

		$sections[] = array(
			'id'          => $section,
			'title'       => __( 'Typography', 'foodiepro' ),
			'description' => __( 'You can customize your fonts here. For best results, we recommend using no more than two unique font families.', 'foodiepro' ),
			'priority'    => '75',
		);

		$fonts = foodie_pro_get_fonts();
		$counter = 20;

		foreach ( $fonts as $font => $setting ) {
			$options[ $font . '_family' ] = array(
				'id'      => $font . '_family',
				'label'   => $setting['label'] . __( ' Family', 'foodiepro' ),
				'section' => $section,
				'type'    => 'select',
				'choices' => customizer_library_get_font_choices(),
				'default' => $setting['default_family'],
			);

			$choices = array(
				'200' => 'Light',
				'300' => 'Normal',
				'700' => 'Bold',
				'900' => 'Extra Bold',
			);

			$options[ $font . '_weight' ] = array(
				'id'      => $font . '_weight',
				'label'   => $setting['label'] . __( ' Weight', 'foodiepro' ),
				'section' => $section,
				'type'    => 'select',
				'choices' => $choices,
				'default' => $setting['default_weight'],
			);

			if ( 'disabled' !== $setting['default_size'] ) {
				$choices = array(
					'13px' => '13px',
					'15px' => '15px',
					'19px' => '19px',
					'21px' => '21px',
                    '27px' => '27px',
					'37px' => '37px',
					'47px' => '47px',
					'57px' => '57px',
				);

				$options[ $font . '_size' ] = array(
					'id'      => $font . '_size',
					'label'   => $setting['label'] . __( ' Size', 'foodiepro' ),
					'section' => $section,
					'type'    => 'select',
					'choices' => $choices,
					'default' => $setting['default_size'],
				);
			}

			if ( 'disabled' !== $setting['default_style'] ) {
				$choices = array(
					'normal' => 'Normal',
					'italic' => 'Italic',
				);

				$options[ $font . '_style' ] = array(
					'id'      => $font . '_style',
					'label'   => $setting['label'] . __( ' Style', 'foodiepro' ),
					'section' => $section,
					'type'    => 'select',
					'choices' => $choices,
					'default' => $setting['default_style'],
				);
			}
		}
	}

	$choices = array(
		'full'       => __( 'Full Width', 'foodiepro' ),
		'one_half'   => __( 'One Half', 'foodiepro' ),
		'one_third'  => __( 'One Third', 'foodiepro' ),
		'one_fourth' => __( 'One Fourth', 'foodiepro' ),
		'one_sixth'  => __( 'One Sixth', 'foodiepro' ),
	);

	$options['foodie_pro_archive_grid'] = array(
		'id'      => 'foodie_pro_archive_grid',
		'label'   => __( 'Archive Grid Display:', 'foodiepro' ),
		'section' => 'genesis_archives',
		'type'    => 'select',
		'choices' => $choices,
		'default' => 'full',
		'priority' => 0,
	);

	$options['foodie_pro_archive_show_title'] = array(
		'id'       => 'foodie_pro_archive_show_title',
		'label'    => __( 'Display The Title?', 'foodiepro' ),
		'section'  => 'genesis_archives',
		'type'     => 'checkbox',
		'default'  => 1,
		'priority' => 5,
	);

	$options['foodie_pro_archive_show_info'] = array(
		'id'       => 'foodie_pro_archive_show_info',
		'label'    => __( 'Display The Entry Info?', 'foodiepro' ),
		'section'  => 'genesis_archives',
		'type'     => 'checkbox',
		'default'  => 1,
		'priority' => 6,
	);

	$options['foodie_pro_archive_show_content'] = array(
		'id'       => 'foodie_pro_archive_show_content',
		'label'    => __( 'Display The Content?', 'foodiepro' ),
		'section'  => 'genesis_archives',
		'type'     => 'checkbox',
		'default'  => 1,
		'priority' => 7,
	);

	$options['foodie_pro_archive_show_meta'] = array(
		'id'       => 'foodie_pro_archive_show_meta',
		'label'    => __( 'Display The Entry Meta?', 'foodiepro' ),
		'section'  => 'genesis_archives',
		'type'     => 'checkbox',
		'default'  => 1,
		'priority' => 8,
	);

	$choices = array(
		'after_title'   => __( 'After Title', 'foodiepro' ),
		'before_title'  => __( 'Before Title', 'foodiepro' ),
		'after_content' => __( 'After Content', 'foodiepro' ),
	);

	$options['foodie_pro_archive_image_placement'] = array(
		'id'      => 'foodie_pro_archive_image_placement',
		'label'   => __( 'Featured Image Placement:', 'foodiepro' ),
		'section' => 'genesis_archives',
		'type'    => 'select',
		'choices' => $choices,
		'default' => 'after_title',
	);

	// Adds the sections to the $options array
	$options['sections'] = $sections;

	$customizer_library = Customizer_Library::Instance();
	$customizer_library->add_options( $options );

}

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
			'selector' => 'body',
			'rule'     => 'background',
		),
		'foodie_container_bg_color' => array(
			'default'  => '#ffffff',
			'label'    => __( 'Container Background Color', 'foodiepro' ),
			'selector' => '.site-inner',
			'rule'     => 'background',
		),
		'foodie_accent_color' => array(
			'default'  => '#f5f5f5',
			'label'    => __( 'Accent Background Color', 'foodiepro' ),
			'selector' => '.before-header, .enews-widget, .footer-widgets, .form-allowed-tags',
			'rule'     => 'background',
		),
		'foodie_site_title_color' => array(
			'default'  => '#101010',
			'label'    => __( 'Site Title Color', 'foodiepro' ),
			'selector' => '.site-title a, .site-title a:hover',
			'rule'     => 'color',
		),
		'foodie_menu_bg_color' => array(
			'default'  => '#ffffff',
			'label'    => __( 'Menu Background Color', 'foodiepro' ),
			'selector' => '.genesis-nav-menu',
			'rule'     => 'background',
		),
		'foodie_menu_link_color' => array(
			'default'  => '#101010',
			'label'    => __( 'Menu Link Color', 'foodiepro' ),
			'selector' => '.genesis-nav-menu > li > a',
			'rule'     => 'color',
		),
		'foodie_menu_link_hover_color' => array(
			'default'  => '#fb6a4a',
			'label'    => __( 'Menu Link Hover Color', 'foodiepro' ),
			'selector' => '.genesis-nav-menu > li > a:hover, .genesis-nav-menu > .current-menu-item > a',
			'rule'     => 'color',
		),
		'foodie_text_color' => array(
			'default'  => '#010101',
			'label'    => __( 'Text Color', 'foodiepro' ),
			'selector' => 'body, .site-description, .sidebar a',
			'rule'     => 'color',
		),
		'foodie_border_color' => array(
			'default'  => '#eee',
			'label'    => __( 'Border Color', 'foodiepro' ),
			'selector' => '.genesis-nav-menu, .genesis-nav-menu .sub-menu, .entry-footer .entry-meta, .post-meta, li.comment',
			'rule'     => 'border-color',
		),
		'foodie_entry_title_color' => array(
			'default'  => '#010101',
			'label'    => __( 'Title Color', 'foodiepro' ),
			'selector' => 'h1.entry-title, .entry-title a, .widgettitle, .recipes-top .widgettitle, .footer-widgets .widgettitle',
			'rule'     => 'color',
		),
		'foodie_secondary_text_color' => array(
			'default'  => '#aaaaaa',
			'label'    => __( 'Secondary Text Color', 'foodiepro' ),
			'selector' => '.entry-meta, .post-info, .post-meta, .site-footer',
			'rule'     => 'color',
		),
		'foodie_accent_text_color' => array(
			'default'  => '#010101',
			'label'    => __( 'Accent Text Color', 'foodiepro' ),
			'selector' => '.before-header, .enews-widget, .before-header .widgettitle, .enews-widget .widgettitle, .footer-widgets, .form-allowed-tags',
			'rule'     => 'color',
		),
		'foodie_link_color' => array(
			'default'  => '#fb6a4a',
			'label'    => __( 'Link Color', 'foodiepro' ),
			'selector' => 'a, .entry-meta a, .post-info a, .post-meta a, .site-footer a, .entry-content a',
			'rule'     => 'color',
		),
		'foodie_link_hover_color' => array(
			'default'  => '#fb6a4a',
			'label'    => __( 'Link Hover Color', 'foodiepro' ),
			'selector' => 'a:hover, .entry-meta a:hover, .post-info a:hover, .post-meta a:hover, .site-footer a:hover',
			'rule'     => 'color',
		),
		'foodie_button_color' => array(
			'default'  => '#010101',
			'label'    => __( 'Button Color', 'foodiepro' ),
			'selector' => '.button, button, .enews-widget input[type="submit"], a.more-link, .more-from-category a',
			'rule'     => 'background',
		),
        'foodie_button_border_color' => array(
			'default'  => '#010101',
			'label'    => __( 'Button Border Color', 'foodiepro' ),
			'selector' => '.button, button, .enews-widget input[type="submit"], a.more-link, .more-from-category a',
			'rule'     => 'border-color',
		),
		'foodie_button_hover_color' => array(
			'default'  => '#ffffff',
			'label'    => __( 'Button Hover Color', 'foodiepro' ),
			'selector' => '.button:hover, button:hover, .enews-widget input[type="submit"]:hover, a.more-link:hover, .more-from-category a:hover',
			'rule'     => 'background',
		),
		'foodie_button_text_color' => array(
			'default'  => '#ffffff',
			'label'    => __( 'Button Text Color', 'foodiepro' ),
			'selector' => '.button, button, .enews-widget input[type="submit"], a.more-link, .more-from-category a',
			'rule'     => 'color',
		),
		'foodie_button_text_hover_color' => array(
			'default'  => '#010101',
			'label'    => __( 'Button Hover Text Color', 'foodiepro' ),
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
			'selector'       => 'body, .site-description, .sidebar .featured-content .entry-title ',
		),
		'foodie_accent_font' => array(
			'default_family' => 'Karla',
			'default_size'   => 'disabled',
			'default_style'  => 'normal',
			'default_weight' => '600',
			'label'          => __( 'Menu Font', 'foodiepro' ),
			'selector'       => '.genesis-nav-menu',
		),
		'foodie_heading_font' => array(
			'default_family' => 'Karla',
			'default_size'   => 'disabled',
			'default_style'  => 'normal',
			'default_weight' => '700',
			'label'          => __( 'Heading Font', 'foodiepro' ),
			'selector'       => 'h1, h2, h3, h4, h5, h6, .site-title, .entry-title, .widgettitle',
		),
        'foodie_entry_title_font' => array(
			'default_family' => 'Karla',
			'default_size'   => '19px',
			'default_style'  => 'normal',
			'default_weight' => '700',
			'label'          => __( 'Entry Title Font', 'foodiepro' ),
			'selector'       => '.entry-title',
		),
        'foodie_button_font' => array(
			'default_family' => 'Karla',
			'default_size'   => 'disabled',
			'default_style'  => 'normal',
			'default_weight' => '700',
			'label'          => __( 'Button Font', 'foodiepro' ),
			'selector'       => '.button, .button-secondary, button, input[type="button"], input[type="reset"], input[type="submit"], a.more-link, .more-from-category a',
		),
	);
	return apply_filters( 'foodie_pro_get_fonts', $fonts );
}

add_filter( 'customizer_library_font_variants', 'foodie_pro_font_variants', 10, 3 );
/**
 * Filters the allowed Google Font varoamts for the Foodie Pro theme.
 *
 * @since  2.0.0
 *
 * @param  array $chosen_variants
 * @param  array $font
 * @param  array $variants
 * @return array $chosen_variants
 */
function foodie_pro_font_variants( $chosen_variants, $font, $variants ) {

	// Only add "200" if it exists
	if ( in_array( '200', $variants ) ) {
		$chosen_variants[] = '200';
	}

	// Only add "300" if it exists
	if ( in_array( '300', $variants ) ) {
		$chosen_variants[] = '300';
	}

	// Only add "300italic" if it exists
	if ( in_array( '300italic', $variants ) ) {
		$chosen_variants[] = '300italic';
	}

	// Only add "900" if it exists
	if ( in_array( '900', $variants ) ) {
		$chosen_variants[] = '900';
	}

	return array_unique( $chosen_variants );
}
//* Disable standard fonts.
add_filter( 'customizer_library_all_fonts', 'customizer_library_get_google_fonts' );

add_filter( 'customizer_library_get_google_fonts', 'foodie_pro_get_google_fonts' );
/**
 * Filters the allowed Google Fonts for the Foodie Pro theme.
 *
 * @since  3.0.0
 *
 * @param  array $fonts
 * @return array $fonts
 */
function foodie_pro_get_google_fonts( $fonts ) {
	$fonts = array(
		'Abril Fatface' => array(
			'label'    => 'Abril Fatface',
			'variants' => array(
				'regular',
			),
			'subsets' => array(
				'latin',
				'latin-ext',
			),
		),
		'Adamina' => array(
			'label'    => 'Adamina',
			'variants' => array(
				'regular',
			),
			'subsets' => array(
				'latin',
			),
		),
        'Coustard' => array(
			'label'    => 'Coustard',
			'variants' => array(
				'regular',
				'900',
			),
			'subsets' => array(
				'latin',
			),
		),
        'Cutive Mono' => array(
			'label'    => 'Cutive Mono',
			'variants' => array(
				'regular',
			),
			'subsets' => array(
				'latin',
				'latin-ext',
			),
		),
		'Droid Serif' => array(
			'label'    => 'Droid Serif',
			'variants' => array(
				'regular',
				'italic',
				'700',
				'700italic',
			),
			'subsets' => array(
				'latin',
			),
		),
        'Karla' => array(
			'label'    => 'Karla',
			'variants' => array(
				'regular',
				'italic',
				'700',
				'700italic',
			),
			'subsets' => array(
				'latin',
				'latin-ext',
			),
		),
		'Lato' => array(
			'label'    => 'Lato',
			'variants' => array(
				'100',
				'100italic',
				'300',
				'300italic',
				'regular',
				'italic',
				'700',
				'700italic',
				'900',
				'900italic',
			),
			'subsets' => array(
				'latin',
				'latin-ext',
			),
		),
		'Libre Baskerville' => array(
			'label'    => 'Libre Baskerville',
			'variants' => array(
				'regular',
				'italic',
				'700',
			),
			'subsets' => array(
				'latin',
				'latin-ext',
			),
		),
        'Muli' => array(
			'label'    => 'Muli',
			'variants' => array(
				'300',
				'300italic',
				'regular',
				'italic',
			),
			'subsets' => array(
				'latin',
			),
		),
        'Nunito' => array(
			'label'    => 'Nunito',
			'variants' => array(
				'300',
				'regular',
				'700',
			),
			'subsets' => array(
				'latin',
			),
		),
		'Oswald' => array(
			'label'    => 'Oswald',
			'variants' => array(
				'300',
				'regular',
				'700',
			),
			'subsets' => array(
				'latin',
				'latin-ext',
			),
		),
        'Pontano Sans' => array(
			'label'    => 'Pontano Sans',
			'variants' => array(
				'regular',
			),
			'subsets' => array(
				'latin',
				'latin-ext',
			),
		),
		'PT Sans Narrow' => array(
			'label'    => 'PT Sans Narrow',
			'variants' => array(
				'regular',
				'700',
			),
			'subsets' => array(
				'latin',
				'cyrillic',
				'latin-ext',
				'cyrillic-ext',
			),
		),
		'PT Serif' => array(
			'label'    => 'PT Serif',
			'variants' => array(
				'regular',
				'italic',
				'700',
				'700italic',
			),
			'subsets' => array(
				'latin',
				'cyrillic',
				'latin-ext',
				'cyrillic-ext',
			),
		),
		'Playfair Display' => array(
			'label'    => 'Playfair Display',
			'variants' => array(
				'regular',
				'italic',
				'700',
				'700italic',
				'900',
				'900italic',
			),
			'subsets' => array(
				'latin',
				'cyrillic',
				'latin-ext',
			),
		),
        'Questrial' => array(
			'label'    => 'Questrial',
			'variants' => array(
				'regular',
			),
			'subsets' => array(
				'latin',
			),
		),
		'Raleway' => array(
			'label'    => 'Raleway',
			'variants' => array(
				'100',
				'200',
				'300',
				'regular',
				'500',
				'600',
				'700',
				'800',
				'900',
			),
			'subsets' => array(
				'latin',
			),
		),
		'Roboto Slab' => array(
			'label'    => 'Roboto Slab',
			'variants' => array(
				'100',
				'300',
				'regular',
				'700',
			),
			'subsets' => array(
				'latin',
				'greek-ext',
				'cyrillic',
				'greek',
				'vietnamese',
				'latin-ext',
				'cyrillic-ext',
			),
		),
        'Trocchi' => array(
			'label'    => 'Trocchi',
			'variants' => array(
				'regular',
			),
			'subsets' => array(
				'latin',
				'latin-ext',
			),
		),
	);
	return $fonts;
}

endif;
