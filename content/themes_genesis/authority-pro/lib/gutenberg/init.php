<?php
/**
 * Gutenberg theme support.
 *
 * @package Authority Pro
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */

add_action( 'wp_enqueue_scripts', 'authority_pro_enqueue_gutenberg_frontend_styles' );
/**
 * Enqueues Gutenberg front-end styles.
 *
 * @since 2.7.0
 */
function authority_pro_enqueue_gutenberg_frontend_styles() {

	wp_enqueue_style(
		'authority-pro-gutenberg',
		get_stylesheet_directory_uri() . '/lib/gutenberg/front-end.css',
		array( 'authority-pro' ),
		CHILD_THEME_VERSION
	);

}

add_action( 'enqueue_block_editor_assets', 'authority_pro_block_editor_styles' );
/**
 * Enqueues Gutenberg admin editor fonts and styles.
 *
 * @since 2.7.0
 */
function authority_pro_block_editor_styles() {

	wp_enqueue_style(
		'authority-pro-gutenberg-fonts',
		'https://fonts.googleapis.com/css?family=Source+Sans+Pro:600,700,900|Libre+Baskerville:400,400italic,700',
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
			'name'      => __( 'Small', 'authority-pro' ),
			'shortName' => __( 'S', 'authority-pro' ),
			'size'      => 12,
			'slug'      => 'small',
		),
		array(
			'name'      => __( 'Normal', 'authority-pro' ),
			'shortName' => __( 'M', 'authority-pro' ),
			'size'      => 16,
			'slug'      => 'normal',
		),
		array(
			'name'      => __( 'Large', 'authority-pro' ),
			'shortName' => __( 'L', 'authority-pro' ),
			'size'      => 20,
			'slug'      => 'large',
		),
		array(
			'name'      => __( 'Larger', 'authority-pro' ),
			'shortName' => __( 'XL', 'authority-pro' ),
			'size'      => 24,
			'slug'      => 'larger',
		),
	)
);

require_once get_stylesheet_directory() . '/lib/gutenberg/inline-styles.php';

add_theme_support(
	'editor-color-palette',
	array(
		array(
			'name'  => __( 'Primary color', 'authority-pro' ),
			'slug'  => 'primary',
			'color' => get_theme_mod( 'authority_primary_color', authority_customizer_get_default_primary_color() ),
		),
	)
);

add_action( 'after_setup_theme', 'authority_pro_content_width', 0 );
/**
 * Set content width to match the “wide” Gutenberg block width.
 */
function authority_pro_content_width() {

	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- See https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/924
	$GLOBALS['content_width'] = apply_filters( 'authority_pro_content_width', 1062 );

}
