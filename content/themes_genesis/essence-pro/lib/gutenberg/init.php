<?php
/**
 * Gutenberg theme support.
 *
 * @package Essence Pro
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */

add_action( 'wp_enqueue_scripts', 'essence_pro_enqueue_gutenberg_frontend_styles' );
/**
 * Enqueues Gutenberg front-end styles.
 *
 * @since 1.1.0
 */
function essence_pro_enqueue_gutenberg_frontend_styles() {

	wp_enqueue_style(
		'essence-pro-gutenberg',
		get_stylesheet_directory_uri() . '/lib/gutenberg/front-end.css',
		array( 'essence-pro' ),
		CHILD_THEME_VERSION
	);

}

add_action( 'enqueue_block_editor_assets', 'essence_pro_block_editor_styles' );
/**
 * Enqueues Gutenberg admin editor fonts and styles.
 *
 * @since 1.1.0
 */
function essence_pro_block_editor_styles() {

	wp_enqueue_style(
		'essence-pro-gutenberg-fonts',
		'https://fonts.googleapis.com/css?family=Alegreya+Sans:400,400i,700|Lora:400,700',
		array(),
		CHILD_THEME_VERSION
	);

}

// Add support for editor styles.
add_theme_support( 'editor-styles' );

// Enqueue editor styles.
add_editor_style( '/lib/gutenberg/style-editor.css' );

// Adds support for block alignments.
add_theme_support( 'align-wide' );

// Make media embeds responsive.
add_theme_support( 'responsive-embeds' );

// Adds support for editor font sizes.
add_theme_support(
	'editor-font-sizes',
	array(
		array(
			'name'      => __( 'Small', 'essence-pro' ),
			'shortName' => __( 'S', 'essence-pro' ),
			'size'      => 16,
			'slug'      => 'small',
		),
		array(
			'name'      => __( 'Normal', 'essence-pro' ),
			'shortName' => __( 'M', 'essence-pro' ),
			'size'      => 18,
			'slug'      => 'normal',
		),
		array(
			'name'      => __( 'Large', 'essence-pro' ),
			'shortName' => __( 'L', 'essence-pro' ),
			'size'      => 22,
			'slug'      => 'large',
		),
		array(
			'name'      => __( 'Larger', 'essence-pro' ),
			'shortName' => __( 'XL', 'essence-pro' ),
			'size'      => 26,
			'slug'      => 'larger',
		),
	)
);

// Adds support for editor color palette.
add_theme_support(
	'editor-color-palette',
	array(
		array(
			'name'  => __( 'Custom color', 'essence-pro' ), // Called “Link Color” in the Customizer options. Renamed because “Link Color” implies it can only be used for links.
			'slug'  => 'custom',
			'color' => get_theme_mod( 'essence_link_color', essence_customizer_get_default_link_color() ),
		),
	)
);

require_once get_stylesheet_directory() . '/lib/gutenberg/inline-styles.php';

add_action( 'after_setup_theme', 'essence_pro_content_width', 0 );
/**
 * Set content width to match the “wide” Gutenberg block width.
 */
function essence_pro_content_width() {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- See https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/924
	$GLOBALS['content_width'] = apply_filters( 'essence_pro_content_width', 860 );
}
