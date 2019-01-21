<?php
/**
 * Gutenberg theme support.
 *
 * @package Monochrome Pro
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */

add_action( 'wp_enqueue_scripts', 'monochrome_pro_enqueue_gutenberg_frontend_styles' );
/**
 * Enqueues Gutenberg front-end styles.
 *
 * @since 2.7.0
 */
function monochrome_pro_enqueue_gutenberg_frontend_styles() {

	wp_enqueue_style(
		'monochrome-pro-gutenberg',
		get_stylesheet_directory_uri() . '/lib/gutenberg/front-end.css',
		array( 'monochrome-pro' ),
		CHILD_THEME_VERSION
	);

}

add_action( 'enqueue_block_editor_assets', 'monochrome_pro_block_editor_styles' );
/**
 * Enqueues Gutenberg admin editor fonts and styles.
 *
 * @since 2.7.0
 */
function monochrome_pro_block_editor_styles() {

	wp_enqueue_style(
		'monochrome-pro-gutenberg-fonts',
		'https://fonts.googleapis.com/css?family=Muli:200,300,300i,400,400i,600,600i|Open+Sans+Condensed:300',
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
			'name'      => __( 'Small', 'monochrome-pro' ),
			'shortName' => __( 'S', 'monochrome-pro' ),
			'size'      => 14,
			'slug'      => 'small',
		),
		array(
			'name'      => __( 'Normal', 'monochrome-pro' ),
			'shortName' => __( 'M', 'monochrome-pro' ),
			'size'      => 18,
			'slug'      => 'normal',
		),
		array(
			'name'      => __( 'Large', 'monochrome-pro' ),
			'shortName' => __( 'L', 'monochrome-pro' ),
			'size'      => 22,
			'slug'      => 'large',
		),
		array(
			'name'      => __( 'Larger', 'monochrome-pro' ),
			'shortName' => __( 'XL', 'monochrome-pro' ),
			'size'      => 26,
			'slug'      => 'larger',
		),
	)
);

require_once get_stylesheet_directory() . '/lib/gutenberg/inline-styles.php';

add_theme_support(
	'editor-color-palette',
	array(
		array(
			'name'  => __( 'Custom color', 'monochrome-pro' ),
			'slug'  => 'custom',
			'color' => get_theme_mod( 'monochrome_link_color', monochrome_customizer_get_default_link_color() ),
		),
		array(
			'name'  => __( 'Accent color', 'monochrome-pro' ),
			'slug'  => 'accent',
			'color' => get_theme_mod( 'monochrome_accent_color', monochrome_customizer_get_default_accent_color() ),
		),
	)
);

add_action( 'after_setup_theme', 'monochrome_pro_content_width', 0 );
/**
 * Set content width to match the “wide” Gutenberg block width.
 */
function monochrome_pro_content_width() {

	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- See https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/924
	$GLOBALS['content_width'] = apply_filters( 'monochrome_pro_content_width', 1062 );

}
