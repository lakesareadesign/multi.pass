<?php
/**
 * Class: WD_Disable_Ping_Back
 */

/**
 * @author: Hoang Ngo
 */
class WD_Disable_Ping_Back extends WD_Hardener_Abstract {
	public function on_creation() {
		$this->id         = 'disable_ping_back';
		$this->title      = __( "Disable trackbacks and pingbacks", wp_defender()->domain );
		$this->can_revert = true;

		$this->add_action( 'admin_footer', 'print_scripts' );
		$this->add_ajax_action( $this->generate_ajax_action( 'disable_ping_back' ), 'process' );
	}

	/**
	 * @return bool
	 */
	public function check() {
		return WD_Utils::get_setting( $this->get_setting_key( 'remove_pingback' ) ) == 1;
	}

	public function print_scripts() {
		?>
		<script type="text/javascript">
			jQuery(function ($) {
				$('body').on('submit', '#disable_ping_back_frm', function () {
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
								$('#disable_ping_back_frm .wd-error').html(data.error).removeClass('wd-hide');
							} else {
								$('#disable_ping_back_frm .wd-error').html('').addClass('wd-hide');
								that.closest('div').html(data.message);
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
										var div = parent.detach();
										$('.hardener-error-container').removeClass('wd-hide');

										//find the position
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
											/*$('html, body').animate({
											 scrollTop: div.find('.rule-title').offset().top
											 }, 1000);*/
										});
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

		if ( ! $this->verify_nonce( 'disable_ping_back' ) ) {
			return;
		}

		if ( WD_Utils::get_setting( $this->get_setting_key( 'remove_pingback' ) ) == 1 ) {
			WD_Utils::update_setting( $this->get_setting_key( 'remove_pingback' ), 0 );
			wp_send_json( array(
				'status'  => 1,
				'message' => $this->_display(),
				'revert'  => 1
			) );
		} else {
			$this->after_processed();
			WD_Utils::update_setting( $this->get_setting_key( 'remove_pingback' ), 1 );
			wp_send_json( array(
				'status'  => 1,
				'message' => $this->_display(),
				'done'    => 1
			) );
		}
	}

	public function display() {
		?>
		<div class="wd-hardener-rule">
			<?php echo $this->get_rule_title(); ?>
			<div class="wd-clearfix"></div>

			<div id="<?php echo $this->id ?>" class="wd-rule-content">
				<h4 class="tl"><?php _e( "Overview", wp_defender()->domain ) ?></h4>

				<p><?php _e( "Pingbacks notify a website when it has been mentioned by another website, like a form of courtesy communication. However, these notifications can be sent to any website willing to receive them, opening you up to DDoS attacks, which can take your website down in seconds and fill your posts with spam comments.", wp_defender()->domain ) ?></p>

				<div class="wd-clearfix"></div>
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

	public function _display() {
		ob_start();
		?>
		<?php if ( $this->check() ): ?>
			<p>
				<?php _e( 'Trackbacks and pingbacks are turned off.', wp_defender()->domain ) ?>
			</p>
			<form id="disable_ping_back_frm" method="post">
				<?php $this->generate_nonce_field( 'disable_ping_back' ) ?>
				<input type="hidden" name="action"
				       value="<?php echo $this->generate_ajax_action( 'disable_ping_back' ) ?>">
				<button type="submit"
				        class="button button-grey"><?php _e( "Revert", wp_defender()->domain ) ?></button>
			</form>
		<?php else: ?>
			<p>
				<?php _e( "We will turn off trackbacks and pingbacks in your WordPress settings area.", wp_defender()->domain ) ?>
			</p>
			<form id="disable_ping_back_frm" method="post">
				<?php $this->generate_nonce_field( 'disable_ping_back' ) ?>
				<input type="hidden" name="action"
				       value="<?php echo $this->generate_ajax_action( 'disable_ping_back' ) ?>">
				<button type="submit"
				        class="button wd-button"><?php _e( "Disable Pingbacks", wp_defender()->domain ) ?></button>
			</form>
		<?php endif; ?>
		<?php
		return ob_get_clean();
	}

	public function revert() {

	}
}