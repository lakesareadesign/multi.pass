<?php

class WDS_Controller_Sitemap extends WDS_Renderable {

	private static $_instance;

	private function __construct () {}

	public static function serve () {
		$me = WDS_Controller_Sitemap::get();
		$me->_add_hooks();
	}

	public static function get () {
		if (empty(self::$_instance)) self::$_instance = new self;
		return self::$_instance;
	}

	protected function _add_hooks () {
		add_action( 'init', array($this, 'serve_sitemap'), 999 );

		add_action('wp_ajax_wds_update_sitemap', array($this, 'json_update_sitemap'));
		add_action('wp_ajax_wds_update_engines', array($this, 'json_update_engines'));

		add_action('wp_ajax_wds-sitemap-add_extra', array($this, 'json_add_sitemap_extra'));
		add_action('wp_ajax_wds-sitemap-remove_extra', array($this, 'json_remove_sitemap_extra'));
		add_action('wp_ajax_wds-get-sitemap-report', array($this, 'json_get_sitemap_report'));

		$wds_options = WDS_Settings::get_options();
		if (isset($wds_options['sitemap-disable-automatic-regeneration']) && empty($wds_options['sitemap-disable-automatic-regeneration'])) {
			add_action('delete_post', array($this, 'update_sitemap'));
			add_action('publish_post', array($this, 'update_sitemap'));

			add_action('delete_page', array($this, 'update_sitemap'));
			add_action('publish_page', array($this, 'update_sitemap'));
		}
	}

	public function json_get_sitemap_report()
	{
		$result = array(
			'success' => false
		);
		$data = stripslashes_deep($_POST);
		$open_type = isset($data['open_type']) ? $data['open_type'] : null;

		if (!current_user_can('manage_options')) {
			wp_send_json($result);
			return;
		}

		ob_start();
		$this->_render('sitemap/sitemap-crawl-content', array(
			'open_type' => $open_type
		));
		$result['markup'] = ob_get_clean();
		$result['success'] = true;

		wp_send_json($result);
	}

	/**
	 * Adds extra item to sitemap processing
	 */
	public function json_add_sitemap_extra()
	{
		$result = array('status' => 0);
		if (!current_user_can('manage_options')) {
			wp_send_json($result);
			return;
		}

		$data = stripslashes_deep($_POST);
		if (empty($data['path'])) {
			wp_send_json($result);
			return;
		}

		$path = $data['path'];
		$paths = is_array($path) ? $path : array($path);

		$extras = WDS_XML_Sitemap::get_extra_urls();
		foreach ($paths as $current_path) {
			$index = array_search($current_path, $extras);
			if ($index === false) {
				$extras[] = esc_url($current_path);
			}
		}
		WDS_XML_Sitemap::set_extra_urls($extras);

		// Update sitemap
		new WDS_XML_Sitemap;

		$result['status'] = 1;
		wp_send_json($result);
	}

	/**
	 * Removes extra item to sitemap processing
	 */
	public function json_remove_sitemap_extra () {
		$result = array('status' => 0);
		if (!current_user_can('manage_options')) return wp_send_json($result);

		$data = stripslashes_deep($_POST);
		if (empty($data['path'])) return wp_send_json($result);

		$extras = WDS_XML_Sitemap::get_extra_urls();
		$idx = array_search($data['path'], $extras);
		if (false === $idx) return wp_send_json($result);

		unset($extras[$idx]);
		WDS_XML_Sitemap::set_extra_urls($extras);

		// Update sitemap
		new WDS_XML_Sitemap;

		$result['status'] = 1;
		return wp_send_json($result);
	}

	/**
	 * Gets sitemap stat options
	 *
	 * @return array
	 */
	public function get_sitemap_stats () {
		$opts = get_option('wds_sitemap_dashboard');
		return is_array($opts) ? $opts: array();
	}

	/**
	 * Extracts the URL part
	 *
	 * Falls back to the original passed argument
	 *
	 * @param string $raw Raw URL to extract from
	 * @param int|string $part Part flag (one of the PHP `parse_url()` flags, OR string key value)
	 *
	 * @return string
	 */
	public function get_url_part ($raw, $part) {
		if (empty($part)) return $raw;

		if (is_numeric($part)) {
			$clean = parse_url($raw, $part);
			return false !== $clean
				? $clean
				: $raw
			;
		}
		$parts = parse_url($raw);
		return !empty($parts[$part])
			? $parts[$part]
			: $raw
		;
	}

	/**
	 * Serves the sitemap, if requested via the URL
	 *
	 * @return void
	 */
	public function serve_sitemap () {
		if (!function_exists('wds_get_sitemap_path')) return false;
		$wds_options = WDS_Settings::get_options();
		$url_path = $this->get_url_part($_SERVER['REQUEST_URI'], PHP_URL_PATH);

		$path = wds_get_sitemap_path();

		$is_gzip = preg_match('~\.gz$~i', $url_path);
		$path = $is_gzip ? "{$path}.gz" : $path;

		if (preg_match('~' . preg_quote('/sitemap.xml') . '(\.gz)?$~i', $url_path)) {
			if (file_exists($path)) {
				if ($is_gzip) header('Content-Encoding: gzip');
				header('Content-Type: text/xml');
				readfile($path);
				die;
			} else {
				$sitemap = new WDS_XML_Sitemap;
				if(file_exists($path)) {
					if ($is_gzip) header('Content-Encoding: gzip');
					header('Content-Type: text/xml');
					readfile( $path );
					die;
				} else wp_die( __( 'The sitemap file was not found.' , 'wds') );
			}
		}
	}

	public function update_sitemap () {
		if( class_exists('WDS_XML_Sitemap') )
			$sitemap = new WDS_XML_Sitemap;
	}

	public function update_engines () {
		WDS_XML_Sitemap::notify_engines(1);
	}

	public function json_update_sitemap () {
		$this->update_sitemap();
		die(1);
	}

	public function json_update_engines () {
		$this->update_sitemap();
		die(1);
	}

	protected function _get_view_defaults()
	{
		return array();
	}
}
WDS_Controller_Sitemap::serve();