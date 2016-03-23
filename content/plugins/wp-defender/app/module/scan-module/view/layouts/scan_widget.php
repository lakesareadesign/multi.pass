<div class="wd-scan">
	<section class="dev-box scan-reports scan-widget">
		<div class="box-title">
			<h3>
				<?php _e( "Scan Report", wp_defender()->domain ) ?>
				<span class="tr">
				<a class="button button-light button-small"
				   href="<?php echo network_admin_url( 'admin.php?page=wdf-settings' ) ?>"><?php _e( "Configure", wp_defender()->domain ) ?></a>
				</span>
			</h3>
		</div>
		<div class="box-content">
			<?php
			$date = $model->get_raw_post()->post_date;
			$date = date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( $date ) );
			echo '<p>' . sprintf( __( "Your last scan was on <strong>%s</strong>", wp_defender()->domain ), $date ) . '</p'; ?>
			<br/><br/>
			{{contents}}
			<div class="tl wd-scan-widget-footer">
				<p class="float-l wd-inline">
					<?php
					$automate_scan  = WD_Utils::get_automatic_scan_settings();
					$is_active      = WD_Utils::get_setting( 'scan->auto_scan', 0 );
					$frequency_text = '';
					switch ( $automate_scan['frequency'] ) {
						case 1:
							$frequency_text = __( "daily", wp_defender()->domain );
							break;
						case 7:
							$frequency_text = __( "weekly", wp_defender()->domain );
							break;
						case 30:
							$frequency_text = __( "monthly", wp_defender()->domain );
							break;
					}
					if ( $is_active ) {
						printf( __( "Automatic scans are running <strong>%s</strong>", wp_defender()->domain ), $frequency_text );
					} else {
						_e( "Automatic scans are <strong>disabled</strong>", wp_defender()->domain );
					}
					?>
				</p>

				<form id="start_a_scan" method="post" class="wd-inline float-r">
					<input type="hidden" name="action" value="wd_start_a_scan">
					<?php wp_nonce_field( 'wd_start_a_scan', 'wd_scan_nonce' ) ?>
					<button type="submit" class="button button-cta wd-button">
						<?php _e( "Run New Scan", wp_defender()->domain ) ?>
					</button>
				</form>
				<div class="wd-clearfix"></div>
			</div>
		</div>
	</section>
</div>