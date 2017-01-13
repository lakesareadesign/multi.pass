<div class="dev-box">
	<div class="box-title">
		<h3><?php _e( "IP Blacklist", wp_defender()->domain ) ?></h3>
	</div>
	<div class="box-content">
		<form method="post" class="form">
			<p class="intro">
				<?php _e( "Choose which IP addresses you wish to permanently ban from accessing your website.", wp_defender()->domain ) ?>
			</p>
			<hr/>
			<div class="columns">
				<div class="column is-one-third">
					<label for="ip_blacklist">
						<?php _e( "Blacklist", wp_defender()->domain ) ?>
					</label>
					<span class="sub">
						<?php _e( "Any IPs addresses you list here will be completely blocked from accessing your website, including admins.", wp_defender()->domain ) ?>
					</span>
				</div>
				<div class="column">
					<textarea name="ip_blacklist" id="ip_blacklist"
					          rows="8"><?php echo $settings->ip_blacklist ?></textarea>
					<span class="form-help">
						<?php _e( "One IP address per line and IPv4 format only.", wp_defender()->domain ) ?>
					</span>
				</div>
			</div>
			<hr/>
			<div class="columns">
				<div class="column is-one-third">
					<label for="detect_404_lockout_message">
						<?php esc_html_e( "Lockout message", wp_defender()->domain ) ?>
					</label>
					<span class="sub">
                                        <?php esc_html_e( "Customize the message locked out users will see.", wp_defender()->domain ) ?>
                                    </span>
				</div>
				<div class="column">
						<textarea name="ip_lockout_message"
						          id="ip_lockout_message"><?php echo $settings->ip_lockout_message ?></textarea>
					<span class="form-help">
                                         <?php echo sprintf( __( "This message will be displayed across your website for any IP matching your blacklist. See a quick preview <a href=\"%s\">here</a>.", wp_defender()->domain ), add_query_arg( array(
	                                         'def-lockout-demo' => 1,
	                                         'type'             => 'blacklist'
                                         ), network_site_url() ) ) ?>
                                    </span>
				</div>
			</div>
			<hr/>
			<div class="columns">
				<div class="column is-one-third">
					<label for="ip_whitelist">
						<?php _e( "Whitelist", wp_defender()->domain ) ?>
					</label>
					<span class="sub">
						<?php _e( "Any IPs you list here will be exempt from the rules defined in Login Project or 404 Detection.", wp_defender()->domain ) ?>
					</span>
				</div>
				<div class="column">
					<textarea name="ip_whitelist" id="ip_whitelist"
					          rows="8"><?php echo $settings->ip_whitelist ?></textarea>
					<span class="form-help">
						<?php _e( "One IP address per line and IPv4 format only.", wp_defender()->domain ) ?>
					</span>
				</div>
			</div>
			<hr/>
			<input type="hidden" name="scenario" value="blacklist"/>
			<?php wp_nonce_field( 'save_lockout_settings', '_wdnonce' ) ?>
			<button type="reset" class="button button-secondary">
				<?php esc_html_e( "Cancel", wp_defender()->domain ) ?></button>
			<button type="submit" class="button button-primary float-r">
				<?php esc_html_e( "UPDATE SETTINGS", wp_defender()->domain ) ?>
			</button>
		</form>
	</div>
</div>