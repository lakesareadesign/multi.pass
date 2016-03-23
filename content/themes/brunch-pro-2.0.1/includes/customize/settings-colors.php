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

add_action( 'customize_register', 'brunch_pro_remove_customizer_defaults' );
add_action( 'customize_register', 'brunch_pro_register_customizer_colors' );

/**
 * Remove unwanted default customizer sections for the Brunch Pro theme.
 *
 * @since  1.0.0
 * @access public
 * @param  object $wp_customize the customizer object.
 * @return void
 */
function brunch_pro_remove_customizer_defaults( $wp_customize ) {
	$wp_customize->remove_section( 'colors' );
}

/**
 * Register custom sections for the Brunch Pro theme.
 *
 * @since  1.0.0
 * @access public
 * @param  object $wp_customize the customizer object.
 * @return void
 */
function brunch_pro_register_customizer_colors( $wp_customize ) {
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

	Customizer_Library::Instance()->add_options( $options );
}
