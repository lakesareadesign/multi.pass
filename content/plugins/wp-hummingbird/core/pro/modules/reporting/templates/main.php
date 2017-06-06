<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<table class="wrapper main" align="center" style="border-collapse: collapse; border-spacing: 0; padding: 0; text-align: left; vertical-align: top; width: 100%;">
	<tbody>
	<tr style="padding: 0; text-align: left; vertical-align: top;">
		<td class="wrapper-inner main-inner" style="-moz-hyphens: auto; -webkit-hyphens: auto; Margin: 0; border-collapse: collapse !important; color: #555555; font-family: Arial, sans-serif; font-size: 14px; font-weight: normal; hyphens: auto; line-height: 30px; margin: 0; padding: 30px 60px; text-align: left; vertical-align: top; word-wrap: break-word;">

			<table class="main-content" style="border-collapse: collapse; border-spacing: 0; padding: 0; text-align: left; vertical-align: top; width: 100%;">
				<tbody>
				<tr style="padding: 0; text-align: left; vertical-align: top;">
					<td class="main-content-text" style="-moz-hyphens: auto; -webkit-hyphens: auto; Margin: 0; border-collapse: collapse !important; color: #555555; font-family: Arial, sans-serif; font-size: 15px; font-weight: normal; hyphens: auto; line-height: 30px; margin: 0; padding: 0; text-align: left; vertical-align: top; word-wrap: break-word;">
						<p style="color: #555555;font-family: Arial, sans-serif;font-size: 32px;font-weight: normal;line-height: 37px;margin: 0;margin-bottom: 30px;padding: 0;text-align: left"><?php printf( __( 'Hi %s,', 'wphb' ), $params['USER_NAME'] ); ?></p>

						<p style="color: #555555;font-family: Arial, sans-serif;font-size: 15px;font-weight: normal;line-height: 30px;margin: 0;margin-bottom: 30px;padding: 0;text-align: left"><?php _e( 'It’s Hummingbird here, straight from the', 'wphb' ); ?> <strong><a class="brand" href="<?php echo $params['SITE_MANAGE_URL']; ?>" target="_blank" style="color: #333;font: inherit;font-family: Arial, sans-serif;font-weight: inherit;line-height: 30px;margin: 0;padding: 0;text-align: left;text-decoration: none"><?php echo $params['SITE_URL']; ?></a></strong> <?php _e( 'engine room. Here’s your latest Performance Test summary.', 'wphb' ); ?></p>

						<table class="reports-list" align="center" style="border-collapse: collapse;border-spacing: 0;border-top: 1px solid #e6e6e6;margin: 0 0 30px;padding: 0;text-align: left;vertical-align: top;width: 100%">
							<tbody>
							<?php foreach ( $last_test->rule_result as $rule => $rule_result ): ?>
								<tr class="report-list-item" style="border-bottom: 1px solid #E6E6E6;padding: 0;text-align: left;vertical-align: top">
									<td class="report-list-item-info" style="border-collapse: collapse !important;color: #555555;font-family: Arial, sans-serif;font-size: 15px;font-weight: 700;line-height: 30px;margin: 0;padding: 10px 0;text-align: left;vertical-align: top">
										<?php if ( $rule_result->impact_score_class === 'aplus' || $rule_result->impact_score_class === 'a' || $rule_result->impact_score_class === 'b' ): ?>
											<img src="<?php echo esc_url( wphb_plugin_url() . 'core/pro/modules/reporting/templates/images/icon-ok.png' ); ?>" alt="<?php _e( 'Ok', 'wphb' ); ?>" style="-ms-interpolation-mode: bicubic; border: none; clear: both; float: left; display: inline-block; margin: 5px 10px 0 0; outline: none; text-decoration: none; width: auto; vertical-align: middle;" /><span style="color: inherit; display: inline; font-size: inherit; font-family: inherit; line-height: inherit; vertical-align: middle;"><?php echo $rule_result->label; ?></span>
										<?php elseif ( $rule_result->impact_score_class === 'c' || $rule_result->impact_score_class === 'd' ): ?>
											<img src="<?php echo esc_url( wphb_plugin_url() . 'core/pro/modules/reporting/templates/images/icon-warning.png' ); ?>" alt="<?php _e( 'Warning', 'wphb' ); ?>" style="-ms-interpolation-mode: bicubic; border: none; clear: both; float: left; display: inline-block; margin: 5px 10px 0 0; outline: none; text-decoration: none; width: auto; vertical-align: middle;" /><span style="color: inherit; display: inline; font-size: inherit; font-family: inherit; line-height: inherit; vertical-align: middle;"><?php echo $rule_result->label; ?></span>
										<?php elseif ( $rule_result->impact_score_class === 'e' || $rule_result->impact_score_class === 'f' ): ?>
											<img src="<?php echo esc_url( wphb_plugin_url() . 'core/pro/modules/reporting/templates/images/icon-error.png' ); ?>" alt="<?php _e( 'Critical', 'wphb' ); ?>" style="-ms-interpolation-mode: bicubic; border: none; clear: both; float: left; display: inline-block; margin: 5px 10px 0 0; outline: none; text-decoration: none; width: auto; vertical-align: middle;" /><span style="color: inherit; display: inline; font-size: inherit; font-family: inherit; line-height: inherit; vertical-align: middle;"><?php echo $rule_result->label; ?></span>
										<?php endif; ?>
									</td>
									<?php if ( $rule_result->impact_score_class === 'aplus' || $rule_result->impact_score_class === 'a' || $rule_result->impact_score_class === 'b' ): ?>
										<td class="report-list-item-result ok" style="border-collapse: collapse !important;color: #1ABC9C;font-family: Arial, sans-serif;font-size: 15px;font-weight: 700;line-height: 30px;margin: 0;min-width: 65px;padding: 10px 0;text-align: right;vertical-align: top"><?php echo $rule_result->impact_score; ?>/100</td>
									<?php elseif ( $rule_result->impact_score_class === 'c' || $rule_result->impact_score_class === 'd' ): ?>
										<td class="report-list-item-result warning" style="border-collapse: collapse !important;color: #FECF2F;font-family: Arial, sans-serif;font-size: 15px;font-weight: 700;line-height: 30px;margin: 0;min-width: 65px;padding: 10px 0;text-align: right;vertical-align: top"><?php echo $rule_result->impact_score; ?>/100</td>
									<?php elseif ( $rule_result->impact_score_class === 'e' || $rule_result->impact_score_class === 'f' ): ?>
										<td class="report-list-item-result critical" style="border-collapse: collapse !important;color: #FF6D6D;font-family: Arial, sans-serif;font-size: 15px;font-weight: 700;line-height: 30px;margin: 0;min-width: 65px;padding: 10px 0;text-align: right;vertical-align: top"><?php echo $rule_result->impact_score; ?>/100</td>
									<?php endif; ?>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
						<p style="color: #555555;font-family: Arial, sans-serif;font-size: 15px;font-weight: normal;line-height: 30px;margin: 0;margin-bottom: 30px;padding: 0;text-align: left"><a href="<?php echo $params['SCAN_PAGE_LINK']; ?>" class="brand-button" style="background: #17A8E3;color: #ffffff;font-family: Arial, sans-serif;font-size: 12px;font-weight: normal;line-height: 20px;margin: 0;padding: 10px 20px;text-align: center;text-decoration: none;display: inline-block;border-radius: 4px;text-transform: uppercase"><?php _e( 'View full report', 'wphb' ); ?></a></p>
					</td>
				</tr>
				</tbody>
			</table>

		</td>
	</tr>
	</tbody>
</table>