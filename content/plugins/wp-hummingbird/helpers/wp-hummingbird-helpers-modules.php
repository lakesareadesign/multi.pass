<?php

/**
 * Return the list of modules and their object instances
 *
 * Do not try to load before 'wp_hummingbird_loaded' action has been executed
 *
 * @return mixed
 */
function wphb_get_modules() {
	return wp_hummingbird()->core->modules;
}

/**
 * Get a module instance
 *
 * @param string $module Module slug
 *
 * @return WP_Hummingbird_Module|bool
 */
function wphb_get_module( $module ) {
	return isset( wp_hummingbird()->core->modules[ $module ] ) ? wp_hummingbird()->core->modules[ $module ] : false;
}

/**
 * Wrapper function for WP_Hummingbird_Module_Minify::is_checking_files()
 *
 * @return bool
 */
function wphb_minification_is_checking_files() {
	return WP_Hummingbird_Module_Minify::is_checking_files();
}

/**
 * If minification scan hasn't finished after 4 minutes, stop it
 */
function wphb_minification_maybe_stop_checking_files() {
	if ( wphb_minification_is_checking_files() ) {
		// For extra checks, we'll stop check files here if needed
		$check_files = get_option( 'wphb-minification-check-files' );

		// If more than 4 minutes has passed, kill the process
		if ( empty( $check_files['on'] ) || current_time( 'timestamp' ) > ( $check_files['on'] + 240 ) ) {
			delete_option( 'wphb-minification-check-files' );
		}
	}
}

/**
 * Get all resources collected
 *
 * This collection is displayed in minification admin page
 */
function wphb_minification_get_resources_collection() {
	$collection = WP_Hummingbird_Sources_Collector::get_collection();
	$posts = WP_Hummingbird_Module_Minify_Group::get_minify_groups();
	foreach ( $posts as $post ) {
		$group = WP_Hummingbird_Module_Minify_Group::get_instance_by_post_id( $post->ID );
		if ( ! $group ) {
			continue;
		}
		foreach ( $group->get_handles() as $handle ) {
			if ( isset( $collection[ $group->type ][ $handle ] ) ) {
				$collection[ $group->type ][ $handle ]['original_size'] = $group->get_handle_original_size( $handle );
				$collection[ $group->type ][ $handle ]['compressed_size'] = $group->get_handle_compressed_size( $handle );
			}
		}
	}

	return $collection;
}

function wphb_use_minify_cdn() {
	return apply_filters( 'wphb_use_minify_cdn', false );
}


/**
 * Wrapper function for WP_Hummingbird_Module_Minify::init_scan()
 */
function wphb_minification_init_scan() {
	WP_Hummingbird_Module_Minify::init_scan();
}

/**
 * Get the Gzip status data
 *
 * @return array
 */
function wphb_get_gzip_status( $force = false ) {
	$gzip_module = wphb_get_module( 'gzip' );

	/** @var WP_Hummingbird_Module_Gzip $gzip_module */
	return $gzip_module->get_analysis_data( $force );
}

/**
 * Get the Caching status data
 *
 * @return array
 */
function wphb_get_caching_status( $force = false ) {
	$caching_module = wphb_get_module( 'caching' );

	/** @var WP_Hummingbird_Module_Caching $caching_module */
	return $caching_module->get_analysis_data( $force );
}

function wphb_uptime_get_last_report( $time = 'week', $force = false ) {
	return WP_Hummingbird_Module_Uptime::get_last_report( $time, $force );
}

function wphb_is_uptime_remotely_enabled() {
	return WP_Hummingbird_Module_Uptime::is_remotely_enabled();
}

/**
 * Enable Uptime remotely
 *
 * @return array|mixed|object|WP_Error
 */
function wphb_uptime_enable() {
	return WP_Hummingbird_Module_Uptime::enable();
}

/**
 * Enable Uptime remotely
 */
function wphb_uptime_disable() {
	WP_Hummingbird_Module_Uptime::disable();
}

/**
 * Wrapper function for WP_Hummingbird_Module_Uptime::refresh_report()
 */
function wphb_uptime_refresh_report() {
	WP_Hummingbird_Module_Uptime::refresh_report();
}


/**
 * Check if Smush plugin is activated
 *
 * @return boolean
 */
function wphb_smush_is_smush_active() {
	if ( ! wphb_smush_is_smush_installed() ) {
		return false;
	}

	return WP_Hummingbird_Module_Smush::is_smush_active();
}

/**
 * Check if Smush plugin is installed
 *
 * @return boolean
 */
function wphb_smush_is_smush_installed() {
	return WP_Hummingbird_Module_Smush::is_smush_installed();
}

function wphb_smush_get_install_url() {
	return WP_Hummingbird_Module_Smush::get_smush_install_url();
}

function wphb_has_cloudflare( $force = false ) {
	WP_Hummingbird_Module_Cloudflare::has_cloudflare( $force );
}

function wphb_cloudflare_disconnect() {
	$cloudflare = wphb_get_module( 'cloudflare' );
	$settings = wphb_get_settings();
	$cloudflare->clear_caching_page_rules();

	$settings['cloudflare-email'] = '';
	$settings['cloudflare-api-key'] = '';
	$settings['cloudflare-zone'] = '';
	$settings['cloudflare-zone-name'] = '';
	$settings['cloudflare-connected'] = false;
	$settings['cloudflare-plan'] = '';
	wphb_update_settings( $settings );
}