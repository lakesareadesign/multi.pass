<?php
if ( ! defined( 'LEADIN_PLUGIN_VERSION' ) ) {
  header( 'HTTP/1.0 403 Forbidden' );
  wp_die();
}

if ( is_admin() ) {
  add_action( 'wp_ajax_leadin_oauth_refresh_ajax', 'leadin_oauth_refresh_ajax' );
}

function leadin_oauth_refresh_ajax() {
  $existingPortalId = get_option( 'leadin_portalId' );

  if ( empty( $existingPortalId ) ) {
    error_log( 'Refresh error' );
    header( 'HTTP/1.0 400 Bad Request' );
    wp_die( '{"error": "No leadin_portalId found, cannot refresh."}' );
  }

  $data = json_decode( file_get_contents( 'php://input' ), true );

  $portalId = $data['portalId'];
  $accessToken = $data['accessToken'];

  if ( empty( $portalId ) || empty( $accessToken ) ) {
    error_log( 'Refresh error' );
    header( 'HTTP/1.0 400 Bad Request' );
    wp_die( '{"error": "Refresh missing required fields"}' );
  }

  update_option( 'leadin_accessToken', $accessToken );
}
