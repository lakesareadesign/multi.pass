<?php
/**
 * Kickstart Pro
 *
 * @author  Lean Themes
 * @license GPL-2.0+
 * @link    http://demo.leanthemes.co/kickstart/
 */

add_action( 'customize_register', 'kickstart_register_theme_customizer' );
/**
 * Registers options with the Theme Customizer
 *
 * @link http://code.tutsplus.com/tutorials/a-guide-to-the-wordpress-theme-customizer-adding-a-new-setting--wp-33180
 * @param      object    $wp_customize    The WordPress Theme Customizer
 */
function kickstart_register_theme_customizer( $wp_customize ) {

	$wp_customize->add_setting(
		'kickstart_primary_color',
		array(
			'default'     => '#f26c4f'
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'link_color',
			array(
			    'label'      => __( 'Primary Color', 'lean-kickstart' ),
			    'section'    => 'colors',
			    'settings'   => 'kickstart_primary_color'
			)
		)
	);
}
