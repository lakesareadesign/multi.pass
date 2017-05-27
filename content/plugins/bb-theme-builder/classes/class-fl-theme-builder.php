<?php

/**
 * Handles base logic for the theme builder.
 *
 * @since 1.0
 */
final class FLThemeBuilder {

	/**
	 * Initializes the theme builder.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function init() {
		self::register_user_access_settings();

		// Actions
		add_action( 'plugins_loaded', __CLASS__ . '::load_plugin_textdomain' );
	}

	/**
	 * Registers the user access settings for the theme builder.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function register_user_access_settings() {
		FLBuilderUserAccess::register_setting( 'theme_builder_editing', array(
			'default'     => array( 'administrator' ),
			'group'       => __( 'Admin', 'fl-theme-builder' ),
			'label'       => __( 'Theme Builder Editing', 'fl-theme-builder' ),
			'description' => __( 'The selected roles will be able to edit themes using the builder.', 'fl-theme-builder' ),
		) );
	}

	/**
	 * Load the translation file for current language. Checks the default WordPress
	 * languages folder first and then the languages folder inside the plugin.
	 *
	 * @since 1.0
	 * @return string|bool The translation file path or false if none is found.
	 */
	static public function load_plugin_textdomain() {
		// Traditional WordPress plugin locale filter
		$locale = apply_filters( 'plugin_locale', get_locale(), 'fl-theme-builder' );

		// Setup paths to current locale file
		$mofile_global = trailingslashit( WP_LANG_DIR ) . 'plugins/bb-theme-builder/' . $locale . '.mo';
		$mofile_local  = trailingslashit( FL_THEME_BUILDER_DIR ) . 'languages/' . $locale . '.mo';

		if ( file_exists( $mofile_global ) ) {
			// Look in global /wp-content/languages/plugins/bb-plugin/ folder
			return load_textdomain( 'fl-theme-builder', $mofile_global );
		} elseif ( file_exists( $mofile_local ) ) {
			// Look in local /wp-content/plugins/bb-plugin/languages/ folder
			return load_textdomain( 'fl-theme-builder', $mofile_local );
		}

		// Nothing found
		return false;
	}

	/**
	 * Checks to see if the current page has a layout
	 * of the specified type.
	 *
	 * @since 1.0
	 * @param string $type
	 * @return bool
	 */
	static public function has_layout( $type = null ) {
		$layouts = FLThemeBuilderLayoutData::get_current_page_layouts( $type );
		return count( $layouts ) ? true : false;
	}
}

FLThemeBuilder::init();
