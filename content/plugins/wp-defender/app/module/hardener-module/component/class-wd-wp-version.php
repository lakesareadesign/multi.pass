<?php

/**
 * Class: WD_WP_Version
 */
class WD_WP_Version extends WD_Hardener_Abstract {
	public $wp_version;

	public function on_creation() {
		global $wp_version;
		$this->id         = 'wp_verify_version';
		$this->title      = __( 'Update WordPress to latest version', wp_defender()->domain );
		$this->wp_version = $wp_version;
	}

	/**
	 * This will check if we need to upgrade or not
	 * @return bool
	 */
	public function check() {
		$latest = $this->get_latest_version();
		//we get error when getting the update packages information
		if ( $latest == false ) {
			return new WP_Error( 'cant_check_updates', __( "An error occurred, please try again", wp_defender()->domain ) );
		}

		if ( version_compare( $this->wp_version, $this->get_latest_version() ) == - 1 ) {
			return false;
		}

		return true;
	}

	/**
	 * @return bool
	 */
	private function get_latest_version() {
		if ( ! function_exists( 'get_core_updates' ) ) {
			include_once ABSPATH . 'wp-admin/includes/update.php';
		}
		$update_data = get_core_updates();

		if ( isset( $update_data[0] ) && is_object( $update_data[0] ) ) {
			$latest = $update_data[0];

			return $latest->version;
		}

		return false;
	}

	protected function get_upgrade_url() {
		$url = network_admin_url( 'update-core.php' );

		return apply_filters( 'wd_hardener/' . $this->id . '/upgrade_url', $url );
	}

	public function process() {

	}

	public function display() {
		?>
		<div class="wd-hardener-rule">
			<?php echo $this->get_rule_title(); ?>
			<div class="wd-clearfix"></div>

			<div id="<?php echo $this->id ?>" class="wd-rule-content">
				<h4 class="tl"><?php _e( "Overview", wp_defender()->domain ) ?></h4>

				<p>
					<?php _e( "WordPress is an extremely popular platform, and with that popularity comes hackers that increasingly want to exploit WordPress based websites. Leaving your WordPress installation out of date is an almost guaranteed way to get hacked!", wp_defender()->domain ) ?>
				</p>

				<div class="group wd-version-subs">
					<div class="col span_5_of_12">
						<div class="group">
							<div class="col span_6_of_12 wd-version-sub">
								<strong><?php _e( "Current Version", wp_defender()->domain ) ?></strong>

								<div class="wd-clearfix"></div>
								<span><?php echo $this->wp_version ?></span>
							</div>
							<div class="col span_6_of_12 wd-version-sub">
								<strong><?php _e( "Latest Version", wp_defender()->domain ) ?></strong>

								<div class="wd-clearfix"></div>
								<span><?php echo $this->get_latest_version() ?></span>
							</div>
							<div class="wd-clearfix"></div>
						</div>
					</div>
					<div class="wd-clearfix"></div>
				</div>

				<h4 class="tl"><?php _e( "How To Fix", wp_defender()->domain ) ?></h4>

				<div class="wd-well">
					<?php if ( ( $res_check = $this->check() ) === true ): ?>
						<?php _e( "You have the latest WordPress version installed.", wp_defender()->domain ) ?>
					<?php else: ?>
						<?php if ( is_wp_error( $res_check ) ): ?>
							<p class="text-error"><?php echo $res_check->get_error_message() ?></p>
						<?php else: ?>
							<a href="<?php echo $this->get_upgrade_url() ?>" class="button wd-button">
								<?php _e( "Update WordPress", wp_defender()->domain ) ?>
							</a>
						<?php endif; ?>
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
