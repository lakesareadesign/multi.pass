<?php
/*
 * Clientside Updates class
 * Handles plugin updates outside of the WP plugin repository. Based on the custom update script by Jeremy Clark of http://clark-technet.com.
 */

class Clientside_Updates {

	static $update_host = 'frique.me';
	static $api_url = 'http://frique.me/_updates/';
	static $plugin_path = 'Clientside/index.php';

	// Perform Clientside update check
	// $checked_data->checked contains list of all plugins with their versions
	static function filter_check( $checked_data ) {

		global $wp_version;

		// Comment out these two lines during testing.
		if ( empty( $checked_data->checked ) ) {
			return $checked_data;
		}

		// Start checking for an update
		$raw_response = wp_remote_post(
			self::$api_url,
			array(
				'body' => array(
					'action' => 'basic_check',
					'request' => serialize(
						array(
							'slug' => 'clientside',
							'version' => $checked_data->checked[ self::$plugin_path ],
						)
					)
					//'api-key' => md5( get_bloginfo( 'url' ) )
				),
				'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo( 'url' )
			)
		);

		// Process response
		if ( ! is_wp_error( $raw_response ) && ( $raw_response['response']['code'] == 200 ) ) {
			$response = unserialize( $raw_response['body'] );
		}

		// Feed the update data into WP updater
		if ( isset( $response ) && is_object( $response ) && ! empty( $response ) ) {
			$checked_data->response[ self::$plugin_path ] = $response;
		}

		return $checked_data;

	}

	// What to display in the plugin info window
	static function filter_plugin_info( $def, $action, $args ) {

		global $wp_version;

		// Only when the plugin is Clientside
		if ( ! isset( $args->slug ) || ( $args->slug != 'clientside' ) ) {
			return false;
		}

		// Get the current version
		$plugin_info = get_site_transient( 'update_plugins' );
		$args->version = $plugin_info->checked[ self::$plugin_path ];

		$raw_response = wp_remote_post(
			self::$api_url,
			array(
				'body' => array(
					'action' => $action,
					'request' => serialize( $args )
					//'api-key' => md5( get_bloginfo( 'url' ) )
				),
				'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo( 'url' )
			)
		);

		// Process reponse
		if ( is_wp_error( $raw_response ) ) {
			$response = new WP_Error( 'plugins_api_failed', __( 'An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>' ), $raw_response->get_error_message() );
		} else {
			$response = unserialize( $raw_response['body'] );
			if ( $response === false ) {
				$response = new WP_Error( 'plugins_api_failed', __( 'An unknown error occurred' ), $raw_response['body'] );
			}
		}

		// Return response
		return $response;

	}

	// Allow downloading updates from external server
	function allow_update_host( $allow, $host, $url ) {

		if ( $host == self::$update_host ) {
			$allow = true;
		}

		return $allow;

	}

}

?>