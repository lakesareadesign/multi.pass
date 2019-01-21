<?php
/**
 * Adds front-end inline styles for the custom Gutenberg color palette.
 *
 * @package Essence Pro
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */

add_action( 'wp_enqueue_scripts', 'essence_custom_gutenberg_css' );
/**
 * Output front-end inline styles for `editor-color-palette` colors.
 *
 * These colors can be changed in the Customizer, so CSS is set dynamically.
 *
 * @since 1.1.0
 */
function essence_custom_gutenberg_css() {

	$link_color = get_theme_mod( 'essence_link_color', essence_customizer_get_default_link_color() );

	$css = <<<CSS
.has-custom-color {
	color: $link_color !important;
}

.has-custom-background-color {
	background-color: $link_color !important;
}

.content .wp-block-button .wp-block-button__link:focus,
.content .wp-block-button .wp-block-button__link:hover {
	background-color: $link_color !important;
	color: #fff;
}

.entry-content .wp-block-pullquote.is-style-solid-color {
	background-color: $link_color;
}
CSS;

	$handle = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';
	wp_add_inline_style( $handle, $css );

}

add_action( 'enqueue_block_editor_assets', 'essence_custom_gutenberg_admin_css' );
/**
 * Output back-end inline styles for link state.
 *
 * Causes the custom color to apply to elements with the Gutenberg editor.
 * The custom color is set in the Customizer in the Colors panel.
 *
 * @since 1.1.0
 */
function essence_custom_gutenberg_admin_css() {

	$link_color = get_theme_mod( 'essence_link_color', essence_customizer_get_default_link_color() );

	$css = <<<CSS
.block-editor__container .editor-block-list__block a {
	color: $link_color;
}

h6 {
	color: $link_color !important;
}

.product-price {
	color: $link_color;
}

.product-add-to-cart {
	background-color: $link_color !important;
}

.wp-block-pullquote.is-style-solid-color {
	background-color: $link_color;
}
CSS;

	wp_add_inline_style( 'essence-pro-gutenberg-fonts', $css );

}
