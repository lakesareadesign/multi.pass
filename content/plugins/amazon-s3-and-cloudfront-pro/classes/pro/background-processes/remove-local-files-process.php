<?php

namespace DeliciousBrains\WP_Offload_S3\Pro\Background_Processes;

class Remove_Local_Files_Process extends Background_Tool_Process {

	/**
	 * @var string
	 */
	protected $action = 'remove_local_files';

	/**
	 * @var int
	 */
	protected $blog_id;

	/**
	 * @var array
	 */
	protected $paths = array();

	/**
	 * Process attachments chunk.
	 *
	 * @param array $attachments
	 * @param int   $blog_id
	 */
	protected function process_attachments_chunk( $attachments, $blog_id ) {
		$this->blog_id = $blog_id;

		foreach ( $attachments as $key => $attachment_id ) {
			if ( ! $this->as3cf->is_attachment_served_by_s3( $attachment_id, true ) || ! $this->attachment_exist_locally( $attachment_id ) ) {
				unset( $attachments[ $key ] );
			}
		}

		$keys = $this->get_keys( $attachments );

		foreach( $attachments as $attachment_id ) {
			$this->delete_local_attachment( $attachment_id, $keys );
		}
	}

	/**
	 * Does attachment exist locally?
	 *
	 * @param int $attachment_id
	 *
	 * @return bool
	 */
	protected function attachment_exist_locally( $attachment_id ) {
		$paths = $this->get_attachment_local_paths( $attachment_id );

		foreach ( $paths as $path ) {
			if ( file_exists( $path ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Delete local attachment files.
	 *
	 * @param int $attachment_id
	 * @param array $keys
	 */
	protected function delete_local_attachment( $attachment_id, $keys ) {
		$paths = $this->get_attachment_local_paths( $attachment_id );
		$keys  = isset( $keys[ $attachment_id ] ) ? $keys[ $attachment_id ] : array();

		foreach ( $paths as $path ) {
			if ( file_exists( $path ) && $this->file_exists_on_s3( $path, $keys ) ) {
				wp_delete_file( $path );
			}
		}
	}

	/**
	 * Does file local file exist on S3?
	 *
	 * @param string $path
	 * @param array  $keys
	 *
	 * @return bool
	 */
	protected function file_exists_on_s3( $path, $keys ) {
		foreach ( $keys as $key ) {
			if ( pathinfo( $path, PATHINFO_BASENAME ) === pathinfo( $key, PATHINFO_BASENAME ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Get attachment local paths.
	 *
	 * @param int $attachment_id
	 *
	 * @return array
	 */
	protected function get_attachment_local_paths( $attachment_id ) {
		if ( isset( $this->paths[ $this->blog_id ][ $attachment_id ] ) ) {
			return $this->paths[ $this->blog_id ][ $attachment_id ];
		}

		$file    = get_attached_file( $attachment_id, true );
		$parts   = pathinfo( $file );
		$meta    = wp_get_attachment_metadata( $attachment_id );
		$backups = get_post_meta( $attachment_id, '_wp_attachment_backup_sizes', true );
		$paths   = array( $file );

		if ( ! empty( $meta['sizes'] ) ) {
			foreach ( $meta['sizes'] as $size ) {
				$paths[] = path_join( $parts['dirname'], $size['file'] );
			}
		}

		if ( ! empty( $backups ) ) {
			foreach ( $backups as $size ) {
				$paths[] = path_join( $parts['dirname'], $size['file'] );
			}
		}

		$this->paths[ $this->blog_id ][ $attachment_id ] = $paths;

		return $paths;
	}

	/**
	 * Get object keys that exist on S3 for attachments.
	 *
	 * It's possible that attachments belong to different buckets therefore they could have
	 * different regions, so we have to build an array of clients and commands.
	 *
	 * @param array $attachments
	 *
	 * @return array
	 */
	protected function get_keys( $attachments ) {
		$regions = array();

		foreach ( $attachments as $attachment_id ) {
			$s3info = $this->as3cf->get_attachment_s3_info( $attachment_id );
			$region = empty( $s3info['region'] ) ? 'us-east-1' : $s3info['region'];

			if ( ! isset( $regions[ $region ]['s3client'] ) ) {
				$regions[ $region ]['s3client'] = $this->as3cf->get_s3client( $region, true );
			}

			$regions[ $region ]['commands'][ $attachment_id ] = $regions[ $region ]['s3client']->getCommand( 'ListObjects', array(
				'Bucket' => $s3info['bucket'],
				'Prefix' => $this->get_search_prefix( $s3info ),
			) );
		}

		return $this->get_keys_from_regions( $regions );
	}

	/**
	 * Get search prefix.
	 *
	 * @param array $s3info
	 *
	 * @return string
	 */
	protected function get_search_prefix( $s3info ) {
		$parts = pathinfo( $s3info['key'] );
		// Remove the suffix from edited images
		$filename = preg_replace( '/-e[0-9]{13}/', '', $parts['filename'] );

		return str_replace( $parts['basename'], $filename, $s3info['key'] );
	}

	/**
	 * Get object keys from region results.
	 *
	 * @param array $regions
	 *
	 * @return array
	 */
	protected function get_keys_from_regions( $regions ) {
		$keys = array();

		foreach ( $regions as $region ) {
			$region['s3client']->execute( $region['commands'] );

			foreach ( $region['commands'] as $attachment_id => $command ) {
				$keys[ $attachment_id ] = $command->getResult()->getPath( 'Contents/*/Key' );
			}
		}

		return $keys;
	}
}
