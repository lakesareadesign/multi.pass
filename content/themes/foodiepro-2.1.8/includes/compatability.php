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

add_filter( 'genesis_responsive_slider_settings_defaults', 'foodie_pro_responsive_slider_defaults' );
/**
 * Set up some custom default settings for the Genesis Responsive Slier
 *
 * @since   2.0.0
 *
 * @param   $defaults array of plugin default settings
 * @return  $defaults array of new defaults for the Foodie pro theme
 */
function foodie_pro_responsive_slider_defaults( $defaults ) {
	$foodie = array(
		'slideshow_height'        => 350,
		'slideshow_width'         => 680,
		'slideshow_excerpt_show'  => 0,
		'slideshow_title_show'    => 1,
		'slideshow_hide_mobile'   => 0,
		'slideshow_excerpt_width' => '100',
	);
	return array_merge( $defaults, $foodie );
}
