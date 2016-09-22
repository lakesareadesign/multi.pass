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
			}
			$email_content = apply_filters( 'wd_notification_email_content_before', $email_content, $model );
			foreach ( $params as $key => $val ) {
				$email_content = str_replace( '{' . $key . '}', $val, $email_content );
				$subject       = str_replace( '{' . $key . '}', $val, $subject );
			}
			//change nl to br
			$email_content = wpautop( stripslashes( $email_content ) );
			$email_content = apply_filters( 'wd_notification_email_content_after', $email_content, $model );

			$email_template = $this->render( 'email_template', array(
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
		<table width="100%" style="text-align: left;border-collapse: collapse">
			<thead>
			<tr style="border-bottom: 1px solid #EEEEEE">
				<th style="padding:7px 0"><?php _e( "File", wp_defender()->domain ) ?></th>
				<th style="padding:7px 0"><?php _e( "Issue", wp_defender()->domain ) ?></th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ( $model->get_results() as $item ): ?>
				<tr style="border-bottom: 1px solid #EEEEEE">
					<td style="padding:7px 0" width="40%" class="file-path">
						<strong><?php echo $item->get_name() ?></strong>
						<span><?php echo $item->get_sub() ?></span>
					</td>
					<td style="padding:7px 0" width="45%"><?php echo $item->get_detail() ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		<?php
		return ob_get_clean();
	}
}