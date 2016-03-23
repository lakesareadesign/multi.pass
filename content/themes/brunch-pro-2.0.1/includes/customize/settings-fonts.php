<?php
/**
 * Register Customizer settings.
 *
 * @package    BrunchPro\Functions\Customizer
 * @subpackage Genesis
 * @author     Robert Neu
 * @copyright  Copyright (c) 2016, Shay Bocks
 * @license    GPL-2.0+
 * @link       http://www.shaybocks.com/brunch-pro/
 * @since      1.0.0
 */

defined( 'ABSPATH' ) || exit;

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
				'choices' => customizer_library_get_font_choices(),
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

	Customizer_Library::Instance()->add_options( $options );
}
