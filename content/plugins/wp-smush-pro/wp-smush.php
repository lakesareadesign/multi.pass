<?php
/**
 * WP Smush plugin
 *
 * Reduce image file sizes, improve performance and boost your SEO using the
 * <a href="https://premium.wpmudev.org/">WPMU DEV</a> WordPress Smush API.
 *
 * @link              http://premium.wpmudev.org/projects/wp-smush-pro/
 * @since             1.0.0
 * @package           WP_Smush
 *
 * @wordpress-plugin
 * Plugin Name:       Smush Pro
 * Plugin URI:        http://premium.wpmudev.org/projects/wp-smush-pro/
 * Description:       Reduce image file sizes, improve performance and boost your SEO using the free <a href="https://premium.wpmudev.org/">WPMU DEV</a> WordPress Smush API.
 * Version:           3.0.0
 * Author:            WPMU DEV
 * Author URI:        https://premium.wpmudev.org/
 * License:           GPLv2
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wp-smushit
 * Domain Path:       /languages/
 * WDP ID:            912164
 */

/*
Copyright 2007-2018 Incsub (http://incsub.com)
Author - Aaron Edwards, Sam Najian, Umesh Kumar

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License (Version 2 - GPLv2) as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! defined( 'WP_SMUSH_VERSION' ) ) {
	define( 'WP_SMUSH_VERSION', '3.0.0' );
}
// Used to define body class.
if ( ! defined( 'WP_SHARED_UI_VERSION' ) ) {
	define( 'WP_SHARED_UI_VERSION', 'sui-2-3-6' );
}
if ( ! defined( 'WP_SMUSH_BASENAME' ) ) {
	define( 'WP_SMUSH_BASENAME', plugin_basename( __FILE__ ) );
}
if ( ! defined( 'WP_SMUSH_API' ) ) {
	define( 'WP_SMUSH_API', 'https://smushpro.wpmudev.org/1.0/' );
}
if ( ! defined( 'WP_SMUSH_UA' ) ) {
	define( 'WP_SMUSH_UA', 'WP Smush/' . WP_SMUSH_VERSION . '; ' . network_home_url() );
}
if ( ! defined( 'WP_SMUSH_DIR' ) ) {
	define( 'WP_SMUSH_DIR', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'WP_SMUSH_URL' ) ) {
	define( 'WP_SMUSH_URL', plugin_dir_url( __FILE__ ) );
}
if ( ! defined( 'WP_SMUSH_MAX_BYTES' ) ) {
	define( 'WP_SMUSH_MAX_BYTES', 1000000 );
}
if ( ! defined( 'WP_SMUSH_PREMIUM_MAX_BYTES' ) ) {
	define( 'WP_SMUSH_PREMIUM_MAX_BYTES', 32000000 );
}
if ( ! defined( 'WP_SMUSH_PREFIX' ) ) {
	define( 'WP_SMUSH_PREFIX', 'wp-smush-' );
}
if ( ! defined( 'WP_SMUSH_TIMEOUT' ) ) {
	define( 'WP_SMUSH_TIMEOUT', apply_filters( 'WP_SMUSH_API_TIMEOUT', 150 ) );
}

/**
 * To support Smushing on staging sites like SiteGround staging where staging site urls are different
 * but redirects to main site url. Remove the protocols and www, and get the domain name.*
 * If Set to false, WP Smush switch backs to the Old Sync Optimisation.
 */
$site_url = str_replace( array( 'http://', 'https://', 'www.' ), '', site_url() );
if ( ! defined( 'WP_SMUSH_ASYNC' ) && ! empty( $_SERVER['SERVER_NAME'] ) && ( 0 !== strpos( $site_url, $_SERVER['SERVER_NAME'] ) ) ) { // Input var ok.
	define( 'WP_SMUSH_ASYNC', false );
} elseif ( ! defined( 'WP_SMUSH_ASYNC' ) ) {
	define( 'WP_SMUSH_ASYNC', true );
}

/**
 * If we are activating a version, while having another present and activated.
 * Leave in the Pro version, if it is available.
 *
 * @since 2.9.1
 */
if ( WP_SMUSH_BASENAME !== plugin_basename( __FILE__ ) ) {
	$pro_installed = false;
	if ( file_exists( WP_PLUGIN_DIR . '/wp-smush-pro/wp-smush.php' ) ) {
		$pro_installed = true;
	}

	if ( ! function_exists( 'is_plugin_active' ) ) {
		include_once ABSPATH . 'wp-admin/includes/plugin.php';
	}

	if ( is_plugin_active( 'wp-smush-pro/wp-smush.php' ) ) {
		deactivate_plugins( plugin_basename( __FILE__ ) );
		update_site_option( 'smush_deactivated', 1 );
		return; // Return to avoid errors with free-dashboard module.
	} elseif ( $pro_installed && is_plugin_active( WP_SMUSH_BASENAME ) ) {
		deactivate_plugins( WP_SMUSH_BASENAME );
		activate_plugin( plugin_basename( __FILE__ ) );
	}
}

register_activation_hook( 'core/class-wp-smush-installer.php', array( 'WP_Smush_Installer', 'smush_activated' ) );

// Init the plugin and load the plugin instance for the first time.
add_action( 'plugins_loaded', array( 'WP_Smush', 'get_instance' ) );

if ( ! class_exists( 'WP_Smush' ) ) {
	/**
	 * Class WP_Smush
	 */
	class WP_Smush {

		/**
		 * Plugin instance.
		 *
		 * @since 2.9.0
		 *
		 * @var null|WP_Smush
		 */
		private static $instance = null;

		/**
		 * Plugin core.
		 *
		 * @since 2.9.0
		 *
		 * @var WP_Smush_Core
		 */
		private $core;

		/**
		 * Plugin admin.
		 *
		 * @since 2.9.0
		 *
		 * @var WP_Smush_Admin
		 */
		private $admin;

		/**
		 * Plugin API.
		 *
		 * @since 3.0
		 *
		 * @var WP_Smush_API
		 */
		private $api = '';

		/**
		 * Stores the value of validate_install function.
		 *
		 * @var bool $is_pro
		 */
		private static $is_pro;

		/**
		 * Return the plugin instance.
		 *
		 * @return WP_Smush
		 */
		public static function get_instance() {
			if ( ! self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * WP_Smush constructor.
		 */
		private function __construct() {
			$this->register_actions();

			$this->includes();

			$this->init();
		}

		/**
		 * Register actions and filters.
		 *
		 * @since 2.9.0
		 */
		private function register_actions() {
			add_action( 'admin_init', array( $this, 'register_free_modules' ) );
			add_action( 'init', array( $this, 'register_pro_modules' ), 5 );
		}

		/**
		 * Includes.
		 *
		 * @since 2.9.0
		 */
		private function includes() {
			/**
			 * Installer class.
			 *
			 * @noinspection PhpIncludeInspection
			 */
			require_once WP_SMUSH_DIR . 'core/class-wp-smush-installer.php';

			/**
			 * Settings class.
			 *
			 * @noinspection PhpIncludeInspection
			 */
			require_once WP_SMUSH_DIR . 'core/class-wp-smush-settings.php';

			/**
			 * Include core class.
			 *
			 * @noinspection PhpIncludeInspection
			 */
			require_once WP_SMUSH_DIR . 'core/class-wp-smush-core.php';

			/**
			 * Include admin class.
			 *
			 * @noinspection PhpIncludeInspection
			 */
			require_once WP_SMUSH_DIR . 'core/class-wp-smush-admin.php';

			/**
			 * Include API classes.
			 *
			 * @noinspection PhpIncludeInspection
			 */
			require_once WP_SMUSH_DIR . 'core/api/class-wp-smush-api.php';
			/* @noinspection PhpIncludeInspection */
			require_once WP_SMUSH_DIR . 'core/api/class-wp-smush-api-request.php';
		}

		/**
		 * Init core module.
		 *
		 * @since 2.9.0
		 */
		private function init() {
			try {
				$this->api = new WP_Smush_API( self::get_api_key() );
			} catch ( Exception $e ) {
				// Unable to init API for some reason.
			}

			self::$is_pro = $this->validate_install();

			$this->core  = new WP_Smush_Core();
			$this->admin = new WP_Smush_Admin();
		}

		/**
		 * Getter method for core.
		 *
		 * @since 2.9.0
		 *
		 * @return WP_Smush_Core
		 */
		public function core() {
			return $this->core;
		}

		/**
		 * Getter method for core.
		 *
		 * @since 2.9.0
		 *
		 * @return WP_Smush_Admin
		 */
		public function admin() {
			return $this->admin;
		}

		/**
		 * Getter method for core.
		 *
		 * @since 3.0
		 *
		 * @return WP_Smush_API
		 */
		public function api() {
			return $this->api;
		}

		/**
		 * Return PRO status.
		 *
		 * @since 2.9.0
		 *
		 * @return bool
		 */
		public static function is_pro() {
			return self::$is_pro;
		}

		/**
		 * Filters the rating message, include stats if greater than 1Mb
		 *
		 * @param string $message  Message text.
		 *
		 * @return string
		 */
		public function wp_smush_rating_message( $message ) {
			if ( empty( $this->core()->stats ) ) {
				$this->core()->setup_global_stats();
			}

			$savings    = $this->core()->stats;
			$show_stats = false;

			// If there is any saving, greater than 1Mb, show stats.
			if ( ! empty( $savings ) && ! empty( $savings['bytes'] ) && $savings['bytes'] > 1048576 ) {
				$show_stats = true;
			}

			$message = "Hey %s, you've been using %s for a while now, and we hope you're happy with it.";

			// Conditionally Show stats in rating message.
			if ( $show_stats ) {
				$message .= sprintf( " You've smushed <strong>%s</strong> from %d images already, improving the speed and SEO ranking of this site!", $savings['human'], $savings['total_images'] );
			}
			$message .= " We've spent countless hours developing this free plugin for you, and we would really appreciate it if you dropped us a quick rating!";

			return $message;
		}

		/**
		 * NewsLetter
		 *
		 * @param string $message  Message text.
		 *
		 * @return string
		 */
		public function wp_smush_email_message( $message ) {
			$message = "You're awesome for installing %s! Site speed isn't all image optimization though, so we've
			collected all the best speed resources we know in a single email - just for users of Smush!";

			return $message;
		}

		/**
		 * Register sub-modules.
		 * Only for wordpress.org members.
		 */
		public function register_free_modules() {
			if ( false === strpos( WP_SMUSH_DIR, 'wp-smushit' ) ) {
				return;
			}

			/* @noinspection PhpIncludeInspection */
			require_once WP_SMUSH_DIR . 'core/external/free-dashboard/module.php';

			// Register the current plugin.
			do_action(
				'wdev-register-plugin',
				/* 1             Plugin ID */ WP_SMUSH_BASENAME,
				/* 2          Plugin Title */ 'Smush',
				/* 3 https://wordpress.org */ '/plugins/wp-smushit/',
				/* 4      Email Button CTA */ __( 'Get Fast!', 'wp-smushit' ),
				/* 5  Mailchimp List id for the plugin - e.g. 4b14b58816 is list id for Smush */ '4b14b58816'
			);

			// The rating message contains 2 variables: user-name, plugin-name.
			add_filter( 'wdev-rating-message-' . WP_SMUSH_BASENAME, array( $this, 'wp_smush_rating_message' ) );
			// The email message contains 1 variable: plugin-name.
			add_filter( 'wdev-email-message-' . WP_SMUSH_BASENAME, array( $this, 'wp_smush_email_message' ) );
		}

		/**
		 * Register sub-modules.
		 * Only for WPMU DEV Members.
		 */
		public function register_pro_modules() {
			if ( ! file_exists( WP_SMUSH_DIR . 'core/external/dash-notice/wpmudev-dash-notification.php' ) ) {
				return;
			}

			// Register items for the dashboard plugin.
			global $wpmudev_notices;
			$wpmudev_notices[] = array(
				'id'      => 912164,
				'name'    => 'WP Smush Pro',
				'screens' => array(
					'upload',
					'toplevel_page_smush',
					'toplevel_page_smush-network',
				),
			);

			/* @noinspection PhpIncludeInspection */
			require_once WP_SMUSH_DIR . 'core/external/dash-notice/wpmudev-dash-notification.php';
		}

		/**
		 * Check if user is premium member, check for API key.
		 *
		 * @return bool  True if a premium member, false if regular user.
		 */
		public function validate_install() {
			if ( isset( self::$is_pro ) ) {
				return self::$is_pro;
			}

			// No API key set, always false.
			$api_key = self::get_api_key();

			if ( empty( $api_key ) ) {
				return false;
			}

			// Flag to check if we need to revalidate the key.
			$revalidate = false;

			$api_auth = get_site_option( 'wp_smush_api_auth' );

			// Check if need to revalidate.
			if ( ! $api_auth || empty( $api_auth ) || empty( $api_auth[ $api_key ] ) ) {
				$revalidate = true;
			} else {
				$last_checked = $api_auth[ $api_key ]['timestamp'];
				$valid        = $api_auth[ $api_key ]['validity'];

				$diff = current_time( 'timestamp' ) - $last_checked;

				// Difference in hours.
				$diff_h = $diff / 3600;

				// Difference in minutes.
				$diff_m = $diff / 60;

				switch ( $valid ) {
					case 'valid':
						// If last checked was more than 12 hours.
						if ( $diff_h > 12 ) {
							$revalidate = true;
						}
						break;
					case 'invalid':
						// If last checked was more than 24 hours.
						if ( $diff_h > 24 ) {
							$revalidate = true;
						}
						break;
					case 'network_failure':
						// If last checked was more than 5 minutes.
						if ( $diff_m > 5 ) {
							$revalidate = true;
						}
						break;
				}
			}

			// If we are suppose to validate API, update the results in options table.
			if ( $revalidate ) {
				if ( empty( $api_auth[ $api_key ] ) ) {
					// For api key resets.
					$api_auth[ $api_key ] = array();

					// Storing it as valid, unless we really get to know from API call.
					$api_auth[ $api_key ]['validity'] = 'valid';
				}

				// Aaron suggested to Update timestamp before making the API call, to avoid any concurrent calls, clever.
				$api_auth[ $api_key ]['timestamp'] = current_time( 'timestamp' );
				update_site_option( 'wp_smush_api_auth', $api_auth );

				$request = $this->api()->check();

				if ( ! is_wp_error( $request ) && 200 === wp_remote_retrieve_response_code( $request ) ) {
					$result = json_decode( wp_remote_retrieve_body( $request ) );
					if ( ! empty( $result->success ) && $result->success ) {
						$valid = 'valid';
						update_site_option( WP_SMUSH_PREFIX . 'cdn_status', $result->data );
					} else {
						$valid = 'invalid';
					}
				} else {
					$valid = 'network_failure';
				}

				// Reset value.
				$api_auth = array();

				// Add a fresh timestamp.
				$timestamp            = current_time( 'timestamp' );
				$api_auth[ $api_key ] = array(
					'validity'  => $valid,
					'timestamp' => $timestamp,
				);

				// Update API validity.
				update_site_option( 'wp_smush_api_auth', $api_auth );
			}

			self::$is_pro = isset( $valid ) && ( 'valid' === $valid );

			return self::$is_pro;
		}

		/**
		 * Returns api key.
		 *
		 * @return mixed
		 */
		private static function get_api_key() {
			$api_key = false;

			// If API key defined manually, get that.
			if ( defined( 'WPMUDEV_APIKEY' ) && WPMUDEV_APIKEY ) {
				$api_key = WPMUDEV_APIKEY;
			} elseif ( class_exists( 'WPMUDEV_Dashboard' ) ) {
				// If dashboard plugin is active, get API key from db.
				$api_key = get_site_option( 'wpmudev_apikey' );
			}

			return $api_key;
		}

	} // End class.
} // End if() check.