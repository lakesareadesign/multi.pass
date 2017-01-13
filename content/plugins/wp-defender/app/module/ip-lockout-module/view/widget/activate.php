<section class="dev-box">
	<div class="box-title">
		<h3><?php esc_html_e( "IP LOCKOUTS", wp_defender()->domain ) ?>
			<a class="button button-light button-small wd-button-widget float-r"
			   href="<?php echo network_admin_url( 'admin.php?page=wdf-ip-lockout' ) ?>"><?php esc_html_e( "Configure", wp_defender()->domain ) ?></a>
		</h3>
	</div>
	<div class="box-content">
		<p><?php _e( "Protect to your login area and have Defender automatically lockout any suspicious behaviour.", wp_defender()->domain ) ?></p>
		<table width="100%">
			<tbody>
			<tr>
				<td width="40%" class="wd-no-padding">
					<p><span class="medium-dark"><?php _e( "LAST LOCKOUT", wp_defender()->domain ) ?></span></p>
				</td>
				<td width="60%" class="wd-no-padding">
					<p class="tr">
						<span class="lockout-widget-stats">
							<?php
							$model = \WP_Defender\IP_Lockout\Component\Login_Protection_Api::get_last_lockout();
							if ( is_object( $model ) ) {
								$last_lockout_text = get_date_from_gmt( date( 'Y-m-d H:i:s', $model->date ), \WD_Utils::get_date_time_format() );
								echo ucfirst( $last_lockout_text );
							} else {
								_e( "Never", wp_defender()->domain );
							}
							?>
						</span>
					</p>
				</td>
			</tr>
			<tr>
				<td width="40%" class="wd-no-padding">
					<p><span class="medium-dark"><?php _e( "LOGIN LOCKOUTS THIS WEEK", wp_defender()->domain ) ?></span>
					</p>
				</td>
				<td width="60%" class="wd-no-padding">
					<p class="tr">
						<span class="lockout-widget-stats">
							<?php
							$settings = new \WP_Defender\IP_Lockout\Model\Settings_Model();
							if ( $settings->login_protection == false ) {
								?>
								<a href="#" data-type="login" class="button button-small wd-button toggle-ip-protect">
									<?php _e( "Activate", wp_defender()->domain ) ?>
								</a>
								<?php
							} else {
								echo count( \WP_Defender\IP_Lockout\Component\Login_Protection_Api::get_login_lockouts( 'monday this week' ) );
							}
							?>
						</span>
					</p>
				</td>
			</tr>
			<tr>
				<td width="40%" class="wd-no-padding">
					<p><span class="medium-dark"><?php _e( "404 LOCKOUTS THIS WEEK", wp_defender()->domain ) ?></span>
					</p>
				</td>
				<td width="60%" class="wd-no-padding">
					<p class="tr">
						<span class="lockout-widget-stats">
						<?php
						if ( $settings->detect_404 == false ) {
							?>
							<a href="#" data-type="404" class="button button-small wd-button toggle-ip-protect">
									<?php _e( "Activate", wp_defender()->domain ) ?>
								</a>
							<?php
						} else {
							echo count( \WP_Defender\IP_Lockout\Component\Login_Protection_Api::get_404_lockouts( 'monday this week' ) );
						}
						?>
					</span>
					</p>
				</td>
			</tr>
			</tbody>
		</table>
	</div>
</section>