<?php

if ( ! defined( 'LEADIN_PLUGIN_VERSION' ) ) {
  wp_die( '', '', 403 );
}

if ( ! defined( 'LEADIN_PORTAL_ID' ) ) {
  DEFINE( 'LEADIN_PORTAL_ID', intval( get_option( 'leadin_portalId' ) ) );
}

/**
 * Get Leadin user
 *
 * @return  array
 */
function leadin_get_current_user() {
  global $wp_version;

  $current_user = wp_get_current_user();
  $li_user_id   = md5( get_bloginfo( 'wpurl' ) );

  $li_options     = get_option( 'leadin_options' );
  $leadinPortalId = get_option( 'leadin_portalId' );

  if ( isset( $li_options['li_email'] ) ) {
    $li_user_email = $li_options['li_email'];
  } else {
    $li_user_email = $current_user->user_email;
  }

  $leadin_user = array(
    'user_id'    => $li_user_id,
    'email'      => $li_user_email,
    'alias'      => $current_user->display_name,
    'wp_url'     => get_bloginfo( 'wpurl' ),
    'li_version' => LEADIN_PLUGIN_VERSION,
    'wp_version' => $wp_version,
    'user_email' => $current_user->user_email,
  );

  if ( defined( 'LEADIN_REFERRAL_SOURCE' ) ) {
    $leadin_user['referral_source'] = LEADIN_REFERRAL_SOURCE;
  } else {
    $leadin_user['referral_source'] = '';
  }

  if ( defined( 'LEADIN_UTM_SOURCE' ) ) {
    $leadin_user['utm_source'] = LEADIN_UTM_SOURCE;
  } else {
    $leadin_user['utm_source'] = '';
  }

  if ( defined( 'LEADIN_UTM_MEDIUM' ) ) {
    $leadin_user['utm_medium'] = LEADIN_UTM_MEDIUM;
  } else {
    $leadin_user['utm_medium'] = '';
  }

  if ( defined( 'LEADIN_UTM_TERM' ) ) {
    $leadin_user['utm_term'] = LEADIN_UTM_TERM;
  } else {
    $leadin_user['utm_term'] = '';
  }

  if ( defined( 'LEADIN_UTM_CONTENT' ) ) {
    $leadin_user['utm_content'] = LEADIN_UTM_CONTENT;
  } else {
    $leadin_user['utm_content'] = '';
  }

  if ( defined( 'LEADIN_UTM_CAMPAIGN' ) ) {
    $leadin_user['utm_campaign'] = LEADIN_UTM_CAMPAIGN;
  } else {
    $leadin_user['utm_campaign'] = '';
  }

  if ( ! empty( $leadinPortalId ) ) {
    $leadin_user['portal_id'] = $leadinPortalId;
  }

  return $leadin_user;
}

/**
 * Logs a debug statement to /wp-content/debug.log
 *
 * @param   string
 */
function leadin_log_debug( $message ) {
  if ( WP_DEBUG === true ) {
    if ( is_array( $message ) || is_object( $message ) ) {
      error_log( print_r( $message, true ) );
    } else {
      error_log( $message );
    }
  }
}

/**
 * Returns the user role for the current user
 */
function leadin_get_user_role() {
  global $current_user;

  $user_roles = $current_user->roles;
  $user_role  = array_shift( $user_roles );

  return $user_role;
}

/**
 * Return the signup url based on the site options
 */
function leadin_get_signup_url() {
  $acquisition_option = get_option( 'hubspot_acquisition_attribution', '' );
  $affiliate_code = get_option( 'hubspot_affiliate_code' );
  $signup_url = LEADIN_BASE_URL . "/signup/wordpress?$acquisition_option";

  if ($affiliate_code) {
    $destination_url = rawurlencode($signup_url);
    return "https://mbsy.co/$affiliate_code?url=$destination_url";
  }

  return "$signup_url&utm_source=wordpress-plugin&utm_medium=marketplaces";
}

/**
 * Returns the right iframe src
 * The src will be `/hubspot-plugin/{portalId}/{path}`,
 * where path is the content after `leadin_` in ?page=leadin_path
 * eg: ?page=leadin_forms will point to /hubspot-plugin/{portalId}/forms
 */
function leadin_get_iframe_src() {
  $portal_id = get_option('leadin_portalId');
  $regex = "/^leadin(_|$)/";
  $page = null;

  if ( isset( $_GET['page'] ) ) {
    $page = $_GET["page"];
  }

  if ( empty( $portal_id ) ) {
    return leadin_get_signup_url();
  }

  $pathname = preg_replace( $regex, "", $page );
  return LEADIN_BASE_URL."/hubspot-plugin/$portal_id/$pathname";
}

function leadin_get_background_iframe_src() {
  $portal_id = get_option('leadin_portalId');
  $portal_id_url = '';

  if ( ! empty( $portal_id ) ) {
    $portal_id_url = "/$portal_id";
  }

  return LEADIN_BASE_URL . "/hubspot-plugin$portal_id_url/background";
}
