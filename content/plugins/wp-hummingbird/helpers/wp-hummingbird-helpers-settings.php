<?php

/**
 * Return the plugin settings
 *
 * @return array Plugin Settings
 */
function wphb_get_settings() {
	if ( ! is_multisite() ) {
		$options = get_option( 'wphb_settings', array() );
	}
	else {
		$blog_options = get_option( 'wphb_settings', array() );
		$network_options = get_site_option( 'wphb_settings', array() );
		$options = array_merge( $blog_options, $network_options );
	}

	return wp_parse_args( $options, wphb_get_default_settings() );
}

/**
 * @param $option_nameReturn a single WP Hummingbird setting
 */
function wphb_get_setting( $option_name ) {
	$settings = wphb_get_settings();
	if ( ! isset( $settings[ $option_name ] ) ) {
		return '';
	}

	return $settings[ $option_name ];
}

/**
 * Return the plugin default settings
 *
 * @return array Default Plugin Settings
 */
function wphb_get_default_settings() {
	$defaults = array(
		'minify' => false,
		'caching' => false,
		'uptime' => false,

		// Only for multisites. Toggles minification in a subsite
		// By default is true as if 'minify' is set to false, this option has no meaning
		'minify-blog' => true,

		'max_files_in_group' => 10,
		'block' => array( 'scripts' => array(), 'styles' => array() ),
		'dont_minify' => array( 'scripts' => array(), 'styles' => array() ),
		'dont_combine' => array( 'scripts' => array(), 'styles' => array() ),
		'position' => array( 'scripts' => array(), 'styles' => array() ),
		'caching_expiry_css' => '8d/A691200',
		'caching_expiry_javascript' => '8d/A691200',
		'caching_expiry_media' => '8d/A691200',
		'caching_expiry_images' => '8d/A691200',

		'cloudflare-email' => '',
		'cloudflare-api-key' => '',
		'cloudflare-zone' => '',
		'cloudflare-zone-name' => '',
		'cloudflare-connected' => false,
		'cloudflare-plan' => false,
		'cloudflare-page-rules' => array(),
		'cloudflare-caching-expiry' => 691200,
	);

	/**
	 * Filter the default settings.
	 * Useful when adding new settings to the plugin
	 */
	return apply_filters( 'wp_hummingbird_default_options', $defaults );
}


function wphb_get_blog_option_names() {
	return array( 'block', 'minify-blog', 'dont_minify', 'dont_combine', 'position', 'max_files_in_group', 'last_change' );
}


function wphb_get_setting_type( $option_name ) {
	// Settings per site
	$blog_options = wphb_get_blog_option_names();

	// Rest of the options are network options

	if ( in_array( $option_name, $blog_options ) ) {
		return 'blog';
	}

	return 'network';
}

/**
 * Update the plugin settings
 *
 * @param array $new_settings New settings
 */
function wphb_update_settings( $new_settings ) {
	if ( ! is_multisite() ) {
		update_option( 'wphb_settings', $new_settings );
	}
	else {
		$network_options = array_diff_key( $new_settings, array_fill_keys( wphb_get_blog_option_names(), wphb_get_blog_option_names() ) );
		$blog_options = array_intersect_key( $new_settings, array_fill_keys( wphb_get_blog_option_names(), wphb_get_blog_option_names() ) );

		update_site_option( 'wphb_settings', $network_options );
		update_option( 'wphb_settings', $blog_options );
	}
}


function wphb_update_setting( $setting, $value ) {
	$settings = wphb_get_settings();
	$settings[ $setting ] = $value;
	wphb_update_settings( $settings );
}

/**
 * @param $value
 * @param bool $network
 */
function wphb_toggle_minification( $value, $network = false ) {

	$settings = wphb_get_settings();
	if ( is_multisite() ) {
		if ( $network ) {
			// Updating for the whole network
			$settings['minify'] = $value;
		}
		else {
			// Updating on subsite
			if ( ! $settings['minify'] ) {
				// Minification is turned down for the whole network, do not activate it per site
				$settings['minify-blog'] = false;
			}
			else {
				$settings['minify-blog'] = $value;
			}
		}
	}
	else {
		$settings['minify'] = $value;
	}

	wphb_update_settings( $settings );
}