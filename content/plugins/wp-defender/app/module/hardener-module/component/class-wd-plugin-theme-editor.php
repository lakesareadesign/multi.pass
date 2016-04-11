<?php
/**
 * Class: WD_Plugin_Theme_Editor
 */

/**
 * @author: Hoang Ngo
 */
class WD_Plugin_Theme_Editor extends WD_Hardener_Abstract {
	public function on_creation() {
		$this->id         = 'plugin_theme_editor';
		$this->title      = __( "Disable the file editor", wp_defender()->domain );
		$this->can_revert = true;

		$this->add_action( 'admin_footer', 'print_scripts' );
		$this->add_ajax_action( $this->generate_ajax_action( 'disable_editor' ), 'process' );
		$this->add_ajax_action( $this->generate_ajax_action( 'revert_disable_editor' ), 'revert' );
	}

	/**
	 * @param null $path
	 *
	 * @return bool
	 */
	public function check( $path = null ) {
		if ( is_null( $path ) ) {
			if ( defined( 'DISALLOW_FILE_EDIT' ) && constant( 'DISALLOW_FILE_EDIT' ) == true ) {
				return true;
			}
		} else {
			$check = $this->is_file_edit_off( $path );
			if ( is_array( $check ) && $check[0] == true ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Check the wp-config.php file, to see if the DISALLOW_FILE_EDIT turn on or off, or haven't add
	 *
	 * @param $path
	 *
	 * @return bool|int|string
	 * @access private
	 * @since 1.0
	 */
	private function is_file_edit_off( $path ) {
		$config  = file( $path );
		$pattern = "/^define\(\s*(\'|\")DISALLOW_FILE_EDIT(\'|\"),\s*.*\s*\)/";
		foreach ( $config as $key => $line ) {
			$line = trim( $line );
			if ( preg_match( $pattern, $line ) ) {
				if ( preg_match( "/^define\(\s*(\'|\")DISALLOW_FILE_EDIT(\'|\"),\s*true\s*\)/", $line ) ) {
					//disabled
					return array( true, $key );
				} else {
					//return the position
					return $key;
				}
			}
		}

		//no key here, return -1
		return - 1;
	}

	public function print_scripts() {
		?>
		<script type="text/javascript">
			jQuery(function ($) {
				$('body').on('submit', '#plugin_theme_editor_frm', function () {
					var that = $(this);
					var parent = $(this).closest('.wd-hardener-rule');
					$.ajax({
						type: 'POST',
						url: ajaxurl,
						data: that.serialize(),
						beforeSend: function () {
							that.find('button').attr('disabled', 'disabled');
							that.find('button').css({
								'cursor': 'progress'
							});
						},
						success: function (data) {
							that.find('button').removeAttr('disabled');
							that.find('button').css({
								'cursor': 'pointer'
							});

							if (data.status == 0) {
								$('#plugin_theme_editor .wd-error').html(data.error).removeClass('wd-hide');
							} else {
								that.closest('div').html(data.message);
								if (data.revert == 1) {
									parent.hide(500, function () {
										var div = parent.detach();
										$('.hardener-error-container').removeClass('wd-hide');
										var titles = $('.hardener-error-container .rule-title');
										if (titles.size() > 0) {
											titles = $.makeArray(titles);
											titles.reverse();
											var current_title = div.find('.rule-title').text();
											var found = false;
											$.each(titles, function (i, v) {
												var text = $(this).text().toUpperCase();
												//if the current letter is order up the current, add bellow that
												if (current_title.toUpperCase().localeCompare(text) == true) {
													div.insertAfter($(this).closest('.wd-hardener-rule'));
													found = true;
													return false;
												}
											})
											if (found == false) {
												//append it
												div.prependTo($('.wd-hardener-error'));
											}
										} else {
											div.appendTo($('.wd-hardener-error'));
										}
										div.find('.rule-title').removeClass('fixed').addClass('issue').find('button').show();
										div.find('i.wdv-icon-ok').replaceWith($('<i class="dashicons dashicons-flag"/>'));
										div.find('.form-ignore').removeClass('wd-hide');
										div.show(500, function () {
											$('html, body').animate({
												scrollTop: div.find('.rule-title').offset().top
											}, 1000);
										});
									})
								}
								if (data.done == 1) {
									$('#plugin_theme_editor .wd-error').html('').addClass('wd-hide');
									parent.hide(500, function () {
										var div = parent.detach();
										div.prependTo($('.wd-hardener-success'));
										//find the position
										div.find('.rule-title').removeClass('issue').addClass('fixed').find('button').hide();
										div.find('i.dashicons-flag').replaceWith($('<i class="wdv-icon wdv-icon-fw wdv-icon-ok"/>'));
										div.find('.form-ignore').addClass('wd-hide');
										div.show(500);
									})
								}
							}
						}
					})
					return false;
				})
			})
		</script>
		<?php
	}

	public function process() {
		if ( ! WD_Utils::check_permission() ) {
			return;
		}

		if ( ! $this->verify_nonce( 'disable_editor' ) ) {
			return;
		}

		$path = WD_Utils::retrieve_wp_config_path();

		$this->write_to_config( $path );
		if ( $this->is_ajax() ) {
			$this->after_processed();
			wp_send_json( array(
				'status'  => 1,
				'done'    => 1,
				'message' => $this->_display()
			) );
		}
	}

	/**
	 * @param null $path
	 *
	 * @return bool
	 */
	public function write_to_config( $path = null ) {
		if ( is_null( $path ) ) {
			$path = WD_Utils::retrieve_wp_config_path();
		}

		if ( ! is_writeable( $path ) ) {
			$this->output_error( 'cant_write', __( "Your wp-config.php isn't writable", wp_defender()->domain ) );
		}

		$config    = file( $path );
		$hook_line = $this->is_file_edit_off( $path );
		if ( defined( 'DISALLOW_FILE_EDIT' ) && constant( 'DISALLOW_FILE_EDIT' ) == true ) {
			//means true
			if ( is_array( $hook_line ) && $hook_line[0] === true ) {
				unset( $config[ $hook_line[1] ] );
			} else {
				//hmm, key defined, but we cant find in wp-config.php, so it must be somewhere
				$this->output_error( 'cant_revert', __( "You already have ​*DISALLOW_FILE_EDIT*​ defined as true somewhere other than your `wp-config.php` file which means the file editor can’t be disabled. Please find and remove this line of code manually and try this fix again.", wp_defender()->domain ) );
			}
		} elseif ( defined( 'DISALLOW_FILE_EDIT' ) && constant( 'DISALLOW_FILE_EDIT' ) == false ) {
			//keys somewhere but false
			if ( $hook_line == - 1 ) {
				//hmm, key defined, but we cant find in wp-config.php, so it must be somewhere
				$this->output_error( 'cant_revert', __( "You already have ​*DISALLOW_FILE_EDIT*​ defined as true somewhere other than your `wp-config.php` file which means the file editor can’t be disabled. Please find and remove this line of code manually and try this fix again.", wp_defender()->domain ) );
			} else {
				$line                 = "define( 'DISALLOW_FILE_EDIT', true );" . PHP_EOL;
				$config[ $hook_line ] = $line;
			}
		} elseif ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
			//hasn't defined
			global $wpdb;
			$pattern = '/^\$table_prefix\s*=\s*(\'|\")' . preg_quote( $wpdb->prefix ) . '(\'|\")/';
			foreach ( $config as $key => $line ) {
				$line = trim( $line );
				if ( preg_match( $pattern, $line ) ) {
					$hook_line = $key;
					break;
				}
			}
			$line = "define( 'DISALLOW_FILE_EDIT', true );" . PHP_EOL;
			array_splice( $config, $hook_line + 1, 0, array( $line ) );
		}

		file_put_contents( $path, implode( '', $config ), LOCK_EX );

		return true;
	}

	public function display() {
		?>
		<div class="wd-hardener-rule">
			<?php echo $this->get_rule_title(); ?>
			<div class="wd-clearfix"></div>

			<div id="<?php echo $this->id ?>" class="wd-rule-content">
				<h4 class="tl"><?php _e( "Overview", wp_defender()->domain ) ?></h4>

				<p><?php _e( "WordPress comes with a file editor built into the system. This means that anyone with access to your login information can edit your plugin and theme files. We recommend disabling the editor.", wp_defender()->domain ) ?></p>

				<h4 class="tl"><?php _e( "How To Fix", wp_defender()->domain ) ?></h4>

				<div class="wd-error wd-hide">

				</div>
				<div class="wd-well">
					<?php echo $this->_display(); ?>
				</div>
				<?php echo $this->ignore_button() ?>
			</div>
		</div>
		<?php
	}

	private function _display() {
		ob_start();
		if ( $this->is_ajax() ) {
			$config_path = WD_Utils::retrieve_wp_config_path();
		} else {
			$config_path = null;
		}
		?>
		<?php if ( $this->check( $config_path ) ): ?>
			<p>
				<?php _e( "The file editor is disabled.", wp_defender()->domain ) ?>
			</p>
			<form id="plugin_theme_editor_frm" method="post">
				<?php $this->generate_nonce_field( 'disable_editor' ) ?>
				<input type="hidden" name="action"
				       value="<?php echo $this->generate_ajax_action( 'revert_disable_editor' ) ?>">
				<button type="submit"
				        class="button button-grey"><?php _e( "Revert", wp_defender()->domain ) ?></button>
			</form>
		<?php else: ?>
			<p>
				<?php _e( "We will disable access to the file editor for you. You can enable it again anytime.", wp_defender()->domain ) ?>
			</p>
			<form id="plugin_theme_editor_frm" method="post">
				<?php $this->generate_nonce_field( 'disable_editor' ) ?>
				<input type="hidden" name="action"
				       value="<?php echo $this->generate_ajax_action( 'disable_editor' ) ?>">
				<button type="submit"
				        class="button wd-button"><?php _e( "Disable File Editor", wp_defender()->domain ) ?></button>
			</form>
		<?php endif; ?>
		<?php
		return ob_get_clean();
	}

	public function revert() {
		if ( ! WD_Utils::check_permission() ) {
			return;
		}

		if ( ! $this->verify_nonce( 'disable_editor' ) ) {
			return;
		}

		$path = WD_Utils::retrieve_wp_config_path();

		$this->write_to_config( $path );
		if ( $this->is_ajax() ) {
			$this->after_processed();
			wp_send_json( array(
				'status'  => 1,
				'revert'  => 1,
				'message' => $this->_display()
			) );
		}
	}
}