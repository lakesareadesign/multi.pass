<?php

/**
 * Class WP_Hummingbird_Module_Gravatar is responsible for handling Gravatar Cache.
 *
 * @since 1.6.0
 */
class WP_Hummingbird_Module_Gravatar extends WP_Hummingbird_Module {

	/**
	 * WP_Hummingbird_Filesystem class instance.
	 *
	 * @since 1.6.0
	 * @var   WP_Hummingbird_Filesystem $filesystem
	 */
	private $filesystem;

	/**
	 * Last error.
	 *
	 * @since 1.6.0
	 * @var   WP_Error $error
	 */
	public $error = false;

	/**
	 * Initialize module.
	 *
	 * @since 1.6.0
	 */
	public function init() {
		// Init filesystem.
		$this->filesystem = WP_Hummingbird_Filesystem::instance( 'gravatar' );

		if ( is_wp_error( $this->filesystem->status ) ) {
			$this->error = $this->filesystem->status;
		}

		if ( $this->is_active() && ! is_wp_error( $this->error ) ) {
			add_filter( 'get_avatar', array( $this, 'get_cached_avatar' ), 10, 5 );
		}
	}

	/**
	 * Execute module actions
	 *
	 * @since 1.6.0
	 */
	public function run() {}

	/**
	 * Delete cached files.
	 *
	 * @return bool
	 * @since  1.6.0
	 */
	public function delete_files() {
		return $this->filesystem->purge();
	}

	/**
	 * Count the number of cached Gravatars.
	 *
	 * Because each Gravatar is cached in two different sizes, we divide the end result by 2.
	 * Might need refactoring, because one user can hava several avatars cached (two different sizes),
	 * and that will cause confusion for the user.
	 *
	 * @return bool|int
	 * @since  1.6.0  Implemented, but not used in official release.
	 */
	public function get_cache_count() {
		$dir_list = $this->filesystem->dirlist();

		$files = 0;
		foreach ( $dir_list as $directory ) {
			$found = array_filter(
				$directory['files'],
				array( $this, 'array_filter_cb' )
			);
			$files = $files + count( $found );
		}

		return (int) ( $files / 2 );
	}

	/**
	 * Array filter callback for backward php 5.2 compatibility.
	 *
	 * @since 1.6.0
	 * @param array $resource  Resource array.
	 *
	 * @return bool
	 */
	private function array_filter_cb( $resource ) {
		return 'f' === $resource['type'];
	}

	/**
	 * Fetch remote avatar and save to local cache
	 *
	 * @access private
	 * @see Requests_Utility_CaseInsensitiveDictionary for $remote_avatar['headers']->getAll().
	 * @param  mixed $id_or_email  The Gravatar to retrieve a URL for. Accepts a user_id, gravatar md5 hash,
	 *                             user email, WP_User object, WP_Post object, or WP_Comment object.
	 * @param  int   $size         Size of avatar.
	 * @since  1.6.0
	 * @return bool|WP_Error       Returns true if file write is ok, WP_Error on error.
	 */
	private function get_remote_avatar( $id_or_email, $size ) {
		$gravatar = get_avatar_data( $id_or_email, array(
			'size' => $size,
		));

		if ( true === $gravatar['found_avatar'] ) {
			$remote_avatar = wp_remote_get( $gravatar['url'] );
			/**
			 * TODO: if png is used here, then we need to use png in get_cached_avatar().
			$header = $remote_avatar['headers']->getAll();
			switch ( $header['content-type'] ) {
				case 'image/jpeg':
				default:
					$extension = '.jpg';
					break;
				case 'image/png':
					$extension = '.png';
					break;
			}
			*/

			/**
			 * Filename.
			 * Format: [md5_hash]x[size].[extension]
			 * Example: 0973085bb3339de14706edda7bc62581x100.jpg
			 */
			$email_hash = $this->get_email_hash( $id_or_email );
			$file = $email_hash . 'x' . $size . '.jpg';
			return $this->filesystem->write( $file, $remote_avatar['body'] );
		} else {
			return new WP_Error( 'gravatar-not-found', __( 'Error fetching Gravatar. Gravatar not found.', 'wphb' ) );
		}
	}

	/**
	 * Calculate email hash
	 *
	 * @access private
	 * @param  mixed $id_or_email  The Gravatar to retrieve a URL for. Accepts a user_id, gravatar md5 hash,
	 *                             user email, WP_User object, WP_Post object, or WP_Comment object.
	 * @return string              Email hash.
	 * @since  1.6.0
	 */
	private function get_email_hash( $id_or_email ) {
		$email_hash = '';
		$user = $email = false;

		// Process the user identifier.
		if ( is_numeric( $id_or_email ) ) {
			$user = get_user_by( 'id', absint( $id_or_email ) );
		} elseif ( is_string( $id_or_email ) ) {
			if ( strpos( $id_or_email, '@md5.gravatar.com' ) ) {
				// MD5 hash.
				list( $email_hash ) = explode( '@', $id_or_email );
			} else {
				// Email address.
				$email = $id_or_email;
			}
		} elseif ( $id_or_email instanceof WP_User ) {
			// User Object.
			$user = $id_or_email;
		} elseif ( $id_or_email instanceof WP_Post ) {
			// Post Object.
			$user = get_user_by( 'id', (int) $id_or_email->post_author );
		} elseif ( $id_or_email instanceof WP_Comment ) {
			/**
			 * Filters the list of allowed comment types for retrieving avatars.
			 *
			 * @since 3.0.0
			 *
			 * @param array $types An array of content types. Default only contains 'comment'.
			 */
			$allowed_comment_types = apply_filters( 'get_avatar_comment_types', array( 'comment' ) );
			if ( ! empty( $id_or_email->comment_type ) && ! in_array( $id_or_email->comment_type, (array) $allowed_comment_types ) ) {
				$args['url'] = false;
				/** This filter is documented in wp-includes/link-template.php */
				return apply_filters( 'get_avatar_data', $args, $id_or_email );
			}

			if ( ! empty( $id_or_email->user_id ) ) {
				$user = get_user_by( 'id', (int) $id_or_email->user_id );
			}
			if ( ( ! $user || is_wp_error( $user ) ) && ! empty( $id_or_email->comment_author_email ) ) {
				$email = $id_or_email->comment_author_email;
			}
		} // End if().

		if ( ! $email_hash ) {
			if ( $user ) {
				$email = $user->user_email;
			}

			if ( $email ) {
				$email_hash = md5( strtolower( trim( $email ) ) );
			}
		}

		return $email_hash;
	}

	/**
	 * Get cached avatar
	 *
	 * @param  string $image        Image source.
	 * @param  mixed  $id_or_email  The Gravatar to retrieve a URL for. Accepts a user_id, gravatar md5 hash,
	 *                              user email, WP_User object, WP_Post object, or WP_Comment object.
	 * @param  int    $size         Image size.
	 * @param  bool   $default      Not used. URL for an image, defaults to the "Mystery Person".
	 * @param  string $alt          Alternate text to use in the avatar image tag.
	 * @return string $image        Image source.
	 * @since  1.6.0
	 * TODO: handle $default unset avatars
	 */
	public function get_cached_avatar( $image, $id_or_email, $size, $default, $alt ) {
		if ( ! current_user_can( wphb_get_admin_capability() ) ) {
			return false;
		}

		$email_hash = $this->get_email_hash( $id_or_email );

		// Avatar file names for normal and retina.
		$images = array(
			'normal' => array(
				'file'  => $email_hash . 'x' . $size . '.jpg',
				'size' => $size,
			),
			'retina' => array(
				'file'  => $email_hash . 'x' . ( $size * 2 ) . '.jpg',
				'size' => $size * 2,
			),
		);

		foreach ( $images as $img ) {
			// Try to save the avatar.
			if ( $this->filesystem->find( $img['file'] ) ) {
				break;
			}

			$file_write = $this->get_remote_avatar( $id_or_email, $img['size'] );
			// If error creating file - log and return original image.
			if ( is_wp_error( $file_write ) ) {
				self::log( $file_write->get_error_message() );
				$this->error = $file_write;
				return $image;
			}
		}

		$gravatar_dir = trailingslashit( substr( $images['normal']['file'], 0, 3 ) );

		$src = $this->filesystem->baseurl . $gravatar_dir . $images['normal']['file'];
		$srcset = $this->filesystem->baseurl . $gravatar_dir . $images['retina']['file'];

		$image = "<img alt='{$alt}' src='{$src}' srcset='$srcset 2x' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";

		return $image;
	}

	/**
	 * Log errors.
	 *
	 * @since 1.6.0
	 * @param string $message  Error message.
	 */
	private function log( $message ) {
		if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
			$date = current_time( 'mysql' );
			if ( ! is_string( $message ) ) {
				$message = print_r( $message, true );
			}
			error_log( '[' . $date . '] - Error in Hummingbird Gravatar module:  ' . $message );
		}
	}

}