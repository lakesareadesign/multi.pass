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
		$this->_is_done = true;

		if (!$this->is_enabled()) {
			return false;
		}

		$card = $this->get_card_content();
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

	private function get_type_string($location)
	{
		// @todo: make sure are location types from Smartcrawl_Endpoint_Resolver are handled
		$mapping = array(
			Smartcrawl_Endpoint_Resolver::L_BLOG_HOME      => 'home',
			Smartcrawl_Endpoint_Resolver::L_STATIC_HOME    => 'home',
			Smartcrawl_Endpoint_Resolver::L_SEARCH         => 'search',
			Smartcrawl_Endpoint_Resolver::L_404            => '404',
			Smartcrawl_Endpoint_Resolver::L_AUTHOR_ARCHIVE => 'author',
			Smartcrawl_Endpoint_Resolver::L_BP_GROUPS      => 'bp_groups',
			Smartcrawl_Endpoint_Resolver::L_BP_PROFILE     => 'bp_profile',
		);

		$queried_object = get_queried_object();
		if (is_a($queried_object, 'WP_Post')) {
			$mapping[ Smartcrawl_Endpoint_Resolver::L_SINGULAR ] = get_post_type($queried_object);
		} elseif (is_a($queried_object, 'WP_Term')) {
			$mapping[ Smartcrawl_Endpoint_Resolver::L_TAX_ARCHIVE ] = $queried_object->taxonomy;
		}

		return isset($mapping[ $location ]) ? $mapping[ $location ] : '';
	}

	private function get_twitter_meta($key)
	{
		$meta = array();
		$queried_object = get_queried_object();
		if (is_a($queried_object, 'WP_Post')) {
			$meta = smartcrawl_get_value('twitter');
		} elseif (is_a($queried_object, 'WP_Term')) {
			$meta = smartcrawl_get_term_meta($queried_object, $queried_object->taxonomy, 'twitter');;
		}

		return isset($meta[ $key ]) ? $meta[ $key ] : '';
	}

	private function get_twitter_setting($key)
	{
		$settings = Smartcrawl_Settings::get_options();
		$resolver = Smartcrawl_Endpoint_Resolver::resolve();
		$type_string = $this->get_type_string($resolver->get_location());
		$setting_key = sprintf('twitter-%s-%s', $key, $type_string);

		return isset($settings[ $setting_key ]) ? $settings[ $setting_key ] : '';
	}

	private function is_enabled()
	{
		$disabled_for_object = (bool)$this->get_twitter_meta('disabled');
		$enabled_for_type = (bool)$this->get_twitter_setting('active');
		return !$disabled_for_object && $enabled_for_type;
	}

	private function get_tag_content($key, $default)
	{
		// Check the object meta for required value
		$value_from_meta = $this->get_twitter_meta($key);
		if (!empty($value_from_meta)) {
			return $value_from_meta;
		}

		// Check the plugin settings for required value
		$value_from_settings = $this->get_twitter_setting($key);
		if (!empty($value_from_settings)) {
			return smartcrawl_replace_vars($value_from_settings, get_queried_object());
		}

		return $default;
	}

	/**
	 * Gets image URL to use for this card
	 *
	 * @return string Image URL
	 */
	public function get_image_content()
	{
		$url = '';
		if (is_singular() && has_post_thumbnail()) {
			$url = get_the_post_thumbnail_url();
		}

		$images = $this->get_tag_content('images', array($url));
		return empty($images) ? '' : $images[0];
	}

	/**
	 * Current resolved title
	 *
	 * @return string Title
	 */
	public function get_title_content()
	{
		if (!class_exists('Smartcrawl_OnPage')) {
			require_once(SMARTCRAWL_PLUGIN_DIR . '/tools/onpage.php');
		}

		return $this->get_tag_content('title', Smartcrawl_OnPage::get()->get_title());
	}

	/**
	 * Current resolved description
	 *
	 * @return string Description
	 */
	public function get_description_content()
	{
		if (!class_exists('Smartcrawl_OnPage')) {
			require_once(SMARTCRAWL_PLUGIN_DIR . '/tools/onpage.php');
		}

		return $this->get_tag_content('description', Smartcrawl_OnPage::get()->get_description());
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