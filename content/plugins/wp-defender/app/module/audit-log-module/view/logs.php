<div class="wrap">
	<div class="wpmud">
		<div class="wp-defender">
			<div class="wd-audit-logging">
				<section id="header">
					<h1 class="tl"><?php _e( "Audit Logging", wp_defender()->domain ) ?></h1>
				</section>

				<div class="dev-box">
					<div class="box-title">
						<h3><?php _e( "Audit Log", wp_defender()->domain ) ?>
							<?php
							if ( WD_Utils::get_setting( 'audit_log->enabled', 0 ) == 0 ) {
								$tooltip = __( "Enable Audit Logging", wp_defender()->domain );
							} else {
								$tooltip = __( "Deactivate Audit Logging", wp_defender()->domain );
							}
							?>
							<a href="#setup-email-report" class="button button-small button-grey">
								<?php _e( "Configure Report", wp_defender()->domain ) ?></a>
							<span
								tooltip="<?php echo $tooltip ?>"
								class="toggle float-r">
									<input type="checkbox" class="toggle-checkbox"
									       id="toggle_audit_log" <?php checked( 1, WD_Utils::get_setting( 'audit_log->enabled' ) ) ?>/>
									<label class="toggle-label" for="toggle_audit_log"></label>
								</span>

							<form method="post" class="wd_audit_status_toggle">
								<?php wp_nonce_field( 'wd_toggle_audit_log', 'wd_audit_nonce' ) ?>
								<input type="hidden" name="action" value="wd_toggle_audit_log">
							</form>
						</h3>
					</div>
					<div class="box-content">
						<?php
						$table = new WD_Audit_Table();
						$table->display_tablenav( 'top' ); ?>
						<div id="audit-table-content">
							<i class="wdv-icon wdv-icon-fw wdv-icon-refresh spin"></i> <?php _e( "Loading events...", wp_defender()->domain ) ?>
						</div>
					</div>
				</div>
				<div id="audit-table-nav">

				</div>
				<section id="setup-email-report" class="dev-box setup-email-report">
					<div class="box-title">
						<h3><?php _e( "Automatic Report", wp_defender()->domain ) ?>
							<?php
							if ( WD_Utils::get_setting( 'audit_log->report_email', false ) == false ) {
								$tooltip = __( "Activate Email Report", wp_defender()->domain );
							} else {
								$tooltip = __( "Deactivate Email Report", wp_defender()->domain );
							}
							?>
							<span
								tooltip="<?php echo $tooltip ?>"
								class="toggle float-r">
									<input type="checkbox" class="toggle-checkbox"
									       id="toggle_audit_email_report" <?php checked( 1, WD_Utils::get_setting( 'audit_log->report_email' ) ) ?>/>
									<label class="toggle-label" for="toggle_audit_email_report"></label>
								</span>

							<form method="post" class="setup-email-report-form">
								<input type="hidden" name="action" value="wd_audit_email_report">
								<?php wp_nonce_field( 'wd_audit_email_report', 'wd_audit_nonce' ) ?>
							</form>
						</h3>

					</div>
					<div class="box-content">
						<p>
							<?php _e( "Defender can automatically send an email report summarising your website events so that you can keep track of logs without having to check back here.", wp_defender()->domain ) ?>
						</p>
						<p class="wd-audit-log-information">
							<?php echo $controller->get_next_report_time_info() ?>
						</p>
						<br/>
						<div class="wd-well">
							<form method="post" class="setup-email-report-form" id="setup-email-report-form">
								<label>
									<?php _e( "Send me an email report", wp_defender()->domain ) ?>
								</label>
								<select name="frequency">
									<?php foreach ( WD_Scan_Api::get_frequently() as $key => $val ): ?>
										<option <?php selected( WD_Utils::get_setting( 'audit_log->report_email_frequent', 7 ), $key ) ?>
											value="<?php echo esc_attr( $key ) ?>">
											<?php echo esc_html( $val ) ?>
										</option>
									<?php endforeach; ?>
								</select>
								<input type="hidden" name="action" value="wd_audit_email_report">
								<?php wp_nonce_field( 'wd_audit_email_report', 'wd_audit_nonce' ) ?>

								<button class="button wd-button">
									<?php
									if ( WD_Utils::get_setting( 'audit_log->report_email' ) ) {
										_e( "Update", wp_defender()->domain );
									} else {
										_e( "Activate", wp_defender()->domain );
									}
									?>
								</button>
							</form>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
</div>