<?php
/*
 * Clientside Setup class
 * Contains functions to integrate itself into the WordPress installation
 */

class Clientside_Setup {

	static $editor_font_family = 'Lato:400,400:italic';
	static $admin_font_family = 'Lato:400,400:italic';

	// Enqueue admin stylesheets
	static function action_enqueue_admin_styles() {

		// Always-use CSS
		wp_enqueue_style( 'clientside-admin-css', plugins_url( 'css/clientside-admin.css', __FILE__ ), array(), '1.2.9' );

		// Enqueue the media manager scripts and styles
		wp_enqueue_media();

		// Theme CSS, when admin theming is enabled
		if ( Clientside_Options::get_saved_option( 'enable-admin-theme' ) ) {
			wp_enqueue_style( 'clientside-theme-css', plugins_url( 'css/clientside-admin-theme.min.css', __FILE__ ), array( 'clientside-admin-css', 'thickbox' ), '1.2.9' );

			// Additional external plugin support
			if ( Clientside_Options::get_saved_option( 'enable-plugin-support' ) ) {
				wp_enqueue_style( 'clientside-plugin-support-css', plugins_url( 'css/clientside-plugin-support.min.css', __FILE__ ), array( 'clientside-theme-css' ), '1.2.9' );
			}

		}

	}

	// Enqueue admin scripts
	static function action_enqueue_admin_scripts() {

		wp_enqueue_script( 'clientside-admin-js', plugins_url( 'js/clientside-admin.js', __FILE__ ), array( 'jquery', 'thickbox', 'jquery-ui-sortable' ), '1.2.9' );

		// Add localized strings
		wp_localize_script( 'clientside-admin-js', 'L10n',
			array(
				// Source: navMenuL10n
				'saveAlert' => __( 'The changes you made will be lost if you navigate away from this page.' ),
				'untitled' => _x( '(no label)', 'missing menu item navigation label' ),
				// Custom:
				'backtotop' => _x( 'Back to Top', 'Title attribute for the Back to Top button.', 'clientside' ),
				'revertConfirm' => _x( 'Are you sure you want to remove all customizations and start from scratch?', 'Confirmation message when reverting the Admin Menu Editor to default.', 'clientside' ),
				'screenOptions' => __( 'Screen Options' ),
				'help' => __( 'Help' ),
				'exportLoading' => __( 'Loading...', 'clientside' ),
				// Non-translation variables
				'options_slug' => Clientside_Options::$options_slug
			)
		);

	}

	// Enqueue login/register page stylesheet
	static function action_enqueue_login_styles() {

		// Only if login page theming is enabled
		if ( Clientside_Options::get_saved_option( 'enable-login-theme' ) ) {
			wp_enqueue_style( 'clientside-login-css', plugins_url( 'css/clientside-login.css', __FILE__ ), array(), '1.2.9' );
		}

	}

	// Enqueue login/register page scripts
	static function action_enqueue_login_scripts() {

		// Only if login page theming is enabled
		if ( Clientside_Options::get_saved_option( 'enable-login-theme' ) ) {
			wp_enqueue_script( 'clientside-login-js', plugins_url( 'js/clientside-login.js', __FILE__ ), array( 'jquery' ), '1.2.9' );
		}

	}

	// Enqueue text editor CSS
	static function action_enqueue_editor_styles() {

		// Only if the option is enabled
		if ( ! Clientside_Options::get_saved_option( 'enable-editor-styling' ) ) {
			return;
		}

		// Load the stylesheet
		add_editor_style( plugins_url( 'css/clientside-editor.css', __FILE__ ) );

		// Load the Google Fonts, unless Google Fonts are disabled
		if ( ! Clientside_Options::get_saved_option( 'disable-google-fonts-admin' ) ) {
			add_editor_style( str_replace( ',', '%2C', '//fonts.googleapis.com/css?family=' . self::$editor_font_family ) );
		}

	}

	// Deactivate the default Google Fonts version of Open Sans while viewing the site
	static function action_dequeue_fonts() {

		wp_deregister_style( 'open-sans' );
		wp_register_style( 'open-sans', false );

	}

	// Dequeue and enqueue Google Fonts in the admin area
	static function action_enqueue_admin_fonts() {

		// Deactivate the default Google Fonts version of Open Sans
		wp_deregister_style( 'open-sans' );
		wp_register_style( 'open-sans', false );

		// Replace them, unless Google Fonts are disabled
		if ( ! Clientside_Options::get_saved_option( 'disable-google-fonts-admin' ) ) {
			wp_enqueue_style( 'clientside-admin-fonts', '//fonts.googleapis.com/css?family=' . self::$admin_font_family );
		}

	}

	// Enqueue Google Fonts fonts for the login screen
	static function action_enqueue_login_fonts() {
		wp_enqueue_style( 'clientside-login-fonts', '//fonts.googleapis.com/css?family=' . self::$admin_font_family );
	}

	// Add plugin options link to the plugin entry in the plugin list
	static function filter_add_plugin_options_link( $links, $file ) {

		// Check that this is the right plugin entry
		$plugin_base_file = dirname( plugin_basename( __FILE__ ) ) . '/index.php';
		if ( $file != $plugin_base_file ) {
			return $links;
		}

		// Check that this user is allowed to manage the settings
		if ( ! Clientside_User::is_admin() ) {
			return $links;
		}

		// Generate link
		$settings_link = '<a href="' . Clientside_Pages::get_page_url( 'clientside-options-general' ) . '">' . __( 'Settings' ) . '</a>';

		// Add to links array
		array_unshift( $links, $settings_link );

		// Return links array
		return $links;

	}

	// Add CSS classes to the page's <body> tag
	static function filter_add_body_classes( $body_classes ) {

		$new_classes = array();

		// Only when logged in
		if ( ! is_user_logged_in() ) {
			return $body_classes;
		}

		// If viewing the site
		if ( ! is_admin() ) {
			$new_classes[] = 'clientside-site';
		}

		// If theming is enabled
		if ( Clientside::is_themed() ) {
			$new_classes[] = 'clientside-theme';
		}

		// If a custom logo image is provided and the menu logo hiding option is not enabled
		if ( Clientside_Options::get_saved_option( 'logo-image' ) && ! Clientside_Options::get_saved_option( 'hide-menu-logo' ) ) {
			$new_classes[] = 'clientside-custom-logo';
		}

		// If posts-per-page is overwritten via the option
		if ( Clientside_Options::get_saved_option( 'paging-posts' ) ) {
			$new_classes[] = 'clientside-custom-paging';
		}

		// If hide-top-paging option is enabled
		if ( Clientside_Options::get_saved_option( 'hide-top-paging' ) ) {
			$new_classes[] = 'clientside-hide-top-paging';
		}

		// If hide-post-search option is enabled
		if ( Clientside_Options::get_saved_option( 'hide-post-search' ) ) {
			$new_classes[] = 'clientside-hide-post-search';
		}

		// If hide-top-bulk option is enabled
		if ( Clientside_Options::get_saved_option( 'hide-top-bulk' ) ) {
			$new_classes[] = 'clientside-hide-top-bulk';
		}

		// If hide-user-role-changer
		if ( Clientside_Options::get_saved_option( 'hide-user-role-changer' ) ) {
			$new_classes[] = 'clientside-hide-user-role-changer';
		}

		// If hide-view-switch option is enabled
		if ( Clientside_Options::get_saved_option( 'hide-view-switch' ) ) {
			$new_classes[] = 'clientside-hide-view-switch';
		}

		// If hide-media-bulk-select option is enabled
		if ( Clientside_Options::get_saved_option( 'hide-media-bulk-select' ) ) {
			$new_classes[] = 'clientside-hide-media-bulk-select';
		}

		// If hide-comment-type-filter option is enabled
		if ( Clientside_Options::get_saved_option( 'hide-comment-type-filter' ) ) {
			$new_classes[] = 'clientside-hide-comment-type-filter';
		}

		// If enable-separators option is enabled
		if ( Clientside_Options::get_saved_option( 'enable-separators' ) ) {
			$new_classes[] = 'clientside-show-menu-separators';
		}

		// If enable-notification-center option is enabled
		if ( Clientside_Options::get_saved_option( 'enable-notification-center' ) ) {
			$new_classes[] = 'clientside-notification-center';
		}

		// If menu-hover-expand option is enabled
		if ( Clientside_Options::get_saved_option( 'menu-hover-expand' ) && is_admin() ) {
			$new_classes[] = 'clientside-menu-hover-expand';
		}

		// If hide-permalink option is enabled
		if ( ! Clientside_Options::get_saved_option( 'admin-widget-manager-permalink' ) ) {
			$new_classes[] = 'clientside-hide-permalink';
		}

		// If hide-media-button option is enabled
		if ( ! Clientside_Options::get_saved_option( 'admin-widget-manager-media-button' ) ) {
			$new_classes[] = 'clientside-hide-media-button';
		}

		// Merge & return
		if ( is_array( $body_classes ) ) {
			return array_merge( $body_classes, $new_classes );
		}
		return $body_classes . ' ' . implode( ' ', $new_classes ) . ' ';

	}

	// Remove plugin settings when uninstalling Clientside
	static function action_uninstall() {
		delete_option( Clientside_Options::$options_slug );
	}

	// Tells WP where to find language files
	static function action_prepare_translations() {
		load_plugin_textdomain( 'clientside', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	// Hide Clientside from plugin list depending on network option
	static function filter_trim_plugin_list( $plugins ) {

		if ( is_multisite() && Clientside_Options::get_saved_network_option( 'hide-plugin-entry' ) ) {
			unset( $plugins['Clientside/index.php'] );
		}

		// Return
		return $plugins;

	}

}
?>
