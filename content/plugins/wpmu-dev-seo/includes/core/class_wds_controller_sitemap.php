<?php

class WDS_Controller_Sitemap {

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

		global $wds_options;
		if (isset($wds_options['sitemap-disable-automatic-regeneration']) && empty($wds_options['sitemap-disable-automatic-regeneration'])) {
			add_action('delete_post', array($this, 'update_sitemap'));
			add_action('publish_post', array($this, 'update_sitemap'));

			add_action('delete_page', array($this, 'update_sitemap'));
			add_action('publish_page', array($this, 'update_sitemap'));
		}
	}

	/**
	 * Adds extra item to sitemap processing
	 */
	public function json_add_sitemap_extra () {
		$result = array('status' => 0);
		if (!current_user_can('manage_options')) return wp_send_json($result);

		$data = stripslashes_deep($_POST);
		if (empty($data['path'])) return wp_send_json($result);

		$extras = WDS_XML_Sitemap::get_extra_urls();
		$extras[] = esc_url($data['path']);
		WDS_XML_Sitemap::set_extra_urls($extras);

		// Update sitemap
		new WDS_XML_Sitemap;

		$result['status'] = 1;
		return wp_send_json($result);
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

	public function serve_sitemap () {
		if (!function_exists('wds_get_sitemap_path')) return false;
		global $wds_options;

		$path = wds_get_sitemap_path();

		$is_gzip = preg_match('~\.gz$~i', $_SERVER['REQUEST_URI']);
		$path = $is_gzip ? "{$path}.gz" : $path;

		if (preg_match('~' . preg_quote('/sitemap.xml') . '(\.gz)?$~i', $_SERVER['REQUEST_URI'])) {
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
}
WDS_Controller_Sitemap::serve();