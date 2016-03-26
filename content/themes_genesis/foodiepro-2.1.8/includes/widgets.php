<?php
/**
 * Load theme widgets.
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

add_action( 'widgets_init', 'foodie_pro_include_widgets', 10 );
/**
 * Load all the required widget class files.
 *
 * @since  2.0.0
 */
function foodie_pro_include_widgets() {
	if ( class_exists( 'Foodie_Pro_Featured_Posts' ) ) {
		return;
	}
	$widgets_dir = trailingslashit( get_stylesheet_directory() ) . 'includes/widgets/';
	require_once $widgets_dir . 'foodie-featured-posts.php';
}

add_action( 'widgets_init', 'foodie_pro_register_widgets', 11 );
/**
 * Unregister the default Genesis Featured Posts widget and register all of
 * our custom Foodie Pro widgets.
 *
 * @since  2.0.0
 */
function foodie_pro_register_widgets() {
	if ( ! class_exists( 'Foodie_Pro_Featured_Posts' ) ) {
		return;
	}
	unregister_widget( 'Genesis_Featured_Post' );
	register_widget( 'Foodie_Pro_Featured_Posts' );
}
