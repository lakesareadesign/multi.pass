<?php
/**
 * Hello Pro.
 *
 * This file loads scripts and styles used in the Hello Pro Theme.
 *
 * @package Hello Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://www.studiopress.com/
 */

// * Enqueue Styles and Scripts
add_action( 'wp_enqueue_scripts', 'hello_pro_load_scripts' );

function hello_pro_load_scripts() {

	// * Get Sticky Header setting - to determine if we enqueue the JS
	$fixed_header_off = get_theme_mod( 'fixed_header_off', false );

	 // Dashicons.
	 wp_enqueue_style( 'dashicons' );

	 // Google Fonts.
	 wp_enqueue_style( 'google-font', '//fonts.googleapis.com/css?family=Lato:400,700,900|Quicksand:700', array(), CHILD_THEME_VERSION );

	 // Homepage-specific.
	if ( is_front_page() ) {
		wp_enqueue_style( 'home-styles', CHILD_THEME_URI . '/front-page.css', array( 'hello-pro' ), CHILD_THEME_VERSION );
	}

	 $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	 wp_enqueue_script( 'hello-pro-responsive-menu', CHILD_THEME_URI . "/js/responsive-menus{$suffix}.js", array( 'jquery' ), CHILD_THEME_VERSION, true );
	 wp_localize_script(
		 'hello-pro-responsive-menu',
		 'genesis_responsive_menu',
		 hello_pro_responsive_menu_settings()
	 );

	if ( false === $fixed_header_off ) {
		// Custom scripts.
		wp_enqueue_script( 'hello-pro-debounce', CHILD_THEME_URI . '/js/debounce.js', array( 'jquery' ), '2.0.0', true );
		// Sticky Nav
		// if ( is_active_sidebar( 'header-right' ) ) {
		// If sticky header is not disabled.
		wp_enqueue_script( 'sticky-nav-script', CHILD_THEME_URI . '/js/sticky-nav.js', array( 'hello-pro-debounce' ), '2.0.4', true );
	}
}
		// Define our responsive menu settings.
function hello_pro_responsive_menu_settings() {

	$settings = array(
			'mainMenu'          => __( 'Menu', 'hello-pro' ),
			'menuIconClass'     => 'dashicons-before dashicons-menu',
			'subMenu'           => __( 'Submenu', 'hello-pro' ),
			'subMenuIconsClass' => 'dashicons-before dashicons-arrow-down-alt2',
			'menuClasses'       => array(
			'combine' => array(
			'.nav-primary',
			'.nav-header',
			),
			'others'  => array(),
		),
	);

	return $settings;

}
