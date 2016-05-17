<div class="wrap">
	<div class="wpmud">
		<div class="wp-defender">
			<h2 class="tl wd-title"><?php _e( "Dashboard", wp_defender()->domain ) ?></h2>

			<div class="wd-dashboard">
				<section class="dev-box wd-dashboard-intro">
					<div class="box-title">
						<h3><?php printf( __( "Welcome, %s!", wp_defender()->domain ), WD_Utils::get_display_name() ) ?>
							<a href="#" class="wd-hide-dashboard-intro float-r">
								<i class="dev-icon dev-icon-cross"></i>
							</a>
						</h3>
					</div>
					<div class="box-content">
						<div class="group">
							<div class="col span_8_of_12 float-r">
								<h2 class="tl"><?php _e( "Oh yeah, it's about to go down!", wp_defender()->domain ) ?></h2>

								<p>
									<?php printf( __( "Congratulations, %s! You've just installed the most advanced and easy-to-use WordPress security plugin that will defend you against evil bots, hackers and bad internet-y things. With Defender you can tighten up loopholes in your WordPress security, scan for malicious code, vulnerabilities, and corrupt files as well as set up automatic scans of your site.", wp_defender()->domain ), WD_Utils::get_display_name() ) ?>
								</p>

								<p>
									<?php printf( __( "Get fixing %s!", wp_defender()->domain ), WD_Utils::get_display_name() ) ?>
								</p>
							</div>
							<div class="wd-clearfix"></div>
						</div>
					</div>
				</section>
				<div class="group wd-no-margin">
					<div class="col span_6_of_12 wd-no-padding">
						<?php
						///hardener widget
						$widget = WD_Widget_Manager::get_instance()->display( 'WD_Hardener_Widget' );
						//blacklist widget
						$widget = WD_Widget_Manager::get_instance()->display( 'WD_Blacklist_Widget' );
						//backup
						$widget = WD_Widget_Manager::get_instance()->display( 'WD_Backup_Widget' );
						?>
						<section class="dev-box setup-scan">
							<div class="box-title">
								<h3><?php _e( "Setup Automatic Scans", wp_defender()->domain ) ?>
									<?php
									if ( WD_Utils::get_setting( 'scan->auto_scan', false ) == false ) {
										$tooltip = __( "Activate Automatic Scans", wp_defender()->domain );
									} else {
										$tooltip = __( "Deactivate Automatic Scans", wp_defender()->domain );
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
									<?php _e( "We recommend setting up WP Defender to automatically and regularly scan your website and email you reports. You can choose the frequency and time of day depending on your website traffic patterns.", wp_defender()->domain ) ?>
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
											<?php _e( "Scan my website", wp_defender()->domain ) ?>
										</label>
										<div class="wd-clearfix"></div>
										<select name="frequency">
											<?php foreach ( WD_Scan_Api::get_frequently() as $key => $val ): ?>
												<option <?php selected( $frequency, $key ) ?>
													value="<?php echo esc_attr( $key ) ?>">
													<?php echo esc_html( $val ) ?>
												</option>
											<?php endforeach; ?>
										</select>

										<div class="day-container">

											<select name="day">
												<?php foreach ( WD_Scan_Api::get_days_of_week() as $val ): ?>
													<option <?php selected( $day, strtolower( $val ) ) ?>
														value="<?php echo strtolower( esc_attr( $val ) ) ?>">
														<?php echo esc_html( $val ) ?>
													</option>
												<?php endforeach; ?>
											</select>
										</div>
										<div class="time-container wd-inline">
											<select name="time">
												<?php foreach ( WD_Scan_Api::get_times() as $key => $val ): ?>
													<option <?php echo selected( $time, $key ) ?>
														value="<?php echo esc_attr( $key ) ?>">
														<?php echo esc_html( strftime( '%I:%M %p', strtotime( $val ) ) ) ?>
													</option>
												<?php endforeach; ?>
											</select>
										</div>
										<div class="wd-clearfix"></div>
										<input type="hidden" name="action" value="wd_schedule_scan">
										<?php wp_nonce_field( 'wd_schedule_scan', 'wd_scan_nonce' ) ?>

										<button class="button wd-button">
											<?php
											if ( WD_Utils::get_setting( 'scan->auto_scan' ) ) {
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
					<div class="col span_6_of_12 wd-no-padding float-r">
						<?php $widget = WD_Widget_Manager::get_instance()->display( 'WD_Scan_Widget' ); ?>
						<section class="dev-box">
							<div class="box-title">
								<h3><?php _e( "Audit Logging", wp_defender()->domain ) ?></h3>
							</div>
							<div class="box-content tc">
								<img width="200px"
								     src="<?php echo wp_defender()->get_plugin_url() ?>assets/img/dev-man-log.png"/>

								<h2><?php _e( "Coming Soon", wp_defender()->domain ) ?></h2>

								<p>
									<?php
									_e( "We are working on an audit log feature that will track all interactions with your website and store them securely in the cloud. That way, you'll always know who did what on your site and hackers or malware can't cover their tracks. We'll keep you posted!", wp_defender()->domain )
									?>
								</p>
							</div>
						</section>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	jQuery(function ($) {
		if (readCookie('wd-hide-dashboard-intro') == 1) {
			$('.wd-dashboard-intro').hide();
		}

		$('.wd-hide-dashboard-intro').click(function () {
			createCookie('wd-hide-dashboard-intro', '1', 365);
			$('.wd-dashboard-intro').fadeOut(1000);
		})
		function createCookie(name, value, days) {
			if (days) {
				var date = new Date();
				date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
				var expires = "; expires=" + date.toGMTString();
			}
			else var expires = "";
			document.cookie = name + "=" + value + expires + "; path=/";
		}

		function readCookie(name) {
			var nameEQ = name + "=";
			var ca = document.cookie.split(';');
			for (var i = 0; i < ca.length; i++) {
				var c = ca[i];
				while (c.charAt(0) == ' ') c = c.substring(1, c.length);
				if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
			}
			return null;
		}

		function eraseCookie(name) {
			createCookie(name, "", -1);
		}
	})
</script>