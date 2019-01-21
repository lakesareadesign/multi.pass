<?php
/**
 * Gutenberg theme support.
 *
 * @package Magazine Pro
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */

add_action( 'wp_enqueue_scripts', 'magazine_pro_enqueue_gutenberg_frontend_styles' );
/**
 * Enqueues Gutenberg front-end styles.
 *
 * @since 3.3.0
 */
function magazine_pro_enqueue_gutenberg_frontend_styles() {

	wp_enqueue_style(
		'magazine-pro-gutenberg',
		get_stylesheet_directory_uri() . '/lib/gutenberg/front-end.css',
		array( 'magazine-pro' ),
		CHILD_THEME_VERSION
	);

}

add_action( 'enqueue_block_editor_assets', 'magazine_pro_block_editor_styles' );
/**
 * Enqueues Gutenberg admin editor fonts and styles.
 *
 * @since 3.3.0
 */
function magazine_pro_block_editor_styles() {

	wp_enqueue_style(
		'magazine-pro-gutenberg-fonts',
		'https://fonts.googleapis.com/css?family=Roboto:300,400|Raleway:400,500,900',
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
			'name'      => __( 'Small', 'magazine-pro' ),
			'shortName' => __( 'S', 'magazine-pro' ),
			'size'      => 12,
			'slug'      => 'small',
		),
		array(
			'name'      => __( 'Normal', 'magazine-pro' ),
			'shortName' => __( 'M', 'magazine-pro' ),
			'size'      => 16,
			'slug'      => 'normal',
		),
		array(
			'name'      => __( 'Large', 'magazine-pro' ),
			'shortName' => __( 'L', 'magazine-pro' ),
			'size'      => 20,
			'slug'      => 'large',
		),
		array(
			'name'      => __( 'Larger', 'magazine-pro' ),
			'shortName' => __( 'XL', 'magazine-pro' ),
			'size'      => 24,
			'slug'      => 'larger',
		),
	)
);

// Adds support for editor color palette.
add_theme_support(
	'editor-color-palette',
	array(
		array(
			'name'  => __( 'Custom color', 'magazine-pro' ), // Called “Link Color” in the Customizer options. Renamed because “Link Color” implies it can only be used for links.
			'slug'  => 'custom',
			'color' => get_theme_mod( 'magazine_link_color', magazine_get_default_link_color() ),
		),
		array(
			'name'  => __( 'Accent color', 'magazine-pro' ),
			'slug'  => 'accent',
			'color' => get_theme_mod( 'magazine_accent_color', magazine_get_default_accent_color() ),
		),
	)
);

require_once get_stylesheet_directory() . '/lib/gutenberg/inline-styles.php';

add_action( 'after_setup_theme', 'magazine_pro_content_width', 0 );
/**
 * Set content width to match the “wide” Gutenberg block width.
 */
function magazine_pro_content_width() {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- See https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/924
	$GLOBALS['content_width'] = apply_filters( 'magazine_pro_content_width', 1340 );
}
