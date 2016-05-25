<?php

/**
 * @author: Hoang Ngo
 */
class WD_Scan_Result_Core_Item_Model extends WD_Scan_Result_Item_Model {
	public $delete_tooltip;
	public $delete_confirm_text;

	public function __wakeup() {
		$this->delete_tooltip      = __( "Delete this file", wp_defender()->domain );
		$this->delete_confirm_text = 'delete_confirm_msg';
	}

	/**
	 * @return mixed
	 */
	public function get_name() {
		return pathinfo( $this->name, PATHINFO_BASENAME );
	}

	public function can_delete() {
		$detail = $this->detail;
		if ( $detail['is_added'] == true ) {
			return true;
		}

		return false;
	}

	/**
	 * @return mixed
	 */
	public function get_sub() {
		if ( stristr( PHP_OS, 'win' ) ) {
			$abs_path = rtrim( ABSPATH, '/' );
			$abs_path .= '\\';
			$sub = str_replace( $abs_path, '\\', $this->name );

			return $sub;
		} else {
			return str_replace( ABSPATH, '/', $this->name );
		}
	}

	/**
	 * @return string
	 */
	public function get_detail() {
		$detail = $this->detail;
		if ( $detail['is_added'] == true ) {
			return '<strong>' . esc_html( __( "Unknown file in WordPress core", wp_defender()->domain ) ) . '</strong>';
		} else {
			return '<strong>' . esc_html( __( "This WordPress core file appears modified", wp_defender()->domain ) ) . '</strong>';
		}
	}

	public function can_ignore() {
		return true;
	}

	/**
	 * @return null
	 */
	public function get_type() {
		return WD_Scan_Result_Model::get_system_type_label( WD_Scan_Result_Model::TYPE_CORE );
	}

	/**
	 * @return string
	 */
	public function get_system_type() {
		return WD_Scan_Result_Model::TYPE_CORE;
	}

	/**
	 * @return array
	 */
	public function get_raw_data() {
		return array(
			'file'     => $this->name,
			'type'     => 'core_integrity',
			'behavior' => $this->detail['is_added'] == true ? 'added' : 'modified',
			'date'     => @filemtime( $this->name ),
			'size'     => @filesize( $this->name )
		);
	}

	/**
	 * this will remove the file, and self out of result
	 */
	public function remove() {
		//first we need to unlink the file
		if ( @unlink( $this->name ) ) {
			$model = WD_Scan_Api::get_last_scan();

			$model->delete_item_from_result( $this->id );
		} else {
			return new WP_Error( 'cant_unlink', __( "It appears Defender cannot delete these files, tarnation! You should try and delete them yourself via FTP, cPanel file manager or however you access your server, or ask your hosting support to do it for you.", wp_defender()->domain ) );
		}
	}

	public function can_automate_resolve() {
		if ( $this->detail['is_added'] == true ) {
			return false;
		}

		return true;
	}

	/**
	 * @return bool|null|WP_Error
	 */
	public function automate_resolve() {
		if ( $this->detail['is_added'] == true ) {
			return null;
		}

		$original = $this->get_file_original_source();
		if ( file_put_contents( $this->name, $original, LOCK_EX ) ) {
			return true;
		}

		return new WP_Error( 'cant_write', sprintf( __( "It seems the %s file is currently using by another process or isn't writeable.", wp_defender()->domain ), $this->get_sub() ) );
	}

	/**
	 * this will display the instruction
	 */
	public function clean() {
		/**
		 * case :
		 * 1. modified
		 *  - display date/time when modified, and a link to replacement file.
		 * - if suspicuous found, display strongly recommend
		 * 2. added
		 * -display date/time and size. if suspicious found, display strongly recommend
		 */

		$model  = WD_Scan_Api::get_last_scan();
		$groups = $model->group_result_by_file( $this->name );
		$output = $this->_get_resolve_html_template();
		$output = str_replace(
			array(
				'{{location}}',
				'{{size}}',
				'{{date}}'
			),
			array(
				$this->name,
				$this->convert_size( filesize( $this->name ) ),
				date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), filemtime( $this->name ) )
			),
			$output );

		$error_msg = '';
		if ( count( $groups ) > 1 ) {
			foreach ( $groups as $item_result ) {
				if ( $item_result instanceof WD_Scan_Result_File_Item_Model ) {
					//this mean suspicious found
					$error_msg = __( "Something fishy is going on here. This file isn’t a WordPress core file and has suspicious content. We recommend replacing or isolating it right away!", wp_defender()->domain );
				}
			}
		}
		if ( $this->detail['is_added'] == false ) {
			$resolve_note = $this->_get_instruction();
			$output       = str_replace( '{{resolve_note}}', $resolve_note, $output );
		} elseif ( empty( $error_msg ) ) {
			$output = str_replace( '{{resolve_note}}', '<p>' . __( "We found this file floating around in your WordPress file list but it's not required by your current WP Version. As far as we can tell it's harmless (probably from an older WP install) so you can either delete it or ignore it, up to you! (please be sure to make a backup before you do start deleting files).", wp_defender()->domain ) . '</p>', $output );
		} else {
			$error_msg = '<p>' . $error_msg . '</p>';
			$output    = str_replace( '{{resolve_note}}', $error_msg, $output );
		}

		return $output;
	}

	private function _get_instruction() {
		ob_start();
		?>
		<p><?php _e( "Don't you know Defender can automate resolving this for you, just in one click. Please note that this will
			update your file content permanently.", wp_defender()->domain ) ?></p>
		<?php
		return ob_get_clean();
	}

	/**
	 * Retrive original content of a file
	 *
	 * @return mixed|string
	 * @since 1.0.2
	 */
	public function get_file_original_source( $force = false ) {
		if ( $this->detail['is_added'] == true ) {
			return null;
		}

		global $wp_version, $wp_local_package;
		if ( isset( $wp_local_package ) ) {
			$locale = $wp_local_package;
		} else {
			$locale = null;
		}
		$ds = DIRECTORY_SEPARATOR;
		if ( $this->get_sub() == $ds . 'wp-includes' . $ds . 'version.php' && ! empty( $locale ) ) {
			$upload_dirs = wp_upload_dir();
			$path        = $upload_dirs['basedir'] . $ds . 'wp-defender' . $ds;
			if ( file_exists( $path . $wp_version . '.zip' ) ) {
				//get last time

			}
			if ( ! file_exists( $path . $wp_version . '.zip' ) ) {
				$source_file_url = "https://{$locale}.wordpress.org/wordpress-$wp_version-{$locale}.zip";
				$tmp             = download_url( $source_file_url );
				if ( is_wp_error( $tmp ) ) {
					return $tmp;
				}
				//move into vault folder
				$upload_dirs = wp_upload_dir();
				$path        = $upload_dirs['basedir'] . $ds . 'wp-defender' . $ds;
				if ( ! copy( $tmp, $path . $wp_version . '.zip' ) ) {
					return new WP_Error( 'cant_copy', sprintf( __( "Please make sure the folder %s writeable", wp_defender()->domain ), $path ) );
				}
				@unlink( $tmp );
			}

			WP_Filesystem();
			//unzip
			if ( is_wp_error( ( $res = unzip_file( $path . $wp_version . '.zip', $path ) ) ) ) {
				return $res;
			}

			//looking
			$file_path = $path . 'wordpress' . $ds . 'wp-includes' . $ds . 'version.php';

			if ( file_exists( $file_path ) ) {
				$content = file_get_contents( $file_path );
				global $wp_filesystem;
				$wp_filesystem->rmdir( $path . 'wordpress', true );

				return $content;
			}

			return new WP_Error( 'generic', __( "An unexpected error happened. Please try again", wp_defender()->domain ) );
		} else {
			//no global locale, means this is enUS
			$rev_path = $this->get_sub();
			if ( stristr( PHP_OS, 'win' ) ) {
				$rev_path = str_replace( '\\', '/', $rev_path );
			}
			$rev_path        = ltrim( $rev_path, '/' );
			$source_file_url = "http://core.svn.wordpress.org/tags/$wp_version/" . $rev_path;
			if ( ! function_exists( 'download_url' ) ) {
				require_once ABSPATH . 'wp-admin' . $ds . 'includes' . $ds . 'file.php';
			}
			$tmp = download_url( $source_file_url );
			if ( is_wp_error( $tmp ) ) {
				return $tmp;
			}
			$content = file_get_contents( $tmp );
			@unlink( $tmp );

			return $content;
		}
	}

	public function check( $model = null, $md5 = null ) {
		if ( ! is_object( $model ) ) {
			$model = WD_Scan_Api::get_last_scan();
		}

		if ( ! file_exists( $this->name ) ) {
			$model->delete_item_from_result( $this->id );

			return true;
		}
		if ( is_null( $md5 ) ) {
			//we will need to lookpup the md5 each request to check this file content
			$md5 = WD_Utils::get_cache( 'wd_md5_checksum' );
			if ( $md5 == false || is_wp_error( $md5 ) || ! is_array( $md5 ) ) {
				$md5 = WD_Scan_Api::download_md5_files();
				if ( is_wp_error( $md5 ) ) {
					return false;
				}
				//short cache, as user might update the version anytime
				WD_Utils::cache( 'wd_md5_checksum', $md5, 3600 );
			}
		}
		$rev_path = str_replace( '\\', '/', $this->get_sub() );

		if ( isset( $md5[ ltrim( $rev_path, '/' ) ] ) ) {
			$hash = $md5[ ltrim( $rev_path, '/' ) ];
			if ( stristr( PHP_OS, 'win' ) ) {
				$file_content = file_get_contents( $this->name );
				$file_content = str_replace( '\r\n', '\n', $file_content );

				$md5_file = md5( $file_content );
				$hash     = $md5[ ltrim( $rev_path, '/' ) ];

				if ( $hash == $md5_file ) {
					$model->delete_item_from_result( $this->id );

					return true;
				} elseif ( $hash == md5_file( $this->name ) ) {
					$model->delete_item_from_result( $this->id );

					return true;
				}
			} else {
				if ( $hash == md5_file( $this->name ) ) {
					$model->delete_item_from_result( $this->id );

					return true;
				}
			}
		}

		return false;
	}

	private function _get_resolve_html_template() {
		$id = $this->id;
		ob_start();
		?>
		<div class="wp-defender">
			<div class="wd-scan-resolve-dialog">
				<div class="group">
					<div class="col span_3_of_12">
						<strong><?php _e( "Location: ", wp_defender()->domain ) ?></strong>
					</div>
					<div class="col span_9_of_12">
						{{location}}
					</div>
				</div>
				<div class="group">
					<div class="col span_3_of_12">
						<strong><?php _e( "Size: ", wp_defender()->domain ) ?></strong>
					</div>
					<div class="col span_9_of_12">
						{{size}}
					</div>
				</div>
				<div class="group">
					<div class="col span_3_of_12">
						<strong><?php echo( $this->detail['is_added'] == true ? __( "Date added: " ) : __( "Date modified:" ) ) ?></strong>
					</div>
					<div class="col span_9_of_12">
						{{date}}
					</div>
				</div>
				<hr/>
				<div>
					{{resolve_note}}
				</div>
				<div class="wd-ignore-cancel wd-inline">
					<form method="post" class="wd-resolve-frm">
						<input type="hidden" name="action" value="wd_resolve_result">
						<?php wp_nonce_field( 'wd_resolve', 'wd_resolve_nonce' ) ?>
						<input type="hidden" value="<?php echo esc_attr( get_class( $this ) ) ?>" name="class">
						<input type="hidden" name="id" value="<?php echo esc_attr( $id ) ?>"/>
						<?php if ( $this->can_automate_resolve() ): ?>
							<button data-type="resolve_ci" class="button wd-button button-small"
							        type="submit"><?php _e( "Restore File", wp_defender()->domain ) ?></button>
							<a href="<?php echo network_admin_url( 'admin.php?page=wdf-issue-detail&id=' . $id ) ?>"
							   class="button wd-button button-secondary button-small">
								<?php _e( "Review changes", wp_defender()->domain ) ?>
							</a>
						<?php endif; ?>
						<?php if ( $this->can_ignore() ): ?>
							<button type="submit" data-confirm="<?php echo 'ignore_confirm_msg' ?>"
							        data-confirm-button="<?php echo 'ignore_confirm_btn' ?>" data-type="ignore"
							        class="button button-grey button-small">
								<?php _e( "Ignore File", wp_defender()->domain ) ?>
							</button>&nbsp;
						<?php endif; ?>
						<?php if ( $this->can_delete() ): ?>
							<button data-type="delete" data-confirm-button="<?php echo 'delete_confirm_btn' ?>"
							        data-confirm="<?php echo 'delete_confirm_msg' ?>" type="submit"
							        class="button button-red button-small">
								<?php _e( "Delete File", wp_defender()->domain ) ?>
							</button>
						<?php endif; ?>
					</form>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}