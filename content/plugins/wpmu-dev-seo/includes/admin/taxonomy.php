<?php

class WDS_Taxonomy {

	public function __construct() {
		if ( is_admin() && isset( $_GET['taxonomy'] ) ) {
			add_action( $_GET['taxonomy'] . '_edit_form', array( &$this, 'term_additions_form' ), 10, 2 );
		}

		add_action( 'edit_term', array( &$this, 'update_term' ), 10, 3 );

	}

	public function form_row( $id, $label, $desc, $tax_meta, $type = 'text' ) {
		$val = ! empty( $tax_meta[ $id ] ) ? stripslashes( $tax_meta[ $id ] ) : '';

		include WDS_PLUGIN_DIR . 'admin/templates/taxonomy-form-row.php';

	}

	public function term_additions_form( $term, $taxonomy ) {
		global $wds_options;
		$tax_meta = get_option( 'wds_taxonomy_meta' );

		if ( isset( $tax_meta[ $taxonomy ][ $term->term_id ] ) ) {
			$tax_meta = $tax_meta[ $taxonomy ][ $term->term_id ];
		}

		$taxonomy_object = get_taxonomy( $taxonomy );
		$taxonomy_labels = $taxonomy_object->labels;

		$global_noindex = ! empty( $wds_options[ 'meta_robots-noindex-' . $term->taxonomy ] )
			? $wds_options[ 'meta_robots-noindex-' . $term->taxonomy ]
			: false
		;
		$global_nofollow = ! empty( $wds_options[ 'meta_robots-nofollow-' . $term->taxonomy ] )
			? $wds_options[ 'meta_robots-nofollow-' . $term->taxonomy ]
			: false
		;

		include WDS_PLUGIN_DIR . 'admin/templates/term-additions-form.php';

	}

	public function update_term( $term_id, $tt_id, $taxonomy ) {
		global $wds_options;

		$tax_meta = get_option( 'wds_taxonomy_meta' );

		foreach ( array( 'title', 'desc', 'bctitle', 'canonical' ) as $key ) {
			$tax_meta[ $taxonomy ][ $term_id ][ 'wds_'.$key ] = @$_POST[ 'wds_' . $key ];
		}

		foreach ( array( 'noindex', 'nofollow' ) as $key ) {
			$global = ! empty( $wds_options[ "meta_robots-{$key}-{$taxonomy}" ] ) ? (bool) $wds_options[ "meta_robots-{$key}-{$taxonomy}" ] : false;

			if ( ! $global) $tax_meta[ $taxonomy ][ $term_id ][ 'wds_'.$key ] = isset( $_POST[ "wds_{$key}" ] ) ? (bool) $_POST[ "wds_{$key}" ] : false;
			else $tax_meta[ $taxonomy ][ $term_id ][ "wds_override_{$key}" ] = isset( $_POST[ "wds_override_{$key}" ] ) ? (bool) $_POST[ "wds_override_{$key}" ] : false;
		}

		update_option( 'wds_taxonomy_meta', $tax_meta );

		if (function_exists('w3tc_flush_all')) {
			// Use W3TC API v0.9.5+
			w3tc_flush_all();
		} else if ( defined( 'W3TC_DIR' ) && is_readable(W3TC_DIR . '/lib/W3/ObjectCache.php') ) {
			// Old (very old) API
			require_once W3TC_DIR . '/lib/W3/ObjectCache.php';
			$w3_objectcache = & W3_ObjectCache::instance();

			$w3_objectcache->flush();
		}

	}
}

$wds_taxonomy = new WDS_Taxonomy();