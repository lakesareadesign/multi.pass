<?php
/**
 * Load theme widgets.
 *
 * @package    BrunchPro\Functions\Widgets
 * @subpackage Genesis
 * @author     Robert Neu
 * @copyright  Copyright (c) 2016, Shay Bocks
 * @license    GPL-2.0+
 * @link       http://www.shaybocks.com/brunch-pro/
 * @since      1.0.0
 */

defined( 'ABSPATH' ) || exit;

add_action( 'widgets_init', 'brunch_pro_register_sidebars', 5 );
add_action( 'widgets_init', 'brunch_pro_register_widgets', 10 );

/**
 * Register all custom sidebars.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function brunch_pro_register_sidebars() {
	genesis_register_sidebar( array(
		'id'          => 'before-header',
		'name'        => __( 'Before Header', 'brunch-pro' ),
		'description' => __( 'This is the section before the header.', 'brunch-pro' ),
	) );
	genesis_register_sidebar( array(
		'id'          => 'home-top',
		'name'        => __( 'Home Top', 'brunch-pro' ),
		'description' => __( 'This is the home top section.', 'brunch-pro' ),
	) );
	genesis_register_sidebar( array(
		'id'          => 'home-middle',
		'name'        => __( 'Home Middle', 'brunch-pro' ),
		'description' => __( 'This is the home middle section.', 'brunch-pro' ),
	) );
	genesis_register_sidebar( array(
		'id'          => 'home-bottom',
		'name'        => __( 'Home Bottom', 'brunch-pro' ),
		'description' => __( 'This is the home bottom section.', 'brunch-pro' ),
	) );
	genesis_register_sidebar( array(
		'id'          => 'recipe-index',
		'name'        => __( 'Recipe Index', 'brunch-pro' ),
		'description' => __( 'This is the recipe index section.', 'brunch-pro' ),
	) );
}

/**
 * Unregister the default Genesis Featured Posts widget and register all of
 * our custom Brunch Pro widgets.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function brunch_pro_register_widgets() {
	if ( ! class_exists( 'Brunch_Pro_Featured_Posts', false ) ) {
		brunch_pro_require_once( 'widgets/class-brunch-pro-featured-posts.php' );
	}

	unregister_widget( 'Genesis_Featured_Post' );
	register_widget( 'Brunch_Pro_Featured_Posts' );
}
