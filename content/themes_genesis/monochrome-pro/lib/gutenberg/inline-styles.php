<?php
/**
 * Adds front-end inline styles for the custom Gutenberg color palette.
 *
 * @package Monochrome Pro
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */

add_action( 'wp_enqueue_scripts', 'monochrome_custom_gutenberg_css' );
/**
 * Output front-end inline styles for `editor-color-palette` colors.
 *
 * These colors can be changed in the Customizer, so CSS is set dynamically.
 *
 * @since 1.1.0
 */
function monochrome_custom_gutenberg_css() {

	$custom_color = get_theme_mod( 'monochrome_link_color', monochrome_customizer_get_default_link_color() );
	$accent_color = get_theme_mod( 'monochrome_accent_color', monochrome_customizer_get_default_accent_color() );

	$css = <<<CSS
.entry-content .has-custom-color {
	color: $custom_color !important;
}

.entry-content .has-custom-background-color {
	background-color: $custom_color !important;
}

.entry-content .has-accent-color {
	color: $accent_color !important;
}

.entry-content .has-accent-background-color {
	background-color: $accent_color !important;
}

.content .wp-block-button .wp-block-button__link:focus,
.content .wp-block-button .wp-block-button__link:hover {
	background-color: $accent_color !important;
	color: #fff;
}

.entry-content .wp-block-pullquote.is-style-solid-color {
	background-color: $accent_color;
}

CSS;

	$handle = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';
	wp_add_inline_style( $handle, $css );

}

add_action( 'enqueue_block_editor_assets', 'monochrome_custom_gutenberg_admin_css' );
/**
 * Output back-end inline styles for link state.
 *
 * Causes the custom color to apply to elements with the Gutenberg editor.
 * The custom color is set in the Customizer in the Colors panel.
 *
 * @since 1.1.0
 */
function monochrome_custom_gutenberg_admin_css() {

	$custom_color = get_theme_mod( 'monochrome_link_color', monochrome_customizer_get_default_link_color() );
	$accent_color = get_theme_mod( 'monochrome_accent_color', monochrome_customizer_get_default_accent_color() );

	$css = <<<CSS
.block-editor__container .editor-block-list__block a {
	color: $custom_color;
}

.product-title,
.product-price {
	color: $custom_color;
}

.wp-block-pullquote.is-style-solid-color {
	background-color: $accent_color;
}
CSS;

	wp_add_inline_style( 'monochrome-pro-gutenberg-fonts', $css );

}
