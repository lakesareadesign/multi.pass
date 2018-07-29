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
	 * Singleton instance getter
	 *
	 * @return Smartcrawl_OpenGraph_Printer instance
	 */
	public static function get() {
		if ( empty( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * First-line dispatching of OG tags injection
	 */
	public function dispatch_og_tags_injection() {
		if ( ! ! $this->_is_done ) {
			return false;
		}

		$settings = Smartcrawl_Settings::get_component_options( Smartcrawl_Settings::COMP_SOCIAL );
		if ( empty( $settings['og-enable'] ) ) {
			return false;
		}
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

		$this->inject_type();
		$this->inject_url();
	}

	/**
	 * Actually prints the OG tag
	 *
	 * @param string $tag Tagname or tagname-like string to print
	 * @param mixed $value Tag value as string, or list of string tag values
	 *
	 * @return bool
	 */
	public function print_og_tag( $tag, $value ) {
		if ( empty( $tag ) || empty( $value ) ) {
			return false;
		}

		$og_tag = $this->get_og_tag( $tag, $value );
		if ( empty( $og_tag ) ) {
			return false;
		}

		echo wp_kses( $og_tag, $this->get_allowed_tags() );

		return true;
	}

	/**
	 * Gets the markup for an OG tag
	 *
	 * @param string $tag Tagname or tagname-like string to print
	 * @param mixed $value Tag value as string, or list of string tag values
	 *
	 * @return string
	 */
	public function get_og_tag( $tag, $value ) {
		if ( empty( $tag ) || empty( $value ) ) {
			return false;
		}

		if ( is_array( $value ) ) {
			$results = array();
			foreach ( $value as $val ) {
				$tmp = $this->get_og_tag( $tag, $val );
				if ( ! empty( $tmp ) ) {
					$results[] = $tmp;
				}
			}

			return join( "\n", $results );
		}

		$tag = preg_replace( '/-/', ':', $tag );
		$value = smartcrawl_replace_vars( $value, get_queried_object() );
		$value = wp_strip_all_tags( $value );

		return '<meta property="' . esc_attr( $tag ) . '" content="' . esc_attr( $value ) . '" />' . "\n";
	}

	private function inject_type() {
		if ( is_front_page() || is_home() ) {
			$type = 'website';
		} elseif ( is_singular() ) {
			$type = 'article';
		} else {
			$type = 'object';
		}
		$this->print_og_tag( 'og:type', $type );
	}

	private function inject_url() {
		$onpage = Smartcrawl_OnPage::get();
		$canonical_url = $onpage->get_canonical_url();

		if ( ! empty( $canonical_url ) && ! is_wp_error( $canonical_url ) ) {
			$this->print_og_tag( 'og:url', $canonical_url );
		}
	}

	/**
	 * Attempt to use post-specific meta setup to resolve tag values
	 *
	 * Fallback to generic, global values
	 *
	 * @return bool
	 */
	public function inject_specific_og_tags() {
		$post = get_post();
		if ( ! is_object( $post ) || empty( $post->ID ) ) {
			return false;
		}

		// Check custom values for OG disabled per post first
		$raw = smartcrawl_get_value( 'opengraph' );
		if ( ! is_array( $raw ) ) {
			$raw = array();
		}
		if ( ! empty( $raw['disabled'] ) ) {
			return false; // Bail out, no OG here
		}
		if ( isset( $raw['disabled'] ) ) {
			unset( $raw['disabled'] ); // So we can carry on with the logic
		}
		$image_urls = array();

		// Attempt to use featured image, if any
		// Do this first, so we can fall back to generic stuff
		// if needs be
		if ( has_post_thumbnail( $post ) ) {
			$url = get_the_post_thumbnail_url();
			if ( ! empty( $url ) ) {
				$this->print_og_images( $url );
				$image_urls[] = $url;
			}
		}

		$raw = array_filter( $raw );
		if ( empty( $raw ) ) {
			return $this->inject_generic_og_tags();
		}

		// Separately process any other images
		$images = $this->get_post_images();
		unset( $raw['images'] );
		foreach ( $images as $img ) {
			if ( in_array( $img, $image_urls, true ) ) {
				continue; // Do not double-print images
			}
			$this->print_og_images( $img );
			$image_urls[] = $img;
		}

		$supported_keys = array( 'title', 'description', 'images' );
		foreach ( $supported_keys as $key ) {
			$value = $this->get_tag_value( $key );
			if ( empty( $value ) ) {
				continue;
			}

			if ( 'images' === $key ) {
				if ( is_array( $value ) ) {
					$clean = array();
					foreach ( $value as $img ) {
						if ( in_array( $img, $image_urls, true ) ) {
							continue; // Do not double-print images
						}
						$clean[] = $img;
						$image_urls[] = $img;
					}
					$value = $clean;
				} elseif ( ! empty( $value ) ) {
					if ( in_array( $value, $image_urls, true ) ) {
						continue; // Do not double-print images
					}
					$image_urls[] = $value;
				}
				$this->print_og_images( $value );
			} else {
				$this->print_og_tag( "og:{$key}", $value );
			}
		}

		$date = get_the_date( 'Y-m-d\TH:i:s', $post );
		$this->print_og_tag( 'article:published_time', $date );

		$user_id = $post->post_author;
		if ( ! empty( $user_id ) ) {
			$user = Smartcrawl_Model_User::get( $user_id );
			$this->print_og_tag( 'article:author', $user->get_full_name() );
		}
	}

	public function print_og_images( $values ) {
		if ( empty( $values ) ) {
			return;
		}

		$values = is_string( $values ) ? array( $values ) : $values;

		$image_tags = array();
		foreach ( $values as $value ) {
			$image_tags[] = $this->get_og_tag( 'og:image', $value );

			// Try to inject image width and height
			$attachment = smartcrawl_get_attachment_by_url( trim( $value ) );
			if ( $attachment ) {
				$image_tags[] = $this->get_og_tag( 'og:image:width', $attachment['width'] );
				$image_tags[] = $this->get_og_tag( 'og:image:height', $attachment['height'] );
			}
		}
		$markup = join( "\n", array_filter( $image_tags ) );
		echo wp_kses( $markup, $this->get_allowed_tags() );
	}

	/**
	 * Use global setup to resolve tag values
	 * @return boolean
	 */
	public function inject_generic_og_tags() {
		$keys = array(
			'og-title'       => '',
			'og-description' => '',
			'og-images'      => array(),
		);
		$type = false;

		if ( is_front_page() ) {
			$type = 'home';
		} elseif ( is_search() ) {
			$type = 'search';
		} elseif ( is_category() ) {
			$type = 'category';
		} elseif ( is_tag() ) {
			$type = 'post_tag';
		} elseif ( is_tax() ) {
			$term = get_queried_object();
			if ( ! empty( $term ) && is_object( $term ) && ! empty( $term->taxonomy ) ) {
				$type = $term->taxonomy;
			}
		} elseif ( is_singular() ) {
			$type = get_post_type();
		} elseif ( is_author() ) {
			$type = 'author';
		} elseif ( is_date() ) {
			$type = 'date';
		} elseif ( is_post_type_archive() ) {
			$post_type = get_queried_object();
			if ( is_a( $post_type, 'WP_Post_Type' ) ) {
				$type = Smartcrawl_Onpage_Settings::PT_ARCHIVE_PREFIX . $post_type->name;
			}
		}

		if ( empty( $type ) ) {
			return false; // We don't know what to do here
		}

		$smartcrawl_options = Smartcrawl_Settings::get_options();
		if ( empty( $smartcrawl_options["og-active-{$type}"] ) || ! $smartcrawl_options["og-active-{$type}"] ) {
			return false;
		}

		if ( is_category() || is_tag() || is_tax() ) {
			$term_obj = get_queried_object();
			$opengraph = smartcrawl_get_term_meta( $term_obj, $type, 'opengraph' );
			if ( ! empty( $opengraph ) ) {
				if ( ! empty( $opengraph['disabled'] ) ) {
					return false;
				}
				foreach ( $opengraph as $og_item => $value ) {
					if ( ! in_array( "og-{$og_item}", array_keys( $keys ), true ) ) {
						continue;
					}
					$keys["og-{$og_item}"] = $value;
				}
			}
		}

		foreach ( $keys as $key => $val ) {
			if ( 'og-images' === $key ) {
				$this->print_og_images(
					! empty( $val ) ? $val : $this->get_generic_og_tag_value( $key, $type )
				);
			} else {
				$this->print_og_tag(
					$key,
					! empty( $val ) ? $val : $this->get_generic_og_tag_value( $key, $type )
				);
			}
		}

		return true;
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
		if ( empty( $key ) || empty( $type ) ) {
			return false;
		}

		$smartcrawl_options = Smartcrawl_Settings::get_options();
		if ( empty( $smartcrawl_options["{$key}-{$type}"] ) ) {
			$value = false;
			if ( class_exists( 'Smartcrawl_OnPage' ) && 'og-title' === $key ) {
				$value = Smartcrawl_OnPage::get()->get_title();
			} elseif ( class_exists( 'Smartcrawl_OnPage' ) && 'og-description' === $key ) {
				$value = Smartcrawl_OnPage::get()->get_description();
			}

			return $value;
		}

		return $smartcrawl_options["{$key}-{$type}"];
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
			: $raw[ $suffix ];
	}

	/**
	 * @return array
	 */
	private function get_allowed_tags() {
		$allowed_tags = array(
			'meta' => array(
				'property' => array(),
				'content'  => array()
			)
		);

		return $allowed_tags;
	}
}