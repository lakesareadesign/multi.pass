<?php
/**
 * Author: Hoang Ngo
 */

namespace WP_Defender\Module\Hardener\Behavior;

use Hammer\Base\Behavior;
use WP_Defender\Module\Hardener\Model\Settings;

class Widget extends Behavior {
	public function renderHardenerWidget() {
		$issues = Settings::instance()->getIssues();
		$issues = array_slice( $issues, 0, 3 );
		?>
        <div class="dev-box hardener-widget">
            <div class="box-title">
                <span class="span-icon hardener-icon"></span>
                <h3><?php _e( "Security Tweaks", wp_defender()->domain ) ?>
					<?php if ( count( Settings::instance()->issues ) ): ?>
                        <span class="def-tag tag-yellow">
                        <?php
                        echo count( Settings::instance()->issues ) ?>
                    </span>
					<?php endif; ?>
                </h3>
            </div>
            <div class="box-content">
				<?php $count = count( $issues ); ?>
                <div class="line <?php echo $count ? 'end' : null ?>">
					<?php _e( " Defender checks for basic security tweaks you can make to enhance your website’s
                    defense against hackers and bots.", wp_defender()->domain ) ?>
                </div>
				<?php if ( $count ): ?>
                    <ul class="dev-list end">
						<?php
						foreach ( $issues as $issue ):
							?>
                            <li>
                                <div>
                                <span class="list-label">
                                    <i class="def-icon icon-h-warning"></i>
	                                <?php echo $issue->getTitle(); ?>
                                </span>
                                    <span class="list-detail">
                                    <a href="<?php echo network_admin_url( 'admin.php?page=wdf-hardener#' . $issue::$slug ) ?>"
                                       class="button button-secondary button-small"><?php _e( "View", wp_defender()->domain ) ?></a>
                                </span>
                                </div>
                            </li>
						<?php endforeach;
						?>
                    </ul>
				<?php else: ?>
                    <div class="well well-green with-cap mline">
                        <i class="def-icon icon-tick"></i>
						<?php _e( "You have actioned all available security tweaks. Great work!", wp_defender()->domain ) ?>
                    </div>
				<?php endif; ?>
                <div class="row">
                    <div class="col-third tl">
                        <a href="<?php echo network_admin_url( 'admin.php?page=wdf-hardener' ) ?>"
                           class="button button-small button-secondary"><?php _e( "VIEW ISSUES", wp_defender()->domain ) ?></a>
                    </div>
                </div>
            </div>
        </div>
		<?php
	}

	private function _renderNew() {

	}

	private function _render() {

	}
}