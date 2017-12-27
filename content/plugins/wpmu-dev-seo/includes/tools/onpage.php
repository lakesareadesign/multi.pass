<?php
/**
 * WDS_OnPage::wds_title(), WDS_OnPage::wds_head(), WDS_OnPage::wds_metadesc()
 * inspired by WordPress SEO by Joost de Valk (http://yoast.com/wordpress/seo/).
 */


class WDS_OnPage {

	private static $_instance;

	private $_is_running = false;

	public static function get () {
		if (empty(self::$_instance)) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	private function __construct () {
		if (defined('SF_PREFIX') && function_exists('sf_get_option')) {
			add_action('template_redirect', array($this, 'postpone_for_simplepress'), 1);
			return;
		}
	}

	public function run () {
		if ($this->_is_running) return false;

		$options = WDS_Settings::get_options();

		remove_action('wp_head', 'rel_canonical');

		add_action('wp_head', array($this, 'wds_head'), 10, 1);

		// wp_title isn't enough. We'll do it anyway: suspenders and belt approach.
		add_filter('wp_title', array($this, 'wds_title'), 10, 3);
		// Buffer the header output and process it instead.
		//add_action('init', array($this, 'wds_start_title_buffer'));
		add_action('template_redirect', array($this, 'wds_start_title_buffer'), 99);
		// This should now work with BuddyPress as well.
		add_filter('bp_page_title', array($this, 'wds_title'), 10, 3);

		add_action('wp',array($this,'wds_page_redirect'), 99, 1);

		if (!empty($options['general-suppress-generator'])) {
			remove_action('wp_head', 'wp_generator');
		}

		if (!empty($options['general-suppress-redundant_canonical'])) {
			if (!defined('WDS_SUPPRESS_REDUNDANT_CANONICAL')) define('WDS_SUPPRESS_REDUNDANT_CANONICAL', true);
		}
		$this->_is_running = true;
	}

	/**
	 * Can't fully handle SimplePress installs properly.
	 * For non-forum pages, do our thing all the way.
	 * For forum pages, do nothing.
	 */
	function postpone_for_simplepress () {
		global $wp_query;
		if ((int)sf_get_option('sfpage') != $wp_query->post->ID) {
			$this->_init();
		}
	}

	/**
	 * Starts buffering the header.
	 * The buffer output will be used to replace the title.
	 */
	function wds_start_title_buffer () {
		ob_start(array($this, 'wds_process_title_buffer'));
	}

	/**
	 * Stops buffering the output - the title should now be in the buffer.
	 */
	function wds_stop_title_buffer () {
		if (function_exists('ob_list_handlers')) {
			$active_handlers = ob_list_handlers();
		} else {
			$active_handlers = array();
		}
		if (count($active_handlers) > 0) {
			$offset = count($active_handlers) - 1;
			$handler = !empty($active_handlers[$offset]) && is_string($active_handlers[$offset])
				? trim($active_handlers[$offset])
				: ''
			;
			if (preg_match('/::wds_process_title_buffer$/', $handler)) {
				ob_end_flush();
			}
		}
		/* if (count($active_handlers) > 0 && preg_match('/::wds_process_title_buffer$/', trim($active_handlers[count($active_handlers) - 1]))) { */
		/* 	ob_end_flush(); */
		/* } */
	}

	/**
	 * Handles the title buffer.
	 * Replaces the title with what we get from the old wds_title method.
	 * If we get nothing from it, do nothing.
	 */
	function wds_process_title_buffer ($head) {
		if (is_feed()) return $head;

		$title_rx = '<title[^>]*?>.*?' . preg_quote('</title>');
		$head_rx = '<head [^>]*? >';
		$head = preg_replace('/\n/', '__WDS_NL__', $head);
		// Dollar signs throw off replacement...
		$title = preg_replace('/\$/', '__WDS_DOLLAR__', $this->wds_title('')); // ... so temporarily escape them, then
		// Make sure we're replacing TITLE that's actually in the HEAD
		$head = ($title && preg_match("~{$head_rx}~ix", $head)) ?
			preg_replace("~{$title_rx}~i", "<title>{$title}</title>", $head)
			: $head
		;
		return preg_replace('/__WDS_NL__/', "\n", preg_replace('/__WDS_DOLLAR__/', '\$', $head));
	}

	public function get_resolver () {
		if (!class_exists('WDS_Endpoint_Resolver')) require_once(WDS_PLUGIN_DIR . '/core/class_wds_endpoint_resolver.php');
		return WDS_Endpoint_Resolver::resolve();
	}

	private function get_request_param($key)
	{
		$data = stripslashes_deep($_POST);
		return sanitize_text_field(
			wds_get_array_value($data, $key)
		);
	}

	/**
	 * Gets resolved title
	 *
	 * @param string $title Optional seed title
	 *
	 * @return string Resolved title
	 */
	public function get_title ($title='') {
		$request_title = $this->get_request_param('wds_title');
		if (!empty($request_title)) {
			return $request_title;
		}

		$resolver = $this->get_resolver();

		$post = $resolver->get_context();
		$wp_query = $resolver->get_query_context();

		if (empty($title)) $title = get_the_title($post);
		$wds_options = WDS_Settings::get_options();

		$location = $resolver->get_location();

		if ( WDS_Endpoint_Resolver::L_BLOG_HOME === $location ) {
			$title = wds_replace_vars($wds_options['title-home'], (array) $post );
		} else if ( WDS_Endpoint_Resolver::L_STATIC_HOME === $location ) {
			$post = get_post(get_option('page_for_posts'));
			$fixed_title = wds_get_value('title');
			if ( $fixed_title ) {
				$title = wds_replace_vars($fixed_title, (array)$post);
			} else if (!empty($post->post_type) && isset($wds_options['title-'.$post->post_type]) && !empty($wds_options['title-'.$post->post_type]) ) {
				$title = wds_replace_vars($wds_options['title-'.$post->post_type], (array) $post );
			}
		} else if ( WDS_Endpoint_Resolver::L_TAX_ARCHIVE === $location ) {
			$term = $wp_query->get_queried_object();
			$title = wds_get_term_meta( $term, $term->taxonomy, 'wds_title' );
			if ( !$title && isset($wds_options['title-'.$term->taxonomy]) && !empty($wds_options['title-'.$term->taxonomy]) )
				$title = wds_replace_vars($wds_options['title-'.$term->taxonomy], (array) $term );
		} else if ( WDS_Endpoint_Resolver::L_SEARCH === $location && !empty($wds_options['title-search']) ) {
			$title = wds_replace_vars($wds_options['title-search'], (array) $wp_query->get_queried_object() );
		} else if ( WDS_Endpoint_Resolver::L_AUTHOR_ARCHIVE === $location ) {
			$author_id = get_query_var('author');
			$title = get_the_author_meta('wds_title', $author_id);
			if ( empty($title) && isset($wds_options['title-author']) && !empty($wds_options['title-author']) ) {
				$title = wds_replace_vars($wds_options['title-author'], array() );
			}
		} else if ( WDS_Endpoint_Resolver::L_ARCHIVE === $location && !empty($wds_options['title-archive']) ) {
			$title = wds_replace_vars($wds_options['title-archive'], array('post_title' => $title) );
		} else if ( WDS_Endpoint_Resolver::L_404 === $location && !empty($wds_options['title-404']) ) {
			$title = wds_replace_vars($wds_options['title-404'], array('post_title' => $title) );
		} else if ( WDS_Endpoint_Resolver::L_BP_GROUPS === $location ) {
			$title = wds_replace_vars($wds_options['title-bp_groups'], array(
				'name' => $group->name,
				'description' => $group->description
			));
		} else if ( WDS_Endpoint_Resolver::L_BP_PROFILE === $location ) {
			$title = wds_replace_vars($wds_options['title-bp_profile'], array(
				'full_name' => bp_get_displayed_user_fullname(),
				'username' => bp_get_displayed_user_username(),
			));
		} else if ( WDS_Endpoint_Resolver::L_MP_GPRODS === $location ) {
			// Global MarketPress products
			if (!empty($wds_options['title-mp_marketplace-base'])) $title = wds_replace_vars($wds_options['title-mp_marketplace-base']);
		} else if (WDS_Endpoint_Resolver::L_MP_GTAX === $location) {
			// Global MarketPress Tags / Categories
			$mp_term = $wp_query->get('global_taxonomy');
			$args = array();
			$raw_title = 'mp_global_tags' == $wp_query->get('pagename')
				? $wds_options['title-mp_marketplace-tags']
				: $wds_options['title-mp_marketplace-categories']
			;
			if (!empty($mp_term)) {
				$mp_term_name = wds_get_mp_global_term_name($mp_term);
				if (!empty($mp_term_name)) $args['name'] = $mp_term_name;
			}
			if (!empty($raw_title)) $title = wds_replace_vars($raw_title, $args);
		} else if ( WDS_Endpoint_Resolver::L_SINGULAR === $location ) {
			$object = get_queried_object();
			$post_id = !empty($post->ID)
				? $post->ID
				: (!empty($object->ID) ? $object->ID : false)
			;
			$fixed_title = wds_get_value('title', $post_id);
			if ( $fixed_title ) {
				$title = wds_replace_vars($fixed_title, (array)$post);
			} else if (!empty($post->post_type) && isset($wds_options['title-'.$post->post_type]) && !empty($wds_options['title-'.$post->post_type]) ) {
				$title = wds_replace_vars($wds_options['title-'.$post->post_type], (array) $post );
			}
		} else if ( WDS_Endpoint_Resolver::L_WOO_SHOP === $location ) { // WooCommerce shop page
			$post_id = woocommerce_get_page_id('shop');
			$fixed_title = wds_get_value('title', $post_id);
			if ( $fixed_title ) {
				$title = wds_replace_vars($fixed_title, (array)$post);
			} /*else if (
				!empty($post->post_type) &&
				isset($wds_options['title-'.$post->post_type]) &&
				!empty($wds_options['title-'.$post->post_type])
			) {
				$title = wds_replace_vars($wds_options['title-'.$post->post_type], (array) $post );
			}*/
		}

		return $title;
	}


	/**
	 * Gets resolved description
	 *
	 * @param string $metadesc Optional seed metadesc
	 *
	 * @return string Resolved description
	 */
	public function get_description ($metadesc='') {
		$request_description = $this->get_request_param('wds_description');
		if (!empty($request_description)) {
			return $request_description;
		}

		$resolver = $this->get_resolver();

		$post = $resolver->get_context();
		$wp_query = $resolver->get_query_context();

		if (empty($metadesc) && is_object($post)) {
			$metadesc = wds_get_trimmed_excerpt($post->post_excerpt, $post->post_content);
		}
		$location = $resolver->get_location();
		$wds_options = WDS_Settings::get_options();

		if ( WDS_Endpoint_Resolver::L_BP_GROUPS === $location ) { // BP group?
			$optvar = !empty($wds_options['metadesc-bp_groups']) ? $wds_options['metadesc-bp_groups'] : '';
			$metadesc = wds_replace_vars($optvar, array(
				'name' => $group->name,
				'description' => $group->description
			));
		} else if ( WDS_Endpoint_Resolver::L_BP_PROFILE === $location ) {
			$optvar = !empty($wds_options['metadesc-bp_profile']) ? $wds_options['metadesc-bp_profile'] : '';
			$metadesc = wds_replace_vars($optvar, array(
				'full_name' => bp_get_displayed_user_fullname(),
				'username' => bp_get_displayed_user_username(),
			));
		} else if ( WDS_Endpoint_Resolver::L_MP_GPRODS === $location ) {
			// Global MarketPress products
			if (!empty($wds_options['metadesc-mp_marketplace-base'])) $metadesc = wds_replace_vars($wds_options['metadesc-mp_marketplace-base']);
		} else if ( WDS_Endpoint_Resolver::L_MP_GTAX === $location ) {
			// Global MarketPress Tags / Categories
			$mp_term = $wp_query->get('global_taxonomy');
			$args = array();
			$raw_metadesc = 'mp_global_tags' == $wp_query->get('pagename')
				? $wds_options['metadesc-mp_marketplace-tags']
				: $wds_options['metadesc-mp_marketplace-categories']
			;
			if (!empty($mp_term)) {
				$mp_term_name = wds_get_mp_global_term_name($mp_term);
				if (!empty($mp_term_name)) $args['name'] = $mp_term_name;
			}
			if (!empty($raw_metadesc)) $metadesc = wds_replace_vars($raw_metadesc, $args);
		} else if ( WDS_Endpoint_Resolver::L_SINGULAR === $location ) {
			$object = get_queried_object();
			$post_id = !empty($post->ID)
				? $post->ID
				: (!empty($object->ID) ? $object->ID : false)
			;
			$stored = wds_get_value('metadesc', $post_id);
			if (empty($stored) && is_object($post)) {
				$optvar = !empty($wds_options['metadesc-'.$post->post_type]) ? $wds_options['metadesc-'.$post->post_type] : '';
				$stored = wds_replace_vars($optvar, (array) $post );
			} else if (!empty($stored)) {
				$stored = wds_replace_vars($stored, (array)$post);
			}
			if (!empty($stored)) $metadesc = $stored;
		} else if ( WDS_Endpoint_Resolver::L_WOO_SHOP === $location ) { // WooCommerce shop page
			$post_id = woocommerce_get_page_id('shop');
			$metadesc = wds_get_value('metadesc', $post_id);
			if (is_object($post)) $metadesc = wds_replace_vars($metadesc, (array)$post);
		} else if ( WDS_Endpoint_Resolver::L_BLOG_HOME === $location && isset($wds_options['metadesc-home']) ) {
			$metadesc = wds_replace_vars($wds_options['metadesc-home'], array() );
		} else if ( WDS_Endpoint_Resolver::L_STATIC_HOME === $location ) {
			$npost = get_post( get_option('page_for_posts') );
			$metadesc = is_object($npost) && !empty($npost->ID)
				? wds_get_value('metadesc', $npost->ID)
				: wds_get_value('metadesc')
			;
			if (is_object($npost)) $metadesc = wds_replace_vars($metadesc, (array)$npost);
			if ( ($metadesc == '' || !$metadesc) && is_object($npost) &&  isset($wds_options['metadesc-'.$npost->post_type]) ) {
				$metadesc = wds_replace_vars($wds_options['metadesc-'.$npost->post_type], (array) $npost );
			}
		} else if ( WDS_Endpoint_Resolver::L_TAX_ARCHIVE === $location ) {
			$term = $wp_query->get_queried_object();

			$metadesc = wds_get_term_meta( $term, $term->taxonomy, 'wds_desc' );
			if ( !$metadesc && isset($wds_options['metadesc-'.$term->taxonomy])) {
				$metadesc = wds_replace_vars($wds_options['metadesc-'.$term->taxonomy], (array) $term );
			}
		} else if ( WDS_Endpoint_Resolver::L_AUTHOR_ARCHIVE === $location ) {
			$author_id = get_query_var('author');
			$metadesc = get_the_author_meta('wds_metadesc', $author_id);
		}


		return strip_tags(stripslashes($metadesc));
	}

	function wds_title( $title, $sep = '', $seplocation = '', $postid = '' ) {
		$title = $this->get_title($title);
		return esc_html( strip_tags( stripslashes( apply_filters('wds_title', $title) ) ) );
	}

	function wds_head() {
		global $wp_query, $paged;
		$wds_options = WDS_Settings::get_options();

		$this->wds_stop_title_buffer(); // STOP processing the buffer.

		$robots = '';

		if (!wds_is_switch_active('WDS_WHITELABEL_ON')) {
			echo "<!-- SEO meta tags powered by SmartCrawl https://premium.wpmudev.org/project/smartcrawl-wordpress-seo/ -->\n";
		}
		$this->wds_canonical();
		$this->wds_rel_links();
		$this->wds_robots();
		$this->wds_metadesc();
		$this->wds_meta_keywords();

		$metas = $this->get_meta_tags();
		foreach ($metas as $meta) {
			echo "{$meta}\n";
		}

		do_action('wds_head-after_output');

		if (!wds_is_switch_active('WDS_WHITELABEL_ON')) {
			echo "<!-- /SEO -->\n";
		}
	}

	public function get_meta_tags () {
		$wds_options = WDS_Settings::get_options();
		$metas = array();

		$include_verifications = (bool)(
			empty($wds_options['verification-pages'])
			|| (
				!empty($wds_options['verification-pages'])
				&&
				'home' === $wds_options['verification-pages']
				&&
				is_front_page()
			)
		);

		if (!empty($wds_options['verification-google']) && $include_verifications) {
			$metas['google'] = '<meta name="google-site-verification" content="' .
				esc_attr($wds_options['verification-google']) . '" />';
		}
		if (!empty($wds_options['verification-bing']) && $include_verifications) {
			$metas['bing'] = '<meta name="msvalidate.01" content="' .
				esc_attr($wds_options['verification-bing']) . '" />';
		}

		// Full meta overrides
		if (!empty($wds_options['verification-google-meta']) && $include_verifications) {
			$metas['google'] = $wds_options['verification-google-meta'];
		}
		if (!empty($wds_options['verification-bing-meta']) && $include_verifications) {
			$metas['bing'] = $wds_options['verification-bing-meta'];
		}

		$additional = !empty($wds_options['additional-metas']) ? $wds_options['additional-metas'] : array();
		if (!is_array($additional)) $additional = array();

		foreach ($additional as $meta) $metas[] = $meta;

		return $metas;
	}

	/**
	 * Gets singular entity fallback canonical URL
	 *
	 * @return string|bool Canonical URL, or (bool)false
	 */
	function get_rel_canonical () {
		$link = false;
        if (!is_singular()) return $link;

        global $wp_the_query;
        if (!$id = $wp_the_query->get_queried_object_id()) return;

        $link = get_permalink($id);
        if ($page = get_query_var('cpage')) $link = get_comments_pagenum_link($page);

		return $link;
    }

	/**
	 * Handle canonical link rendering
	 *
	 * @return bool Status
	 */
	function wds_canonical () {
		global $wp_query, $paged;

		if (
			function_exists('bp_is_blog_page') // If we have BuddyPress ...
			&& // ... and
			!(bp_is_blog_page() || is_404()) // ... we're on a BP page
		) return false;

		if (!apply_filters('wds_process_canonical', true)) return false; // Allow optional filtering out

		// Set decent canonicals for homepage, singulars and taxonomy pages
		$canonical = wds_get_value('canonical');

		if (empty($canonical)) {
			if (is_singular()) {
                $canonical = $this->get_rel_canonical();
			} else {
				$canonical = '';
				if (is_front_page()) {
					$canonical = trailingslashit(get_bloginfo('url'));
				} else if (is_tax() || is_tag() || is_category()) {
					$term = $wp_query->get_queried_object();
					$canonical = wds_get_term_meta($term, $term->taxonomy, 'wds_canonical');
					$canonical = $canonical	? $canonical : get_term_link( $term, $term->taxonomy );
				} else if (is_date()) {
					$requested_year = get_query_var('year');
					$requested_month = get_query_var('monthnum');
					$date_callback = !empty($requested_year) && empty($requested_month)
						? 'get_year_link'
						: 'get_month_link'
					;
					$canonical = $date_callback($requested_year, $requested_month);
				}

				//only show id not error object
				if ($canonical && !is_wp_error($canonical)) {
					if ($paged && !is_wp_error($paged)) $canonical .= trailingslashit('page/'.$paged);
				}
			}
		}

		$canonical = apply_filters("wds_filter_canonical", $canonical);

		// Let's check if we're dealing with the redundant canonical
		if (wds_is_switch_active('WDS_SUPPRESS_REDUNDANT_CANONICAL')) {
			global $wp;
			$current_url = add_query_arg($_GET, trailingslashit(home_url($wp->request)));
			if ($current_url === $canonical) $canonical = false;
		}

		if (!empty($canonical)) {
			echo "" .
				'<link rel="canonical" href="' . esc_attr($canonical) . '" />' .
			"\n";
		}

		return !empty($canonical);
	}

	function wds_rel_links () {
		global $wp_query, $paged;
		$wds_options = WDS_Settings::get_options();

		if (!$wp_query->max_num_pages) return false; // Short out on missing max page number

		if (!apply_filters('wds_process_rel_links', true)) return false; // Allow optional filtering out

		$is_taxonomy = (is_tax() || is_tag() || is_category() || is_date());
		$requested_year = get_query_var('year');
		$requested_month = get_query_var('monthnum');
		$is_date = is_date() && !empty($requested_year);
		$date_callback = !empty($requested_year) && empty($requested_month)
			? 'get_year_link'
			: 'get_month_link'
		;
		$pageable = ($is_taxonomy || (is_home() && 'posts' == get_option('show_on_front')));
		if (!$pageable) return false;

		$term = $wp_query->get_queried_object();
		$canonical = !empty($term->taxonomy) && $is_taxonomy ? wds_get_term_meta( $term, $term->taxonomy, 'wds_canonical' ) : false;
		if (!$canonical) {
			if ((int)$paged > 1) {
				$prev = is_home() ? home_url() : (
					$is_date
						? $date_callback($requested_year, $requested_month)
						: get_term_link($term, $term->taxonomy)
				);
				$prev = ('' == get_option('permalink_structure'))
					? (($paged > 2) ? add_query_arg('page', $paged-1, $prev) : $prev)
					: (($paged > 2) ? trailingslashit($prev) . 'page/' . ($paged-1) : $prev)
				;
				$prev = trailingslashit($prev);
				echo "<link rel='prev' href='{$prev}' />\n";
			}
			$is_paged = (int)$paged ? (int)$paged : 1;
			if ($is_paged && $is_paged < $wp_query->max_num_pages) {
				$next = is_home() ? home_url() : (
					$is_date
						? $date_callback($requested_year, $requested_month)
						: get_term_link($term, $term->taxonomy)
				);
				$next_page = $is_paged+1;
				$next = ('' == get_option('permalink_structure'))
					? add_query_arg('page', $next_page, $next)
					: trailingslashit($next) . 'page/' . $next_page
				;
				$next = trailingslashit($next);
				echo "<link rel='next' href='{$next}' />\n";
			}
		}
	}

	function wds_robots () {
		global $wp_query, $paged;
		$wds_options = WDS_Settings::get_options();

		if (!apply_filters('wds_process_robots', true)) return false; // Allow optional filtering out

		$robots = '';
		$term = is_tax() || is_tag() || is_category()
			? $wp_query->get_queried_object()
			: false
		;

		if (is_singular()) {
			$current_comments_page = (int)get_query_var('cpage');
			if ($current_comments_page) {
				$robots = 'noindex,';
			} else {
				/* $robots = wds_get_value('meta-robots-noindex') ? 'noindex,' : 'index,'; */
				$noindex = wds_get_value('meta-robots-noindex');
				// Allow global per-type noindex support
				if (empty($noindex)) {
					$type = get_post_type();
					if (!empty($type) && isset($wds_options["meta_robots-noindex-{$type}"])) {
						$noindex = $wds_options["meta_robots-noindex-{$type}"];
					}
				}
				$robots = !empty($noindex) ? 'noindex,' : 'index,';
			}

			/* $robots .= wds_get_value('meta-robots-nofollow') ? 'nofollow' : 'follow'; */
			$nofollow = wds_get_value('meta-robots-nofollow');
			// Allow globale per-type nofollow support
			if (empty($nofollow)) {
				$type = get_post_type();
				if (!empty($type) && isset($wds_options["meta_robots-nofollow-{$type}"])) {
					$nofollow = $wds_options["meta_robots-nofollow-{$type}"];
				}
			}
			$robots .= !empty($nofollow) ? 'nofollow' : 'follow';

			if ( wds_get_value('meta-robots-adv') && wds_get_value('meta-robots-adv') != 'none' ) {
				$robots .= ','.wds_get_value('meta-robots-adv');
			}
		} else if (function_exists('is_shop') && is_shop() && function_exists('woocommerce_get_page_id')) { // WooCommerce shop page
			$post_id = woocommerce_get_page_id('shop');
			$robots .= wds_get_value('meta-robots-noindex', $post_id) ? 'noindex,' : 'index,';
			$robots .= wds_get_value('meta-robots-nofollow', $post_id) ? 'nofollow' : 'follow';
			if ( wds_get_value('meta-robots-adv', $post_id) && wds_get_value('meta-robots-adv', $post_id) != 'none' ) {
				$robots .= ','.wds_get_value('meta-robots-adv', $post_id);
			}
		} else if (is_search()) {
			$global_noindex = !empty($wds_options['meta_robots-noindex-search'])
				? 'noindex'
				: 'index'
			;
			$global_nofollow = !empty($wds_options['meta_robots-nofollow-search'])
				? 'nofollow'
				: 'follow'
			;
			$robots = "{$global_noindex},{$global_nofollow}";
		} else if (is_home() && 'posts' == get_option('show_on_front')) {
			$global_noindex = !empty($wds_options['meta_robots-noindex-main_blog_archive'])
				? 'noindex'
				: 'index'
			;
			$global_nofollow = !empty($wds_options['meta_robots-nofollow-main_blog_archive'])
				? 'nofollow'
				: 'follow'
			;
			$robots = (empty($wds_options['meta_robots-main_blog_archive-subsequent_pages'])) || ($paged > 1 && !empty($wds_options['meta_robots-main_blog_archive-subsequent_pages']))
				? "{$global_noindex},{$global_nofollow}"
				: ''
			;
		} else {
			$taxonomy = ($term && is_object($term)) ? $term->taxonomy : false;
			if (!$taxonomy) {
				// Check for faux taxonomies (author, date)
				if (is_author()) $taxonomy = 'author';
				if (is_date()) $taxonomy = 'date';
			}

			if ('author' === $taxonomy && empty($wds_options['enable-author-archive'])) {
				$robots = 'noindex,follow';
			} else if ('date' === $taxonomy && empty($wds_options['enable-date-archive'])) {
				$robots = 'noindex,follow';
			} else if ($taxonomy) {
				$global_noindex = !empty($wds_options['meta_robots-noindex-' . $taxonomy])
					? $wds_options['meta_robots-noindex-' . $taxonomy]
					: false
				;
				$global_nofollow = !empty($wds_options['meta_robots-nofollow-' . $taxonomy])
					? $wds_options['meta_robots-nofollow-' . $taxonomy]
					: false
				;
				if (empty($wds_options["meta_robots-{$taxonomy}-subsequent_pages"]) || (!empty($wds_options["meta_robots-{$taxonomy}-subsequent_pages"]) && $paged > 1)) {
					$nofollow = $noindex = '';

					$noindex = (bool)$global_noindex;
					$noindex = $noindex
						? (isset($term) && is_object($term) ? !(bool)wds_get_term_meta($term, $taxonomy, 'wds_override_noindex') : $noindex)
						: (isset($term) && is_object($term) ? wds_get_term_meta($term, $taxonomy, 'wds_noindex') : false)
					;
					$nofollow = (bool)$global_nofollow;
					$nofollow = $nofollow
						? (isset($term) && is_object($term) ? !(bool)wds_get_term_meta($term, $taxonomy, 'wds_override_nofollow') : $nofollow)
						: (isset($term) && is_object($term) ? wds_get_term_meta($term, $taxonomy, 'wds_nofollow') : false)
					;
					$robots = join(',', array(
						($noindex ? 'noindex' : 'index'),
						($nofollow ? 'nofollow' : 'follow'),
					));
				}
			}
		}

		// Clean up, index, follow is the default and doesn't need to be in output. All other combinations should be.
		if ($robots == 'index,follow')
			$robots = '';
		if (strpos($robots, 'index,follow,') === 0)
			$robots = str_replace('index,follow,','',$robots);

		foreach (array('noodp','noydir','noarchive','nosnippet') as $robot) {
			if (isset($wds_options[$robot]) && $wds_options[$robot]) {
				if (!empty($robots) && substr($robots, -1) != ',')
					$robots .= ',';
				$robots .= $robot;
			}
		}

		$robots = rtrim($robots,',');
		if ($robots != '' && 1 == (int)get_option('blog_public')) {
			echo '<meta name="robots" content="'.$robots.'"/>'."\n";
		}

	}

	function wds_metadesc() {
		if (is_admin()) return false;

		$metadesc = $this->get_description();

		if (!empty($metadesc)) {
			echo '<meta name="description" content="'.
				esc_attr( strip_tags( stripslashes( apply_filters('wds_metadesc', $metadesc) ) ) )
			.'" />' . "\n";
		}
	}

	/**
	 * Gets a list of keywords for current resolved endpoint
	 *
	 * @param string $location Resolved location to get keywords for
	 * @param WP_Post $post Post context for location
	 *
	 * @return array A list of keywords
	 */
	public function get_keywords ($location=false, $post=false) {
		$resolver = $this->get_resolver();
		$wds_options = WDS_Settings::get_options();

		if (empty($location)) $location = $resolver->get_location();
		if (empty($post)) $post = $resolver->get_context();

		$metakey = '';
		$extra = array();

		if (WDS_Endpoint_Resolver::L_BLOG_HOME === $location && isset($wds_options['keywords-home'])) {
			$metakey = wds_replace_vars($wds_options['keywords-home'], (array) $post );
		} else if (WDS_Endpoint_Resolver::L_WOO_SHOP === $location) {
			$post_id = woocommerce_get_page_id('shop');
			$metakey = wds_get_value('keywords', $post_id);
			$use_tags = wds_get_value('tags_to_keywords', $post_id);
			$metakey = $use_tags ? $this->_tags_to_keywords($metakey) : $metakey;
		} else {
			$metakey = $resolver->is_singular($location) ? wds_get_value('keywords', $post->ID) : false;
			if ($resolver->is_singular($location)) {
				if (wds_get_value('tags_to_keywords', $post->ID)) $extra = array_merge($extra, $this->get_tag_keywords($post));
				$extra = array_merge($extra, $this->get_focus_keywords($post));
			}
		}

		$keywords = array_filter(array_unique(array_merge(
			$this->keywords_string_to_array($metakey),
			$extra
		)));

		return $keywords;
	}

	/**
	 * Gets a list of focus keywords for a given post
	 *
	 * Defaults to currently resolved post if no post given.
	 *
	 * @param WP_Post $post Optional post
	 *
	 * @return array A list of focus keywords
	 */
	public function get_focus_keywords ($post=false) {
		$result = array();
		if (empty($post)) {
			$post = $this->get_resolver()->get_context();
		}
		if (!is_object($post) || !($post instanceof WP_Post)) return $result;

		$request_keywords = $this->get_request_param('wds_focus_keywords');
		$focus_keywords = !empty($request_keywords) ? $request_keywords : wds_get_value('focus-keywords', $post->ID);
		$result = $this->keywords_string_to_array($focus_keywords);

		return $result;
	}

	/**
	 * Gets list of post tags
	 *
	 * Defaults to currently resolved post if no post given.
	 *
	 * @param WP_Post $post Post object instance
	 *
	 * @return array List of tags
	 */
	public function get_tag_keywords ($post=false) {
		$tags = array();
		if (empty($post)) {
			$post = $this->get_resolver()->get_context();
		}
		if (!is_object($post) || !($post instanceof WP_Post)) return $tags;

		$raw_tags = get_the_tags($post->ID);
		if ($raw_tags) foreach($raw_tags as $tag) {
			$tags[] = $tag->name;
		}

		return $tags;
	}

	/**
	 * Converts a comma-separated string of keywords into an array
	 *
	 * @param string $kws Keywords string
	 *
	 * @return array List of keywords
	 */
	public function keywords_string_to_array ($kws) {
		$kw_array = $kws ? explode(',', trim($kws)) : array();
		$kw_array = is_array($kw_array) ? $kw_array : array();
		$kw_array = array_map('trim', $kw_array);

		return array_filter(array_unique($kw_array));
	}

	/**
	* Output meta keywords, if any.
	*/
	function wds_meta_keywords () {
		if (is_admin()) return;

		if (!apply_filters('wds_process_keywords', true)) return false; // Allow optional filtering out

		$keywords = $this->get_keywords();
		if (empty($keywords)) return false;

		echo '<meta name="keywords" content="' . esc_attr(stripslashes(join(',', $keywords))) . '" />'."\n";

		// News keywords
		$resolver = $this->get_resolver();
		$news_meta = $resolver->is_singular() ? stripslashes(wds_get_value('news_keywords')) : false;
		$news_meta = trim(preg_replace('/\s\s+/', ' ', preg_replace('/[^-_,a-z0-9 ]/i', ' ', $news_meta)));
		if ($news_meta) echo '<meta name="news_keywords" content="'. esc_attr($news_meta).'" />'."\n";
	}

	function wds_page_redirect( $input ) {
		global $post;

		if (!apply_filters('wds_process_redirect', true)) return false; // Allow optional filtering out

		if ($post && $redir = wds_get_value('redirect', $post->ID)) {
			wp_redirect( $redir, 301 );
			exit;
		}
	}
}

$wds_onpage = WDS_OnPage::get()->run();