<?php

/**
 * Class: WD_Protect_Core_Dir
 */
class WD_Protect_Core_Dir extends WD_Hardener_Abstract {
	const BROWSER_LISTING = 'browser_listing', PROTECT_HTACCESS = 'protect_htaccess',
		PREVENT_PHP_ACCESS = 'prevent_php_access', WPINCLUDE_EXCLUDE = 'exclude_file',
		PROTECT_ENUM = 'protect_enum';

	protected $check_urls = array();

	public function on_creation() {
		$this->id         = 'protect_core_dir';
		$this->title      = __( 'Prevent Information Disclosure', wp_defender()->domain );
		$this->can_revert = true;
		$this->init_check_rules();

		$this->add_action( 'admin_footer', 'print_scripts' );
		$this->add_ajax_action( $this->generate_ajax_action( 'apply_htaccess' ), 'process' );
	}

	protected function init_check_rules() {
		$this->check_urls = array(
			//options index
			'wp-includes' => array(
				self::BROWSER_LISTING    => includes_url(),
				self::PROTECT_HTACCESS   => includes_url( '.htaccess' ),
				self::PREVENT_PHP_ACCESS => includes_url( 'wp-db.php' ),
			),
			'wp-content'  => array(
				self::BROWSER_LISTING    => content_url(),
				self::PROTECT_HTACCESS   => content_url( '.htaccess' ),
				self::PREVENT_PHP_ACCESS => content_url( 'index.php' ),
				self::PROTECT_ENUM       => wp_defender()->get_plugin_url() . 'vault/sample.bak'
			),
			'uploads'     => array(
				self::BROWSER_LISTING    => content_url(),
				self::PROTECT_HTACCESS   => content_url( 'uploads/.htaccess' ),
				self::PREVENT_PHP_ACCESS => content_url( 'uploads/defender-access-test.php' ),
				self::PROTECT_ENUM       => wp_defender()->get_plugin_url() . 'vault/sample.bak'
			)
		);
	}

	public function check( $force = false ) {
		//get from cache maybe
		if ( isset( $this->check_cache ) && ! $force ) {
			return $this->check_cache;
		}

		if ( is_wp_error( $this->init_test_env() ) ) {
			$this->check_cache = false;

			return $this->check_cache;
		}

		if ( ! $this->check_rule_by_request( self::BROWSER_LISTING, 'wp-includes' ) ) {
			$this->check_cache = false;

			return $this->check_cache;
		}

		$context = array_rand( $this->check_urls );
		if ( ! $this->check_rule_by_request( self::PROTECT_HTACCESS, $context ) ) {
			$this->check_cache = false;

			return $this->check_cache;
		}
		if ( ! $this->check_rule_by_request( self::PROTECT_ENUM, 'wp-content' ) ) {
			$this->check_cache = false;

			return $this->check_cache;
		}

		$this->check_cache = true;

		return $this->check_cache;
	}

	protected function init_test_env() {
		global $is_apache;
		if ( $is_apache ) {
			//init htaccess
			$include_path = ABSPATH . WPINC . '/';
			if ( ! file_exists( $include_path . '.htaccess' ) ) {
				if ( ! @file_put_contents( $include_path . '.htaccess', '', LOCK_EX ) ) {
					return new WP_Error( 'cant_write', sprintf( __( "Can't write to the file %s", wp_defender()->domain ), $include_path . '.htaccess' ) );
				}
			}

			$content_path = WP_CONTENT_DIR . '/';
			if ( ! file_exists( $content_path . '.htaccess' ) ) {
				if ( ! @file_put_contents( $content_path . '.htaccess', '', LOCK_EX ) ) {
					return new WP_Error( 'cant_write', sprintf( __( "Can't write to the file %s", wp_defender()->domain ), $content_path . '.htaccess' ) );
				}
			}
		}

		$upload_dirs  = wp_upload_dir();
		$defender_dir = $upload_dirs['basedir'];

		if ( ! file_exists( $defender_dir . '/defender-access-test.php' ) ) {
			@file_put_contents( $defender_dir . '/defender-access-test.php', '', LOCK_EX );
		}

		return true;
	}

	public function process() {
		if ( ! WD_Utils::check_permission() ) {
			return;
		}

		global $is_apache;
		if ( ! $is_apache ) {
			//do nothing, we will display manual way
		} else {
			if ( ! $this->verify_nonce( 'apply_htaccess' ) ) {
				return;
			}

			$type = WD_Utils::http_post( 'type' );
			if ( $type == 'protect' ) {
				$this->protect();
			} elseif ( $type == 'revert' ) {
				$this->revert();
			}

		}

		return;
	}


	/**
	 * removing all the text added from htaccess file
	 */
	public function revert( $htaccess_path = null, $silent = false ) {
		if ( is_null( $htaccess_path ) ) {
			$htaccess_path = ABSPATH . '.htaccess';
		}
		$content = file( $htaccess_path );

		$class  = new ReflectionClass( __CLASS__ );
		$consts = $class->getConstants();
		foreach ( $consts as $const ) {
			if ( $const == self::WPINCLUDE_EXCLUDE || $const == self::PREVENT_PHP_ACCESS ) {
				continue;
			}

			$rule = $this->get_rules( $const );
			if ( ! empty( $rule ) ) {
				if ( ( $indexer = $this->check_rule( $content, $const ) ) !== false ) {
					//need to get the rule block, and unset it
					list( $first, $last ) = $indexer;

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
		//removig the comment
		$content = array_map( 'trim', $content );
		$content = array_filter( $content );
		$content = implode( PHP_EOL, $content );
		$content = str_replace( array(
			'## WP Defender - Prevent information disclosure ##',
			'## WP Defender - End ##'
		), '', $content );

		if ( $this->is_ajax() && $silent == false ) {
			if ( @file_put_contents( $htaccess_path, $content, LOCK_EX ) ) {
				wp_send_json( array(
					'status'  => 1,
					'revert'  => 1,
					'element' => $this->apache_output()
				) );
			} else {
				$this->output_error( 'write_permission', sprintf( __( "Can't write to the file %s", wp_defender()->domain ), $htaccess_path ) );
			}
		} else {
			if ( @file_put_contents( $htaccess_path, $content, LOCK_EX ) ) {
				return true;
			} else {
				return new WP_Error( 'write_permission', sprintf( __( "Can't write to the file %s", wp_defender()->domain ), $htaccess_path ) );
			}
		}
	}

	protected function protect() {
		//we will write to root htaccess
		$htacces_path = ABSPATH . '.htaccess';
		if ( ! file_exists( $htacces_path ) ) {
			if ( ! file_put_contents( $htacces_path, '', LOCK_EX ) ) {
				$this->output_error( 'cant_write', sprintf( __( "Can't write to the file %s", wp_defender()->domain ), $htacces_path ) );
			}
		}

		$will_add = array();
		//check random, for here, we will check browser indexing, protect enum and protect htaccess if is apache
		if ( ! $this->check_rule_by_request( self::BROWSER_LISTING, 'wp-includes' ) ) {
			$will_add[] = $this->create_rule( self::BROWSER_LISTING );
		}
		//random again
		$context = array_rand( $this->check_urls );
		if ( ! $this->check_rule_by_request( self::PROTECT_HTACCESS, $context ) ) {
			$will_add[] = $this->create_rule( self::PROTECT_HTACCESS );
		}
		if ( ! $this->check_rule_by_request( self::PROTECT_ENUM, 'wp-content' ) ) {
			$will_add[] = $this->create_rule( self::PROTECT_ENUM );
		}

		if ( count( $will_add ) ) {
			$will_add   = array_merge( array( '## WP Defender - Prevent information disclosure ##' ), $will_add );
			$will_add[] = '## WP Defender - End ##';
			$will_add   = implode( PHP_EOL, $will_add );
			$will_add   = preg_replace( "/\n+/", "\n", $will_add );

			//we already test above, no need again
			if ( file_put_contents( $htacces_path, PHP_EOL . $will_add, FILE_APPEND | LOCK_EX ) ) {
				wp_send_json( array(
					'status'  => 1,
					'element' => $this->apache_output(),
					'done'    => $this->check(),
				) );
			} else {
				$this->output_error( 'write_permission', sprintf( __( "Can't write to the file %s", wp_defender()->domain ), $htacces_path ) );
			}
		} else {
			//cant be here
		}
	}

	/**
	 * @param $rule
	 * @param $context
	 *
	 * @return bool
	 */
	public function check_rule_by_request( $rule, $context ) {
		$check_urls = $this->check_urls;

		global $is_apache;
		if ( ! $is_apache && $rule == self::PROTECT_HTACCESS ) {
			return true;
		}

		$urls = isset( $check_urls[ $context ] ) ? $check_urls[ $context ] : array();
		$url  = isset( $urls[ $rule ] ) ? $urls[ $rule ] : false;
		if ( $url == false ) {
			return $url;
		}

		if ( $rule == self::BROWSER_LISTING ) {
			//this is a special case, as usually this will return 200, need to make sure content is blank
			$status = @wp_remote_get( $url );
			if ( 200 == wp_remote_retrieve_response_code( $status ) ) {
				$body = wp_remote_retrieve_body( $status );
				if ( strlen( $body ) == 0 ) {
					return true;
				}

				return false;
			} else {
				return true;
			}
		}

		$status = wp_remote_head( $url, array( 'user-agent' => $_SERVER['HTTP_USER_AGENT'] ) );
		if ( 200 == wp_remote_retrieve_response_code( $status ) ) {
			return false;
		}

		return true;
	}

	/**
	 * We will create htaccess rule
	 *
	 * @param $rule
	 *
	 * @return string
	 * @since 1.0
	 */
	public function create_rule( $rule ) {
		return implode( PHP_EOL, $this->get_rules( $rule ) );
	}

	/**
	 * This function check the rule given to current htaccess content, and see if the rules applied.
	 *
	 * @param $content
	 * @param $rule
	 *
	 * @return bool
	 * @since 1.0
	 */
	//todo update to regex
	public function check_rule( $content, $rule ) {
		$rules      = self::get_rules( $rule );
		$true_count = 0;
		$ret        = false;
		$first      = 0;
		$end        = 0;

		foreach ( $content as $key => $line ) {
			$line = trim( $line );

			if ( $true_count == 0 && stristr( $line, $rules[ $true_count ] ) !== false ) {
				//we catch the first line for the rule
				$true_count += 1;
				$first = $key;
				//some rule only have one line, need to check
				if ( count( $rules ) == 1 ) {
					//this rule only have one line, jump out
					$ret = true;
					$end = $key;
					break;
				}
				//next line
				continue;
			}

			if ( $true_count > 0 && empty( $line ) ) {
				//we accept break line
				continue;
			}

			if ( $true_count > 0 && stristr( $line, $rules[ $true_count ] ) === false ) {
				//we need to reset the order
				$true_count = 0;
				continue;
			}

			if ( $true_count > 0 && stristr( $line, $rules[ $true_count ] ) !== false ) {
				//find the next line,
				//first need to check, if this is the last line of this rule
				$end = $key;
				if ( count( $rules ) - 1 == $true_count ) {
					//yeah, jump out
					$ret = true;
					break;
				}
				$true_count += 1;
				continue;
			}
		}


		if ( $ret == false ) {
			return false;
		} else {
			return array( $first, $end );
		}
	}

	/**
	 * Htaccess rules bank
	 * @todo add wp-config protection like in nginx
	 *
	 * @param $scenario
	 *
	 * @return array
	 */
	protected function get_rules( $scenario ) {
		switch ( $scenario ) {
			case self::BROWSER_LISTING:
				return array(
					'Options -Indexes'
				);
				break;
			case self::PROTECT_HTACCESS:
				return array(
					'<FilesMatch "^\.">',
					'Order allow,deny',
					'Deny from all',
					'</FilesMatch>',
				);
			case self::PROTECT_ENUM:
				return array(
					'<FilesMatch "\.(txt|md|exe|sh|bak|inc|pot|po|mo|log|sql)$">',
					'Order allow,deny',
					'Deny from all',
					'</FilesMatch>',
				);
			case self::PREVENT_PHP_ACCESS:
				return array(
					'<Files *.php>',
					'Order allow,deny',
					'Deny from all',
					'</Files>',
				);
			case self::WPINCLUDE_EXCLUDE:
				return array(
					'<Files wp-tinymce.php>',
					'Allow from all',
					'</Files>',
					'<Files ms-files.php>',
					'Allow from all',
					'</Files>'
				);
				break;
			default:
				return apply_filters( $this->id . '/htaccess_rules', array() );
		}
	}

	/**
	 * print javascripts for ajax form
	 */
	public function print_scripts() {
		?>
		<script type="text/javascript">
			jQuery(function ($) {
				$('body').on('submit', '#protect_core_dir_frm', function () {
					var that = $(this);
					var parent = $(this).closest('.wd-hardener-rule');
					var data = that.serialize();
					var clicked = parent.find('input[type="submit"]');
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
									clicked.closest('.wd-well').replaceWith(data.element);
								}
								if (data.done == 1) {
									parent.hide(500, function () {
										var div = parent.detach();
										div.prependTo($('.wd-hardener-success'));
										div.find('.rule-title').removeClass('issue').addClass('fixed').find('button').hide();
										div.find('i.dashicons-flag').replaceWith($('<i class="wdv-icon wdv-icon-fw wdv-icon-ok"/>'));
										div.find('.form-ignore').addClass('wd-hide');
										div.show(500);
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
											$.each(titles, function (i, v) {
												//if the current letter is order up the current, add bellow that
												var text = $(this).text().toUpperCase();
												//if the current letter is order up the current, add bellow that
												if (current_title.toUpperCase().localeCompare(text) == true) {
													div.insertAfter($(this).closest('.wd-hardener-rule'));
													return false;
												}
											})
										} else {
											div.appendTo($('.wd-hardener-error'));
										}
										div.find('.rule-title').removeClass('fixed').addClass('issue').find('button').show();
										div.find('i.wdv-icon-ok').replaceWith($('<i class="dashicons dashicons-flag"/>'));
										div.find('.form-ignore').removeClass('wd-hide');
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
				<h4 class="tl"><?php _e( "Overview", wp_defender()->domain ) ?></h4>

				<p><?php _e( "Often servers are incorrectly configured, and can allow an attacker to get access to sensitive information that can be used in attacks. WP Defender can help you prevent that disclosure.", wp_defender()->domain ) ?></p>

				<h4 class="tl"><?php _e( "How To Fix", wp_defender()->domain ) ?></h4>

				<div class="wd-error wd-hide">

				</div>
				<?php
				//this mostly static content, so we have to check a static
				$url    = wp_defender()->get_plugin_url() . 'assets/defender-icon.css';
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
		$wp_content = str_replace( $_SERVER['DOCUMENT_ROOT'], '', WP_CONTENT_DIR );

		$rules = "# Turn off directory indexing
autoindex off;

# Deny access to htaccess and other hidden files
location ~ /\. {
  deny  all;
}

# Deny access to wp-config.php file
location = /wp-config.php {
  deny all;
}

# Deny access to revealing or potentially dangerous files in the /wp-content/ directory (including sub-folders)
location ~* ^$wp_content/.*\.(txt|md|exe|sh|bak|inc|pot|po|mo|log|sql)$ {
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
			<p><?php sprintf( __( "Still having trouble? <a target='_blank' href=\"%s\">Open a support ticket</a>.", wp_defender()->domain ), 'https://premium.wpmudev.org/forums/forum/support#question' ) ?></p>
			<pre>
## WP Defender - Prevent information disclosure ##
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
					<?php _e( "Both directories are protected.", wp_defender()->domain ) ?>
				</p>
			<?php else: ?>
				<p>
					<?php _e( "We will place <strong>.htaccess</strong> files into each of these directories to lock down the files and folders inside.", wp_defender()->domain ) ?>
				</p>
			<?php endif; ?>
			<form id="protect_core_dir_frm" method="post">
				<?php $this->generate_nonce_field( 'apply_htaccess' ) ?>
				<input type="hidden" name="action"
				       value="<?php echo $this->generate_ajax_action( 'apply_htaccess' ) ?>">
				<?php if ( $this->check() ): ?>
					<input type="hidden" name="type" value="revert">
					<input type="submit" class="button button-grey"
					       name="revert"
					       value="<?php esc_attr_e( "Revert", wp_defender()->domain ) ?>">
				<?php else: ?>
					<input type="hidden" name="type" value="protect">
					<input type="submit" class="button wd-button" name="process"
					       value="<?php esc_attr_e( "Add .htaccess file", wp_defender()->domain ) ?>">
				<?php endif; ?>
			</form>
		</div>
		<?php
		return ob_get_clean();
	}
}