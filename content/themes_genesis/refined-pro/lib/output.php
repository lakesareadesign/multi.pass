<?php
/**
 * This file adds the required CSS for the Customizer to the Refined Theme.
 *
 * @package      Refined
 * @subpackage   Customizations
 * @link         http://restored316designs.com/themes
 * @author       Lauren Gaige // Restored 316 LLC
 * @copyright    Copyright (c) 2015, Restored 316 LLC, Released 04/12/2017
 * @license      GPL-2.0+
 */

add_action( 'wp_enqueue_scripts', 'refined_css' );
/**
* Checks the settings for the link color color, primary color, and header
* If any of these value are set the appropriate CSS is output
*
* @since 1.0.0
*/
function refined_css() {

	$handle = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$color_text              = get_theme_mod( 'refined_text_color', refined_customizer_get_default_text_color() );
	$color_links             = get_theme_mod( 'refined_links_color', refined_customizer_get_default_links_color() );
	$color_homeslider        = get_theme_mod( 'refined_homeslider_color', refined_customizer_get_default_homeslider_color() );
	$color_hometitles        = get_theme_mod( 'refined_hometitles_color', refined_customizer_get_default_hometitles_color() );
	$color_button            = get_theme_mod( 'refined_button_color', refined_customizer_get_default_button_color() );
	$color_buttonborder      = get_theme_mod( 'refined_buttonborder_color', refined_customizer_get_default_buttonborder_color() );
	$color_buttontext        = get_theme_mod( 'refined_buttontext_color', refined_customizer_get_default_buttontext_color() );
	$color_buttonhover       = get_theme_mod( 'refined_buttonhover_color', refined_customizer_get_default_buttonhover_color() );
	$color_buttonhoverborder = get_theme_mod( 'refined_buttonhoverborder_color', refined_customizer_get_default_buttonhoverborder_color() );
	$color_buttonhovertext   = get_theme_mod( 'refined_buttonhovertext_color', refined_customizer_get_default_buttonhovertext_color() );
	$color_newsletter        = get_theme_mod( 'refined_newsletter_color', refined_customizer_get_default_newsletter_color() );
	$color_footer            = get_theme_mod( 'refined_footer_color', refined_customizer_get_default_footer_color() );
	$color_footertext        = get_theme_mod( 'refined_footertext_color', refined_customizer_get_default_footertext_color() );
	$color_announcement      = get_theme_mod( 'refined_announcement_color', refined_customizer_get_default_announcement_color() );
	$color_announcementtext  = get_theme_mod( 'refined_announcementtext_color', refined_customizer_get_default_announcementtext_color() );

	$css = '';

	$css .= ( refined_customizer_get_default_text_color() !== $color_text ) ? sprintf( '

		body,
		h1, h2, h3, h4, h5, h6,
		.genesis-nav-menu a,
		.site-title a, .site-title a:hover,
		.entry-title a, .sidebar .widget-title a,
		.widget-above-content .enews-widget,
		input, select, textarea,
		.archive-pagination li a,
		.content #genesis-responsive-slider h2 a,
		.content article .custom-date {
			color: %1$s;
		}

		.front-page .site-inner .content-sidebar-wrap .widget-title {
			color: %1$s !important;
		}

		*::-moz-placeholder {
			color: %1$s;
		}

		', $color_text ) : '';

	$css .= ( refined_customizer_get_default_links_color() !== $color_links ) ? sprintf( '

		a,
		.genesis-nav-menu a:hover,
		.genesis-nav-menu .current-menu-item > a,
		.entry-title a:hover,
		.content #genesis-responsive-slider h2 a:hover,
		.single-post .entry-content h1,
		.page .entry-content h1,
		.single-post article h3,
		.page article h3,
		.single-post article h4,
		.page article h4,
		.menu-toggle:focus,
		.menu-toggle:hover,
		.sub-menu-toggle:focus,
		.sub-menu-toggle:hover {
			color: %1$s;
		}

		.woocommerce .woocommerce-message,
		.woocommerce .woocommerce-info {
			border-top-color: %1$s !important;
		}

		.woocommerce .woocommerce-message::before,
		.woocommerce .woocommerce-info::before,
		.woocommerce div.product p.price,
		.woocommerce div.product span.price,
		.woocommerce ul.products li.product .price,
		.woocommerce form .form-row .required,
		.front-page .icon {
			color: %1$s !important;
		}

		', $color_links ) : '';

	$css .= ( refined_customizer_get_default_homeslider_color() !== $color_homeslider ) ? sprintf( '

		.home-slider-overlay .widget-title,
		.front-page .home-slider-overlay.widget-area h3 {
			color: %1$s !important;
		}

		', $color_homeslider ) : '';

	$css .= ( refined_customizer_get_default_hometitles_color() !== $color_hometitles ) ? sprintf( '

		.front-page-1 .widget-title,
		.front-page-2 .widget-title,
		.front-page-3 .widget-title,
		.front-page-4 .widget-title,
		.front-page-5 .widget-title,
		.blog.widget-area .widget-title,
		.front-page .widget-area h3,
		.site-inner .flexible-widgets .widget:first-child {
			color: %1$s !important;
		}

		', $color_hometitles ) : '';

	$css .= ( refined_customizer_get_default_button_color() !== $color_button ) ? sprintf( '

		button, input[type="button"],
		input[type="reset"],
		input[type="submit"], .button,
		a.more-link,
		.more-from-category a,
		.site-wide-cta .enews-widget input[type="submit"]:hover,
		.announcement-widget .enews-widget input[type="submit"]:hover {
			background-color: %1$s;
		}

		.woocommerce #respond input#submit,
		.woocommerce a.button,
		.woocommerce button.button,
		.woocommerce input.button {
			background-color: %1$s !important;
		}

		', $color_button ) : '';

	$css .= ( refined_customizer_get_default_buttonborder_color() !== $color_buttonborder ) ? sprintf( '

		button, input[type="button"],
		input[type="reset"],
		input[type="submit"], .button,
		a.more-link,
		.more-from-category a,
		.site-wide-cta .enews-widget input[type="submit"]:hover,
		.announcement-widget .enews-widget input[type="submit"]:hover {
			border-color: %1$s;
		}

		.woocommerce #respond input#submit,
		.woocommerce a.button,
		.woocommerce button.button,
		.woocommerce input.button {
			border-color: %1$s !important;
		}

		', $color_buttonborder ) : '';

	$css .= ( refined_customizer_get_default_buttontext_color() !== $color_buttontext ) ? sprintf( '

		button, input[type="button"],
		input[type="reset"],
		input[type="submit"], .button,
		a.more-link,
		.more-from-category a,
		.site-wide-cta .enews-widget input[type="submit"]:hover,
		.announcement-widget .enews-widget input[type="submit"]:hover {
			color: %1$s;
		}

		.woocommerce #respond input#submit,
		.woocommerce a.button,
		.woocommerce button.button,
		.woocommerce input.button {
			color: %1$s !important;
		}

		', $color_buttontext ) : '';

	$css .= ( refined_customizer_get_default_buttonhover_color() !== $color_buttonhover ) ? sprintf( '

		button, input[type="button"]:hover,
		input[type="reset"]:hover,
		input[type="submit"]:hover,
		.button:hover,
		a.more-link:hover,
		.more-from-category a:hover,
		.site-wide-cta .enews-widget input[type="submit"],
		.announcement-widget .enews-widget input[type="submit"] {
			background-color: %1$s;
		}

		.woocommerce #respond input#submit:hover,
		.woocommerce a.button:hover,
		.woocommerce button.button:hover,
		.woocommerce input.button:hover,
		.woocommerce span.onsale {
			background-color: %1$s !important;
		}

		.nc_socialPanel.swp_d_fullColor .googlePlus,
		body .nc_socialPanel.swp_o_fullColor:hover .googlePlus,
		html body .nc_socialPanel.swp_i_fullColor .googlePlus:hover,
		.nc_socialPanel.swp_d_fullColor .twitter, body .nc_socialPanel.swp_o_fullColor:hover .twitter, html body .nc_socialPanel.swp_i_fullColor .twitter:hover,
		.nc_socialPanel.swp_d_fullColor .swp_fb, body .nc_socialPanel.swp_o_fullColor:hover .swp_fb, html body .nc_socialPanel.swp_i_fullColor .swp_fb:hover,
		.nc_socialPanel.swp_d_fullColor .linkedIn, body .nc_socialPanel.swp_o_fullColor:hover .linkedIn, html body .nc_socialPanel.swp_i_fullColor .linkedIn:hover,
		.nc_socialPanel.swp_d_fullColor .nc_pinterest, body .nc_socialPanel.swp_o_fullColor:hover .nc_pinterest, html body .nc_socialPanel.swp_i_fullColor .nc_pinterest:hover {
			background-color: %1$s !important;
		}

		', $color_buttonhover ) : '';


	$css .= ( refined_customizer_get_default_buttonhoverborder_color() !== $color_buttonhoverborder ) ? sprintf( '

		button, input[type="button"]:hover,
		input[type="reset"]:hover,
		input[type="submit"]:hover,
		.button:hover,
		a.more-link:hover,
		.more-from-category a:hover,
		.site-wide-cta .enews-widget input[type="submit"],
		.announcement-widget .enews-widget input[type="submit"] {
			border-color: %1$s;
		}

		.woocommerce #respond input#submit:hover,
		.woocommerce a.button:hover,
		.woocommerce button.button:hover,
		.woocommerce input.button:hover {
			border-color: %1$s !important;
		}

		', $color_buttonhoverborder ) : '';

	$css .= ( refined_customizer_get_default_buttonhovertext_color() !== $color_buttonhovertext ) ? sprintf( '

		button, input[type="button"]:hover,
		input[type="reset"]:hover,
		input[type="submit"]:hover,
		.button:hover,
		a.more-link:hover,
		.more-from-category a:hover,
		.site-wide-cta .enews-widget input[type="submit"],
		.announcement-widget .enews-widget input[type="submit"] {
			color: %1$s;
		}

		.woocommerce #respond input#submit:hover,
		.woocommerce a.button:hover,
		.woocommerce button.button:hover,
		.woocommerce input.button:hover {
			color: %1$s !important;
		}

		', $color_buttonhovertext ) : '';

	$css .= ( refined_customizer_get_default_newsletter_color() !== $color_newsletter ) ? sprintf( '

		.sidebar .enews-widget,
		.content article .custom-date,
		div.ck_form,
		.single-post .content article .custom-date,
		.after-entry .enews-widget {
			background-color: %1$s;
		}

		.front-page-1 .featured-content .entry-header,
		.woocommerce div.product .woocommerce-tabs ul.tabs li {
			background-color: %1$s !important;
		}

		', $color_newsletter ) : '';

	$css .= ( refined_customizer_get_default_footer_color() !== $color_footer ) ? sprintf( '

		.site-footer,
		#flex-footer {
			background-color: %1$s;
		}

		', $color_footer ) : '';

	$css .= ( refined_customizer_get_default_footertext_color() !== $color_footertext ) ? sprintf( '

		.site-footer,
		#flex-footer,
		.site-footer a,
		#flex-footer .widget-title,
		#flex-footer a {
			color: %1$s;
		}

		', $color_footertext ) : '';

	$css .= ( refined_customizer_get_default_announcement_color() !== $color_announcement ) ? sprintf( '

		.announcement-widget {
			background-color: %1$s;
		}

		', $color_announcement ) : '';

	$css .= ( refined_customizer_get_default_announcementtext_color() !== $color_announcementtext ) ? sprintf( '

		.announcement-widget {
			color: %1$s;
		}

		', $color_announcementtext ) : '';

	if ( $css ) {
		wp_add_inline_style( $handle, $css );
	}

}
