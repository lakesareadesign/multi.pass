<div class="dev-box">
	<div class="box-title">
		<h3><?php esc_html_e( "Reporting", wp_defender()->domain ) ?></h3>
	</div>
	<div class="box-content">
		<form method="post" class="form">
			<div class="columns">
				<div class="column is-one-third">
					<label>
						<?php esc_html_e( "Lockouts report", wp_defender()->domain ) ?>
					</label>
					<span class="sub">
                        <?php esc_html_e( "Configure Defender to automatically email you a lockout report for this website. ", wp_defender()->domain ) ?>
					</span>
				</div>
				<div class="column">
					<div class="intro toggle-container">
                                        <span
	                                        tooltip="<?php echo esc_attr( __( "Send regular email report", wp_defender()->domain ) ) ?>"
	                                        class="toggle float-l">
	                                        <input type="hidden" name="report" value="0"/>
                                <input type="checkbox"
                                       name="report" <?php checked( 1, $settings->report ) ?>
                                       value="1" class="toggle-checkbox"
                                       id="toggle_report"/>
                                <label class="toggle-label" for="toggle_report"></label>
                                </span>
						<span class="float-l">
							<?php esc_html_e( "Send regular email report", wp_defender()->domain ) ?>
						</span>
						<div class="clearfix"></div>
					</div>
					<div class="well well-medium schedule-box">
						<h3><?php esc_html_e( "SCHEDULE", wp_defender()->domain ) ?></h3>
						<div class="columns">
							<div class="column is-one-quarter tr">
								<label><?php esc_html_e( "Frequency", wp_defender()->domain ) ?></label>
							</div>
							<div class="column">
								<select name="report_frequency">
									<option <?php selected( 'daily', $settings->report_frequency ) ?>
										value="daily"><?php esc_html_e( "Daily", wp_defender()->domain ) ?></option>
									<option <?php selected( 'weekly', $settings->report_frequency ) ?>
										value="weekly"><?php esc_html_e( "Weekly", wp_defender()->domain ) ?></option>
									<option <?php selected( 'monthly', $settings->report_frequency ) ?>
										value="monthly"><?php esc_html_e( "Monthly", wp_defender()->domain ) ?></option>
								</select>
							</div>
						</div>
						<div class="columns days-of-week">
							<div class="column is-one-quarter tr">
								<label><?php esc_html_e( "Day of the week", wp_defender()->domain ) ?></label>
							</div>
							<div class="column">
								<select name="report_day">
									<?php foreach ( WD_Scan_Api::get_days_of_week() as $day ): ?>
										<option <?php selected( $settings->report_day, strtolower($day) ) ?>
											value="<?php echo strtolower( $day ) ?>"><?php echo $day ?></option>
									<?php endforeach;; ?>
								</select>
							</div>
						</div>
						<div class="columns">
							<div class="column is-one-quarter tr">
								<label><?php esc_html_e( "Time of day", wp_defender()->domain ) ?></label>
							</div>
							<div class="column">
								<select name="report_time">
									<?php foreach ( WD_Scan_Api::get_times() as $timestamp => $time ): ?>
										<option <?php selected( $settings->report_time, $timestamp ) ?>
											name="<?php echo $timestamp ?>"><?php echo $time ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<span><?php printf( esc_html__( "You will receive a lockout report email %s.", wp_defender()->domain ), date_i18n( WD_Utils::get_date_time_format(), \WP_Defender\IP_Lockout\Component\Login_Protection_Api::get_report_sending_time() ) ) ?></span>
					</div>
				</div>
			</div>
			<hr/>
			<div class="columns">
				<div class="column is-one-third">
					<label>
						<?php esc_html_e( "Email recipients", wp_defender()->domain ) ?>
					</label>
					<span class="sub">
						<?php esc_html_e( "Choose which of your website’s users will receive the lockout report.", wp_defender()->domain ) ?>
					</span>
				</div>
				<div class="column">
					<?php $email_search->render() ?>
				</div>
			</div>
			<hr/>
			<input type="hidden" name="scenario" value="reporting"/>
			<?php wp_nonce_field( 'save_lockout_settings', '_wdnonce' ) ?>
			<button type="reset" class="button button-secondary">
				<?php esc_html_e( "Cancel", wp_defender()->domain ) ?></button>
			<button type="submit" class="button button-primary float-r">
				<?php esc_html_e( "UPDATE SETTINGS", wp_defender()->domain ) ?>
			</button>
		</form>
	</div>
</div>