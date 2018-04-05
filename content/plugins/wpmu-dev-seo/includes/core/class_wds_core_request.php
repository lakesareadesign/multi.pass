<?php

class Smartcrawl_Core_Request {

	/**
	 * Gets post from front-end, via HTTP API
	 *
	 * @param int $post_id ID of the post to fetch content.
	 *
	 * @return string|WP_Error
	 */
	public function get_rendered_post( $post_id ) {
		$post_id = (int) $post_id;
		if ( ! $post_id ) {
			return new WP_Error( __CLASS__, 'Unknown post ID' );
		}

		$post_parent = wp_is_post_revision( $post_id );
		$permalink = !empty($post_parent)
			? get_permalink($post_parent)
			: get_permalink( $post_id )
		;
		if ( empty( $permalink ) ) {
			return new WP_Error( __CLASS__, 'Error figuring out post permalink' );
		}

		$url = add_query_arg('preview', 'true', $permalink);
		$url = add_query_arg('preview_id', $post_id, $url);
		$url = add_query_arg('preview_nonce', wp_create_nonce('post_preview_' . $post_id), $url);
		$url = add_query_arg( 'wds-frontend-check', md5( microtime() ), $url );

		$post_status = get_post_status( $post_id );
		if ( 'auto-draft' === $post_status ) {
			return '';
		}

		$params = array();

		// Let's copy over the current cookies to apply to the request.
		$cookies = array();
		$source = ! empty( $_COOKIE )
			? $_COOKIE
			: array()
		;
		foreach ( $source as $cname => $cvalue ) {
			if ( ! preg_match( '/^(wp-|wordpress_)/', $cname ) ) { continue; } // Only WP cookies, pl0x.
			$cookies[] = new WP_Http_Cookie(array(
				'name' => $cname,
				'value' => $cvalue,
			));
		}
		if ( ! empty( $cookies ) ) { $params['cookies'] = $cookies; }

		$response = wp_remote_get( $url, $params );

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		if ( 200 !== wp_remote_retrieve_response_code( $response ) ) {
			return new WP_Error( __CLASS__, 'Non-200 response' );
		}

		$content = wp_remote_retrieve_body( $response );

		if ( ! class_exists( 'Smartcrawl_Html' ) ) { require_once( SMARTCRAWL_PLUGIN_DIR . '/core/class_wds_html.php' ); }
		$bits = Smartcrawl_Html::find( '.wds-frontend-content-check', $content );

		return (string) trim( join( "\n", $bits ) );
	}
}