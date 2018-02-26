<?php

class Smartcrawl_Redirection_Front {

	private static $_instance;
	private $_model;

	private function __construct() {
		$this->_model = new Smartcrawl_Model_Redirection;
	}
	private function __clone() {}

	public static function get() {
		if ( empty( self::$_instance ) ) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	public static function serve() {
		self::get()->_add_hooks();
	}

	private function _add_hooks() {
		add_action( 'wp', array( $this, 'intercept' ) );

		$opts = Smartcrawl_Settings::get_options();
		if ( ! empty( $opts['redirect-attachments'] ) ) {
			add_action( 'template_redirect', array( $this, 'redirect_attachments' ) );
		}
	}

	/**
	 * Intercept the page and redirect if needs be
	 */
	public function intercept() {
		$source = $this->_model->get_current_url();
		$redirection = $this->_model->get_redirection( $source );
		if ( empty( $redirection ) ) { return false; }

		// We're here, so redirect
		wp_redirect(
			$this->_to_safe_redirection( $redirection, $source ),
			$this->_get_redirection_status( $source )
		);
		die;
	}

	/**
	 * Redirects attachments to parent post
	 *
	 * If we can't determine parent post type,
	 * we at least throw the noindex header.
	 *
	 * Respects the `redirect-attachment-images_only` sub-option,
	 *
	 * @return void
	 */
	public function redirect_attachments() {
		if ( ! is_attachment() ) { return; }

		$opts = Smartcrawl_Settings::get_options();
		if ( ! empty( $opts['redirect-attachments-images_only'] ) ) {
			$type = get_post_mime_type();
			if ( ! preg_match( '/^image\//', $type ) ) { return; }
		}

		$post = get_post();
		$parent_id = is_object( $post ) && ! empty( $post->post_parent )
			? $post->post_parent
			: false
		;

		if ( ! empty( $parent_id ) ) {
			wp_safe_redirect( get_permalink( $parent_id ), 301 );
			die;
		}

		// No parent post, let's noidex
		header( 'X-Robots-Tag: noindex', true );
	}

	/**
	 * Gets redirection status header code
	 *
	 * @param string $source Raw URL (optional)
	 *
	 * @return int
	 */
	private function _get_redirection_status( $source = false ) {
		$status_code = $this->_model->get_default_redirection_status_type();
		if ( ! empty( $source ) ) {
			$item_status = $this->_model->get_redirection_type( $source );
			if ( ! empty( $item_status ) && is_numeric( $item_status ) ) { $status_code = (int) $item_status; }
		}
		if ( $status_code > 399 || $status_code < 300 ) { $status_code = Smartcrawl_Model_Redirection::DEFAULT_STATUS_TYPE; }

		return (int) $status_code;
	}

	/**
	 * Converts the redirection to a safe one
	 *
	 * @param string $redirection Raw URL
	 * @param string $source Source URL (optional)
	 *
	 * @return string Safe redirection URL
	 */
	private function _to_safe_redirection( $redirection, $source = false ) {
		$fallback = home_url();

		$status = $this->_get_redirection_status( $source );

		$redirection = wp_sanitize_redirect( $redirection );
		$redirection = wp_validate_redirect( $redirection, apply_filters( 'wp_safe_redirect_fallback', $fallback, $status ) );

		return $redirection;
	}

}
Smartcrawl_Redirection_Front::serve();