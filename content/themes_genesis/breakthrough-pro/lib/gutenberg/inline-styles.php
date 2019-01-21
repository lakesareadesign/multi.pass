<?php
/**
 * Adds front-end inline styles for the custom Gutenberg color palette.
 *
 * @package Breakthrough Pro
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */

add_action( 'wp_enqueue_scripts', 'breakthrough_custom_gutenberg_css' );
/**
 * Output front-end inline styles for `editor-color-palette` colors.
 *
 * These colors can be changed in the Customizer, so CSS is set dynamically.
 *
 * @since 1.1.0
 */
function breakthrough_custom_gutenberg_css() {

	$color_primary          = get_theme_mod( 'breakthrough_primary_color', breakthrough_customizer_get_primary_color() );
	$color_secondary        = get_theme_mod( 'breakthrough_secondary_color', breakthrough_customizer_get_secondary_color() );
	$color_primary_brighter = breakthrough_color_brightness( $color_primary, 20 );

	$css = <<<CSS
.has-primary-color {
	color: $color_primary !important;
}

.has-primary-background-color {
	background-color: $color_primary !important;
}

.has-secondary-color {
	color: $color_secondary !important;
}

.has-secondary-background-color {
	background-color: $color_secondary !important;
}

.content .wp-block-button .wp-block-button__link:focus,
.content .wp-block-button .wp-block-button__link:hover {
	background-color: $color_primary !important;
	color: #fff;
}

.content .wp-block-button.is-style-outline .wp-block-button__link:focus,
.content .wp-block-button.is-style-outline .wp-block-button__link:hover {
	border-color: $color_primary !important;
	color: $color_primary !important;
}

.entry-content .wp-block-pullquote.is-style-solid-color {
	background-color: $color_primary;
}
CSS;

	$handle = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';
	wp_add_inline_style( $handle, $css );

}

add_action( 'enqueue_block_editor_assets', 'breakthrough_custom_gutenberg_admin_css' );
/**
 * Output back-end inline styles for link state.
 *
 * Causes the custom color to apply to elements with the Gutenberg editor.
 * The custom color is set in the Customizer in the Colors panel.
 *
 * @since 1.1.0
 */
function breakthrough_custom_gutenberg_admin_css() {

	$color_primary   = get_theme_mod( 'breakthrough_primary_color', breakthrough_customizer_get_primary_color() );
	$color_secondary = get_theme_mod( 'breakthrough_secondary_color', breakthrough_customizer_get_secondary_color() );

	$css = <<<CSS
.block-editor__container .editor-block-list__block a {
	color: $color_secondary;
}

h4,
h5 {
	color: $color_primary !important;
}

.block-editor__container .wp-block-button .wp-block-button__link {
	background-color: $color_primary;
}

.product-price {
	color: $color_primary;
}

.product-add-to-cart {
	background-color: $color_secondary !important;
}

.wp-block-pullquote.is-style-solid-color {
	background-color: $color_primary;
}
CSS;

	wp_add_inline_style( 'breakthrough-pro-gutenberg-fonts', $css );

}
