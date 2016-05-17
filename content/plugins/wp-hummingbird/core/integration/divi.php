<?php
$stylesheet = get_stylesheet();
$theme = wp_get_theme();

if ( 'divi' === strtolower( $theme ) || 'divi' === strtolower( $theme->get_template() ) ) {
	if ( ! function_exists( 'wphb_divi_after_setup_theme' ) ) {
		// Divi tries to add inline script in header. This break dependencies with Hummingbird so we'll enqueue them at footer
		function wphb_divi_after_setup_theme() {
			if ( has_action( 'wp_head', 'et_divi_add_customizer_css' ) ) {
				remove_action( 'wp_head', 'et_divi_add_customizer_css' );
				add_action( 'wp_footer', 'et_divi_add_customizer_css', 900 );
			}
		}
		add_action( 'after_setup_theme', 'wphb_divi_after_setup_theme' );
	}
}