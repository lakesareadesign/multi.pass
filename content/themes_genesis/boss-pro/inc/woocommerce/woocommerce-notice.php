<?php
/**
 * Boss Pro
 *
 * This file adds the Genesis Connect for WooCommerce notice to the Boss Pro Theme.
 *
 * @package Boss
 * @author  Bloom
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/boss/
 */

add_action( 'admin_print_styles', 'boss_remove_woocommerce_notice' );
/**
 * Remove the default WooCommerce Notice.
 *
 * @return void
 *
 * @since 1.0.0
 */
function boss_remove_woocommerce_notice() {

	// If below version WooCommerce 2.3.0, exit early.
	if ( ! class_exists( 'WC_Admin_Notices' ) ) {
		return;
	}

	WC_Admin_Notices::remove_notice( 'theme_support' );

}

add_action( 'admin_notices', 'boss_woocommerce_theme_notice' );
/**
 * Add a prompt to activate Genesis Connect for WooCommerce
 * if WooCommerce is active but Genesis Connect is not.
 *
 * @return void
 *
 * @since 1.0.0
 */
function boss_woocommerce_theme_notice() {

	// If WooCommerce isn't installed or Genesis Connect is installed, exit early.
	if ( ! class_exists( 'WooCommerce' ) || function_exists( 'gencwooc_setup' ) ) {
		return;
	}

	// If user doesn't have access, exit early.
	if ( ! current_user_can( 'manage_woocommerce' ) ) {
		return;
	}

	// If message dismissed, exit early.
	if ( get_user_option( 'boss_woocommerce_message_dismissed', get_current_user_id() ) ) {
		return;
	}

	$notice_html = sprintf( __( 'Please install and activate <a href="https://wordpress.org/plugins/genesis-connect-woocommerce/" target="_blank">Genesis Connect for WooCommerce</a> to <strong>enable WooCommerce support for %s</strong>.', 'boss-pro' ), esc_html( CHILD_THEME_NAME ) );

	if ( current_user_can( 'install_plugins' ) ) {
		$plugin_slug  = 'genesis-connect-woocommerce';
		$admin_url    = network_admin_url( 'update.php' );
		$install_link = sprintf( '<a href="%s">%s</a>', wp_nonce_url(
			add_query_arg(
				array(
					'action' => 'install-plugin',
					'plugin' => $plugin_slug,
				),
				$admin_url
			),
			'install-plugin_' . $plugin_slug
		), __( 'install and activate Genesis Connect for WooCommerce', 'boss-pro' ) );

		$notice_html = sprintf( __( 'Please %s to <strong>enable WooCommerce support for %s</strong>.', 'boss-pro' ), $install_link, esc_html( CHILD_THEME_NAME ) );
	}

	echo '<div class="notice notice-info is-dismissible showcase-woocommerce-notice"><p>' . $notice_html . '</p></div>';

}

add_action( 'wp_ajax_boss_dismiss_woocommerce_notice', 'boss_dismiss_woocommerce_notice' );
/**
 * Add option to dismiss Genesis Connect for Woocommerce plugin install prompt.
 *
 * @return void
 *
 * @since 1.0.0
 */
function boss_dismiss_woocommerce_notice() {
	update_user_option( get_current_user_id(), 'boss_woocommerce_message_dismissed', 1 );
}

add_action( 'admin_enqueue_scripts', 'boss_notice_script' );
/**
 * Enqueue script to clear the Genesis Connect for WooCommerce plugin install prompt on dismissal.
 *
 * @return void
 *
 * @since 1.0.0
 */
function boss_notice_script() {
	wp_enqueue_script( 'boss_notice_script', get_stylesheet_directory_uri() . '/inc/woocommerce/js/notice-update.js', array( 'jquery' ), '1.0', true  );
}

add_action( 'switch_theme', 'boss_reset_woocommerce_notice', 10, 2 );
/**
 * Clear the Genesis Connect for WooCommerce plugin install prompt on theme change.
 *
 * @return void
 *
 * @since 1.0.0
 */
function boss_reset_woocommerce_notice() {

	global $wpdb;

	$args = array(
		'meta_key'   => $wpdb->prefix . 'boss_woocommerce_message_dismissed',
		'meta_value' => 1,
	);

	$users = get_users( $args );

	foreach ( $users as $user ) {
		delete_user_option( $user->ID, 'boss_woocommerce_message_dismissed' );
	}

}

add_action( 'deactivated_plugin', 'boss_reset_woocommerce_notice_on_deactivation', 10, 2 );
/**
 * Clear the Genesis Connect for WooCommerce plugin prompt on deactivation.
 *
 * @param string $plugin The plugin slug.
 * @return void
 *
 * @since 1.0.0
 */
function boss_reset_woocommerce_notice_on_deactivation( $plugin ) {

	// Conditional check to see if we're deactivating WooCommerce or Genesis Connect for WooCommerce.
	if ( $plugin !== 'woocommerce/woocommerce.php' && $plugin !== 'genesis-connect-woocommerce/genesis-connect-woocommerce.php' ) {
		return;
	}

	boss_reset_woocommerce_notice();

}
