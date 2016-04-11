<?php

/**
 * @author: Hoang Ngo
 */
abstract class WD_Hardener_Abstract extends WD_Component {
	/**
	 * unique id of the rule
	 * @var string
	 */
	protected $id;
	/**
	 * rule description, can be html
	 * @var string
	 */
	protected $title;

	/**
	 * If this rule can be undone, mark this as true
	 * @var bool
	 */
	protected $can_revert = false;

	/**
	 * For caching status of check
	 * @var bool
	 */
	protected $check_cache;

	/**
	 * Contains errors after process a hardener rule
	 * @var array
	 */
	public $last_processed = 0;

	public function __construct() {
		$this->on_creation();
		if ( ( $last_processed = WD_Utils::get_setting( $this->get_setting_key( 'processed_time' ) ) ) ) {
			$this->last_processed = $last_processed;
		}
		do_action( 'wd_hardener_' . $this->id . '_after_init', $this );
		$this->add_ajax_action( 'wd_hardener_ignore', 'hardener_ignore' );
		if ( ! isset( wp_defender()->global['hardener_js_output'] ) ) {
			$this->add_action( 'admin_footer', 'js_output' );
			wp_defender()->global['hardener_js_output'] = 1;
		}
	}

	/**
	 * this must be implement by child class, to initial data when load
	 * @return mixed
	 */
	abstract function on_creation();

	/**
	 * we process the fix here
	 * @return mixed
	 */
	abstract function process();

	/**
	 * For revert the stuff
	 * @return mixed
	 */
	abstract function revert();

	/**
	 * For diagnosis the issue
	 * @return mixed
	 */
	abstract function check();

	/**
	 * This will return the display for current module
	 * @return mixed
	 */
	abstract function display();

	/**
	 * Return css class
	 * @return string
	 */
	protected function get_css_class() {
		return $this->is_ignored() ? 'ignored' : ( $this->check() === true ? 'fixed' : 'issue' );
	}

	/**
	 * This will output a shorter version of hardening title
	 * @return string
	 */
	public function display_link_only() {
		ob_start();
		?>
		<div class="wd-hardener-rule">
			<div class="rule-title <?php echo $this->get_css_class(); ?>">
				<a href="<?php echo $this->get_link() ?>">
					<?php echo $this->get_icon(); ?>
					<?php echo $this->title ?>
				</a>
			</div>
			<div class="wd-clearfix"></div>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Return the icon for header
	 * @return string
	 */
	protected function get_icon() {
		return $this->check() === true ? '<i class="wdv-icon wdv-icon-fw wdv-icon-ok"></i>' : '<i class="dashicons dashicons-flag"></i>';
	}

	/**
	 * This will output full version of hardening title
	 *
	 * @return string
	 */
	protected function get_rule_title() {
		ob_start();
		?>
		<div class="rule-title <?php echo $this->get_css_class(); ?> wd-according"
		     data-target="#<?php echo $this->id ?>">
			<?php echo $this->get_icon(); ?>
			<?php echo $this->title ?>
			<?php if ( $this->is_ignored() ): ?>
				<form method="post" class="form-ignore">
					<input type="hidden" name="id" value="<?php echo $this->id ?>"/>
					<input type="hidden" name="action" value="wd_hardener_ignore"/>
					<?php echo $this->generate_nonce_field( 'wd_hardener_ignore' ) ?>
					<button type="submit" class="button button-small button-light">
						<i class="wdv-icon wdv-icon-fw wdv-icon-undo wd_undo_icon"></i>
					</button>
				</form>
			<?php else: ?>
				<i class="wdv-icon wdv-icon-large wdv-icon-plus wd_toggle_icon"></i>

				<div class="wd-caret-down wd-hide"></div>
			<?php endif; ?>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Return the hardening link
	 * @return string|void
	 */
	public function get_link() {
		$base_url = network_admin_url( 'admin.php?page=wdf-hardener' );
		$base_url .= "#" . $this->id;

		return $base_url;
	}

	/**
	 * @param $action
	 *
	 * @return string
	 */
	public function generate_ajax_action( $action ) {
		return 'wd_' . $this->id . '_' . $action;
	}

	/**
	 * @param $action
	 *
	 * @return string
	 */
	public function generate_nonce_field( $action ) {
		return wp_nonce_field( $this->id . '_' . $action, $this->id . '_nonce' );
	}

	/**
	 * @param $action
	 *
	 * @return string
	 */
	public function generate_nonce( $action ) {
		return wp_create_nonce( $this->id . '_' . $action );
	}

	/**
	 * @param $action
	 *
	 * @return false|int
	 */
	public function verify_nonce( $action ) {
		return wp_verify_nonce( WD_Utils::http_post( $this->id . '_nonce', null ), $this->id . '_' . $action );
	}

	/**
	 * @param $key
	 * @param $error
	 *
	 * @return WP_Error
	 */
	public function output_error( $key, $error ) {
		//logging
		$this->log( 'WP Defender Error-' . $this->id . ' : ' . $error, self::ERROR_LEVEL_ERROR );
		if ( $this->is_ajax() ) {
			wp_send_json( array(
				'status' => 0,
				'error'  => $error
			) );
		} else {
			return new WP_Error( $key, $error );
		}
	}

	/**
	 * logic after processed
	 */
	protected function after_processed() {
		WD_Utils::update_setting( $this->get_setting_key( 'processed_time' ), time() );
		WD_Utils::flag_for_submitting();
		do_action( 'wd_hardener_' . $this->id . '_after_processed', $this );
		do_action( 'wd_hardener_after_processed', $this );
	}

	/**
	 * @param $key
	 *
	 * @return string
	 */
	protected function get_setting_key( $key ) {
		return $this->id . '->' . $key;
	}

	/**
	 * return html code to display ignore button
	 * @return string
	 */
	public function ignore_button() {
		ob_start();
		?>
		<form method="post" class="form-ignore tr <?php echo $this->check() ? 'wd-hide' : null ?>">
			<input type="hidden" name="id" value="<?php echo $this->id ?>"/>
			<input type="hidden" name="action" value="wd_hardener_ignore"/>
			<?php echo $this->generate_nonce_field( 'wd_hardener_ignore' ) ?>
			<button
				tooltip="<?php esc_attr_e( "Ignore this hardening tweak, you can un-ignore at any time", wp_defender()->domain ) ?>"
				type="submit" class="button button-light"><?php _e( "Ignore", wp_defender()->domain ) ?></button>
		</form>
		<div class="clearfix"></div>
		<?php
		return ob_get_clean();
	}

	public function js_output() {
		?>
		<script type="text/javascript">
			jQuery(function ($) {
				$('body').on('submit', '.form-ignore', function () {
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

							} else {
								if (data.type == 'ignore') {
									if ($('.wd-hardener-ignored').size() == 0) {
										location.reload();
									} else {
										parent.hide(500, function () {
											parent.remove();
											$('.wd-hardener-ignored').append(data.html);
										})
									}
								} else {
									parent.fadeOut(500, function () {
										if (data.type == 'fixed') {
											var titles = $('.hardener-success-container .rule-title');
										} else if (data.type == 'issue') {
											var titles = $('.hardener-error-container .rule-title');
										}
										var found = false;
										if (titles.size() > 0) {
											titles = $.makeArray(titles);
											titles.reverse();
											var div = $(data.html);
											var current_title = div.find('.rule-title').text();
											$.each(titles, function (i, v) {
												var text = $(this).text().toUpperCase();
												//if the current letter is order up the current, add bellow that
												if (current_title.toUpperCase().localeCompare(text) == true) {
													div.insertAfter($(this).closest('.wd-hardener-rule'));
													found = true;
													return false;
												}
											})
										}
										if (found == false) {
											//append it
											if (data.type == 'fixed') {
												div.prependTo($('.wd-success-error'));
											} else {
												div.prependTo($('.wd-hardener-error'));
											}
										}
										$('.wd-according').wd_according();
										parent.remove();
										if ($('.wd-hardener-ignored').find('.wd-hardener-rule').size() == 0) {
											location.reload();
										}
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

	/**
	 *
	 */
	public function hardener_ignore() {
		if ( ! WD_Utils::check_permission() ) {
			return;
		}

		if ( ! $this->verify_nonce( 'wd_hardener_ignore' ) ) {
			return;
		}

		$ignored = WD_Utils::get_setting( 'hardener->ignores', array() );
		$id      = WD_Utils::http_post( 'id' );
		if ( ( $key = array_search( $id, $ignored ) ) !== false ) {
			//lift it out
			unset( $ignored[ $key ] );
			WD_Utils::update_setting( 'hardener->ignores', $ignored );
			ob_start();
			$this->display();
			$content = ob_get_clean();
			WD_Utils::flag_for_submitting();
			wp_send_json( array(
				'status' => 1,
				'type'   => $this->check() ? 'fixed' : 'issue',
				'html'   => $content
			) );
		} else {
			$ignored[] = $id;
			WD_Utils::update_setting( 'hardener->ignores', $ignored );
			WD_Utils::flag_for_submitting();
			wp_send_json( array(
				'status' => 1,
				'type'   => 'ignore',
				'html'   => $this->ignore_html()
			) );
		}
	}

	public function ignore_html() {
		ob_start();
		?>
		<div class="wd-hardener-rule">
			<?php echo $this->get_rule_title(); ?>
			<div class="wd-clearfix"></div>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * @return bool
	 */
	public function is_ignored() {
		$ignored = WD_Utils::get_setting( 'hardener->ignores', array() );
		if ( array_search( $this->id, $ignored ) !== false ) {
			return true;
		}

		return false;
	}
}