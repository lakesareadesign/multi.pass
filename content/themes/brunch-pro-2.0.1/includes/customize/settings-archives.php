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

	Customizer_Library::Instance()->add_options( $options );
}
