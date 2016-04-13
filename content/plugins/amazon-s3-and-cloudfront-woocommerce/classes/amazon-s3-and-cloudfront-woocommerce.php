<?php

class Amazon_S3_And_CloudFront_WooCommerce {

	/**
	 * @var string
	 */
	protected $plugin_file_path;

	/**
	 * @param string $plugin_file_path
	 */
	function __construct( $plugin_file_path ) {
		$this->plugin_file_path = $plugin_file_path;

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
		add_action( 'wp_ajax_as3cf_woo_is_amazon_s3_attachment', array( $this, 'ajax_is_amazon_s3_attachment' ) );
		add_action( 'woocommerce_process_product_file_download_paths', array( $this, 'make_files_private_on_s3' ), 10, 3 );
		add_action( 'woocommerce_download_file_as3cf', array( $this, 'download_file' ), 10, 2 );
		add_filter( 'woocommerce_file_download_method', array( $this, 'add_download_method' ) );

		load_plugin_textdomain( 'as3cf-woocommerce', false, dirname( plugin_basename( $plugin_file_path ) ) . '/languages/' );
	}

	/**
	 * Enqueue scripts
	 *
	 * @return void
	 */
	function admin_scripts() {
		$screen = get_current_screen();

		if ( in_array( $screen->id, array( 'product', 'edit-product' ) ) ) {
			global $as3cfpro;

			if ( ! $as3cfpro->is_pro_plugin_setup() ) {
				// Don't allow new shortcodes if Pro not set up
				return;
			}

			$version = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? time() : $GLOBALS['aws_meta']['amazon-s3-and-cloudfront-woocommerce']['version'];
			$suffix  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
			$src     = plugins_url( 'assets/js/script' . $suffix . '.js', $this->plugin_file_path );

			wp_enqueue_media();
			wp_enqueue_script( 'as3cf-woo-script', $src, array( 'jquery', 'wp-util' ), $version, true );

			wp_localize_script( 'as3cf-woo-script', 'as3cf_woo', array(
				'strings' => array(
					'media_modal_title'  => __( 'Select Downloadable File', 'as3cf-woocommerce' ),
					'media_modal_button' => __( 'Insert File', 'as3cf-woocommerce' ),
					'input_placeholder'  => __( 'Retrieving...', 'as3cf-woocommerce' ),
				),
				'nonces'  => array(
					'is_amazon_s3_attachment' => wp_create_nonce( 'as3cf_woo_is_amazon_s3_attachment' )
				)
			) );
		}
	}

	/**
	 * Ajax get s3 info
	 *
	 * @return void
	 */
	function ajax_is_amazon_s3_attachment() {
		global $as3cf;

		$as3cf->verify_ajax_request();

		$return = false;

		if ( $as3cf->get_attachment_s3_info( intval( $_POST['attachment_id'] ) ) ) {
			$return = true;
		}
		wp_send_json_success( $return );
	}

	/**
	 * Make file private on Amazon S3
	 *
	 * @param int $post_id
	 * @param int $deprecated
	 * @param array $files
	 *
	 * @return void
	 */
	function make_files_private_on_s3( $post_id, $deprecated, $files ) {
		global $as3cf;

		$new_attachments = array();

		foreach ( $files as $file ) {
			$attachment_id = $this->get_attachment_id_from_shortcode( $file['file'] );

			if ( false === $attachment_id ) {
				// Attachment id could not be determined, ignore
				continue;
			}

			$new_attachments[] = $attachment_id;

			if ( ! ( $s3object = $as3cf->get_attachment_s3_info( $attachment_id ) ) ) {
				// Not S3 upload, ignore
				continue;
			}

			global $as3cfpro;
			if ( $as3cfpro->is_pro_plugin_setup() ) {
				// Only set new files as private if the Pro plugin is setup
				$s3object = $as3cf->set_attachment_acl_on_s3( $attachment_id, $s3object, $as3cf::PRIVATE_ACL );
				if ( $s3object && ! is_wp_error( $s3object ) ) {
					$as3cf->make_acl_admin_notice( $s3object );
				}
			}
		}

		$this->maybe_make_removed_files_public( $post_id, $new_attachments );

		return $files;
	}

	/**
	 * Get attachment id from shortcode
	 *
	 * @param string $shortcode
	 *
	 * @return int|bool
	 */
	function get_attachment_id_from_shortcode( $shortcode ) {
		global $wpdb;

		$atts = $this->get_shortcode_atts( $shortcode );

		if ( isset( $atts['id'] ) ) {
			return $atts['id'];
		}

		if ( ! isset( $atts['bucket'] ) || ! isset( $atts['object'] ) ) {
			return false;
		}

		$bucket_length = strlen( $atts['bucket'] );
		$object_length = strlen( $atts['object'] );

		$sql = "
			SELECT `post_id`
			FROM `{$wpdb->prefix}postmeta`
			WHERE `{$wpdb->prefix}postmeta`.`meta_key` = 'amazonS3_info'
			AND `{$wpdb->prefix}postmeta`.`meta_value` LIKE '%s:6:\"bucket\";s:{$bucket_length}:\"{$atts['bucket']}\";s:3:\"key\";s:{$object_length}:\"{$atts['object']}\";%'
		";

		if ( $id = $wpdb->get_var( $sql ) ) {
			return $id;
		}

		return false;
	}

	/**
	 * Get shortcode atts
	 *
	 * @param string $shortcode
	 *
	 * @return array
	 */
	function get_shortcode_atts( $shortcode ) {
		$shortcode = trim( stripcslashes( $shortcode ) );
		$shortcode = ltrim( $shortcode, '[' );
		$shortcode = rtrim( $shortcode, ']' );
		$shortcode = shortcode_parse_atts( $shortcode );

		return $shortcode;
	}

	/**
	 * Remove private ACL from S3 if no longer used by WooCommerce
	 *
	 * @param int $post_id
	 * @param array $new_attachments
	 *
	 * @return void
	 */
	function maybe_make_removed_files_public( $post_id, $new_attachments ) {
		global $as3cf, $wpdb;

		$old_files       = get_post_meta( $post_id, '_downloadable_files', true );
		$old_attachments = array();

		if ( is_array( $old_files ) ) {
			foreach ( $old_files as $old_file ) {
				$attachment_id = $this->get_attachment_id_from_shortcode( $old_file['file'] );

				if ( false !== $attachment_id ) {
					$old_attachments[] = $attachment_id;
				}
			}
		}

		$removed_attachments = array_diff( $old_attachments , $new_attachments );

		if ( empty( $removed_attachments ) ) {
			return;
		}

		foreach ( $removed_attachments as $attachment_id ) {
			if ( ! ( $s3object = $as3cf->get_attachment_s3_info( $attachment_id ) ) ) {
				// Not an S3 attachment, ignore
				continue;
			}

			$bucket = preg_quote( $s3object['bucket'], '@' );
			$key    = preg_quote( $s3object['key'], '@' );

			// Check the attachment isn't used by other downloads
			$sql = $wpdb->prepare( "
				SELECT meta_value
				FROM $wpdb->postmeta
				WHERE post_id != %d
				AND meta_key = %s
				AND meta_value LIKE %s
			", $post_id, '_downloadable_files', '%amazon_s3%' );

			$results = $wpdb->get_results( $sql, ARRAY_A );

			foreach( $results as $result ) {
				// WP Offload S3
				if ( preg_match( '@\[amazon_s3\sid=[\'\"]*' . $attachment_id . '[\'\"]*\]@', $result['meta_value'] ) ) {
					continue 2;
				}

				// Official WooCommerce S3 addon
				if ( preg_match( '@\[amazon_s3\sobject=[\'\"]*' . $key . '[\'\"]*\sbucket=[\'\"]*' . $bucket . '[\'\"]*\]@', $result['meta_value'] ) ) {
					continue 2;
				}
				if ( preg_match( '@\[amazon_s3\sbucket=[\'\"]*' . $bucket . '[\'\"]*\sobject=[\'\"]*' . $key . '[\'\"]*\]@', $result['meta_value'] ) ) {
					continue 2;
				}
			}

			// Set ACL to public
			$s3object = $as3cf->set_attachment_acl_on_s3( $attachment_id, $s3object, $as3cf::DEFAULT_ACL );
			if ( $s3object && ! is_wp_error( $s3object ) ) {
				$as3cf->make_acl_admin_notice( $s3object );
			}
		}
	}

	/**
	 * Add download method to WooCommerce
	 *
	 * @return string
	 */
	function add_download_method() {
		return 'as3cf';
	}

	/**
	 * Use S3 secure link to download file
	 *
	 * @param string $file_path
	 * @param int    $filename
	 *
	 * @return void
	 */
	function download_file( $file_path, $filename ) {
		global $as3cf;

		$attachment_id = $this->get_attachment_id_from_shortcode( $file_path );

		$expires = apply_filters( 'as3cf_woocommerce_download_expires', 5 );

		$file_data = array(
			'name' => $filename,
			'file' => $file_path,
		);

		if ( ! $attachment_id || ! $as3cf->get_attachment_s3_info( $attachment_id ) ) {
			/*
			This addon is meant to be a drop-in replacement for the
			WooCommerce Amazon S3 Storage extension. The latter doesn't encourage people
			to add the file to the Media Library, so even though we can't get an
			attachment ID for the shortcode, we should still serve the download
			if the shortcode contains the `bucket` and `object` attributes.
			*/
			$atts = $this->get_shortcode_atts( $file_path );

			if ( isset( $atts['bucket'] ) && isset( $atts['object'] ) ) {
				$bucket_setting = $as3cf->get_setting( 'bucket' );

				if ( $bucket_setting === $atts['bucket'] ) {
					$region = $as3cf->get_setting( 'region' );
				} else {
					$region = $as3cf->get_bucket_region( $atts['bucket'] );
				}

				try {
					$expires    = time() + $expires;
					$headers    = apply_filters( 'as3cf_woocommerce_download_headers', array( 'ResponseContentDisposition' => 'attachment' ), $file_data );
					$secure_url = $as3cf->get_s3client( $region, true )->getObjectUrl( $atts['bucket'], $atts['object'], $expires, $headers );
				} catch ( Exception $e ) {
					return;
				}

				header( 'Location: ' . $secure_url );
				exit;
			}

			// Handle shortcode inputs where the file has been removed from S3
			// Parse the url, shortcodes do not return a host
			$url = parse_url( $file_path );

			if ( ! isset( $url['host'] ) ) {
				$file_path = wp_get_attachment_url( $attachment_id );
				$filename  = basename( $file_path );
			}

			// File not on S3, trigger WooCommerce saved download method
			$method = get_option( 'woocommerce_file_download_method', 'force' );
			do_action( 'woocommerce_download_file_' . $method, $file_path, $filename );

			return;
		}

		$file_data['attachment_id'] = $attachment_id;
		$headers    = apply_filters( 'as3cf_woocommerce_download_headers', array( 'ResponseContentDisposition' => 'attachment' ), $file_data );
		$secure_url = $as3cf->get_secure_attachment_url( $attachment_id, $expires, null, $headers, true );

		header( 'Location: ' . $secure_url );
		exit;
	}

}