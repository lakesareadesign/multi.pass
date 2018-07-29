<?php

class Smartcrawl_Taxonomy extends Smartcrawl_Renderable {
	/**
	 * Static instance
	 *
	 * @var Smartcrawl_Taxonomy
	 */
	private static $_instance;
	/**
	 * State flag
	 *
	 * @var bool
	 */
	private $_is_running = false;

	public function __construct() {
	}

	/**
	 * Boot the hooking part
	 */
	public static function run() {
		self::get()->_add_hooks();
	}

	public function _add_hooks() {
		if ( $this->_is_running ) {
			return false;
		}

		$taxonomy = smartcrawl_get_array_value( $_GET, 'taxonomy' ); // phpcs:ignore -- Can't add nonce to the request
		if ( is_admin() && ! empty( $taxonomy ) ) {
			add_action( sanitize_key( $taxonomy ) . '_edit_form', array(
				&$this,
				'term_additions_form',
			), 10, 2 );
		}

		add_action( 'edit_term', array( &$this, 'update_term' ), 10, 3 );

		$this->_is_running = true;
	}

	/**
	 * Static instance getter
	 */
	public static function get() {
		if ( empty( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function form_row( $id, $label, $desc, $tax_meta, $type = 'text' ) {
		$val = ! empty( $tax_meta[ $id ] ) ? stripslashes( $tax_meta[ $id ] ) : '';

		include SMARTCRAWL_PLUGIN_DIR . 'admin/templates/taxonomy-form-row.php';

	}

	public function term_additions_form( $term, $taxonomy ) {
		$smartcrawl_options = Smartcrawl_Settings::get_options();
		$tax_meta = get_option( 'wds_taxonomy_meta' );

		if ( isset( $tax_meta[ $taxonomy ][ $term->term_id ] ) ) {
			$tax_meta = $tax_meta[ $taxonomy ][ $term->term_id ];
		}

		$taxonomy_object = get_taxonomy( $taxonomy );
		$taxonomy_labels = $taxonomy_object->labels;

		$global_noindex = ! empty( $smartcrawl_options[ 'meta_robots-noindex-' . $term->taxonomy ] )
			? $smartcrawl_options[ 'meta_robots-noindex-' . $term->taxonomy ]
			: false;
		$global_nofollow = ! empty( $smartcrawl_options[ 'meta_robots-nofollow-' . $term->taxonomy ] )
			? $smartcrawl_options[ 'meta_robots-nofollow-' . $term->taxonomy ]
			: false;

		$version = Smartcrawl_Loader::get_version();
		Smartcrawl_Settings_Admin::enqueue_shared_ui( false );

		wp_enqueue_style( 'wds-admin-opengraph', SMARTCRAWL_PLUGIN_URL . '/css/wds-opengraph.css', null, $version );
		wp_enqueue_style( 'wds-qtip2-style', SMARTCRAWL_PLUGIN_URL . '/css/external/jquery.qtip.min.css', null, $version );
		wp_enqueue_style( 'wds-app', SMARTCRAWL_PLUGIN_URL . 'css/app.css', array( 'wds-qtip2-style' ), $version );

		wp_enqueue_media();

		wp_enqueue_script( 'wds-admin', SMARTCRAWL_PLUGIN_URL . 'js/wds-admin.js', array( 'jquery' ), $version );

		wp_localize_script( 'wds-admin', '_wds_admin', array(
			'nonce' => wp_create_nonce( 'wds-admin-nonce' ),
		) );
		wp_enqueue_script( 'wds-admin-opengraph', SMARTCRAWL_PLUGIN_URL . 'js/wds-admin-opengraph.js', array(
			'underscore',
			'jquery',
			'wds-admin',
		), $version );

		include SMARTCRAWL_PLUGIN_DIR . 'admin/templates/term-additions-form.php';

	}

	public function update_term( $term_id, $tt_id, $taxonomy ) {
		$smartcrawl_options = Smartcrawl_Settings::get_options();

		$tax_meta = get_option( 'wds_taxonomy_meta' );
		$post_data = isset( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'update-tag_' . $term_id )
			? stripslashes_deep( $_POST )
			: array();

		foreach ( array( 'title', 'desc', 'bctitle', 'canonical' ) as $key ) {
			$value = isset( $post_data["wds_{$key}"] )
				? $post_data["wds_{$key}"]
				: '';
			if ( 'canonical' === $key ) {
				$value = esc_url_raw( $value );
			} else {
				$value = sanitize_text_field( $value );
			}
			$tax_meta[ $taxonomy ][ $term_id ]["wds_{$key}"] = $value;
		}

		foreach ( array( 'noindex', 'nofollow' ) as $key ) {
			$global = ! empty( $smartcrawl_options["meta_robots-{$key}-{$taxonomy}"] ) ? (bool) $smartcrawl_options["meta_robots-{$key}-{$taxonomy}"] : false;

			if ( ! $global ) {
				$tax_meta[ $taxonomy ][ $term_id ][ 'wds_' . $key ] = isset( $post_data["wds_{$key}"] )
					? (bool) $post_data["wds_{$key}"]
					: false;
			} else {
				$tax_meta[ $taxonomy ][ $term_id ]["wds_override_{$key}"] = isset( $post_data["wds_override_{$key}"] )
					? (bool) $post_data["wds_override_{$key}"]
					: false;
			}
		}

		if ( ! empty( $post_data['wds-opengraph'] ) ) {
			$data = is_array( $post_data['wds-opengraph'] ) ? stripslashes_deep( $post_data['wds-opengraph'] ) : array();
			$tax_meta[ $taxonomy ][ $term_id ]['opengraph'] = array();
			if ( ! empty( $data['title'] ) ) {
				$tax_meta[ $taxonomy ][ $term_id ]['opengraph']['title'] = sanitize_text_field( $data['title'] );
			}
			if ( ! empty( $data['description'] ) ) {
				$tax_meta[ $taxonomy ][ $term_id ]['opengraph']['description'] = sanitize_text_field( $data['description'] );
			}
			if ( ! empty( $data['images'] ) && is_array( $data['images'] ) ) {
				$tax_meta[ $taxonomy ][ $term_id ]['opengraph']['images'] = array();
				foreach ( $data['images'] as $img ) {
					$img = esc_url_raw( $img );
					$tax_meta[ $taxonomy ][ $term_id ]['opengraph']['images'][] = $img;
				}
			}
		}

		if ( ! empty( $post_data['wds-twitter'] ) ) {
			$data = is_array( $post_data['wds-twitter'] ) ? stripslashes_deep( $post_data['wds-twitter'] ) : array();
			$tax_meta[ $taxonomy ][ $term_id ]['twitter'] = array();
			if ( ! empty( $data['title'] ) ) {
				$tax_meta[ $taxonomy ][ $term_id ]['twitter']['title'] = sanitize_text_field( $data['title'] );
			}
			if ( ! empty( $data['description'] ) ) {
				$tax_meta[ $taxonomy ][ $term_id ]['twitter']['description'] = sanitize_text_field( $data['description'] );
			}
			if ( ! empty( $data['images'] ) && is_array( $data['images'] ) ) {
				$tax_meta[ $taxonomy ][ $term_id ]['twitter']['images'] = array();
				foreach ( $data['images'] as $img ) {
					$img = esc_url_raw( $img );
					$tax_meta[ $taxonomy ][ $term_id ]['twitter']['images'][] = $img;
				}
			}
		}

		update_option( 'wds_taxonomy_meta', $tax_meta );

		if ( function_exists( 'w3tc_flush_all' ) ) {
			// Use W3TC API v0.9.5+
			w3tc_flush_all();
		} elseif ( defined( 'W3TC_DIR' ) && is_readable( W3TC_DIR . '/lib/W3/ObjectCache.php' ) ) {
			// Old (very old) API
			require_once W3TC_DIR . '/lib/W3/ObjectCache.php';
			$w3_objectcache = &W3_ObjectCache::instance();

			$w3_objectcache->flush();
		}

	}

	protected function _get_view_defaults() {
		return array();
	}
}