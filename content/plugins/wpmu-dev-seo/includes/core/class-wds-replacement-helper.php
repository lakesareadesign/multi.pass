<?php

class Smartcrawl_Replacement_Helper extends Smartcrawl_Type_Traverser {

	private $specific_replacements;
	private $bp_data;
	private $subject;

	/**
	 * Singleton instance
	 *
	 * @var Smartcrawl_Replacement_Helper
	 */
	private static $_instance;

	/**
	 * Constructor
	 */
	private function __construct() {
	}

	/**
	 * Singleton instance getter
	 *
	 * @return Smartcrawl_Replacement_Helper instance
	 */
	private static function get() {
		if ( empty( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public static function replace( $subject, $context_object = null ) {
		if ( ! is_string( $subject ) ) {
			return $subject;
		}

		$instance = self::get();
		$instance->subject = $subject;
		$resolver = $instance->get_resolver();

		if ( $context_object ) {
			if ( $instance->is_post_object( $context_object ) ) {
				$resolver->simulate_post( $context_object );
			} elseif ( $instance->is_term_object( $context_object ) ) {
				$resolver->simulate_taxonomy_term( $context_object );
			} elseif ( $instance->is_post_type_object( $context_object ) ) {
				$resolver->simulate_post_type( $context_object );
			}
		}

		$instance->traverse();
		$replacements = array_merge(
			$instance->get_general_replacements(),
			$instance->get_specific_replacements()
		);

		foreach ( $replacements as $macro => $replacement ) {
			$subject = str_replace( $macro, $instance->process_replacement_value( $replacement ), $subject );
		}

		if ( $context_object ) {
			$resolver->stop_simulation();
		}

		return preg_replace( '/%%[a-zA-Z_]*%%/', '', $subject );
	}

	public static function get_dynamic_replacements( $subject, $context_object ) {
		if ( ! is_string( $subject ) ) {
			return array();
		}
		$instance = self::get();

		return $instance->find_dynamic_replacements( $subject, $context_object );
	}

	private function is_post_type_object( $object ) {
		return is_a( $object, 'WP_Post_Type' );
	}

	private function is_term_object( $context_object ) {
		return is_a( $context_object, 'WP_Term' );
	}

	private function is_post_object( $context_object ) {
		return is_a( $context_object, 'WP_Post' );
	}

	private function process_replacement_value( $replacement ) {
		return wp_strip_all_tags( $replacement );
	}

	public function get_bp_data() {
		if ( empty( $this->bp_data ) && function_exists( 'buddypress' ) ) {
			$this->bp_data = buddypress();
		}

		return $this->bp_data;
	}

	public function set_bp_data( $bp_data ) {
		$this->bp_data = $bp_data;
	}

	private function get_specific_replacements() {
		return empty( $this->specific_replacements ) ? array() : $this->specific_replacements;
	}

	private function get_general_replacements() {
		$query = $this->get_query_context();
		$paged = intval( $query->get( 'paged' ) );
		$max_num_pages = isset( $query->max_num_pages ) ? $query->max_num_pages : 1;
		$page_x_of_y = esc_html__( 'Page %1$s of %2$s' );
		$smartcrawl_options = Smartcrawl_Settings::get_options();
		$preset_sep = ! empty( $smartcrawl_options['preset-separator'] ) ? $smartcrawl_options['preset-separator'] : 'pipe';
		$separator = ! empty( $smartcrawl_options['separator'] ) ? $smartcrawl_options['separator'] : smartcrawl_get_separators( $preset_sep );
		$pagenum = $paged;
		if ( 0 === $pagenum ) {
			$pagenum = $max_num_pages > 1 ? 1 : '';
		}

		return array(
			'%%sitename%%'         => get_bloginfo( 'name' ),
			'%%sitedesc%%'         => get_bloginfo( 'description' ),
			'%%page%%'             => $paged !== 0 ? sprintf( $page_x_of_y, $paged, $max_num_pages ) : '',
			'%%spell_page%%'       => $paged !== 0 ? sprintf( $page_x_of_y, smartcrawl_spell_number( $paged ), smartcrawl_spell_number( $max_num_pages ) ) : '',
			'%%pagetotal%%'        => $max_num_pages > 1 ? $max_num_pages : '',
			'%%spell_pagetotal%%'  => $max_num_pages > 1 ? smartcrawl_spell_number( $max_num_pages ) : '',
			'%%pagenumber%%'       => empty( $pagenum ) ? '' : $pagenum,
			'%%spell_pagenumber%%' => empty( $pagenum ) ? '' : smartcrawl_spell_number( $pagenum ),
			'%%currenttime%%'      => date_i18n( get_option( 'time_format' ) ),
			'%%currentdate%%'      => date_i18n( get_option( 'date_format' ) ),
			'%%currentmonth%%'     => date_i18n( 'F' ),
			'%%currentyear%%'      => date_i18n( 'Y' ),
			'%%sep%%'              => $separator,
		);
	}

	public function handle_bp_groups() {
		$bp = $this->get_bp_data();
		$current_group = empty( $bp->groups->current_group ) ? null : $bp->groups->current_group;

		$this->specific_replacements = array(
			'%%bp_group_name%%'        => $current_group ? $current_group->name : '',
			'%%bp_group_description%%' => $current_group ? $current_group->description : '',
		);
	}

	public function handle_bp_profile() {
		$bp_active = function_exists( 'buddypress' );

		$this->specific_replacements = array(
			'%%bp_user_username%%'  => $bp_active ? bp_get_displayed_user_username() : '',
			'%%bp_user_full_name%%' => $bp_active ? bp_get_displayed_user_fullname() : '',
		);
	}

	public function handle_woo_shop() {
		// TODO: Implement handle_woo_shop() method.
	}

	public function handle_blog_home() {
		// No context specific values available on blog index page
	}

	public function handle_static_home() {
		$this->handle_singular();
	}

	public function handle_search() {
		$query = $this->get_query_context();

		$this->specific_replacements = array(
			'%%searchphrase%%' => esc_html( $query->get( 's' ) ),
		);
	}

	public function handle_404() {
		// No context specific values available on the 404 page
	}

	public function handle_date_archive() {
		$this->specific_replacements = array(
			'%%date%%' => $this->get_date_for_archive(),
		);
	}

	public function handle_pt_archive() {
		$post_type = $this->get_queried_object();
		$is_pt_archive = $this->is_post_type_object( $post_type );

		$this->specific_replacements = array(
			'%%pt_plural%%' => $is_pt_archive ? $post_type->labels->name : '',
			'%%pt_single%%' => $is_pt_archive ? $post_type->labels->singular_name : '',
		);
	}

	public function handle_tax_archive() {
		$term = $this->get_queried_object();
		$term_data = $this->is_term_object( $term ) ? (array) $term : array();
		$term_data = wp_parse_args( $term_data, $this->get_term_defaults() );

		$this->specific_replacements = array(
			'%%id%%'               => $term_data['term_id'],
			'%%term_title%%'       => $term_data['name'],
			'%%term_description%%' => $term_data['description'],
		);

		$custom_replacements = $this->find_dynamic_replacements( $this->subject, $term );
		$this->specific_replacements = wp_parse_args( $this->specific_replacements, $custom_replacements );

		if ( $term_data['taxonomy'] === 'category' ) {
			$this->specific_replacements['%%category%%'] = $term_data['name'];
			$this->specific_replacements['%%category_description%%'] = $term_data['description'];
		} elseif ( $term_data['taxonomy'] === 'post_tag' ) {
			$this->specific_replacements['%%tag%%'] = $term_data['name'];
			$this->specific_replacements['%%tag_description%%'] = $term_data['description'];
		}
	}

	public function handle_author_archive() {
		$query = $this->get_query_context();
		$user_id = $query->get( 'author' );

		$this->specific_replacements = array(
			'%%name%%'   => empty( $user_id ) ? '' : get_the_author_meta( 'display_name', $user_id ),
			'%%userid%%' => (string) $user_id,
		);
	}

	public function handle_archive() {
		// No context specific values available on the archive page
	}

	public function handle_singular() {
		$post = $this->get_context();
		$post_data = $this->is_post_object( $post ) ? (array) $post : array();
		$post_data = wp_parse_args( $post_data, $this->get_post_defaults() );

		$this->specific_replacements = array(
			'%%date%%'         => mysql2date( get_option( 'date_format' ), $post_data['post_date'] ),
			'%%excerpt%%'      => smartcrawl_get_trimmed_excerpt( $post_data['post_excerpt'], $post_data['post_content'] ),
			'%%excerpt_only%%' => $post_data['post_excerpt'],
			'%%id%%'           => $post_data['ID'],
			'%%modified%%'     => $post_data['post_modified'],
			'%%name%%'         => empty( $post_data['post_author'] ) ? '' : get_the_author_meta( 'display_name', $post_data['post_author'] ),
			'%%title%%'        => $post_data['post_title'],
			'%%userid%%'       => $post_data['post_author'],
		);

		$custom_replacements = $this->find_dynamic_replacements( $this->subject, $post );
		$this->specific_replacements = wp_parse_args( $this->specific_replacements, $custom_replacements );

		if ( $post_data['post_type'] === 'attachment' ) {
			$this->specific_replacements['%%caption%%'] = $post_data['post_excerpt'];
		} elseif ( $post_data['post_type'] === 'post' ) {
			$this->specific_replacements['%%category%%'] = get_the_category_list( ', ', '', $post_data['ID'] );
		}
	}

	private function get_hierarchical_terms_for_post_type( $post ) {
		$custom_taxonomy = $this->get_post_type_taxonomy( $post );
		if ( $custom_taxonomy ) {
			$terms = wp_get_post_terms( $post->ID, $custom_taxonomy, array( 'fields' => 'names' ) );
			if ( ! is_wp_error( $terms ) ) {
				return implode( ', ', $terms );
			}
		}

		return '';
	}

	private function get_post_type_taxonomy( $post ) {
		$taxonomies = get_object_taxonomies( $post );

		return empty( $taxonomies ) ? '' : array_shift( $taxonomies );
	}

	private function get_post_defaults() {
		return array(
			'ID'                => '',
			'post_author'       => '',
			'post_name'         => '',
			'post_type'         => '',
			'post_title'        => '',
			'post_date'         => '',
			'post_date_gmt'     => '',
			'post_content'      => '',
			'post_excerpt'      => '',
			'post_status'       => '',
			'comment_status'    => '',
			'ping_status'       => '',
			'post_password'     => '',
			'post_parent'       => '',
			'post_modified'     => '',
			'post_modified_gmt' => '',
			'comment_count'     => '',
			'menu_order'        => '',
		);
	}

	private function get_term_defaults() {
		return array(
			'name'             => '',
			'term_taxonomy_id' => '',
			'count'            => '',
			'description'      => '',
			'term_id'          => '',
			'taxonomy'         => '',
			'term_group'       => '',
			'slug'             => '',
		);
	}

	private function get_date_for_archive() {
		$query = $this->get_query_context();
		$day = $query->get( 'day' );
		$month = $query->get( 'monthnum' );
		$year = $query->get( 'year' );
		$format = '';
		if ( empty( $year ) ) {
			// At the very least we need an year
			return '';
		}
		$timestamp = mktime( 0, 0, 0,
			empty( $month ) ? 1 : $month,
			empty( $day ) ? 1 : $day,
			$year
		);

		if ( ! empty( $day ) ) {
			$format = get_option( 'date_format' );
		} elseif ( ! empty( $month ) ) {
			$format = 'F Y';
		} elseif ( ! empty( $year ) ) {
			$format = 'Y';
		}

		$date = date_i18n( $format, $timestamp );

		return $date;
	}

	private function find_dynamic_replacements( $subject, $context_object ) {
		$term_desc_replacements = $this->find_term_field_replacements( $subject, $context_object, 'ct_desc_', 'description' );
		$subject = str_replace( array_keys( $term_desc_replacements ), '', $subject );

		$term_name_replacements = $this->find_term_field_replacements( $subject, $context_object, 'ct_', 'name' );
		$subject = str_replace( array_keys( $term_name_replacements ), '', $subject );

		$meta_replacements = $this->find_meta_replacements( $subject, $context_object );

		return array_merge( $term_desc_replacements, $term_name_replacements, $meta_replacements );
	}

	private function find_term_field_replacements( $subject, $context_object, $prefix, $term_field ) {
		$pattern = "/(%%{$prefix}[a-z_]+%%)/";
		$matches = array();
		$replacements = array();
		$match_result = preg_match_all( $pattern, $subject, $matches, PREG_PATTERN_ORDER );
		if ( ! empty( $match_result ) ) {
			$placeholders = array_shift( $matches );
			foreach ( array_unique( $placeholders ) as $placeholder ) {
				$taxonomy_name = str_replace( array( "%%$prefix", '%%' ), '', $placeholder );

				$taxonomy = get_taxonomy( $taxonomy_name );
				if ( empty( $taxonomy ) ) {
					continue;
				}

				$terms = $this->get_linked_terms( $context_object, $taxonomy_name );
				if ( ! empty( $terms ) ) {
					$term = array_shift( $terms );
					$replacements[ $placeholder ] = wp_strip_all_tags( get_term_field( $term_field, $term, $taxonomy_name ) );
				}
			}
		}

		return $replacements;
	}

	private function find_meta_replacements( $subject, $context_object ) {
		$prefix = 'cf_';
		$pattern = "/(%%{$prefix}[a-z_]+%%)/";
		$matches = array();
		$replacements = array();
		$match_result = preg_match_all( $pattern, $subject, $matches, PREG_PATTERN_ORDER );
		if ( ! empty( $match_result ) ) {
			$placeholders = array_shift( $matches );
			foreach ( array_unique( $placeholders ) as $placeholder ) {
				$meta_key = str_replace( array( "%%$prefix", '%%' ), '', $placeholder );

				$meta_value = $this->get_meta( $context_object, $meta_key );
				if ( ! empty( $meta_value ) && ! is_array( $meta_value ) && ! is_object( $meta_value ) ) {
					$replacements[ $placeholder ] = wp_strip_all_tags( $meta_value );
				}
			}
		}

		return $replacements;
	}

	private function get_meta( $context_object, $meta_key ) {
		if ( $this->is_post_object( $context_object ) ) {
			return get_post_meta( $context_object->ID, $meta_key, true );
		} elseif ( $this->is_term_object( $context_object ) ) {
			return get_term_meta( $context_object->term_id, $meta_key, true );
		}

		return array();
	}

	private function get_linked_terms( $context_object, $taxonomy_name ) {
		if ( $this->is_post_object( $context_object ) ) {
			return get_the_terms( $context_object->ID, $taxonomy_name );
		} elseif ( $this->is_term_object( $context_object ) && $context_object->taxonomy === $taxonomy_name ) {
			return array( $context_object );
		}

		return array();
	}
}