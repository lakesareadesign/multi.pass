<?php
/**
 * Customizer additions.
 *
 * @package Modern Studio Pro
 * @author  StudioPress
 * @link    http://my.studiopress.com/themes/modern-studio/
 * @license GPL2-0+
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
function ms_customizer_get_default_accent_color() {
	return '#f7a27f';
}

add_action( 'customize_register', 'ms_customizer_register' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 1.0.0
 * 
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function ms_customizer_register() {

	global $wp_customize;
	
	$wp_customize->add_setting(
		'ms_accent_color',
		array(
			'default' => ms_customizer_get_default_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'ms_accent_color',
			array(
			    'label'    => __( 'Accent Color', 'modern-studio' ),
				'description' => __( 'Change the default accent color for links and link borders.', 'modern-studio' ),
			    'section'  => 'colors',
			    'settings' => 'ms_accent_color',
			)
		)
	);

}

add_action( 'wp_enqueue_scripts', 'ms_css' );
/**
* Checks the settings for the accent color, highlight color, and header
* If any of these value are set the appropriate CSS is output
*
* @since 1.0.0
*/
function ms_css() {

	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$color = get_theme_mod( 'ms_accent_color', ms_customizer_get_default_accent_color() );

	$css = '';
	
	$css .= ( ms_customizer_get_default_accent_color() !== $color ) ? sprintf( '
		a,
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
		.sticky-message a:hover {
			color: %1$s;
		}
		
		.after-entry a,
		.after-entry a:hover,
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
		.entry-content a,
		.entry-content a:hover,
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
		}
		', $color ) : '';

	if( $css ){
		wp_add_inline_style( $handle, $css );
	}

}
