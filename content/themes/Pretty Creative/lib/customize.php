<?php
/**
 * Customizer additions.
 *
 * @package Pretty Creative
 * @author  Lindsey Riel
 * @link    http://prettydarncute.com/product/pretty-creative/
 */
 
/**
 * Get default accent color for Customizer.
 *
 * Abstracted here since at least two functions use it.
 *
 * @since 1.0.0
 *
 * @return string Hex color code for accent color.
 */
function pc_customizer_get_default_accent_color() {
	return '#2c2c2c';
}

add_action( 'customize_register', 'pc_customizer_register' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 1.0.0
 * 
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function pc_customizer_register() {

	global $wp_customize;
	
	$wp_customize->add_setting(
		'pc_accent_color',
		array(
			'default' => pc_customizer_get_default_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'pc_accent_color',
			array(
			    'label'    => __( 'Accent Color', 'pretty-creative' ),
				'description' => __( 'Change the default accent color for links and link borders.', 'pretty-creative' ),
			    'section'  => 'colors',
			    'settings' => 'pc_accent_color',
			)
		)
	);

}

add_action( 'wp_enqueue_scripts', 'pc_css' );
/**
* Checks the settings for the accent color, highlight color, and header
* If any of these value are set the appropriate CSS is output
*
* @since 1.0.0
*/
function pc_css() {

	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$color = get_theme_mod( 'pc_accent_color', pc_customizer_get_default_accent_color() );

	$css = '';
	
	$css .= ( pc_customizer_get_default_accent_color() !== $color ) ? sprintf( '
		a,
		.nav-primary .genesis-nav-menu a,
		.widget-title,
		.after-entry a:hover,
		.archive-description a:hover,
		.author-box a:hover,
		.breadcrumb a:hover,
		.comment-respond a:hover,
		.entry-comments a:hover,
		.entry-content a:hover,
		.entry-title a:hover,
		.footer-widgets a:hover,
		.genesis-nav-menu a:hover,
		.genesis-nav-menu .sub-menu a:hover,
		.pagination a:hover,
		.sidebar a:hover,
		.site-footer a:hover,
		.sticky-message a:hover,
		.genesis-nav-menu .search-form input[type="submit"] {
			color: %1$s;
		}


		.home-subscribe-widget .enews-widget input:hover[type="submit"],
		.woocommerce ul.products li.product .price,
		.woocommerce div.product p.price,
		.woocommerce div.product span.price {
			color: %1$s !important;
		}


		.nav-secondary .genesis-nav-menu a,
		.home-subscribe-widget .enews-widget input[type="submit"],
		.sidebar .widget.enews-widget,
		.woocommerce .woocommerce-info:before,
		.woocommerce-page .woocommerce-info:before,
		.woocommerce span.onsale {
			background-color: %1$s !important;
		}

		input:hover[type="button"],
		input:hover[type="reset"],
		input:hover[type="submit"],
		.button:hover,
		::-moz-selection,
		::selection,
		.rmtext:hover,
		a.more-link:hover,
		.enews-widget input:hover[type="submit"],
		.nav-secondary .genesis-nav-menu a:hover {
			background-color: %1$s;
		}

		.nav-primary .simple-social-icons ul li a {
			color: %1$s !important;
		}
		
		.archive-description a,
		.archive-description a:hover,
		.author-box a,
		.author-box a:hover,
		.breadcrumb a,		
		.breadcrumb a:hover,
		.comment-respond a,
		.comment-respond a:hover,
		.entry-comments a,
		.entry-comments a:hover,
		.footer-widgets a,
		.footer-widgets a:hover,
		.pagination a,
		.pagination a:hover,
		.sidebar a,
		.sidebar a:hover,		
		.site-footer a,
		.site-footer a:hover,
		.sticky-message a,
		.sticky-message a:hover {
			border-color: %1$s;
		}		', $color ) : '';

	if( $css ){
		wp_add_inline_style( $handle, $css );
	}

}
