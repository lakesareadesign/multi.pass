<?php

/**
 * Class: WD_Prevent_PHP_Execution
 */
class WD_Prevent_PHP_Execution extends WD_Protect_Core_Dir {

	public function on_creation() {
		$this->id          = 'protect_upload_dir';
		$this->title       = esc_html__( "Prevent PHP execution", wp_defender()->domain );
		$this->can_revert  = false;
		$this->check_cache = null;
		$this->init_check_rules();
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

		if ( ! $this->init_test_env() ) {
			return false;
		}

		if ( ! $this->check_rule_by_request( self::PREVENT_PHP_ACCESS, 'wp-includes' ) ) {
			$this->check_cache = false;

			return $this->check_cache;
		}

		if ( ! $this->check_rule_by_request( self::PREVENT_PHP_ACCESS, 'wp-content' ) ) {
			$this->check_cache = false;

			return $this->check_cache;
		}

		if ( ! $this->check_rule_by_request( self::PREVENT_PHP_ACCESS, 'uploads' ) ) {
			$this->check_cache = false;

			return $this->check_cache;
		}

		$this->check_cache = true;

		return $this->check_cache;
	}

	public function process() {
		global $is_apache;
		if ( ! WD_Utils::check_permission() ) {
			return;
		}

		if ( ! $is_apache ) {
			//nothing to do here
		} else {
			if ( ! $this->verify_nonce( 'apply_htaccess_upload' ) ) {
				return;
			}
			$type = WD_Utils::http_post( 'type' );

			if ( $type == 'protect' ) {
				$this->protect();
			} elseif ( $type == 'revert' ) {
				$this->revert();
			}
		}
	}

	public function revert() {
		if ( $this->check_rule_by_request( self::PREVENT_PHP_ACCESS, 'wp-includes' ) ) {
			$htacces_path = ABSPATH . WPINC . '/.htaccess';
			if ( file_exists( $htacces_path ) ) {
				$this->_revert( $htacces_path, 'wp-includes' );
			}
		}

		if ( $this->check_rule_by_request( self::PREVENT_PHP_ACCESS, 'wp-content' ) ) {
			$htacces_path = WP_CONTENT_DIR . '/.htaccess';
			if ( file_exists( $htacces_path ) ) {
				$this->_revert( $htacces_path, 'wp-content' );
			}
		}

		if ( $this->check_rule_by_request( self::PREVENT_PHP_ACCESS, 'uploads' ) ) {
			$uploads_dir = wp_upload_dir();

			$htacces_path = $uploads_dir['basedir'] . '/.htaccess';
			if ( file_exists( $htacces_path ) ) {
				$this->_revert( $htacces_path, 'uploads' );
			}
		}
		if ( $this->is_ajax() && ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
			wp_send_json( array(
				'status'  => 1,
				'revert'  => 1,
				'element' => $this->apache_output()
			) );
		}
	}

	private function _revert( $htaccess_path, $context ) {
		$content = file( $htaccess_path );
		if ( ( $indexer = $this->check_rule( $content, self::PREVENT_PHP_ACCESS ) ) !== false ) {
			//need to get the rule block, and unset it
			list( $first, $last ) = $indexer;

			if ( $first == $last ) {
				$content[ $first ] = '';
			} else {
				for ( $i = $first; $i <= $last; $i ++ ) {
					$content[ $i ] = '';
				}
			}
			//write back
			$content = array_map( 'trim', $content );
			$content = array_filter( $content );
			$content = implode( PHP_EOL, $content );
			$content = str_replace( array(
				'## WP Defender - Prevent information disclosure ##',
				'## WP Defender - End ##'
			), '', $content );
			if ( file_put_contents( $htaccess_path, $content, LOCK_EX ) ) {
				return true;
			} else {
				$this->output_error( 'write_permission', sprintf( esc_html__( "Can't write to the file %s", wp_defender()->domain ), $htaccess_path ) );
			}
		}
	}

	protected function protect() {
		if ( ! $this->check_rule_by_request( self::PREVENT_PHP_ACCESS, 'wp-includes' ) ) {
			$htacces_path = ABSPATH . WPINC . '/.htaccess';
			$will_add     = array(
				'## WP Defender - Prevent PHP Execution ##',
				$this->create_rule( self::PREVENT_PHP_ACCESS ),
				$this->create_rule( self::WPINCLUDE_EXCLUDE ),
				'## WP Defender - End ##'
			);
			$will_add     = implode( PHP_EOL, $will_add );
			$will_add     = preg_replace( "/\n+/", "\n", $will_add );
			if ( ! file_put_contents( $htacces_path, PHP_EOL . $will_add, FILE_APPEND | LOCK_EX ) ) {
				$this->output_error( 'write_permission', sprintf( esc_html__( "Can't write to the file %s", wp_defender()->domain ), $htacces_path ) );
			}
		}

		if ( ! $this->check_rule_by_request( self::PREVENT_PHP_ACCESS, 'wp-content' ) ) {
			$htacces_path = WP_CONTENT_DIR . '/.htaccess';
			$will_add     = array(
				'## WP Defender - Prevent PHP Execution ##',
				$this->create_rule( self::PREVENT_PHP_ACCESS ),
				'## WP Defender - End ##'
			);
			$will_add     = implode( PHP_EOL, $will_add );
			$will_add     = preg_replace( "/\n+/", "\n", $will_add );
			if ( ! file_put_contents( $htacces_path, PHP_EOL . $will_add, FILE_APPEND | LOCK_EX ) ) {
				$this->output_error( 'write_permission', sprintf( esc_html__( "Can't write to the file %s", wp_defender()->domain ), $htacces_path ) );
			}
		}

		if ( ! $this->check_rule_by_request( self::PREVENT_PHP_ACCESS, 'uploads' ) ) {
			$uploads_dir = wp_upload_dir();

			$htacces_path = $uploads_dir['basedir'] . '/.htaccess';

			$will_add = array(
				'## WP Defender - Prevent PHP Execution ##',
				$this->create_rule( self::PREVENT_PHP_ACCESS ),
				'## WP Defender - End ##'
			);
			$will_add = implode( PHP_EOL, $will_add );
			$will_add = preg_replace( "/\n+/", "\n", $will_add );
			if ( ! file_put_contents( $htacces_path, PHP_EOL . $will_add, FILE_APPEND | LOCK_EX ) ) {
				$this->output_error( 'write_permission', sprintf( esc_html__( "Can't write to the file %s", wp_defender()->domain ), $htacces_path ) );
			}
		}
		//if come here, means everythng ok
		wp_send_json( array(
			'status'  => 1,
			'element' => $this->apache_output(),
			'done'    => $this->check(),
		) );
	}

	public function print_scripts() {
		?>
		<script type="text/javascript">
			jQuery(function ($) {
				$('body').on('submit', '#protect_upload_dir_frm', function () {
					var that = $(this);
					var parent = $(this).closest('.wd-hardener-rule');
					var data = that.serialize();
					var clicked = that.find("input[type=submit]");

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
								$('#protect_upload_dir .wd-error').html(data.error).removeClass('wd-hide');
							} else {
								$('#protect_upload_dir .wd-error').html('').addClass('wd-hide');
								if (data.element != undefined) {
									clicked.closest('.wd-well').replaceWith(data.element);
								}
								if (data.done == 1) {
									parent.hide(500, function () {
										var div = parent.detach();
										div.prependTo($('.wd-hardener-success'));
										div.find('.rule-title').removeClass('issue').addClass('fixed').find('button').hide();
										div.find('i.dashicons-flag').replaceWith($('<i class="wdv-icon wdv-icon-fw wdv-icon-ok"/>'));
										div.find('.form-ignore').addClass('wd-hide');
										div.show(500, function () {
											/*$('html, body').animate({
											 scrollTop: div.find('.rule-title').offset().top
											 }, 1000);*/
										});
										$('body').trigger('after_an_issue_resolved', -1);
									})
								}

								if (data.revert == 1) {
									parent.hide(500, function () {
										$('.hardener-error-container').removeClass('wd-hide');
										var div = parent.detach();
										//find the position
										var titles = $('.hardener-error-container .rule-title');
										if (titles.size() > 0) {
											titles = $.makeArray(titles);
											titles.reverse();
											var current_title = div.find('.rule-title').text();
											var append = false;
											$.each(titles, function (i, v) {
												var text = $(this).text().toUpperCase();
												//if the current letter is order up the current, add bellow that
												if (current_title.toUpperCase().localeCompare(text) == true) {
													div.insertAfter($(this).closest('.wd-hardener-rule'));
													append = true;
													return false;
												}
											})
											if (append == false) {
												div.prependTo($('.wd-hardener-error'));
											}
										} else {
											div.appendTo($('.wd-hardener-error'));
										}
										div.find('.rule-title').removeClass('fixed').addClass('issue').find('button').show();
										div.find('i.wdv-icon-ok').replaceWith($('<i class="dashicons dashicons-flag"/>'));
										div.find('.form-ignore').addClass('wd-hide');
										div.show(500, function () {
											/*$('html, body').animate({
											 scrollTop: div.find('.rule-title').offset().top
											 }, 1000);*/
										});
										$('body').trigger('after_an_issue_resolved', 1);
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
				<h4 class="tl"><?php esc_html_e( "OVERVIEW", wp_defender()->domain ) ?></h4>

				<p><?php esc_html_e( "By default, a plugin/theme vulnerability could allow a PHP file to get uploaded into your site's directories and in turn execute harmful scripts that can wreak havoc on your website. Prevent this altogether by disabling direct PHP execution in directories that don't require it.", wp_defender()->domain ) ?></p>

				<h4 class="tl"><?php esc_html_e( "How To Fix", wp_defender()->domain ) ?></h4>

				<div class="wd-error wd-hide">

				</div>
				<?php
				$url    = site_url( 'index.php' );
				$server = WD_Utils::determine_server( $url );
				switch ( $server ) {
					case 'nginx':
						echo $this->nginx_output();
						break;
					case 'apache':
						echo $this->apache_output();
						break;
					default:
						printf( __( "Your website currently run on %s, which has not yet supported. Please contact our <a target='_blank' href=\"%s\">support for more information</a>", wp_defender()->domain ), $server, 'https://premium.wpmudev.org/forums/forum/support#question' );
						break;
				}
				?>
				<?php echo $this->ignore_button() ?>
			</div>
		</div>
		<?php
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
			<p><?php esc_html_e( "For NGINX servers:", wp_defender()->domain ) ?></p>
			<ol>
				<li>
					<?php esc_html_e( "Copy the generated code into your site specific .conf file usually located in a subdirectory under /etc/nginx/... or /usr/local/nginx/conf/...", wp_defender()->domain ) ?>
				</li>
				<li>
					<?php _e( "Add the code above inside the <strong>server</strong> section in the file, right before the php location block. Looks something like:", wp_defender()->domain ) ?>
					<pre>location ~ \.php$ {</pre>
				</li>
				<li>
					<?php esc_html_e( "Reload NGINX.", wp_defender()->domain ) ?>
				</li>
			</ol>
			<p><?php sprintf( __( "Still having trouble? <a target='_blank' href=\"%s\">Open a support ticket</a>.", wp_defender()->domain ), 'https://premium.wpmudev.org/forums/forum/support#question' ) ?></p>
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
		ob_start();
		?>
		<div class="wd-well">
			<?php if ( $this->check() ): ?>
				<p>
					<?php esc_html_e( "PHP execution is locked down.", wp_defender()->domain ) ?>
				</p>
			<?php else: ?>
				<p>
					<?php esc_html_e( "We will place .htaccess files into each of these directories to prevent PHP execution.", wp_defender()->domain ) ?>
				</p>
			<?php endif; ?>
			<form id="protect_upload_dir_frm" method="post">
				<?php $this->generate_nonce_field( 'apply_htaccess_upload' ) ?>
				<input type="hidden" name="action"
				       value="<?php echo $this->generate_ajax_action( 'apply_htaccess_upload' ) ?>">
				<?php if ( $this->check() ): ?>
					<input type="hidden" name="type" value="revert">
					<input type="submit" class="button button-grey"
					       value="<?php esc_attr_e( "Revert", wp_defender()->domain ) ?>">
				<?php else: ?>
					<input type="hidden" name="type" value="protect">
					<input type="submit" class="button wd-button"
					       value="<?php esc_attr_e( "Add .htaccess file", wp_defender()->domain ) ?>">
				<?php endif; ?>
			</form>
		</div>
		<?php
		return ob_get_clean();
	}
}