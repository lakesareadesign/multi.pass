<?php
/**
 * Class: WD_Security_Key
 */

/**
 * @author: Hoang Ngo
 */
class WD_Security_Key extends WD_Hardener_Abstract {
	public $days_check;

	public function on_creation() {
		$this->id         = 'wd_security_key';
		$this->title      = __( 'Update old security keys', wp_defender()->domain );
		$this->can_revert = false;
		$this->days_check = apply_filters( 'wd/security_key_days_check', 30 );

		$this->add_action( 'admin_footer', 'print_scripts' );
		$this->add_action( 'wd_hardener_layout_end', 'show_dialog' );
		$this->add_ajax_action( $this->generate_ajax_action( 'generate' ), 'process' );
	}

	/**
	 * Check to see if the keys need to generated
	 *
	 * @return bool|float
	 * @access public
	 * @since 1.0
	 */
	public function check() {
		$last_gen = WD_Utils::get_setting( $this->get_setting_key( 'last_update' ), false );

		if ( $last_gen == false ) {
			return false;
		}
		//now check, if this is in day
		if ( strtotime( '+ ' . $this->days_check . ' days', $last_gen ) <= time() ) {
			//its the time to regen
			return false;
		}

		return true;
	}

	/**
	 * Convert the timestamp to days
	 * @return float
	 *
	 * @access public
	 * @since 1.0
	 */
	public function days_ago() {
		$last_gen = WD_Utils::get_setting( $this->get_setting_key( 'last_update' ), false );
		//return the days ago
		$days_ago = ( time() - $last_gen ) / ( 60 * 60 * 24 );

		return $days_ago;
	}

	/**
	 * @return bool|void
	 */
	public function process() {
		if ( ! WD_Utils::check_permission()  ) {
			return;
		}

		if ( ! $this->verify_nonce( 'generate' ) ) {
			return;
		}

		if ( ! is_writable( WD_Utils::retrieve_wp_config_path() ) ) {
			wp_send_json( array(
				'status' => 0,
				'error'  => __( "Your wp-config.php isn't writable", wp_defender()->domain )
			) );
		}

		if ( $this->generate_salt() === true ) {
			if ( $this->is_ajax() ) {
				$this->after_processed();

				$url = is_multisite() ? network_admin_url( 'admin.php?page=wdf-hardener' ) : admin_url( "admin.php?page=wdf-hardener" );
				wp_send_json( array(
					'status'  => 1,
					'message' => '<div class="wp-defender">' . sprintf( __( 'All key salts have been regenerated. You will now need to <a href="%s"><strong>re-login</strong></a>.<br/>This will auto reload after 3 seconds.', wp_defender()->domain ), $url ) . '</div>'
				) );
			} else {
				return true;
			}
		}

		return false;
	}

	/**
	 * This function will check & generate new salt if needed
	 * Cover case
	 * All salt provided in wp-config
	 * No salt in wp-config
	 * Partial salt (missing some) in wp-config
	 *
	 * @param null $path
	 *
	 * @return bool
	 */
	public function generate_salt( $path = null ) {
		$const = array(
			'AUTH_KEY',
			'SECURE_AUTH_KEY',
			'LOGGED_IN_KEY',
			'NONCE_KEY',
			'AUTH_SALT',
			'SECURE_AUTH_SALT',
			'LOGGED_IN_SALT',
			'NONCE_SALT',
		);

		//get wp-config data as an array
		if ( $path == null || ! file_exists( $path ) ) {
			$path = WD_Utils::retrieve_wp_config_path();
		}
		$this->log( 'start to generate security keys' );
		$config = file( $path );
		//we need a place where we can inject the define in case wp config missing
		$hook_line = false;
		$missing   = array();
		foreach ( $const as $key ) {
			//generate salt
			$salt = wp_generate_password( 64, true, true );
			//replace it to the wp config
			if ( defined( $key ) ) {
				$old_salt = constant( $key );
				//replace
				foreach ( $config as $index => $line ) {
					$line = trim( $line );

					$pattern = '/^define\(\s*(\'|\")' . $key . '(\'|\")\s*,\s*(\'|\")' . preg_quote( $old_salt, '/' ) . '(\'|\")\s*\)/';

					if ( preg_match( $pattern, $line ) === 1 ) {
						//match
						$new_line         = "define( '$key', '$salt' );" . PHP_EOL;
						$config[ $index ] = $new_line;
						if ( $hook_line === false ) {
							$hook_line = $index;
						}
						$this->log( sprintf( 'key "%s" replace "%s" by "%s"', $key, $old_salt, $salt ) );
						//break out of the config line loop
						break;
					}
				}
			} else {
				//we don't have any key like this, so we will inject
				$missing[] = $key;
			}
		}
		//now check the missing
		if ( count( $missing ) ) {
			if ( $hook_line !== false ) {
				//we have a place to inject
				foreach ( $missing as $key ) {
					$salt     = wp_generate_password( 64, true, true );
					$new_line = "define( '$key', '$salt' );" . PHP_EOL;
					array_splice( $config, $hook_line, 0, array( $new_line ) );
					$this->log( sprintf( 'key "%s" is missing, created with "%s"', $key, $salt ) );
				}
			} else {
				//this is the case we missing all line(rare), we will trying to hook into the prefix line
				global $wpdb;
				$pattern = '/^(\$table_prefix\s*=\s*)([\'""])' . $wpdb->base_prefix . '([\'""])/';
				foreach ( $config as $index => $line ) {
					$line = trim( $line );
					if ( preg_match( $pattern, $line ) === 1 ) {
						foreach ( $missing as $key ) {
							$salt     = wp_generate_password( 64, true, true );
							$new_line = "define( '$key', '$salt' );" . PHP_EOL;
							array_splice( $config, $index, 0, array( $new_line ) );
							$this->log( sprintf( 'key "%s" is missing, created with "%s"', $key, $salt ) );
						}
						break;
					}
				}
			}
		}

		//todo backup hashing
		//we already check for perm above, no need to check again
		//lock the file
		file_put_contents( $path, implode( '', $config ), LOCK_EX );
		WD_Utils::update_setting( $this->get_setting_key( 'last_update' ), time() );

		return true;
	}

	public function show_dialog() {
		?>
		<a href="#<?php echo $this->id ?>_dialog" rel="dialog" class="wd_security_key_dialog_trigger"></a>
		<dialog id="<?php echo $this->id ?>_dialog" class="no-close"
		        title="<?php esc_attr_e( "Action Required", wp_defender()->domain ) ?>">

		</dialog>
		<?php
	}

	public function print_scripts() {
		?>
		<script type="text/javascript">
			jQuery(function ($) {
				$('#wd_security_key_form').submit(function () {
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
								$('#wd_security_key_form .wd-error').html(data.error).removeClass('wd-hide');
							} else {
								$('#wd_security_key_form .wd-error').html('').addClass('wd-hide');
								$('#wd_security_key_dialog').html(data.message);
								$('.wd_security_key_dialog_trigger').trigger('click');
								setTimeout(function () {
									location.reload();
								}, 3000)
							}
						}
					})
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

				<p><?php _e( "We recommend changing your security keys every 60 days and it looks like yours are currently older than this! Simply regenerate them to prevent unwanted snooping.", wp_defender()->domain ) ?></p>

				<h4 class="tl"><?php _e( "How To Fix", wp_defender()->domain ) ?></h4>

				<div class="wd-well">
					<?php if ( ( $this->check() ) === false ): ?>
						<p><?php _e( "We can regenerate your key salts instantly for you and they will be good for another 60 days. Note that this will log all users out of your site.", wp_defender()->domain ) ?></p>
						<form method="post" id="wd_security_key_form">
							<input type="hidden" name="action"
							       value="<?php echo $this->generate_ajax_action( 'generate' ) ?>">
							<?php echo $this->generate_nonce_field( 'generate' ) ?>
							<button class="button wd-button" type="submit">
								<?php _e( "Regenerate Security Keys", wp_defender()->domain ) ?>
							</button>
						</form>
					<?php else: ?>
						<?php printf( __( "Your salt keys are %d days old. You are fine for now.", wp_defender()->domain ), floor( $this->days_ago() ) ) ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
	}

	public function revert() {

	}
}