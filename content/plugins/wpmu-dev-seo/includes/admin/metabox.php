<?php
/**
 * Metabox main class
 *
 * @package wpmu-dev-seo
 */

/**
 * Metabox rendering / handling class
 */
class Smartcrawl_Metabox extends Smartcrawl_Renderable {

	/**
	 * Static instance
	 *
	 * @var Smartcrawl_Metabox
	 */
	private static $_instance;

	/**
	 * State flag
	 *
	 * @var bool
	 */
	private $_is_running = false;

	/**
	 * Constructor
	 */
	public function __construct() {
	}

	/**
	 * Boot the hooking part
	 */
	public static function run() {
		self::get()->_add_hooks();
	}

	public function _add_hooks() {
		if ( $this->_is_running ) {
			return false;
		}

		// WPSC integration.
		add_action( 'wpsc_edit_product', array( $this, 'rebuild_sitemap' ) );
		add_action( 'wpsc_rate_product', array( $this, 'rebuild_sitemap' ) );

		add_action( 'admin_menu', array( $this, 'smartcrawl_create_meta_box' ) );

		add_action( 'save_post', array( $this, 'smartcrawl_save_postdata' ) );
		add_filter( 'attachment_fields_to_save', array( $this, 'smartcrawl_save_attachment_postdata' ) );

		add_filter( 'manage_pages_columns', array( $this, 'smartcrawl_page_title_column_heading' ), 10, 1 );
		add_filter( 'manage_posts_columns', array( $this, 'smartcrawl_page_title_column_heading' ), 10, 1 );

		add_action( 'manage_pages_custom_column', array( $this, 'smartcrawl_page_title_column_content' ), 10, 2 );
		add_action( 'manage_posts_custom_column', array( $this, 'smartcrawl_page_title_column_content' ), 10, 2 );

		add_action( 'quick_edit_custom_box', array( $this, 'smartcrawl_quick_edit_dispatch' ), 10, 2 );
		add_action( 'admin_footer-edit.php', array( $this, 'smartcrawl_quick_edit_javascript' ) );
		add_action( 'wp_ajax_wds_get_meta_fields', array( $this, 'json_wds_postmeta' ) );
		add_action( 'wp_ajax_wds_metabox_update', array( $this, 'smartcrawl_metabox_live_update' ) );

		add_action( 'admin_print_scripts-post.php', array( $this, 'js_load_scripts' ) );
		add_action( 'admin_print_scripts-post-new.php', array( $this, 'js_load_scripts' ) );
		add_action( 'wp_ajax_wds-metabox-preview', array( $this, 'json_create_preview' ) );

		$this->_is_running = true;
	}

	/**
	 * Static instance getter
	 */
	public static function get() {
		if ( empty( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Handles preview asking requests
	 */
	public function json_create_preview() {
		$data = $this->get_request_data();
		$title = sanitize_text_field( smartcrawl_get_array_value( $data, 'title' ) );
		$description = sanitize_text_field( smartcrawl_get_array_value( $data, 'description' ) );
		$post_id = (int) smartcrawl_get_array_value( $data, 'post_id' );
		$result = array( 'success' => false );

		if ( is_null( $title ) || is_null( $description ) || empty( $post_id ) ) {
			wp_send_json( $result );

			return;
		}

		$latest_post_version = smartcrawl_get_latest_post_version( $post_id );
		$result['success'] = true;
		$result['markup'] = $this->_load( 'metabox/metabox-preview', array(
			'post'        => $latest_post_version,
			'title'       => $title,
			'description' => $description,
		) );

		wp_send_json( $result );
	}

	/**
	 * Enqueues frontend dependencies
	 */
	public function js_load_scripts() {
		$options = Smartcrawl_Settings::get_options();
		$version = Smartcrawl_Loader::get_version();

		wp_enqueue_script( 'wds_metabox_counter', SMARTCRAWL_PLUGIN_URL . '/js/wds-metabox-counter.js', array(), $version );
		wp_localize_script( 'wds_metabox_counter', 'l10nWdsCounters', array(
			'title_length'      => __( '{TOTAL_LEFT} characters left', 'wds' ),
			'title_longer'      => __( 'Over {MAX_COUNT} characters ({CURRENT_COUNT})', 'wds' ),
			'main_title_longer' => __( 'Over {MAX_COUNT} characters ({CURRENT_COUNT}) - make sure your SEO title is shorter', 'wds' ),

			'title_limit'        => SMARTCRAWL_TITLE_LENGTH_CHAR_COUNT_LIMIT,
			'metad_limit'        => SMARTCRAWL_METADESC_LENGTH_CHAR_COUNT_LIMIT,
			'main_title_warning' => ! ( defined( 'SMARTCRAWL_MAIN_TITLE_LENGTH_WARNING_HIDE' ) && SMARTCRAWL_MAIN_TITLE_LENGTH_WARNING_HIDE ),
			'lax_enforcement'    => ( isset( $options['metabox-lax_enforcement'] ) ? ! ! $options['metabox-lax_enforcement'] : false ),
		) );
		Smartcrawl_Settings_Admin::register_global_admin_scripts();
		wp_enqueue_script( 'wds_metabox_onpage', SMARTCRAWL_PLUGIN_URL . '/js/wds-metabox.js', array( 'wds-select2' ), $version );
		wp_localize_script( 'wds_metabox_onpage', '_wds_metabox', array(
			'nonce' => wp_create_nonce( 'wds-metabox-nonce' ),
		) );
		wp_localize_script( 'wds_metabox_onpage', 'l10nWdsMetabox', array(
			'content_analysis_working' => __( 'Analyzing content, please wait a few moments', 'wds' ),
		) );

		Smartcrawl_Settings_Admin::enqueue_shared_ui( false );

		wp_enqueue_script( 'wds-admin-opengraph' );
		wp_enqueue_style( 'wds-admin-opengraph' );
		wp_enqueue_style( 'wds-select2' );
		wp_enqueue_style( 'wds-app' );
	}

	/**
	 * Handles page body class
	 *
	 * @param string $string Body classes this far.
	 *
	 * @return string
	 */
	public function admin_body_class( $string ) {
		return str_replace( 'wpmud', '', $string );
	}

	/**
	 * Handles actual metabox rendering
	 */
	public function smartcrawl_meta_boxes() {
		global $post;

		$robots_noindex_value = (int) smartcrawl_get_value( 'meta-robots-noindex' );
		$robots_nofollow_value = (int) smartcrawl_get_value( 'meta-robots-nofollow' );
		$robots_index_value = (int) smartcrawl_get_value( 'meta-robots-index' );
		$robots_follow_value = (int) smartcrawl_get_value( 'meta-robots-follow' );
		$advanced_value = explode( ',', smartcrawl_get_value( 'meta-robots-adv' ) );
		$advanced_options = array(
			'noodp'     => __( 'NO ODP (Block Open Directory Project description of the page)', 'wds' ),
			'noydir'    => __( 'NO YDIR (Don\'t display the Yahoo! Directory titles and abstracts)', 'wds' ),
			'noarchive' => __( 'No Archive', 'wds' ),
			'nosnippet' => __( 'No Snippet', 'wds' ),
		);
		$sitemap_priority_options = array(
			''    => __( 'Automatic prioritization', 'wds' ),
			'1'   => __( '1 - Highest priority', 'wds' ),
			'0.9' => '0.9',
			'0.8' => '0.8 - ' . __( 'High priority (root pages default)', 'wds' ),
			'0.7' => '0.7',
			'0.6' => '0.6 - ' . __( 'Secondary priority (subpages default)', 'wds' ),
			'0.5' => '0.5 - ' . __( 'Medium priority', 'wds' ),
			'0.4' => '0.4',
			'0.3' => '0.3',
			'0.2' => '0.2',
			'0.1' => '0.1 - ' . __( 'Lowest priority', 'wds' ),
		);

		$this->_render( 'metabox/metabox-main', array(
			'post'                     => $post,
			'robots_noindex_value'     => $robots_noindex_value,
			'robots_nofollow_value'    => $robots_nofollow_value,
			'robots_index_value'       => $robots_index_value,
			'robots_follow_value'      => $robots_follow_value,
			'advanced_value'           => $advanced_value,
			'advanced_options'         => $advanced_options,
			'sitemap_priority_options' => $sitemap_priority_options,
		) );
	}

	/**
	 * Adds the metabox to the queue
	 */
	public function smartcrawl_create_meta_box() {
		$show = user_can_see_seo_metabox();
		if ( function_exists( 'add_meta_box' ) ) {
			$metabox_title = is_multisite() ? __( 'SmartCrawl', 'wds' ) : 'SmartCrawl'; // Show branding for singular installs.
			foreach ( get_post_types() as $posttype ) {
				if ( $show ) {
					add_meta_box( 'wds-wds-meta-box', $metabox_title, array(
						&$this,
						'smartcrawl_meta_boxes',
					), $posttype, 'normal', 'high' );
				}
			}
		}
	}

	/**
	 * Handles attachment metadata saving
	 *
	 * @param array $data Data to save.
	 *
	 * @return array
	 */
	public function smartcrawl_save_attachment_postdata( $data ) {
		$request_data = $this->get_request_data();
		if ( empty( $request_data ) || empty( $data['post_ID'] ) || ! is_numeric( $data['post_ID'] ) ) {
			return $data;
		}
		$this->smartcrawl_save_postdata( (int) $data['post_ID'] );

		return $data;
	}

	private function get_post() {
		global $post;

		return $post;
	}

	/**
	 * Saves submitted metabox POST data
	 *
	 * @param int $post_id Post ID.
	 *
	 * @return bool
	 */
	public function smartcrawl_save_postdata( $post_id ) {
		$request_data = $this->get_request_data();
		if ( ! $post_id || empty( $request_data ) ) {
			return;
		}

		$post = $this->get_post();
		if ( empty( $post ) ) {
			$post = get_post( $post_id );
		}

		$all_options = Smartcrawl_Settings::get_options();
		$post_type_noindexed = (bool) smartcrawl_get_array_value( $all_options, sprintf( 'meta_robots-noindex-%s', get_post_type( $post ) ) );
		$post_type_nofollowed = (bool) smartcrawl_get_array_value( $all_options, sprintf( 'meta_robots-nofollow-%s', get_post_type( $post ) ) );

		// Determine posted type.
		$post_type_rq = ! empty( $request_data['post_type'] ) ? sanitize_key( $request_data['post_type'] ) : false;
		if ( 'page' === $post_type_rq && ! current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		} elseif ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		$ptype = ! empty( $post_type_rq )
			? $post_type_rq
			: ( ! empty( $post->post_type ) ? $post->post_type : false );
		// Do not process post stuff for non-public post types.
		if ( ! in_array( $ptype, get_post_types( array( 'public' => true ) ), true ) ) {
			return $post_id;
		}

		if ( ! empty( $request_data['wds-opengraph'] ) ) {
			$input = stripslashes_deep( $request_data['wds-opengraph'] );
			$result = array();

			$result['disabled'] = ! empty( $input['disabled'] );
			if ( ! empty( $input['title'] ) ) {
				$result['title'] = sanitize_text_field( $input['title'] );
			}
			if ( ! empty( $input['description'] ) ) {
				$result['description'] = sanitize_text_field( $input['description'] );
			}
			if ( ! empty( $input['images'] ) && is_array( $input['images'] ) ) {
				$result['images'] = array();
				foreach ( $input['images'] as $img ) {
					$img = esc_url_raw( $img );
					$result['images'][] = $img;
				}
			}

			if ( ! empty( $result ) ) {
				update_post_meta( $post_id, '_wds_opengraph', $result );
			}
		}

		if ( ! empty( $request_data['wds-twitter'] ) ) {
			$input = stripslashes_deep( $request_data['wds-twitter'] );
			$twitter = array();

			$twitter['disabled'] = ! empty( $input['disabled'] );
			if ( ! empty( $input['title'] ) ) {
				$twitter['title'] = sanitize_text_field( $input['title'] );
			}
			if ( ! empty( $input['description'] ) ) {
				$twitter['description'] = sanitize_text_field( $input['description'] );
			}
			if ( ! empty( $input['images'] ) && is_array( $input['images'] ) ) {
				$twitter['images'] = array();
				foreach ( $input['images'] as $img ) {
					$img = esc_url_raw( $img );
					$twitter['images'][] = $img;
				}
			}

			if ( ! empty( $twitter ) ) {
				update_post_meta( $post_id, '_wds_twitter', $twitter );
			}
		}

		if ( isset( $request_data['wds_focus'] ) ) {
			$focus = stripslashes_deep( $request_data['wds_focus'] );
			update_post_meta( $post_id, '_wds_focus-keywords', sanitize_text_field( $focus ) );
		}

		foreach ( $request_data as $key => $value ) {
			if ( in_array( $key, array( 'wds-opengraph', 'wds_focus', 'wds-twitter' ), true ) ) {
				continue;
			} // We already handled those.
			if ( ! preg_match( '/^wds_/', $key ) ) {
				continue;
			}

			$id = "_{$key}";
			$data = $value;
			if ( is_array( $value ) ) {
				$data = join( ',', $value );
			}

			if ( $data ) {
				$value = in_array( $key, array( 'wds_canonical', 'wds_redirect' ), true )
					? esc_url_raw( $data )
					: sanitize_text_field( $data );
				update_post_meta( $post_id, $id, $value );
			} else {
				delete_post_meta( $post_id, $id );
			}
		}

		/**
		 * If the user un-checks a checkbox and saves the post, the value for that checkbox will not be included inside $_POST array
		 * so we may have to delete the corresponding meta value manually.
		 */
		$checkbox_meta_items = array(
			'wds_tags_to_keywords',
			'wds_meta-robots-adv',
			'wds_autolinks-exclude',
		);
		$checkbox_meta_items[] = $post_type_nofollowed ? 'wds_meta-robots-follow' : 'wds_meta-robots-nofollow';
		$checkbox_meta_items[] = $post_type_noindexed ? 'wds_meta-robots-index' : 'wds_meta-robots-noindex';
		foreach ( $checkbox_meta_items as $item ) {
			if ( ! isset( $request_data[ $item ] ) ) {
				delete_post_meta( $post_id, "_{$item}" );
			}
		}

		do_action( 'wds_saved_postdata' );
	}

	/**
	 * Handles sitemap rebuilding
	 */
	public function rebuild_sitemap() {
		Smartcrawl_Xml_Sitemap::get()->generate_sitemap();
	}

	/**
	 * Adds title and robots columns to post listing page
	 *
	 * @param array $columns Post list columns.
	 *
	 * @return array
	 */
	public function smartcrawl_page_title_column_heading( $columns ) {
		return array_merge(
			array_slice( $columns, 0, 2 ),
			array( 'page-title' => __( 'Title Tag', 'wds' ) ),
			array_slice( $columns, 2, 6 ),
			array( 'page-meta-robots' => __( 'Robots Meta', 'wds' ) )
		);
	}

	/**
	 * Puts out actual column bodies
	 *
	 * @param string $column_name Column ID.
	 * @param int $id Post ID.
	 *
	 * @return void
	 */
	public function smartcrawl_page_title_column_content( $column_name, $id ) {
		if ( 'page-title' === $column_name ) {
			echo esc_html( $this->smartcrawl_page_title( $id ) );

			// Show any 301 redirects.
			$redirect = smartcrawl_get_value( 'redirect', $id );
			if ( ! empty( $redirect ) ) {
				$href = $redirect;
				$link = "<a href='{$href}' target='_blank'>{$href}</a>";
				echo '<br /><em>' . sprintf( esc_html( __( 'Redirects to %s', 'wds' ) ), esc_url( $href ) ) . '</em>';
			}
		}

		if ( 'page-meta-robots' === $column_name ) {
			$meta_robots_arr = array(
				( smartcrawl_get_value( 'meta-robots-noindex', $id ) ? 'noindex' : 'index' ),
				( smartcrawl_get_value( 'meta-robots-nofollow', $id ) ? 'nofollow' : 'follow' ),
			);
			$meta_robots = join( ',', $meta_robots_arr );
			if ( empty( $meta_robots ) ) {
				$meta_robots = 'index,follow';
			}
			echo esc_html( ucwords( str_replace( ',', ', ', $meta_robots ) ) );

			// Show additional robots data.
			$advanced = array_filter( array_map( 'trim', explode( ',', smartcrawl_get_value( 'meta-robots-adv', $id ) ) ) );
			if ( ! empty( $advanced ) && 'none' !== $advanced ) {
				$adv_map = array(
					'noodp'     => __( 'No ODP', 'wds' ),
					'noydir'    => __( 'No YDIR', 'wds' ),
					'noarchive' => __( 'No Archive', 'wds' ),
					'nosnippet' => __( 'No Snippet', 'wds' ),
				);
				$additional = array();
				foreach ( $advanced as $key ) {
					if ( ! empty( $adv_map[ $key ] ) ) {
						$additional[] = $adv_map[ $key ];
					}
				}
				if ( ! empty( $additional ) ) {
					echo '<br /><small>' . esc_html( join( ', ', $additional ) ) . '</small>';
				}
			}
		}
	}

	/**
	 * Gets SEO title (with expanded macro replacements)
	 *
	 * @param int $postid Post ID.
	 *
	 * @return string
	 */
	public function smartcrawl_page_title( $postid ) {
		$post = get_post( $postid );
		$fixed_title = smartcrawl_get_value( 'title', $post->ID );
		if ( $fixed_title ) {
			return smartcrawl_replace_vars( $fixed_title, (array) $post );
		} else {
			$smartcrawl_options = Smartcrawl_Settings::get_options();
			if ( ! empty( $smartcrawl_options[ 'title-' . $post->post_type ] ) ) {
				return smartcrawl_replace_vars( $smartcrawl_options[ 'title-' . $post->post_type ], (array) $post );
			} else {
				return '';
			}
		}
	}

	/**
	 * Dispatch quick edit areas
	 *
	 * @param string $column Column ID.
	 * @param string $type Passthrough.
	 */
	public function smartcrawl_quick_edit_dispatch( $column, $type ) {
		switch ( $column ) {
			case 'page-title':
				return $this->_title_qe_box( $type );
			case 'page-meta-robots':
				return $this->_robots_qe_box();
		}
	}

	/**
	 * Renders title quick edit box
	 */
	private function _title_qe_box() {
		global $post;
		$this->_render( 'quick-edit-title', array(
			'post' => $post,
		) );
	}

	/**
	 * Renders robots quick edit box
	 */
	private function _robots_qe_box() {
		global $post;
		$this->_render( 'quick-edit-robots', array(
			'post' => $post,
		) );
	}

	/**
	 * Inject the quick editing javascript
	 */
	public function smartcrawl_quick_edit_javascript() {
		$this->_render( 'quick-edit-javascript' );
	}

	/**
	 * Handle postmeta getting requests
	 */
	public function json_wds_postmeta() {
		$data = $this->get_request_data();
		$id = (int) $data['id'];
		$post = get_post( $id );
		die( wp_json_encode( array(
			'title'       => smartcrawl_replace_vars( smartcrawl_get_value( 'title', $id ), (array) $post ),
			'description' => smartcrawl_replace_vars( smartcrawl_get_value( 'metadesc', $id ), (array) $post ),
			'focus'       => smartcrawl_get_value( 'focus-keywords', $id ),
			'keywords'    => smartcrawl_get_value( 'keywords', $id ),
		) ) );
	}

	/**
	 * Handle metabox live update requests
	 */
	public function smartcrawl_metabox_live_update() {
		$data = $this->get_request_data();
		$id = (int) $data['id'];
		$post = get_post( $id );

		$post_data = sanitize_post( $data['post'] );

		/* Merge live post data with currently saved post data */
		$post->post_author = $post_data['post_author'];
		$post->post_title = $post_data['post_title'];
		$post->post_excerpt = $post_data['excerpt'];
		$post->post_content = $post_data['content'];
		$post->post_type = $post_data['post_type'];

		$title = smartcrawl_get_seo_title( $post );
		$description = smartcrawl_get_seo_desc( $post );

		wp_send_json( array(
			'title'       => $title,
			'description' => $description,
			'focus'       => smartcrawl_get_value( 'focus-keywords', $id ),
			'keywords'    => smartcrawl_get_value( 'keywords', $id ),
		) );

		die();
	}

	/**
	 * Sattisfy interface
	 */
	protected function _get_view_defaults() {
		return array();
	}

	private function get_request_data() {
		return isset( $_POST['_wds_nonce'] ) && wp_verify_nonce( $_POST['_wds_nonce'], 'wds-metabox-nonce' ) ? stripslashes_deep( $_POST ) : array();
	}
}