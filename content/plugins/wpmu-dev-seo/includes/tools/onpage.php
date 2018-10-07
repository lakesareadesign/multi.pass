<?php
/**
 * On-page processing stuff
 *
 * Smartcrawl_OnPage::smartcrawl_title(), Smartcrawl_OnPage::smartcrawl_head(), Smartcrawl_OnPage::smartcrawl_metadesc()
 * inspired by WordPress SEO by Joost de Valk (http://yoast.com/wordpress/seo/).
 *
 * @package wpmu-dev-seo
 */

/**
 * On-page (title, meta etc) stuff processing class
 */
class Smartcrawl_OnPage {

	/**
	 * Static instance
	 *
	 * @var Smartcrawl_OnPage
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
	private function __construct() {
		if ( defined( 'SF_PREFIX' ) && function_exists( 'sf_get_option' ) ) {
			add_action( 'template_redirect', array( $this, 'postpone_for_simplepress' ), 1 );

			return;
		}
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
	 * Binds processing actions
	 */
	public function run() {
		if ( $this->_is_running ) {
			return false;
		}

		$options = Smartcrawl_Settings::get_options();

		remove_action( 'wp_head', 'rel_canonical' );

		add_action( 'wp_head', array( $this, 'smartcrawl_head' ), 10, 1 );

		// wp_title isn't enough. We'll do it anyway: suspenders and belt approach.
		add_filter( 'wp_title', array( $this, 'smartcrawl_title' ), 100, 3 );

		// For newer themes using wp_get_document_title()
		add_filter( 'pre_get_document_title', array( $this, 'smartcrawl_title' ), 100 );

		// Buffer the header output and process it instead.
		if ( $this->force_rewrite_title() ) {
			add_action( 'template_redirect', array( $this, 'smartcrawl_start_title_buffer' ), 99 );
		}

		// This should now work with BuddyPress as well.
		add_filter( 'bp_page_title', array( $this, 'smartcrawl_title' ), 10, 3 );

		add_action( 'wp', array( $this, 'smartcrawl_page_redirect' ), 99, 1 );

		if ( ! empty( $options['general-suppress-generator'] ) ) {
			remove_action( 'wp_head', 'wp_generator' );
		}

		if ( ! empty( $options['general-suppress-redundant_canonical'] ) ) {
			if ( ! defined( 'SMARTCRAWL_SUPPRESS_REDUNDANT_CANONICAL' ) ) {
				define( 'SMARTCRAWL_SUPPRESS_REDUNDANT_CANONICAL', true );
			}
		}
		$this->_is_running = true;
	}

	/**
	 * Can't fully handle SimplePress installs properly.
	 * For non-forum pages, do our thing all the way.
	 * For forum pages, do nothing.
	 */
	public function postpone_for_simplepress() {
		global $wp_query;
		if ( (int) sf_get_option( 'sfpage' ) !== $wp_query->post->ID ) {
			$this->_init();
		}
	}

	/**
	 * Starts buffering the header.
	 * The buffer output will be used to replace the title.
	 */
	public function smartcrawl_start_title_buffer() {
		ob_start( array( $this, 'smartcrawl_process_title_buffer' ) );
	}

	/**
	 * Handles the title buffer.
	 * Replaces the title with what we get from the old smartcrawl_title method.
	 * If we get nothing from it, do nothing.
	 *
	 * @param string $head Header area to process.
	 *
	 * @return string
	 */
	public function smartcrawl_process_title_buffer( $head ) {
		if ( is_feed() ) {
			return $head;
		}

		$title_rx = '<title[^>]*?>.*?' . preg_quote( '</title>' );
		$head_rx = '<head [^>]*? >';
		$head = preg_replace( '/\n/', '__SMARTCRAWL_NL__', $head );
		// Dollar signs throw off replacement...
		$title = preg_replace( '/\$/', '__SMARTCRAWL_DOLLAR__', $this->smartcrawl_title( '' ) ); // ... so temporarily escape them, then
		// Make sure we're replacing TITLE that's actually in the HEAD.
		$head = ( $title && preg_match( "~{$head_rx}~ix", $head ) ) ?
			preg_replace( "~{$title_rx}~i", "<title>{$title}</title>", $head )
			: $head;

		return preg_replace( '/__SMARTCRAWL_NL__/', "\n", preg_replace( '/__SMARTCRAWL_DOLLAR__/', '\$', $head ) );
	}

	/**
	 * Gets the processed HTML title
	 *
	 * @param string $title Original title.
	 * @param string $sep Separator to use.
	 * @param string $seplocation deprecated.
	 * @param string $postid deprecated.
	 *
	 * @return string
	 */
	public function smartcrawl_title( $title, $sep = '', $seplocation = '', $postid = '' ) {
		$title = $this->get_title( $title );

		return esc_html( strip_tags( stripslashes( apply_filters( 'wds_title', $title ) ) ) );
	}

	/**
	 * Gets resolved title
	 *
	 * @param string $title Optional seed title.
	 *
	 * @return string Resolved title
	 */
	public function get_title( $title = '' ) {
		$request_title = $this->get_request_param( 'wds_title' );
		if ( ! empty( $request_title ) ) {
			return $request_title;
		}

		$resolver = $this->get_resolver();

		$post = $resolver->get_context();
		$wp_query = $resolver->get_query_context();

		$smartcrawl_options = Smartcrawl_Settings::get_options();

		$location = $resolver->get_location();
		if ( empty( $title ) ) {
			if ( Smartcrawl_Endpoint_Resolver::L_PT_ARCHIVE === $location ) {
				$title = post_type_archive_title( '', false );
			} elseif ( Smartcrawl_Endpoint_Resolver::L_ARCHIVE === $location ) {
				$title = get_the_archive_title();
			} else {
				$title = get_the_title( $post );
			}
		}

		if ( Smartcrawl_Endpoint_Resolver::L_BLOG_HOME === $location ) {
			$title = smartcrawl_replace_vars( $smartcrawl_options['title-home'], (array) $post );
		} elseif ( Smartcrawl_Endpoint_Resolver::L_STATIC_HOME === $location ) {
			$post = get_post( get_option( 'page_for_posts' ) );
			$fixed_title = smartcrawl_get_value( 'title' );
			if ( $fixed_title ) {
				$title = smartcrawl_replace_vars( $fixed_title, (array) $post );
			} elseif ( ! empty( $post->post_type ) && isset( $smartcrawl_options[ 'title-' . $post->post_type ] ) && ! empty( $smartcrawl_options[ 'title-' . $post->post_type ] ) ) {
				$title = smartcrawl_replace_vars( $smartcrawl_options[ 'title-' . $post->post_type ], (array) $post );
			}
		} elseif ( Smartcrawl_Endpoint_Resolver::L_TAX_ARCHIVE === $location ) {
			$term = $wp_query->get_queried_object();
			$title = smartcrawl_get_term_meta( $term, $term->taxonomy, 'wds_title' );
			if ( ! $title && isset( $smartcrawl_options[ 'title-' . $term->taxonomy ] ) && ! empty( $smartcrawl_options[ 'title-' . $term->taxonomy ] ) ) {
				$title = smartcrawl_replace_vars( $smartcrawl_options[ 'title-' . $term->taxonomy ], (array) $term );
			}
		} elseif ( Smartcrawl_Endpoint_Resolver::L_SEARCH === $location && ! empty( $smartcrawl_options['title-search'] ) ) {
			$title = smartcrawl_replace_vars( $smartcrawl_options['title-search'], (array) $wp_query->get_queried_object() );
		} elseif ( Smartcrawl_Endpoint_Resolver::L_AUTHOR_ARCHIVE === $location ) {
			$author_id = get_query_var( 'author' );
			$title = get_the_author_meta( 'wds_title', $author_id );
			if ( empty( $title ) && isset( $smartcrawl_options['title-author'] ) && ! empty( $smartcrawl_options['title-author'] ) ) {
				$title = smartcrawl_replace_vars( $smartcrawl_options['title-author'], array() );
			}
		} elseif ( Smartcrawl_Endpoint_Resolver::L_DATE_ARCHIVE === $location && ! empty( $smartcrawl_options['title-date'] ) ) {
			$title = smartcrawl_replace_vars( $smartcrawl_options['title-date'], array( 'post_title' => $title ) );
		} elseif ( Smartcrawl_Endpoint_Resolver::L_PT_ARCHIVE === $location ) {
			$title = $this->get_pt_archive_meta_setting( $smartcrawl_options, 'title-', $title );
		} elseif ( Smartcrawl_Endpoint_Resolver::L_ARCHIVE === $location && ! empty( $smartcrawl_options['title-archive'] ) ) {
			$title = smartcrawl_replace_vars( $smartcrawl_options['title-archive'], array( 'post_title' => $title ) );
		} elseif ( Smartcrawl_Endpoint_Resolver::L_404 === $location && ! empty( $smartcrawl_options['title-404'] ) ) {
			$title = smartcrawl_replace_vars( $smartcrawl_options['title-404'], array( 'post_title' => $title ) );
		} elseif ( Smartcrawl_Endpoint_Resolver::L_BP_GROUPS === $location ) {
			$bp = buddypress();
			$group = $bp->groups->current_group;
			$title = smartcrawl_replace_vars( $smartcrawl_options['title-bp_groups'], array(
				'name'        => $group->name,
				'description' => $group->description,
			) );
		} elseif ( Smartcrawl_Endpoint_Resolver::L_BP_PROFILE === $location ) {
			$title = smartcrawl_replace_vars( $smartcrawl_options['title-bp_profile'], array(
				'full_name' => bp_get_displayed_user_fullname(),
				'username'  => bp_get_displayed_user_username(),
			) );
		} elseif ( Smartcrawl_Endpoint_Resolver::L_SINGULAR === $location ) {
			$object = get_queried_object();
			$post_id = ! empty( $post->ID )
				? $post->ID
				: ( ! empty( $object->ID ) ? $object->ID : false );
			$fixed_title = smartcrawl_get_value( 'title', $post_id );
			if ( $fixed_title ) {
				$title = smartcrawl_replace_vars( $fixed_title, (array) $post );
			} elseif ( ! empty( $post->post_type ) && isset( $smartcrawl_options[ 'title-' . $post->post_type ] ) && ! empty( $smartcrawl_options[ 'title-' . $post->post_type ] ) ) {
				$title = smartcrawl_replace_vars( $smartcrawl_options[ 'title-' . $post->post_type ], (array) $post );
			}
		} elseif ( Smartcrawl_Endpoint_Resolver::L_WOO_SHOP === $location ) { // WooCommerce shop page.
			$post_id = wc_get_page_id( 'shop' );
			$fixed_title = smartcrawl_get_value( 'title', $post_id );
			if ( $fixed_title ) {
				$title = smartcrawl_replace_vars( $fixed_title, (array) $post );
			}
		}

		return $title;
	}

	/**
	 * Gets a parameter from POST array
	 *
	 * @param string $key Parameter key to fetch.
	 *
	 * @return mixed
	 */
	private function get_request_param( $key ) {
		$data = $this->get_request_data();

		return sanitize_text_field(
			smartcrawl_get_array_value( $data, $key )
		);
	}

	private function get_request_data() {
		return isset( $_POST['_wds_nonce'] ) && wp_verify_nonce( $_POST['_wds_nonce'], 'wds-metabox-nonce' ) ? stripslashes_deep( $_POST ) : array();
	}

	/**
	 * Spawn endpoint resolver
	 *
	 * @return Smartcrawl_Endpoint_Resolver
	 */
	public function get_resolver() {
		return Smartcrawl_Endpoint_Resolver::resolve();
	}

	/**
	 * @param $smartcrawl_options
	 *
	 * @return string
	 */
	private function get_pt_archive_meta_setting( $smartcrawl_options, $setting_prefix, $default_value ) {
		$post_type = get_queried_object();
		if ( is_a( $post_type, 'WP_Post_Type' ) ) {
			$pt_archive_key = $setting_prefix . Smartcrawl_Onpage_Settings::PT_ARCHIVE_PREFIX . $post_type->name;

			if ( ! empty( $smartcrawl_options[ $pt_archive_key ] ) ) {
				return smartcrawl_replace_vars( $smartcrawl_options[ $pt_archive_key ], $post_type );
			}
		}

		return $default_value;
	}

	/**
	 * Processes the stuff that goes into the HTML head
	 */
	public function smartcrawl_head() {
		global $wp_query, $paged;
		$smartcrawl_options = Smartcrawl_Settings::get_options();

		if ( $this->force_rewrite_title() ) {
			$this->smartcrawl_stop_title_buffer(); // STOP processing the buffer.
		}

		$robots = '';

		if ( ! smartcrawl_is_switch_active( 'SMARTCRAWL_WHITELABEL_ON' ) ) {
			$project = defined( 'SMARTCRAWL_PROJECT_TITLE' )
				? SMARTCRAWL_PROJECT_TITLE
				: 'SmartCrawl';
			echo "<!-- SEO meta tags powered by " . esc_html( $project ) . " -->\n";
		}
		$this->smartcrawl_canonical();
		$this->smartcrawl_rel_links();
		$this->smartcrawl_robots();
		$this->smartcrawl_metadesc();
		$this->smartcrawl_meta_keywords();

		$metas = $this->get_meta_tags();
		foreach ( $metas as $meta ) {
			$this->print_html_tag( "{$meta}\n" );
		}

		do_action( 'wds_head-after_output' );

		if ( ! smartcrawl_is_switch_active( 'SMARTCRAWL_WHITELABEL_ON' ) ) {
			echo "<!-- /SEO -->\n";
		}
	}

	private function print_html_tag( $html ) {
		if (!preg_match('/\<(link|meta)/', $html)) {
			// Do not allow plaintext output.
			return false;
		}
		echo wp_kses( $html, array(
			'meta' => array(
				'name'       => array(),
				'content'    => array(),
				'http-equiv' => array(),
				'charset'    => array(),
				'scheme'     => array(),
			),
			'link' => array(
				'charset'         => array(),
				'crossorigin'     => array(),
				'use-credentials' => array(),
				'href'            => array(),
				'hreflang'        => array(),
				'media'           => array(),
				'rel'             => array(),
				'stylesheet'      => array(),
				'rev'             => array(),
				'sizes'           => array(),
				'any'             => array(),
				'target'          => array(),
				'frame_name'      => array(),
				'type'            => array(),
			)
		) );
	}

	/**
	 * Stops buffering the output - the title should now be in the buffer.
	 */
	private function smartcrawl_stop_title_buffer() {
		if ( function_exists( 'ob_list_handlers' ) ) {
			$active_handlers = ob_list_handlers();
		} else {
			$active_handlers = array();
		}
		if ( count( $active_handlers ) > 0 ) {
			$offset = count( $active_handlers ) - 1;
			$handler = ! empty( $active_handlers[ $offset ] ) && is_string( $active_handlers[ $offset ] )
				? trim( $active_handlers[ $offset ] )
				: '';
			if ( preg_match( '/::smartcrawl_process_title_buffer$/', $handler ) ) {
				ob_end_flush();
			}
		}
	}

	/**
	 * Handle canonical link rendering
	 *
	 * @return bool Status
	 */
	private function smartcrawl_canonical() {
		if (
			function_exists( 'bp_is_blog_page' ) // If we have BuddyPress ...
			&& // ... and
			! ( bp_is_blog_page() || is_404() ) // ... we're on a BP page.
		) {
			return false;
		}

		if ( ! apply_filters( 'wds_process_canonical', true ) ) {
			return false;
		} // Allow optional filtering out.
		// Set decent canonicals for homepage, singulars and taxonomy pages.
		$canonical = $this->get_canonical_url();

		// Let's check if we're dealing with the redundant canonical.
		if ( smartcrawl_is_switch_active( 'SMARTCRAWL_SUPPRESS_REDUNDANT_CANONICAL' ) ) {
			global $wp;
			$current_url = add_query_arg( $_GET, trailingslashit( home_url( $wp->request ) ) ); // phpcs:ignore -- Nonce not applicable
			if ( $current_url === $canonical ) {
				$canonical = false;
			}
		}

		if ( ! empty( $canonical ) ) {
			$this->print_html_tag( '<link rel="canonical" href="' . esc_attr( $canonical ) . '" />' . "\n" );
		}

		return ! empty( $canonical );
	}

	/**
	 * @return bool|mixed|string|WP_Error
	 */
	public function get_canonical_url() {
		global $wp_query, $paged;
		$canonical = smartcrawl_get_value( 'canonical' );

		if ( empty( $canonical ) ) {
			if ( is_singular() ) {
				$canonical = $this->get_rel_canonical();
			} else {
				$canonical = '';
				if ( is_front_page() ) {
					$canonical = trailingslashit( get_bloginfo( 'url' ) );
				} elseif ( is_tax() || is_tag() || is_category() ) {
					$term = $wp_query->get_queried_object();
					$canonical = smartcrawl_get_term_meta( $term, $term->taxonomy, 'wds_canonical' );
					$canonical = $canonical ? $canonical : get_term_link( $term, $term->taxonomy );
				} elseif ( is_date() ) {
					$requested_year = get_query_var( 'year' );
					$requested_month = get_query_var( 'monthnum' );
					$date_callback = ! empty( $requested_year ) && empty( $requested_month )
						? 'get_year_link'
						: 'get_month_link';
					$canonical = $date_callback( $requested_year, $requested_month );
				} elseif ( is_author() ) {
					$user = get_queried_object();
					$canonical = get_author_posts_url( $user->ID );
				}

				// only show id not error object.
				if ( $canonical && ! is_wp_error( $canonical ) ) {
					if ( $paged && ! is_wp_error( $paged ) ) {
						$canonical .= trailingslashit( 'page/' . $paged );
					}
				}
			}
		}

		$canonical = apply_filters( 'wds_filter_canonical', $canonical );

		return $canonical;
	}

	/**
	 * Gets singular entity fallback canonical URL
	 *
	 * @return string|bool Canonical URL, or (bool)false
	 */
	private function get_rel_canonical() {
		$link = false;
		if ( ! is_singular() ) {
			return $link;
		}

		global $wp_the_query;
		$id = $wp_the_query->get_queried_object_id();
		if ( ! $id ) {
			return;
		}

		$link = get_permalink( $id );
		$page = get_query_var( 'cpage' );
		if ( $page ) {
			$link = get_comments_pagenum_link( $page );
		}

		return $link;
	}

	/**
	 * Output link rel tags
	 */
	private function smartcrawl_rel_links() {
		global $wp_query, $paged;
		$smartcrawl_options = Smartcrawl_Settings::get_options();

		if ( ! $wp_query->max_num_pages ) {
			return false;
		} // Short out on missing max page number.
		if ( ! apply_filters( 'wds_process_rel_links', true ) ) {
			return false;
		} // Allow optional filtering out.

		$is_taxonomy = ( is_tax() || is_tag() || is_category() || is_date() );
		$requested_year = get_query_var( 'year' );
		$requested_month = get_query_var( 'monthnum' );
		$is_date = is_date() && ! empty( $requested_year );
		$date_callback = ! empty( $requested_year ) && empty( $requested_month )
			? 'get_year_link'
			: 'get_month_link';
		$pageable = ( $is_taxonomy || ( is_home() && 'posts' === get_option( 'show_on_front' ) ) );
		if ( ! $pageable ) {
			return false;
		}

		$term = $wp_query->get_queried_object();
		$canonical = ! empty( $term->taxonomy ) && $is_taxonomy ? smartcrawl_get_term_meta( $term, $term->taxonomy, 'wds_canonical' ) : false;
		if ( ! $canonical ) {
			if ( (int) $paged > 1 ) {
				$prev = is_home() ? home_url() : (
				$is_date
					? $date_callback( $requested_year, $requested_month )
					: get_term_link( $term, $term->taxonomy )
				);
				$prev = ( '' === get_option( 'permalink_structure' ) )
					? ( ( $paged > 2 ) ? add_query_arg( 'page', $paged - 1, $prev ) : $prev )
					: ( ( $paged > 2 ) ? trailingslashit( $prev ) . 'page/' . ( $paged - 1 ) : $prev );
				$prev = esc_attr( trailingslashit( $prev ) );
				$this->print_html_tag( "<link rel='prev' href='{$prev}' />\n" );
			}
			$is_paged = (int) $paged ? (int) $paged : 1;
			if ( $is_paged && $is_paged < $wp_query->max_num_pages ) {
				$next = is_home() ? home_url() : (
				$is_date
					? $date_callback( $requested_year, $requested_month )
					: get_term_link( $term, $term->taxonomy )
				);
				$next_page = $is_paged + 1;
				$next = ( '' === get_option( 'permalink_structure' ) )
					? add_query_arg( 'page', $next_page, $next )
					: trailingslashit( $next ) . 'page/' . $next_page;
				$next = esc_attr( trailingslashit( $next ) );
				$this->print_html_tag( "<link rel='next' href='{$next}' />\n" );
			}
		}
	}

	/**
	 * Output meta robots tag
	 */
	private function smartcrawl_robots() {
		$smartcrawl_options = Smartcrawl_Settings::get_options();

		if ( ! apply_filters( 'wds_process_robots', true ) ) {
			return false;
		}

		$helper = $this->get_robot_value_helper();
		$helper->traverse();
		$robots = $helper->get_value();

		// Clean up, index, follow is the default and doesn't need to be in output. All other combinations should be.
		if ( 'index,follow' === $robots ) {
			$robots = '';
		}
		if ( strpos( $robots, 'index,follow,' ) === 0 ) {
			$robots = str_replace( 'index,follow,', '', $robots );
		}

		foreach ( array( 'noodp', 'noydir', 'noarchive', 'nosnippet' ) as $robot ) {
			if ( isset( $smartcrawl_options[ $robot ] ) && $smartcrawl_options[ $robot ] ) {
				if ( ! empty( $robots ) && substr( $robots, - 1 ) !== ',' ) {
					$robots .= ',';
				}
				$robots .= $robot;
			}
		}

		$robots = rtrim( $robots, ',' );
		if ( '' !== $robots && 1 === (int) get_option( 'blog_public' ) ) {
			$this->print_html_tag( '<meta name="robots" content="' . esc_attr( $robots ) . '"/>' . "\n" );
		}
	}

	private function get_robot_value_helper() {
		return new Smartcrawl_Robots_Value_Helper();
	}

	/**
	 * Outputs meta description
	 */
	private function smartcrawl_metadesc() {
		if ( is_admin() ) {
			return false;
		}

		$metadesc = $this->get_description();

		if ( ! empty( $metadesc ) ) {
			echo '<meta name="description" content="' .
			     esc_attr( strip_tags( stripslashes( apply_filters( 'wds_metadesc', $metadesc ) ) ) )
			     . '" />' . "\n";
		}
	}

	/**
	 * Gets resolved description
	 *
	 * @param string $metadesc Optional seed metadesc.
	 *
	 * @return string Resolved description
	 */
	public function get_description( $metadesc = '' ) {
		$request_description = $this->get_request_param( 'wds_description' );
		if ( ! empty( $request_description ) ) {
			return $request_description;
		}

		$resolver = $this->get_resolver();

		$post = $resolver->get_context();
		$wp_query = $resolver->get_query_context();

		if ( empty( $metadesc ) && is_object( $post ) ) {
			$metadesc = smartcrawl_get_trimmed_excerpt( $post->post_excerpt, $post->post_content );
		}
		$location = $resolver->get_location();
		$smartcrawl_options = Smartcrawl_Settings::get_options();

		if ( Smartcrawl_Endpoint_Resolver::L_BP_GROUPS === $location ) { // BP group?
			$optvar = ! empty( $smartcrawl_options['metadesc-bp_groups'] ) ? $smartcrawl_options['metadesc-bp_groups'] : '';
			$bp = buddypress();
			$group = $bp->groups->current_group;
			$metadesc = smartcrawl_replace_vars( $optvar, array(
				'name'        => $group->name,
				'description' => $group->description,
			) );
		} elseif ( Smartcrawl_Endpoint_Resolver::L_BP_PROFILE === $location ) {
			$optvar = ! empty( $smartcrawl_options['metadesc-bp_profile'] ) ? $smartcrawl_options['metadesc-bp_profile'] : '';
			$metadesc = smartcrawl_replace_vars( $optvar, array(
				'full_name' => bp_get_displayed_user_fullname(),
				'username'  => bp_get_displayed_user_username(),
			) );
		} elseif ( Smartcrawl_Endpoint_Resolver::L_SINGULAR === $location ) {
			$object = get_queried_object();
			$post_id = ! empty( $post->ID )
				? $post->ID
				: ( ! empty( $object->ID ) ? $object->ID : false );
			$stored = smartcrawl_get_value( 'metadesc', $post_id );
			if ( empty( $stored ) && is_object( $post ) ) {
				$optvar = ! empty( $smartcrawl_options[ 'metadesc-' . $post->post_type ] ) ? $smartcrawl_options[ 'metadesc-' . $post->post_type ] : '';
				$stored = smartcrawl_replace_vars( $optvar, (array) $post );
			} elseif ( ! empty( $stored ) ) {
				$stored = smartcrawl_replace_vars( $stored, (array) $post );
			}
			if ( ! empty( $stored ) ) {
				$metadesc = $stored;
			}
		} elseif ( Smartcrawl_Endpoint_Resolver::L_WOO_SHOP === $location ) { // WooCommerce shop page.
			$post_id = wc_get_page_id( 'shop' );
			$metadesc = smartcrawl_get_value( 'metadesc', $post_id );
			if ( is_object( $post ) ) {
				$metadesc = smartcrawl_replace_vars( $metadesc, (array) $post );
			}
		} elseif ( Smartcrawl_Endpoint_Resolver::L_BLOG_HOME === $location && isset( $smartcrawl_options['metadesc-home'] ) ) {
			$metadesc = smartcrawl_replace_vars( $smartcrawl_options['metadesc-home'], array() );
		} elseif ( Smartcrawl_Endpoint_Resolver::L_STATIC_HOME === $location ) {
			$npost = get_post( get_option( 'page_for_posts' ) );
			$metadesc = is_object( $npost ) && ! empty( $npost->ID )
				? smartcrawl_get_value( 'metadesc', $npost->ID )
				: smartcrawl_get_value( 'metadesc' );
			if ( is_object( $npost ) ) {
				$metadesc = smartcrawl_replace_vars( $metadesc, (array) $npost );
			}
			if ( ( '' === $metadesc || ! $metadesc ) && is_object( $npost ) && isset( $smartcrawl_options[ 'metadesc-' . $npost->post_type ] ) ) {
				$metadesc = smartcrawl_replace_vars( $smartcrawl_options[ 'metadesc-' . $npost->post_type ], (array) $npost );
			}
		} elseif ( Smartcrawl_Endpoint_Resolver::L_TAX_ARCHIVE === $location ) {
			$term = $wp_query->get_queried_object();

			$metadesc = smartcrawl_get_term_meta( $term, $term->taxonomy, 'wds_desc' );
			if ( ! $metadesc && isset( $smartcrawl_options[ 'metadesc-' . $term->taxonomy ] ) ) {
				$metadesc = smartcrawl_replace_vars( $smartcrawl_options[ 'metadesc-' . $term->taxonomy ], (array) $term );
			}
		} elseif ( Smartcrawl_Endpoint_Resolver::L_AUTHOR_ARCHIVE === $location ) {
			$author_id = get_query_var( 'author' );
			$metadesc = get_the_author_meta( 'wds_metadesc', $author_id );
			if ( empty( $metadesc ) && isset( $smartcrawl_options['metadesc-author'] ) && ! empty( $smartcrawl_options['metadesc-author'] ) ) {
				$metadesc = smartcrawl_replace_vars( $smartcrawl_options['metadesc-author'], array() );
			}
		} elseif ( Smartcrawl_Endpoint_Resolver::L_DATE_ARCHIVE === $location && ! empty( $smartcrawl_options['metadesc-date'] ) ) {
			$metadesc = smartcrawl_replace_vars( $smartcrawl_options['metadesc-date'] );
		} elseif ( Smartcrawl_Endpoint_Resolver::L_PT_ARCHIVE === $location ) {
			$metadesc = $this->get_pt_archive_meta_setting( $smartcrawl_options, 'metadesc-', $metadesc );
		} elseif ( Smartcrawl_Endpoint_Resolver::L_SEARCH === $location && ! empty( $smartcrawl_options['metadesc-search'] ) ) {
			$metadesc = smartcrawl_replace_vars( $smartcrawl_options['metadesc-search'] );
		} elseif ( Smartcrawl_Endpoint_Resolver::L_404 === $location && ! empty( $smartcrawl_options['metadesc-404'] ) ) {
			$metadesc = smartcrawl_replace_vars( $smartcrawl_options['metadesc-404'] );
		}

		return strip_tags( stripslashes( $metadesc ) );
	}

	/**
	 * Output meta keywords, if any.
	 */
	private function smartcrawl_meta_keywords() {
		if ( is_admin() ) {
			return;
		}

		if ( ! apply_filters( 'wds_process_keywords', true ) ) {
			return false;
		} // Allow optional filtering out.
		$keywords = $this->get_keywords();
		if ( empty( $keywords ) ) {
			return false;
		}

		echo '<meta name="keywords" content="' . esc_attr( stripslashes( join( ',', $keywords ) ) ) . '" />' . "\n";

		// News keywords.
		$resolver = $this->get_resolver();
		$news_meta = $resolver->is_singular() ? stripslashes( smartcrawl_get_value( 'news_keywords' ) ) : false;
		$news_meta = trim( preg_replace( '/\s\s+/', ' ', preg_replace( '/[^-_,a-z0-9 ]/i', ' ', $news_meta ) ) );
		if ( $news_meta ) {
			echo '<meta name="news_keywords" content="' . esc_attr( $news_meta ) . '" />' . "\n";
		}
	}

	/**
	 * Gets a list of keywords for current resolved endpoint
	 *
	 * @param string $location Resolved location to get keywords for.
	 * @param WP_Post $post Post context for location.
	 *
	 * @return array A list of keywords
	 */
	public function get_keywords( $location = false, $post = false ) {
		$resolver = $this->get_resolver();
		$smartcrawl_options = Smartcrawl_Settings::get_options();

		if ( empty( $location ) ) {
			$location = $resolver->get_location();
		}
		if ( empty( $post ) ) {
			$post = $resolver->get_context();
		}

		$metakey = '';
		$extra = array();

		if ( Smartcrawl_Endpoint_Resolver::L_BLOG_HOME === $location && isset( $smartcrawl_options['keywords-home'] ) ) {
			$metakey = smartcrawl_replace_vars( $smartcrawl_options['keywords-home'], (array) $post );
		} elseif ( Smartcrawl_Endpoint_Resolver::L_WOO_SHOP === $location ) {
			$post_id = wc_get_page_id( 'shop' );
			$metakey = smartcrawl_get_value( 'keywords', $post_id );
			$use_tags = smartcrawl_get_value( 'tags_to_keywords', $post_id );
			$metakey = $use_tags ? $this->_tags_to_keywords( $metakey ) : $metakey;
		} else {
			$metakey = $resolver->is_singular( $location ) ? smartcrawl_get_value( 'keywords', $post->ID ) : false;
			if ( $resolver->is_singular( $location ) ) {
				if ( smartcrawl_get_value( 'tags_to_keywords', $post->ID ) ) {
					$extra = array_merge( $extra, $this->get_tag_keywords( $post ) );
				}
				$extra = array_merge( $extra, $this->get_focus_keywords( $post ) );
			}
		}

		$keywords = array_filter( array_unique( array_merge(
			$this->keywords_string_to_array( $metakey ),
			$extra
		) ) );

		return $keywords;
	}

	/**
	 * Gets list of post tags
	 *
	 * Defaults to currently resolved post if no post given.
	 *
	 * @param WP_Post $post Post object instance.
	 *
	 * @return array List of tags
	 */
	public function get_tag_keywords( $post = false ) {
		$tags = array();
		if ( empty( $post ) ) {
			$post = $this->get_resolver()->get_context();
		}
		if ( ! is_object( $post ) || ! ( $post instanceof WP_Post ) ) {
			return $tags;
		}

		$raw_tags = get_the_tags( $post->ID );
		if ( $raw_tags ) {
			foreach ( $raw_tags as $tag ) {
				$tags[] = $tag->name;
			}
		}

		return $tags;
	}

	/**
	 * Gets a list of focus keywords for a given post
	 *
	 * Defaults to currently resolved post if no post given.
	 *
	 * @param WP_Post $post Optional post.
	 *
	 * @return array A list of focus keywords
	 */
	public function get_focus_keywords( $post = false ) {
		$result = array();
		if ( empty( $post ) ) {
			$post = $this->get_resolver()->get_context();
		}
		if ( ! is_object( $post ) || ! ( $post instanceof WP_Post ) ) {
			return $result;
		}

		$request_keywords = $this->get_request_param( 'wds_focus_keywords' );
		$focus_keywords = ! empty( $request_keywords ) ? $request_keywords : smartcrawl_get_value( 'focus-keywords', $post->ID );
		$result = $this->keywords_string_to_array( $focus_keywords );

		return $result;
	}

	/**
	 * Converts a comma-separated string of keywords into an array
	 *
	 * @param string $kws Keywords string.
	 *
	 * @return array List of keywords
	 */
	public function keywords_string_to_array( $kws ) {
		$kw_array = $kws ? explode( ',', trim( $kws ) ) : array();
		$kw_array = is_array( $kw_array ) ? $kw_array : array();
		$kw_array = array_map( 'trim', $kw_array );

		return array_filter( array_unique( $kw_array ) );
	}

	/**
	 * Gets (custom) meta tags for output
	 */
	public function get_meta_tags() {
		// Sitemap options are shown on the settings page so the decision to fallback should be made after checking
		// if Smartcrawl_Settings::TAB_SETTINGS is allowed.
		//
		// This logic follows the pattern used in Smartcrawl_Settings._populate_options
		$smartcrawl_options = is_multisite() && smartcrawl_is_switch_active( 'SMARTCRAWL_SITEWIDE' ) || ! smartcrawl_is_allowed_tab( Smartcrawl_Settings::TAB_SETTINGS )
			? get_site_option( Smartcrawl_Settings::TAB_SITEMAP . '_options', array() )
			: get_option( Smartcrawl_Settings::TAB_SITEMAP . '_options', array() );

		$metas = array();

		$include_verifications = (bool) (
			empty( $smartcrawl_options['verification-pages'] )
			|| (
				! empty( $smartcrawl_options['verification-pages'] )
				&&
				'home' === $smartcrawl_options['verification-pages']
				&&
				is_front_page()
			)
		);

		// Full meta overrides.
		if ( ! empty( $smartcrawl_options['verification-google-meta'] ) && $include_verifications ) {
			$metas['google'] = $smartcrawl_options['verification-google-meta'];
		}
		if ( ! empty( $smartcrawl_options['verification-bing-meta'] ) && $include_verifications ) {
			$metas['bing'] = $smartcrawl_options['verification-bing-meta'];
		}

		$additional = ! empty( $smartcrawl_options['additional-metas'] ) ? $smartcrawl_options['additional-metas'] : array();
		if ( ! is_array( $additional ) ) {
			$additional = array();
		}

		foreach ( $additional as $meta ) {
			$metas[] = $meta;
		}

		return $metas;
	}

	/**
	 * Performs page redirect
	 *
	 * @param mixed $input Not used.
	 */
	public function smartcrawl_page_redirect( $input ) {
		global $post;

		// Fix redirection on archive pages - do not redirect if not singular.
		// Fixes: https://app.asana.com/0/46496453944769/505196129561557/f.
		if ( ! is_singular() ) {
			return false;
		}

		if ( ! apply_filters( 'wds_process_redirect', true ) ) {
			return false;
		} // Allow optional filtering out.

		$redir = smartcrawl_get_value( 'redirect', $post->ID );
		if ( $post && $redir ) {
			wp_redirect( $redir, 301 );
			exit;
		}
	}

	private function force_rewrite_title() {
		return smartcrawl_is_switch_active( 'SMARTCRAWL_FORCE_REWRITE_TITLE' );
	}
}