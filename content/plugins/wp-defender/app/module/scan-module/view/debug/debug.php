<div class="wrap">
	<div class="wp-defender">
		<div class="group">
			<div class="col span_6_of_12">
				<h2 class="tl wd-title"><?php _e( "Debug Info", wp_defender()->domain ) ?></h2>
			</div>
			<div class="col span_6_of_12 float-r tr">
				<div>
					<br/>

					<form method="post">
						<?php wp_nonce_field( 'wd_cleanup_log', 'wd_debug_nonce' ) ?>

						<button type="submit" class="button wd-button button-small button-cta">
							<?php _e( "Cleanup", wp_defender()->domain ) ?>
						</button>
					</form>
				</div>
			</div>
			<div class="wd-clearfix"></div>
		</div>
		<div class="vertical-tabs">
			<section class="tab">
				<input type="radio" name="tab_group1" id="tab_1" checked/>
				<label for="tab_1"><?php _e( "Scan Data", wp_defender()->domain ) ?></label>

				<div class="content">
					<div class="group">
						<div class="col span_6_of_12">
							<p>
								<strong>Total Scan:</strong>
								<?php echo WD_Utils::get_cache( 'wd_scan_count' ) ?>
							</p>

							<p>
								<strong><?php _e( "Progress: " ) ?></strong>
								<?php echo is_object( $model ) ? $model->get_percent() : 0 ?>%
							</p>

							<p>
								<strong><?php _e( "Total files: " ) ?></strong>
								<?php echo $model->total_files ?>
							</p>

							<p>
								<strong><?php _e( "Current index: " ) ?></strong>
								<?php echo $model->current_index ?>
							</p>

							<p>
								<strong><?php _e( "Start time: " ) ?></strong>
								<?php echo date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), $model->execute_time['start'] ); ?>
							</p>

							<p>
								<strong><?php _e( "Last modified time: " ) ?></strong>

								<?php
								if ( is_object( $model ) ) {
									echo date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( $model->get_raw_post()->post_modified ) );
								}
								?>
							</p>
							<?php if ( $model->status == WD_Scan_Result_Model::STATUS_COMPLETE ): ?>
								<p>
									<strong><?php _e( "Complete: " ) ?></strong>
									<?php echo date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), $model->execute_time['end'] ); ?>
								</p>
							<?php endif; ?>
							<hr/>
							<p>
								<strong><?php _e( "Total Core Files: " ) ?></strong>
								<?php echo count( $core_files ) ?>
							</p>
							<p>
								<strong><?php _e( "Fraging Files: " ) ?></strong>
								<?php echo count( $frag_files ) ?>
							</p>
							<p>
								<strong><?php _e( "Total Contents Files: " ) ?></strong>
								<?php echo count( $content_files ) ?>
							</p>
						</div>
						<div class="col span_6_of_12">
							<h3>
								<?php _e( "Memory Info" ) ?>
							</h3>

							<p>
								<strong><?php _e( "CPU usage: " ) ?></strong>
								<?php
								$loaded = sys_getloadavg();
								echo $loaded[0]
								?>
							</p>

							<p>
								<strong><?php _e( "Memory usage: " ) ?></strong>
								<?php
								echo $controller->convert_size( memory_get_usage() )
								?>
							</p>

							<p>
								<strong><?php _e( "Peak Memory usage: " ) ?></strong>
								<?php
								echo $controller->convert_size( memory_get_peak_usage() )
								?>
							</p>
						</div>
						<div class="wd-clear"></div>
					</div>
					<?php if ( $model->status == WD_Scan_Result_Model::STATUS_COMPLETE ): ?>
						<div>
							<?php
							$res = array_merge(
								$model->get_result_by_type( WD_Scan_Result_Model::TYPE_PLUGIN ),
								$model->get_result_by_type( WD_Scan_Result_Model::TYPE_THEME )
							);

							?>
							<h3>
								<?php echo sprintf( __( "Result VulnDB (%s)" ), count( $res ) ) ?>
							</h3>
							<?php foreach ( $res as $item ): ?>
								<strong><?php echo $item->get_name(); ?></strong>
								<pre><?php print_r( $item->export() ) ?></pre>
							<?php endforeach; ?>
						</div>
						<div>
							<?php
							$res = $model->get_result_by_type( WD_Scan_Result_Model::TYPE_CORE );
							?>
							<h3>
								<?php echo sprintf( __( "Result Core Integrity (%s)" ), count( $res ) ) ?>
							</h3>
							<?php foreach ( $res as $item ): ?>
								<strong><?php echo $item->get_name(); ?></strong>
								<pre><?php print_r( $item->export() ) ?></pre>
							<?php endforeach; ?>
						</div>
						<div>
							<?php
							$res = $model->get_result_by_type( WD_Scan_Result_Model::TYPE_FILE );
							?>
							<h3>
								<?php echo sprintf( __( "Result Suspicious Scan (%s)" ), count( $res ) ) ?>
							</h3>
							<?php foreach ( $res as $item ): ?>
								<strong><?php echo $item->get_name(); ?></strong>
								<pre><?php print_r( $item->export() ) ?></pre>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</section>
			<?php foreach ( $logs_data as $key => $log ): ?>
				<?php $id = uniqid() ?>
				<section class="tab">
					<input type="radio" name="tab_group1" id="<?php echo $id ?>"/>
					<label for="<?php echo $id ?>">
						<?php echo pathinfo( $key, PATHINFO_FILENAME ) ?>
					</label>

					<div class="content" style="overflow-y: scroll">
						<pre><?php echo( esc_html( $log ) ) ?></pre>
					</div>
				</section>
			<?php endforeach; ?>
		</div>
	</div>
</div>