<?php
/**
 * Provide backwards compatibility with older versions of WordPress.
 *
 * @package   Cookd
 * @copyright Copyright (c) 2016, Shay Bocks
 * @license   GPL-2.0+
 * @link      http://www.feastdesignco.com/cookd/
 * @since     1.0.0
 */

if ( ! function_exists( '_navigation_markup' ) ) {
	/**
	 * Wraps passed links in navigational markup.
	 *
	 * @since 4.1.0
	 * @access private
	 *
	 * @param string $links              Navigational links.
	 * @param string $class              Optional. Custom class for nav element. Default: 'posts-navigation'.
	 * @param string $screen_reader_text Optional. Screen reader text for nav element. Default: 'Posts navigation'.
	 * @return string Navigation template tag.
	 */
	function _navigation_markup( $links, $class = 'posts-navigation', $screen_reader_text = '' ) {
		if ( empty( $screen_reader_text ) ) {
			$screen_reader_text = __( 'Posts navigation', 'cookd' );
		}
		$template = '
		<nav class="navigation %1$s" role="navigation">
			<h2 class="screen-reader-text">%2$s</h2>
			<div class="nav-links">%3$s</div>
		</nav>';
		/**
		 * Filters the navigation markup template.
		 *
		 * Note: The filtered template HTML must contain specifiers for the navigation
		 * class (%1$s), the screen-reader-text value (%2$s), and placement of the
		 * navigation links (%3$s):
		 *
		 *     <nav class="navigation %1$s" role="navigation">
		 *         <h2 class="screen-reader-text">%2$s</h2>
		 *         <div class="nav-links">%3$s</div>
		 *     </nav>
		 *
		 * @since 4.4.0
		 *
		 * @param string $template The default template.
		 * @param string $class    The class passed by the calling function.
		 * @return string Navigation template.
		 */
		$template = apply_filters( 'navigation_markup_template', $template, $class );
		return sprintf( $template, sanitize_html_class( $class ), esc_html( $screen_reader_text ), $links );
	}
}

if ( ! function_exists( 'get_the_posts_pagination' ) ) {
	/**
	 * Retrieves a paginated navigation to next/previous set of posts, when applicable.
	 *
	 * @since 4.1.0
	 *
	 * @param array $args {
	 *     Optional. Default pagination arguments, see paginate_links().
	 *
	 *     @type string $screen_reader_text Screen reader text for navigation element.
	 *                                      Default 'Posts navigation'.
	 * }
	 * @return string Markup for pagination links.
	 */
	function get_the_posts_pagination( $args = array() ) {
		$navigation = '';
		// Don't print empty markup if there's only one page.
		if ( $GLOBALS['wp_query']->max_num_pages > 1 ) {
			$args = wp_parse_args( $args, array(
				'mid_size'           => 1,
				'prev_text'          => _x( 'Previous', 'previous post', 'cookd' ),
				'next_text'          => _x( 'Next', 'next post', 'cookd' ),
				'screen_reader_text' => __( 'Posts navigation', 'cookd' ),
			) );
			// Make sure we get a string back. Plain is the next best thing.
			if ( isset( $args['type'] ) && 'array' == $args['type'] ) {
				$args['type'] = 'plain';
			}
			// Set up paginated links.
			$links = paginate_links( $args );
			if ( $links ) {
				$navigation = _navigation_markup( $links, 'pagination', $args['screen_reader_text'] );
			}
		}
		return $navigation;
	}
}
