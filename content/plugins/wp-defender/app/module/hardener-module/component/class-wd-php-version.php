<?php

/**
 * Class: WD_PHP_Version
 */
class WD_PHP_Version extends WD_Hardener_Abstract {
	public $php_version;

	public function on_creation() {
		$this->id          = 'php_version';
		$this->title       = esc_html__( 'Update PHP to latest version', wp_defender()->domain );
		$this->php_version = phpversion();
	}

	/**
	 * This will check if we need to upgrade or not
	 * @return bool|WP_Error
	 */
	public function check() {
		if ( version_compare( $this->php_version, '5.6', '<=' ) ) {
			return false;
		}

		return true;
	}


	public function process() {

	}

	public function display() {
		?>
        <div class="wd-hardener-rule">
			<?php echo $this->get_rule_title(); ?>
            <div class="wd-clearfix"></div>

            <div id="<?php echo $this->id ?>" class="wd-rule-content">
                <h4 class="tl"><?php esc_html_e( "Overview", wp_defender()->domain ) ?></h4>

                <p>
					<?php esc_html_e( "PHP versions older than 5.6 are no longer supported. For security and stability we strongly recommend you upgrade your PHP version to version 5.6 or newer as soon as possible.", wp_defender()->domain ) ?>
                </p>
                <p>
					<?php printf( esc_html__( "More information: %s", wp_defender()->domain ), '<a target="_blank" href="http://php.net/supported-versions.php">http://php.net/supported-versions.php</a>' ) ?>
                </p>

                <div class="group wd-version-subs">
                    <div class="col span_5_of_12">
                        <div class="group">
                            <div class="col span_6_of_12 wd-version-sub">
                                <strong><?php esc_html_e( "Current Version", wp_defender()->domain ) ?></strong>

                                <div class="wd-clearfix"></div>
                                <span class="<?php echo $this->check() ? 'ok' : null ?>"><?php echo $this->php_version ?></span>
                            </div>
                            <div class="col span_6_of_12 wd-version-sub">
                                <strong><?php esc_html_e( "Recommend Version", wp_defender()->domain ) ?></strong>

                                <div class="wd-clearfix"></div>
                                <span><?php echo '5.6' ?></span>
                            </div>
                            <div class="wd-clearfix"></div>
                        </div>
                    </div>
                    <div class="wd-clearfix"></div>
                </div>

                <h4 class="tl"><?php esc_html_e( "How To Fix", wp_defender()->domain ) ?></h4>

                <div class="wd-well">
					<?php if ( ( $res_check = $this->check() ) === true ): ?>
						<?php esc_html_e( "Your PHP version is up to date. Your PHP version can be upgraded by your hosting provider or System Administrator. Please contact them for assistance.", wp_defender()->domain ) ?>
					<?php else: ?>
						<?php esc_html_e( "Your PHP version can be upgraded by your hosting provider or System Administrator. Please contact them for assistance.", wp_defender()->domain ) ?>
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
