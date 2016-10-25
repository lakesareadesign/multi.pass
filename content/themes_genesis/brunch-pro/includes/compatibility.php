<?php
/**
 * Plugin compatibility functions.
 *
 * @package    BrunchPro\Functions\PluginCompatibility
 * @subpackage Genesis
 * @author     Robert Neu
 * @copyright  Copyright (c) 2016, Shay Bocks
 * @license    GPL-2.0+
 * @link       http://www.shaybocks.com/brunch-pro/
 * @since      1.0.0
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'init', 'brunch_pro_disable_easy_recipe' );
/**
 * Because EasyRecipe loads a lot of strange JavaScript, we need to disable as
 * much of it as we can when working in the customizer. If we don't do this, the
 * customizer will hang and performance will suffer.
 *
 * @since  1.0.0
 * @access public
 * @see    EasyRecipe https://wordpress.org/plugins/easyrecipe/
 * @return void
 */
function brunch_pro_disable_easy_recipe() {
	if ( class_exists( 'EasyRecipe', false ) && genesis_is_customizer() ) {
		$plugin = new EasyRecipe;
		remove_action( 'wp_enqueue_scripts', array( $plugin, 'enqueueScripts' ) );
	}
}

add_filter( 'simple_social_default_styles', 'brunch_pro_social_default_styles' );
/**
 * Override the default settings in the Simple Social Icons plugin.
 *
 * @since  1.0.0
 * @access public
 * @param  array $defaults the default settings.
 * @return array $defaults the overridden default settings.
 */
function brunch_pro_social_default_styles( $defaults ) {
	return wp_parse_args( array(
		'alignment'              => 'aligncenter',
		'background_color'       => '#ffffff',
		'background_color_hover' => '#f04848',
		'border_radius'          => 60,
		'icon_color'             => '#000000',
		'icon_color_hover'       => '#ffffff',
		'size'                   => 60,
	), $defaults );
}

add_filter( 'archive_template', 'brunch_pro_recipe_archive_template' );
/**
 * Load a custom page template for the recipe post type archive.
 *
 * @since  1.0.0
 * @access public
 * @uses   locate_template()
 * @param  string $template the default WordPress templates.
 * @return array  $templates an array of templates for our post type.
 */
function brunch_pro_recipe_archive_template( $template ) {
	if ( ! in_array( 'recipe', array_filter( (array) get_query_var( 'post_type' ) ) ) ) {
		return $template;
	}
	return locate_template( 'templates/page-recipes.php' );
}

add_action( 'init', 'brunch_pro_add_recipe_cpt_support' );
/**
 * Add support for Genesis settings to the Simmer recipe archive.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function brunch_pro_add_recipe_cpt_support() {
	add_post_type_support( 'recipe', 'genesis-layouts' );
	add_post_type_support( 'recipe', 'genesis-cpt-archives-settings' );
}
