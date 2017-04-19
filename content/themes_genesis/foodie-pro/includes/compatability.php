<?php
/**
 * Plugin compatibility functions.
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

if ( ! function_exists( 'genesis_is_customizer' ) ) {
	/**
	 * Check whether we are currently viewing the site via the WordPress Customizer.
	 *
	 * @since 2.0.0
	 *
	 * @global $wp_customize Customizer.
	 *
	 * @return boolean Return true if viewing page via Customizer, false otherwise.
	 */
	function genesis_is_customizer() {

		global $wp_customize;

		return is_a( $wp_customize, 'WP_Customize_Manager' ) && $wp_customize->is_preview();

	}
}

add_filter( 'init', 'foodie_pro_disable_easy_recipe' );
/**
 * Because EasyRecipe loads a lot of strange JavaScript, we need to disable as
 * much of it as we can when working in the customizer. If we don't do this, the
 * customizer will hang and performance will suffer.
 *
 * @since   2.0.0
 *
 * @return  null if we're not in the customizer or EasyRecipe is deactivated.
 * @see     EasyRecipe https://wordpress.org/plugins/easyrecipe/
 */
function foodie_pro_disable_easy_recipe() {
	if ( ! class_exists( 'EasyRecipe' ) || ! genesis_is_customizer() ) {
		return;
	}

	$plugin = new EasyRecipe;
	remove_action( 'wp_enqueue_scripts', array( $plugin, 'enqueueScripts' ) );
}
