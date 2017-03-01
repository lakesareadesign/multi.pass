<?php
/**
 * Outputs OG tags to the page
 */
class Wds_OpenGraph_Printer {

	/**
	 * Singleton instance holder
	 */
	private static $_instance;

	private $_is_running = false;

	public function __construct () {
	}

	/**
	 * Singleton instance getter
	 *
	 * @return object Wds_OpenGraph_Printer instance
	 */
	public static function get () {
		if (empty(self::$_instance)) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	/**
	 * Boot the hooking part
	 */
	public static function run () {
		self::get()->_add_hooks();
	}

	private function _add_hooks () {
		// Do not double-bind
		if (apply_filters('wds-opengraph-is_running', $this->_is_running)) {
			return true;
		}

		add_action('wp_head', array($this, 'dispatch_og_tags_injection'));

		$this->_is_running = true;
	}

	/**
	 * First-line dispatching of OG tags injection
	 */
	public function dispatch_og_tags_injection () {
		return is_singular()
			? $this->inject_specific_og_tags()
			: $this->inject_generic_og_tags()
		;
	}

	/**
	 * Attempt to use post-specific meta setup to resolve tag values
	 * Fallback to generic, global values
	 */
	public function inject_specific_og_tags () {
		$post = get_post();
		if (!is_object($post) || empty($post->ID)) return false;

		$raw = wds_get_value('opengraph');
		if (empty($raw)) return $this->inject_generic_og_tags();

		// Attempt to use featured image, if any
		if (has_post_thumbnail($post)) {
			$url = get_the_post_thumbnail_url();
			if (!empty($url)) $this->print_og_tag("og:image", $url);
		}

		// Separately process any other images
		$images = !empty($raw['images']) ? $raw['images'] : array();
		unset($raw['images']);
		foreach ($images as $img) {
			$this->print_og_tag('og:image', $img);
		}

		$supported_keys = array('title', 'description', 'images');
		foreach ($supported_keys as $key) {
			$value = empty($raw[$key])
				? $this->get_generic_og_tag_value("og-{$key}", get_post_type($post))
				: $raw[$key]
			;
			if (empty($value)) continue;

			$this->print_og_tag("og:{$key}", $value);
		}
	}

	/**
	 * Use global setup to resolve tag values
	 */
	public function inject_generic_og_tags () {
		$keys = array(
			'og-title',
			'og-description',
			'og-images',
		);
		$type = false;

		if (is_front_page()) $type = 'home';
		else if (is_search()) $type = 'search';
		else if (is_category()) $type = 'category';
		else if (is_tag()) $type = 'tag';
		else if (is_tax()) {
			$term = get_queried_object();
			if (!empty($term) && is_object($term) && !empty($term->taxonomy)) {
				$type = $term->taxonomy;
			}
		} else if (is_singular()) {
			$type = get_post_type();
		}

		if (empty($type)) {
			return false; // We don't know what to do here
		}

		foreach ($keys as $key) {
			$this->print_og_tag($key, $this->get_generic_og_tag_value($key, $type));
		}
	}

	public function get_generic_og_tag_value ($key, $type) {
		if (empty($key) || empty($type)) return false;

		$wds_options = get_wds_options();
		if (empty($wds_options["{$key}-{$type}"])) return false;

		return $wds_options["{$key}-{$type}"];
	}

	/**
	 * Actually prints the OG tag
	 *
	 * @param string $tag Tagname or tagname-like string to print
	 * @param mixed $value Tag value as string, or list of string tag values
	 *
	 * @return bool
	 */
	public function print_og_tag ($tag, $value) {
		if (empty($tag) || empty($value)) return false;

		$og_tag = $this->get_og_tag($tag, $value);
		if (empty($og_tag)) return false;

		echo $og_tag;
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
	public function get_og_tag ($tag, $value) {
		if (empty($tag) || empty($value)) return false;

		if (is_array($value)) {
			$results = array();
			foreach ($value as $val) {
				$tmp = $this->get_og_tag($tag, $val);
				if (!empty($tmp)) $results[] = $tmp;
			}
			return join("\n", $results);
		}

		$tag = preg_replace('/-/', ':', $tag);
		if ('og:images' === $tag) $tag = 'og:image';

		$value = wds_replace_vars($value, get_queried_object());
		$value = wp_strip_all_tags($value);

		return '<meta property="' . esc_attr($tag) . '" content="' . esc_attr($value) . '" />';
	}
}