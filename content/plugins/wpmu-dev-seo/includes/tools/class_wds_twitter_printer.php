<?php

if ( ! class_exists( 'Smartcrawl_Work_Unit' ) ) { require_once( SMARTCRAWL_PLUGIN_DIR . '/core/class_wds_work_unit.php' ); }

/**
 * Outputs Twitter cards data to the page
 */
class Smartcrawl_Twitter_Printer extends Smartcrawl_WorkUnit {

	const CARD_SUMMARY = 'summary';
	const CARD_IMAGE = 'summary_large_image';

	/**
	 * Singleton instance holder
	 */
	private static $_instance;

	private $_is_running = false;
	private $_is_done = false;

	/**
	 * Holds resolver instance
	 *
	 * @var object Smartcrawl_Entity_Resolver instance
	 */
	private $_resolver;

	public function __construct() {
	}

	/**
	 * Singleton instance getter
	 *
	 * @return Smartcrawl_Twitter_Printer instance
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
		if ( $this->apply_filters( 'is_running', $this->_is_running ) ) {
			return true;
		}

		add_action( 'wp_head', array( $this, 'dispatch_tags_injection' ), 50 );
		add_action( 'wds_head-after_output', array( $this, 'dispatch_tags_injection' ) );

		$this->_is_running = true;
	}

	public function dispatch_tags_injection() {
		if ( ! ! $this->_is_done ) { return false; }

		$card = $this->get_card_content();
		if ( empty( $card ) ) { return false; // No card type, nothing to output
		}
		$this->_is_done = true;

		echo $this->get_html_tag( 'card', $card );

		$this->_resolver = Smartcrawl_Endpoint_Resolver::resolve();

		$site = $this->get_site_content();
		if ( ! empty( $site ) ) { echo $this->get_html_tag( 'site', $site ); }

		$title = $this->get_title_content();
		if ( ! empty( $title ) ) { echo $this->get_html_tag( 'title', $title ); }

		$desc = $this->get_description_content();
		if ( ! empty( $desc ) ) { echo $this->get_html_tag( 'description', $desc ); }

		$img = $this->get_image_content();
		if ( ! empty( $img ) ) { echo $this->get_html_tag( 'image', $img ); }
	}

	/**
	 * Card type to render
	 *
	 * @return string Card type
	 */
	public function get_card_content() {
		$meta = array();

		if ( is_singular() ) {
			$meta = smartcrawl_get_value( 'twitter' );
		} elseif ( is_category() || is_tag() || is_tax() ) {
			$term = get_queried_object();
			$type = false;
			if ( ! empty( $term ) && is_object( $term ) && ! empty( $term->taxonomy ) ) {
				$type = $term->taxonomy;
			}
			if ( $type ) { $meta = smartcrawl_get_term_meta( $term, $type, 'twitter' ); }
		}
		if ( ! empty( $meta['disabled'] ) ) { return false; }

		$options = Smartcrawl_Settings::get_component_options( Smartcrawl_Settings::COMP_SOCIAL );
		$card = is_array( $options ) && ! empty( $options['twitter-card-type'] )
			? $options['twitter-card-type']
			: self::CARD_IMAGE
		;

		if ( self::CARD_IMAGE === $card ) {
			// Force summary card if we can't show image
			$url = $this->get_image_content();
			if ( empty( $url ) ) { $card = self::CARD_SUMMARY; }
		}

		return $card;
	}

	/**
	 * Sitewide twitter handle
	 *
	 * @return string Handle
	 */
	public function get_site_content() {
		$options = Smartcrawl_Settings::get_component_options( Smartcrawl_Settings::COMP_SOCIAL );
		return is_array( $options ) && ! empty( $options['twitter_username'] )
			? $options['twitter_username']
			: ''
		;
	}

	/**
	 * Gets image URL to use for this card
	 *
	 * @return string Image URL
	 */
	public function get_image_content() {
		$url = '';

		$meta = smartcrawl_get_value( 'twitter' );

		if ( ! empty( $meta['use_og'] ) ) {
			$img = Smartcrawl_OpenGraph_Printer::get()->get_post_images();
			if ( ! empty( $img[0] ) ) { return $img[0]; }
		}

		if ( is_singular() && has_post_thumbnail() ) {
			$url = get_the_post_thumbnail_url();
		}

		return (string) $url;
	}

	/**
	 * Current resolved title
	 *
	 * @return string Title
	 */
	public function get_title_content() {
		$meta = smartcrawl_get_value( 'twitter' );
		if ( is_category() || is_tag() || is_tax() ) {
			$term = get_queried_object();
			$type = false;
			if ( ! empty( $term ) && is_object( $term ) && ! empty( $term->taxonomy ) ) {
				$type = $term->taxonomy;
			}
			if ( $type ) { $meta = smartcrawl_get_term_meta( $term, $type, 'twitter' ); }
		}

		if ( ! empty( $meta['use_og'] ) ) {
			$post = get_post();
			$title = Smartcrawl_OpenGraph_Printer::get()->get_tag_value( 'title' );
			if ( ! empty( $title ) ) { return $title; }
		} elseif ( ! empty( $meta['title'] ) ) {
			$title = $meta['title'];
			if ( ! empty( $title ) ) { return $title; }
		}

		if ( ! class_exists( 'Smartcrawl_OnPage' ) ) {
			require_once( SMARTCRAWL_PLUGIN_DIR . '/tools/onpage.php' );
		}
		return Smartcrawl_OnPage::get()->get_title();
	}

	/**
	 * Current resolved description
	 *
	 * @return string Description
	 */
	public function get_description_content() {
		$meta = smartcrawl_get_value( 'twitter' );
		if ( is_category() || is_tag() || is_tax() ) {
			$term = get_queried_object();
			$type = false;
			if ( ! empty( $term ) && is_object( $term ) && ! empty( $term->taxonomy ) ) {
				$type = $term->taxonomy;
			}
			if ( $type ) { $meta = smartcrawl_get_term_meta( $term, $type, 'twitter' ); }
		}

		if ( ! empty( $meta['use_og'] ) ) {
			$post = get_post();
			$description = Smartcrawl_OpenGraph_Printer::get()->get_tag_value( 'description' );
			if ( ! empty( $description ) ) { return $description; }
		} elseif ( ! empty( $meta['description'] ) ) {
			$description = $meta['description'];
			if ( ! empty( $description ) ) { return $description; }
		}

		return Smartcrawl_OnPage::get()->get_description();
	}

	/**
	 * Gets HTML element ready for rendering
	 *
	 * @param string $type Element type to prepare
	 * @param string $content Element content
	 *
	 * @return string Element
	 */
	public function get_html_tag( $type, $content ) {
		return '<meta name="twitter:' . esc_attr( $type ) . '" content="' . esc_attr( $content ) . '" />' . "\n";
	}

	public function get_filter_prefix() {
		return 'wds-twitter';
	}
}