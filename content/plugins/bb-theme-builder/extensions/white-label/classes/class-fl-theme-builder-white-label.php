<?php

/**
 * White labeling for the theme builder.
 *
 * @since 1.0
 */
final class FLThemeBuilderWhiteLabel {

	/**
	 * @return void
	 */
	static public function init()
	{
		add_filter( 'all_plugins', __CLASS__ . '::plugins_page' );
	}

	/**
	 * White labels the themer builder on the plugins page.
	 *
	 * @since 1.0
	 * @param array $plugins An array data for each plugin.
	 * @return array
	 */
	static public function plugins_page( $plugins )
	{
		$default  = __( 'Page Builder', 'fl-theme-builder' );
		$branding = FLBuilderModel::get_branding();
		$key	  = plugin_basename( FL_THEME_BUILDER_DIR . 'bb-theme-builder.php' );

		if ( isset( $plugins[ $key ] ) && $branding != $default ) {
			$plugins[ $key ]['Name']	   = $branding . ' - Themer Add-On';
			$plugins[ $key ]['Title']	   = $branding . ' - Themer Add-On';
			$plugins[ $key ]['Author']	   = '';
			$plugins[ $key ]['AuthorName'] = '';
			$plugins[ $key ]['PluginURI']  = '';
		}

		return $plugins;
	}
}

FLThemeBuilderWhiteLabel::init();
