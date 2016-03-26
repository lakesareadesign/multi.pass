<?php

/**
 * Number of pending requests
 */
function um_verified_requests_count() {
	$args = array( 'fields' => 'ID', 'number' => 0 );
	$args['meta_query'][] = array(array('key' => '_um_verified','value' => 'pending','compare' => '='));
	$users = new WP_User_Query( $args );
	return (int) count($users->results);
}

/**
 * URL to verify a user
 */
function um_verify_user_url( $user_id ) {
	$url = add_query_arg( 'um_adm_action', 'verify_user', admin_url('users.php') );
	$url = add_query_arg( 'uid', $user_id, $url );
	return $url;
}

/**
 * URL to unverify a user
 */
function um_unverify_user_url( $user_id ) {
	$url = add_query_arg( 'um_adm_action', 'unverify_user', admin_url('users.php') );
	$url = add_query_arg( 'uid', $user_id, $url );
	return $url;
}

/**
 * Check if user is verified
 */
function um_is_verified( $user_id ) {
	$is_verified = get_user_meta( $user_id, '_um_verified', true );
	return ( $is_verified && $is_verified == 'verified' ) ? true : false;
}

/**
 * Get user verification status
 */
function um_verified_status( $user_id ) {
	$is_verified = get_user_meta( $user_id, '_um_verified', true );
	return ( $is_verified ) ? $is_verified : 'unverified';
}

/**
 * Show verified badge
 */
function um_verified() {
	return '<i class="um-verified um-icon-checkmark-circled um-tip-s" title="' . __('Verified Account','um-verified') . '"></i>';
}

/**
 * Verify user
 */
function um_verify( $user_id, $sendmail = false ) {
	
	update_user_meta( $user_id, '_um_verified', 'verified' );
	do_action('um_after_user_is_verified', $user_id );
	
	if ( $sendmail ) {
		um_fetch_user( $user_id );
		UM_Mail( $user_id, __('Your Account is Now Verified!','um-verified'), 'verified-account', um_verified_path . 'templates/email/' );
	}
}

/**
 * Unverify user
 */
function um_unverify( $user_id ) {
	
	update_user_meta( $user_id, '_um_verified', 'unverified' );
	do_action('um_after_user_is_unverified', $user_id );
	
}

/**
 * Verification request URL
 */
function um_verify_url( $user_id, $redirect_to = '' ) {
	global $um_verified;
	$url = $um_verified->api->get_request_verify_url( $user_id );
	if ( $redirect_to ) {
		$url = add_query_arg('redirect_to', $redirect_to, $url );
	}
	return $url;
}

/**
 * Cancel verification request URL
 */
function um_verify_cancel_url( $user_id, $redirect_to = '' ) {
	global $um_verified;
	$url = $um_verified->api->get_cancel_request_verify_url( $user_id );
	if ( $redirect_to ) {
		$url = add_query_arg('redirect_to', $redirect_to, $url );
	}
	return $url;
}