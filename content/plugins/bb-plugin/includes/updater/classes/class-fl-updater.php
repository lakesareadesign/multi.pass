<?php

/**
 * Manages remote updates for all Beaver Builder products.
 *
 * @since 1.0
 */
final class FLUpdater {

	/**
	 * The API URL for the Beaver Builder update server. 
	 *
	 * @since 1.0
	 * @access private
	 * @var string $_updates_api_url
	 */
	static private $_updates_api_url = 'http://updates.wpbeaverbuilder.com/';

	/**
	 * An internal array of data for each product.
	 *
	 * @since 1.0
	 * @access private
	 * @var array $_products
	 */
	static private $_products = array();

	/**
	 * An internal array of settings for the updater instance.
	 *
	 * @since 1.0
	 * @access private
	 * @var array $settings
	 */
	private $settings = array();

	/**
	 * Updater constructor method.
	 *
	 * @since 1.0
	 * @param array $settings An array of settings for this instance.
	 * @return void
	 */
	public function __construct( $settings = array() )
	{
		$this->settings = $settings;

		if ( 'plugin' == $settings['type'] ) {
			add_filter( 'pre_set_site_transient_update_plugins', array( $this, 'update_check' ) );
			add_filter( 'plugins_api', array( $this, 'plugin_info' ), 10, 3 );
			add_action( 'in_plugin_update_message-' . self::get_plugin_file( $settings['slug'] ), array( $this, 'update_message' ), 1, 2 );
		}
		else if ( $settings['type'] == 'theme' ) {
			add_filter( 'pre_set_site_transient_update_themes', array( $this, 'update_check' ) );
		}
	}

	/**
	 * Checks to see if an update is available for the current product.
	 *
	 * @since 1.0
	 * @param object $transient A WordPress transient object with update data.
	 * @return object
	 */
	public function update_check($transient)
	{
		if(empty($transient->checked)) {
			return $transient;
		}

		$response = FLUpdater::api_request(self::$_updates_api_url, array(
			'fl-api-method' => 'update_check',
			'license'       => FLUpdater::get_subscription_license(),
			'domain'        => network_home_url(),
			'product'       => $this->settings['name'],
			'slug'          => $this->settings['slug'],
			'version'       => $this->settings['version']
		));

		if( ! isset( $response->error ) ) {

			if($this->settings['type'] == 'plugin') {

				$plugin   = self::get_plugin_file($this->settings['slug']);
				$new_ver  = $response->new_version;
				$curr_ver = $this->settings['version'];
				
				if ( empty( $response->package ) ) {
					$response->upgrade_notice = FLUpdater::get_update_error_message();
				}
				if(version_compare($new_ver, $curr_ver, '>')) {
					$transient->response[$plugin] = $response;
				}
			}
			else if($this->settings['type'] == 'theme') {

				$new_ver  = $response->new_version;
				$curr_ver = $this->settings['version'];

				if(version_compare($new_ver, $curr_ver, '>')) {
					$transient->response[$this->settings['slug']] = array(
						'new_version'   => $response->new_version,
						'url'           => $response->url,
						'package'       => $response->package
					);
				}
			}
		}

		return $transient;
	}

	/**
	 * Shows an update message on the plugins page if an update
	 * is available but there is no active subscription.
	 *
	 * @since 1.0
	 * @param array $plugin_data An array of data for this plugin.
	 * @param object $response An object with update data for this plugin.
	 * @return void
	 */
	public function update_message( $plugin_data, $response )
	{
		if ( empty( $response->package ) ) {
			echo FLUpdater::get_update_error_message( $plugin_data );
		}
	}

	/**
	 * Retrives the data for the plugin info lightbox.
	 *
	 * @since 1.0
	 * @param bool $false
	 * @param string $action
	 * @param object $args
	 * @return object|bool
	 */
	public function plugin_info($false, $action, $args)
	{
		if(!isset($args->slug) || $args->slug != $this->settings['slug']) {
			return $false;
		}

		$response = FLUpdater::api_request(self::$_updates_api_url, array(
			'fl-api-method' => 'plugin_info',
			'license'       => FLUpdater::get_subscription_license(),
			'domain'        => network_home_url(),
			'product'       => $this->settings['name'],
			'slug'          => $this->settings['slug'],
			'version'       => $this->settings['version']
		));

		if( ! isset( $response->error ) ) {
			$response->name     = $this->settings['name'];
			$response->sections = (array)$response->sections;
			return $response;
		}

		return $false;
	}

	/**
	 * Static method for initializing an instance of the updater
	 * for each active product.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function init()
	{
		include FL_UPDATER_DIR . 'includes/config.php';

		foreach($config as $path) {
			if(file_exists($path)) {
				require_once $path;
			}
		}
	}

	/**
	 * Static method for adding a product to the updater and
	 * creating the new instance.
	 *
	 * @since 1.0
	 * @param array $args An array of settings for the product.
	 * @return void
	 */
	static public function add_product($args = array())
	{
		if(is_array($args) && isset($args['slug'])) {

			if($args['type'] == 'plugin') {
				if(file_exists(WP_CONTENT_DIR . '/plugins/' . $args['slug'])) {
					self::$_products[$args['name']] = $args;
					new FLUpdater(self::$_products[$args['name']]);
				}
			}
			if($args['type'] == 'theme') {
				if(file_exists(WP_CONTENT_DIR . '/themes/' . $args['slug'])) {
					self::$_products[$args['name']] = $args;
					new FLUpdater(self::$_products[$args['name']]);
				}
			}
		}
	}

	/**
	 * Static method for rendering the license form.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function render_form()
	{
		// Activate a subscription?
		if(isset($_POST['fl-updater-nonce'])) {
			if(wp_verify_nonce($_POST['fl-updater-nonce'], 'updater-nonce')) {
				self::save_subscription_license($_POST['license']);
			}
		}

		$license 	  = self::get_subscription_license();
		$subscription = self::get_subscription_info();

		// Include the form ui.
		include FL_UPDATER_DIR . 'includes/form.php';
	}

	/**
	 * Static method for getting the subscription license key.
	 *
	 * @since 1.0
	 * @return string
	 */
	static public function get_subscription_license()
	{
		$value = get_site_option('fl_themes_subscription_email');

		return $value ? $value : '';
	}

	/**
	 * Static method for updating the subscription license.
	 *
	 * @since 1.0
	 * @param string $license The new license key.
	 * @return void
	 */
	static public function save_subscription_license($license)
	{
		FLUpdater::api_request(self::$_updates_api_url, array(
			'fl-api-method' => 'activate_domain',
			'license'       => $license,
			'domain'        => network_home_url(),
			'products'		=> json_encode( self::$_products )
		));
		
		update_site_option('fl_themes_subscription_email', $license);
	}

	/**
	 * Static method for retrieving the subscription info.
	 *
	 * @since 1.0
	 * @return bool
	 */
	static public function get_subscription_info()
	{
		return self::api_request(self::$_updates_api_url, array(
			'fl-api-method' => 'subscription_info',
			'domain'        => network_home_url(),
			'license'       => FLUpdater::get_subscription_license()
		));
	}

	/**
	 * Returns an update message for if an update
	 * is available but there is no active subscription.
	 *
	 * @since 1.6.4.3
	 * @param array $plugin_data An array of data for this plugin.
	 * @return string
	 */
	static private function get_update_error_message( $plugin_data = null )
	{
		$message  = '';
		$message .= '<p style="padding:10px 20px; margin-top: 10px; background: #d54e21; color: #fff;">';
		$message .= __( '<strong>UPDATE UNAVAILABLE!</strong>', 'fl-builder' );
		$message .= '&nbsp;&nbsp;&nbsp;';
		$message .= __('Please subscribe to enable automatic updates for this plugin.', 'fl-builder');
		
		if ( $plugin_data && isset( $plugin_data['PluginURI'] ) ) {
			$message .= ' <a href="' . $plugin_data['PluginURI'] . '" target="_blank" style="color: #fff; text-decoration: underline;">';
			$message .= __('Subscribe Now', 'fl-builder');
			$message .= ' &raquo;</a>';
		}
		
		$message .= '</p>';
		
		return $message;
	}

	/**
	 * Static method for retrieving the plugin file path for a
	 * product relative to the plugins directory.
	 *
	 * @since 1.0
	 * @access private
	 * @param string $slug The product slug.
	 * @return string
	 */
	static private function get_plugin_file( $slug )
	{
		if ( 'bb-plugin' == $slug ) {
			$file = $slug . '/fl-builder.php';
		}
		else {
			$file = $slug . '/' . $slug . '.php';
		}

		return $file;
	}

	/**
	 * Static method for sending a request to the store
	 * or update API.
	 *
	 * @since 1.0
	 * @access private
	 * @param string $api_url The API URL to use.
	 * @param array $args An array of args to send along with the request.
	 * @return mixed The response or false if there is an error.
	 */
	static private function api_request($api_url = false, $args = array())
	{
		if($api_url) {

			$params = array();

			foreach($args as $key => $val) {
				$params[] = $key . '=' . urlencode($val);
			}

			return self::remote_get($api_url . '?' . implode('&', $params));
		}

		return false;
	}

	/**
	 * Get a remote response.
	 *
	 * @since 1.0
	 * @access private
	 * @param string $url The URL to get.
	 * @return mixed The response or false if there is an error.
	 */
	static private function remote_get($url)
	{
		$request      = wp_remote_get($url);
		$error        = new stdClass();
		$error->error = true;

		if(is_wp_error($request)) {
			return $error;
		}
		if(wp_remote_retrieve_response_code($request) != 200) {
			return $error;
		}
		
		$body = wp_remote_retrieve_body($request);
		
		if(is_wp_error($body)) {
			return $error;
		}

		$body_decoded = json_decode($body);
		
		if(!is_object($body_decoded)) {
			return $error;
		}

		return $body_decoded;
	}
}