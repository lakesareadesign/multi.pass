<div class="wrap">
	<div class="wpmud">
		<div class="wp-defender" id="container">
			<section id="header">
				<h1 class="tl"><?php esc_html_e( "IP Lockouts", wp_defender()->domain ) ?></h1>
			</section>
			<?php if ( isset( $errors ) && count( $errors ) ): ?>
				<div class="well well-error well-medium intro">
					<?php echo implode( '<br/>', $errors ) ?>
				</div>
			<?php endif; ?>
			<?php if ( $controller->has_flash( 'success' ) ): ?>
				<div class="well well-success well-medium intro">
					<?php echo $controller->get_flash( 'success' ) ?>
				</div>
			<?php endif; ?>
			<?php if ( $controller->has_flash( 'warning' ) ): ?>
				<div class="well well-yellow well-medium intro">
					<?php echo $controller->get_flash( 'warning' ) ?>
				</div>
			<?php endif; ?>
			<?php $settings = new \WP_Defender\IP_Lockout\Model\Settings_Model(); ?>
			<div class="dev-box summary ip-lockout">
				<div class="box-content">
					<div class="is-hidden-touch">
						<div class="columns">
							<div class="column is-3 is-offset-3">
								<h1 class="no-margin tl big-statistic">
									<?php if ( $settings->login_protection == false && $settings->detect_404 == false ): ?>
										&ndash;
									<?php else: ?>
										<?php echo count( \WP_Defender\IP_Lockout\Component\Login_Protection_Api::get_all_lockouts( '-24 hours' ) ) ?>
									<?php endif; ?>
								</h1>
								<p class="tl intro"><?php _e( "Lockouts in the past 24 hours", wp_defender()->domain ) ?></p>
								<h3 class="tl no-margin">
									<?php if ( $settings->login_protection == false && $settings->detect_404 == false ): ?>
										&ndash;
									<?php else: ?>
										<?php echo count( \WP_Defender\IP_Lockout\Component\Login_Protection_Api::get_all_lockouts( 'midnight first day of this month' ) ) ?>
									<?php endif; ?>
								</h3>
								<p class="tl"><?php _e( "Lockouts this month", wp_defender()->domain ) ?></p>
							</div>
							<div class="column is-5 is-offset-1">
								<div>
									<h4><?php _e( "LAST LOCKOUT", wp_defender()->domain ) ?></h4>
									<h4 class="float-r lowercase statistic no-margin">
										<?php
										$model = \WP_Defender\IP_Lockout\Component\Login_Protection_Api::get_last_lockout();
										if ( is_object( $model ) ) {
											$last_lockout_text = get_date_from_gmt( date( 'Y-m-d H:i:s', $model->date ), \WD_Utils::get_date_time_format() );
											echo ucfirst( $last_lockout_text );
										} else {
											esc_html_e( "Never", wp_defender()->domain );
										}
										?>
									</h4>
								</div>
								<div>
									<h4><?php _e( "LOGIN LOCKOUTS THIS WEEK", wp_defender()->domain ) ?></h4>
									<h4 class="float-r statistic no-margin">
										<?php
										if ( $settings->login_protection == false ) {
											echo '&ndash;';
										} else {
											echo count( \WP_Defender\IP_Lockout\Component\Login_Protection_Api::get_login_lockouts( 'monday this week' ) );
										}
										?>
									</h4>
								</div>
								<div>
									<h4><?php _e( "404 LOCKOUTS THIS WEEK", wp_defender()->domain ) ?></h4>
									<h4 class="float-r statistic no-margin">
										<?php
										if ( $settings->detect_404 == false ) {
											echo '&ndash;';
										} else {
											echo count( \WP_Defender\IP_Lockout\Component\Login_Protection_Api::get_404_lockouts( 'monday this week' ) );
										}
										?>
									</h4>
								</div>
							</div>
						</div>
					</div>
					<div class="is-hidden-desktop">
						<div class="columns">
							<div class="column is-5">
								<h1 class="no-margin tl big-statistic">
									<?php if ( $settings->login_protection == false && $settings->detect_404 == false ): ?>
										&ndash;
									<?php else: ?>
										<?php echo count( \WP_Defender\IP_Lockout\Component\Login_Protection_Api::get_all_lockouts( 'midnight yesterday' ) ) ?>
									<?php endif; ?>
								</h1>
								<p class="tl intro"><?php _e( "Lockouts in the past 24 hours", wp_defender()->domain ) ?></p>
								<h3 class="tl no-margin">
									<?php if ( $settings->login_protection == false && $settings->detect_404 == false ): ?>
										&ndash;
									<?php else: ?>
										<?php echo count( \WP_Defender\IP_Lockout\Component\Login_Protection_Api::get_all_lockouts( 'midnight first day of this month' ) ) ?>
									<?php endif; ?>
								</h3>
								<p class="tl"><?php _e( "Lockouts this month", wp_defender()->domain ) ?></p>
							</div>
							<div class="column is-7">
								<div>
									<h4><?php _e( "LAST LOCKOUT", wp_defender()->domain ) ?></h4>
									<h4 class="float-r statistic no-margin">
										<?php
										$model = \WP_Defender\IP_Lockout\Component\Login_Protection_Api::get_last_lockout();
										if ( is_object( $model ) ) {
											echo get_date_from_gmt( date( 'Y-m-d H:i:s', $model->date ), \WD_Utils::get_date_time_format() );
										} else {
											esc_html_e( "Never", wp_defender()->domain );
										}
										?>
									</h4>
								</div>
								<div>
									<h4><?php _e( "LOGIN LOCKOUTS THIS WEEK", wp_defender()->domain ) ?></h4>
									<h4 class="float-r statistic no-margin">
										<?php
										if ( $settings->login_protection == false ) {
											echo '&ndash;';
										} else {
											echo count( \WP_Defender\IP_Lockout\Component\Login_Protection_Api::get_login_lockouts( 'monday this week' ) );
										}
										?>
									</h4>
								</div>
								<div>
									<h4><?php _e( "404 LOCKOUTS THIS WEEK", wp_defender()->domain ) ?></h4>
									<h4 class="float-r statistic no-margin">
										<?php
										if ( $settings->detect_404 == false ) {
											echo '&ndash;';
										} else {
											echo count( \WP_Defender\IP_Lockout\Component\Login_Protection_Api::get_404_lockouts( 'monday this week' ) );
										}
										?>
									</h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="columns ip-lockout is-desktop">
				<div class="column is-one-quarter-desktop def-nav">
					<div class="is-hidden-desktop is-hidden-widescreen">
						<select class="def-mobile-nav">
							<option <?php selected( null, WD_Utils::http_get( 'view', null ) ) ?>
								value="<?php echo network_admin_url( 'admin.php?page=wdf-ip-lockout' ) ?>"><?php _e( "Login Protection", wp_defender()->domain ) ?></option>
							<option <?php selected( '404', WD_Utils::http_get( 'view', null ) ) ?>
								value="<?php echo network_admin_url( 'admin.php?page=wdf-ip-lockout&view=404' ) ?>"><?php _e( "404 Detection", wp_defender()->domain ) ?></option>
							<option <?php selected( 'blacklist', WD_Utils::http_get( 'view', null ) ) ?>
								value="<?php echo network_admin_url( 'admin.php?page=wdf-ip-lockout&view=blacklist' ) ?>"><?php _e( "IP Blacklist", wp_defender()->domain ) ?></option>
							<option <?php selected( 'logs', WD_Utils::http_get( 'view', null ) ) ?>
								value="<?php echo network_admin_url( 'admin.php?page=wdf-ip-lockout&view=logs' ) ?>"><?php _e( "Logs", wp_defender()->domain ) ?></option>
							<option <?php selected( 'notification', WD_Utils::http_get( 'view', null ) ) ?>
								value="<?php echo network_admin_url( 'admin.php?page=wdf-ip-lockout&view=notification' ) ?>"><?php _e( "Notifications", wp_defender()->domain ) ?></option>
							<option <?php selected( 'reporting', WD_Utils::http_get( 'view', null ) ) ?>
								value="<?php echo network_admin_url( 'admin.php?page=wdf-ip-lockout&view=reporting' ) ?>"><?php _e( "Reporting", wp_defender()->domain ) ?></option>
						</select>
					</div>
					<div class="is-hidden-touch">
						<ul>
							<li><a class="<?php echo WD_Utils::http_get( 'view', null ) == null ? 'active' : null ?>"
							       href="<?php echo network_admin_url( 'admin.php?page=wdf-ip-lockout' ) ?>">
									<?php _e( "Login Protection", wp_defender()->domain ) ?>
								</a></li>
							<li><a class="<?php echo WD_Utils::http_get( 'view', null ) == '404' ? 'active' : null ?>"
							       href="<?php echo network_admin_url( 'admin.php?page=wdf-ip-lockout&view=404' ) ?>">
									<?php _e( "404 Detection", wp_defender()->domain ) ?>
								</a></li>
							<li>
								<a class="<?php echo WD_Utils::http_get( 'view', null ) == 'blacklist' ? 'active' : null ?>"
								   href="<?php echo network_admin_url( 'admin.php?page=wdf-ip-lockout&view=blacklist' ) ?>">
									<?php _e( "IP Blacklist", wp_defender()->domain ) ?>
								</a>
							</li>
							<li><a class="<?php echo WD_Utils::http_get( 'view', null ) == 'logs' ? 'active' : null ?>"
							       href="<?php echo network_admin_url( 'admin.php?page=wdf-ip-lockout&view=logs' ) ?>">
									<?php _e( "Logs", wp_defender()->domain ) ?>
								</a></li>
							<li>
								<a class="<?php echo WD_Utils::http_get( 'view', null ) == 'notification' ? 'active' : null ?>"
								   href="<?php echo network_admin_url( 'admin.php?page=wdf-ip-lockout&view=notification' ) ?>">
									<?php _e( "Notifications", wp_defender()->domain ) ?>
								</a>
							</li>
							<li>
								<a class="<?php echo WD_Utils::http_get( 'view', null ) == 'reporting' ? 'active' : null ?>"
								   href="<?php echo network_admin_url( 'admin.php?page=wdf-ip-lockout&view=reporting' ) ?>">
									<?php _e( "Reporting", wp_defender()->domain ) ?>
								</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="column">
					{{contents}}
				</div>
			</div>
		</div>
	</div>
</div>