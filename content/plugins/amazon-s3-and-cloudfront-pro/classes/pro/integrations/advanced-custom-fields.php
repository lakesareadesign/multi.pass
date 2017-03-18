<?php

namespace DeliciousBrains\WP_Offload_S3\Pro\Integrations;

use DeliciousBrains\WP_Offload_S3\Pro\Integration;

class Advanced_Custom_Fields extends Integration {

	/**
	 * Is installed?
	 *
	 * @return bool
	 */
	public function is_installed() {
		if ( class_exists( 'acf' ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Init integration.
	 */
	public function init() {
		// Content filtering
		add_filter( 'acf/load_value/type=text', array( $this->as3cf->filter_local, 'filter_post' ) );
		add_filter( 'acf/load_value/type=textarea', array( $this->as3cf->filter_local, 'filter_post' ) );
		add_filter( 'acf/load_value/type=wysiwyg', array( $this->as3cf->filter_local, 'filter_post' ) );
		add_filter( 'acf/update_value/type=text', array( $this->as3cf->filter_s3, 'filter_post' ) );
		add_filter( 'acf/update_value/type=textarea', array( $this->as3cf->filter_s3, 'filter_post' ) );
		add_filter( 'acf/update_value/type=wysiwyg', array( $this->as3cf->filter_s3, 'filter_post' ) );
	}

}