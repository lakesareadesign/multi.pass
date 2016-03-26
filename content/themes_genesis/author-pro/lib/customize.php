<?php

/**
 * Customizer additions.
 *
 * @package Author Pro
 * @author  StudioPress
 * @link    http://my.studiopress.com/themes/author/
 * @license GPL2-0+
 */
 
/**
 * Get default header color for Customizer.
 *
 * Abstracted here since at least two functions use it.
 *
 * @since 1.0.0
 *
 * @return string Hex color code for header color.
 */
function author_customizer_get_default_header_color() {

	return '#7a8690';

}

/**
 * Get default light color for Customizer.
 *
 * Abstracted here since at least two functions use it.
 *
 * @since 1.0.0
 *
 * @return string Hex color code for light color.
 */
function author_customizer_get_default_light_color() {

	return '#e1e9ee';

}

/**
 * Get default dark color for Customizer.
 *
 * Abstracted here since at least two functions use it.
 *
 * @since 1.0.0
 *
 * @return string Hex color code for dark color.
 */
function author_customizer_get_default_dark_color() {

	return '#181c1e';

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
function author_customizer_get_default_accent_color() {

	return '#0085da';

}

add_action( 'customize_register', 'author_customizer_register' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 1.0.0
 * 
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function author_customizer_register() {

	global $wp_customize;
	
	$wp_customize->add_setting(
		'author_header_color',
		array(
			'default' => author_customizer_get_default_header_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'author_header_color',
			array(
			    'label'    => __( 'Header Background Color', 'author' ),
				'description' => __( 'Change the header background color. You can use the same color as the background color, if desired.', 'author' ),
			    'section'  => 'colors',
			    'settings' => 'author_header_color',
			)
		)
	);
	
	$wp_customize->add_setting(
		'author_light_color',
		array(
			'default' => author_customizer_get_default_light_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'author_light_color',
			array(
			    'label'    => __( 'Light Color', 'author' ),
				'description' => __( 'Change the light background color for areas such as the secondary navigation and sidebar.', 'author' ),
			    'section'  => 'colors',
			    'settings' => 'author_light_color',
			)
		)
	);
	
	$wp_customize->add_setting(
		'author_dark_color',
		array(
			'default' => author_customizer_get_default_dark_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'author_dark_color',
			array(
			    'label'    => __( 'Dark Color', 'author' ),
				'description' => __( 'Change the dark background color for areas such as submenus and footer widgets.', 'author' ),
			    'section'  => 'colors',
			    'settings' => 'author_dark_color',
			)
		)
	);
	
	$wp_customize->add_setting(
		'author_accent_color',
		array(
			'default' => author_customizer_get_default_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'author_accent_color',
			array(
			    'label'    => __( 'Accent Color', 'author' ),
				'description' => __( 'Change the default accent color for links, numeric pagination, and highlighted menu items.', 'author' ),
			    'section'  => 'colors',
			    'settings' => 'author_accent_color',
			)
		)
	);

}

add_action( 'wp_enqueue_scripts', 'author_css' );
/**
* Checks the settings for the accent color, highlight color, and header
* If any of these value are set the appropriate CSS is output
*
* @since 1.0.0
*/
function author_css() {

	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$header_color = get_theme_mod( 'author_header_color', author_customizer_get_default_header_color() );
	$light_color = get_theme_mod( 'author_light_color', author_customizer_get_default_light_color() );
	$dark_color = get_theme_mod( 'author_dark_color', author_customizer_get_default_dark_color() );
	$accent_color = get_theme_mod( 'author_accent_color', author_customizer_get_default_accent_color() );

	$css = '';
	
	$css .= ( author_customizer_get_default_header_color() !== $header_color ) ? sprintf( '
		.site-header {
			background-color: %1$s;
		}
		', $header_color ) : '';
		
	$css .= ( author_customizer_get_default_light_color() !== $light_color ) ? sprintf( '
		blockquote::before,
		.nav-primary:hover .genesis-nav-menu a,
		.nav-secondary .genesis-nav-menu .sub-menu a {
			color: %1$s;
		}
		
		.content .widget-full .featuredpost,
		.nav-secondary,
		.sidebar .widget {
			background-color: %1$s;
		}
		', $light_color ) : '';
		
	$css .= ( author_customizer_get_default_dark_color() !== $dark_color ) ? sprintf( '
		.content .widget-full .featuredpage,
		.genesis-nav-menu .sub-menu,
		.genesis-nav-menu .sub-menu li a,
		.footer-widgets .wrap,
		.nav-secondary .genesis-nav-menu a:hover,
		.nav-secondary .genesis-nav-menu .current-menu-item > a,
		.nav-secondary .genesis-nav-menu .sub-menu .current-menu-item > a:hover,
		.site-footer .wrap,
		.widget-full .featured-content .widget-title {
			background-color: %1$s;
		}
		', $dark_color ) : '';
	
	$css .= ( author_customizer_get_default_accent_color() !== $accent_color ) ? sprintf( '
		a,
		.archive-pagination li a:hover,
		.archive-pagination .active a,
		.entry-title a:hover,
		.footer-widgets a:hover,		
		.site-footer a:hover {
			color: %1$s;
		}

		.nav-secondary .genesis-nav-menu .highlight > a {
			background-color: %1$s;
		}
		', $accent_color ) : '';

	if( $css ){
		wp_add_inline_style( $handle, $css );
	}

}
