<?php
/*
 * Clientside class
 * General plugin class containing methods to add/remove/change functionality and UI components to alter the appearance and usage of the WordPress admin interface
 */

class Clientside {

	// Make the login logo link to the site
	static function filter_change_login_logo_link( $original ) {
		return home_url();
	}

	// Set the login logo title attribute to the site name
	static function filter_change_login_logo_title( $original ) {
		return get_bloginfo( 'name' );
	}

	// Use an uploaded image as the login logo or hide it
	static function action_change_login_logo() {

		// Hide the logo if the option is enabled
		if ( Clientside_Options::get_saved_option( 'hide-login-logo' ) ) {
			echo '<style>#login > h1 a { display: none !important; }</style>';
		}

		// Set new logo image background via CSS if a logo image is available
		else if ( Clientside_Options::get_saved_option( 'logo-image' ) ) {
			echo '<style>#login > h1 a { background-image: url("' . esc_url( Clientside_Options::get_saved_option( 'logo-image' ) ) . '") !important; }</style>';
		}

	}

	// Remove admin footer text
	static function filter_footer_text( $text ) {

		// Only if admin theming is enabled
		if ( Clientside_Options::get_saved_option( 'enable-admin-theme' ) ) {
			return '';
		}

		// Return default
		return $text;

	}

	// Remove the admin footer version number
	static function filter_footer_version( $version ) {

		// Only if admin theming is enabled
		if ( Clientside_Options::get_saved_option( 'enable-admin-theme' ) ) {
			return '';
		}

		// Return default
		return $version;

	}

	// Tell WP everything is up to date
	static function filter_prevent_updates() {

		global $wp_version;

		// Return
		return (object) array(
			'last_checked' => time(),
			'version_checked' => $wp_version
		);

	}

	// Hide update notices depending on role-based option
	static function action_hide_updates() {

		// Only if the option is enabled for the current user role
		if ( ! Clientside_Options::get_saved_option( 'hide-updates' ) ) {
			return;
		}

		// Stop checking for core, plugin, theme updates
		add_filter( 'pre_site_transient_update_core', array( __CLASS__, 'filter_prevent_updates' ) );
		add_filter( 'pre_site_transient_update_plugins', array( __CLASS__, 'filter_prevent_updates' ) );
		add_filter( 'pre_site_transient_update_themes', array( __CLASS__, 'filter_prevent_updates' ) );

		// Hide updates menu item
		add_action( 'admin_menu', array( 'Clientside_Menu', 'action_remove_update_menu'), 999 );

	}

	// Hide the Screen Options button depending on the role-based option
	static function action_hide_screen_options() {

		// Only if option is enabled
		if ( Clientside_Options::get_saved_option( 'hide-screen-options' ) ) {
			add_filter( 'screen_options_show_screen', '__return_false' );
		}

	}

	// Hide the Help button depending on the role-based option
	static function action_hide_help() {

		// Only if option is enabled
		if ( Clientside_Options::get_saved_option( 'hide-help' ) ) {
			$screen = get_current_screen();
		    $screen->remove_help_tabs();
		}

	}

	// Hide login errors for extra security
	static function filter_login_errors( $errors ) {

		// Only if option is enabled
		if ( Clientside_Options::get_saved_option( 'disable-login-errors' ) ) {
			return null;
		}

		// Return default
		return $errors;

	}

	// Hide the post-list date filter dropdown
	static function action_hide_post_list_date_filter() {

		// Only if option is enabled
		if ( Clientside_Options::get_saved_option( 'hide-post-list-date-filter' ) ) {
			add_filter( 'months_dropdown_results', '__return_empty_array' );
		}

	}

	// Hide the post-list category filter dropdown
	static function action_hide_post_list_category_filter() {

		// Only if option is enabled
		if ( Clientside_Options::get_saved_option( 'hide-post-list-category-filter' ) ) {
			add_filter( 'wp_dropdown_cats', '__return_false' );
		}

	}

	// Prevent WP from printing the WP version in the site header for extra security
	static function action_remove_version_header( $errors ) {

		// Only if option is enabled
		if ( Clientside_Options::get_saved_option( 'remove-version-header' ) ) {
			remove_action( 'wp_head', 'wp_generator' );
		}

	}

	// Return number of posts to show per page
	static function filter_paging_posts( $original ) {

		// Return saved setting if it's a number and not empty
		if ( is_numeric( Clientside_Options::get_saved_option( 'paging-posts' ) ) && Clientside_Options::get_saved_option( 'paging-posts' ) ) {
			return Clientside_Options::get_saved_option( 'paging-posts' );
		}

		// Return default
		return $original;

	}

	// Disable theme/plugin file editor if option is enabled
	static function action_disable_file_editor() {

		if ( Clientside_Options::get_saved_option( 'disable-file-editor' ) && ! defined( 'DISALLOW_FILE_EDIT' ) ) {
			define( 'DISALLOW_FILE_EDIT', true );
		}

	}

	// Inject custom CSS in the site header (Custom CSS/JS tool)
	static function action_inject_custom_site_css_header() {

		// Only if custom CSS is supplied
		if ( ! Clientside_Options::get_saved_option( 'custom-site-css' ) ) {
			return;
		}

		// Output CSS
		echo '<style type="text/css" class="clientside-custom-css">';
			echo Clientside_Options::get_saved_option( 'custom-site-css' );
		echo '</style>';

	}

	// Inject custom JS in the site header (Custom CSS/JS tool)
	static function action_inject_custom_site_js_header() {

		// Only if custom JS is supplied
		if ( ! Clientside_Options::get_saved_option( 'custom-site-js-header' ) ) {
			return;
		}

		// Output JS
		echo '<script type="text/javascript" class="clientside-custom-js">';
			echo Clientside_Options::get_saved_option( 'custom-site-js-header' );
		echo '</script>';

	}

	// Inject custom JS in the site footer (Custom CSS/JS tool)
	static function action_inject_custom_site_js_footer() {

		// Only if custom JS is supplied
		if ( ! Clientside_Options::get_saved_option( 'custom-site-js-footer' ) ) {
			return;
		}

		// Output JS
		echo '<script type="text/javascript" class="clientside-custom-js">';
			echo Clientside_Options::get_saved_option( 'custom-site-js-footer' );
		echo '</script>';

	}

	// Inject custom CSS in the admin header (Custom CSS/JS tool)
	static function action_inject_custom_admin_css_header() {

		// Only if custom CSS is supplied
		if ( ! Clientside_Options::get_saved_option( 'custom-admin-css' ) ) {
			return;
		}

		// Output CSS
		echo '<style class="clientside-custom-css">';
			echo Clientside_Options::get_saved_option( 'custom-admin-css' );
		echo '</style>';

	}

	// Inject custom JS in the admin header (Custom CSS/JS tool)
	static function action_inject_custom_admin_js_header() {

		// Only if custom JS is supplied
		if ( ! Clientside_Options::get_saved_option( 'custom-admin-js-header' ) ) {
			return;
		}

		// Output JS
		echo '<script class="clientside-custom-js">';
			echo Clientside_Options::get_saved_option( 'custom-admin-js-header' );
		echo '</script>';

	}

	// Inject custom JS in the admin footer (Custom CSS/JS tool)
	static function action_inject_custom_admin_js_footer() {

		// Only if custom JS is supplied
		if ( ! Clientside_Options::get_saved_option( 'custom-admin-js-footer' ) ) {
			return;
		}

		// Output JS
		echo '<script class="clientside-custom-js">';
			echo Clientside_Options::get_saved_option( 'custom-admin-js-footer' );
		echo '</script>';

	}

	// Remove the quick-edit functionality from post/page listings depending on the user's role
	static function action_disable_quick_edit( $actions = array(), $post = null ) {

		// Only if enabled for the current role
		if ( ! Clientside_Options::get_saved_option( 'disable-quick-edit' ) ) {
			return $actions;
	    }

		// Remove "Quick Edit"
		if ( isset( $actions['inline hide-if-no-js'] ) ) {
			unset( $actions['inline hide-if-no-js'] );
		}

		// Return
		return $actions;

	}

	// Return wether the current page renders the Clientide theming
	static function is_themed() {

		// Login / Register pages
		if ( in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) && Clientside_Options::get_saved_option( 'enable-login-theme' ) ) {
			return true;
		}

		// Admin area
		if ( is_admin() && Clientside_Options::get_saved_option( 'enable-admin-theme' ) ) {
			return true;
		}

		// Viewing site
		if ( Clientside_Options::get_saved_option( 'enable-site-toolbar-theme' ) ) {
			return true;
		}

		// Otherwise
		return false;

	}

	// Avoid loading jQuery Migrate
	static function dequeue_jquery_migrate( $scripts ) {
		if ( Clientside_Options::get_saved_option( 'disable-jquery-migrate' ) ) {
			if ( ! empty( $scripts->registered['jquery'] ) ) {
				$jquery_dependencies = $scripts->registered['jquery']->deps;
				$scripts->registered['jquery']->deps = array_diff( $jquery_dependencies, array( 'jquery-migrate' ) );
			}
		}
	}

}

?>
