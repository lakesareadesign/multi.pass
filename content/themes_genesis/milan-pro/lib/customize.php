<?php
/**
 * Customizer additions.
 *
 * @package Milan Pro
 * @author  Themetry
 * @link    http://my.studiopress.com/themes/milan/
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
function milan_customizer_get_default_accent_color() {
	return '#ffff00';
}

add_action( 'customize_register', 'milan_customizer_register' );

/**
 * Register settings and controls with the Customizer.
 *
 * @since 1.0.0
 * 
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function milan_customizer_register() {

	global $wp_customize;
	
	$wp_customize->add_setting(
		'milan_accent_color',
		array(
			'default' => milan_customizer_get_default_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'milan_accent_color',
			array(
			    'label'    => __( 'Accent Color', 'milan' ),
				'description' => __( 'Change the default accent color for links and link borders.', 'milan' ),
			    'section'  => 'colors',
			    'settings' => 'milan_accent_color',
			)
		)
	);

}

add_action( 'wp_enqueue_scripts', 'milan_css' );
/**
* Checks the settings for the accent color, highlight color, and header
* If any of these value are set the appropriate CSS is output
*
* @since 1.0.0
*/
function milan_css() {

	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$color = get_theme_mod( 'milan_accent_color', milan_customizer_get_default_accent_color() );

	$css = '';
	
	$css .= ( milan_customizer_get_default_accent_color() !== $color ) ? sprintf( '
		.site-header,
		.single .entry-title:before,
		.comment-reply-title  {
			background-color: %1$s;
		}

		.archive-pagination a,
		.site-main #infinite-handle span button,
		.site-main #infinite-handle span button:hover,
		.site-main #infinite-handle span button:focus,
		.archive-pagination a:before,
		#infinite-handle button:before,
		.main-navigation a,
		.byline a,
		.cat-links a,
		.entry-content a,
		.featured-primary .entry-excerpt a,
		.post-navigation .nav-links a,
		.comment-navigation a,
		.comment-content a,
		.comment-form a,
		.comment-author span[itemprop="name"] a,
		.widget a,
		.site-footer p a,
		.breadcrumb a,
		.featured-row {
			border-color: %1$s;
		}
		', $color ) : '';

	if( $css ) {
		wp_add_inline_style( $handle, $css );
	}

}

/**
 * Remove unwanted Customizer options
 *
 * @since 1.0.0
 * 
 */
add_action( 'customize_register', 'milan_customize_register', 99 );
function milan_customize_register( $wp_customize ) {
	$wp_customize->remove_section( 'genesis_archives' );
	$wp_customize->remove_control( 'blog_title' );
}
