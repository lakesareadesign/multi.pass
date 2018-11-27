<?php

class Smartcrawl_OpenGraph_Value_Helper extends Smartcrawl_Type_Traverser {

	private $title = '';
	private $description = '';
	private $images = array();
	private $enabled = false;

	public function __construct() {
		$this->traverse();
	}

	public function get_title() {
		return $this->title;
	}

	public function get_description() {
		return $this->description;
	}

	public function get_images() {
		return array_unique( array_map( 'trim', $this->images ) );
	}

	public function is_enabled() {
		return $this->enabled;
	}

	private function get_options() {
		return Smartcrawl_Settings::get_options();
	}

	private function from_options( $location ) {
		$options = $this->get_options();

		$title = smartcrawl_get_array_value( $options, 'og-title-' . $location );
		$description = smartcrawl_get_array_value( $options, 'og-description-' . $location );
		$images = smartcrawl_get_array_value( $options, 'og-images-' . $location );
		$enabled = smartcrawl_get_array_value( $options, 'og-active-' . $location );

		$title = smartcrawl_replace_vars( wp_strip_all_tags( strval( $title ) ), $this->get_queried_object() );
		$description = smartcrawl_replace_vars( wp_strip_all_tags( strval( $description ) ), $this->get_queried_object() );

		$this->title = empty( $title ) ? Smartcrawl_OnPage::get()->get_title() : $title;
		$this->description = empty( $description ) ? Smartcrawl_OnPage::get()->get_description() : $description;
		$this->images = is_array( $images ) ? $images : array();
		$this->enabled = (bool) $enabled;
	}

	private function from_post_meta( $post ) {
		$post_meta = smartcrawl_get_value( 'opengraph', $post->ID );
		$title = smartcrawl_get_array_value( $post_meta, 'title' );
		$description = smartcrawl_get_array_value( $post_meta, 'description' );
		$images = smartcrawl_get_array_value( $post_meta, 'images' );
		$disabled = smartcrawl_get_array_value( $post_meta, 'disabled' );

		if ( ! empty( $title ) ) {
			$this->title = $title;
		}
		if ( ! empty( $description ) ) {
			$this->description = $description;
		}
		if ( is_array( $images ) && ! empty( $images ) ) {
			$this->images = $images;
		}

		// Add featured image as the last resort
		if ( has_post_thumbnail( $post ) ) {
			$this->images[] = get_the_post_thumbnail_url();
		}

		$this->enabled = ! $disabled;
	}

	private function from_term_meta( $term ) {
		$term_meta = smartcrawl_get_term_meta( $term, $term->taxonomy, 'opengraph' );
		$title = smartcrawl_get_array_value( $term_meta, 'title' );
		$description = smartcrawl_get_array_value( $term_meta, 'description' );
		$images = smartcrawl_get_array_value( $term_meta, 'images' );
		$disabled = smartcrawl_get_array_value( $term_meta, 'disabled' );

		if ( ! empty( $title ) ) {
			$this->title = $title;
		}
		if ( ! empty( $description ) ) {
			$this->description = $description;
		}
		if ( is_array( $images ) && ! empty( $images ) ) {
			$this->images = $images;
		}
		$this->enabled = ! $disabled;
	}

	public function handle_bp_groups() {
		// TODO: Implement handle_bp_groups() method.
	}

	public function handle_bp_profile() {
		// TODO: Implement handle_bp_profile() method.
	}

	public function handle_woo_shop() {
		$this->handle_singular();
	}

	public function handle_blog_home() {
		$this->from_options( 'home' );
	}

	public function handle_static_home() {
		// TODO: use post type of the current post here instead of 'home'
		$this->from_options( 'home' );
		$post = $this->get_context();

		if ( $this->enabled && is_a( $post, 'WP_Post' ) ) {
			// Now apply any overrides from the individual post's meta
			$this->from_post_meta( $post );
		}
	}

	public function handle_search() {
		$this->from_options( 'search' );
	}

	public function handle_404() {
		// No OG for 404 page
	}

	public function handle_date_archive() {
		$this->from_options( 'date' );
	}

	public function handle_pt_archive() {
		$post_type = $this->get_queried_object();
		if ( is_a( $post_type, 'WP_Post_Type' ) ) {
			$location = Smartcrawl_Onpage_Settings::PT_ARCHIVE_PREFIX . $post_type->name;
			$this->from_options( $location );
		}
	}

	public function handle_tax_archive() {
		$term = $this->get_queried_object();
		if ( is_a( $term, 'WP_Term' ) ) {
			$this->from_options( $term->taxonomy );

			if ( $this->enabled ) {
				// Now apply any overrides from the term taxonomy
				$this->from_term_meta( $term );
			}
		}
	}

	public function handle_author_archive() {
		$this->from_options( 'author' );
	}

	public function handle_archive() {
		// TODO: Implement handle_archive() method.
	}

	public function handle_singular() {
		$post = $this->get_context();
		if ( is_a( $post, 'WP_Post' ) ) {
			$this->from_options( $post->post_type );

			if ( $this->enabled ) {
				// Now apply any overrides from the individual post's meta
				$this->from_post_meta( $post );
			}
		}
	}
}