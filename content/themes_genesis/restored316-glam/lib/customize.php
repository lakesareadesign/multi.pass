<?php
/**
 * Customizer Additions.
 *
 * @package      Glam
 * @link         http://restored316designs.com/themes
 * @author       Lauren Gaige // Restored 316 LLC
 * @copyright    Copyright (c) 2015, Restored 316 LLC, Released 02/03/2016
 * @license      GPL-2.0+
 */

//* This theme contains intellectual property owned by Restored 316 LLC, including trademarks, copyrights, proprietary information, and other intellectual property. You may not modify, publish, transmit, participate in the transfer or sale of, create derivative works from, distribute, reproduce or perform, or in any way exploit in any format whatsoever any of this theme or intellectual property, in whole or in part, without our prior written consent. 
 
/**
 * Get default primary color for Customizer.
 *
 * Abstracted here since at least two functions use it.
 *
 * @since 1.0.0
 *
 * @return string Hex color code for primary color.
 */
function glam_customizer_get_default_primary_color() {
	return '#ffe9e2';
}

/**
 * Get default accent color for Customizer.
 *
 * Abstracted here since at least two functions use it.
 *
 * @since 1.0.0
 *
 * @return string Hex color code for accent color.
 */
function glam_customizer_get_default_accent_color() {
	return '#333';
}

/**
 * Get default highlight color for Customizer.
 *
 * Abstracted here since at least two functions use it.
 *
 * @since 1.0.0
 *
 * @return string Hex color code for accent color.
 */
function glam_customizer_get_default_highlight_color() {
	return '#fec5b1';
}
 
add_action( 'customize_register', 'glam_customizer_register' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 1.0.0
 * 
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function glam_customizer_register() {

	global $wp_customize;
	
	$wp_customize->add_setting(
		'glam_primary_color',
		array(
			'default' => glam_customizer_get_default_primary_color(),
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'glam_primary_color',
			array(
				'description' => __( 'Change the default color for your top navigation, footer, and a few other elements.', 'glam' ),
			    'label'    => __( 'Primary Color', 'glam' ),
			    'section'  => 'colors',
			    'settings' => 'glam_primary_color',
			)
		)
	);
	
	$wp_customize->add_setting(
		'glam_accent_color',
		array(
			'default' => glam_customizer_get_default_accent_color(),
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'glam_accent_color',
			array(
				'description' => __( 'Change the default navigation links, and text on top of your Primary Color chosen above.', 'glam' ),
			    'label'    => __( 'Accent Color', 'glam' ),
			    'section'  => 'colors',
			    'settings' => 'glam_accent_color',
			)
		)
	);
	
	$wp_customize->add_setting(
		'glam_highlight_color',
		array(
			'default' => glam_customizer_get_default_highlight_color(),
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'glam_highlight_color',
			array(
				'description' => __( 'Change the default color of your links on hover.', 'glam' ),
			    'label'    => __( 'Highlight Color', 'glam' ),
			    'section'  => 'colors',
			    'settings' => 'glam_highlight_color',
			)
		)
	);

}

add_action( 'wp_enqueue_scripts', 'glam_css' );
/**
* Checks the settings for the accent color, highlight color, and header
* If any of these value are set the appropriate CSS is output
*
* @since 1.0.0
*/
function glam_css() {

	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$color = get_theme_mod( 'glam_primary_color', glam_customizer_get_default_primary_color() );
	$color_accent = get_theme_mod( 'glam_accent_color', glam_customizer_get_default_accent_color() );
	$color_highlight = get_theme_mod( 'glam_highlight_color', glam_customizer_get_default_highlight_color() );

	$css = '';
		
	$css .= ( glam_customizer_get_default_primary_color() !== $color ) ? sprintf( '
		
		.nav-primary,
		.site-footer,
		.archive-pagination li a:hover,
		.archive-pagination li.active a,
		.genesis-nav-menu .sub-menu a,
		.after-entry .enews-widget {
			background: %1$s;
		}
		
		a:hover,
		.entry-title a:hover, 
		.footer-widgets .entry-title a:hover {
			color: %1$s;
		}
		
		.woocommerce .woocommerce-message,
		.woocommerce .woocommerce-info {
			border-top-color: %1$s !important;
		}
		
		.woocommerce .woocommerce-message::before,
		.woocommerce .woocommerce-info::before,
		.woocommerce div.product p.price,
		.woocommerce form .form-row .required {
			color: %1$s !important;
		}
		
		.easyrecipe .ui-button-text-icon-primary .ui-button-text, 
		.easyrecipe .ui-button-text-icons .ui-button-text,
		#sb_instagram .sbi_follow_btn a {
			background-color: %1$s !important;
		}
		
		', $color ) : '';

	$css .= ( glam_customizer_get_default_accent_color() !== $color_accent ) ? sprintf( '

		.nav-primary .genesis-nav-menu a,
		.nav-primary .genesis-nav-menu .sub-menu a,
		.site-footer,
		.site-footer a,
		.site-footer .genesis-nav-menu a,
		.archive-pagination li a:hover,
		.archive-pagination li.active a,
		.after-entry .enews-widget .widget-title {
			color: %1$s;
		}
		
		.genesis-nav-menu *::-moz-placeholder {
			color: %1$s;
		}
		
		', $color_accent ) : '';
		
	$css .= ( glam_customizer_get_default_accent_color() !== $color_highlight ) ? sprintf( '

		a:hover {
			color: %1$s;
		}
		
		.woocommerce div.product p.price,
		.woocommerce div.product span.price {
			color: %1$s !important;
		}
		
		', $color_highlight ) : '';
		
		
	if ( glam_customizer_get_default_primary_color() !== $color || glam_customizer_get_default_accent_color() !== $color_accent || glam_customizer_get_default_highlight_color() !== $color_highlight ) {
		$css .= '
		}
		';
	}

	if( $css ){
		wp_add_inline_style( $handle, $css );
	}

}
