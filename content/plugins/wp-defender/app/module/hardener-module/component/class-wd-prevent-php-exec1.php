<?php

class WD_Prevent_PHP_Execution1 extends WD_Protect_Core_Dir {

	public function on_creation() {
		$this->id         = 'protect_upload_dir';
		$this->title      = __( "Prevent PHP execution", wp_defender()->domain );
		$this->can_revert = false;

		$this->add_action( 'admin_footer', 'print_scripts' );
		$this->add_ajax_action( $this->generate_ajax_action( 'apply_htaccess_upload' ), 'process' );
	}

	/**
	 * @return bool
	 */
	public function check( $force = false ) {
		//get from cache maybe
		if ( isset( $this->check_cache ) && ! $force ) {
			return $this->check_cache;
		}

		$this->check_cache = $this->check_upload_protected() && $this->check_content_protected() && $this->check_include_protected();

		return $this->check_cache;
	}

	public function process() {
		if ( ! WD_Utils::check_permission() ) {
			return;
		}

		if ( WD_Utils::is_nginx() ) {
			//nothing to do here
		} else {
			if ( ! $this->verify_nonce( 'apply_htaccess_upload' ) ) {
				return;
			}

			$type = WD_Utils::http_post( 'type', null );
			if ( $type == 'wp_upload' ) {
				$this->protect_upload();
			} elseif ( $type == 'revert_wp_upload' ) {
				$this->revert_protect_upload();
			} elseif ( $type == 'wp_content' ) {
				$this->protect_content();
			} elseif ( $type == 'revert_wp_content' ) {
				$this->revert_wp_content();
			} elseif ( $type == 'wp_include' ) {
				$this->protect_include();
			} elseif ( $type == 'revert_wp_include' ) {
				$this->revert_wp_include();
			}
		}
	}

	/**
	 * Apply a htacces file inside wp-content folder, to prevent
	 * 1. Browser listing (usually we got a index.php, however, another layer stll worth)
	 * 2. Prevent directly access to php file
	 * 3. Prevent any access to htaccess file
	 *
	 * @access public
	 * @since 1.0
	 */
	public function protect_content( $htaccess_path = null ) {
		if ( is_null( $htaccess_path ) ) {
			$htaccess_path = WP_CONTENT_DIR . DIRECTORY_SEPARATOR . '.htaccess';
		}

		if ( ! file_exists( $htaccess_path ) ) {
			file_put_contents( $htaccess_path, '', LOCK_EX );
		}
		$content = file( $htaccess_path );
		if ( ! is_array( $content ) ) {
			$content = array();
		}
		$based = content_url( 'index.php' );
		$files = array();
		if ( ! $this->check_rule_by_request( self::PREVENT_PHP_ACCESS, $based, true ) ) {
			$files[] = $this->create_rule( self::PREVENT_PHP_ACCESS );
		}

		if ( count( $files ) ) {
			$files   = array_merge( array( '## WP Defender - Prevent PHP Execution ##' ), $files );
			$files[] = '## WP Defender - End ##';
			$content = array_merge( $content, $files );
		}

		$content = implode( PHP_EOL, $content );
		//remove duplciate new line
		$content = preg_replace( "/\n+/", "\n", $content );

		if ( file_put_contents( $htaccess_path, $content ) ) {
			if ( $this->check() ) {
				$this->after_processed();
			}
			wp_send_json( array(
				'status'  => 1,
				'element' => $this->get_protect_wp_content_html(),
				'done'    => $this->check(),
			) );
		} else {
			$this->output_error( 'write_permission', __( "Can't write to the file %s", wp_defender()->domain ) );
		}
	}

	public function protect_include( $htaccess_path = null ) {
		if ( is_null( $htaccess_path ) ) {
			$htaccess_path = ABSPATH . WPINC . DIRECTORY_SEPARATOR . '.htaccess';
		}
		if ( ! file_exists( $htaccess_path ) ) {
			file_put_contents( $htaccess_path, '', LOCK_EX );
		}
		$content = file( $htaccess_path );
		if ( ! is_array( $content ) ) {
			$content = array();
		}
		$based = includes_url( 'wp-db.php' );

		$files = array();
		if ( ! $this->check_rule_by_request( self::PREVENT_PHP_ACCESS, $based, true ) ) {
			$files[] = $this->create_rule( self::PREVENT_PHP_ACCESS );
		}

		if ( $this->check_rule( $content, self::WPINCLUDE_EXCLUDE ) == false ) {
			$files[] = $this->create_rule( self::WPINCLUDE_EXCLUDE );
		}

		if ( count( $files ) ) {
			$files   = array_merge( array( '## WP Defender - Prevent PHP Execution ##' ), $files );
			$files[] = '## WP Defender - End ##';
			$content = array_merge( $content, $files );
		}

		$content = implode( PHP_EOL, $content );
		//remove duplciate new line
		$content = preg_replace( "/\n+/", "\n", $content );

		if ( file_put_contents( $htaccess_path, $content ) ) {
			if ( $this->check() ) {
				$this->after_processed();
			}
			wp_send_json( array(
				'status'  => 1,
				'element' => $this->get_protect_wp_include_html(),
				'done'    => $this->check(),
			) );
		} else {
			$this->output_error( 'write_permission', __( "Can't write to the file %s", wp_defender()->domain ) );
		}
	}

	/**
	 * Revert the htaccess inside wp-content folder to original, if only changes from this plugin, we will remove it
	 */
	public function revert_wp_content() {
		$htaccess_path = WP_CONTENT_DIR . DIRECTORY_SEPARATOR . '.htaccess';
		//we need to check what rules applied here
		$content = file( $htaccess_path );

		//we will get all the const here
		$class  = new ReflectionClass( __CLASS__ );
		$consts = $class->getConstants();
		foreach ( $consts as $const ) {
			if ( $const != self::PREVENT_PHP_ACCESS ) {
				continue;
			}

			$rule = $this->get_rules( $const );
			if ( ! empty( $rule ) ) {
				if ( ( $indexer = $this->check_rule( $content, $const ) ) !== false ) {
					//need to get the rule block, and unset it
					list( $first, $last ) = $indexer;
					//var_dump( $indexer );
					if ( $first == $last ) {
						$content[ $first ] = '';
					} else {
						for ( $i = $first; $i <= $last; $i ++ ) {
							$content[ $i ] = '';
						}
					}
				}
			}
		}
		$content = array_map( 'trim', $content );
		$content = array_filter( $content );

		$can_revert = false;
		if ( $this->check() ) {
			$can_revert = true;
		}
		if ( empty( $content ) ) {
			//nothing here, just remove the file
			if ( unlink( $htaccess_path ) ) {
				wp_send_json( array(
					'status'  => 1,
					'revert'  => $can_revert,
					'element' => $this->get_protect_wp_content_html()
				) );
			}
		}

		if ( file_put_contents( $htaccess_path, implode( PHP_EOL, $content ) ) ) {
			wp_send_json( array(
				'status'  => 1,
				'revert'  => $can_revert,
				'element' => $this->get_protect_wp_content_html()
			) );
		} else {
			$this->output_error( 'write_permission', __( "Can't write to the file %s", wp_defender()->domain ) );
		}
	}

	/**
	 *
	 */
	public function revert_wp_include() {
		$htaccess_path = ABSPATH . WPINC . DIRECTORY_SEPARATOR . '.htaccess';
		//we need to check what rules applied here
		$content = file( $htaccess_path );

		//we will get all the const here
		$class  = new ReflectionClass( __CLASS__ );
		$consts = $class->getConstants();
		foreach ( $consts as $const ) {
			if ( $const != self::PREVENT_PHP_ACCESS && $const != self::WPINCLUDE_EXCLUDE ) {
				continue;
			}

			$rule = $this->get_rules( $const );
			if ( ! empty( $rule ) ) {
				if ( ( $indexer = $this->check_rule( $content, $const ) ) !== false ) {
					//need to get the rule block, and unset it
					list( $first, $last ) = $indexer;
					//var_dump( $indexer );
					if ( $first == $last ) {
						$content[ $first ] = '';
					} else {
						for ( $i = $first; $i <= $last; $i ++ ) {
							$content[ $i ] = '';
						}
					}
				}
			}
		}
		$content    = array_map( 'trim', $content );
		$content    = array_filter( $content );
		$can_revert = false;
		if ( $this->check() ) {
			$can_revert = true;
		}
		if ( empty( $content ) ) {
			//nothing here, just remove the file
			if ( unlink( $htaccess_path ) ) {
				wp_send_json( array(
					'status'  => 1,
					'element' => $this->get_protect_wp_include_html(),
					'revert'  => $can_revert
				) );
			}
		}

		if ( file_put_contents( $htaccess_path, implode( PHP_EOL, $content ) ) ) {
			wp_send_json( array(
				'status'  => 1,
				'element' => $this->get_protect_wp_include_html(),
				'revert'  => $can_revert
			) );
		} else {
			$this->output_error( 'write_permission', __( "Can't write to the file %s", wp_defender()->domain ) );
		}
	}

	public function protect_upload( $htaccess_path = null ) {
		if ( is_null( $htaccess_path ) ) {
			$upload_dir    = wp_upload_dir();
			$htaccess_path = $upload_dir['basedir'] . DIRECTORY_SEPARATOR . '.htaccess';
		}

		if ( ! file_exists( $htaccess_path ) ) {
			file_put_contents( $htaccess_path, '', LOCK_EX );
		}
		$content = file( $htaccess_path );
		if ( ! is_array( $content ) ) {
			$content = array();
		}
		$files = array();
		if ( ! $this->check_upload_protected() ) {
			$files[] = $this->create_rule( self::PREVENT_PHP_ACCESS );
		}

		if ( count( $files ) ) {
			$files   = array_merge( array( '## WP Defender - Prevent PHP Execution ##' ), $files );
			$files[] = '## WP Defender - End ##';
			$content = array_merge( $content, $files );
		}

		$content = implode( PHP_EOL, $content );
		//remove duplciate new line
		$content = preg_replace( "/\n+/", "\n", $content );

		if ( file_put_contents( $htaccess_path, $content ) ) {
			if ( $this->check() ) {
				$this->after_processed();
			}
			wp_send_json( array(
				'status'  => 1,
				'element' => $this->get_protect_upload_html(),
				'done'    => $this->check(),
			) );
		} else {
			$this->output_error( 'write_permission', __( "Can't write to the file %s", wp_defender()->domain ) );
		}

		return;
		if ( ! file_exists( $htaccess_path ) ) {
			$files = array();
			//all empty in this case, we just create ours
			$files[] = '## WP Defender - Prevent PHP Execution ##';
			$files[] = $this->create_rule( self::PREVENT_PHP_ACCESS );
			$files[] = '## WP Defender - End ##';
			//now just put this
			if ( file_put_contents( $htaccess_path, implode( PHP_EOL, $files ) ) ) {
				if ( $this->check() ) {
					$this->after_processed();
				}

				wp_send_json( array(
					'status'  => 1,
					'element' => $this->get_protect_upload_html(),
					'done'    => $this->check()
				) );
			} else {
				$this->output_error( 'write_permission', __( "Can't write to the file %s", wp_defender()->domain ) );
			}
		} else {
			//this case, rarely jump in, but still
			$content  = file( $htaccess_path );
			$will_add = array();
			if ( $this->check_rule( $content, self::PREVENT_PHP_ACCESS ) == false ) {
				$will_add[] = $this->create_rule( self::PREVENT_PHP_ACCESS );
			}
			if ( count( $will_add ) ) {
				$will_add   = array_merge( array( '## WP Defender - Prevent PHP Execution ##' . PHP_EOL ), $will_add );
				$will_add[] = '## WP Defender - End ##' . PHP_EOL;
				$content    = array_merge( $content, $will_add );
			}
			$content = implode( PHP_EOL, $content );
			//remove duplciate new line
			$content = preg_replace( "/\n+/", "\n", $content );
			if ( file_put_contents( $htaccess_path, $content ) ) {
				if ( $this->is_ajax() ) {
					if ( $this->check() ) {
						$this->after_processed();
					}

					wp_send_json( array(
						'status'  => 1,
						'element' => $this->get_protect_upload_html(),
						'done'    => $this->check()
					) );
				} else {
					return true;
				}
			} else {
				$this->output_error( 'write_permission', __( "Can't write to the file %s", wp_defender()->domain ) );
			}
		}
	}

	public function revert_protect_upload( $htaccess_path = null ) {
		if ( is_null( $htaccess_path ) ) {
			$upload_dir    = wp_upload_dir();
			$htaccess_path = $upload_dir['basedir'] . DIRECTORY_SEPARATOR . '.htaccess';
		}
		//we need to check waht rules applied here
		$content = file( $htaccess_path );

		//we will get all the const here
		$class  = new ReflectionClass( __CLASS__ );
		$consts = $class->getConstants();
		foreach ( $consts as $const ) {
			if ( $const != self::PREVENT_PHP_ACCESS ) {
				continue;
			}

			$rule = $this->get_rules( $const );
			if ( ! empty( $rule ) ) {
				if ( ( $indexer = $this->check_rule( $content, $const ) ) !== false ) {
					//need to get the rule block, and unset it
					list( $first, $last ) = $indexer;
					//var_dump( $indexer );
					if ( $first == $last ) {
						$content[ $first ] = '';
					} else {
						for ( $i = $first; $i <= $last; $i ++ ) {
							$content[ $i ] = '';
						}
					}
				}
			}
		}
		$content    = array_map( 'trim', $content );
		$content    = array_filter( $content );
		$can_revert = false;
		if ( $this->check() ) {
			$can_revert = true;
		}
		if ( empty( $content ) ) {
			//nothing here, just remove the file
			if ( unlink( $htaccess_path ) ) {
				wp_send_json( array(
					'status'  => 1,
					'revert'  => $can_revert,
					'element' => $this->get_protect_upload_html()
				) );
			}
		}

		if ( file_put_contents( $htaccess_path, implode( PHP_EOL, $content ) ) ) {
			wp_send_json( array(
				'status'  => 1,
				'revert'  => $can_revert,
				'element' => $this->get_protect_upload_html()
			) );
		} else {
			$this->output_error( 'write_permission', __( "Can't write to the file %s", wp_defender()->domain ) );
		}
	}

	public function print_scripts() {
		?>
		<script type="text/javascript">
			jQuery(function ($) {
				$('body').on('click', '#protect_upload_dir_frm input[type=submit]', function () {
					$('#protect_upload_dir_frm').find('input[type=submit]').removeAttr('clicked');
					$(this).attr('clicked', true);
				});
				$('body').on('submit', '#protect_upload_dir_frm', function () {
					var that = $(this);
					var parent = $(this).closest('.wd-hardener-rule');
					var data = that.serialize();
					var clicked = that.find("input[type=submit][clicked=true]");
					data += '&type=' + clicked.attr('name');

					$.ajax({
						type: 'POST',
						'url': ajaxurl,
						data: data,
						beforeSend: function () {
							clicked.attr('disabled', 'disabled').css({
								'cursor': 'progress'
							});
						},
						success: function (data) {
							if (data.status == 0) {
								clicked.removeAttr('disabled').css({
									'cursor': 'pointer'
								});
								$('#protect_core_dir .wd-error').html(data.error).removeClass('wd-hide');
							} else {
								$('#protect_core_dir .wd-error').html('').addClass('wd-hide');
								if (data.element != undefined) {
									clicked.closest('.group').replaceWith(data.element);
								}
								if (data.done == 1) {
									parent.hide(500, function () {
										var div = parent.detach();
										div.prependTo($('.wd-hardener-success'));
										div.find('.rule-title').removeClass('issue').addClass('fixed').find('button').hide();
										div.show(500, function () {
											/*$('html, body').animate({
											 scrollTop: div.find('.rule-title').offset().top
											 }, 1000);*/
										});
									})
								}

								if (data.revert == 1) {
									parent.hide(500, function () {
										$('.hardener-error-container').removeClass('wd-hide');
										var div = parent.detach();
										div.appendTo($('.wd-hardener-error'));
										div.find('.rule-title').removeClass('fixed').addClass('issue').find('button').show();
										div.show(500, function () {
											/*$('html, body').animate({
											 scrollTop: div.find('.rule-title').offset().top
											 }, 1000);*/
										});
									})
								}
							}
						}
					});
					return false;
				})
			})
		</script>
		<?php
	}

	public function display() {
		?>
		<div class="wd-hardener-rule">
			<?php echo $this->get_rule_title(); ?>
			<div class="wd-clearfix"></div>

			<div id="<?php echo $this->id ?>" class="wd-rule-content">
				<h4 class="tl"><?php _e( "OVERVIEW", wp_defender()->domain ) ?></h4>

				<p><?php _e( "By default, a plugin/theme vulnerability could allow a PHP file to get uploaded into your site's directories and in turn execute harmful scripts that can wreak havoc on your website. Prevent this altogether by disabling direct PHP execution in directories that don't require it.", wp_defender()->domain ) ?></p>

				<h4 class="tl"><?php _e( "How To Fix", wp_defender()->domain ) ?></h4>

				<div class="wd-error wd-hide">

				</div>
				<?php if ( WD_Utils::is_nginx() ) {
					echo $this->nginx_output();
				} else {
					$this->apache_output();
				} ?>

			</div>
		</div>
		<?php
	}

	/**
	 * This will check the content of htaccess file, and see if we missing any rules
	 *
	 * @return bool
	 */
	public function check_content_protected() {
		$based = content_url( 'index.php' );
		if ( ! $this->check_rule_by_request( self::PROTECT_HTACCESS, $based, true ) ) {
			return false;
		}

		return true;
	}


	public function check_include_protected() {
		$based = includes_url( 'wp-db.php' );
		if ( ! $this->check_rule_by_request( self::PROTECT_HTACCESS, $based, true ) ) {
			return false;
		}

		return true;
	}

	public function check_upload_protected() {
		$upload_dirs  = wp_upload_dir();
		$defender_dir = $upload_dirs['basedir'];

		if ( ! file_exists( $defender_dir . '/defender-access-test.php' ) ) {
			file_put_contents( $defender_dir . '/defender-access-test.php', '' );
		}

		$based = $upload_dirs['baseurl'] . '/defender-access-test.php';
		if ( ! $this->check_rule_by_request( self::PROTECT_HTACCESS, $based, true ) ) {
			return false;
		}

		return true;
	}

	/**
	 * If the server is nginx, we will output an instruction
	 */
	private function nginx_output() {
		ob_start();

		//get proper paths relative to document root for this virtualhost
		$wp_includes = str_replace( $_SERVER['DOCUMENT_ROOT'], '', ABSPATH . WPINC );
		$wp_content  = str_replace( $_SERVER['DOCUMENT_ROOT'], '', WP_CONTENT_DIR );

		$rules = "# Stop php access except to needed files in wp-includes
location ~* ^$wp_includes/.*(?<!(js/tinymce/wp-tinymce))\.php$ {
  internal; #internal allows ms-files.php rewrite in multisite to work
}

# Specifically locks down upload directories in case full wp-content rule below is skipped
location ~* /(?:uploads|files)/.*\.php$ {
  deny all;
}

# Deny direct access to .php files in the /wp-content/ directory (including sub-folders).
#  Note this can break some poorly coded plugins/themes, replace the plugin or remove this block if it causes trouble
location ~* ^$wp_content/.*\.php$ {
  deny all;
}
";
		?>
		<div class="group wd-no-margin">
			<p><?php _e( "For NGINX servers:", wp_defender()->domain ) ?></p>
			<ol>
				<li>
					<?php _e( "Copy the generated code into your site specific .conf file usually located in a subdirectory under /etc/nginx/... or /usr/local/nginx/conf/...", wp_defender()->domain ) ?>
				</li>
				<li>
					<?php _e( "Add the code above inside the <strong>server</strong> section in the file, right before the php location block. Looks something like:", wp_defender()->domain ) ?>
					<pre>location ~ \.php$ {</pre>
				</li>
				<li>
					<?php _e( "Reload NGINX.", wp_defender()->domain ) ?>
				</li>
			</ol>
			<p><?php printf( __( "Still having trouble? <a target='_blank' href=\"%s\">Open a support ticket</a>.", wp_defender()->domain ), 'https://premium.wpmudev.org/forums/forum/support#question' ) ?></p>
			<pre>
## WP Defender - Prevent PHP Execution ##
				<?php echo esc_html( $rules ); ?>
				## WP Defender - End ##
			</pre>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * If the server is apache, we will output a form for append htaccess
	 */
	private function apache_output() {
		?>
		<div class="wd-well">
			<?php if ( $this->check() ): ?>
				<p>
					<?php _e( "PHP execution is locked down.", wp_defender()->domain ) ?>
				</p>
			<?php else: ?>
				<p>
					<?php _e( "We will place .htaccess files into each of these directories to to prevent PHP execution.", wp_defender()->domain ) ?>
				</p>
			<?php endif; ?>
			<hr/>
			<form id="protect_upload_dir_frm" method="post">
				<?php $this->generate_nonce_field( 'apply_htaccess_upload' ) ?>
				<input type="hidden" name="action"
				       value="<?php echo $this->generate_ajax_action( 'apply_htaccess_upload' ) ?>">
				<?php echo $this->get_protect_upload_html() ?>
				<hr/>
				<?php echo $this->get_protect_wp_content_html() ?>
				<hr/>
				<?php echo $this->get_protect_wp_include_html() ?>
			</form>
		</div>
		<?php
	}

	private function get_protect_wp_content_html() {
		//get proper paths relative to document root for this virtualhost
		$wp_content = str_replace( $_SERVER['DOCUMENT_ROOT'], '', WP_CONTENT_DIR );
		ob_start();
		?>
		<div class="group protect-wp-content">
			<div class="col span_6_of_12">
				<?php echo $wp_content; ?>
				<i class="wdv-icon wdv-icon-fw wdv-icon-ok-sign <?php echo $this->check_content_protected() ? '' : 'wd-hide'; ?>"></i>
			</div>
			<div class="col span_6_of_12 tr">
				<?php if ( $this->check_content_protected() ): ?>
					<input type="submit" class="button button-small button-grey"
					       name="revert_wp_content"
					       value="<?php esc_attr_e( "Revert", wp_defender()->domain ) ?>">
				<?php else: ?>
					<input type="submit" class="button button-small wd-button" name="wp_content"
					       value="<?php esc_attr_e( "Add .htaccess file", wp_defender()->domain ) ?>">
				<?php endif; ?>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}

	private function get_protect_wp_include_html() {
		$wp_includes = str_replace( $_SERVER['DOCUMENT_ROOT'], '', ABSPATH . WPINC );
		ob_start();
		?>
		<div class="group">
			<div class="col span_6_of_12">
				<?php echo $wp_includes; ?>
				<i class="wdv-icon wdv-icon-fw wdv-icon-ok-sign <?php echo $this->check_include_protected() ? '' : 'wd-hide'; ?>"></i>
			</div>
			<div class="col span_6_of_12 tr">
				<?php if ( $this->check_include_protected() ): ?>
					<input type="submit" class="button button-small button-grey"
					       name="revert_wp_include"
					       value="<?php esc_attr_e( "Revert", wp_defender()->domain ) ?>">
				<?php else: ?>
					<input type="submit" class="button button-small wd-button" name="wp_include"
					       value="<?php esc_attr_e( "Add .htaccess file", wp_defender()->domain ) ?>">
				<?php endif; ?>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}

	public function get_protect_upload_html() {
		$upload_dir = wp_upload_dir();
		$wp_uploads = str_replace( $_SERVER['DOCUMENT_ROOT'], '', $upload_dir['basedir'] );
		ob_start();
		?>
		<div class="group">
			<div class="col span_6_of_12">
				<?php echo $wp_uploads; ?>
				<i class="wdv-icon wdv-icon-fw wdv-icon-ok-sign <?php echo $this->check_upload_protected() ? '' : 'wd-hide'; ?>"></i>
			</div>
			<div class="col span_6_of_12 tr">
				<?php if ( $this->check_upload_protected() ): ?>
					<input type="submit" class="button button-small button-grey"
					       name="revert_wp_upload"
					       value="<?php esc_attr_e( "Revert", wp_defender()->domain ) ?>">
				<?php else: ?>
					<input type="submit" class="button button-small wd-button" name="wp_upload"
					       value="<?php esc_attr_e( "Add .htaccess file", wp_defender()->domain ) ?>">
				<?php endif; ?>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}

	public function revert() {

	}
}