<?php
if ( ! defined( 'LEADIN_PLUGIN_VERSION' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	wp_die();
}

if ( is_admin() ) {
	add_action( 'wp_ajax_leadin_registration_ajax', 'leadin_registration_ajax' ); // Call when user logged in
	add_action( 'wp_ajax_leadin_deregistration_ajax', 'leadin_deregistration_ajax' );
}

function leadin_registration_ajax() {
	delete_option( 'leadin_hapikey' );
	$existingPortalId = get_option( 'leadin_portalId' );

	if ( ! empty( $existingPortalId ) ) {
		header( 'HTTP/1.0 400 Bad Request' );
		wp_die( '{"error": "Registration is already complete for this portal"}' );
	}

	$data = json_decode( file_get_contents( 'php://input' ), true );

	$newPortalId = $data['portalId'];

	if ( empty( $newPortalId ) ) {
		error_log( 'Registration error' );
		header( 'HTTP/1.0 400 Bad Request' );
		wp_die( '{"error": "Registration missing required fields"}' );
	}

	$userId = $data['userId'];
	$accessToken = $data['accessToken'];
	$refreshToken = $data['refreshToken'];
	$connectionTimeInMs = $data['connectionTimeInMs'];
	$oAuthMode = $data['oAuthMode'];

	add_option( 'leadin_portalId', $newPortalId );
	add_option( 'leadin_slumber_mode', $oAuthMode ? '0' : '1' );

	add_option( 'leadin_oauth_mode', $oAuthMode ? '1' : '0');
	add_option( 'leadin_userId', $userId);
	add_option( 'leadin_accessToken', $accessToken);
	add_option( 'leadin_refreshToken', $refreshToken);
	add_option( 'leadin_connectionTimeInMs', $connectionTimeInMs);

	wp_die( '{"message": "Success!"}' );
}

function leadin_deregistration_ajax() {
	delete_option( 'leadin_portalId' );
	delete_option( 'leadin_hapikey' );
	delete_option( 'leadin_slumber_mode' );

	delete_option( 'leadin_accessToken' );
	delete_option( 'leadin_refreshToken' );
	delete_option( 'leadin_oauth_mode' );
	delete_option( 'leadin_userId' );
	delete_option( 'leadin_connectionTimeInMs' );

	wp_die( '{"message": "Success!"}' );
}


