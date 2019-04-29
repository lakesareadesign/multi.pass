<?php

if ( ! defined( 'LEADIN_PLUGIN_VERSION' ) ) {
  wp_die( '', '', 403 );
}

// =============================================
// Define Constants
// =============================================
if ( ! defined( 'LEADIN_ADMIN_PATH' ) ) {
  define( 'LEADIN_ADMIN_PATH', untrailingslashit( __FILE__ ) );
}

// =============================================
// Include Needed Files
// =============================================
require_once ABSPATH . 'wp-admin/includes/plugin.php';

function action_required_notice(){
  $current_screen = get_current_screen();
  if ( $current_screen->parent_base !== 'leadin' ) {
    $leadin_icon = LEADIN_PATH . '/images/sprocket.svg';
    echo '<div class="notice notice-warning is-dismissible"><p><img src="' . $leadin_icon . '" height="16" style="margin-bottom: -3px" /> The HubSpot plugin isn’t connected right now. To use HubSpot tools on your WordPress site, <a href="admin.php?page=leadin">connect the plugin now</a>.</p></div>';
  }
}

// =============================================
// WPLeadInAdmin Class
// =============================================
class WPLeadInAdmin {


  var $li_viewers;
  var $stats_dashboard;
  var $action;

  /**
   * Class constructor
   */
  function __construct() {
    // =============================================
    // Hooks & Filters
    // =============================================
    $plugin_version = get_option( 'leadin_pluginVersion' );

    $this->action = $this->leadin_current_action();

    // If the plugin version matches the latest version escape the update function
    if ( $plugin_version != LEADIN_PLUGIN_VERSION ) {
      self::leadin_update_check();
    }

    add_action( 'admin_menu', array( &$this, 'leadin_add_menu_items' ) );
    add_action( 'admin_print_scripts', array( &$this, 'add_leadin_admin_scripts' ) );
    add_filter( 'plugin_action_links_' . 'leadin/leadin.php', array( $this, 'leadin_plugin_settings_link' ) );
    add_action( 'admin_notices', array( &$this, 'leadin_add_iframe' ) );

    if ($affiliate = $this->get_affiliate_code()) {
        add_option( 'hubspot_affiliate_code', $affiliate );
    }
    $this->hydrate_acquisition_attribution();
  }

  function get_affiliate_code() {
      $affiliate = get_option( 'hubspot_affiliate_code');
      if (!$affiliate && file_exists(LEADIN_PLUGIN_DIR . '/hs_affiliate.txt' )) {
          $affiliate = trim(preg_replace('/\s\s+/', ' ', file_get_contents(LEADIN_PLUGIN_DIR . '/hs_affiliate.txt')));
      }
      if ($affiliate) {
          return $affiliate;
      }
      return false;
  }

  function get_acquisition_attribution_option() {
    return get_option('hubspot_acquisition_attribution');
  }

  function hydrate_acquisition_attribution() {
    if ($this->get_acquisition_attribution_option()) {
      return;
    }

    if (file_exists(LEADIN_PLUGIN_DIR . '/hs_attribution.txt' )) {
      $acquisition_attribution = trim(file_get_contents(LEADIN_PLUGIN_DIR . '/hs_attribution.txt'));
      add_option('hubspot_acquisition_attribution', $acquisition_attribution);
    }
  }

  function leadin_update_check() {
    update_option( 'leadin_pluginVersion', LEADIN_PLUGIN_VERSION );
  }

  // =============================================
  // Menus
  // =============================================
  /**
   * Adds Leadin menu to /wp-admin sidebar
   */
  function leadin_add_menu_items() {
    $options = get_option( 'leadin_options' );

    global $submenu;
    global $wp_version;

    // Block non-sanctioned users from accessing Leadin
    $capability = 'activate_plugins';
    if ( ! current_user_can( 'activate_plugins' ) ) {
      if ( ! array_key_exists( 'li_grant_access_to_' . leadin_get_user_role(), $options ) ) {
        return false;
      } else {
        if ( current_user_can( 'manage_network' ) ) { // super admin
          $capability = 'manage_network';
        } elseif ( current_user_can( 'edit_pages' ) ) { // editor
          $capability = 'edit_pages';
        } elseif ( current_user_can( 'publish_posts' ) ) { // author
          $capability = 'publish_posts';
        } elseif ( current_user_can( 'edit_posts' ) ) { // contributor
          $capability = 'edit_posts';
        } elseif ( current_user_can( 'read' ) ) { // subscriber
          $capability = 'read';
        }
      }
    }

    $notificationIcon = '';
    if ( ! get_option( 'leadin_portalId' ) ) {
      $notificationIcon = ' <span class="update-plugins count-1"><span class="plugin-count">!</span></span>';
      add_action('admin_notices', 'action_required_notice');
    }

    add_menu_page( 'HubSpot', 'HubSpot'.$notificationIcon, $capability, 'leadin', array( $this, 'leadin_build_app' ), 'dashicons-sprocket', '25.100713' );

    $portal_id = get_option('leadin_portalId');
    if ( !empty( $portal_id ) ) {
      add_submenu_page('leadin', 'Forms', 'Forms', 'activate_plugins', 'leadin_forms', array($this, 'leadin_build_app'));
      add_submenu_page('leadin', 'Settings', 'Settings', 'activate_plugins', 'leadin_settings', array($this, 'leadin_build_app'));
      remove_submenu_page('leadin','leadin');
    }
  }

  // =============================================
  // Settings Page
  // =============================================
  /**
   * Adds setting link for Leadin to plugins management page
   *
   * @param   array $links
   * @return  array
   */
  function leadin_plugin_settings_link( $links ) {
    $portal_id = get_option('leadin_portalId');
    if ( !empty( $portal_id ) ) {
      $page = "leadin_settings";
    } else {
      $page = "leadin";
    }
    $url           = get_admin_url( get_current_blog_id(), "admin.php?page=$page" );
    $settings_link = '<a href="' . $url . '">Settings</a>';
    array_unshift( $links, $settings_link );
    return $links;
  }

  /**
   * Creates leadin app
   */
  function leadin_build_app() {
    wp_enqueue_style( 'leadin-bridge-css' );
  }

  /**
   * Add iframe
   */
  function leadin_add_iframe() {
    global $wp_version;
    $error_message = "";

    if ( version_compare( phpversion(), LEADIN_REQUIRED_PHP_VERSION, '<' ) ) {
      $error_message = "HubSpot All-In-One Marketing ".LEADIN_PLUGIN_VERSION." requires PHP ".LEADIN_REQUIRED_PHP_VERSION." or higher. Please upgrade WordPress first.";
    } else if ( version_compare( $wp_version, LEADIN_REQUIRED_WP_VERSION, '<' ) ) {
      $error_message = "HubSpot All-In-One Marketing ".LEADIN_PLUGIN_VERSION." requires PHP ".LEADIN_REQUIRED_WP_VERSION." or higher. Please upgrade WordPress first.";
    }

    if ($error_message) {
      echo "<div class='notice notice-warning'><p>$error_message</p></div>";
    } else {
      echo '<div id="leadin"></div>';
    }
  }

  // =============================================
  // Admin Styles & Scripts
  // =============================================
  /**
   * Adds admin javascript
   */
  function add_leadin_admin_scripts() {
    global $pagenow;
    global $wp_roles;
    global $wp_version;

    $ajaxUrl = get_admin_url( get_current_blog_id(), 'admin-ajax.php' );
    $wpUser = wp_get_current_user();

    /**
     * Note! Some of this information will be sent to Sentry on errors.
     * If you add any sensitive information, make sure to delete it here
     * https://git.hubteam.com/HubSpot/hubspot-plugin-ui/blob/cd3818adaa91fb83dc7f053956995247c878bb63/bridge/static/js/leadinWordPressShell.js#L14
     */
    $leadin_config = array(
      'portalId'              => get_option( 'leadin_portalId' ),
      'affiliateCode'         => get_option( 'hubspot_affiliate_code' ),
      'acquisitionAttributionParams' => $this->get_acquisition_attribution_option(),
      'env'                   => constant( 'LEADIN_ENV' ),
      'user'                  => $this->leadin_get_user_for_tracking(),
      'allRoles'              => $wp_roles->get_names(),
      'leadinPluginVersion'   => constant( 'LEADIN_PLUGIN_VERSION' ),
      'wpVersion'             => $wp_version,
      'siteUrl'               => get_site_url(),
      'adminEmail'            => get_option( 'admin_email' ),
      'siteName'              => get_bloginfo( 'name' ),
      'adminBaseUrl'          => get_admin_url( get_current_blog_id(), 'admin.php' ),
      'leadinPluginDirectory' => LEADIN_PLUGIN_SLUG,
      'ajaxUrl'               => is_ssl() ? str_replace( 'http:', 'https:', $ajaxUrl ) : str_replace( 'https:', 'http:', $ajaxUrl ),
      'locale'                => get_locale(),
      'timezone'              => get_option( 'gmt_offset' ),
      'timezoneString'        => get_option( 'timezone_string' ), // If not set by the user manually it will be an empty string
      'connectionTimeInMs'    => get_option( 'leadin_connectionTimeInMs' ),
      'plugins'               => get_plugins(),
      'phpVersion'            => phpversion(),
      'wpUserFirstName'       => $wpUser->user_firstname,
      'wpUserLastName'        => $wpUser->user_lastname,
      'wpUserEmail'       		=> $wpUser->user_email,
    );

    wp_register_script( 'leadin-head-js', leadin_get_resource_url( '/bundle/head/head.js' ), false, false, false );
    wp_localize_script( 'leadin-head-js', 'leadin_config', $leadin_config );
    wp_enqueue_script( 'leadin-head-js' );

    wp_register_script( 'leadin-bridge-app', leadin_get_resource_url( '/bundle/app.js' ), array( 'backbone' ), false, true );
    wp_register_style( 'leadin-bridge-css', leadin_get_resource_url( '/bundle/app.css' ) );
    wp_register_script( 'leadin-js', LEADIN_PATH.'/scripts/leadin.js', false, false, true );

    wp_enqueue_script( 'leadin-bridge-app' );
    wp_enqueue_script( 'leadin-js' );
  }

  // =============================================
  // Internal Class Functions
  // =============================================
  function leadin_get_user_for_tracking() {
    $leadin_user          = leadin_get_current_user();
    $tracking_leadin_user = array(
      'hashed_wp_url'   => $leadin_user['user_id'],
      'name'            => $leadin_user['alias'],
      'email'           => $leadin_user['email'],
      'wp-url'          => $leadin_user['wp_url'],
      'wp-version'      => $leadin_user['wp_version'],
      'li-source'       => LEADIN_SOURCE,
      'website'         => $leadin_user['wp_url'],
      'company'         => $leadin_user['wp_url'],
      'utm_source'      => $leadin_user['utm_source'],
      'utm_medium'      => $leadin_user['utm_medium'],
      'utm_term'        => $leadin_user['utm_term'],
      'utm_content'     => $leadin_user['utm_term'],
      'utm_campaign'    => $leadin_user['utm_campaign'],
      'referral_source' => $leadin_user['referral_source'],
      'user_email'      => $leadin_user['user_email'],
    );
    return $tracking_leadin_user;
  }

  /**
   * GET and set url actions into readable strings
   *
   * @return string if actions are set,   bool if no actions set
   */
  function leadin_current_action() {
    if ( isset( $_REQUEST['action'] ) && -1 != $_REQUEST['action'] ) { // WPCS: CSRF ok.
      return $_REQUEST['action']; // WPCS: CSRF ok.
    }

    if ( isset( $_REQUEST['action2'] ) && -1 != $_REQUEST['action2'] ) { // WPCS: CSRF ok.
      return $_REQUEST['action2']; // WPCS: CSRF ok.
    }

    return false;
  }

}


