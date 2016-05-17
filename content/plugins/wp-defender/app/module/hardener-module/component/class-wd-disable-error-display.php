<?php
/**
 * Class: WD_Disable_Error_Display
 */

/**
 * @author: Hoang Ngo
 */
class WD_Disable_Error_Display extends WD_Hardener_Abstract {

	public function on_creation() {
		$this->id         = 'disable_error_display';
		$this->title      = __( "Hide error reporting", wp_defender()->domain );
		$this->can_revert = true;

		$this->add_action( 'admin_footer', 'print_scripts' );
		$this->add_ajax_action( $this->generate_ajax_action( 'disable_error_display' ), 'process' );
	}

	/**
	 * Check the WP_DEBUG is on or off, if on, we will need to check the WP_DEBUG_DISPLAY
	 *
	 * @param string $path
	 *
	 * @return bool
	 * @access public
	 * @since 1.0
	 */
	public function check( $path = null ) {
		//we can reuse wordpress function here.
		if ( is_null( $path ) ) {
			$path = WD_Utils::retrieve_wp_config_path();
		}
		$is_debug_on = $this->is_debug_on( $path );
		if ( $is_debug_on === false ) {
			return true;
		}

		$is_display_on = $this->is_display_on( $path );
		if ( $is_display_on === 0 ) {
			//debug is one, but the display defined & turn off
			return true;
		}

		//if till here, mean the display defined and on, or doesn't
		return false;
	}

	/**
	 * Will check to find if the wp debug turn on
	 *
	 * @param $path
	 *
	 * @return bool|int|string
	 * @access private
	 * @since 1.0
	 */
	private function is_debug_on( $path ) {
		$config  = file( $path );
		$pattern = "/^define\(\s*('|\")WP_DEBUG('|\"),\s*true\s*\)/";
		foreach ( $config as $key => $line ) {
			$line = trim( $line );
			if ( preg_match( $pattern, $line ) ) {
				return $key;
			}
		}

		return false;
	}

	/**
	 * Look for WP_DEBUG_DISPLAY
	 * return line number if found, 0 if found but disable, and -1 if not found
	 *
	 * @param $path
	 *
	 * @return int|string
	 */
	private function is_display_on( $path ) {
		$config  = file( $path );
		$pattern = "/^define\(\s*('|\")WP_DEBUG_DISPLAY('|\"),\s*.*\s*\)/";
		foreach ( $config as $key => $line ) {
			$line = trim( $line );
			if ( preg_match( $pattern, $line ) ) {
				//find a line having defined wp debug display, chekc if it is on
				if ( preg_match( "/^define\(\s*('|\")WP_DEBUG_DISPLAY('|\"),\s*true\s*\)/", $line ) ) {
					return $key;
				} else {
					return 0;
				}
			}
		}

		return - 1;
	}

	/**
	 * Print out the script for processing this rule
	 * @since 1.0
	 * @access public
	 */
	public function print_scripts() {
		?>
		<script type="text/javascript">
			jQuery(function ($) {
				$('#disable_error_display_frm').submit(function () {
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
								$('#disable_error_display .wd-error').html(data.error).removeClass('wd-hide');
							} else {
								$('#disable_error_display .wd-error').html('').addClass('wd-hide');
								that.closest('div').html(data.message);
								parent.hide(500, function () {
									var div = parent.detach();
									div.prependTo($('.wd-hardener-success'));
									div.find('.rule-title').removeClass('issue').addClass('fixed').find('button').hide();
									div.find('i.dashicons-flag').replaceWith($('<i class="wdv-icon wdv-icon-fw wdv-icon-ok"/>'));
									div.find('.form-ignore').addClass('wd-hide');
									div.show(500);
								})
							}
						}
					})
					return false;
				})
			})
		</script>
		<?php
	}

	/**
	 * Process the rule in ajax
	 * @access public
	 * @since 1.0
	 */
	public function process() {
		if ( ! WD_Utils::check_permission()  ) {
			return;
		}

		if ( ! $this->verify_nonce( 'disable_error_display' ) ) {
			return;
		}

		if ( ! is_writable( WD_Utils::retrieve_wp_config_path() ) ) {
			wp_send_json( array(
				'status' => 0,
				'error'  => __( "Your wp-config.php isn't writable", wp_defender()->domain )
			) );
		}

		if ( ( $res = $this->write_wp_config() ) === true ) {
			$this->after_processed();
			wp_send_json( array(
				'status'  => 1,
				'message' => __( "All PHP errors are hidden.", wp_defender()->domain )
			) );
		} else {
			$this->output_error( 'cant_writable', $res->get_error_message() );
		}
	}

	/**
	 * Write the WP_DEBUG key to false inside wp-config.php
	 *
	 * @param null $path
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @return bool|WP_Error
	 */
	public function write_wp_config( $path = null ) {
		if ( $path == null ) {
			$path = WD_Utils::retrieve_wp_config_path();
		}
		$config        = file( $path );
		$error_display = $this->is_display_on( $path );
		if ( $error_display > 0 ) {
			$this->log( 'DEBUG on, turning WP_DEBUG_DISPLAY off' );
			//this cae, mean admin want to tracking something, we don't turn of the debug
			$config[ $error_display ] = 'define("WP_DEBUG_DISPLAY",false);' . PHP_EOL;
		} elseif ( ( $debug_on = $this->is_debug_on( $path ) ) != false ) {
			//this case, we need to turn the debug off
			$this->log( 'DEBUG on, cant fount WP_DEBUG_DISPLAY, turn debug off ' );
			$config[ $debug_on ] = 'define("WP_DEBUG",false);' . PHP_EOL;
		}

		if ( file_put_contents( $path, implode( '', $config ), LOCK_EX ) ) {
			return true;
		}

		return new WP_Error( 'cant_writable', __( "Your wp-config.php isn't writable", wp_defender()->domain ) );	  	 	   	 		 		 				
	}

	public function display() {
		?>
		<div class="wd-hardener-rule">
			<?php echo $this->get_rule_title(); ?>
			<div class="wd-clearfix"></div>

			<div id="<?php echo $this->id ?>" class="wd-rule-content">
				<h4 class="tl"><?php _e( "Overview", wp_defender()->domain ) ?></h4>

				<p><?php _e( "In addition to hiding error logs, developers often use the built-in front-end PHP and scripts error debugging feature, which displays code errors on the front-end. This provides hackers yet another way to find loopholes in your site's security.", wp_defender()->domain ) ?></p>

				<h4 class="tl"><?php _e( "How To Fix", wp_defender()->domain ) ?></h4>

				<div class="wd-error wd-hide">

				</div>
				<div class="wd-well">
					<?php if ( $this->check() ): ?>
						<?php _e( "All PHP errors are hidden..", wp_defender()->domain ) ?>
					<?php else: ?>
						<p>
							<?php _e( "We will add the necessary code to prevent these errors displaying.", wp_defender()->domain ) ?>
						</p>
						<form id="disable_error_display_frm" method="post">
							<?php $this->generate_nonce_field( 'disable_error_display' ) ?>
							<input type="hidden" name="action"
							       value="<?php echo $this->generate_ajax_action( 'disable_error_display' ) ?>">
							<button type="submit"
							        class="button wd-button"><?php _e( "DISABLE ERROR DEBUGGING", wp_defender()->domain ) ?></button>
						</form>
					<?php endif; ?>
				</div>
				<?php echo $this->ignore_button() ?>
			</div>
		</div>
		<?php
	}

	public function revert() {

	}
}