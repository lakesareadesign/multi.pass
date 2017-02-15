<div class="dev-box">
	<div class="box-title">
		<h3><?php esc_html_e( "NOTIFICATIONS", wp_defender()->domain ) ?></h3>
	</div>
	<div class="box-content">
		<form method="post" class="form">
			<div class="columns">
				<div class="column is-one-third">
					<label>
						<?php esc_html_e( "Send email notifications", wp_defender()->domain ) ?>
					</label>
					<span class="sub">
                        <?php esc_html_e( "Choose which lockout notifications you wish to be notified about. These are sent instantly.", wp_defender()->domain ) ?>
					</span>
				</div>
				<div class="column">
					<div class="intro toggle-container">
                                        <span
	                                        tooltip="<?php echo esc_attr( __( "Enable Login Protection", wp_defender()->domain ) ) ?>"
	                                        class="toggle float-l">
	                                        <input type="hidden" name="login_lockout_notification" value="0"/>
                                <input type="checkbox"
                                       name="login_lockout_notification" <?php checked( 1, $settings->login_lockout_notification ) ?>
                                       value="1" class="toggle-checkbox"
                                       id="toggle_login_protection"/>
                                <label class="toggle-label" for="toggle_login_protection"></label>
                                </span>
						<span class="form-help float-l">
							<?php esc_html_e( "Login Protection Lockout", wp_defender()->domain ) ?>
							<span>
								<?php esc_html_e( "When a user or IP is locked out for trying to access your login area.", wp_defender()->domain ) ?>
							</span>
						</span>
						<div class="clearfix"></div>
					</div>
					<div class="toggle-container">
                                    <span
	                                    tooltip="<?php echo esc_attr( __( "Enable 404 Detection", wp_defender()->domain ) ) ?>"
	                                    class="toggle float-l">
	                                    <input type="hidden" name="ip_lockout_notification" value="0"/>
                                <input type="checkbox" name="ip_lockout_notification"
                                       value="1" <?php checked( 1, $settings->ip_lockout_notification ) ?>
                                       class="toggle-checkbox"
                                       id="toggle_404_detection"/>
                                <label class="toggle-label" for="toggle_404_detection"></label>
                                </span>
						<span class="form-help float-l">
							<?php esc_html_e( "404 Detection Lockout", wp_defender()->domain ) ?>
							<span>
								<?php esc_html_e( "When a user or IP is locked out for repeated hits on non-existent files.", wp_defender()->domain ) ?>
							</span>
						</span>
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
						<?php esc_html_e( "Choose which of your website's users will receive scan report results via email.", wp_defender()->domain ) ?>
					</span>
				</div>
				<div class="column">
					<?php $email_search->render() ?>
				</div>
			</div>
			<hr/>
			<input type="hidden" name="scenario" value="notification"/>
			<?php wp_nonce_field( 'save_lockout_settings', '_wdnonce' ) ?>
			<button type="reset" class="button button-secondary">
				<?php esc_html_e( "Cancel", wp_defender()->domain ) ?></button>
			<button type="submit" class="button button-primary float-r">
				<?php esc_html_e( "UPDATE SETTINGS", wp_defender()->domain ) ?>
			</button>
		</form>
	</div>
</div>