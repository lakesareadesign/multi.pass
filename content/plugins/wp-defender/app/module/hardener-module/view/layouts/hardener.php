<div class="wrap">
	<div class="wpmud">
		<div class="wp-defender">
			<?php do_action( 'wd_hardener_layout_top' ) ?>
			<div class="wd-hardener">
				<h2 class="tl wd-title"><?php _e( "Hardening", wp_defender()->domain ) ?></h2>
				<section class="dev-box wd-hardener-summary">
					<div class="box-title">
						<h3><?php _e( "Summary", wp_defender()->domain ) ?></h3>
					</div>
					<div class="box-content">
						<h2 class="tl">
							<?php
							if ( count( $issues ) == 0 ) {
								_e( "All Issues Resolved. Legendary!", wp_defender()->domain );
							} else {
								printf( __( "You have a few security risks, %s!", wp_defender()->domain ), WD_Utils::get_display_name() );
							} ?>
						</h2>

						<div class="group">
							<div class="col span_6_of_12">
								<div class="wd-indicators">
									<div class="wd-indicator yellow">
										<strong><?php echo count( $issues ) ?></strong>

										<div class="wd-footer">
											<?php _e( "Issues", wp_defender()->domain ) ?>
										</div>
									</div>
									<div class="wd-indicator green">
										<strong><?php echo count( $resolved ) ?></strong>

										<div class="wd-footer">
											<?php
											_e( "Resolved", wp_defender()->domain );
											?>
										</div>
									</div>
									<div class="wd-clearfix"></div>
								</div>
								<div class="wd-clearfix"></div>
							</div>
						</div>
						<div class="wd-clearfix"></div>
						<?php _e( "Start fixing any outstanding security risks in the Issues list below.", wp_defender()->domain ) ?>
						<div class="wd-clearfix"></div>
					</div>
				</section>
				<div class="group">
					<?php if ( ! is_plugin_active( 'wp-hummingbird/wp-hummingbird.php' ) ): ?>
						<div class="col span_9_of_12 full-width-if-lower-than-1000">
							<section class="wd-hardener-content">
								{{contents}}
							</section>
						</div>
						<div class="col span_3_of_12 full-width-if-lower-than-1000 wd-no-padding">
							<?php
							$widget = WD_Widget_Manager::get_instance()->display( 'WD_Performance_Widget' ); ?>
						</div>
					<?php else: ?>
						<div class="col span_12_of_12 full-width-if-lower-than-1000">
							<section class="wd-hardener-content">
								{{contents}}
							</section>
						</div>
					<?php endif; ?>
					<div class="wd-clearfix"></div>
				</div>
			</div>
			<?php do_action( 'wd_hardener_layout_end' ) ?>
		</div>
	</div>
</div>