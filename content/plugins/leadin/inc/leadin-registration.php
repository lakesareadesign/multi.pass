<?php
if ( ! defined( 'LEADIN_PLUGIN_VERSION' ) ) {
  wp_die( '', '', 403 );
}

if ( is_admin() ) {
  add_action( 'wp_ajax_leadin_registration_ajax', 'leadin_registration_ajax' ); // Call when user logged in
}

function leadin_registration_ajax() {
  delete_option( 'leadin_hapikey' );
  $existingPortalId = get_option( 'leadin_portalId' );

  if ( ! empty( $existingPortalId ) ) {
    wp_die( '{"error": "Registration is already complete for this portal"}', '', 400 );
  }

  $requestBody = file_get_contents( 'php://input' );
  $data = json_decode( $requestBody, true );

  $newPortalId = $data['portalId'];

  if ( empty( $newPortalId ) ) {
    error_log( 'Registration error' );

    $errorBody = array(
      "error"   => "Registration missing required fields",
      "request" => $requestBody,
    );

    wp_die( json_encode( $errorBody ), '', 400 );
  }

  $userId = $data['userId'];
  $accessToken = $data['accessToken'];
  $refreshToken = $data['refreshToken'];
  $connectionTimeInMs = $data['connectionTimeInMs'];

  add_option( 'leadin_portalId', $newPortalId );
  add_option( 'leadin_userId', $userId);
  add_option( 'leadin_accessToken', $accessToken);
  add_option( 'leadin_refreshToken', $refreshToken);
  add_option( 'leadin_connectionTimeInMs', $connectionTimeInMs);

  wp_die( '{"message": "Success!"}' );
}
