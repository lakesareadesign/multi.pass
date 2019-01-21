<?php
/**
 * Adds front-end inline styles for the custom Gutenberg color palette.
 *
 * @package Infinity Pro
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */

add_action( 'wp_enqueue_scripts', 'infinity_custom_gutenberg_css' );
/**
 * Output front-end inline styles for `editor-color-palette` colors.
 *
 * These colors can be changed in the Customizer, so CSS is set dynamically.
 *
 * @since 1.2.0
 */
function infinity_custom_gutenberg_css() {

	$accent_color   = get_theme_mod( 'infinity_accent_color', infinity_customizer_get_default_accent_color() );

	$css = <<<CSS
.has-accent-color {
	color: $accent_color !important;
}

.has-accent-background-color {
	background-color: $accent_color !important;
}

.content .wp-block-button .wp-block-button__link:focus,
.content .wp-block-button .wp-block-button__link:hover {
	background-color: $accent_color !important;
	color: #fff;
}

.content .wp-block-button.is-style-outline .wp-block-button__link:focus,
.content .wp-block-button.is-style-outline .wp-block-button__link:hover {
	border-color: $accent_color !important;
	color: $accent_color !important;
}


.entry-content .wp-block-pullquote.is-style-solid-color {
	background-color: $accent_color;
}

CSS;

	$handle = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';
	wp_add_inline_style( $handle, $css );

}

add_action( 'enqueue_block_editor_assets', 'infinity_custom_gutenberg_admin_css' );
/**
 * Output back-end inline styles for link state.
 *
 * Causes the custom color to apply to elements with the Gutenberg editor.
 * The custom color is set in the Customizer in the Colors panel.
 *
 * @since 1.2.0
 */
function infinity_custom_gutenberg_admin_css() {

	$accent_color = get_theme_mod( 'infinity_accent_color', infinity_customizer_get_default_accent_color() );

	$css = <<<CSS
.block-editor__container .editor-block-list__block a {
	color: $accent_color;
}

.product-title,
.product-price {
	color: $accent_color;
}

.wp-block-pullquote.is-style-solid-color {
	background-color: $accent_color;
}
CSS;

	wp_add_inline_style( 'infinity-pro-gutenberg-fonts', $css );

}
