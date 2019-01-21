<?php
/**
 * Gutenberg theme support.
 *
 * @package Infinity Pro
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */

add_action( 'wp_enqueue_scripts', 'infinity_pro_enqueue_gutenberg_frontend_styles' );
/**
 * Enqueues Gutenberg front-end styles.
 *
 * @since 1.2.0
 */
function infinity_pro_enqueue_gutenberg_frontend_styles() {

	wp_enqueue_style(
		'infinity-pro-gutenberg',
		get_stylesheet_directory_uri() . '/lib/gutenberg/front-end.css',
		array( 'infinity-pro' ),
		CHILD_THEME_VERSION
	);

}

add_action( 'enqueue_block_editor_assets', 'infinity_pro_block_editor_styles' );
/**
 * Enqueues Gutenberg admin editor fonts and styles.
 *
 * @since 1.2.0
 */
function infinity_pro_block_editor_styles() {

	wp_enqueue_style(
		'infinity-pro-gutenberg-fonts',
		'https://fonts.googleapis.com/css?family=Cormorant+Garamond:400,400i,700|Raleway:700',
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
			'name'      => __( 'Small', 'infinity-pro' ),
			'shortName' => __( 'S', 'infinity-pro' ),
			'size'      => 18,
			'slug'      => 'small',
		),
		array(
			'name'      => __( 'Normal', 'infinity-pro' ),
			'shortName' => __( 'M', 'infinity-pro' ),
			'size'      => 22,
			'slug'      => 'normal',
		),
		array(
			'name'      => __( 'Large', 'infinity-pro' ),
			'shortName' => __( 'L', 'infinity-pro' ),
			'size'      => 26,
			'slug'      => 'large',
		),
		array(
			'name'      => __( 'Larger', 'infinity-pro' ),
			'shortName' => __( 'XL', 'infinity-pro' ),
			'size'      => 30,
			'slug'      => 'larger',
		),
	)
);

// Adds support for editor color palette.
add_theme_support(
	'editor-color-palette',
	array(
		array(
			'name'  => __( 'Accent color', 'infinity-pro' ), // Called “Link Color” in the Customizer options. Renamed because “Link Color” implies it can only be used for links.
			'slug'  => 'accent',
			'color' => get_theme_mod( 'infinity_accent_color', infinity_customizer_get_default_accent_color() ),
		),
	)
);

require_once get_stylesheet_directory() . '/lib/gutenberg/inline-styles.php';

add_action( 'after_setup_theme', 'infinity_pro_content_width', 0 );
/**
 * Set content width to match the “wide” Gutenberg block width.
 */
function infinity_pro_content_width() {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- See https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/924
	$GLOBALS['content_width'] = apply_filters( 'infinity_pro_content_width', 1020 );
}
