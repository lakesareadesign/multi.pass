<?php

class WDS_Onpage_Settings extends WDS_Settings_Admin {

	private static $_instance;

	public static function get_instance () {
		if (empty(self::$_instance)) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	/**
	 * Validate submitted options
	 *
	 * @param array $input Raw input
	 *
	 * @return array Validated input
	 */
	public function validate ($input) {
		$result = array();

		// Setup
		if (!empty($input['wds_onpage-setup'])) $result['wds_onpage-setup'] = true;

		// Meta robots
		if (!empty($input['meta_robots-noindex-main_blog_archive'])) $result['meta_robots-noindex-main_blog_archive'] = true;
		if (!empty($input['meta_robots-nofollow-main_blog_archive'])) $result['meta_robots-nofollow-main_blog_archive'] = true;
		if (!empty($input['meta_robots-main_blog_archive-subsequent_pages'])) $result['meta_robots-main_blog_archive-subsequent_pages'] = true;

		if (!empty($input['meta_robots-noindex-search'])) $result['meta_robots-noindex-search'] = true;
		if (!empty($input['meta_robots-nofollow-search'])) $result['meta_robots-nofollow-search'] = true;

		$tax_options = $this->_get_tax_options('');
		foreach ($tax_options as $option => $_tax) {
			$rbts = $this->get_robots_options_for($option);
			if (!empty($rbts) && is_array($rbts)) foreach (array_keys($rbts) as $item) {
				if (!empty($input[$item])) $result[$item] = true;
			}
		}
		$other_options = $this->_get_other_types_options('');
		foreach ($other_options as $option => $_tax) {
			$rbts = $this->get_robots_options_for($option);
			if (!empty($rbts) && is_array($rbts)) foreach (array_keys($rbts) as $item) {
				if (!empty($input[$item])) $result[$item] = true;
			}
		}

		// String values
		$strings = array(
			'home',
			'search',
			'404',
			'bp_groups',
			'bp_profile',
			'mp_marketplace-base',
			'mp_marketplace-categories',
			'mp_marketplace-tags',
		);
		foreach (get_post_types(array('public' => true)) as $pt) {
			$strings[] = $pt;
		}
		$strings = array_merge($strings, array_values($tax_options));
		$strings = array_merge($strings, array_values($other_options));

		foreach ($strings as $str) {
			if (isset($input["title-{$str}"])) $result["title-{$str}"] = $this->_sanitize_preserve_macros($input["title-{$str}"]);
			if (isset($input["metadesc-{$str}"])) $result["metadesc-{$str}"] = $this->_sanitize_preserve_macros($input["metadesc-{$str}"]);
			if (isset($input["metakeywords-{$str}"])) $result["metakeywords-{$str}"] = $this->_sanitize_preserve_macros($input["metakeywords-{$str}"]);


			// OpenGraph
			if (isset($input["og-title-{$str}"])) {
				$result["og-title-{$str}"] = $this->_sanitize_preserve_macros($input["og-title-{$str}"]);
			}
			if (isset($input["og-description-{$str}"])) {
				$result["og-description-{$str}"] = $this->_sanitize_preserve_macros($input["og-description-{$str}"]);
			}

			$result["og-images-{$str}"] = array();
			if (!empty($input["og-images-{$str}"]) && is_array($input["og-images-{$str}"])) {
				foreach ($input["og-images-{$str}"] as $img) {
					$result["og-images-{$str}"][] = esc_url($img);
				}
			}
			$result["og-images-{$str}"] = array_values(array_filter(array_unique($result["og-images-{$str}"])));
		}

		// Special case handling for home page keywords
		// because the legacy one doesn't follow the naming convention
		if (isset($input["keywords-home"])) {
			$result["keywords-home"] = $this->_sanitize_preserve_macros($input["keywords-home"]);
		}


		return $result;
	}

	/**
	 * Preserve macros in sanitization
	 *
	 * @param string $str String to sanitize
	 *
	 * @return string Sanitized string
	 */
	private function _sanitize_preserve_macros ($str) {
		if (empty($str)) return $str;

		$rpl = '__WDS_MACRO_QUOTES_REPLACEMENT__';
		$str = preg_replace('/%%/', $rpl, $str);

		$str = sanitize_text_field($str);

		$str = preg_replace('/' . preg_quote($rpl, '/') . '/', '%%', $str);

		return $str;
	}

	public function init () {
		$this->option_name     = 'wds_onpage_options';
		$this->name            = WDS_Settings::COMP_ONPAGE;
		$this->slug            = WDS_Settings::TAB_ONPAGE;
		$this->action_url      = admin_url( 'options.php' );
		$this->title           = __( 'Title & Meta', 'wds' );
		$this->page_title      = __( 'SmartCrawl Wizard: Title & Meta', 'wds' );

		add_action('wp_ajax_wds-onpage-preview', array($this, 'json_create_preview'));

		parent::init();

	}

	/**
	 * Preview building handler
	 */
	public function json_create_preview () {
		$data = stripslashes_deep($_POST);

		$src_type = !empty($data['type']) ? $data['type'] : false;
		$src_title = !empty($data['title']) ? $data['title'] : false;
		$src_meta = !empty($data['description']) ? $data['description'] : false;

		$updated = false;

		$link = home_url();
		$title = get_bloginfo('name');
		$description = get_bloginfo('description');

		$warnings = array();

		switch ($src_type) {
			case "tab_search-page":
				set_query_var('s', 'test');
			case "tab_author-archive":
				set_query_var('author', get_current_user_id());
			case "tab_date-archive":
			case "tab_homepage":
			case "tab_404-page":
				$title = wds_replace_vars($src_title);
				$description = wds_replace_vars($src_meta);
				$updated = true;

				if (strlen($title) > WDS_TITLE_LENGTH_CHAR_COUNT_LIMIT) {
					$warnings['title'] = __('Your title seems to be a bit on the long side, consider trimming it', 'wds');
				}
				if (strlen($description) > WDS_METADESC_LENGTH_CHAR_COUNT_LIMIT) {
					$warnings['description'] = __('Your description seems to be a bit on the long side, consider trimming it', 'wds');
				}

				break;
			case "tab_post-categories":
				$tax = $this->_get_random_term('category');
				if (!empty($tax)) {
					$title = wds_replace_vars($src_title, $tax);
					$description = wds_replace_vars($src_meta, $tax);
					$link = get_term_link($tax['term_id'], 'category');
				}
				$updated = true;
				break;
			case "tab_post-tags":
				$tax = $this->_get_random_term('post_tag');
				if (!empty($tax)) {
					$title = wds_replace_vars($src_title, $tax);
					$description = wds_replace_vars($src_meta, $tax);
					$link = get_term_link($tax['term_id'], 'post_tag');
				}
				$updated = true;
				break;
		}

		// Custom post type?
		if (!$updated) foreach (get_post_types(array('public' => true)) as $type) {
			if ("tab_{$type}" !== $src_type) continue;
			$updated = true;
			$post = $this->_get_random_post($type);
			if (!empty($post)) {
				$title = wds_replace_vars($src_title, $post);
				$description = wds_replace_vars($src_meta, $post);
				$link = get_permalink($post['ID']);
			}
		}

		// Custom taxonomy?
		if (!$updated) foreach (get_taxonomies(array( '_builtin' => false )) as $tax) {
			if ("tab_{$tax}" !== $src_type) continue;
			$updated = true;
			$term = $this->_get_random_term($tax);
			if (!empty($term)) {
				$title = wds_replace_vars($src_title, $term);
				$description = wds_replace_vars($src_meta, $term);
				$link = get_term_link($term['term_id'], $tax);
			}
		}

		wp_send_json(array(
			'status' => $updated,
			'markup' => $this->_load('onpage-preview', array(
				'link' => $link,
				'title' => $title,
				'description' => $description,
			)),
			'warnings' => $warnings,
		));
	}

	/**
	 * Randomly spawns a post of certain post type
	 *
	 * @param string $type Post type
	 *
	 * @return array
	 */
	private function _get_random_post ($type='post') {
		$args = array(
			'posts_per_page' => 1,
			'post_type' => $type,
			'orderby' => 'random',
		);
		if ('attachment' === $type) {
			$args['post_status'] = 'any';
		}
		$q = new WP_Query($args);
		return !empty($q->post)
			? (array)$q->post
			: array()
		;
	}

	/**
	 * Spawn a random taxonomy term for a tax type
	 *
	 * @param string $type Taxonomy type
	 *
	 * @return array
	 */
	private function _get_random_term ($type='category') {
		$q = get_terms(array(
			'taxonomy' => $type,
		));
		if (empty($q)) return array();

		$idx = rand(0, count($q));
		return !empty($q[$idx])
			? (array)$q[$idx]
			: array()
		;
	}

	/**
	 * Returns a set of known macros, as macro => description pairs
	 *
	 * @return array List of known macros
	 */
	public static function get_macros () {
		return array(
			'%%date%%' => __( 'Date of the post/page', 'wds' ),
			'%%title%%' => __( 'Title of the post/page', 'wds' ),
			'%%sitename%%' => __( 'Site\'s name', 'wds' ),
			'%%sitedesc%%' => __( 'Site\'s tagline / description', 'wds' ),
			'%%excerpt%%' => __( 'Post/page excerpt (or auto-generated if it does not exist)', 'wds' ),
			'%%excerpt_only%%' => __( 'Post/page excerpt (without auto-generation)', 'wds' ),
			'%%tag%%' => __( 'Current tag/tags', 'wds' ),
			'%%category%%' => __( 'Post categories (comma separated)', 'wds' ),
			'%%category_description%%' => __( 'Category description', 'wds' ),
			'%%tag_description%%' => __( 'Tag description', 'wds' ),
			'%%term_description%%' => __( 'Term description', 'wds' ),
			'%%term_title%%' => __( 'Term name', 'wds' ),
			'%%modified%%' => __( 'Post/page modified time', 'wds' ),
			'%%id%%' => __( 'Post/page ID', 'wds' ),
			'%%name%%' => __( 'Post/page author\'s \'nicename\'', 'wds' ),
			'%%userid%%' => __( 'Post/page author\'s userid', 'wds' ),
			'%%searchphrase%%' => __( 'Current search phrase', 'wds' ),
			'%%currenttime%%' => __( 'Current time', 'wds' ),
			'%%currentdate%%' => __( 'Current date', 'wds' ),
			'%%currentmonth%%' => __( 'Current month', 'wds' ),
			'%%currentyear%%' => __( 'Current year', 'wds' ),
			'%%page%%' => __( 'Current page number (i.e. page 2 of 4)', 'wds' ),
			'%%pagetotal%%' => __( 'Current page total', 'wds' ),
			'%%pagenumber%%' => __( 'Current page number', 'wds' ),
			'%%caption%%' => __( 'Attachment caption', 'wds' ),
			'%%spell_pagenumber%%' => __( 'Current page number, spelled out as numeral in English', 'wds' ),
			'%%spell_pagetotal%%' => __( 'Current page total, spelled out as numeral in English', 'wds' ),
			'%%spell_page%%' => __( 'Current page number, spelled out as numeral in English', 'wds' ),
		);
	}

	/**
	 * Spawns a set of robots options for a given type
	 *
	 * @param string $type Archives type to generate the robots options for
	 *
	 * @return array Generated meta robots option array
	 */
	public static function get_robots_options_for ($type) {
		return array(
			"meta_robots-noindex-{$type}" => __( 'Noindex', 'wds' ),
			"meta_robots-nofollow-{$type}" => __( 'Nofollow', 'wds' ),
			"meta_robots-{$type}-subsequent_pages" => __( 'Leave the first page alone, but apply to subsequent pages', 'wds' ),
		);
	}

	/**
	 * Spawn taxonomy options and names, indexed by taxonomy option names
	 *
	 * @param string $pfx Prefix options with this
	 *
	 * @return array
	 */
	protected function _get_tax_options ($pfx='') {
		$pfx = !empty($pfx) ? rtrim($pfx, '_') . '_' : $pfx;
		$opts = array();
		foreach ( get_taxonomies( array( '_builtin' => false ), 'objects' ) as $taxonomy ) {
			$name = $pfx . str_replace( '-', '_', $taxonomy->name );
			$opts[$name] = $taxonomy->name;
		}
		return $opts;
	}

	/**
	 * Spawn taxonomy options and names, indexed by taxonomy option names
	 *
	 * @param string $pfx Prefix options with this
	 *
	 * @return array
	 */
	protected function _get_other_types_options ($pfx='') {
		$pfx = !empty($pfx) ? rtrim($pfx, '_') . '_' : $pfx;
		$opts = array();
		$other_types = array(
			'category',
			'post_tag',
			'author',
			'date',
		);
		foreach ($other_types as $value) {
			$name = $pfx . $value;
			$opts[$name] = $value;
		}
		return $opts;
	}

	/**
	 * Add admin settings page
	 */
	public function options_page () {
		parent::options_page();

		$wds_options = WDS_Settings::get_options();

		$arguments = array(
			'macros' => self::get_macros(),
			'meta_robots_main_blog_archive' => self::get_robots_options_for('main_blog_archive'),
		);

		foreach ($this->_get_tax_options('meta_robots_') as $option => $tax) {
			$tax = str_replace('-', '_', $tax);
			if (empty($arguments[$option])) $arguments[$option] = self::get_robots_options_for($tax);
		}

		foreach ($this->_get_other_types_options('meta_robots_') as $option => $value) {
			if (empty($arguments[$option])) $arguments[$option] = self::get_robots_options_for($value);
		}

		$arguments['meta_robots_search'] = array(
			"meta_robots-noindex-search" => __('Noindex', 'wds'),
			"meta_robots-nofollow-search" => __('Nofollow', 'wds'),
		);
		$arguments['radio_options'] = array(
			__( 'No', 'wds' ),
			__( 'Yes', 'wds' ),
		);

		$arguments['engines'] = array(
			'ping-google' => __('Google', 'wds'),
			'ping-bing' => __('Bing', 'wds'),
		);

		wp_enqueue_script('wds-admin-onpage');
		$this->_render_page('onpage-settings', $arguments);
	}

	/**
	 * Default settings
	 */
	public function defaults () {

		if( is_multisite() && WDS_SITEWIDE ) {
			$this->options = get_site_option( $this->option_name );
		} else {
			$this->options = get_option( $this->option_name );
		}

		if ( empty($this->options['title-home']) ) {
			$this->options['title-home'] = '%%sitename%%';
		}

		if ( empty($this->options['metadesc-home']) ) {
			$this->options['metadesc-home'] = '%%sitedesc%%';
		}

		if ( empty($this->options['keywords-home']) ) {
			$this->options['keywords-home'] = '';
		}

		if ( empty($this->options['onpage-stylesheet']) ) {
			$this->options['onpage-stylesheet'] = 0;
		}

		if ( empty($this->options['onpage-dashboard-widget']) ) {
			$this->options['onpage-dashboard-widget'] = 1;
		}

		if ( empty($this->options['onpage-disable-automatic-regeneration']) ) {
			$this->options['onpage-disable-automatic-regeneration'] = 0;
		}

		foreach ( get_post_types(array('public' => true)) as $posttype ) {
			if ( in_array( $posttype, array( 'revision', 'nav_menu_item' ) ) ) continue;
			if ( isset( $wds_options['redirectattachment'] ) && $wds_options['redirectattachment'] && $posttype == 'attachment' ) continue;
			if (preg_match('/^upfront_/', $posttype)) continue;

			$type_obj = get_post_type_object( $posttype );
			if ( ! is_object( $type_obj ) ) continue;

			if ( empty($this->options['title-' . $posttype]) ) {
				$this->options['title-' . $posttype] = '%%title%% | %%sitename%%';
			}

			if ( empty($this->options['metadesc-' . $posttype]) ) {
				$this->options['metadesc-' . $posttype] = '%%excerpt%%';
			}
		}

		foreach ( get_taxonomies( array( '_builtin' => false ), 'objects' ) as $taxonomy ) {
			if ( empty($this->options['title-' . $taxonomy->name]) ) {
				$this->options['title-' . $taxonomy->name] = '';
			}

			if ( empty($this->options['metadesc-' . $taxonomy->name]) ) {
				$this->options['metadesc-' . $taxonomy->name] = '';
			}
		}

		$other_types = array(
			'category'                  => array( 'title' => '%%category%% | %%sitename%%', 'desc' => '%%category_description%%' ),
			'post_tag'                  => array( 'title' => '%%tag%% | %%sitename%%', 'desc' => '%%tag_description%%' ),
			'author'                    => array( 'title' => '%%name%% | %%sitename%%', 'desc' => '' ),
			'date'                      => array( 'title' => '%%currentdate%% | %%sitename%%', 'desc' => '' ),
			'search'                    => array( 'title' => '%%searchphrase%% | %%sitename%%', 'desc' => '' ),
			'404'                       => array( 'title' => 'Page not found | %%sitename%%', 'desc' => '' ),
			'bp_groups'                 => array( 'title' => '%%bp_group_name%% | %%sitename%%', 'desc' => '%%bp_group_description%%' ),
			'bp_profile'                => array( 'title' => '%%bp_user_username%% | %%sitename%%', 'desc' => '%%bp_user_full_name%%' ),
			'mp_marketplace-base'       => array( 'title' => '', 'desc' => '' ),
			'mp_marketplace-categories' => array( 'title' => '', 'desc' => '' ),
			'mp_marketplace-tags'       => array( 'title' => '', 'desc' => '' ),
		);

		foreach ( $other_types as $key => $value ) {
			if ( empty($this->options['title-' . $key]) ) {
				$this->options['title-' . $key] = $value['title'];
			}

			if ( empty($this->options['metadesc-' . $key]) ) {
				$this->options['metadesc-' . $key] = $value['desc'];
			}
		}

		if( is_multisite() && WDS_SITEWIDE ) {
			update_site_option( $this->option_name, $this->options );
		} else {
			update_option( $this->option_name, $this->options );
		}

	}

}
