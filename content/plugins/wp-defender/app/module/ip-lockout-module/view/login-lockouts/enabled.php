<div class="dev-box">
    <form method="post" class="form">
        <div class="box-title">
            <h3>Login Protection</h3>
            <div class="side float-r">
                <div>
                                <span
                                        tooltip="<?php esc_attr_e( "Deactivate Login Protection", wp_defender()->domain ) ?>"
                                        class="toggle">
	                                <input type="hidden" name="login_protection" value="0"/>
                                <input type="checkbox" checked="checked" name="login_protection" value="1"
                                       class="toggle-checkbox"
                                       id="toggle_login_protect"/>
                                <label class="toggle-label" for="toggle_login_protect"></label>
                                </span>
                </div>
            </div>
        </div>
        <div class="box-content">
			<?php if ( ( $count = count( \WP_Defender\IP_Lockout\Component\Login_Protection_Api::get_login_lockouts( '-24 hours' ) ) ) > 0 ): ?>
                <div class="well well-yellow well-medium intro">
					<?php echo sprintf( __( "There have been %d lockouts in the last 24 hours. <a href=\"%s\"><strong>View log</strong></a>.", wp_defender()->domain ), $count, network_admin_url( 'admin.php?page=wdf-ip-lockout&view=logs' ) ) ?>
                </div>
			<?php else: ?>
                <div class="well well-blue well-medium intro">
					<?php esc_html_e( "Login protection is enabled. There are no lockouts logged yet.", wp_defender()->domain ) ?>
                </div>
			<?php endif; ?>
            <div class="columns">
                <div class="column is-one-third">
                    <label for="login_protection_login_attempt">
						<?php esc_html_e( "Lockout Threshold", wp_defender()->domain ) ?>
                    </label>
                    <span class="sub">
                        <?php esc_html_e( "Specify how many failed login attempts within a specific time period will trigger a lockout.", wp_defender()->domain ) ?>
						</span>
                </div>
                <div class="column">
                    <input size="8" value="<?php echo $settings->login_protection_login_attempt ?>" type="text"
                           class="inline" id="login_protection_login_attempt"
                           name="login_protection_login_attempt"/> <span
                            class="form-help inline"><?php esc_html_e( "failed logins within", wp_defender()->domain ) ?></span>
                    <input size="8" value="<?php echo $settings->login_protection_lockout_timeframe ?>"
                           id="login_lockout_timeframe"
                           name="login_protection_lockout_timeframe" type="text" class="inline">
                    <span class="form-help"><?php esc_html_e( "seconds", wp_defender()->domain ) ?></span>
                </div>
            </div>
            <hr/>
            <div class="columns">
                <div class="column is-one-third">
                    <label for="login_protection_lockout_timeframe">
						<?php esc_html_e( "Lockout Time", wp_defender()->domain ) ?>
                    </label>
                    <span class="sub">
                                        <?php esc_html_e( "Choose how long you’d like to ban the locked out user for.", wp_defender()->domain ) ?>
                                    </span>
                </div>
                <div class="column">
                    <input value="<?php echo $settings->login_protection_lockout_duration ?>" size="8"
                           name="login_protection_lockout_duration"
                           id="login_protection_lockout_duration" type="text" class="inline"/>
                    <span class="form-help"><?php esc_html_e( "seconds", wp_defender()->domain ) ?></span>
                    <div class="clearfix"></div>
                    <input type="hidden" name="login_protection_lockout_ban" value="0"/>
                    <input
                            id="login_protection_lockout_ban" <?php checked( 1, $settings->login_protection_lockout_ban ) ?>
                            type="checkbox"
                            name="login_protection_lockout_ban" value="1">
                    <label for="login_protection_lockout_ban"
                           class="inline form-help is-marginless"><?php esc_html_e( 'Permanently ban login lockouts.', wp_defender()->domain ) ?></label>
                </div>
            </div>
            <hr/>
            <div class="columns">
                <div class="column is-one-third">
                    <label for="login_protection_lockout_message">
						<?php esc_html_e( "Lockout message", wp_defender()->domain ) ?>
                    </label>
                    <span class="sub">
                                        <?php esc_html_e( "Customize the message locked out users will see.", wp_defender()->domain ) ?>
                                    </span>
                </div>
                <div class="column">
						<textarea name="login_protection_lockout_message"
                                  id="login_protection_lockout_message"><?php echo $settings->login_protection_lockout_message ?></textarea>
                    <span class="form-help">
                                        <?php echo sprintf( __( "This message will be displayed across your website during the lockout period. See a quick preview <a href=\"%s\">here</a>.", wp_defender()->domain ), add_query_arg( array(
	                                        'def-lockout-demo' => 1,
	                                        'type'             => 'login'
                                        ), network_site_url() ) ) ?>
                                    </span>
                </div>
            </div>
            <hr/>
            <div class="columns">
                <div class="column is-one-third">
                    <label for="login_protection_ban_admin_brute">
						<?php esc_html_e( "Ban admin user logins", wp_defender()->domain ) ?>
                    </label>
                    <span class="sub">
                                        <?php esc_html_e( "Choose whether you want to instantly ban users who log in with the admin username.", wp_defender()->domain ) ?>
                                    </span>
                </div>
                <div class="column">
                    <input type="hidden" name="login_protection_ban_admin_brute" value="0"/>
                    <input <?php checked( '1', $settings->login_protection_ban_admin_brute ) ?>
                            name="login_protection_ban_admin_brute" id="login_protection_ban_admin_brute"
                            type="checkbox" value="1"/>
                    <label for="login_protection_ban_admin_brute" class="form-help inline is-marginless">
						<?php esc_html_e( "Automatically ban IPs that attempt to login with the admin username.", wp_defender()->domain ) ?>
                    </label>
                </div>
            </div>
            <hr/>
            <input type="hidden" name="scenario" value="login_protect"/>
			<?php wp_nonce_field( 'save_lockout_settings', '_wdnonce' ) ?>
            <button type="reset" class="button button-secondary">
				<?php esc_html_e( "Cancel", wp_defender()->domain ) ?></button>
            <button type="submit" class="button button-primary float-r">
				<?php esc_html_e( "UPDATE SETTINGS", wp_defender()->domain ) ?>
            </button>
        </div>
    </form>
</div>