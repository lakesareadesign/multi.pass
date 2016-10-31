<div class="wrap">
	<div class="wpmud">
		<div class="wp-defender">
			<div class="wd-settings">
				<section id="header">
					<h1 class="tl"><?php esc_html_e( "Setup Automatic Scans", wp_defender()->domain ) ?></h1>
				</section>
				<section class="dev-box setup-scan">
					<div class="box-title">
						<h3><?php esc_html_e( "Setup Automatic Scans", wp_defender()->domain ) ?>
							<?php
							if ( WD_Utils::get_setting( 'scan->auto_scan', false ) == false ) {
								$tooltip = esc_html__( "Activate Automatic Scans", wp_defender()->domain );
							} else {
								$tooltip = esc_html__( "Deactivate Automatic Scans", wp_defender()->domain );
							}
							?>
							<span
								tooltip="<?php echo $tooltip ?>"
								class="toggle float-r">
									<input type="checkbox" class="toggle-checkbox"
									       id="toggle_auto_scan" <?php checked( 1, WD_Utils::get_setting( 'scan->auto_scan' ) ) ?>/>
									<label class="toggle-label" for="toggle_auto_scan"></label>
								</span>

							<form method="post" id="toggle_auto_scan_frm">
								<input type="hidden" name="action" value="wd_toggle_auto_scan">
								<?php wp_nonce_field( 'wd_toggle_auto_scan', 'wd_scan_nonce' ) ?>
							</form>
						</h3>

					</div>
					<div class="box-content">
						<div class="update-notice ok wd-hide">
							<a href="#" class="wd-dismiss">
								<i class="dev-icon dev-icon-cross"></i>
							</a>
						</div>
						<p>
							<?php esc_html_e( "We recommend setting up WP Defender to automatically and regularly scan your website and email you reports. You can choose the frequency and time of day depending on your website traffic patterns.", wp_defender()->domain ) ?>
						</p>

						<div class="next-run-information">
							<?php
							echo WD_Scan_Api::next_run_information();
							?>
						</div>
						<br/>

						<div class="wd-well">
							<form method="post" id="setup-scan-form">
								<label>
									<?php esc_html_e( "Scan my website", wp_defender()->domain ) ?>
								</label>
								<select name="frequency">
									<?php foreach ( $controller->get_frequently() as $key => $val ): ?>
										<option <?php selected( $frequency, $key ) ?>
											value="<?php echo esc_attr( $key ) ?>">
											<?php echo esc_html( $val ) ?>
										</option>
									<?php endforeach; ?>
								</select>

								<div class="day-container">
									<label>
										<?php esc_html_e( "on", wp_defender()->domain ) ?>
									</label>
									<select name="day">
										<?php foreach ( $controller->get_days_of_week() as $val ): ?>
											<option <?php selected( $day, strtolower( $val ) ) ?>
												value="<?php echo strtolower( esc_attr( $val ) ) ?>">
												<?php echo esc_html( $val ) ?>
											</option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="time-container wd-inline">
									<label>
										<?php esc_html_e( "at", wp_defender()->domain ) ?>
									</label>
									<select name="time">
										<?php foreach ( $controller->get_times() as $key => $val ): ?>
											<option <?php echo selected( $time, $key ) ?>
												value="<?php echo esc_attr( $key ) ?>">
												<?php echo esc_html( strftime( '%I:%M %p', strtotime( $val ) ) ) ?>
											</option>
										<?php endforeach; ?>
									</select>
								</div>

								<input type="hidden" name="action" value="wd_schedule_scan">
								<?php wp_nonce_field( 'wd_schedule_scan', 'wd_scan_nonce' ) ?>

								<button class="button wd-button">
									<?php
									if ( WD_Utils::get_setting( 'scan->auto_scan' ) ) {
										esc_html_e( "Update", wp_defender()->domain );
									} else {
										esc_html_e( "Activate", wp_defender()->domain );
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