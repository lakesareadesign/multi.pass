<?php
/**
 * Adds front-end inline styles for the custom Gutenberg color palette.
 *
 * @package Magazine Pro
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */

add_action( 'wp_enqueue_scripts', 'magazine_custom_gutenberg_css' );
/**
 * Output front-end inline styles for `editor-color-palette` colors.
 *
 * These colors can be changed in the Customizer, so CSS is set dynamically.
 *
 * @since 3.3.0
 */
function magazine_custom_gutenberg_css() {

	$link_color   = get_theme_mod( 'magazine_link_color', magazine_get_default_link_color() );
	$accent_color = get_theme_mod( 'magazine_accent_color', magazine_get_default_accent_color() );

	$css = <<<CSS
.has-custom-color {
	color: $link_color !important;
}

.has-custom-background-color {
	background-color: $link_color !important;
}

.has-accent-color {
	color: $accent_color !important;
}

.has-accent-background-color {
	background-color: $accent_color !important;
}

.content .wp-block-button .wp-block-button__link:focus,
.content .wp-block-button .wp-block-button__link:hover {
	background-color: $accent_color;
	color: #fff;
}

.content .wp-block-button.is-style-outline .wp-block-button__link.has-text-color,
.content .wp-block-button.is-style-outline .wp-block-button__link:not(.has-text-color):focus,
.content .wp-block-button.is-style-outline .wp-block-button__link:not(.has-text-color):hover {
	color: $accent_color;
}

.entry-content .wp-block-pullquote.is-style-solid-color {
	background-color: $accent_color;
}
CSS;

	$handle = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';
	wp_add_inline_style( $handle, $css );

}

add_action( 'enqueue_block_editor_assets', 'magazine_custom_gutenberg_admin_css' );
/**
 * Output back-end inline styles for link hover state.
 *
 * Causes the link hover state in the Gutenberg editor to reflect the
 * Link Color set in the Customizer.
 *
 * @since 3.3.0
 */
function magazine_custom_gutenberg_admin_css() {

	$link_color   = get_theme_mod( 'magazine_link_color', magazine_get_default_link_color() );
	$accent_color = get_theme_mod( 'magazine_accent_color', magazine_get_default_accent_color() );

	$css = <<<CSS
.block-editor__container .editor-block-list__block a {
	color: $link_color;
}

.product-price {
	color: $link_color;
}

.wp-block-pullquote.is-style-solid-color {
	background-color: $accent_color;
}
CSS;

	wp_add_inline_style( 'magazine-pro-gutenberg-fonts', $css );

}