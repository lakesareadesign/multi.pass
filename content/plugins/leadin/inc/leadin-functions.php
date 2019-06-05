<?php

if ( ! defined( 'LEADIN_PLUGIN_VERSION' ) ) {
  wp_die( '', '', 403 );
}

if ( ! defined( 'LEADIN_PORTAL_ID' ) ) {
  DEFINE( 'LEADIN_PORTAL_ID', intval( get_option( 'leadin_portalId' ) ) );
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
 * Return query string from object
 */
function leadin_http_build_query($arr) {
  return http_build_query( $arr, null, ini_get('arg_separator.output'), PHP_QUERY_RFC3986 );
}

/**
 * Return the given version until the patch version
 * eg: 6.4.2.1-beta => 6.4.2
 */
function leadin_parse_version($version) {
  preg_match('/^\d+(\.\d+){0,2}/', $version, $match);
  if ( empty( $match ) ) {
    return '';
  }
  return $match[0];
}

function leadin_get_query_params() {
  global $wp_version;

  return leadin_http_build_query( array(
    'l'   => get_locale(),
    'php' => leadin_parse_version( phpversion() ),
    'v'   => LEADIN_PLUGIN_VERSION,
    'wp'  => leadin_parse_version( $wp_version ),
  ) );
}

/**
 * Return the affiliate code
 */
function leadin_get_affiliate_code() {
  $affiliate_link = get_option( 'hubspot_affiliate_code' );
  preg_match('/(?:(?:hubs\.to)|(?:mbsy\.co))\/([a-zA-Z0-9]+)/', $affiliate_link, $matches);
  if (sizeof($matches) === 2) {
    return $matches[1];
  } else {
    return $affiliate_link;
  }
}

/**
 * Return the signup url based on the site options
 */
function leadin_get_signup_url() {
  // Get attribution string.
  $acquisition_option = get_option( 'hubspot_acquisition_attribution', '' );
  parse_str( $acquisition_option, $signup_params );

  // Get leadin query.
  $leadin_query = leadin_get_query_params();
  parse_str( $leadin_query, $leadin_params );

  $signup_params = array_merge( $signup_params, $leadin_params );

  // Add signup pre-fill info.
  $wp_user = wp_get_current_user();
  $signup_params['firstName'] = $wp_user->user_firstname;
  $signup_params['lastName'] = $wp_user->user_lastname;
  $signup_params['email'] = $wp_user->user_email;
  $signup_params['company'] = get_bloginfo( 'name' );
  $signup_params['domain'] = get_site_url();

  $affiliate_code = leadin_get_affiliate_code();
  $signup_url = LEADIN_SIGNUP_BASE_URL . '/signup/wordpress?';

  if (LEADIN_SIGNUP_BASE_URL !== LEADIN_BASE_URL) {
    $signup_params['redirectBaseUrl'] = LEADIN_BASE_URL;
  }

  if ($affiliate_code) {
    $signup_url .= leadin_http_build_query( $signup_params );
    $destination_url = rawurlencode($signup_url);
    return "https://mbsy.co/$affiliate_code?url=$destination_url";
  }

  $signup_params['utm_source'] = 'wordpress-plugin';
  $signup_params['utm_medium'] = 'marketplaces';

  return $signup_url . leadin_http_build_query( $signup_params );
}

function leadin_get_ajax_url() {
  $ajaxUrl = get_admin_url( get_current_blog_id(), 'admin-ajax.php' );
  return parse_url( $ajaxUrl )['path'];
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
  return LEADIN_BASE_URL . "/hubspot-plugin/$portal_id/$pathname?" . leadin_get_query_params();
}

function leadin_get_background_iframe_src() {
  $portal_id = get_option('leadin_portalId');
  $portal_id_url = '';

  if ( ! empty( $portal_id ) ) {
    $portal_id_url = "/$portal_id";
  }

  return LEADIN_BASE_URL . "/hubspot-plugin$portal_id_url/background?" . leadin_get_query_params();
}
