<?php

class Smartcrawl_Taxonomy extends Smartcrawl_Renderable {
	protected function _get_view_defaults() {
		return array(); }

	public function __construct() {
		if ( is_admin() && ! empty( $_GET['taxonomy'] ) ) {
			add_action( sanitize_key( $_GET['taxonomy'] ) . '_edit_form', array( &$this, 'term_additions_form' ), 10, 2 );
		}

		add_action( 'edit_term', array( &$this, 'update_term' ), 10, 3 );

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
			: false
		;
		$global_nofollow = ! empty( $smartcrawl_options[ 'meta_robots-nofollow-' . $term->taxonomy ] )
			? $smartcrawl_options[ 'meta_robots-nofollow-' . $term->taxonomy ]
			: false
		;

		$version = Smartcrawl_Loader::get_version();
		Smartcrawl_Settings_Admin::enqueue_shared_ui( false );

		wp_enqueue_style( 'wds-admin-opengraph', SMARTCRAWL_PLUGIN_URL . '/css/wds-opengraph.css', null, $version );
		wp_enqueue_style( 'wds-qtip2-style', SMARTCRAWL_PLUGIN_URL . '/css/external/jquery.qtip.min.css', null, $version );
		wp_enqueue_style( 'wds-app', SMARTCRAWL_PLUGIN_URL . 'css/app.css', array( 'wds-qtip2-style' ), $version );

		wp_enqueue_media();

		wp_enqueue_script( 'wds-admin', SMARTCRAWL_PLUGIN_URL . 'js/wds-admin.js', array( 'jquery' ), $version );
		wp_enqueue_script( 'wds-admin-opengraph', SMARTCRAWL_PLUGIN_URL . 'js/wds-admin-opengraph.js', array( 'underscore', 'jquery', 'wds-admin' ), $version );

		include SMARTCRAWL_PLUGIN_DIR . 'admin/templates/term-additions-form.php';

	}

	public function update_term( $term_id, $tt_id, $taxonomy ) {
		$smartcrawl_options = Smartcrawl_Settings::get_options();

		$tax_meta = get_option( 'wds_taxonomy_meta' );

		foreach ( array( 'title', 'desc', 'bctitle', 'canonical' ) as $key ) {
			$value = isset( $_POST[ "wds_{$key}" ] )
				? $_POST[ "wds_{$key}" ]
				: ''
			;
			if ( 'canonical' === $key ) {
				$value = esc_url_raw( $value );
			} else {
				$value = sanitize_text_field( $value );
			}
			$tax_meta[ $taxonomy ][ $term_id ][ "wds_{$key}" ] = $value;
		}

		foreach ( array( 'noindex', 'nofollow' ) as $key ) {
			$global = ! empty( $smartcrawl_options[ "meta_robots-{$key}-{$taxonomy}" ] ) ? (bool) $smartcrawl_options[ "meta_robots-{$key}-{$taxonomy}" ] : false;

			if ( ! $global ) {
				$tax_meta[ $taxonomy ][ $term_id ][ 'wds_' . $key ] = isset( $_POST[ "wds_{$key}" ] )
					? (bool) $_POST[ "wds_{$key}" ]
					: false
				;
			} else {
				$tax_meta[ $taxonomy ][ $term_id ][ "wds_override_{$key}" ] = isset( $_POST[ "wds_override_{$key}" ] )
					? (bool) $_POST[ "wds_override_{$key}" ]
					: false
				;
			}
		}

		if ( ! empty( $_POST['wds-opengraph'] ) ) {
			$data = is_array( $_POST['wds-opengraph'] ) ? stripslashes_deep( $_POST['wds-opengraph'] ) : array();
			$tax_meta[ $taxonomy ][ $term_id ]['opengraph'] = array();
			if ( ! empty( $data['title'] ) ) { $tax_meta[ $taxonomy ][ $term_id ]['opengraph']['title'] = sanitize_text_field( $data['title'] ); }
			if ( ! empty( $data['description'] ) ) { $tax_meta[ $taxonomy ][ $term_id ]['opengraph']['description'] = sanitize_text_field( $data['description'] ); }
			if ( ! empty( $data['og-images'] ) && is_array( $data['og-images'] ) ) {
				$tax_meta[ $taxonomy ][ $term_id ]['opengraph']['images'] = array();
				foreach ( $data['og-images'] as $img ) {
					$img = esc_url_raw( $img );
					$tax_meta[ $taxonomy ][ $term_id ]['opengraph']['images'][] = $img;
				}
			}
		}

		if ( ! empty( $_POST['wds-twitter'] ) ) {
			$data = is_array( $_POST['wds-twitter'] ) ? stripslashes_deep( $_POST['wds-twitter'] ) : array();
			$tax_meta[ $taxonomy ][ $term_id ]['twitter'] = array();
			if ( ! empty( $data['title'] ) ) { $tax_meta[ $taxonomy ][ $term_id ]['twitter']['title'] = sanitize_text_field( $data['title'] ); }
			if ( ! empty( $data['description'] ) ) { $tax_meta[ $taxonomy ][ $term_id ]['twitter']['description'] = sanitize_text_field( $data['description'] ); }
		}

		update_option( 'wds_taxonomy_meta', $tax_meta );

		if ( function_exists( 'w3tc_flush_all' ) ) {
			// Use W3TC API v0.9.5+
			w3tc_flush_all();
		} elseif ( defined( 'W3TC_DIR' ) && is_readable( W3TC_DIR . '/lib/W3/ObjectCache.php' ) ) {
			// Old (very old) API
			require_once W3TC_DIR . '/lib/W3/ObjectCache.php';
			$w3_objectcache = & W3_ObjectCache::instance();

			$w3_objectcache->flush();
		}

	}
}

$smartcrawl_taxonomy = new Smartcrawl_Taxonomy();