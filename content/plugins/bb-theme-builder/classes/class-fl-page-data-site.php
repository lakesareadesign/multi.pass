<?php

/**
 * Handles logic for page data site properties.
 *
 * @since 1.0
 */
final class FLPageDataSite {

	/**
	 * Returns the current site title.
	 *
	 * @since 1.0
	 * @return string
	 */
	static public function get_title() {
		return get_bloginfo( 'name' );
	}

	/**
	 * Returns the current site description.
	 *
	 * @since 1.0
	 * @return string
	 */
	static public function get_description() {
		return get_bloginfo( 'description' );
	}

	/**
	 * Returns the current site URL.
	 *
	 * @since 1.0
	 * @return string
	 */
	static public function get_url() {
		return get_bloginfo( 'url' );
	}
}
