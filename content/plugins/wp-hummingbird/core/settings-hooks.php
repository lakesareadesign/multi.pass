<?php

add_filter( 'wphb_block_resource', 'wphb_filter_resource_block', 10, 5 );
function wphb_filter_resource_block( $value, $handle, $type ) {
	$options = wphb_get_settings();
	$blocked = $options['block'][ $type ];
	if ( in_array( $handle, $blocked ) ) {
		return true;
	}


	return $value;
}

add_filter( 'wphb_minify_resource', 'wphb_filter_resource_minify', 10, 3 );
function wphb_filter_resource_minify( $value, $handle, $type ) {
	$options = wphb_get_settings();
	$dont_minify = $options['dont_minify'][ $type ];
	if ( in_array( $handle, $dont_minify ) ) {
		return false;
	}

	return $value;
}

add_filter( 'wphb_combine_resource', 'wphb_filter_resource_combine', 10, 3 );
function wphb_filter_resource_combine( $value, $handle, $type ) {
	$options = wphb_get_settings();
	$dont_combine = $options['dont_combine'][ $type ];
	if ( in_array( $handle, $dont_combine ) )
		return false;

	return $value;
}

add_filter( 'wphb_send_resource_to_footer', 'wphb_filter_resource_to_footer', 10, 3 );
function wphb_filter_resource_to_footer( $value, $handle, $type ) {
	$options = wphb_get_settings();
	$to_footer = $options['position'][ $type ];

	if ( array_key_exists( $handle, $to_footer ) && $to_footer[ $handle ] === 'footer' )
		return true;

	return $value;
}

add_filter( 'wp_hummingbird_is_active_module_caching', 'wphb_caching_module_status' );
function wphb_caching_module_status( $current ) {
	$options = wphb_get_settings();
	if ( ! $options['caching'] )
		return false;

	return $current;
}

add_filter( 'wp_hummingbird_is_active_module_uptime', 'wphb_uptime_module_status' );
function wphb_uptime_module_status( $current ) {
	$options = wphb_get_settings();
	if ( ! $options['uptime'] )
		return false;

	return $current;
}

add_filter( 'wp_hummingbird_is_active_module_minify', 'wphb_minify_module_status' );
function wphb_minify_module_status( $current ) {
	$options = wphb_get_settings();

	if ( false === $options['minify'] ) {
		return false;
	}

	if ( is_multisite() ) {
		$current = $options['minify-blog'];
	}
	else {
		$current = $options['minify'];
	}

	return $current;
}

add_filter( 'wphb_get_server_type', 'wphb_set_user_server_type' );
function wphb_set_user_server_type( $type ) {
	$user_type = get_user_meta( get_current_user_id(), 'wphb-server-type', true );
	if ( $user_type ) {
		$type = $user_type;
	}
	return $type;
}


add_filter( 'wphb_use_minify_cdn', 'wphb_set_use_cdn' );
function wphb_set_use_cdn( $use_cdn ) {
	return wphb_get_setting( 'use_cdn' );
}