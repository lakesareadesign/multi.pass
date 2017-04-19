<?php
/**
 * Author: Hoang Ngo
 */

namespace WP_Defender\Module\IP_Lockout\Behavior;

use Hammer\Base\Behavior;
use WP_Defender\Behavior\Utils;
use WP_Defender\Module\IP_Lockout\Model\Settings;

class Widget extends Behavior {
	public function renderLockoutWidget() {
		?>
        <div class="dev-box">
            <div class="box-title">
                <span class="span-icon icon-lockout"></span>
                <h3><?php _e( "IP LOCKOUTS", wp_defender()->domain ) ?></h3>
            </div>
            <div class="box-content">
                <div class="line">
					<?php _e( "Protect your login area by automatically locking out any suspicious behavior.", wp_defender()->domain ) ?>
                </div>
				<?php if ( ! Settings::instance()->detect_404 && ! Settings::instance()->login_protection ): ?>
                    <form method="post" id="settings-frm" class="ip-frm">
						<?php wp_nonce_field( 'saveLockoutSettings' ) ?>
                        <input type="hidden" name="action" value="saveLockoutSettings"/>
                        <input type="hidden" name="login_protection" value="1"/>
                        <input type="hidden" name="detect_404" value="1"/>
                        <button type="submit" class="button button-primary button-small">
							<?php esc_html_e( "Activate", wp_defender()->domain ) ?>
                        </button>
                    </form>
				<?php else: ?>
                    <div class="end"></div>
                    <ul class="dev-list bold end">
                        <li>
                            <div>
                                <span class="list-label"><?php _e( "Last lockout", wp_defender()->domain ) ?></span>
                                <span class="list-detail"><?php
									echo $this->getLastEventLockout();
									?></span>
                            </div>
                        </li>
                        <li>
                            <div>
                                <span class="list-label"><?php _e( "Login lockouts this week", wp_defender()->domain ) ?></span>
                                <span class="list-detail">
                                            <?php
                                            $count = \WP_Defender\Module\IP_Lockout\Component\Login_Protection_Api::getLoginLockouts( strtotime( 'first day of this week', current_time( 'timestamp' ) ) );
                                            echo $count;
                                            ?>
                                        </span>
                            </div>
                        </li>
                        <li>
                            <div>
                                <span class="list-label"><?php _e( "404 lockouts this week", wp_defender()->domain ) ?></span>
                                <span class="list-detail">
                                            <?php
                                            $count = \WP_Defender\Module\IP_Lockout\Component\Login_Protection_Api::get404Lockouts( strtotime( 'first day of this week', current_time( 'timestamp' ) ) );
                                            echo $count;
                                            ?>
                                        </span>
                            </div>
                        </li>
                    </ul>
                    <div class="row">
                        <div class="col-third tl">
                            <a href="<?php echo network_admin_url( 'admin.php?page=wdf-ip-lockout&view=logs', wp_defender()->domain
							) ?>"
                               class="button button-small button-secondary">
								<?php _e( "View logs", wp_defender()->domain ) ?></a>
                        </div>
                        <div class="col-two-third tr">
                            <p class="status-text"><?php if ( Settings::instance()->ip_lockout_notification && Settings::instance()->login_lockout_notification ) {
									echo _e( "Lockout notifications are enabled", wp_defender()->domain );
								} else {
									echo _e( "Lockout notifications are disabled", wp_defender()->domain );
								}
								?></p>
                        </div>
                    </div>
				<?php endif; ?>
            </div>
        </div>
		<?php
	}

	public function getLastEventLockout() {
		$last = \WP_Defender\Module\IP_Lockout\Component\Login_Protection_Api::getLastLockout();
		if ( is_object( $last ) ) {
			return Utils::instance()->formatDateTime( date( 'Y-m-d H:i:s', $last->date ) );
		} else {
			return __( "Never", wp_defender()->domain );
		}
	}
}