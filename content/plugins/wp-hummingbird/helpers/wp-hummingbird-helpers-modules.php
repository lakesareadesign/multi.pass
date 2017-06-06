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
 * Clear minified group files
 */
function wphb_minification_clear_files() {
	$groups = WP_Hummingbird_Module_Minify_Group::get_minify_groups();

	foreach ( $groups as $group ) {
		$path = get_post_meta( $group->ID, '_path', true );
		if ( $path ) {
			wp_delete_file( $path );
		}
		wp_delete_post( $group->ID );
		wp_cache_delete( 'wphb_minify_groups' );
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
 * Return the number of files used by minification.
 *
 * @since 1.4.5
 */
function wphb_minification_files_count() {
	// Get files count
	$collection = wphb_minification_get_resources_collection();
	// Remove those assets that we don't want to display
	foreach ( $collection['styles'] as $key => $item ) {
		if ( ! apply_filters( 'wphb_minification_display_enqueued_file', true, $item, 'styles' ) ) {
			unset( $collection['styles'][ $key ] );
		}
	}
	foreach ( $collection['scripts'] as $key => $item ) {
		if ( ! apply_filters( 'wphb_minification_display_enqueued_file', true, $item, 'scripts' ) ) {
			unset( $collection['scripts'][ $key ] );
		}
	}

	return ( count( $collection['scripts'] ) + count( $collection['styles'] ) );
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


/**
 * Get the number of issues for selected module
 *
 * @param string $module Module name.
 *
 * @return int
 */
function wphb_get_number_of_issues( $module ) {
	$issues = 0;

	switch ( $module ) {
		case 'caching':
			$caching_status = wphb_get_caching_status();
			$recommended = wphb_get_recommended_caching_values();
			if ( ! $caching_status ) {
				break;
			}
			foreach ( $caching_status as $type => $value ) {
				if ( empty( $value ) || ( $recommended[ $type ]['value'] > $value ) ) {
					$issues++;
				}
			}
			break;
		case 'gzip':
			$gzip_status = wphb_get_gzip_status();
			if ( ! $gzip_status ) {
				break;
			}
			$issues = count( $gzip_status ) - count( array_filter( $gzip_status ) );
			break;
		case 'performance':
			$last_report = wphb_performance_get_last_report();
			if ( ! $last_report || is_wp_error( $last_report ) ) {
				break;
			}
			$last_report = $last_report->data;
			foreach ( $last_report->rule_result as $recommendation ) {
				if ( 'a' !== $recommendation->impact_score_class ) {
					$issues++;
				}
			}
			break;
	}

	return $issues;
}

function wphb_uptime_get_last_report( $time = 'week', $force = false ) {
	return WP_Hummingbird_Module_Uptime::get_last_report( $time, $force );
}

/**
 * Check if Uptime is remotely enabled
 *
 * @return bool
 */
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
 * Disable Uptime remotely
 */
function wphb_uptime_disable() {
	WP_Hummingbird_Module_Uptime::disable();
}


/**
 * Enable Uptime locally
 */
function wphb_uptime_enable_locally() {
	/** @var WP_Hummingbird_Module_Uptime $uptime */
	$uptime = wphb_get_module( 'uptime' );
	if ( $uptime ) {
		$uptime::enable_locally();
	}
}

/**
 * Disable Uptime locally
 */
function wphb_uptime_disable_locally() {
	/** @var WP_Hummingbird_Module_Uptime $uptime */
	$uptime = wphb_get_module( 'uptime' );
	if ( $uptime ) {
		$uptime::disable_locally();
	}
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

/**
 * Check if Cloudflare is active
 *
 * @return bool
 *
 * @since 1.5.0
 */
function wphb_cloudflare_is_active() {
	$cf_module = wphb_get_module( 'cloudflare' );
	$cf_active = false;
	if ( $cf_module->is_active() && $cf_module->is_connected() && $cf_module->is_zone_selected() ) {
		$cf_active = true;
	}

	return $cf_active;
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

/**
 * Remove quick setup
 *
 * @since 1.5.0
 */
function wphb_remove_quick_setup() {
	$quick_setup = get_option( 'wphb-quick-setup' );
	$quick_setup['finished'] = true;
	update_option( 'wphb-quick-setup', $quick_setup );
}




/**
 * Wrapper function for WP_Hummingbird_Module_Performance::get_last_report()
 * @return bool|mixed|
 */
function wphb_performance_get_last_report() {
	return WP_Hummingbird_Module_Performance::get_last_report();
}

/**
 * Wrapper function for WP_Hummingbird_Module_Performance::refresh_report()
 */
function wphb_performance_refresh_report() {
	WP_Hummingbird_Module_Performance::refresh_report();
}

/**
 * Wrapper function for WP_Hummingbird_Module_Performance::is_doing_report()
 * @return bool|mixed
 */
function wphb_performance_is_doing_report() {
	return WP_Hummingbird_Module_Performance::is_doing_report();
}

/**
 * Wrapper function for WP_Hummingbird_Module_Performance::stopped_report()
 * @return mixed
 */
function wphb_performance_stopped_report() {
	return WP_Hummingbird_Module_Performance::stopped_report();
}

/**
 * Wrapper function for WP_Hummingbird_Module_Performance::set_doing_report()
 * @param bool $status
 */
function wphb_performance_set_doing_report( $status = true ) {
	WP_Hummingbird_Module_Performance::set_doing_report( $status );
}

/**
 * Wrapper function for WP_Hummingbird_Module_Performance::init_scan()
 */
function wphb_performance_init_scan() {
	// Init scan
	WP_Hummingbird_Module_Performance::init_scan();
	do_action( 'wphb_init_performance_scan' );
}