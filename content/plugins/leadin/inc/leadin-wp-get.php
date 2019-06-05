<?php
if ( ! defined( 'LEADIN_PLUGIN_VERSION' ) ) {
  wp_die( '', '', 403 );
}

if ( is_admin() ) {
  add_action( 'wp_ajax_leadin_get_portal', 'leadin_get_portal_ajax' );
  add_action( 'wp_ajax_leadin_get_domain', 'leadin_get_domain_ajax' );
}

function leadin_get_portal_ajax() {
  $portal_id = get_option( 'leadin_portalId' );
  wp_die( json_encode( array ( 'portalId' => $portal_id ) ) );
}

function leadin_get_domain_ajax() {
  $domain = get_site_url();
  wp_die( json_encode( array ( 'domain' => $domain ) ) );
}
