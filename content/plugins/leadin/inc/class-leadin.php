<?php

// =============================================
// WPLeadIn Class
// =============================================
class WPLeadIn {

  /**
   * Class constructor
   */
  function __construct() {
    global $pagenow;

    add_action( 'wp_enqueue_scripts', array($this, 'add_common_frontend_scripts' ) );
    add_action( 'admin_enqueue_scripts', array($this, 'add_common_frontend_scripts' ) );

    if ( is_admin() ) {
      if ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) {
        $li_wp_admin = new WPLeadInAdmin();
      }
    } else {
      // Adds the leadin-tracking script to wp-login.php page which doesnt hook into the enqueue logic
      if ( $this->leadin_is_login_or_register_page() ) {
        add_action( 'login_enqueue_scripts', array( $this, 'add_leadin_frontend_scripts' ) );
      } else {
        add_action( 'wp_enqueue_scripts', array( $this, 'add_leadin_frontend_scripts' ) );
      }
    }
  }

  // =============================================
  // Scripts & Styles
  // =============================================
  /**
   * Adds front end javascript + initializes ajax object
   */

  function add_leadin_frontend_scripts() {

    add_filter( 'script_loader_tag', array( $this, 'leadin_add_embed_script_attributes' ), 10, 2 );

    $embedDomain = constant( 'LEADIN_SCRIPT_LOADER_DOMAIN' );
    $portalId    = get_option( 'leadin_portalId' );

    if ( empty( $portalId ) ) {
      echo '<!-- HubSpot WordPress Plugin v' . LEADIN_PLUGIN_VERSION . ': embed JS disabled as a portalId has not yet been configured -->';
      return;
    }

    $embedUrl = '//' . $embedDomain . '/' . $portalId . '.js?integration=wordpress';
    $embedId  = 'leadin-scriptloader-js';

    if ( is_single() ) {
      $page_type = 'post';
    } elseif ( is_front_page() ) {
      $page_type = 'home';
    } elseif ( is_archive() ) {
      $page_type = 'archive';
    } elseif ( $this->leadin_is_login_or_register_page() ) {
      $page_type = 'login';
    } elseif ( is_page() ) {
      $page_type = 'page';
    } else {
      $page_type = 'other';
    }

    $leadin_wordpress_info = array(
      'userRole'            => ( is_user_logged_in() ) ? leadin_get_user_role() : 'visitor',
      'pageType'            => $page_type,
      'leadinPluginVersion' => LEADIN_PLUGIN_VERSION,
    );

    wp_register_script( $embedId, $embedUrl, array( 'jquery' ), false, true );
    wp_localize_script( $embedId, 'leadin_wordpress', $leadin_wordpress_info );
    wp_enqueue_script( $embedId );
    $this->add_page_analytics();
  }

  function add_common_frontend_scripts() {
    if ( is_user_logged_in() ) {
      wp_register_style( 'leadin-css', LEADIN_PATH.'/style/leadin.css' );
      wp_enqueue_style( 'leadin-css' );
    }
  }

  /* HubSpot page analytics */
  function add_page_analytics() {
    echo "\n".'<!-- DO NOT COPY THIS SNIPPET! Start of Page Analytics Tracking for HubSpot WordPress plugin v'.LEADIN_PLUGIN_VERSION.' -->'."\n";
    echo '<script type="text/javascript">'."\n";

    echo 'var _hsq = _hsq || [];'."\n";
    // Pass along the correct content-type
    if ( is_single () ) {
        echo '_hsq.push(["setContentType", "blog-post"]);' . "\n";
    }  else if ( is_archive () || is_search() ) {
        echo '_hsq.push(["setContentType", "listing-page"]);' . "\n";
    } else {
        echo '_hsq.push(["setContentType", "standard-page"]);' . "\n";
    }

    echo '</script>'."\n";
    echo '<!-- DO NOT COPY THIS SNIPPET! End of Page Analytics Tracking for HubSpot WordPress plugin -->'."\n";
  }

  function leadin_add_embed_script_attributes( $tag, $handle ) {
    if ( $handle == 'leadin-scriptloader-js' ) {
      return str_replace( ' src', ' async defer src', $tag );
    } else {
      return $tag;
    }
  }

  public static function leadin_is_login_or_register_page() {
    return in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) );
  }
}

// =============================================
// Leadin Init
// =============================================
global $li_wp_admin;
