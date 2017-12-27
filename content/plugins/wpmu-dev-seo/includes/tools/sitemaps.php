<?php
/**
 * WDS_XML_Sitemap::generate_sitemap()
 * inspired by WordPress SEO by Joost de Valk (http://yoast.com/wordpress/seo/).
 */

/**
 * SmartCrawl pages optimization classes
 *
 * @package SmartCrawl
 * @since 1.3
 */

class WDS_XML_Sitemap {

	const EXTRAS_STORAGE = 'wds-sitemap-extras';

	private $_data;
	private $_db;

	private $_items;

	public function __construct () {
		global $wpdb;

		$data = WDS_Settings::get_component_options(WDS_Settings::COMP_SITEMAP);
		if (empty($data['sitemappath'])) return false;

		$this->_data = $data;
		$this->_db = $wpdb;

		$this->_init_items();

		// Refactor this!
		$this->generate_sitemap();
	}

	public function generate_sitemap () {
		$wds_options = WDS_Settings::get_options();

		WDS_Logger::info('(Re)generating sitemap');

		if (is_admin() && defined('WDS_SITEMAP_SKIP_ADMIN_UPDATE') && WDS_SITEMAP_SKIP_ADMIN_UPDATE) {
			WDS_Logger::debug('Skipping sitemap generation in admin context');
			return false;
		}

		//this can take a whole lot of time on big blogs
		$this->_set_time_limit(120);

		if (!$this->_items) $this->_load_all_items();

		$map = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";

		if (!empty($wds_options['sitemap-stylesheet'])) $map .= $this->_get_stylesheet('xml-sitemap');

		$image_schema_url = 'http://www.google.com/schemas/sitemap-image/1.1';
		$image_schema = !empty($wds_options['sitemap-images']) ? "xmlns:image='{$image_schema_url}'" : '';
		$map .= "<urlset xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:schemaLocation='http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd' xmlns='http://www.sitemaps.org/schemas/sitemap/0.9' {$image_schema}>\n";

		foreach ($this->_items as $item) {
			$map .= "<url>\n";
			foreach ($item as $key => $val) {
				if ('images' == $key) {
					if (!$val) continue;
					if (!@$wds_options['sitemap-images']) continue;
					foreach ($item['images'] as $image) {
						$text = $image['title'] ? $image['title'] : $image['alt'];
						$map .= "<image:image>";
						$map .= "<image:loc>" . esc_url($image['src']) . '</image:loc>';
						$map .= "<image:title>" . ent2ncr($text) . '</image:title>';
						$map .= "</image:image>\n";
					}
				} else $map .= "<{$key}>{$val}</{$key}>\n";
			}
			$map .= "</url>\n\n";
		}
		$map .= "</urlset>";

        $this->_write_sitemap($map);
        $this->_postprocess_sitemap();

		WDS_Logger::info('Sitemap regenerated');
	}

	protected function _set_time_limit ($amount=120) {
		$amount = empty($amount) || !is_numeric($amount)
			? 120
			: (int)$amount
		;
		// Check manual override
		if (defined('WDS_SITEMAP_SKIP_TIME_LIMIT_SETTING') && WDS_SITEMAP_SKIP_TIME_LIMIT_SETTING) return false;

		// Check safe mode
		$is_safe_mode = strtolower(ini_get('safe_mode'));
		if (!empty($is_safe_mode) && 'off' !== $is_safe_mode) {
			WDS_Logger::debug('Safe mode on, skipping time limit set.');
			return false;
		}

		// Check disabled state
		$disabled = array_map('trim', explode(',', ini_get('disable_functions')));
		if (in_array('set_time_limit', $disabled)) {
			WDS_Logger::debug('Time limit setting disabled, skipping.');
			return false;
		}

		return set_time_limit($amount);
	}

	public static function notify_engines ($forced=false) {
		if (wds_is_switch_active('WDS_SITEMAP_SKIP_SE_NOTIFICATION')) {
			WDS_Logger::debug('Skipping SE update notification.');
			return false;
		}

		$wds_options = WDS_Settings::get_options();
		if (!@$wds_options['sitemapurl']) return false;

		$result = array();
		$now = time();

		if ($forced || !empty($wds_options['ping-google'])) {
			do_action('wds_before_search_engine_update', 'google');
            $resp = wp_remote_get('http://www.google.com/webmasters/tools/ping?sitemap=' . esc_url(wds_get_sitemap_url()));
			$result['google'] = array(
				'response' => $resp,
				'time' => $now,
			);
			if (is_wp_error($resp)) {
				do_action('wds_after_search_engine_update', 'google', false, $resp);
			} else {
				do_action('wds_after_search_engine_update', 'google', (bool)(@$resp['response']['code'] == '200'), $resp);
			}
		}

		if ($forced || !empty($wds_options['ping-bing'])) {
			do_action('wds_before_search_engine_update', 'bing');
            $resp = wp_remote_get('http://www.bing.com/webmaster/ping.aspx?sitemap=' . esc_url(wds_get_sitemap_url()));
			$result['bing'] = array(
				'response' => $resp,
				'time' => $now,
			);
			if (is_wp_error($resp)) {
				do_action('wds_after_search_engine_update', 'bing', false, $resp);
			} else {
				do_action('wds_after_search_engine_update', 'bing', (bool)(@$resp['response']['code'] == '200'), $resp);
			}
		}

		update_option('wds_engine_notification', $result);
	}

	private function _is_admin_mapped () {
		return (bool)(is_multisite() && (is_admin() || is_network_admin()) && class_exists('domain_map'));
	}

	private function _get_stylesheet($xsl) {
		if (is_multisite() && defined('SUBDOMAIN_INSTALL') && !SUBDOMAIN_INSTALL) {
			$plugin_host = parse_url(WDS_PLUGIN_URL, PHP_URL_HOST);
			$protocol = (is_ssl() || force_ssl_admin()) ? 'https://' : 'http://';
			$xsl_host = preg_replace('~' . preg_quote($protocol . $plugin_host . '/') . '~', '', WDS_PLUGIN_URL);
			$xsl_host = '../' . $xsl_host;
			return "<?xml-stylesheet type='text/xml' href='{$xsl_host}admin/templates/xsl/{$xsl}.xsl'?>\n";
		} else {
			$plugin_dir_url = plugin_dir_url(dirname(__FILE__));
			return "<?xml-stylesheet type='text/xml' href='{$plugin_dir_url}admin/templates/xsl/{$xsl}.xsl'?>\n";
		}
	}

	/**
	 * Check whether the sitemap output file is writable.
	 *
	 * @return bool
	 */
	public static function is_sitemap_path_writable () {
		$file = wds_get_sitemap_path();

		if (file_exists($file)) {
			$fp = @fopen($file, 'a');
			if ($fp) {
				fclose($fp);
				return true;
			}
			return false;
		}

		return is_writable(dirname($file));
	}

	private function _write_sitemap ($map) {
		$file = wds_get_sitemap_path();
		$status = !!@file_put_contents($file, $map);
		if (!$status) {
			WDS_Logger::error("Failed writing sitemap file to [{$file}]");
		}

		$f = @fopen("{$file}.gz", "w");
		if (!$f) {
			WDS_Logger::error("Failed writing compressed sitemap file to [{$file}.gz]");
			return false;
		}

		@fwrite($f, gzencode($map, 9));
		@fclose($f);

		return true;
	}

	private function _postprocess_sitemap () {
		// Throw a hook
		do_action('wds_sitemap_created');

		$this->notify_engines();

		// Update sitemap meta data
		update_option('wds_sitemap_dashboard', array(
			'items' => count($this->_items),
			'time' => time(),
		));
	}

	private function _extract_images ($content) {
		if (wds_is_switch_active('WDS_SITEMAP_SKIP_IMAGES')) return array();

		preg_match_all("|(<img [^>]+?>)|", $content, $matches, PREG_SET_ORDER);
		if (!$matches) return false;

		$images = array();
		foreach ($matches as $tmp) {
			$img = $tmp[0];

			$res = preg_match('/src=("|\')([^"\']+)("|\')/', $img, $match);
			$src = $res ? $match[2] : '';
			if ( strpos($src, 'http') !== 0 ) {
				$src = site_url($src);
			}

			$res = preg_match( '/title=("|\')([^"\']+)("|\')/', $img, $match );
			$title = $res ? str_replace('-', ' ', str_replace('_', ' ', $match[2])) : '';

			$res = preg_match( '/alt=("|\')([^"\']+)("|\')/', $img, $match );
			$alt = $res ? str_replace('-', ' ', str_replace('_', ' ', $match[2])) : '';

			$images[] = array(
				'src' => $src,
				'title' => $title,
				'alt' => $alt,
			);
		}
		return $images;
	}

	private function _init_items () {
		$this->_items = array();
	}

	/**
	 * Adds a single item into the sitemap queue.
	 */
	private function _add_item ($url, $priority, $freq='weekly', $time=false, $content='') {
		if (!$this->_items) $this->_init_items();
		$time = $time ? $time : time();
		$offset = date("O", $time);

		$item = array (
			'loc' => esc_url($url),
			'lastmod' => date("Y-m-d\TH:i:s",$time).substr($offset,0,3).":".substr($offset,-2),//date('Y-m-d', $time),
            'changefreq' => strtolower( apply_filters('wds_sitemap_changefreq', $freq, $url, $priority, $time, $content ) ),
			'priority' => sprintf("%.1f", $priority),
		);

		$item['images'] = $content ? $this->_extract_images($content) : array();

		$this->_items[] = $item;
	}

	/**
	 * Loads all items that will get into a sitemap.
	 */
	private function _load_all_items () {
		$this->_add_item(home_url(), 1, 'daily'); // Home URL
		$this->_load_post_items();
		$this->_load_taxonomy_items();
		// Load BuddyPress-specific items.
		if (defined('BP_VERSION') && wds_is_main_bp_site()) {
			$this->_load_buddypress_group_items();
			$this->_load_buddypress_profile_items();
		}

		$this->_load_extra_items();
	}

	/**
	 * Loads extra items
	 *
	 * @return bool Status
	 */
	private function _load_extra_items () {
		$extras = self::get_extra_urls();
		foreach ($extras as $url) {
			$this->_add_item(
				$url,
				0.5,
				'weekly',
				time()
			);
		}

		return true;
	}

	/**
	 * Extra URLs storage getter
	 *
	 * @return array Extra sitemap URLs
	 */
	public static function get_extra_urls () {
		$extras = get_option(self::EXTRAS_STORAGE);
		return empty($extras) || !is_array($extras)
			? array()
			: array_filter(array_unique($extras))
		;
	}

	/**
	 * Extra URLs storage setter
	 *
	 * @param array $extras New extra URLs
	 *
	 * @return bool
	 */
	public static function set_extra_urls ($extras=array()) {
		if (!is_array($extras)) return false;
		return update_option(self::EXTRAS_STORAGE, array_filter(array_unique($extras)));
	}

	/**
	 * Loads BuddyPress Group items.
	 */
	private function _load_buddypress_group_items () {
		if (!function_exists('groups_get_groups')) return false; // No BuddyPress Groups, bail out.
		$wds_options = WDS_Settings::get_options();
		if (!defined('BP_VERSION')) return false; // Nothing to do
		if (!(int)@$wds_options['sitemap-buddypress-groups']) return false; // Nothing to do

		$groups = groups_get_groups(array('per_page' => WDS_BP_GROUPS_LIMIT));
		$groups = @$groups['groups'] ? $groups['groups'] : array();

		//$total_users = (int)count_users();
		//$total_users = $total_users ? $total_users : 1;

		foreach ($groups as $group) {
			if (@$wds_options["exclude-buddypress-group-{$group->slug}"]) continue;

			//$priority = sprintf("%.1f", ($group->total_member_count / $total_users));
			$link = bp_get_group_permalink($group);
			$this->_add_item(
				$link,
				0.2, //$priority
				'weekly',
				strtotime($group->last_activity),
				$group->description
			);
		}
		return true;
	}

	/**
	 * Loads BuddyPress profile items.
	 */
	private function _load_buddypress_profile_items () {
		$wds_options = WDS_Settings::get_options();
		if (!defined('BP_VERSION')) return false; // Nothing to do
		if (!function_exists('bp_core_get_users')) return false;
		if (!(int)@$wds_options['sitemap-buddypress-profiles']) return false; // Nothing to do

		$users = bp_core_get_users(array('per_page' => WDS_BP_PROFILES_LIMIT));
		$users = @$users['users'] ? $users['users'] : array();

		foreach ($users as $user) {
			$wp_user = new WP_User($user->id);
			$role = @$wp_user->roles[0];
			if (@$wds_options["exclude-profile-role-{$role}"]) continue;

			$link = bp_core_get_user_domain($user->id);
			$this->_add_item(
				$link,
				0.2,
				'weekly',
				strtotime($user->last_activity),
				$user->display_name
			);
		}
	}

	/**
	 * Loads posts into the sitemap.
	 */
	private function _load_post_items () {
		$wds_options = WDS_Settings::get_options();

		$get_content = !empty($wds_options['sitemap-images']) ? 'post_content,' : '';

		// Cache the static front page state
		$front_page = 'page' === get_option('show_on_front')
			? get_option('page_on_front')
			: false
		;

		$types = array();
		$raw = get_post_types(array(
			'public' => true,
			'show_ui' => true,
		));
		foreach ($raw as $type) {
			if (!empty($wds_options['post_types-' . $type . '-not_in_sitemap'])) continue;
			$types[] = $type;
		}
		$types_query = "AND post_type IN ('" . join("', '", $types) . "')";
		$posts = $this->_db->get_results(
			"SELECT ID, {$get_content} post_parent, post_type, post_modified FROM {$this->_db->posts} " .
				"WHERE post_status = 'publish' " .
				"AND post_password = '' " .
				"{$types_query} " .
				"ORDER BY post_parent ASC, post_modified DESC LIMIT " . WDS_SITEMAP_POST_LIMIT
		);
		$posts = $posts ? $posts : array();

		foreach ($posts as $post) {
			if (wds_get_value('meta-robots-noindex', $post->ID)) continue; // Not adding no-index files
			if (wds_get_value('redirect', $post->ID)) continue; // Don't add redirected URLs

			// Check for inclusion
			if (!apply_filters('wds-sitemaps-include_post', true, $post)) continue;

			// If this is a page and it's actually the one set as static front, pass
			if ('page' === $post->post_type && $front_page === $post->ID) continue;

			$link = get_permalink($post->ID);

			$canonical = wds_get_value('canonical', $post->ID);
			$link = $canonical ? $canonical : $link;

			$priority = wds_get_value('sitemap-priority', $post->ID);
			$priority = apply_filters('wds-post-priority', (
				$priority
					? $priority
					: ($post->post_parent ? 0.6 : 0.8)
			), $post);

			$content = isset($post->post_content) ? $post->post_content : '';
			$modified_ts = !empty($post->post_modified) ? strtotime($post->post_modified) : time();
			$modified_ts = $modified_ts > 0 ? $modified_ts : time();

			$this->_add_item(
				$link,
				$priority,
				'weekly',
				$modified_ts,
				$content
			);
		}
	}

	/**
	 * Loads taxonomies into the sitemap.
	 */
	private function _load_taxonomy_items () {
		if (wds_is_switch_active('WDS_SITEMAP_SKIP_TAXONOMIES')) return false;

		$wds_options = WDS_Settings::get_options();

		$tax = array();
		$raw = get_taxonomies(array(
			'public' => true,
			'show_ui' => true,
		), 'objects');
		foreach ($raw as $tid => $taxonomy) {
			if (!empty($wds_options['taxonomies-' . $taxonomy->name . '-not_in_sitemap'])) continue;
			$tax[] = $taxonomy->name;
		}
		if (empty($tax)) return true; // All done here

		$terms = get_terms($tax, array('hide_empty' => true));

		foreach ($terms as $term) {
			if (wds_get_term_meta($term, $term->taxonomy, 'wds_noindex')) continue;

			$canonical = wds_get_term_meta($term, $term->taxonomy, 'wds_canonical');
			$link = $canonical ? $canonical : get_term_link($term, $term->taxonomy);

			$priority = apply_filters('wds-term-priority', (
				$term->count > 10
					? 0.6
					: ($term->count > 3 ? 0.4 : 0.2)
			), $term);

// -------------------------------------- Potential kludge
			$q = new WP_Query(array(
				'tax_query' => array(
					'taxonomy' => $term->taxonomy,
					'field' => 'id',
					'terms' => $term->term_id
				),
				'orderby' => 'date',
				'order' => 'DESC',
				'posts_per_page' => 1,
			));
			$time = $q->posts ? strtotime($q->posts[0]->post_date) : time();
// -------------------------------------- Potential kludge

			$this->_add_item(
				$link,
				$priority,
				'weekly',
				$time
			);
		}
	}
}

/**
 * Regenerate sitemap on admin page visit
 */
function wds_xml_sitemap_init() {
	global $plugin_page;

	if( class_exists('WDS_Settings') && isset( $plugin_page ) && WDS_Settings::TAB_SITEMAP === $plugin_page ) {
		if (WDS_Settings::get_setting('sitemap')) $wds_xml = new WDS_XML_Sitemap();
	}
}
add_action( 'admin_init', 'wds_xml_sitemap_init' );

/**
 * Fetch the actual sitemap path, to the best of our abilities.
 */
function wds_get_sitemap_path () {
	$wds_options = WDS_Settings::get_options();

	$dir = wp_upload_dir();
	$path = !empty($wds_options['sitemappath']) ? $wds_options['sitemappath'] : false; // First thing first, try the sitewide option

	// Not in sitewide mode, check per-blog options
	if (!WDS_SITEWIDE) {
		$_data = get_option('wds_sitemap_options');
		$path = !empty($_data['sitemappath']) ? $_data['sitemappath'] : false;
	}

	// If there isn't a dir we need to write to,
	// or we're on a network child in sitewide mode,
	// go for the uploads dir
	if (!is_dir(dirname($path)) || (WDS_SITEWIDE && !is_main_site())) {
		$path = trailingslashit($dir['basedir']);
		$path = "{$path}sitemap.xml";
	}

	return wp_normalize_path($path);
}

/**
 * Fetch sitemap URL in an uniform fashion.
 */
function wds_get_sitemap_url () {
	$wds_options = WDS_Settings::get_options();
	$sitemap_options = (is_multisite() && is_main_site()) ? $wds_options : get_option('wds_sitemap_options');
	$sitemap_url = !empty($sitemap_options['sitemapurl']) ? $sitemap_options['sitemapurl'] : false;

	if (is_multisite() && class_exists('domain_map')) {
        $sitemap_url = home_url(false) . '/sitemap.xml';

		if (defined('WDS_SITEMAP_DM_SIMPLE_DISCOVERY_FALLBACK') && WDS_SITEMAP_DM_SIMPLE_DISCOVERY_FALLBACK) {
			$sitemap_url = (is_network_admin() ? '../../' : (is_admin() ? '../' : '/')) . 'sitemap.xml'; // Simplest possible logic
		}
	}
	return apply_filters('wds-sitemaps-sitemap_url', $sitemap_url);
}