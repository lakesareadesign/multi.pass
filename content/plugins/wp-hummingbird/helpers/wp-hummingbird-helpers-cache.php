<?php

/**
 * Flush all WP Hummingbird Cache
 */
function wphb_flush_cache( $clear_settings = true ) {
	// Minification data
	wphb_clear_minification_cache( $clear_settings );

	// GZip data
	wphb_clear_gzip_cache();
	wphb_unsave_htaccess( 'gzip' );

	// Caching data
	wphb_clear_caching_cache();
	wphb_unsave_htaccess( 'caching' );

	// Last report
	wphb_performance_clear_cache();

	// Last Uptime report
	wphb_uptime_clear_cache();

	delete_metadata( 'user', '', 'wphb-hide-welcome-box', '', true );	  	 	   	 		 		 		 	
	delete_metadata( 'user', '', 'wphb-server-type', '', true );
	delete_site_option( 'wphb-is-cloudflare' );
}



/**
 * Clear all data saved in Minification
 *
 * @param bool $clear_settings If set to true will set Minification settings to default (that includes files positions)
 */
function wphb_clear_minification_cache( $clear_settings = true ) {
	WP_Hummingbird_Module_Minify::clear_cache( $clear_settings );
}

/**
 * Clears only a cached group of files
 *
 * Once clear, the group will be processed again in sucesive page loads
 *
 * @param string $group_key The group key that matches the option_name in options table
 */
function wphb_delete_minification_cache_group( $group_key ) {
	WP_Hummingbird_Module_Minify::clear_cache_group( $group_key );
}

/**
 * Delete all the pending process queue for minification
 */
function wphb_delete_pending_process_queue() {
	WP_Hummingbird_Module_Minify::clear_pending_process_queue();
}


/**
 * Clear GZip cache
 */
function wphb_clear_gzip_cache() {
	$gzip_module = wphb_get_module( 'gzip' );
	/** @var WP_Hummingbird_Module_GZip $module */
	$gzip_module->clear_analysis_data();
}

/**
 * Clear the Caching Module cache
 */
function wphb_clear_caching_cache() {
	$module = wphb_get_module( 'caching' );
	/** @var WP_Hummingbird_Module_Caching $module */
	$module->clear_analysis_data();
}


/**
 * Return the cache dir, normally in uploads folder
 *
 * @return mixed|void
 */
function wphb_get_cache_dir() {
	wphb_include_file_cache_class();
	return WP_Hummingbird_Cache_File::get_base_path();
}

/**
 * Return the cache URL, normally in uploads folder
 *
 * @return mixed|void
 */
function wphb_get_cache_url() {
	wphb_include_file_cache_class();
	return WP_Hummingbird_Cache_File::get_base_url();
}

/**
 * Check if cache dir has been created already
 *
 * @return bool
 */
function wphb_is_cache_folder_created() {
	wphb_include_file_cache_class();
	$result = WP_Hummingbird_Cache_File::is_cache_folder_created();
	if ( ! $result ) {
		// Try to create it
		$result = WP_Hummingbird_Cache_File::create_cache_folder();
	}
	return $result;
}


function wphb_performance_clear_cache() {
	WP_Hummingbird_Module_Performance::clear_cache();
}

function wphb_uptime_clear_cache() {
	WP_Hummingbird_Module_Uptime::clear_cache();
}
