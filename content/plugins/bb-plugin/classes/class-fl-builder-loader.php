<?php

if ( ! class_exists( 'FLBuilderLoader' ) ) {
	
	/**
	 * Responsible for setting up builder constants, classes and includes.
	 *
	 * @since 1.8
	 */
	final class FLBuilderLoader {
		
		/**
		 * Load the builder if it's not already loaded, otherwise
		 * show an admin notice.
		 *
		 * @since 1.8
		 * @return void
		 */ 
		static public function init()
		{
			if ( ! function_exists( 'is_plugin_active' ) ) {
				include_once ABSPATH . 'wp-admin/includes/plugin.php';
			}
			
			$lite_dirname   = 'beaver-builder-lite-version';
			$lite_active    = is_plugin_active( $lite_dirname . '/fl-builder.php' );
			$plugin_dirname = basename( dirname( dirname( __FILE__ ) ) );
			
			if ( class_exists( 'FLBuilder' ) || ( $plugin_dirname != $lite_dirname && $lite_active ) ) {
				self::admin_notice_hooks();
				return;
			}
			
			self::define_constants();
			self::load_files();
		}
		
		/**
		 * Define builder constants.
		 *
		 * @since 1.8
		 * @return void
		 */ 
		static private function define_constants()
		{
			define('FL_BUILDER_VERSION', '1.8');
			define('FL_BUILDER_FILE', trailingslashit(dirname(dirname(__FILE__))) . 'fl-builder.php');
			define('FL_BUILDER_DIR', plugin_dir_path(FL_BUILDER_FILE));
			define('FL_BUILDER_URL', plugins_url('/', FL_BUILDER_FILE));
			define('FL_BUILDER_LITE', false);
			define('FL_BUILDER_SUPPORT_URL', 'https://www.wpbeaverbuilder.com/support/');
			define('FL_BUILDER_UPGRADE_URL', 'https://www.wpbeaverbuilder.com/');
			define('FL_BUILDER_DEMO_URL', 'http://demos.wpbeaverbuilder.com');
			define('FL_BUILDER_OLD_DEMO_URL', 'http://demos.fastlinemedia.com');
			define('FL_BUILDER_DEMO_CACHE_URL', 'http://demos.wpbeaverbuilder.com/wp-content/uploads/bb-plugin/cache/');
		}
		
		/**
		 * Loads classes and includes.
		 *
		 * @since 1.8
		 * @return void
		 */ 
		static private function load_files()
		{
			/* Classes */
			require_once FL_BUILDER_DIR . 'classes/class-fl-builder.php';
			require_once FL_BUILDER_DIR . 'classes/class-fl-builder-admin.php';
			require_once FL_BUILDER_DIR . 'classes/class-fl-builder-admin-posts.php';
			require_once FL_BUILDER_DIR . 'classes/class-fl-builder-admin-settings.php';
			require_once FL_BUILDER_DIR . 'classes/class-fl-builder-ajax.php';
			require_once FL_BUILDER_DIR . 'classes/class-fl-builder-ajax-layout.php';
			require_once FL_BUILDER_DIR . 'classes/class-fl-builder-auto-suggest.php';
			require_once FL_BUILDER_DIR . 'classes/class-fl-builder-color.php';
			require_once FL_BUILDER_DIR . 'classes/class-fl-builder-export.php';
			require_once FL_BUILDER_DIR . 'classes/class-fl-builder-extensions.php';
			require_once FL_BUILDER_DIR . 'classes/class-fl-builder-fonts.php';
			require_once FL_BUILDER_DIR . 'classes/class-fl-builder-icons.php';
			require_once FL_BUILDER_DIR . 'classes/class-fl-builder-import.php';
			require_once FL_BUILDER_DIR . 'classes/class-fl-builder-loop.php';
			require_once FL_BUILDER_DIR . 'classes/class-fl-builder-model.php';
			require_once FL_BUILDER_DIR . 'classes/class-fl-builder-module.php';
			require_once FL_BUILDER_DIR . 'classes/class-fl-builder-photo.php';
			require_once FL_BUILDER_DIR . 'classes/class-fl-builder-services.php';
			require_once FL_BUILDER_DIR . 'classes/class-fl-builder-shortcodes.php';
			require_once FL_BUILDER_DIR . 'classes/class-fl-builder-update.php';
			require_once FL_BUILDER_DIR . 'classes/class-fl-builder-timezones.php';
			require_once FL_BUILDER_DIR . 'classes/class-fl-builder-utils.php';
			
			/* Includes */
			require_once FL_BUILDER_DIR . 'includes/compatibility.php';
			require_once FL_BUILDER_DIR . 'includes/updater/updater.php';
		}
		
		/**
		 * Initializes actions for the admin notice if another version 
		 * of the builder has already been loaded before this one.
		 *
		 * @since 1.8
		 * @return void
		 */ 
		static private function admin_notice_hooks()
		{
			add_action('admin_notices',           __CLASS__ . '::admin_notice');
			add_action('network_admin_notices',   __CLASS__ . '::admin_notice');
		}
	
		/**
		 * Shows an admin notice if another version of the builder
		 * has already been loaded before this one.
		 *
		 * @since 1.8
		 * @return void
		 */
		static public function admin_notice()
		{
			if ( ! is_admin() ) {
				return;
			}
			else if ( ! is_user_logged_in() ) {
				return;
			}
			else if ( ! current_user_can( 'update_core' ) ) {
				return;
			}
			
			$message = __( 'You currently have two versions of Beaver Builder active on this site. Please <a href="%s">deactivate one</a> before continuing.', 'fl-builder' );
			
			echo '<div class="updated">';
			echo '<p>' . sprintf( $message, admin_url( 'plugins.php' ) ) . '</p>';
			echo '</div>';
		}
	}
}

FLBuilderLoader::init();
