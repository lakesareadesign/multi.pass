<?php
/**
 * Register Customizer settings.
 *
 * @package   BrunchPro\Functions\Customizer
 * @copyright Copyright (c) 2017, Feast Design Co.
 * @license   GPL-2.0+
 * @since     1.0.0
 */

/**
 * Add hover and focus states to an array of selectors.
 *
 * @since  1.0.0
 * @access public
 * @param  array $selectors an array of selectors.
 * @return array $output an array of selectors with hover states added.
 */
function brunch_pro_add_hover_states( $selectors ) {
	$output = array();
	foreach ( (array) $selectors as $selector ) {
		$output[] = "{$selector}:hover";
		$output[] = "{$selector}:focus";
	}
	return $output;
}

/**
 * Return a list of all button selectors used in the theme.
 *
 * @since  1.0.0
 * @access public
 * @return array $output an array of selectors.
 */
function brunch_pro_get_button_selectors() {
	return array(
		'.button',
		'.button-secondary',
		'button',
		'input[type="button"]',
		'input[type="reset"]',
		'input[type="submit"]',
		'.enews-widget input[type="submit"]',
		'div.gform_wrapper .gform_footer input[type="submit"]',
		'a.more-link',
		'.more-from-category a',
	);
}

/**
 * Build color rules into an associative array to use when building CSS output.
 *
 * @since  1.0.0
 * @access public
 * @param  array $rules a list of rules to associate with color options.
 * @param  mixed $mod a WordPress theme mod or option.
 * @return array $built_rules a list of rules and their color options.
 */
function brunch_pro_get_color_rules( $rules, $mod ) {
	$built_rules = array();
	foreach ( (array) $rules as $rule ) {
		$built_rules[ $rule ] = $mod;
	}
	return $built_rules;
}

/**
 * Build our color styles into an associative array which can be passed to
 * the Customizer Library style builder to actually build the style output.
 *
 * @since  1.0.0
 * @access public
 * @param  array $selectors a list of selectors to associate with style rules.
 * @param  array $rules a list of rules to associate with style selectors.
 * @param  mixed $mod a WordPress theme mod or option.
 * @return array styles a list of CSS selectors and their associated rules.
 */
function brunch_pro_build_color_styles( $selectors, $rules, $mod ) {
	return array(
		'selectors'    => array( rtrim( implode( ', ', $selectors ) ) ),
		'declarations' => brunch_pro_get_color_rules( $rules, $mod ),
	);
}

/**
 * Add an individual color setting to the group of customizer-generated styles
 * to be output on the front-end.
 *
 * @since  1.0.0
 * @access public
 * @param  mixed $mod a WordPress theme mod or option.
 * @param  array $data An array of information about a given color setting.
 * @return void
 */
function brunch_pro_add_color( $mod, $data ) {
	if ( ! strcasecmp( $mod, $data['default'] ) ) {
		return;
	}

	Feastco_Customizer_Styles::instance()->add( brunch_pro_build_color_styles(
		$data['selectors'],
		$data['rules'],
		$mod
	) );

	if ( isset( $data['alt_selectors'] ) ) {
		Feastco_Customizer_Styles::instance()->add( brunch_pro_build_color_styles(
			$data['alt_selectors'],
			$data['alt_rules'],
			$mod
		) );
	}
}

/**
 * An array of the color settings used in Brunch Pro.
 *
 * @since  1.0.0
 * @access public
 * @return array $colors a list of theme color options and associated data.
 */
function brunch_pro_get_colors() {
	$colors = array(
		'header_bg_color' => array(
			'default'   => '#f5f5f5',
			'label'     => __( 'Header Background Color', 'brunch-pro' ),
			'section'   => 'general',
			'rules'     => array( 'background' ),
			'selectors' => array(
				'.brunch-pro .site-header',
			),
		),
		'title_color' => array(
			'default'   => '#302a2c',
			'label'     => __( 'Title Color', 'brunch-pro' ),
			'section'   => 'general',
			'rules'     => array( 'color' ),
			'selectors' => array(
				'.entry-title',
				'.entry-title a',
				'h1.entry-title',
				'.widgettitle',
				'.recipe-index .widgettitle',
				'.footer-widgets .widgettitle',
				'.site-title a',
				'.site-title a:hover',
				'.site-title a:focus',
				'.brunch-pro .simmer-embedded-recipe .simmer-recipe-title a',
			),
		),
		'text_color' => array(
			'default'   => '#302a2c',
			'label'     => __( 'Text Color', 'brunch-pro' ),
			'section'   => 'general',
			'rules'     => array( 'color' ),
			'selectors' => array(
				'body',
				'.entry-meta a:not(.button)',
				'.sidebar a:not(.button)',
				'.site-description',
				'.site-footer a:not(.button)',
			),
		),
		'secondary_text_color' => array(
			'default'   => '#302a2c',
			'label'     => __( 'Secondary Text Color', 'brunch-pro' ),
			'section'   => 'general',
			'rules'     => array( 'color' ),
			'selectors' => array(
				'.entry-meta',
				'.entry-meta a',
				'.site-footer',
				'.brunch-pro .simmer-recipe-details',
			),
		),
		'link_color' => array(
			'default'   => '#44d5af',
			'label'     => __( 'Link Color', 'brunch-pro' ),
			'section'   => 'general',
			'rules'     => array( 'color' ),
			'selectors' => array(
				'a',
				'.site-footer a:not(.button)',
				'.pagination-next:after',
				'.pagination-previous:before',
			),
		),
		'link_hover_color' => array(
			'default'   => '#302a2c',
			'label'     => __( 'Link Hover Color', 'brunch-pro' ),
			'section'   => 'general',
			'rules'     => array( 'color' ),
			'selectors' => brunch_pro_add_hover_states( array(
				'a',
				'site-footer a',
			) ),
		),
		'menu_bg_color' => array(
			'default'   => '#ffffff',
			'label'     => __( 'Menu Background Color', 'brunch-pro' ),
			'section'   => 'menus',
			'rules'     => array( 'background' ),
			'selectors' => array(
				'.nav-primary',
				'.nav-secondary .wrap',
			),
		),
		'menu_link_color' => array(
			'default'   => '#302a2c',
			'label'     => __( 'Menu Link Color', 'brunch-pro' ),
			'section'   => 'menus',
			'rules'     => array( 'color' ),
			'selectors' => array(
				'.genesis-nav-menu > li > a',
			),
		),
		'menu_link_hover_color' => array(
			'default'   => '#000000',
			'label'     => __( 'Menu Link Hover Color', 'brunch-pro' ),
			'section'   => 'menus',
			'rules'     => array( 'color' ),
			'selectors' => array(
				'.genesis-nav-menu > li > a:hover',
				'.genesis-nav-menu > li > a:focus',
				'.genesis-nav-menu > .current-menu-item > a',
			),
		),
		'button_color' => array(
			'default'   => '#302a2c',
			'label'     => __( 'Button Color', 'brunch-pro' ),
			'section'   => 'buttons',
			'rules'     => array( 'background' ),
			'selectors' => brunch_pro_get_button_selectors(),
		),
		'button_hover_color' => array(
			'default'   => '#ffffff',
			'label'     => __( 'Button Hover Color', 'brunch-pro' ),
			'section'   => 'buttons',
			'rules'     => array( 'background' ),
			'selectors' => brunch_pro_add_hover_states( brunch_pro_get_button_selectors() ),
		),
		'button_border_color' => array(
			'default'   => '#302a2c',
			'label'     => __( 'Button Border Color', 'brunch-pro' ),
			'section'   => 'buttons',
			'rules'     => array( 'border-color' ),
			'selectors' => brunch_pro_get_button_selectors(),
		),
		'button_border_hover_color' => array(
			'default'   => '#302a2c',
			'label'     => __( 'Button Border Hover Color', 'brunch-pro' ),
			'section'   => 'buttons',
			'rules'     => array( 'border-color' ),
			'selectors' => brunch_pro_add_hover_states( brunch_pro_get_button_selectors() ),
		),
		'button_text_color' => array(
			'default'   => '#ffffff',
			'label'     => __( 'Button Text Color', 'brunch-pro' ),
			'section'   => 'buttons',
			'rules'     => array( 'color' ),
			'selectors' => brunch_pro_get_button_selectors(),
		),
		'button_text_hover_color' => array(
			'default'   => '#302a2c',
			'label'     => __( 'Button Hover Text Color', 'brunch-pro' ),
			'section'   => 'buttons',
			'rules'     => array( 'color' ),
			'selectors' => brunch_pro_add_hover_states( brunch_pro_get_button_selectors() ),
		),
	);

	return (array) apply_filters( 'brunch_pro_get_colors', $colors );
}

/**
 * Build font rules into an associative array to use when building CSS output.
 *
 * @since  1.0.0
 * @access public
 * @param  string $type the type of font setting for the rule we're building.
 * @param  mixed  $mod a WordPress theme mod or option.
 * @return array $output a CSS font rule and declaration.
 */
function brunch_pro_get_font_declarations( $type, $mod ) {
	$output = array();

	switch ( $type ) {
		case 'family':
			$output = array(
				'font-family' => feastco_customizer_get_font_stack( $mod ),
			);
		break;
		case 'size':
			$output = array(
				'font-size' => "{$mod}px",
			);
		break;
		default:
			$output = array(
				"font-{$type}" => $mod,
			);
		break;
	}

	return $output;
}


/**
 * Build our font styles into an associative array which can be passed to
 * the Customizer Library style builder to actually build the style output.
 *
 * @since  1.0.0
 * @access public
 * @param  string $type the type of font setting for the rule we're building.
 * @param  array  $selectors a list of selectors to associate with style rules.
 * @param  mixed  $mod a WordPress theme mod or option.
 * @return array styles a list of CSS selectors and their associated rules.
 */
function brunch_pro_build_font_styles( $type, $selectors, $mod ) {
	return array(
		'selectors'    => array( rtrim( implode( ', ', $selectors ) ) ),
		'declarations' => brunch_pro_get_font_declarations( $type, $mod ),
	);
}

/**
 * Add an individual font setting to the group of customizer-generated styles
 * to be output on the front-end.
 *
 * @since  1.0.0
 * @access public
 * @param  string $type the type of font setting for the rule we're building.
 * @param  mixed  $mod a WordPress theme mod or option.
 * @param  array  $data An array of information about a given font setting.
 * @return void
 */
function brunch_pro_add_font( $type, $mod, $data ) {
	if ( $mod === $data[ "default_{$type}" ] ) {
		return;
	}

	Feastco_Customizer_Styles::instance()->add( brunch_pro_build_font_styles(
		$type,
		$data['selectors'],
		$mod
	) );
}

/**
 * An array of the font settings used in Brunch Pro.
 *
 * @since  1.0.0
 * @access public
 * @return array $fonts
 */
function brunch_pro_get_fonts() {
	$fonts = array(
		'body_font' => array(
			'default_family' => 'Libre Baskerville',
			'default_weight' => 400,
			'default_size'   => 12,
			'min_size'       => 11,
			'max_size'       => 21,
			'default_style'  => 'disabled',
			'label'          => __( 'Body Font', 'brunch-pro' ),
			'selectors'      => array( 'body' ),
		),
		'accent_font' => array(
			'default_family' => 'Lato',
			'default_weight' => 300,
			'default_size'   => 'disabled',
			'default_style'  => 'italic',
			'label'          => __( 'Accent Font', 'brunch-pro' ),
			'selectors'      => array(
				'input',
				'select',
				'textarea',
				'.wp-caption-text',
				'.site-description',
				'.entry-meta',
			),
		),
		'accent_font_meta' => array(
			'default_family' => 'disabled',
			'default_weight' => 'disabled',
			'default_size'   => 11,
			'min_size'       => 10,
			'max_size'       => 18,
			'default_style'  => 'disabled',
			'label'          => __( 'Accent Font', 'brunch-pro' ),
			'selectors'      => array(
				'.wp-caption-text',
				'.site-description',
				'.entry-meta',
			),
		),
		'heading_font' => array(
			'default_family' => 'Lato',
			'default_weight' => 600,
			'default_size'   => 'disabled',
			'default_style'  => 'normal',
			'label'          => __( 'Heading Font', 'brunch-pro' ),
			'selectors'      => array(
				'h1',
				'h2',
				'h3',
				'h4',
				'h5',
				'h6',
				'.site-title',
				'.entry-title',
				'.entry-title a',
				'.widgettitle',
				'.site-footer',
			),
		),
		'h1_font' => array(
			'default_family' => 'disabled',
			'default_weight' => 'disabled',
			'default_size'   => 22,
			'min_size'       => 18,
			'max_size'       => 38,
			'default_style'  => 'disabled',
			'label'          => __( 'H1 Font', 'brunch-pro' ),
			'selectors'      => array( 'h1' ),
		),
		'h2_font' => array(
			'default_family' => 'disabled',
			'default_weight' => 'disabled',
			'default_size'   => 20,
			'min_size'       => 16,
			'max_size'       => 34,
			'default_style'  => 'disabled',
			'label'          => __( 'H2 Font', 'brunch-pro' ),
			'selectors'      => array( 'h2' ),
		),
		'h3_font' => array(
			'default_family' => 'disabled',
			'default_weight' => 'disabled',
			'default_size'   => 18,
			'min_size'       => 14,
			'max_size'       => 30,
			'default_style'  => 'disabled',
			'label'          => __( 'H3 Font', 'brunch-pro' ),
			'selectors'      => array( 'h3' ),
		),
		'h4_font' => array(
			'default_family' => 'disabled',
			'default_weight' => 'disabled',
			'default_size'   => 16,
			'min_size'       => 12,
			'max_size'       => 28,
			'default_style'  => 'disabled',
			'label'          => __( 'H4 Font', 'brunch-pro' ),
			'selectors'      => array( 'h4' ),
		),
		'entry_title_font' => array(
			'default_family' => 'disabled',
			'default_weight' => 'disabled',
			'default_size'   => 18,
			'min_size'       => 14,
			'max_size'       => 34,
			'default_style'  => 'disabled',
			'label'          => __( 'Entry Title Font', 'brunch-pro' ),
			'selectors'      => array(
				'.single .content .entry-title',
				'.page .content .page .entry-title',
				'.archive-description .entry-title',
				'.home-top .entry-title',
				'.home-middle .entry-title',
				'.home-bottom .entry-title',
			),
		),
		'widgettitle_font' => array(
			'default_family' => 'disabled',
			'default_weight' => 'disabled',
			'default_size'   => 10,
			'min_size'       => 10,
			'max_size'       => 16,
			'default_style'  => 'disabled',
			'label'          => __( 'Widget Title Font', 'brunch-pro' ),
			'selectors'      => array(
				'.sidebar .widgettitle',
				'.footer-widgets .widgettitle',
			),
		),
		'menu_font' => array(
			'default_family' => 'Lato',
			'default_weight' => 400,
			'default_size'   => 10,
			'min_size'       => 10,
			'max_size'       => 16,
			'default_style'  => 'disabled',
			'label'          => __( 'Menu Font', 'brunch-pro' ),
			'selectors'      => array( '.genesis-nav-menu .menu-item' ),
		),
		'button_font' => array(
			'default_family' => 'Lato',
			'default_weight' => 300,
			'default_size'   => 'disabled',
			'default_style'  => 'normal',
			'label'          => __( 'Button Font', 'brunch-pro' ),
			'selectors'      => brunch_pro_get_button_selectors(),
		),
	);

	return (array) apply_filters( 'brunch_pro_get_fonts', $fonts );
}
