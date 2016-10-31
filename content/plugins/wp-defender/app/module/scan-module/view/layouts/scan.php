<div class="wrap">
	<div class="wpmud">
		<div class="wp-defender">
			<?php do_action( 'wd_scan_layout_top' ) ?>
			<div class="wd-scan">
				<section id="header">
					<div class="group">
						<div class="col span_6_of_12">
							<h1 class="tl"><?php esc_html_e( "Scans", wp_defender()->domain ) ?></h1>
						</div>
						<div class="col span_6_of_12 last-scan-status float-r tr">
							<?php if ( is_object( $model = WD_Scan_Api::get_last_scan() ) ): ?>
								<div>
									<p>
										<strong><?php esc_html_e( "Last scan:", wp_defender()->domain ) ?></strong>
										<?php
										$date = $model->get_raw_post()->post_date;
										echo date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( $date ) )
										?>
									</p>
									<?php if ( WD_Scan_Api::maybe_scan() ): ?>
										<?php if ( ! is_object( WD_Scan_Api::get_active_scan() ) ): ?>
											<form method="post" id="start_a_scan">
												<input type="hidden" name="action" value="wd_start_a_scan">
												<?php wp_nonce_field( 'wd_start_a_scan', 'wd_scan_nonce' ) ?>

												<button type="submit" class="button wd-button button-small button-cta">
													<?php esc_html_e( "Scan", wp_defender()->domain ) ?>
												</button>
											</form>
										<?php endif; ?>
									<?php else: ?>
										<div>
											<?php printf( esc_html__( "Please enable at least 1 scan type <a href='%s'>here</a> to continue", wp_defender()->domain ), network_admin_url( 'admin.php?page=wdf-settings' ) ) ?>
										</div>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						</div>
						<div class="wd-clearfix"></div>
					</div>
				</section>
				<section class="wd-scan-main">
					{{contents}}
				</section>
			</div>
			<dialog title="<?php esc_attr_e( "How to fix", wp_defender()->domain ) ?>" id="wd-resolve-dialog">
			</dialog>
			<a id="wd-resolve-trigger" href="#wd-resolve-dialog" rel="dialog"></a>
			<?php do_action( 'wd_scan_layout_bottom' ) ?>
		</div>
	</div>
</div>