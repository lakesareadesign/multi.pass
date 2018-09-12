<?php
/*
Plugin Name: Contact Form Builder for WordPress – Conversion Tools by HubSpot
Plugin URI: http://www.hubspot.com/products/wordpress/contact-form
Description: Whether you’re just getting started with HubSpot or already a HubSpot power user, Contact Form Builder for WordPress and Conversion Tools by HubSpot will let you use HubSpot tools on your WordPress website and connect the two platforms without dealing with code.
Version: 6.1.11
Author: HubSpot
Author URI: http://www.hubspot.com
License: GPL2
*/

// =============================================
// Define Constants
// =============================================
if ( ! defined( 'LEADIN_PATH' ) ) {
	define( 'LEADIN_PATH', untrailingslashit( plugins_url( '', __FILE__ ) ) );
}

if ( ! defined( 'LEADIN_PLUGIN_DIR' ) ) {
	define( 'LEADIN_PLUGIN_DIR', untrailingslashit( dirname( __FILE__ ) ) );
}

if ( ! defined( 'LEADIN_PLUGIN_SLUG' ) ) {
	define( 'LEADIN_PLUGIN_SLUG', basename( dirname( __FILE__ ) ) );
}

if ( file_exists( LEADIN_PLUGIN_DIR . '/inc/leadin-overrides.php' ) ) {
	require_once LEADIN_PLUGIN_DIR . '/inc/leadin-overrides.php';
}

if ( ! defined( 'LEADIN_DB_VERSION' ) ) {
	define( 'LEADIN_DB_VERSION', '2.2.5' );
}

if ( ! defined( 'LEADIN_PLUGIN_VERSION' ) ) {
	define( 'LEADIN_PLUGIN_VERSION', '6.1.11' );
}

if ( ! defined( 'LEADIN_SOURCE' ) ) {
	define( 'LEADIN_SOURCE', 'leadin.com' );
}

if ( ! defined( 'LEADIN_ADMIN_ASSETS_BASE_URL' ) ) {
	define( 'LEADIN_ADMIN_ASSETS_BASE_URL', 'https://app.hubspot.com/leadin_admin_static_live' );
}

if ( ! defined( 'LEADIN_SCRIPT_LOADER_DOMAIN' ) ) {
	define( 'LEADIN_SCRIPT_LOADER_DOMAIN', 'js.hs-scripts.com' );
}

if ( ! defined( 'LEADIN_ENV' ) ) {
	define( 'LEADIN_ENV', 'prod' );
}

// =============================================
// Include Needed Files
// =============================================
if ( file_exists( LEADIN_PLUGIN_DIR . '/inc/leadin-constants.php' ) ) {
	require_once LEADIN_PLUGIN_DIR . '/inc/leadin-constants.php';
}

require_once LEADIN_PLUGIN_DIR . '/inc/leadin-functions.php';
require_once LEADIN_PLUGIN_DIR . '/inc/leadin-registration.php';
require_once LEADIN_PLUGIN_DIR . '/inc/leadin-disconnect.php';
require_once LEADIN_PLUGIN_DIR . '/admin/leadin-admin.php';

require_once LEADIN_PLUGIN_DIR . '/inc/class-leadin.php';


// =============================================
// Hooks & Filters
// =============================================
/**
 * Activate the plugin
 */
function activate_leadin( $network_wide ) {

	// Check activation on entire network or one blog
	if ( is_multisite() && $network_wide ) {
		global $wpdb;

		// Get this so we can switch back to it later
		$current_blog = $wpdb->blogid;
		// For storing the list of activated blogs
		$activated = array();

		// Get all blogs in the network and activate plugin on each one
		$blog_ids = $wpdb->get_col(
			"SELECT blog_id FROM $wpdb->blogs"
		);
		foreach ( $blog_ids as $blog_id ) {
			switch_to_blog( $blog_id );
			add_leadin_defaults();
			$activated[] = $blog_id;
		}

		// Switch back to the current blog
		switch_to_blog( $current_blog );

		// Store the array for a later function
		update_site_option( 'leadin_activated', $activated );
	} else {
		add_leadin_defaults();
	}
}

/**
 * Check Leadin installation and set options
 */
function add_leadin_defaults() {
	global $wpdb;
	$options = get_option( 'leadin_options' );

	if ( ( $options['li_installed'] != 1 ) || ( ! is_array( $options ) ) ) {
		$opt = array(
			'li_installed'            => 1,
			'leadin_version'          => LEADIN_PLUGIN_VERSION,
			'li_email'                => get_bloginfo( 'admin_email' ),
			'li_updates_subscription' => 1,
			'onboarding_step'         => 1,
			'onboarding_complete'     => 0,
			'ignore_settings_popup'   => 0,
			'data_recovered'          => 1,
			'delete_flags_fixed'      => 1,
			'beta_tester'             => 0,
			'converted_to_tags'       => 1,
			'names_added_to_contacts' => 1,
			'affiliate_code'          => '',
		);

		// Add the Pro flag if this is a pro installation
		if ( ( defined( 'LEADIN_UTM_SOURCE' ) && LEADIN_UTM_SOURCE != 'leadin%20repo%20plugin' ) || ! defined( 'LEADIN_UTM_SOURCE' ) ) {
			$opt['pro'] = 1;
		}

		// this is a hack because multisite doesn't recognize local options using either update_option or update_site_option...
		if ( is_multisite() ) {
			$multisite_prefix = ( is_multisite() ? $wpdb->prefix : '' );
			$wpdb->query(
				$wpdb->prepare(
					"
                    INSERT INTO %soptions
                        ( option_name, option_value )
                    VALUES ('leadin_options', %s)",
					$multisite_prefix,
					serialize( $opt )
				)
			);
			// TODO: Glob settings for multisite
		} else {
			update_option( 'leadin_options', $opt );
		}
	}

	setcookie( 'ignore_social_share', '1', 2592000, '/' );
}

/**
 * Deactivate Leadin plugin hook
 */
function deactivate_leadin( $network_wide ) {
	if ( is_multisite() && $network_wide ) {
		global $wpdb;

		// Get this so we can switch back to it later
		$current_blog = $wpdb->blogid;

		// Get all blogs in the network and activate plugin on each one
		$blog_ids = $wpdb->get_col(
			"SELECT blog_id FROM $wpdb->blogs"
		);
		foreach ( $blog_ids as $blog_id ) {
			switch_to_blog( $blog_id );
		}

		// Switch back to the current blog
		switch_to_blog( $current_blog );
	}
}

function activate_leadin_on_new_blog( $blog_id, $user_id, $domain, $path, $site_id, $meta ) {
	global $wpdb;

	if ( is_plugin_active_for_network( 'leadin/leadin.php' ) ) {
		$current_blog = $wpdb->blogid;
		switch_to_blog( $blog_id );
		add_leadin_defaults();
		switch_to_blog( $current_blog );
	}
}


//=============================================
// Shortcodes
//=============================================
function addHubspotShortcode($attributes) {
    $parsedAttributes = shortcode_atts(array(
        'type' => NULL,
        'portal' => NULL,
        'id' => NULL,
    ), $attributes);

    if (
        !isset($parsedAttributes['type']) ||
        !isset($parsedAttributes['portal']) ||
        !isset($parsedAttributes['id'])
    ) {
        return;
    }

    $portalId = $parsedAttributes['portal'];
    $id = $parsedAttributes['id'];

    switch ($parsedAttributes['type']) {
        case 'form':
            return '
                <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/shell.js"></script>
                <script>
                  hbspt.forms.create({
                    portalId: '. $portalId . ',
                    formId: "' . $id . '",
                    shortcode: "wp"
                  });
                </script>
            ';
        case 'cta':
            return '
                <!--HubSpot Call-to-Action Code -->
                <span class="hs-cta-wrapper" id="hs-cta-wrapper-' . $id . '">
                    <span class="hs-cta-node hs-cta-' . $id . '" id="'. $id . '">
                        <!--[if lte IE 8]>
                        <div id="hs-cta-ie-element"></div>
                        <![endif]-->
                        <a href="https://cta-redirect.hubspot.com/cta/redirect/' . $portalId . '/'. $id . '" >
                            <img class="hs-cta-img" id="hs-cta-img-' . $id . '" style="border-width:0px;" src="https://no-cache.hubspot.com/cta/default/' . $portalId . '/' . $id . '.png"  alt="New call-to-action"/>
                        </a>
                    </span>
                    <script charset="utf-8" src="//js.hubspot.com/cta/current.js"></script>
                    <script type="text/javascript">
                        hbspt.cta.load(' . $portalId . ', \''. $id . '\', {});
                    </script>
                </span>
                <!-- end HubSpot Call-to-Action Code -->
            ';
    }
}

/**
 * Checks the stored database version against the current data version + updates if needed
 */
function leadin_init()
{
    $leadin_wp = new WPLeadIn();
    add_shortcode('hubspot', 'addHubspotShortcode');
}


add_action( 'plugins_loaded', 'leadin_init', 14 );

if ( is_admin() ) {
	// Activate + install Leadin
	register_activation_hook( __FILE__, 'activate_leadin' );

	// Deactivate Leadin
	register_deactivation_hook( __FILE__, 'deactivate_leadin' );

	// Activate on newly created wpmu blog
	add_action( 'wpmu_new_blog', 'activate_leadin_on_new_blog', 10, 6 );
}


