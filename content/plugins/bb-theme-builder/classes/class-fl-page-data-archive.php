<?php

/**
 * Handles logic for page data archive properties.
 *
 * @since 1.0
 */
final class FLPageDataArchive {

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_title() {
		// Category
		if ( is_category() ) {
			$title = single_cat_title( '', false );
		} // Tag
		elseif ( is_tag() ) {
			$title = single_tag_title( '', false );
		} // Taxonomy
		elseif ( is_tax() ) {
			$title = single_term_title( '', false );
		} // Author
		elseif ( is_author() ) {
			$title = get_the_author();
		} // Search
		elseif ( is_search() ) {
			$title = sprintf( _x( 'Search Results: %s', 'Search results title.', 'fl-theme-builder' ), get_search_query() );
		} // Post Type
		elseif ( is_post_type_archive() ) {
			$title = post_type_archive_title( '', false );
		} // Posts Archive
		elseif ( is_home() ) {
			$title = __( 'Posts', 'fl-theme-builder' );
		} // Everything else...
		else {
			$title = get_the_archive_title();
		}

		return $title;
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_term_meta( $settings ) {

		if ( empty( $settings->key ) ) {
			return '';
		}

		$term_id        = 0;
		$queried_object = get_queried_object();

		if ( is_object( $queried_object ) && isset( $queried_object->term_id ) ) {
			$term_id = $queried_object->term_id;
		}

		return get_term_meta( $term_id, $settings->key, true );
	}
}
