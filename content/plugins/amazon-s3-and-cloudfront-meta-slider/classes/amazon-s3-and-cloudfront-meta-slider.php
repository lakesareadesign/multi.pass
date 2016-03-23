<?php

class Amazon_S3_And_CloudFront_Meta_Slider {

	/**
	 * @param string $plugin_file_path
	 */
	function __construct( $plugin_file_path ) {
		add_filter( 'metaslider_attachment_url', array( $this, 'metaslider_attachment_url' ), 10, 2 );
		add_action( 'add_post_meta', array( $this, 'add_post_meta' ), 10, 3 );
		add_action( 'update_post_meta', array( $this, 'update_post_meta' ), 10, 4 );

		load_plugin_textdomain( 'as3cf-meta-slider', false, dirname( plugin_basename( $plugin_file_path ) ) . '/languages/' );
	}

	/**
	 * Use the S3 URL for a Meta Slider slide image
	 *
	 * @param string $url
	 * @param int    $slide_id
	 *
	 * @return string
	 */
	function metaslider_attachment_url( $url, $slide_id ) {
		global $as3cf;

		$s3_url = $as3cf->get_attachment_url( $slide_id );
		if ( ! is_wp_error( $s3_url ) && false !== $s3_url ) {
			return $s3_url;
		}

		return $url;
	}

	/**
	 * Add post meta
	 *
	 * @param int    $object_id
	 * @param string $meta_key
	 * @param mixed  $_meta_value
	 */
	function add_post_meta( $object_id, $meta_key, $_meta_value ) {
		$this->maybe_upload_attachment_backup_sizes( $object_id, $meta_key, $_meta_value );
	}

	/**
	 * Update post meta
	 *
	 * @param int    $meta_id
	 * @param int    $object_id
	 * @param string $meta_key
	 * @param mixed  $_meta_value
	 */
	function update_post_meta( $meta_id, $object_id, $meta_key, $_meta_value ) {
		$this->maybe_upload_attachment_backup_sizes( $object_id, $meta_key, $_meta_value );
	}

	/**
	 * Maybe upload attachment backup sizes
	 *
	 * @param int    $object_id
	 * @param string $meta_key
	 * @param mixed $data
	 */
	function maybe_upload_attachment_backup_sizes( $object_id, $meta_key, $data ) {
		if ( '_wp_attachment_backup_sizes' !== $meta_key ) {
			return;
		}

		if ( 'resize_image_slide' !== filter_input( INPUT_POST, 'action' ) ) {
			return;
		}

		global $as3cf;
		if ( ! $as3cf->is_plugin_setup() ) {
			return;
		}

		if ( ! ( $s3object = $as3cf->get_attachment_s3_info( $object_id ) ) && ! $as3cf->get_setting( 'copy-to-s3' ) ) {
			// Abort if not already uploaded to S3 and the copy setting is off
			return;
		}

		$this->upload_attachment_backup_sizes( $object_id, $s3object, $data );
	}

	/**
	 * Upload attachment backup sizes
	 *
	 * @param int   $object_id
	 * @param array $s3object
	 * @param mixed $data
	 */
	function upload_attachment_backup_sizes( $object_id, $s3object, $data ) {
		global $as3cf;

		$region = '';
		$prefix = trailingslashit( dirname( $s3object['key'] ) );
		$acl    = $as3cf::DEFAULT_ACL;

		if ( isset( $s3object['region'] ) ) {
			$region = $s3object['region'];
		}

		if ( isset( $s3object['acl'] ) ) {
			$acl = $s3object['acl'];
		}

		$s3client = $as3cf->get_s3client( $region, true );

		foreach ( $data as $file ) {
			if ( ! isset( $file['path'] ) ) {
				continue;
			}

			if ( $this->is_remote_file( $file['path'] ) ) {
				continue;
			}

			$args = array(
				'Bucket'       => $s3object['bucket'],
				'Key'          => $prefix . $file['file'],
				'ACL'          => $acl,
				'SourceFile'   => $file['path'],
				'CacheControl' => 'max-age=31536000',
				'Expires'      => date( 'D, d M Y H:i:s O', time() + 31536000 ),
			);
			$args = apply_filters( 'as3cf_object_meta', $args, $object_id );

			try {
				$s3client->putObject( $args );
			} catch ( Exception $e ) {
				AS3CF_Error::log( 'Error uploading ' . $args['SourceFile'] . ' to S3: ' . $e->getMessage(), 'META_SLIDER' );
			}
		}
	}

	/**
	 * Is remote file
	 *
	 * @param string $path
	 *
	 * @return bool
	 */
	function is_remote_file( $path ) {
		if ( preg_match( '@^s3[a-z0-9]*:\/\/@', $path ) ) {
			return true;
		}

		return false;
	}
}
