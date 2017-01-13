<?php

/**
 * @author: Hoang Ngo
 */
class WD_Notification_Controller extends WD_Controller {

	public function __construct() {
		$this->add_action( 'wd_scan_completed', 'send_scan_notification' );
	}

	/**
	 * Send email to an email provided by admin
	 *
	 * @param WD_Scan_Result_Model $model
	 *
	 * @access public
	 * @since 1.0
	 */
	public function send_scan_notification( WD_Scan_Result_Model $model ) {
		if ( WD_Utils::get_setting( 'always_notify', 0 ) == 0 && count( $model->get_results() ) == 0 ) {
			return;
		}

		if ( get_post_meta( $model->id, 'email_sent', true ) == 'yes' ) {
			return;
		}

		$recipients = WD_Utils::get_setting( 'recipients', array() );
		if ( empty( $recipients ) ) {
			return;
		}

		foreach ( $recipients as $user_id ) {
			$user = get_user_by( 'id', $user_id );
			if ( ! is_object( $user ) ) {
				continue;
			}
			//prepare the parameters
			$email   = $user->user_email;
			$params  = array(
				'USER_NAME'      => WD_Utils::get_display_name( $user_id ),
				'ISSUES_COUNT'   => count( $model->get_results() ),
				'SCAN_PAGE_LINK' => network_admin_url( 'admin.php?page=wdf-scan' ),
				'ISSUES_LIST'    => $this->issues_list_html( $model ),
				'SITE_URL'       => network_site_url(),
			);
			$params  = apply_filters( 'wd_notification_email_params', $params );
			$subject = apply_filters( 'wd_notification_email_subject', WD_Utils::get_setting( 'completed_scan_email_subject' ) );
			$subject = stripslashes( $subject );
			if ( count( $model->get_results() ) == 0 ) {
				$email_content = WD_Utils::get_setting( 'completed_scan_email_content_success' );
			} else {
				$email_content = WD_Utils::get_setting( 'completed_scan_email_content_error' );
				//we need to replace the current email with the new one
				$old = "<a href=\"{SCAN_PAGE_LINK}\">Follow me back to the lair and let's get you patched up.<\/a>";
				$old = str_replace( ' ', '[\n\r\s]+', $old );
				$old = "/$old/";
				if ( preg_match( $old, $email_content ) ) {
					$email_content = preg_replace( $old, '', $email_content );
					WD_Utils::update_setting( 'completed_scan_email_content_error', $email_content );
				}
			}
			$email_content = apply_filters( 'wd_notification_email_content_before', $email_content, $model );
			foreach ( $params as $key => $val ) {
				$email_content = str_replace( '{' . $key . '}', $val, $email_content );
				$subject       = str_replace( '{' . $key . '}', $val, $subject );
			}
			//change nl to br
			$email_content = wpautop( stripslashes( $email_content ) );
			$email_content = apply_filters( 'wd_notification_email_content_after', $email_content, $model );

			$email_template = $this->render( 'email-template', array(
				'subject' => $subject,
				'message' => $email_content
			), false );
			$no_reply_email = "noreply@" . parse_url( get_site_url(), PHP_URL_HOST );
			$headers        = array(
				'From: WP Defender <' . $no_reply_email . '>',
				'Content-Type: text/html; charset=UTF-8'
			);
			wp_mail( $email, $subject, $email_template, $headers );
		}
		update_post_meta( $model->id, 'email_sent', 'yes' );
	}

	/**
	 * Build issues html table
	 *
	 * @param $model
	 *
	 * @return string
	 * @access private
	 * @since 1.0
	 */
	private function issues_list_html( $model ) {
		ob_start();
		?>
		<table class="results-list"
		       style="border-collapse: collapse; border-spacing: 0; padding: 0; text-align: left; vertical-align: top;">
			<thead class="results-list-header" style="border-bottom: 2px solid #ff5c28;">
			<tr style="padding: 0; text-align: left; vertical-align: top;">
				<th class="result-list-label-title"
				    style="Margin: 0; color: #ff5c28; font-family: Helvetica, Arial, sans-serif; font-size: 22px; font-weight: 700; line-height: 48px; margin: 0; padding: 0; text-align: left; width: 35%;"><?php esc_html_e( "File", wp_defender()->domain ) ?></th>
				<th class="result-list-data-title"
				    style="Margin: 0; color: #ff5c28; font-family: Helvetica, Arial, sans-serif; font-size: 22px; font-weight: 700; line-height: 48px; margin: 0; padding: 0; text-align: left;"><?php esc_html_e( "Issue", wp_defender()->domain ) ?></th>
			</tr>
			</thead>
			<tbody class="results-list-content">
			<?php foreach ( $model->get_results() as $k => $item ): ?>
				<?php if ( $k == 0 ): ?>
					<tr style="padding: 0; text-align: left; vertical-align: top;">
						<td class="result-list-label"
						    style="-moz-hyphens: auto; -webkit-hyphens: auto; Margin: 0; border-collapse: collapse !important; color: #555555; font-family: Helvetica, Arial, sans-serif; font-size: 15px; font-weight: 700; hyphens: auto; line-height: 28px; margin: 0; padding: 20px 5px; text-align: left; vertical-align: top; word-wrap: break-word;"><?php echo $item->get_name() ?>
							<span
								style="display: inline-block; font-weight: 400; width: 100%;"><?php echo $item->get_sub() ?></span>
						</td>
						<td class="result-list-data"
						    style="-moz-hyphens: auto; -webkit-hyphens: auto; Margin: 0; border-collapse: collapse !important; color: #555555; font-family: Helvetica, Arial, sans-serif; font-size: 15px; font-weight: 700; hyphens: auto; line-height: 28px; margin: 0; padding: 20px 5px; text-align: left; vertical-align: top; word-wrap: break-word;"><?php echo $item->get_detail() ?></td>
					</tr>
				<?php else: ?>
					<tr style="padding: 0; text-align: left; vertical-align: top;">
						<td class="result-list-label <?php echo $k > 0 ? " bordered" : null ?>"
						    style="-moz-hyphens: auto; -webkit-hyphens: auto; Margin: 0; border-collapse: collapse !important; border-top: 2px solid #ff5c28; color: #555555; font-family: Helvetica, Arial, sans-serif; font-size: 15px; font-weight: 700; hyphens: auto; line-height: 28px; margin: 0; padding: 20px 5px; text-align: left; vertical-align: top; word-wrap: break-word;"><?php echo $item->get_name() ?>
							<span
								style="display: inline-block; font-weight: 400; width: 100%;"><?php echo $item->get_sub() ?></span>
						</td>
						<td class="result-list-data <?php echo $k > 0 ? " bordered" : null ?>"
						    style="-moz-hyphens: auto; -webkit-hyphens: auto; Margin: 0; border-collapse: collapse !important; border-top: 2px solid #ff5c28; color: #555555; font-family: Helvetica, Arial, sans-serif; font-size: 15px; font-weight: 700; hyphens: auto; line-height: 28px; margin: 0; padding: 20px 5px; text-align: left; vertical-align: top; word-wrap: break-word;"><?php echo $item->get_detail() ?></td>
					</tr>
				<?php endif; ?>
			<?php endforeach; ?>
			</tbody>
			<tfoot class="results-list-footer">
			<tr style="padding: 0; text-align: left; vertical-align: top;">
				<td colspan="2"
				    style="-moz-hyphens: auto; -webkit-hyphens: auto; Margin: 0; border-collapse: collapse !important; color: #555555; font-family: Helvetica, Arial, sans-serif; font-size: 15px; font-weight: normal; hyphens: auto; line-height: 26px; margin: 0; padding: 10px 0 0; text-align: left; vertical-align: top; word-wrap: break-word;">
					<p style="Margin: 0; Margin-bottom: 0; color: #555555; font-family: Helvetica, Arial, sans-serif; font-size: 15px; font-weight: normal; line-height: 26px; margin: 0; margin-bottom: 0; padding: 0 0 24px; text-align: left;">
						<a class="plugin-brand" href="<?php echo network_admin_url( 'admin.php?page=wdf-scan' ) ?>"
						   style="Margin: 0; color: #ff5c28; display: inline-block; font: inherit; font-family: Helvetica, Arial, sans-serif; font-weight: normal; line-height: 1.3; margin: 0; padding: 0; text-align: left; text-decoration: none;"><?php esc_html_e( "Let’s get your site patched up.", wp_defender()->domain ) ?>
							<img class="icon-arrow-right"
							     src="<?php echo wp_defender()->get_plugin_url() ?>assets/email-images/icon-arrow-right-defender.png"
							     alt="Arrow"
							     style="-ms-interpolation-mode: bicubic; border: none; clear: both; display: inline-block; margin: -2px 0 0 5px; max-width: 100%; outline: none; text-decoration: none; vertical-align: middle; width: auto;"></a>
					</p>
				</td>
			</tr>
			</tfoot>
		</table>
		<?php
		return ob_get_clean();
	}
}