<?php
/**
 * Gutenberg theme support.
 *
 * @package Breakthrough Pro
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */

add_action( 'wp_enqueue_scripts', 'breakthrough_pro_enqueue_gutenberg_frontend_styles' );
/**
 * Enqueues Gutenberg front-end styles.
 *
 * @since 1.1.0
 */
function breakthrough_pro_enqueue_gutenberg_frontend_styles() {

	wp_enqueue_style(
		'breakthrough-pro-gutenberg',
		get_stylesheet_directory_uri() . '/lib/gutenberg/front-end.css',
		array( 'breakthrough-pro' ),
		CHILD_THEME_VERSION
	);

}

add_action( 'enqueue_block_editor_assets', 'breakthrough_pro_block_editor_styles' );
/**
 * Enqueues Gutenberg admin editor fonts and styles.
 *
 * @since 1.1.0
 */
function breakthrough_pro_block_editor_styles() {

	wp_enqueue_style(
		'breakthrough-pro-gutenberg-fonts',
		'https://fonts.googleapis.com/css?family=Alegreya+Sans:400,400i,700|PT+Serif:400,400i,700,700i',
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
			'name'      => __( 'Small', 'breakthrough-pro' ),
			'shortName' => __( 'S', 'breakthrough-pro' ),
			'size'      => 16,
			'slug'      => 'small',
		),
		array(
			'name'      => __( 'Normal', 'breakthrough-pro' ),
			'shortName' => __( 'M', 'breakthrough-pro' ),
			'size'      => 20,
			'slug'      => 'normal',
		),
		array(
			'name'      => __( 'Large', 'breakthrough-pro' ),
			'shortName' => __( 'L', 'breakthrough-pro' ),
			'size'      => 24,
			'slug'      => 'large',
		),
		array(
			'name'      => __( 'Larger', 'breakthrough-pro' ),
			'shortName' => __( 'XL', 'breakthrough-pro' ),
			'size'      => 28,
			'slug'      => 'larger',
		),
	)
);

// Adds support for editor color palette.
add_theme_support(
	'editor-color-palette',
	array(
		array(
			'name'  => __( 'Primary color', 'breakthrough-pro' ),
			'slug'  => 'primary',
			'color' => get_theme_mod( 'breakthrough_primary_color', breakthrough_customizer_get_primary_color() ),
		),
		array(
			'name'  => __( 'Secondary color', 'breakthrough-pro' ),
			'slug'  => 'secondary',
			'color' => get_theme_mod( 'breakthrough_secondary_color', breakthrough_customizer_get_secondary_color() ),
		),
	)
);

require_once get_stylesheet_directory() . '/lib/gutenberg/inline-styles.php';

add_action( 'after_setup_theme', 'breakthrough_pro_content_width', 0 );
/**
 * Set content width to match the “wide” Gutenberg block width.
 */
function breakthrough_pro_content_width() {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- See https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/924
	$GLOBALS['content_width'] = apply_filters( 'breakthrough_pro_content_width', 860 );
}
