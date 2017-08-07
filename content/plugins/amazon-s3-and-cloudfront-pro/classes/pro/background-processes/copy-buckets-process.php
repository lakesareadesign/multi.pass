<?php

namespace DeliciousBrains\WP_Offload_S3\Pro\Background_Processes;

use Amazon_S3_And_CloudFront;
use AS3CF_Error;
use AS3CF_Utils;
use Exception;
use Guzzle\Service\Exception\CommandTransferException;

class Copy_Buckets_Process extends Background_Tool_Process {

	/**
	 * @var string
	 */
	protected $action = 'copy_buckets';

	/**
	 * Process attachments chunk.
	 *
	 * @param array $attachments
	 * @param int   $blog_id
	 */
	protected function process_attachments_chunk( $attachments, $blog_id ) {
		$bucket = $this->as3cf->get_setting( 'bucket' );
		$region = $this->as3cf->get_setting( 'region' );

		$attachments_to_copy = array();

		foreach ( $attachments as $attachment_id ) {
			$s3info = $this->as3cf->get_attachment_s3_info( $attachment_id );

			if ( $bucket === $s3info['bucket'] ) {
				continue;
			}

			$attachments_to_copy[] = $attachment_id;
		}

		$this->copy_attachments( $attachments_to_copy, $blog_id, $bucket, $region );
	}

	/**
	 * Copy attachments to new bucket.
	 *
	 * @param array  $attachments
	 * @param int    $blog_id
	 * @param string $bucket
	 * @param string $region
	 */
	protected function copy_attachments( $attachments, $blog_id, $bucket, $region ) {
		if ( empty( $attachments ) ) {
			return;
		}

		$keys = $this->get_s3_keys( $attachments );

		if ( empty( $keys ) ) {
			return;
		}

		$client   = $this->as3cf->get_s3client( $region, true );
		$commands = array();

		foreach ( $keys as $attachment_id => $attachment_keys ) {
			$s3_info = $this->as3cf->get_attachment_s3_info( $attachment_id );

			foreach ( $attachment_keys as $key ) {
				$args = array(
					'Bucket'     => $bucket,
					'Key'        => $key,
					'CopySource' => "{$s3_info['bucket']}/{$key}",
					'ACL'        => $this->determine_key_acl( $attachment_id, $key ),
				);
				$size = AS3CF_Utils::get_intermediate_size_from_filename( $attachment_id, wp_basename( $key ) );
				$args = apply_filters( 'as3cf_object_meta', $args, $attachment_id, $size, true );

				$commands[] = $client->getCommand( 'CopyObject', $args );
			}
		}

		try {
			$client->execute( $commands );
		} catch ( CommandTransferException $e ) {
			$failed = $e->getFailedCommands();
		} catch ( Exception $e ) {
			AS3CF_Error::log( $e->getMessage() );

			return;
		}

		if ( ! empty( $failed ) ) {
			$keys = $this->handle_failed_keys( $keys, $failed, $blog_id );
		}

		$this->update_attachment_s3_info( $keys, $bucket, $region );
	}

	/**
	 * Determine ACL for key.
	 *
	 * @param int    $attachment_id
	 * @param string $key
	 *
	 * @return string
	 */
	protected function determine_key_acl( $attachment_id, $key ) {
		$filename = wp_basename( $key );
		$size     = AS3CF_Utils::get_intermediate_size_from_filename( $attachment_id, $filename );

		return $this->as3cf->get_acl_for_intermediate_size( $attachment_id, $size );
	}

	/**
	 * Handle failed keys.
	 *
	 * @param array $keys
	 * @param array $failed
	 * @param int   $blog_id
	 *
	 * @return array
	 */
	protected function handle_failed_keys( $keys, $failed, $blog_id ) {
		foreach ( $failed as $failure ) {
			foreach ( $keys as $attachment_id => $attachment_keys ) {
				if ( false !== array_search( $failure->get( 'Key' ), $attachment_keys ) ) {
					$key       = $failure->get( 'Key' );
					$message   = $failure->getResult()->get( 'Message' );
					$error_msg = sprintf( __( 'Error copying %s between buckets: %s', 'amazon-s3-and-cloudfront' ), $key, $message );

					$this->record_error( $blog_id, $attachment_id, $error_msg );

					unset( $keys[ $attachment_id ] );

					break;
				}
			}
		}

		return $keys;
	}

	/**
	 * Update attachment S3 info.
	 *
	 * @param array  $keys
	 * @param string $bucket
	 * @param string $region
	 */
	protected function update_attachment_s3_info( $keys, $bucket, $region ) {
		if ( empty( $keys ) ) {
			return;
		}

		foreach ( $keys as $attachment_id => $attachment_keys ) {
			$s3_info = $this->as3cf->get_attachment_s3_info( $attachment_id );

			$s3_info['bucket'] = $bucket;
			$s3_info['region'] = $region;

			update_post_meta( $attachment_id, 'amazonS3_info', $s3_info );
		}
	}

	/**
	 * Get complete notice message.
	 *
	 * @return string
	 */
	protected function get_complete_message() {
		return __( '<strong>WP Offload S3</strong> &mdash; Finished copying media files to new bucket.', 'amazon-s3-and-cloudfront' );
	}

}