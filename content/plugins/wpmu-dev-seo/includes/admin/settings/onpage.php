<?php

class Smartcrawl_Onpage_Settings extends Smartcrawl_Settings_Admin {

	private static $_instance;

	public static function get_instance() {
		if ( empty( self::$_instance ) ) {
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
	public function validate( $input ) {
		$result = array();

		// Setup
		if ( ! empty( $input['wds_onpage-setup'] ) ) { $result['wds_onpage-setup'] = true; }

		// Meta robots
		if ( ! empty( $input['meta_robots-noindex-main_blog_archive'] ) ) { $result['meta_robots-noindex-main_blog_archive'] = true; }
		if ( ! empty( $input['meta_robots-nofollow-main_blog_archive'] ) ) { $result['meta_robots-nofollow-main_blog_archive'] = true; }
		if ( ! empty( $input['meta_robots-main_blog_archive-subsequent_pages'] ) ) { $result['meta_robots-main_blog_archive-subsequent_pages'] = true; }

		if ( ! empty( $input['meta_robots-noindex-search'] ) ) { $result['meta_robots-noindex-search'] = true; }
		if ( ! empty( $input['meta_robots-nofollow-search'] ) ) { $result['meta_robots-nofollow-search'] = true; }

		$tax_options = $this->_get_tax_options( '' );
		foreach ( $tax_options as $option => $_tax ) {
			$rbts = $this->get_robots_options_for( $option );
			if ( ! empty( $rbts ) && is_array( $rbts ) ) { foreach ( array_keys( $rbts ) as $item ) {
					if ( ! empty( $input[ $item ] ) ) { $result[ $item ] = true; }
			}
			}
		}
		$other_options = $this->_get_other_types_options( '' );
		foreach ( $other_options as $option => $_tax ) {
			$rbts = $this->get_robots_options_for( $option );
			if ( ! empty( $rbts ) && is_array( $rbts ) ) { foreach ( array_keys( $rbts ) as $item ) {
					if ( ! empty( $input[ $item ] ) ) { $result[ $item ] = true; }
			}
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
		foreach ( get_post_types( array( 'public' => true ) ) as $pt ) {
			$strings[] = $pt;
			// Allow post types robots noindex/nofollow
			if ( isset( $input[ "meta_robots-noindex-{$pt}" ] ) ) { $result[ "meta_robots-noindex-{$pt}" ] = true; }
			if ( isset( $input[ "meta_robots-nofollow-{$pt}" ] ) ) { $result[ "meta_robots-nofollow-{$pt}" ] = true; }
		}
		$strings = array_merge( $strings, array_values( $tax_options ) );
		$strings = array_merge( $strings, array_values( $other_options ) );

		foreach ( $strings as $str ) {
			if ( isset( $input[ "title-{$str}" ] ) ) { $result[ "title-{$str}" ] = $this->_sanitize_preserve_macros( $input[ "title-{$str}" ] ); }
			if ( isset( $input[ "metadesc-{$str}" ] ) ) { $result[ "metadesc-{$str}" ] = $this->_sanitize_preserve_macros( $input[ "metadesc-{$str}" ] ); }
			if ( isset( $input[ "metakeywords-{$str}" ] ) ) { $result[ "metakeywords-{$str}" ] = $this->_sanitize_preserve_macros( $input[ "metakeywords-{$str}" ] ); }

			// OpenGraph
			if ( isset( $input[ "og-active-{$str}" ] ) ) {
				$result[ "og-active-{$str}" ] = (boolean) $input[ "og-active-{$str}" ];
			}
			if ( isset( $input[ "og-title-{$str}" ] ) ) {
				$result[ "og-title-{$str}" ] = $this->_sanitize_preserve_macros( $input[ "og-title-{$str}" ] );
			}
			if ( isset( $input[ "og-description-{$str}" ] ) ) {
				$result[ "og-description-{$str}" ] = $this->_sanitize_preserve_macros( $input[ "og-description-{$str}" ] );
			}

			$result[ "og-images-{$str}" ] = array();
			if ( ! empty( $input[ "og-images-{$str}" ] ) && is_array( $input[ "og-images-{$str}" ] ) ) {
				foreach ( $input[ "og-images-{$str}" ] as $img ) {
					$result[ "og-images-{$str}" ][] = esc_url( $img );
				}
			}
			$result[ "og-images-{$str}" ] = array_values( array_filter( array_unique( $result[ "og-images-{$str}" ] ) ) );
		}

		// Special case handling for home page keywords
		// because the legacy one doesn't follow the naming convention
		if ( isset( $input['keywords-home'] ) ) {
			$result['keywords-home'] = $this->_sanitize_preserve_macros( $input['keywords-home'] );
		}

		$result['enable-author-archive'] = isset( $input['enable-author-archive'] )
			? (boolean) $input['enable-author-archive']
			: false
		;
		$result['enable-date-archive'] = isset( $input['enable-date-archive'] )
			? (boolean) $input['enable-date-archive']
			: false
		;

		if ( isset( $input['preset-separator'] ) ) {
			$result['preset-separator'] = sanitize_text_field( $input['preset-separator'] );
		}

		if ( isset( $input['separator'] ) ) {
			$result['separator'] = sanitize_text_field( $input['separator'] );
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
	private function _sanitize_preserve_macros( $str ) {
		if ( empty( $str ) ) { return $str; }

		$rpl = '__SMARTCRAWL_MACRO_QUOTES_REPLACEMENT__';
		$str = preg_replace( '/%%/', $rpl, $str );

		$str = sanitize_text_field( $str );

		$str = preg_replace( '/' . preg_quote( $rpl, '/' ) . '/', '%%', $str );

		return $str;
	}

	public function init() {
		$this->option_name     = 'wds_onpage_options';
		$this->name            = Smartcrawl_Settings::COMP_ONPAGE;
		$this->slug            = Smartcrawl_Settings::TAB_ONPAGE;
		$this->action_url      = admin_url( 'options.php' );
		$this->title           = __( 'Title & Meta', 'wds' );
		$this->page_title      = __( 'SmartCrawl Wizard: Title & Meta', 'wds' );

		add_action( 'wp_ajax_wds-onpage-preview', array( $this, 'json_create_preview' ) );

		parent::init();

	}

	/**
	 * Preview building handler
	 */
	public function json_create_preview() {
		$data = stripslashes_deep( $_POST );

		$src_type = ! empty( $data['type'] ) ? sanitize_text_field( $data['type'] ) : false;
		$src_title = ! empty( $data['title'] ) ? $this->_sanitize_preserve_macros( $data['title'] ) : false;
		$src_meta = ! empty( $data['description'] ) ? $this->_sanitize_preserve_macros( $data['description'] ) : false;

		$updated = false;

		$link = home_url();
		$title = get_bloginfo( 'name' );
		$description = get_bloginfo( 'description' );

		$warnings = array();

		switch ( $src_type ) {
			case 'search-page':
				set_query_var( 's', 'Example search phrase' );
			case 'author-archive':
				set_query_var( 'author', get_current_user_id() );
			case 'date-archive':
			case 'homepage':
			case '404-page':
				$title = smartcrawl_replace_vars( $src_title );
				$description = smartcrawl_replace_vars( $src_meta );
				$updated = true;

				if ( strlen( $title ) > SMARTCRAWL_TITLE_LENGTH_CHAR_COUNT_LIMIT ) {
					$warnings['title'] = __( 'Your title seems to be a bit on the long side, consider trimming it', 'wds' );
				}
				if ( strlen( $description ) > SMARTCRAWL_METADESC_LENGTH_CHAR_COUNT_LIMIT ) {
					$warnings['description'] = __( 'Your description seems to be a bit on the long side, consider trimming it', 'wds' );
				}
				break;

			case 'bp-group':
				$group = $this->_get_random_bp_group();
				if ( ! empty( $group ) ) {
					$title = smartcrawl_replace_vars( $src_title, (array) $group );
					$description = smartcrawl_replace_vars( $src_meta, (array) $group );
					$link = bp_get_group_permalink( $group );
				}
				$updated = true;
				break;

			case 'bp-profile':
				$bp_profile_args = array(
					'full_name' => bp_get_loggedin_user_fullname(),
					'username' => bp_get_loggedin_user_username(),
				);

				$title = smartcrawl_replace_vars( $src_title, $bp_profile_args );
				$description = smartcrawl_replace_vars( $src_meta, $bp_profile_args );
				$link = bp_loggedin_user_domain();
				$updated = true;
				break;
		}

		// Custom post type?
		if ( ! $updated ) {
			foreach ( get_post_types( array( 'public' => true ) ) as $type ) {
				if ( $type !== $src_type ) {
					continue;
				}

				$updated = true;
				$post = $this->_get_random_post( $type );
				if ( ! empty( $post ) ) {
					$title = smartcrawl_replace_vars( $src_title, $post );
					$description = smartcrawl_replace_vars( $src_meta, $post );
					$link = get_permalink( $post['ID'] );
				}
			}
		}

		// Custom taxonomy?
		if ( ! $updated ) {
			foreach ( get_taxonomies() as $tax ) {
				if ( $tax !== $src_type ) {
					continue;
				}

				$updated = true;
				$term = $this->_get_random_term( $tax );
				if ( ! empty( $term ) ) {
					$title = smartcrawl_replace_vars( $src_title, $term );
					$description = smartcrawl_replace_vars( $src_meta, $term );
					$link = get_term_link( $term['term_id'], $tax );
				}
			}
		}

		wp_send_json(array(
			'status' => $updated,
			'markup' => $this->_load('onpage/onpage-preview', array(
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
	private function _get_random_post( $type = 'post' ) {
		$args = array(
			'posts_per_page' => 1,
			'post_type' => $type,
			'orderby' => 'random',
		);
		if ( 'attachment' === $type ) {
			$args['post_status'] = 'any';
		}
		$q = new WP_Query( $args );
		return ! empty( $q->post )
			? (array) $q->post
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
	private function _get_random_term( $type = 'category' ) {
		$terms = get_terms(
			array(
				'taxonomy'   => $type,
				'hide_empty' => 0,
			)
		);
		if ( empty( $terms ) ) {
			return array();
		}

		shuffle( $terms );
		return (array) $terms[0];
	}

	/**
	 * Returns a set of known macros, as macro => description pairs
	 *
	 * @return array List of known macros
	 */
	public static function get_macros() {
		$macros = array(
			'%%sep%%'                  => __( 'Separator', 'wds' ),
			'%%date%%'                 => __( 'Date of the post/page', 'wds' ),
			'%%title%%'                => __( 'Title of the post/page', 'wds' ),
			'%%sitename%%'             => __( 'Site\'s name', 'wds' ),
			'%%sitedesc%%'             => __( 'Site\'s tagline / description', 'wds' ),
			'%%excerpt%%'              => __( 'Post/page excerpt (or auto-generated if it does not exist)', 'wds' ),
			'%%excerpt_only%%'         => __( 'Post/page excerpt (without auto-generation)', 'wds' ),
			'%%tag%%'                  => __( 'Current tag/tags', 'wds' ),
			'%%category%%'             => __( 'Post categories (comma separated)', 'wds' ),
			'%%category_description%%' => __( 'Category description', 'wds' ),
			'%%tag_description%%'      => __( 'Tag description', 'wds' ),
			'%%term_description%%'     => __( 'Term description', 'wds' ),
			'%%term_title%%'           => __( 'Term name', 'wds' ),
			'%%modified%%'             => __( 'Post/page modified time', 'wds' ),
			'%%id%%'                   => __( 'Post/page ID', 'wds' ),
			'%%name%%'                 => __( 'Post/page author\'s \'nicename\'', 'wds' ),
			'%%userid%%'               => __( 'Post/page author\'s userid', 'wds' ),
			'%%searchphrase%%'         => __( 'Current search phrase', 'wds' ),
			'%%currenttime%%'          => __( 'Current time', 'wds' ),
			'%%currentdate%%'          => __( 'Current date', 'wds' ),
			'%%currentmonth%%'         => __( 'Current month', 'wds' ),
			'%%currentyear%%'          => __( 'Current year', 'wds' ),
			'%%page%%'                 => __( 'Current page number (i.e. page 2 of 4)', 'wds' ),
			'%%pagetotal%%'            => __( 'Current page total', 'wds' ),
			'%%pagenumber%%'           => __( 'Current page number', 'wds' ),
			'%%caption%%'              => __( 'Attachment caption', 'wds' ),
			'%%spell_pagenumber%%'     => __( 'Current page number, spelled out as numeral in English', 'wds' ),
			'%%spell_pagetotal%%'      => __( 'Current page total, spelled out as numeral in English', 'wds' ),
			'%%spell_page%%'           => __( 'Current page number, spelled out as numeral in English', 'wds' ),
		);

		if ( defined( 'BP_VERSION' ) ) {
			$macros['%%bp_group_name%%'] = __( 'BuddyPress group name', 'wds' );
			$macros['%%bp_group_description%%'] = __( 'BuddyPress group description', 'wds' );
			$macros['%%bp_user_username%%'] = __( 'BuddyPress username', 'wds' );
			$macros['%%bp_user_full_name%%'] = __( "BuddyPress user's full name", 'wds' );
		}

		return $macros;
	}

	/**
	 * Spawns a set of robots options for a given type
	 *
	 * @param string $type Archives type to generate the robots options for
	 * @param bool   $include_subsequent_pages_option Whether to include the subsequent pages option.
	 *
	 * @return array Generated meta robots option array
	 */
	public static function get_robots_options_for( $type, $include_subsequent_pages_option = true ) {
		$options = array(
			"meta_robots-noindex-{$type}"          => array(
				'label'       => __( 'Noindex', 'wds' ),
				'description' => __( 'Disabling indexing means that this content will not be indexed and searchable in search engines.', 'wds' ),
			),
			"meta_robots-nofollow-{$type}"         => array(
				'label'       => __( 'Nofollow', 'wds' ),
				'description' => __( 'Disabling following means search engines will not follow and crawl links it finds in this content.', 'wds' ),
			),
		);

		if ( $include_subsequent_pages_option ) {
			$options[ "meta_robots-{$type}-subsequent_pages" ] = array(
				'label'       => __( 'Apply to all pages except the first', 'wds' ),
				'description' => __( 'If you select this option, the first page will be left alone, but the indexing settings will be applied to subsequent pages.', 'wds' ),
			);
		}

		return $options;
	}

	/**
	 * Spawn taxonomy options and names, indexed by taxonomy option names
	 *
	 * @param string $pfx Prefix options with this
	 *
	 * @return array
	 */
	protected function _get_tax_options( $pfx = '' ) {
		$pfx = ! empty( $pfx ) ? rtrim( $pfx, '_' ) . '_' : $pfx;
		$opts = array();
		foreach ( get_taxonomies( array( '_builtin' => false ), 'objects' ) as $taxonomy ) {
			$name = $pfx . str_replace( '-', '_', $taxonomy->name );
			$opts[ $name ] = $taxonomy->name;
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
	protected function _get_other_types_options( $pfx = '' ) {
		$pfx = ! empty( $pfx ) ? rtrim( $pfx, '_' ) . '_' : $pfx;
		$opts = array();
		$other_types = array(
			'category',
			'post_tag',
			'author',
			'date',
		);
		foreach ( $other_types as $value ) {
			$name = $pfx . $value;
			$opts[ $name ] = $value;
		}
		return $opts;
	}

	/**
	 * Add admin settings page
	 */
	public function options_page() {
		parent::options_page();

		$smartcrawl_options = Smartcrawl_Settings::get_options();

		$arguments = array(
			'macros' => self::get_macros(),
			'meta_robots_main_blog_archive' => self::get_robots_options_for( 'main_blog_archive' ),
		);

		foreach ( $this->_get_tax_options( 'meta_robots_' ) as $option => $tax ) {
			$tax = str_replace( '-', '_', $tax );
			if ( empty( $arguments[ $option ] ) ) { $arguments[ $option ] = self::get_robots_options_for( $tax ); }
		}

		foreach ( $this->_get_other_types_options( 'meta_robots_' ) as $option => $value ) {
			if ( empty( $arguments[ $option ] ) ) { $arguments[ $option ] = self::get_robots_options_for( $value ); }
		}

		$arguments['meta_robots_search'] = self::get_robots_options_for( 'search', false );

		// Allow for post type options
		$arguments['post_robots'] = array(
			'attachment' => self::get_robots_options_for( 'attachment', false ),
		);

		$arguments['radio_options'] = array(
			__( 'No', 'wds' ),
			__( 'Yes', 'wds' ),
		);

		$arguments['engines'] = array(
			'ping-google' => __( 'Google', 'wds' ),
			'ping-bing' => __( 'Bing', 'wds' ),
		);

		$arguments['separators'] = smartcrawl_get_separators();

		$arguments['show_homepage_options'] = $this->_show_homepage_options();
		$arguments['homepage_title'] = $this->_get_homepage_title( $smartcrawl_options );
		$arguments['homepage_description'] = $this->_get_homepage_description( $smartcrawl_options );

		$arguments['active_tab'] = $this->_get_last_active_tab( 'tab_homepage' );

		wp_enqueue_script( 'wds-admin-onpage' );
		$this->_render_page( 'onpage/onpage-settings', $arguments );
	}

	/**
	 * Default settings
	 */
	public function defaults() {

		if ( is_multisite() && SMARTCRAWL_SITEWIDE ) {
			$this->options = get_site_option( $this->option_name );
		} else {
			$this->options = get_option( $this->option_name );
		}

		if ( empty( $this->options['title-home'] ) ) {
			$this->options['title-home'] = '%%sitename%%';
		}

		if ( empty( $this->options['metadesc-home'] ) ) {
			$this->options['metadesc-home'] = '%%sitedesc%%';
		}

		if ( empty( $this->options['keywords-home'] ) ) {
			$this->options['keywords-home'] = '';
		}

		if ( empty( $this->options['onpage-stylesheet'] ) ) {
			$this->options['onpage-stylesheet'] = 0;
		}

		if ( empty( $this->options['onpage-dashboard-widget'] ) ) {
			$this->options['onpage-dashboard-widget'] = 1;
		}

		if ( empty( $this->options['onpage-disable-automatic-regeneration'] ) ) {
			$this->options['onpage-disable-automatic-regeneration'] = 0;
		}

		foreach ( get_post_types( array( 'public' => true ) ) as $posttype ) {
			if ( in_array( $posttype, array( 'revision', 'nav_menu_item' ) ) ) { continue; }
			if ( preg_match( '/^upfront_/', $posttype ) ) { continue; }

			$type_obj = get_post_type_object( $posttype );
			if ( ! is_object( $type_obj ) ) { continue; }

			if ( empty( $this->options[ 'title-' . $posttype ] ) ) {
				$this->options[ 'title-' . $posttype ] = '%%title%% %%sep%% %%sitename%%';
			}

			if ( empty( $this->options[ 'metadesc-' . $posttype ] ) ) {
				$this->options[ 'metadesc-' . $posttype ] = '%%excerpt%%';
			}
		}

		foreach ( get_taxonomies( array( '_builtin' => false ), 'objects' ) as $taxonomy ) {
			if ( empty( $this->options[ 'title-' . $taxonomy->name ] ) ) {
				$this->options[ 'title-' . $taxonomy->name ] = '';
			}

			if ( empty( $this->options[ 'metadesc-' . $taxonomy->name ] ) ) {
				$this->options[ 'metadesc-' . $taxonomy->name ] = '';
			}
		}

		$other_types = array(
			'category'                  => array( 'title' => '%%category%% %%sep%% %%sitename%%', 'desc' => '%%category_description%%' ),
			'post_tag'                  => array( 'title' => '%%tag%% %%sep%% %%sitename%%', 'desc' => '%%tag_description%%' ),
			'author'                    => array( 'title' => '%%name%% %%sep%% %%sitename%%', 'desc' => '' ),
			'date'                      => array( 'title' => '%%currentdate%% %%sep%% %%sitename%%', 'desc' => '' ),
			'search'                    => array( 'title' => '%%searchphrase%% %%sep%% %%sitename%%', 'desc' => '' ),
			'404'                       => array( 'title' => 'Page not found %%sep%% %%sitename%%', 'desc' => '' ),
			'bp_groups'                 => array( 'title' => '%%bp_group_name%% %%sep%% %%sitename%%', 'desc' => '%%bp_group_description%%' ),
			'bp_profile'                => array( 'title' => '%%bp_user_username%% %%sep%% %%sitename%%', 'desc' => '%%bp_user_full_name%%' ),
			'mp_marketplace-base'       => array( 'title' => '', 'desc' => '' ),
			'mp_marketplace-categories' => array( 'title' => '', 'desc' => '' ),
			'mp_marketplace-tags'       => array( 'title' => '', 'desc' => '' ),
		);

		foreach ( $other_types as $key => $value ) {
			if ( empty( $this->options[ 'title-' . $key ] ) ) {
				$this->options[ 'title-' . $key ] = $value['title'];
			}

			if ( empty( $this->options[ 'metadesc-' . $key ] ) ) {
				$this->options[ 'metadesc-' . $key ] = $value['desc'];
			}
		}

		if ( ! isset( $this->options['preset-separator'] ) ) {
			$this->options['preset-separator'] = 'pipe';
		}

		if ( ! isset( $this->options['separator'] ) ) {
			$this->options['separator'] = '';
		}

		if ( ! isset( $this->options['enable-author-archive'] ) ) {
			$this->options['enable-author-archive'] = true;
		}

		if ( ! isset( $this->options['enable-date-archive'] ) ) {
			$this->options['enable-date-archive'] = true;
		}

		if ( is_multisite() && SMARTCRAWL_SITEWIDE ) {
			update_site_option( $this->option_name, $this->options );
		} else {
			update_option( $this->option_name, $this->options );
		}

	}

	private function _show_homepage_options() {
		if ( is_multisite() ) {
			$show_homepage_options = SMARTCRAWL_SITEWIDE || 'posts' == get_site_option( 'show_on_front' );
		} else {
			$show_homepage_options = 'posts' == get_option( 'show_on_front' );
		}

		return $show_homepage_options;
	}

	private function _get_homepage_title( $options ) {
		$front_page_id = (int) get_option( 'page_on_front' );

		if ( ! $this->_show_homepage_options() && $front_page_id ) {

			$homepage_title = smartcrawl_get_value( 'title', $front_page_id );
			if ( empty( $homepage_title ) ) {
				$front_page = get_post( $front_page_id );
				$homepage_title = $front_page->post_title;
			}

			return $homepage_title;
		} else {
			return $options['title-home'];
		}
	}

	private function _get_homepage_description( $options ) {
		$front_page_id = (int) get_option( 'page_on_front' );

		if ( ! $this->_show_homepage_options() && $front_page_id ) {
			$homepage_description = smartcrawl_get_value( 'metadesc', $front_page_id );
			if ( empty( $homepage_description ) ) {
				$front_page = get_post( $front_page_id );
				$homepage_description = substr( strip_tags( $front_page->post_content ), 0, 130 );
			}

			return $homepage_description;
		} else {
			return $options['metadesc-home'];
		}
	}

	private function _get_random_bp_group() {
		$groups = groups_get_groups(array(
			'orderby'  => 'random',
			'per_page' => 1,
		));

		$total = isset( $groups['total'] ) ? $groups['total'] : 0;
		$groups = isset( $groups['groups'] ) ? $groups['groups'] : array();

		return $total > 0 ? $groups[0] : null;
	}
}
