<?php
/**
 * Adds front-end inline styles for the custom Gutenberg color palette.
 *
 * @package Authority Pro
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */

add_action( 'wp_enqueue_scripts', 'authority_custom_gutenberg_css' );
/**
 * Output front-end inline styles for `editor-color-palette` colors.
 *
 * These colors can be changed in the Customizer, so CSS is set dynamically.
 *
 * @since 1.1.0
 */
function authority_custom_gutenberg_css() {

	$primary_color = get_theme_mod( 'authority_primary_color', authority_customizer_get_default_primary_color() );

	$css = <<<CSS
.entry-content .has-primary-color {
	color: $primary_color !important;
}

.entry-content .has-primary-background-color {
	background-color: $primary_color !important;
}

.content .wp-block-button.is-style-outline .wp-block-button__link:focus,
.content .wp-block-button.is-style-outline .wp-block-button__link:hover {
	border: 2px solid $primary_color !important;
	color: $primary_color !important;
}

.content .wp-block-button .wp-block-button__link:focus,
.content .wp-block-button .wp-block-button__link:hover {
	background-color: $primary_color;
	color: #fff;
}

.entry-content .wp-block-pullquote.is-style-solid-color {
	background-color: $primary_color;
}
CSS;

	$handle = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';
	wp_add_inline_style( $handle, $css );

}

add_action( 'enqueue_block_editor_assets', 'authority_custom_gutenberg_admin_css' );
/**
 * Output back-end inline styles for link state.
 *
 * Causes the custom color to apply to elements with the Gutenberg editor.
 * The custom color is set in the Customizer in the Colors panel.
 *
 * @since 1.1.0
 */
function authority_custom_gutenberg_admin_css() {

	$primary_color = get_theme_mod( 'authority_primary_color', authority_customizer_get_default_primary_color() );

	$css = <<<CSS
.block-editor__container .editor-block-list__block a {
	color: $primary_color;
}

h4,
h5 {
	color: $primary_color !important;
}

.product-price {
	color: $primary_color;
}

.product-add-to-cart {
	border: 2px solid $primary_color !important;
	color: $primary_color !important;
}

.wp-block-pullquote.is-style-solid-color {
	background-color: $primary_color;
}
CSS;

	wp_add_inline_style( 'authority-pro-gutenberg-fonts', $css );

}
