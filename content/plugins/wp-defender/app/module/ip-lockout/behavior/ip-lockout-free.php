<?php
/**
 * Author: Hoang Ngo
 */

namespace WP_Defender\Module\IP_Lockout\Behavior;

use Hammer\Base\Behavior;
use WP_Defender\Module\IP_Lockout\Model\Settings;

class IP_Lockout_Free extends Behavior {
	public function renderLockoutWidget() {
		?>
        <div class="dev-box">
            <div class="box-title">
                <span class="span-icon icon-lockout"></span>
                <h3><?php _e( "IP LOCKOUTS", wp_defender()->domain ) ?></h3>
            </div>
            <div class="box-content">
                <div class="line">
					<?php _e( "Protect to your login area and have Defender automatically lockout any suspicious
                        behaviour.", wp_defender()->domain ) ?>
                </div>
                <button type="button" class="button button-small"><?php _e( "Active", wp_defender()->domain ) ?></button>
            </div>
        </div>
		<?php
	}

	public function getLastEventLockout() {
		$last = \WP_Defender\Module\IP_Lockout\Component\Login_Protection_Api::getLastLockout();
		if ( is_object( $last ) ) {
			$format = get_option( 'date_format' ) . ' ' . get_option( 'time_format' );

			return esc_html( get_date_from_gmt( date( 'Y-m-d H:i:s', $last->date ), $format ) );
		} else {
			return '-';
		}
	}
}