<?php // phpcs:ignore

class Snapshot_Local_Backups {
	public static $instance = null;

	const OPTION_SHOW_NOTICE = 'snapshot-local-backups-notification-pending';
	const OPTION_NOTICE_DISMISSED = 'snapshot-local-backups-notice-dismissed';
	const OPTION_EMAILS_SENT = 'snapshot-local-backups-emails-sent';
	const MANAGED_BACKUPS_QUERY_VAR = 'snapshot_pro_managed_backups';
	const HOURLY_SCHEDULED_EVENT = 'snapshot_local_backup_check';

	private function __construct() {
	}

	public static function serve() {
		self::get()->add_hooks();
	}

	public static function stop() {
		self::get()->remove_hooks();
	}

	/**
	 * @return null|Snapshot_Local_Backups
	 */
	public static function get() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function add_hooks() {
		add_action( self::HOURLY_SCHEDULED_EVENT, array( $this, 'check_for_local_backups' ) );
		add_action( is_multisite() ? 'network_admin_notices' : 'admin_notices', array(
			$this,
			'display_local_backups_warning',
		) );
		add_action( 'wp_ajax_dismiss_local_backups_notice', array(
			$this,
			'snapshot_ajax_dismiss_local_backups_notice',
		) );
		add_action( 'admin_footer', array( $this, 'print_dismiss_notice_script' ) );

		$this->schedule_event();
	}

	public function remove_hooks() {
		remove_action( self::HOURLY_SCHEDULED_EVENT, array( $this, 'check_for_local_backups' ) );
		remove_action( is_multisite() ? 'network_admin_notices' : 'admin_notices', array(
			$this,
			'display_local_backups_warning',
		) );
		remove_action( 'wp_ajax_dismiss_local_backups_notice', array(
			$this,
			'snapshot_ajax_dismiss_local_backups_notice',
		) );
		remove_action( 'admin_footer', array( $this, 'print_dismiss_notice_script' ) );

		$this->unschedule_event();
	}

	public function check_for_local_backups() {
		// Get local backups older than 12 hours
		$timestamps = $this->get_local_backup_timestamps();
		if ( empty( $timestamps ) ) {
			return;
		}

		$this->set_local_backup_notice_flag( $timestamps );
		$this->send_local_backup_email( $timestamps );
	}

	private function set_local_backup_notice_flag( $timestamps ) {
		$dismissed_timestamps = get_option( self::OPTION_NOTICE_DISMISSED, array() );
		$unhandled_timestamps = array_diff( $timestamps, $dismissed_timestamps );
		if ( empty( $unhandled_timestamps ) ) {
			return;
		}

		update_option( self::OPTION_SHOW_NOTICE, true );
	}

	private function send_local_backup_email( $timestamps ) {
		$email_sent_timestamps = get_option( self::OPTION_EMAILS_SENT, array() );
		$unhandled_timestamps = array_diff( $timestamps, $email_sent_timestamps );
		if ( empty( $unhandled_timestamps ) ) {
			return;
		}

		$user_info = $this->get_user_data();
		add_filter( 'wp_mail_content_type', array( $this, 'enable_html_emails' ) );
		wp_mail(
			$user_info->user_email,
			esc_html__( 'Snapshot -  Scheduled backup failed to upload to WPMU server', SNAPSHOT_I18N_DOMAIN ),
			$this->get_email_body( $user_info->user_login )
		);
		remove_filter( 'wp_mail_content_type', array( $this, 'enable_html_emails' ) );
		update_option( self::OPTION_EMAILS_SENT, $timestamps );
	}

	public function display_local_backups_warning() {
		// phpcs:ignore
		if ( isset( $_GET['page'] ) && self::MANAGED_BACKUPS_QUERY_VAR === $_GET['page'] ) {
			return;
		}

		if ( ! $this->show_notice() ) {
			return;
		}
		$message_text = $this->format_text(
			esc_html__( "Your backup failed to upload to WPMU server. You can't use this backup from HUB in case your server is crashed. %s to see more details.", SNAPSHOT_I18N_DOMAIN )
		);
		?>
		<div class="snapshot-notice-local-backups notice-error notice is-dismissible">
			<p><?php echo wp_kses_post( $message_text ); ?></p>
		</div>
		<?php
	}

	public function snapshot_ajax_dismiss_local_backups_notice() {
		$this->dismiss_local_backups_notice();
		die;
	}

	public function dismiss_local_backups_notice() {
		// Hide the message right away
		delete_option( self::OPTION_SHOW_NOTICE );

		// Note the timestamps
		$timestamps = $this->get_local_backup_timestamps();
		update_option( self::OPTION_NOTICE_DISMISSED, $timestamps );
	}

	private function schedule_event() {
		if ( ! wp_next_scheduled( self::HOURLY_SCHEDULED_EVENT ) ) {
			wp_schedule_event( time(), 'hourly', self::HOURLY_SCHEDULED_EVENT );
		}
	}

	private function unschedule_event() {
		wp_clear_scheduled_hook( self::HOURLY_SCHEDULED_EVENT );
	}

	public function print_dismiss_notice_script() {
		if ( ! $this->show_notice() ) {
			return;
		}

		?>
		<script type="text/javascript">
			jQuery(document).ready(function ($) {
				$(document).on('click', '.snapshot-notice-local-backups .notice-dismiss', function () {
					jQuery.ajax({
						url: ajaxurl,
						data: {
							action: 'dismiss_local_backups_notice'
						}
					})
				});
			});
		</script>
		<?php
	}

	private function get_local_backup_timestamps() {
		$local_model = new Snapshot_Model_Full_Local();
		$backups = $local_model->get_backups();
		$timestamps = array();
		if ( empty( $backups ) ) {
			return $timestamps;
		}

		foreach ( $backups as $backup ) {
			if ( ! isset( $backup['timestamp'] ) ) {
				continue;
			}

			$timestamps[] = intval( $backup['timestamp'] );
		}

		// Sort newest to oldest
		rsort( $timestamps );
		// Only care about the ones older than 12 hours
		return array_filter( $timestamps, array( $this, 'is_timestamp_12_hours_old' ) );
	}

	private function is_timestamp_12_hours_old( $timestamp ) {
		$time_difference = time() - $timestamp;
		$stale_interval = $this->get_stale_interval();
		return $time_difference / 3600 >= $stale_interval;
	}

	private function get_stale_interval() {
		return defined( 'SNAPSHOT_STALE_BACKUP_INTERVAL' )
			? intval( SNAPSHOT_STALE_BACKUP_INTERVAL )
			: 12;
	}

	private function get_user_data() {
		if ( class_exists( 'WPMUDEV_Dashboard' )
		     && isset( WPMUDEV_Dashboard::$site )
		     && is_callable( array( WPMUDEV_Dashboard::$site, 'get_option' ) )
		) {
			$profile_data = WPMUDEV_Dashboard::$site->get_option( 'profile_data' );
			$name = empty( $profile_data['profile']['name'] )
				? ''
				: $profile_data['profile']['name'];
			$email = empty( $profile_data['profile']['user_name'] )
				? ''
				: sanitize_email( $profile_data['profile']['user_name'] );

			if ( $name && $email ) {
				return (object) array(
					'user_login' => $name,
					'user_email' => $email,
				);
			}
		}

		return get_userdata( 1 );
	}

	public function enable_html_emails() {
		return "text/html";
	}

	private function get_email_body( $user ) {
		$email_body = sprintf(
			esc_html__( "Hi %1\$s\n\nSnapshot has found a local backup on your server. The backup was created but failed to upload to WPMU server. Local backups are not helpful in case your server gets compromised as they don’t appear on HUB until uploaded to WPMU server. %2\$s to open the managed backups and retry uploading the local backups to WPMU server.\n\nCheers,\nSnapshot", SNAPSHOT_I18N_DOMAIN ),
			$user, '%s'
		);
		$email_body = $this->format_text( $email_body );
		return nl2br( $email_body );
	}

	private function format_text( $text ) {
		$click_here = sprintf( '<a href="%s" target="_blank">%s</a>',
			$this->get_managed_backups_url(),
			esc_html__( 'Click here', SNAPSHOT_I18N_DOMAIN )
		);

		return sprintf( $text, $click_here );
	}

	private function get_managed_backups_url() {
		return esc_url_raw( add_query_arg( 'page', self::MANAGED_BACKUPS_QUERY_VAR, network_admin_url( 'admin.php' ) ) );
	}

	private function show_notice() {
		return get_option( self::OPTION_SHOW_NOTICE, false )
		       && current_user_can( 'manage_options' );
	}
}