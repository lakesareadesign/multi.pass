<?php
/**
 * Register Customizer settings.
 *
 * @package   BrunchPro\Functions\Customizer
 * @copyright Copyright (c) 2017, Feast Design Co.
 * @license   GPL-2.0+
 * @since     1.0.0
 */

defined( 'WPINC' ) || die;

add_action( 'customize_register', 'brunch_pro_register_customizer_archives' );
/**
 * Register custom sections for the Brunch Pro theme.
 *
 * @since  1.0.0
 * @access public
 * @param  object $wp_customize the customizer object.
 * @return void
 */
function brunch_pro_register_customizer_archives( $wp_customize ) {
	$options = array();
	$section = 'genesis_archives';

	$options['archive_grid'] = array(
		'id'       => 'archive_grid',
		'label'    => __( 'Archive Grid Display:', 'brunch-pro' ),
		'section'  => $section,
		'type'     => 'select',
		'default'  => 'full',
		'priority' => 0,
		'choices'  => array(
			'full'       => __( 'Full Width', 'brunch-pro' ),
			'one_half'   => __( 'One Half', 'brunch-pro' ),
			'one_third'  => __( 'One Third', 'brunch-pro' ),
			'one_fourth' => __( 'One Fourth', 'brunch-pro' ),
			'one_sixth'  => __( 'One Sixth', 'brunch-pro' ),
		),
	);

	$options['archive_show_title'] = array(
		'id'       => 'archive_show_title',
		'label'    => __( 'Display The Title?', 'brunch-pro' ),
		'section'  => $section,
		'type'     => 'checkbox',
		'default'  => 1,
		'priority' => 5,
	);

	$options['archive_show_info'] = array(
		'id'       => 'archive_show_info',
		'label'    => __( 'Display The Entry Info?', 'brunch-pro' ),
		'section'  => $section,
		'type'     => 'checkbox',
		'default'  => 1,
		'priority' => 6,
	);

	$options['archive_show_content'] = array(
		'id'       => 'archive_show_content',
		'label'    => __( 'Display The Content?', 'brunch-pro' ),
		'section'  => $section,
		'type'     => 'checkbox',
		'default'  => 1,
		'priority' => 7,
	);

	$options['archive_show_meta'] = array(
		'id'       => 'archive_show_meta',
		'label'    => __( 'Display The Entry Meta?', 'brunch-pro' ),
		'section'  => $section,
		'type'     => 'checkbox',
		'default'  => 1,
		'priority' => 8,
	);

	$options['archive_image_placement'] = array(
		'id'      => 'archive_image_placement',
		'label'   => __( 'Featured Image Placement:', 'brunch-pro' ),
		'section' => $section,
		'type'    => 'select',
		'default' => 'after_title',
		'priority' => 10,
		'choices' => array(
			'after_title'   => __( 'After Title', 'brunch-pro' ),
			'before_title'  => __( 'Before Title', 'brunch-pro' ),
			'after_content' => __( 'After Content', 'brunch-pro' ),
		),
	);

	Feastco_Customizer_Options::add_options( $options );
}

add_action( 'customize_register', 'brunch_pro_register_customizer_colors' );
/**
 * Register custom sections for the Brunch Pro theme.
 *
 * @since  1.0.0
 * @access public
 * @param  object $wp_customize the customizer object.
 * @return void
 */
function brunch_pro_register_customizer_colors( $wp_customize ) {
	$wp_customize->remove_section( 'colors' );

	if ( apply_filters( 'brunch_pro_disable_colors', false ) ) {
		return;
	}

	$options = array();
	$counter = 10;
	$panel = 'colors';

	$wp_customize->add_panel(
		$panel,
		array(
			'title'       => __( 'Colors', 'brunch-pro' ),
			'description' => __( 'You can customize your theme colors by changing any of the options within this panel.', 'brunch-pro' ),
			'capability'  => 'edit_theme_options',
			'priority'    => 70,
		)
	);

	$wp_customize->add_section(
		"{$panel}_general",
		array(
			'title'       => __( 'General', 'brunch-pro' ),
			'description' => __( 'Customize your general theme colors by changing the options below.', 'brunch-pro' ),
			'capability'  => 'edit_theme_options',
			'panel'       => $panel,
			'priority'    => 10,
		)
	);

	$wp_customize->add_section(
		"{$panel}_menus",
		array(
			'title'       => __( 'Menus', 'brunch-pro' ),
			'description' => __( 'Customize your menu colors by changing the options below.', 'brunch-pro' ),
			'capability'  => 'edit_theme_options',
			'panel'       => $panel,
			'priority'    => 12,
		)
	);

	$wp_customize->add_section(
		"{$panel}_buttons",
		array(
			'title'       => __( 'Buttons', 'brunch-pro' ),
			'description' => __( 'Customize your button colors by changing the options below.', 'brunch-pro' ),
			'capability'  => 'edit_theme_options',
			'panel'       => $panel,
			'priority'    => 14,
		)
	);

	foreach ( brunch_pro_get_colors() as $color => $setting ) {

		$options[ $color ] = array(
			'id'       => $color,
			'label'    => $setting['label'],
			'section'  => "{$panel}_{$setting['section']}",
			'type'     => 'color',
			'default'  => $setting['default'],
			'priority' => $counter++,
		);
	}

	Feastco_Customizer_Options::add_options( $options );
}

add_action( 'customize_register', 'brunch_pro_register_customizer_fonts' );
/**
 * Register custom sections for the Brunch Pro theme.
 *
 * @since  1.0.0
 * @access public
 * @param  object $wp_customize the customizer object.
 * @return void
 */
function brunch_pro_register_customizer_fonts( $wp_customize ) {
	if ( apply_filters( 'brunch_pro_disable_google_fonts', false ) ) {
		return;
	}

	$options = array();
	$counter = 10;
	$panel   = 'typography';
	$cap     = 'edit_theme_options';

	$wp_customize->add_panel(
		$panel,
		array(
			'title'       => __( 'Typography', 'brunch-pro' ),
			'description' => __( 'You can customize your theme font styles by changing any of the options within this panel.', 'brunch-pro' ),
			'capability'  => $cap,
			'priority'    => 75,
		)
	);

	$wp_customize->add_section(
		"{$panel}_families",
		array(
			'title'       => __( 'Font Families', 'brunch-pro' ),
			'description' => __( 'Customize your font families by changing the options below.', 'brunch-pro' ),
			'capability'  => $cap,
			'panel'       => $panel,
			'priority'    => 10,
		)
	);

	$wp_customize->add_section(
		"{$panel}_weights",
		array(
			'title'       => __( 'Font Weights', 'brunch-pro' ),
			'description' => __( 'Customize your font weights by changing the options below.', 'brunch-pro' ),
			'capability'  => $cap,
			'panel'       => $panel,
			'priority'    => 12,
		)
	);

	$wp_customize->add_section(
		"{$panel}_styles",
		array(
			'title'       => __( 'Font Styles', 'brunch-pro' ),
			'description' => __( 'Customize your font styles by changing the options below.', 'brunch-pro' ),
			'capability'  => $cap,
			'panel'       => $panel,
			'priority'    => 14,
		)
	);

	$wp_customize->add_section(
		"{$panel}_sizes",
		array(
			'title'       => __( 'Font Sizes', 'brunch-pro' ),
			'description' => __( 'Customize your font sizes by changing the options below.', 'brunch-pro' ),
			'capability'  => $cap,
			'panel'       => $panel,
			'priority'    => 16,
		)
	);

	foreach ( brunch_pro_get_fonts() as $font => $setting ) {
		if ( 'disabled' !== $setting['default_family'] ) {
			$options[ "{$font}_family" ] = array(
				'id'      => "{$font}_family",
				'label'   => $setting['label'] . __( ' Family', 'brunch-pro' ),
				'section' => "{$panel}_families",
				'type'    => 'select',
				'choices' => feastco_customizer_get_font_choices(),
				'default' => $setting['default_family'],
			);
		}

		if ( 'disabled' !== $setting['default_weight'] ) {
			$options[ "{$font}_weight" ] = array(
				'id'      => "{$font}_weight",
				'label'   => $setting['label'] . __( ' Weight', 'brunch-pro' ),
				'section' => "{$panel}_weights",
				'type'    => 'range',
				'default' => $setting['default_weight'],
				'input_attrs' => array(
					'min'   => 200,
					'max'   => 900,
					'step'  => 100,
				),
			);
		}

		if ( 'disabled' !== $setting['default_size'] ) {
			$options[ "{$font}_size" ] = array(
				'id'      => "{$font}_size",
				'label'   => $setting['label'] . __( ' Size', 'brunch-pro' ),
				'section' => "{$panel}_sizes",
				'type'    => 'range',
				'default' => $setting['default_size'],
				'input_attrs' => array(
					'min'   => $setting['min_size'],
					'max'   => $setting['max_size'],
					'step'  => 1,
				),
			);
		}

		if ( 'disabled' !== $setting['default_style'] ) {
			$options[ "{$font}_style" ] = array(
				'id'      => "{$font}_style",
				'label'   => $setting['label'] . __( ' Style', 'brunch-pro' ),
				'section' => "{$panel}_styles",
				'type'    => 'select',
				'default' => $setting['default_style'],
				'choices' => array(
					'normal' => 'Normal',
					'italic' => 'Italic',
				),
			);
		}
	}

	Feastco_Customizer_Options::add_options( $options );
}
