<?php
/**
 * Outputs OG tags to the page
 */
class Smartcrawl_OpenGraph_Printer {

	/**
	 * Singleton instance holder
	 */
	private static $_instance;

	private $_is_running = false;
	private $_is_done = false;

	public function __construct() {
	}

	/**
	 * Singleton instance getter
	 *
	 * @return Smartcrawl_OpenGraph_Printer instance
	 */
	public static function get() {
		if ( empty( self::$_instance ) ) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	/**
	 * Boot the hooking part
	 */
	public static function run() {
		self::get()->_add_hooks();
	}

	private function _add_hooks() {
		// Do not double-bind
		if ( apply_filters( 'wds-opengraph-is_running', $this->_is_running ) ) {
			return true;
		}

		add_action( 'wp_head', array( $this, 'dispatch_og_tags_injection' ), 50 );
		add_action( 'wds_head-after_output', array( $this, 'dispatch_og_tags_injection' ) );

		$this->_is_running = true;
	}

	/**
	 * First-line dispatching of OG tags injection
	 */
	public function dispatch_og_tags_injection() {
		if ( ! ! $this->_is_done ) { return false; }

		$settings = Smartcrawl_Settings::get_component_options( Smartcrawl_Settings::COMP_SOCIAL );
		if ( empty( $settings['og-enable'] ) ) { return false; }
		$this->inject_global_tags();

		$this->_is_done = true;

		return is_singular()
			? $this->inject_specific_og_tags()
			: $this->inject_generic_og_tags();
	}

	/**
	 * Injects globally valid tags - regardless of context
	 */
	public function inject_global_tags() {
		$settings = Smartcrawl_Settings::get_component_options( Smartcrawl_Settings::COMP_SOCIAL );
		if ( ! empty( $settings['fb-app-id'] ) ) {
			$this->print_og_tag( 'fb:app_id', $settings['fb-app-id'] );
		}
	}

	public function get_post_images() {
		$raw = smartcrawl_get_value( 'opengraph' );
		return ! empty( $raw['images'] ) ? $raw['images'] : array();
	}

	public function get_tag_value( $suffix ) {
		$raw = smartcrawl_get_value( 'opengraph' );
		$post = get_post();
		return empty( $raw[ $suffix ] )
			? $this->get_generic_og_tag_value( "og-{$suffix}", get_post_type( $post ) )
			: $raw[ $suffix ]
		;
	}

	/**
	 * Attempt to use post-specific meta setup to resolve tag values
	 *
	 * Fallback to generic, global values
	 *
	 * @return void
	 */
	public function inject_specific_og_tags() {
		$post = get_post();
		if ( ! is_object( $post ) || empty( $post->ID ) ) { return false; }

		// Check custom values for OG disabled per post first
		$raw = smartcrawl_get_value( 'opengraph' );
		if ( ! is_array( $raw ) ) { $raw = array(); }
		if ( ! empty( $raw['disabled'] ) ) { return false; // Bail out, no OG here
		}
		if ( isset( $raw['disabled'] ) ) { unset( $raw['disabled'] ); // So we can carry on with the logic
		}
		$image_urls = array();

		// Attempt to use featured image, if any
		// Do this first, so we can fall back to generic stuff
		// if needs be
		if ( has_post_thumbnail( $post ) ) {
			$url = get_the_post_thumbnail_url();
			if ( ! empty( $url ) ) {
				$this->print_og_tag( 'og:image', $url );
				$image_urls[] = $url;
			}
		}

		$raw = array_filter( $raw );
		if ( empty( $raw ) ) { return $this->inject_generic_og_tags(); }

		// Separately process any other images
		$images = $this->get_post_images();
		unset( $raw['images'] );
		foreach ( $images as $img ) {
			if ( in_array( $img, $image_urls ) ) { continue; // Do not double-print images
			}			$this->print_og_tag( 'og:image', $img );
			$image_urls[] = $img;
		}

		$supported_keys = array( 'title', 'description', 'images' );
		foreach ( $supported_keys as $key ) {
			$value = $this->get_tag_value( $key );
			if ( empty( $value ) ) { continue; }

			if ( 'images' === $key ) {
				if ( is_array( $value ) ) {
					$clean = array();
					foreach ( $value as $img ) {
						if ( in_array( $img, $image_urls ) ) { continue; // Do not double-print images
						}						$clean[] = $img;
						$image_urls[] = $img;
					}
					$value = $clean;
				} elseif ( ! empty( $value ) ) {
					if ( in_array( $value, $image_urls ) ) { continue; // Do not double-print images
					}					$image_urls[] = $value;
				}
			}

			$this->print_og_tag( "og:{$key}", $value );
		}

		$date = get_the_date( 'Y-m-d\TH:i:s', $post );
		$this->print_og_tag( 'article:published_time', $date );

		$user_id = $post->post_author;
		if ( ! empty( $user_id ) ) {
			$user = Smartcrawl_Model_User::get( $user_id );
			$this->print_og_tag( 'article:author', $user->get_full_name() );
		}
	}

	/**
	 * Use global setup to resolve tag values
	 */
	public function inject_generic_og_tags() {
		$keys = array(
			'og-title' => '',
			'og-description' => '',
			'og-images' => array(),
		);
		$type = false;

		if ( is_front_page() ) { $type = 'home'; } elseif ( is_search() ) { $type = 'search'; } elseif ( is_category() ) { $type = 'category'; } elseif ( is_tag() ) { $type = 'post_tag'; } elseif ( is_tax() ) {
			$term = get_queried_object();
			if ( ! empty( $term ) && is_object( $term ) && ! empty( $term->taxonomy ) ) {
				$type = $term->taxonomy;
			}
		} elseif ( is_singular() ) {
			$type = get_post_type();
		}

		if ( empty( $type ) ) {
			return false; // We don't know what to do here
		}

		$smartcrawl_options = Smartcrawl_Settings::get_options();
		if ( empty( $smartcrawl_options[ "og-active-{$type}" ] ) || ! $smartcrawl_options[ "og-active-{$type}" ] ) {
			return false;
		}

		if ( is_category() || is_tag() || is_tax() ) {
			$term_obj = get_queried_object();
			$opengraph = smartcrawl_get_term_meta( $term_obj, $type, 'opengraph' );
			if ( ! empty( $opengraph ) ) {
				if ( ! empty( $opengraph['disabled'] ) ) { return false; }
				foreach ( $opengraph as $og_item => $value ) {
					if ( ! in_array( "og-{$og_item}", array_keys( $keys ) ) ) { continue; }
					$keys[ "og-{$og_item}" ] = $value;
				}
			}
		}

		foreach ( $keys as $key => $val ) {
			if ( ! empty( $val ) ) { $this->print_og_tag( $key, $val ); } else { $this->print_og_tag( $key, $this->get_generic_og_tag_value( $key, $type ) ); }
		}
	}

	/**
	 * Gets a generic OG tag value
	 *
	 * Value will be resolved to what's in OG settings, or
	 * alternatively will fall back to title/description
	 * resolution for those tags specifically.
	 *
	 * @param string $key OG tag internal key representation
	 * @param string $type Entity type
	 *
	 * @return string|bool Either a resolved tag value, or false on failure
	 */
	public function get_generic_og_tag_value( $key, $type ) {
		if ( empty( $key ) || empty( $type ) ) { return false; }

		$smartcrawl_options = Smartcrawl_Settings::get_options();
		if ( empty( $smartcrawl_options[ "{$key}-{$type}" ] ) ) {
			$value = false;
			if ( class_exists( 'Smartcrawl_OnPage' ) && 'og-title' === $key ) {
				$value = Smartcrawl_OnPage::get()->get_title();
			} elseif ( class_exists( 'Smartcrawl_OnPage' ) && 'og-description' === $key ) {
				$value = Smartcrawl_OnPage::get()->get_description();
			}
			return $value;
		}

		return $smartcrawl_options[ "{$key}-{$type}" ];
	}

	/**
	 * Actually prints the OG tag
	 *
	 * @param string $tag Tagname or tagname-like string to print
	 * @param mixed  $value Tag value as string, or list of string tag values
	 *
	 * @return bool
	 */
	public function print_og_tag( $tag, $value ) {
		if ( empty( $tag ) || empty( $value ) ) { return false; }

		$og_tag = $this->get_og_tag( $tag, $value );
		if ( empty( $og_tag ) ) { return false; }

		echo $og_tag;
		return true;
	}

	/**
	 * Gets the markup for an OG tag
	 *
	 * @param string $tag Tagname or tagname-like string to print
	 * @param mixed  $value Tag value as string, or list of string tag values
	 *
	 * @return string
	 */
	public function get_og_tag( $tag, $value ) {
		if ( empty( $tag ) || empty( $value ) ) { return false; }

		if ( is_array( $value ) ) {
			$results = array();
			foreach ( $value as $val ) {
				$tmp = $this->get_og_tag( $tag, $val );
				if ( ! empty( $tmp ) ) { $results[] = $tmp; }
			}
			return join( "\n", $results );
		}

		$tag = preg_replace( '/-/', ':', $tag );
		if ( 'og:images' === $tag ) { $tag = 'og:image'; }

		$value = smartcrawl_replace_vars( $value, get_queried_object() );
		$value = wp_strip_all_tags( $value );

		return '<meta property="' . esc_attr( $tag ) . '" content="' . esc_attr( $value ) . '" />' . "\n";	     	 	 	  		 		
	}
}